<?php

if (!defined('ABSPATH')) exit;

/**
 * =================================================================
 * FILE 6: class-rest-api.php (REST API Endpoints) - FIXED
 * =================================================================
 */
class Elematic_REST_API {
    
    private static $instance = null;
    
    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
        add_action('wp_ajax_elematic_create_template', [$this, 'ajax_create_template']);
        add_action('wp_ajax_elematic_duplicate_template', [$this, 'ajax_duplicate_template']);
        add_action('wp_ajax_elematic_clear_cache', [$this, 'ajax_clear_cache']);
    }

    public function ajax_clear_cache() {
        check_ajax_referer('elematic_nonce', 'nonce');
        
        if (! current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'Unauthorized']);
        }
        
        Elematic_Conditions::instance()->clear_template_cache();
        
        wp_send_json_success(['message' => 'Cache cleared']);
    }

    /**
     * AJAX handler for creating new templates
     * FIXED: Added isset() checks and wp_unslash() for $_POST data
     */
    public function ajax_create_template() {
        check_ajax_referer('elematic_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'Unauthorized']);
        }
        
        // FIXED:  Validate input exists and use wp_unslash()
        if (!isset($_POST['title']) || !isset($_POST['type'])) {
            wp_send_json_error(['message' => 'Missing required fields']);
        }
        
        $title = sanitize_text_field(wp_unslash($_POST['title']));
        $type = sanitize_text_field(wp_unslash($_POST['type']));
        
        // Validate inputs aren't empty
        if (empty($title) || empty($type)) {
            wp_send_json_error(['message' => 'Title and type are required']);
        }
        
        // Create post
        $post_id = wp_insert_post([
            'post_title'  => $title,
            'post_type'   => 'elematic_template',
            'post_status' => 'publish',
        ]);
        
        if (is_wp_error($post_id)) {
            wp_send_json_error(['message' => $post_id->get_error_message()]);
        }
        
        // Set type taxonomy
        wp_set_object_terms($post_id, $type, 'elematic_template_type');
        
        // Set default priority
        update_post_meta($post_id, '_elematic_priority', 999);
        
        // Set default conditions
        update_post_meta($post_id, '_elematic_conditions', ['type' => 'global']);
        
        // Set Elementor template type
        update_post_meta($post_id, '_elementor_template_type', 'page');
        
        // Set canvas template
        update_post_meta($post_id, '_wp_page_template', 'elementor_canvas');
        
        // Clear template cache to show new template immediately
        Elematic_Conditions::instance()->clear_template_cache($post_id);
        
        wp_send_json_success([
            'id'       => $post_id,
            'edit_url' => admin_url('post.php?post=' . $post_id . '&action=elementor')
        ]);
    }
    
    public function register_routes() {
        register_rest_route('elematic/v1', '/templates', [
            'methods'             => 'GET',
            'callback'            => [$this, 'get_templates'],
            'permission_callback' => [$this, 'check_permissions'],
        ]);
        
        register_rest_route('elematic/v1', '/template/(?P<id>\d+)', [
            'methods'             => 'PUT',
            'callback'            => [$this, 'update_template'],
            'permission_callback' => [$this, 'check_permissions'],
        ]);
        
        register_rest_route('elematic/v1', '/template/(?P<id>\d+)', [
            'methods'             => 'DELETE',
            'callback'            => [$this, 'delete_template'],
            'permission_callback' => [$this, 'check_permissions'],
        ]);
    }
    
    public function check_permissions() {
        return current_user_can('manage_options');
    }
    
    /**
     * Get templates - FIXED:  Optimized query to avoid slow db warnings
     */
    public function get_templates($request) {
        $type = $request->get_param('type');
        
        // Base query without slow meta_key ordering
        $args = [
            'post_type'      => 'elematic_template',
            'post_status'    => 'publish',
            'posts_per_page' => 100, // Reasonable limit instead of -1
            'no_found_rows'  => true,
        ];
        
        // Handle type filter using optimized approach
        if ($type) {
            $term = get_term_by('slug', $type, 'elematic_template_type');
            if ($term && ! is_wp_error($term)) {
                $template_ids = get_objects_in_term($term->term_id, 'elematic_template_type');
                if (! empty($template_ids) && ! is_wp_error($template_ids)) {
                    $args['post__in'] = $template_ids;
                } else {
                    return rest_ensure_response([]);
                }
            }
        }
        
        $templates = get_posts($args);
        $data = [];
        
        foreach ($templates as $template) {
            $conditions = get_post_meta($template->ID, '_elematic_conditions', true);
            $priority = get_post_meta($template->ID, '_elematic_priority', true);
            
            $data[] = [
                'id'         => $template->ID,
                'title'      => $template->post_title,
                'type'       => $this->get_template_type($template->ID),
                'conditions' => $conditions ?  $conditions : [],
                'priority'   => $priority ? intval($priority) : 0,
                'edit_url'   => admin_url('post.php?post=' . $template->ID . '&action=elementor'),
            ];
        }
        
        // Sort by priority in PHP instead of database
        usort($data, function($a, $b) {
            return $a['priority'] - $b['priority'];
        });
        
        return rest_ensure_response($data);
    }
    
    public function update_template($request) {
        $id = $request->get_param('id');
        $conditions = $request->get_param('conditions');
        
        if ($conditions) {
            update_post_meta($id, '_elematic_conditions', $conditions);
        }
        
        // Clear cache
        Elematic_Conditions::instance()->clear_template_cache($id);
        
        return rest_ensure_response(['success' => true]);
    }
    
    public function delete_template($request) {
        $id = $request->get_param('id');
        
        wp_delete_post($id, true);
        
        // Clear cache
        Elematic_Conditions::instance()->clear_template_cache();
        
        return rest_ensure_response(['success' => true]);
    }
    
    /**
     * AJAX handler for duplicating templates
     * FIXED:  Added isset() check for $_POST['template_id']
     */
    public function ajax_duplicate_template() {
        check_ajax_referer('elematic_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'Unauthorized']);
        }
        
        // FIXED: Check if template_id exists before using it
        if (!isset($_POST['template_id'])) {
            wp_send_json_error(['message' => 'Template ID is required']);
        }
        
        $template_id = intval(wp_unslash($_POST['template_id']));
        
        if ($template_id <= 0) {
            wp_send_json_error(['message' => 'Invalid template ID']);
        }
        
        $original = get_post($template_id);
        
        if (! $original || $original->post_type !== 'elematic_template') {
            wp_send_json_error(['message' => 'Template not found']);
        }
        
        // Duplicate post
        $new_post_id = wp_insert_post([
            'post_title'  => $original->post_title .  ' - Copy',
            'post_type'   => 'elematic_template',
            'post_status' => 'publish',
            'meta_input'  => []
        ]);
        
        if (is_wp_error($new_post_id)) {
            wp_send_json_error(['message' => $new_post_id->get_error_message()]);
        }
        
        // Copy taxonomy
        $terms = wp_get_post_terms($template_id, 'elematic_template_type');
        if (!empty($terms) && ! is_wp_error($terms)) {
            wp_set_object_terms($new_post_id, $terms[0]->slug, 'elematic_template_type');
        }
        
        // Copy meta data
        $meta_keys = ['_elematic_priority', '_elematic_conditions', '_elementor_template_type', '_wp_page_template'];
        foreach ($meta_keys as $key) {
            $meta_value = get_post_meta($template_id, $key, true);
            if ($meta_value) {
                update_post_meta($new_post_id, $key, $meta_value);
            }
        }
        
        // Copy Elementor meta (content)
        $elementor_data = get_post_meta($template_id, '_elementor_data', true);
        if ($elementor_data) {
            update_post_meta($new_post_id, '_elementor_data', $elementor_data);
        }
        
        wp_send_json_success([
            'id'      => $new_post_id,
            'message' => 'Template duplicated successfully'
        ]);
    }
    
    private function get_template_type($template_id) {
        $terms = wp_get_post_terms($template_id, 'elematic_template_type');
        return (! empty($terms) && !is_wp_error($terms)) ? $terms[0]->slug : '';
    }
}
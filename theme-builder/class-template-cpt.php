<?php

if (!defined('ABSPATH')) exit;

/**
 * =================================================================
 * class-template-cpt.php (Custom Post Type)
 * =================================================================
 */
class Elematic_Template_CPT {
    
    private static $instance = null;
    
    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        add_action('init', [$this, 'register_post_type']);
        add_action('init', [$this, 'register_taxonomy']);
        add_filter('template_redirect', [$this, 'block_frontend_access']);
        
        // Add Elementor support
        add_action('admin_init', [$this, 'add_elementor_support']);
    }
    
    public function register_post_type() {
        $args = [
            'label' => __('Templates', 'elematic-addons-for-elementor'),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => false,
            'show_in_nav_menus' => false,
            'exclude_from_search' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => false,
            'query_var' => false,
            'supports' => ['title', 'editor', 'elementor'],
            'labels' => [
                'name' => __('Templates', 'elematic-addons-for-elementor'),
                'singular_name' => __('Template', 'elematic-addons-for-elementor'),
            ],
        ];
        
        register_post_type('elematic_template', $args);
    }
    
    public function register_taxonomy() {
        $args = [
            'hierarchical' => true,
            'show_ui' => false,
            'show_in_nav_menus' => false,
            'show_admin_column' => false,
            'query_var' => false,
            'rewrite' => false,
            'public' => false,
        ];
        
        register_taxonomy('elematic_template_type', 'elematic_template', $args);
    }
    
    public function block_frontend_access() {
        if (is_singular('elematic_template') && !current_user_can('edit_posts')) {
            wp_safe_redirect(home_url(), 301);
            exit;
        }
    }
    
    public function add_elementor_support() {
        $cpt_support = get_option('elementor_cpt_support');
        
        if (!$cpt_support) {
            update_option('elementor_cpt_support', ['page', 'post', 'elematic_template']);
        } elseif (!in_array('elematic_template', $cpt_support)) {
            $cpt_support[] = 'elematic_template';
            update_option('elementor_cpt_support', $cpt_support);
        }
        
        // Hook into template redirect to provide editing template
        add_action('template_redirect', [$this, 'provide_editing_template'], 1);
    }
    
    /**
     * Provide a proper template for Elementor editing
     * This ensures Elementor can find the content area
     */
    public function provide_editing_template() {
        // Only for admin editing - verify nonce and parameters
        if (!is_admin()) {
            return;
        }
        
        // Check if required parameters exist
        if (!isset($_GET['post']) || !isset($_GET['action'])) {
            return;
        }
        
        // Verify the action is for elementor
        if ($_GET['action'] !== 'elementor') {
            return;
        }
        
        // Verify nonce for Elementor editor
        // Elementor uses its own nonce system
        if (!isset($_GET['_wpnonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'])), 'elementor-editing')) {
            // For Elementor compatibility, also check standard edit nonce
            $post_id = absint($_GET['post']);
            if (!current_user_can('edit_post', $post_id)) {
                return;
            }
        }
        
        $post_id = absint($_GET['post']);
        $post = get_post($post_id);
        
        // Check if this is an elematic_template post
        if (!$post || $post->post_type !== 'elematic_template') {
            return;
        }
        
        // Mark that we're editing a template
        define('ELEMATIC_EDITING_TEMPLATE', true);
        
        // Disable theme customizer and unnecessary hooks
        add_filter('show_admin_bar', '__return_false');
        
        // Load our editing template for editing
        add_filter('template_include', [$this, 'get_editing_template'], 999);
    }
    
    /**
     * Return a blank template for Elementor editing
     */
    public function get_editing_template( $template ) {

        // Only proceed if a post param exists
        if ( ! isset( $_GET['post'] ) ) {
            return $template;
        }

        // Optional nonce verification (PHPCS-compliant)
        if ( isset( $_GET['_wpnonce'] ) ) {

            // Sanitize nonce first (PHPCS requires this)
            $nonce = sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) );

            if ( ! wp_verify_nonce( $nonce, 'elementor' ) ) {
                return $template;
            }
        }

        // Sanitize post ID
        $post_id = absint( wp_unslash( $_GET['post'] ) );
        $post    = get_post( $post_id );

        if ( $post && $post->post_type === 'elematic_template' ) {
            return ELEMATIC_PATH . 'theme-builder/templates/template-elematic_template.php';
        }

        return $template;
    }
}
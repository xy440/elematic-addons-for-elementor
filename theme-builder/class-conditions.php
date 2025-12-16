<?php

if (!defined('ABSPATH')) exit;

/**
 * =================================================================
 * class-conditions.php (Condition Engine) - REFACTORED
 * =================================================================
 */
class Elematic_Conditions {
    
    private static $instance = null;
    
    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self:: $instance;
    }
    
    /**
     * Get active template for specific type (header/footer)
     */
    public function get_active_template($type) {
        $cache_key = 'elematic_' . $type . '_' . $this->get_current_context();
        $cached = wp_cache_get($cache_key, 'elematic_templates');
        
        if (false !== $cached) {
            return $cached;
        }
        
        $templates = $this->get_templates_by_type($type);
        
        if (empty($templates)) {
            return null;
        }
        
        foreach ($templates as $template) {
            if ($this->template_matches_conditions($template)) {
                wp_cache_set($cache_key, $template->ID, 'elematic_templates', HOUR_IN_SECONDS);
                return $template->ID;
            }
        }
        
        return null;
    }
    
    /**
     * Get templates by type, ordered by priority
     */
    // private function get_templates_by_type($type) {
    //     $args = [
    //         'post_type'      => 'elematic_template',
    //         'post_status'    => 'publish',
    //         'posts_per_page' => 100,
    //         'fields'         => 'ids',
    //         'no_found_rows'  => true,
    //         'tax_query'      => [
    //             [
    //                 'taxonomy' => 'elematic_template_type',
    //                 'field'    => 'slug',
    //                 'terms'    => $type,
    //             ],
    //         ],
    //     ];
        
    //     $template_ids = get_posts($args);
        
    //     if (empty($template_ids)) {
    //         return [];
    //     }
        
    //     $templates = get_posts([
    //         'post_type'      => 'elematic_template',
    //         'post__in'       => $template_ids,
    //         'posts_per_page' => count($template_ids),
    //         'orderby'        => 'post__in',
    //         'no_found_rows'  => true,
    //     ]);
        
    //     usort($templates, function($a, $b) {
    //         $priority_a = (int) get_post_meta($a->ID, '_elematic_priority', true);
    //         $priority_b = (int) get_post_meta($b->ID, '_elematic_priority', true);
    //         return $priority_a - $priority_b;
    //     });
        
    //     return $templates;
    // }

    /**
 * Get templates by type, ordered by priority
 * Optimized:  Added caching to reduce tax_query calls
 */
private function get_templates_by_type($type) {
    // Cache the taxonomy query results
    $cache_key = 'elematic_templates_' . sanitize_key($type);
    $template_ids = wp_cache_get($cache_key, 'elematic_templates');
    
    if (false === $template_ids) {
        // Get term ID first (more efficient than slug lookup in tax_query)
        $term = get_term_by('slug', $type, 'elematic_template_type');
        
        if (! $term || is_wp_error($term)) {
            return [];
        }
        
        // Use get_objects_in_term() - more direct than tax_query
        $template_ids = get_objects_in_term($term->term_id, 'elematic_template_type');
        
        if (is_wp_error($template_ids) || empty($template_ids)) {
            return [];
        }
        
        // Cache for 1 hour
        wp_cache_set($cache_key, $template_ids, 'elematic_templates', HOUR_IN_SECONDS);
    }
    
    if (empty($template_ids)) {
        return [];
    }
    
    // Get published templates only
    $templates = get_posts([
        'post_type'      => 'elematic_template',
        'post_status'    => 'publish',
        'post__in'       => (array) $template_ids,
        'posts_per_page' => 100,
        'orderby'        => 'post__in',
        'no_found_rows'  => true,
    ]);
    
    // Sort by priority in PHP
    usort($templates, function($a, $b) {
        $priority_a = (int) get_post_meta($a->ID, '_elematic_priority', true);
        $priority_b = (int) get_post_meta($b->ID, '_elematic_priority', true);
        return $priority_a - $priority_b;
    });
    
    return $templates;
}
    
    /**
     * Check if template matches current page conditions
     */
    private function template_matches_conditions($template) {
        if ($template->post_status !== 'publish') {
            return false;
        }
        
        $conditions = get_post_meta($template->ID, '_elematic_conditions', true);
        
        if (empty($conditions)) {
            return true;
        }
        
        $condition_type = isset($conditions['type']) ? $conditions['type'] : '';
        
        if ($condition_type === 'none' || empty($condition_type)) {
            return false;
        }
        
        switch ($condition_type) {
            case 'global':
                return true;
                
            case 'all_pages':
                return is_page();
                
            case 'all_posts':
                return is_single() && get_post_type() === 'post';
                
            case 'specific_pages':
                $page_ids = isset($conditions['page_ids']) ? $conditions['page_ids'] :  '';
                if (is_string($page_ids)) {
                    $page_ids = array_map('trim', explode(',', $page_ids));
                    $page_ids = array_filter($page_ids, 'is_numeric');
                }
                return is_page($page_ids);
                
            case 'specific_posts': 
                $post_ids = isset($conditions['post_ids']) ? $conditions['post_ids'] : '';
                if (is_string($post_ids)) {
                    $post_ids = array_map('trim', explode(',', $post_ids));
                    $post_ids = array_filter($post_ids, 'is_numeric');
                }
                return is_single($post_ids);
                
            case 'post_type':
                $post_type = isset($conditions['post_type']) ? $conditions['post_type'] :  '';
                return is_singular($post_type);
                
            default:
                return false;
        }
    }
    
    /**
     * Get current page context for cache key
     */
    private function get_current_context() {
        if (is_front_page()) {
            return 'front_page';
        } elseif (is_home()) {
            return 'blog';
        } elseif (is_singular()) {
            return 'single_' . get_post_type() . '_' . get_the_ID();
        } elseif (is_archive()) {
            return 'archive_' . get_query_var('post_type');
        } elseif (is_search()) {
            return 'search';
        } elseif (is_404()) {
            return '404';
        }
        
        return 'default';
    }
    
    /**
     * Clear cache when template is saved
     */
    public function clear_template_cache($post_id = null) {
        if ($post_id && get_post_type($post_id) !== 'elematic_template') {
            return;
        }
        
        if (function_exists('wp_cache_flush_group')) {
            wp_cache_flush_group('elematic_templates');
        } else {
            $contexts = ['front_page', 'blog', 'search', '404', 'default'];
            $types = ['header', 'footer'];
            
            foreach ($types as $type) {
                foreach ($contexts as $context) {
                    delete_transient('elematic_' . $type .  '_' . $context);
                }
            }
        }
        
        wp_cache_delete('elematic_templates', 'elematic');
    }
}
<?php

if (!defined('ABSPATH')) exit;

class Elematic_Renderer {
    
    private static $instance = null;
    private $using_block_theme = false;
    private $custom_header_active = false;
    private $custom_footer_active = false;
    
    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        // Detect block theme - check multiple times as detection can vary during page load
        add_action('wp_loaded', [$this, 'detect_and_setup_theme_hooks']);
    }
    
    /**
     * Detect theme type and setup appropriate hooks
     */
    public function detect_and_setup_theme_hooks() {
        // Detect block theme with fallback methods
        $this->using_block_theme = $this->is_block_theme();
        
        // Add body classes
        add_filter('body_class', [$this, 'add_body_classes']);
        
        // Enqueue template styles
        add_action('wp_enqueue_scripts', [$this, 'enqueue_template_styles']);
        
        // For block themes, use block rendering filters
        if ($this->using_block_theme) {
            $this->setup_block_theme_hooks();
        } else {
            // For traditional themes, use template_redirect to hook get_header/get_footer
            add_action('template_redirect', [$this, 'setup_traditional_theme_hooks']);
        }
    }
    
    /**
     * Detect if current theme is a block theme
     */
    private function is_block_theme() {
        // Primary check
        if (function_exists('wp_is_block_theme') && wp_is_block_theme()) {
            return true;
        }
        
        // Fallback check - look for block templates directory
        $theme = wp_get_theme();
        $theme_path = $theme->get_stylesheet_directory();
        if (file_exists($theme_path . '/block-templates') || file_exists($theme_path . '/templates')) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Setup hooks for block-based themes (Twenty Twenty-Three, etc.)
     */
    public function setup_block_theme_hooks() {
        if (is_admin() || wp_doing_ajax()) {
            return;
        }
        
        // Hook into block rendering at the highest priority
        add_filter('render_block_context', [$this, 'filter_block_context'], -999, 2);
        add_filter('render_block', [$this, 'filter_render_block'], -999, 2);
        
        // Also hook into the template part loading for block themes
        add_filter('block_template_part', [$this, 'filter_block_template_part'], -999, 3);
        
        // Prevent WordPress from calling deprecated get_header/get_footer on block themes
        add_action('get_header', [$this, 'block_theme_bypass_header'], -9999, 1);
        add_action('get_footer', [$this, 'block_theme_bypass_footer'], -9999, 1);
    }
    
    /**
     * Bypass header.php loading on block themes
     */
    public function block_theme_bypass_header($name) {
        // Stop WordPress from trying to load header.php
        remove_action('get_header', [$this, 'block_theme_bypass_header'], -9999);
        // Exit without loading anything - block themes don't use header.php
    }
    
    /**
     * Bypass footer.php loading on block themes
     */
    public function block_theme_bypass_footer($name) {
        // Stop WordPress from trying to load footer.php
        remove_action('get_footer', [$this, 'block_theme_bypass_footer'], -9999);
        // Exit without loading anything - block themes don't use footer.php
    }
    
    /**
     * Setup hooks for traditional themes
     */
    public function setup_traditional_theme_hooks() {
        // Don't run if this is a block theme
        if ($this->using_block_theme) {
            return;
        }
        
        if (is_admin() || wp_doing_ajax()) {
            return;
        }
        
        $header_id = Elematic_Conditions::instance()->get_active_template('header');
        $footer_id = Elematic_Conditions::instance()->get_active_template('footer');
        
        // Store active state
        $this->custom_header_active = (bool) $header_id;
        $this->custom_footer_active = (bool) $footer_id;
        
        // Hook into get_header and get_footer early
        if ($header_id) {
            add_action('get_header', [$this, 'get_header'], -999, 1);
        }
        
        if ($footer_id) {
            add_action('get_footer', [$this, 'get_footer'], -999, 1);
            // CRITICAL: Prevent wp_footer from being called twice
            add_action('get_footer', [$this, 'prevent_duplicate_footer'], -998, 1);
        }
    }
    
    /**
     * Filter block rendering for block-based themes
     */
    public function filter_render_block($block_content, $block) {
        // Check if this is a template part block
        if ($block['blockName'] === 'core/template-part') {
            $attributes = isset($block['attrs']) ? $block['attrs'] : [];
            $area = isset($attributes['area']) ? $attributes['area'] : '';
            $slug = isset($attributes['slug']) ? $attributes['slug'] : '';
            
            // Normalize slug - check for both 'header' and variations
            $is_header = ($area === 'header' || $slug === 'header' || strpos($slug, 'header') !== false);
            $is_footer = ($area === 'footer' || $slug === 'footer' || strpos($slug, 'footer') !== false);
            
            // Handle header template part
            if ($is_header) {
                $header_id = Elematic_Conditions::instance()->get_active_template('header');
                if ($header_id) {
                    // Return custom header instead of theme template part
                    return '<header id="site-header" role="banner" class="wp-block-template-part elematic-custom-header">' . 
                           $this->get_template_content($header_id) . 
                           '</header>';
                }
            }
            
            // Handle footer template part
            if ($is_footer) {
                $footer_id = Elematic_Conditions::instance()->get_active_template('footer');
                if ($footer_id) {
                    // Return custom footer instead of theme template part
                    return '<footer id="site-footer" role="contentinfo" class="wp-block-template-part elematic-custom-footer">' . 
                           $this->get_template_content($footer_id) . 
                           '</footer>';
                }
            }
        }
        
        return $block_content;
    }
    
    /**
     * Get template content without echoing
     */
    private function get_template_content($template_id) {
        if (!$template_id || !class_exists('\Elementor\Plugin')) {
            return '';
        }
        
        ob_start();
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor content is pre-sanitized
        echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($template_id, false);
        return ob_get_clean();
    }
    
    /**
     * Filter block template parts before they're loaded
     */
    public function filter_block_template_part($template_part_html, $template_part_type, $template_part_slug) {
        // Handle header template parts
        if (in_array($template_part_type, ['header', 'wp_template_part_header'], true) || 
            in_array($template_part_slug, ['header'], true)) {
            $header_id = Elematic_Conditions::instance()->get_active_template('header');
            if ($header_id) {
                return '<header id="site-header" role="banner" class="wp-block-template-part elematic-custom-header">' . 
                       $this->get_template_content($header_id) . 
                       '</header>';
            }
        }
        
        // Handle footer template parts
        if (in_array($template_part_type, ['footer', 'wp_template_part_footer'], true) || 
            in_array($template_part_slug, ['footer'], true)) {
            $footer_id = Elematic_Conditions::instance()->get_active_template('footer');
            if ($footer_id) {
                return '<footer id="site-footer" role="contentinfo" class="wp-block-template-part elematic-custom-footer">' . 
                       $this->get_template_content($footer_id) . 
                       '</footer>';
            }
        }
        
        return $template_part_html;
    }
    
    /**
     * Filter block context
     */
    public function filter_block_context($context, $block) {
        return $context;
    }
    
    public function get_header($name) {
        // Skip on block themes - they use filter_render_block instead
        if ($this->using_block_theme) {
            return;
        }
        
        $header_id = Elematic_Conditions::instance()->get_active_template('header');
        
        if (!$header_id) {
            return;
        }
        
        // Stop this hook from running again
        remove_action('get_header', [$this, 'get_header'], -999);
        
        // Output our custom header HTML structure
        require ELEMATIC_PATH . 'theme-builder/templates/elematic-header.php';
        
        // Render the Elementor template content inside the header
        $this->render_template($header_id);
        
        // Close header tag
        echo '</header>';
    }
    
    /**
     * CRITICAL FIX: Prevent duplicate footer rendering
     */
    public function prevent_duplicate_footer($name) {
        // Skip on block themes
        if ($this->using_block_theme) {
            return;
        }
        
        // This runs right after get_footer is called
        // We need to tell WordPress we're handling the footer completely
        
        // Remove the default theme footer action to prevent it from running
        remove_action('wp_footer', 'wp_admin_bar_render', 1000);
        
        // Mark that we're handling the footer
        define('ELEMATIC_FOOTER_RENDERED', true);
    }
    
    public function get_footer($name) {
        // Skip on block themes - they use filter_render_block instead
        if ($this->using_block_theme) {
            return;
        }
        
        $footer_id = Elematic_Conditions::instance()->get_active_template('footer');
        
        if (!$footer_id) {
            return;
        }
        
        // Stop this hook from running again
        remove_action('get_footer', [$this, 'get_footer'], -999);
        
        // Output our custom footer
        echo '<footer id="colophon" class="site-footer elematic-custom-footer">';
        
        // Render the Elementor template inside the footer
        $this->render_template($footer_id);
        
        echo '</footer>';
        
        // Close page container
        echo '</div><!-- #page -->';
        
        // CRITICAL: Only call wp_footer ONCE
        // This ensures all scripts are loaded, but only once
        if (!defined('ELEMATIC_FOOTER_RENDERED') || !ELEMATIC_FOOTER_RENDERED) {
            wp_footer();
            define('ELEMATIC_FOOTER_RENDERED', true);
        }
        
        echo '</body>';
        echo '</html>';
        
        // CRITICAL: Exit to prevent theme from rendering its own footer
        // This stops the theme's footer.php from being included
        exit;
    }
    
    public function add_body_classes($classes) {
        $has_header = Elematic_Conditions::instance()->get_active_template('header');
        $has_footer = Elematic_Conditions::instance()->get_active_template('footer');
        
        if ($has_header) {
            $classes[] = 'elematic-has-custom-header';
        }
        
        if ($has_footer) {
            $classes[] = 'elematic-has-custom-footer';
        }
        
        return $classes;
    }
    
    public function enqueue_template_styles() {
        $header_id = Elematic_Conditions::instance()->get_active_template('header');
        if ($header_id) {
            $this->enqueue_template_css($header_id);
        }
        
        $footer_id = Elematic_Conditions::instance()->get_active_template('footer');
        if ($footer_id) {
            $this->enqueue_template_css($footer_id);
        }
    }
    
    private function enqueue_template_css($post_id) {
        if (class_exists('\Elementor\Core\Files\CSS\Post')) {
            $css_file = new \Elementor\Core\Files\CSS\Post($post_id);
            $css_file->enqueue();
        }
    }
    
    public static function render_template($template_id) {
        if (!$template_id || !class_exists('\Elementor\Plugin')) {
            return;
        }
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor content is pre-sanitized
        echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($template_id, false);
    }
}
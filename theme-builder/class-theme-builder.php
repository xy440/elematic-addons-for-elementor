<?php

if (!defined('ABSPATH')) exit;

/**
 * =================================================================
 * FILE 1: class-theme-builder.php (Main Controller)
 * =================================================================
 */
class Elematic_Theme_Builder {
    
    private static $instance = null;
    
    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        $this->includes();
        $this->init_hooks();
    }
    
    private function includes() {
        require_once ELEMATIC_PATH . 'theme-builder/class-template-cpt.php';
        require_once ELEMATIC_PATH . 'theme-builder/class-conditions.php';
        require_once ELEMATIC_PATH . 'theme-builder/class-renderer.php';
        require_once ELEMATIC_PATH . 'theme-builder/class-frontend-editor.php';
        require_once ELEMATIC_PATH . 'theme-builder/class-rest-api.php';
    }
    
    private function init_hooks() {
        // Initialize components
        Elematic_Template_CPT::instance();
        Elematic_Conditions::instance();
        Elematic_Renderer::instance();
        Elematic_Frontend_Editor::instance();
        Elematic_REST_API::instance();
        
        // Admin menu
        add_action('admin_menu', [$this, 'add_admin_menu']);
        
        // Enqueue admin assets
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }
    
    public function add_admin_menu() {
        // Add main Elematic menu with Welcome page
        add_menu_page(
            __('Elematic', 'elematic-addons-for-elementor'),
            __('Elematic', 'elematic-addons-for-elementor'),
            'manage_options',
            'elematic',
            [$this, 'render_welcome_page'],
            'dashicons-layout',
            59
        );
        
        // Add Welcome submenu (same as parent)
        add_submenu_page(
            'elematic',
            __('Welcome', 'elematic-addons-for-elementor'),
            __('Welcome', 'elematic-addons-for-elementor'),
            'manage_options',
            'elematic',
            [$this, 'render_welcome_page']
        );
        
        // Add Theme Builder as submenu
        add_submenu_page(
            'elematic',
            __('Theme Builder', 'elematic-addons-for-elementor'),
            __('Theme Builder', 'elematic-addons-for-elementor'),
            'manage_options',
            'elematic-theme-builder',
            [$this, 'render_admin_page']
        );
    }
    
    public function render_welcome_page() {
        require_once ELEMATIC_PATH . 'admin/welcome-page.php';
    }

    
    public function render_admin_page() {
        require_once ELEMATIC_PATH . 'admin/theme-builder-page.php';
    }
    
    public function enqueue_admin_assets($hook) {
        if ('elematic_page_elematic-theme-builder' !== $hook) {
            return;
        }
        
        // Admin dashboard (MUST load BEFORE Alpine.js)
        wp_enqueue_script(
            'elematic-admin-dashboard',
            ELEMATIC_URL . 'assets/js/admin-dashboard.js',
            [],
            ELEMATIC_VERSION,
            false  // Load in header, BEFORE Alpine
        );
        
        // Alpine.js (load LAST, depends on admin-dashboard)
        wp_enqueue_script(
            'elematic-alpine',
            ELEMATIC_URL . 'assets/js/vendor/alpine.min.js',
            ['elematic-admin-dashboard'],  // Depends on our JS
            '3.13.3',
            true  // Load in header
        );
        
        // Localize script
        wp_localize_script('elematic-admin-dashboard', 'elematicData', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'restUrl' => rest_url('elematic/v1'),
            'nonce' => wp_create_nonce('elematic_nonce'),
            'restNonce' => wp_create_nonce('wp_rest'),
        ]);
        
        // Admin CSS
        wp_enqueue_style(
            'elematic-admin-dashboard',
            ELEMATIC_URL . 'assets/css/admin-dashboard.css',
            [],
            ELEMATIC_VERSION
        );
    }

    
}
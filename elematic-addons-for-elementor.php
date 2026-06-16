<?php
/**
 * Plugin Name: Elematic — Elementor Addons, Header Footer Builder & Animations
 * Plugin URI: https://themes.network/elematic/
 * Description: Modern Elementor addons with Webflow-style animations, advanced widgets, and a powerful Elementor Theme Builder to create custom headers and footers.
 * Version: 1.8
 * Text Domain: elematic-addons-for-elementor
 * Domain Path: /languages
 * Author: theme-x
 * Author URI: https://theme-x.org/
 * License: GPLv3
 * Requires at least: 6.1
 * Tested up to: 7.0
 * Requires PHP: 7.4
 * Requires Plugins: elementor
 * Elementor requires at least: 3.22
 * Elementor tested up to: 3.31.1
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'ELEMATIC_VERSION', '1.8' );
define( 'ELEMATIC_PATH', plugin_dir_path( __FILE__ ) );
define( 'ELEMATIC_URL', plugin_dir_url( __FILE__ ) );

require_once ELEMATIC_PATH . 'includes/class-init.php';

// Initialize Theme Builder
require_once ELEMATIC_PATH . 'theme-builder/class-theme-builder.php';

// Activation hook - redirect to welcome page
register_activation_hook(__FILE__, 'elematic_activation_redirect');

function elematic_activation_redirect() {
    // Set transient for redirect
    set_transient('elematic_activation_redirect', true, 30);
}

// Check for redirect transient
add_action('admin_init', 'elematic_check_activation_redirect');
function elematic_check_activation_redirect() {
    if ( ! current_user_can( 'activate_plugins' ) ) {
        return;
    }
    
    if ( ! get_transient( 'elematic_activation_redirect' ) ) {
        return;
    }
    
    delete_transient( 'elematic_activation_redirect' );
    
    // Check for bulk or network activation without accessing $_GET directly
    $is_bulk = filter_input( INPUT_GET, 'activate-multi', FILTER_SANITIZE_SPECIAL_CHARS );
    if ( $is_bulk || is_network_admin() ) {
        return;
    }
    
    wp_safe_redirect( admin_url( 'admin.php?page=elematic' ) );
    exit;
}

add_action( 'elementor/init', function() {
  \Elematic\Init::start();
  Elematic_Theme_Builder::instance();
  do_action( 'elematic_pro_loaded' );
});

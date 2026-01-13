<?php
/**
 * Plugin Name: Elematic — Addons for Elementor
 * Plugin URI: https://themes.network/elematic/
 * Description: Lightweight and blazing fast Elementor widgets.
 * Version: 1.6
 * Text Domain: elematic-addons-for-elementor
 * Domain Path: /languages
 * Author: Anwar Hossain
 * Author URI: https://anwarhossain.dev/
 * License: GPL3
 * Requires at least: 6.0
 * Tested up to: 6.9
 * Requires Plugins: elementor
 * Elementor requires at least: 3.22
 * Elementor tested up to: 3.31
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'ELEMATIC_VERSION', '1.6' );
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
  Elematic_Theme_Builder::instance(); // Actually initialize it!
});

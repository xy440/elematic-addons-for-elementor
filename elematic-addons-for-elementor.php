<?php
/**
 * Plugin Name: Elematic — Addons for Elementor
 * Plugin URI: https://themes.network/elematic/
 * Description: Lightweight and blazing fast Elementor widgets.
 * Version: 1.3
 * Text Domain: elematic-addons-for-elementor
 * Domain Path: /languages
 * Author: Anwar Hossain
 * Author URI: https://anwarhossain.dev/
 * License: GPL3
 * Requires at least: 6.0
 * Tested up to: 6.8
 * Requires Plugins: elementor
 * Elementor requires at least: 3.22
 * Elementor tested up to: 3.31
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'ELEMATIC_VERSION', '1.3' );
define( 'ELEMATIC_PATH', plugin_dir_path( __FILE__ ) );
define( 'ELEMATIC_URL', plugin_dir_url( __FILE__ ) );

require_once ELEMATIC_PATH . 'includes/class-init.php';


add_action( 'elementor/init', function() {
  \Elematic\Init::start();
});

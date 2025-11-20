<?php
namespace Elematic;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Enqueue {
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'plugin_enqueue_scripts' ] );

    }

    public function plugin_enqueue_scripts() {
        wp_enqueue_style( 'elematic-plugin-styles', ELEMATIC_URL . 'assets/css/styles.min.css', [], ELEMATIC_VERSION );
        wp_enqueue_style( 'elematic-fontawesome-7', ELEMATIC_URL . 'assets/css/all.min.css', [], ELEMATIC_VERSION );
    }



}
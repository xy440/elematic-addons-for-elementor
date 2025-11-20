<?php
namespace Elematic;

if ( ! defined( 'ABSPATH' ) ) exit;

class Init {

    public static function start() {
        if ( ! defined( 'ELEMATIC' ) ) {
            define( 'ELEMATIC', 'Elematic ' );
        }

        self::elematic_load_dependencies();
        self::elematic_setup_hooks();
    }

    private static function elematic_load_dependencies() {
        require_once ELEMATIC_PATH . 'includes/class-plugin-core.php';
        require_once ELEMATIC_PATH . 'includes/class-widget-manager.php';
        require_once ELEMATIC_PATH . 'includes/class-helper.php';
        require_once ELEMATIC_PATH . 'includes/class-enqueue.php';

        new Plugin_Core();
        new Enqueue();
        new Helper();
        new WidgetManager();
        
    }

    private static function elematic_setup_hooks() {
        add_action( 'elementor/elements/categories_registered', [ __CLASS__, 'elematic_register_category' ] );
    }

    public static function elematic_register_category( $elements_manager ) {
        $elements_manager->add_category(
            'elematic-widgets',
            [
                'title' => esc_html__( 'Elematic Widgets', 'elematic-addons-for-elementor' ),
                'icon'  => 'eicon-fire',
            ]
        );
    }


}
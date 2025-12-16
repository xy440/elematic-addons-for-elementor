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
        require_once ELEMATIC_PATH . 'includes/class-module-manager.php';
        require_once ELEMATIC_PATH . 'includes/class-helper.php';
        require_once ELEMATIC_PATH . 'includes/class-enqueue.php';
        require_once ELEMATIC_PATH . 'includes/class-ajax-handler.php';
        require_once ELEMATIC_PATH . 'includes/class-image-choose.php';
        require_once ELEMATIC_PATH . 'base/module-base.php';

        new Plugin_Core();
        new Enqueue();
        new Helper();
        new WidgetManager();
        new ModuleManager();
        new Ajax_Handler();

        
    }

    private static function elematic_setup_hooks() {
        add_action( 'elementor/elements/categories_registered', [ __CLASS__, 'elematic_register_category' ] );
        
        // Register custom control
        add_action( 'elementor/controls/register', [ __CLASS__, 'register_custom_controls' ] );

        // Clear shapes cache on plugin activation/update
        add_action( 'upgrader_process_complete', [ __CLASS__, 'clear_shapes_cache_on_update' ], 10, 2 );
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

    /**
     * Register custom controls
     */
    public static function register_custom_controls( $controls_manager ) {
        require_once ELEMATIC_PATH . 'includes/class-image-choose.php';
        $controls_manager->register( new Image_Choose() );
    }

    /**
     * Clear shapes cache when plugin is updated
     */
    public static function clear_shapes_cache_on_update( $upgrader_object, $options ) {
        if ( isset( $options['plugins'] ) && is_array( $options['plugins'] ) ) {
            foreach ( $options['plugins'] as $plugin ) {
                if ( false !== strpos( $plugin, 'elematic' ) ) {
                    Helper::clear_svg_shapes_cache();
                    break;
                }
            }
        }
    }

    
}
<?php

namespace Elematic;

use Elementor\Widgets_Manager;

final class WidgetManager {

    private array $widgets = [
        'accordion',
        'animated-heading',
        'animated-shape',
        'button',
        'circle-progress-bar',
        'circle-text',
        'counter',
        'gallery',
        'grid',
        'highlight-text',
        'image-animate',
        'image-slide',
        'info-link',
        'lottie',
        'marquee',
        'progress-bar',
        'service-list',
    ];

    public function __construct() {
        add_action( 'elementor/widgets/register', [ $this, 'elematic_register_widgets' ] );
    }

    public function elematic_register_widgets( Widgets_Manager $widgets_manager ) {
        foreach ( $this->widgets as $widget_slug ) {
            $class_name = $this->elematic_resolve_class_name( $widget_slug );
            $file_path = ELEMATIC_PATH . 'widgets/' . $widget_slug . '/' . $widget_slug . '.php';

            if ( file_exists( $file_path ) ) {
                require_once $file_path;

                $fq_class = "\\Elematic\\Widgets\\$class_name";
                if ( class_exists( $fq_class ) ) {
                    $widgets_manager->register( new $fq_class );
                }
            }
        }
    }

    private function elematic_resolve_class_name( string $slug ): string {
        // Convert hyphenated slug to PascalCase class name
        return str_replace( ' ', '', ucwords( str_replace( '-', ' ', $slug ) ) );
    }
}
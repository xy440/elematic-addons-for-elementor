<?php

namespace Elematic;

if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Widgets_Manager;

final class WidgetManager {

    private array $widgets = [
        'accordion',
        'animated-heading',
        'animated-shape',
        'banner',
        'breadcrumbs',
        'button',
        'chart',
        'circle-info',
        'circle-progress-bar',
        'circle-text',
        'contact-form-7',
        'countdown',
        'counter',
        'dual-button',
        'features',
        'flip-box',
        'gallery',
        'grid',
        'highlight-text',
        'hotspot',
        'icon-box',
        'image-animate',
        'image-box',
        'image-comparison',
        'image-hover',
        'image-mask',
        'image-scrolling',
        'image-slide',
        'info-link',
        'logo',
        'lottie',
        'marquee',
        'menu',
        'page-title',
        'post-alter',
        'post-grid',
        'post-tiled',
        'progress-bar',
        'service-list',
        'table',
        'team',
        'timeline'
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
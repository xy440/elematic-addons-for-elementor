<?php
namespace Elematic;

if ( ! defined( 'ABSPATH' ) ) exit;

class Plugin_Core {

	public function __construct() {
		$this->elematic_setup_hooks();
	}

	private function elematic_setup_hooks() {
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'elematic_widget_styles' ] );
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'elematic_widget_scripts' ] );
	}

	public function elematic_widget_styles() {
		wp_register_style( 'animation', ELEMATIC_URL . 'assets/css/animation.min.css', [], ELEMATIC_VERSION );
		wp_register_style( 'elematic-accordion', ELEMATIC_URL . 'assets/css/widgets/accordion/accordion.min.css', [], ELEMATIC_VERSION );
		wp_register_style( 'elematic-animated-heading', ELEMATIC_URL . 'assets/css/widgets/animated-heading/animated-heading.min.css', [], ELEMATIC_VERSION );
		wp_register_style( 'elematic-animated-shape', ELEMATIC_URL . 'assets/css/widgets/animated-shape/animated-shape.min.css', [], ELEMATIC_VERSION );
		wp_register_style( 'elematic-button', ELEMATIC_URL . 'assets/css/widgets/button/button.min.css', [], ELEMATIC_VERSION );
		wp_register_style( 'elematic-circle-progress-bar', ELEMATIC_URL . 'assets/css/widgets/circle-progress-bar/circle-progress-bar.min.css', [], ELEMATIC_VERSION );
		wp_register_style( 'elematic-circle-text', ELEMATIC_URL . 'assets/css/widgets/circle-text/circle-text.min.css', [], ELEMATIC_VERSION );
		wp_register_style( 'elematic-counter', ELEMATIC_URL . 'assets/css/widgets/counter/counter.min.css', [], ELEMATIC_VERSION );
		wp_register_style( 'elematic-gallery', ELEMATIC_URL . 'assets/css/widgets/gallery/gallery.min.css', [], ELEMATIC_VERSION );
		wp_register_style( 'elematic-grid', ELEMATIC_URL . 'assets/css/widgets/grid/grid.min.css', [], ELEMATIC_VERSION );
		wp_register_style( 'elematic-highlight-text', ELEMATIC_URL . 'assets/css/widgets/highlight-text/highlight-text.min.css', [], ELEMATIC_VERSION );
		wp_register_style( 'elematic-image-animate', ELEMATIC_URL . 'assets/css/widgets/image-animate/image-animate.min.css', [], ELEMATIC_VERSION );
		wp_register_style( 'elematic-image-slide', ELEMATIC_URL . 'assets/css/widgets/image-slide/image-slide.min.css', [], ELEMATIC_VERSION );
		wp_register_style( 'elematic-info-link', ELEMATIC_URL . 'assets/css/widgets/info-link/info-link.min.css', [], ELEMATIC_VERSION );
		wp_register_style( 'elematic-lottie', ELEMATIC_URL . 'assets/css/widgets/lottie/lottie.min.css', [], ELEMATIC_VERSION );
		wp_register_style( 'elematic-marquee', ELEMATIC_URL . 'assets/css/widgets/marquee/marquee.min.css', [], ELEMATIC_VERSION );
		wp_register_style( 'elematic-progress-bar', ELEMATIC_URL . 'assets/css/widgets/progress-bar/progress-bar.min.css', [], ELEMATIC_VERSION );
		wp_register_style( 'elematic-service-list', ELEMATIC_URL . 'assets/css/widgets/service-list/service-list.min.css', [], ELEMATIC_VERSION );
	}


	public function elematic_widget_scripts() {
		wp_register_script( 'isotope', ELEMATIC_URL . 'assets/js/vendor/isotope.pkgd.min.js', [ 'jquery' ], ELEMATIC_VERSION, true );
		wp_register_script( 'imagesloaded', ELEMATIC_URL . 'assets/js/vendor/imagesloaded.pkgd.min.js', [ 'jquery' ], ELEMATIC_VERSION, true );

		wp_register_script( 'elematic-accordion', ELEMATIC_URL . 'assets/js/widgets/accordion/accordion.min.js', [ 'jquery' ], ELEMATIC_VERSION, true );
		wp_register_script( 'elematic-animated-heading', ELEMATIC_URL . 'assets/js/widgets/animated-heading/animated-heading.min.js', [ 'jquery' ], ELEMATIC_VERSION, true );
		wp_register_script( 'morphext', ELEMATIC_URL . 'assets/js/widgets/animated-heading/morphext.min.js', [ 'jquery' ], ELEMATIC_VERSION, true );
		wp_register_script( 'typed', ELEMATIC_URL . 'assets/js/widgets/animated-heading/typed.min.js', [ 'jquery' ], ELEMATIC_VERSION, true );
		wp_register_script( 'elematic-circle-progress-bar', ELEMATIC_URL . 'assets/js/widgets/circle-progress-bar/circle-progress-bar.min.js', [ 'jquery' ], ELEMATIC_VERSION, true );
		wp_register_script( 'asPieProgress', ELEMATIC_URL . 'assets/js/widgets/circle-progress-bar/jquery-asPieProgress.min.js', [ 'jquery' ], ELEMATIC_VERSION, true );
		wp_register_script( 'elematic-circle-text', ELEMATIC_URL . 'assets/js/widgets/circle-text/circle-text.min.js', [ 'jquery' ], ELEMATIC_VERSION, true );
		wp_register_script( 'elematic-counter', ELEMATIC_URL . 'assets/js/widgets/counter/counter.min.js', [ 'jquery' ], ELEMATIC_VERSION, true );
		wp_register_script( 'elematic-gallery', ELEMATIC_URL . 'assets/js/widgets/gallery/gallery.min.js', [ 'jquery' ], ELEMATIC_VERSION, true );
		wp_register_script( 'elematic-highlight-text', ELEMATIC_URL . 'assets/js/widgets/highlight-text/highlight-text.min.js', [ 'jquery' ], ELEMATIC_VERSION, true );
		wp_register_script( 'elematic-image-slide', ELEMATIC_URL . 'assets/js/widgets/image-slide/image-slide.min.js', [ 'jquery' ], ELEMATIC_VERSION, true );
		wp_register_script( 'infiniteslidev2', ELEMATIC_URL . 'assets/js/widgets/image-slide/infiniteslidev2.min.js', [ 'jquery' ], ELEMATIC_VERSION, true );
		wp_register_script( 'elematic-info-link', ELEMATIC_URL . 'assets/js/widgets/info-link/info-link.min.js', [ 'jquery' ], ELEMATIC_VERSION, true );
		wp_register_script( 'elematic-lottie', ELEMATIC_URL . 'assets/js/widgets/lottie/elematic-lottie.min.js', [ 'jquery' ], ELEMATIC_VERSION, true );
		wp_register_script( 'lottie', ELEMATIC_URL . 'assets/js/widgets/lottie/lottie.min.js', [ 'jquery' ], ELEMATIC_VERSION, true );
		wp_register_script( 'elematic-progress-bar', ELEMATIC_URL . 'assets/js/widgets/progress-bar/progress-bar.min.js', [ 'jquery' ], ELEMATIC_VERSION, true );
	}


}
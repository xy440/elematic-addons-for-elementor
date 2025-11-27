<?php 
namespace Elematic;
use Elementor\Base_Data_Control;

defined( 'ABSPATH' ) || exit;

class Image_Choose extends Base_Data_Control {

	/**
	 * Get choose control type.
	 *
	 * Retrieve the control type, in this case `choose`.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Control type.
	 */
	public function get_type() {
		return 'elematic-image-choose';
	}
	
	/**
	 * Enqueue ontrol scripts and styles.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enqueue() {

		// styles
		wp_register_style( 'elematic-image-choose-control', ELEMATIC_URL . 'assets/css/image-choose.min.css', [], ELEMATIC_VERSION );
		wp_enqueue_style( 'elematic-image-choose-control' );

		// script
		wp_register_script( 'elematic-image-choose-control', ELEMATIC_URL . 'assets/js/image-choose.min.js',  ['jquery'], ELEMATIC_VERSION, true);
		wp_enqueue_script( 'elematic-image-choose-control' );
	}

	/**
     * Render choose control output in the editor.
     */
    public function content_template() {
        $control_uid = $this->get_control_uid( '{{value}}' );
        ?>
        <div class="elementor-control-field">
            <label class="elementor-control-title">{{{ data.label }}}</label>
            <div class="elementor-control-input-wrapper">
                <div class="elementor-image-choices">
                    <# _.each( data.options, function( options, value ) { 
                        var control_uid = '<?php echo esc_attr( $control_uid ); ?>'.replace('{{value}}', value);
                    #>
                        <div class="image-choose-label-block" style="width:{{ options.width }}">
                            <input id="{{ control_uid }}" type="radio" name="elementor-choose-{{ data.name }}-{{ data._cid }}" value="{{ value }}">
                            <label class="elementor-image-choices-label" for="{{ control_uid }}" title="{{ options.title }}">
                                <img class="imagesmall" src="{{ options.imagesmall }}" alt="{{ options.title }}" />
                                <span class="elementor-screen-only">{{{ options.title }}}</span>
                            </label>
                        </div>
                    <# }); #>
                </div>
            </div>
        </div>

        <# if ( data.description ) { #>
            <div class="elementor-control-field-description">{{{ data.description }}}</div>
        <# } #>
        <?php
    }

    /**
     * Get choose control default settings.
     */
    protected function get_default_settings() {
        return array(
            'label_block' => true,
            'options'     => [],
            'toggle'      => false,
        );
    }
}
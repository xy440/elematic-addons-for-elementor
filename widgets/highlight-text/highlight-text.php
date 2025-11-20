<?php
namespace Elematic\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit;

class HighlightText extends Widget_Base {

	public function get_name() { 
		return 'elematic-highlight-text'; 
	}
	public function get_title() { 
		return esc_html__( 'Highlight Text', 'elematic-addons-for-elementor' ); 
	}
	public function get_icon() { 
		return 'eicon-text'; 
	}
	public function get_categories() { 
		return [ 'elematic-widgets' ]; 
	}

	public function get_style_depends() { 
		return [ 'elematic-highlight-text' ]; 
	}
	public function get_script_depends() {
		return [ 'elematic-highlight-text']; 
	}

	protected function register_controls() {

    $this->start_controls_section(
    	'elematic_highlight_text_content',
    	[
    		'label'=>esc_html__('Content','elematic-addons-for-elementor')
    	]
    );
    $this->add_control('elematic_highlight_text',
    	[
	      'label'=>__('Text','elematic-addons-for-elementor'),
	      'type'=>Controls_Manager::TEXTAREA,
	      'dynamic' => [
						'active' => true,
					],
	      'default'=>"We believe in pushing digital boundaries and exploring new creative horizons. You can trust our experienced team to guide you through every stage of the process and bring your vision to life."
	    ]
	);
    $this->add_control('elematic_highlight_color',
    	[
	      'label'=>__('Highlight Color','elematic-addons-for-elementor'),
	      'type'=>Controls_Manager::COLOR,
	      'default'=>'#111111'
	    ]
	);
    $this->add_control('elematic_muted_color',
    	[
	      'label'=>__('Muted Color','elematic-addons-for-elementor'),
	      'type'=>Controls_Manager::COLOR,
	      'default'=>'rgba(182,182,182,0.25)'
	    ]
	);
    $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'elematic_highlight_text_typography',
				'selector'  => '{{WRAPPER}} .elematic-highlight-text',
			]
		);
    $this->end_controls_section();
  }

  protected function render() {
    $s = $this->get_settings_for_display();
    $html = nl2br( wp_kses_post( $s['elematic_highlight_text'] ) );
    printf(
      '<div class="elematic-highlight-text" style="--elematic-active:%1$s;--elematic-muted:%2$s">%3$s</div>',
      esc_attr($s['elematic_highlight_color'] ?: '#111'),
      esc_attr($s['elematic_muted_color'] ?: 'rgba(182,182,182,.25)'),
      wp_kses_post( $html ) // escape/sanitize at output
    );
  }
}
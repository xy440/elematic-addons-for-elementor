<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elematic\Helper;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Accordion extends Widget_Base {

	public function get_name() {
		return 'elematic-accordion';
	}

	public function get_title() {
		return ELEMATIC . esc_html__( 'Accordion', 'elematic-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-accordion';
	}

	public function get_categories() {
		return [ 'elematic-widgets' ];
	}

	public function get_keywords() {
		return [ 'accordion', 'tabs', 'toggle' ];
	}

	public function get_script_depends() {
		return [ 'elematic-accordion'];
	}

	public function get_style_depends() {
		return [ 'elematic-accordion'];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Accordion', 'elematic-addons-for-elementor' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'tab_title',
			[
				'label' => esc_html__( 'Title', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Accordion Title', 'elematic-addons-for-elementor' ),
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'tab_content',
			[
				'label' => esc_html__( 'Content', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Accordion Content', 'elematic-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'tabs',
			[
				'label' => esc_html__( 'Accordion Items', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_title' => esc_html__( 'Accordion #1', 'elematic-addons-for-elementor' ),
						'tab_content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'elematic-addons-for-elementor' ),
					],
					[
						'tab_title' => esc_html__( 'Accordion #2', 'elematic-addons-for-elementor' ),
						'tab_content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'elematic-addons-for-elementor' ),
					],
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);
		$this->add_control(
		    'accordion_initial_state',
		    [
		        'label'   => esc_html__( 'Initial State', 'elematic-addons-for-elementor' ),
		        'type'    => \Elementor\Controls_Manager::SELECT,
		        'default' => 'first',
		        'options' => [
		            'first' => esc_html__( 'Open First Item', 'elematic-addons-for-elementor' ),
		            'all'   => esc_html__( 'Open All Items', 'elematic-addons-for-elementor' ),
		            'none'  => esc_html__( 'All Items Closed', 'elematic-addons-for-elementor' ),
		        ],
		    ]
		);
		$this->add_control(
			'selected_icon',
			[
				'label' => esc_html__( 'Icon', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::ICONS,
				'separator' => 'before',
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-plus',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'chevron-down',
						'angle-down',
						'angle-double-down',
						'caret-down',
						'caret-square-down',
					],
					'fa-regular' => [
						'caret-square-down',
					],
				],
				'skin' => 'inline',
				'label_block' => false,
			]
		);

		$this->add_control(
			'selected_active_icon',
			[
				'type' => Controls_Manager::ICONS,
				'label' => esc_html__( 'Active Icon', 'elematic-addons-for-elementor' ),
				'fa4compatibility' => 'icon_active',
				'default' => [
					'value' => 'fas fa-minus',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'chevron-up',
						'angle-up',
						'angle-double-up',
						'caret-up',
						'caret-square-up',
					],
					'fa-regular' => [
						'caret-square-up',
					],
				],
				'skin' => 'inline',
				'label_block' => false,
				'condition' => [
					'selected_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
            'elematic_accor_html_tag',
            [
                'label'   => esc_html__( 'HTML Tag', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'div',
                 'options' => Helper::elematic_html_tags(),
            ]
        );

		$this->add_control(
			'faq_schema',
			[
				'label' => esc_html__( 'FAQ Schema', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Accordion', 'elematic-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'elematic_accordion_background',
                'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ], // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_exclude
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                ],
                'selector' => '{{WRAPPER}} .elematic-accordion-item',
            ]
        );
		$this->add_control(
			'elematic_accordion_color',
			[
				'label' => esc_html__( 'Color', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elematic-accordion-item' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'elematic_accordion_border',
                'label' => esc_html__( 'Border', 'elematic-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .elematic-accordion-item',
            ]
        );
        $this->add_responsive_control(
            'elematic_accordion_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-accordion-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
			'elematic_accordion_padding',
			[
				'label' => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .elematic-accordion-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'elematic_accordion_margin',
			[
				'label' => esc_html__( 'Margin', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .elematic-accordion-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'elematic_accordion_box_shadow',
                'selector' => '{{WRAPPER}} .elematic-accordion-item',
            ]
        );
		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style_title',
			[
				'label' => esc_html__( 'Title', 'elematic-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_background',
			[
				'label' => esc_html__( 'Background', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elematic-accordion-tab-title' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elematic-accordion-icon, {{WRAPPER}} .elematic-accordion-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elematic-accordion-icon svg' => 'fill: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'tab_active_color',
			[
				'label' => esc_html__( 'Active Color', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elematic-accordion-active .elematic-accordion-icon, {{WRAPPER}} .elematic-accordion-active .elematic-accordion-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elematic-accordion-active .elematic-accordion-icon svg' => 'fill: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .elematic-accordion-title',

			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[
				'name' => 'text_stroke',
				'selector' => '{{WRAPPER}} .elematic-accordion-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'selector' => '{{WRAPPER}} .elematic-accordion-title',
			]
		);
		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'elematic_accordion_title_border',
                'label' => esc_html__( 'Border', 'elematic-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .elematic-accordion-tab-title',
            ]
        );
        $this->add_responsive_control(
            'elematic_accordion_title_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-accordion-tab-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		$this->add_responsive_control(
			'title_padding',
			[
				'label' => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .elematic-accordion-tab-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .elematic-accordion-tab-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style_icon',
			[
				'label' => esc_html__( 'Icon', 'elematic-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'selected_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label' => esc_html__( 'Alignment', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Start', 'elematic-addons-for-elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'End', 'elematic-addons-for-elementor' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => is_rtl() ? 'right' : 'left',
				'toggle' => false,
			]
		);
		$this->add_control(
			'icon_bg_color',
			[
				'label' => esc_html__( 'Background', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elematic-accordion-tab-title .elematic-accordion-icon i:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .elematic-accordion-tab-title .elematic-accordion-icon svg' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'icon_active_bg_color',
			[
				'label' => esc_html__( 'Active Background', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elematic-accordion-tab-title.elematic-accordion-active .elematic-accordion-icon i:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .elematic-accordion-tab-title.elematic-accordion-active .elematic-accordion-icon svg' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elematic-accordion-tab-title .elematic-accordion-icon i:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elematic-accordion-tab-title .elematic-accordion-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_active_color',
			[
				'label' => esc_html__( 'Active Color', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elematic-accordion-tab-title.elematic-accordion-active .elematic-accordion-icon i:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elematic-accordion-tab-title.elematic-accordion-active .elematic-accordion-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Size', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'max' => 100,
					],
					'em' => [
						'max' => 10,
					],
					'rem' => [
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elematic-accordion-tab-title .elematic-accordion-icon i:before' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elematic-accordion-tab-title .elematic-accordion-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'icon_space',
			[
				'label' => esc_html__( 'Spacing', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'max' => 100,
					],
					'em' => [
						'max' => 1,
					],
					'rem' => [
						'max' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elematic-accordion-icon.elematic-accordion-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elematic-accordion-icon.elematic-accordion-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'elematic_accordion_icon_border',
                'label' => esc_html__( 'Border', 'elematic-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .elematic-accordion-tab-title .elematic-accordion-icon i:before, {{WRAPPER}} .elematic-accordion-tab-title .elematic-accordion-icon svg',
            ]
        );
		$this->add_responsive_control(
            'elematic_accordion_icon_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-accordion-tab-title .elematic-accordion-icon i:before, {{WRAPPER}} .elematic-accordion-tab-title .elematic-accordion-icon svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
			'elematic_accordion_icon_padding',
			[
				'label' => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .elematic-accordion-tab-title .elematic-accordion-icon i:before, {{WRAPPER}} .elematic-accordion-tab-title .elematic-accordion-icon svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style_content',
			[
				'label' => esc_html__( 'Content', 'elematic-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_background_color',
			[
				'label' => esc_html__( 'Background', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elematic-accordion-tab-content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Color', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elematic-accordion-tab-content' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .elematic-accordion-tab-content',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'content_shadow',
				'selector' => '{{WRAPPER}} .elematic-accordion-tab-content',
			]
		);
		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'elematic_accordion_content_border',
                'label' => esc_html__( 'Border', 'elematic-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .elematic-accordion-tab-content',
            ]
        );
        $this->add_responsive_control(
            'elematic_accordion_content_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-accordion-tab-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		$this->add_responsive_control(
			'content_padding',
			[
				'label' => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .elematic-accordion-tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'content_margin',
			[
				'label' => esc_html__( 'Margin', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .elematic-accordion-tab-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render accordion widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$migrated = isset( $settings['__fa4_migrated']['selected_icon'] );

		if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			$settings['icon'] = 'fa fa-plus';
			$settings['icon_active'] = 'fa fa-minus';
			$settings['icon_align'] = $this->get_settings( 'icon_align' );
		}

		$is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
		$has_icon = ( ! $is_new || ! empty( $settings['selected_icon']['value'] ) );
		$id_int = substr( $this->get_id_int(), 0, 3 );
		?>
		
		<div class="elematic-accordion" data-initial-state="<?php echo esc_attr( $settings['accordion_initial_state'] ); ?>">
			<?php
			foreach ( $settings['tabs'] as $index => $item ) :
				$tab_count = $index + 1;

				$tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );

				$tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', $index );

				$this->add_render_attribute( $tab_title_setting_key, [
					'id' => 'elematic-accordion-tab-title-' . $id_int . $tab_count,
					'class' => [ 'elematic-accordion-tab-title' ],
					'data-tab' => $tab_count,
					'role' => 'button',
					'aria-controls' => 'elematic-accordion-tab-content-' . $id_int . $tab_count,
					'aria-expanded' => 'false',
				] );

				$this->add_render_attribute( $tab_content_setting_key, [
					'id' => 'elematic-accordion-tab-content-' . $id_int . $tab_count,
					'class' => [ 'elematic-accordion-tab-content', 'clearfix' ],
					'data-tab' => $tab_count,
					'role' => 'region',
					'aria-labelledby' => 'elematic-accordion-tab-title-' . $id_int . $tab_count,
				] );

				$this->add_inline_editing_attributes( $tab_content_setting_key, 'advanced' );
				?>
				<div class="elematic-accordion-item">
					<<?php Utils::print_validated_html_tag( $settings['elematic_accor_html_tag'] ); ?> <?php $this->print_render_attribute_string( $tab_title_setting_key ); ?>>
						<?php if ( $has_icon ) : ?>
							<span class="elematic-accordion-icon elematic-accordion-icon-<?php echo esc_attr( $settings['icon_align'] ); ?>" aria-hidden="true">
							<?php
							if ( $is_new || $migrated ) { ?>
								<span class="elematic-accordion-icon-closed"><?php Icons_Manager::render_icon( $settings['selected_icon'] ); ?></span>
								<span class="elematic-accordion-icon-opened"><?php Icons_Manager::render_icon( $settings['selected_active_icon'] ); ?></span>
							<?php } else { ?>
								<i class="elematic-accordion-icon-closed <?php echo esc_attr( $settings['icon'] ); ?>"></i>
								<i class="elematic-accordion-icon-opened <?php echo esc_attr( $settings['icon_active'] ); ?>"></i>
							<?php } ?>
							</span>
						<?php endif; ?>
						<span class="elematic-accordion-title" tabindex="0"><?php $this->print_unescaped_setting( 'tab_title', 'tabs', $index );	?></span>
					</<?php Utils::print_validated_html_tag( $settings['elematic_accor_html_tag'] ); ?>>
					<div <?php $this->print_render_attribute_string( $tab_content_setting_key ); ?>><?php
						$this->print_text_editor( $item['tab_content'] );
					?></div>
				</div>
			<?php endforeach; ?>
			<?php
			if ( isset( $settings['faq_schema'] ) && 'yes' === $settings['faq_schema'] ) {
				$json = [
					'@context' => 'https://schema.org',
					'@type' => 'FAQPage',
					'mainEntity' => [],
				];

				foreach ( $settings['tabs'] as $index => $item ) {
					$json['mainEntity'][] = [
						'@type' => 'Question',
						'name' => wp_strip_all_tags( $item['tab_title'] ),
						'acceptedAnswer' => [
							'@type' => 'Answer',
							'text' => $this->parse_text_editor( $item['tab_content'] ),
						],
					];
				}
				?>
				<script type="application/ld+json"><?php echo wp_json_encode( $json ); ?></script>
			<?php } ?>
		</div>
		<?php
	}

	
}

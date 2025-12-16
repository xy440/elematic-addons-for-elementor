<?php
namespace Elematic\widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Table extends Widget_Base {

    public function get_name() {
        return 'elematic-table';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( 'Table', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-table';
    }
    public function get_style_depends() {
        return [ 'elematic-table' ];
    }
    public function get_script_depends() {
        return [ 'elematic-table' ];
    }

    public function get_categories() {
        return [ 'elematic-widgets' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'sec_table_header',
            [
                'label' => esc_html__( 'Header', 'elematic-addons-for-elementor' )
            ]
        );
        $repeater = new Repeater();
        $repeater->add_control(
            'tx_table_header_col', 
            [
                'label' => esc_html__( 'Title', 'elematic-addons-for-elementor' ),
                'default' => 'Table Header',
                'type' => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control(
            'tx_table_header_col_span', 
            [
                'label' => esc_html__( 'Span', 'elematic-addons-for-elementor' ),
                'default' => '',
                'type' => Controls_Manager::NUMBER,
            ]
        );
        $repeater->add_control(
            'tx_table_header_col_icon_enabled', 
            [
                'label' => esc_html__( 'Header Icon', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'yes', 'elematic-addons-for-elementor' ),
                'label_off' => esc_html__( 'no', 'elematic-addons-for-elementor' ),
                'default' => 'false',
                'return_value' => 'true',
            ]
        );
        $repeater->add_control(
            'tx_table_header_icon_type', 
            [
                'label' => esc_html__( 'Icon Type', 'elematic-addons-for-elementor' ),
                'type'  => Controls_Manager::CHOOSE,
                    'options'               => [
                        'icon'        => [
                        'title'   => esc_html__( 'Icon', 'elematic-addons-for-elementor' ),
                        'icon'    => 'fa fa-star',
                    ],
                        'image'       => [
                        'title'   => esc_html__( 'Image', 'elematic-addons-for-elementor' ),
                        'icon'    => 'far fa-image',
                            ],
                        ],
                'default'               => 'icon',
                'condition' => [
                    'tx_table_header_col_icon_enabled' => 'true'
                ]
            ]
        );
        $repeater->add_control(
            'tx_table_header_col_icon', 
            [
                'name' => 'tx_table_header_col_icon',
                'label' => esc_html__( 'Icon', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::ICON,
                'default' => '',
                'condition' => [
                    'tx_table_header_col_icon_enabled' => 'true',
                    'tx_table_header_icon_type'  => 'icon'
                ]
            ]
        );
        $repeater->add_control(
            'tx_table_header_col_img', 
            [
                'label' => esc_html__( 'Image', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                'tx_table_header_icon_type'  => 'image'
                ]
            ]
        );
        $repeater->add_control(
            'tx_table_header_col_img_size', 
            [
                'label' => esc_html__( 'Image Size', 'elematic-addons-for-elementor' ),
                'default' => '25',
                'type' => Controls_Manager::NUMBER,
                'label_block' => false,
                'condition' => [
                    'tx_table_header_icon_type'  => 'image'
                ]
            ]
        );

        $this->add_control(
            'tx_table_header',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [ 'tx_table_header_col' => 'Table Header' ],
                    [ 'tx_table_header_col' => 'Table Header' ],
                    [ 'tx_table_header_col' => 'Table Header' ],
                    [ 'tx_table_header_col' => 'Table Header' ],
                ],

                'title_field' => '{{{ tx_table_header_col }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'sec_table_body',
            [
                'label' => esc_html__( 'Body', 'elematic-addons-for-elementor' )
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'tx_table_body_type', 
            [
                'label' => esc_html__( 'Type', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'row',
                'options' => [
                    'row' => esc_html__( 'Row', 'elematic-addons-for-elementor' ),
                    'col' => esc_html__( 'Column', 'elematic-addons-for-elementor' ),
                ]
            ]
        );
        $repeater->add_control(
            'tx_table_body_colspan', 
            [
                'label'         => esc_html__( 'Col Span', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 1,
                'min'           => 1,
                'label_block'   => true,
                'condition'     => [
                    'tx_table_body_type' => 'col'
                ]
            ]
        );
        $repeater->add_control(
            'tx_table_body_rowspan', 
            [
                'label'         => esc_html__( 'Row Span', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 1,
                'min'           => 1,
                'label_block'   => true,
                'condition'     => [
                    'tx_table_body_type' => 'col'
                ]
            ]
        );
        $repeater->add_control(
            'tx_table_body_content', 
            [
                'type' => Controls_Manager::WYSIWYG,
                'label_block' => true,
                'default' => esc_html__( 'Content', 'elematic-addons-for-elementor' ),
                'condition' => [
                    'tx_table_body_type' => 'col',
                ]
            ]
        );

        $this->add_control(
            'tx_table_body',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [ 'tx_table_body_type' => 'row' ],
                    [ 'tx_table_body_type' => 'col' ],
                    [ 'tx_table_body_type' => 'col' ],
                    [ 'tx_table_body_type' => 'col' ],
                    [ 'tx_table_body_type' => 'col' ],
                ],
                
                'title_field' => '{{{ tx_table_body_type }}}',
            ]
        );

        $this->end_controls_section();

        // styles
        $this->start_controls_section(
            'sec_styles',
            [
                'label' => esc_html__( 'General', 'elematic-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'table_width',
            [
                'label'                 => esc_html__( 'Width', 'elematic-addons-for-elementor' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'size_units'            => [ '%', 'px' ],
                'range'                 => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1200,
                    ],
                ],
                'selectors'             => [
                    '{{WRAPPER}} .elematic-table' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'table_alignment',
            [
                'label'                 => esc_html__( 'Alignment', 'elematic-addons-for-elementor' ),
                'type'                  => Controls_Manager::CHOOSE,
                'label_block'           => false,
                'default'               => 'center',
                'options'               => [
                    'left'      => [
                        'title' => esc_html__( 'Left', 'elematic-addons-for-elementor' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center'    => [
                        'title' => esc_html__( 'Center', 'elematic-addons-for-elementor' ),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right'     => [
                        'title' => esc_html__( 'Right', 'elematic-addons-for-elementor' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class'           => 'elematic-table-align-',
                'toggle' => false
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'sec_table_header_styles',
            [
                'label' => esc_html__( 'Header Style', 'elematic-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );


        $this->add_control(
            'table_header_radius',
            [
                'label' => esc_html__( 'Header Border Radius', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-table thead tr th:first-child' => 'border-radius: {{SIZE}}px 0px 0px 0px;',
                    '{{WRAPPER}} .elematic-table thead tr th:last-child' => 'border-radius: 0px {{SIZE}}px 0px 0px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'table_header_padding',
            [
                'label' => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-table .table-header th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-table tbody tr td .th-mobile-screen' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('table_header_title_tabs');

            $this->start_controls_tab( 'table_header_title_normal', [ 'label' => esc_html__( 'Normal', 'elematic-addons-for-elementor' ) ] );

                $this->add_control(
                    'table_header_title_color',
                    [
                        'label' => esc_html__( 'Color', 'elematic-addons-for-elementor' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .elematic-table thead tr th' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'table_header_bg_color',
                    [
                        'label' => esc_html__( 'Background Color', 'elematic-addons-for-elementor' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .elematic-table thead tr th' => 'background-color: {{VALUE}};'
                        ],
                    ]
                );
                
                $this->add_group_control(
                    Group_Control_Border::get_type(),
                        [
                            'name' => 'table_header_border_color',
                            'label' => esc_html__( 'Border', 'elematic-addons-for-elementor' ),
                            'selector' => '{{WRAPPER}} .elematic-table thead tr th',
                        ]
                );

            $this->end_controls_tab();
            
            $this->start_controls_tab( 'table_header_title_hover', [ 'label' => esc_html__( 'Hover', 'elematic-addons-for-elementor' ) ] );

                $this->add_control(
                    'table_header_title_hover_color',
                    [
                        'label' => esc_html__( 'Color', 'elematic-addons-for-elementor' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .elematic-table thead tr th:hover' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'table_header_title_hover_bg_color',
                    [
                        'label' => esc_html__( 'Background Color', 'elematic-addons-for-elementor' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .elematic-table thead tr th:hover' => 'background-color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                        [
                            'name' => 'table_header_hover_border',
                            'label' => esc_html__( 'Border', 'elematic-addons-for-elementor' ),
                            'selector' => '{{WRAPPER}} .elematic-table thead tr th:hover',
                        ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'table_header_title_typography',
                'selector' => '{{WRAPPER}} .elematic-table thead tr th',
            ]
        );

        $this->add_responsive_control(
            'table_header_title_alignment',
            [
                'label' => esc_html__( 'Title Alignment', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'prefix_class' => 'elematic-table-dt-th-align-',
            ]
        );

        $this->end_controls_section();

        /**
         * -------------------------------------------
         * Body Style
         * -------------------------------------------
         */
        $this->start_controls_section(
            'sec_body_styles',
            [
                'label' => esc_html__( 'Body Style', 'elematic-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('table_body_tabs');

            $this->start_controls_tab('table_body_normal', ['label' => esc_html__( 'Normal', 'elematic-addons-for-elementor')]);

                $this->add_control(
                    'table_content_color_odd',
                    [
                        'label' => esc_html__( 'Odd Row Color', 'elematic-addons-for-elementor' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .elematic-table tbody > tr:nth-child(2n) td' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'table_content_bg_odd',
                    [
                        'label' => esc_html__( 'Odd Row Background Color', 'elematic-addons-for-elementor' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .elematic-table tbody > tr:nth-child(2n) td' => 'background: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'table_content_even_color',
                    [
                        'label' => esc_html__( 'Even Row Color', 'elematic-addons-for-elementor' ),
                        'type' => Controls_Manager::COLOR,
                        'separator' => 'before',
                        'selectors' => [
                            '{{WRAPPER}} .elematic-table tbody > tr:nth-child(2n+1) td' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'table_content_bg_even_color',
                    [
                        'label' => esc_html__( 'Even Row Background Color', 'elematic-addons-for-elementor' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .elematic-table tbody > tr:nth-child(2n+1) td' => 'background-color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                        [
                            'name' => 'table_cell_border',
                            'label' => esc_html__( 'Border', 'elematic-addons-for-elementor' ),
                            'selector' => '{{WRAPPER}} .elematic-table tbody tr td',
                             'separator' => 'before'
                        ]
                );

                $this->add_responsive_control(
                    'table_cell_padding',
                    [
                        'label' => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => [ 'px', 'em' ],
                        'selectors' => [
                                 '{{WRAPPER}} .elematic-table tbody tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                         ],
                          'separator' => 'after',
                    ]
                );

            $this->end_controls_tab();
            
            $this->start_controls_tab('table_body_odd_cell_hover_style', ['label' => esc_html__( 'Hover', 'elematic-addons-for-elementor')]);

                $this->add_control(
                    'table_content_hover_color_odd',
                    [
                        'label' => esc_html__( 'Odd Row Color', 'elematic-addons-for-elementor' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .elematic-table tbody > tr:nth-child(2n) td:hover' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'table_content_hover_bg_odd',
                    [
                        'label' => esc_html__( 'Odd Row Background Color', 'elematic-addons-for-elementor' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .elematic-table tbody > tr:nth-child(2n) td:hover' => 'background: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'table_content_hover_color_even',
                    [
                        'label' => esc_html__( 'Even Row Color', 'elematic-addons-for-elementor' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .elematic-table tbody > tr:nth-child(2n+1) td:hover' => 'color: {{VALUE}};',
                        ],
                         'separator' => 'before'
                    ]
                );

                $this->add_control(
                    'table_content_bg_even_hover_color',
                    [
                        'label' => esc_html__( 'Even Row Background Color', 'elematic-addons-for-elementor' ),
                        'type' => Controls_Manager::COLOR,
                        'default' => '',
                        'selectors' => [
                            '{{WRAPPER}} .elematic-table tbody > tr:nth-child(2n+1) td:hover' => 'background-color: {{VALUE}};',
                        ],
                         'separator' => 'after',
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'table_content_typography',
                'selector' => '{{WRAPPER}} .elematic-table tbody tr td',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'table_content_alignment',
            [
                'label' => esc_html__( 'Content Alignment', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'prefix_class' => 'elematic-table-dt-td-align-',
                'toggle' => false
            ]
        );
        $this->end_controls_section();
    }


    protected function render( ) {

        $settings = $this->get_settings_for_display();

        $table_tr = [];
        $table_td = [];

        foreach( $settings['tx_table_body'] as $content_row ) {

            $row_id = wp_rand(10, 1000);
            if( $content_row['tx_table_body_type'] == 'row' ) {
                $table_tr[] = [
                    'id' => $row_id,
                    'type' => $content_row['tx_table_body_type'],
                ];

            }
            if( $content_row['tx_table_body_type'] == 'col' ) {
                $table_tr_keys = array_keys( $table_tr );
                  $last_key = end( $table_tr_keys );

                $table_td[] = [
                    'row_id'        => $table_tr[$last_key]['id'],
                    'type'          => $content_row['tx_table_body_type'],
                    'content'         => $content_row['tx_table_body_content'],
                    'colspan'       => $content_row['tx_table_body_colspan'],
                    'rowspan'       => $content_row['tx_table_body_rowspan'],
                ];
            }
        }  
        $table_th_count = count($settings['tx_table_header']);
        $this->add_render_attribute('elematic-table-wrap', [
            'class'                  => 'elematic-table-wrap',
            'data-table_id'          => esc_attr($this->get_id()),
        ]);

        $this->add_render_attribute('elematic-table', [
            'class' => [ 'table elematic-table', esc_attr($settings['table_alignment']) ],
            'id'    => 'elematic-table-'.esc_attr($this->get_id())
        ]);

        $this->add_render_attribute( 'td_content', [
            'class' => 'td-content',
        ]);

        ?>
        <div <?php $this->print_render_attribute_string('elematic-table-wrap'); ?>>
            <table <?php $this->print_render_attribute_string('elematic-table'); ?>>
                <thead>
                    <tr class="table-header">
                        <?php $i = 0; foreach( $settings['tx_table_header'] as $header_title ) :
                            $this->add_render_attribute('th_class'.$i, [
                                'colspan'   => $header_title['tx_table_header_col_span']
                            ]);
                        ?>
                        <th <?php $this->print_render_attribute_string('th_class'.$i); ?>>
                            <?php
                                if( $header_title['tx_table_header_col_icon_enabled'] == 'true' && $header_title['tx_table_header_icon_type'] == 'icon' ) :
                                    $this->add_render_attribute('table_header_col_icon'.$i, [
                                        'class' => [ 'data-header-icon', esc_attr( $header_title['tx_table_header_col_icon'] )]
                                    ]);
                            ?>
                                <i <?php $this->print_render_attribute_string('table_header_col_icon'.$i); ?>></i>
                            <?php endif; ?>
                            <?php
                                if( $header_title['tx_table_header_col_icon_enabled'] == 'true' && $header_title['tx_table_header_icon_type'] == 'image' ) :
                                    $this->add_render_attribute('data_table_th_img'.$i, [
                                        'src'   => esc_url( $header_title['tx_table_header_col_img']['url'] ),
                                        'class' => 'elematic-table-th-img',
                                        'style' => "width:{$header_title['tx_table_header_col_img_size']}px;",
                                        'alt'   => esc_attr( $header_title['tx_table_header_col'] )
                                    ]);
                            ?><img <?php $this->print_render_attribute_string('data_table_th_img'.$i); ?>><?php endif; ?><?php echo esc_html( $header_title['tx_table_header_col'] ); ?></th>
                        <?php $i++; endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php for( $i = 0; $i < count( $table_tr ); $i++ ) : ?>
                        <tr>
                            <?php
                                for( $j = 0; $j < count( $table_td ); $j++ ) {
                                    if( $table_tr[$i]['id'] == $table_td[$j]['row_id'] ) {

                                        $this->add_render_attribute('table_inside_td'.$i.$j,
                                            [
                                                'colspan' => ($table_td[$j]['colspan'] > 1) ? $table_td[$j]['colspan'] : '',
                                                'rowspan' => ($table_td[$j]['rowspan'] > 1) ? $table_td[$j]['rowspan'] : '',
                                            ]
                                        );
                                        ?>
                                            <td <?php $this->print_render_attribute_string('table_inside_td'.$i.$j); ?>>
                                                <div class="td-content-wrapper">
                                                    <div <?php $this->print_render_attribute_string('td_content'); ?>>
                                                        <?php echo wp_kses_post($table_td[$j]['content']); ?>
                                                    </div>
                                                </div>
                                            </td>
                                        <?php
                                    }
                                }
                            ?>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
        <?php
    } // render
} //class

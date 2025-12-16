<?php
namespace Elematic\Widgets;
use elementor\Widget_Base;
use elementor\Controls_Manager;
use elementor\Group_Control_Border;
use elementor\Group_Control_Typography;
use elementor\Icons_Manager;
use elementor\Utils;
use Elematic\Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PageTitle extends Widget_Base {

	public function get_name() {
		return 'elematic-page-title';
	}

	public function get_title() {
		return ELEMATIC . esc_html__( 'Page Title', 'elematic-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-archive-title';
	}

	public function get_categories() {
		return [ 'elematic-widgets' ];
	}

	public function get_keywords() {
		return [ 'title', 'heading', 'name', 'page title', 'post title', 'archive title' ];
	}
	
	protected function register_controls() {
		$this->start_controls_section(
			'pt_settings',
			[
				'label' => esc_html__( 'Settings', 'elematic-addons-for-elementor' ),
			]
		);

        $this->add_control(
            'pt_html_tag',
            [
                'label'   => esc_html__( 'HTML Tag', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h1',
                 'options' => Helper::elematic_html_tags(),
            ]
        );
		
		$this->add_responsive_control(
            'pt_alignment',
            [
                'label' => esc_html__( 'Alignment', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
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
                'toggle' => false,
                'selectors'         => [
					'{{WRAPPER}} .elematic-page-title'   => 'text-align: {{VALUE}};',
				],

            ]
        );
		$this->end_controls_section();

		$this->start_controls_section(
            'pt_styles',
            [
                'label'                 => esc_html__( 'Style', 'elematic-addons-for-elementor' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
            'pt_color',
            [
                'label'     => esc_html__( 'Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-page-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'pt_typo',
                'selector'  => '{{WRAPPER}} .elematic-page-title',
            ]
        );
        $this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
	?>

		<<?php echo esc_attr($settings['pt_html_tag']); ?> class="elematic-page-title">
		<?php 
            if( !is_front_page() && !is_archive() ) :
                echo esc_html( get_the_title() );

            elseif ( is_archive() && !is_post_type_archive('product') ) :
                echo post_type_archive_title();
                echo single_term_title();
                echo esc_html( get_the_author_meta('nickname') );             

            elseif( is_post_type_archive('product') ) :
                woocommerce_page_title( false );

            endif;
        ?>
		</<?php echo esc_attr($settings['pt_html_tag']); ?>>
		
		
<?php } // render()

} // class

<?php
namespace Elementor;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Ultra_Slider_Block extends Widget_Base {
	use \Elementor\WPOPEACommonFunctions;

	public function get_title() {
		return esc_html__( 'Slider Block', 'wpopea' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}
	public function get_categories() {
		return [ 'ultra-elements' ];
	}
	public function get_name() {
		return 'ultra-slider-block';
	}

	public function get_script_depends() {
		return [
			'lightslider',
			'ultra-custom-js'
			
		];
	}

	public function get_style_depends() {
		return [
			'lightslider',
		];
	}

	protected function _register_controls() {

		/* Query Settings */
		$this->start_controls_section(
			'wpop_query_settings',
			[
				'label' => esc_html__( 'Query Settings', 'wpopea' )
			]
		); 

		$this->add_control(
			'post_type',
			[
				'label' => esc_html__( 'Post Type', 'wpopea' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'latest'   => esc_html__('Latest','wpopea'),
					'category'     => esc_html__('Category','wpopea'),
				],
				'default' => 'latest'
			]
		);

		$this->add_control(
			'category',
			[
				'label' => esc_html__( 'Categories', 'wpopea' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'label_block' => true,
				'options' => get_post_type_categories('category'),
				'condition' => [
					'post_type' => 'category'
				]
			]
		);

		$this->add_control(
			'per_page',
			[
				'label' => esc_html__( 'No. of Posts', 'wpopea' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 3
			]
		);

		$this->add_control(
			'offset',
			[
				'label' => esc_html__( 'No. of Offset', 'wpopea' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
			]
		);

		$this->end_controls_section();

		/* Meta Settings */
		$this->start_controls_section(
			'wpop_meta_section',
			[
				'label' => esc_html__( 'Post Meta Settings', 'wpopea' ),
			]
		); 

		$this->add_control(
			'show_category',
			[
				'label' => esc_html__( 'Show Category', 'wpopea' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'true',
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'show_meta',
			[
				'label' => esc_html__( 'Show Meta', 'wpopea' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'true',
				'return_value' => 'true',
			]
		);

		$this->end_controls_section();

		/* 
		** Title Styles 
		**/
		$this->start_controls_section(
			'ultra_title_style_settings',
			[
				'label' => esc_html__( 'Title Style ', 'wpopea' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ultra_cat_title_typography',
				'selector' => '{{WRAPPER}} .slider-caption h3',
			]
		);

		$this->start_controls_tabs( 'ultra_title_tabs' );

        // Normal State Tab
		$this->start_controls_tab( 'ultra_title_normal', [ 'label' => esc_html__( 'Normal', 'wpopea' ) ] );

		$this->add_control(
			'ultra_title_color',
			[
				'label' => esc_html__( 'Color', 'wpopea' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .slider-caption h3 a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
        // Hover State Tab
		$this->start_controls_tab( 'ultra_title_hover', [ 'label' => esc_html__( 'Hover', 'wpopea' ) ] );

		$this->add_control(
			'ultra_title_hcolor',
			[
				'label' => esc_html__( 'Color', 'wpopea' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .slider-caption h3 a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs(); 

		$this->add_responsive_control(
			'ultra_title_padding',
			[
				'label' => esc_html__( 'Padding', 'wpopea' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .slider-caption h3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* Meta Styles */
        $this->wpop_meta_styles();


	}

	protected function render( ) {

	    // get our input from the widget settings.
		$settings = $this->get_settings();

		$ultra_slider_type = $settings['post_type'];
		$ultra_slider_per_page = $settings['per_page'];
		$ultra_cat_slider = !empty($settings['category']) ? $settings['category'] : null;
		$ultra_slider_offset = $settings['offset'];

		$cat_show = $settings['show_category'];
		$show_meta = $settings['show_meta'];

		?>

		<div class="ultra-main-slider clearfix fullwidth">

			<div class="slider-section">
				<?php
				$ultra_seven_slider_args = ultra_seven_query_args( $ultra_slider_type, $ultra_slider_per_page, $ultra_cat_slider,$ultra_slider_offset );
				$ultra_seven_slider_query = new \WP_Query( $ultra_seven_slider_args );
				if( $ultra_seven_slider_query->have_posts() ) {
					echo '<ul class="ultraSlider cS-hidden">';
					while( $ultra_seven_slider_query->have_posts() ) {
						$ultra_seven_slider_query->the_post();
						$image_id = get_post_thumbnail_id();

						$image_path = wp_get_attachment_image_src( $image_id, 'ultra-image-1400x840', true );									
						$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
						if( has_post_thumbnail() ) { ?>
							<li class="slide">
								<a class="slider-img thumb-zoom" href="<?php the_permalink(); ?>">
									<img src="<?php echo esc_url( $image_path[0] ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" title="<?php the_title(); ?>">
								</a>
								<div class="slider-caption">
									<?php 
									if($cat_show == true){
										do_action( 'ultra_seven_post_cat_or_tag_lists' ); 
									}
									?>
									<h3 class="featured-large-font"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<?php if($show_meta == true){?>
										<div class="post-meta">
											<?php 
											do_action( 'ultra_seven_post_meta' );
											?>
										</div>
									<?php }?>
								</div>
							</li>
							<?php
						}
					}
					wp_reset_postdata();
					echo '</ul>';
				}       
				?>
			</div><!-- .slider-section -->
		</div>
			<?php
			if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
				$this->render_editor_script();
			}
		}
		protected function render_editor_script() { ?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {

					$('.ultraSlider').lightSlider({
						adaptiveHeight: true,
						item: 1,
						slideMargin: 0,
						enableDrag: false,
						loop: true,
						pager: false,
						pagerHtml: false,
						auto: true,
						speed: 700,
						pause: 4200,
						onSliderLoad: function() {
							$('.ultraSlider').removeClass('cS-hidden');

						}
					});

				});
			</script> 
			<?php
		}  
		protected function content_template() {}

		public function render_plain_content( $instance = [] ) {}
	}

	Plugin::instance()->widgets_manager->register_widget_type( new Widget_Ultra_Slider_Block() );
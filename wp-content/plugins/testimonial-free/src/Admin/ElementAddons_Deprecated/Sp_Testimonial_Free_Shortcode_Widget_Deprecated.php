<?php
/**
 * Framework options.class file.
 *
 * @link https://shapedplugin.com
 * @since 2.0.0
 *
 * @package Testimonial_free
 * @subpackage Testimonial_free/Admin
 */

namespace ShapedPlugin\TestimonialFree\Admin\ElementAddons_Deprecated;

use ShapedPlugin\TestimonialFree\Frontend\Helper;

/**
 * Elementor real testimonial free shortcode Widget.
 *
 * @since 2.5.2
 */
class Sp_Testimonial_Free_Shortcode_Widget_Deprecated extends \Elementor\Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since 2.5.2
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'real_testimonial_free_shortcode';
	}

	/**
	 * Get widget title.
	 *
	 * @since 2.5.2
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Real Testimonial Deprecated', 'testimonial-free' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 2.5.2
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'icon-rt';
	}

	/**
	 * Get widget categories.
	 *
	 * @since 2.5.2
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'deprecated' );
	}

	/**
	 * Get all post list.
	 *
	 * @since 2.5.2
	 * @return array
	 */
	public function sprtp_post_list() {
		$post_list   = array();
		$sprtp_posts = new \WP_Query(
			array(
				'post_type'      => 'spt_shortcodes',
				'post_status'    => 'publish',
				'posts_per_page' => 9999,
			)
		);

		$posts       = $sprtp_posts->posts;
		foreach ( $posts as $post ) {
			$post_list[ $post->ID ] = $post->post_title;
		}
		krsort( $post_list );
		return $post_list;
	}

	/**
	 * Controls register.
	 *
	 * @return void
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => __( 'Content', 'testimonial-free' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'sp_testimonial_free_shortcode',
			array(
				'label'       => __( 'Real Testimonial Shortcode(s)', 'testimonial-free' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'default'     => '',
				'options'     => $this->sprtp_post_list(),
			)
		);

		$this->add_control(
			'deprecated_notice',
			array(
				'type'            => \Elementor\Controls_Manager::DEPRECATED_NOTICE,
				'widget'          => 'Real Testimonial Deprecated',
				'since'           => '2.5.5',
				'last'            => '2.5.8',
				'plugin'          => 'Real Testimonials',
				'replacement'     => 'Real Testimonials Pro',
				'content_classes' => 'sp-real-testimonial-deprecated',
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Render testimonial shortcode widget output on the frontend.
	 *
	 * @since 2.5.2
	 * @access protected
	 */
	protected function render() {

		$settings                 = $this->get_settings_for_display();
		$sp_testimonial_shortcode = $settings['sp_testimonial_free_shortcode'];

		if ( '' === $sp_testimonial_shortcode ) {
			echo '<div style="text-align: center; margin-top: 0; padding: 10px" class="elementor-add-section-drag-title">Select a shortcode</div>';
			return;
		}

		$generator_id = $sp_testimonial_shortcode;

		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			$post_id            = $generator_id;
			$setting_options    = get_option( 'sp_testimonial_pro_options' );
			$shortcode_data     = get_post_meta( $post_id, 'sp_tpro_shortcode_options', true );
			$main_section_title = get_the_title( $post_id );
			Helper::sp_testimonial_html_show( $post_id, $setting_options, $shortcode_data, $main_section_title );
			?>
			<script>
			jQuery('#sp-testimonial-preloader-' + <?php echo esc_attr( $generator_id ); ?>).animate({ opacity: 0, zIndex: -99 }, 600);
			</script>
			<script src="<?php echo esc_url( SP_TFREE_URL . 'Frontend/assets/js/sp-slick-active.min.js' ); ?>" ></script>
			<?php
		} else {
			echo do_shortcode( '[sp_testimonial id="' . $generator_id . '"]' );
		}

	}

}

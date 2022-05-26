<?php
/**
 * The Frontend class to manage all output and enqueue Scripts and styles files of the plugin.
 *
 * @link http://shapedplugin.com
 * @since 2.0.0
 *
 * @package Testimonial_free.
 * @subpackage Testimonial_free/Frontend.
 */

namespace ShapedPlugin\TestimonialFree\Frontend;

use ShapedPlugin\TestimonialFree\Frontend\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; }  // if direct access

/**
 * Frontend class
 */
class Frontend {

	/**
	 * Single instance of the class.
	 *
	 * @var null
	 * @since 1.0
	 */
	protected static $_instance = null;

	/**
	 * Frontend Instance.
	 *
	 * @return Frontend
	 * @since 1.0
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Initialize the class
	 */
	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'front_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_front_scripts' ) );
		add_shortcode( 'sp_testimonial', array( $this, 'shortcode_render' ) );
	}

	/**
	 * Shortcode render.
	 *
	 * @param array $attributes Shortcode attributes.
	 *
	 * @return string
	 * @since 2.0
	 */
	public function shortcode_render( $attributes ) {

		shortcode_atts(
			array(
				'id' => '',
			),
			$attributes,
			'sp_testimonial'
		);

		$post_id            = $attributes['id'];
		$setting_options    = get_option( 'sp_testimonial_pro_options' );
		$shortcode_data     = get_post_meta( $post_id, 'sp_tpro_shortcode_options', true );
		$main_section_title = get_the_title( $post_id );

		ob_start();
		Helper::sp_testimonial_html_show( $post_id, $setting_options, $shortcode_data, $main_section_title );
		return Helper::minify_output( ob_get_clean() );
	}

	/**
	 * Plugin Scripts and Styles
	 */
	public function front_scripts() {
		$setting_options   = get_option( 'sp_testimonial_pro_options' );
		$dequeue_slick_css = isset( $setting_options['tf_dequeue_slick_css'] ) ? $setting_options['tf_dequeue_slick_css'] : true;
		$dequeue_fa_css    = isset( $setting_options['tf_dequeue_fa_css'] ) ? $setting_options['tf_dequeue_fa_css'] : true;
		$custom_css        = isset( $setting_options['custom_css'] ) ? $setting_options['custom_css'] : '';
		// CSS Files.
		if ( $dequeue_slick_css ) {
			wp_enqueue_style( 'tfree-slick', SP_TFREE_URL . 'Frontend/assets/css/slick.min.css', array(), SP_TFREE_VERSION );
		}
		if ( $dequeue_fa_css ) {
			wp_enqueue_style( 'tfree-font-awesome', SP_TFREE_URL . 'Frontend/assets/css/font-awesome.min.css', array(), SP_TFREE_VERSION );
		}
		wp_enqueue_style( 'tfree-deprecated-style', SP_TFREE_URL . 'Frontend/assets/css/deprecated-style.min.css', array(), SP_TFREE_VERSION );
		wp_enqueue_style( 'tfree-style', SP_TFREE_URL . 'Frontend/assets/css/style.min.css', array(), SP_TFREE_VERSION );

		$sptp_posts = new \WP_Query(
			array(
				'post_type'      => 'spt_shortcodes',
				'post_status'    => 'publish',
				'posts_per_page' => 1000,
			)
		);
		$post_ids   = wp_list_pluck( $sptp_posts->posts, 'ID' );
		$outline    = '';
		foreach ( $post_ids as $post_id ) {
			$setting_options = get_option( 'sp_testimonial_pro_options' );
			$shortcode_data  = get_post_meta( $post_id, 'sp_tpro_shortcode_options', true );
			include SP_TFREE_PATH . 'Frontend/Views/partials/dynamic-style.php';
		}
		if ( ! empty( $custom_css ) ) {
			$outline .= $custom_css;
		}

		$css = Helper::minify_output( $outline );
		wp_add_inline_style( 'tfree-style', $css );

		// JS Files.
		wp_register_script( 'tfree-slick-min-js', SP_TFREE_URL . 'Frontend/assets/js/slick.min.js', array( 'jquery' ), SP_TFREE_VERSION, true );
		wp_register_script( 'tfree-slick-active', SP_TFREE_URL . 'Frontend/assets/js/sp-slick-active.min.js', array( 'jquery' ), SP_TFREE_VERSION, true );

	}
	/**
	 * Plugin Scripts and Styles
	 */
	public function admin_front_scripts() {
		$wpscreen = get_current_screen();
		if ( 'spt_shortcodes' === $wpscreen->post_type ) {
			$setting_options   = get_option( 'sp_testimonial_pro_options' );
			$dequeue_slick_css = isset( $setting_options['tf_dequeue_slick_css'] ) ? $setting_options['tf_dequeue_slick_css'] : true;
			$dequeue_fa_css    = isset( $setting_options['tf_dequeue_fa_css'] ) ? $setting_options['tf_dequeue_fa_css'] : true;
			// CSS Files.
			if ( $dequeue_slick_css ) {
				wp_enqueue_style( 'admin-tfree-slick', SP_TFREE_URL . 'Frontend/assets/css/slick.min.css', array(), SP_TFREE_VERSION );
			}
			if ( $dequeue_fa_css ) {
				wp_enqueue_style( 'admin-tfree-font-awesome', SP_TFREE_URL . 'Frontend/assets/css/font-awesome.min.css', array(), SP_TFREE_VERSION );
			}

			wp_enqueue_style( 'admin-tfree-deprecated-style', SP_TFREE_URL . 'Frontend/assets/css/deprecated-style.min.css', array(), SP_TFREE_VERSION );
			wp_enqueue_style( 'admin-tfree-style', SP_TFREE_URL . 'Frontend/assets/css/style.min.css', array(), SP_TFREE_VERSION );
			wp_enqueue_script( 'tfree-slick-min-js', SP_TFREE_URL . 'Frontend/assets/js/slick.min.js', array( 'jquery' ), SP_TFREE_VERSION, true );
		}

	}

}

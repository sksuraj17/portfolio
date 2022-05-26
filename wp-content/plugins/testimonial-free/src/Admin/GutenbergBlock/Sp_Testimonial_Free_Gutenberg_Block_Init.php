<?php
/**
 * The plugin gutenberg block Initializer.
 *
 * @link       https://shapedplugin.com/
 * @since      2.5.1
 *
 * @package    testimonial_free
 * @subpackage testimonial_free/Admin
 * @author     ShapedPlugin <support@shapedplugin.com>
 */

namespace ShapedPlugin\TestimonialFree\Admin\GutenbergBlock;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Sp_Testimonial_Free_Gutenberg_Block_Init' ) ) {
	/**
	 * Sp_Testimonial_free_Gutenberg_Block_Init class.
	 */
	class Sp_Testimonial_Free_Gutenberg_Block_Init {
		/**
		 * Script and style suffix
		 *
		 * @since 2.5.3
		 * @access protected
		 * @var string
		 */
		protected $suffix;
		/**
		 * Custom Gutenberg Block Initializer.
		 */
		public function __construct() {
			$this->suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || defined( 'WP_DEBUG' ) && WP_DEBUG ? '' : '.min';
			add_action( 'init', array( $this, 'sptf_gutenberg_shortcode_block' ) );
			add_action( 'enqueue_block_editor_assets', array( $this, 'sptf_block_editor_assets' ) );
		}

		/**
		 * Register block editor script for backend.
		 */
		public function sptf_block_editor_assets() {
			wp_enqueue_script(
				'sp-testimonial-free-shortcode-block',
				plugins_url( '/GutenbergBlock/build/index.js', dirname( __FILE__ ) ),
				array( 'jquery', 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components' ),
				SP_TFREE_VERSION,
				true
			);

			/**
			 * Register block editor css file enqueue for backend.
			 */

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

		}

		/**
		 * Shortcode list.
		 *
		 * @return array
		 */
		public function sptf_post_list() {
			$shortcodes = get_posts(
				array(
					'post_type'      => 'spt_shortcodes',
					'post_status'    => 'publish',
					'posts_per_page' => 9999,
				)
			);

			if ( count( $shortcodes ) < 1 ) {
				return array();
			}

			return array_map(
				function ( $shortcode ) {
						return (object) array(
							'id'    => absint( $shortcode->ID ),
							'title' => esc_html( $shortcode->post_title ),
						);
				},
				$shortcodes
			);
		}

		/**
		 * Register Gutenberg shortcode block.
		 */
		public function sptf_gutenberg_shortcode_block() {
			/**
			 * Register block editor js file enqueue for backend.
			 */
			wp_register_script( 'tfree-slick-min-js', SP_TFREE_URL . 'Frontend/assets/js/slick.min.js', array( 'jquery' ), SP_TFREE_VERSION, true );
			wp_register_script( 'tfree-slick-active', SP_TFREE_URL . 'Frontend/assets/js/sp-slick-active.min.js', array( 'jquery' ), SP_TFREE_VERSION, true );

			wp_localize_script(
				'tfree-slick-active',
				'sp_testimonial_free',
				array(
					'ajax_url'      => admin_url( 'admin-ajax.php' ),
					'url'           => esc_url( SP_TFREE_URL ),
					'loadScript'    => SP_TFREE_URL . 'Frontend/assets/js/sp-slick-active.min.js',
					'link'          => esc_url( admin_url( 'post-new.php?post_type=spt_shortcodes' ) ),
					'shortCodeList' => $this->sptf_post_list(),
				)
			);
			/**
			 * Register Gutenberg block on server-side.
			 */
			register_block_type(
				'sp-testimonial-pro/shortcode',
				array(
					'attributes'      => array(
						'shortcode'          => array(
							'type'    => 'string',
							'default' => '',
						),
						'showInputShortcode' => array(
							'type'    => 'boolean',
							'default' => true,
						),
						'preview'            => array(
							'type'    => 'boolean',
							'default' => false,
						),
						'is_admin'           => array(
							'type'    => 'boolean',
							'default' => is_admin(),
						),
					),
					'example'         => array(
						'attributes' => array(
							'preview' => true,
						),
					),
					// Enqueue blocks.editor.build.js in the editor only.
					'editor_script'   => array(
						'tfree-slick-min-js',
						'tfree-slick-active',
					),
					// Enqueue blocks.editor.build.css in the editor only.
					'editor_style'    => array(),
					'render_callback' => array( $this, 'sp_testimonial_free_render_shortcode' ),
				)
			);
		}

		/**
		 * Render callback.
		 *
		 * @param string $attributes Shortcode.
		 * @return string
		 */
		public function sp_testimonial_free_render_shortcode( $attributes ) {
			$class_name = '';
			if ( ! empty( $attributes['className'] ) ) {
				$class_name = $attributes['className'];
			}

			if ( ! $attributes['is_admin'] ) {
				return '<div class="' . esc_attr( $class_name ) . '">' . do_shortcode( '[sp_testimonial id="' . sanitize_text_field( $attributes['shortcode'] ) . '"]' ) . '</div>';
			}

			$post_id         = $attributes['shortcode'];
			$outline         = '';
			$setting_options = get_option( 'sp_testimonial_pro_options' );
			$shortcode_data  = get_post_meta( $post_id, 'sp_tpro_shortcode_options', true );
			$custom_css      = isset( $setting_options['custom_css'] ) ? $setting_options['custom_css'] : '';
			include SP_TFREE_PATH . 'Frontend/Views/partials/dynamic-style.php';
			if ( ! empty( $custom_css ) ) {
				$outline .= $custom_css;
			}
			$style = '<style>' . $outline . '</style>';

			return $style . '<div id="' . uniqid() . '" class="' . $class_name . '">' . do_shortcode( '[sp_testimonial id="' . sanitize_text_field( $attributes['shortcode'] ) . '"]' ) . '</div>';
		}
	}
}

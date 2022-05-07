<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'TSSGutenBurg' ) ) :

	class TSSGutenBurg {

		protected $version;

		function __construct() {
			$this->version = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? time() : TSS_VERSION;
			add_action( 'enqueue_block_assets', [ $this, 'block_assets' ] );
			add_action( 'enqueue_block_editor_assets', [ $this, 'block_editor_assets' ] );
			if ( function_exists( 'register_block_type' ) ) {
				register_block_type(
					'radiustheme/tss',
					[
						'render_callback' => [ $this, 'render_shortcode' ],
					]
				);
			}
		}

		static function render_shortcode( $atts ) {
			if ( ! empty( $atts['gridId'] ) && $id = absint( $atts['gridId'] ) ) {
				return do_shortcode( '[rt-testimonial id="' . $id . '"]' );
			}
		}


		function block_assets() {
			wp_enqueue_style( 'wp-blocks' );
		}

		function block_editor_assets() {
			// Scripts.
			wp_enqueue_script(
				'rt-tss-gb-block-js',
				TSSPro()->assetsUrl . 'js/testimonial-slider-blocks.min.js',
				[ 'wp-blocks', 'wp-i18n', 'wp-element' ],
				$this->version,
				true
			);
			wp_localize_script(
				'rt-tss-gb-block-js',
				'tss',
				[
					'short_codes' => TSSPro()->get_shortCode_list(),
					'icon'        => TSSPro()->assetsUrl . 'images/icon-32x32.png',
				]
			);
			wp_enqueue_style( 'wp-edit-blocks' );
		}
	}

endif;

<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'TSSElementorControls' ) ) :

	class TSSElementorControls {

		private static $controls;

		public static function register() {
			self::includes();

			self::$controls = apply_filters(
				'rttss_elementor_custom_controls',
				array(
					TSSImageSelectorControl::class,
				)
			);

			if ( empty( self::$controls ) ) {
				return;
			}

			// Registering the controls.
			self::registerControls();
		}

		private static function registerControls() {
			foreach ( self::$controls as $control ) {
				$controls_manager = \Elementor\Plugin::instance()->controls_manager;

				$controls_manager->register_control( $control::$controlName, new $control() );
			}
		}

		private static function includes() {
			$directories = array(
				'/elementor/controls/',
			);

			foreach ( $directories as $include ) {
				TSSPro()->loadClass( TSSPro()->incPath . $include );
			}
		}
	}

endif;

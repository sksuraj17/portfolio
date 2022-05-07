<?php
if ( ! class_exists( 'TSSElementorGridStyle' ) ) :
	/**
	 *
	 */
	class TSSElementorGridStyle {

		/**
		 * Accumulates tab fields.
		 *
		 * @access private
		 * @static
		 *
		 * @var array
		 */
		private static $fields = array();

		/**
		 * Registering the tab contents.
		 *
		 * @access public
		 * @static
		 *
		 * @return array
		 */
		public static function register() {
			self::settings();

			return apply_filters( 'rttss_elementor_end_of_style_tab', self::$fields );
		}

		/**
		 * Method to add required fields.
		 *
		 * @access public
		 * @static
		 *
		 * @return void
		 */
		public static function settings() {
			$styleSections = new TSSElementorStyleSections();

			$sections = array(
				'gridColors',
				'typography',
				'image',
			);

			foreach ( $sections as $section ) {
				self::$fields = array_merge( $styleSections->$section() );
			}
		}
	}
endif;

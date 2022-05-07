<?php
if ( ! class_exists( 'TSSElementorGridContent' ) ) :
	/**
	 * Grid Widget Elementor Content Tab Controls Class
	 */
	class TSSElementorGridContent {

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

			return apply_filters( 'rttss_elementor_grid_content_fields', self::$fields );
		}

		/**
		 * Method to add required fields.
		 *
		 * @since  1.0.0
		 * @access private
		 * @static
		 *
		 * @return void
		 */
		public static function settings() {
			$contentSections = new TSSElementorContentSections();

			$sections = array(
				'gridlayout',
				'filtering',
				'image',
				'pagination',
				'textLimit',
				'contentVisibility',
			);

			foreach ( $sections as $section ) {
				self::$fields = array_merge( $contentSections->$section() );
			}

			// Promotional content.
			self::$fields = array_merge( TSSPro()->tssContentPromotion( self::$fields ) );
		}
	}
endif;

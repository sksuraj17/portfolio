<?php
/**
 * Preview field file.
 *
 * @link http://shapedplugin.com
 * @since 2.4.0
 *
 * @package Testimonial_Free
 * @subpackage Testimonial_Free/Admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.

if ( ! class_exists( 'SPFTESTIMONIAL_Field_preview' ) ) {
	/**
	 *
	 * Field: shortcode
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SPFTESTIMONIAL_Field_preview extends SPFTESTIMONIAL_Fields {

		/**
		 * Shortcode field constructor.
		 *
		 * @param array  $field The field type.
		 * @param string $value The values of the field.
		 * @param string $unique The unique ID for the field.
		 * @param string $where To where show the output CSS.
		 * @param string $parent The parent args.
		 */
		/**
		 * Field constructor.
		 *
		 * @param array  $field The field type.
		 * @param string $value The values of the field.
		 * @param string $unique The unique ID for the field.
		 * @param string $where To where show the output CSS.
		 * @param string $parent The parent args.
		 */
		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		/**
		 * Render
		 *
		 * @return void
		 */
		/**
		 * Render field
		 *
		 * @return void
		 */
		public function render() {
			echo '<div class="sp_tpro-preview-box"><div id="sp_tpro-preview-box"></div></div>';
		}

	}
}

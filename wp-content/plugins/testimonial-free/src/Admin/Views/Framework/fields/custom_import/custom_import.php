<?php
/**
 * Framework Custom_import field file.
 *
 * @link https://shapedplugin.com
 * @since 2.0.0
 *
 * @package Testimonial_free
 * @subpackage Testimonial_free/framework
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

if ( ! class_exists( 'SPFTESTIMONIAL_Field_custom_import' ) ) {
	/**
	 *
	 * Field: Custom_import
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SPFTESTIMONIAL_Field_custom_import extends SPFTESTIMONIAL_Fields {

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
		 * Render field
		 *
		 * @return void
		 */
		public function render() {
			echo wp_kses_post( $this->field_before() );
			$spt_testimonial      = admin_url( 'edit.php?post_type=spt_testimonial' );
			$spt_shortcodes       = admin_url( 'edit.php?post_type=spt_shortcodes' );
			$spt_testimonial_form = admin_url( 'edit.php?post_type=spt_testimonial_form' );
				echo '<p><input type="file" id="import" accept=".json"></p>';
				echo '<p><button type="button" class="import">Import</button></p>';
				echo '<a id="spt_shortcode_link_redirect" href="' . esc_url( $spt_shortcodes ) . '"></a>';
				echo '<a id="spt_testimonial_link_redirect" href="' . esc_url( $spt_testimonial ) . '"></a>';
				echo '<a id="spt_forms_link_redirect" href="' . esc_url( $spt_testimonial_form ) . '"></a>';
			echo wp_kses_post( $this->field_after() );
		}
	}
}

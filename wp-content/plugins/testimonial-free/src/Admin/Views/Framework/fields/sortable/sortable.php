<?php
/**
 * Framework sortable field file.
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

use ShapedPlugin\TestimonialFree\Admin\Views\Framework\Classes\SPFTESTIMONIAL;

if ( ! class_exists( 'SPFTESTIMONIAL_Field_sortable' ) ) {
	/**
	 *
	 * Field: sortable
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SPFTESTIMONIAL_Field_sortable extends SPFTESTIMONIAL_Fields {

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

			echo '<div class="spftestimonial-sortable" data-depend-id="' . esc_attr( $this->field['id'] ) . '">';

			$pre_sortby = array();
			$pre_fields = array();

			// Add array-keys to defined fields for sort by.
			foreach ( $this->field['fields'] as $key => $field ) {
				$pre_fields[ $field['id'] ] = $field;
			}

			// Set sort by by saved-value or default-value.
			if ( ! empty( $this->value ) ) {

				foreach ( $this->value as $key => $value ) {
					$pre_sortby[ $key ] = $pre_fields[ $key ];
				}

				$diff = array_diff_key( $pre_fields, $this->value );

				if ( ! empty( $diff ) ) {
					$pre_sortby = array_merge( $pre_sortby, $diff );
				}
			} else {

				foreach ( $pre_fields as $key => $value ) {
					$pre_sortby[ $key ] = $value;
				}
			}

			foreach ( $pre_sortby as $key => $field ) {

				echo '<div class="spftestimonial-sortable-item">';

				echo '<div class="spftestimonial-sortable-content">';

				$field_default = ( isset( $this->field['default'][ $key ] ) ) ? $this->field['default'][ $key ] : '';
				$field_value   = ( isset( $this->value[ $key ] ) ) ? $this->value[ $key ] : $field_default;
				$unique_id     = ( ! empty( $this->unique ) ) ? $this->unique . '[' . $this->field['id'] . ']' : $this->field['id'];

				SPFTESTIMONIAL::field( $field, $field_value, $unique_id, 'field/sortable' );

				echo '</div>';

				echo '<div class="spftestimonial-sortable-helper"><i class="fa fa-arrows-alt"></i></div>';

				echo '</div>';

			}

			echo '</div>';

			echo wp_kses_post( $this->field_after() );

		}

		/**
		 * Enqueue sorter js.
		 *
		 * @return void
		 */
		public function enqueue() {
			if ( ! wp_script_is( 'jquery-ui-sortable' ) ) {
				wp_enqueue_script( 'jquery-ui-sortable' );
			}
		}

	}
}

<?php
/**
 * Framework accordion field file.
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
if ( ! class_exists( 'SPFTESTIMONIAL_Field_accordion' ) ) {
	/**
	 *
	 * Field: accordion
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SPFTESTIMONIAL_Field_accordion extends SPFTESTIMONIAL_Fields {

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

			$unallows = array( 'accordion' );

			echo wp_kses_post( $this->field_before() );

			echo '<div class="spftestimonial-accordion-items" data-depend-id="' . esc_attr( $this->field['id'] ) . '">';

			foreach ( $this->field['accordions'] as $key => $accordion ) {

				echo '<div class="spftestimonial-accordion-item">';

				$icon = ( ! empty( $accordion['icon'] ) ) ? 'spftestimonial--icon ' . $accordion['icon'] : 'spftestimonial-accordion-icon fa fa-angle-right';

				echo '<h4 class="spftestimonial-accordion-title">';
				echo '<i class="' . esc_attr( $icon ) . '"></i>';
				echo esc_html( $accordion['title'] );
				echo '</h4>';

				echo '<div class="spftestimonial-accordion-content">';
				if ( isset( $accordion['fields'] ) && is_array( $accordion['fields'] ) ) {
					foreach ( $accordion['fields'] as $field ) {

						if ( in_array( $field['type'], $unallows ) ) {
							$field['_notice'] = true; }

						$field_id      = ( isset( $field['id'] ) ) ? $field['id'] : '';
						$field_default = ( isset( $field['default'] ) ) ? $field['default'] : '';
						$field_value   = ( isset( $this->value[ $field_id ] ) ) ? $this->value[ $field_id ] : $field_default;
						$unique_id     = ( ! empty( $this->unique ) ) ? $this->unique . '[' . $this->field['id'] . ']' : $this->field['id'];

						SPFTESTIMONIAL::field( $field, $field_value, $unique_id, 'field/accordion' );

					}
				}
				echo '</div>';

				echo '</div>';

			}

			echo '</div>';

			echo wp_kses_post( $this->field_after() );

		}

	}
}

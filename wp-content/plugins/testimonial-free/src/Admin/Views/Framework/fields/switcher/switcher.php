<?php
/**
 * Framework switcher field file.
 *
 * @link https://shapedplugin.com
 * @since 2.0.0
 *
 * @package Testimonial_free
 * @subpackage Testimonial_free/framework
 */

if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.

if ( ! class_exists( 'SPFTESTIMONIAL_Field_switcher' ) ) {
	/**
	 *
	 * Field: switcher
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SPFTESTIMONIAL_Field_switcher extends SPFTESTIMONIAL_Fields {

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

			$active     = ( ! empty( $this->value ) ) ? ' spftestimonial--active' : '';
			$text_on    = ( ! empty( $this->field['text_on'] ) ) ? $this->field['text_on'] : esc_html__( 'On', 'testimonial-free' );
			$text_off   = ( ! empty( $this->field['text_off'] ) ) ? $this->field['text_off'] : esc_html__( 'Off', 'testimonial-free' );
			$text_width = ( ! empty( $this->field['text_width'] ) ) ? $this->field['text_width'] : '60';

			echo wp_kses_post( $this->field_before() );

			echo '<div class="spftestimonial--switcher' . esc_attr( $active ) . '" style="width: ' . esc_attr( $text_width ) . 'px;">';
			echo '<span class="spftestimonial--on">' . esc_attr( $text_on ) . '</span>';
			echo '<span class="spftestimonial--off">' . esc_attr( $text_off ) . '</span>';
			echo '<span class="spftestimonial--ball"></span>';
			echo '<input type="hidden" name="' . esc_attr( $this->field_name() ) . '" value="' . esc_attr( $this->value ) . '"' . $this->field_attributes() . ' />';// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '</div>';

			echo ( ! empty( $this->field['label'] ) ) ? '<span class="spftestimonial--label">' . esc_attr( $this->field['label'] ) . '</span>' : '';

			echo wp_kses_post( $this->field_after() );

		}

	}
}

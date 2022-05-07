<?php
/**
 * Framework Rating field file.
 *
 * @link https://shapedplugin.com
 * @since 2.0.0
 *
 * @package Testimonial_free
 * @subpackage Testimonial_free/framework
 */

if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.

if ( ! class_exists( 'SPFTESTIMONIAL_Field_rating' ) ) {
	/**
	 *
	 * Field: Rating
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SPFTESTIMONIAL_Field_rating extends SPFTESTIMONIAL_Fields {

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

			$args = wp_parse_args(
				$this->field,
				array(
					'query_args' => array(),
				)
			);

			echo wp_kses_post( $this->field_before() );

			if ( isset( $this->field['options'] ) ) {

				$options = $this->field['options'];
				$options = ( is_array( $options ) ) ? $options : array_filter( $this->field_data( $options, false, $args['query_args'] ) );

				if ( is_array( $options ) && ! empty( $options ) ) {

					echo '<div class="sp-tpro-client-rating">';
					foreach ( $options as $sub_key => $sub_value ) {
						$checked = ( $sub_key == $this->value ) ? ' checked' : '';
						echo '<input type="radio" name="' . esc_attr( $this->field_name() ) . '" id="' . esc_attr( $sub_key ) . '" value="' . esc_attr( $sub_key ) . '"' . $this->field_attributes() . esc_attr( $checked ) . '/><label for="' . esc_attr( $sub_key ) . '" title="' . esc_attr( $sub_value ) . '"><i class="fa fa-star"></i></label>';// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
					echo '</div>';

				} else {

					echo ! empty( $this->field['empty_message'] ) ? esc_html( $this->field['empty_message'] ) : esc_html__( 'No data provided for this option type.', 'testimonial-free' );

				}
			} else {
				$label = ( isset( $this->field['label'] ) ) ? $this->field['label'] : '';
				echo '<label><input type="radio" name="' . esc_attr( $this->field_name() ) . '" value="1"' . $this->field_attributes() . checked( $this->value, 1, false ) . '/> ' . esc_html( $label ) . '</label>';// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			echo wp_kses_post( $this->field_after() );

		}

	}
}

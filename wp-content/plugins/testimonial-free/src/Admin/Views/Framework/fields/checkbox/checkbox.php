<?php
/**
 * Framework checkbox field file.
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

if ( ! class_exists( 'SPFTESTIMONIAL_Field_checkbox' ) ) {
	/**
	 *
	 * Field: checkbox
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SPFTESTIMONIAL_Field_checkbox extends SPFTESTIMONIAL_Fields {

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
					'inline'     => false,
					'query_args' => array(),
				)
			);

			$inline_class = ( $args['inline'] ) ? 'spftestimonial--inline-list' : '';

			echo wp_kses_post( $this->field_before() );

			if ( isset( $this->field['options'] ) ) {

				$value   = ( is_array( $this->value ) ) ? $this->value : array_filter( (array) $this->value );
				$options = $this->field['options'];
				$options = ( is_array( $options ) ) ? $options : array_filter( $this->field_data( $options, false, $args['query_args'] ) );

				if ( is_array( $options ) && ! empty( $options ) ) {

					echo '<ul class="' . esc_attr( $inline_class ) . '">';

					foreach ( $options as $option_key => $option_value ) {

						if ( is_array( $option_value ) && ! empty( $option_value ) ) {

							echo '<li>';
							echo '<ul>';
							echo '<li><strong>' . esc_attr( $option_key ) . '</strong></li>';
							foreach ( $option_value as $sub_key => $sub_value ) {
								$checked = ( in_array( $sub_key, $value ) ) ? ' checked' : '';
								echo '<li>';
								echo '<label>';
								echo '<input type="checkbox" name="' . esc_attr( $this->field_name( '[]' ) ) . '" value="' . esc_attr( $sub_key ) . '"' . $this->field_attributes() . esc_attr( $checked ) . '/>';// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								echo '<span class="spftestimonial--text">' . esc_attr( $sub_value ) . '</span>';
								echo '</label>';
								echo '</li>';
							}
							echo '</ul>';
							echo '</li>';

						} else {

							$checked = ( in_array( $option_key, $value ) ) ? ' checked' : '';

							echo '<li>';
							echo '<label>';
							echo '<input type="checkbox" name="' . esc_attr( $this->field_name( '[]' ) ) . '" value="' . esc_attr( $option_key ) . '"' . $this->field_attributes() . esc_attr( $checked ) . '/>';// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							echo '<span class="spftestimonial--text">' . esc_attr( $option_value ) . '</span>';
							echo '</label>';
							echo '</li>';

						}
					}

					echo '</ul>';

				} else {

					echo ! empty( $this->field['empty_message'] ) ? esc_attr( $this->field['empty_message'] ) : esc_html__( 'No data available.', 'testimonial-free' );

				}
			} else {

				echo '<label class="spftestimonial-checkbox">';
				echo '<input type="hidden" name="' . esc_attr( $this->field_name() ) . '" value="' . esc_attr( $this->value ) . '" class="spftestimonial--input"' . $this->field_attributes() . '/>';// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo '<input type="checkbox" name="_pseudo" class="spftestimonial--checkbox"' . esc_attr( checked( $this->value, 1, false ) ) . '/>';
				echo ( ! empty( $this->field['label'] ) ) ? '<span class="spftestimonial--text">' . esc_attr( $this->field['label'] ) . '</span>' : '';
				echo '</label>';

			}

			echo wp_kses_post( $this->field_after() );

		}

	}
}

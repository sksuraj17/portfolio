<?php
/**
 * Framework select_f field file.
 *
 * @link https://shapedplugin.com
 * @since 2.0.0
 *
 * @package Testimonial_free
 * @subpackage Testimonial_free/framework
 */

if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.

if ( ! class_exists( 'SPFTESTIMONIAL_Field_select_f' ) ) {
	/**
	 *
	 * Field: select_f
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SPFTESTIMONIAL_Field_select_f extends SPFTESTIMONIAL_Fields {

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
					'placeholder' => '',
					'chosen'      => false,
					'multiple'    => false,
					'sortable'    => false,
					'ajax'        => false,
					'settings'    => array(),
					'query_args'  => array(),
				)
			);

			$this->value = ( is_array( $this->value ) ) ? $this->value : array_filter( (array) $this->value );

			echo wp_kses_post( $this->field_before() );

			if ( isset( $this->field['options'] ) ) {

				if ( ! empty( $args['ajax'] ) ) {
					$args['settings']['data']['type']  = $args['options'];
					$args['settings']['data']['nonce'] = wp_create_nonce( 'spftestimonial_chosen_ajax_nonce' );
					if ( ! empty( $args['query_args'] ) ) {
						$args['settings']['data']['query_args'] = $args['query_args'];
					}
				}

				$chosen_rtl       = ( is_rtl() ) ? ' chosen-rtl' : '';
				$multiple_name    = ( $args['multiple'] ) ? '[]' : '';
				$multiple_attr    = ( $args['multiple'] ) ? ' multiple="multiple"' : '';
				$chosen_sortable  = ( $args['chosen'] && $args['sortable'] ) ? ' spftestimonial-chosen-sortable' : '';
				$chosen_ajax      = ( $args['chosen'] && $args['ajax'] ) ? ' spftestimonial-chosen-ajax' : '';
				$placeholder_attr = ( $args['chosen'] && $args['placeholder'] ) ? ' data-placeholder="' . esc_attr( $args['placeholder'] ) . '"' : '';
				$field_class      = ( $args['chosen'] ) ? ' class="spftestimonial-chosen' . esc_attr( $chosen_rtl . $chosen_sortable . $chosen_ajax ) . '"' : '';
				$field_name       = $this->field_name( $multiple_name );
				$field_attr       = $this->field_attributes();
				$maybe_options    = $this->field['options'];
				$chosen_data_attr = ( $args['chosen'] && ! empty( $args['settings'] ) ) ? ' data-chosen-settings="' . esc_attr( wp_json_encode( $args['settings'] ) ) . '"' : '';

				if ( is_string( $maybe_options ) && ! empty( $args['chosen'] ) && ! empty( $args['ajax'] ) ) {
					$options = $this->field_wp_query_data_title( $maybe_options, $this->value );
				} elseif ( is_string( $maybe_options ) ) {
					$options = $this->field_data( $maybe_options, false, $args['query_args'] );
				} else {
					$options = $maybe_options;
				}

				if ( ( is_array( $options ) && ! empty( $options ) ) || ! empty( $args['chosen'] ) ) {

					if ( ! empty( $args['chosen'] ) && ! empty( $args['multiple'] ) ) {
						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						echo '<select name="' . esc_attr( $field_name ) . '" class="spftestimonial-hidden-select spftestimonial-hidden"' . $multiple_attr . $field_attr . '>';
						foreach ( $this->value as $option_key ) {
							echo '<option value="' . esc_attr( $option_key ) . '" selected>' . esc_html( $option_key ) . '</option>';
						}
						echo '</select>';

						$field_name = '_pseudo';
						$field_attr = '';

					}
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo '<select name="' . esc_attr( $field_name ) . '"' . $field_class . $multiple_attr . $placeholder_attr . $field_attr . $chosen_data_attr . '>';

					if ( $args['placeholder'] && empty( $args['multiple'] ) ) {
						if ( ! empty( $args['chosen'] ) ) {
							echo '<option value=""></option>';
						} else {
							echo '<option value="">' . esc_html( $args['placeholder'] ) . '</option>';
						}
					}

					foreach ( $options as $option_key => $option ) {
							$pro_only_value = isset( $option['pro_only'] ) ? $option['pro_only'] : '';
							$pro_only       = true === $pro_only_value ? ' disabled' : '';
							$selected       = ( in_array( $option_key, $this->value, true ) ) ? ' selected' : '';
							echo '<option' . esc_html( $pro_only ) . ' value="' . esc_attr( $option_key ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $option['name'] ) . '</option>';
					}

					echo '</select>';

				} else {

					echo ! empty( $this->field['empty_message'] ) ? wp_kses_post( $this->field['empty_message'] ) : esc_html__( 'No data provided for this option type.', 'testimonial-free' );

				}
			}

			echo wp_kses_post( $this->field_after() );

		}

	}
}

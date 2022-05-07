<?php
/**
 * Framework spinner field file.
 *
 * @link https://shapedplugin.com
 * @since 2.0.0
 *
 * @package Testimonial_free
 * @subpackage Testimonial_free/framework
 */

if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.

if ( ! class_exists( 'SPFTESTIMONIAL_Field_spinner' ) ) {
	/**
	 *
	 * Field: spinner
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SPFTESTIMONIAL_Field_spinner extends SPFTESTIMONIAL_Fields {

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
					'max'  => 100,
					'min'  => 0,
					'step' => 1,
					'unit' => '',
				)
			);

			echo wp_kses_post( $this->field_before() );

			echo '<div class="spftestimonial--spin"><input type="number" name="' . esc_attr( $this->field_name() ) . '" value="' . esc_attr( $this->value ) . '"' . $this->field_attributes( array( 'class' => 'spftestimonial-input-number' ) ) . ' data-min="' . esc_attr( $args['min'] ) . '" data-max="' . esc_attr( $args['max'] ) . '" data-step="' . esc_attr( $args['step'] ) . '" data-unit="' . esc_attr( $args['unit'] ) . '" step="any" /></div>';// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			echo wp_kses_post( $this->field_after() );

		}

		/**
		 * Enqueue spinner js.
		 *
		 * @return void
		 */
		public function enqueue() {

			if ( ! wp_script_is( 'jquery-ui-spinner' ) ) {
				wp_enqueue_script( 'jquery-ui-spinner' );
			}

		}

		/**
		 * Fields output
		 *
		 * @return statement
		 */
		public function output() {

			$output    = '';
			$elements  = ( is_array( $this->field['output'] ) ) ? $this->field['output'] : array_filter( (array) $this->field['output'] );
			$important = ( ! empty( $this->field['output_important'] ) ) ? '!important' : '';
			$mode      = ( ! empty( $this->field['output_mode'] ) ) ? $this->field['output_mode'] : 'width';
			$unit      = ( ! empty( $this->field['unit'] ) ) ? $this->field['unit'] : 'px';

			if ( ! empty( $elements ) && isset( $this->value ) && '' !== $this->value ) {
				foreach ( $elements as $key_property => $element ) {
					if ( is_numeric( $key_property ) ) {
						if ( $mode ) {
							$output = implode( ',', $elements ) . '{' . $mode . ':' . $this->value . $unit . $important . ';}';
						}
						break;
					} else {
						$output .= $element . '{' . $key_property . ':' . $this->value . $unit . $important . '}';
					}
				}
			}

			$this->parent->output_css .= $output;

			return $output;

		}

	}
}

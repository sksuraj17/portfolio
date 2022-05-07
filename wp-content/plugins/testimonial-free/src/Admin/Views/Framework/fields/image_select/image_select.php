<?php
/**
 * Framework image_select field file.
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

if ( ! class_exists( 'SPFTESTIMONIAL_Field_image_select' ) ) {
	/**
	 *
	 * Field: image_select
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SPFTESTIMONIAL_Field_image_select extends SPFTESTIMONIAL_Fields {

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
					'multiple' => false,
					'inline'   => false,
					'options'  => array(),
				)
			);

			$inline = ( $args['inline'] ) ? ' spftestimonial--inline-list' : '';

			$value = ( is_array( $this->value ) ) ? $this->value : array_filter( (array) $this->value );

			echo wp_kses_post( $this->field_before() );
			if ( ! empty( $args['options'] ) ) {

				echo '<div class="spftestimonial-siblings spftestimonial--image-group' . esc_attr( $inline ) . '" data-multiple="' . esc_attr( $args['multiple'] ) . '">';

				$num = 1;
				foreach ( $args['options'] as $key => $option ) {

					$type      = ( $args['multiple'] ) ? 'checkbox' : 'radio';
					$extra     = ( $args['multiple'] ) ? '[]' : '';
					$active    = ( in_array( $key, $value ) ) ? ' spftestimonial--active' : '';
					$checked   = ( in_array( $key, $value ) ) ? ' checked' : '';
					$opt_class = isset( $option['class'] ) && ! empty( $option['class'] ) ? $option['class'] : '';
					echo '<div class="spftestimonial--sibling spftestimonial--image' . esc_attr( $active . ' ' . $opt_class ) . '">';
					echo '<figure>';
					echo '<img src="' . esc_url( $option['image'] ) . '" alt="img-' . esc_attr( $num++ ) . '" />';
					echo '<input type="' . esc_attr( $type ) . '" name="' . esc_attr( $this->field_name( $extra ) ) . '" value="' . esc_attr( $key ) . '"' . $this->field_attributes() . esc_attr( $checked ) . '/>';// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo '</figure>';
					if ( isset( $option['name'] ) ) {
						echo '<p class="text-center">' . esc_attr( $option['name'] ) . '</p>';
					}
					echo '</div>';

				}

				echo '</div>';

			}

			echo wp_kses_post( $this->field_after() );

		}

		/**
		 * Output
		 *
		 * @return statement
		 */
		public function output() {

			$output    = '';
			$bg_image  = array();
			$important = ( ! empty( $this->field['output_important'] ) ) ? '!important' : '';
			$elements  = ( is_array( $this->field['output'] ) ) ? join( ',', $this->field['output'] ) : $this->field['output'];

			if ( ! empty( $elements ) && isset( $this->value ) && '' !== $this->value ) {
				$output = $elements . '{background-image:url(' . $this->value . ')' . $important . ';}';
			}

			$this->parent->output_css .= $output;

			return $output;
		}

	}
}

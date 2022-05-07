<?php
/**
 * Framework repeater field file.
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
if ( ! class_exists( 'SPFTESTIMONIAL_Field_repeater' ) ) {
	/**
	 *
	 * Field: repeater
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SPFTESTIMONIAL_Field_repeater extends SPFTESTIMONIAL_Fields {

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
					'max'          => 0,
					'min'          => 0,
					'button_title' => '<i class="fa fa-plus-circle"></i>',
				)
			);

			if ( preg_match( '/' . preg_quote( '[' . $this->field['id'] . ']' ) . '/', $this->unique ) ) {

				echo '<div class="spftestimonial-notice spftestimonial-notice-danger">' . esc_html__( 'Error: Field ID conflict.', 'testimonial-free' ) . '</div>';

			} else {

				echo wp_kses_post( $this->field_before() );

				echo '<div class="spftestimonial-repeater-item spftestimonial-repeater-hidden" data-depend-id="' . esc_attr( $this->field['id'] ) . '">';
				echo '<div class="spftestimonial-repeater-content">';
				foreach ( $this->field['fields'] as $field ) {

					$field_default = ( isset( $field['default'] ) ) ? $field['default'] : '';
					$field_unique  = ( ! empty( $this->unique ) ) ? $this->unique . '[' . $this->field['id'] . '][0]' : $this->field['id'] . '[0]';

					SPFTESTIMONIAL::field( $field, $field_default, '___' . $field_unique, 'field/repeater' );

				}
				echo '</div>';
				echo '<div class="spftestimonial-repeater-helper">';
				echo '<div class="spftestimonial-repeater-helper-inner">';
				echo '<i class="spftestimonial-repeater-sort fa fa-arrows-alt"></i>';
				echo '<i class="spftestimonial-repeater-clone far fa-clone"></i>';
				echo '<i class="spftestimonial-repeater-remove spftestimonial-confirm fa fa-times" data-confirm="' . esc_html__( 'Are you sure to delete this item?', 'testimonial-free' ) . '"></i>';
				echo '</div>';
				echo '</div>';
				echo '</div>';

				echo '<div class="spftestimonial-repeater-wrapper spftestimonial-data-wrapper" data-field-id="[' . esc_attr( $this->field['id'] ) . ']" data-max="' . esc_attr( $args['max'] ) . '" data-min="' . esc_attr( $args['min'] ) . '">';

				if ( ! empty( $this->value ) && is_array( $this->value ) ) {

					$num = 0;

					foreach ( $this->value as $key => $value ) {

						echo '<div class="spftestimonial-repeater-item">';
						echo '<div class="spftestimonial-repeater-content">';
						foreach ( $this->field['fields'] as $field ) {

							$field_unique = ( ! empty( $this->unique ) ) ? $this->unique . '[' . $this->field['id'] . '][' . $num . ']' : $this->field['id'] . '[' . $num . ']';
							$field_value  = ( isset( $field['id'] ) && isset( $this->value[ $key ][ $field['id'] ] ) ) ? $this->value[ $key ][ $field['id'] ] : '';

							SPFTESTIMONIAL::field( $field, $field_value, $field_unique, 'field/repeater' );

						}
						echo '</div>';
						echo '<div class="spftestimonial-repeater-helper">';
						echo '<div class="spftestimonial-repeater-helper-inner">';
						echo '<i class="spftestimonial-repeater-sort fa fa-arrows-alt"></i>';
						echo '<i class="spftestimonial-repeater-clone far fa-clone"></i>';
						echo '<i class="spftestimonial-repeater-remove spftestimonial-confirm fa fa-times" data-confirm="' . esc_html__( 'Are you sure to delete this item?', 'testimonial-free' ) . '"></i>';
						echo '</div>';
						echo '</div>';
						echo '</div>';

						$num++;

					}
				}

				echo '</div>';

				echo '<div class="spftestimonial-repeater-alert spftestimonial-repeater-max">' . esc_html__( 'You cannot add more.', 'testimonial-free' ) . '</div>';
				echo '<div class="spftestimonial-repeater-alert spftestimonial-repeater-min">' . esc_html__( 'You cannot remove more.', 'testimonial-free' ) . '</div>';
				echo '<a href="#" class="button button-primary spftestimonial-repeater-add">' . wp_kses_post( $args['button_title'] ) . '</a>';

				echo wp_kses_post( $this->field_after() );

			}

		}

		/**
		 * Enqueue sortable script.
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

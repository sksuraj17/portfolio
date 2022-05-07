<?php
/**
 * Framework custom_size field file.
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

if ( ! class_exists( 'SPFTESTIMONIAL_Field_custom_size' ) ) {
	/**
	 *
	 * Field: Dimension Advanced.
	 *
	 * @since 2.2.0
	 * @version 2.2.0
	 */
	class SPFTESTIMONIAL_Field_custom_size extends SPFTESTIMONIAL_Fields {

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
					'width_icon'         => '<i class="fa fa-arrows-h"></i>',
					'height_icon'        => '<i class="fa fa-arrows-v"></i>',
					'width_placeholder'  => esc_html__( 'width', 'testimonial-free' ),
					'height_placeholder' => esc_html__( 'height', 'testimonial-free' ),
					'width'              => true,
					'height'             => true,
					'crop'               => true,
					'crops'              => array( 'soft-crop', 'hard-crop' ),
					'unit'               => 'px',
				)
			);

			$default_value = array(
				'width'  => '',
				'height' => '',
				'crop'   => 'hard-crop',
			);

			$default_value = ( ! empty( $this->field['default'] ) ) ? wp_parse_args( $this->field['default'], $default_value ) : $default_value;

			$value = wp_parse_args( $this->value, $default_value );

			echo wp_kses_post( $this->field_before() );

			$properties = array();

			foreach ( array( 'width', 'height' ) as $prop ) {
				if ( ! empty( $args[ $prop ] ) ) {
					$properties[] = $prop;
				}
			}

			$properties = ( array( 'width', 'height' ) === $properties ) ? array_reverse( $properties ) : $properties;
			echo '<div class="spftestimonial--inputs" data-depend-id="' . esc_attr( $this->field['id'] ) . '">';
			foreach ( $properties as $property ) {

				$placeholder = ( ! empty( $args[ $property . '_placeholder' ] ) ) ? $args[ $property . '_placeholder' ] : '';

				echo '<div class="spftestimonial--input">';
				echo ( ! empty( $args[ $property . '_icon' ] ) ) ? '<span class="spftestimonial--label spftestimonial--icon">' . wp_kses_post( $args[ $property . '_icon' ] ) . '</span>' : '';
				echo '<input type="number" name="' . esc_attr( $this->field_name( '[' . $property . ']' ) ) . '" value="' . esc_attr( $value[ $property ] ) . '"  placeholder="' . esc_attr( $placeholder ) . '" class="spftestimonial-number spftestimonial--is-unit" />';
				echo ( ! empty( $args['unit'] ) ) ? '<span class="spftestimonial--label spftestimonial--unit">' . esc_html( $args['unit'] ) . '</span>' : '';
				echo '</div>';

			}

			if ( ! empty( $args['crop'] ) ) {
				echo '<div class="spf--left spf--input">';
				echo '<select name="' . esc_attr( $this->field_name( '[crop]' ) ) . '">';
				foreach ( $args['crops'] as $crop_prop ) {
					$selected = ( $value['crop'] === $crop_prop ) ? ' selected' : '';
					echo '<option value="' . esc_attr( $crop_prop ) . '"' . esc_attr( $selected ) . '>' . esc_attr( $crop_prop ) . '</option>';
				}
				echo '</select>';
				echo '</div>';
			}

			echo '</div>';
			echo '<div class="clear"></div>';

			echo wp_kses_post( $this->field_after() );

		}

	}
}

<?php
/**
 * Framework column field file.
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

if ( ! class_exists( 'SPFTESTIMONIAL_Field_column' ) ) {
	/**
	 *
	 * Field: column
	 *
	 * @since 2.2.0
	 * @version 2.2.0
	 */
	class SPFTESTIMONIAL_Field_column extends SPFTESTIMONIAL_Fields {

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
					'large_desktop_icon'        => '<i class="fa fa-television"></i>',
					'desktop_icon'              => '<i class="fa fa-desktop"></i>',
					'laptop_icon'               => '<i class="fa fa-laptop"></i>',
					'tablet_icon'               => '<i class="fa fa-tablet"></i>',
					'mobile_icon'               => '<i class="fa fa-mobile"></i>',
					'large_desktop_placeholder' => esc_html__( 'Large Desktop', 'testimonial-free' ),
					'desktop_placeholder'       => esc_html__( 'Desktop', 'testimonial-free' ),
					'laptop_placeholder'        => esc_html__( 'Laptop', 'testimonial-free' ),
					'tablet_placeholder'        => esc_html__( 'Tablet', 'testimonial-free' ),
					'mobile_placeholder'        => esc_html__( 'Mobile', 'testimonial-free' ),
					'large_desktop'             => true,
					'desktop'                   => true,
					'laptop'                    => true,
					'tablet'                    => true,
					'mobile'                    => true,
				)
			);

			$default_values = array(
				'large_desktop' => '',
				'desktop'       => '',
				'laptop'        => '',
				'tablet'        => '',
				'mobile'        => '',
			);

			$value = wp_parse_args( $this->value, $default_values );

			echo wp_kses_post( $this->field_before() );

			$properties = array();

			foreach ( array( 'large_desktop', 'desktop', 'laptop', 'tablet', 'mobile' ) as $prop ) {
				if ( ! empty( $args[ $prop ] ) ) {
					$properties[] = $prop;
				}
			}
			echo '<div class="spftestimonial--inputs">';
			$properties = ( array( 'desktop', 'tablet' ) === $properties ) ? array_reverse( $properties ) : $properties;

			foreach ( $properties as $property ) {

				$placeholder = ( ! empty( $args[ $property . '_placeholder' ] ) ) ? $args[ $property . '_placeholder' ] : '';

				echo '<div class="spftestimonial--input">';
				echo ( ! empty( $args[ $property . '_icon' ] ) ) ? '<span class="spftestimonial--label spftestimonial--icon">' . wp_kses_post( $args[ $property . '_icon' ] ) . '</span>' : '';
				echo '<input type="number" name="' . esc_attr( $this->field_name( '[' . $property . ']' ) ) . '" value="' . esc_attr( $value[ $property ] ) . '" placeholder="' . esc_attr( $placeholder ) . '" class="spftestimonial-number" step="any" min="1" required />';
				echo '</div>';

			}
			echo '</div>';

			echo '<div class="clear"></div>';

			echo wp_kses_post( $this->field_after() );

		}

	}
}

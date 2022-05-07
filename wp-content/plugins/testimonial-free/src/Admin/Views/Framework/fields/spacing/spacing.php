<?php
/**
 * Framework spacing field file.
 *
 * @link https://shapedplugin.com
 * @since 2.0.0
 *
 * @package Testimonial_free
 * @subpackage Testimonial_free/framework
 */

if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.

if ( ! class_exists( 'SPFTESTIMONIAL_Field_spacing' ) ) {
	/**
	 *
	 * Field: spacing
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SPFTESTIMONIAL_Field_spacing extends SPFTESTIMONIAL_Fields {

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
					'top_icon'           => '<i class="fa fa-long-arrow-up"></i>',
					'right_icon'         => '<i class="fa fa-long-arrow-right"></i>',
					'bottom_icon'        => '<i class="fa fa-long-arrow-down"></i>',
					'left_icon'          => '<i class="fa fa-long-arrow-left"></i>',
					'all_icon'           => '<i class="fa fa-arrows-alt"></i>',
					'top_placeholder'    => esc_html__( 'top', 'testimonial-free' ),
					'right_placeholder'  => esc_html__( 'right', 'testimonial-free' ),
					'bottom_placeholder' => esc_html__( 'bottom', 'testimonial-free' ),
					'left_placeholder'   => esc_html__( 'left', 'testimonial-free' ),
					'all_placeholder'    => esc_html__( 'all', 'testimonial-free' ),
					'top'                => true,
					'left'               => true,
					'bottom'             => true,
					'right'              => true,
					'unit'               => true,
					'show_units'         => true,
					'all'                => false,
					'units'              => array( 'px', '%', 'em' ),
				)
			);

			$default_values = array(
				'top'    => '',
				'right'  => '',
				'bottom' => '',
				'left'   => '',
				'all'    => '',
				'unit'   => 'px',
			);

			$value   = wp_parse_args( $this->value, $default_values );
			$unit    = ( count( $args['units'] ) === 1 && ! empty( $args['unit'] ) ) ? $args['units'][0] : '';
			$is_unit = ( ! empty( $unit ) ) ? ' spftestimonial--is-unit' : '';

			echo wp_kses_post( $this->field_before() );

			echo '<div class="spftestimonial--inputs" data-depend-id="' . esc_attr( $this->field['id'] ) . '">';

			if ( ! empty( $args['all'] ) ) {

				$placeholder = ( ! empty( $args['all_placeholder'] ) ) ? $args['all_placeholder'] : '';

				echo '<div class="spftestimonial--input">';
				echo ( ! empty( $args['all_icon'] ) ) ? '<span class="spftestimonial--label spftestimonial--icon">' . wp_kses_post( $args['all_icon'] ) . '</span>' : '';
				echo '<input type="number" name="' . esc_attr( $this->field_name( '[all]' ) ) . '" value="' . esc_attr( $value['all'] ) . '" placeholder="' . esc_attr( $placeholder ) . '" class="spftestimonial-input-number' . esc_attr( $is_unit ) . '" step="any" />';
				echo ( $unit ) ? '<span class="spftestimonial--label spftestimonial--unit">' . esc_attr( $args['units'][0] ) . '</span>' : '';
				echo '</div>';

			} else {

				$properties = array();

				foreach ( array( 'top', 'right', 'bottom', 'left' ) as $prop ) {
					if ( ! empty( $args[ $prop ] ) ) {
						$properties[] = $prop;
					}
				}

				$properties = ( array( 'right', 'left' ) === $properties ) ? array_reverse( $properties ) : $properties;

				foreach ( $properties as $property ) {

					$placeholder = ( ! empty( $args[ $property . '_placeholder' ] ) ) ? $args[ $property . '_placeholder' ] : '';

					echo '<div class="spftestimonial--input">';
					echo ( ! empty( $args[ $property . '_icon' ] ) ) ? '<span class="spftestimonial--label spftestimonial--icon">' . wp_kses_post( $args[ $property . '_icon' ] ) . '</span>' : '';
					echo '<input type="number" name="' . esc_attr( $this->field_name( '[' . $property . ']' ) ) . '" value="' . esc_attr( $value[ $property ] ) . '" placeholder="' . esc_attr( $placeholder ) . '" class="spftestimonial-input-number' . esc_attr( $is_unit ) . '" step="any" />';
					echo ( $unit ) ? '<span class="spftestimonial--label spftestimonial--unit">' . esc_attr( $args['units'][0] ) . '</span>' : '';
					echo '</div>';

				}
			}

			if ( ! empty( $args['unit'] ) && ! empty( $args['show_units'] ) && count( $args['units'] ) > 1 ) {
				echo '<div class="spftestimonial--input">';
				echo '<select name="' . esc_attr( $this->field_name( '[unit]' ) ) . '">';
				foreach ( $args['units'] as $unit ) {
					$selected = ( $value['unit'] === $unit ) ? ' selected' : '';
					echo '<option value="' . esc_attr( $unit ) . '"' . esc_attr( $selected ) . '>' . esc_attr( $unit ) . '</option>';
				}
				echo '</select>';
				echo '</div>';
			}

			echo '</div>';

			echo wp_kses_post( $this->field_after() );

		}

		/**
		 * Output
		 *
		 * @return statement
		 */
		public function output() {
			$output    = '';
			$element   = ( is_array( $this->field['output'] ) ) ? join( ',', $this->field['output'] ) : $this->field['output'];
			$important = ( ! empty( $this->field['output_important'] ) ) ? '!important' : '';
			$unit      = ( ! empty( $this->value['unit'] ) ) ? $this->value['unit'] : 'px';

			$mode = ( ! empty( $this->field['output_mode'] ) ) ? $this->field['output_mode'] : 'padding';

			if ( 'border-radius' === $mode || 'radius' === $mode ) {

				$top    = 'border-top-left-radius';
				$right  = 'border-top-right-radius';
				$bottom = 'border-bottom-right-radius';
				$left   = 'border-bottom-left-radius';

			} elseif ( 'relative' === $mode || 'absolute' === $mode || 'none' === $mode ) {

				$top    = 'top';
				$right  = 'right';
				$bottom = 'bottom';
				$left   = 'left';

			} else {

				$top    = $mode . '-top';
				$right  = $mode . '-right';
				$bottom = $mode . '-bottom';
				$left   = $mode . '-left';

			}

			if ( ! empty( $this->field['all'] ) && isset( $this->value['all'] ) && '' !== $this->value['all'] ) {

				$output  = $element . '{';
				$output .= $top . ':' . $this->value['all'] . $unit . $important . ';';
				$output .= $right . ':' . $this->value['all'] . $unit . $important . ';';
				$output .= $bottom . ':' . $this->value['all'] . $unit . $important . ';';
				$output .= $left . ':' . $this->value['all'] . $unit . $important . ';';
				$output .= '}';

			} else {

				$top    = ( isset( $this->value['top'] ) && '' !== $this->value['top'] ) ? $top . ':' . $this->value['top'] . $unit . $important . ';' : '';
				$right  = ( isset( $this->value['right'] ) && '' !== $this->value['right'] ) ? $right . ':' . $this->value['right'] . $unit . $important . ';' : '';
				$bottom = ( isset( $this->value['bottom'] ) && '' !== $this->value['bottom'] ) ? $bottom . ':' . $this->value['bottom'] . $unit . $important . ';' : '';
				$left   = ( isset( $this->value['left'] ) && '' !== $this->value['left'] ) ? $left . ':' . $this->value['left'] . $unit . $important . ';' : '';

				if ( '' !== $top || '' !== $right || '' !== $bottom || '' !== $left ) {
					$output = $element . '{' . $top . $right . $bottom . $left . '}';
				}
			}

			$this->parent->output_css .= $output;

			return $output;

		}

	}
}

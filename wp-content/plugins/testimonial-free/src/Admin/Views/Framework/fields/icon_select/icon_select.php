<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Field: icon_select
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! class_exists( 'SPFTESTIMONIAL_Field_icon_select' ) ) {
	class SPFTESTIMONIAL_Field_icon_select extends SPFTESTIMONIAL_Fields {

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
					'options'  => array(),
				)
			);

			$value = ( is_array( $this->value ) ) ? $this->value : array_filter( (array) $this->value );

			echo wp_kses_post( $this->field_before() );

			if ( ! empty( $args['options'] ) ) {

				echo '<div class="spftestimonial-siblings spftestimonial--image-group" data-multiple="' . esc_attr( $args['multiple'] ) . '">';

				$num = 1;

				foreach ( $args['options'] as $key => $option ) {

					$type           = ( $args['multiple'] ) ? 'checkbox' : 'radio';
					$extra          = ( $args['multiple'] ) ? '[]' : '';
					$active         = ( in_array( $key, $value ) ) ? ' spftestimonial--active' : '';
					$checked        = ( in_array( $key, $value ) ) ? ' checked' : '';
					$pro_only_class = ( isset( $option['pro_only'] ) && $option['pro_only'] ) ? ' spftestimonial-pro-only' : '';

					echo '<div class="spftestimonial--sibling spftestimonial--image sp-field-icon-select' . esc_attr( $active . $pro_only_class ) . '">';
					if ( isset( $option['icon'] ) && ! empty( $option['icon'] ) ) {
						echo '<span class="' . esc_attr( $option['icon'] ) . '"/></span>';
					} else {
						echo '<span class="' . esc_attr( $option ) . '"/></span>';
					}
					echo '<input type="' . esc_attr( $type ) . '" name="' . esc_attr( $this->field_name( $extra ) ) . '" value="' . esc_attr( $key ) . '"' . $this->field_attributes() . esc_attr( $checked ) . '/>';
					echo '</div>';

				}

				echo '</div>';

			}

			echo '<div class="clear"></div>';

			echo wp_kses_post( $this->field_after() );

		}

	}
}

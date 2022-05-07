<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Field: heading
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! class_exists( 'SPFTESTIMONIAL_Field_heading' ) ) {
	class SPFTESTIMONIAL_Field_heading extends SPFTESTIMONIAL_Fields {

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

			echo ( ! empty( $this->field['content'] ) ) ? wp_kses_post( $this->field['content'] ) : '';

		}

	}
}

<?php
/**
 * Framework abstract.class file.
 *
 * @link https://shapedplugin.com
 * @since 2.0.0
 *
 * @package Testimonial_Free
 * @subpackage Testimonial_free/framework
 */

use ShapedPlugin\TestimonialFree\Admin\Views\Framework\Classes\SPFTESTIMONIAL;

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

if ( ! class_exists( 'SPFTESTIMONIAL_Abstract' ) ) {
	/**
	 *
	 * Abstract Class
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	abstract class SPFTESTIMONIAL_Abstract {

		/**
		 * $abstract variable
		 *
		 * @var string
		 */
		public $abstract = '';
		/**
		 * $output_css variable
		 *
		 * @var string
		 */
		public $output_css = '';
		/**
		 * Constructor of the class.
		 */
		public function __construct() {

			// Collect output css and typography.
			if ( ! empty( $this->args['output_css'] ) || ! empty( $this->args['enqueue_webfont'] ) ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'collect_output_css_and_typography' ), 10 );
				SPFTESTIMONIAL::$css = apply_filters( "spftestimonial_{$this->unique}_output_css", SPFTESTIMONIAL::$css, $this );
			}

		}
		/**
		 * Add output CSS and typography.
		 *
		 * @return void
		 */
		public function collect_output_css_and_typography() {

			$this->recursive_output_css( $this->pre_fields );
		}

		/**
		 * Add output CSS.
		 *
		 * @param array $fields get fields.
		 * @param array $combine_field get fields.
		 *
		 * @return void
		 */
		public function recursive_output_css( $fields = array(), $combine_field = array() ) {

			if ( ! empty( $fields ) ) {

				foreach ( $fields as $field ) {

					$field_id     = ( ! empty( $field['id'] ) ) ? $field['id'] : '';
					$field_type   = ( ! empty( $field['type'] ) ) ? $field['type'] : '';
					$field_output = ( ! empty( $field['output'] ) ) ? $field['output'] : '';
					$field_check  = ( 'typography' === $field_type || $field_output ) ? true : false;
					$field_class  = 'SPFTESTIMONIAL_Field_' . $field_type;

					if ( $field_type && $field_id ) {

						if ( 'fieldset' === $field_type ) {
							if ( ! empty( $field['fields'] ) ) {
									$this->recursive_output_css( $field['fields'], $field );
							}
						}

						if ( 'accordion' === $field_type ) {
							if ( ! empty( $field['accordions'] ) ) {
								foreach ( $field['accordions'] as $accordion ) {
									$this->recursive_output_css( $accordion['fields'], $field );
								}
							}
						}

						if ( 'tabbed' === $field_type ) {
							if ( ! empty( $field['tabs'] ) ) {
								foreach ( $field['tabs'] as $accordion ) {
									$this->recursive_output_css( $accordion['fields'], $field );
								}
							}
						}

						if ( class_exists( $field_class ) ) {

							if ( method_exists( $field_class, 'output' ) ) {

								$field_value = '';

								if ( $field_check && ( 'options' === $this->abstract || 'customize' === $this->abstract ) ) {

									if ( ! empty( $combine_field ) ) {

										$field_value = ( isset( $this->options[ $combine_field['id'] ][ $field_id ] ) ) ? $this->options[ $combine_field['id'] ][ $field_id ] : '';

									} else {

										$field_value = ( isset( $this->options[ $field_id ] ) ) ? $this->options[ $field_id ] : '';

									}
								} elseif ( $field_check && ( 'metabox' === $this->abstract && is_singular() || 'taxonomy' === $this->abstract && is_archive() ) ) {

									if ( ! empty( $combine_field ) ) {

										$meta_value  = $this->get_meta_value( $combine_field );
										$field_value = ( isset( $meta_value[ $field_id ] ) ) ? $meta_value[ $field_id ] : '';

									} else {

										$meta_value  = $this->get_meta_value( $field );
										$field_value = ( isset( $meta_value ) ) ? $meta_value : '';

									}
								}

								$instance = new $field_class( $field, $field_value, $this->unique, 'wp/enqueue', $this );

								// output css.
								if ( $field_output && $this->args['output_css'] ) {
									SPFTESTIMONIAL::$css .= $instance->output();
								}

								unset( $instance );

							}
						}
					}
				}
			}

		}

	}
}

<?php
/**
 * Framework Shortcode field file.
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

if ( ! class_exists( 'SPFTESTIMONIAL_Field_shortcode' ) ) {

	/**
	 *
	 * Field: Shortcode
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SPFTESTIMONIAL_Field_shortcode extends SPFTESTIMONIAL_Fields {


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

			$post_id = get_the_ID();
			echo ( ! empty( $post_id ) ) ? '<div class="spftestimonial-scode-wrap-side"><p>To display your testimonial form, add the following shortcode into your post, custom post types, page, widget or block editor. If adding the form to your theme files, additionally include the surrounding PHP code, <a href="https://docs.shapedplugin.com/docs/testimonial-pro/create-a-front-end-forma-z/" target="_blank">see how</a>.</p><span class="spftestimonial-shortcode-selectable">[sp_testimonial_form id="' . esc_attr( $post_id ) . '"]</span></div><div class="sp-testimonial-after-copy-text"><i class="fa fa-check-circle"></i> Shortcode Copied to Clipboard!</div>' : '';
		}

	}
}

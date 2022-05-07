<?php
/**
 * Framework form_upper_section field file.
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

if ( ! class_exists( 'SPFTESTIMONIAL_Field_form_upper_section' ) ) {
	/**
	 *
	 * Field: form_upper_section
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SPFTESTIMONIAL_Field_form_upper_section extends SPFTESTIMONIAL_Fields {

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
		public function render() { ?>
		<div class="sp-testimonial-help sp-testimonial-upgrade sp-testimonial-upper-box-area">
	<div class="sp-testimonial-features">
		<h1 class="sp-testimonial-text-center">Easily Collect and Display Testimonials on Your Website, Boost Sales!</h1>
		<p class="sp-testimonial-text-center sp-testimonial-subtitle"> With this Real Testimonials Pro, you can quickly create multiple forms to collect Testimonials or Feedbacks from your website visitors and customers.</p>

		<div class="feature-section three-col">
			<div class="col">
				<div class="sp-testimonial-feature">
					<h3><span class="dashicons dashicons-yes"></span>Collect New Testimonials Automatically</h3>
					<h3><span class="dashicons dashicons-yes"></span>Create Unlimited Real Testimonial Forms</h3>
					<h3><span class="dashicons dashicons-yes"></span>Email Notifications for New Testimonials</h3>
					<h3><span class="dashicons dashicons-yes"></span>Manage New Testimonials Before Publish</h3>
				</div>
			</div>
			<div class="col">
				<div class="sp-testimonial-feature">
					<h3><span class="dashicons dashicons-yes"></span>Protect your Form against Spam</h3>
					<h3><span class="dashicons dashicons-yes"></span>Drag-and-Drop Real Testimonials Form Builder</h3>
					<h3><span class="dashicons dashicons-yes"></span>5+ Beautiful Layouts to Display Testimonials</h3>
					<h3><span class="dashicons dashicons-yes"></span>10+ Professionally Designed Themes</h3>
				</div>
			</div>
			<div class="col">
				<div class="sp-testimonial-feature">
					<h3><span class="dashicons dashicons-yes"></span>Collect and Display Video Testimonials </h3>
					<h3><span class="dashicons dashicons-yes"></span>Add Testimonial Forms To Any Page or Post</h3>
					<h3><span class="dashicons dashicons-yes"></span>Rich Snippets or Structured Data compatible</h3>
					<h3><span class="dashicons dashicons-yes"></span>Regular Updates & Great Customer Support</h3>
				</div>
			</div>
		</div>
		<p  class="sp-testimonial-text-center sp-testimonial-subtitle">Get access to all robust features and start collecting fresh testimonials right now.</p>
		<p class="sp-testimonial-text-center"><a class="sp-testimonial-upgrade-btn" target="_blank" href="https://shapedplugin.com/real-testimonials/?ref=1">Upgrade To Real Testimonials Pro Now!</a></p>

	</div>
	</div>
			<?php

		}
	}
}

<?php
/**
 * The testimonial settings configuration.
 *
 * @link https://shapedplugin.com
 * @since 2.0.0
 *
 * @package Testimonial_free
 * @subpackage Testimonial_free/admin/views
 */

use ShapedPlugin\TestimonialFree\Admin\Views\Framework\Classes\SPFTESTIMONIAL;

if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.

//
// Set a unique slug-like ID.
//
$prefix = 'sp_testimonial_pro_options';

//
// Review text.
//
$url  = 'https://wordpress.org/support/plugin/testimonial-free/reviews/?filter=5#new-post';
$text = sprintf(
	wp_kses_post( 'If you like <strong>Real Testimonials</strong> please leave us a <a href="%s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> rating. Your Review is very important to us as it helps us to grow more.' ),
	esc_url( $url )
);

//
// Create a settings page.
//
SPFTESTIMONIAL::createOptions(
	$prefix,
	array(
		'menu_title'       => __( 'Settings', 'testimonial-free' ),
		'menu_parent'      => 'edit.php?post_type=spt_testimonial',
		'menu_type'        => 'submenu', // menu, submenu, options, theme, etc.
		'menu_slug'        => 'spt_settings',
		'theme'            => 'light',
		'class'            => 'spt-main-class',
		'show_all_options' => false,
		'show_bar_menu'    => false,
		'show_search'      => false,
		'show_reset_all'   => false,
		'show_footer'      => false,
		'footer_credit'    => $text,
		'framework_title'  => __( 'Settings', 'testimonial-free' ),
	)
);


//
// Advanced Settings section.
//
SPFTESTIMONIAL::createSection(
	$prefix,
	array(
		'name'   => 'advanced_settings',
		'title'  => __( 'Advanced Settings', 'testimonial-free' ),
		'icon'   => 'fa fa-cogs',
		'fields' => array(
			array(
				'id'         => 'testimonial_data_remove',
				'type'       => 'checkbox',
				'title'      => __( 'Clean up Data on Deletion', 'testimonial-free' ),
				'title_help' => __( 'Delete all Real Testimonials data from the database on plugin deletion.', 'testimonial-free' ),
				'default'    => false,
				'sanitize'   => 'rest_sanitize_boolean',
			),
			array(
				'id'         => 'tpro_dequeue_google_fonts',
				'type'       => 'switcher',
				'title'      => __( 'Google Fonts', 'testimonial-free' ),
				'text_on'    => __( 'Enqueue', 'testimonial-free' ),
				'text_off'   => __( 'Dequeue', 'testimonial-free' ),
				'text_width' => 95,
				'class'      => 'pro_switcher',
				'attributes' => array( 'disabled' => 'disabled' ),
				'default'    => false,
				'sanitize'   => 'rest_sanitize_boolean',
			),
			array(
				'type'    => 'subheading',
				'content' => __( 'Enqueue or Dequeue JS', 'testimonial-free' ),
			),
			array(
				'id'         => 'tf_dequeue_slick_js',
				'type'       => 'switcher',
				'title'      => __( 'Slick JS', 'testimonial-free' ),
				'text_on'    => __( 'Enqueue', 'testimonial-free' ),
				'text_off'   => __( 'Dequeue', 'testimonial-free' ),
				'text_width' => 95,
				'default'    => true,
				'sanitize'   => 'rest_sanitize_boolean',
			),
			array(
				'type'    => 'subheading',
				'content' => __( 'Enqueue or Dequeue CSS', 'testimonial-free' ),
			),
			array(
				'id'         => 'tf_dequeue_slick_css',
				'type'       => 'switcher',
				'title'      => __( 'Slick CSS', 'testimonial-free' ),
				'text_on'    => __( 'Enqueue', 'testimonial-free' ),
				'text_off'   => __( 'Dequeue', 'testimonial-free' ),
				'text_width' => 95,
				'default'    => true,
				'sanitize'   => 'rest_sanitize_boolean',
			),
			array(
				'id'         => 'tf_dequeue_fa_css',
				'type'       => 'switcher',
				'title'      => __( 'Font Awesome CSS', 'testimonial-free' ),
				'text_on'    => __( 'Enqueue', 'testimonial-free' ),
				'text_off'   => __( 'Dequeue', 'testimonial-free' ),
				'text_width' => 95,
				'default'    => true,
				'sanitize'   => 'rest_sanitize_boolean',
			),
		),
	)
);

//
// Menu Settings section.
//
SPFTESTIMONIAL::createSection(
	$prefix,
	array(
		'name'   => 'menu_settings',
		'title'  => __( 'Menu Settings', 'testimonial-free' ),
		'icon'   => 'fa fa-bars',
		'fields' => array(
			array(
				'id'       => 'tpro_singular_name',
				'type'     => 'text',
				'title'    => __( 'Singular name', 'testimonial-free' ),
				'default'  => 'Testimonial',
				'sanitize' => 'spftestimonial_sanitize_text',
			),
			array(
				'id'       => 'tpro_plural_name',
				'type'     => 'text',
				'title'    => __( 'Plural name', 'testimonial-free' ),
				'default'  => 'Testimonials',
				'sanitize' => 'spftestimonial_sanitize_text',
			),

		),
	)
);

// Field: reCAPTCHA.
SPFTESTIMONIAL::createSection(
	$prefix,
	array(
		'id'     => 'google_recaptcha',
		'title'  => __( 'reCAPTCHA', 'testimonial-free' ),
		'icon'   => 'fa fa-shield',
		'fields' => array(

			array(
				'type'    => 'submessage',
				'class'   => 'pro_only_field',
				'style'   => 'info',
				'content' => __(
					'<a href="https://www.google.com/recaptcha" target="_blank">reCAPTCHA</a> is a free anti-spam service of Google that protects your website from spam and abuse. <a
href="https://www.google.com/recaptcha/admin#list" target="_blank"> Get your API Keys</a>. <a target="_blank" href="https://shapedplugin.com/real-testimonials/?ref=1"><b>(Available in Pro)</b></a>',
					'testimonial-free'
				),
			),
			array(
				'id'         => 'captcha_site_key',
				'type'       => 'text',
				'class'      => 'pro_only_field',
				'attributes' => array( 'disabled' => 'disabled' ),
				'title'      => __( 'Site key', 'testimonial-free' ),
				'sanitize'   => 'spftestimonial_sanitize_text',
			),
			array(
				'id'         => 'captcha_secret_key',
				'type'       => 'text',
				'class'      => 'pro_only_field',
				'attributes' => array( 'disabled' => 'disabled' ),
				'title'      => __( 'Secret key', 'testimonial-free' ),
				'sanitize'   => 'spftestimonial_sanitize_text',

			),

		),
	)
);

//
// Custom CSS section.
//
SPFTESTIMONIAL::createSection(
	$prefix,
	array(
		'name'   => 'custom_css_section',
		'title'  => __( 'Custom CSS', 'testimonial-free' ),
		'icon'   => 'fa fa-css3',
		'fields' => array(
			array(
				'id'       => 'custom_css',
				'type'     => 'code_editor',
				'sanitize' => 'wp_strip_all_tags',
				'settings' => array(
					'theme' => 'dracula',
					'mode'  => 'css',
				),

				'title'    => __( 'Custom CSS', 'testimonial-free' ),
			),
		),
	)
);

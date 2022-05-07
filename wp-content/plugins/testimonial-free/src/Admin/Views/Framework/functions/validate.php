<?php
/**
 * Real Testimonials validate functions.
 *
 * @link https://shapedplugin.com
 * @since 2.0.0
 *
 * @package Testimonial_free
 * @subpackage Testimonial_free/admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

if ( ! function_exists( 'spftestimonial_validate_email' ) ) {
	/**
	 *
	 * Email validate
	 *
	 * @param  mixed $value value.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	function spftestimonial_validate_email( $value ) {

		if ( ! filter_var( $value, FILTER_VALIDATE_EMAIL ) ) {
			return esc_html__( 'Please enter a valid email address.', 'testimonial-free' );
		}

	}
}


if ( ! function_exists( 'spftestimonial_validate_numeric' ) ) {
	/**
	 *
	 * Numeric validate
	 *
	 * @param  mixed $value value.
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	function spftestimonial_validate_numeric( $value ) {

		if ( ! is_numeric( $value ) ) {
			return esc_html__( 'Please enter a valid number.', 'testimonial-free' );
		}

	}
}


if ( ! function_exists( 'spftestimonial_validate_required' ) ) {
	/**
	 *
	 * Required validate
	 *
	 * @param  mixed $value value.
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	function spftestimonial_validate_required( $value ) {

		if ( empty( $value ) ) {
			return esc_html__( 'This field is required.', 'testimonial-free' );
		}

	}
}

if ( ! function_exists( 'spftestimonial_validate_url' ) ) {
	/**
	 *
	 * URL validate
	 *
	 * @param  mixed $value value.
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	function spftestimonial_validate_url( $value ) {

		if ( ! filter_var( $value, FILTER_VALIDATE_URL ) ) {
			return esc_html__( 'Please enter a valid URL.', 'testimonial-free' );
		}

	}
}

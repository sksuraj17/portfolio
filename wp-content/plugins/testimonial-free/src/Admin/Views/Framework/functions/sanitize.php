<?php
/**
 * Real Testimonials sanitize functions.
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

if ( ! function_exists( 'spftestimonial_sanitize_replace_a_to_b' ) ) {
	/**
	 *
	 * Sanitize
	 * Replace letter a to letter b
	 *
	 * @param  mixed $value value.
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	function spftestimonial_sanitize_replace_a_to_b( $value ) {
		return str_replace( 'a', 'b', $value );
	}
}


if ( ! function_exists( 'spftestimonial_sanitize_title' ) ) {
	/**
	 *
	 * Sanitize title
	 *
	 * @param  mixed $value value.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	function spftestimonial_sanitize_title( $value ) {
		return sanitize_title( $value );
	}
}


if ( ! function_exists( 'spftestimonial_sanitize_number_array_field' ) ) {
	/**
	 *
	 * Sanitize number array
	 *
	 * @param  mixed $array value.
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	function spftestimonial_sanitize_number_array_field( $array ) {

		foreach ( $array as $key => $value ) {
			if ( 'unit' === $key ) {
				$array[ $key ] = wp_filter_nohtml_kses( $value );
			} else {
				if ( ! empty( $value ) ) {
					$array[ $key ] = intval( $value );
				}
			}
		}
		return $array;
	}
}

if ( ! function_exists( 'spftestimonial_sanitize_number_field' ) ) {
	/**
	 *
	 * Sanitize number
	 *
	 * @param  mixed $value value.
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	function spftestimonial_sanitize_number_field( $value ) {
		if ( ! empty( $value ) ) {
			return intval( $value );
		}
	}
}

if ( ! function_exists( 'spftestimonial_sanitize_border_field' ) ) {
	/**
	 *
	 * Sanitize border field
	 *
	 * @param  mixed $array value.
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	function spftestimonial_sanitize_border_field( $array ) {

		foreach ( $array as $key => $value ) {
			if ( 'style' == $key ) {
				$array[ $key ] = sanitize_text_field( $value );
			} elseif ( strpos( $key, 'color' ) !== false ) {
				$array[ $key ] = sanitize_text_field( $value );
			} else {
				if ( ! empty( $value ) ) {
					$array[ $key ] = intval( $value );
				}
			}
		}
		return $array;
	}
}

if ( ! function_exists( 'spftestimonial_sanitize_color_group_field' ) ) {
	/**
	 *
	 * Sanitize color group field
	 *
	 * @param  mixed $array value.
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	function spftestimonial_sanitize_color_group_field( $array ) {
		foreach ( $array as $key => $value ) {
			$array[ $key ] = sanitize_text_field( $value );
		}
		return $array;
	}
}

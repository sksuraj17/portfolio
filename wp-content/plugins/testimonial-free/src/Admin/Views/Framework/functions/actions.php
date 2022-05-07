<?php
/**
 * Real Testimonials actions functions.
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

if ( ! function_exists( 'spftestimonial_get_icons' ) ) {
	/**
	 * Get Icon
	 *
	 * @return void
	 */
	function spftestimonial_get_icons() {

		$nonce = ( ! empty( $_POST['nonce'] ) ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';

		if ( ! wp_verify_nonce( $nonce, 'spftestimonial_icon_nonce' ) ) {
			wp_send_json_error( array( 'error' => esc_html__( 'Error: Invalid nonce verification.', 'testimonial-free' ) ) );
		}

		ob_start();

		$icon_library = ( apply_filters( 'spftestimonial_fa4', false ) ) ? 'fa4' : 'fa5';

		SPFTESTIMONIAL::include_plugin_file( 'fields/icon/' . $icon_library . '-icons.php' );

		$icon_lists = apply_filters( 'spftestimonial_field_icon_add_icons', spftestimonial_get_default_icons() );

		if ( ! empty( $icon_lists ) ) {

			foreach ( $icon_lists as $list ) {

				echo ( count( $icon_lists ) >= 2 ) ? '<div class="spftestimonial-icon-title">' . esc_attr( $list['title'] ) . '</div>' : '';

				foreach ( $list['icons'] as $icon ) {
					echo '<i title="' . esc_attr( $icon ) . '" class="' . esc_attr( $icon ) . '"></i>';
				}
			}
		} else {

				echo '<div class="spftestimonial-error-text">' . esc_html__( 'No data available.', 'testimonial-free' ) . '</div>';

		}

		$content = ob_get_clean();

		wp_send_json_success( array( 'content' => $content ) );

	}
	add_action( 'wp_ajax_spftestimonial-get-icons', 'spftestimonial_get_icons' );
}


if ( ! function_exists( 'spftestimonial_export' ) ) {
	/**
	 * Export
	 *
	 * @return void
	 */
	function spftestimonial_export() {

		$nonce  = ( ! empty( $_GET['nonce'] ) ) ? sanitize_text_field( wp_unslash( $_GET['nonce'] ) ) : '';
		$unique = ( ! empty( $_GET['unique'] ) ) ? sanitize_text_field( wp_unslash( $_GET['unique'] ) ) : '';

		if ( ! wp_verify_nonce( $nonce, 'spftestimonial_backup_nonce' ) ) {
			die( esc_html__( 'Error: Invalid nonce verification.', 'testimonial-free' ) );
		}

		if ( empty( $unique ) ) {
			die( esc_html__( 'Error: Invalid key.', 'testimonial-free' ) );
		}

		// Export.
		header( 'Content-Type: application/json' );
		header( 'Content-disposition: attachment; filename=backup-' . gmdate( 'd-m-Y' ) . '.json' );
		header( 'Content-Transfer-Encoding: binary' );
		header( 'Pragma: no-cache' );
		header( 'Expires: 0' );

		echo json_encode( get_option( $unique ) );

		die();

	}
	add_action( 'wp_ajax_spftestimonial-export', 'spftestimonial_export' );
}

if ( ! function_exists( 'spftestimonial_import_ajax' ) ) {
	/**
	 * Ajax Import
	 *
	 * @return void
	 */
	function spftestimonial_import_ajax() {

		$nonce  = ( ! empty( $_POST['nonce'] ) ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
		$unique = ( ! empty( $_POST['unique'] ) ) ? sanitize_text_field( wp_unslash( $_POST['unique'] ) ) : '';
		$data   = ( ! empty( $_POST['data'] ) ) ? wp_kses_post_deep( json_decode( wp_unslash( trim( $_POST['data'] ) ), true ) ) : array();

		if ( ! wp_verify_nonce( $nonce, 'spftestimonial_backup_nonce' ) ) {
			wp_send_json_error( array( 'error' => esc_html__( 'Error: Invalid nonce verification.', 'testimonial-free' ) ) );
		}

		if ( empty( $unique ) ) {
			wp_send_json_error( array( 'error' => esc_html__( 'Error: Invalid key.', 'testimonial-free' ) ) );
		}

		if ( empty( $data ) || ! is_array( $data ) ) {
			wp_send_json_error( array( 'error' => esc_html__( 'Error: The response is not a valid JSON response.', 'testimonial-free' ) ) );
		}

		// Success.
		update_option( $unique, $data );

		wp_send_json_success();

	}
	add_action( 'wp_ajax_spftestimonial-import', 'spftestimonial_import_ajax' );
}

if ( ! function_exists( 'spftestimonial_reset_ajax' ) ) {
	/**
	 * Ajax reset.
	 *
	 * @return void
	 */
	function spftestimonial_reset_ajax() {

		$nonce  = ( ! empty( $_POST['nonce'] ) ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
		$unique = ( ! empty( $_POST['unique'] ) ) ? sanitize_text_field( wp_unslash( $_POST['unique'] ) ) : '';

		if ( ! wp_verify_nonce( $nonce, 'spftestimonial_backup_nonce' ) ) {
			wp_send_json_error( array( 'error' => esc_html__( 'Error: Invalid nonce verification.', 'testimonial-free' ) ) );
		}

		// Success.
		delete_option( $unique );

		wp_send_json_success();

	}
	add_action( 'wp_ajax_spftestimonial-reset', 'spftestimonial_reset_ajax' );
}

if ( ! function_exists( 'spftestimonial_chosen_ajax' ) ) {
	/**
	 * Chosen Ajax.
	 *
	 * @return void
	 */
	function spftestimonial_chosen_ajax() {

		$nonce = ( ! empty( $_POST['nonce'] ) ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
		$type  = ( ! empty( $_POST['type'] ) ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : '';
		$term  = ( ! empty( $_POST['term'] ) ) ? sanitize_text_field( wp_unslash( $_POST['term'] ) ) : '';
		$query = ( ! empty( $_POST['query_args'] ) ) ? wp_kses_post_deep( $_POST['query_args'] ) : array();

		if ( ! wp_verify_nonce( $nonce, 'spftestimonial_chosen_ajax_nonce' ) ) {
			wp_send_json_error( array( 'error' => esc_html__( 'Error: Invalid nonce verification.', 'testimonial-free' ) ) );
		}

		if ( empty( $type ) || empty( $term ) ) {
			wp_send_json_error( array( 'error' => esc_html__( 'Error: Invalid term ID.', 'testimonial-free' ) ) );
		}

		$capability = apply_filters( 'spftestimonial_chosen_ajax_capability', 'manage_options' );

		if ( ! current_user_can( $capability ) ) {
			wp_send_json_error( array( 'error' => esc_html__( 'Error: You do not have permission to do that.', 'testimonial-free' ) ) );
		}

		// Success.
		$options = SPFTESTIMONIAL_Fields::field_data( $type, $term, $query );

		wp_send_json_success( $options );

	}
	add_action( 'wp_ajax_spftestimonial-chosen', 'spftestimonial_chosen_ajax' );
}

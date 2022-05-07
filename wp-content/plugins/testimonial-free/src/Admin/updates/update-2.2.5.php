<?php
/**
 * Update version.
 */
update_option( 'testimonial_version', '2.2.5' );
update_option( 'testimonial_db_version', '2.2.5' );

/**
 * Shortcode query for id.
 */
$args          = new WP_Query(
	array(
		'post_type'      => 'sp_tfree_shortcodes',
		'post_status'    => 'any',
		'posts_per_page' => '300',
	)
);
$shortcode_ids = wp_list_pluck( $args->posts, 'ID' );
if ( count( $shortcode_ids ) > 0 ) {
	foreach ( $shortcode_ids as $shortcode_key => $shortcode_id ) {
		$shortcode_data = get_post_meta( $shortcode_id, 'sp_tpro_shortcode_options', true );

		/**
		 * Responsive columns.
		 */
		$number_of_testimonials               = isset( $shortcode_data['number_of_testimonials'] ) ? $shortcode_data['number_of_testimonials'] : '';
		$number_of_testimonials_desktop       = isset( $shortcode_data['number_of_testimonials_desktop'] ) ? $shortcode_data['number_of_testimonials_desktop'] : '';
		$number_of_testimonials_small_desktop = isset( $shortcode_data['number_of_testimonials_small_desktop'] ) ? $shortcode_data['number_of_testimonials_small_desktop'] : '';
		$number_of_testimonials_tablet        = isset( $shortcode_data['number_of_testimonials_tablet'] ) ? $shortcode_data['number_of_testimonials_tablet'] : '';
		$number_of_testimonials_mobile        = isset( $shortcode_data['number_of_testimonials_mobile'] ) ? $shortcode_data['number_of_testimonials_mobile'] : '';
		$shortcode_data['columns']            = array(
			'large_desktop' => $number_of_testimonials,
			'desktop'       => $number_of_testimonials_desktop,
			'laptop'        => $number_of_testimonials_small_desktop,
			'tablet'        => $number_of_testimonials_tablet,
			'mobile'        => $number_of_testimonials_mobile,
		);
		if ( ! empty( $number_of_testimonials ) ) {
			unset( $shortcode_data['number_of_testimonials'] );
		}
		if ( ! empty( $number_of_testimonials_desktop ) ) {
			unset( $shortcode_data['number_of_testimonials_desktop'] );
		}
		if ( ! empty( $number_of_testimonials_small_desktop ) ) {
			unset( $shortcode_data['number_of_testimonials_small_desktop'] );
		}
		if ( ! empty( $number_of_testimonials_tablet ) ) {
			unset( $shortcode_data['number_of_testimonials_tablet'] );
		}
		if ( ! empty( $number_of_testimonials_mobile ) ) {
			unset( $shortcode_data['number_of_testimonials_mobile'] );
		}

		$navigation_arrow_color              = isset( $shortcode_data['navigation_arrow_color'] ) ? $shortcode_data['navigation_arrow_color'] : '';
		$navigation_hover_arrow_color        = isset( $shortcode_data['navigation_hover_arrow_color'] ) ? $shortcode_data['navigation_hover_arrow_color'] : '';
		$shortcode_data['navigation_color']  = array(
			'color'            => $navigation_arrow_color,
			'hover-color'      => $navigation_hover_arrow_color,
			'background'       => 'transparent',
			'hover-background' => 'transparent',
		);
		$shortcode_data['navigation_border'] = array(
			'all'         => '0',
			'style'       => 'solid',
			'color'       => '#777777',
			'hover-color' => '#1595ce',
		);
		if ( ! empty( $navigation_arrow_color ) ) {
			unset( $shortcode_data['navigation_arrow_color'] );
		}
		if ( ! empty( $navigation_hover_arrow_color ) ) {
			unset( $shortcode_data['navigation_hover_arrow_color'] );
		}

		$pagination_color                    = isset( $shortcode_data['pagination_color'] ) ? $shortcode_data['pagination_color'] : '';
		$pagination_active_color             = isset( $shortcode_data['pagination_active_color'] ) ? $shortcode_data['pagination_active_color'] : '';
		$shortcode_data['pagination_colors'] = array(
			'color'        => $pagination_color,
			'active-color' => $pagination_active_color,
		);
		if ( ! empty( $pagination_color ) ) {
			unset( $shortcode_data['pagination_color'] );
		}
		if ( ! empty( $pagination_active_color ) ) {
			unset( $shortcode_data['pagination_active_color'] );
		}

		$rtl_mode                    = isset( $shortcode_data['rtl_mode'] ) ? $shortcode_data['rtl_mode'] : '';
		$slider_direction = 'ltr';
		if ( true == $rtl_mode ) {
			$slider_direction = 'rtl';
		}
		$shortcode_data['slider_direction'] = $slider_direction;
		if ( ! empty( $rtl_mode ) ) {
			unset( $shortcode_data['rtl_mode'] );
		}

		$shortcode_data['image_sizes'] = 'tf-client-image-size';

		update_post_meta( $shortcode_id, 'sp_tpro_shortcode_options', $shortcode_data );
	}
}

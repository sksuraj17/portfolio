<?php
/**
 * Update version.
 */
update_option( 'testimonial_version', '2.1.5' );
update_option( 'testimonial_db_version', '2.1.5' );

/**
 * Convert old to new shortcode meta.
 */
function covert_old_to_new_shortcode_meta_2_1_5() {
	$args     = new WP_Query(
		array(
			'post_type'      => 'sp_tfree_shortcodes',
			'post_status'    => 'any',
			'posts_per_page' => '300',
		)
	);
	$post_ids = wp_list_pluck( $args->posts, 'ID' );
	if ( count( $post_ids ) > 0 ) {
		foreach ( $post_ids as $post_id ) {
			$slider_layout                  = get_post_meta( $post_id, 'tfree_slider_layout', true );
			$theme_style                    = get_post_meta( $post_id, 'tfree_themes', true );
			$testimonials_from              = get_post_meta( $post_id, 'tfree_testimonials_from', true );
			$number_of_total_testimonials   = get_post_meta( $post_id, 'tfree_number_of_total_testimonials', true );
			$order_by                       = get_post_meta( $post_id, 'tfree_order_by', true );
			$order                          = get_post_meta( $post_id, 'tfree_order', true );
			$number_of_column               = get_post_meta( $post_id, 'tfree_number_of_column', true );
			$number_of_column_desktop       = get_post_meta( $post_id, 'tfree_number_of_column_desktop', true );
			$number_of_column_small_desktop = get_post_meta( $post_id, 'tfree_number_of_column_small_desktop', true );
			$number_of_column_tablet        = get_post_meta( $post_id, 'tfree_number_of_column_tablet', true );
			$number_of_column_mobile        = get_post_meta( $post_id, 'tfree_number_of_column_mobile', true );

			$auto_play               = 'on' === get_post_meta( $post_id, 'tfree_auto_play', true ) ? 'true' : 'false';
			$auto_play_speed         = get_post_meta( $post_id, 'tfree_auto_play_speed', true );
			$scroll_speed            = get_post_meta( $post_id, 'tfree_scroll_speed', true );
			$pause_on_hover          = 'on' === get_post_meta( $post_id, 'tfree_pause_on_hover', true ) ? true : false;
			$infinite_loop           = 'on' === get_post_meta( $post_id, 'tfree_infinite_loop', true ) ? true : false;
			$navigation              = 'on' === get_post_meta( $post_id, 'tfree_navigation', true ) ? 'true' : 'false';
			$nav_arrow_color         = get_post_meta( $post_id, 'tfree_nav_arrow_color', true );
			$nav_arrow_hover         = get_post_meta( $post_id, 'tfree_nav_arrow_hover', true );
			$pagination              = 'on' === get_post_meta( $post_id, 'tfree_pagination', true ) ? 'true' : 'false';
			$pagination_color        = get_post_meta( $post_id, 'tfree_pagination_color', true );
			$pagination_active_color = get_post_meta( $post_id, 'tfree_pagination_active_color', true );
			$adaptive                = 'on' === get_post_meta( $post_id, 'tfree_adaptive', true ) ? true : false;
			$swipe                   = 'on' === get_post_meta( $post_id, 'tfree_swipe', true ) ? true : false;
			$mouse_draggable         = 'on' === get_post_meta( $post_id, 'tfree_mouse_draggable', true ) ? true : false;
			$rtl                     = 'on' === get_post_meta( $post_id, 'tfree_rtl', true ) ? true : false;

			$section_title             = 'off' === get_post_meta( $post_id, 'tfree_section_title', true ) ? false : true;
			$section_title_color       = get_post_meta( $post_id, 'tfree_section_title_color', true );
			$testimonial_title         = 'on' === get_post_meta( $post_id, 'tfree_testimonial_title', true ) ? true : false;
			$testimonial_title_color   = get_post_meta( $post_id, 'tfree_testimonial_title_color', true );
			$testimonial_content       = 'on' === get_post_meta( $post_id, 'tfree_testimonial_content', true ) ? true : false;
			$testimonial_content_color = get_post_meta( $post_id, 'tfree_testimonial_content_color', true );
			$reviewer_name             = 'on' === get_post_meta( $post_id, 'tfree_reviewer_name', true ) ? true : false;
			$reviewer_name_color       = get_post_meta( $post_id, 'tfree_reviewer_name_color', true );
			$star_rating               = 'on' === get_post_meta( $post_id, 'tfree_star_rating', true ) ? true : false;
			$star_rating_color         = get_post_meta( $post_id, 'tfree_star_rating_color', true );
			$position                  = 'on' === get_post_meta( $post_id, 'tfree_position', true ) ? true : false;
			$position_color            = get_post_meta( $post_id, 'tfree_position_color', true );

			add_post_meta(
				$post_id, 'sp_tpro_shortcode_options', array(
					'layout'                               => $slider_layout,
					'theme_style'                          => $theme_style,
					'display_testimonials_from'            => $testimonials_from,
					'number_of_total_testimonials'         => $number_of_total_testimonials,
					'testimonial_order_by'                 => $order_by,
					'testimonial_order'                    => $order,
					'number_of_testimonials'               => $number_of_column,
					'number_of_testimonials_desktop'       => $number_of_column_desktop,
					'number_of_testimonials_small_desktop' => $number_of_column_small_desktop,
					'number_of_testimonials_tablet'        => $number_of_column_tablet,
					'number_of_testimonials_mobile'        => $number_of_column_mobile,
					'slider_auto_play'                     => $auto_play,
					'slider_auto_play_speed'               => $auto_play_speed,
					'slider_scroll_speed'                  => $scroll_speed,
					'slider_pause_on_hover'                => $pause_on_hover,
					'slider_infinite'                      => $infinite_loop,
					'navigation'                           => $navigation,
					'navigation_arrow_color'               => $nav_arrow_color,
					'navigation_hover_arrow_color'         => $nav_arrow_hover,
					'pagination'                           => $pagination,
					'pagination_color'                     => $pagination_color,
					'pagination_active_color'              => $pagination_active_color,
					'adaptive_height'                      => $adaptive,
					'slider_swipe'                         => $swipe,
					'slider_draggable'                     => $mouse_draggable,
					'rtl_mode'                             => $rtl,
					'section_title'                        => $section_title,
					'testimonial_title'                    => $testimonial_title,
					'testimonial_text'                     => $testimonial_content,
					'testimonial_client_name'              => $reviewer_name,
					'testimonial_client_rating'            => $star_rating,
					'testimonial_client_rating_color'      => $star_rating_color,
					'client_designation'                   => $position,
					'section_title_typography'             => array(
						'color' => $section_title_color,
					),
					'testimonial_title_typography'         => array(
						'color' => $testimonial_title_color,
					),
					'testimonial_text_typography'          => array(
						'color' => $testimonial_content_color,
					),
					'client_name_typography'               => array(
						'color' => $reviewer_name_color,
					),
					'client_designation_company_typography' => array(
						'color' => $position_color,
					),
				)
			);
		}
	}
}

/**
 * Delete old shortcode meta.
 */
function delete_old_shortcode_meta_2_1_5() {
	delete_post_meta_by_key( 'tfree_slider_layout' );
	delete_post_meta_by_key( 'tfree_themes' );
	delete_post_meta_by_key( 'tfree_testimonials_from' );
	delete_post_meta_by_key( 'tfree_number_of_total_testimonials' );
	delete_post_meta_by_key( 'tfree_number_of_column' );
	delete_post_meta_by_key( 'tfree_number_of_column_desktop' );
	delete_post_meta_by_key( 'tfree_number_of_column_small_desktop' );
	delete_post_meta_by_key( 'tfree_number_of_column_tablet' );
	delete_post_meta_by_key( 'tfree_number_of_column_mobile' );
	delete_post_meta_by_key( 'tfree_order_by' );
	delete_post_meta_by_key( 'tfree_order' );
	delete_post_meta_by_key( 'tfree_auto_play' );
	delete_post_meta_by_key( 'tfree_auto_play_speed' );
	delete_post_meta_by_key( 'tfree_scroll_speed' );
	delete_post_meta_by_key( 'tfree_pause_on_hover' );
	delete_post_meta_by_key( 'tfree_infinite_loop' );
	delete_post_meta_by_key( 'tfree_navigation' );
	delete_post_meta_by_key( 'tfree_nav_arrow_color' );
	delete_post_meta_by_key( 'tfree_nav_arrow_hover' );
	delete_post_meta_by_key( 'tfree_pagination' );
	delete_post_meta_by_key( 'tfree_pagination_color' );
	delete_post_meta_by_key( 'tfree_pagination_active_color' );
	delete_post_meta_by_key( 'tfree_adaptive' );
	delete_post_meta_by_key( 'tfree_swipe' );
	delete_post_meta_by_key( 'tfree_mouse_draggable' );
	delete_post_meta_by_key( 'tfree_rtl' );
	delete_post_meta_by_key( 'tfree_section_title' );
	delete_post_meta_by_key( 'tfree_section_title_color' );
	delete_post_meta_by_key( 'tfree_testimonial_title' );
	delete_post_meta_by_key( 'tfree_testimonial_title_color' );
	delete_post_meta_by_key( 'tfree_testimonial_content' );
	delete_post_meta_by_key( 'tfree_testimonial_content_color' );
	delete_post_meta_by_key( 'tfree_reviewer_name' );
	delete_post_meta_by_key( 'tfree_reviewer_name_color' );
	delete_post_meta_by_key( 'tfree_star_rating' );
	delete_post_meta_by_key( 'tfree_star_rating_color' );
	delete_post_meta_by_key( 'tfree_position' );
	delete_post_meta_by_key( 'tfree_position_color' );
	delete_post_meta_by_key( 'tfree_load_section_title_font' );
	delete_post_meta_by_key( 'tfree_load_testimonial_title_font' );
	delete_post_meta_by_key( 'tfree_load_testimonial_content_font' );
	delete_post_meta_by_key( 'tfree_load_name_font' );
	delete_post_meta_by_key( 'tfree_load_identity_font' );
	delete_post_meta_by_key( 'tfree_load_location_font' );
	delete_post_meta_by_key( 'tfree_load_mobile_font' );
	delete_post_meta_by_key( 'tfree_load_email_font' );
	delete_post_meta_by_key( 'tfree_load_website_font' );
}

covert_old_to_new_shortcode_meta_2_1_5();
delete_old_shortcode_meta_2_1_5();

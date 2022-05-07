<?php
	$slider_pagination             = isset( $shortcode_data['pagination'] ) ? $shortcode_data['pagination'] : 'true';
	$pagination_colors             = isset( $shortcode_data['pagination_colors'] ) ? $shortcode_data['pagination_colors'] : '#cccccc';
	$pagination_color              = isset( $pagination_colors['color'] ) ? $pagination_colors['color'] : '#cccccc';
	$pagination_active_color       = isset( $pagination_colors['active-color'] ) ? $pagination_colors['active-color'] : '#1595ce';
	$slider_navigation             = isset( $shortcode_data['navigation'] ) ? $shortcode_data['navigation'] : 'true';
	$navigation_colors             = isset( $shortcode_data['navigation_color'] ) ? $shortcode_data['navigation_color'] : '';
	$navigation_color              = isset( $navigation_colors['color'] ) ? $navigation_colors['color'] : '';
	$navigation_hover_color        = isset( $navigation_colors['hover-color'] ) ? $navigation_colors['hover-color'] : '';
	$navigation_background         = isset( $navigation_colors['background'] ) ? $navigation_colors['background'] : '';
	$navigation_hover_background   = isset( $navigation_colors['hover-background'] ) ? $navigation_colors['hover-background'] : '';
	$navigation_border             = isset( $shortcode_data['navigation_border'] ) ? $shortcode_data['navigation_border'] : '';
	$navigation_border_size        = isset( $navigation_border['all'] ) ? $navigation_border['all'] : '';
	$navigation_border_style       = isset( $navigation_border['style'] ) ? $navigation_border['style'] : '';
	$navigation_border_color       = isset( $navigation_border['color'] ) ? $navigation_border['color'] : '';
	$navigation_border_hover_color = isset( $navigation_border['hover-color'] ) ? $navigation_border['hover-color'] : '';
	$star_rating                   = isset( $shortcode_data['testimonial_client_rating'] ) ? $shortcode_data['testimonial_client_rating'] : '';
	$star_rating_color             = isset( $shortcode_data['testimonial_client_rating_color'] ) ? $shortcode_data['testimonial_client_rating_color'] : '#f3bb00';
	$reviewer_position             = isset( $shortcode_data['client_designation'] ) ? $shortcode_data['client_designation'] : '';
	// Typography.
	$section_title_color      = isset( $shortcode_data['section_title_typography'] ) ? $shortcode_data['section_title_typography']['color'] : '#444444';
	$testimonial_title_color  = isset( $shortcode_data['testimonial_title_typography'] ) ? $shortcode_data['testimonial_title_typography']['color'] : '#333333';
	$testimonial_text_color   = isset( $shortcode_data['testimonial_text_typography'] ) ? $shortcode_data['testimonial_text_typography']['color'] : '#333333';
	$client_name_color        = isset( $shortcode_data['client_name_typography'] ) ? $shortcode_data['client_name_typography']['color'] : '#333333';
	$client_designation_color = isset( $shortcode_data['client_designation_company_typography'] ) ? $shortcode_data['client_designation_company_typography']['color'] : '#444444';

	$section_title         = isset( $shortcode_data['section_title'] ) ? $shortcode_data['section_title'] : '';
	$testimonial_title     = isset( $shortcode_data['testimonial_title'] ) ? $shortcode_data['testimonial_title'] : '';
	$testimonial_title_tag = isset( $shortcode_data['testimonial_title_tag'] ) ? $shortcode_data['testimonial_title_tag'] : 'h3';
	$testimonial_text      = isset( $shortcode_data['testimonial_text'] ) ? $shortcode_data['testimonial_text'] : '';
	$reviewer_name         = isset( $shortcode_data['testimonial_client_name'] ) ? $shortcode_data['testimonial_client_name'] : '';

// Style.

$outline .= '#sp-testimonial-free-wrapper-' . $post_id . ' .sp-testimonial-free-section .slick-dots li button{
	background: ' . $pagination_color . ';
}
#sp-testimonial-free-wrapper-' . $post_id . ' .sp-testimonial-free-section .slick-dots li.slick-active button{
	background: ' . $pagination_active_color . ';
}
#sp-testimonial-free-wrapper-' . $post_id . ' .sp-testimonial-free-section .slick-prev,
#sp-testimonial-free-wrapper-' . $post_id . ' .sp-testimonial-free-section .slick-next{
	background: ' . $navigation_background . ';
	border: ' . $navigation_border_size . 'px ' . $navigation_border_style . ' ' . $navigation_border_color . ';
	color: ' . $navigation_color . ';
}
#sp-testimonial-free-wrapper-' . $post_id . ' .sp-testimonial-free-section .slick-prev:hover,
#sp-testimonial-free-wrapper-' . $post_id . ' .sp-testimonial-free-section .slick-next:hover{
	background: ' . $navigation_hover_background . ';
	border-color: ' . $navigation_border_hover_color . ';
	color: ' . $navigation_hover_color . ';
}
';
if ( 'true' === $slider_navigation || 'hide_on_mobile' === $slider_navigation ) {
	$outline .= '#sp-testimonial-free-wrapper-' . $post_id . ' .sp-testimonial-free-section{
		padding: 0 50px;
	}';
}
if ( 'hide_on_mobile' === $slider_navigation ) {
	$outline .= '@media only screen and (max-width: 425px){
		#sp-testimonial-free-wrapper-' . $post_id . ' .sp-testimonial-free-section{
			padding: 0 0;
		}
	}';
}

if ( $star_rating ) {
	$outline .= '#sp-testimonial-free-wrapper-' . $post_id . ' .sp-testimonial-free-section .sp-testimonial-client-rating{
		color: ' . $star_rating_color . ';
	}';
}
if ( $reviewer_position ) {
	$outline .= '#sp-testimonial-free-wrapper-' . $post_id . ' .sp-testimonial-free-section .sp-testimonial-client-designation{
		color: ' . $client_designation_color . ';
	}';
}
if ( $reviewer_name ) {
	$outline .= '#sp-testimonial-free-wrapper-' . $post_id . ' .sp-testimonial-free-section .sp-testimonial-client-name{
		color: ' . $client_name_color . ';
	}';
}
if ( $testimonial_text ) {
	$outline .= '#sp-testimonial-free-wrapper-' . $post_id . ' .sp-testimonial-free-section .sp-testimonial-client-testimonial{
		color: ' . $testimonial_text_color . ';
	}';
}
if ( $testimonial_title ) {
	$outline .= '#sp-testimonial-free-wrapper-' . $post_id . ' .sp-testimonial-free-section .sp-testimonial-title{
		color: ' . $testimonial_title_color . ';
	}';
}
if ( $section_title ) {
	$outline .= '#sp-testimonial-free-wrapper-' . $post_id . ' .sp-testimonial-free-section-title{
		color: ' . $section_title_color . ';
	}';
}


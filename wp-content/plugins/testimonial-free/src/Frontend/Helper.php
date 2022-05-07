<?php

/**
 * The Helper class to manage all public-facing functionality of the plugin.
 *
 * @package    testimonial_free
 * @subpackage testimonial_free/Frontend
 * @author     ShapedPlugin <support@shapedplugin.com>
 */

namespace ShapedPlugin\TestimonialFree\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Real Testimonials - helper class
 *
 * @since 2.0
 */
class Helper {
	/**
	 * Full Output show for frontend.
	 *
	 * @param array $post_id Shortcode ID.
	 * @param array $setting_options get all layout options.
	 * @param array $shortcode_data get all meta options.
	 * @param mixed $main_section_title section title.
	 * @return void
	 */
	public static function sp_testimonial_html_show( $post_id, $setting_options, $shortcode_data, $main_section_title ) {
		$theme_style           = isset( $shortcode_data['theme_style'] ) ? $shortcode_data['theme_style'] : 'theme-one';
		$columns               = isset( $shortcode_data['columns'] ) ? $shortcode_data['columns'] : '';
		$columns_large_desktop = isset( $columns['large_desktop'] ) ? $columns['large_desktop'] : '1';
		$columns_desktop       = isset( $columns['desktop'] ) ? $columns['desktop'] : '1';
		$columns_laptop        = isset( $columns['laptop'] ) ? $columns['laptop'] : '1';
		$columns_tablet        = isset( $columns['tablet'] ) ? $columns['tablet'] : '1';
		$columns_mobile        = isset( $columns['mobile'] ) ? $columns['mobile'] : '1';

		// Slider Settings.
		$slider_auto_play = isset( $shortcode_data['slider_auto_play'] ) ? $shortcode_data['slider_auto_play'] : 'true';
		switch ( $slider_auto_play ) {
			case 'true':
				$auto_play        = 'true';
				$auto_play_mobile = 'true';
				break;
			case 'off_on_mobile':
				$auto_play        = 'true';
				$auto_play_mobile = 'false';
				break;
			case 'false':
				$auto_play        = 'false';
				$auto_play_mobile = 'false';
				break;
		}
		$slider_auto_play_speed = isset( $shortcode_data['slider_auto_play_speed'] ) ? $shortcode_data['slider_auto_play_speed'] : '3000';
		$slider_scroll_speed    = isset( $shortcode_data['slider_scroll_speed'] ) ? $shortcode_data['slider_scroll_speed'] : '600';
		$slider_pause_on_hover  = isset( $shortcode_data['slider_pause_on_hover'] ) && $shortcode_data['slider_pause_on_hover'] ? 'true' : 'false';
		$slider_infinite        = isset( $shortcode_data['slider_infinite'] ) && $shortcode_data['slider_infinite'] ? 'true' : 'false';
		$slider_navigation      = isset( $shortcode_data['navigation'] ) ? $shortcode_data['navigation'] : 'true';

		switch ( $slider_navigation ) {
			case 'true':
				$navigation        = 'true';
				$navigation_mobile = 'true';
				break;
			case 'hide_on_mobile':
				$navigation        = 'true';
				$navigation_mobile = 'false';
				break;
			case 'false':
				$navigation        = 'false';
				$navigation_mobile = 'false';
				break;
		}
		$slider_pagination = isset( $shortcode_data['pagination'] ) ? $shortcode_data['pagination'] : 'true';
		switch ( $slider_pagination ) {
			case 'true':
				$pagination        = 'true';
				$pagination_mobile = 'true';
				break;
			case 'hide_on_mobile':
				$pagination        = 'true';
				$pagination_mobile = 'false';
				break;
			case 'false':
				$pagination        = 'false';
				$pagination_mobile = 'false';
				break;
		}
		$adaptive_height  = isset( $shortcode_data['adaptive_height'] ) && $shortcode_data['adaptive_height'] ? 'true' : 'false';
		$slider_swipe     = isset( $shortcode_data['slider_swipe'] ) && $shortcode_data['slider_swipe'] ? 'true' : 'false';
		$swipe_to_slide   = isset( $shortcode_data['swipe_to_slide'] ) && $shortcode_data['swipe_to_slide'] ? 'true' : 'false';
		$slider_draggable = isset( $shortcode_data['slider_draggable'] ) && $shortcode_data['slider_draggable'] ? 'true' : 'false';
		$slider_direction = isset( $shortcode_data['slider_direction'] ) ? $shortcode_data['slider_direction'] : 'ltr';
		$rtl_mode         = ( 'rtl' === $slider_direction ) ? 'true' : 'false';

		$section_title = isset( $shortcode_data['section_title'] ) ? $shortcode_data['section_title'] : '';
		// Preloader.
		$preloader = isset( $shortcode_data['preloader'] ) ? $shortcode_data['preloader'] : false;
		// Schema markup.
		if ( isset( $shortcode_data['schema_markup'] ) ) {
			$show_schema_markup = $shortcode_data['schema_markup'];
		} else {
			$show_schema_markup = isset( $setting_options['spt_enable_schema'] ) ? $setting_options['spt_enable_schema'] : false;
		}

		// Enqueue Script.
		$dequeue_slick_js = isset( $setting_options['tf_dequeue_slick_js'] ) ? $setting_options['tf_dequeue_slick_js'] : true;
		if ( $dequeue_slick_js ) {
			wp_enqueue_script( 'tfree-slick-min-js' );
		}
		wp_enqueue_script( 'tfree-slick-active' );
		$slider_attr = 'data-slick=\'{"dots": ' . esc_attr( $pagination ) . ', "adaptiveHeight": ' . esc_attr( $adaptive_height ) . ', "pauseOnHover": ' . esc_attr( $slider_pause_on_hover ) . ', "slidesToShow": ' . esc_attr( $columns_large_desktop ) . ', "speed": ' . esc_attr( $slider_scroll_speed ) . ', "arrows": ' . esc_attr( $navigation ) . ', "autoplay": ' . esc_attr( $auto_play ) . ', "autoplaySpeed": ' . esc_attr( $slider_auto_play_speed ) . ', "swipe": ' . esc_attr( $slider_swipe ) . ', "swipeToSlide": ' . esc_attr( $swipe_to_slide ) . ', "draggable": ' . esc_attr( $slider_draggable ) . ', "rtl": ' . esc_attr( $rtl_mode ) . ', "infinite": ' . esc_attr( $slider_infinite ) . ', "responsive": [{"breakpoint": 1280, "settings": { "slidesToShow": ' . esc_attr( $columns_desktop ) . ' }},{"breakpoint": 980, "settings": { "slidesToShow": ' . esc_attr( $columns_laptop ) . ' }},{"breakpoint": 736, "settings": { "slidesToShow": ' . esc_attr( $columns_tablet ) . ' }},{"breakpoint": 480, "settings": {"slidesToShow": ' . esc_attr( $columns_mobile ) . ',"dots": ' . esc_attr( $pagination_mobile ) . ',"arrows": ' . esc_attr( $navigation_mobile ) . ',"autoplay": ' . esc_attr( $auto_play_mobile ) . '}}] }\'';

		$outline           = '';
		$post_query        = self::testimonial_query( $shortcode_data, $post_id );
		$testimonial_items = self::testimonial_items( $post_query, $shortcode_data, $post_id );
		$sc_title          = get_the_title( $post_id ) ? get_the_title( $post_id ) : 'Testimonial';
		include self::sp_testimonial_locate_template( 'slider.php' );
		if ( $show_schema_markup ) {
			ob_start();
			self::testimonials_schema( $post_query, $sc_title, $testimonial_items['aggregate_rating'], $testimonial_items['schema_html'], $testimonial_items['total_testimonial'] );
			echo ob_get_clean();
		}
	}

	/**
	 * Testimonial Query
	 *
	 * @param  array $shortcode_data shortcode options.
	 * @param  int   $post_id shortcode id.
	 * @return object
	 */
	public static function testimonial_query( $shortcode_data, $post_id ) {
		$number_of_total_testimonials = isset( $shortcode_data['number_of_total_testimonials'] ) ? $shortcode_data['number_of_total_testimonials'] : '10';
		$order_by                     = isset( $shortcode_data['testimonial_order_by'] ) ? $shortcode_data['testimonial_order_by'] : 'date';
		$order                        = isset( $shortcode_data['testimonial_order'] ) ? $shortcode_data['testimonial_order'] : 'DESC';
		$args                         = array(
			'post_type'      => 'spt_testimonial',
			'orderby'        => $order_by,
			'order'          => $order,
			'posts_per_page' => empty( $number_of_total_testimonials ) ? '10000' : $number_of_total_testimonials,
		);
		$args                         = apply_filters( 'spt_testimonial_pro_query_args', $args, $post_id );
		$post_query                   = new \WP_Query( $args );
		return $post_query;
	}

	/**
	 * Testimonial items
	 *
	 * @param object $post_query Query.
	 * @param array  $shortcode_data options.
	 * @param array  $post_id post id.
	 * @return array
	 */
	public static function testimonial_items( $post_query, $shortcode_data, $post_id ) {
		$theme_style           = isset( $shortcode_data['theme_style'] ) ? $shortcode_data['theme_style'] : 'theme-one';
		$show_schema_markup    = isset( $shortcode_data['schema_markup'] ) ? $shortcode_data['schema_markup'] : false;
		$testimonial_title     = isset( $shortcode_data['testimonial_title'] ) ? $shortcode_data['testimonial_title'] : '';
		$testimonial_text      = isset( $shortcode_data['testimonial_text'] ) ? $shortcode_data['testimonial_text'] : '';
		$reviewer_name         = isset( $shortcode_data['testimonial_client_name'] ) ? $shortcode_data['testimonial_client_name'] : '';
		$star_rating           = isset( $shortcode_data['testimonial_client_rating'] ) ? $shortcode_data['testimonial_client_rating'] : '';
		$reviewer_position     = isset( $shortcode_data['client_designation'] ) ? $shortcode_data['client_designation'] : '';
		$testimonial_title_tag = isset( $shortcode_data['testimonial_title_tag'] ) ? $shortcode_data['testimonial_title_tag'] : 'h3';
		$reviewer_name_tag     = ( isset( $shortcode_data['testimonial_name_tag'] ) && $shortcode_data['testimonial_name_tag'] ) ? $shortcode_data['testimonial_name_tag'] : 'h4';

		// Image Settings.
		$client_image = isset( $shortcode_data['client_image'] ) ? $shortcode_data['client_image'] : true;
		$image_sizes  = isset( $shortcode_data['image_sizes'] ) ? $shortcode_data['image_sizes'] : 'tf-client-image-size';
		ob_start();
		$tpro_total_rating = 0;
		$testimonial_count = 0;
		$total_posts       = $post_query->found_posts;
		$schema_html       = '';
		if ( $post_query->have_posts() ) {
			while ( $post_query->have_posts() ) :
				$post_query->the_post();
				$testimonial_data  = get_post_meta( get_the_ID(), 'sp_tpro_meta_options', true );
				$tfree_designation = ( isset( $testimonial_data['tpro_designation'] ) ? $testimonial_data['tpro_designation'] : '' );
				$tfree_name        = ( isset( $testimonial_data['tpro_name'] ) ? $testimonial_data['tpro_name'] : '' );
				$tfree_rating_star = ( isset( $testimonial_data['tpro_rating'] ) ? $testimonial_data['tpro_rating'] : '' );
				if ( 'theme-one' === $theme_style ) {
					include self::sp_testimonial_locate_template( 'theme/theme-one.php' );
				}
				if ( $show_schema_markup ) {
					$testimonial_data  = get_post_meta( get_the_ID(), 'sp_tpro_meta_options', true );
					$tfree_name        = ( isset( $testimonial_data['tpro_name'] ) ? $testimonial_data['tpro_name'] : '' );
					$tfree_rating_star = ( isset( $testimonial_data['tpro_rating'] ) ? $testimonial_data['tpro_rating'] : 'five_star' );
					$rating_value      = '0';
					switch ( $tfree_rating_star ) {
						case 'five_star':
							$rating_value = '5';
							break;
						case 'four_star':
							$rating_value = '4';
							break;
						case 'three_star':
							$rating_value = '3';
							break;
						case 'two_star':
							$rating_value = '2';
							break;
						case 'one_star':
							$rating_value = '1';
							break;
					}
					$tpro_total_rating += (int) $rating_value;
					$name               = get_the_title() ? esc_attr( wp_strip_all_tags( get_the_title() ) ) : '';
					$review_body        = get_the_content() ? esc_attr( wp_strip_all_tags( get_the_content() ) ) : '';
					$date               = get_the_date( 'F j, Y' );
					$schema_html       .= '{
					"@type": "Review",
					"datePublished": "' . $date . '",
					"name": "' . $name . '",
					"reviewBody": "' . $review_body . '",
					"reviewRating": {
						"@type": "Rating",
						"bestRating": "5",
						"ratingValue": "' . $rating_value . '",
						"worstRating": "1"
					},
					"author": {
						"@type": "Person", 
						"name": "' . $tfree_name . '"
					}
					}';
					if ( ++$testimonial_count !== $total_posts ) {
						$schema_html .= ',';
					}
				}
				$aggregate_rating = 5;
				if ( $show_schema_markup ) {
					$aggregate_rating = round( ( $tpro_total_rating / $testimonial_count ), 2 );
				}
			endwhile;
		} else {
			echo '<h2 class="sp-not-testimonial-found">' . esc_html__( 'No testimonials found', 'testimonial-free' ) . '</h2>';
		}
		wp_reset_postdata();
		$outline = ob_get_clean();

		return array(
			'output'            => $outline,
			'aggregate_rating'  => $aggregate_rating,
			'schema_html'       => $schema_html,
			'total_testimonial' => $total_posts,
		);
	}

	/**
	 * Item schema markup
	 *
	 * @param  object $post_query query.
	 * @param  string $global_item_name Global item name.
	 * @param  string $aggregate_rating ratting.
	 * @param  string $schema_html schema HTML.
	 * @param  int    $total_posts  total post.
	 * @return void
	 */
	public static function testimonials_schema( $post_query, $global_item_name, $aggregate_rating, $schema_html, $total_posts ) {
		$outline = '';
		if ( $post_query->have_posts() ) {
			$outline .= '<script type="application/ld+json">
		{
			"@context": "http://schema.org",
			"@type": "Product",
			"name": "' . $global_item_name . '",
			"aggregateRating": {
				"@type": "AggregateRating",
				"bestRating": "5",
				"ratingValue": "' . $aggregate_rating . '",
				"worstRating": "1",
				"reviewCount": "' . $total_posts . '"
			},
			"review": [';
			$outline .= $schema_html;
			$outline .= ']
		}
		</script>';
		}
		echo $outline;
	}

	/**
	 * Minify output
	 *
	 * @param  statement $html output.
	 * @return statement
	 */
	public static function minify_output( $html ) {
		$html = preg_replace( '/<!--(?!s*(?:[if [^]]+]|!|>))(?:(?!-->).)*-->/s', '', $html );
		$html = str_replace( array( "\r\n", "\r", "\n", "\t" ), '', $html );
		while ( stristr( $html, '  ' ) ) {
			$html = str_replace( '  ', ' ', $html );
		}
		return $html;
	}

	/**
	 * Custom Template locator.
	 *
	 * @param  mixed $template_name template name.
	 * @param  mixed $template_path template path.
	 * @param  mixed $default_path default path.
	 * @return string
	 */
	public static function sp_testimonial_locate_template( $template_name, $template_path = '', $default_path = '' ) {
		if ( ! $template_path ) {
			$template_path = 'testimonial-free/templates';
		}
		if ( ! $default_path ) {
			$default_path = SP_TFREE_PATH . 'Frontend/Views/templates/';
		}
		$template = locate_template( trailingslashit( $template_path ) . $template_name );
		// Get default template.
		if ( ! $template ) {
			$template = $default_path . $template_name;
		}
		// Return what we found.
		return $template;
	}
}


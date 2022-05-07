<?php
/**
 * Old shortcode file.
 *
 * @link http://shapedplugin.com
 * @since 2.0.0
 *
 * @package Testimonial_free.
 * @subpackage Testimonial_free/includes.
 */

namespace ShapedPlugin\TestimonialFree\Frontend\Views;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.

/**
 * Class of Deprecated Shortcodes.
 */
class Deprecated_Shortcodes {
	/**
	 * Initialize the class
	 */
	public function __construct() {
		add_shortcode( 'testimonial-free', array( $this, 'sp_testimonial_free_shortcode' ) );
	}

	/**
	 * Real Testimonials Free shortcode.
	 *
	 * @param array $atts shortcode attributes.
	 */
	public function sp_testimonial_free_shortcode( $atts ) {
		// phpcs:ignore
		extract(
			shortcode_atts(
				array(
					'color'      => '#1595ce',
					'nav'        => 'true',
					'pagination' => 'true',
					'autoplay'   => 'true',
				),
				$atts,
				'testimonial-free'
			)
		);

		$args = array(
			'post_type'      => 'spt_testimonial',
			'orderby'        => 'date',
			'order'          => 'DESC',
			'posts_per_page' => -1,
		);

		$que = new \WP_Query( $args );

		$custom_id = uniqid();

		wp_enqueue_script( 'tfree-slick-min-js' );

		$outline = '';

		$outline .= '
    <script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#sp-testimonial-free' . $custom_id . '").slick({
			slidesToScroll: 1,
			arrows: ' . $nav . ',
			prevArrow: "<div class=\'slick-prev\'><i class=\'fa fa-angle-left\'></i></div>",
            nextArrow: "<div class=\'slick-next\'><i class=\'fa fa-angle-right\'></i></div>",
			dots: ' . $pagination . ',
			autoplay: ' . $autoplay . ',
			pauseOnHover: false,
		});

    });
    </script>';
		if ( 'false' === $nav ) {
			echo "<style type='text/css'>
				.sp-testimonial-section .testimonial-free{
					margin: 0;
				}
				.sp-testimonial-section .owl-controls .owl-buttons div:hover{
					color: #000;
				}
				</style>";
		}

		$outline .= '<style type="text/css">
				#sp-testimonial-free' . $custom_id . '.sp-testimonial-section .slick-prev:hover,
				#sp-testimonial-free' . $custom_id . '.sp-testimonial-section .slick-next:hover{
					color: ' . $color . ';
				}
				#sp-testimonial-free' . $custom_id . '.sp-testimonial-section .slick-dots li.slick-active button{
					background: ' . $color . ';
				}
				</style>';

		$outline .= '<div id="sp-testimonial-free' . $custom_id . '" class="sp-testimonial-section">';
		if ( $que->have_posts() ) {
			while ( $que->have_posts() ) :
				$que->the_post();

				$tf_designation = esc_html( get_post_meta( get_the_ID(), 'tf_designation', true ) );

				$testimonial_data = get_post_meta( get_the_ID(), 'sp_tpro_meta_options', true );

				$outline .= '<div class="testimonial-free text-center">';
				if ( has_post_thumbnail( $que->post->ID ) ) {
					$outline .= '<div class="tf-client-image">';
					$outline .= get_the_post_thumbnail( $que->post->ID, 'tf-client-image-size', array( 'class' => 'tf-client-img' ) );
					$outline .= '</div>';
				}
				$outline .= '<div class="tf-client-testimonial">';
				$outline .= apply_filters( 'the_content', get_the_content() );
				$outline .= '</div>';
				$outline .= '<h2 class="tf-client-name">';
				if ( isset( $testimonial_data['tpro_name'] ) && '' !== $testimonial_data['tpro_name'] ) {
					$outline .= $testimonial_data['tpro_name'];
				} else {
					$outline .= get_the_title();
				}
				$outline .= '</h2>';
				if ( isset( $testimonial_data['tpro_designation'] ) || $tf_designation ) {
					$outline .= '<h6 class="tf-client-designation">';
					if ( isset( $tf_designation ) && '' !== $tf_designation ) {
						$outline .= $tf_designation;
					} elseif ( isset( $testimonial_data['tpro_designation'] ) ) {
						$outline .= $testimonial_data['tpro_designation'];
					}

					$outline .= '</h6>';
				}

				$outline .= '</div>'; // testimonial free.

			endwhile;
		} else {
			$outline .= '<h2 class="sp-not-found-any-testimonial">' . esc_html__( 'No testimonials found', 'testimonial-free' ) . '</h2>';
		}
		$outline .= '</div>';

		wp_reset_postdata();

		return $outline;

	}
}




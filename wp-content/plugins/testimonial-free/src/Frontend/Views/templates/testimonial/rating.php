<?php
/**
 * Client rating.
 *
 * This template can be overridden by copying it to your theme/testimonial-free/templates/testimonial/rating.php
 *
 * @package    Testimonial_Free
 * @subpackage Testimonial_Free/Frontend
 */

$full_star_icon  = '<i class="fa fa-star" aria-hidden="true"></i>';
$empty_star_icon = '<i class="fa fa-star-o" aria-hidden="true"></i>';
$full_star_icon  = apply_filters( 'testimonial_client_rating_full_star_icon', $full_star_icon, get_the_ID() );
$empty_star_icon = apply_filters( 'testimonial_client_rating_empty_star_icon', $empty_star_icon, get_the_ID() );
switch ( $tfree_rating_star ) {
	case 'five_star':
		$star_rating_data = sprintf( '%1$s%1$s%1$s%1$s%1$s', $full_star_icon );
		break;
	case 'four_star':
		$star_rating_data = sprintf( '%1$s%1$s%1$s%1$s%2$s', $full_star_icon, $empty_star_icon );
		break;
	case 'three_star':
		$star_rating_data = sprintf( '%1$s%1$s%1$s%2$s%2$s', $full_star_icon, $empty_star_icon );
		break;
	case 'two_star':
		$star_rating_data = sprintf( '%1$s%1$s%2$s%2$s%2$s', $full_star_icon, $empty_star_icon );
		break;
	case 'one_star':
		$star_rating_data = sprintf( '%1$s%2$s%2$s%2$s%2$s', $full_star_icon, $empty_star_icon );
		break;
}
?>
<div class="sp-testimonial-client-rating">
<?php
do_action( 'sptpro_before_testimonial_client_rating' );
echo wp_kses_post( $star_rating_data );
do_action( 'sptpro_after_testimonial_client_rating' );
?>
</div>


<?php
/**
 * Theme One
 *
 * This template can be overridden by copying it to your theme/testimonial-free/templates/theme/theme-one.php
 *
 * @package Testimonial
 */

?>
<div class="sp-testimonial-item">
<div class="sp-testimonial-free">
<?php
if ( $client_image && has_post_thumbnail( $post_query->post->ID ) ) {
	include self::sp_testimonial_locate_template( 'testimonial/thumbnail.php' );
}
if ( $testimonial_title && ! empty( get_the_title() ) ) {
	include self::sp_testimonial_locate_template( 'testimonial/title.php' );
}
if ( $testimonial_text && ! empty( get_the_content() ) ) {
	include self::sp_testimonial_locate_template( 'testimonial/content.php' );
}
if ( $reviewer_name && ! empty( $tfree_name ) ) {
	include self::sp_testimonial_locate_template( 'testimonial/client-name.php' );
}
if ( $star_rating && ! empty( $tfree_rating_star ) ) {
	include self::sp_testimonial_locate_template( 'testimonial/rating.php' );
}
if ( $reviewer_position && ! empty( $tfree_designation ) ) {
	include self::sp_testimonial_locate_template( 'testimonial/designation.php' );
}
?>
</div> <!-- sp-testimonial-free. -->
</div> <!--sp-testimonial-item.-->


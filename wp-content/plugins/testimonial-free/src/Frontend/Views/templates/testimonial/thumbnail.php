<?php
/**
 * Client thumbnails.
 *
 * This template can be overridden by copying it to your theme/testimonial-free/templates/testimonial/thumbnail.php
 *
 * @package    Testimonial_Free
 * @subpackage Testimonial_Free/Frontend
 */

$image = get_the_post_thumbnail( $post_query->post->ID, $image_sizes, array( 'class' => 'tfree-client-image' ) );
?>

	<div class="sp-testimonial-client-image">
	<?php
	do_action( 'sptpro_before_testimonial_client_image' );
		echo wp_kses_post( $image );
	do_action( 'sptpro_after_testimonial_client_image' );
	?>
	</div>

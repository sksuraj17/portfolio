<?php
/**
 * Testimonial title.
 *
 * This template can be overridden by copying it to your theme/testimonial-free/templates/testimonial/title.php
 *
 * @package    Testimonial_Free
 * @subpackage Testimonial_Free/Frontend
 */

?>
<div class="sp-testimonial-title">
	<?php do_action( 'sptpro_before_testimonial_title' ); ?>
	<<?php echo esc_attr( $testimonial_title_tag ); ?> class="sp-testimonial-post-title">
		<?php echo wp_kses_post( get_the_title() ); ?>
	</<?php echo esc_attr( $testimonial_title_tag ); ?>>
	<?php do_action( 'sptpro_after_testimonial_title' ); ?>
</div>


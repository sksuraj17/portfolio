<?php
/**
 * Preloader.
 *
 * This template can be overridden by copying it to your theme/testimonial-free/templates/preloader.php
 *
 * @package    Testimonial_Free
 * @subpackage Testimonial_Free/Frontend
 */

$preloader_style = ( $preloader ) ? '' : 'display: none;';
$preloader_image = SP_TFREE_URL . 'Frontend/assets/img/spinner.svg';
$preloader_image = apply_filters( 'sp_testimonial_pro_preloader_image', $preloader_image );
?>
<div class="sp-testimonial-preloader" id="sp-testimonial-preloader-<?php echo esc_attr( $post_id ); ?>" style="<?php echo esc_attr( $preloader_style ); ?>">
	<img src="<?php echo esc_url( $preloader_image ); ?>" alt="preloader-image"/>
</div>

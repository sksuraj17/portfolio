<?php
/**
 * The WooCommerce template file
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#woocommerce
 * @package ThemeHunk
 * @subpackage Portfoliolite
 * @since 1.0.0
 */
if ( ! class_exists( 'WooCommerce' ) ){
    return;
}
get_header();
$layout = '';
$value = '';
if((is_product()) || is_product_category()){
     $layout = 'no-sidebar';
}
if(is_shop()){
	 $shop_page_id = get_option( 'woocommerce_shop_page_id' );
	 $layout = get_post_meta( $shop_page_id, 'th_sidebar_dyn', true );
}
?>
<div id="page" class="clearfix <?php echo esc_attr($value); ?>">
<div class="content-wrapper">
<div class="content">
<div class="page-content">
					<main id="main" class="site-main" role="main">
						<?php woocommerce_content(); ?>
					</main>
				</div> <!-- primary End -->
				         
	 		</div> <!-- content End -->	
  		</div> <!-- content-wrapper End -->
  		<?php
				         if( $layout != 'no-sidebar' ){?>
				         	<div class="sidebar-wrapper">
				             <?php get_sidebar();?>
				         </div>
				           <?php }
				         ?>
	</div><!-- thunk-content-wrap -->
<?php get_footer();?>
</div><!-- #page -->
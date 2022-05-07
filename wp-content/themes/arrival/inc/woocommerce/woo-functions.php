<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Arrival
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function arrival_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'arrival_woocommerce_setup' );

/**
* Remove default woocommerce hooks
*/
remove_action( 'woocommerce_sidebar',             'woocommerce_get_sidebar',                  10 );
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
remove_action('woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart',10);
remove_action( 'woocommerce_before_shop_loop_item_title','woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title','woocommerce_template_loop_product_thumbnail', 10 );
add_action ( 'woocommerce_before_shop_loop_item_title', 'arrival_product_thumb_wrapp',10);
add_action( 'woocommerce_after_main_content', 'arrival_woo_sidebar_wrapp', 10 );



/**
* Disable woocommerce shop page title
*/
add_filter('woocommerce_show_page_title','__return_false');


add_action('woocommerce_before_shop_loop','arrival_woo_shop_header_wrapp_start',9);
if( ! function_exists('arrival_woo_shop_header_wrapp_start')):
	function arrival_woo_shop_header_wrapp_start(){ ?>
		<div class="arrival-shop-header-wrapp clearfix">
<?php 
	}
endif;


add_action('woocommerce_before_shop_loop','arrival_woo_shop_header_wrapp_end',31);
if( ! function_exists('arrival_woo_shop_header_wrapp_end')):
	function arrival_woo_shop_header_wrapp_end(){ ?>
	</div>
<?php 
	}
endif;

/**
* Cart Icon
*
* @since 1.2.5
*/
add_action('arrival_cart_icon_disp','arrival_cart_icon_disp');

if( ! function_exists('arrival_cart_icon_disp')){
  function arrival_cart_icon_disp(){
    echo arrival_get_icon_svg('cart');
  }
}

/**
* Cart counter
*
*/
if (! function_exists('arrival_header_cart_counter')){
  function arrival_header_cart_counter(){ ?>

    <a class="cart-contentsone" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'arrival' ); ?>">
         <?php do_action('arrival_cart_icon_disp'); ?>
         <span class="cart-count"><?php echo wp_kses_data( sprintf(  WC()->cart->get_cart_contents_count() ) ); ?></span>
    </a>
  <?php 
  }
}

/**
* Header Shopping Cart function 
*/
if ( ! function_exists( 'arrival_header_cart' ) ) {
   function arrival_header_cart(){ 
   
    if ( is_cart() ) {
      $class = 'current-menu-item';
    } else {
      $class = '';
    }
    ?>
    <ul class="site-header-cart">
      <li class="<?php echo esc_attr( $class ); ?> avl-cart">
        <?php arrival_header_cart_counter(); ?>
        <?php do_action('arrival_header_cart_text'); // header cart text ?>
      </li>
      <?php if( ! wp_is_mobile() ){ ?>
        <li class="cart-itm">
          <?php
          $instance = array(
            'title' => '',
          );

          the_widget( 'WC_Widget_Cart', $instance );
          ?>
        </li> 
      <?php } ?>
      
    </ul>
    <?php  
     
  
   }
}

if ( ! function_exists( 'arrival_cart_fragments' ) ) {

    function arrival_cart_fragments( $fragments ) {
        global $woocommerce;
        ob_start();
        arrival_header_cart_counter();
        $fragments['a.cart-contentsone'] = ob_get_clean();
        return $fragments;
    }
}
add_filter( 'woocommerce_add_to_cart_fragments', 'arrival_cart_fragments' );


/*******************************************************************************************************/
/**
*  Add the Link to Quick View Function
**/
if( ! function_exists('arrival_quickview') ){

  function arrival_quickview(){
    if( ! defined( 'YITH_WCQV' ) )
      return;

    global $product;
    $quick_view = YITH_WCQV_Frontend();
    $icon = arrival_get_icon_svg('eye');
    remove_action( 'woocommerce_after_shop_loop_item', array( $quick_view, 'yith_add_quick_view_button' ), 15 );
    $label = esc_html( get_option( 'yith-wcqv-button-label' ) );
    echo '<a href="#" class="button link-quickview yith-wcqv-button" data-product_id="' . get_the_ID() . '"><span>' . $label .'</span>'. $icon. '</a>';
  }
}


/*******************************************************************************************************/
/**
 ** Product Wishlist Button Function
**/
if( ! function_exists('arrival_wishlist_products') ){
  function arrival_wishlist_products() { 

    if ( ! defined( 'YITH_WCWL' ) )      
      return;

    global $product;
    $url = add_query_arg( 'add_to_wishlist', get_the_ID() );
    $id = get_the_ID();
    $wishlist_url = YITH_WCWL()->get_wishlist_url(); ?> 

      <div class="add-to-wishlist-custom add-to-wishlist-<?php echo esc_attr( $id ); ?>">
          
          <div class="yith-wcwl-add-button show" style="display:block">
            <a href="<?php echo esc_url( $url ); ?>" data-toggle="tooltip" data-placement="top" rel="nofollow" data-product-id="<?php echo esc_attr( $id ); ?>" data-product-type="simple" title="<?php esc_attr_e( 'Add to Wishlist', 'arrival' ); ?>" class="add_to_wishlist link-wishlist">
                    <span>
                    <?php esc_html_e( 'Add To Wishlist', 'arrival' ); ?>
                    </span>
                    <?php echo arrival_get_icon_svg('heart',19); ?>
            </a>
            <img src="<?php echo esc_url(get_template_directory_uri()) . '/assets/images/loading.gif'; ?>" class="ajax-loading" alt="<?php esc_attr_e('loading','arrival')?>" width="16" height="16">

          </div>          

          <div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;">
            <a class="link-wishlist" href="<?php echo esc_url( $wishlist_url ); ?>">
                    <span>
                    <?php esc_html_e( 'View Wishlist', 'arrival' ); ?>
                    </span>
                     <?php echo arrival_get_icon_svg('heart',19); ?>
                    </a>
          </div>

          <div class="yith-wcwl-wishlistexistsbrowse hide" style="display:none">
            <a  class="link-wishlist" href="<?php echo esc_url( $wishlist_url ); ?>">
                    <span>
                    <?php _e( 'Browse Wishlist', 'arrival' ); ?>
                    </span>
                     <?php echo arrival_get_icon_svg('heart',19); ?>
                </a>
          </div>

          <div class="clear"></div>
          <div class="yith-wcwl-wishlistaddresponse"></div>

      </div>
  <?php
  }
}


/*******************************************************************************************************/
//Compare URL
if(!function_exists('arrival_compare_url')){
    function arrival_compare_url($id = false){
        $html = '';
        $icon = arrival_get_icon_svg('compare',19);
        if(class_exists('YITH_Woocompare')){
            if(!$id) $id = get_the_ID();
            $cp_link = str_replace('&', '&amp;',add_query_arg( array('action' => 'yith-woocompare-add-product','id' => $id )));
            $html = '<div class="compare-wrap"> <a href="'.esc_url($cp_link).'" class="arrival-compare product-compare compare compare-link " data-product_id="'.get_the_ID().'"><span>'.esc_html__('Compare','arrival').'</span>'.$icon.'</a></div>';
        }
        return $html;
    }
}

/*******************************************************************************************************/

/**
* Cart button wrapper
*/
//add_action('woocommerce_after_shop_loop_item','arrival_cart_buttons_wrapp',11);
if( ! function_exists('arrival_cart_buttons_wrapp')){
  function arrival_cart_buttons_wrapp(){
    ?>
    <div class="arrival-cart-wrapper">
      <?php 
        woocommerce_template_loop_add_to_cart();
        arrival_quickview();
        arrival_wishlist_products();
        echo arrival_compare_url();
      ?>
    </div>
    <?php 
  }
}

if( ! function_exists('arrival_product_thumb_wrapp') ){
  function arrival_product_thumb_wrapp(){
    echo '<div class="arrival-product-thumb-wrapp">';
    woocommerce_show_product_loop_sale_flash();
    echo '<div class="arrival-product-img-before">';
    echo '<a href="'.get_the_permalink().'">';
    woocommerce_template_loop_product_thumbnail();
    echo '</a>';
    echo '</div>';   
    arrival_cart_buttons_wrapp();
    echo '</div>';
  }
  
}


if( ! function_exists('arrival_woo_sidebar_wrapp')){
  function arrival_woo_sidebar_wrapp(){

    $default                = arrival_get_default_theme_options();
    $_archive_shop_sidebars = get_theme_mod('arrival_archive_shop_sidebars',$default['arrival_archive_shop_sidebars']);
    $_single_shop_sidebars  = get_theme_mod('arrival_single_shop_sidebars',$default['arrival_single_shop_sidebars']);


    if( is_singular()){
      $sidebar = $_single_shop_sidebars;
    }else{
      $sidebar = $_archive_shop_sidebars;
    }

    if( $sidebar != 'no_sidebar' ){
      get_sidebar( $sidebar );
    }

  }
}

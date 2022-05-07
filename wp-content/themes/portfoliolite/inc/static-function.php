<?php
/**
 * @package ThemeHunk
 * @subpackage Portfoliolite
 * @since 1.0.0
 */
 /**
 * Enable support for Post Thumbnails on posts and pages.
 *
 */
add_theme_support('post-thumbnails');
if ( ! function_exists( 'portfoliolite_the_custom_logo' ) ) :
/*
 * Displays the optional custom logo.
 * Does nothing if the custom logo is not available.
 */
function portfoliolite_the_custom_logo() {
    if ( function_exists( 'the_custom_logo' ) ) {
        the_custom_logo();
    }
}
endif;    
/*
 * Custom header menu
*/
add_action( 'after_setup_theme', 'register_theme_menu' );
function register_theme_menu(){
register_nav_menus( 
array(
        'home-menu'     => esc_html__( 'Front Menu', 'portfoliolite' ),
        'frontpage-menu' => esc_html__( 'Main Menu', 'portfoliolite' ),
        'footer' => esc_html__( 'Footer Menu', 'portfoliolite' ),
    ) );
}

function portfoliolite_nav_menu(){
              wp_nav_menu( array(
              'theme_location' => 'home-menu', 
              'container'      => false, 
              'link_before'    =>'<span class="portfolio-menu-link">',
              'link_after'     => '</span>',
              'items_wrap'     => '<ul id="portfolio-front-menu" class="portfolio-menu" data-menu-style="horizontal">%3$s</ul>',
              'fallback_cb'     => 'portfoliolite_wp_page_menu'
             ));
         }
function portfoliolite_front_nav_menu(){
              wp_nav_menu( array(
              'theme_location' => 'frontpage-menu', 
              'container'      => false, 
              'link_before'    =>'<span class="portfolio-menu-link">',
              'link_after'     => '</span>',
              'items_wrap'     => '<ul id="portfolio-main-menu" class="portfolio-menu" data-menu-style="horizontal">%3$s</ul>',
              'fallback_cb'     => 'portfoliolite_wp_page_menu'
             ));
         }

function portfoliolite_wp_page_menu(){
    echo '<ul class="portfolio-menu" id="portfolio-menu">';
    wp_list_pages(array('title_li' => ''));
    echo '</ul>';
}

function portfoliolite_secnd_menu(){
              wp_nav_menu( array('theme_location' => 'footer',  
              'container'       => false, 
        'menu_class'      => 'secondary-menu', 
        'menu_id'         => 'secondary-menu'
             ));
}
/************************/
// description Menu
/************************/
function portfolioline_nav_description( $item_output, $item, $depth, $args ){
    if ( !empty( $item->description ) ){
        $item_output = str_replace( $args->link_after . '</a>', '<p class="menu-item-description">' . esc_html($item->description) . '</p>' . esc_html($args->link_after) . '</a>', esc_html($item_output) );
    }
    return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'portfolioline_nav_description', 10, 4 );
/*
 * Display navigation to next/previous post when applicable.
 * @since ThemeHunk 1.0
 */
if ( ! function_exists( 'portfoliolite_post_nav' ) ) :
function portfoliolite_post_nav(){
    // Don't print empty markup if there's nowhere to navigate.
    ?>
    <nav class="navigation post-navigation" role="navigation">
        <div class="nav-links">
           <?php
              the_post_navigation( array(
                'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( '%title', 'portfoliolite' ) . '</span> ' ,
                'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( '%title', 'portfoliolite' )));
                //%title
            ?>
        </div><!-- .nav-links -->
    </nav><!-- .navigation -->
    <?php
}
endif;

function portfoliolite_page_thumb(){
return wp_get_attachment_url(get_post_thumbnail_id());
}
/*Number of comment*/
function portfoliolite_comment_number(){
comments_popup_link(__('No Comment','portfoliolite'), __('1 Comment','portfoliolite'), __('% Comments','portfoliolite')); 
 }
/********************************/
// responsive slider function
/*********************************/
if ( ! function_exists( 'portfoliolite_responsive_slider_funct' ) ) :
function portfoliolite_responsive_slider_funct($control_name,$function_name){
  $custom_css='';
           $control_value = get_theme_mod( $control_name );
           if ( empty( $control_value ) ){
                return '';
             }  
        if ( portfoliolite_is_json( $control_value ) ){
    $control_value = json_decode( $control_value, true );
    if ( ! empty( $control_value ) ) {

      foreach ( $control_value as $key => $value ){
        $custom_css .= call_user_func( $function_name, $value, $key );
      }
    }
    return $custom_css;
  }  
}
endif;
/********************************/
// responsive slider function add media query
/********************************/
if ( ! function_exists( 'portfoliolite_add_media_query' ) ) :
function portfoliolite_add_media_query( $dimension, $custom_css ){
  switch ($dimension){
      case 'desktop':
      $custom_css = '@media (min-width: 769px){' . $custom_css . '}';
      break;
      break;
      case 'tablet':
      $custom_css = '@media (max-width: 768px){' . $custom_css . '}';
      break;
      case 'mobile':
      $custom_css = '@media (max-width: 550px){' . $custom_css . '}';
      break;
  }

      return $custom_css;
}
endif;
//Add class to the body and layout switch classes
function portfoliolite_body_classes( $classes ) {
    $classes[] = 'frontpage';
    $header_type = get_theme_mod('portfoliolite_header_fxd');
        if ('on' == $header_type ){
            $classes[] = 'stick-hdr';
        }
        else{
            $classes[] = 'static-hdr';
        }
    return $classes;
}
add_filter( 'body_class','portfoliolite_body_classes' );


// add scroll class
function portfoliolite_add_menuclass($ulclass){
   return preg_replace('/<a /', '<a class="page-scroll"', $ulclass);
}
add_filter('wp_nav_menu','portfoliolite_add_menuclass');
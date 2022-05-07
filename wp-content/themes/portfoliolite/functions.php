<?php
/**
 * Portfoliolite functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Portfoliolite
 * @since 1.0.0
 */
if ( ! function_exists( 'portfoliolite_setup' ) ) :
define( 'PORTFOLIOLITE_THEME_VERSION','1.0.0');
define( 'PORTFOLIOLITE_THEME_DIR', get_template_directory() . '/' );
define( 'PORTFOLIOLITE_THEME_URI', get_template_directory_uri() . '/' );
define( 'PORTFOLIOLITE_THEME_SETTINGS', 'portfoliolite-settings' );

/**
   * Sets up theme defaults and registers support for various WordPress features.
   *
   * Note that this function is hooked into the after_open_shop_setup_theme hook, which
   * runs before the init hook. The init hook is too late for some features, such
   * as indicating support for post thumbnails.
   */
function portfoliolite_setup(){
/*
     * Make theme available for translation.
     */
    load_theme_textdomain( 'portfoliolite' );
    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );
    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );
    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support( 'post-thumbnails' );
    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    ) );
    add_theme_support( 'woocommerce' );
  
    // Add support for Block Styles.
        add_theme_support( 'wp-block-styles' );

        // Add support for full and wide align images.
        add_theme_support( 'align-wide' );

        // Add support for editor styles.
        add_theme_support( 'editor-styles' );

        // Enqueue editor styles.
        add_editor_style( 'style-editor.css' );
        // Add support for responsive embedded content.
        add_theme_support( 'responsive-embeds' );
        // Add theme support for selective refresh for widgets.
        add_theme_support( 'customize-selective-refresh-widgets' );

        add_theme_support( 'starter-content');
    /**
     * Add support for core custom logo.
     */
    add_theme_support( 'custom-logo', array(
      'height'      => 250,
      'width'       => 250,
      'flex-width'  => true,
      'flex-height' => true,
    ) );
    // Add support for Custom Header.
    add_theme_support( 'custom-header', 

    apply_filters( 'portfoliolite_custom_header_args', array(
        'default-image' => '',
        'flex-height'   => true,
        'header-text'   => false,
        'video'         => false,
    ) 


    ) );
    $args = array(
      'default-color' => 'fff',
    );
    add_theme_support( 'custom-background',$args );
        
    $GLOBALS['content_width'] = apply_filters( 'portfoliolite_content_width', 1170 );
    add_theme_support( 'woocommerce', array(
                                                 'thumbnail_image_width' => 320,
                                             ) );
      // WooCommerce.
      add_theme_support( 'wc-product-gallery-zoom' );
      add_theme_support( 'wc-product-gallery-lightbox' );
      add_theme_support( 'wc-product-gallery-slider' );

      // Recommend plugins
        add_theme_support( 'recommend-plugins', array(


            'hunk-companion' => array(
                'name' => esc_html__( 'Hunk Companion (Highly Recommended)', 'portfoliolite' ),
                'img' => 'icon-128x128.png',
                'active_filename' => 'hunk-companion/hunk-companion.php',
            ),

            'th-advance-product-search' => array(
            'name' => esc_html__( 'TH Advance Product Search', 'portfoliolite' ),
            'img' => 'icon-128x128.gif',
            'active_filename' => 'th-advance-product-search/th-advance-product-search.php',
            ),
            'th-variation-swatches' => array(
                'name' => esc_html__( 'TH Variation Swatches', 'portfoliolite' ),
                 'img' => 'icon-128x128.gif',
                'active_filename' => 'th-variation-swatches/th-variation-swatches.php',
            ),
            'lead-form-builder' => array(
                'name' => esc_html__( 'Lead Form Builder', 'portfoliolite' ),
                 'img' => 'icon-128x128.png',
                'active_filename' => 'lead-form-builder/lead-form-builder.php',
            ),
            'wp-popup-builder' => array(
                'name' => esc_html__( 'WP Popup Builder – Popup Forms & Newsletter', 'portfoliolite' ),
                 'img' => 'icon-128x128.png',
                'active_filename' => 'wp-popup-builder/wp-popup-builder.php',
            ), 
            'woocommerce' => array(
                'name' => esc_html__( 'Woocommerce', 'portfoliolite' ),
                 'img' => 'icon-128x128.png',
                'active_filename' => 'woocommerce/woocommerce.php',
            ),

            

        ) );

        // Import Data Content plugins
        add_theme_support( 'import-demo-content', array(

             'hunk-companion' => array(
                'name' => esc_html__( 'Hunk Companion (Highly Recommended)', 'portfoliolite' ),
                'img' => 'icon-128x128.png',
                'active_filename' => 'hunk-companion/hunk-companion.php',
            ),

            'one-click-demo-import' => array(
                'name' => esc_html__( 'One Click Demo Import', 'portfoliolite' ),
                'img' => 'icon-128x128.png',
                'active_filename' => 'one-click-demo-import/one-click-demo-import.php',
            ), 
            'woocommerce' => array(
                'name' => esc_html__( 'Woocommerce', 'portfoliolite' ),
                'img' => 'icon-128x128.png',
                'active_filename' => 'woocommerce/woocommerce.php',
            ),

        ));

        // Useful plugins
        add_theme_support( 'useful-plugins', array(
             'themehunk-megamenu-plus' => array(
                'name' => esc_html__( 'Megamenu plugin from Themehunk.', 'portfoliolite' ),
                'active_filename' => 'themehunk-megamenu-plus/themehunk-megamenu.php',
            ),
        ) );



    }

endif;
add_action( 'after_setup_theme', 'portfoliolite_setup' );
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 */
/**
 * Register widget area.
 */
function portfoliolite_widgets_init() {
// Area , located below the Primary Widget Area in the sidebar. Empty by default.
register_sidebar(array(
'name' => __('Primary Sidebar', 'portfoliolite'),
'id' => 'primary-sidebar',
'description' => __('Main sidebar that appears on the left.', 'portfoliolite'),
'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="portfolio-widget-content">',
    'after_widget'  => '</div></div>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
));
// Area , located below the secondary Widget Area in the sidebar. Empty by default.
register_sidebar(array(
'name' => __('Secondary Sidebar', 'portfoliolite'),
'id' => 'secondary-sidebar',
'description' => __('Secondary sidebar that appears on the left.', 'portfoliolite'),
'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="portfolio-widget-content">',
    'after_widget'  => '</div></div>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
));
// Area 1, located in the footer. Empty by default.
register_sidebar(array(
'name' => __('First Footer Widget Area', 'portfoliolite'),
'id' => 'first-footer-widget-area',
'description' => __('Appears in the first footer section of the site.', 'portfoliolite'),
'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="portfolio-widget-content">',
    'after_widget'  => '</div></div>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
));
// Area 2, located in the footer. Empty by default.
register_sidebar(array(
'name' => __('Second Footer Widget Area', 'portfoliolite'),
'id' => 'second-footer-widget-area',
'description' => __('Appears in the Second footer section of the site.', 'portfoliolite'),
'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="portfolio-widget-content">',
    'after_widget'  => '</div></div>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
));
// Area 3, located in the footer. Empty by default.
register_sidebar(array(
'name' => __('Third Footer Widget Area', 'portfoliolite'),
'id' => 'third-footer-widget-area',
'description' => __('Appears in the Third footer section of the site.', 'portfoliolite'),
'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="portfolio-widget-content">',
    'after_widget'  => '</div></div>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
));


}
/** Register sidebars by running portfoliolite_widgets_init() on the widgets_init hook. */
add_action('widgets_init', 'portfoliolite_widgets_init');
/**
 * Enqueue scripts and styles.
 */
function portfoliolite_scripts(){
// Add Genericons font, used in the main stylesheet.
wp_enqueue_style( 'portfoliolite-menu', PORTFOLIOLITE_THEME_URI . '/css/menu-css.css', array(), PORTFOLIOLITE_THEME_VERSION );
wp_enqueue_style( 'font-awesome', PORTFOLIOLITE_THEME_URI . '/third-party/font-awesome/css/font-awesome.css', array(), PORTFOLIOLITE_THEME_VERSION );
wp_enqueue_style( 'portfoliolite-style', get_stylesheet_uri(), array(),PORTFOLIOLITE_THEME_VERSION );
wp_add_inline_style('portfoliolite-style', portfoliolite_custom_style());
wp_add_inline_style('portfoliolite-style', portfoliolite_typography_style());
// js include
wp_enqueue_script("jquery-effects-core",array( 'jquery' ));
wp_enqueue_script( 'portfoliolite-menu', PORTFOLIOLITE_THEME_URI . '/js/menu.js', array( 'jquery' ), PORTFOLIOLITE_THEME_VERSION, true );
wp_enqueue_script( 'portfoliolite-custom', PORTFOLIOLITE_THEME_URI . '/js/custom.js', array( 'jquery' ), PORTFOLIOLITE_THEME_VERSION, true );
if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ){
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', 'portfoliolite_scripts' );


if ( ! function_exists( 'portfoliolite_body_open' ) ) {

/**
   * Shim for wp_body_open, ensuring backward compatibility with versions of WordPress older than 5.2.
*/
function portfoliolite_body_open(){
    do_action( 'wp_body_open' );
  }
}
/********************************************************/
// Adding Dashicons in WordPress Front-end
/********************************************************/
add_action( 'wp_enqueue_scripts', 'portfoliolite_load_dashicons_front_end' );
function portfoliolite_load_dashicons_front_end(){
  wp_enqueue_style( 'dashicons' );
}
//custom function conditional check for blog page
function portfoliolite_is_blog(){
    return ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag()) && 'post' == get_post_type();
}
/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function portfoliolite_skip_link_focus_fix() {
  // The following is minified via `terser --compress --mangle -- js/skip-link-focus-fix.js`.
  ?>
  <script>
  /(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
  </script>
  <?php
}
add_action( 'wp_print_footer_scripts', 'portfoliolite_skip_link_focus_fix' );
/**
 * Load init.
 */
require_once trailingslashit(PORTFOLIOLITE_THEME_DIR).'inc/include.php';
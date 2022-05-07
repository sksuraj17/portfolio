<?php
/**
 * Arrival functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package arrival
 */
/** important constants **/
$theme_ob = wp_get_theme();
$ver      = $theme_ob -> get( 'Version' );
define( 'ARRIVAL_THEME', $theme_ob->get( 'Name' ) );
define( 'ARRIVAL_VER',$ver);
define( 'ARRIVAL_URI', get_template_directory_uri() );
define( 'ARRIVAL_DIR', get_template_directory() );
define( 'ARRIVAL_LIB_URI', get_template_directory_uri(). '/assets//lib' );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function arrival_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on arrival, use a find and replace
		* to change 'arrival' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'arrival', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );


	/* custom image size */
	add_image_size( 'arrival-blog-list-thumb', 800, 800, true );
	add_image_size( 'arrival-blog-masonry-thumb', 520, 345, true );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'responsive-embeds' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		apply_filters('arrival_nav_register',array(
			'primary' 	=> esc_html__( 'Primary', 'arrival' ),
			'top'		=> esc_html__( 'Top', 'arrival' ),
		))
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5', array(
			'script',
			'style',
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'audio',
		'video',
		'gallery',
	) );
	

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background', apply_filters(
			'arrival_custom_background_args', array(
				'default-color' => 'f1f1f1',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo', array(
			'height'      => 1200,
			'width'       => 1920,
			'flex-width'  => false,
			'flex-height' => false,
		)
	);

	/**
	 * Add support for default block styles.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#default-block-styles
	 */
	add_theme_support( 'wp-block-styles' );
	/**
	 * Add support for wide aligments.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#wide-alignment
	 */
	add_theme_support( 'align-wide' );

	/**
	 * Add support for block color palettes.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#block-color-palettes
	 */
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => esc_html__( 'Dusty orange', 'arrival' ),
			'slug'  => 'dusty-orange',
			'color' => '#ed8f5b',
		),
		array(
			'name'  => esc_html__( 'Dusty red', 'arrival' ),
			'slug'  => 'dusty-red',
			'color' => '#e36d60',
		),
		array(
			'name'  => esc_html__( 'Dusty wine', 'arrival' ),
			'slug'  => 'dusty-wine',
			'color' => '#9c4368',
		),
		array(
			'name'  => esc_html__( 'Dark sunset', 'arrival' ),
			'slug'  => 'dark-sunset',
			'color' => '#33223b',
		),
		array(
			'name'  => esc_html__( 'Almost black', 'arrival' ),
			'slug'  => 'almost-black',
			'color' => '#0a1c28',
		),
		array(
			'name'  => esc_html__( 'Dusty water', 'arrival' ),
			'slug'  => 'dusty-water',
			'color' => '#41848f',
		),
		array(
			'name'  => esc_html__( 'Dusty sky', 'arrival' ),
			'slug'  => 'dusty-sky',
			'color' => '#72a7a3',
		),
		array(
			'name'  => esc_html__( 'Dusty daylight', 'arrival' ),
			'slug'  => 'dusty-daylight',
			'color' => '#97c0b7',
		),
		array(
			'name'  => esc_html__( 'Dusty sun', 'arrival' ),
			'slug'  => 'dusty-sun',
			'color' => '#eee9d1',
		),
	) );

	/**
	 * Optional: Disable custom colors in block color palettes.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
	 *
	 * add_theme_support( 'disable-custom-colors' );
	 */

	/**
	 * Add support for font sizes.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#block-font-sizes
	 */
	add_theme_support( 'editor-font-sizes', array(
		array(
			'name'      => esc_html__( 'small', 'arrival' ),
			'shortName' => esc_html__( 'S', 'arrival' ),
			'size'      => 16,
			'slug'      => 'small',
		),
		array(
			'name'      => esc_html__( 'regular', 'arrival' ),
			'shortName' => esc_html__( 'M', 'arrival' ),
			'size'      => 20,
			'slug'      => 'regular',
		),
		array(
			'name'      => esc_html__( 'large', 'arrival' ),
			'shortName' => esc_html__( 'L', 'arrival' ),
			'size'      => 36,
			'slug'      => 'large',
		),
		array(
			'name'      => esc_html__( 'larger', 'arrival' ),
			'shortName' => esc_html__( 'XL', 'arrival' ),
			'size'      => 48,
			'slug'      => 'larger',
		),
	) );

	

}
add_action( 'after_setup_theme', 'arrival_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function arrival_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'arrival_content_width', 640 );
}
add_action( 'after_setup_theme', 'arrival_content_width', 0 );


/**
 * Set the embed width in pixels, based on the theme's design and stylesheet.
 *
 * @param array $dimensions An array of embed width and height values in pixels (in that order).
 * @return array
 */
function arrival_embed_dimensions( array $dimensions ) {
	$dimensions['width'] = 720;
	return $dimensions;
}
add_filter( 'embed_defaults', 'arrival_embed_dimensions' );

/**
 * Register Google Fonts
 */
function arrival_fonts_url() {
	$fonts_url = '';

	/**
	 * Translator: If Roboto Sans does not support characters in your language, translate this to 'off'.
	 */
	$roboto_cond = esc_html_x( 'on', 'Roboto Condensed font: on or off', 'arrival' );

	/**
	 * Translator: If Crimson Text does not support characters in your language, translate this to 'off'.
	 */
	$roboto = esc_html_x( 'on', 'Roboto font: on or off', 'arrival' );

	$font_families = array();

	if ( 'off' !== $roboto_cond ) {
		$font_families[] = 'Roboto Condensed:400,400i,700,700i';
	}

	if ( 'off' !== $roboto ) {
		$font_families[] = 'Roboto:400,500,700';
	}

	if ( in_array( 'on', array( $roboto_cond, $roboto ) ) ) {
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );

}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function arrival_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'arrival-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'arrival_resource_hints', 10, 2 );

/**
 * Enqueue WordPress theme styles within Gutenberg.
 */
function arrival_gutenberg_styles() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'arrival-fonts', arrival_fonts_url(), array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

	// Enqueue main stylesheet.
	wp_enqueue_style( 'arrival-base-style', get_theme_file_uri( '/assets/css/editor-styles.css' ), array(), ARRIVAL_VER );
}
add_action( 'enqueue_block_editor_assets', 'arrival_gutenberg_styles' );

/** Adding Editor Styles **/
function arrival_add_editor_styles() {
    add_editor_style( get_template_directory_uri().'/assets/css/editor-style.css' );
}
add_action( 'admin_init', 'arrival_add_editor_styles' );




/* Require theme files*/
$file_paths = array(
	'/inc/enqueue',
	'/inc/image-sizes',
	'/inc/template-tags',
	'/inc/template-functions',
	'/inc/customizer/customizer',
	'/pluggable/breadcrumb',
	'/pluggable/custom-header',
    '/inc/hooks/header-hooks',
    '/inc/hooks/footer-hooks',
    '/inc/hooks/metabox-controllers',
    '/inc/dynamic-styles',
    '/inc/widgets/widgets-init',
    '/inc/arrival-contents'
);

foreach ($file_paths as $file_path) {
	require get_parent_theme_file_path() . $file_path.'.php';
}

/**
 * Optional: Add theme support for lazyloading images.
 *
 * @link https://developers.google.com/web/fundamentals/performance/lazy-loading-guidance/images-and-video/
 */
require get_template_directory() . '/pluggable/lazyload/lazyload.php';

/**
* SVG icons 
*
*/
require get_template_directory() . '/pluggable/svg-icons/arrival-svg-icons.php';


/**
* WooCommerce functions
*
*
*/
if( class_exists('woocommerce')){
	require get_template_directory() . '/inc/woocommerce/woo-functions.php';
}


/**
 * Load welcome section to admin.
 */
if ( is_admin() ) {
    require get_template_directory().'/inc/welcome/welcome-config.php';
}
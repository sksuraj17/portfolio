<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package arrival
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php if ( ! arrival_is_amp() ) : ?>
		<script>document.documentElement.classList.remove("no-js");</script>
	<?php endif; ?>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php 
//wp_body_open hook from WordPress 5.2
if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
}else {
 	do_action( 'wp_body_open' ); 
}

$default 					= arrival_get_default_theme_options();
$_page_header_layout 		= get_theme_mod('arrival_page_header_layout',$default['arrival_page_header_layout']);
$_breadcrumb_enable 		= get_theme_mod('arrival_breadcrumb_enable',$default['arrival_breadcrumb_enable']);

?>

	<a class="skip-link screen-reader-text" href="#page"><?php esc_html_e( 'Skip to content', 'arrival' ); ?></a>
		
		<?php do_action('arrival_main_header_wrapp'); ?>

<?php if( $_page_header_layout == 'layout-two' && $_breadcrumb_enable == 'yes' ){
	do_action('arrival_breadcrumb_banner');
}?>
<?php 
	$class = 'site';

if( is_page_template('tpl-home.php') ){
		$class = 'front-page';
	}

 ?>
<div id="page" class="<?php echo esc_attr($class)?>">
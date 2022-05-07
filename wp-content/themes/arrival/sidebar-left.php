<?php
/**
 * Left sidebar area for the theme
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package arrival
 */
$default  = arrival_get_default_theme_options();


if ( ! is_active_sidebar( 'sidebar-2' ) ) {
	return;
}
?>

<?php wp_print_styles( array( 'arrival-sidebar' ) ); ?>
<aside id="secondary" class="left-sidebar widget-area">
	<?php dynamic_sidebar( 'sidebar-2' ); ?>
</aside><!-- #secondary -->

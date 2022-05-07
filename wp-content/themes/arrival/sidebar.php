<?php
/**
 * sidebar for the theme
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package arrival
 */

$default  = arrival_get_default_theme_options();


if ( ! is_active_sidebar( 'sidebar-1' )  &&  ! is_active_sidebar( 'sidebar-2' ) ) {
        return;
}else{
	get_sidebar('right');
}
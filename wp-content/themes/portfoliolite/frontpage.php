<?php
/**
 * Template Name: Homepage Template
 * @package ThemeHunk
 * @subpackage Portfoliolite
 * @since 1.0.0
 */
get_header();?>
<div class="page-wrapper">
<?php
if( shortcode_exists( 'portfoliolite' ) ){
 do_shortcode("[portfoliolite section='portfoliolite_show_frontpage']");
 }
?>
</div>
<?php get_footer(); 

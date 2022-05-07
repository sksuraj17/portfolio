<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Arrival
 */
get_header();
?>
<main id="main" class="site-main">

	<?php
	while ( have_posts() ) : the_post();

		get_template_part( 'template-parts/content', 'page' );
		

	endwhile; // End of the loop.
	?>

</main><!-- #main -->
<?php
$default              	= arrival_get_default_theme_options();
$_single_page_sidebars 	= get_theme_mod('arrival_single_page_sidebars',$default['arrival_single_page_sidebars']);

if( function_exists('arrival_mb_single_posts_sidebar')){
	$meta_sidebar = arrival_mb_single_posts_sidebar();

	if($meta_sidebar != 'default' ){
		if( $meta_sidebar == 'leftsidebar' ){
			get_sidebar('left');	
		}else if( $meta_sidebar == 'rightsidebar' ){
			get_sidebar('right');
		}	
	}elseif($_single_page_sidebars != 'no_sidebar' ){
		get_sidebar($_single_page_sidebars);
	}
}else if( $_single_page_sidebars != 'no_sidebar' ){
	get_sidebar($_single_page_sidebars);
}

get_footer();

<?php
/**
 * The main template file for displaying single posts
 *
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Arrival
 */

get_header(); ?>

	<main id="primary" class="site-main single-post-wrapp">

	<?php

	if ( have_posts() ) :

		/**
		 * Include the component stylesheet for the content.
		 * This call runs only once on index and archive pages.
		 * At some point, override functionality should be built in similar to the template part below.
		 */
		//wp_print_styles( array( 'arrival-content' ) ); // Note: If this was already done it will be skipped.

		/* Display the appropriate header when required. */
		

		/* Start the Loop. */
		while ( have_posts() ) :
			the_post();

			/*
			 * Include the Post-Type-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
			 */
			get_template_part( 'template-parts/content', 'single' );

			
		endwhile;

		
		the_post_navigation(
		array(
			'prev_text' => '<div class="post-navigation-sub"><span>' . esc_html__( 'Previous:', 'arrival' ) . '</span></div>%title',
			'next_text' => '<div class="post-navigation-sub"><span>' . esc_html__( 'Next:', 'arrival' ) . '</span></div>%title',
			)
		);
arrival_post_tags();
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	else :

		get_template_part( 'template-parts/content', 'none' );

	endif;
	?>

	</main><!-- #primary -->

<?php

$default              	= arrival_get_default_theme_options();
$_single_post_sidebars 	= get_theme_mod('arrival_single_post_sidebars',$default['arrival_single_post_sidebars']);


if( function_exists('arrival_mb_single_posts_sidebar')){
	$meta_sidebar = arrival_mb_single_posts_sidebar();

	if($meta_sidebar != 'default' ){
		if( $meta_sidebar == 'leftsidebar' ){
			get_sidebar('left');	
		}else if( $meta_sidebar == 'rightsidebar' ){
			get_sidebar('right');
		}	
	}elseif($_single_post_sidebars != 'no_sidebar' ){
		get_sidebar($_single_post_sidebars);
	}
}else if( $_single_post_sidebars != 'no_sidebar' ){
	get_sidebar($_single_post_sidebars);
}


get_footer();

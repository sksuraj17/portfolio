<?php
/**
 * Template for displaying search page
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package arrival
 */

get_header(); ?>

	<main id="primary" class="site-main">

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

			get_template_part( 'template-parts/content', 'search' );
			
			

		endwhile;

		
		if ( ! is_singular() ) :
			arrival_numeric_posts_nav();
		endif;

	else :

		get_template_part( 'template-parts/content', 'none' );

	endif;
	?>

	</main><!-- #primary -->

<?php
get_footer();

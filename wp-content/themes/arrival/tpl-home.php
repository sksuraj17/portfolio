<?php
/**
* Template Name: Arrival Home
*
*/
get_header();

if ( have_posts() ) :

	while ( have_posts() ) : the_post();

			the_content();
			
	endwhile;

	else :
		get_template_part( 'template-parts/content', 'none' );

endif;

get_footer();
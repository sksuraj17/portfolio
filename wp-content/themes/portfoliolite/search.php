<?php
/**
* The template for displaying Search Results pages
 * @package ThemeHunk
 * @subpackage Portfoliolite
 * @since 1.0.0
*/
get_header(); ?>
<div class="clearfix"></div>
<div class="page-wrapper">
<div class="blog-top">
<div class="blog-image">
<div class="full-fs-caption">
     <div class="caption-container">
      <h1 class="title overtext">
      <a href="#"><?php printf( __( 'Search Results for : %s', 'portfoliolite' ), get_search_query() ); ?></a></h1>
     </div>
</div>
</div>
</div>
<div class="clearfix"></div>
<div id="page">
<div class="content-wrapper">
<div class="content">
<div class="blog-content">
<ul class="load_post standard-layout">
<?php
									if( have_posts()): ?>
									<?php
										/* Start the Loop */
										while ( have_posts() ) : the_post();
											/*
											 * Include the Post-Format-specific template for the content.
											 * If you want to override this in a child theme, then include a file
											 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
											 */
										get_template_part( 'template-parts/content', 'search' );
										endwhile;
										
									else :
										get_template_part( 'template-parts/content', 'none' );
									endif;
								?>
</ul>    
</div>
</div>   
</div> 
 <div class="sidebar-wrapper">
<?php get_sidebar(); ?>
</div>
</div>
</div>
<?php get_footer(); 
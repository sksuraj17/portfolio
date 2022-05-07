<?php
/**
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ThemeHunk
 * @subpackage Portfoliolite
 * @since 1.0.0
 */
?>
<?php get_header(); 
$value = get_post_meta( $post->ID, 'th_sidebar_dyn', true );
?>
<div class="page-wrapper">
<div class="blog-top">
<div class="blog-image hd-img" data-center="background-position: 50% 0px;" data-top-bottom="background-position: 50% -100px;" style="background-image: url(<?php header_image(); ?>);">
<div class="full-fs-caption">
      <div class="caption-container">
      <h1 class="title overtext">
                <?php
					      the_archive_title('<h1 class="thunk-page-top-title entry-title">','</h1>');
				       ?>
      </h1>
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
            if( have_posts()):
                /* Start the Loop */
                while ( have_posts() ) : the_post();
                    /*
                     * Include the Post-Format-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                     */
                get_template_part( 'template-parts/content', get_post_format() );
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
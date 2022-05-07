<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Portfoliolite
 * @since 1.0.0
 */
get_header(); 
$value = get_post_meta( $post->ID, 'th_sidebar_dyn', true );
?>
<div class="page-wrapper">
<div class="blog-top">
<div class="blog-image" data-center="background-position: 50% 0px;" data-top-bottom="background-position: 50% -100px;" style="background-image: url(<?php esc_url(header_image()); ?>);">
<div class="full-fs-caption">
     <div class="caption-container">
      <h1 class="title overtext">
      <a href="#"><?php echo esc_html(get_the_title( get_option('page_for_posts', true) )); ?></a></h1>
</div>
</div>
</div>
</div>
<div class="clearfix"></div>
<div id="page" class="clearfix <?php echo esc_attr($value); ?>">
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
<?php the_posts_pagination();?>
</div>
</div>   
</div> 
<div class="sidebar-wrapper">
<?php get_sidebar(); ?>
</div> 
</div>
</div>
<?php get_footer(); 
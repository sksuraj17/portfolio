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
 * @package ThemeHunk
 * @subpackage Portfoliolite
 * @since 1.0.0
 */
get_header();
$value = get_post_meta( $post->ID, 'th_sidebar_dyn', true );
?>
<div class="page-wrapper">
<div class="blog-top">
<?php  
$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'size' );
 ?>
 <?php if($thumbnail_src==''){?>
 <div class="blog-image" data-center="background-position: 50% 0px;" data-top-bottom="background-position: 50% -100px;">	
 <?php } else{?>	
<div class="blog-image" data-center="background-position: 50% 0px;" data-top-bottom="background-position: 50% -100px;" style="background-image: url(<?php echo esc_url($thumbnail_src[0]); ?>);">
<?php } ?>
<div class="full-fs-caption">
     <div class="caption-container">
      <h1 class="title overtext">
      <a href="#"><?php wp_title(''); ?></a></h1>
      <?php portfoliolite_breadcrumb_trail(); ?>
     </div>
</div>

</div>
</div>
<div class="clearfix"></div>
<div id="page" class="clearfix <?php echo esc_attr($value); ?>">
<div class="content-wrapper">
<div class="content">
<div class="page-content">
<?php
                            while( have_posts() ) : the_post();
                               get_template_part( 'template-parts/content', 'page' );
                              // If comments are open or we have at least one comment, load up the comment template.
                              if ( comments_open() || get_comments_number() ) :
                                comments_template();
                               endif;
                               endwhile; // End of the loop.
                            ?>
</div>
</div>   
</div> 

<?php if($value!='no-sidebar'): ?>
<div class="sidebar-wrapper">
<?php get_sidebar(); ?>
</div>
<?php endif; ?>
</div>
</div>
<?php get_footer(); 
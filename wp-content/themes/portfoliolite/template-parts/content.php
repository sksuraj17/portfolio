<?php
/**
 * Template part for displaying posts
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @package  Portfoliolite
 * @since 1.0.0
 */
?>
<!-- Start the Loop. -->
<li class="post"  id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="post-img-wrapper">
<div class="post-img">
<?php if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) { ?>
<a href="<?php echo esc_url(get_permalink()); ?>"> <?php the_post_thumbnail('post_thumbnail_loop'); ?></a>
<?php } ?>
</div>  
</div>
<div class="blog-info-header">
<div class="blog-info-meta ">
            <ul class="post_meta">
                 <li class="posted_on"><i class="fa fa-calendar-o"></i><span></span><?php echo get_the_time('M, d, Y') ?></li>
                 <li class="posted_by"><a href=""><?php the_category(', '); ?></a></li>
                 <li class="post_comment"><i class="fa fa-comments-o"></i><a href="" title=""><?php portfoliolite_comment_number(); ?></a></li>
            </ul>
</div>
<h2><a href="<?php the_permalink(); ?>"><?php the_title();  ?></a></h2>
</div> 
<div class="clearfix"></div>
<div class="blog-info-content"><p><?php the_excerpt(); ?></p>
<a href="<?php the_permalink(); ?>"><button class="load-more"><?php _e('Read more','portfoliolite');?></button></a>
</div> 
</li>
<!--End post-->
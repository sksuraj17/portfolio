<?php
/**
 * Template part for displaying single post
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Portfoliolite
 * @since 1.0.0
 */
?>
<div class="post" id="post-<?php the_ID(); ?>"<?php post_class('post'); ?>>
<div class="post-img-wrapper">  
</div>
<div class="blog-info-header">
<div class="blog-info-meta">
 <ul class="post_meta">
               
                 
                 <li class="posted_on"><i class="fa fa-calendar-o"></i><span></span><?php echo get_the_time('M, d, Y') ?></li>
                 <li class="posted_by"><a href=""><?php the_category(', '); ?></a></li>
                 <li class="post_comment"><i class="fa fa-comments-o"></i><a href="" title="">
                 	<?php portfoliolite_comment_number(); ?></a></li>
                 
 </ul>
</div>
<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"></a></h2>
</div> 
<div class="clearfix"></div>
<div class="blog-info-content"><p>
	<?php
				the_content( sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'portfoliolite' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				) );

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'portfoliolite' ),
					'after'  => '</div>',
				) );
			?>
</p>
<div class="tagcloud"><?php echo get_the_tag_list( '', __( ' ', 'portfoliolite' ) ); ?></div>
</div> 
<div class="paginate">
  <span class="post-previous"><?php previous_post_link('%link'); ?></span>
  <span class="post-next"><?php next_post_link('%link'); ?></span>
</div>
</div>
<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Arrival
 */

$defaults 			= arrival_get_default_theme_options();
$_blog_excerpts 	= get_theme_mod('arrival_blog_excerpts',$defaults['arrival_blog_excerpts']);
$_blog_layout 		= get_theme_mod('arrival_blog_layout',$defaults['arrival_blog_layout']);
$_post_meta_enable 	= get_theme_mod('arrival_post_meta_enable',$defaults['arrival_post_meta_enable']);

$post_format 	= get_post_format( get_the_id() );

$slider_class = '';
if( 'gallery' == $post_format ){
	$slider_class = 'gallery-post-format';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
	
	<div class="post-thumb <?php echo esc_attr($slider_class)?>">
		<?php arrival_post_format_display(); ?>
	</div>
	<div class="post-content-wrap">
		<?php 
		arrival_post_categories(); 
		the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		echo arrival_get_excerpt_content($_blog_excerpts); //sanitization already done inside arrival_get_excerpt_content()
		?>

	<?php if( $_post_meta_enable == 'yes' ){ ?>
		<div class="entry-meta">
		<?php
		if( $_blog_layout == 'list-layout' ){
			arrival_posted_by();	
		}
		
		echo arrival_post_view(); //sanitization already done
		arrival_posted_on(); 
		arrival_comments_link();
		arrival_edit_post_link();
		?>
		</div><!-- .entry-meta -->
	<?php } ?>

	</div>
</article><!-- #post-<?php the_ID(); ?> -->
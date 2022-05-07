<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package ThemeHunk
 * @subpackage Portfoliolite
 * @since 1.0.0
 */
get_header(); ?>
<div class="page-wrapper">
<div class="blog-top">
<div class="blog-image">
<div class="full-fs-caption">
     <div class="caption-container">
      <h1 class="title overtext">
      <a href="#"><?php _e( 'Not Found', 'portfoliolite' ); ?></a></h1>
     </div>
</div>
</div>
</div>
<div class="clearfix"></div>
<div id="page">
<div class="content-wrapper">
<div class="content">
<div class="error-404 not-found">
				<div class="error-heading">
					<h2 class="thunk-page-top-title entry-title"><?php esc_html_e( '404', 'portfoliolite' ); ?></h2>
					<h3><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'portfoliolite' ); ?></h3>
				</div><!-- .error-heading -->

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'portfoliolite' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .page-content -->

				<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-404',
					'depth'          => 1,
					'container'      => 'div',
					'container_id'   => 'quick-links-404',
					'fallback_cb'    => false,
					) );
				?>
			</div><!-- .error-404 -->
</div>   
</div> 
<div class="sidebar-wrapper">
<?php get_sidebar(); ?>
</div>
</div>
</div>
<?php get_footer(); 
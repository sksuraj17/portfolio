<?php
/**
* The file controls metabox options for the themes and metabox are available on companion plugin so some prefixings is from companion plugin
* @package Arrival
* @since 1.0.9
*
*
*/



/**
* Header & footer control from metaboxes
* @since 1.0.9
*
*/
if( ! class_exists('Ultra_Companion')  ){
	return;
}else if( ! class_exists('Elementor\Plugin') ){
	return;
}
	

add_action( 'wp_head', 'arrival_meta_headers_hooks' );

if( ! function_exists('arrival_meta_headers_hooks') ){
	function arrival_meta_headers_hooks(){
		$default 						= arrival_get_default_theme_options();
		$_site_header_type 				= get_theme_mod('arrival_site_header_type',$default['arrival_site_header_type']);
		$_site_header_custom_template 	= get_theme_mod('arrival_site_header_custom_template',$default['arrival_site_header_custom_template']);

		$_site_footer_type 				= get_theme_mod('arrival_site_footer_type',$default['arrival_site_footer_type']);
		$_site_footer_custom_template 	= get_theme_mod('arrival_site_footer_custom_template',$default['arrival_site_footer_custom_template']);

		$mb_header 						= arrival_get_post_meta('ultra_page_header','default');
		$mb_footer 						= arrival_get_post_meta('ultra_page_footer','default');
		$mb_hdr_temp 					= arrival_get_post_meta('ultra_page_custom_header');
		$ultra_page_title_banner 		= arrival_get_post_meta('ultra_page_title_banner','on' );
		$ultra_page_custom_title 		= arrival_get_post_meta('ultra_page_custom_title');
		$ultra_page_breadcrumb_show 	= arrival_get_post_meta('ultra_page_breadcrumb_show','on');


		//remove header
	
		if( ('default' != $mb_header) && ( ! is_404() ) && ( ! is_search() ) ){
			remove_action('arrival_main_header_wrapp','arrival_main_header_wrapp');
		}else if( ('custom' == $_site_header_type)  && $_site_header_custom_template  ){
			remove_action('arrival_main_header_wrapp','arrival_main_header_wrapp');
		}

		//remove footer
		if( ('default' != $mb_footer) && ( ! is_404() ) && ( ! is_search() ) ){
			remove_action('arrival_footer_contents','arrival_footer_contents',10);
		}else if( ('custom' == $_site_footer_type)  && $_site_footer_custom_template  ){
			remove_action('arrival_footer_contents','arrival_footer_contents',10);
		}
		
		//custom header options
		if( 'custom' == $mb_header ){
			echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($mb_hdr_temp);

		}else if( ('custom' == $_site_header_type)  && $_site_header_custom_template ){
			//custom header from customizer
			echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($_site_header_custom_template);
		}

		//custom footer
		if( 'custom' == $mb_footer ){
			add_action('arrival_footer_contents','arrival_mb_footer_temp',15);
		}else if( ('custom' == $_site_footer_type)  && $_site_footer_custom_template ){
			add_action('arrival_footer_contents','arrival_mb_footer_temp',15);
		}


		//breadcrumbs
		if( 'off' == $ultra_page_title_banner ){
			add_filter( 'arrival_header_banner_control','__return_false' );
		}

		//custom title for pages
		if( $ultra_page_custom_title ){
			add_filter( 'arrival_header_bcm_title','__return_false' );
			remove_action('arrival_breadcrumb_header_titles','arrival_breadcrumb_header_titles');
			add_action('arrival_breadcrumb_header_titles','arrival_mb_breadcrumbs');
		}

		if( 'off' == $ultra_page_breadcrumb_show ){
			add_filter( 'arrival_header_breadcrumb_links','__return_false' );
		}


	}
}


/**
* Custom footer 
*
*/
if( ! function_exists('arrival_mb_footer_temp')){
	function arrival_mb_footer_temp(){

		$default 						= arrival_get_default_theme_options();
		$_site_footer_type 				= get_theme_mod('arrival_site_footer_type',$default['arrival_site_footer_type']);
		$_site_footer_custom_template 	= get_theme_mod('arrival_site_footer_custom_template',$default['arrival_site_footer_custom_template']);

		$mb_ftr_temp 	= arrival_get_post_meta('ultra_page_custom_footer');
		$mb_footer 		= arrival_get_post_meta('ultra_page_footer','default');

		//custom footer options
		if( 'custom' == $mb_footer ){
			echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($mb_ftr_temp);
		}else if( ('custom' == $_site_footer_type)  && $_site_footer_custom_template ){
			echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($_site_footer_custom_template);
			
		}

	}
}


/**
* /body class for metabox sidebar
* @return returns current value of sidebar from metabox and adds to body class
*/

add_filter( 'body_class', 'arrival_mb_sidebar_class' );
if( ! function_exists('arrival_mb_sidebar_class')){
	function arrival_mb_sidebar_class( $classes ){

		$ultra_sidebar_layout = arrival_get_post_meta('ultra_sidebar_layout','default');

		if( 'nosidebar' == $ultra_sidebar_layout ){
			$ultra_sidebar_layout = 'no-sidebar';
		}else if( ('nosidebar' != $ultra_sidebar_layout) &&  ('default' != $ultra_sidebar_layout) &&  ( ! is_404() ) && ( ! is_search() ) ){
        	$classes[] = 'has-sidebar';
    	}
	

		$classes[] = $ultra_sidebar_layout;

		return $classes;
	}
}


/**
* Single post sidebars
*
*/
if( ! function_exists('arrival_mb_single_posts_sidebar')){
	function arrival_mb_single_posts_sidebar(){
		$ultra_sidebar_layout 	= arrival_get_post_meta('ultra_sidebar_layout','default');

		return $ultra_sidebar_layout;
	}
}

/**
* Metabox control for breadcrumb
*
*/


if( ! function_exists('arrival_mb_breadcrumbs')){
	function arrival_mb_breadcrumbs(){

		$ultra_page_custom_title 	= arrival_get_post_meta('ultra_page_custom_title');
		$ultra_page_custom_subtitle = arrival_get_post_meta('ultra_page_custom_subtitle');


		if( $ultra_page_custom_title ){ ?>
			<div class="breadcrumb-title">
				<h1 class="page-title">
					<?php echo esc_html($ultra_page_custom_title); ?>
				</h1>
				<?php if( $ultra_page_custom_subtitle ){ ?>
					<h3 class="page-subtitle"><?php echo esc_html($ultra_page_custom_subtitle); ?></h3>
				<?php } ?>
			</div>
		<?php
		}
		
	}
}
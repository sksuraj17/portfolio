<?php
/**
* Dynamic styles for the theme
*
* @package Arrival 
* @since 1.0.1
*/

function arrival_dynamic_styles(){
	ob_start();
	
	$defaults = arrival_get_default_theme_options();
	$prefix = 'arrival';

	
	//Theme color
	$_theme_color = get_theme_mod('arrival_theme_color',$defaults['arrival_theme_color']);
	?>
	
	.top-header-wrapp,.scroll-top-top,.widget h2.widget-title:before,.comment-reply-link, .comment-form .form-submit input,span.tags-links a:hover,.header-last-item.search-wrap.header-btn a.header-cta-btn,.arrival-archive-navigation ul li a:hover,
	.arrival-archive-navigation ul li.active a,.comment-reply-link, .comment-form .form-submit input,.woocommerce div.product form.cart .button,.woocommerce .products li a.button:hover,.woocommerce #respond input#submit,.woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current,.woocommerce div.product form.cart .button, .woocommerce .cart .button, .woocommerce .cart input.button, .woocommerce button.button,button, input[type="button"], input[type="reset"], input[type="submit"],header.hover-layout-two .main-header-wrapp nav.main-navigation ul.arrival-main-navigation>li.menu-item>a:before,header.hover-layout-three .main-header-wrapp nav.main-navigation ul.arrival-main-navigation>li.menu-item:before,header span.cart-count,.site-main .entry-content a.button.wc-backward,.woocommerce div.product form.cart .button, .woocommerce .cart .button, .woocommerce .cart input.button, .woocommerce button.button, .content-area .product a.compare.button, .content-area .product .yith-wcwl-wishlistexistsbrowse.show a, .woocommerce .widget_shopping_cart .buttons a, .woocommerce.widget_shopping_cart .buttons a, .site-main .entry-content a.button.wc-backward,.arrival-cart-wrapper,
	.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,.woocommerce-account .woocommerce-MyAccount-navigation ul li a{
		background: <?php echo  arrival_sanitize_color($_theme_color);?>;
	}

	.main-navigation a:hover, .main-navigation a:focus, .arrival-top-navigation ul a:hover, .arrival-top-navigation ul a:focus,.main-navigation ul li a:hover,.header-last-item.search-wrap:hover,.widget ul li a:hover,.site-footer a:hover,.site-main a:hover,.entry-meta > span:hover,.main-navigation a:hover,footer .widget_pages a:hover::before, footer .widget_pages a:focus::before, footer .widget_nav_menu a:hover::before, footer .widget_nav_menu a:focus::before,nav.navigation.post-navigation .nav-links a:hover::after,.site-main .entry-content a,.main-navigation .current-menu-item a{
		color:	<?php echo  arrival_sanitize_color($_theme_color);?>;
	}
	
	.scroll-top-top,.comment-reply-link, .comment-form .form-submit input,span.tags-links a:hover,.arrival-archive-navigation ul li a:hover,.arrival-archive-navigation ul li.active a,.header-last-item.search-wrap.header-btn a.header-cta-btn,.comment-reply-link, .comment-form .form-submit input{
		border-color: <?php echo  arrival_sanitize_color($_theme_color);?>;
	}
	
	p.woocommerce-mini-cart__buttons.buttons a:hover{
		background: <?php echo  arrival_hex2rgba($_theme_color,0.8);?>;
	}


	<?php 


	//top header bg
	$top_header_bg_color = get_theme_mod('arrival_top_header_bg_color',$defaults['arrival_top_header_bg_color']);
	
	if( $top_header_bg_color != '#e12454' ){ ?>
		.top-header-wrapp{
			background: <?php echo arrival_sanitize_color($top_header_bg_color); ?>;
		}
	<?php 
	}

	//top header text color
	$_top_header_txt_color = get_theme_mod('arrival_top_header_txt_color',$defaults['arrival_top_header_txt_color']);
	if($_top_header_txt_color){ ?>
		.top-header-wrapp a, .top-header-wrapp,header .cart-wrapper a{
			color: <?php echo arrival_sanitize_color($_top_header_txt_color); ?>;
		}
		.top-header-wrapp .phone-wrap:before{
			background: <?php echo arrival_sanitize_color($_top_header_txt_color); ?>;
		}
		.top-header-wrapp ul.social li a svg{
			fill: <?php echo arrival_sanitize_color($_top_header_txt_color); ?>;
		}
		.top-header-wrapp .site-header-cart svg{
			stroke: <?php echo arrival_sanitize_color($_top_header_txt_color); ?>;
		}
	<?php }

	//main nav bg color
	$main_nav_bg_color = get_theme_mod('arrival_main_nav_bg_color',$defaults['arrival_main_nav_bg_color']);

	if( $main_nav_bg_color ){ ?>
		
		.main-header-wrapp.boxed .container, .main-header-wrapp.full{
			background: <?php echo arrival_sanitize_color($main_nav_bg_color); ?>;
		}

	<?php 
	}

	//menu link color
	$main_nav_menu_color = get_theme_mod('arrival_main_nav_menu_color',$defaults['arrival_main_nav_menu_color']);
	
	if( $main_nav_menu_color ){ ?>

		.main-navigation ul li > a,.site-title a,.site-description,.header-last-item .search-wrap i,header .header-last-item .cart-wrapper a{
			color: <?php echo arrival_sanitize_color($main_nav_menu_color); ?>;
		}
		.main-navigation .dropdown-symbol, .arrival-top-navigation .dropdown-symbol{
			border-color: <?php echo arrival_sanitize_color($main_nav_menu_color); ?>;
		}

		.header-last-item.search-wrap .search-wrap svg{
			fill: <?php echo arrival_sanitize_color($main_nav_menu_color); ?>!important;
		}

	<?php 
	}

	//menu link color:Hover
	$main_nav_menu_color_hover = get_theme_mod('arrival_main_nav_menu_color_hover',$defaults['arrival_theme_color']);

	if( $main_nav_menu_color_hover != '#e12454' ){ ?>

		.main-navigation ul li a:hover,.main-navigation .current-menu-item a{
			color: <?php echo arrival_sanitize_color($main_nav_menu_color_hover); ?>;
		}
		.main-navigation ul li:hover .dropdown-symbol, .arrival-top-navigation ul li:hover.dropdown-symbol:hover{
			border-color: <?php echo arrival_sanitize_color($main_nav_menu_color_hover); ?>;
		}

		header.hover-layout-two .main-header-wrapp nav.main-navigation ul.arrival-main-navigation>li.menu-item>a:before{
			background: <?php echo arrival_sanitize_color($main_nav_menu_color_hover); ?>;
		}

	<?php 
	}


	//transparent header menu color
	$_main_nav_menu_color_transparent = get_theme_mod('arrival_main_nav_menu_color_transparent',$defaults['arrival_main_nav_menu_color']);
	
	if( $_main_nav_menu_color_transparent ){ ?>

		.home .arrival-transparent-header .main-navigation ul li > a,.home .arrival-transparent-header .site-title a,.home .arrival-transparent-header .site-description,.home .arrival-transparent-header .header-last-item .search-wrap i{
			color: <?php echo arrival_sanitize_color($_main_nav_menu_color_transparent); ?>;
		}
		.home .arrival-transparent-header .main-navigation .dropdown-symbol{
			border-color: <?php echo arrival_sanitize_color($_main_nav_menu_color_transparent); ?>;
		}

		.home .arrival-transparent-header .header-last-item.search-wrap .search-wrap svg{
			fill: <?php echo arrival_sanitize_color($_main_nav_menu_color_transparent); ?>!important;
		}
		.home header.arrival-transparent-header .header-last-item .cart-wrapper svg{
			stroke: <?php echo arrival_sanitize_color($_main_nav_menu_color_transparent); ?>!important;
		}

	<?php 
	}

	//header box-shadow
	$_header_box_shadow_disable = get_theme_mod('arrival_header_box_shadow_disable',$defaults['arrival_header_box_shadow_disable']);

	if( $_header_box_shadow_disable == true ){ ?>
		.main-header-wrapp.boxed .container, .main-header-wrapp.full{
			-webkit-box-shadow: unset;
			box-shadow: unset;
		}
	<?php 
	}

	//menu last item text align
	$_main_nav_last_item_align = get_theme_mod('arrival_main_nav_last_item_align',$defaults['arrival_main_nav_last_item_align']);

	?>
	.header-last-item{
		text-align: <?php echo esc_attr($_main_nav_last_item_align); ?>;
	}
	<?php 

	//container width
	$main_container_width = get_theme_mod('arrival_main_container_width',$defaults['arrival_main_container_width']);
	if( $main_container_width ){ ?>
		
		.container{
			max-width: <?php echo absint($main_container_width); ?>px;
		}
		.site{
			width: <?php echo absint($main_container_width); ?>px;
		}

	<?php 
	}

	//navigation paddings
	$_nav_header_padding = get_theme_mod('arrival_nav_header_padding',$defaults['arrival_nav_header_padding']);
	

	if( $_nav_header_padding != 0 ){
	?>
		.main-header-wrapp.boxed .container, .main-header-wrapp.full{
			padding: <?php echo absint($_nav_header_padding); ?>px 0;
		}
	<?php 	
	}

	/**
	* After top header height
	*
	*/
	$_after_top_hdr_top_padding = get_theme_mod('arrival_after_top_hdr_top_padding',$defaults[$prefix.'_after_top_hdr_top_padding']);
	$_after_top_hdr_btm_padding = get_theme_mod('arrival_after_top_hdr_btm_padding',$defaults[$prefix.'_after_top_hdr_btm_padding']);
	?>
	.after-top-header-wrapp{
			padding-top: <?php echo absint($_after_top_hdr_top_padding); ?>px;
			padding-bottom: <?php echo absint($_after_top_hdr_btm_padding); ?>px;
		}
	<?php 

	/**
	* After top header border top
	*/
	$_after_top_header_top_border_show = get_theme_mod('arrival_after_top_header_top_border_show',$defaults['arrival_after_top_header_top_border_show']);
	$_after_top_header_border_color = get_theme_mod('arrival_after_top_header_border_color',$defaults['arrival_after_top_header_border_color']);

	if( $_after_top_header_top_border_show ){ ?>
		.after-top-header-wrapp{
			border-top: 1px solid <?php  echo arrival_sanitize_color($_after_top_header_border_color);?>;
		}
	<?php 
	}

	/**
	* After top header colors
	*
	*/
	$_after_top_header_bg_color = get_theme_mod('arrival_after_top_header_bg_color',$defaults['arrival_after_top_header_bg_color']);
	$_after_top_header_txt_color = get_theme_mod('arrival_after_top_header_txt_color',$defaults['arrival_after_top_header_txt_color']);
	$_after_top_header_icon_color = get_theme_mod('arrival_after_top_header_icon_color',$defaults['arrival_after_top_header_icon_color']);

	?>
	
	.after-top-header-wrapp{
		background: <?php  echo arrival_sanitize_color($_after_top_header_bg_color);?>;
		color: 		<?php  echo arrival_sanitize_color($_after_top_header_txt_color);?>;
	}
	

	.after-top-header-wrapp .icon-wrap i{
		color: 		<?php  echo arrival_sanitize_color($_after_top_header_icon_color);?>;
	}
	<?php 

	/**
	* breadcrumb layout / inner page header layout
	* 
	*  
	*/
	
	$_page_header_layout = get_theme_mod('arrival_page_header_layout',$defaults['arrival_page_header_layout']);

	//inner page header bg image
	$_inner_header_image = get_theme_mod('arrival_inner_header_image');
	?>
		.arrival-breadcrumb-wrapper{
			background-image: url(<?php echo esc_url($_inner_header_image); ?>);
		}
		
	<?php 
	//header padding inner /breadcrumb height
	$_inner_header_image_padding_btm = get_theme_mod('arrival_inner_header_image_padding_btm',$defaults['arrival_inner_header_image_padding_btm']);

	if( $_inner_header_image_padding_btm && $_page_header_layout == 'default' ){ ?>
		body.arrival-inner-page .site-header{
			padding-bottom: <?php echo absint($_inner_header_image_padding_btm); ?>px;
		}
		.arrival-breadcrumb-wrapper{
			padding-top: <?php echo absint($_inner_header_image_padding_btm); ?>px;
			padding-bottom: <?php echo absint($_inner_header_image_padding_btm); ?>px;
		}	
	<?php 
	}else{ ?>
		.arrival-breadcrumb-wrapper{
			padding-top: <?php echo absint($_inner_header_image_padding_btm); ?>px;
			padding-bottom: <?php echo absint($_inner_header_image_padding_btm); ?>px;
		}
	<?php 
	}

	//inner page header image position
	$_inner_header_img_position = get_theme_mod('arrival_inner_header_img_position',$defaults['arrival_inner_header_img_position']);

	if( $_inner_header_img_position && $_page_header_layout == 'default' ){ ?>
		body.arrival-inner-page .site-header{
			background-position: <?php echo esc_attr($_inner_header_img_position); ?>;
		}
	<?php 
	}else{ ?>
		.arrival-breadcrumb-wrapper{
			background-position: <?php echo esc_attr($_inner_header_img_position); ?>;
		}
	<?php 
	}

	//buttons border-radius
	$_all_btn_radius_top 	= get_theme_mod('arrival_all_btn_radius_top');
	$_all_btn_radius_right 	= get_theme_mod('arrival_all_btn_radius_right');
	$_all_btn_radius_btm 	= get_theme_mod('arrival_all_btn_radius_btm');
	$_all_btn_radius_left 	= get_theme_mod('arrival_all_btn_radius_left');

	if( $_all_btn_radius_top || $_all_btn_radius_right || $_all_btn_radius_btm || $_all_btn_radius_left ){ ?>

		.header-last-item.search-wrap.header-btn,.comment-reply-link, .comment-form .form-submit input,.woocommerce #respond input#submit,.woocommerce div.product form.cart .button
		{
			border-radius: <?php echo absint($_all_btn_radius_top).'px '. absint($_all_btn_radius_right).'px '.absint($_all_btn_radius_btm).'px '. absint($_all_btn_radius_left).'px' ?>;
		}

	<?php }

	//navigation font-weight
	$_nav_font_weight = get_theme_mod('arrival_nav_font_weight',$defaults['arrival_nav_font_weight']);
	?>
	.main-navigation a,.header-last-item.search-wrap.header-btn a.header-cta-btn{
		font-weight: <?php echo absint($_nav_font_weight); ?>;
	}

	<?php 
	// site link colors
	$arrival_link_color 		= get_theme_mod('arrival_link_color',$defaults['arrival_link_color']);
	$arrival_link_color_hover 	= get_theme_mod('arrival_link_color_hover',$defaults['arrival_theme_color']);

	if($arrival_link_color != $defaults['arrival_link_color'] ){
	?>
		a,a:visited,.site-main a{
			color: <?php  echo arrival_sanitize_color($arrival_link_color);?>;
		}

	<?php } ?>
	<?php if( $arrival_link_color_hover != $defaults['arrival_theme_color'] ){ ?>
			
			a:hover,.site-main a:hover{
				color: <?php  echo arrival_sanitize_color($arrival_link_color_hover);?>;
			}

	<?php }

	//footer background color
	$_footer_bg_color 	= get_theme_mod('arrival_footer_bg_color',$defaults['arrival_footer_bg_color']);
	$_footer_text_color = get_theme_mod('arrival_footer_text_color',$defaults['arrival_footer_text_color']);
	$_footer_link_color = get_theme_mod('arrival_footer_link_color',$defaults['arrival_footer_link_color']);

	if( $_footer_bg_color != $defaults['arrival_footer_bg_color'] ){ ?>

		.site-footer{
			background: <?php echo arrival_sanitize_color($_footer_bg_color);?>;
		}

	<?php }

	if( $_footer_text_color != $defaults['arrival_footer_text_color'] ){ ?>

		.site-footer h2.widget-title,.site-footer{
			color: <?php echo arrival_sanitize_color($_footer_text_color);?>;
		}

		.site-footer svg{
			fill: <?php echo arrival_sanitize_color($_footer_text_color);?>;
		}

	<?php
	}

	if( $_footer_link_color != $defaults['arrival_footer_link_color'] ){ ?>

		.site-footer ul li a,.site-footer a{
			color: <?php echo arrival_sanitize_color($_footer_link_color);?>;
		}

	<?php
	}

	//metabox styles for breadcrumbs
	$ultra_page_banner_bg_color = arrival_get_post_meta('ultra_page_banner_bg_color');
	$ultra_page_banner_bg_image = arrival_get_post_meta('ultra_page_banner_bg_image');
	$ultra_page_banner_height 	= arrival_get_post_meta('ultra_page_banner_height');


	if( $ultra_page_banner_bg_color ){ ?>
		body.arrival-inner-page .site-header{
			background: <?php echo arrival_sanitize_color($ultra_page_banner_bg_color);?>;
		}
	<?php 
	}

	if( $ultra_page_banner_bg_image ){
		 $image_path = wp_get_attachment_image_src( $ultra_page_banner_bg_image, 'full', true );
	 ?>
		body.arrival-inner-page .site-header{
			background: url(<?php echo esc_url($image_path[0]);?>);
		}
	<?php 
	}

	if( $ultra_page_banner_height ){ ?>
		.arrival-breadcrumb-wrapper{
			padding-top: <?php echo absint($ultra_page_banner_height);?>px;
			padding-bottom: <?php echo absint($ultra_page_banner_height);?>px;
		}
	<?php 
	}

	//page bg color
	$ultra_page_bg_color = arrival_get_post_meta('ultra_page_bg_color');
	if( $ultra_page_bg_color ){ ?>
		body{
		 background-color: <?php echo arrival_sanitize_color($ultra_page_bg_color); ?>
		}
	<?php 
	}

	//custom style from metabox
	$ultra_page_custom_css = arrival_get_post_meta('ultra_page_custom_css');
	if( $ultra_page_custom_css ){

		echo esc_html($ultra_page_custom_css); 
	}

	/***
	* Header background color from page metabox
	*
	* @since 1.3.3
	*/
	$ultra_arrival_header_bg_color 		= arrival_get_post_meta('ultra_arrival_header_bg_color');
	$ultra_arrival_header_link_color 	= arrival_get_post_meta('ultra_arrival_header_link_color');
	

	if( $ultra_arrival_header_bg_color ){ ?>
		header .main-header-wrapp.full{
			background: <?php echo arrival_sanitize_color($ultra_arrival_header_bg_color); ?>
		}
		.main-header-wrapp.boxed .container, .main-header-wrapp.full{
			box-shadow: unset;
			-webkit-box-shadow:unset;
		}
	<?php }

		if( $ultra_arrival_header_link_color ){ ?>
		.main-navigation ul li > a, .site-title a, .site-description, .header-last-item .search-wrap i, header .header-last-item .cart-wrapper a{
			color: <?php echo arrival_sanitize_color($ultra_arrival_header_link_color); ?>
		}
		.main-navigation .dropdown-symbol, .arrival-top-navigation .dropdown-symbol{
			border-color: <?php echo arrival_sanitize_color($ultra_arrival_header_link_color); ?>
		}
	<?php }



	/**
	 * Boxed Header & After top header fix
	 * @since 1.4.1
	 * 
	 */ 
	$arrival_main_nav_layout = get_theme_mod('arrival_main_nav_layout',$defaults['arrival_main_nav_layout']);
	$arrival_after_top_header_enable = get_theme_mod('arrival_after_top_header_enable',$defaults['arrival_after_top_header_enable']);

	if($arrival_main_nav_layout == 'boxed' && $arrival_after_top_header_enable == 'yes' ){ ?>
 		.main-header-overlap .main-header-wrapp.boxed.on {
		    top: 140px;
		}
	<?php 
	}

	if($arrival_main_nav_layout == 'boxed' ){ ?>
 		.arrival-breadcrumb-wrapper {
		    padding-top: 55px;
		}
	<?php 
	}


	/**
	* Additional settings
	* @since 1.2.7
	*/
	$_main_logo_width = get_theme_mod('arrival_main_logo_width',$defaults['arrival_main_logo_width']);
	if($_main_logo_width != 100 ){ ?>
		.site-header .site-branding img{
		 max-width: <?php echo absint($_main_logo_width); ?>%
		}
	<?php 
	}



	$hook_css = '';
	$dynamic_hook = apply_filters('arrival_dynamic_styles_dev',$hook_css);



	$custom_css = ob_get_clean();
	$custom_css = arrival_css_strip_whitespace( $custom_css );

        
wp_add_inline_style( 'arrival-responsive', $custom_css );

}
add_action( 'wp_enqueue_scripts', 'arrival_dynamic_styles' );
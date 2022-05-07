<?php 
/**
 * Register Google Fonts
 */
function arrival_me_fonts_url() {
    $fonts_url = '';

    $poppins = esc_html_x( 'on', 'Poppins font: on or off', 'arrival-me' );

    $font_families = array();

    if ( 'off' !== $poppins ) {
        $font_families[] = 'Poppins:300,400,500,600,700';
    }

    if ( in_array( 'on', array(  $poppins ) ) ) {
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );

        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }

    return esc_url_raw( $fonts_url );

}


add_action( 'wp_enqueue_scripts', 'arrival_me_scripts' );
function arrival_me_scripts() {

    $themeVersion = wp_get_theme()->get('Version');
    wp_enqueue_style('arrival-me-styles', get_template_directory_uri() . '/style.css',array(), $themeVersion);
    wp_enqueue_style( 'arrival-me-fonts', arrival_me_fonts_url(), array(), null );

}


/**
 * Get default theme options and replace with new values
 *
 * @since 1.0.0
 *
 * @return array Default theme options.
 */
add_filter('arrival_filter_default_theme_options','arrival_me_get_default_theme_options');
function arrival_me_get_default_theme_options() {
    $prefix = 'arrival';
    $defaults = array();
    
    $defaults[$prefix.'_top_header_enable']                 = 'off';
    $defaults[$prefix.'_top_header_email']                  = '';
    $defaults[$prefix.'_top_header_phone']                  = '';
    $defaults[$prefix.'_top_right_header_content']          = 'menus';
    $defaults[$prefix.'_blog_layout']                       = 'list-layout';
    $defaults[$prefix.'_top_right_header_menus']            = 'top';
    $defaults[$prefix.'_main_nav_layout']                   = 'full';
    $defaults[$prefix.'_main_nav_right_content']            = 'button';
    $defaults[$prefix.'_main_nav_right_btn_txt']            = esc_html('Contact Us','arrival-me');
    $defaults[$prefix.'_main_nav_right_btn_url']            = '#';
    $defaults[$prefix.'_page_header_layout']                = 'default';
    $defaults[$prefix.'_menu_hover_styles']                 = 'hover-layout-one';
    $defaults[$prefix.'_one_page_menus']                    = 'no';
    $defaults[$prefix.'_footer_widget_enable']              = 'no';
    $defaults[$prefix.'_footer_icons_enable']               = 'yes';
    $defaults[$prefix.'_lazyload_image_enable']             = 'yes';
    $defaults[$prefix.'_smooth_scroll_enable']              = 'no';
    $defaults[$prefix.'_top_header_bg_color']               = '#fbd214';
    $defaults[$prefix.'_main_nav_bg_color']                 = '#fafafa';
    $defaults[$prefix.'_footer_bg_color']                   = '#223645';
    $defaults[$prefix.'_footer_text_color']                 = '#fff';
    $defaults[$prefix.'_footer_link_color']                 = '#fff';
    $defaults[$prefix.'_footer_copyright_border_top']       = false;
    $defaults[$prefix.'_breadcrumb_overlay_disable']        = true;
    $defaults[$prefix.'_main_nav_menu_color']               = '#333';
    $defaults[$prefix.'_link_color']                        = '#333';
    $defaults[$prefix.'_main_container_width']              = 1170;
    $defaults[$prefix.'_inner_header_image_padding_btm']    = 32;
    $defaults[$prefix.'_inner_header_img_position']         = 'initial';
    $defaults[$prefix.'_sidebar_width']                     = 440;
    $defaults[$prefix.'_header_box_shadow_disable']         = false;
    $defaults[$prefix.'_blog_excerpts']                     = 580;
    $defaults[$prefix.'_single_post_sidebars']              = 'no_sidebar';
    $defaults[$prefix.'_nav_font_weight']                   = 500;
    $defaults[$prefix.'_top_header_txt_color']              = '#fff';
    $defaults[$prefix.'_theme_color']                       = '#fbd214';
    $defaults[$prefix.'_top_left_content_type']             = 'contacts';
    $defaults[$prefix.'_top_header_txt']                    = '';
    $defaults[$prefix.'_main_nav_menu_align']               = 'default';
    $defaults[$prefix.'_main_nav_last_item_align']          = 'left';
    $defaults[$prefix.'_after_top_header_enable']           = 'no';
    $defaults[$prefix.'_main_nav_disable_logo']             = 'no';
    $defaults[$prefix.'_after_top_header_height']           = 150;
    $defaults[$prefix.'_after_top_hdr_top_padding']         = 30;
    $defaults[$prefix.'_after_top_hdr_btm_padding']         = 75;
    $defaults[$prefix.'_after_top_header_top_border_show']  = false;
    $defaults[$prefix.'_after_top_header_align_center']     = false;
    $defaults[$prefix.'_after_top_header_bg_color']         = '#fff';
    $defaults[$prefix.'_after_top_header_txt_color']        = '#333';
    $defaults[$prefix.'_after_top_header_border_color']     = '#f1f1f1';
    $defaults[$prefix.'_after_top_header_icon_color']       = '#333';
    $defaults[$prefix.'_cart_display_position']             = 'top';
    $defaults[$prefix.'_site_header_type']                  = 'default';
    $defaults[$prefix.'_site_header_custom_template']       = 0;
    $defaults[$prefix.'_site_footer_type']                  = 'default';
    $defaults[$prefix.'_site_footer_custom_template']       = 0;
    $defaults[$prefix.'_nav_header_padding']                = 0;
    $defaults[$prefix.'_transparent_header_enable']         = false;
    $defaults[$prefix.'_social_icons_new_tab']              = false;
    $defaults[$prefix.'_breadcrumb_enable']                = 'yes';
    $defaults[$prefix.'_main_nav_menu_color_transparent']  = '#333';
   
    $defaults[$prefix.'_main_logo_width']                   = 100;
    $defaults[$prefix.'_single_page_sidebars']              = 'no_sidebar';
    $defaults[$prefix.'_post_featured_image_enable']        = 'yes';
    $defaults[$prefix.'_blog_page_sidebars']                = 'no_sidebar';
    $defaults[$prefix.'_post_meta_enable']                  = 'yes';
    $defaults[$prefix.'_post_author_enable']                = 'yes';
    $defaults[$prefix.'_post_date_enable']                  = 'yes';
    $defaults[$prefix.'_post_comment_enable']               = 'yes';

if( class_exists('woocommerce')):
    $defaults[$prefix.'_archive_shop_sidebars']             = 'no_sidebar';
    $defaults[$prefix.'_single_shop_sidebars']              = 'no_sidebar';
endif;

	return $defaults;

}
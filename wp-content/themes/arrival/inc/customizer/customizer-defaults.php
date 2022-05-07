<?php
/**
 * Default theme options.
 *
 * @package arrival
 */

if (!function_exists('arrival_get_default_theme_options')):

/**
 * Get default theme options
 *
 * @since 1.0.0
 *
 * @return array Default theme options.
 */
function arrival_get_default_theme_options() {
    $prefix = 'arrival';
    $defaults = array();
    
    $defaults[$prefix.'_top_header_enable']                 = 'on';
    $defaults[$prefix.'_top_header_email']                  = '';
    $defaults[$prefix.'_top_header_phone']                  = '';
    $defaults[$prefix.'_top_right_header_content']          = 'menus';
    $defaults[$prefix.'_blog_layout']                       = 'list-layout';
    $defaults[$prefix.'_top_right_header_menus']            = 'top';
    $defaults[$prefix.'_main_nav_layout']                   = 'full';
    $defaults[$prefix.'_main_nav_right_content']            = 'search';
    $defaults[$prefix.'_main_nav_right_btn_txt']            = esc_html__('Contact Us','arrival');
    $defaults[$prefix.'_main_nav_right_btn_url']            = '#';
    $defaults[$prefix.'_page_header_layout']                = 'default';
    $defaults[$prefix.'_menu_hover_styles']                 = 'hover-layout-one';
    $defaults[$prefix.'_one_page_menus']                    = 'no';
    $defaults[$prefix.'_footer_widget_enable']              = 'yes';
    $defaults[$prefix.'_footer_icons_enable']               = 'yes';
    $defaults[$prefix.'_lazyload_image_enable']             = 'yes';
    $defaults[$prefix.'_smooth_scroll_enable']              = 'no';
    $defaults[$prefix.'_top_header_bg_color']               = '#E12454';
    $defaults[$prefix.'_main_nav_bg_color']                 = '#fff';
    $defaults[$prefix.'_footer_bg_color']                   = '#223645';
    $defaults[$prefix.'_footer_text_color']                 = '#fff';
    $defaults[$prefix.'_footer_link_color']                 = '#fff';
    $defaults[$prefix.'_footer_copyright_border_top']       = true;
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
    $defaults[$prefix.'_theme_color']                       = '#E12454';
    $defaults[$prefix.'_top_left_content_type']             = 'contacts';
    $defaults[$prefix.'_top_header_txt']                    = '';
    $defaults[$prefix.'_main_nav_menu_align']               = 'default';
    $defaults[$prefix.'_main_nav_last_item_align']          = 'left';
    $defaults[$prefix.'_after_top_header_enable']           = 'no';
    $defaults[$prefix.'_main_nav_disable_logo']             = 'no';
    $defaults[$prefix.'_after_top_header_height']           = 150;
    $defaults[$prefix.'_after_top_hdr_top_padding']         = 30;
    $defaults[$prefix.'_after_top_hdr_btm_padding']         = 30;
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
    $defaults[$prefix.'_breadcrumb_enable']                 = 'yes';
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

    
   

   

    // Pass through filter.
    $defaults = apply_filters('arrival_filter_default_theme_options', $defaults);

	return $defaults;

}

endif;

<?php
/**
 * Tabs test file
 *
 * @package Arrival
 * @since 1.0.1
 */


function arrival_tabs_customize_register( $wp_customize ) {

if ( class_exists( 'Arrival_Customize_Control_Tabs' ) ) {

$prefix = 'arrival';
		

/**
* main navigation header tabs
*
*/
$wp_customize->add_setting( $prefix.'_main_nav_header_tabs', array(
                'sanitize_callback' => 'sanitize_text_field',
            ));

$wp_customize->add_control( new Arrival_Customize_Control_Tabs( $wp_customize, $prefix.'_main_nav_header_tabs', array(
                    'section' => $prefix.'_main_header_options_panel',
                    'tabs'    => array(

                        'general' => array(
                            'nicename' => esc_html__( 'Main Bar', 'arrival' ),
                            'controls' => apply_filters($prefix.'_header_options',array(
                                
                                $prefix.'_site_header_type',
                                $prefix.'_site_header_custom_template',
                                $prefix.'_main_nav_layout',
                                $prefix.'_main_nav_disable_logo',
                                $prefix.'_main_nav_menu_align',
                                $prefix.'_cart_display_position',
                                $prefix.'_nav_last_item_sep',
                                $prefix.'_main_nav_right_content',
                                $prefix.'_main_nav_right_btn_txt',
                                $prefix.'_main_nav_right_btn_url',
                                $prefix.'_main_nav_last_item_align',
                                $prefix.'_single_nav_enable_sep',
                                $prefix.'_one_page_menus',
                                $prefix.'_header_section_info',
                                
                            )),
                        ),

                        'top' => array(
                            'nicename' => esc_html__( 'Top Bar', 'arrival' ),
                            'controls' => apply_filters($prefix.'_header_top_options',array(
                                
                                $prefix.'_top_header_enable',
                                $prefix.'_top_left_options',
                                $prefix.'_top_left_content_type',
                                $prefix.'_top_header_email',
                                $prefix.'_top_header_phone',
                                $prefix.'_top_header_txt',
                                $prefix.'_top_right_options',
                                $prefix.'_top_right_header_content',
                                $prefix.'_top_social_redirect_btn',
                                $prefix.'_top_right_header_menus',
                                $prefix.'_top_header_after_seperator',
                                $prefix.'_after_top_header_enable',
                                $prefix.'_after_top_hdr_padding',
                                $prefix.'_after_top_header_top_border_show',
                                $prefix.'_after_top_header_align_center',
                                $prefix.'_header_section_info',
                                
                            )),
                        ),

                        'styles' => array(
                            'nicename' => esc_html__( 'Styles', 'arrival' ),
                            'controls' => apply_filters($prefix.'_header_nav_options_styles',array(
                                
                                $prefix.'_main_nav_bg_color',
                                $prefix.'_main_nav_menu_color',
                                $prefix.'_main_nav_menu_color_hover',
                                $prefix.'_transparent_hdr_styles_seperatpr',
                                $prefix.'_transparent_header_enable',
                                $prefix.'_main_nav_menu_color_transparent',
                                $prefix.'_hdr_addi_styles_seperatpr',
                                $prefix.'_nav_header_padding',
                                $prefix.'_nav_font_weight',
                                $prefix.'_header_box_shadow_disable',
                                $prefix.'_menu_hover_styles',
                                
                                $prefix.'_top_hdr_styles_seperatpr',
                                $prefix.'_top_header_bg_color',
                                $prefix.'_top_header_txt_color',
                                $prefix.'_after_top_hdr_styles_seperatpr',
                                $prefix.'_after_top_header_bg_color',
                                $prefix.'_after_top_header_txt_color',
                                $prefix.'_after_top_header_border_color',
                                $prefix.'_after_top_header_icon_color',
                                $prefix.'_header_section_info',
                                

                            ) ),
                        ),
                       
                    ),
                )
            )
        );



/**
* Footer section tabs
*
*/
$wp_customize->add_setting( $prefix.'_footer_control_tabs', array(
                'sanitize_callback' => 'sanitize_text_field',
            ));

$wp_customize->add_control( new Arrival_Customize_Control_Tabs( $wp_customize, $prefix.'_footer_control_tabs', array(
                    'section' => $prefix.'_footer_settings',
                    'tabs'    => array(

                        'general' => array(
                            'nicename' => esc_html__( 'General', 'arrival' ),
                            'controls' => apply_filters($prefix.'_footer_options',array(
                                
                                $prefix.'_site_footer_type',
                                $prefix.'_site_footer_custom_template',
                                $prefix.'_footer_widget_enable',
                                $prefix.'_footer_copyright_text',
                                $prefix.'_footer_icons_enable',
                                $prefix.'_footer_social_redirect_btn',
                                $prefix.'_footer_settings_info',

                                )
                            ),
                        ),

                        'styles' => array(
                            'nicename' => esc_html__( 'Styles', 'arrival' ),
                            'controls' => apply_filters($prefix.'_footer_options_styles', array(

                                $prefix.'_footer_bg_color',
                                $prefix.'_footer_copyright_border_top',
                                $prefix.'_footer_settings_info',
                                $prefix.'_footer_text_color',
                                $prefix.'_footer_link_color',

                                )
                            ),
                        ),
                       
                    ),
                )
            )
        );


		
	}

}
add_action( 'customize_register', 'arrival_tabs_customize_register' );

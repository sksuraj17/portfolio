<?php
//  =============================
//  = Default Theme Customizer Settings  =
     //  @ portfoliolite Theme
//  =============================
/*theme customizer*/
function portfoliolite_customize_register( $wp_customize ){
   
 $palette = array(
        'rgba(255, 0, 0, 0.7)',
        'rgba(54, 0, 170, 0.8)',
        '#FFCC00',
        'rgba( 20, 20, 20, 0.8 )',
        '#666666',
        '#F5f5f5',
        '#2B4267'
    );
 //  =============================
 //  = Site Settings     =
 //  =============================
$wp_customize->add_panel( 'portfoliolite-panel-default', array(
    'priority'       => 2,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'    => __( 'Wordpress Default', 'portfoliolite' ),
    'description'    => '',
) );
$wp_customize->get_section( 'title_tagline' )->panel = 'portfoliolite-panel-default';
$wp_customize->get_section( 'static_front_page' )->panel = 'portfoliolite-panel-default';
$wp_customize->get_section( 'custom_css' )->panel = 'portfoliolite-panel-default';
$wp_customize->get_section( 'header_image' )->panel = 'portfoliolite-panel-default';
$wp_customize->get_section( 'background_image' )->panel = 'portfoliolite-panel-default';

$wp_customize->get_section('title_tagline')->title = esc_html__('Site Identity', 'portfoliolite');
$wp_customize->get_section('title_tagline')->priority = 2;
   //Menu Options
    $wp_customize->add_setting('title_disable', array(
        'default'           => 'enable',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_checkbox',
    ));
    $wp_customize->add_control('title_disable', array(
    'label'    => __('Display Site Title & Tagline', 'portfoliolite'),
    'section'  => 'title_tagline',
    'settings' => 'title_disable',
    'type'       => 'checkbox',
    'choices'    => array(
    'enable' => 'Display Site Title & Tagline',
        ),
    ));
    // site identity doc link
    $wp_customize->add_setting('portfoliolite_idententity_doc', array(
    'sanitize_callback' => 'portfoliolite_sanitize_text',
    ));
     $wp_customize->add_control(new Portfoliolite_Misc_Control( $wp_customize, 'portfoliolite_idententity_doc',
            array(
        'section'    => 'title_tagline',
        'type'      => 'doc-link',
        'url'       => 'https://themehunk.com/docs/portfoliolite-theme/#site-identity',
        'description' => esc_html__( 'To know more go with this', 'portfoliolite' ),
        'priority'   =>100,
    )));
      // home page doc link
    $wp_customize->add_setting('portfoliolite_homepage_doc', array(
    'sanitize_callback' => 'portfoliolite_sanitize_text',
    ));
    $wp_customize->add_control(new Portfoliolite_Misc_Control( $wp_customize, 'portfoliolite_homepage_doc',
            array(
        'section'    => 'static_front_page',
        'type'      => 'doc-link',
        'url'       => 'https://themehunk.com/docs/portfoliolite-theme/#homepage-setting',
        'description' => esc_html__( 'To know more go with this', 'portfoliolite' ),
        'priority'   =>100,
    )));
//header-area add
 $wp_customize->add_section('portfoliolite_header_area', array(
        'title'    => __('Header Settings', 'portfoliolite'),
        'priority' => 2,
    ));

$wp_customize->add_setting('portfoliolite_header_fxd', array(
        'default'        =>'on',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_radio',
    ));
$wp_customize->add_control( 'portfoliolite_header_fxd', array(
        'settings' => 'portfoliolite_header_fxd',
        'label'   => __('Header','portfoliolite'),
        'type'    => 'radio',
        'section' => 'portfoliolite_header_area',
        'choices'    => array(
            'on'        =>'Sticky',
            'off'      => 'Static',
        ),
    ));
// add menu style
$wp_customize->add_setting('portfoliolite_menu_style', array(
        'default'        =>'on',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_radio',
    ));
    $wp_customize->add_control( 'portfoliolite_menu_style', array(
        'settings' => 'portfoliolite_menu_style',
        'label'   => __('Menu Style','portfoliolite'),
        'type'    => 'radio',
        'section' => 'portfoliolite_header_area',
        'choices'    => array(
            'on'        =>'Inline',
            'off'      => 'centered',
            
        ),
    ));
// header visibility hidden
    $wp_customize->add_setting('portfoliolite_header_hide', array(
       'default'        => '',
       'capability'     => 'edit_theme_options',
       'sanitize_callback' => 'portfoliolite_sanitize_checkbox'
   ));
   $wp_customize->add_control( 'portfoliolite_header_hide', array(
       'settings' => 'portfoliolite_header_hide',
       'label'   => __('Header Visibility','portfoliolite'),
       'description' => __('(If this box is checked the header will toggle on front page)','portfoliolite'),
       'section' => 'portfoliolite_header_area',
       'type'    => 'checkbox',
       'choices'    => array(
       'image'      => 'Use Background Image',
       ),
   ));
   // header doc link
    $wp_customize->add_setting('portfoliolite_header_doc', array(
    'sanitize_callback' => 'portfoliolite_sanitize_text',
    ));
    $wp_customize->add_control(new Portfoliolite_Misc_Control( $wp_customize, 'portfoliolite_header_doc',
            array(
        'section'    => 'portfoliolite_header_area',
        'type'      => 'doc-link',
        'url'       => 'https://themehunk.com/docs/portfoliolite-theme/#header-Setting',
        'description' => esc_html__( 'To know more go with this', 'portfoliolite' ),
        'priority'   =>100,
    )));
//------- start footer contact detail--------//
$portfoliolite_cnt_panel = new Portfoliolite_WP_Customize_Section( $wp_customize, 'portfoliolite_cnt_panel', array(
    'title'    => __( 'Contact Section', 'portfoliolite' ),
    'panel'    => 'portfoliolite_footr_panel',
    'priority' => 1,
  ));
$wp_customize->add_section( $portfoliolite_cnt_panel );


$cnt_settings = new Portfoliolite_WP_Customize_Section( $wp_customize, 'cnt_settings', array(
    'title'    => __( 'Settings', 'portfoliolite' ),
    'panel'    => 'portfoliolite_footr_panel',
    'section'    => 'portfoliolite_cnt_panel',
    'priority' => 2,
  ));
$wp_customize->add_section( $cnt_settings );
   
$wp_customize->add_setting('portfoliolite_eml_icon_', array(
        'default'           => __('fa fa-envelope-o','portfoliolite'),
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_text',
         
    ));
    $wp_customize->add_control('portfoliolite_eml_icon_', array(
        'label'       => __('Email Detail', 'portfoliolite'),
        'section'     => 'cnt_settings',
        'settings'    => 'portfoliolite_eml_icon_',
        'type'        => 'text',
        'description' => __('Fontawesome-Icon','portfoliolite'),
    ));
$wp_customize->add_setting('portfoliolite_eml_txt_', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_email',
         'transport'      => 'postMessage'
    ));
    $wp_customize->add_control('portfoliolite_eml_txt_', array(
        'label'    => '',
        'section'  => 'cnt_settings',
        'settings' => 'portfoliolite_eml_txt_',
         'type'       => 'email',
         'description' => __('Email-Address','portfoliolite'),
    ));
//address
$wp_customize->add_setting('portfoliolite_add_icon_', array(
        'default'           => __('fa fa-map-marker','portfoliolite'),
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_text',
         
    ));
    $wp_customize->add_control('portfoliolite_add_icon_', array(
        'label'    => __('Address Detail', 'portfoliolite'),
        'section'  => 'cnt_settings',
        'settings' => 'portfoliolite_add_icon_',
         'type'       => 'text',
         'description' => __('Fontawesome-Icon','portfoliolite'),
    ));
$wp_customize->add_setting('portfoliolite_add_txt_', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_text',
        'transport'      => 'postMessage'
         
    ));
    $wp_customize->add_control('portfoliolite_add_txt_', array(
        'label'    => '',
        'section'  => 'cnt_settings',
        'settings' => 'portfoliolite_add_txt_',
         'type'       => 'text',
         'description' => __('Address','portfoliolite'),
    ));
//mobile
$wp_customize->add_setting('portfoliolite_mob_icon_', array(
        'default'           => __('fa fa-mobile','portfoliolite'),
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_text',
         
    ));
    $wp_customize->add_control('portfoliolite_mob_icon_', array(
        'label'    => __('Contact Detail', 'portfoliolite'),
        'section'  => 'cnt_settings',
        'settings' => 'portfoliolite_mob_icon_',
         'type'       => 'text',
         'description' => __('Fontawesome-Icon','portfoliolite'),
    ));
$wp_customize->add_setting('portfoliolite_mob_txt_', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_phone_number',
        'transport'      => 'postMessage'
         
    ));
$wp_customize->add_control('portfoliolite_mob_txt_', array(
        'label'    => '',
        'section'  => 'cnt_settings',
        'settings' => 'portfoliolite_mob_txt_',
         'type'       => 'number',
         'description' => __('Contact Number','portfoliolite'),
    ));
// doc link
$wp_customize->add_setting('portfoliolite_cnt_doc', array(
    'sanitize_callback' => 'portfoliolite_sanitize_text',
    ));
$wp_customize->add_control(new Portfoliolite_Misc_Control( $wp_customize, 'portfoliolite_cnt_doc',
            array(
        'section'     => 'cnt_settings',
        'type'        => 'doc-link',
        'url'         => 'https://themehunk.com/docs/portfoliolite-theme/#contact-section',
        'description' => esc_html__( 'To know more go with this', 'portfoliolite' ),
        'priority'    =>100,
    )));

$portfoliolite_cnt_background = new Portfoliolite_WP_Customize_Section( $wp_customize, 'portfoliolite_cnt_background', array(
    'title'    => __( 'Color & Bg', 'portfoliolite' ),
     'panel'    => 'portfoliolite_footr_panel',
    'section'    => 'portfoliolite_cnt_panel',
    'priority' => 2,
  ));
$wp_customize->add_section( $portfoliolite_cnt_background );

//images
$wp_customize->add_setting('portfoliolite_cnt_bg_image', array(
        'default'        => '',
        'capability'    => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_upload'
    ));
$wp_customize->add_control( new WP_Customize_Image_Control(
        $wp_customize, 'portfoliolite_cnt_bg_image', array(
        'label'    => __('Upload Background Image', 'portfoliolite'),
        'section'  => 'portfoliolite_cnt_background',
        'settings' => 'portfoliolite_cnt_bg_image',
))); 
$wp_customize->add_setting('portfoliolite_cnt_img_overly_color',array(
            'default'     => 'rgba(41, 41, 41, 0.5)',
            'capability'  => 'edit_theme_options',
            'sanitize_callback' => 'portfoliolite_sanitize_color',
 ) );
$wp_customize->add_control(
        new Portfoliolite_Customizer_Color_Control($wp_customize,
            'portfoliolite_cnt_img_overly_color',
              array(
                'label'     => __('Background Color', 'portfoliolite' ),
                'description'=>__('Image Overlay & Background Color Change','portfoliolite'),
                'section'   => 'portfoliolite_cnt_background',
                'settings'  => 'portfoliolite_cnt_img_overly_color',
            ) ));

$wp_customize->add_setting('portfoliolite_cnt_icon_color', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_color'
    ));
    $wp_customize->add_control( 
    new WP_Customize_Color_Control($wp_customize,'portfoliolite_cnt_icon_color', array(
        'label'      => __('Icon Color', 'portfoliolite' ),
        'section'    => 'portfoliolite_cnt_background',
        'settings'   => 'portfoliolite_cnt_icon_color',
    ) ) );

    $wp_customize->add_setting('portfoliolite_cnt_icon_text_color', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_color'
    ));
    $wp_customize->add_control( 
    new WP_Customize_Color_Control($wp_customize,'portfoliolite_cnt_icon_text_color', array(
        'label'      => __('Icon Text Color', 'portfoliolite' ),
        'section'    => 'portfoliolite_cnt_background',
        'settings'   => 'portfoliolite_cnt_icon_text_color',
    ) ) );  
//----------- End footer contact detail--------------//
// custom color
 $wp_customize->get_section('colors')->title = esc_html__('Global Color', 'portfoliolite');
 $wp_customize->get_section('colors')->priority = 31;

 $wp_customize->add_setting('portfoliolite_theme_color', array(
        'default'           => '#ff6c54',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_color',
    ));
$wp_customize->add_control( new WP_Customize_Color_Control(
    $wp_customize, 
    'portfoliolite_theme_color', array(
        'label'      => __( 'Theme Color', 'portfoliolite' ),
        'section'    => 'colors',
        'settings'   => 'portfoliolite_theme_color',
    ) ) 
);
// doc link
    $wp_customize->add_setting('portfoliolite_glb_doc', array(
    'sanitize_callback' => 'portfoliolite_sanitize_text',
    ));
    $wp_customize->add_control(new Portfoliolite_Misc_Control( $wp_customize, 'portfoliolite_glb_doc',
            array(
        'section'     => 'colors',
        'type'        => 'doc-link',
        'url'         => 'https://themehunk.com/docs/portfoliolite-theme/#global-color',
        'description' => esc_html__( 'To know more go with this', 'portfoliolite' ),
        'priority'    =>100,
    )));
//footer
$wp_customize->add_panel( 'portfoliolite_footr_panel', array(
        'priority'       => 30,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => __('Footer Settings', 'portfoliolite'),
        'description'    => '',
    )); 
$wp_customize->add_section( 'portfoliolite_foothd_delt', array(
     'title'          => __( 'Footer Logo', 'portfoliolite' ),
     'panel'  => 'portfoliolite_footr_panel',
     'priority'       => 2,
    ));
$wp_customize->add_setting('portfoliolite_thm_txt_', array(
        'default'           => 'Portfolioline',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_text',
        'transport'         => 'postMessage',
         
    ));
$wp_customize->add_control('portfoliolite_thm_txt_', array(
        'label'    => __('Heading', 'portfoliolite'),
        'section'  => 'portfoliolite_foothd_delt',
        'settings' => 'portfoliolite_thm_txt_',
         'type'       => 'text',
        
));  
$wp_customize->add_setting('portfoliolite_thm_txt_link', array(
        'default'           => __('#','portfoliolite'),
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
         
    ));
$wp_customize->add_control('portfoliolite_thm_txt_link', array(
        'label'    => __('Link', 'portfoliolite'),
        'section'  => 'portfoliolite_foothd_delt',
        'settings' => 'portfoliolite_thm_txt_link',
        'type' => 'url',
        
));  
$wp_customize->add_section( 'portfoliolite_footer_option', array(
         'title'          => __( 'Color Options', 'portfoliolite' ),
         'priority'       => 3,
         'panel'  => 'portfoliolite_footr_panel',
) );

$wp_customize->add_setting('portfoliolite_footer_bg_color', array(
        'default'        => '#fff',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_color',
        'transport'      => 'postMessage'
    ));
    $wp_customize->add_control( 
    new WP_Customize_Color_Control($wp_customize,'portfoliolite_footer_bg_color', 
    array('label'      => __( 'Footer Background Color', 'portfoliolite' ),
        'section'    => 'portfoliolite_footer_option',
        'settings'   => 'portfoliolite_footer_bg_color',
    ) ) 
);
    $wp_customize->add_setting('portfoliolite_footer_copybg_color', array(
        'default'        => '#F2F2F2',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_color',
        'transport'      => 'postMessage'
    ));
    $wp_customize->add_control( 
    new WP_Customize_Color_Control($wp_customize,'portfoliolite_footer_copybg_color', 
    array('label'      => __( 'Footer Copyright Background Color', 'portfoliolite' ),
        'section'    => 'portfoliolite_footer_option',
        'settings'   => 'portfoliolite_footer_copybg_color',
    ) ) 
);
    $wp_customize->add_setting('portfoliolite_footer_txt_color', array(
        'default'        => '#1f1f1f',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_color',
        'transport'      => 'postMessage'
    ));
    $wp_customize->add_control( 
    new WP_Customize_Color_Control($wp_customize,'portfoliolite_footer_txt_color', 
    array('label'      => __( 'Footer Text Color', 'portfoliolite' ),
        'section'    => 'portfoliolite_footer_option',
        'settings'   => 'portfoliolite_footer_txt_color',
    ) ) 
);
    $wp_customize->add_setting('portfoliolite_footer_anch_color', array(
        'default'        => '#666',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_color',
        'transport'      => 'postMessage'
    ));
    $wp_customize->add_control( 
    new WP_Customize_Color_Control($wp_customize,'portfoliolite_footer_anch_color', 
    array('label'      => __( 'Footer Anchor Color', 'portfoliolite' ),
        'section'    => 'portfoliolite_footer_option',
        'settings'   => 'portfoliolite_footer_anch_color',
    ) ) 
);
  // doc link
    $wp_customize->add_setting('portfoliolite_cnt_clr_doc', array(
    'sanitize_callback' => 'portfoliolite_sanitize_text',
    ));
    $wp_customize->add_control(new Portfoliolite_Misc_Control( $wp_customize, 'portfoliolite_cnt_clr_doc',
            array(
        'section'     => 'portfoliolite_footer_option',
        'type'        => 'doc-link',
        'url'         => 'https://themehunk.com/docs/portfoliolite-theme/#color-options',
        'description' => esc_html__( 'To know more go with this', 'portfoliolite' ),
        'priority'    =>100,
    )));
 
$wp_customize->add_section( 'portfoliolite_copy_right_txt', array(
         'title'          => __( 'Copyright Text', 'portfoliolite' ),
         'priority'       => 2,
         'panel'  => 'portfoliolite_footr_panel',
    ) );
$wp_customize->add_setting('copyright_textbox', array(
        'default'           => __('Powered by Themehunk WordPress Theme','portfoliolite'),
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_text',
        'transport'         =>  'postMessage'
    ));
$wp_customize->add_control('copyright_textbox', array(
        'label'    => __('Footer Text', 'portfoliolite'),
        'section'  => 'portfoliolite_copy_right_txt',
        'settings' => 'copyright_textbox',
         'type'       => 'text',
    ));
    
}
add_action('customize_register','portfoliolite_customize_register');

function portfoliolite_is_json( $string ){
    return is_string( $string ) && is_array( json_decode( $string, true ) ) ? true : false;
}
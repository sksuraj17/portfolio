<?php
// Register JS control types
$wp_customize->register_control_type( 'Arrival_Customizer_Buttonset_Control' );
$wp_customize->register_control_type( 'Arrival_Customizer_Range_Control' );
$wp_customize->register_control_type( 'Arrival_Customizer_Color_Control' );
$wp_customize->register_control_type( 'Arrival_Customizer_Dimensions_Control');



$prefix               = 'arrival';
$default              = arrival_get_default_theme_options();
$menus                = get_registered_nav_menus();
$elementor_templates  = arrival_get_elementor_templates();

/**
* General settings for the theme
*
*/
$wp_customize->add_panel( 'general_settings', array(
    'priority'         =>      35,
    'capability'       =>      'edit_theme_options',
    'title'            =>      esc_html__( 'General Options', 'arrival' ),
    'description'      =>      esc_html__( 'This allows to edit general theme settings', 'arrival' ),
));

/**
* General styles
*
*/

$wp_customize->add_section( $prefix.'_general_styling_section', array(
      'title'   => esc_html__( 'General Styles', 'arrival' ),
      'panel'   => 'general_settings'
    )
  );



/**
* Theme color
*/
$wp_customize->add_setting($prefix.'_theme_color', array(
        'default'           => $default[$prefix.'_theme_color'],
        'sanitize_callback' => 'arrival_sanitize_color',
        
    )
);
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,$prefix.'_theme_color', array(
            'label'         => esc_html__( 'Theme Color', 'arrival' ),
            'section'       => $prefix.'_general_styling_section',
            'priority'      => 1,
)));

//general styling background seperator
$wp_customize->add_setting( $prefix.'_general_styling_bg_sep', array(
        'sanitize_callback'   => 'sanitize_text_field',        
      ) );

$wp_customize->add_control( new Arrival_Customize_Seperator_Control( $wp_customize, $prefix.'_general_styling_bg_sep', array(
        'label'         => esc_html__( 'Background Options', 'arrival' ),
        'section'       => $prefix.'_general_styling_section',
        'priority'      => 2
      ) ) );

//default color section
$wp_customize->get_control('background_color')->section = $prefix.'_general_styling_section';
$wp_customize->get_control('header_textcolor')->section = 'title_tagline';
$wp_customize->get_control('background_color')->priority = 3;

//default bg section
$wp_customize->get_control('background_image')->section = $prefix.'_general_styling_section';
$wp_customize->get_control('background_image')->priority = 4;

$wp_customize->get_control('background_preset')->section = $prefix.'_general_styling_section';
$wp_customize->get_control('background_preset')->priority = 5;

$wp_customize->get_control('background_position')->section = $prefix.'_general_styling_section';
$wp_customize->get_control('background_position')->priority = 6;

$wp_customize->get_control('background_size')->section = $prefix.'_general_styling_section';
$wp_customize->get_control('background_size')->priority = 7;

$wp_customize->get_control('background_repeat')->section = $prefix.'_general_styling_section';
$wp_customize->get_control('background_repeat')->priority = 8;

$wp_customize->get_control('background_attachment')->section = $prefix.'_general_styling_section';
$wp_customize->get_control('background_attachment')->priority = 9;

/**
* link colors seperator
*
*/
$wp_customize->add_setting( $prefix.'_link_color_sep', array(
        'sanitize_callback'   => 'sanitize_text_field',        
      ) );

$wp_customize->add_control( new Arrival_Customize_Seperator_Control( $wp_customize, $prefix.'_link_color_sep', array(
        'label'         => esc_html__( 'Link Color', 'arrival' ),
        'section'       => $prefix.'_general_styling_section',
        'priority'      => 10
      ) ) );

//link color
$wp_customize->add_setting($prefix.'_link_color', array(
        'default'           => $default[$prefix.'_link_color'],
        'sanitize_callback' => 'arrival_sanitize_color',
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,$prefix.'_link_color', array(
            'label'         => esc_html__( 'Color', 'arrival' ),
            'section'       => $prefix.'_general_styling_section',
            'priority'      => 11
)));

//link color:hover
$wp_customize->add_setting($prefix.'_link_color_hover', array(
        'default'           => $default[$prefix.'_theme_color'],
        'sanitize_callback' => 'arrival_sanitize_color',
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,$prefix.'_link_color_hover', array(
            'label'         => esc_html__( 'Color: Hover', 'arrival' ),
            'section'       => $prefix.'_general_styling_section',
            'priority'      => 12
)));

/**
* Buttons general stylings
*/
$wp_customize->add_setting( $prefix.'_all_btn_border_radius_sep', array(
        'sanitize_callback'   => 'sanitize_text_field',        
      ) );

$wp_customize->add_control( new Arrival_Customize_Seperator_Control( $wp_customize, $prefix.'_all_btn_border_radius_sep', array(
        'label'         => esc_html__( 'Site Buttons', 'arrival' ),
        'section'       => $prefix.'_general_styling_section',
        'priority'      => 13
      ) ) );

//buttons general stylings
$wp_customize->add_setting( $prefix.'_all_btn_radius_top', array(
  'sanitize_callback'   => 'arrival_sanitize_number',
) );
$wp_customize->add_setting( $prefix.'_all_btn_radius_right', array(
  'sanitize_callback'   => 'arrival_sanitize_number',
) );
$wp_customize->add_setting( $prefix.'_all_btn_radius_btm', array(
  'transport'       => 'postMessage',
  'sanitize_callback'   => 'arrival_sanitize_number',
) );
$wp_customize->add_setting( $prefix.'_all_btn_radius_left', array(
  'sanitize_callback'   => 'arrival_sanitize_number',
) );

$wp_customize->add_control( new Arrival_Customizer_Dimensions_Control( $wp_customize, $prefix.'_all_btn_border_radius', array(
  'label'           => esc_html__( 'Border Radius (px)', 'arrival' ),
  'description'     => esc_html__( 'Border radius for all default theme buttons','arrival'),
  'section'         => $prefix.'_general_styling_section',
  'responsive'      => false,
  'priority'      => 14,
  'settings'   => array(
          'desktop_top'     => $prefix.'_all_btn_radius_top',
          'desktop_right'   => $prefix.'_all_btn_radius_right',
          'desktop_bottom'  => $prefix.'_all_btn_radius_btm',
          'desktop_left'    => $prefix.'_all_btn_radius_left',
  ),
    'input_attrs'       => array(
        'min'   => 0,
        'max'   => 300,
        'step'  => 1,
    ),
) ) );

/**
* General settings
*
*/
$wp_customize->add_section( $prefix.'_general_setting_section', array(
      'title'   => esc_html__( 'General Settings', 'arrival' ),
      'panel'   => 'general_settings'
    )
  );

//lazy load images
if ( function_exists( 'arrival_lazyload_images' ) ) {

$wp_customize->add_setting( $prefix.'_lazyload_image_enable', array(
        'default'             => $default[$prefix.'_lazyload_image_enable'],
        'sanitize_callback'   => 'arrival_sanitize_switch',
        
      ) );

$wp_customize->add_control( new Arrival_Customizer_Buttonset_Control( $wp_customize, $prefix.'_lazyload_image_enable', array(
        'label'         => esc_html__( 'Enable Lazyload', 'arrival' ),
        'description'   => esc_html__( 'Lazy-loading images means images are loaded only when they are in view. Improves performance, but can result in content jumping around on slower connections.', 'arrival' ),
        'section'       => $prefix.'_general_setting_section',
        'priority'      => 1,
        'choices'       => array(
          'yes'        => esc_html__( 'Yes', 'arrival' ),
          'no'        => esc_html__( 'No', 'arrival' ),
        )
      ) ) );

}

$wp_customize->add_setting( $prefix.'_smooth_scroll_enable', array(
        'default'             => $default[$prefix.'_smooth_scroll_enable'],
        'sanitize_callback'   => 'arrival_sanitize_switch',
        
      ) );

$wp_customize->add_control( new Arrival_Customizer_Buttonset_Control( $wp_customize, $prefix.'_smooth_scroll_enable', array(
        'label'         => esc_html__( 'Enable Smooth Scroll', 'arrival' ),
        'description'   => esc_html__( 'This will enable or disable smooth scrolling behaviour on your browser.', 'arrival' ),
        'section'       => $prefix.'_general_setting_section',
        'priority'      => 1,
        'choices'       => array(
          'yes'        => esc_html__( 'Yes', 'arrival' ),
          'no'        => esc_html__( 'No', 'arrival' ),
        )
      ) ) );


/**
* Main Container Width
*/
$wp_customize->add_setting( $prefix.'_main_container_width', array(
  'default'             => $default[$prefix.'_main_container_width'],
  'sanitize_callback'   => 'arrival_sanitize_number',
) );

$wp_customize->add_control( new Arrival_Customizer_Range_Control( $wp_customize, $prefix.'_main_container_width', array(
  'label'           => esc_html__( 'Main Container Width (px)', 'arrival' ),
  'priority'        => 2,
  'section'         => $prefix.'_general_setting_section',
    'input_attrs'       => array(
        'min'   => 800,
        'max'   => 2000,
        'step'  => 1,
    ),
) ) );


if( function_exists('arrival_customizer_pro_info')){
  arrival_customizer_pro_info( $wp_customize, $prefix.'_general_settings_info',$prefix.'_general_setting_section');
}


/**
* Blog settings
*
*/
$wp_customize->add_section( $prefix.'_blog_settings', array(
      'title'   => esc_html__( 'Blog/Archive Settings', 'arrival' ),
      'panel'   => 'general_settings'
    )
  );

//blog layout
$wp_customize->add_setting( $prefix.'_blog_layout', array(
        'default'               => $default[$prefix.'_blog_layout'],
        'sanitize_callback'     => 'arrival_sanitize_blog_layout',
      ) );

$wp_customize->add_control( $prefix.'_blog_layout', array(
        'label'         => esc_html__( 'Blog Layout', 'arrival' ),
        'description'   => esc_html__('Select your blog layout','arrival'),
        'section'       => $prefix.'_blog_settings',
        'type'      => 'select',
        'choices' => array(
          'list-layout' => esc_html__('Default','arrival'),
          'masonry-layout' => esc_html__('Grid','arrival')
        )
        
      ) );

//blog excerpts
$wp_customize->add_setting( $prefix.'_blog_excerpts', array(
        'default'             => $default[$prefix.'_blog_excerpts'],
        'sanitize_callback'   => 'absint',
        
      ) );

$wp_customize->add_control( $prefix.'_blog_excerpts', array(
        'label'         => esc_html__( 'Blog Excerpts', 'arrival' ),
        'description'   => esc_html__('Enter excerpt for blogs in letter count','arrival'),
        'section'       => $prefix.'_blog_settings',
        'type'          => 'number'
        
      ) );

// blog sidebar separator
$wp_customize->add_setting( $prefix.'_blog_sidebars_sep', array(
        'sanitize_callback'   => 'sanitize_text_field',        
      ) );

$wp_customize->add_control( new Arrival_Customize_Seperator_Control( $wp_customize, $prefix.'_blog_sidebars_sep', array(
        'label'         => esc_html__( 'Sidebar Options', 'arrival' ),
        'section'       => $prefix.'_blog_settings',
      ) ) );


//blog sidebars
$wp_customize->add_setting( $prefix.'_blog_page_sidebars', array(
    'default'           => $default[$prefix.'_blog_page_sidebars'],
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'arrival_sanitize_page_sidebar'
       )
);
$wp_customize->add_control( new Arrival_Lite_Image_Radio_Control($wp_customize, $prefix.'_blog_page_sidebars', array(
    'type'        => 'radio',
    'description' => esc_html__( 'Select sidebar for the blogs.', 'arrival' ),
    'section'     => $prefix.'_blog_settings',
    'choices'     => array(
        'left'          => ARRIVAL_URI . '/assets/images/sidebars/lft.png',
        'right'         => ARRIVAL_URI . '/assets/images/sidebars/rt.png',
        'no_sidebar'    => ARRIVAL_URI . '/assets/images/sidebars/no.png',
                
        )
       )
    )
);

if( function_exists('arrival_customizer_pro_info')){
  arrival_customizer_pro_info( $wp_customize, $prefix.'_blog_post_info',$prefix.'_blog_settings');
}


/**
* Post Meta Options
*@since 1.2.6
*/

/**
* Header Options
*/
$wp_customize->add_panel( $prefix.'_header_options_panel', array(
        'priority'         =>      30,
        'capability'       =>      'edit_theme_options',
        'title'            =>      esc_html__( 'Header Settings', 'arrival' ),
        'description'      =>      esc_html__( 'All the settings for theme header.', 'arrival' ),
    ));

/*
* Top header
*/

$wp_customize->add_setting( $prefix.'_top_header_enable', array(
        'default'             => $default[$prefix.'_top_header_enable'],
        'sanitize_callback'   => 'arrival_sanitize_enable_disable',
        
      ) );

$wp_customize->add_control( new Arrival_Customizer_Buttonset_Control( $wp_customize, $prefix.'_top_header_enable', array(
        'label'         => esc_html__( 'Enable Top Header', 'arrival' ),
        'description' 	=> esc_html__('Enable or disable top header','arrival'),
        'section'       => $prefix.'_main_header_options_panel',
        'choices'       => array(
          'on'        => esc_html__( 'Yes', 'arrival' ),
          'off'       => esc_html__( 'No', 'arrival' ),
        )
      ) ) );


//top left seperator
$wp_customize->add_setting( $prefix.'_top_left_options', array(
        'sanitize_callback'   => 'sanitize_text_field',        
      ) );

$wp_customize->add_control( new Arrival_Customize_Seperator_Control( $wp_customize, $prefix.'_top_left_options', array(
        'label'         => esc_html__( 'Top Left Options', 'arrival' ),
        'section'       => $prefix.'_main_header_options_panel',
      ) ) );

/**
* Top Header Left content type
*
*/
$wp_customize->add_setting( $prefix.'_top_left_content_type', array(
        'default'               => $default[$prefix.'_top_left_content_type'],
        'sanitize_callback'     => 'arrival_sanitize_select',
      ) );

$wp_customize->add_control( $prefix.'_top_left_content_type', array(
        'label'         => esc_html__( 'Content Type', 'arrival' ),
        'description'   => esc_html__('Select content type for top left header','arrival'),
        'section'       => $prefix.'_main_header_options_panel',
        'type'          => 'select',
        'choices'       => array(
          'contacts'  => esc_html__('Contact Info','arrival'),
          'text'      => esc_html__('Text','arrival')
        )
        
      ) );

/**
* Top header email
*/
$wp_customize->add_setting( $prefix.'_top_header_email', array(
        'default'             => $default[$prefix.'_top_header_email'],
        'sanitize_callback'   => 'sanitize_text_field',
        'transport'           => 'postMessage'
        
      ) );

$wp_customize->add_control( $prefix.'_top_header_email', array(
        'label'          => esc_html__( 'Email', 'arrival' ),
        'description' 	 => esc_html__('Enter email address','arrival'),
        'section'        => $prefix.'_main_header_options_panel',
        'type'			     => 'text'
        
      ) );
/**
* Top header phone
*/
$wp_customize->add_setting( $prefix.'_top_header_phone', array(
        'default'             => $default[$prefix.'_top_header_phone'],
        'sanitize_callback'   => 'sanitize_text_field',
        'transport'           => 'postMessage'
        
      ) );

$wp_customize->add_control( $prefix.'_top_header_phone', array(
        'label'         => esc_html__( 'Phone', 'arrival' ),
        'description' 	=> esc_html__('Enter phone number','arrival'),
        'section'       => $prefix.'_main_header_options_panel',
        'type'			    => 'text'
        
      ) );


/**
* Top header text
*
*/
$wp_customize->add_setting( $prefix.'_top_header_txt', array(
        'default'             => $default[$prefix.'_top_header_txt'],
        'sanitize_callback'   => 'sanitize_text_field',
        'transport'           => 'postMessage'
        
      ) );

$wp_customize->add_control( $prefix.'_top_header_txt', array(
        'label'         => esc_html__( 'Text', 'arrival' ),
        'description'   => esc_html__('Enter header text','arrival'),
        'section'       => $prefix.'_main_header_options_panel',
        'type'          => 'text'
        
      ) );

/*
* top header left items selective refresh
*/
$top_left_items = array('_top_header_phone','_top_header_email');

foreach( $top_left_items as $top_left_item ){
  $setting_id = $prefix.''.$top_left_item;
  $wp_customize->selective_refresh->add_partial( $setting_id, array(
            'selector'            => '.top-left-wrapp',
            'render_callback'     => 'arrival_top_header_left',
      ) );
}
//top right seperator
$wp_customize->add_setting( $prefix.'_top_right_options', array(
        'sanitize_callback'   	=> 'sanitize_text_field',
        'transport'				=> 'postMessage'		
      ) );

$wp_customize->add_control( new Arrival_Customize_Seperator_Control( $wp_customize, $prefix.'_top_right_options', array(
        'label'         => esc_html__( 'Top Right Options', 'arrival' ),
        'section'       => $prefix.'_main_header_options_panel',
      ) ) );


$wp_customize->selective_refresh->add_partial( $prefix.'_top_right_options', array(
          'selector'            => '.top-right-wrapp',
          'render_callback'     => 'arrival_top_header_right',
    ) );
/**
* Right header content type
*/
$wp_customize->add_setting( $prefix.'_top_right_header_content', array(
        'default'             	=> $default[$prefix.'_top_right_header_content'],
        'sanitize_callback'   	=> 'sanitize_text_field',
        'transport' 			      => 'postMessage'
      ) );

$wp_customize->add_control( $prefix.'_top_right_header_content', array(
        'label'         => esc_html__( 'Content Type', 'arrival' ),
        'description' 	=> esc_html__('Select content type for top right header','arrival'),
        'section'       => $prefix.'_main_header_options_panel',
        'type'			=> 'select',
        'choices' => array(
        	'menus' => esc_html__('Menus','arrival'),
        	'icons' => esc_html__('Social Icons','arrival')
        )
        
      ) );

// top right content selective refresh
$wp_customize->selective_refresh->add_partial( $prefix.'_top_right_header_content', array(
      'selector'            => '.top-header-wrapp .top-right-wrapp',
      'container_inclusive' => true,
      'render_callback'     => 'arrival_top_header_right',
  ) );

$wp_customize->add_setting( $prefix.'_top_social_redirect_btn', array(
        'sanitize_callback'     => 'sanitize_text_field',
        'transport'             => 'postMessage'    
      ) );

$wp_customize->add_control( new Arrival_Customize_Redirect( $wp_customize, $prefix.'_top_social_redirect_btn', array(
        'label'         => esc_html__( 'Configure Social Icons', 'arrival' ),
        'description'   => 'arrival_social_icons_section',
        'section'       => $prefix.'_main_header_options_panel',
      ) ) );

/**
* dropdown for menu locations
*/

$wp_customize->add_setting( $prefix.'_top_right_header_menus', array(
        'default'             => $default[$prefix.'_top_right_header_menus'],
        'sanitize_callback'   => 'sanitize_text_field'
        
      ) );

$wp_customize->add_control( $prefix.'_top_right_header_menus', array(
        'label'         => esc_html__( 'Menu Location', 'arrival' ),
        'description' 	=> esc_html__('Select menu to display on top right header','arrival'),
        'section'       => $prefix.'_main_header_options_panel',
        'type'			    => 'select',
        'choices' 		  => $menus
        
      ) );


/**
* After top header
* Content to display after top header
* @since 1.0.8
*/
$wp_customize->add_setting( $prefix.'_top_header_after_seperator', array(
        'sanitize_callback'     => 'sanitize_text_field',
        'transport'             => 'postMessage'    
      ) );

$wp_customize->add_control( new Arrival_Customize_Seperator_Control( $wp_customize, $prefix.'_top_header_after_seperator', array(
        'label'         => esc_html__( 'After Top Header', 'arrival' ),
        'description'   => esc_html__( 'This section will display contents from widget area "After Top Header"', 'arrival' ),
        'section'       => $prefix.'_main_header_options_panel',
      ) ) );

//enable disable after top header section
$wp_customize->add_setting( $prefix.'_after_top_header_enable', array(
        'default'             => $default[$prefix.'_after_top_header_enable'],
        'sanitize_callback'   => 'arrival_sanitize_switch',
        
      ) );

$wp_customize->add_control( new Arrival_Customizer_Buttonset_Control( $wp_customize, $prefix.'_after_top_header_enable', array(
        'label'         => esc_html__( 'Enable After Top Header Section', 'arrival' ),
        'description'   => esc_html__( 'Show or hide after top header section', 'arrival' ),
        'section'       => $prefix.'_main_header_options_panel',
        'choices'       => array(
          'yes'         => esc_html__( 'Yes', 'arrival' ),
          'no'          => esc_html__( 'No', 'arrival' ),
        )
      ) ) );


//after top header paddings
$wp_customize->add_setting( $prefix.'_after_top_hdr_top_padding', array(
  'transport'           => 'postMessage',
  'default'             => $default[$prefix.'_after_top_hdr_top_padding'],
  'sanitize_callback'   => 'arrival_sanitize_number',
) );
$wp_customize->add_setting( $prefix.'_after_top_hdr_btm_padding', array(
  'transport'           => 'postMessage',
  'default'             => $default[$prefix.'_after_top_hdr_btm_padding'],
  'sanitize_callback'   => 'arrival_sanitize_number',
) );

$wp_customize->add_control( new Arrival_Customizer_Dimensions_Control( $wp_customize, $prefix.'_after_top_hdr_padding', array(
  'label'         => esc_html__( 'Padding (px)', 'arrival' ),
  'section'       => $prefix.'_main_header_options_panel',
  'responsive'    => false,
  'settings'   => array(
          'desktop_top'     => $prefix.'_after_top_hdr_top_padding',
          'desktop_bottom'  => $prefix.'_after_top_hdr_btm_padding',
  ),
    'input_attrs'       => array(
        'min'   => 0,
        'max'   => 700,
        'step'  => 1,
    ),
) ) );

//enable top border
$wp_customize->add_setting($prefix.'_after_top_header_top_border_show', array(
        'default'           => $default[$prefix.'_after_top_header_top_border_show'],
        'sanitize_callback' => 'arrival_sanitize_checkbox',
    )
);

$wp_customize->add_control( $prefix.'_after_top_header_top_border_show',array(
        'label'       => esc_html__( 'Show Top Border ?', 'arrival' ),
        'description' => esc_html__('Check the box to enable top border','arrival'),
        'section'     => $prefix.'_main_header_options_panel',
        'type'        => 'checkbox',

));


$wp_customize->add_setting($prefix.'_after_top_header_align_center', array(
        'default'           => $default[$prefix.'_after_top_header_align_center'],
        'sanitize_callback' => 'arrival_sanitize_checkbox',
    )
);

$wp_customize->add_control( $prefix.'_after_top_header_align_center',array(
        'label'       => esc_html__( 'Center Align Item?', 'arrival' ),
        'description' => esc_html__('Check the box to align single widget to center of header.','arrival'),
        'section'     => $prefix.'_main_header_options_panel',
        'type'        => 'checkbox',

));

/**
* Main navigation section
*
*/

$wp_customize->add_section( $prefix.'_main_header_options_panel', array(
			'title'		=> esc_html__( 'Header Options', 'arrival' ),
			'panel'		=> $prefix.'_header_options_panel'
		)
	);


/**
* Header type
* @since 1.1.1
*/
$wp_customize->add_setting( $prefix.'_site_header_type', array(
        'default'             => $default[$prefix.'_site_header_type'],
        'sanitize_callback'   => 'arrival_sanitize_header_type',
        
      ) );

$wp_customize->add_control( new Arrival_Customizer_Buttonset_Control( $wp_customize, $prefix.'_site_header_type', array(
        'label'         => esc_html__( 'Header Type', 'arrival' ),
        'description'   => sprintf(__('Select site header type, %1$s Note: %2$s If you choose custom header you will have to seperately design your header using elementor.','arrival'),'<strong>','</strong>'),
        'priority'      => 1,
        'section'       => $prefix.'_main_header_options_panel',
        'choices'       => array(
          'default'     => esc_html__( 'Default', 'arrival' ),
          'custom'      => esc_html__( 'Custom', 'arrival' ),
        )
      ) ) );

$wp_customize->add_setting( $prefix.'_site_header_custom_template', array(
        'default'               => $default[$prefix.'_site_header_custom_template'],
        'sanitize_callback'     => 'absint',
      ) );

$wp_customize->add_control( $prefix.'_site_header_custom_template', array(
        'label'         => esc_html__( 'Select Elementor Template', 'arrival' ),
        'priority'      => 2,
        'description'   => esc_html__('Select elementor template to display as header.','arrival'),
        'section'       => $prefix.'_main_header_options_panel',
        'type'          => 'select',
        'choices'       => $elementor_templates,
        
      ) );



$wp_customize->add_setting( $prefix.'_main_nav_layout', array(
        'default'             => $default[$prefix.'_main_nav_layout'],
        'sanitize_callback'   => 'arrival_sanitize_main_nav',
        
      ) );

$wp_customize->add_control( new Arrival_Customizer_Buttonset_Control( $wp_customize, $prefix.'_main_nav_layout', array(
        'label'         => esc_html__( 'Main Navigation Layout', 'arrival' ),
        'description' 	=> esc_html__('Select layout for main navigation','arrival'),
        'priority'      => 5,
        'section'       => $prefix.'_main_header_options_panel',
        'choices'       => array(
          'full'        => esc_html__( 'Full', 'arrival' ),
          'boxed'       => esc_html__( 'Boxed', 'arrival' ),
        )
      ) ) );

/**
* Disable site logo and tagline
* @since 1.0.8
*/

$wp_customize->add_setting( $prefix.'_main_nav_disable_logo', array(
        'default'             => $default[$prefix.'_main_nav_disable_logo'],
        'sanitize_callback'   => 'arrival_sanitize_switch',
        
      ) );

$wp_customize->add_control( new Arrival_Customizer_Buttonset_Control( $wp_customize, $prefix.'_main_nav_disable_logo', array(
        'label'         => esc_html__( 'Disable Logo & Site Title', 'arrival' ),
        'priority'      => 10,
        'section'       => $prefix.'_main_header_options_panel',
        'choices'       => array(
          'yes'         => esc_html__( 'Yes', 'arrival' ),
          'no'          => esc_html__( 'No', 'arrival' ),
        )
      ) ) );



/**
* Align main navigation menu items
* @since 1.0.8
*/
$wp_customize->add_setting( $prefix.'_main_nav_menu_align', array(
        'default'               => $default[$prefix.'_main_nav_menu_align'],
        'sanitize_callback'     => 'arrival_sanitize_select',
      ) );

$wp_customize->add_control( $prefix.'_main_nav_menu_align', array(
        'label'         => esc_html__( 'Align menu', 'arrival' ),
        'priority'      => 15,
        'description'   => esc_html__('How you want your menus to be aligned','arrival'),
        'section'       => $prefix.'_main_header_options_panel',
        'type'          => 'select',
        'choices'       => array(
          'default'     => esc_html__('Default','arrival'),
          'center-menu' => esc_html__('Center','arrival'),
        )
        
      ) );

/**
* Cart location option
* @since 1.1.0
*/
if( class_exists('woocommerce') ){
  
$wp_customize->add_setting( $prefix.'_cart_display_position', array(
        'default'             => $default[$prefix.'_cart_display_position'],
        'sanitize_callback'   => 'arrival_sanitize_switch_cart',
        
      ) );

$wp_customize->add_control( new Arrival_Customizer_Buttonset_Control( $wp_customize, $prefix.'_cart_display_position', array(
        'label'         => esc_html__( 'Cart Display Option', 'arrival' ),
        'description'   => sprintf(__('Choose cart display option to %1$s top menu %2$s or %1$s main navigation menu  %2$s , OR disable it','arrival'),'<strong>','</strong>'),
        'priority'      => 10,
        'section'       => $prefix.'_main_header_options_panel',
        'choices'       => array(
          'none'        => esc_html__( 'Disable', 'arrival' ),
          'top'         => esc_html__( 'Top', 'arrival' ),
          'main'        => esc_html__( 'Main', 'arrival' ),
        )
      ) ) );

}

/**
* main navigation menu last item
*/

//menu last item seperator
$wp_customize->add_setting( $prefix.'_nav_last_item_sep', array(
        'sanitize_callback'   => 'sanitize_text_field',        
      ) );

$wp_customize->add_control( new Arrival_Customize_Seperator_Control( $wp_customize, $prefix.'_nav_last_item_sep', array(
        'label'         => esc_html__( 'Menu Last Item', 'arrival' ),
        'priority'      => 20,
        'section'       => $prefix.'_main_header_options_panel',
      ) ) );


$wp_customize->add_setting( $prefix.'_main_nav_right_content', array(
        'default'             	=> $default[$prefix.'_main_nav_right_content'],
        'sanitize_callback'   	=> 'sanitize_text_field',
        
      ) );

$wp_customize->add_control( $prefix.'_main_nav_right_content', array(
        'label'         => esc_html__( 'Last Item Type', 'arrival' ),
        'priority'      => 25,
        'description' 	=> esc_html__('Select last item for menu','arrival'),
        'section'       => $prefix.'_main_header_options_panel',
        'type'			=> 'select',
        'choices' => apply_filters( $prefix.'_nav_last_item',array(
        	'search' => esc_html__('Search','arrival'),
        	'button' => esc_html__('Button','arrival'),
          'none'   => esc_html__('Empty','arrival')
        ))
        
      ) );



/**
* text for cta button
*/
$wp_customize->add_setting( $prefix.'_main_nav_right_btn_txt', array(
        'default'             	=> $default[$prefix.'_main_nav_right_btn_txt'],
        'sanitize_callback'   	=> 'sanitize_text_field',
        'transport'             => 'postMessage'
      ) );

$wp_customize->add_control( $prefix.'_main_nav_right_btn_txt', array(
		    'type'			   => 'text',
        'priority'      => 30,
        'label'         => esc_html__( 'Button Text', 'arrival' ),
        'description' 	=> esc_html__('Text for button','arrival'),
        'section'       => $prefix.'_main_header_options_panel'
        
      ) );

$wp_customize->add_setting( $prefix.'_main_nav_right_btn_url', array(
        'default'               => $default[$prefix.'_main_nav_right_btn_url'],
        'sanitize_callback'     => 'esc_url_raw',
      ) );

$wp_customize->add_control( $prefix.'_main_nav_right_btn_url', array(
        'type'         => 'text',
        'priority'      => 35,
        'label'         => esc_html__( 'Button URL', 'arrival' ),
        'description'   => esc_html__('Add URL for header button','arrival'),
        'section'       => $prefix.'_main_header_options_panel'
        
      ) );

/**
* last item align
*/
$wp_customize->add_setting( $prefix.'_main_nav_last_item_align', array(
        'default'               => $default[$prefix.'_main_nav_last_item_align'],
        'sanitize_callback'     => 'sanitize_text_field',
        
      ) );

$wp_customize->add_control( $prefix.'_main_nav_last_item_align', array(
        'label'         => esc_html__( 'Text Align', 'arrival' ),
        'priority'      => 40,
        'description'   => esc_html__('Align menu last item type as','arrival'),
        'section'       => $prefix.'_main_header_options_panel',
        'type'          => 'select',
        'choices'       => array(
          'left' => esc_html__('Left','arrival'),
          'right' => esc_html__('Right','arrival'),
        )
        
      ) );


//single page navigation
$wp_customize->add_setting( $prefix.'_single_nav_enable_sep', array(
        'sanitize_callback'   => 'sanitize_text_field',        
      ) );

$wp_customize->add_control( new Arrival_Customize_Seperator_Control( $wp_customize, $prefix.'_single_nav_enable_sep', array(
        'label'         => esc_html__( 'Scrolling Menus', 'arrival' ),
        'priority'      => 45,
        'description'   => esc_html__( 'This setting will enable or disable one page parallax scrolling menus', 'arrival' ),
        'section'       => $prefix.'_main_header_options_panel',
      ) ) );

//enable one page menus
$wp_customize->add_setting( $prefix.'_one_page_menus', array(
        'default'             => $default[$prefix.'_one_page_menus'],
        'sanitize_callback'   => 'arrival_sanitize_switch',
        
      ) );

$doc_link = '<a href="https://wpoperation.com/wp-documentation/arrival" target="_blank">';
$wp_customize->add_control( new Arrival_Customizer_Buttonset_Control( $wp_customize, $prefix.'_one_page_menus', array(
        'label'         => esc_html__( 'Enable One Page Menu', 'arrival' ),
        'priority'      => 50,
        /*  Translators: %1$s: url open , %2$s: url close*/
        'description'   => sprintf(__('Please refer to %1$s documentation %2$s on configuring one page menus','arrival'),$doc_link,'</a>'),
        'section'       => $prefix.'_main_header_options_panel',
        'choices'       => array(
          'yes'        => esc_html__( 'Yes', 'arrival' ),
          'no'        => esc_html__( 'No', 'arrival' ),
        )
      ) ) );


if( function_exists('arrival_customizer_pro_info')){
  arrival_customizer_pro_info( $wp_customize, $prefix.'_header_section_info',$prefix.'_main_header_options_panel');
}

/**
* Main navigation color options
*
*/

//bg color
$wp_customize->add_setting($prefix.'_main_nav_bg_color', array(
        'default'           => $default[$prefix.'_main_nav_bg_color'],
        'sanitize_callback' => 'arrival_sanitize_color',
        'transport'         => 'postMessage'
    )
);

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix.'_main_nav_bg_color', array(
        'label'           => esc_html__( 'Background Color', 'arrival' ),
        'priority'        => 10,
        'section'         => $prefix.'_main_header_options_panel',
      ) ) );

//menu colors
$wp_customize->add_setting($prefix.'_main_nav_menu_color', array(
        'default'           => $default[$prefix.'_main_nav_menu_color'],
        'sanitize_callback' => 'arrival_sanitize_color',
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,$prefix.'_main_nav_menu_color', array(
            'label'         => esc_html__( 'Menu Color', 'arrival' ),
            'priority'      => 15,
            'section'       => $prefix.'_main_header_options_panel',
)));


//menu colors:hover
$wp_customize->add_setting($prefix.'_main_nav_menu_color_hover', array(
        'default'           => $default[$prefix.'_theme_color'],
        'sanitize_callback' => 'arrival_sanitize_color',
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,$prefix.'_main_nav_menu_color_hover', array(
            'label'         => esc_html__( 'Menu Color: Hover', 'arrival' ),
            'priority'      => 20,
            'section'       => $prefix.'_main_header_options_panel',
)));

/**
* Transparend header options
* @since 1.1.6
*/
$wp_customize->add_setting( $prefix.'_transparent_hdr_styles_seperatpr', array(
        'sanitize_callback'     => 'sanitize_text_field',
        'transport'             => 'postMessage'    
      ) );

$wp_customize->add_control( new Arrival_Customize_Seperator_Control( $wp_customize, $prefix.'_transparent_hdr_styles_seperatpr', array(
        'label'         => esc_html__( 'Transparent Header Styles', 'arrival' ),
        'description'   => esc_html__('The transparent header will only be displayed on homepage','arrival'),
        'priority'      => 21,
        'section'       => $prefix.'_main_header_options_panel',
      ) ) );

//enable transparent header
$wp_customize->add_setting($prefix.'_transparent_header_enable', array(
        'default'           => $default[$prefix.'_transparent_header_enable'],
        'sanitize_callback' => 'arrival_sanitize_checkbox',
    )
);

$wp_customize->add_control( $prefix.'_transparent_header_enable',array(
        'label'       => esc_html__( 'Enable Transparent Header', 'arrival' ),
        'priority'    => 22,
        'description' => esc_html__('Check the box to enable transparent header','arrival'),
        'section'     => $prefix.'_main_header_options_panel',
        'type'        => 'checkbox',

));

//transparent header menu color
$wp_customize->add_setting($prefix.'_main_nav_menu_color_transparent', array(
        'default'           => $default[$prefix.'_main_nav_menu_color_transparent'],
        'sanitize_callback' => 'arrival_sanitize_color',
    )
);
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,$prefix.'_main_nav_menu_color_transparent', array(
            'label'         => esc_html__( 'Menu Color', 'arrival' ),
            'priority'      => 23,
            'section'       => $prefix.'_main_header_options_panel',
)));

/**
* Additional styles
*/
$wp_customize->add_setting( $prefix.'_hdr_addi_styles_seperatpr', array(
        'sanitize_callback'     => 'sanitize_text_field',
        'transport'             => 'postMessage'    
      ) );

$wp_customize->add_control( new Arrival_Customize_Seperator_Control( $wp_customize, $prefix.'_hdr_addi_styles_seperatpr', array(
        'label'         => esc_html__( 'Additional Styles', 'arrival' ),
        'priority'      => 24,
        'section'       => $prefix.'_main_header_options_panel',
      ) ) );

/**
* Main Nav Padding
*/
$wp_customize->add_setting( $prefix.'_nav_header_padding', array(
  'default'             => $default[$prefix.'_nav_header_padding'],
  'sanitize_callback'   => 'arrival_sanitize_number',
  'transport'           => 'postMessage'
) );

$wp_customize->add_control( new Arrival_Customizer_Range_Control( $wp_customize, $prefix.'_nav_header_padding', array(
  'label'           => esc_html__( 'Navigation Height (px)', 'arrival' ),
  'priority'        => 25,
  'section'         => $prefix.'_main_header_options_panel',
    'input_attrs'       => array(
        'min'   => 0,
        'max'   => 250,
        'step'  => 1,
    ),
) ) );



//menu item font-weight
$arrival_free_font_weight = apply_filters('arrival_free_nav_font_weight','__return_true' );
if( $arrival_free_font_weight == true ){

$wp_customize->add_setting( $prefix.'_nav_font_weight', array(
  'sanitize_callback'   => 'arrival_sanitize_number',
  'default'             => $default[$prefix.'_nav_font_weight'],
) );

$wp_customize->add_control( $prefix.'_nav_font_weight', array(
        'type'          => 'select',
        'priority'      => 30,
        'label'         => esc_html__( 'Font Weight', 'arrival' ),
        'description'   => esc_html__('Main navigation font weight','arrival'),
        'section'       => $prefix.'_main_header_options_panel',
        'choices'       => array(
          '200' => esc_html__('200','arrival'),
          '300' => esc_html__('300','arrival'),
          '400' => esc_html__('400','arrival'),
          '500' => esc_html__('500','arrival'),
          '600' => esc_html__('600','arrival'),
          '700' => esc_html__('700','arrival')
        )
        
      ) );
}

//disable header box-shadow
$wp_customize->add_setting($prefix.'_header_box_shadow_disable', array(
        'default'           => $default[$prefix.'_header_box_shadow_disable'],
        'sanitize_callback' => 'arrival_sanitize_checkbox',
    )
);

$wp_customize->add_control( $prefix.'_header_box_shadow_disable',array(
        'label'       => esc_html__( 'Disable Box-shadow', 'arrival' ),
        'priority'    => 35,
        'description' => esc_html__('Check the box to disable the header box-shadow','arrival'),
        'section'     => $prefix.'_main_header_options_panel',
        'type'        => 'checkbox',

));


//Menu hover styles
$wp_customize->add_setting( $prefix.'_menu_hover_styles', array(
        'default'               => $default[$prefix.'_menu_hover_styles'],
        'sanitize_callback'     => 'arrival_sanitize_select',
      ) );

$wp_customize->add_control( $prefix.'_menu_hover_styles', array(
        'label'         => esc_html__( 'Menu Hover Styles', 'arrival' ),
        'priority'      => 40,
        'description'   => esc_html__( 'Select menu hover styles', 'arrival' ),
        'section'       => $prefix.'_main_header_options_panel',
        'type'          => 'select',
        'choices'       => apply_filters( $prefix.'_menu_hover_styles',array(
          'hover-layout-one'  => esc_html__('Style One','arrival'),
          'hover-layout-two'  => esc_html__('Style Two','arrival'),
          'hover-layout-three'  => esc_html__('Style Three','arrival')
        )),
        
  ) );

/**
* Top header color options
*
*/
$wp_customize->add_setting( $prefix.'_top_hdr_styles_seperatpr', array(
        'sanitize_callback'     => 'sanitize_text_field',
        'transport'       => 'postMessage'    
      ) );

$wp_customize->add_control( new Arrival_Customize_Seperator_Control( $wp_customize, $prefix.'_top_hdr_styles_seperatpr', array(
        'label'         => esc_html__( 'Top Header Styles', 'arrival' ),
        'priority'      => 45,
        'section'       => $prefix.'_main_header_options_panel',
      ) ) );

//top header bg color
$wp_customize->add_setting($prefix.'_top_header_bg_color', array(
        'default'           => $default[$prefix.'_top_header_bg_color'],
        'sanitize_callback' => 'arrival_sanitize_color',
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control( new Arrival_Customizer_Color_Control( $wp_customize,$prefix.'_top_header_bg_color', array(
            'label'         => esc_html__( 'Background Color', 'arrival' ),
            'priority'      => 50,
            'section'       => $prefix.'_main_header_options_panel',
)));

//top header text colors
$wp_customize->add_setting($prefix.'_top_header_txt_color', array(
        'default'           => $default[$prefix.'_top_header_txt_color'],
        'sanitize_callback' => 'arrival_sanitize_color',
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,$prefix.'_top_header_txt_color', array(
            'label'         => esc_html__( 'Text Color', 'arrival' ),
            'priority'      => 50,
            'section'       => $prefix.'_main_header_options_panel',
)));


/**
* Middle header color options
* @since 1.0.8
*/
$wp_customize->add_setting( $prefix.'_after_top_hdr_styles_seperatpr', array(
        'sanitize_callback'     => 'sanitize_text_field',
        'transport'       => 'postMessage'    
      ) );

$wp_customize->add_control( new Arrival_Customize_Seperator_Control( $wp_customize, $prefix.'_after_top_hdr_styles_seperatpr', array(
        'label'         => esc_html__( 'After Top Header Styles', 'arrival' ),
        'priority'      => 60,
        'section'       => $prefix.'_main_header_options_panel',
      ) ) );

//after top header bg color
$wp_customize->add_setting($prefix.'_after_top_header_bg_color', array(
        'default'           => $default[$prefix.'_after_top_header_bg_color'],
        'sanitize_callback' => 'arrival_sanitize_color',
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control( new Arrival_Customizer_Color_Control( $wp_customize,$prefix.'_after_top_header_bg_color', array(
            'label'         => esc_html__( 'Background Color', 'arrival' ),
            'priority'      => 65,
            'section'       => $prefix.'_main_header_options_panel',
)));

//after top header text color
$wp_customize->add_setting($prefix.'_after_top_header_txt_color', array(
        'default'           => $default[$prefix.'_after_top_header_txt_color'],
        'sanitize_callback' => 'arrival_sanitize_color',
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,$prefix.'_after_top_header_txt_color', array(
            'label'         => esc_html__( 'Text Color', 'arrival' ),
            'priority'      => 70,
            'section'       => $prefix.'_main_header_options_panel',
)));

//top border color
$wp_customize->add_setting($prefix.'_after_top_header_border_color', array(
        'default'           => $default[$prefix.'_after_top_header_border_color'],
        'sanitize_callback' => 'arrival_sanitize_color',
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,$prefix.'_after_top_header_border_color', array(
            'label'         => esc_html__( 'Border Color', 'arrival' ),
            'priority'      => 75,
            'section'       => $prefix.'_main_header_options_panel',
)));

//icon color
$wp_customize->add_setting($prefix.'_after_top_header_icon_color', array(
        'default'           => $default[$prefix.'_after_top_header_icon_color'],
        'sanitize_callback' => 'arrival_sanitize_color',
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,$prefix.'_after_top_header_icon_color', array(
            'label'         => esc_html__( 'Icons Color', 'arrival' ),
            'priority'      => 80,
            'section'       => $prefix.'_main_header_options_panel',
)));




/**
* Breadcrumb Options
*/
$wp_customize->add_section( $prefix.'_breadcrumb_potions', array(
      'title'   => esc_html__( 'Inner Page Header', 'arrival' ),
      'panel'   => $prefix.'_header_options_panel'
    )
  );


/**
* Disable breadcrumbs
* @since 1.2.1
*/

$wp_customize->add_setting( $prefix.'_breadcrumb_enable', array(
        'default'             => $default[$prefix.'_breadcrumb_enable'],
        'sanitize_callback'   => 'arrival_sanitize_switch',
        
      ) );

$wp_customize->add_control( new Arrival_Customizer_Buttonset_Control( $wp_customize, $prefix.'_breadcrumb_enable', array(
        'label'         => esc_html__( 'Enable Breadcrumbs', 'arrival' ),
        'description'   => esc_html__('Show or hide breadcrumb header bars.','arrival'),
        'section'       => $prefix.'_breadcrumb_potions',
        'choices'       => array(
          'yes'         => esc_html__( 'Yes', 'arrival' ),
          'no'          => esc_html__( 'No', 'arrival' ),
        )
      ) ) );


//layout
$wp_customize->add_setting( $prefix.'_page_header_layout', array(
        'default'               => $default[$prefix.'_page_header_layout'],
        'sanitize_callback'     => 'arrival_sanitize_breadcrumb',
      ) );

$wp_customize->add_control( $prefix.'_page_header_layout', array(
        'label'         => esc_html__( 'Page Header Layout', 'arrival' ),
        'description'   => esc_html__('Please change this layout to Seperate if using custom Elementor header','arrival'),
        'section'       => $prefix.'_breadcrumb_potions',
        'type'          => 'select',
        'choices'       => array(
          'default'     => esc_html__('Attached To Navigation','arrival'),
          'layout-two'  => esc_html__('Seperate','arrival')
        )
        
  ) );

//header bg image
$wp_customize->add_setting( $prefix.'_inner_header_image',array(
        'sanitize_callback' => 'esc_url_raw'
    )
);
$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, $prefix.'_inner_header_image',
      array(
          'label'       => esc_html__( 'Header Background Image', 'arrival' ),
            'section'   => $prefix.'_breadcrumb_potions',
        )
    )
);

//background position
$wp_customize->add_setting( $prefix.'_inner_header_img_position', array(
        'default'               => $default[$prefix.'_inner_header_img_position'],
        'sanitize_callback'     => 'arrival_sanitize_bg_position',
        'transport'             => 'postMessage'
      ) );

$wp_customize->add_control( $prefix.'_inner_header_img_position', array(
        'label'         => esc_html__( 'Background Position', 'arrival' ),
        'section'       => $prefix.'_breadcrumb_potions',
        'type'      => 'select',
        'choices' => array(
          'bottom' => esc_html__('Bottom','arrival'),
          'center' => esc_html__('Center','arrival'),
          'initial' => esc_html__('Initial','arrival'),
          'left' => esc_html__('Left','arrival'),
          'right' => esc_html__('Right','arrival'),
          'top' => esc_html__('Top','arrival')
        )
        
  ) );

//background padding
$wp_customize->add_setting( $prefix.'_inner_header_image_padding_btm', array(
  'default'             => $default[$prefix.'_inner_header_image_padding_btm'],
  'sanitize_callback'   => 'arrival_sanitize_number',
  'transport'           => 'postMessage'
) );

$wp_customize->add_control( new Arrival_Customizer_Range_Control( $wp_customize, $prefix.'_inner_header_image_padding_btm', array(
  'label'           => esc_html__( 'Height (px)', 'arrival' ),
  'section'         => $prefix.'_breadcrumb_potions',
    'input_attrs'       => array(
        'min'   => 10,
        'max'   => 500,
        'step'  => 1,
    ),
) ) );

//disable image overlay
$wp_customize->add_setting( $prefix.'_breadcrumb_overlay_disable', array(
  'sanitize_callback'   => 'arrival_sanitize_checkbox',
  'default'             => $default[$prefix.'_breadcrumb_overlay_disable']
) );

$wp_customize->add_control( $prefix.'_breadcrumb_overlay_disable', array(
        'type'          => 'checkbox',
        'label'         => esc_html__( 'Enable Overlay', 'arrival' ),
        'description'   => esc_html__('Check the box to enable background overlay','arrival'),
        'section'       => $prefix.'_breadcrumb_potions'
        
      ) );

/**
* Theme footer settings
*
*/
$wp_customize->add_section( $prefix.'_footer_settings', array(
      'title'   => esc_html__( 'Footer Settings', 'arrival' ),
      'priority'  => 50
    )
  );



/**
* Footer type
* @since 1.1.1
*/
$wp_customize->add_setting( $prefix.'_site_footer_type', array(
        'default'             => $default[$prefix.'_site_footer_type'],
        'sanitize_callback'   => 'arrival_sanitize_header_type',
        
      ) );

$wp_customize->add_control( new Arrival_Customizer_Buttonset_Control( $wp_customize, $prefix.'_site_footer_type', array(
        'label'         => esc_html__( 'Footer Type', 'arrival' ),
        'description'   => sprintf(__('Select site footer type, %1$s Note: %2$s If you choose custom footer you will have to seperately design your footer using elementor.','arrival'),'<strong>','</strong>'),
        'priority'      => 1,
        'section'       => $prefix.'_footer_settings',
        'choices'       => array(
          'default'     => esc_html__( 'Default', 'arrival' ),
          'custom'      => esc_html__( 'Custom', 'arrival' ),
        )
      ) ) );

$wp_customize->add_setting( $prefix.'_site_footer_custom_template', array(
        'default'               => $default[$prefix.'_site_footer_custom_template'],
        'sanitize_callback'     => 'absint',
      ) );

$wp_customize->add_control( $prefix.'_site_footer_custom_template', array(
        'label'         => esc_html__( 'Select Elementor Template', 'arrival' ),
        'priority'      => 2,
        'description'   => esc_html__('Select elementor template to display as footer.','arrival'),
        'section'       => $prefix.'_footer_settings',
        'type'          => 'select',
        'choices'       => $elementor_templates,
        
      ) );




//enable or disable footer widgets section
$wp_customize->add_setting( $prefix.'_footer_widget_enable', array(
        'default'             => $default[$prefix.'_footer_widget_enable'],
        'sanitize_callback'   => 'arrival_sanitize_switch',
        'transport'           => 'postMessage'
        
      ) );

$wp_customize->add_control( new Arrival_Customizer_Buttonset_Control( $wp_customize, $prefix.'_footer_widget_enable', array(
        'label'         => esc_html__( 'Enable Footer Widgets', 'arrival' ),
        'section'       => $prefix.'_footer_settings',
        'priority'      => 5,
        'choices'       => array(
          'yes'         => esc_html__( 'Yes', 'arrival' ),
          'no'          => esc_html__( 'No', 'arrival' ),
        )
      ) ) );

// footer widgets enable/disable selective refresh
$wp_customize->selective_refresh->add_partial( $prefix.'_footer_widget_enable', array(
            'selector'            => 'footer.site-footer .container .footer-widget-wrapper',
            'render_callback'     => 'arrival_theme_footer_widgets',
            'container_inclusive' => true
      ) );

//footer copyright
$wp_customize->add_setting( $prefix.'_footer_copyright_text', array(
  'sanitize_callback'   => 'wp_kses_post',
  'transport'           => 'postMessage'
) );



$wp_customize->add_control( $prefix.'_footer_copyright_text', array(
        'type'          => 'textarea',
        'priority'      => 10,
        'label'         => esc_html__( 'Footer Copyright Text', 'arrival' ),
        'description'   => esc_html__('HTML and shortcodes allowed on this section','arrival'),
        'section'       => $prefix.'_footer_settings'
        
      ) );



//footer social icons
$wp_customize->add_setting( $prefix.'_footer_icons_enable', array(
        'default'             => $default[$prefix.'_footer_icons_enable'],
        'sanitize_callback'   => 'arrival_sanitize_switch',
        'transport'           => 'postMessage'
        
      ) );

$wp_customize->add_control( new Arrival_Customizer_Buttonset_Control( $wp_customize, $prefix.'_footer_icons_enable', array(
        'label'         => esc_html__( 'Enable Footer Social Icons', 'arrival' ),
        'priority'      => 15,
        'section'       => $prefix.'_footer_settings',
        'choices'       => array(
          'yes'         => esc_html__( 'Yes', 'arrival' ),
          'no'          => esc_html__( 'No', 'arrival' ),
        )
      ) ) );

//footer social icons
$wp_customize->add_setting( $prefix.'_footer_social_redirect_btn', array(
        'sanitize_callback'     => 'sanitize_text_field',
        'transport'             => 'postMessage'    
      ) );

$wp_customize->add_control( new Arrival_Customize_Redirect( $wp_customize, $prefix.'_footer_social_redirect_btn', array(
        'label'         => esc_html__( 'Configure Social Icons', 'arrival' ),
        'priority'      => 20,
        'description'   => 'arrival_social_icons_section',
        'section'       => $prefix.'_footer_settings',
      ) ) );


/**
* Footer stylings
*
*/

$wp_customize->add_setting($prefix.'_footer_bg_color', array(
        'default'           => $default[$prefix.'_footer_bg_color'],
        'sanitize_callback' => 'arrival_sanitize_color',
        'transport'         => 'postMessage'
    )
);

$wp_customize->add_control( new Arrival_Customizer_Color_Control( $wp_customize, $prefix.'_footer_bg_color', array(
        'label'           => esc_html__( 'Background Color', 'arrival' ),
        'section'         => $prefix.'_footer_settings',
      ) ) );

//foter text colors
$wp_customize->add_setting($prefix.'_footer_text_color', array(
        'default'           => $default[$prefix.'_footer_text_color'],
        'sanitize_callback' => 'arrival_sanitize_color',
        'transport'         => 'postMessage'
    )
);

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix.'_footer_text_color', array(
        'label'           => esc_html__( 'Text Color', 'arrival' ),
        'section'         => $prefix.'_footer_settings',
      ) ) );

//link color
$wp_customize->add_setting($prefix.'_footer_link_color', array(
        'default'           => $default[$prefix.'_footer_link_color'],
        'sanitize_callback' => 'arrival_sanitize_color',
        'transport'         => 'postMessage'
    )
);

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix.'_footer_link_color', array(
        'label'           => esc_html__( 'Link Color', 'arrival' ),
        'section'         => $prefix.'_footer_settings',
      ) ) );

//footer copyright top border
$wp_customize->add_setting( $prefix.'_footer_copyright_border_top', array(
  'sanitize_callback'   => 'arrival_sanitize_checkbox',
  'default'             => $default[$prefix.'_footer_copyright_border_top'],
  'transport'           => 'postMessage'
) );

$wp_customize->add_control( $prefix.'_footer_copyright_border_top', array(
        'type'          => 'checkbox',
        'label'         => esc_html__( 'Enable Copyright Section Top Border', 'arrival' ),
        'description'   => esc_html__('Check the box to enable top border on copyright section','arrival'),
        'section'       => $prefix.'_footer_settings'
        
      ) );

if( function_exists('arrival_customizer_pro_info')){
  arrival_customizer_pro_info( $wp_customize, $prefix.'_footer_settings_info',$prefix.'_footer_settings');
}


/**
* Footer section selective refresh
* 
*/
$footer_ids = array('_footer_copyright_text','_footer_icons_enable','_footer_copyright_border_top');

foreach( $footer_ids as $footer_id ){

  $wp_customize->selective_refresh->add_partial( $prefix.$footer_id, array(
              'selector'            => '.footer-btm',
              'render_callback'     => 'arrival_btm_footer',
              'container_inclusive' => true
        ) );

}


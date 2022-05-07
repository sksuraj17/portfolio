<?php
/**
* Additional settings for customizer
*
* @since 1.2.7
*
*/

$prefix               = 'arrival';
$default              = arrival_get_default_theme_options();


/*
* Width for site logo
*/


$wp_customize->add_setting( $prefix.'_main_logo_width', array(
  'default'             => $default[$prefix.'_main_logo_width'],
  'sanitize_callback'   => 'arrival_sanitize_number',
) );

$wp_customize->add_control( new Arrival_Customizer_Range_Control( $wp_customize, $prefix.'_main_logo_width', array(
  'label'           => esc_html__( 'Logo Width (%)', 'arrival' ),
  'priority'        => 15,
  'section'         => 'title_tagline',
    'input_attrs'       => array(
        'min'   => 0,
        'max'   => 100,
        'step'  => 1,
    ),
) ) );


/**
* Page Settings
*
*/

$wp_customize->add_section( $prefix.'_page_setting_section', array(
      'title'   => esc_html__( 'Page Settings', 'arrival' ),
      'panel'   => 'general_settings'
    )
  );



// page sidebar separator
$wp_customize->add_setting( $prefix.'_page_sidebars_sep', array(
        'sanitize_callback'   => 'sanitize_text_field',        
      ) );

$wp_customize->add_control( new Arrival_Customize_Seperator_Control( $wp_customize, $prefix.'_page_sidebars_sep', array(
        'label'         => esc_html__( 'Sidebar Options', 'arrival' ),
        'section'       => $prefix.'_page_setting_section',
      ) ) );


//page sidebars
$wp_customize->add_setting( $prefix.'_single_page_sidebars', array(
    'default'           => $default[$prefix.'_single_page_sidebars'],
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'arrival_sanitize_page_sidebar'
       )
);
$wp_customize->add_control( new Arrival_Lite_Image_Radio_Control($wp_customize, $prefix.'_single_page_sidebars', array(
    'type'        => 'radio',
    'description' => esc_html__( 'Select sidebar for the pages.', 'arrival' ),
    'section'     => $prefix.'_page_setting_section',
    'choices'     => array(
        'left'          => ARRIVAL_URI . '/assets/images/sidebars/lft.png',
        'right'         => ARRIVAL_URI . '/assets/images/sidebars/rt.png',
        'no_sidebar'    => ARRIVAL_URI . '/assets/images/sidebars/no.png',
                
        )
       )
    )
);

if( function_exists('arrival_customizer_pro_info')){
  arrival_customizer_pro_info( $wp_customize, $prefix.'_single_page_info',$prefix.'_page_setting_section');
}


/**
* Post Settings
*
*/

$wp_customize->add_section( $prefix.'_post_setting_section', array(
      'title'   => esc_html__( 'Post Settings', 'arrival' ),
      'panel'   => 'general_settings'
    )
  );



$wp_customize->add_setting( $prefix.'_post_featured_image_enable', array(
        'default'             => $default[$prefix.'_post_featured_image_enable'],
        'sanitize_callback'   => 'arrival_sanitize_switch',
        
      ) );

$wp_customize->add_control( new Arrival_Customizer_Buttonset_Control( $wp_customize, $prefix.'_post_featured_image_enable', array(
        'label'         => esc_html__( 'Show Featured Image', 'arrival' ),
        'section'       => $prefix.'_post_setting_section',
        'priority'      => 1,
        'choices'       => array(
          'yes'        => esc_html__( 'Yes', 'arrival' ),
          'no'        => esc_html__( 'No', 'arrival' ),
        )
      ) ) );

// post sidebar separator
$wp_customize->add_setting( $prefix.'_post_sidebars_sep', array(
        'sanitize_callback'   => 'sanitize_text_field',        
      ) );

$wp_customize->add_control( new Arrival_Customize_Seperator_Control( $wp_customize, $prefix.'_post_sidebars_sep', array(
        'label'         => esc_html__( 'Sidebar Options', 'arrival' ),
        'section'       => $prefix.'_post_setting_section',
      ) ) );


//post sidebars
$wp_customize->add_setting( $prefix.'_single_post_sidebars', array(
    'default'           => $default[$prefix.'_single_post_sidebars'],
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'arrival_sanitize_page_sidebar'
       )
);
$wp_customize->add_control( new Arrival_Lite_Image_Radio_Control($wp_customize, $prefix.'_single_post_sidebars', array(
    'type'        => 'radio',
    'description' => esc_html__( 'Select sidebar for the pages.', 'arrival' ),
    'section'     => $prefix.'_post_setting_section',
    'choices'     => array(
        'left'          => ARRIVAL_URI . '/assets/images/sidebars/lft.png',
        'right'         => ARRIVAL_URI . '/assets/images/sidebars/rt.png',
        'no_sidebar'    => ARRIVAL_URI . '/assets/images/sidebars/no.png',
                
        )
       )
    )
);


if( function_exists('arrival_customizer_pro_info')){
  arrival_customizer_pro_info( $wp_customize, $prefix.'_single_post_info',$prefix.'_post_setting_section');
}

/**
* Shop Settings
*
*/

if( class_exists('woocommerce')):
$wp_customize->add_section( $prefix.'_shop_setting_section', array(
      'title'   => esc_html__( 'Shop Settings', 'arrival' ),
      'panel'   => 'general_settings'
    )
  );



// post sidebar separator (Archive)
$wp_customize->add_setting( $prefix.'_shop_sidebars_sep_archive', array(
        'sanitize_callback'   => 'sanitize_text_field',        
      ) );

$wp_customize->add_control( new Arrival_Customize_Seperator_Control( $wp_customize, $prefix.'_shop_sidebars_sep_archive', array(
        'label'         => esc_html__( 'Archive Sidebar Options', 'arrival' ),
        'section'       => $prefix.'_shop_setting_section',
      ) ) );


//post sidebars
$wp_customize->add_setting( $prefix.'_archive_shop_sidebars', array(
    'default'           => $default[$prefix.'_archive_shop_sidebars'],
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'arrival_sanitize_page_sidebar'
       )
);
$wp_customize->add_control( new Arrival_Lite_Image_Radio_Control($wp_customize, $prefix.'_archive_shop_sidebars', array(
    'type'        => 'radio',
    'description' => esc_html__( 'Select sidebar for the archive shop page.', 'arrival' ),
    'section'     => $prefix.'_shop_setting_section',
    'choices'     => array(
        'left'          => ARRIVAL_URI . '/assets/images/sidebars/lft.png',
        'right'         => ARRIVAL_URI . '/assets/images/sidebars/rt.png',
        'no_sidebar'    => ARRIVAL_URI . '/assets/images/sidebars/no.png',
                
        )
       )
    )
);


// post sidebar separator (single product page)
$wp_customize->add_setting( $prefix.'_shop_sidebars_sep_single', array(
        'sanitize_callback'   => 'sanitize_text_field',        
      ) );

$wp_customize->add_control( new Arrival_Customize_Seperator_Control( $wp_customize, $prefix.'_shop_sidebars_sep_single', array(
        'label'         => esc_html__( 'Single Sidebar Options', 'arrival' ),
        'section'       => $prefix.'_shop_setting_section',
      ) ) );


//post sidebars
$wp_customize->add_setting( $prefix.'_single_shop_sidebars', array(
    'default'           => $default[$prefix.'_single_shop_sidebars'],
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'arrival_sanitize_page_sidebar'
       )
);
$wp_customize->add_control( new Arrival_Lite_Image_Radio_Control($wp_customize, $prefix.'_single_shop_sidebars', array(
    'type'        => 'radio',
    'description' => esc_html__( 'Select sidebar for the single product page.', 'arrival' ),
    'section'     => $prefix.'_shop_setting_section',
    'choices'     => array(
        'left'          => ARRIVAL_URI . '/assets/images/sidebars/lft.png',
        'right'         => ARRIVAL_URI . '/assets/images/sidebars/rt.png',
        'no_sidebar'    => ARRIVAL_URI . '/assets/images/sidebars/no.png',
                
        )
       )
    )
);

$wp_customize->add_setting( $prefix.'_shop_additional_options_redirect', array(
        'sanitize_callback'     => 'sanitize_text_field',
        'transport'             => 'postMessage'    
      ) );

$wp_customize->add_control( new Arrival_Customize_Redirect( $wp_customize, $prefix.'_shop_additional_options_redirect', array(
        'label'         => esc_html__( 'Additional Settings', 'arrival' ),
        'description'   => 'woocommerce',
        'type'          => 'panel',
        'section'       => $prefix.'_shop_setting_section',
      ) ) );

endif;

/**
* Meta Options
*
*/
$wp_customize->add_section( $prefix.'_meta_setting_section', array(
      'title'   => esc_html__( 'Post Meta', 'arrival' ),
      'panel'   => 'general_settings'
    )
  );


$wp_customize->add_setting( $prefix.'_post_meta_enable', array(
        'default'             => $default[$prefix.'_post_meta_enable'],
        'sanitize_callback'   => 'arrival_sanitize_switch',
        
      ) );

$wp_customize->add_control( new Arrival_Customizer_Buttonset_Control( $wp_customize, $prefix.'_post_meta_enable', array(
        'label'         => esc_html__( 'Show Post Meta', 'arrival' ),
        'description'   => esc_html__('Post meta includes post date, comment counts, author name, post view etc.','arrival'),
        'section'       => $prefix.'_meta_setting_section',
        'priority'      => 1,
        'choices'       => array(
          'yes'        => esc_html__( 'Yes', 'arrival' ),
          'no'        => esc_html__( 'No', 'arrival' ),
        )
      ) ) );

//post author
$wp_customize->add_setting( $prefix.'_post_author_enable', array(
        'default'             => $default[$prefix.'_post_author_enable'],
        'sanitize_callback'   => 'arrival_sanitize_switch',
        
      ) );

$wp_customize->add_control( new Arrival_Customizer_Buttonset_Control( $wp_customize, $prefix.'_post_author_enable', array(
        'label'         => esc_html__( 'Show Post Author', 'arrival' ),
        'section'       => $prefix.'_meta_setting_section',
        'priority'      => 1,
        'choices'       => array(
          'yes'        => esc_html__( 'Yes', 'arrival' ),
          'no'        => esc_html__( 'No', 'arrival' ),
        )
      ) ) );

//post date
$wp_customize->add_setting( $prefix.'_post_date_enable', array(
        'default'             => $default[$prefix.'_post_date_enable'],
        'sanitize_callback'   => 'arrival_sanitize_switch',
        
      ) );

$wp_customize->add_control( new Arrival_Customizer_Buttonset_Control( $wp_customize, $prefix.'_post_date_enable', array(
        'label'         => esc_html__( 'Show Post Date', 'arrival' ),
        'section'       => $prefix.'_meta_setting_section',
        'priority'      => 1,
        'choices'       => array(
          'yes'        => esc_html__( 'Yes', 'arrival' ),
          'no'        => esc_html__( 'No', 'arrival' ),
        )
      ) ) );

// comment count
$wp_customize->add_setting( $prefix.'_post_comment_enable', array(
        'default'             => $default[$prefix.'_post_comment_enable'],
        'sanitize_callback'   => 'arrival_sanitize_switch',
        
      ) );

$wp_customize->add_control( new Arrival_Customizer_Buttonset_Control( $wp_customize, $prefix.'_post_comment_enable', array(
        'label'         => esc_html__( 'Show Post Comment Count', 'arrival' ),
        'section'       => $prefix.'_meta_setting_section',
        'priority'      => 1,
        'choices'       => array(
          'yes'        => esc_html__( 'Yes', 'arrival' ),
          'no'        => esc_html__( 'No', 'arrival' ),
        )
      ) ) );
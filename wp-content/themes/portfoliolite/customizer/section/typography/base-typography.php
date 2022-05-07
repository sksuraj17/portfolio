<?php 
/**
 * Base-Typography for Portfolioline Theme.
 * @package     Portfolioline
 * @author      Portfolioline
 * @copyright   Copyright (c) 2019, Portfolioline
 * @since       Portfolioline 1.0.0
 */
function portfoliolite_typo_customize_register($wp_customize){

 $wp_customize->add_panel( 'portfoliolite_typography_panel', array(
    'priority'       => 30,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __('Typography', 'portfoliolite'),
    'description'    => '',
) );

$wp_customize->add_section('portfoliolite_typography_font_subset', array(
        'title'    => __('Font Subset', 'portfoliolite'),
        'priority' => 2,
        'panel'    =>'portfoliolite_typography_panel'
    ));

if ( class_exists( 'Portfoliolite_Customize_Control_Checkbox_Multiple' ) ){
    $wp_customize->add_setting(
            'portfoliolite_font_subsets', array(
                'default' => array( 'latin' ),
                'sanitize_callback' => 'portfoliolite_checkbox_explode',
            )
        );
    $wp_customize->add_control(
            new Portfoliolite_Customize_Control_Checkbox_Multiple(
                $wp_customize, 'portfoliolite_font_subsets', array(
                    'section' => 'portfoliolite_typography_font_subset',
                    'label'   => esc_html__( 'Font Subsets', 'portfoliolite' ),
                    'choices' => array(
                        'latin'     => 'latin',
                        'latin-ext' => 'latin-ext',
                        'cyrillic'  => 'cyrillic',
                        'cyrillic-ext' => 'cyrillic-ext',
                        'greek'        => 'greek',
                        'greek-ext'    => 'greek-ext',
                        'vietnamese'   => 'vietnamese',
                        'arabic'       => 'arabic',
                    ),
                    'priority' => 1,
                )
            )
        );
}

//Body
$wp_customize->add_section('portfoliolite_base_typography_body_font', array(
        'title'    => __('Body', 'portfoliolite'),
        'priority' => 2,
        'panel'    =>'portfoliolite_typography_panel'
    ));

if (class_exists( 'Portfoliolite_Font_Selector')){
        $wp_customize->add_setting(
            'portfoliolite_body_font', array(
                'type'              => 'theme_mod',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );
        $wp_customize->add_control(
            new Portfoliolite_Font_Selector(
                $wp_customize, 'portfoliolite_body_font', array(
        'label' => esc_html__( 'Font family', 'portfoliolite' ),
                    'section'           => 'portfoliolite_base_typography_body_font',
                    'priority'          => 1,
                    'type'              => 'select',
            )
        )
    );
}
//Text-transform
$wp_customize->add_setting('portfoliolite_body_text_transform', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_select',
));
$wp_customize->add_control( 'portfoliolite_body_text_transform', array(
        'settings' => 'portfoliolite_body_text_transform',
        'label'    => __('Text Transform','portfoliolite'),
        'section'  => 'portfoliolite_base_typography_body_font',
        'type'     => 'select',
        'choices'    => array(
        ''           => __( 'Default', 'portfoliolite' ),
        'none'       => __( 'None', 'portfoliolite' ),
        'capitalize' => __( 'Capitalize', 'portfoliolite' ),
        'uppercase'  => __( 'Uppercase', 'portfoliolite' ),
        'lowercase'  => __( 'Lowercase', 'portfoliolite' ),    
        ),
));

/*******************/
//Title Font-Style
/*******************/
$wp_customize->add_section('portfoliolite-base-typography-body-title', array(
        'title'    => __('Title', 'portfoliolite'),
        'priority' => 2,
        'panel'    =>'portfoliolite_typography_panel'
    ));

if (class_exists( 'Portfoliolite_Font_Selector')){
        $wp_customize->add_setting(
            'portfoliolite_title_font', array(
                'default'           => '',
                'type'              => 'theme_mod',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );
        $wp_customize->add_control(
            new Portfoliolite_Font_Selector(
                $wp_customize, 'portfoliolite_title_font', array(
            'label' => esc_html__( 'Font family', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-title',
                    'priority'    => 1,
                    'type'        => 'select',
            )
        )
    );
}
//Text-transform
$wp_customize->add_setting('portfoliolite_title_text_transform', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_select',
));
$wp_customize->add_control( 'portfoliolite_title_text_transform', array(
        'settings' => 'portfoliolite_title_text_transform',
        'label'    => __('Text Transform','portfoliolite'),
        'section'  => 'portfoliolite-base-typography-body-title',
        'type'     => 'select',
        'choices'    => array(
        ''           => __( 'Default', 'portfoliolite' ),
        'none'       => __( 'None', 'portfoliolite' ),
        'capitalize' => __( 'Capitalize', 'portfoliolite' ),
        'uppercase'  => __( 'Uppercase', 'portfoliolite' ),
        'lowercase'  => __( 'Lowercase', 'portfoliolite' ),    
        ),
));

//content
$wp_customize->add_section('portfoliolite-base-typography-body-content', array(
        'title'    => __('Content', 'portfoliolite'),
        'priority' => 2,
        'panel'    =>'portfoliolite_typography_panel'
    ));
/**********************/
//Content Font-Style H1
/**********************/
if (class_exists( 'Portfoliolite_Font_Selector')){
        $wp_customize->add_setting(
            'portfoliolite_h1_font', array(
                'default'           => '',
                'type'              => 'theme_mod',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );
        $wp_customize->add_control(
            new Portfoliolite_Font_Selector(
                $wp_customize, 'portfoliolite_h1_font', array(
            'label' => esc_html__( 'H1', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    'type'        => 'select',
            )
        )
    );
}
//H1 Text-transform
$wp_customize->add_setting('portfoliolite_h1_text_transform', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_select',
));
$wp_customize->add_control( 'portfoliolite_h1_text_transform', array(
        'settings' => 'portfoliolite_h1_text_transform',
        'label'    => __('Text Transform','portfoliolite'),
        'section'  => 'portfoliolite-base-typography-body-content',
        'type'     => 'select',
        'choices'    => array(
        ''           => __( 'Default', 'portfoliolite' ),
        'none'       => __( 'None', 'portfoliolite' ),
        'capitalize' => __( 'Capitalize', 'portfoliolite' ),
        'uppercase'  => __( 'Uppercase', 'portfoliolite' ),
        'lowercase'  => __( 'Lowercase', 'portfoliolite' ),    
        ),
));
if ( class_exists( 'Portfoliolite_WP_Customizer_Range_Value_Control' ) ){
$wp_customize->add_setting(
            'portfoliolite_h1_size', array(
                'sanitize_callback' => 'portfoliolite_sanitize_range_value',
                'default'           => '48',
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new Portfoliolite_WP_Customizer_Range_Value_Control(
                $wp_customize, 'portfoliolite_h1_size', array(
                    'label'       => esc_html__( 'Font-Size', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    'type'        => 'portfoliolite-range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
    );
$wp_customize->add_setting(
            'portfoliolite_h1_line_height', array(
                'sanitize_callback' => 'portfoliolite_sanitize_range_value',
                'default'           => '1.2',
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new Portfoliolite_WP_Customizer_Range_Value_Control(
                $wp_customize,'portfoliolite_h1_line_height', array(
                    'label'       => esc_html__( 'Line-Height', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    'type'        => 'portfoliolite-range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 10,
                        'step' => 0.1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
    );

// font letter spacing
$wp_customize->add_setting(
                'portfoliolite_h1_letter_spacing', array(
                'sanitize_callback' => 'portfoliolite_sanitize_range_value',
                'default'           => '1',
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new Portfoliolite_WP_Customizer_Range_Value_Control(
                $wp_customize, 'portfoliolite_h1_letter_spacing', array(
                    'label'       => esc_html__( 'Letter-Spacing', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    'type'        => 'portfoliolite-range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
    );
}

/**********************/
//Content Font-Style H2
/**********************/
if (class_exists( 'Portfoliolite_Font_Selector')){
        $wp_customize->add_setting(
            'portfoliolite_h2_font', array(
                'default'           => '',
                'type'              => 'theme_mod',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );
        $wp_customize->add_control(
            new Portfoliolite_Font_Selector(
                $wp_customize, 'portfoliolite_h2_font', array(
            'label' => esc_html__( 'H2', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    
                    'type'        => 'select',
            )
        )
    );
}
//H1 Text-transform
$wp_customize->add_setting('portfoliolite_h2_text_transform', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_select',
));
$wp_customize->add_control( 'portfoliolite_h2_text_transform', array(
        'settings' => 'portfoliolite_h2_text_transform',
        'label'    => __('Text Transform','portfoliolite'),
        'section'  => 'portfoliolite-base-typography-body-content',
        'type'     => 'select',
        'choices'    => array(
        ''           => __( 'Default', 'portfoliolite' ),
        'none'       => __( 'None', 'portfoliolite' ),
        'capitalize' => __( 'Capitalize', 'portfoliolite' ),
        'uppercase'  => __( 'Uppercase', 'portfoliolite' ),
        'lowercase'  => __( 'Lowercase', 'portfoliolite' ),    
        ),
));
if ( class_exists( 'Portfoliolite_WP_Customizer_Range_Value_Control' ) ){
$wp_customize->add_setting(
            'portfoliolite_h2_size', array(
                'default'           => '44',
                'sanitize_callback' => 'portfoliolite_sanitize_range_value',
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new Portfoliolite_WP_Customizer_Range_Value_Control(
                $wp_customize, 'portfoliolite_h2_size', array(
                    'label'       => esc_html__( 'Font-Size', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    'type'        => 'portfoliolite-range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
    );
$wp_customize->add_setting(
            'portfoliolite_h2_line_height', array(
                'sanitize_callback' => 'portfoliolite_sanitize_range_value',
                'default'           => '1.3',
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new Portfoliolite_WP_Customizer_Range_Value_Control(
                $wp_customize,'portfoliolite_h2_line_height', array(
                    'label'       => esc_html__( 'Line-Height', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    'type'        => 'portfoliolite-range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 10,
                        'step' => 0.1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
    );

// font letter spacing
$wp_customize->add_setting(
                'portfoliolite_h2_letter_spacing', array(
                'sanitize_callback' => 'portfoliolite_sanitize_range_value',
                'default'           => '1',
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new Portfoliolite_WP_Customizer_Range_Value_Control(
                $wp_customize, 'portfoliolite_h2_letter_spacing', array(
                    'label'       => esc_html__( 'Letter-Spacing', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    'type'        => 'portfoliolite-range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
    );
}
/**********************/
//Content Font-Style H3
/**********************/
if (class_exists( 'Portfoliolite_Font_Selector')){
        $wp_customize->add_setting(
            'portfoliolite_h3_font', array(
                'default'           => '',
                'type'              => 'theme_mod',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );
        $wp_customize->add_control(
            new Portfoliolite_Font_Selector(
                $wp_customize, 'portfoliolite_h3_font', array(
            'label' => esc_html__( 'H3', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    
                    'type'        => 'select',
            )
        )
    );
}
//H1 Text-transform
$wp_customize->add_setting('portfoliolite_h3_text_transform', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_select',
));
$wp_customize->add_control( 'portfoliolite_h3_text_transform', array(
        'settings' => 'portfoliolite_h3_text_transform',
        'label'    => __('Text Transform','portfoliolite'),
        'section'  => 'portfoliolite-base-typography-body-content',
        'type'     => 'select',
        'choices'    => array(
        ''           => __( 'Default', 'portfoliolite'),
        'none'       => __( 'None', 'portfoliolite'),
        'capitalize' => __( 'Capitalize', 'portfoliolite'),
        'uppercase'  => __( 'Uppercase', 'portfoliolite'),
        'lowercase'  => __( 'Lowercase', 'portfoliolite'),    
        ),
));
if ( class_exists( 'Portfoliolite_WP_Customizer_Range_Value_Control' ) ){
$wp_customize->add_setting(
            'portfoliolite_h3_size', array(
                'sanitize_callback' => 'portfoliolite_sanitize_range_value',
                'default'           => '44',
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new Portfoliolite_WP_Customizer_Range_Value_Control(
                $wp_customize, 'portfoliolite_h3_size', array(
                    'label'       => esc_html__( 'Font-Size', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    'type'        => 'portfoliolite-range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
    );
$wp_customize->add_setting(
            'portfoliolite_h3_line_height', array(
                'sanitize_callback' => 'portfoliolite_sanitize_range_value',
                'default'           => '1.3',
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new Portfoliolite_WP_Customizer_Range_Value_Control(
                $wp_customize,'portfoliolite_h3_line_height', array(
                    'label'       => esc_html__( 'Line-Height', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    'type'        => 'portfoliolite-range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 10,
                        'step' => 0.1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
    );

// font letter spacing
$wp_customize->add_setting(
                'portfoliolite_h3_letter_spacing', array(
                'sanitize_callback' => 'portfoliolite_sanitize_range_value',
                'default'           => '1',
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new Portfoliolite_WP_Customizer_Range_Value_Control(
                $wp_customize, 'portfoliolite_h3_letter_spacing', array(
                    'label'       => esc_html__( 'Letter-Spacing', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    'type'        => 'portfoliolite-range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
    );
}

/**********************/
//Content Font-Style H4
/**********************/
if (class_exists( 'Portfoliolite_Font_Selector')){
        $wp_customize->add_setting(
            'portfoliolite_h4_font', array(
                'default'           => '',
                'type'              => 'theme_mod',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );
        $wp_customize->add_control(
            new Portfoliolite_Font_Selector(
                $wp_customize, 'portfoliolite_h4_font', array(
            'label' => esc_html__( 'H4', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    
                    'type'        => 'select',
            )
        )
    );
}
//H1 Text-transform
$wp_customize->add_setting('portfoliolite_h4_text_transform', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_select',
));
$wp_customize->add_control( 'portfoliolite_h4_text_transform', array(
        'settings' => 'portfoliolite_h4_text_transform',
        'label'    => __('Text Transform','portfoliolite'),
        'section'  => 'portfoliolite-base-typography-body-content',
        'type'     => 'select',
        'choices'    => array(
        ''           => __( 'Default', 'portfoliolite' ),
        'none'       => __( 'None', 'portfoliolite' ),
        'capitalize' => __( 'Capitalize', 'portfoliolite' ),
        'uppercase'  => __( 'Uppercase', 'portfoliolite' ),
        'lowercase'  => __( 'Lowercase', 'portfoliolite' ),    
        ),
));
if ( class_exists( 'Portfoliolite_WP_Customizer_Range_Value_Control' ) ){
$wp_customize->add_setting(
            'portfoliolite_h4_size', array(
                'sanitize_callback' => 'portfoliolite_sanitize_range_value',
                'default'           => '44',
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new Portfoliolite_WP_Customizer_Range_Value_Control(
                $wp_customize, 'portfoliolite_h4_size', array(
                    'label'       => esc_html__( 'Font-Size', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    'type'        => 'portfoliolite-range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
    );
$wp_customize->add_setting(
            'portfoliolite_h4_line_height', array(
                'sanitize_callback' => 'portfoliolite_sanitize_range_value',
                'default'           => '1.3',
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new Portfoliolite_WP_Customizer_Range_Value_Control(
                $wp_customize,'portfoliolite_h4_line_height', array(
                    'label'       => esc_html__( 'Line-Height', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    'type'        => 'portfoliolite-range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 10,
                        'step' => 0.1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
    );

// font letter spacing
$wp_customize->add_setting(
                'portfoliolite_h4_letter_spacing', array(
                'sanitize_callback' => 'portfoliolite_sanitize_range_value',
                'default'           => '1',
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new Portfoliolite_WP_Customizer_Range_Value_Control(
                $wp_customize, 'portfoliolite_h4_letter_spacing', array(
                    'label'       => esc_html__( 'Letter-Spacing', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    'type'        => 'portfoliolite-range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
    );
}
/**********************/
//Content Font-Style H5
/**********************/
if (class_exists( 'Portfoliolite_Font_Selector')){
        $wp_customize->add_setting(
            'portfoliolite_h5_font', array(
                'default'           => '',
                'type'              => 'theme_mod',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );
        $wp_customize->add_control(
            new Portfoliolite_Font_Selector(
                $wp_customize, 'portfoliolite_h5_font', array(
            'label' => esc_html__( 'H5', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    
                    'type'        => 'select',
            )
        )
    );
}
//H1 Text-transform
$wp_customize->add_setting('portfoliolite_h5_text_transform', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_select',
));
$wp_customize->add_control( 'portfoliolite_h5_text_transform', array(
        'settings' => 'portfoliolite_h5_text_transform',
        'label'    => __('Text Transform','portfoliolite'),
        'section'  => 'portfoliolite-base-typography-body-content',
        'type'     => 'select',
        'choices'    => array(
        ''           => __( 'Default', 'portfoliolite' ),
        'none'       => __( 'None', 'portfoliolite' ),
        'capitalize' => __( 'Capitalize', 'portfoliolite' ),
        'uppercase'  => __( 'Uppercase', 'portfoliolite' ),
        'lowercase'  => __( 'Lowercase', 'portfoliolite' ),    
        ),
));
if ( class_exists( 'Portfoliolite_WP_Customizer_Range_Value_Control' ) ){
$wp_customize->add_setting(
            'portfoliolite_h5_size', array(
                'sanitize_callback' => 'portfoliolite_sanitize_range_value',
                'default'           => '44',
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new Portfoliolite_WP_Customizer_Range_Value_Control(
                $wp_customize, 'portfoliolite_h5_size', array(
                    'label'       => esc_html__( 'Font-Size', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    'type'        => 'portfoliolite-range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
    );
$wp_customize->add_setting(
            'portfoliolite_h5_line_height', array(
                'sanitize_callback' => 'portfoliolite_sanitize_range_value',
                'default'           => '1.3',
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new Portfoliolite_WP_Customizer_Range_Value_Control(
                $wp_customize,'portfoliolite_h5_line_height', array(
                    'label'       => esc_html__( 'Line-Height', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    'type'        => 'portfoliolite-range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 10,
                        'step' => 0.1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
    );

// font letter spacing
$wp_customize->add_setting(
                'portfoliolite_h5_letter_spacing', array(
                'sanitize_callback' => 'portfoliolite_sanitize_range_value',
                'default'           => '1',
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new Portfoliolite_WP_Customizer_Range_Value_Control(
                $wp_customize, 'portfoliolite_h5_letter_spacing', array(
                    'label'       => esc_html__( 'Letter-Spacing', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    'type'        => 'portfoliolite-range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
    );
}
/**********************/
//Content Font-Style H6
/**********************/
if (class_exists( 'Portfoliolite_Font_Selector')){
        $wp_customize->add_setting(
            
            'portfoliolite_h6_font', array(
                'default'           => '',
                'type'              => 'theme_mod',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );
        $wp_customize->add_control(
            new Portfoliolite_Font_Selector(
                $wp_customize, 'portfoliolite_h6_font', array(
            'label' => esc_html__( 'H6', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    
                    'type'        => 'select',
            )
        )
    );
}
//H1 Text-transform
$wp_customize->add_setting('portfoliolite_h6_text_transform', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'portfoliolite_sanitize_select',
));
$wp_customize->add_control( 'portfoliolite_h6_text_transform', array(
        'settings' => 'portfoliolite_h6_text_transform',
        'label'    => __('Text Transform','portfoliolite'),
        'section'  => 'portfoliolite-base-typography-body-content',
        'type'     => 'select',
        'choices'    => array(
        ''           => __( 'Default', 'portfoliolite' ),
        'none'       => __( 'None', 'portfoliolite' ),
        'capitalize' => __( 'Capitalize', 'portfoliolite' ),
        'uppercase'  => __( 'Uppercase', 'portfoliolite' ),
        'lowercase'  => __( 'Lowercase', 'portfoliolite' ),    
        ),
));
if ( class_exists( 'Portfoliolite_WP_Customizer_Range_Value_Control' ) ){
$wp_customize->add_setting(
            'portfoliolite_h6_size', array(
                'sanitize_callback' => 'portfoliolite_sanitize_range_value',
                'default'           => '44',
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new Portfoliolite_WP_Customizer_Range_Value_Control(
                $wp_customize, 'portfoliolite_h6_size', array(
                    'label'       => esc_html__( 'Font-Size', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    'type'        => 'portfoliolite-range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
    );
$wp_customize->add_setting(
            'portfoliolite_h6_line_height', array(
                'sanitize_callback' => 'portfoliolite_sanitize_range_value',
                'default'           => '1.3',
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new Portfoliolite_WP_Customizer_Range_Value_Control(
                $wp_customize,'portfoliolite_h6_line_height', array(
                    'label'       => esc_html__( 'Line-Height', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    'type'        => 'portfoliolite-range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 10,
                        'step' => 0.1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
    );

// font letter spacing
$wp_customize->add_setting(
                'portfoliolite_h6_letter_spacing', array(
                'sanitize_callback' => 'portfoliolite_sanitize_range_value',
                'default'           => '1',
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new Portfoliolite_WP_Customizer_Range_Value_Control(
                $wp_customize, 'portfoliolite_h6_letter_spacing', array(
                    'label'       => esc_html__( 'Letter-Spacing', 'portfoliolite' ),
                    'section'     => 'portfoliolite-base-typography-body-content',
                    'type'        => 'portfoliolite-range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
    );
}

// doc link
    $wp_customize->add_setting('portfoliolite_typo_doc', array(
    'sanitize_callback' => 'portfoliolite_sanitize_text',
    ));
    $wp_customize->add_control(new Portfoliolite_Misc_Control( $wp_customize, 'portfoliolite_typo_doc',
            array(
        'section'     => 'portfoliolite_base_typography_body_font',
        'type'        => 'doc-link',
        'url'         => 'https://themehunk.com/docs/portfoliolite-theme/#typography-setting',
        'description' => esc_html__( 'To know more go with this', 'portfoliolite' ),
        'priority'    =>100,
    )));

}
add_action('customize_register','portfoliolite_typo_customize_register');

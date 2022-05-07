<?php
/**
 * Arrival Theme Customizer
 *
 * @package arrival
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
require ARRIVAL_DIR . '/inc/customizer/customizer-defaults.php';
require ARRIVAL_DIR . '/inc/customizer/buttonset/init.php';
require ARRIVAL_DIR . '/inc/customizer/customizer-custom-controllers.php';
require ARRIVAL_DIR . '/inc/customizer/customizer-sanitize.php';
require ARRIVAL_DIR . '/inc/customizer/repeater-controller/customizer.php';
require ARRIVAL_DIR . '/inc/customizer/customizer-tabs/init.php';
require ARRIVAL_DIR . '/inc/customizer/range/class-control-range.php';
require ARRIVAL_DIR . '/inc/customizer/color/class-control-color.php';
require ARRIVAL_DIR . '/inc/customizer/dimensions/class-control-dimensions.php';



function arrival_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname', array(
				'selector'        => '.site-title a',
				'render_callback' => 'arrival_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription', array(
				'selector'        => '.site-description',
				'render_callback' => 'arrival_customize_partial_blogdescription',
			)
		);
	}

	

	require get_template_directory() . '/inc/customizer/arrival-customizer.php';

	require get_template_directory() . '/inc/customizer/customizer-additional.php';

	/**
	* Hook to pass additional customizer settings from child themes
	* the hook accepts array or single file
	*/
	$arrival_req_additional = apply_filters('arrival_customizer_additionals_req','__return_false');
	
	if( $arrival_req_additional != '__return_false' ){

		if( is_array($arrival_req_additional) ){
			foreach ( $arrival_req_additional as $arrival_req ){
				require $arrival_req;
			}
		}else{
			require $arrival_req_additional;		
		}
		
	}


if( ! class_exists('Arrival_Companion') ):
	// Register custom section types.
	$wp_customize->register_section_type( 'Arrival_Customize_Section_Pro' );

	// Register sections.
	$wp_customize->add_section(
	    new Arrival_Customize_Section_Pro(
	        $wp_customize,
	        'arrival-pro',
	        array(
	            'title'    => esc_html__( 'Premium Addons Available', 'arrival' ),
	            'pro_text' => esc_html__( 'Buy Now','arrival' ),
	            'pro_text1' => esc_html__( 'Compare','arrival' ),
	            'pro_url'  => 'https://wpoperation.com/themes/arrival-pro/',
	            'priority' => 0,
	        )
	    )
	);
	$wp_customize->add_setting(
		'opstore_pro_upbuton',
		array(
			'section' => 'arrival-pro',
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control(
		'opstore_pro_upbuton',
		array(
			'section' => 'arrival-pro'
		)
	);

endif;

}
add_action( 'customize_register', 'arrival_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function arrival_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function arrival_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function arrival_customize_preview_js() {
	wp_enqueue_script( 'arrival-customizer', get_theme_file_uri( '/assets/js/customizer.js' ), array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'arrival_customize_preview_js' );


/**
* add customizer scripts
*/
function arrival_customizer_scripts(){
	wp_enqueue_style( 'arrival-customizer-colors', get_theme_file_uri( '/assets/css/colors.css' ), array(), ARRIVAL_VER );

	wp_enqueue_style( 'arrival-customizer-styles', get_theme_file_uri( '/assets/css/customizer-styles.css' ), array(), ARRIVAL_VER );
	wp_enqueue_style( 'arrival-customizer-general', get_theme_file_uri( '/assets/css/customizer-general.css' ), array(), ARRIVAL_VER );

	wp_enqueue_script( 'arrival-customizer-general', get_theme_file_uri( '/assets/js/customizer-general.js' ), array('jquery','customize-base'), ARRIVAL_VER );
	wp_enqueue_script( 'arrival-customizer-scripts', get_theme_file_uri( '/assets/js/customizer-control.js' ), array('jquery','customize-controls'), ARRIVAL_VER );
}
add_action('customize_controls_enqueue_scripts','arrival_customizer_scripts');


/**
* Pro info section
*
* @return text for premium version
*/
if( ! function_exists('arrival_customizer_pro_info')){
	function arrival_customizer_pro_info($wp_customize,$call_back_id, $section){

	$pro_info_return = apply_filters('arrival_customizer_text_pro','__return_true');

	

	if( (false == $pro_info_return) || class_exists('Arrival_Companion') )
		return;

	if ( ! class_exists( 'WP_Customize_Control' ) ) {
		return; 
	}


	$wp_customize->add_setting( $call_back_id, array(
        'sanitize_callback'   => 'sanitize_text_field',        
      ) );

	$wp_customize->add_control( new Arrival_Customize_Pro_Info( $wp_customize, $call_back_id, array(
			'label' 		=> sprintf( __('%1$s Arrival Pro %2$s','arrival'), '<a href="https://wpoperation.com/themes/arrival-pro" target="_blank">', '</a>' ),
			'priority'		=> 90,
	        'description'   => esc_html__( 'more options available in', 'arrival' ),
	        'section'       => $section,
	      ) ) );

	}
}



/**
 * Default color picker palettes
 *
 * @since 1.0.1
 */
if ( ! function_exists( 'arrival_default_color_palettes' ) ) {

	function arrival_default_color_palettes() {

		$palettes = array(
			'#000000',
			'#ffffff',
			'#dd3333',
			'#dd9933',
			'#eeee22',
			'#81d742',
			'#1e73be',
			'#8224e3',
		);

		// Apply filters and return
		return apply_filters( 'arrival_default_color_palettes', $palettes );

	}

}
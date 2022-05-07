<?php 
/**
* Register widget area for theme
* @package Arrival
* @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
* 
*/
function arrival_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Right Sidebar', 'arrival' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to display on right sidebar.', 'arrival' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Left Sidebar', 'arrival' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here to display on left sidebar.', 'arrival' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );


	register_sidebar( array(
		'name'          => esc_html__( 'After Top Header', 'arrival' ),
		'id'            => 'top-header-after',
		'description'   => esc_html__( 'Add widgets here to display after top header.', 'arrival' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );


	$footer_widget_regions = apply_filters( 'arrival_footer_widget_regions', 4 );
	for ( $i = 1; $i <= intval( $footer_widget_regions ); $i++ ) {
		register_sidebar( array(
			'name' 				=> sprintf( esc_html__( 'Footer Area %d', 'arrival' ), $i ),
			'id' 				=> sprintf( 'footer-%d', $i ),
			'description' 		=> sprintf( esc_html__( ' Add Widgetized Footer Region %d.', 'arrival' ), $i ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		));
	}

}
add_action( 'widgets_init', 'arrival_widgets_init' );

/**
* required files and functions for widgets
*
*/

require get_template_directory() . '/inc/widgets/widget-fields.php';
require get_template_directory() . '/inc/widgets/widget-contact-info.php';
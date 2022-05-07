<?php
/**
* Starter content for the theme
* @package Arrival
* @since 1.0.8
* @link https://github.com/WordPress/WordPress/blob/ee36cf92143dd7da39f9dd6d092637fcee38822e/wp-content/themes/twentyseventeen/functions.php#L106-L189
*/

class Arrival_Starter_Contents{


	/**
	 * A reference to an instance of this class.
	 *
	 * @access private
	 * @var    object
	 */

	private static $instance = null;



	public static function get_instance() {
        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }



    public function __construct() {

    	add_action( 'after_setup_theme', array($this,'arrival_starter_content_data') );

    }



    function arrival_starter_content_data(){

    	add_theme_support('starter-content', array(
    		

	        // Starter pages to include
	        'posts' => array(
	            'home',
	            'about',
	            'contact',
	            'blog'
	        ),

	        // Add pages to primary navigation menu
	        'nav_menus' => array(

	            'primary' => array(
	                'name' => esc_html__('Main Menu', 'arrival'),
	                'items' => array(
	                    'home_link',
	                    'page_about',
	                    'page_blog',
	                    'page_contact',
	                ),
	            ),

	            'top' => array(
	                'name' => esc_html__('Top Menu', 'arrival'),
	                'items' => array(
	                    'home_link',
	                    'page_about',
	                    'page_blog',
	                    'page_contact',
	                ),
	            )

	        ),

	        //theme options
	        'theme_mods' => array(
				'arrival_top_header_email' => esc_html__('info@example.com','arrival'),
				'arrival_top_header_phone' => esc_html__('+023-5584-633','arrival'),

			),

		    // Add test widgets to footer sidebar
	        'widgets' => array(
	            
	            'footer-1' => array(
					'text_business_info',
				),

				'footer-2' => array(
					'search',
					'text_about',
				),

				'footer-3' => array(
					'text_business_info',
				),

				'footer-4' => array(
					'text_about',
				),

	        )



    	));

    }






}

/**
* Returns instanse of the class.
*
* @return object
*/
function arrival_starter_contents_init() {
	return Arrival_Starter_Contents::get_instance();
}

arrival_starter_contents_init();
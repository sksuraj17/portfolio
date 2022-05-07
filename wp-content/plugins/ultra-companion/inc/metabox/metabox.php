<?php

/**
 * Fucntions for rendering metaboxes in page and posts
 * 
 * @package WPoperation
 * @subpackage Ultra Companion
 * @since 1.0.6
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Ultra_Metabox_Options' ) ) {
	final class Ultra_Metabox_Options{

		private $post_types;
		private $default_control;
		private $custom_control;

		private function setup_actions() {


			// Post types to add the metabox to
			$this->post_types = apply_filters( 'ultra_main_metaboxes_post_types', array(
				'post',
				'page',
			) );

			// Default butterbean controls
			$this->default_control = array(
				'select',
				'color',
				'image',
				'text',
				'number',
				'textarea',
			);

			// Custom butterbean controls
			$this->custom_control = array(
				'buttonset' 		=> 'Ultra_ButterBean_Control_Buttonset',
				'range' 			=> 'Ultra_ButterBean_Control_Range',
				'media' 			=> 'Ultra_ButterBean_Control_Media',
				'rgba-color' 		=> 'Ultra_ButterBean_Control_RGBA_Color',
				'multiple-select' 	=> 'Ultra_ButterBean_Control_Multiple_Select',
				'editor' 			=> 'Ultra_ButterBean_Control_Editor',
				//'typography' 		=> 'Ultra_ButterBean_Control_Typography',
			);
			// Overwrite default controls
			add_filter( 'butterbean_pre_control_template', array( $this, 'default_control_templates' ), 10, 2 );

			// Register custom controls
			add_filter( 'butterbean_control_template', array( $this, 'custom_control_templates' ), 10, 2 );

			// Register new controls types
			add_action( 'butterbean_register', array( $this, 'register_control_types' ), 10, 2 );

			// Load scripts and styles.
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

			add_action( 'butterbean_register', array($this,'ultra_companion_meta_register'), 10, 2 );
	    }

		/**
		 * Load scripts and styles
		 *
		 * @since 1.0.6
		 */
		public function enqueue_scripts( $hook ) {

			// Only needed on these admin screens
			if ( $hook != 'edit.php' && $hook != 'post.php' && $hook != 'post-new.php' ) {
				return;
			}

			// Get global post
			global $post;

			// Return if post is not object
			if ( ! is_object( $post ) ) {
				return;
			}

			$post_types_scripts = apply_filters( 'ultra_metaboxes_post_types_scripts', $this->post_types );

			// Return if wrong post type
			if ( ! in_array( $post->post_type, $post_types_scripts ) ) {
				return;
			}

			$min = ( SCRIPT_DEBUG ) ? '' : '.min';

			// Default style
			wp_enqueue_style( 'ultra-companion-butterbean', plugins_url( '/controls/assets/css/butterbean'. $min .'.css', __FILE__ ) );

			// Default script.
			wp_enqueue_script( 'ultra-companion-butterbean', plugins_url( '/controls/assets/js/butterbean'. $min .'.js', __FILE__ ), array( 'butterbean' ), '', true );

			// Metabox script
			wp_enqueue_script( 'ultra-companion-metabox-script', plugins_url( '/assets/js/metabox.js', __FILE__ ), array( 'jquery' ), ULC_VERSION, true );

			// Enqueue the select2 script, I use "ultra-companion-select2" to avoid plugins conflicts
			wp_enqueue_script( 'ultra-companion-select2', plugins_url( '/controls/assets/js/select2.full.min.js', __FILE__ ), array( 'jquery' ), false, true );

			// Enqueue the select2 style
			wp_enqueue_style( 'select2', plugins_url( '/controls/assets/css/select2.min.css', __FILE__ ) );

			// Enqueue color picker alpha
			wp_enqueue_script( 'wp-color-picker-alpha', plugins_url( '/controls/assets/js/wp-color-picker-alpha.js', __FILE__ ), array( 'wp-color-picker' ), false, true );

		}

		/**
		 * Registers control types
		 *
		 * @since  1.2.4
		 */
		public function register_control_types( $butterbean ) {
			$controls = $this->custom_control;

			foreach ( $controls as $control => $class ) {

				require_once( ULC_PATH . '/inc/metabox/controls/'. $control .'/class-control-'. $control .'.php' );
				$butterbean->register_control_type( $control, $class );

			}
		}

		/**
		 * Get custom control templates
		 *
		 * @since  1.2.4
		 */
		public function default_control_templates( $located, $slug ) {
			$controls = $this->default_control;

			foreach ( $controls as $control ) {

				if ( $slug === $control ) {
					return ULC_PATH . '/inc/metabox/controls/'. $control .'/template.php';
				}

			}

			return $located;
		}

		/**
		 * Get custom control templates
		 *
		 * @since  1.2.4
		 */
		public function custom_control_templates( $located, $slug ) {
			$controls = $this->custom_control;

			foreach ( $controls as $control => $class ) {

				if ( $slug === $control ) {
					return ULC_PATH . '/inc/metabox/controls/'. $control .'/template.php';
				}

			}

			return $located;
		}

		/**
		 * Registration callback
		 *
		 * @since 1.0.6
		 */
		public function ultra_companion_meta_register( $butterbean, $post_type ) {
            $theme = wp_get_theme();
			$butterbean->register_manager(
			        'page_options',
			        array(
			        	'label'     => $theme->get('Name').esc_html__( ' Page Options', 'ultra-companion' ),
			        	'post_type' => array('page','post'),
			        	'context'   => 'normal',
			        	'priority'  => 'high'
			        )
			);
			$manager = $butterbean->get_manager( 'page_options' );

			/* Adding Global Settings */
			if(get_template() == 'arrival' || wp_get_theme( 'opstore-lite' )){
			$manager->register_section(
			        'global_settings',
			        array(
			        	'label' => esc_html__( 'Global Settings', 'ultra-companion' ),
					'icon'  => 'dashicons-admin-site'
				)
			);

           

		    //Bg color
			$manager->register_control(
		        'ultra_page_bg_color', // Same as setting name.
		        array(
		            'section' 		=> 'global_settings',
		            'type'    		=> 'rgba-color',
		            'label'   		=> esc_html__( 'Background Color', 'ultra-companion' ),
		            'description'   => esc_html__( 'Select a color. Hex code, ex: #555', 'ultra-companion' ),
		        )
		    );
			$manager->register_setting(
		        'ultra_page_bg_color', // Same as control name.
		        array(
		            'sanitize_callback' => 'butterbean_maybe_hash_hex_color',
		        )
		    );



			if ( get_stylesheet() == 'arrival' || get_stylesheet() == 'arrival-me' ){
		    //Header Colors for Arrival theme
		    $manager->register_control(
		        'ultra_arrival_header_bg_color', // Same as setting name.
		        array(
		            'section' 		=> 'global_settings',
		            'type'    		=> 'rgba-color',
		            'label'   		=> esc_html__( 'Header Background Color', 'ultra-companion' ),
		            'description'   => esc_html__( 'Select header color for this page', 'ultra-companion' ),
		        )
		    );
			$manager->register_setting(
		        'ultra_arrival_header_bg_color', // Same as control name.
		        array(
		            'sanitize_callback' => 'butterbean_maybe_hash_hex_color',
		        )
		    );

		    $manager->register_control(
		        'ultra_arrival_header_link_color', // Same as setting name.
		        array(
		            'section' 		=> 'global_settings',
		            'type'    		=> 'rgba-color',
		            'label'   		=> esc_html__( 'Menu Link Color', 'ultra-companion' ),
		            'description'   => esc_html__( 'Menu link color for this page', 'ultra-companion' ),
		        )
		    );
			$manager->register_setting(
		        'ultra_arrival_header_link_color', // Same as control name.
		        array(
		            'sanitize_callback' => 'butterbean_maybe_hash_hex_color',
		        )
		    );
			


			}

		    
		    //Header Layout
			$manager->register_control(
		        'ultra_page_header', // Same as setting name.
		        array(
		            'section' 		=> 'global_settings',
		            'type'    		=> 'buttonset',
		            'label'   		=> esc_html__( 'Header Layout', 'ultra-companion' ),
		            'description'   => esc_html__( 'It is a settings for header for this specific page..', 'ultra-companion' ),
					'choices' 		=> array(
						'default' 	=> esc_html__( 'Default', 'ultra-companion' ),
						'custom' 		=> esc_html__( 'Custom', 'ultra-companion' ),
						'hide' 		=> esc_html__( 'Hide', 'ultra-companion' ),
					),
		        )
		    );
			$manager->register_setting(
		        'ultra_page_header',
		        array(
		            'sanitize_callback' => 'sanitize_key',
		            'default' 			=> 'default',
		        )
		    );

		    //elementor lib lists
			$manager->register_control(
		        'ultra_page_custom_header', 
		        array(
		            'section' 		=> 'global_settings',
		            'type'    		=> 'select',
		            'label'   		=> esc_html__( 'Header Template', 'ultra-companion' ),
		            'description'   => esc_html__( 'Select your custom header template from elementor library.', 'ultra-companion' ),
					'choices' 		=> $this->helpers( 'elementor_lib' ),
		        )
		    );
			$manager->register_setting(
		        'ultra_page_custom_header',
		        array(
		            'sanitize_callback' => 'sanitize_key',
		        )
		    );

		    //Footer Layout
			$manager->register_control(
		        'ultra_page_footer', // Same as setting name.
		        array(
		            'section' 		=> 'global_settings',
		            'type'    		=> 'buttonset',
		            'label'   		=> esc_html__( 'Footer Layout', 'ultra-companion' ),
		            'description'   => esc_html__( 'It is a settings for footer for this specific page..', 'ultra-companion' ),
					'choices' 		=> array(
						'default' 	=> esc_html__( 'Default', 'ultra-companion' ),
						'custom' 		=> esc_html__( 'Custom', 'ultra-companion' ),
						'hide' 		=> esc_html__( 'Hide', 'ultra-companion' ),
					),
		        )
		    );
			$manager->register_setting(
		        'ultra_page_footer',
		        array(
		            'sanitize_callback' => 'sanitize_key',
		            'default' 			=> 'default',
		        )
		    );
		    //Show Hide Inner paddings
			$manager->register_control(
		        'ultra_inner_page_paddings', // Same as setting name.
		        array(
		            'section' 		=> 'global_settings',
		            'type'    		=> 'select',
		            'label'   		=> esc_html__( 'Inner Page Padding', 'ultra-companion' ),
		            'description'   => esc_html__( 'Top & Bottom paddings for inner pages.', 'ultra-companion' ),
					'choices' 		=> array(
						'both' 	            => esc_html__( 'Both', 'ultra-companion' ),
						'only_top' 	        => esc_html__( 'Only Top', 'ultra-companion' ),
						'only_bottom' 		=> esc_html__( 'Only Bottom', 'ultra-companion' ),
						'none' 		=> esc_html__( 'None', 'ultra-companion' ),
					),
		        )
		    );
			$manager->register_setting(
		        'ultra_inner_page_paddings',
		        array(
		            'sanitize_callback' => 'sanitize_key',
		            'default' 			=> 'both',
		        )
		    );

		    //elementor lib lists
			$manager->register_control(
		        'ultra_page_custom_footer', 
		        array(
		            'section' 		=> 'global_settings',
		            'type'    		=> 'select',
		            'label'   		=> esc_html__( 'Footer Template', 'ultra-companion' ),
		            'description'   => esc_html__( 'Select your custom footer template from elementor library.', 'ultra-companion' ),
					'choices' 		=> $this->helpers( 'elementor_lib' ),
		        )
		    );
			$manager->register_setting(
		        'ultra_page_custom_footer',
		        array(
		            'sanitize_callback' => 'sanitize_key',
		        )
		    );
		    }

			/* Adding Sidebar Settings */
			$manager->register_section(
			        'sidebar_settings',
			        array(
			        	'label' => esc_html__( 'Sidebar Settings', 'ultra-companion' ),
					'icon'  => 'dashicons-admin-page'
				)
			);

			//Sidebar Layout
			$manager->register_control(
		        'ultra_sidebar_layout', // Same as setting name.
		        array(
		            'section' 		=> 'sidebar_settings',
		            'type'    		=> 'radio-image',
		            'label'   		=> esc_html__( 'Choose Sidebar Layout', 'ultra-companion' ),
					'choices' 		=> array(
						'default' 	=> array('label'=>'Default','url'=>UIMAGE_PATH.'sidebar-default.png'),
						'leftsidebar' 	=> array('label'=>'Left Sidebar','url'=>UIMAGE_PATH.'sidebar-left.png'),
						'rightsidebar' 		=> array('label'=>'Right Sidebar','url'=>UIMAGE_PATH.'sidebar-right.png'),
						'nosidebar' 		=> array('label'=>'No Sidebar','url'=>UIMAGE_PATH.'sidebar-no.png'),
					),
		        )
		    );
			$manager->register_setting(
		        'ultra_sidebar_layout',
		        array(
		            'sanitize_callback' => 'sanitize_key',
		            'default' 			=> 'default',
		        )
		    );

		    //Sidebar Area
			$manager->register_control(
		        'ultra_sidebar', 
		        array(
		            'section' 		=> 'sidebar_settings',
		            'type'    		=> 'select',
		            'label'   		=> esc_html__( 'Sidebar', 'ultra-companion' ),
		            'description'   => esc_html__( 'Select your custom sidebar.', 'ultra-companion' ),
					'choices' 		=> $this->helpers( 'widget_areas' ),
		        )
		    );
			$manager->register_setting(
		        'ultra_sidebar',
		        array(
		            'sanitize_callback' => 'sanitize_key',
		        )
		    );

		    if(get_template() != 'ultra-seven'){

			/* Adding Title Banner Settings */
			$manager->register_section(
			        'title_banner_settings',
			        array(
			        	'label' => esc_html__( 'Banner Settings', 'ultra-companion' ),
					'icon'  => 'dashicons-menu'
				)
			);

		    //Show Hide Title Banner
			$manager->register_control(
		        'ultra_page_title_banner', // Same as setting name.
		        array(
		            'section' 		=> 'title_banner_settings',
		            'type'    		=> 'buttonset',
		            'label'   		=> esc_html__( 'Title Banner', 'ultra-companion' ),
		            'description'   => esc_html__( 'Show/Hide Title Banner', 'ultra-companion' ),
					'choices' 		=> array(
						'on' 	=> esc_html__( 'Show', 'ultra-companion' ),
						'off' 		=> esc_html__( 'Hide', 'ultra-companion' ),
					),
		        )
		    );
			$manager->register_setting(
		        'ultra_page_title_banner',
		        array(
		            'sanitize_callback' => 'sanitize_key',
		            'default' 			=> 'on',
		        )
		    );

		    //custom title
			$manager->register_control(
		        'ultra_page_custom_title', // Same as setting name.
		        array(
		            'section' 		=> 'title_banner_settings',
		            'type'    		=> 'text',
		            'label'   		=> esc_html__( 'Custom Title', 'ultra-companion' ),
		            'description'   => esc_html__( 'Add your custom title to replace default page title', 'ultra-companion' ),
		        )
		    );

			$manager->register_setting(
		        'ultra_page_custom_title', // Same as control name.
		        array(
		            'sanitize_callback' => 'sanitize_text_field',
		        )
		    );

		    //Custom subtitle
			$manager->register_control(
		        'ultra_page_custom_subtitle', // Same as setting name.
		        array(
		            'section' 		=> 'title_banner_settings',
		            'type'    		=> 'textarea',
		            'label'   		=> esc_html__( 'Custom Sub Title', 'ultra-companion' ),
		            'description'   => esc_html__( 'Add your custom sub title below title', 'ultra-companion' ),
		        )
		    );
			$manager->register_setting(
		        'ultra_page_custom_subtitle', // Same as control name.
		        array(
		            'sanitize_callback' => 'wp_kses_post',
		        )
		    );
            
            //Show/Hide Breadcrumb
			$manager->register_control(
		        'ultra_page_breadcrumb_show', // Same as setting name.
		        array(
		            'section' 		=> 'title_banner_settings',
		            'type'    		=> 'buttonset',
		            'label'   		=> esc_html__( 'Show/Hide Breadcrumb', 'ultra-companion' ),
					'choices' 		=> array(
						'on' 	=> esc_html__( 'Show', 'ultra-companion' ),
						'off' 		=> esc_html__( 'Hide', 'ultra-companion' ),
					),
		        )
		    );
			$manager->register_setting(
		        'ultra_page_breadcrumb_show',
		        array(
		            'sanitize_callback' => 'sanitize_key',
		            'default' 			=> '',
		        )
		    );

		    //Banner Title Position
			$manager->register_control(
		        'ultra_page_title_position', // Same as setting name.
		        array(
		            'section' 		=> 'title_banner_settings',
		            'type'    		=> 'select',
		            'label'   		=> esc_html__( 'Title Position', 'ultra-companion' ),
		            'description'   => esc_html__( 'Set your Banner Title Position', 'ultra-companion' ),
					'choices' 		=> array(
						'' 	            => esc_html__( 'Default', 'ultra-companion' ),
						'left' 	        => esc_html__( 'Left', 'ultra-companion' ),
						'right' 		=> esc_html__( 'Right', 'ultra-companion' ),
						'center' 		=> esc_html__( 'Center', 'ultra-companion' ),
						'wide' 		=> esc_html__( 'Wide', 'ultra-companion' ),
					),
		        )
		    );
			$manager->register_setting(
		        'ultra_page_title_position',
		        array(
		            'sanitize_callback' => 'sanitize_key',
		            'default' 			=> 'left',
		        )
		    );

		    //Custom subtitle
			$manager->register_control(
		        'ultra_page_banner_height', // Same as setting name.
		        array(
		            'section' 		=> 'title_banner_settings',
		            'type'    		=> 'number',
		            'label'   		=> esc_html__( 'Banner Height', 'ultra-companion' ),
		            'description'   => esc_html__( 'Banner height in px.', 'ultra-companion' ),
		        )
		    );
			$manager->register_setting(
		        'ultra_page_banner_height', // Same as control name.
		        array(
		            'sanitize_callback' => 'wp_kses_post',
		        )
		    );
            
            //Bg color
			$manager->register_control(
		        'ultra_page_banner_bg_color', // Same as setting name.
		        array(
		            'section' 		=> 'title_banner_settings',
		            'type'    		=> 'rgba-color',
		            'label'   		=> esc_html__( 'Background Color', 'ultra-companion' ),
		            'description'   => esc_html__( 'Select a color. Hex code, ex: #555', 'ultra-companion' ),
		        )
		    );
			$manager->register_setting(
		        'ultra_page_banner_bg_color', // Same as control name.
		        array(
		            'sanitize_callback' => 'butterbean_maybe_hash_hex_color',
		        )
		    );

		    //Bg Image
			$manager->register_control(
		        'ultra_page_banner_bg_image', // Same as setting name.
		        array(
		            'section' 		=> 'title_banner_settings',
		            'type'    		=> 'image',
		            'label'   		=> esc_html__( 'Background Image', 'ultra-companion' ),
		            'description'   => esc_html__( 'Select a custom image for your main title.', 'ultra-companion' ),
		        )
		    );
			$manager->register_setting(
		        'ultra_page_banner_bg_image', // Same as control name.
		        array(
		        	'sanitize_callback' => 'sanitize_key',
		        )
		    );
		    }

			/* Adding Custom CSS  */
			$manager->register_section(
			        'custom_css_js',
			        array(
			        	'label' => esc_html__( 'Custom CSS', 'ultra-companion' ),
					'icon'  => 'dashicons-welcome-write-blog'
				)
			);

			$manager->register_control(
		        'ultra_page_custom_css', // Same as setting name.
		        array(
		            'section' 		=> 'custom_css_js',
		            'type'    		=> 'textarea',
		            'label'   		=> esc_html__( 'Custom Css', 'ultra-companion' ),
		            'description'   => esc_html__( 'Add your custom css for this page only. Note:add without <style> tag', 'ultra-companion' ),
		        )
		    );
			$manager->register_setting(
		        'ultra_page_custom_css', // Same as control name.
		        array(
		            'sanitize_callback' => '',
		        )
		    );

		}  

		/**
		 * Helpers
		 *
		 * @since 1.0.6
		 */
		public static function helpers( $return = NULL ) {

			// Return array of WP menus
			if ( 'menus' == $return ) {
				$menus 		= array( esc_html__( 'Default', 'ultra-companion' ) );
				$get_menus 	= get_terms( 'nav_menu', array( 'hide_empty' => true ) );
				foreach ( $get_menus as $menu) {
					$menus[$menu->term_id] = $menu->name;
				}
				return $menus;
			}

			// Widgets
			elseif ( 'widget_areas' == $return ) {
				global $wp_registered_sidebars;
				$widgets_areas = array( esc_html__( 'Default', 'ultra-companion' ) );
				$get_widget_areas = $wp_registered_sidebars;
				if ( ! empty( $get_widget_areas ) ) {
					foreach ( $get_widget_areas as $widget_area ) {
						$name = isset ( $widget_area['name'] ) ? $widget_area['name'] : '';
						$id = isset ( $widget_area['id'] ) ? $widget_area['id'] : '';
						if ( $name && $id ) {
							$widgets_areas[$id] = $name;
						}
					}
				}
				return $widgets_areas;
			}
            
            //elementor library
			elseif( 'elementor_lib' == $return ){
				$args = [
				  'post_type'         => 'elementor_library',
				  'posts_per_page'    => -1,
				];
				  
				$page_templates = get_posts( $args );

				$options = array();

				if ( ! empty( $page_templates ) && ! is_wp_error( $page_templates ) ){

					foreach ( $page_templates as $post ) {
						$options[ $post->ID ] = $post->post_title;
					}
				}
				return $options;
			}

		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.6
		 * @access public
		 * @return object
		 */
		public static function get_instance() {
			static $instance = null;
			if ( is_null( $instance ) ) {
				$instance = new self;
				$instance->setup_actions();
			}
			return $instance;
		}

		/**
		 * Constructor method.
		 *
		 * @since  1.0.6
		 * @access private
		 * @return void
		 */
		private function __construct() {}
    }
    Ultra_Metabox_Options::get_instance();
}
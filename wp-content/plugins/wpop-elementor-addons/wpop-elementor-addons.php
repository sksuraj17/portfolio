<?php
defined( 'ABSPATH' ) or die( "No script kiddies please!" );
/*
 * Plugin Name:       WPOP Elementor Addons
 * Plugin URI:        https://wpoperation.com/plugins
 * Description:       This is Elementor addons for WPoperation Themes.
 * Version:           1.1.7
 * Author:            WPoperation
 * Author URI:        https://wpoperation.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpopea
 * Domain Path:       /languages
 */


/** Necessary Constants **/
defined( 'WPOPEA_VERSION' ) or define( 'WPOPEA_VERSION', '1.1.7' ); //plugin version
defined( 'WPOPEA_TD' ) or define( 'WPOPEA_TD', 'wpopea' ); //plugin's text domain
defined( 'WPOPEA_PATH' ) or define( 'WPOPEA_PATH', plugin_dir_path( __FILE__ ) );
defined( 'WPOPEA_ASSETS' ) or define( 'WPOPEA_ASSETS', plugin_dir_url(__FILE__).'assets/' );


if(!class_exists('Wpop_El_Addons')) :

	class Wpop_El_Addons {

		public function __construct() {

	        /** Loads plugin text domain for internationalization **/
			add_action('init', array($this, 'load_text_domain'));
			if(!defined('ELEMENTOR_VERSION')){
				add_action('admin_notices',  array($this, 'wpop_admin_notices'));
			}else{	
	            add_action( 'wp_enqueue_scripts',array($this,'wpopea_script_register') );
				add_action( 'elementor/widgets/widgets_registered',array($this,'wpopea_elements_register') );
	            add_action('admin_init',array($this,'wpopea_check_opstore_pro') );
	            $this->includes();
        	}
		}
		
		/**
	     * Loads Plugin Text Domain
	     * 
	     */
	    function load_text_domain() {
	        load_plugin_textdomain('wpopea', false, basename(dirname(__FILE__)) . '/languages');
	    }

	    /* Include Theme Files */
	    function includes(){
			require WPOPEA_PATH.'/includes/functions.php';
			require WPOPEA_PATH.'/includes/helpers.php';
			require WPOPEA_PATH.'/includes/class-icon-manager.php';
	    }

	
		function wpopea_elements_register(){
            require_once WPOPEA_PATH.'elements/common/site-logo.php';
            require_once WPOPEA_PATH.'elements/common/advanced-menu.php';
            require_once WPOPEA_PATH.'elements/common/header-icons.php';
            require_once WPOPEA_PATH.'elements/common/normal-search.php';
            require_once WPOPEA_PATH.'elements/common/news-ticker.php';
			require_once WPOPEA_PATH.'elements/common/blog.php';
			require_once WPOPEA_PATH.'elements/common/tiled-posts.php';
			require_once WPOPEA_PATH.'elements/common/single-post.php';
			if(class_exists('woocommerce')){
				require_once WPOPEA_PATH.'elements/common/category-dropdown.php';
				require_once WPOPEA_PATH.'elements/common/products.php';
			    require_once WPOPEA_PATH.'elements/common/product-sale.php';
		    }
			if( defined('OPSTORE_THEME') ){
				if(class_exists('woocommerce')){
					require_once WPOPEA_PATH.'elements/opstore/product-info.php';
					require_once WPOPEA_PATH.'elements/opstore/advanced-search.php';
				}
		    }elseif(defined('ULTRALITE_THEME') || defined('ULTRANEWS_THEME')){
			    require_once WPOPEA_PATH.'elements/ultra-lite/block-header.php';
			    require_once WPOPEA_PATH.'elements/ultra-lite/slider-block.php';
			    require_once WPOPEA_PATH.'elements/ultra-lite/cat-block.php';
			    require_once WPOPEA_PATH.'elements/ultra-lite/grid-block.php';
			    require_once WPOPEA_PATH.'elements/ultra-lite/list-block.php';
			    require_once WPOPEA_PATH.'elements/ultra-lite/post-list.php';
			    require_once WPOPEA_PATH.'elements/ultra-lite/tab-block.php';
			    require_once WPOPEA_PATH.'elements/ultra-lite/youtube-block.php';
			    if(class_exists('woocommerce')){
			    	require_once WPOPEA_PATH.'elements/ultra-lite/woo-block.php';
			    }
		    }else{
		    	//nothing
		    }

		}

			

		function wpopea_script_register(){
			wp_register_script( 'wpopea-el-slick-js', WPOPEA_ASSETS . 'slick/slick.min.js', array('jquery'), WPOPEA_VERSION, true );
			wp_register_script( 'wpopea-el-isotope-js', WPOPEA_ASSETS . 'isotope/isotope.pkgd.js', array('jquery'), WPOPEA_VERSION, true );
			wp_register_script( 'wpopea-el-countdown-js', WPOPEA_ASSETS . 'countdown/jquery.countdown.min.js', array('jquery'), WPOPEA_VERSION, true );
			wp_register_script( 'wpopea-el-menu-js', WPOPEA_ASSETS . 'advanced-menu.js', array('jquery'), WPOPEA_VERSION, true );
			wp_register_script( 'wpopea-el-smartmenu-js', WPOPEA_ASSETS . 'jquery-smartmenu.js', array('jquery'), WPOPEA_VERSION, true );

		    wp_register_script( 'wpopea-el-js', WPOPEA_ASSETS . 'wpopea-elements.js', array('jquery','imagesloaded'), WPOPEA_VERSION, true );
		    wp_enqueue_script( 'wpopea-el-js' );

		    wp_register_style('wpopea-slick-style',WPOPEA_ASSETS.'slick/slick.css',array(),WPOPEA_VERSION);
		    wp_register_style('wpopea-slick-theme-style',WPOPEA_ASSETS.'slick/slick-theme.css',array(),WPOPEA_VERSION);
		    wp_register_style('ticker',WPOPEA_ASSETS.'ticker.css',array(),WPOPEA_VERSION);
		    wp_register_style('search',WPOPEA_ASSETS.'search.css',array(),WPOPEA_VERSION);
		    wp_register_style('cat-drop',WPOPEA_ASSETS.'cat-drop.css',array(),WPOPEA_VERSION);
		    wp_register_style('tiled-post',WPOPEA_ASSETS.'tiled-post.css',array(),WPOPEA_VERSION);
		    wp_register_style('advanced-menu',WPOPEA_ASSETS.'advanced-menu.css',array(),WPOPEA_VERSION);
		    wp_register_style('single-post',WPOPEA_ASSETS.'single-post.css',array(),WPOPEA_VERSION);

		    wp_register_style( 'wpopea-el-css', WPOPEA_ASSETS . 'wpopea-element.css' );
		    wp_enqueue_style( 'wpopea-el-css' );
		}

        public function wpop_admin_notices() {
            $class = 'notice notice-error';
            $message = __('WPOP Elementor Addon requires Elementor Plugin to be installed and active.', 'wpopea');
            printf('<div class="%1$s"><p>%2$s</p></div>', $class, $message);
        }

		function wpopea_check_opstore_pro(){

			$current_theme = wp_get_theme();
			$theme_name = $current_theme -> get( 'Name' );
			if( $theme_name != 'Opstore Pro'){
				return;
			}else{
				deactivate_plugins( plugin_basename( __FILE__ ) );
			}

		}
    }

    $bscd_object = new Wpop_El_Addons();
endif;
<?php
defined( 'ABSPATH' ) or die( "No script kiddies please!" );
/*
Plugin Name: Ultra Companion
Description: This is a companion plugin for WPoperation themes
Author: WPoperation
Author URI:  https://wpoperation.com/
Version: 1.1.8
License: GPL2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
Domain Path: /languages/
Text Domain: ultra-companion
*/

/** Necessary Constants **/
defined( 'ULC_VERSION' ) or define( 'ULC_VERSION', '1.1.8' ); //plugin version
defined( 'ULC_TD' ) or define( 'ULC_TD', 'ultra-companion' ); //plugin's text domain
defined( 'ULC_PATH' ) or define( 'ULC_PATH', plugin_dir_path( __FILE__ ) );
defined( 'ULC_URL' ) or define( 'ULC_URL', plugin_dir_url( __FILE__ ) );
defined( 'UIMAGE_PATH' ) or define( 'UIMAGE_PATH', plugin_dir_url( __FILE__ ).'assets/images/' );
require_once ULC_PATH.'inc/dynamic-sidebar/sidebar.php';
if(!class_exists('Ultra_Companion')) :

	class Ultra_Companion {

		public function __construct() {

	        /** Loads plugin text domain for internationalization **/
			add_action('init', array($this, 'load_text_domain'));

			/** Add Shortcode File **/
			add_action('init', array($this, 'add_shortcode_file'));

			/** Add theme functions **/
            add_action('init', array($this, 'add_theme_functions'));

            add_action('admin_notices', array($this, 'wpop_admin_notice') );
	        add_action('wp_ajax_wpop_nag_ignore', array($this, 'wpop_nag_ignore') );

			/** Enqueue Styles & Scripts **/
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles_and_scripts' ) );

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );



		}

		/** Enqueue Necessary Plugin Scripts and Styles **/
		public function enqueue_styles_and_scripts() {

			wp_enqueue_style('ultra-shortcodes-front', plugin_dir_url( __FILE__ ) . 'assets/css/shortcodes.css');
			wp_register_style('slick', plugin_dir_url( __FILE__ ) . 'assets/slick/slick.css' );
            wp_register_style('slick-theme', plugin_dir_url( __FILE__ ) . 'assets/slick/slick-theme.css' );

			wp_register_script('slick', plugin_dir_url( __FILE__ ) . 'assets/slick/slick.js' , array('jquery'),ULC_VERSION);
			wp_enqueue_script('ultra-shortcodes-front', ULC_URL . 'shortcodes/shortcodes-front.js' , array('jquery'),ULC_VERSION);
		}

		public function enqueue_admin_styles(){

			wp_enqueue_script('media-script', plugin_dir_url( __FILE__ ) . 'assets/js/media-uploader.js' );
			wp_enqueue_script('admin-script', plugin_dir_url( __FILE__ ) . 'assets/js/admin.js' );
			wp_enqueue_style('admin-style', plugin_dir_url( __FILE__ ) . 'assets/css/admin.css' );

		}

		/** Shortcode File **/
		public function add_shortcode_file() {
			require_once ULC_PATH.'shortcodes/shortcodes.php';
		}

		/** Theme Functions **/
		public function add_theme_functions() {
			require_once ULC_PATH.'inc/theme-functions.php';
            if(!defined('WPOP_PRO')){
				require_once ULC_PATH.'inc/meta/ultra-post-meta.php';
	            require_once ULC_PATH.'inc/metabox/butterbean/butterbean.php';
	            require_once ULC_PATH.'inc/metabox/metabox.php';
	            	
		    }
		}		

		/**
	     * Loads Plugin Text Domain
	     * 
	     */
	    function load_text_domain() {
	        load_plugin_textdomain('ultra-companion', false, basename(dirname(__FILE__)) . '/languages');
	    }
		// admin notice
		function wpop_admin_notice() {
		if ( current_user_can( 'install_plugins' ) ){
		    global $current_user,$pagenow;
		    $user_id = $current_user->ID;
		    /* Check that the user hasn't already clicked to ignore the message */
		    if ( get_user_meta($user_id, 'wpop_ignore_notice222',true)!='yes' &&(!defined('WPOP_PRO') && !defined('ARRIVAL_COMP_VER')) ) {
		    	global $wp;
            ?>
            <div class="notice wpop_admin_notice wpop_admin_notice_1" >
            	<img class="wpop_notice_img" src="<?php echo UIMAGE_PATH . 'sale.png'?>">
            	<div class="wpop_notice_right_content">
                    <div class="wpop_notice_content">
                    	<a class="wpop_no_thanks" href="javascript:void(0);" data-user="<?php echo $user_id;?>">not interested</a>
                    </div>
                    <div class="wpop_notice_after_content"></div>
                </div>
                <div class="wpop_notice_content_wrap">
                    <div class="wpop_notice_content">
                    	<?php if(get_template() == 'ultra-seven'|| get_template() == 'ultra-lite' || get_template() == 'ultra-news'){?>
		 					Upgrade to <strong>Ultra Eleven - Premium WordPress Magazine Theme </strong> and Unlock More Powerful Features 
		     				<a class="wpop_button" href="https://wpoperation.com/themes/ultra-eleven/" target="_blank">Details</a>
	     			    <?php } elseif(get_template() == 'opstore' || get_template() == 'opstore-lite'){?>
		 					Upgrade to <strong>Opstore Pro - Premium WordPress eCommerce Theme </strong> and Unlock More Powerful Features 
		     				<a class="wpop_button" href="https://wpoperation.com/themes/opstore-pro/" target="_blank">Details</a>
		     			<?php } elseif(get_template() == 'arrival' || get_template() == 'arrival-me' || get_template() == 'arrival-store'){?>	
							Upgrade to <strong>Arrival Pro - Premium Addons for Arrival </strong> and Unlock More Powerful Features 
		     				<a class="wpop_button" href="https://wpoperation.com/themes/arrival-pro/" target="_blank">Details</a>
		     			<?php }elseif(get_template() == 'wpparallax'){?>	
							Upgrade to <strong>WPparallax Pro - Premium Addons for WPparallax </strong> and Unlock More Powerful Features 
		     				<a class="wpop_button" href="https://wpoperation.com/themes/wpparallax-pro/" target="_blank">Details</a>
		     			<?php }else{ ?>	
		 					Check Themes By <strong>WPoperation</strong> and Unlock More Powerful Features 
		     				<a class="wpop_button" href="https://wpoperation.com/best-wordpress-themes/" target="_blank">Details</a>
		     			<?php }?>	
     				</div>
                    <div class="wpop_notice_after_content"></div>
                </div>
            </div>

            <?php
		    }
		    }
		}

		function wpop_nag_ignore() {
	        $user_id = $_POST['userid'];
	        /* If user clicks to ignore the notice, add that to their user meta */
            update_user_meta($user_id, 'wpop_ignore_notice222', 'yes');
            echo 'yes';
            die();
		}

    }

    $bscd_object = new Ultra_Companion();
endif;
<?php

if(!class_exists('TSSShortCodeGenerator')):

	class TSSShortCodeGenerator{

		public $shortcode_tag = 'rt_tss';

		function __construct() {
			if ( is_admin() ){
				add_action('admin_head', array( $this, 'admin_head') );

				if ( 
					( isset( $_GET['post'] ) && get_post_type( $_GET['post'] ) == 'tss-sc' ) ||
					( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'tss-sc' ) ||
					( isset( $_GET['post'] ) && get_post_type( $_GET['post'] ) == 'testimonial' ) ||
					( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'testimonial' )
				) {
					add_action('admin_footer', array($this, 'pro_alert_html'));
				}
			}
		}

		function pro_alert_html() { 
            if ( function_exists('rttsp') ) return;
            $html = '';
            $html .= '<div class="rtts-document-box rtts-alert rtts-pro-alert">
                    <div class="rtts-box-icon"><i class="dashicons dashicons-lock"></i></div>
                    <div class="rtts-box-content">
                        <h3 class="rtts-box-title">' . esc_html__( 'Pro field alert!', 'review-schema' ) . '</h3>
                        <p><span></span>' . esc_html__( 'Sorry! this is a pro field. To use this field, you need to use pro plugin.', 'review-schema' ) . '</p>
                        <a href="https://www.radiustheme.com/downloads/wp-testimonial-slider-showcase-pro-wordpress/" target="_blank" class="rt-admin-btn">' . esc_html__("Upgrade to pro", "review-schema") . '</a>
                        <a href="#" target="_blank" class="rtts-alert-close rtts-pro-alert-close">x</a>
                    </div>
                </div>';  
            echo $html;
        }

		/**
		 * admin_head
		 * calls your functions into the correct filters
		 * @return void
		 */
		function admin_head() {
			// check user permissions
			if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
				return;
			}
			// check if WYSIWYG is enabled
			if ( 'true' == get_user_option( 'rich_editing' ) ) {
				add_filter( 'mce_external_plugins', array( $this ,'mce_external_plugins' ) );
				add_filter( 'mce_buttons', array($this, 'mce_buttons' ) );
				echo "<style>";
				echo "i.mce-i-rt_tss{";
				echo "background: url('".TSSPro()->assetsUrl ."images/icon-20x20.png');";
				echo "}";
				echo "i.tss-vc-icon{";
				echo "background: url('".TSSPro()->assetsUrl ."images/icon-32x32.png');";
				echo "}";
				echo "</style>";
			}
		}
		/**
		 * mce_external_plugins
		 * Adds our tinymce plugin
		 * @param  array $plugin_array
		 * @return array
		 */
		function mce_external_plugins( $plugin_array ) {
			$plugin_array[$this->shortcode_tag] = TSSPro()->assetsUrl .'js/mce-button.js';
			return $plugin_array;
		}

		/**
		 * mce_buttons
		 * Adds our tinymce button
		 * @param  array $buttons
		 * @return array
		 */
		function mce_buttons( $buttons ) {
			array_push( $buttons, $this->shortcode_tag );
			return $buttons;
		}

	}

endif;
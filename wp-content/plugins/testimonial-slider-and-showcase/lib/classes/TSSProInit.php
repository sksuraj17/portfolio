<?php
if ( ! class_exists( 'TSSProInit' ) ) :


	class TSSProInit {

		function __construct() {
			add_action( 'init', array( __CLASS__, 'init' ), 1 );
			add_action( 'admin_menu', array( $this, 'tss_menu_register' ), 99 );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
			register_activation_hook( TSS_PLUGIN_ACTIVE_FILE_NAME, array( $this, 'activate' ) );
			register_deactivation_hook( TSS_PLUGIN_ACTIVE_FILE_NAME, array( $this, 'deactivate' ) );
			add_action( 'plugins_loaded', array( $this, 'plugin_loaded' ) );
			add_action( 'wp_ajax_tssSettingsAction', array( $this, 'tssSettingsUpdate' ) );
			add_filter( 'plugin_action_links_' . plugin_basename( TSS_PLUGIN_ACTIVE_FILE_NAME ), array( $this, 'rt_plugin_active_link_marketing' ) );
			add_action( 'admin_init', array( $this, 'my_plugin_redirect' ) );
		}

		public function activate() {
			$this->flush_rewrite();
			$this->fixLayout();
			add_option( 'rtts_activation_redirect', true );
		}

		// function my_plugin_redirect() {
		// 	if ( get_option( 'rtts_activation_redirect', false ) ) {
		// 		delete_option( 'rtts_activation_redirect' );
		// 		wp_redirect( admin_url( 'edit.php?post_type=testimonial&page=tss_settings&tab=support' ) );
		// 	}
		// }

		function my_plugin_redirect() {
			if ( get_option( 'rtts_activation_redirect', false ) ) {
				delete_option( 'rtts_activation_redirect' );
				wp_redirect( admin_url( 'edit.php?post_type=testimonial&page=tss_get_help' ) );
			}
		}

		public function flush_rewrite() {
			flush_rewrite_rules();
		}

		public function deactivate() {
			$this->flush_rewrite();
		}

		function fixLayout() {
			$installed_version = get_option( TSSPro()->options['installed_version'] );

			if ( $installed_version && version_compare( $installed_version, '2.0.0', '<' ) ) {
				if ( ! function_exists( 'rttsp' ) ) {
					$this->scLayoutFixer();
				}
			} else {
				// pro version with free install
				if ( ! $installed_version ) {
					if ( ! function_exists( 'rttsp' ) ) {
						$this->scLayoutFixer();
					}
				}
			}
		}

		private function scLayoutFixer() {
			$allSC = get_posts(
				array(
					'post_type'      => TSSPro()->shortCodePT,
					'posts_per_page' => -1,
				)
			);

			if ( is_array( $allSC ) && ! empty( $allSC ) ) {
				foreach ( $allSC as $sc ) {

					// layout fixing
					$layout = get_post_meta( $sc->ID, 'tss_layout', true );

					if ( $layout == 'carousel1' ) {
						update_post_meta( $sc->ID, 'tss_layout', 'carousel3' );
					}

					if ( $layout == 'layout1' || $layout == 'carousel1' ) {
						$tss_author_name_style = array( 'color' => '#3a3a3a' );
						update_post_meta( $sc->ID, 'tss_author_name_style', $tss_author_name_style );

						$tss_author_bio_style = array( 'color' => '#8cc63e' );
						update_post_meta( $sc->ID, 'tss_author_bio_style', $tss_author_bio_style );
					}
				}
			}
		}

		public static function init() {
			$testimonial_args = array(
				'label'               => esc_html__( 'Testimonial', 'testimonial-slider-showcase' ),
				'labels'              => array(
					'name'               => esc_html__( 'Testimonials', 'testimonial-slider-showcase' ),
					'all_items'          => esc_html__( 'All Testimonials', 'testimonial-slider-showcase' ),
					'singular_name'      => esc_html__( 'Testimonial', 'testimonial-slider-showcase' ),
					'menu_name'          => esc_html__( 'Testimonial', 'testimonial-slider-showcase' ),
					'name_admin_bar'     => esc_html__( 'Testimonial', 'testimonial-slider-showcase' ),
					'add_new'            => esc_html__( 'Add Testimonial', 'testimonial-slider-showcase' ),
					'add_new_item'       => esc_html__( 'Add Testimonial', 'testimonial-slider-showcase' ),
					'edit_item'          => esc_html__( 'Edit Testimonial', 'testimonial-slider-showcase' ),
					'new_item'           => esc_html__( 'New Testimonial', 'testimonial-slider-showcase' ),
					'view_item'          => esc_html__( 'View Testimonial', 'testimonial-slider-showcase' ),
					'search_items'       => esc_html__( 'Search Testimonial', 'testimonial-slider-showcase' ),
					'not_found'          => esc_html__( 'No Testimonials found', 'testimonial-slider-showcase' ),
					'not_found_in_trash' => esc_html__( 'No Testimonials in the trash', 'testimonial-slider-showcase' ),
				),
				'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ),
				'hierarchical'        => false,
				'public'              => true,
				'rewrite'             => array( 'slug' => TSSPro()->post_type_slug ),
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_icon'           => TSSPro()->assetsUrl . 'images/icon-16x16.png',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => false,
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'page',
			);
			register_post_type( TSSPro()->post_type, $testimonial_args );

			$sc_args = array(
				'label'               => esc_html__( 'ShortCode', 'testimonial-slider-showcase' ),
				'description'         => esc_html__( 'Testimonial ShortCode generator', 'testimonial-slider-showcase' ),
				'labels'              => array(
					'all_items'          => esc_html__( 'ShortCode', 'testimonial-slider-showcase' ),
					'menu_name'          => esc_html__( 'ShortCode', 'testimonial-slider-showcase' ),
					'singular_name'      => esc_html__( 'ShortCode', 'testimonial-slider-showcase' ),
					'edit_item'          => esc_html__( 'Edit ShortCode', 'testimonial-slider-showcase' ),
					'new_item'           => esc_html__( 'New ShortCode', 'testimonial-slider-showcase' ),
					'view_item'          => esc_html__( 'View ShortCode', 'testimonial-slider-showcase' ),
					'search_items'       => esc_html__( 'ShortCode Locations', 'testimonial-slider-showcase' ),
					'not_found'          => esc_html__( 'No ShortCode found.', 'testimonial-slider-showcase' ),
					'not_found_in_trash' => esc_html__( 'No ShortCode found in trash.', 'testimonial-slider-showcase' ),
				),
				'supports'            => array( 'title' ),
				'public'              => false,
				'rewrite'             => false,
				'show_ui'             => true,
				'show_in_menu'        => 'edit.php?post_type=' . TSSPro()->post_type,
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => false,
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => false,
				'publicly_queryable'  => false,
				'capability_type'     => 'page',
			);
			register_post_type( TSSPro()->shortCodePT, $sc_args );

			TSSPro()->doFlush();

			// register scripts
			$scripts                     = array();
			$styles                      = array();

			$scripts['swiper']             = array(
				'src'    => TSSPro()->assetsUrl . 'vendor/swiper/swiper.min.js',
				'deps'   => array( 'jquery' ),
				'footer' => false,
			);
			$scripts['tss-image-load']     = array(
				'src'    => TSSPro()->assetsUrl . 'vendor/isotope/imagesloaded.pkgd.min.js',
				'deps'   => array( 'jquery' ),
				'footer' => false,
			);
			$scripts['tss-isotope']        = array(
				'src'    => TSSPro()->assetsUrl . 'vendor/isotope/isotope.pkgd.min.js',
				'deps'   => array( 'jquery' ),
				'footer' => false,
			);
			$scripts['tss-actual-height']  = array(
				'src'    => TSSPro()->assetsUrl . 'vendor/actual-height/jquery.actual.min.js',
				'deps'   => array( 'jquery' ),
				'footer' => false,
			);
			$scripts['tss-admin-taxonomy'] = array(
				'src'    => TSSPro()->assetsUrl . 'js/admin-taxonomy.js',
				'deps'   => array( 'jquery' ),
				'footer' => true,
			);

			if ( function_exists( 'rttsp' ) ) {
				$scripts['rt-tss-sortable'] = array(
					'src'    => TSSPro()->assetsUrl . 'js/rt-sortable.js',
					'deps'   => array( 'jquery' ),
					'footer' => true,
				);
			}

			$scripts['tss-recaptcha'] = array(
				'src'    => 'https://www.google.com/recaptcha/api.js',
				'deps'   => '',
				'footer' => true,
			);
			$scripts['tss-validator'] = array(
				'src'    => TSSPro()->assetsUrl . 'js/jquery.validate.min.js',
				'deps'   => array( 'jquery' ),
				'footer' => true,
			);
			$scripts['tss-submit']    = array(
				'src'    => TSSPro()->assetsUrl . 'js/tss-submit.js',
				'deps'   => array( 'jquery' ),
				'footer' => true,
			);
			$scripts['tss']           = array(
				'src'    => TSSPro()->assetsUrl . 'js/wptestimonial.js',
				'deps'   => array( 'jquery' ),
				'footer' => true,
			);

			// register acf styles
			$styles['tss-fontawsome']         = TSSPro()->assetsUrl . 'vendor/font-awesome/css/font-awesome.min.css';
			$styles['swiper'] = TSSPro()->assetsUrl . 'vendor/swiper/swiper.min.css';
			$styles['tss']    = TSSPro()->assetsUrl . 'css/wptestimonial.css';

			if ( is_admin() ) {

				/*
				 $scripts['ace_code_highlighter_js'] = array(
					'src'    => TSSPro()->assetsUrl . "vendor/ace/ace.js",
					'deps'   => null,
					'footer' => true
				);
				$scripts['ace_mode_js'] = array(
					'src'    => TSSPro()->assetsUrl . "vendor/ace/mode-css.js",
					'deps'   => array('ace-code-highlighter-js'),
					'footer' => true
				); */
				$scripts['tss-select2']       = array(
					'src'    => TSSPro()->assetsUrl . 'vendor/select2/select2.min.js',
					'deps'   => array( 'jquery' ),
					'footer' => false,
				);
				$scripts['tss-admin-preview'] = array(
					'src'    => TSSPro()->assetsUrl . 'js/admin-preview.js',
					'deps'   => array( 'jquery' ),
					'footer' => false,
				);
				$scripts['tss-admin']         = array(
					'src'    => TSSPro()->assetsUrl . 'js/settings.js',
					'deps'   => array( 'jquery' ),
					'footer' => true,
				);
				$scripts['tss-admin-sc']      = array(
					'src'    => TSSPro()->assetsUrl . 'js/admin-sc.js',
					'deps'   => array( 'jquery' ),
					'footer' => true,
				);
				$styles['tss-select2']        = TSSPro()->assetsUrl . 'vendor/select2/select2.min.css';
				$styles['tss-admin']          = TSSPro()->assetsUrl . 'css/settings.css';
			}
			$version = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? time() : TSS_VERSION;
			foreach ( $scripts as $handel => $script ) {
				wp_register_script( $handel, $script['src'], $script['deps'], $version, $script['footer'] );
			}

			foreach ( $styles as $k => $v ) {
				wp_register_style( $k, $v, false, $version );
			}

		}


		function tssSettingsUpdate() {
			$error = true;
			$msg   = false;
			if ( TSSPro()->verifyNonce() ) {
				unset( $_REQUEST['action'] );
				unset( $_REQUEST['_wp_http_referer'] );
				unset( $_REQUEST['tss_nonce'] );
				$mates = TSSPro()->tssAllSettingsFields();
				foreach ( $mates as $key => $field ) {
					$rValue       = ! empty( $_REQUEST[ $key ] ) ? $_REQUEST[ $key ] : null;  // sanitize data in the next line
					$value        = TSSPro()->sanitize( $field, $rValue );
					$data[ $key ] = $value;
				}
				$settings = get_option( TSSPro()->options['settings'] );
				if ( ! empty( $settings['slug'] ) && $_REQUEST['slug'] && $settings['slug'] !== $_REQUEST['slug'] ) {
					update_option( TSSPro()->options['flash'], true );
				}
				update_option( TSSPro()->options['settings'], $data );
				$error = false;
				$msg   = esc_html__( 'Settings successfully updated', 'testimonial-slider-showcase' );
			} else {
				$msg = esc_html__( 'Security Error !!', 'testimonial-slider-showcase' );
			}
			$response = array(
				'error' => $error,
				'msg'   => $msg,
			);
			wp_send_json( $response );
			die();
		}


		function tss_menu_register() {
			add_submenu_page(
				'edit.php?post_type=' . TSSPro()->post_type,
				esc_html__( 'Testimonial Settings', 'testimonial-slider-showcase' ),
				esc_html__( 'Settings', 'testimonial-slider-showcase' ),
				'administrator',
				'tss_settings',
				array( $this, 'settings_page_view' )
			);

			add_submenu_page(
				'edit.php?post_type=' . TSSPro()->post_type,
				esc_html__( 'Get Help', 'testimonial-slider-showcase' ),
				esc_html__( 'Get Help', 'testimonial-slider-showcase' ),
				'administrator',
				'tss_get_help',
				array( $this, 'get_help' )
			);
		}

		function admin_enqueue_scripts() {
			global $pagenow, $typenow;
			// validate page
			if ( ! in_array( $pagenow, array( 'post.php', 'post-new.php', 'edit.php' ) ) ) {
				// return;
			}
			if ( $typenow != TSSPro()->post_type ) {
				return;
			}
			// scripts
			wp_enqueue_script(
				array(
					'jquery',
					'jquery-ui-core',
					'jquery-ui-sortable',
					'ace_code_highlighter_js',
					'ace_mode_js',
					'tss-select2',
					'tss-admin',
				)
			);

			// styles
			wp_enqueue_style(
				array(
					'tss-select2',
					'tss-admin',
				)
			);

			wp_localize_script(
				'tss-admin',
				'tss',
				array(
					'nonce'   => wp_create_nonce( TSSPro()->nonceText() ),
					'nonceId' => TSSPro()->nonceId(),
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
				)
			);
		}


		function settings_page_view() {
			TSSPro()->render_view( 'settings' );
		}

		function get_help() {
			TSSPro()->render_view( 'help' );
		}

		/**
		 * Load the plugin text domain for translation.
		 *
		 * @since 0.1.0
		 */
		public function plugin_loaded() {
			load_plugin_textdomain( 'testimonial-slider-showcase', false, TSS_LANGUAGE_PATH );
			if ( ! get_option( TSSPro()->options['settings'] ) ) {
				update_option( TSSPro()->options['settings'], TSSPro()->preSettings );
			}
		}

		public function rt_plugin_active_link_marketing( $links ) {
			$links[] = '<a target="_blank" href="' . esc_url( TSSPro()->demo_home_page_link() ) . '">Demo</a>';
			$links[] = '<a target="_blank" href="' . esc_url( TSSPro()->documentation_link() ) . '">Documentation</a>';
			if ( ! function_exists( 'rttsp' ) ) {
				$links[] = '<a target="_blank" style="color: #39b54a;font-weight: 700;" href="' . esc_url( TSSPro()->pro_version_link() ) . '">Get Pro</a>';
			}

			return $links;
		}

	}
endif;

<?php
	if(!class_exists('Arrival_Welcome')) :

		class Arrival_Welcome {

			public $tab_sections = array(); // Welcome Page Tab Sections
			public $theme_name = null; // For storing Theme Name
			public $theme_slug = null; // For storing Theme Slug
			public $theme_version = null; // For Storing Theme Current Version Information
			public $free_plugins = array(); // Displayed Under Recommended Tabs
			public $pro_plugins = array(); // Will be displayed under Recommended Plugins
			public $req_plugins = array(); // Will be displayed under Required Plugins Tab
			public $companion_plugins = array(); // Will be displayed under Demo Import Tab
			public $strings = array(); // Common Display Strings

			
			public function __construct( $plugins, $strings ) {
				/** Useful Variables **/
				$theme = wp_get_theme();
				$this->theme_name = $theme->Name;
				$this->theme_slug = $theme->TextDomain;
				$this->theme_version = $theme->Version;

				/** Plugins **/
				$this->free_plugins = $plugins['recommended_plugins']['free_plugins'];
				$this->pro_plugins = $plugins['recommended_plugins']['pro_plugins'];
				$this->req_plugins = $plugins['required_plugins'];
				$this->companion_plugins = $plugins['companion_plugins'];

				/** Tabs **/
				$this->tab_sections = array(
					'getting_started' 		=> esc_html__('Getting Started', 'arrival'),
					'recommended_plugins' 	=> esc_html__('Recommended Plugins', 'arrival'),
					'demo_import' 			=> esc_html__('Import Demo', 'arrival'),
					'changelogs'			=> esc_html__('Changelogs','arrival'),
					'free_vs_pro'			=> esc_html__('Free Vs Pro','arrival'),
					'support' 				=> esc_html__('Support', 'arrival'),
					
				);

				/** Strings **/
				$this->strings = $strings;

				/* Theme Activation Notice */
				add_action( 'load-themes.php', array( $this, 'activation_admin_notice' ) );

				/* Create a Welcome Page */
				add_action( 'admin_menu', array( $this, 'welcome_register_menu' ) );

				/* Enqueue Styles & Scripts for Welcome Page */
				add_action( 'admin_enqueue_scripts', array( $this, 'welcome_styles_and_scripts' ) );

				/** WordPress Plugin Installation Ajax **/
				add_action( 'wp_ajax_plugin_installer', array( $this, 'plugin_installer_callback' ) );

				/** Bundled & Remote Plugin Installation Ajax **/
				add_action( 'wp_ajax_plugin_offline_installer', array( $this, 'plugin_offline_installer_callback' ) );

				/** Plugin Activation Ajax **/
				add_action( 'wp_ajax_plugin_activation', array( $this, 'plugin_activation_callback' ) );

				/** Plugin Deactivation Ajax **/
				add_action( 'wp_ajax_plugin_deactivation', array( $this, 'plugin_deactivation_callback' ) );

				add_action( 'init', array( $this, 'get_required_plugin_notification' ));

				/** Remove welcome notice after closing **/
				add_action('admin_init', array( $this, 'info_notice_ignore' ));

			}
			
			public function get_required_plugin_notification() {

				$req_plugins = $this->free_plugins;
				
				$notif_counter = count($this->free_plugins);

				foreach($req_plugins as $plugin) {

					if( isset( $plugin['class'] ) ) {
						if( class_exists( $plugin['class'] ) ) {
							$notif_counter--;
						}
					}
				}
				return $notif_counter;
			}

			function info_notice_ignore() {
				global $current_user;
				
				$user_id = $current_user->ID;
				
				if (isset($_GET['theme-info-ignore-notice'])) {
					add_user_meta($user_id, 'info_notice_ignore', 'true', true);
				}
				
			}
			

			/** Welcome Message Notification on Theme Activation **/
			public function activation_admin_notice() {
				global $pagenow,$current_user;
				
				$user_id = $current_user->ID;
				if (!get_user_meta($user_id, 'info_notice_ignore')) {
					if( is_admin() && ('themes.php' == $pagenow)  ) { 
						add_action( 'admin_notices', array( $this,'welcome_admin_notice_display') );
					}
				}
			}

			public function welcome_admin_notice_display(){
                ?>
			<div class="operation-theme-welcome-info notice notice-success is-dismissible clearfix">
			<p>
			<?php
			printf( '%1$s %2$s %3$s <a href="%4$s">%5$s</a> %6$s', esc_html__( 'Welcome! Thank you for choosing', 'arrival' ), esc_html($this->theme_name), esc_html__( 'Please make sure you visit our', 'arrival' ), esc_url( admin_url( 'themes.php?page=welcome-page' ) ), esc_html__( 'Welcome Page', 'arrival' ), esc_html__( 'to get started with Arrival.', 'arrival' ) );
			?>
			</p>
			<p><a class="button button-primary" href="<?php echo esc_url(admin_url( 'themes.php?page=welcome-page' )) ?>"><?php esc_html_e( 'Lets Get Started', 'arrival' ); ?></a>
				<span class="dismiss"><a href="?theme-info-ignore-notice"><?php esc_html_e('Dismiss','arrival') ?></a></span>
			</p>
			
			</div>
			<?php

			}

			/** Register Menu for Welcome Page **/
			public function welcome_register_menu() {
				$action_count =  $this->get_required_plugin_notification();
				$title        = $action_count > 0 ? esc_html($this->strings['welcome_menu_text']) . '<span class="badge pending-tasks">' . esc_html( $action_count ) . '</span>' : esc_html($this->strings['welcome_menu_text']);
				add_theme_page( esc_html($this->strings['welcome_menu_text']), $title , 'edit_theme_options', 'welcome-page', array( $this, 'welcome_screen' ));
			}

			/** Welcome Page **/
			public function welcome_screen() {
				$tabs = $this->tab_sections;

				$current_section = isset($_GET['section']) ? sanitize_text_field( wp_unslash( $_GET['section'] ) ) : 'getting_started';
				$section_inline_style = '';
				?>
				<div class="op-welcome-header">
					<div class="inner-header-wrapp">
					<h1><?php echo esc_html($this->theme_name); ?></h1>
					<span><?php echo esc_html($this->theme_version); ?></span>
					<div class="about-text"><?php echo wp_kses_post($this->strings['theme_short_description']); ?></div>
					</div>
				</div>
				<div class="wrap op-about-wrap">
					
					

				<div class="nav-tab-wrapper clearfix">
					<?php foreach($tabs as $id => $label) : ?>
						<?php
							$section = isset($_REQUEST['section']) ? sanitize_text_field( wp_unslash( $_REQUEST['section'] ) ) : 'getting_started';
							$nav_class = 'nav-tab';
							if($id == $section) {
								$nav_class .= ' nav-tab-active';
							}
						?>
						<a href="<?php echo esc_url(admin_url('themes.php?page=welcome-page&section='.$id)); ?>" class="<?php echo esc_attr($nav_class); ?>" >
							<?php echo esc_html( $label ); ?>
							<?php if($id == 'recommended_plugins') : $not = $this->get_required_plugin_notification(); ?>
								<?php if($not) : ?>
							   		<span class="pending-tasks">
						   				<?php echo esc_html($not); ?>
						   			</span>
				   				<?php endif; ?>
						   	<?php endif; ?>
					   	</a>
					<?php endforeach; ?>
			   	</div>

		   		<div class="welcome-section-wrapper">
	   				<?php $section = isset($_REQUEST['section']) ? sanitize_text_field( wp_unslash( $_REQUEST['section'] ) ) : 'getting_started'; ?>

   					<div class="welcome-section <?php echo esc_attr($section); ?> clearfix">
   						<?php require_once get_template_directory() . '/inc/welcome/sections/'.esc_html($section).'.php'; ?>
					</div>
			   	</div>
			   	</div>
				<?php
			}

			/** Enqueue Necessary Styles and Scripts for the Welcome Page **/
			public function welcome_styles_and_scripts() {
				wp_enqueue_style( 'arrival-welcome-screen', get_template_directory_uri() . '/inc/welcome/css/welcome.css' );
				wp_enqueue_script( 'arrival-welcome-screen', get_template_directory_uri() . '/inc/welcome/js/welcome.js', array( 'jquery' ) );

				wp_localize_script( 'arrival-welcome-screen', 'operationWelcomeObject', array(
					'admin_nonce'					=> wp_create_nonce( 'plugin_installer_nonce'),
					'activate_nonce'				=> wp_create_nonce( 'plugin_activate_nonce'),
					'deactivate_nonce'				=> wp_create_nonce( 'plugin_deactivate_nonce'),
					'offline_install_plugin_nonce' 	=> wp_create_nonce('offline_install_plugin_nonce'),
					'ajaxurl'						=> esc_url( admin_url( 'admin-ajax.php' ) ),
					'activate_btn' 					=> $this->strings['activate_btn'],
					'installed_btn' 				=> $this->strings['installed_btn'],
					'demo_installing' 				=> $this->strings['demo_installing'],
					'demo_installed' 				=> $this->strings['demo_installed'],
					'demo_confirm' 					=> $this->strings['demo_confirm'],
				) );
			}

			/** Plugin API **/
			public function call_plugin_api( $plugin ) {
				include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

				$call_api = plugins_api( 'plugin_information', array(
					'slug'   => $plugin,
					'fields' => array(
						'downloaded'        => false,
						'rating'            => false,
						'description'       => false,
						'short_description' => true,
						'donate_link'       => false,
						'tags'              => false,
						'sections'          => true,
						'homepage'          => true,
						'added'             => false,
						'last_updated'      => false,
						'compatibility'     => false,
						'tested'            => false,
						'requires'          => false,
						'downloadlink'      => false,
						'icons'             => true
					)
				) );

				return $call_api;
			}

			/** Check For Icon **/
			public function check_for_icon( $arr ) {
				if ( ! empty( $arr['svg'] ) ) {
					$plugin_icon_url = $arr['svg'];
				} elseif ( ! empty( $arr['2x'] ) ) {
					$plugin_icon_url = $arr['2x'];
				} elseif ( ! empty( $arr['1x'] ) ) {
					$plugin_icon_url = $arr['1x'];
				} else {
					$plugin_icon_url = $arr['default'];
				}

				return $plugin_icon_url;
			}

			/** Check if Plugin is active or not **/
			public function get_plugin_active($plugin) {
				$folder_name = $plugin['slug'];
				$file_name = $plugin['filename'];
				$class = $plugin['class'];
				$status = 'install';

				$path = WP_PLUGIN_DIR.'/'.esc_attr($folder_name).'/'.esc_attr($file_name);
				if( file_exists( $path ) ) {
					$status = class_exists( $class ) ? 'inactive' : 'active';
				}
				return $status;
			}

			/** Generate Url for the Plugin Button **/
			public function generate_plugin_url($status, $plugin) {
				$folder_name = $plugin['slug'];
				$file_name = $plugin['filename'];

				switch ( $status ) {
					case 'install':
						return wp_nonce_url(
							add_query_arg(
								array(
									'action' => 'install-plugin',
									'plugin' => esc_attr($folder_name)
								),
								network_admin_url( 'update.php' )
							),
							'install-plugin_' . esc_attr($folder_name)
						);
						break;

					case 'inactive':
						return '#';
						break;

					case 'active':
						return '#';
						break;
				}
			}

			/* ========== Plugin Installation Ajax =========== */
			public function plugin_installer_callback(){

				if ( ! current_user_can('install_plugins') ) {
					wp_die( esc_html__( 'Sorry, you are not allowed to install plugins on this site.', 'arrival' ) );
				}

				$nonce = isset( $_POST["nonce"] ) ? sanitize_text_field( wp_unslash( $_POST["nonce"] ) ) : '';
				$plugin = isset( $_POST["plugin"] ) ? sanitize_text_field( wp_unslash( $_POST["plugin"] ) ) : '';
				$plugin_file = isset( $_POST["plugin_file"] ) ? sanitize_text_field( wp_unslash( $_POST["plugin_file"] ) ) : '';

				// Check our nonce, if they don't match then bounce!
				if (! wp_verify_nonce( $nonce, 'plugin_installer_nonce' )) {
					wp_die( esc_html__( 'Error - unable to verify nonce, please try again.', 'arrival') );
				}


         		// Include required libs for installation
				require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
				require_once ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php';
				require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';

				// Get Plugin Info
				$api = $this->call_plugin_api($plugin);

				$skin     = new WP_Ajax_Upgrader_Skin();
				$upgrader = new Plugin_Upgrader( $skin );
				$upgrader->install($api->download_link);

				$plugin_file = esc_html($plugin).'/'.esc_html($plugin_file);

				if($api->name) {
					if($plugin_file) {
						activate_plugin($plugin_file);
						echo 'success';
						die();
					}
				}
				echo 'fail';

				die();
			}

			/** Plugin Offline Installation Ajax **/
			public function plugin_offline_installer_callback() {

				if ( ! current_user_can('install_plugins') || !wp_verify_nonce( $_POST['offline_install_plugin_nonce'], 'offline_install_plugin_nonce' ) ) {
					wp_die( esc_html__( 'Sorry, you are not allowed to install plugins on this site.', 'arrival' ) );
				}

				$plugin = array();

				$file_location = $plugin['location'] = isset( $_POST['file_location'] ) ? sanitize_text_field( wp_unslash( $_POST['file_location'] ) ) : '';
				$file = isset( $_POST['file'] ) ? sanitize_text_field( wp_unslash( $_POST['file'] ) ) : '';
				$host_type = isset( $_POST['host_type'] ) ? sanitize_text_field( wp_unslash( $_POST['host_type'] ) ) : '';
				$plugin_class = $plugin['class'] = isset( $_POST['class_name'] ) ? sanitize_text_field( wp_unslash( $_POST['class_name'] ) ) : '';
				$plugin_slug = $plugin['slug'] = isset( $_POST['slug'] ) ? sanitize_text_field( wp_unslash( $_POST['slug'] ) ) : '';
				$plugin_directory = ABSPATH . 'wp-content/plugins/';

				$plugin_file = $plugin_slug . '/' . $file;

				if( $host_type == 'remote' ) {
					$file_location = $this->get_local_dir_path($plugin);
				}

				$zip = new ZipArchive();
				if ($zip->open($file_location) === TRUE) {
				    $zip->extractTo($plugin_directory);
				    $zip->close();

				    activate_plugin($plugin_file);

				    if( $host_type == 'remote' ) {
			    		unlink($file_location);
			    	}

				    echo 'success';

					die();
				} else {
				    echo 'failed';
				}

				die();
			}

			/** Plugin Offline Activation Ajax **/
			public function plugin_activation_callback() {

				if ( ! current_user_can('activate_plugins') ) {
					wp_die( esc_html__( 'Sorry, you are not allowed to active plugins on this site.', 'arrival' ) );
				}

				$plugin = isset( $_POST['plugin'] ) ? sanitize_text_field( wp_unslash( $_POST['plugin'] ) ) : '';
				$plugin_file = isset( $_POST['plugin_file'] ) ? sanitize_text_field( wp_unslash( $_POST['plugin_file'] ) ) : '';
				$plugin_file = ABSPATH . 'wp-content/plugins/'.esc_html($plugin).'/'.esc_html($plugin_file);

				if(file_exists($plugin_file)) {

					activate_plugin($plugin_file);
					echo "success";

				} else {
					echo esc_html__('Plugin Does not Exists' , 'arrival');
				}

				die();

			}

			/** Plugin Offline Activation Ajax **/
			public function plugin_deactivation_callback() {

				if ( ! current_user_can('deactivate_plugins') ) {
					wp_die( esc_html__( 'Sorry, you are not allowed to deactivate plugins on this site.', 'arrival' ) );
				}

				$plugin = isset( $_POST['plugin'] ) ? sanitize_text_field( wp_unslash( $_POST['plugin'] ) ) : '';
				$plugin_file = isset( $_POST['plugin_file'] ) ? sanitize_text_field( wp_unslash( $_POST['plugin_file'] ) ) : '';
				$plugin_file = ABSPATH . 'wp-content/plugins/'.esc_html($plugin).'/'.esc_html($plugin_file);

				if(file_exists($plugin_file)) {

					deactivate_plugins($plugin_file);
					echo "success";

				} else {
					echo esc_html__('Plugin Does not Exists' , 'arrival');
				}

				die();

			}


		  	public function get_local_dir_path($plugin) {

		  		$upload_dir = wp_upload_dir();

		  		$file_location = $file_location = $upload_dir['path'] . '/' . $plugin['slug'].'.zip';

		  		if( file_exists( $file_location ) || class_exists( $plugin['class'] ) ) {
		  			return $file_location;
		  		}

	      		$url = wp_nonce_url(admin_url('themes.php?page=' . 'arrival' . '-welcome&section=actions_required'),'remote-file-installation');
				if (false === ($creds = request_filesystem_credentials($url, '', false, false, null) ) ) {
					return; // stop processing here
				}

	      		if ( ! WP_Filesystem($creds) ) {
					request_filesystem_credentials($url, '', true, false, null);
					return;
				}

				global $wp_filesystem;
				$file = $wp_filesystem->get_contents( $plugin['location'] );

				$wp_filesystem->put_contents( $file_location, $file, FS_CHMOD_FILE );

				return $file_location;
	      	}

	      	public function check_plugin_status( $plugins ) {

	      		$status = false;

	      		if( empty( $plugins ) ) {
	      			return;
	      		}

	      		foreach( $plugins as $plugin ) {
	      			if( class_exists( $plugin[ 'class' ] ) ) {
	      				$status = true;
	      			} else {
	      				return false;
	      			}

	      		}

	      		return $status;

	      	}

	      	public function admin_sidebar_contents(){ ?>
	      		<div class="operation-admin-side-wrapper">
					<div class="operation-side-box-wrapper operation-welcome-box-white">
						<div class="box-header op-box-header"><?php esc_html_e('Theme Documentation','arrival'); ?></div>
						<div class="box-content">
							<p><?php esc_html_e('We have online documentation to make your configuration process easy, go through the documentation to get more familiar with theme','arrival'); ?></p>
							<a href="<?php echo esc_url($this->strings['doc_link']);?>" class="button button-primary" target="_blank"><?php esc_html_e('Read Now','arrival'); ?></a>
						</div>
					</div>

					<div class="operation-side-box-wrapper operation-welcome-box-white">
						<div class="box-header op-box-header"><?php printf(esc_html__('Loving %1$s ? ','arrival'),$this->theme_name); ?></div>
						<div class="box-content">
							<p><?php esc_html_e('If you are enjoying theme,spread your love and rate our theme.','arrival'); ?></p>
							<a href="https://wordpress.org/support/theme/arrival/reviews/#new-post" class="button button-primary" target="_blank"><?php esc_html_e('Rate Now','arrival'); ?></a>
						</div>
					</div>

				</div>
			<?php 
	      	}

		}

	endif;
?>
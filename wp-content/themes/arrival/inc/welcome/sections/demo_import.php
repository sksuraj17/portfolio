<?php
	wp_enqueue_style( 'plugin-install' );
	wp_enqueue_script( 'plugin-install' );
	wp_enqueue_script( 'updates' );
	$req_plugins = $this->req_plugins;
	$plugin_count = 0;

	$all_plugins_installed = $this->check_plugin_status( $req_plugins );

	foreach($req_plugins as $plugin) :

		if( $plugin['host_type'] == 'bundled' ) {

			$status = $this->get_plugin_active($plugin);

			switch($status) {
				case 'install' :
					$btn_class = 'install-offline button';
					$label = $this->strings['install_n_activate'];
					$link = $plugin['location'];
					$info = $plugin['info'];
					break;

				case 'inactive' :
					$btn_class = 'deactivate button';
					$label = $this->strings['deactivate'];
					$link = '#';
					$info = $plugin['info'];
					break;

				case 'active' :
					$btn_class = 'activate button button-primary';
					$label = $label = $this->strings['activate'];
					$link = '#';
					$info = $plugin['info'];
					break;
			}

			?>
			<?php if( isset( $plugin['class'] ) && !class_exists( $plugin['class'] ) ) : ?>
				<div class="action-tab warning">
					<h3><?php echo esc_html($label) . ' : '. esc_html($plugin['name']); ?></h3>
					<p><?php echo esc_html( $info ); ?></p>

					<span class="plugin-action-btn plugin-card-<?php echo esc_attr($plugin['slug']); ?>" action_button>
						<a class="<?php echo esc_attr($btn_class); ?>" data-host-type="<?php echo esc_attr($plugin['host_type']); ?>" data-file='<?php echo esc_attr($plugin['filename']); ?>' data-class="<?php echo esc_attr($plugin['class']); ?>" data-slug="<?php echo esc_attr($plugin['slug']); ?>" href="<?php echo esc_attr($link); ?>"><?php echo esc_html($label); ?></a>
					</span>
				</div>
			<?php 
			$plugin_count++;
			endif; ?>
			<?php
		} elseif( $plugin['host_type'] == 'remote' ) {
			
			$status = $this->get_plugin_active($plugin);

			switch($status) {
				case 'install' :
					$btn_class = 'install-offline button';
					$label = $this->strings['install_n_activate'];
					$link = $plugin['location'];
					$info = $plugin['info'];
					break;

				case 'inactive' :
					$btn_class = 'deactivate button';
					$label = $this->strings['deactivate'];
					$link = '#';
					$info = $plugin['info'];
					break;

				case 'active' :
					$btn_class = 'activate button button-primary';
					$label = $label = $this->strings['activate'];
					$link = '#';
					$info = $plugin['info'];
					break;
			}

			?>
			<?php if( isset( $plugin['class'] ) && !class_exists( $plugin['class'] ) ) : ?>
				<div class="action-tab warning">
					<h3><?php esc_html($label). ' : '. esc_html( $plugin['name'] ); ?></h3>
					<p><?php echo esc_html($info); ?></p>

					<span class="plugin-action-btn plugin-card-<?php echo esc_attr($plugin['slug']); ?>" action_button>
						<a class="<?php echo esc_attr($btn_class); ?>" data-host-type="<?php echo esc_attr($plugin['host_type']); ?>" data-file='<?php echo esc_attr($plugin['filename']); ?>' data-class="<?php echo esc_attr($plugin['class']); ?>" data-slug="<?php echo esc_attr($plugin['slug']); ?>" href="<?php echo esc_attr($link); ?>"><?php echo esc_html($label); ?></a>
					</span>
				</div>
			<?php 
			$plugin_count++;
			endif; ?>
			<?php
		} else {
			
			$info = $this->call_plugin_api($plugin['slug']);
			if(!isset($info->errors)) :

				$icon_url = $this->check_for_icon($info->icons);
				$status = $this->get_plugin_active($plugin);
				$btn_url = $this->generate_plugin_url($status, $plugin);

				switch($status) {
					case 'install' :
						$btn_class = 'install button';
						$label = $this->strings['install_n_activate'];
						break;

					case 'inactive' :
						$btn_class = 'deactivate button';
						$label = $this->strings['deactivate'];
						break;

					case 'active' :
						$btn_class = 'activate button button-primary';
						$label = $label = $this->strings['activate'];
						break;
				}
				$path = WP_PLUGIN_DIR.'/'.esc_attr($plugin['slug']).'/'.esc_attr($plugin['filename']);
				?>

				<?php if( isset( $plugin['class'] ) && !class_exists( $plugin['class'] ) ) : ?>
					<div class="action-tab warning">
						<h3><?php echo esc_html__("Install : ", 'arrival'). esc_html($info->name); ?></h3>
						<p><?php echo esc_html($plugin['info']); ?></p>

						<span class="plugin-action-btn plugin-card-<?php echo esc_attr($plugin['slug']); ?>" action_button>
							<a class="<?php echo esc_attr($btn_class); ?>" data-host-type="<?php echo esc_attr($plugin['host_type']); ?>" data-file="<?php echo esc_attr($plugin['filename']); ?>" data-class="<?php echo esc_attr($plugin['class']); ?>" data-slug="<?php echo esc_attr($plugin['slug']); ?>" href="<?php echo esc_attr($btn_url); ?>"><?php echo esc_html($label); ?></a>
						</span>
					</div>
				<?php 
				$plugin_count++;
				endif; ?>

			<?php
			endif;
		}

	endforeach;

if( $all_plugins_installed ) {
	//check if demo importer plugin is available
	if( class_exists('WOPDI')){

		$demoData = new WPOP_Install_Demos;
		$demoData->create_admin_page();
	}
	
}
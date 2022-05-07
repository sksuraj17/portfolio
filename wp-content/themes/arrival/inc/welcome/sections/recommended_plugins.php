<?php
	wp_enqueue_style( 'plugin-install' );
	wp_enqueue_script( 'plugin-install' );
	wp_enqueue_script( 'updates' );

	if( !empty($this->pro_plugins) ) {
		?>
		<h4 class="recomplug-title"><?php echo esc_html($this->strings['pro_plugin_title']); ?></h4>
		<p><?php echo esc_html($this->strings['pro_plugin_description']); ?></p>
		<div class="recomended-plugin-wrap clearfix">
		<?php
		foreach($this->pro_plugins as $plugin) {
			if($plugin['host_type'] == 'bundled') {

				$status = $this->get_plugin_active($plugin);
				$icon_url = $plugin['screenshot'];
				switch( $status ) {
					case 'install' :
						$btn_class = 'install-offline button';
						$label = $this->strings['install_n_activate'];
						$link = $plugin['location'];
						break;

					case 'inactive' :
						$btn_class = 'deactivate button';
						$label = $this->strings['deactivate'];
						$link = admin_url('plugins.php');
						break;

					case 'active' :
						$btn_class = 'activate button button-primary';
						$label = $this->strings['activate'];
						$link = $plugin['location'];
						break;
				} ?>
					<div class="recom-plugin-wrap">
						<div class="plugin-img-wrap">
							<img src="<?php echo esc_url($icon_url); ?>" />
							<div class="version-author-info">
								<span class="version"><?php echo esc_html__('Version ', 'arrival') . esc_html($plugin['version']); ?></span>
								<span class="seperator">|</span>
								<span class="author"><?php echo esc_html($plugin['author']); ?></span>
							</div>
						</div>
						<div class="plugin-title-install clearfix">
							<span class="title" title="<?php echo esc_attr($plugin['name']); ?>">
								<?php echo esc_html($plugin['name']); ?>
							</span>

							<span class="plugin-action-btn plugin-btn-wrapper plugin-card-<?php echo esc_attr($plugin['slug']); ?>">
								<a class="<?php echo esc_attr($btn_class); ?>" data-host-type="<?php echo esc_attr($plugin['host_type']); ?>" data-file="<?php echo esc_attr($plugin['filename']); ?>" data-class="<?php echo esc_attr($plugin['class']); ?>" data-slug="<?php echo esc_attr($plugin['slug']); ?>" href="<?php echo esc_attr($link); ?>"><?php echo esc_html($label); ?></a>
							</span>
						</div>
					</div>
				<?php
			} elseif( $plugin['host_type'] == 'remote' ) {
				$status = $this->get_plugin_active($plugin);
				$icon_url = $plugin['screenshot'];
				switch( $status ) {
					case 'install' :
						$btn_class = 'install-offline button';
						$label = $this->strings['install_n_activate'];
						$link = $plugin['location'];
						break;

					case 'inactive' :
						$btn_class = 'deactivate button';
						$label = $this->strings['deactivate'];
						$link = admin_url('plugins.php');
						break;

					case 'active' :
						$btn_class = 'activate button button-primary';
						$label = $this->strings['activate'];
						$link = $plugin['location'];
						break;
				} ?>
					<div class="recom-plugin-wrap">
						<div class="plugin-img-wrap">
							<img src="<?php echo esc_url($icon_url); ?>" />
							<div class="version-author-info">
								<span class="version"><?php echo esc_html__('Version ', 'arrival') . esc_html($plugin['version']); ?></span>
								<span class="seperator">|</span>
								<span class="author"><?php echo esc_html($plugin['author']); ?></span>
							</div>
						</div>
						<div class="plugin-title-install clearfix">
							<span class="title" title="<?php echo esc_attr($plugin['name']); ?>">
								<?php echo esc_html($plugin['name']); ?>
							</span>

							<span class="plugin-action-btn plugin-btn-wrapper plugin-card-<?php echo esc_attr($plugin['slug']); ?>">
								<a class="<?php echo esc_attr($btn_class); ?>" data-host-type="<?php echo esc_attr($plugin['host_type']); ?>" data-file="<?php echo esc_attr($plugin['filename']); ?>" data-class="<?php echo esc_attr($plugin['class']); ?>" data-slug="<?php echo esc_attr($plugin['slug']); ?>" href="<?php echo esc_attr($link); ?>"><?php echo esc_html($label); ?></a>
							</span>
						</div>
					</div>
				<?php
			}
		} ?>
		</div>
	<?php
	}

	if( !empty($this->free_plugins) ) {
		?>
		<h4 class="recomplug-title"><?php esc_html($this->strings['free_plugin_title']); ?></h4>
		<p><?php esc_html($this->strings['free_plugin_description']); ?></p>
		<div class="recomended-plugin-wrap">
		<?php
		foreach($this->free_plugins as $plugin) {
			$info = $this->call_plugin_api($plugin['slug']);

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
					$label = $this->strings['activate'];
					break;
			}

			?>
				<div class="recom-plugin-wrap">
					<div class="plugin-img-wrap">
						<img src="<?php echo esc_url($icon_url); ?>" />
						<div class="version-author-info">
							<span class="version"><?php echo esc_html__('Version ', 'arrival') . esc_html($info->version); ?></span>
							<span class="seperator">|</span>
							<span class="author"><?php echo wp_kses_post($info->author); ?></span>
						</div>
					</div>
					<div class="plugin-title-install clearfix">
						<span class="title" title="<?php echo esc_attr($info->name); ?>">
							<?php
								echo esc_html($info->name);
							?>
						</span>

						<span class="plugin-action-btn plugin-btn-wrapper plugin-card-<?php echo esc_attr($plugin['slug']); ?>" action_button>
							<a class="<?php echo esc_attr($btn_class); ?>" data-file="<?php echo esc_attr($plugin['filename']); ?>" data-slug="<?php echo esc_attr($plugin['slug']); ?>" href="<?php echo esc_url($btn_url); ?>"><?php echo esc_html($label); ?></a>
						</span>
					</div>
				</div>
			<?php
		} ?>
		</div>
	<?php
	}
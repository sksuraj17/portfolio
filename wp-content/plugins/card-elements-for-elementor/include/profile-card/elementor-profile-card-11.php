<div class="profile-card-style-11" style="background-image: url(<?php echo $settings['profile_image']['url']; ?>);">
    <div class="triangle-div">
	</div>
	<div class="title">
			<div class="name"><?php echo $settings['name']; ?></div>
			<div class="position"><?php echo $settings['position']; ?></div>
	</div>
	<div class="elementor-social-icons-wrapper team-member__socialmedia">
		<?php
		foreach ($settings['social_icon_list'] as $index => $item) {
			$social = str_replace('fab fa-', '', $item['social']);

			$link_key = 'link_' . $index;

			$this->add_render_attribute($link_key, 'href', $item['link']['url']);

			if ($item['link']['is_external']) {
				$this->add_render_attribute($link_key, 'target', '_blank');
			}

			if ($item['link']['nofollow']) {
				$this->add_render_attribute($link_key, 'rel', 'nofollow');
			}
			?>
			<a class="elementor-icon elementor-social-icon elementor-social-icon-<?php echo $social . $class_animation; ?>" <?php echo $this->get_render_attribute_string($link_key); ?>>
				<span class="elementor-screen-only"><?php echo ucwords($social); ?></span>
				<i class="<?php echo $item['social']; ?>"></i>
			</a>
		<?php } ?>
	</div>
</div>
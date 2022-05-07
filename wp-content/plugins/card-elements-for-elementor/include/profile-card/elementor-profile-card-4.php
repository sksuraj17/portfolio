<!-- Start Profile Card 4 -->
<div class="profile-card-style-4 text-center" style="background-image:url(<?php echo $settings['profile_background_image']['url']; ?>);">
    <img src="<?php echo $settings['profile_image']['url']; ?>" style="width: 300px; height: px" class="img img-responsive">
    <div class="profile-content elementor-content-background-color-wrapper">
        <div class="profile-bg elementor-content-background-color-wrapper"></div>
        <div class="profile-name elementor-profile-name-wrapper"><?php echo $settings['name']; ?>
            <p class="profile-position elementor-profile-position-wrapper"><?php echo $settings['position']; ?></p>
        </div>
        <p class="profile-description elementor-profile-description-wrapper"><?php echo $settings['profile_description']; ?></p>
        <div class="profile-icons">
            <!-- social icon -->
            <div class="elementor-social-icons-wrapper">
                <?php
                // Social icon list
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
    </div>
</div>
<!-- End Profile Card -->
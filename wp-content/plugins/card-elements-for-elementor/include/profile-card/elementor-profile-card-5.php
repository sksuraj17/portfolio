<!-- Start Profile Card 5 -->
<div class="profile-card-style-5 text-center" style="background-image:url(<?php echo $settings['profile_background_image']['url']; ?>);">
    <div id="ct-team-member-2" class="ct-team-member-layout ">
        <div class="ct-team-member-inner elementor-content-background-color-wrapper">
            <div class="ct-team-image">
                <img src="<?php echo $settings['profile_image']['url']; ?>" width="255" height="320"class="img img-responsive">
                <div class="profile-icons">
                    <!-- social icon -->
                    <div class="elementor-social-icons-wrapper ct-team-social">
                        <p class="profile-description elementor-profile-description-wrapper"><?php echo $settings['profile_description']; ?></p>
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
            </div>
            <div class="ct-team-holder">
                <h3 class="ct-team-title profile-name elementor-profile-name-wrapper"><?php echo $settings['name']; ?></h3>
                <!-- position -->
                <div class="ct-team-position text-gradient2 subtitle profile-position elementor-profile-position-wrapper"><?php echo $settings['position']; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Profile Card -->
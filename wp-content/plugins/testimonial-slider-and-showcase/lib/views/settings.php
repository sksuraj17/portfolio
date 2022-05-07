<div class="wrap">
    <h2><?php esc_html_e('Testimonial Settings', "testimonial-slider-showcase") ?></h2>
    <div class="rt-settings-container">
        <div class="rt-setting-title">
            <h3><?php esc_html_e('General settings', "testimonial-slider-showcase") ?></h3></div>
        <div class="rt-setting-content">
            <form id="tss-settings">
                <div id="settings-tabs" class="rt-tabs rt-tab-container">
                    <ul class="tab-nav rt-tab-nav">
                        <?php
                            $tab = isset( $_GET['tab'] ) && $_GET['tab'] ? esc_html( $_GET['tab'] ) : '';
                        ?>
                        <li class="<?php echo ( $tab != 'support' ) ? 'active': ''; ?>">
                            <a href="#general"><i class="dashicons dashicons-admin-settings"></i><?php esc_html_e('General', "testimonial-slider-showcase"); ?></a>
                        </li>
                        <?php do_action('rtts_setting_tabs_one'); ?>

                        <!-- <li class="<?php //echo ( $tab == 'support' ) ? 'active': ''; ?>"><a href="#support"><i class="dashicons dashicons-sos"></i><?php //esc_html_e('Support', "testimonial-slider-showcase"); ?></a>
                        </li> -->
                        <?php do_action('rtts_setting_tabs_two'); ?>

                    </ul>
                    <div id="general" class="rt-tab-content" style="<?php echo ( $tab != 'support' ) ? 'display: block;': ''; ?>">
                        <?php echo TSSPro()->rtFieldGenerator(TSSPro()->generalSettings()); ?>
                    </div>

                    <?php do_action('rtts_setting_tabs_content'); ?>

                    <!-- <div id="support" class="rt-tab-content" style="<?php //echo ( $tab == 'support' ) ? 'display: block;': ''; ?> padding: 20px;">
                        <h3><?php //esc_html_e( "How to use Testimonial Slider and Showcase?", "testimonial-slider-showcase" ); ?></h3>
                        <iframe width="611" height="360" src="https://www.youtube.com/embed/Aik0cfidl4A" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                        <h3><?php //esc_html_e( "Online documentation", "testimonial-slider-showcase" ); ?></h3>
                        <p style="padding: 0">
                        <?php //_e( "From our online documentation, you will know how to use our pluign. <br> If you face any issue please create a ticket. We will provide you solution as soon as possible.", "testimonial-slider-showcase" ); ?> <br><br>
                        <a style="margin-right: 5px;" class="rt-admin-btn" target="_blank" href="<?php //echo esc_url( TSSPro()->documentation_link() );?>" target="_blank"><?php //esc_html_e( "Online Documentation", "testimonial-slider-showcase" ); ?></a>
                        <a class="rt-admin-btn" target="_blank" href="https://www.radiustheme.com/contact/" target="_blank"><?php //esc_html_e( "Get Support", "testimonial-slider-showcase" ); ?></a>
                        </p>
                    </div> -->

                </div>
                <p class="submit">
                    <input
                        type="submit"
                        name="submit"
                        id="tss-saveButton"
                        class="rt-admin-btn button button-primary"
                        value="<?php esc_html_e('Save Changes', "testimonial-slider-showcase"); ?>">
                </p>

                <?php wp_nonce_field(TSSPro()->nonceText(), TSSPro()->nonceId()); ?>
            </form>
            <div class="rt-response"></div>
        </div>
        <div class="rt-feature-content">
            <?php TSSPro()->rt_plugin_sc_pro_information(); ?>
        </div>
    </div>
</div>

<?php

if (!class_exists('TSSPortSCMeta')):
    /**
     *
     */
    class TSSPortSCMeta
    {

        function __construct() {
            add_action('add_meta_boxes', array($this, 'rt_tss_sc_meta_boxes'));
            add_action('save_post', array($this, 'save_rt_tss_sc_meta_data'), 10, 2);
            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts_sc'));
            add_action('edit_form_after_title', array($this, 'rt_tss_sc_after_title'));

            add_action('admin_init', array($this, 'remove_all_meta_box'));
        }

        function remove_all_meta_box() {
            if (is_admin()) {
                add_filter("get_user_option_meta-box-order_{" . TSSPro()->shortCodePT . "}",
                    array($this, 'remove_all_meta_boxes_portfolio_sc'));
            }
        }

        function remove_all_meta_boxes_portfolio_sc() {
            global $wp_meta_boxes;
            $publishBox = $wp_meta_boxes[TSSPro()->shortCodePT]['side']['core']['submitdiv'];
            $scBox = $wp_meta_boxes[TSSPro()->shortCodePT]['normal']['high']['rt_tss_sc_settings_meta'];
            $scPreviewBox = $wp_meta_boxes[TSSPro()->shortCodePT]['normal']['high']['rt_tss_sc_preview_meta'];
            $wp_meta_boxes[TSSPro()->shortCodePT] = array(
                'side'   => array('core' => array('submitdiv' => $publishBox)),
                'normal' => array(
                    'high' => array(
                        'rt_tss_sc_settings_meta' => $scBox,
                        'rt_tss_sc_preview_meta'  => $scPreviewBox
                    )
                )
            );

            return array();
        }

        function rt_tss_sc_after_title($post) {
            if (TSSPro()->shortCodePT !== $post->post_type) {
                return;
            }
            $html = null;
            $html .= '<div class="postbox" style="margin-bottom: 0;"><div class="inside">';
            $html .= '<p><input type="text" onfocus="this.select();" readonly="readonly" value="[rt-testimonial id=&quot;' . $post->ID . '&quot; title=&quot;' . $post->post_title . '&quot;]" class="large-text code tlp-code-sc">
            <input type="text" onfocus="this.select();" readonly="readonly" value="&#60;&#63;php echo do_shortcode( &#39;[rt-testimonial id=&quot;' . $post->ID . '&quot; title=&quot;' . $post->post_title . '&quot;]&#39; ) &#63;&#62;" class="large-text code tlp-code-sc">
            </p>';
            $html .= '</div></div>';

            echo $html;
        }

        function rt_tss_sc_meta_boxes() {
            add_meta_box(
                'rt_tss_sc_settings_meta',
                esc_html__('Short Code Generator', 'testimonial-slider-showcase'),
                array($this, 'rt_tss_sc_settings_selection'),
                TSSPro()->shortCodePT,
                'normal',
                'high');

            add_meta_box(
                'rt_tss_sc_preview_meta',
                esc_html__('Layout Preview', 'testimonial-slider-showcase'),
                array($this, 'rt_tss_sc_preview_selection'),
                TSSPro()->shortCodePT,
                'normal',
                'high');

            add_meta_box(
                'rt_plugin_tss_sc_pro_information',
                esc_html__('Documentation', 'testimonial-slider-showcase'),
                array($this, 'rt_plugin_sc_pro_information'),
                TSSPro()->shortCodePT,
                'side');
        }

        function rt_plugin_sc_pro_information() {

            $html = sprintf('<div class="rt-document-box">
							<div class="rt-box-icon"><i class="dashicons dashicons-media-document"></i></div>
							<div class="rt-box-content">
                    			<h3 class="rt-box-title">%1$s</h3>
                    				<p>%2$s</p>
                        			<a href="%3$s" target="_blank" class="rt-admin-btn">%1$s</a>
                			</div>
						</div>',
                esc_html__("Documentation", 'testimonial-slider-showcase'),
                esc_html__("Get started by spending some time with the documentation we included step by step process with screenshots with video.", 'testimonial-slider-showcase'),
                esc_url( TSSPro()->documentation_link() )
            );

            $html .= '<div class="rt-document-box">
							<div class="rt-box-icon"><i class="dashicons dashicons-sos"></i></div>
							<div class="rt-box-content">
                    			<h3 class="rt-box-title">Need Help?</h3>
                    				<p>Stuck with something? Please create a
                        <a href="https://www.radiustheme.com/contact/">ticket here</a> or post on <a href="https://www.facebook.com/groups/234799147426640/">facebook group</a>. For emergency case join our <a href="https://www.radiustheme.com/">live chat</a>.</p>
                        			<a href="https://www.radiustheme.com/contact/" target="_blank" class="rt-admin-btn">Get Support</a>
                			</div>
						</div>';

            if ( ! function_exists('rttsp') ) {
                $html .= '<div class="rt-document-box">
                    <div class="rt-box-icon"><i class="dashicons dashicons-awards"></i></div>
                    <div class="rt-box-content">
                        <h3 class="rt-box-title">Pro Features</h3>
                        <ol style="margin-left: 13px;">
                            <li>30 Amazing Layouts with Grid, Slider, Isotope & Video.</li>
                            <li>Front End Submission</li>
                            <li>Layout Preview in Shortcode Settings.</li>
                            <li>Taxonomy Ordering</li>
                        </ol>
                        <a href="' . esc_url( TSSPro()->pro_version_link() ) . '" class="rt-admin-btn" target="_blank">Get Pro Version</a>
                    </div>
                </div>';
            }
            $html .= '<div class="rt-document-box">
							<div class="rt-box-icon"><i class="dashicons dashicons-smiley"></i></div>
							<div class="rt-box-content">
                    			<h3 class="rt-box-title">Happy Our Work?</h3>
                                <p>Thank you for choosing Testimonial Slider. If you have found our plugin useful and makes you smile, please consider giving us a 5-star rating on WordPress.org. It will help us to grow.</p>
                                <a target="_blank" href="https://wordpress.org/support/plugin/testimonial-slider-and-showcase/reviews/?filter=5#new-post" class="rt-admin-btn">Yes, You Deserve It</a>
                			</div>
						</div>';

            echo $html;
        }

        function rt_tss_sc_settings_selection() {
            wp_nonce_field(TSSPro()->nonceText(), TSSPro()->nonceId());

            //auto select tab
            $tab = get_post_meta( get_the_ID(), '_rtts_sc_tab', true );
            if ( !$tab ) {
                $tab = 'layout';
            }
            $layout_tab = ( $tab == 'layout' ) ? 'active' : '';
            $filtering_tab = ( $tab == 'filtering' ) ? 'active' : '';
            $field_selection = ( $tab == 'field-selection' ) ? 'active' : '';
            $styling = ( $tab == 'styling' ) ? 'active' : '';

            $html = null;
            $html .= '<div id="sc-tabs" class="rt-tabs rt-tab-container">';
            $html .= '<ul class="tab-nav rt-tab-nav">
                    <li class="'.esc_attr( $layout_tab ).'"><a href="#sc-layout"><i class="dashicons dashicons-layout"></i>' . esc_html__('Layout', 'testimonial-slider-showcase') . '</a></li>
                    <li class="'.esc_attr( $filtering_tab ).'"><a href="#sc-filtering"><i class="dashicons dashicons-filter"></i>' . esc_html__('Filtering', 'testimonial-slider-showcase') . '</a></li>
                    <li class="'.esc_attr( $field_selection ).'"><a href="#sc-field-selection"><i class="dashicons dashicons-editor-table"></i>' . esc_html__('Field Selection', 'testimonial-slider-showcase') . '</a></li>
                    <li class="'.esc_attr( $styling ).'"><a href="#sc-styling"><i class="dashicons dashicons-admin-customizer"></i>' . esc_html__('Styling', 'testimonial-slider-showcase') . '</a></li>
                </ul>';

            $html .= '<input type="hidden" id="_rtts_sc_tab" name="_rtts_sc_tab" value="'.esc_attr($tab).'" />';
            $layout_tab = ( $tab == 'layout' ) ? 'display: block' : '';
            $filtering_tab = ( $tab == 'filtering' ) ? 'display: block' : '';
            $field_selection = ( $tab == 'field-selection' ) ? 'display: block' : '';
            $styling = ( $tab == 'styling' ) ? 'display: block' : '';

            $html .= '<div id="sc-layout" class="rt-tab-content" style="'.esc_attr( $layout_tab ).'">';
            $html .= '<div class="tab-content">';
            $html .= TSSPro()->rtFieldGenerator(TSSPro()->scLayoutMetaFields());
            $html .= '</div>';
            $html .= '</div>';

            $html .= '<div id="sc-filtering" class="rt-tab-content" style="'.esc_attr( $filtering_tab ).'">';
            $html .= '<div class="tab-content">';
            $html .= TSSPro()->rtFieldGenerator(TSSPro()->scFilterMetaFields());
            $html .= '</div>';
            $html .= '</div>';

            $html .= '<div id="sc-field-selection" class="rt-tab-content" style="'.esc_attr( $field_selection ).'">';
            $html .= '<div class="tab-content">';
            $html .= TSSPro()->rtFieldGenerator(TSSPro()->scItemMetaFields());
            $html .= '</div>';
            $html .= '</div>';

            $html .= '<div id="sc-styling" class="rt-tab-content" style="'.esc_attr( $styling ).'">';
            $html .= '<div class="tab-content">';
            $html .= TSSPro()->rtFieldGenerator(TSSPro()->scStyleFields());
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';

            echo $html;
        }

        function rt_tss_sc_preview_selection() {
            $html = null;
            $html .= "<div class='tss-response'><span class='spinner'></span></div>";
            $html .= "<div id='tss-preview-container'>";
            $html .= "</div>";

            echo $html;
        }

        function save_rt_tss_sc_meta_data($post_id, $post) {

            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }

            if (!TSSPro()->verifyNonce()) {
                return $post_id;
            }

            if (TSSPro()->shortCodePT != $post->post_type) {
                return $post_id;
            }

            $mates = TSSPro()->pfpScMetaFields();
            foreach ($mates as $metaKey => $field) {
                $rValue = !empty($_REQUEST[$metaKey]) ? $_REQUEST[$metaKey] : null; // sanitize data in the next line
                $value = TSSPro()->sanitize($field, $rValue);
                if (empty($field['multiple'])) {
                    update_post_meta($post_id, $metaKey, $value);
                } else {
                    delete_post_meta($post_id, $metaKey);
                    if (is_array($value) && !empty($value)) {
                        foreach ($value as $item) {
                            add_post_meta($post_id, $metaKey, $item);
                        }
                    } else {
                        update_post_meta($post_id, $metaKey, "");
                    }
                }
            }

            // save current tab
            $sc_tab = isset( $_REQUEST['_rtts_sc_tab'] ) ? sanitize_text_field( $_REQUEST['_rtts_sc_tab'] )  : '';
            update_post_meta($post_id, '_rtts_sc_tab', $sc_tab);

        }

        function admin_enqueue_scripts_sc() {
            global $pagenow, $typenow;
            // validate page
            if (!in_array($pagenow, array('post.php', 'post-new.php', 'edit.php'))) {
                return;
            }

            if ($typenow != TSSPro()->shortCodePT) {
                return;
            }

            wp_enqueue_media();
            // scripts
            wp_enqueue_script(array(
                'jquery',
                'wp-color-picker',
                'tss-select2',
                'swiper',
                'tss-image-load',
                'tss-isotope',
                'tss-admin-preview',
                'tss-admin-sc',
                'tss-admin',
            ));

            // styles
            wp_enqueue_style(array(
                'wp-color-picker',
                'tss-fontawsome',
                'tss-select2',
                'swiper',
                'tss-admin',
                'tss',
            ));

            //when change dmeo url, change, Carousel 1 url line 177
            $demo_url = 'https://www.radiustheme.com/demo/plugins/testimonial-slider/';
            $layout_group = [
				'grid' => [
					[
                        'name' => 'Layout 1',
                        'value' => 'layout1',
                        'img' => TSSPro()->assetsUrl . 'images/layouts/layout1.png',
                        'demo' => $demo_url . 'grid-layout-1',
                    ],
					[
                        'name' => 'Layout 2',
                        'value' => 'layout2',
                        'img' => TSSPro()->assetsUrl . 'images/layouts/layout2.png',
                        'demo' => $demo_url . 'grid-layout-2',
                    ],
				],
                'slider' => [
                    [
                        'name' => 'Carousel 1',
                        'value' => 'carousel1',
                        'img' => TSSPro()->assetsUrl . 'images/layouts/carousel1.png',
                        'demo' => $demo_url . 'slider-1',
                    ],
                    [
                        'name' => 'Carousel 3',
                        'value' => 'carousel3',
                        'img' => TSSPro()->assetsUrl . 'images/layouts/carousel3.png',
                        'demo' => $demo_url . 'slider-2',
                    ],
				],
			];

            $layout_group = apply_filters('rtts_layout_groups', $layout_group);

            wp_localize_script('tss-admin', 'tss', array(
                'ajaxurl' => admin_url('admin-ajax.php '),
                'nonce'   => wp_create_nonce(TSSPro()->nonceText()),
                'nonceId' => TSSPro()->nonceId(),
            ));

            $layout = get_post_meta( get_the_ID(), 'tss_layout', true);

            if ( !$layout ) {
                $layout = 'layout1';
            }

            wp_localize_script('tss-admin-sc', 'tss_layout', array(
                'layout_group' => $layout_group,
                'layout' => $layout ,
            ));
        }
    }
endif;

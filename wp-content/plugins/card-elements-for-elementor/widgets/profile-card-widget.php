<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit;      // Exit if accessed directly

class Profile_Card_Elementor_Widget extends Widget_Base {

    //Function for get the slug of the element name.
    public function get_name() {
        return 'profile-card-elementor-widget';
    }

    //Function for get the name of the element.
    public function get_title() {
        return __('Profile Card', CEE_DOMAIN);
    }

    //Function for get the icon of the element.
    public function get_icon() {
        return 'eicon-icon-box';
    }

    //Function for include element into the category.
    public function get_categories() {
        return ['card-elements'];
    }

    /*
     * Adding the controls fields for the Card Elements
     */

    protected function _register_controls() {

        /*
         * Start profile card controls fields
         */
        $this->start_controls_section(
                'section_items_data', array(
            'label' => esc_html__('Profile Card Items', CEE_DOMAIN),
                )
        );

        $this->add_control(
                'profile_card_style', [
            'label' => __('Profile Card Style', CEE_DOMAIN),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'profile-card-style-1' => esc_html__('Card Style 1', CEE_DOMAIN),
                'profile-card-style-2' => esc_html__('Card Style 2', CEE_DOMAIN),
                'profile-card-style-3' => esc_html__('Card Style 3', CEE_DOMAIN),
                'profile-card-style-4' => esc_html__('Card Style 4', CEE_DOMAIN),
                'profile-card-style-5' => esc_html__('Card Style 5', CEE_DOMAIN),
                'profile-card-style-6' => esc_html__('Card Style 6 (PRO)', CEE_DOMAIN),
                'profile-card-style-7' => esc_html__('Card Style 7 (PRO)', CEE_DOMAIN),
                'profile-card-style-8' => esc_html__('Card Style 8 (PRO)', CEE_DOMAIN),
                'profile-card-style-9' => esc_html__('Card Style 9 (PRO)', CEE_DOMAIN),
                'profile-card-style-10' => esc_html__('Card Style 10 (PRO)', CEE_DOMAIN),
                'profile-card-style-11' => esc_html__('Card Style 11', CEE_DOMAIN),
            ],
            'default' => 'profile-card-style-1',
                ]
        );

        $this->add_control(
                'name', [
            'label' => __('Name', CEE_DOMAIN),
            'type' => Controls_Manager::TEXT,
            'default' => __('John Doe', CEE_DOMAIN),
            'placeholder' => __('Enter your name', CEE_DOMAIN),
                ]
        );

        $this->add_control(
                'position', [
            'label' => __('Position', CEE_DOMAIN),
            'type' => Controls_Manager::TEXT,
            'default' => __('Developer', CEE_DOMAIN),
            'placeholder' => __('Developer', CEE_DOMAIN),
                ]
        );

        $this->add_control(
                'display_profile_description', [
            'label' => __('Display Profile Description', CEE_DOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __('Show', CEE_DOMAIN),
            'label_off' => __('Hide', CEE_DOMAIN),
            'condition' => [
                'profile_card_style' => [
                    'profile-card-style-1',
                    'profile-card-style-2',
                    'profile-card-style-3',
                    'profile-card-style-4',
                    'profile-card-style-5'
                ],
            ],
                ]
        );

        $this->add_control(
                'profile_description', array(
            'label' => esc_html__('Description', CEE_DOMAIN),
            'type' => Controls_Manager::TEXTAREA,
            'condition' => [
                'display_profile_description' => 'yes',
                'profile_card_style' => [
                    'profile-card-style-1',
                    'profile-card-style-2',
                    'profile-card-style-3',
                    'profile-card-style-4',
                    'profile-card-style-5'
                ],
            ],
            'default' => __('Lorem ipsum dolor sit amet, consectetur adipisci ng elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', CEE_DOMAIN),
                )
        );

        $this->add_control(
                'profile_image', [
            'label' => __('Profile Image', CEE_DOMAIN),
            'type' => Controls_Manager::MEDIA,
            'dynamic' => [
                'active' => true,
            ],
            'default' => [
                'url' => Utils::get_placeholder_image_src(),
            ],
                ]
        );

        $this->add_control(
                'profile_background_image', [
            'label' => __('Profile Background Image', CEE_DOMAIN),
            'type' => Controls_Manager::MEDIA,
            'dynamic' => [
                'active' => true,
            ],
            'condition' => [
                'profile_card_style' => [
                    'profile-card-style-1',
                    'profile-card-style-2',
                    'profile-card-style-3',
                    'profile-card-style-4',
                    'profile-card-style-5'
                ]
            ],
            'default' => [
                'url' => Utils::get_placeholder_image_src(),
            ],
                ]
        );

        $this->end_controls_section();
        /*
         * End profile card controls fields
         */

        /*
         * Start Social Media control for profile card
         */
        $this->start_controls_section(
                'section_social_media', array(
            'label' => esc_html__('Social Media', CEE_DOMAIN),
                )
        );

        $this->add_control(
                'display_social_icon', [
            'label' => __('Display Social Icon', CEE_DOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __('Show', CEE_DOMAIN),
            'label_off' => __('Hide', CEE_DOMAIN),
                ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
                'social', [
            'label' => __('Icon', CEE_DOMAIN),
            'type' => Controls_Manager::ICON,
            'label_block' => true,
            'default' => 'fab fa-wordpress',
            'include' => [
                'fab fa-android',
                'fab fa-apple',
                'fab fa-behance',
                'fab fa-bitbucket',
                'fab fa-codepen',
                'fab fa-delicious',
                'fab fa-deviantart',
                'fab fa-digg',
                'fab fa-dribbble',
                'fab fa-envelope',
                'fab fa-facebook',
                'fab fa-flickr',
                'fab fa-foursquare',
                'fab fa-free-code-camp',
                'fab fa-github',
                'fab fa-gitlab',
                'fab fa-globe',
                'fab fa-google-plus',
                'fab fa-houzz',
                'fab fa-instagram',
                'fab fa-jsfiddle',
                'fab fa-link',
                'fab fa-linkedin',
                'fab fa-medium',
                'fab fa-meetup',
                'fab fa-mixcloud',
                'fab fa-odnoklassniki',
                'fab fa-pinterest',
                'fab fa-product-hunt',
                'fab fa-reddit',
                'fab fa-rss',
                'fab fa-shopping-cart',
                'fab fa-skype',
                'fab fa-slideshare',
                'fab fa-snapchat',
                'fab fa-soundcloud',
                'fab fa-spotify',
                'fab fa-stack-overflow',
                'fab fa-steam',
                'fab fa-stumbleupon',
                'fab fa-telegram',
                'fab fa-thumb-tack',
                'fab fa-tripadvisor',
                'fab fa-tumblr',
                'fab fa-twitch',
                'fab fa-twitter',
                'fab fa-vimeo',
                'fab fa-vk',
                'fab fa-weibo',
                'fab fa-weixin',
                'fab fa-whatsapp',
                'fab fa-wordpress',
                'fab fa-xing',
                'fab fa-yelp',
                'fab fa-youtube',
                'fab fa-500px',
            ],
                ]
        );

        $repeater->add_control(
                'link', [
            'label' => __('Link', CEE_DOMAIN),
            'type' => Controls_Manager::URL,
            'label_block' => true,
            'default' => [
                'is_external' => 'true',
            ],
            'placeholder' => __('https://your-link.com', CEE_DOMAIN),
                ]
        );

        $this->add_control(
                'social_icon_list', [
            'label' => __('Social Icons', CEE_DOMAIN),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'condition' => [
                'display_social_icon' => 'yes',
            ],
            'default' => [
                [
                    'social' => 'fab fa-facebook',
                ],
                [
                    'social' => 'fab fa-twitter',
                ],
                [
                    'social' => 'fab fa-google-plus',
                ],
                [
                    'social' => 'fab fa-wordpress',
                ],
            ],
            'title_field' => '<i class="{{ social }}"></i> {{{ social.replace( \'fab fa-\', \'\' ).replace( \'-\', \' \' ).replace( /\b\w/g, function( letter ){ return letter.toUpperCase() } ) }}}',
                ]
        );

        $this->add_control(
                'shape', [
            'label' => __('Shape', CEE_DOMAIN),
            'type' => Controls_Manager::SELECT,
            'default' => 'rounded',
            'options' => [
                'rounded' => __('Rounded', CEE_DOMAIN),
                'square' => __('Square', CEE_DOMAIN),
                'circle' => __('Circle', CEE_DOMAIN),
            ],
            'prefix_class' => 'elementor-shape-',
                ]
        );

        $this->add_responsive_control(
                'social_icon_align', [
            'label' => __('Alignment', CEE_DOMAIN),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', CEE_DOMAIN),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', CEE_DOMAIN),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', CEE_DOMAIN),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'default' => 'center',
            'selectors' => [
                '{{WRAPPER}} .elementor-social-icons-wrapper' => 'text-align: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_section();
        /*
         * End Social Media control for profile card
         */

        /*
         * Start control style tab for profile card
         * Start name control style
         */
        $this->start_controls_section(
                'section_profile_name', [
            'label' => __('Name', CEE_DOMAIN),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_responsive_control(
                'name_text_align', [
            'label' => __('Alignment', CEE_DOMAIN),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', CEE_DOMAIN),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', CEE_DOMAIN),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', CEE_DOMAIN),
                    'icon' => 'fa fa-align-right',
                ],
                'justify' => [
                    'title' => __('Justified', CEE_DOMAIN),
                    'icon' => 'fa fa-align-justify',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-profile-name-wrapper,
				 {{WRAPPER}} .profile-card-style-11 .name' => 'text-align: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'name_color', [
            'label' => __('Text Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-profile-name-wrapper,
				{{WRAPPER}} .profile-card-style-11 .name' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'typography_name',
            'selector' => '{{WRAPPER}} .elementor-profile-name-wrapper,
						{{WRAPPER}} .profile-card-style-11 .name',
                ]
        );

        $this->end_controls_section();
        /*
         * End control style tab for profile card
         */

        /*
         * Start position control style
         */
        $this->start_controls_section(
                'section_profile_position', [
            'label' => __('Designation', CEE_DOMAIN),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_responsive_control(
                'position_text_align', [
            'label' => __('Alignment', CEE_DOMAIN),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', CEE_DOMAIN),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', CEE_DOMAIN),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', CEE_DOMAIN),
                    'icon' => 'fa fa-align-right',
                ],
                'justify' => [
                    'title' => __('Justified', CEE_DOMAIN),
                    'icon' => 'fa fa-align-justify',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-profile-position-wrapper,
		{{WRAPPER}} .profile-card-style-11 .position' => 'text-align: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'position_color', [
            'label' => __('Text Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-profile-position-wrapper,
		{{WRAPPER}} .profile-card-style-11 .position' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'typography_position',
            'selector' => '{{WRAPPER}} .elementor-profile-position-wrapper,
                            {{WRAPPER}} .profile-card-style-11 .position',
                ]
        );

        $this->end_controls_section();

        /*
         * Start desription control style
         */
        $this->start_controls_section(
                'section_profile_description', [
            'label' => __('Description', CEE_DOMAIN),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'profile_card_style' => [
                    'profile-card-style-1',
                    'profile-card-style-2',
                    'profile-card-style-3',
                    'profile-card-style-4',
                    'profile-card-style-5'
                ]
            ]
                ]
        );

        $this->add_responsive_control(
                'description_text_align', [
            'label' => __('Alignment', CEE_DOMAIN),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', CEE_DOMAIN),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', CEE_DOMAIN),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', CEE_DOMAIN),
                    'icon' => 'fa fa-align-right',
                ],
                'justify' => [
                    'title' => __('Justified', CEE_DOMAIN),
                    'icon' => 'fa fa-align-justify',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-profile-description-wrapper' => 'text-align: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'description_color', [
            'label' => __('Text Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-profile-description-wrapper' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'typography_description',
            'selector' => '{{WRAPPER}} .elementor-profile-description-wrapper',
                ]
        );

        $this->end_controls_section();


        /*
         * Start content background control style
         */
        $this->start_controls_section(
                'section_content_background_style', [
            'label' => __('Content Box Style', CEE_DOMAIN),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'profile_card_style' => [
                    'profile-card-style-1',
                    'profile-card-style-2',
                    'profile-card-style-3',
                    'profile-card-style-4',
                    'profile-card-style-5'
                ]
            ]
                ]
        );

        $this->add_control(
                'content_background_color', [
            'label' => __('Background Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-content-background-color-wrapper' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_section();
        /*
         * End content background control style
         */

        /*
         * Start social media control style
         */
        $this->start_controls_section(
                'section_social_style', [
            'label' => __('Social Icon', CEE_DOMAIN),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'content_social_background_color', [
            'label' => __('Social Area Background Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'condition' => [
                'profile_card_style' => ['profile-card-style-1', 'profile-card-style-2', 'profile-card-style-11'],
            ],
            'selectors' => [
                '{{WRAPPER}} .team-member__socialmedia' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'icon_color', [
            'label' => __('Social Color', CEE_DOMAIN),
            'type' => Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default' => __('Official Color', CEE_DOMAIN),
                'custom' => __('Custom', CEE_DOMAIN),
            ],
                ]
        );

        $this->add_control(
                'icon_primary_color', [
            'label' => __('Primary Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'condition' => [
                'icon_color' => 'custom',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-social-icon:not(:hover)' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'icon_secondary_color', [
            'label' => __('Secondary Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'condition' => [
                'icon_color' => 'custom',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-social-icon:not(:hover) i' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'icon_size', [
            'label' => __('Size', CEE_DOMAIN),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 6,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-social-icon' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'icon_padding', [
            'label' => __('Padding', CEE_DOMAIN),
            'type' => Controls_Manager::SLIDER,
            'selectors' => [
                '{{WRAPPER}} .elementor-social-icon' => 'padding: {{SIZE}}{{UNIT}};',
            ],
            'default' => [
                'unit' => 'em',
            ],
            'tablet_default' => [
                'unit' => 'em',
            ],
            'mobile_default' => [
                'unit' => 'em',
            ],
            'range' => [
                'em' => [
                    'min' => 0,
                    'max' => 5,
                ],
            ],
                ]
        );

        $icon_spacing = is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}};' : 'margin-right: {{SIZE}}{{UNIT}};';

        $this->add_responsive_control(
                'icon_spacing', [
            'label' => __('Spacing', CEE_DOMAIN),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'condition' => [
                'profile_card_style' => [
                    'profile-card-style-3',
                    'profile-card-style-4',
                    'profile-card-style-5'
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-social-icon:not(:last-child)' => $icon_spacing,
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'image_border', // We know this mistake - TODO: 'icon_border' (for hover control condition also)
            'selector' => '{{WRAPPER}} .elementor-social-icon',
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'border_radius', [
            'label' => __('Border Radius', CEE_DOMAIN),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->end_controls_section();
        /*
         * End social media control style
         */

        /*
         * Start socail media hover control style
         */
        $this->start_controls_section(
                'section_social_hover', [
            'label' => __('Social Icon Hover', CEE_DOMAIN),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'hover_primary_color', [
            'label' => __('Primary Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'condition' => [
                'icon_color' => 'custom',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-social-icon:hover' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'hover_secondary_color', [
            'label' => __('Secondary Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'condition' => [
                'icon_color' => 'custom',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-social-icon:hover i' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'hover_border_color', [
            'label' => __('Border Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'condition' => [
                'image_border_border!' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-social-icon:hover' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'hover_animation', [
            'label' => __('Hover Animation', CEE_DOMAIN),
            'type' => Controls_Manager::HOVER_ANIMATION,
                ]
        );

        $this->end_controls_section();

        /* start section */
        $this->start_controls_section(
                'section_background_style', [
            'label' => __('Content Background Color', CEE_DOMAIN),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'profile_card_style' => [
                    'profile-card-style-11'
                ]
            ]
                ]
        );

        $this->add_control(
                'name_background_color', [
            'label' => __('Name', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .profile-card-style-11 .name' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'position_background_color', [
            'label' => __('Position', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .profile-card-style-11 .position' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
                'triangle_background_style', [
            'label' => __('Triangle Color', CEE_DOMAIN),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'profile_card_style' => [
                    'profile-card-style-11'
                ]
            ]
                ]
        );

        $this->add_control(
                'triangle_background_color', [
            'label' => __('Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .profile-card-style-11 .triangle-div' => 'border-top: solid 30px {{VALUE}}; border-left: solid 30px {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_section();
        /*
         * End control style tab for profile card
         */
    }

    /**
     * Render Card Elements widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @access protected
     */
    protected function render() {

        $settings = $this->get_settings_for_display();

        $class_animation = '';

        if (!empty($settings['hover_animation'])) {
            $class_animation = ' elementor-animation-' . $settings['hover_animation'];
        }

        switch ($settings['profile_card_style']) {
            case 'profile-card-style-1':
                include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/profile-card/elementor-profile-card-1.php';  // Card Style 1
                break;
            case 'profile-card-style-2':
                include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/profile-card/elementor-profile-card-2.php';  // Card Style 2
                break;
            case 'profile-card-style-3':
                include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/profile-card/elementor-profile-card-3.php';  // Card Style 3
                break;
            case 'profile-card-style-4':
                include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/profile-card/elementor-profile-card-4.php';  // Card Style 4
                break;
            case 'profile-card-style-5':
                include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/profile-card/elementor-profile-card-5.php';  // Card Style 5
                break;
            case 'profile-card-style-6':
                include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/profile-card/elementor-profile-card-pro.php';  // Card Style pro
                break;
            case 'profile-card-style-7':
                include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/profile-card/elementor-profile-card-pro.php';  // Card Style pro
                break;
            case 'profile-card-style-8':
                include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/profile-card/elementor-profile-card-pro.php';  // Card Style pro
                break;
            case 'profile-card-style-9':
                include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/profile-card/elementor-profile-card-pro.php';  // Card Style pro
                break;
            case 'profile-card-style-10':
                include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/profile-card/elementor-profile-card-pro.php';  // Card Style pro
                break;
            case 'profile-card-style-11':
                include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/profile-card/elementor-profile-card-11.php';  // Card Style 11
                break;
            default:
                include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/profile-card/elementor-profile-card-1.php';  // Default Card Style 1
                break;
        }
    }

}

Plugin::instance()->widgets_manager->register_widget_type(new Profile_Card_Elementor_Widget());

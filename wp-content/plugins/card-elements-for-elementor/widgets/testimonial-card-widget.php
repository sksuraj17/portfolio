<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit;      // Exit if accessed directly

class Testimonial_Card_Elementor_Widget extends Widget_Base {

    //Function for get the slug of the element name.
    public function get_name() {
        return 'testimonial-card-elementor-widget';
    }

    //Function for get the name of the element.
    public function get_title() {
        return __('Testimonial Card', CEE_DOMAIN);
    }

    //Function for get the icon of the element.
    public function get_icon() {
        return 'eicon-testimonial';
    }

    //Function for include element into the category.
    public function get_categories() {
        return ['card-elements'];
    }

    /*
     * Adding the controls fields for the testimonial card
     */

    protected function _register_controls() {

        /*
         * Start testimonial card controls fields
         */
        $this->start_controls_section(
                'section_items_data', array(
            'label' => esc_html__('Testimonial Card Items', CEE_DOMAIN),
                )
        );


        $this->add_control(
                'testimonial_card_style', [
            'label' => __('Testimonial Card Style', CEE_DOMAIN),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'testimonial-card-style-1' => esc_html__('Card Style 1', CEE_DOMAIN),
                'testimonial-card-style-2' => esc_html__('Card Style 2', CEE_DOMAIN),
				'testimonial-card-style-3' => esc_html__('Card Style 3 (PRO)', CEE_DOMAIN),
				'testimonial-card-style-4' => esc_html__('Card Style 4 (PRO)', CEE_DOMAIN),
				'testimonial-card-style-5' => esc_html__('Card Style 5 (PRO)', CEE_DOMAIN),
				'testimonial-card-style-6' => esc_html__('Card Style 6', CEE_DOMAIN),
            ],
            'default' => 'testimonial-card-style-1',
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
            'label' => __('Designation', CEE_DOMAIN),
            'type' => Controls_Manager::TEXT,
            'default' => __('Founder', CEE_DOMAIN),
            'placeholder' => __('Founder', CEE_DOMAIN),
                ]
        );

        $this->add_control(
                'display_testimonial_description', [
            'label' => __('Display Testimonial Description', CEE_DOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __('Show', CEE_DOMAIN),
            'label_off' => __('Hide', CEE_DOMAIN),
                ]
        );

        $this->add_control(
                'testimonial_description', array(
            'label' => esc_html__('Description', CEE_DOMAIN),
            'type' => Controls_Manager::TEXTAREA,
            'condition' => [
                'display_testimonial_description' => 'yes',
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
                'testimonial_card_style' => ['testimonial-card-style-none'],
            ],
            'default' => [
                'url' => Utils::get_placeholder_image_src(),
            ],
                ]
        );

        $this->end_controls_section();
        /*
         * End testimonial card controls fields
         */
        $this->start_controls_section(
                'section_rating', [
            'label' => __('Rating', CEE_DOMAIN),
			'condition' => [
                'testimonial_card_style' => ['testimonial-card-style-1'],
				'testimonial_card_style' => ['testimonial-card-style-2'],
            ]
            ]
        );

        $this->add_control(
                'rating_scale', [
            'label' => __('Rating Scale', CEE_DOMAIN),
            'type' => Controls_Manager::SELECT,
            'options' => [
                '5' => '0-5',
                '10' => '0-10',
            ],
            'default' => '5',
                ]
        );

        $this->add_control(
                'rating', [
            'label' => __('Rating', CEE_DOMAIN),
            'type' => Controls_Manager::NUMBER,
            'min' => 0,
            'max' => 10,
            'step' => 0.1,
            'default' => 5,
                ]
        );

        $this->add_control(
                'star_style', [
            'label' => __('Icon', CEE_DOMAIN),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'star_fontawesome' => 'Font Awesome',
                'star_unicode' => 'Unicode',
            ],
            'default' => 'star_fontawesome',
            'render_type' => 'template',
            'prefix_class' => 'elementor--star-style-',
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'unmarked_star_style', [
            'label' => __('Unmarked Style', CEE_DOMAIN),
            'type' => Controls_Manager::CHOOSE,
            'label_block' => false,
            'options' => [
                'solid' => [
                    'title' => __('Solid', CEE_DOMAIN),
                    'icon' => 'fab fa-star',
                ],
                'outline' => [
                    'title' => __('Outline', CEE_DOMAIN),
                    'icon' => 'fab fa-star-o',
                ],
            ],
            'default' => 'solid',
                ]
        );

        $this->add_control(
                'title', [
            'label' => __('Title', CEE_DOMAIN),
            'type' => Controls_Manager::TEXT,
            'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'align', [
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
            'prefix_class' => 'elementor-star-rating--align-',
            'selectors' => [
                '{{WRAPPER}}' => 'text-align: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_section();

        /*
         * Start control style tab for testimonial card
         * Start name control style
         */
        $this->start_controls_section(
                'section_testimonial_name', [
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
                '{{WRAPPER}} .elementor-testimonial-name-wrapper,
				 {{WRAPPER}} .testimonial6 .name' => 'text-align: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'name_color', [
            'label' => __('Text Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-testimonial-name-wrapper,
				{{WRAPPER}} .testimonial6 .name' => 'color: {{VALUE}};',
				'{{WRAPPER}} .testimonial6 .pic' => 'border: 4px solid {{VALUE}}',
                '{{WRAPPER}} .testimonial6 .description' => 'border-bottom: 4px solid {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'typography_name',
            'selector' => '{{WRAPPER}} .elementor-testimonial-name-wrapper,
						{{WRAPPER}} .testimonial6 .name',
                ]
        );

        $this->end_controls_section();

        /*
         * Start position control style
         */
        $this->start_controls_section(
                'section_testimonial_position', [
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
                '{{WRAPPER}} .elementor-testimonial-position-wrapper,
				{{WRAPPER}} .testimonial6 .post' => 'text-align: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'position_color', [
            'label' => __('Text Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-testimonial-position-wrapper,
				 {{WRAPPER}} .testimonial6 .post' => 'color: {{VALUE}};',
				'{{WRAPPER}} .testimonial6 .pic,
                 {{WRAPPER}} .testimonial6 .description' => 'box-shadow: 0 7px rgba(0, 0, 0, 0.1), 0 5px {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'typography_position',
            'selector' => '{{WRAPPER}} .elementor-testimonial-position-wrapper,
						   {{WRAPPER}} .testimonial6 .post',
                ]
        );

        $this->end_controls_section();

        /*
         * Start desription control style
         */
        $this->start_controls_section(
                'section_testimonial_description', [
            'label' => __('Description', CEE_DOMAIN),
            'tab' => Controls_Manager::TAB_STYLE,
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
                '{{WRAPPER}} .elementor-testimonial-description-wrapper,
				 {{WRAPPER}} .testimonial6 .description' => 'text-align: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'description_color', [
            'label' => __('Text Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-testimonial-description-wrapper,
				 {{WRAPPER}} .testimonial6 .description' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'typography_description',
            'selector' => '{{WRAPPER}} .elementor-testimonial-description-wrapper,
						   {{WRAPPER}} .testimonial6 .description',
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
                'testimonial_card_style' => ['testimonial-card-style-1'],
            ]
                ]
        );

        $this->add_control(
                'content_background_color', [
            'label' => __('Background Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'condition' => [
                'testimonial_card_style' => ['testimonial-card-style-1'],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-content-background-color-wrapper' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_title_style', [
            'label' => __('Title', CEE_DOMAIN),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'title!' => '',
            ],
                ]
        );

        $this->add_control(
                'title_color', [
            'label' => __('Text Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-star-rating__title' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .elementor-star-rating__title',
                ]
        );

        $this->add_responsive_control(
                'title_gap', [
            'label' => __('Gap', CEE_DOMAIN),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 50,
                ],
            ],
            'selectors' => [
                'body:not(.rtl) {{WRAPPER}}:not(.elementor-star-rating--align-justify) .elementor-star-rating__title' => 'margin-right: {{SIZE}}{{UNIT}}',
                'body.rtl {{WRAPPER}}:not(.elementor-star-rating--align-justify) .elementor-star-rating__title' => 'margin-left: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_stars_style', [
            'label' => __('Stars', CEE_DOMAIN),
            'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
                'testimonial_card_style' => ['testimonial-card-style-1'],
				'testimonial_card_style' => ['testimonial-card-style-2'],
            ]
            ]
        );

        $this->add_responsive_control(
                'icon_size', [
            'label' => __('Size', CEE_DOMAIN),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-star-rating' => 'font-size: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_responsive_control(
                'icon_space', [
            'label' => __('Spacing', CEE_DOMAIN),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 50,
                ],
            ],
            'selectors' => [
                'body:not(.rtl) {{WRAPPER}} .elementor-star-rating i:not(:last-of-type)' => 'margin-right: {{SIZE}}{{UNIT}}',
                'body.rtl {{WRAPPER}} .elementor-star-rating i:not(:last-of-type)' => 'margin-left: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_control(
                'stars_color', [
            'label' => __('Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-star-rating i:before' => 'color: {{VALUE}}',
            ],
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'stars_unmarked_color', [
            'label' => __('Unmarked Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-star-rating i' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_section();

        /*
         * End control style tab for testimonial card
         */
    }

    /**
     * @since 1.0.0
     * @access protected
     */
    protected function get_rating() {
        $settings = $this->get_settings_for_display();
        $rating_scale = (int) $settings['rating_scale'];
        $rating = (float) $settings['rating'] > $rating_scale ? $rating_scale : $settings['rating'];

        return [$rating, $rating_scale];
    }

    /**
     * @since 1.0.0
     * @access protected
     */
    protected function render_stars($icon) {
        $rating_data = $this->get_rating();
        $rating = $rating_data[0];
        $floored_rating = (int) $rating;
        $stars_html = '';

        for ($stars = 1; $stars <= $rating_data[1]; $stars++) {
            if ($stars <= $floored_rating) {
                $stars_html .= '<i class="elementor-star-full">' . $icon . '</i>';
            } elseif ($floored_rating + 1 === $stars && $rating !== $floored_rating) {
                $stars_html .= '<i class="elementor-star-' . ( $rating - $floored_rating ) * 10 . '">' . $icon . '</i>';
            } else {
                $stars_html .= '<i class="elementor-star-empty">' . $icon . '</i>';
            }
        }

        return $stars_html;
    }

    /**
     * Render testimonial card widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @access protected
     */
    protected function render() {

        $settings = $this->get_settings_for_display();


        $rating_data = $this->get_rating();
        $textual_rating = $rating_data[0] . '/' . $rating_data[1];
        $icon = '&#61445;';

        if ('star_fontawesome' === $settings['star_style']) {
            if ('outline' === $settings['unmarked_star_style']) {
                $icon = '&#61446;';
            }
        } elseif ('star_unicode' === $settings['star_style']) {
            $icon = '&#9733;';

            if ('outline' === $settings['unmarked_star_style']) {
                $icon = '&#9734;';
            }
        }

        $this->add_render_attribute('icon_wrapper', [
            'class' => 'elementor-star-rating',
            'title' => $textual_rating,
            'itemtype' => 'http://schema.org/Rating',
            'itemscope' => '',
            'itemprop' => 'reviewRating',
        ]);

        $schema_rating = '<span itemprop="ratingValue" class="elementor-screen-only">' . $textual_rating . '</span>';
        $stars_element = '<div ' . $this->get_render_attribute_string('icon_wrapper') . '>' . $this->render_stars($icon) . ' ' . $schema_rating . '</div>';

        switch ($settings['testimonial_card_style']) {
            case 'testimonial-card-style-1':
                include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/testimonial-card/elementor-testimonial-card-1.php';  // Card Style 1
                break;
            case 'testimonial-card-style-2':
                include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/testimonial-card/elementor-testimonial-card-2.php';  // Card Style 2
                break;
			case 'testimonial-card-style-3':
                include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/testimonial-card/elementor-testimonial-card-pro.php';  // Card Style pro
                break;
			case 'testimonial-card-style-4':
                include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/testimonial-card/elementor-testimonial-card-pro.php';  // Card Style pro
                break;
			case 'testimonial-card-style-5':
                include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/testimonial-card/elementor-testimonial-card-pro.php';  // Card Style pro
                break;
			case 'testimonial-card-style-6':
                include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/testimonial-card/elementor-testimonial-card-6.php';  // Card Style 6
                break;
            default:
                include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/testimonial-card/elementor-testimonial-card-1.php';  // Default Card Style 1
                break;
        }
    }

}

Plugin::instance()->widgets_manager->register_widget_type(new Testimonial_Card_Elementor_Widget());

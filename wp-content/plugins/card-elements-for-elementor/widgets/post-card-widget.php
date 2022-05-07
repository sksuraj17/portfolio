<?php

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Base;
use ElementorPro\Classes\Utils;
use ElementorPro\Modules\QueryControl\Module;

if (!defined('ABSPATH'))
    exit;      // Exit if accessed directly

class Post_Card_Elementor_Widget extends Widget_Base {

    //Function for get the slug of the element name.
    public function get_name() {
        return 'post-card-elementor-widget';
    }

    //Function for get the name of the element.
    public function get_title() {
        return __('Post Card', CEE_DOMAIN);
    }

    //Function for get the icon of the element.
    public function get_icon() {
        return 'eicon-gallery-grid';
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
         * Start post card controls fields
         */
        $this->start_controls_section(
                'section_layout', array(
            'label' => esc_html__('Post Layout', CEE_DOMAIN),
                )
        );

        $this->add_control(
                'post_card_style', [
            'label' => __('Post Card Style', CEE_DOMAIN),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'post-card-style-1' => esc_html__('Card Style 1', CEE_DOMAIN),
                'post-card-style-2' => esc_html__('Card Style 2', CEE_DOMAIN),
                'post-card-style-3' => esc_html__('Card Style 3 (PRO)', CEE_DOMAIN),
                'post-card-style-4' => esc_html__('Card Style 4 (PRO)', CEE_DOMAIN),
                'post-card-style-5' => esc_html__('Card Style 5 (PRO)', CEE_DOMAIN),
                'post-card-style-6' => esc_html__('Card Style 6', CEE_DOMAIN),
            ],
            'default' => 'post-card-style-1',
                ]
        );

        $this->add_responsive_control(
                'post_card_columns', [
            'label' => __('Columns', CEE_DOMAIN),
            'type' => Controls_Manager::SELECT,
            'default' => '3',
            'tablet_default' => '2',
            'mobile_default' => '1',
            'options' => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
            ],
            'prefix_class' => 'elementor-grid%s-',
            'frontend_available' => true,
            'selectors' => [
                '.elementor-msie {{WRAPPER}} .elementor-post-item' => 'width: calc( 100% / {{SIZE}} )',
            ],
                ]
        );

        $this->add_control(
                'number_of_posts', [
            'label' => __('Display No. of Posts', CEE_DOMAIN),
            'type' => Controls_Manager::NUMBER,
            'default' => 6,
                ]
        );

        $this->add_group_control(
                Group_Control_Image_Size::get_type(), [
            'name' => 'post_image_size',
            'exclude' => ['custom'],
            'default' => 'medium_large',
                ]
        );

        $this->add_control(
                'show_title', [
            'label' => __('Show Title', CEE_DOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_off' => __('Off', CEE_DOMAIN),
            'label_on' => __('On', CEE_DOMAIN),
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'title_tag', [
            'label' => __('Title HTML Tag', CEE_DOMAIN),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'h1' => 'H1',
                'h2' => 'H2',
                'h3' => 'H3',
                'h4' => 'H4',
                'h5' => 'H5',
                'h6' => 'H6',
                'div' => 'div',
                'span' => 'span',
                'p' => 'p',
            ],
            'default' => 'h2',
            'condition' => [
                'show_title' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'show_excerpt', [
            'label' => __('Excerpt', CEE_DOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', CEE_DOMAIN),
            'label_off' => __('Hide', CEE_DOMAIN),
            'default' => 'yes',
                ]
        );

        $this->add_control(
                'excerpt_length', [
            'label' => __('Excerpt Length', CEE_DOMAIN),
            'type' => Controls_Manager::NUMBER,
            'default' => apply_filters('excerpt_length', 25),
            'condition' => ['show_excerpt' => 'yes'],
                ]
        );
        $this->add_control(
                'excerpt_from', [
            'label' => __('Excerpt From', CEE_DOMAIN),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'content' => 'Content',
                'excerpt' => 'Excerpt',
            ],
            'default' => 'content',
            'condition' => [
                'show_excerpt' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'show_read_more', [
            'label' => __('Read More', CEE_DOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', CEE_DOMAIN),
            'label_off' => __('Hide', CEE_DOMAIN),
            'default' => 'yes',
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'read_more_text', [
            'label' => __('Read More Text', CEE_DOMAIN),
            'type' => Controls_Manager::TEXT,
            'default' => __('Read More »', CEE_DOMAIN),
            'condition' => ['show_read_more' => 'yes'],
                ]
        );

        $this->add_control(
                'show_meta_data', [
            'label' => __('Show Meta Data', CEE_DOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', CEE_DOMAIN),
            'label_off' => __('Hide', CEE_DOMAIN),
            'default' => 'yes',
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'meta_data', [
            'label' => __('Meta Data', CEE_DOMAIN),
            'label_block' => true,
            'type' => Controls_Manager::SELECT2,
            'default' => ['author', 'date', 'comments', 'tags', 'category'],
            'multiple' => true,
            'condition' => ['show_meta_data' => 'yes'],
            'options' => [
                'author' => __('Author', CEE_DOMAIN),
                'date' => __('Date', CEE_DOMAIN),
                'comments' => __('Comments', CEE_DOMAIN),
                'tags' => __('Tags', CEE_DOMAIN),
                'category' => __('Category', CEE_DOMAIN),
            ],
            'separator' => 'before',
                ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
                'section_post_query', array(
            'label' => esc_html__('Query', CEE_DOMAIN),
                )
        );

        $this->add_control(
                'blog_categories', [
            'label' => __('Categories', CEE_DOMAIN),
            'type' => Controls_Manager::SELECT2,
            'label_block' => true,
            'multiple' => true,
            'description' => __('Select the categories you want to show', CEE_DOMAIN),
            'options' => card_elements_post_categories(),
                ]
        );

        $this->add_control(
                'advanced', [
            'label' => __('Advanced', CEE_DOMAIN),
            'type' => Controls_Manager::HEADING,
                ]
        );

        $this->add_control(
                'post_card_orderby', [
            'label' => __('Order By', CEE_DOMAIN),
            'type' => Controls_Manager::SELECT,
            'default' => 'post_date',
            'options' => [
                'post_date' => __('Date', CEE_DOMAIN),
                'post_title' => __('Title', CEE_DOMAIN),
                'menu_order' => __('Menu Order', CEE_DOMAIN),
                'rand' => __('Random', CEE_DOMAIN),
            ],
                ]
        );

        $this->add_control(
                'post_sort_order', [
            'label' => __('Sort By', CEE_DOMAIN),
            'type' => Controls_Manager::SELECT,
            'default' => 'desc',
            'options' => [
                'asc' => __('ASC', CEE_DOMAIN),
                'desc' => __('DESC', CEE_DOMAIN),
            ],
                ]
        );

        $this->end_controls_section();
        /*
         * End post card control
         */


        /*
         * Start control style tab for post card
         * Start name control style
         */
        $this->start_controls_section(
                'section_design_layout', [
            'label' => __('Layout', CEE_DOMAIN),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );
        $this->add_control(
                'post_card_grid_gap', [
            'label' => __('Grid Gap', CEE_DOMAIN),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 30,
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'frontend_available' => true,
            'selectors' => [
                '{{WRAPPER}} .post-card-grid-gap' => 'grid-column-gap: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'post_card_row_gap', [
            'label' => __('Rows Gap', CEE_DOMAIN),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 35,
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'frontend_available' => true,
            'selectors' => [
                '{{WRAPPER}} .post-card-container,
				 {{WRAPPER}} .post-card-style-6' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'post_card_border_radius', [
            'label' => __('Border Radius', CEE_DOMAIN),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .post-card-box-radius' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [
                'post_card_style' => ['post-card-style-2', 'post-card-style-6']
            ],
                ]
        );

        $this->add_control(
                'alignment', [
            'label' => __('Alignment', CEE_DOMAIN),
            'type' => Controls_Manager::CHOOSE,
            'label_block' => false,
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
                    'title' => __('Justify', CEE_DOMAIN),
                    'icon' => 'fa fa-align-justify',
                ],
            ],
            'default' => 'left',
            'prefix_class' => 'elementor-posts--align-',
            'selectors' => [
                '{{WRAPPER}} .post-card-alignment,
				 {{WRAPPER}} .card_align,
				 {{WRAPPER}} .card-category,
                 {{WRAPPER}} .card_title' => 'text-align: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
                'section_design_image_layout', [
            'label' => __('Image', CEE_DOMAIN),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'post_card_style' => ['post-card-style-1', 'post-card-style-2'],
            ],
                ]
        );

        $this->add_control(
                'img_border_radius', [
            'label' => __('Border Radius', CEE_DOMAIN),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .post-card-item_img, {{WRAPPER}} .elementor-post-item__overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->start_controls_tabs(
                'thumbnail_effects_tabs', [
            'label' => __('Image Thumbnail', CEE_DOMAIN),
            'condition' => [
                'post_card_style' => ['post-card-style-1', 'post-card-style-2'],
            ]
                ]
        );

        $this->start_controls_tab('normal', [
            'label' => __('Normal', CEE_DOMAIN),
                ]
        );

        $this->add_group_control(
                Group_Control_Css_Filter::get_type(), [
            'name' => 'thumbnail_filters',
            'condition' => [
                'post_card_style' => ['post-card-style-1', 'post-card-style-2'],
            ],
            'selector' => '{{WRAPPER}} .post-card_thumbnail img',
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('hover', [
            'label' => __('Hover', CEE_DOMAIN),
                ]
        );

        $this->add_group_control(
                Group_Control_Css_Filter::get_type(), [
            'name' => 'thumbnail_hover_filters',
            'condition' => [
                'post_card_style' => ['post-card-style-1', 'post-card-style-2'],
            ],
            'selector' => '{{WRAPPER}} .elementor-post:hover .post-card_thumbnail:hover img',
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        $this->start_controls_section(
                'section_design_content_bg', [
            'label' => __('Background Color', CEE_DOMAIN),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'post_card_style' => ['post-card-style-1', 'post-card-style-2'],
            ],
                ]
        );

        $this->add_control(
                'category_bg_color', [
            'label' => __('Category Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'condition' => ['post_card_style' => 'post-card-style-1'],
            'selectors' => [
                '{{WRAPPER}} .post-card_category_background' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'date_bg_color', [
            'label' => __('Date Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-card_date' => 'background-color: {{VALUE}};',
            ],
            'condition' => ['post_card_style' => 'post-card-style-1'],
                ]
        );

        $this->add_control(
                'content_box_bg_color', [
            'label' => __('Content Box Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-card-content-box, 
				{{WRAPPER}} .post-card-content-bg-box' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
                'section_design_content', [
            'label' => __('Content', CEE_DOMAIN),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'date_style', [
            'label' => __('Date', CEE_DOMAIN),
            'type' => Controls_Manager::HEADING,
                ]
        );

        $this->add_control(
                'date_color', [
            'label' => __('Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-card_date_color,
				 {{WRAPPER}} .post-card-style-6 .card-time' => 'color: {{VALUE}};',
            ],
                ]
        );
        $this->add_control(
                'category_style', [
            'label' => __('Category', CEE_DOMAIN),
            'type' => Controls_Manager::HEADING,
                ]
        );

        $this->add_control(
                'category_color', [
            'label' => __('Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-card_category,
                {{WRAPPER}} .post-content .post-card_category,
                {{WRAPPER}} .post-card_category a,
                {{WRAPPER}} .post-card-style-6 .card-category' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'category_hover_color', [
            'label' => __('Hover Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-card_category,
                {{WRAPPER}} .post-card_category:hover span.cat-links a,
                {{WRAPPER}} .post-content .post-card_category a:hover,
                {{WRAPPER}} .post-card-style-6 .card-category' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'cateogry_typography',
            'selector' => '{{WRAPPER}} .post-card_category,
                {{WRAPPER}} .post-card_category a',
                ]
        );

        $this->add_control(
                'category_spacing', [
            'label' => __('Spacing', CEE_DOMAIN),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .post-card_category' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'heading_title_style', [
            'label' => __('Title', CEE_DOMAIN),
            'type' => Controls_Manager::HEADING,
            'condition' => ['show_title' => 'yes'],
                ]
        );

        $this->add_control(
                'title_color', [
            'label' => __('Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-card_title,
                {{WRAPPER}} .post-card_title a,
                {{WRAPPER}} .post-card-style-6 .card-title a' => 'color: {{VALUE}};',
            ],
            'condition' => [
                'show_title' => 'yes'
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'title_typography',
            'selector' =>
            '{{WRAPPER}} .post-card_title,
            {{WRAPPER}} .post-card_title a,
            {{WRAPPER}} .post-card-style-6 .card-title a',
            'condition' => [
                'show_title' => 'yes'
            ],
                ]
        );

        $this->add_control(
                'title_spacing', [
            'label' => __('Spacing', CEE_DOMAIN),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .post-card_title,
		{{WRAPPER}} .post-card-style-6 .card-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'show_title' => 'yes'
            ],
                ]
        );

        $this->add_control(
                'heading_excerpt_style', [
            'label' => __('Excerpt', CEE_DOMAIN),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => [
                'show_excerpt' => 'yes'
            ],
                ]
        );

        $this->add_control(
                'excerpt_color', [
            'label' => __('Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-card_excerpt' => 'color: {{VALUE}};',
            ],
            'condition' => [
                'show_excerpt' => 'yes'
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'excerpt_typography',
            'selector' => '{{WRAPPER}} .post-card_excerpt',
            'condition' => [
                'show_excerpt' => 'yes'
            ],
                ]
        );

        $this->add_control(
                'excerpt_spacing', [
            'label' => __('Spacing', CEE_DOMAIN),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .post-card_excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'show_excerpt' => 'yes'
            ],
                ]
        );

        $this->add_control(
                'heading_readmore_style', [
            'label' => __('Read More', CEE_DOMAIN),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => ['show_read_more' => 'yes'],
                ]
        );

        $this->add_control(
                'read_more_color', [
            'label' => __('Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-card_read-more' => 'color: {{VALUE}};',
            ],
            'condition' => ['show_read_more' => 'yes'],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'read_more_typography',
            'selector' => '{{WRAPPER}} .post-card_read-more',
            'condition' => ['show_read_more' => 'yes'],
                ]
        );

        $this->add_control(
                'heading_meta_style', [
            'label' => __('Meta', CEE_DOMAIN),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => ['show_meta_data' => 'yes'],
                ]
        );

        $this->add_control(
                'meta_color', [
            'label' => __('Icon Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-card_meta-data span .fa,
		{{WRAPPER}} .post-card-style-6 .card-by span .fa' => 'color: {{VALUE}};',
            ],
            'condition' => ['show_meta_data' => 'yes'],
                ]
        );

        $this->add_control(
                'meta_separator_color', [
            'label' => __('Text Color', CEE_DOMAIN),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-card_meta-data span,
                {{WRAPPER}} .post-card_meta-data a,
                {{WRAPPER}} .post-card-style-6 .card-by a' => 'color: {{VALUE}};',
            ],
            'condition' => ['show_meta_data' => 'yes'],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'meta_typography',
            'selector' =>
            '{{WRAPPER}} .post-card_meta-data,
            {{WRAPPER}} .post-card_meta-data i .fa,
            {{WRAPPER}} .post-card_meta-data span a,
            {{WRAPPER}} .post-card-style-6 .card-by a',
            'condition' => ['show_meta_data' => 'yes'],
                ]
        );

        $this->add_control(
                'meta_spacing', [
            'label' => __('Spacing', CEE_DOMAIN),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .post-card_meta-data,
		{{WRAPPER}} .post-card-style-6 .card-by' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
            'condition' => ['show_meta_data' => 'yes'],
                ]
        );

        $this->end_controls_section();
        /*
         * End control style tab for post card
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

        $card_style = $settings['post_card_style'];

        if ($settings['post_card_columns'] == "1") {
            $column = "elementor-grid-1";
        } elseif ($settings['post_card_columns'] == "2") {
            $column = "elementor-grid-2";
        } elseif ($settings['post_card_columns'] == "3") {
            $column = "elementor-grid-3";
        } elseif ($settings['post_card_columns'] == "4") {
            $column = "elementor-grid-4";
        } elseif ($settings['post_card_columns'] == "5") {
            $column = "elementor-grid-5";
        } elseif ($settings['post_card_columns'] == "6") {
            $column = "elementor-grid-6";
        }

        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $settings['number_of_posts'],
            'post_status' => 'publish',
            'orderby' => $settings['post_card_orderby'],
            'order' => $settings['post_sort_order']
        );

        if (isset($settings['blog_categories']) && !empty($settings['blog_categories'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'category',
                'field' => 'ID',
                'terms' => $settings['blog_categories'],
            );
        }

        $blog_posts = new \WP_Query($args);

        if ($blog_posts->have_posts()) :
            ?> 
            <div class="post_card grid-container post-card-grid-gap elementor-grid <?php echo $card_style . ' ' . $column; ?>" > 
                <?php
                while ($blog_posts->have_posts()) : $blog_posts->the_post();

                    switch ($settings['post_card_style']) {
                        case 'post-card-style-1':
                            include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/post-card/elementor-post-card-1.php';  // Card Style 1 
                            break;
                        case 'post-card-style-2':
                            include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/post-card/elementor-post-card-2.php';  // Card Style 2
                            break;
                        case 'post-card-style-3':
                            include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/post-card/elementor-post-card-pro.php';  // Card Style pro
                            break;
                        case 'post-card-style-4':
                            include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/post-card/elementor-post-card-pro.php';  // Card Style pro
                            break;
                        case 'post-card-style-5':
                            include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/post-card/elementor-post-card-pro.php';  // Card Style pro
                            break;
                        case 'post-card-style-6':
                            include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/post-card/elementor-post-card-6.php';  // Card Style 6
                            break;
                        default:
                            include CARD_ELEMENTS_ELEMENTOR_PATH . 'include/post-card/elementor-post-card-1.php';  // Default Card Style 1
                            break;
                    }

                endwhile;
                wp_reset_postdata();
                ?>
            </div> 
            <?php
        endif;
    }

}

Plugin::instance()->widgets_manager->register_widget_type(new Post_Card_Elementor_Widget());

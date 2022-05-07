<?php

namespace Elementor;
use Elementor\Core\Schemes\Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Wpop_News_Ticker extends Widget_Base {

    use \Elementor\WPOPEACommonFunctions;

    public function get_name() {
        return 'wpopea-ticker';
    }

    public function get_title() {
        return __( 'News Ticker', 'wpopea' );
	}


    public function get_icon() {
        return 'eicon-posts-ticker';
    }

    public function get_categories() {
        return [ 'opstore-elements' ];
    }

    public function get_script_depends() {
        return [
          'wpopea-el-slick-js',
          'opstore-el-js',
        ];
    }
    public function get_style_depends() {
        return [
          'ticker',
        ];
    }

    protected function _register_controls() {


        $this->start_controls_section( 'ticker_label_settings', 
            [
            'label' => esc_html__( 'Ticker Label', 'wpopea' ),
            ] 
        );

        $this->add_control( 'label_text', [
            'label'   => __( 'Label Text', 'wpopea' ),
            'type'    => Controls_Manager::TEXT,
            'default' => 'Latest News',
        ] );

        $this->add_control('show_indicator',
            [
                'label'         => esc_html__('Show Indicator', 'wpopea'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'default' => 'true'
            ]
        );

        $this->add_control('show_label_icon',
            [
                'label'         => esc_html__('Show Icon', 'wpopea'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'default' => 'false'
            ]
        );

        $this->add_control( 'icon_position', [
            'label'   => __( 'Icon Position', 'wpopea' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'left',
            'options' => [
                'left'  => __( 'Left', 'wpopea' ),
                'right'  => __( 'Right', 'wpopea' ),
            ],
            'condition' => ['show_label_icon' => 'true']
        ] );

        $this->add_control(
            'label_icon',
            [
                'label' =>__('Icon','wpopea'),
                'type'=>Controls_Manager::ICONS,
                'default' => [
                    'value'=>'fas fa-fire-alt',
                    'library'=>'solid',
                ],
                'condition' => ['show_label_icon' => 'true']
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section( 'ticker_content_settings', 
            [
            'label' => esc_html__( 'Ticker Contents', 'wpopea' ),
            ] 
        );

        $this->add_control( 'ticker_content_type', [
            'label'   => __( 'Content Type', 'wpopea' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'custom',
            'options' => [
                'custom'  => __( 'Custom', 'wpopea' ),
                'latest_post'  => __( 'Latest Post', 'wpopea' ),
                'category_post'  => __( 'Category Post', 'wpopea' ),
            ],
        ] );

        $this->add_control(
        'category',
        [
            'label' => esc_html__( 'Categories', 'wpopea' ),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,
            'label_block' => true,
            'options' => get_post_type_categories('category'),
            'condition' => [
                'ticker_content_type' => 'category_post'
            ]
        ]
        );

        $this->add_control('show_image',[
            'label'         => esc_html__('Show Image', 'wpopea'),
            'type'          => Controls_Manager::SWITCHER,
            'return_value'  => 'true',
            'default' => 'false',
            'conditions' => [
                'terms'    => [
                    [
                        'name'     => 'ticker_content_type',
                        'operator' => '!=',
                        'value'    => 'custom',
                    ],
                ]    

            ]
        ]);

        $this->add_control('show_date',[
            'label'         => esc_html__('Show Date', 'wpopea'),
            'type'          => Controls_Manager::SWITCHER,
            'return_value'  => 'true',
            'default' => 'true',
            'conditions' => [
                'terms'    => [
                    [
                        'name'     => 'ticker_content_type',
                        'operator' => '!=',
                        'value'    => 'custom',
                    ],
                ]    

            ]
        ]);

        $this->add_control(
        'per_page',
        [
            'label' => esc_html__( 'No. of Posts', 'wpopea' ),
            'type' => Controls_Manager::NUMBER,
            'default' => 3,
            'conditions' => [
                'terms'    => [
                    [
                        'name'     => 'ticker_content_type',
                        'operator' => '!=',
                        'value'    => 'custom',
                    ],
                ]

            ]
        ]
        );

        $this->add_control(
            'offset',
            [
                'label' => esc_html__( 'No. of Offset', 'wpopea' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'min' => 0,
                'conditions' => [
                    'terms'    => [
                        [
                            'name'     => 'ticker_content_type',
                            'operator' => '!=',
                            'value'    => 'custom',
                        ],
                    ]
                ]
            ]
        );

        $this->add_control(
            'order',
            [
                'label'             => esc_html__( 'Order', 'wpopea' ),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                   'DESC'           => esc_html__( 'Descending', 'wpopea' ),
                   'ASC'       => esc_html__( 'Ascending', 'wpopea' ),
                ],
                'default'           => 'DESC',
                'conditions' => [
                    'terms'    => [
                        [
                            'name'     => 'ticker_content_type',
                            'operator' => '!=',
                            'value'    => 'custom',
                        ],
                    ]
                ]
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'             => esc_html__( 'Order By', 'wpopea' ),
                'type'              => Controls_Manager::SELECT,
                'options'           => get_post_orderby_options(),
                'default'           => 'date',
                'conditions' => [
                    'terms'    => [
                        [
                            'name'     => 'ticker_content_type',
                            'operator' => '!=',
                            'value'    => 'custom',
                        ],
                    ]
                ]
            ]
        );

    
        $repeater = new Repeater();

        $repeater->add_control(
            'ticker_content',
            [
                'label'   => __( 'Ticker Content', 'wpopea' ),
                'type'    => Controls_Manager::TEXTAREA,
            ]
        );

        $repeater->add_control(
          'ticker_image',
          [
             'label' => esc_html__( 'Ticker Image', 'wpopea' ),
             'type' => Controls_Manager::MEDIA,
             'default'               => [
                'url' => Utils::get_placeholder_image_src(),
             ],
          ]
        );

        $repeater->add_control(
            'ticker_link',
            [
                'label'   => __( 'Ticker Link', 'wpopea' ),
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'ticker_item_list',
            [
                'type'    => Controls_Manager::REPEATER,
                'fields'  => array_values( $repeater->get_controls() ),
                'default' => [
                    [   
                        'ticker_content' => __( 'Ticker1', 'wpopea' ),
                        'ticker_image' => Utils::get_placeholder_image_src(),
                        'ticker_link' => ''
                    ],

                ],
                'title_field' => '{{{ ticker_content }}}',
                'condition' => ['ticker_content_type' => 'custom']
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section( 'ticker_controls', 
            [
            'label' => esc_html__( 'Ticker Controls', 'wpopea' ),
            ] 
        );

        $this->add_control( 'ticker_style', [
            'label'   => __( 'Ticker Style', 'wpopea' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'slide',
            'options' => [
                'slide'  => __( 'Slide', 'wpopea' ),
                'fade'  => __( 'Fade', 'wpopea' ),
            ],
        ] );

        $this->add_control( 'scroll_style', [
            'label'   => __( 'Scroll Style', 'wpopea' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'hor',
            'options' => [
                'hor'  => __( 'Horizontal', 'wpopea' ),
                'ver'  => __( 'Vertical', 'wpopea' ),
            ],
            'condition' => ['ticker_style' => 'slide']
        ] );

        $this->add_responsive_control('slide_no',[
            'label' => esc_html__( 'Slide to Show', 'wpopea' ),
            'type' => Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 10,
            'default' => 1,
        ]);

        $this->add_responsive_control('slide_item',[
            'label' => esc_html__( 'No. of Item to Slide', 'wpopea' ),
            'type' => Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 10,
            'default' => 1,
        ]);

        $this->add_control('show_arrow',[
            'label'         => esc_html__('Show Arrow', 'wpopea'),
            'type'          => Controls_Manager::SWITCHER,
            'return_value'  => 'true',
            'default' => 'true',
        ]);

        $this->add_control( 'arrow_position', [
            'label'   => __( 'Arrow Position', 'wpopea' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'vertical',
            'options' => [
                'vertical'  => __( 'Vertical', 'wpopea' ),
                'horizontal'  => __( 'Horizontal', 'wpopea' ),
            ],
            'condition' => ['show_arrow' => 'true'],
            'prefix_class' => 'arrow-'
        ] );

        $this->add_control('auto_scroll',[
            'label'         => esc_html__('Auto Scroll', 'wpopea'),
            'type'          => Controls_Manager::SWITCHER,
            'return_value'  => 'true',
            'default' => 'true',
        ]);

        $this->add_control('slide_speed',[
            'label' => esc_html__( 'Auto Scroll Speed', 'wpopea' ),
            'type' => Controls_Manager::NUMBER,
            'min' => 500,
            'default' => 2000,
            'condition' => ['auto_scroll'=>'true'],
        ]);

        $this->add_control('infinite_slide',[
            'label' => esc_html__( 'Infinite Slide', 'wpopea' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'true',
            'return_value' => 'true',
        ]);

        $this->add_control(
          'rtl_mode',
          [
            'label' => esc_html__( 'RTL Mode', 'wpopea' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'return_value' => 'true',
          ]
        );


        $this->end_controls_section();

        /*Start Styling Section*/
        $this->start_controls_section('wpopea_label_style',
            [
                'label'         => __('Label Style', 'wpopea'),
                'tab'           => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'label_label_color',
            [
                'label' => esc_html__( 'Label Color', 'wpopea' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpopea-ticker .ticker-label .label-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'label_typography',
                'scheme'        => Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .wpopea-ticker .label-text'
            ]
        );
               

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'label_background',
                'types'             => [ 'classic' , 'gradient' ],
                'selector'          => '{{WRAPPER}} .wpopea-ticker .ticker-label'
            ]
        );

        $this->add_control(
            'label_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'wpopea' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpopea-ticker .ticker-label .ico-wrap' => 'color: {{VALUE}};',
                ],
                'condition' => ['show_label_icon' => 'true']
            ]
        );

        $this->add_responsive_control(
            'label_icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'wpopea' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpopea-ticker .ticker-label .ico-wrap' => 'font-size: {{SIZE}}px;',
                ],
                'condition' => ['show_label_icon' => 'true']
            ]
        );

        $this->add_control(
            'label_indicator_color',
            [
                'label' => esc_html__( 'Indicator Color', 'wpopea' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpopea-ticker .ticker-label:after' => 'border-left-color: {{VALUE}};',
                ],
                'condition' => ['show_indicator' => 'true']
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'label_border',
                'label' => esc_html__( 'Border', 'wpopea' ),
                'selector' => '{{WRAPPER}} .wpopea-ticker .ticker-label',
            ]
        );

        $this->add_control(
            'label_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'wpopea' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpopea-ticker .ticker-label' => 'border-radius: {{SIZE}}px;',
                ],
            ]
        );

        
        $this->add_responsive_control('label_margin',
            [
                'label'         => __('Margin', 'wpopea'),
                'type'          => Controls_Manager::DIMENSIONS,
                'separator'     => 'before',
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .wpopea-ticker .ticker-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        
        $this->add_responsive_control('label_padding',
            [
                'label'         => __('Padding', 'wpopea'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .wpopea-ticker .ticker-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ]
            ]
        );

        $this->end_controls_section();

        /* Content Style Settings*/
        $this->start_controls_section('wpopea_ticker_content_style',
            [
                'label'         => __('Content Style', 'wpopea'),
                'tab'           => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'wpopea_tcontent_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'wpopea' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpopea-ticker .ticker-wrap' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'wpopea_tcontent_bg_border',
                'label' => esc_html__( 'Border', 'wpopea' ),
                'selector' => '{{WRAPPER}} .wpopea-ticker .ticker-wrap',
            ]
        );

        $this->add_control(
            'wpopea_tcontent_bg_radius',
            [
                'label' => esc_html__( 'Border Radius', 'wpopea' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpopea-ticker .ticker-wrap' => 'border-radius: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wpopea_tcontent_shadow',
                'selector' => '{{WRAPPER}} .wpopea-ticker .ticker-wrap',
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'wpopea_tcontent_padding',
            [
                'label' => esc_html__( 'Padding', 'wpopea' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                        '{{WRAPPER}} .wpopea-ticker .ticker-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'ticker_height',
            [
                'label' => esc_html__( 'Height', 'wpopea' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 70,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpopea-ticker .ticker-label' => 'height: {{SIZE}}px;',
                    '{{WRAPPER}} .wpopea-ticker .ticker-wrap' => 'height: {{SIZE}}px;', 
                ],
            ]
        );

        $this->end_controls_section();
        
        /* Title Styles */
        $this->start_controls_section('wpopea_ticker_title_style',
            [
                'label'         => __('Title Style', 'wpopea'),
                'tab'           => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Label Color', 'wpopea' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpopea-ticker .ticker-item .content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'title_typography',
                'scheme'        => Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .wpopea-ticker .ticker-item .content'
            ]
        );

        $this->add_control(
            'date_color',
            [
                'label' => esc_html__( 'Date Color', 'wpopea' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpopea-ticker .ticker-item .date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'date_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'wpopea' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpopea-ticker .ticker-item .date' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* Arrow Styles */
        $this->start_controls_section(
            'wpopea_arrow_style_settings',
            [
                'label' => esc_html__( 'Arrows Style', 'wpopea' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'wpopea_arrow_fontsize',
            [
                'label' => esc_html__( 'Arrow Size', 'wpopea' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpopea-ticker .slick-arrow:before' => 'font-size: {{SIZE}}px;',
                ],
            ]
        );

        $this->start_controls_tabs( 'wpopea_arrow_tabs' );
            // Normal State Tab
            $this->start_controls_tab( 'wpopea_arrow_normal', [ 'label' => esc_html__( 'Normal', 'wpopea' ) ] );

            $this->add_control(
                'wpopea_arrow_normal_text_color',
                [
                    'label' => esc_html__( 'Icon Color', 'wpopea' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .wpopea-ticker .slick-arrow:before' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'wpopea_arrow_normal_bg_color',
                [
                    'label' => esc_html__( 'Background Color', 'wpopea' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .wpopea-ticker .slick-arrow' => 'background: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'wpopea_cat_arrow_normal_border',
                    'label' => esc_html__( 'Border', 'wpopea' ),
                    'selector' => '{{WRAPPER}} .wpopea-ticker .slick-arrow',
                ]
            );

            $this->add_control(
                'wpopea_arrow_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'wpopea' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .wpopea-ticker .slick-arrow' => 'border-radius: {{SIZE}}px;',
                    ],
                ]
            );

            $this->end_controls_tab();

            // Hover State Tab
            $this->start_controls_tab( 'wpopea_arrow_hover', [ 'label' => esc_html__( 'Hover', 'wpopea' ) ] );

            $this->add_control(
                'wpopea_arrow_hover_text_color',
                [
                    'label' => esc_html__( 'Icon Color', 'wpopea' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .wpopea-ticker .slick-prev:hover:before, {{WRAPPER}} .wpopea-ticker .slick-next:hover:before' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'wpopea_arrow_hover_bg_color',
                [
                    'label' => esc_html__( 'Background Color', 'wpopea' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .wpopea-ticker .slick-arrow:hover' => 'background: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'wpopea_arrow_hover_border_color',
                [
                    'label' => esc_html__( 'Border Color', 'wpopea' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .wpopea-ticker .slick-arrow:hover' => 'border-color: {{VALUE}};',
                    ],
                ]

            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wpopea_arrow_shadow',
                'selector' => '{{WRAPPER}} .slick-arrow',
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'wpopea_arrow_padding',
            [
                'label' => esc_html__( 'Padding', 'wpopea' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                        '{{WRAPPER}} .slick-arrow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
     
        $this->end_controls_section(); 
 

    }

    protected function render() {
        
        $settings = $this->get_settings_for_display();

        $tickers = $settings['ticker_item_list'];

        $per_page = $settings['per_page'];
        $offset = $settings['offset'];
        $cat_ids = $settings['category'];
        $order = $settings['order'];
        $orderby = $settings['orderby'];

        //slider options
        $slide_no = $settings['slide_no'];
        $tslide_no = !empty($settings['slide_no_tablet']) ? $settings['slide_no_tablet'] : $slide_no;
        $mslide_no = !empty($settings['slide_no_mobile']) ? $settings['slide_no_mobile'] : $slide_no;
        
        $slide_item = $settings['slide_item'];
        $tslide_item = !empty($settings['slide_item_tablet']) ? $settings['slide_item_tablet'] : $slide_item;
        $mslide_item = !empty($settings['slide_item_mobile']) ? $settings['slide_item_mobile'] : $slide_item;

        $auto_slide = !empty($settings['auto_scroll']) ? 'true' : 'false';
        $slide_speed = $settings['slide_speed'];
        $show_arrow = !empty($settings['show_arrow']) ? 'true' : 'false';
        $infinite_slide = !empty($settings['infinite_slide']) ? 'true' : 'false';
        $rtl = !empty($settings['rtl_mode']) ? 'true' : 'false';
        $slide_type = $settings['ticker_style'];
        $scroll = $settings['scroll_style'] == 'hor' ? 'false' : 'true';

        $this->add_render_attribute( 'ticker', 'class', 'wpopea-ticker' );
        //slider attrs
        $this->add_render_attribute( 'ticker', 'data-slide-no', $slide_no );
        $this->add_render_attribute( 'ticker', 'data-tslide-no', $tslide_no );
        $this->add_render_attribute( 'ticker', 'data-mslide-no', $mslide_no );
        $this->add_render_attribute( 'ticker', 'data-slide-item', $slide_item );
        $this->add_render_attribute( 'ticker', 'data-tslide-item', $tslide_item );
        $this->add_render_attribute( 'ticker', 'data-mslide-item', $mslide_item );
        $this->add_render_attribute( 'ticker', 'data-auto-slide', $auto_slide );
        $this->add_render_attribute( 'ticker', 'data-speed', $slide_speed );
        $this->add_render_attribute( 'ticker', 'data-show-arrow', $show_arrow );
        $this->add_render_attribute( 'ticker', 'data-slide-type', $slide_type );
        $this->add_render_attribute( 'ticker', 'data-rtl', $rtl );
        $this->add_render_attribute( 'ticker', 'data-scroll', $scroll );
        $this->add_render_attribute( 'ticker', 'data-infinite-slide', $infinite_slide );

        if(!$settings['show_indicator']){
            $class = 'indicator-off';
        }else{
            $class = '';
        }
        wp_enqueue_style('wpopea-slick-style');
        wp_enqueue_style('wpopea-slick-theme-style');
        wp_enqueue_script( 'wpopea-el-slick-js');
        ?>
        
        <div <?php echo $this->get_render_attribute_string( 'ticker' );?>>
            <?php if($settings['label_text'] !=''){?>
                <div class="ticker-label icon-<?php echo esc_attr($settings['icon_position'].' '.$class);?>">
                    <?php if($settings['show_label_icon'] == 'true'){?>
                    <span class="ico-wrap">
                        <?php echo Wpopea_Icon_manager::render_icon( $settings['label_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </span>
                    <?php }?>
                    <span class="label-text"><?php echo esc_html($settings['label_text']); ?></span>
                </div>
            <?php }?>
            <div class="ticker-wrap">
                <?php 
                if($settings['ticker_content_type'] == 'custom'){
                if(!empty($tickers)){
                    foreach($tickers as $ticker){
                        $t_content = isset($ticker['ticker_content']) ? $ticker['ticker_content'] : '';
                        $t_image = isset($ticker['ticker_image']) ? $ticker['ticker_image'] : '';
                        if($t_image['id']){
                            $img_src = wp_get_attachment_image_url( $t_image['id'], 'thumbnail');
                        }
                        $t_link = isset($ticker['ticker_link']) ? $ticker['ticker_link'] : '';
                        ?>
                        <div class="ticker-item">
                            <?php if($t_link){?>
                            <a href="<?php echo esc_url($t_link);?>"> 
                            <?php }?>
                                <?php if($t_image['id']){?>
                                <div class="img-wrap">    
                                    <img src="<?php echo esc_url($img_src);?>" >
                                </div>
                                <?php }?> 
                                <div class="content">  
                                <?php echo wp_kses_post($t_content);?>
                                </div>  
                            <?php if($t_link){?>    
                            </a>
                            <?php }?>
                            
                        </div>
                        <?php
                    }
                }
                }else{
                    $args = array(
                      'post_type'         =>  'post',
                      'posts_per_page'    =>   $per_page,
                      'offset'            =>   $offset,
                      'order'             =>   $order,
                      'orderby'           =>   $orderby,
                    );
                    if( $settings['ticker_content_type'] == 'category_posts' ){
                       $args['tax_query'] =  array( array(
                                       'taxonomy'      => 'category',
                                       'terms'         => explode( ',', $cat_ids ),
                                       'field'         => 'ID',
                                       'operator'      => 'IN'
                                   ));
                    }
                    $posts = new \WP_Query( $args );
                    while( $posts->have_posts() ): $posts->the_post();
                        $img_id = get_post_thumbnail_id( get_the_ID() );
                        $img_src = wp_get_attachment_image_url( $img_id, 'thumbnail');
                        ?>
                        <div class="ticker-item">
                            <a href="<?php the_permalink();?>"> 
                                <?php if($settings['show_image'] == 'true' && has_post_thumbnail()){?>
                                <div class="img-wrap">    
                                    <img src="<?php echo esc_url($img_src);?>" >
                                </div>
                                <?php }?> 
                                <div class="content">   
                                    <?php the_title();?> 
                                </div>
                                <?php if($settings['show_date'] == 'true'){?>
                                    <span class="date">
                                        <?php echo get_the_date('M j');?>
                                    </span>
                                <?php }?>  
                            </a> 
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();    
                }        
                ?>
            </div>
        </div>

        <?php
    }
    
}
Plugin::instance()->widgets_manager->register_widget_type( new Wpop_News_Ticker() );
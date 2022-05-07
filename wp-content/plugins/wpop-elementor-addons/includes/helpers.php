<?php
namespace Elementor;

function wpopea_elementor_init(){
    Plugin::instance()->elements_manager->add_category(
        'opstore-elements',
        [
            'title'  => esc_html__('WPOP Elements','wpopea'),
            'icon' => 'font'
        ],
        1
    );
    Plugin::instance()->elements_manager->add_category(
        'ultra-elements',
        [
            'title'  => esc_html__('Ultra Elements','wpopea'),
            'icon' => 'font'
        ],
        0
    );

}
add_action('elementor/init','Elementor\wpopea_elementor_init');

trait WPOPEACommonFunctions {

    /**
     * For Exclude Option
     */
    public function wpopea_query_controls( ) {

      $this->start_controls_section(
         'wpop_query_settings',
         [
            'label' => esc_html__( 'Query Settings', 'wpopea' )
         ]
      ); 

      $this->add_control(
         'post_type',
         [
            'label' => esc_html__( 'Post Type', 'wpopea' ),
            'type' => Controls_Manager::SELECT,
            'options' => [
                       'latest'   => esc_html__('Latest','wpopea'),
                       'category'     => esc_html__('Category','wpopea'),
            ],
            'default' => 'latest'
         ]
      );

      $this->add_control(
         'category',
         [
         'label' => esc_html__( 'Categories', 'wpopea' ),
         'type' => Controls_Manager::SELECT2,
         'multiple' => true,
         'label_block' => true,
         'options' => get_post_type_categories('category'),
         'condition' => [
            'post_type' => 'category'
          ]
         ]
      );

      $this->add_control(
         'per_page',
         [
            'label' => esc_html__( 'No. of Posts', 'wpopea' ),
            'type' => Controls_Manager::NUMBER,
            'default' => 3
         ]
      );

      $this->add_control(
         'offset',
         [
            'label' => esc_html__( 'No. of Offset', 'wpopea' ),
            'type' => Controls_Manager::NUMBER,
            'default' => 0,
         ]
      );

      $this->add_control(
         'columns',
         [
            'label' => esc_html__( 'No. of Column', 'wpopea' ),
            'type' => Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 4,
            'default' => 3,
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
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'             => esc_html__( 'Order By', 'wpopea' ),
                'type'              => Controls_Manager::SELECT,
                'options'           => get_post_orderby_options(),
                'default'           => 'date',
            ]
        );


        $this->add_control('show_excerpt',
            [
                'label'         => esc_html__('Show Excerpt', 'wpopea'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => __( 'Excerpt Length', 'wpopea' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '100',
                'condition' => [
                    'show_excerpt' => 'true',
                ],
            ]
        );

      $this->add_control(
         'readmore_text',
         [
            'label' => esc_html__( 'Read More Text', 'wpopea' ),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__( 'Read More', 'wpopea' ),
            'condition' => [
                'show_excerpt' => 'true',
            ],
         ]
      );

      $this->end_controls_section();
    }

    /**
     * Post Meta Settings
     */
    public function wpopea_meta_controls( ) {

        $this->start_controls_section(
         'wpop_meta_section',
         [
            'label' => esc_html__( 'Post Meta Settings', 'wpopea' ),
         ]
        ); 

        $this->add_control(
        'show_category',
        [
          'label' => esc_html__( 'Show Category', 'wpopea' ),
          'type' => Controls_Manager::SWITCHER,
          'default' => 'true',
          'return_value' => 'true',
        ]
        );

        $this->add_control(
        'show_meta',
        [
          'label' => esc_html__( 'Show Meta', 'wpopea' ),
          'type' => Controls_Manager::SWITCHER,
          'default' => 'true',
          'return_value' => 'true',
        ]
        );

        $this->add_control(
          'show_comment',
          [
            'label' => esc_html__( 'Show Comment', 'wpopea' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'true',
            'return_value' => 'true',
          ]
        );
        $this->add_control(
          'show_views',
          [
            'label' => esc_html__( 'Show Views', 'wpopea' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'true',
            'return_value' => 'true',
          ]
        );
        $this->end_controls_section();
    }

    /**
     * Slider Settings
     */
    public function wpopea_slider_controls( ) {

        $this->start_controls_section(
         'wpopea_slider_section',
         [
            'label' => esc_html__( 'Slider Settings', 'wpopea' ),
            'condition' => ['display_style' => 'carousel']
         ]
        ); 

        $this->add_responsive_control(
         'slide_no',
         [
         'label' => esc_html__( 'Slide to Show', 'wpopea' ),
         'type' => Controls_Manager::NUMBER,
         'label_block' => true,
         'min' => 1,
         'max' => 10,
         'default' => 3,
         ]
        );
        $this->add_responsive_control(
         'slide_item',
         [
         'label' => esc_html__( 'No. of Item to Slide', 'wpopea' ),
         'type' => Controls_Manager::NUMBER,
         'label_block' => true,
         'min' => 1,
         'max' => 10,
         'default' => 1
         ]
        );
        $this->add_control(
        'auto_slide',
        [
          'label' => esc_html__( 'Auto Slide', 'wpopea' ),
          'type' => Controls_Manager::SWITCHER,
          'default' => 'true',
          'return_value' => 'true',
        ]
        );
        $this->add_control(
          'show_pager',
          [
            'label' => esc_html__( 'Show Pager', 'wpopea' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'true',
            'return_value' => 'true',
          ]
        );
        $this->add_control(
          'show_arrow',
          [
            'label' => esc_html__( 'Show Arrow', 'wpopea' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'true',
            'return_value' => 'true',
          ]
        );
        $this->add_control(
          'infinite_slide',
          [
            'label' => esc_html__( 'Infinite Slide', 'wpopea' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'true',
            'return_value' => 'true',
          ]
        );
        $this->end_controls_section();
    }

    /**
     * Arrows & Dots
     */
    public function wpopea_arrows_dots_controls( ) {
        $this->start_controls_section(
            'wpopea_dots_arrow_style_settings',
            [
                'label' => esc_html__( 'Arrows & Dots Style', 'wpopea' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['display_style' => 'carousel']
            ]
        );

        $this->add_control(
             'arrow_style',
             [
                'label' => esc_html__( 'Arrow Styles', 'wpopea' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
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
                    '{{WRAPPER}} .slick-arrow:before' => 'font-size: {{SIZE}}px;',
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
                        '{{WRAPPER}} .slick-arrow:before' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'wpopea_arrow_normal_bg_color',
                [
                    'label' => esc_html__( 'Background Color', 'wpopea' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .slick-arrow' => 'background: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'wpopea_cat_arrow_normal_border',
                    'label' => esc_html__( 'Border', 'wpopea' ),
                    'selector' => '{{WRAPPER}} .slick-arrow',
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
                        '{{WRAPPER}} .slick-arrow' => 'border-radius: {{SIZE}}px;',
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
                        '{{WRAPPER}} .slick-prev:hover:before, {{WRAPPER}} .slick-next:hover:before' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'wpopea_arrow_hover_bg_color',
                [
                    'label' => esc_html__( 'Background Color', 'wpopea' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .slick-arrow:hover' => 'background: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'wpopea_arrow_hover_border_color',
                [
                    'label' => esc_html__( 'Border Color', 'wpopea' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .slick-arrow:hover' => 'border-color: {{VALUE}};',
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

        $this->add_control(
             'dots_style',
             [
                'label' => esc_html__( 'Dots Styles', 'wpopea' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
             ]
        );

        $this->add_control(
            'wpopea_dots_color',
            [
                'label' => esc_html__( 'Dots Color', 'wpopea' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li button:before, {{WRAPPER}} .slick-dots li.slick-active button:before' => 'color: {{VALUE}};',
                ],
            ]
        );
     

        $this->end_controls_section(); 
    } 

    /* 
    ** Meta Styles 
    **/
    function wpop_meta_styles(){

      $this->start_controls_section(
        'wpop_meta_style_settings',
        [
          'label' => esc_html__( 'Meta Style ', 'wpopea' ),
          'tab' => Controls_Manager::TAB_STYLE,
          'condition' => ['show_meta' => 'true']
        ]
      );

      $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
          'name' => 'wpop_meta_typography',
          'selector' => '{{WRAPPER}} .post-meta span a, {{WRAPPER}} .post-meta span a:before',
        ]
      );

      $this->start_controls_tabs( 'wpop_meta_tabs' );

        // Normal State Tab
        $this->start_controls_tab( 'wpop_meta_normal', [ 'label' => esc_html__( 'Normal', 'wpopea' ) ] );

        $this->add_control(
          'wpop_meta_color',
          [
            'label' => esc_html__( 'Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
              '{{WRAPPER}} .post-meta span a' => 'color: {{VALUE}};',
            ],
          ]
        );

        $this->end_controls_tab();
        // Hover State Tab
        $this->start_controls_tab( 'wpop_meta_hover', [ 'label' => esc_html__( 'Hover', 'wpopea' ) ] );

        $this->add_control(
          'wpop_meta_hcolor',
          [
            'label' => esc_html__( 'Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
              '{{WRAPPER}} .post-meta span a:hover' => 'color: {{VALUE}};',
            ],
          ]
        );

        $this->end_controls_tab();

      $this->end_controls_tabs(); 

      $this->end_controls_section();
    } 
    
    /* Button Styles */
    public function wpopea_button_styles(){
        
        $this->start_controls_section(
            'wpopea_section_btn_style_settings',
            [
                'label' => esc_html__( 'Button Style', 'wpopea' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'wpopea_btn_alignment',
            [
                'label' => __( 'Button Alignment', 'wpopea' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'wpopea' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'wpopea' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'wpopea' ),
                        'icon' => 'fa fa-align-right',
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .btn-wrap' => 'text-align: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
             'name' => 'wpopea_btn_typography',
                'selector' => '{{WRAPPER}} .btn-wrap a',
            ]
        );

        $this->start_controls_tabs( 'wpopea_button_tabs' );

            // Normal State Tab
            $this->start_controls_tab( 'wpopea_btn_normal', [ 'label' => esc_html__( 'Normal', 'wpopea' ) ] );

            $this->add_control(
                'wpopea_btn_normal_text_color',
                [
                    'label' => esc_html__( 'Text Color', 'wpopea' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .btn-wrap a' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'wpopea_btn_normal_bg_color',
                [
                    'label' => esc_html__( 'Background Color', 'wpopea' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .btn-wrap a' => 'background: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'wpopea_cat_btn_normal_border',
                    'label' => esc_html__( 'Border', 'wpopea' ),
                    'selector' => '{{WRAPPER}} .btn-wrap a',
                ]
            );

            $this->add_control(
                'wpopea_btn_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'wpopea' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .btn-wrap a' => 'border-radius: {{SIZE}}px;',
                    ],
                ]
            );

            $this->end_controls_tab();

            // Hover State Tab
            $this->start_controls_tab( 'wpopea_btn_hover', [ 'label' => esc_html__( 'Hover', 'wpopea' ) ] );

            $this->add_control(
                'wpopea_btn_hover_text_color',
                [
                    'label' => esc_html__( 'Text Color', 'wpopea' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .btn-wrap a:hover' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'wpopea_btn_hover_bg_color',
                [
                    'label' => esc_html__( 'Background Color', 'wpopea' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .btn-wrap a:hover' => 'background: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'wpopea_btn_hover_border_color',
                [
                    'label' => esc_html__( 'Border Color', 'wpopea' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .btn-wrap a:hover' => 'border-color: {{VALUE}};',
                    ],
                ]

            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wpopea_button_shadow',
                'selector' => '{{WRAPPER}} .btn-wrap a',
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'wpopea_btn_padding',
            [
                'label' => esc_html__( 'Padding', 'wpopea' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                        '{{WRAPPER}} .btn-wrap a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wpopea_btn_margin',
            [
                'label' => esc_html__( 'Margin', 'wpopea' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                        '{{WRAPPER}} .btn-wrap a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
 

      $this->end_controls_section(); 
    }
}
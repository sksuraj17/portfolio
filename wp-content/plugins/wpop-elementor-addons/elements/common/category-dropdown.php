<?php
namespace Elementor;

use Elementor\Core\Schemes\Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Wpopea_Category_Dropdown extends Widget_Base {

   public function get_title() {
      return esc_html__( 'Category Dropdown', 'wpopea' );
   }

   public function get_icon() {
      return 'eicon-bullet-list';
   }
   public function get_categories() {
      return [ 'opstore-elements' ];
   }

   public function get_name() {
      return 'wpopea-category-dropdown';
   }

    public function get_style_depends() {
        return [
          'cat-drop',
        ];
    }
   protected function _register_controls() {

		$this->start_controls_section(
			'display_settings',
			[
			    'label' => esc_html__( 'Display Settings', 'wpopea' )
			]
		); 
		$this->add_control(
			'display_type',
			[
			'label' => esc_html__( 'Home Display Type', 'wpopea' ),
			'type' => Controls_Manager::SELECT,
			'options' => [
			           'collapsed'   => esc_html__('Collapsed','wpopea'),
			           'open'     => esc_html__('Open','wpopea'),
			],
			'default' => 'open'
			]
		);
		$this->add_control(
			'title',
			[
			    'label' => esc_html__( 'Title', 'wpopea' ),
			    'type' => Controls_Manager::TEXT,
			    'default' => 'Categories'
			]
		);


    $this->add_control('show_title_icon',
        [
            'label'         => esc_html__('Show Title Icon', 'wpopea'),
            'type'          => Controls_Manager::SWITCHER,
            'default'       => 'no'
        ]
    );

    $this->add_control(
        'title_icon',
        [
            'label' =>__('Icon','wpopea'),
            'type'=>Controls_Manager::ICONS,
            'default' => [
                'value'=>'fas fa-bars',
                'library'=>'solid',
            ],
            'condition' => [
                'show_title_icon' => 'yes',
            ]
        ]
    );

    $this->add_control('show_subcategory',
        [
            'label'         => esc_html__('Sub Categories', 'wpopea'),
            'type'          => Controls_Manager::SWITCHER,
            'default'       => 'yes'
        ]
    );

    $this->add_control('show_catimage',
        [
            'label'         => esc_html__('Category Image', 'wpopea'),
            'type'          => Controls_Manager::SWITCHER,
            'default'       => 'no'
        ]
    );
    $this->add_control('hide_empty',
        [
            'label'         => esc_html__('Hide Empty', 'wpopea'),
            'type'          => Controls_Manager::SWITCHER,
            'default'       => 'no'
        ]
    );


    $this->end_controls_section();

    $this->start_controls_section(
        'cat_dropdown_title_styles',
        [
            'label' => __( 'Title Style', 'wpopea' ),
            'tab' => Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'name' => 'title_typography',
            'scheme' => Typography::TYPOGRAPHY_1,
            'selector' => '{{WRAPPER}} .wpopea-category-dropdown .toggle-wrap',
        ]
    );

    // Title Tabs Start
    $this->start_controls_tabs('title_style_tabs');

        // Start Normal tab
        $this->start_controls_tab(
            'title_normal_tab',
            [
                'label' => __( 'Normal', 'wpopea' ),
            ]
        );
            
          $this->add_control(
              'title_color',
              [
                  'label'     => __( 'Color', 'wpopea' ),
                  'type'      => Controls_Manager::COLOR,
                  'selectors' => [
                      '{{WRAPPER}} .wpopea-category-dropdown .toggle-wrap a'   => 'color: {{VALUE}};',
                  ],
              ]
          );
        $this->end_controls_tab();  

        // Start Hover tab
        $this->start_controls_tab(
            'title_hover_tab',
            [
                'label' => __( 'Hover', 'wpopea' ),
            ]
        );
            
          $this->add_control(
              'title_hover_color',
              [
                  'label'     => __( 'Color', 'wpopea' ),
                  'type'      => Controls_Manager::COLOR,
                  'selectors' => [
                      '{{WRAPPER}} .wpopea-category-dropdown .toggle-wrap a:hover'   => 'color: {{VALUE}};',
                  ],
              ]
          );
        $this->end_controls_tab(); 
        $this->end_controls_tabs();

        $this->add_responsive_control('title_text_indent',
          [
            'label'         => __( 'Text Indent', 'wpopea' ),
            'type'          => Controls_Manager::SLIDER,
            'default'       => [
              'size' => 12,
            ],
            'range'         => [
              'px' => [
                'min' => 0,
                'max' => 50
              ],
            ],
            'condition'   => [
              'show_title_icon' => 'yes'
            ],
            'selectors'     => [
              '{{WRAPPER}} .wpopea-category-dropdown .toggle-wrap i' => 'padding-right: {{SIZE}}{{UNIT}};',
            ],
          ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'title_background',
                'label' => __( 'Background', 'wpopea' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .wpopea-category-dropdown .toggle-wrap',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => __( 'Margin', 'wpopea' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wpopea-category-dropdown .toggle-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' =>'before',
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => __( 'Padding', 'wpopea' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wpopea-category-dropdown .toggle-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


      $this->end_controls_section(); 

      $this->start_controls_section(
          'cat_dropdown_content_styles',
          [
              'label' => __( 'Content Style', 'wpopea' ),
              'tab' => Controls_Manager::TAB_STYLE,
          ]
      );

        $this->add_responsive_control('content_space',
          [
            'label'         => __( 'Space from title', 'wpopea' ),
            'type'          => Controls_Manager::SLIDER,
            'default'       => [
              'size' => 35,
            ],
            'range'         => [
              'px' => [
                'min' => 0,
                'max' => 100
              ],
            ],
            'selectors'     => [
              '{{WRAPPER}} .wpopea-category-dropdown ul.main-cat' => 'top: {{SIZE}}{{UNIT}};',
            ],
          ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'content_background',
                'label' => __( 'Background', 'wpopea' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .wpopea-category-dropdown ul.main-cat',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
                [
                    'name'              => 'content_border',
                    'selector'          => '{{WRAPPER}} .wpopea-category-dropdown ul.main-cat',
                    ]
                );
        
        $this->add_control('content_border_radius',
                [
                    'label'         => __('Border Radius', 'wpopea'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%', 'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .wpopea-category-dropdown ul.main-cat' => 'border-radius: {{SIZE}}{{UNIT}};'
                        ]
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'              => 'content_box_shadow',
                'selector'          => '{{WRAPPER}} .wpopea-category-dropdown ul.main-cat',
            ]
            );


        $this->add_responsive_control(
            'content_padding',
            [
                'label' => __( 'Padding', 'wpopea' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wpopea-category-dropdown ul.main-cat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

      $this->end_controls_section();    

    $this->start_controls_section(
        'cat_dropdown_cat_list_styles',
        [
            'label' => __( 'Categories Style', 'wpopea' ),
            'tab' => Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'name' => 'cat_typography',
            'scheme' => Typography::TYPOGRAPHY_1,
            'selector' => '{{WRAPPER}} .wpopea-category-dropdown ul.main-cat li',
        ]
    );

    // cat List Tabs Start
    $this->start_controls_tabs('cat_list_style_tabs');

        // Start Normal tab
        $this->start_controls_tab(
            'cat_normal_tab',
            [
                'label' => __( 'Normal', 'wpopea' ),
            ]
        );
            
          $this->add_control(
              'cat_color',
              [
                  'label'     => __( 'Color', 'wpopea' ),
                  'type'      => Controls_Manager::COLOR,
                  'selectors' => [
                      '{{WRAPPER}} .wpopea-category-dropdown ul.main-cat li a'   => 'color: {{VALUE}};',
                  ],
              ]
          );
          $this->add_group_control(
              Group_Control_Background::get_type(),
              [
                  'name' => 'cat_background',
                  'label' => __( 'Background', 'wpopea' ),
                  'types' => [ 'classic', 'gradient' ],
                  'selector' => '{{WRAPPER}} .wpopea-category-dropdown .main-cat li',
              ]
          );
        $this->end_controls_tab();  

        // Start Hover tab
        $this->start_controls_tab(
            'cat_hover_tab',
            [
                'label' => __( 'Hover', 'wpopea' ),
            ]
        );
            
          $this->add_control(
              'cat_hover_color',
              [
                  'label'     => __( 'Color', 'wpopea' ),
                  'type'      => Controls_Manager::COLOR,
                  'selectors' => [
                      '{{WRAPPER}} .wpopea-category-dropdown ul.main-cat li a:hover'   => 'color: {{VALUE}};',
                      '{{WRAPPER}} .wpopea-category-dropdown ul.main-cat li.active a'   => 'color: {{VALUE}};',
                  ],
              ]
          );
          $this->add_group_control(
              Group_Control_Background::get_type(),
              [
                  'name' => 'cat_background_hov',
                  'label' => __( 'Background', 'wpopea' ),
                  'types' => [ 'classic', 'gradient' ],
                  'selector' => '{{WRAPPER}} .wpopea-category-dropdown .main-cat li:hover',
              ]
          );
        $this->end_controls_tab(); 
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'cat_border',
                'label' => esc_html__( 'Border', 'wpopea' ),
                'selector' => '{{WRAPPER}} .wpopea-category-dropdown .main-cat li',
            ]
        );

        $this->add_responsive_control(
            'cat_margin',
            [
                'label' => __( 'Margin', 'wpopea' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wpopea-category-dropdown ul.main-cat li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' =>'before',
            ]
        );

        $this->add_responsive_control(
            'cat_padding',
            [
                'label' => __( 'Padding', 'wpopea' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wpopea-category-dropdown ul.main-cat li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


      $this->end_controls_section(); 

   }

   protected function render( ) {

        // get our input from the widget settings.
        $settings = $this->get_settings();
        $title = $settings['title'];
        $display_type = $settings['display_type'];
        $sub_cat = $settings['show_subcategory'];
        $show_cat_image = $settings['show_catimage'];
        $hide_empty = $settings['hide_empty'];
        if($hide_empty == 'yes'){
          $empty = true;
        }else{
          $empty = false;
        }


        echo '<div class="wpopea-category-dropdown">';
        echo '<div class="toggle-wrap"><a href="javascript:void(0)">';
        if($settings['show_title_icon'] == 'yes'){
        echo Wpopea_Icon_manager::render_icon( $settings['title_icon']);
        }
        echo esc_html($title);
        echo '</a></div>';
        $obj = get_queried_object();
         $args = array(
                  'taxonomy' => 'product_cat',
                  'hide_empty' => $empty,
                  'parent'   => 0
              );
          $product_cat = get_terms( $args );
          echo '<ul class="main-cat '.esc_attr($display_type).'">';
          foreach ($product_cat as $parent_product_cat)
          {
          $thumbnail_id = get_term_meta( $parent_product_cat->term_id, 'thumbnail_id', true ); 
          $cat_image = esc_url(wp_get_attachment_url( $thumbnail_id )); 
          if(isset($obj->term_id)){
            if($obj->term_id == $parent_product_cat->term_id){
              $class = 'active';
            }else{
              $class = '';
            }
          }else{
            $class = '';
          }
          echo '<li class="cats '.$class.'"><a href="'.get_term_link($parent_product_cat->term_id).'">';
          if($thumbnail_id && $show_cat_image == 'yes'){
            echo "<img src='{$cat_image}' height='20px' width='20px'/>";
          }
          echo esc_html($parent_product_cat->name);
          echo '</a>';
          $child_args = array(
                      'taxonomy' => 'product_cat',
                      'hide_empty' => $empty,
                      'parent'   => $parent_product_cat->term_id
                  );
          $child_product_cats = get_terms( $child_args );
          if($child_product_cats && $sub_cat == 'yes'){
            echo '<ul class="sub-cat">';
            foreach ($child_product_cats as $child_product_cat)
            {
              $thumbnail_id = get_term_meta( $parent_product_cat->term_id, 'thumbnail_id', true ); 
              $cat_image = esc_url(wp_get_attachment_url( $thumbnail_id )); 
              if(isset($obj->term_id)){
                if($obj->term_id == $child_product_cat->term_id){
                  $class = 'active';
                }else{
                  $class = '';
                }
              }
              echo '<li class="sub-cats '.$class.'"><a href="'.get_term_link($child_product_cat->term_id).'">';
              if($thumbnail_id && $show_cat_image == 'yes'){
                echo "<img src='{$cat_image}' height='20px' width='20px'/>";
              }
              echo esc_html($child_product_cat->name);
              echo '</a></li>';
            }
            echo '</ul>';
          }
          echo '</li>';
          }
          echo '</ul></div>';
   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}

Plugin::instance()->widgets_manager->register_widget_type( new Wpopea_Category_Dropdown() );
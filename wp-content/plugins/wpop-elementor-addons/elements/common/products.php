<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Opstore_Products extends Widget_Base {

  use \Elementor\WPOPEACommonFunctions;

   public function get_title() {
      return esc_html__( 'Opstore Products', 'wpopea' );
   }

   public function get_icon() {
      return 'eicon-woocommerce';
   }
   public function get_categories() {
      return [ 'opstore-elements' ];
   }
   public function get_name() {
      return 'opstore-products';
   }

    public function get_script_depends() {
        return [
          'wpopea-el-slick-js',
          'wpopea-el-isotope-js',
          'opstore-el-js',
        ];
    }

    public function is_reload_preview_required() {
      return true;  
    }

   protected function _register_controls() {

      $this->start_controls_section(
         'opstore_sections_list',
         [
            'label' => esc_html__( 'Display Settings', 'wpopea' )
         ]
      );

      $this->add_control(
        'wc_style_warning',
        [
          'type' => Controls_Manager::RAW_HTML,
          'raw' => __( 'If design seems to be messed up, please click APPLY button above.', 'wpopea' ),
          'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
        ]
      );

      $this->add_control(
         'display_style',
         [
            'label' => esc_html__( 'Display Style', 'wpopea' ),
            'type' => Controls_Manager::SELECT,
            'options' => [
                       'normal'   => esc_html__('Normal','wpopea'),
                       'carousel' => esc_html__('Carousel','wpopea'),
                       'tabs'     => esc_html__('Tabs','wpopea'),
            ],
            'default' => 'normal'
         ]
      );

      $this->add_control(
         'product_type',
         [
            'label' => esc_html__( 'Product Type', 'wpopea' ),
            'type' => Controls_Manager::SELECT,
            'options' => [
                       'latest'   => esc_html__('Latest','wpopea'),
                       'trending' => esc_html__('Trending','wpopea'),
                       'featured' => esc_html__('Featured','wpopea'),
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
         'options' => get_post_type_categories('product_cat'),
         'condition' => [
            'product_type' => 'category'
          ]
         ]
      );

      $this->add_control(
         'per_page',
         [
         'label' => esc_html__( 'No. of Product', 'wpopea' ),
         'type' => Controls_Manager::NUMBER,
         'default' => 6
         ]
      );

      $this->add_control(
        'offset',
        [
           'label'   => esc_html__( 'Offset Value', 'wpopea' ),
           'type'    => Controls_Manager::NUMBER,
           'default' => 0
        ]
      );

      $this->add_control(
         'columns',
         [
         'label' => esc_html__( 'No. of Column', 'wpopea' ),
         'type' => Controls_Manager::NUMBER,
         'default' => 4,
         'min' => 1,
         'max' => 4
         ]
      );

      $this->end_controls_section();

      //Slider Settings
      $this->wpopea_slider_controls();


        /** 
        * Tabs Styles 
        **/
    $this->start_controls_section(
      'uad_section_tabs_style_settings',
      [
        'label' => esc_html__( 'Tabs Style', 'uncode-addons' ),
        'tab' => Controls_Manager::TAB_STYLE,
        'condition' => [
          'display_style' => 'tabs',
        ],
      ]
    );

    $this->add_responsive_control(
      'uad_tabs_alignment',
      [
        'label' => __( 'Tabs Alignment', 'uncode-addons' ),
        'type' => Controls_Manager::CHOOSE,
        'options' => [
          'left' => [
            'title' => __( 'Left', 'uncode-addons' ),
            'icon' => 'fa fa-align-left',
          ],
          'center' => [
            'title' => __( 'Center', 'uncode-addons' ),
            'icon' => 'fa fa-align-center',
          ],
          'right' => [
            'title' => __( 'Right', 'uncode-addons' ),
            'icon' => 'fa fa-align-right',
          ]
        ],
        'selectors' => [
          '{{WRAPPER}} .wpopea-opstore-products .product-tab-filter' => 'text-align: {{VALUE}};',
        ]
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
           'name' => 'uad_tabs_typography',
        'selector' => '{{WRAPPER}} .wpopea-opstore-products .titles-port .filter',
      ]
    );

    $this->start_controls_tabs( 'uad_tabs_state' );

      // Normal State Tab
      $this->start_controls_tab( 'uad_tabs_normal', [ 'label' => esc_html__( 'Normal', 'uncode-addons' ) ] );

      $this->add_control(
        'uad_tabs_normal_text_color',
        [
          'label' => esc_html__( 'Text Color', 'uncode-addons' ),
          'type' => Controls_Manager::COLOR,
          'default' => '#4d4d4d',
          'selectors' => [
            '{{WRAPPER}} .wpopea-opstore-products .titles-port .filter' => 'color: {{VALUE}};',
          ],
        ]
      );

      $this->add_control(
        'uad_tabs_normal_bg_color',
        [
          'label' => esc_html__( 'Background Color', 'uncode-addons' ),
          'type' => Controls_Manager::COLOR,
          'default' => '#f9f9f9',
          'selectors' => [
            '{{WRAPPER}} .wpopea-opstore-products .titles-port .filter' => 'background: {{VALUE}};',
          ],
        ]
      );

      $this->add_group_control(
        Group_Control_Border::get_type(),
        [
          'name' => 'uad_cat_tabs_normal_border',
          'label' => esc_html__( 'Border', 'uncode-addons' ),
          'selector' => '{{WRAPPER}} .wpopea-opstore-products .titles-port .filter',
        ]
      );

      $this->add_control(
        'uad_tabs_border_radius',
        [
          'label' => esc_html__( 'Border Radius', 'uncode-addons' ),
          'type' => Controls_Manager::SLIDER,
          'range' => [
            'px' => [
              'max' => 100,
            ],
          ],
          'selectors' => [
            '{{WRAPPER}} .wpopea-opstore-products .titles-port .filter' => 'border-radius: {{SIZE}}px;',
          ],
        ]
      );

      $this->end_controls_tab();

      // Hover State Tab
      $this->start_controls_tab( 'uad_tabs_hover', [ 'label' => esc_html__( 'Hover', 'uncode-addons' ) ] );

      $this->add_control(
        'uad_tabs_hover_text_color',
        [
          'label' => esc_html__( 'Text Color', 'uncode-addons' ),
          'type' => Controls_Manager::COLOR,
          'default' => '#f9f9f9',
          'selectors' => [
            '{{WRAPPER}} .wpopea-opstore-products .titles-port .filter:hover' => 'color: {{VALUE}};',
          ],
        ]
      );

      $this->add_control(
        'uad_tabs_hover_bg_color',
        [
          'label' => esc_html__( 'Background Color', 'uncode-addons' ),
          'type' => Controls_Manager::COLOR,
          'default' => '#3F51B5',
          'selectors' => [
            '{{WRAPPER}} .wpopea-opstore-products .titles-port .filter:hover' => 'background: {{VALUE}};',
          ],
        ]
      );

      $this->add_control(
        'uad_tabs_hover_border_color',
        [
          'label' => esc_html__( 'Border Color', 'uncode-addons' ),
          'type' => Controls_Manager::COLOR,
          'default' => '',
          'selectors' => [
            '{{WRAPPER}} .wpopea-opstore-products .titles-port .filter:hover' => 'border-color: {{VALUE}};',
          ],
        ]

      );

      $this->end_controls_tab();

      // Active State Tab
      $this->start_controls_tab( 'uad_tabs_active', [ 'label' => esc_html__( 'Active', 'uncode-addons' ) ] );

      $this->add_control(
        'uad_tabs_active_text_color',
        [
          'label' => esc_html__( 'Text Color', 'uncode-addons' ),
          'type' => Controls_Manager::COLOR,
          'default' => '#f9f9f9',
          'selectors' => [
            '{{WRAPPER}} .wpopea-opstore-products .titles-port .filter.active' => 'color: {{VALUE}};',
          ],
        ]
      );

      $this->add_control(
        'uad_tabs_active_bg_color',
        [
          'label' => esc_html__( 'Background Color', 'uncode-addons' ),
          'type' => Controls_Manager::COLOR,
          'default' => '#3F51B5',
          'selectors' => [
            '{{WRAPPER}} .wpopea-opstore-products .titles-port .filter.active' => 'background: {{VALUE}};',
          ],
        ]
      );

      $this->add_control(
        'uad_tabs_active_border_color',
        [
          'label' => esc_html__( 'Border Color', 'uncode-addons' ),
          'type' => Controls_Manager::COLOR,
          'default' => '',
          'selectors' => [
            '{{WRAPPER}} .wpopea-opstore-products .titles-port .filter.active' => 'border-color: {{VALUE}};',
          ],
        ]

      );

      $this->end_controls_tab();

    $this->end_controls_tabs();

    $this->add_responsive_control(
      'uad_tabs_padding',
      [
        'label' => esc_html__( 'Padding', 'uncode-addons' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .wpopea-opstore-products .titles-port .filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'uad_tabs_margin',
      [
        'label' => esc_html__( 'Margin', 'uncode-addons' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .wpopea-opstore-products .titles-port .filter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );
 

      $this->end_controls_section();  

     $this->start_controls_section(
         'opstore_products_styles',
         [
            'label' => esc_html__( 'Product Styling', 'wpopea' ),
            'tab' => Controls_Manager::TAB_STYLE
         ]
      );
      $this->add_control(
        'title_align',
        [
          'label'                 => __( 'Title Align', 'wpopea' ),
          'type'                  => Controls_Manager::CHOOSE,
          'label_block'           => false,
          'options'               => [
            'left' => [
              'title' => __( 'Left', 'wpopea' ),
              'icon' => 'eicon-h-align-left',
            ],
            'center' => [
              'title' => __( 'Center', 'wpopea' ),
              'icon' => 'eicon-h-align-center',
            ],
            'right' => [
              'title' => __( 'Right', 'wpopea' ),
              'icon' => 'eicon-h-align-right',
            ],
          ],
          'default' => 'center',
            'selectors' => [
               '{{WRAPPER}} .opstore-wc-products ul.products li .content' => 'text-align: {{VALUE}}',
            ]
        ]
      );
      $this->add_control(
        'align_items',
        [
          'label'                 => __( 'Content Align', 'wpopea' ),
          'type'                  => Controls_Manager::CHOOSE,
          'label_block'           => false,
          'options'               => [
            'flex-start' => [
              'title' => __( 'Left', 'wpopea' ),
              'icon' => 'eicon-h-align-left',
            ],
            'center' => [
              'title' => __( 'Center', 'wpopea' ),
              'icon' => 'eicon-h-align-center',
            ],
            'flex-end' => [
              'title' => __( 'Right', 'wpopea' ),
              'icon' => 'eicon-h-align-right',
            ],
          ],
          'default' => 'center',
            'selectors' => [
               '{{WRAPPER}} .opstore-wc-products ul.products li.product .bottom' => 'align-items: {{VALUE}}',
            ]
        ]
      );
      $this->add_control(
         'opstore_block_title_style',
         [
            'label' => esc_html__( 'Block Title Styles', 'wpopea' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
         ]
      ); 
      $this->add_group_control(
         Group_Control_Typography::get_type(),
         [
            'name' => 'product_title_typo',
            'label' => esc_html__( 'Title Typography', 'wpopea' ),
            'selector' => '{{WRAPPER}} ul.products .woocommerce-loop-product__title',
         ]
      );  
      $this->start_controls_tabs( 'icon_colors' );

      $this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'wpopea' ) ] );
      $this->add_control(
         'product_title_color',
         [
            'label' => esc_html__( 'Title Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#2e2e2d',
            'selectors' => [
               '{{WRAPPER}} ul.products .woocommerce-loop-product__title a' => 'color: {{VALUE}}',
               '{{WRAPPER}} ul.products.product-slide .woocommerce-loop-product__title a' => 'color: {{VALUE}}',
               '{{WRAPPER}} ul.products.product-tab .woocommerce-loop-product__title a' => 'color: {{VALUE}}',
               '{{WRAPPER}} ul.products .woocommerce-loop-product__title' => 'color: {{VALUE}}',
            ]

         ]
      );

      $this->end_controls_tab();

      $this->start_controls_tab( 'hover', [ 'label' => esc_html__( 'Hover', 'wpopea' ) ] );
      $this->add_control(
         'product_hover_color',
         [
            'label' => esc_html__( 'Title Hover Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#89c350',
            'selectors' => [
               '{{WRAPPER}} ul.products .woocommerce-loop-product__title a:hover' => 'color: {{VALUE}}',
               '{{WRAPPER}} ul.products.product-slide .woocommerce-loop-product__title a:hover' => 'color: {{VALUE}}',
               '{{WRAPPER}} ul.products.product-tab .woocommerce-loop-product__title a:hover' => 'color: {{VALUE}}',
               '{{WRAPPER}} ul.products .woocommerce-loop-product__title:hover' => 'color: {{VALUE}}',
            ]

         ]
      );

      $this->end_controls_tab();
      $this->end_controls_tabs(); 

      $this->add_control(
         'product_price_color',
         [
            'label' => esc_html__( 'Price Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
               '{{WRAPPER}} .woocommerce-Price-amount.amount' => 'color: {{VALUE}}'
            ]

         ]
      );

      $this->end_controls_section();

      $this->start_controls_section(
         'opstore_saletag_styles',
         [
            'label' => esc_html__( 'Sale Tag', 'wpopea' ),
            'tab' => Controls_Manager::TAB_STYLE
         ]
      );
      $this->add_control(
         'sale_tag_bg_color',
         [
            'label' => esc_html__( 'Background Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#89c350',
            'selectors' => [
               '{{WRAPPER}} ul.products li.product .onsale' => 'background-color: {{VALUE}}',
               '{{WRAPPER}} ul.products.product-slide li.product .onsale' => 'background-color: {{VALUE}}',
               '{{WRAPPER}} ul.products.product-tab li.product .onsale' => 'background-color: {{VALUE}}',
               
            ]

         ]
      );  
      $this->add_control(
         'sale_tag_color',
         [
            'label' => esc_html__( 'Text Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#fff',
            'selectors' => [
               '{{WRAPPER}} ul.products li.product .onsale' => 'color: {{VALUE}}',
               '{{WRAPPER}} ul.products.product-slide li.product .onsale' => 'color: {{VALUE}}',
               '{{WRAPPER}} ul.products.product-tab li.product .onsale' => 'color: {{VALUE}}',
               
            ]

         ]
      );      
      $this->end_controls_section();

      /* Arrows & Dots */
      $this->wpopea_arrows_dots_controls(); 

   }

   protected function render( ) {

      // get our input from the widget settings.
      $settings = $this->get_settings();

        $display_type = !empty( $settings['display_style'] ) ? $settings['display_style'] : 'normal';
        $columns = $settings['columns'];
        $per_page = $settings['per_page'];
        $offset = $settings['offset'];
        $dtype = $settings['product_type'];
        $cat_ids = $settings['category'];

        wc_reset_loop();
        global $woocommerce_loop;
        $woocommerce_loop['columns'] = $columns;
        if($display_type == 'carousel'){
          $columns = '';
        }

       //slider options
        $slide_no = $settings['slide_no'];
        $tslide_no = !empty($settings['slide_no_tablet']) ? $settings['slide_no_tablet'] : $slide_no;
        $mslide_no = !empty($settings['slide_no_mobile']) ? $settings['slide_no_mobile'] : $slide_no;
        
        $slide_item = $settings['slide_item'];
        $tslide_item = !empty($settings['slide_item_tablet']) ? $settings['slide_item_tablet'] : $slide_item;
        $mslide_item = !empty($settings['slide_item_mobile']) ? $settings['slide_item_mobile'] : $slide_item;

        $auto_slide = !empty($settings['auto_slide']) ? 'true' : 'false';
        $show_pager = !empty($settings['show_pager']) ? 'true' : 'false';
        $show_arrow = !empty($settings['show_arrow']) ? 'true' : 'false';
        $infinite_slide = !empty($settings['infinite_slide']) ? 'true' : 'false';

        $this->add_render_attribute( 'opstore-products', 'class', 'wpopea-opstore-products type-'.$display_type.' column-'.$columns );
        if($display_type === 'carousel'){
          $this->add_render_attribute( 'opstore-products', 'data-slide-no', $slide_no );
          $this->add_render_attribute( 'opstore-products', 'data-tslide-no', $tslide_no );
          $this->add_render_attribute( 'opstore-products', 'data-mslide-no', $mslide_no );
          $this->add_render_attribute( 'opstore-products', 'data-slide-item', $slide_item );
          $this->add_render_attribute( 'opstore-products', 'data-tslide-item', $tslide_item );
          $this->add_render_attribute( 'opstore-products', 'data-mslide-item', $mslide_item );
          $this->add_render_attribute( 'opstore-products', 'data-auto-slide', $auto_slide );
          $this->add_render_attribute( 'opstore-products', 'data-show-pager', $show_pager );
          $this->add_render_attribute( 'opstore-products', 'data-show-arrow', $show_arrow );
          $this->add_render_attribute( 'opstore-products', 'data-infinite-slide', $infinite_slide );
        }
        $woocommerce_loop['name'] = 'opstore_products';
        $meta_query = WC()->query->get_meta_query();
        $tax_query = WC()->query->get_tax_query();
        if( $dtype== 'featured' ) {
           $tax_query[] = array(
              'taxonomy' => 'product_visibility',
              'field'    => 'name',
              'terms'    => 'featured',
              'operator' => 'IN',
           );
        }

        if( $display_type == 'tabs' || $dtype == 'category' ){
           $tax_query[] =   array(
                           'taxonomy'      => 'product_cat',
                           'terms'         => $cat_ids,
                           'field'         => 'ID',
                           'operator'      => 'IN'
                       );
        }

        $uniqueid = uniqid();

        $args = array(
           'post_type'         =>  'product',
           'posts_per_page'    =>   $per_page,
           'offset'            =>   $offset,
           'meta_query'        =>   $meta_query,
           'tax_query'         =>   $tax_query,
        );

        if($dtype == 'trending'){
            $args['meta_key'] = 'total_sales';
            unset($args['orderby']);
            $args['orderby'] = 'meta_value_num';
        }

        $mquery = new \WP_Query( $args );
        if( $mquery->have_posts() ):
           echo '<div '.$this->get_render_attribute_string( "opstore-products" ).'>';
           $extra_class = '';
           if( $display_type === 'carousel' ) {
              $extra_class .= 'product-slide';

               wp_enqueue_style('wpopea-slick-style');
               wp_enqueue_style('wpopea-slick-theme-style');
               wp_enqueue_script( 'wpopea-el-slick-js');
           }
           if( $display_type === 'tabs' ){
               $extra_class .= 'product-tab';

               $cat_id_tabs =  $cat_ids ;

               wp_enqueue_script( 'wpopea-el-isotope-js');
               ?>
              <div class="product-tab-filter clearfix">
                  <div class="titles-port">
                      <div class="filter active" data-filter="*"><?php echo esc_html__('All', 'wpopea'); ?></div>
                      <?php
                      if(!empty($cat_id_tabs)){
                          foreach ($cat_id_tabs as $key => $storecat_id) {
                              $term = get_term_by( 'id', $storecat_id, 'product_cat');
                              if(!empty($term)){
                                ?>
                                <div class="filter" data-filter=".product_cat-<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_attr( $term->name ); ?></div> 
                                <?php
                            }
                          }
                      }
                      ?>
                  </div>
              </div>
              <?php
            }
           echo '<div id="'.$uniqueid.'" class="opstore-wc-products opstore-wc-column-'.$columns.'">';
              ?>
              <ul class="products <?php echo esc_attr($extra_class)?>" >
              <?php
              while( $mquery->have_posts() ): $mquery->the_post();
                 wc_get_template_part( 'content', 'product' );
              endwhile;
              echo '</ul>';
              echo '<div class="clearfix"></div>';
           echo '</div>';
            if($display_type == 'tabs'){
              if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
              $this->render_editor_script();
              }
            }
           echo '</div>';
        endif;
        
        wc_reset_loop();
        wp_reset_postdata();
       

   }

  /**
   * Render masonry script
   * 
   * @access protected
   */
  protected function render_editor_script() { ?>
    <script type="text/javascript">
      jQuery(document).ready(function($) {
        $('.wpopea-opstore-products.type-tabs').each(function() {
          var $node_id = '<?php echo $this->get_id(); ?>',
            $scope = $('[data-id="' + $node_id + '"]'),
            tab_element = $(this);

          if (tab_element.closest($scope).length < 1) {
                return;
              }
              var tabSelector = tab_element.find('.product-tab');
              var $grid = tabSelector.imagesLoaded(function() {
                  // init Isotope after all images have loaded
                  $grid.isotope({
                      itemSelector: '.type-product',
                      layoutMode: 'fitRows',
                      percentPosition: true,
                      stagger: 30,
                  });
              });

              var filter_tab = tab_element.find('.product-tab-filter');
              filter_tab.on('click', '.filter', function() {
                  $('.product-tab-filter .filter').removeClass('active');
                  $(this).addClass('active');
                  var filterValue = $(this).attr('data-filter');

                  $('.product-tab').isotope({
                      filter: filterValue
                  });
              });

             // resize
             $('.type-product', tab_element).resize(function() {
                $('.product-tab').isotope({
                    filter: filterValue
                });
             });
          });    

      });
    </script> 

    <?php
    }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}

Plugin::instance()->widgets_manager->register_widget_type( new Widget_Opstore_Products() );
<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Opstore_Header_Icons extends Widget_Base {

   use \Elementor\WPOPEACommonFunctions;

   public function get_title() {
      return esc_html__( 'Header Icons', 'wpopea' );
   }

   public function get_icon() {
      return 'eicon-favorite';
   }
   public function get_categories() {
      return [ 'opstore-elements' ];
   }
   public function get_name() {
      return 'opstore-header-icon';
   }


   protected function _register_controls() {

      $this->start_controls_section(
         'opstore_sections_list',
         [
            'label' => esc_html__( 'Display Settings', 'wpopea' )
         ]
      ); 

      $this->add_control(
         'icon_type',
         [
            'label' => esc_html__( 'Icon Type', 'wpopea' ),
            'type' => Controls_Manager::SELECT,
            'options' => [
                       'search'   => esc_html__('Search','wpopea'),
                       'cart' => esc_html__('Cart','wpopea'),
                       'wishlist'     => esc_html__('Wishlist','wpopea'),
                       'compare'  => esc_html__('Compare','wpopea'),
                       'user'     => esc_html__('User Account','wpopea'),
            ],
            'default' => 'search'
         ]
      );

      $this->add_control(
          'show_price',
          [
              'label'             => __( 'Show Price', 'wpopea' ),
              'type'              => Controls_Manager::SWITCHER,
              'default'           => 'yes',
              'label_on'          => __( 'Show', 'wpopea' ),
              'label_off'         => __( 'Hide', 'wpopea' ),
              'return_value'      => 'yes',
              'condition'         => ['icon_type' => 'cart']
          ]
      );

/*      $this->add_control(
         'minicart_style',
         [
            'label' => esc_html__( 'Minicart Style', 'wpopea' ),
            'type' => Controls_Manager::SELECT,
            'options' => [
                       'dropdown'   => esc_html__('Dropdown','wpopea'),
                       'offcanvas' => esc_html__('Off Canvas','wpopea'),
            ],
            'default' => 'dropdown',
            'condition'         => ['icon_type' => 'cart']
         ]
      );*/

      $this->add_control(
         'header_icon',
      [
      'label' => esc_html__( 'Choose Icon', 'wpopea' ),
      'type' => Controls_Manager::ICONS,
      'default' => [
          'value'=>'fas fa-search',
          'library'=>'solid',
      ],      
      ]
      );

      $this->add_control(
         'custom_icon',
      [
      'label' => esc_html__( 'Custom Icon', 'wpopea' ),
      'type' => Controls_Manager::TEXT,
      'description' => esc_html__( 'If you have custom icons then you can add its class here.eg: fa fa-cart', 'wpopea' ),
      ]
      );

      $this->end_controls_section();



      $this->start_controls_section(
         'icon_styles',
         [
            'label' => esc_html__( 'Icon Styles', 'wpopea' ),
            'tab' => Controls_Manager::TAB_STYLE
         ]
      );

  $this->add_control(
    'align_items',
    [
      'label'                 => __( 'Align', 'wpopea' ),
      'type'                  => Controls_Manager::CHOOSE,
      'label_block'           => false,
      'options'               => [
        'text-left' => [
          'title' => __( 'Left', 'wpopea' ),
          'icon' => 'eicon-h-align-left',
        ],
        'text-center' => [
          'title' => __( 'Center', 'wpopea' ),
          'icon' => 'eicon-h-align-center',
        ],
        'text-right' => [
          'title' => __( 'Right', 'wpopea' ),
          'icon' => 'eicon-h-align-right',
        ],
      ],
      'default' => 'text-center'
    ]
  );

      $this->add_responsive_control(
         'font_size',
         [
         'label' => esc_html__( 'Font Size', 'wpopea' ),
         'type' => Controls_Manager::NUMBER,
         'default' => 20,
        'selectors' => [
           '{{WRAPPER}} .icon' => 'font-size: {{VALUE}}px',
        ]
         ]
      );

      $this->start_controls_tabs( 'icon_colors' );

      $this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'wpopea' ) ] );
      $this->add_control(
         'icon_color',
         [
            'label' => esc_html__( 'Icon Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#000',
            'selectors' => [
               '{{WRAPPER}} .icon, {{WRAPPER}} .total-price' => 'color: {{VALUE}}',
            ]

         ]
      );

      $this->end_controls_tab();

      $this->start_controls_tab( 'hover', [ 'label' => esc_html__( 'Hover', 'wpopea' ) ] );
      $this->add_control(
         'icon_hover_color',
         [
            'label' => esc_html__( 'Hover Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#89c350',
            'selectors' => [
               '{{WRAPPER}} .icon:hover' => 'color: {{VALUE}}',
               '{{WRAPPER}} span.wishlist-count.wishlist-rounded, {{WRAPPER}} .cart-icon .count, {{WRAPPER}} .compare-icon' => 'background: {{VALUE}}'
            ]

         ]
      );

      $this->end_controls_tab();

      $this->end_controls_tabs();      
      $this->end_controls_section();
   }

   protected function render( ) {

      // get our input from the widget settings.
      $settings = $this->get_settings();

        $icon_type = $settings['icon_type'];
        $icon = $settings['header_icon'];
        $custom_icon = $settings['custom_icon'];
        if($custom_icon){
          $icon = $settings['custom_icon'];
        }
        $align_items = $settings['align_items'];
        $show_price = $settings['show_price'];
/*        $minicart_style = $settings['minicart_style'];
        if($minicart_style == 'dropdown'){
          $class= "on-hover";
        }else{
          $class = '';
        }*/

        global $woocommerce;  

        if($icon_type == 'cart'){
            if( function_exists('WC')): ?>
              <div class="site-header-cart menu <?php echo esc_attr($class);?>">
                <div class="header-cart cart-icon <?php echo esc_attr($align_items);?>">
                    <a href="#" data-toggle="dropdown" title="<?php echo esc_attr__('cart','wpopea'); ?>">
                        <?php if($show_price == 'yes'){?>
                        <span class="total-price">
                        <?php
                            if(!empty($woocommerce->cart)){
                              $price = get_woocommerce_currency_symbol();
                              echo esc_html($price.$woocommerce->cart->total);
                            }
                          ?>
                        </span>
                        <?php }?>
                        <span class="count rounded-crcl"><?php //echo WC()->cart->get_cart_contents_count(); ?></span>
                        <?php if($custom_icon){?>
                        <i class="icon <?php echo esc_attr($icon);?>"></i>
                        <?php }else{ echo Wpopea_Icon_manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); }?>
                    </a>
                </div>
              </div>
            <?php endif;
        }elseif($icon_type == 'compare'){
          global $yith_woocompare;
          
          $sm_yith_count = isset($yith_woocompare->obj->products_list) ? $yith_woocompare->obj->products_list : 0;
          $sm_yith_count = count($sm_yith_count);
          ?>
          <div class="header-compare-btn <?php echo esc_attr($align_items);?>">
              <a class="yith-contents yith-woocompare-open" href="#" title="<?php esc_attr_e('My Compare','opstore')?>">
                  <?php if($custom_icon){?>
                  <i class="icon <?php echo esc_attr($icon);?>"></i>
                  <?php }else{ echo Wpopea_Icon_manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); }?>
                  <span class="compare-icon">
                      <?php 
                       echo absint($sm_yith_count);
                      ?>
                  </span>
              </a>
          </div>
          <?php

        }elseif($icon_type == 'wishlist'){
            if( function_exists('yith_wishlist_constructor') ):
                $wishlist_page = get_option('yith_wcwl_wishlist_page_id');
                $link = '#';
                if( $wishlist_page ) {
                    $link = get_permalink( $wishlist_page );
                }
                $wishlist_count = YITH_WCWL()->count_products();
                ?>
                <div class="header-wishlist-icon <?php echo esc_attr($align_items);?>">
                    <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr__('wishlist','wpopea');?>">
                        <?php  ?>
                        <span class="wishlist-count wishlist-rounded"><?php echo esc_attr( $wishlist_count ); ?></span>
                        <?php if($custom_icon){?>
                        <i class="icon <?php echo esc_attr($icon);?>"></i>
                        <?php }else{ echo Wpopea_Icon_manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); }?>
                    </a>
                </div>
                <?php
            endif;
        }elseif($icon_type == 'user'){
            if( function_exists( 'WC' ) ){ 
                if(defined('LRM_VERSION')){
                    ?>
                    <div class="header-login <?php echo esc_attr($align_items);?>"> 
                        <a href="/wp-login.php" class="btn-login lrm-login">
                          <?php if($custom_icon){?>
                          <i class="icon <?php echo esc_attr($icon);?>"></i>
                          <?php }else{ echo Wpopea_Icon_manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); }?>
                        </a>
                    </div>
                    <?php
                } 
                else{ ?>
                    <div class="header-login <?php echo esc_attr($align_items);?>"> 
                        <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" class="btn-login" >
                            <?php if($custom_icon){?>
                            <i class="icon <?php echo esc_attr($icon);?>"></i>
                            <?php }else{ echo Wpopea_Icon_manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); }?>
                            </a>
                    </div>
                    <?php
                }

            }   
        }elseif($icon_type == 'search'){
        ?>
            <div class="header-searchbox <?php echo esc_attr($align_items);?>">
            <span class="searchbox-icon">
              <?php if($custom_icon){?>
              <i class="icon <?php echo esc_attr($icon);?>"></i>
              <?php }else{ echo Wpopea_Icon_manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); }?>
            </span>
            </div>
        <?php
        }else{

        }
   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}

Plugin::instance()->widgets_manager->register_widget_type( new Widget_Opstore_Header_Icons() );
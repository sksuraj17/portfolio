<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Wpop_Woo_Block extends Widget_Base {

   public function get_title() {
      return esc_html__( 'Woo Block', 'wpopea' );
   }

   public function get_icon() {
      return 'eicon-woocommerce';
   }
   public function get_categories() {
      return [ 'ultra-elements' ];
   }
   public function get_name() {
      return 'wpop-woo-block';
   }
   
    public function is_reload_preview_required() {
      return true;  
    }


   protected function _register_controls() {
      
      /* Block Settings */
      $this->start_controls_section(
         'wpop_block_settings',
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
         'header_text',
         [
         'label' => esc_html__( 'Header Text', 'wpopea' ),
         'type' => Controls_Manager::TEXT,
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
         'label_block' => true,
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
           'default' => 0,
           'min' => 0
        ]
      );

      $this->end_controls_section();


      /* Style Settings*/
      $this->start_controls_section(
         'wpop_latest_posts_styles',
         [
            'label' => esc_html__( 'Colors & Typography', 'wpopea' ),
            'tab' => Controls_Manager::TAB_STYLE
         ]
      );
      $this->add_control(
         'wpop_block_title_style',
         [
            'label' => esc_html__( 'Block Title Styles', 'wpopea' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
         ]
      );   
      $this->add_control(
         'wpop_block_title_color',
         [
            'label' => esc_html__( 'Block Title Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
               '{{WRAPPER}} h4.entry-title a' => 'color: {{VALUE}}',
            ]

         ]
      );

      $this->add_control(
         'wpop_title_hover_color',
         [
            'label' => esc_html__( 'Title Hover Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#89c350',
            'selectors' => [
               '{{WRAPPER}} h4.entry-title a:hover' => 'color: {{VALUE}}',
            ]

         ]
      );

      $this->add_group_control(
         Group_Control_Typography::get_type(),
         [
            'name' => 'wpop_block_title_typo',
            'label' => esc_html__( 'Title Typography', 'wpopea' ),
            'selector' => '{{WRAPPER}} h4.entry-title',
         ]
      );         
      $this->end_controls_section();

   }

   protected function render( ) {

	    // get our input from the widget settings.
	    $settings = $this->get_settings();
	    $header_text = $settings['header_text'];
        $dtype = $settings['product_type'];
        $per_page = $settings['per_page'];
        $offset = $settings['offset'];
        $cat_ids = $settings['category'];

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

        if( $dtype == 'category' ){
           $tax_query[] =   array(
                           'taxonomy'      => 'product_cat',
                           'terms'         => $cat_ids,
                           'field'         => 'ID',
                           'operator'      => 'IN'
                       );
        }

        $args = array(
           'post_type'         =>  'product',
           'posts_per_page'    =>   $per_page,
           'offset'            =>   $offset,
           'order'             =>   'ASC',
           'orderby'           =>   'ID',
           'meta_query'        =>   $meta_query,
           'tax_query'         =>   $tax_query,
        );

        if($dtype == 'trending'){
            $args['meta_key'] = 'total_sales';
            unset($args['orderby']);
            $args['orderby'] = 'meta_value_num';
        }

        ?>
		<div class=" ultra-block-wrapper woo-tab-slider">                
		    <div class="ultra-container">
				<?php
				if(class_exists('woocommerce')):
   
				?>
		        <div class="block-title-wrap clearfix">
		            <div class="ultra_sevenAction">
		                <div class="ultra-lSPrev"></div>
		                <div class="ultra-lSNext"></div>
		            </div>
		        </div>
		        <?php if($header_text){?>                   
		        <div class="block-header style1 clearfix">
		            <div class="header"><?php echo esc_html($header_text); ?> </div>
		        </div><!-- .block-header-->
		        <?php }?>
		        <div class="ultra-tab-content clearfix">
		           
		            <div class="tabs-content-wrap store-product">                        
		                <div class="tabs-product-area">    
		                    <ul class="tabs-cat-product cS-hidden">                            
		                        <?php 
		                        $query = new \WP_Query($args);
		                        if($query->have_posts()) { while($query->have_posts()) { $query->the_post();
		                        ?>
		                        <?php wc_get_template_part( 'content', 'product' ); ?>
		                            
		                        <?php } } wp_reset_postdata(); ?>
		                    </ul>
		                </div>
		            </div>
		        </div>
				<?php 
				else:
					echo '<p>'.esc_html__('Woocommerce Plugin is Deactivated','wpopea').'</p>';
				endif; 
				?>
		    </div>
		</div>
        <?php


   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}

Plugin::instance()->widgets_manager->register_widget_type( new Widget_Wpop_Woo_Block() );
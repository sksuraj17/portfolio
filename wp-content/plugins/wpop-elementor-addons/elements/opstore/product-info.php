<?php
namespace Elementor;


if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.


class Widget_Opstore_Product_Info extends Widget_Base {
	

	public function get_name() {
		return 'opstore-product-info';
	}

	public function get_title() {
		return esc_html__( 'Opstore Product Lists', 'wpopea' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

   public function get_categories() {
		return [ 'opstore-elements' ];
	}


	protected function _register_controls() {

		// Content Controls
  		$this->start_controls_section(
  			'opstore_section_product_info_settings',
  			[
  				'label' => esc_html__( 'Product Settings', 'wpopea' )
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
			'opstore_product_info_categories',
			[
				'label' => esc_html__( 'Product Categories', 'wpopea' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => get_post_type_categories('product_cat'),
		        'condition' => [
		            'product_type' => 'category'
		        ]
			]
		);

		$this->add_control(
		  'opstore_product_info_products_count',
		  [
		     'label'   => esc_html__( 'Products Count', 'wpopea' ),
		     'type'    => Controls_Manager::NUMBER,
		     'default' => 4,
		     'min'     => 1,
		     'max'     => 1000,
		     'step'    => 1,
		  ]
		);


		$this->add_control(
		  'opstore_product_info_products_offset',
		  [
		     'label'   => esc_html__( 'Offset Value', 'wpopea' ),
		     'type'    => Controls_Manager::NUMBER,
		     'min'     => 0,
		     'max'     => 1000,
		     'step'    => 1,
		  ]
		);


		$this->add_control(
			'opstore_product_info_rating',
			[
				'label' => esc_html__( 'Show Product Rating?', 'wpopea' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);


		$this->add_control(
			'opstore_show_excerpt',
			[
				'label' => esc_html__( 'Show Excerpt?', 'wpopea' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
		  'opstore_excerpt_length',
		  [
		     'label'   => esc_html__( 'Excerpt Length', 'wpopea' ),
		     'type'    => Controls_Manager::NUMBER,
		     'min'     => 1,
		     'max'     => 50,
		     'step'    => 1,
		     'default' => 10,
		     'condition' => ['opstore_show_excerpt' => 'yes']
		  ]
		);

		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'opstore_product_info_styles',
			[
				'label' => esc_html__( 'Products Styles', 'wpopea' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'opstore_product_info_background_color',
			[
				'label' => esc_html__( 'Content Background Color', 'wpopea' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .opstore-product-info .ops-wrap .product' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'opstore_product_info_border',
				'selector' => '{{WRAPPER}} .opstore-product-info .ops-wrap .product',
			]
		);
		
		$this->add_control(
			'opstore_product_info_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'wpopea' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .opstore-product-info .ops-wrap .product' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);
				
		
		$this->end_controls_section();


		$this->start_controls_section(
			'opstore_section_product_info_typography',
			[
				'label' => esc_html__( 'Color &amp; Typography', 'wpopea' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'opstore_product_info_product_title_heading',
			[
				'label' => __( 'Product Title', 'wpopea' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'opstore_product_info_product_title_color',
			[
				'label' => esc_html__( 'Product Title Color', 'wpopea' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#272727',
				'selectors' => [
					'{{WRAPPER}} .opstore-product-info .product-title a' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'opstore_product_info_product_title_typography',
				'selector' => '{{WRAPPER}} .opstore-product-info .product-title',
			]
		);

		$this->add_control(
			'opstore_product_info_product_price_heading',
			[
				'label' => __( 'Product Price', 'wpopea' ),
				'type' => Controls_Manager::HEADING,
			]
		);


		$this->add_control(
			'opstore_product_info_product_price_color',
			[
				'label' => esc_html__( 'Product Price Color', 'wpopea' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#272727',
				'selectors' => [
					'{{WRAPPER}} .opstore-product-info .ops-wrap .product .price' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'opstore_product_info_product_price_typography',
				'selector' => '{{WRAPPER}} .opstore-product-info .ops-wrap .product .price',
			]
		);

		$this->add_control(
			'opstore_product_info_product_rating_heading',
			[
				'label' => __( 'Star Rating', 'wpopea' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'opstore_product_info_product_rating_color',
			[
				'label' => esc_html__( 'Rating Color', 'wpopea' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f2b01e',
				'selectors' => [
					'{{WRAPPER}} .opstore-product-info .ops-wrap .product .star-rating::before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .opstore-product-info .ops-wrap .product .star-rating span::before' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'opstore_product_info_product_rating_typography',
				'selector' => '{{WRAPPER}} .opstore-product-info .ops-wrap .product .star-rating',
			]
		);

		$this->add_control(
			'opstore_product_info_sale_badge_heading',
			[
				'label' => __( 'Sale Badge', 'wpopea' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'opstore_product_info_sale_badge_color',
			[
				'label' => esc_html__( 'Sale Badge Color', 'wpopea' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .opstore-product-grid:not(.opstore-product-no-style) .onsale' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'opstore_product_info_sale_badge_background',
			[
				'label' => esc_html__( 'Sale Badge Background', 'wpopea' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ff2a13',
				'selectors' => [
					'{{WRAPPER}} .opstore-product-grid:not(.opstore-product-no-style) .onsale' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'opstore_product_info_sale_badge_typography',
				'selector' => '{{WRAPPER}} .opstore-product-grid:not(.opstore-product-no-style) .onsale',
			]
		);


		$this->end_controls_section();

		
		$this->start_controls_section(
			'opstore_section_product_info_add_to_cart_styles',
			[
				'label' => esc_html__( 'Add to Cart Button Styles', 'wpopea' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'button_typo',
				'selector' => '{{WRAPPER}} a.add_to_cart_button',
			]
		);
	      $this->start_controls_tabs( 'button_colors' );

	      $this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'wpopea' ) ] );
	      $this->add_control(
	         'button_bg_color',
	         [
	            'label' => esc_html__( 'Background Color', 'wpopea' ),
	            'type' => Controls_Manager::COLOR,
	            'default' => '#2e2e2d',
	            'selectors' => [
	               '{{WRAPPER}} a.add_to_cart_button' => 'background-color: {{VALUE}}'
	            ]

	         ]
	      );
	      $this->add_control(
	         'button_text_color',
	         [
	            'label' => esc_html__( 'Text Color', 'wpopea' ),
	            'type' => Controls_Manager::COLOR,
	            'default' => '#fff',
	            'selectors' => [
	               '{{WRAPPER}} a.add_to_cart_button' => 'color: {{VALUE}}'
	            ]

	         ]
	      );
	      $this->end_controls_tab();

	      $this->start_controls_tab( 'hover', [ 'label' => esc_html__( 'Hover', 'wpopea' ) ] );
	      $this->add_control(
	         'button_bg_hcolor',
	         [
	            'label' => esc_html__( 'Background Color', 'wpopea' ),
	            'type' => Controls_Manager::COLOR,
	            'default' => '#2e2e2d',
	            'selectors' => [
	               '{{WRAPPER}} a.add_to_cart_button:hover' => 'background-color: {{VALUE}}'
	            ]

	         ]
	      );
	      $this->add_control(
	         'button_text_hcolor',
	         [
	            'label' => esc_html__( 'Text Color', 'wpopea' ),
	            'type' => Controls_Manager::COLOR,
	            'default' => '#fff',
	            'selectors' => [
	               '{{WRAPPER}} a.add_to_cart_button:hover' => 'color: {{VALUE}}'
	            ]

	         ]
	      );

	      $this->end_controls_tab();
	      $this->end_controls_tabs(); 


		$this->end_controls_section();
		
		
	}


	protected function render( ) {
		
			
		$settings = $this->get_settings();
			
		$product_count = $this->get_settings( 'opstore_product_info_products_count' );
		$offset_val		= $this->get_settings( 'opstore_product_info_products_offset' );
		$show_rating = $settings['opstore_product_info_rating'];
		$p_type = $settings['product_type'];
		$cat_ids = $settings['opstore_product_info_categories']; // get custom field value
		$show_excerpt = $settings['opstore_show_excerpt'];
		$excerpt = $settings['opstore_excerpt_length'];

        $meta_query = WC()->query->get_meta_query();
        $tax_query = WC()->query->get_tax_query();

        if( $p_type== 'featured' ) {
           $tax_query[] = array(
              'taxonomy' => 'product_visibility',
              'field'    => 'name',
              'terms'    => 'featured',
              'operator' => 'IN',
           );
        }

        if( $p_type == 'category' ){
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
           'posts_per_page'    =>   $product_count,
           'offset'            =>   $offset_val,
           'order'             =>   'ASC',
           'orderby'           =>   'ID',
           'meta_query'        =>   $meta_query,
           'tax_query'         =>   $tax_query,
        );

        if($p_type == 'trending'){
            $args['meta_key'] = 'total_sales';
            unset($args['orderby']);
            $args['orderby'] = 'meta_value_num';
        }
	?>



<div id="opstore-product-info-<?php echo esc_attr($this->get_id()); ?>" class="opstore-product-info">
        <?php
        $query = new \WP_Query( $args );
        ?>
        <div class="ops-wrap woocommerce">
            <?php if ( $query->have_posts() ) : ?>
                    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <div <?php post_class('clear'); ?>>
                        <div class="item-img">
                        	<a href="<?php the_permalink();?>">
                                <?php woocommerce_template_loop_product_thumbnail();?>
                             </a>   
                        </div>
                        <div class="item-info-wrap">
                        	<h6 class="product-title">
                             <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                             </a>
                            </h6>
                            <div class="woo-price-wrapp">
	                            <?php 
	                            global $product;
                                $rating = $product->get_average_rating();
	                            if( $rating && $show_rating == 'yes' ){ ?>
	                            <div class="product-rating">
	                            	<?php woocommerce_template_loop_rating(); ?>
	                            </div>
	                            <?php } ?>
	                            <div class="item-price">
	                                <?php woocommerce_template_loop_price(); ?>   
	                            </div>
	                            <?php if($show_excerpt){?>
	                            <div class="item-desc">
	                            	<?php echo wp_trim_words(get_the_excerpt(),$excerpt,'...')?>
	                            </div>
	                            <?php }?>
	                        </div>
	                        <?php woocommerce_template_loop_add_to_cart();?>
                        </div>    
                        
                    </div>
                    <?php endwhile;
                     wp_reset_postdata(); 
                    ?>
            <?php endif; ?>
        </div>
    <div class="clearfix"></div>
</div>
	
	<?php

	}
	protected function content_template() {

	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Opstore_Product_Info() );
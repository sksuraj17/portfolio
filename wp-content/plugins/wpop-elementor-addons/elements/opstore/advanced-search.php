<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Opstore_Advanced_Search extends Widget_Base {

   public function get_title() {
      return esc_html__( 'Advanced Product Search', 'wpopea' );
   }

   public function get_icon() {
      return 'eicon-search';
   }
   public function get_categories() {
      return [ 'opstore-elements' ];
   }

   public function get_name() {
      return 'opstore-advance-search';
   }


   protected function _register_controls() {

		$this->start_controls_section(
			'opstore_sections_list',
			[
			    'label' => esc_html__( 'Display Settings', 'wpopea' )
			]
		); 
		$this->add_control(
			'search_type',
			[
			'label' => esc_html__( 'Search Type', 'wpopea' ),
			'type' => Controls_Manager::SELECT,
			'options' => [
			           'normal'   => esc_html__('Normal','wpopea'),
			           'ajax'     => esc_html__('Ajax','wpopea'),
			],
			'default' => 'normal'
			]
		);
		$this->add_control(
			'placeholder',
			[
			    'label' => esc_html__( 'Placeholder', 'wpopea' ),
			    'type' => Controls_Manager::TEXT,
			    'default' => 'Search...'
			]
		);

    $this->add_control('show_category',
        [
            'label'         => esc_html__('Category Dropdown', 'wpopea'),
            'type'          => Controls_Manager::SWITCHER,
            'default'       => 'yes'
        ]
    );

    $this->add_control('show_submit_btn',
        [
            'label'         => esc_html__('Submit Button', 'wpopea'),
            'type'          => Controls_Manager::SWITCHER,
            'default'       => 'yes'
        ]
    );

      $this->end_controls_section();


      $this->start_controls_section(
         'opstore_products_styles',
         [
            'label' => esc_html__( 'Button Style', 'wpopea' ),
            'tab' => Controls_Manager::TAB_STYLE
         ]
      );

      $this->start_controls_tabs( 'buttons_color' );

      $this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'wpopea' ) ] );
      $this->add_control(
         'button_color',
         [
            'label' => esc_html__( 'Button Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#89c350',
            'selectors' => [
               '{{WRAPPER}} .advance-product-search .woocommerce-product-search .searchsubmit' => 'background-color: {{VALUE}}',
            ]

         ]
      );

      $this->add_control(
         'text_color',
         [
            'label' => esc_html__( 'Text Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#fff',
            'selectors' => [
               '{{WRAPPER}} .advance-product-search .woocommerce-product-search .searchsubmit' => 'color: {{VALUE}}',
            ]

         ]
      );
      $this->end_controls_tab();

      $this->start_controls_tab( 'hover', [ 'label' => esc_html__( 'Hover', 'wpopea' ) ] );
      $this->add_control(
         'button_hover_color',
         [
            'label' => esc_html__( 'Button Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#89c350',
            'selectors' => [
               '{{WRAPPER}} .advance-product-search .woocommerce-product-search .searchsubmit:hover' => 'background-color: {{VALUE}}',
            ]

         ]
      );

      $this->add_control(
         'text_hover_color',
         [
            'label' => esc_html__( 'Text Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#fff',
            'selectors' => [
               '{{WRAPPER}} .advance-product-search .woocommerce-product-search .searchsubmit:hover' => 'color: {{VALUE}}',
            ]

         ]
      );

      $this->end_controls_tab();

      $this->end_controls_tabs();

      $this->add_control(
         'border_color',
         [
            'label' => esc_html__( 'Border Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#f0f0f0',
            'selectors' => [
               '{{WRAPPER}} .advance-product-search .woocommerce-product-search .searchsubmit, {{WRAPPER}} .advance-product-search .woocommerce-product-search .search-field, {{WRAPPER}} .advance-product-search .woocommerce-product-search .es-select-products' => 'border-color: {{VALUE}}',
            ]

         ]
      );

      $this->add_responsive_control(
          'border_radius',
          [
              'label'                 => __( 'Border Radius', 'wpopea' ),
              'type'                  => Controls_Manager::SLIDER,
              'default'               => [
                  'size'      => '0',
                  'unit'      => 'px',
              ],
              'range'                 => [
                  'px'        => [
                      'min'   => 0,
                      'max'   => 100,
                      'step'  => 1,
                  ],
              ],
              'size_units'            => [ 'px', '%' ],
              'selectors'             => [
                  '{{WRAPPER}} .advance-product-search .woocommerce-product-search .search-field' => 'border-radius: {{SIZE}}{{UNIT}}',
              ],
          ]
      );

    
      $this->end_controls_section();

   }

   protected function render( ) {

        // get our input from the widget settings.
        $settings = $this->get_settings();

        $search_type = $settings['search_type'];
        $show_category = $settings['show_category'];
        $placeholder = $settings['placeholder'];
        $submit_btn = $settings['show_submit_btn'];
        if($search_type == 'ajax'){
            $class = 'ajax-search';
        }else{
            $class = '';
        }
        ?>
	    <div class="es-advance-product-search-wrapper">
	        <div class="advance-product-search">
	            <form role="search" method="get" class="woocommerce-product-search <?php echo esc_attr($class);?>" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	            <input type="search" id="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" class="search-field op-srch" placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off"/>
	            <?php
	                $woo_terms = get_terms( array(
	                    'taxonomy'   => 'product_cat',
	                    'hide_empty' => true,
	                    'parent'     => 0,
	                ) );
	                if (  ! empty( $woo_terms ) && ! is_wp_error( $woo_terms ) && $show_category == 'yes' ) {
	                    $select_cat = ( isset( $_GET['product_category'] ) ) ? absint( $_GET['product_category'] ) : '' ;
	                ?>
	                    <select id="search-cat" class="es-select-products op-srch" name="product_category">
	                        <option value=""><?php esc_html_e( 'All Categories', 'opstore' ); ?></option>
	                        <?php foreach ( $woo_terms as $cat ) { ?>
	                            <option value="<?php echo esc_attr( $cat->term_id ); ?>" <?php selected( $select_cat, $cat->term_id ); ?> ><?php echo esc_html( $cat->name ); ?></option>
	                        <?php } ?>
	                    </select>
	            <?php } ?>
                  <?php if($submit_btn == 'yes'){?>
	                <button class="fa fa-search searchsubmit op-srch" type="submit"></button>
                  <?php }?>
	                <input type="hidden" name="post_type" value="product" />
	                <?php if($search_type == 'ajax'){ ?>
	                <div id="datafetch" class="scroll" style="display:none"></div>
	                <?php }?>
	            </form>
	        </div>
	    </div>
	    <?php
   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}

Plugin::instance()->widgets_manager->register_widget_type( new Widget_Opstore_Advanced_Search() );
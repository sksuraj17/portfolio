<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Wpop_Block_Header extends Widget_Base {

   public function get_title() {
      return esc_html__( 'Block Header', 'wpopea' );
   }

   public function get_icon() {
      return 'eicon-post-list';
   }
   public function get_categories() {
      return [ 'ultra-elements' ];
   }
   public function get_name() {
      return 'wpop-block-header';
   }

   protected function _register_controls() {
      global $wpop_cat_dropdown;
      $this->start_controls_section(
         'wpop_sections_list',
         [
            'label' => esc_html__( 'Display Settings', 'wpopea' )
         ]
      ); 
      $this->add_control(
         'wpop_header_text',
         [
            'label' => esc_html__( 'Header Text', 'wpopea' ),
            'type' => Controls_Manager::TEXT,
         ]
      ); 
      $this->add_control(
         'header_layout',
         [
            'label' => esc_html__( 'Header Style', 'wpopea' ),
            'type' => Controls_Manager::SELECT,
            'options' => [
                       'style1'   => esc_html__('Style1','wpopea'),
                       'style2'     => esc_html__('Style2','wpopea'),
                       'style3'     => esc_html__('Style3','wpopea'),
            ],
            'default' => 'style1'
         ]
      );

      $this->end_controls_section();


      /* Style Settings */
      $this->start_controls_section(
         'wpop_header_styles',
         [
            'label' => esc_html__( 'Header Styles', 'wpopea' ),
            'tab' => Controls_Manager::TAB_STYLE
         ]
      );
 
      $this->add_control(
         'wpop_header_text_color',
         [
            'label' => esc_html__( 'Text Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#fff',
            'selectors' => [
               '{{WRAPPER}} .block-header .header' => 'color: {{VALUE}}',
            ]

         ]
      );

      $this->add_control(
         'wpop_header_bg_color',
         [
            'label' => esc_html__( 'Background Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
               '{{WRAPPER}} .block-header.style1 .header, {{WRAPPER}} .block-header.style3 .header:after' => 'background-color: {{VALUE}}',
               '{{WRAPPER}} .block-header.style1, {{WRAPPER}} .block-header.style2' => 'border-color: {{VALUE}}',
               '{{WRAPPER}} .block-header.style1 .header:before' => 'border-color: transparent transparent transparent {{VALUE}}'
            ]

         ]
      );

      $this->add_group_control(
         Group_Control_Typography::get_type(),
         [
            'name' => 'wpop_block_title_typo',
            'label' => esc_html__( 'Title Typography', 'wpopea' ),
            'selector' => '{{WRAPPER}} .block-header .header',
         ]
      );         
      $this->end_controls_section();

   }

    protected function render( ) {

	    // get our input from the widget settings.
	    $settings = $this->get_settings();
        $header_text = $settings['wpop_header_text'];
        $header_layout = $settings['header_layout'];
        if($header_text){
        ?>
        <div class="ultra-block-wrapper">
	        <div class="block-header <?php echo esc_attr($header_layout);?> clearfix">
	            <div class="header"><?php echo esc_html($header_text); ?> </div>
	        </div><!-- .block-header-->
        </div>
        <?php
        }
    }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}

Plugin::instance()->widgets_manager->register_widget_type( new Widget_Wpop_Block_Header() );
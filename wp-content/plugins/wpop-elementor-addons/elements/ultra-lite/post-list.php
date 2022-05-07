<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Wpop_Post_List extends Widget_Base {

   use \Elementor\WPOPEACommonFunctions;

   public function get_title() {
      return esc_html__( 'Post List', 'wpopea' );
   }

   public function get_icon() {
      return 'eicon-post-list';
   }
   public function get_categories() {
      return [ 'ultra-elements' ];
   }
   public function get_name() {
      return 'wpop-post-list';
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'wpop_sections_list',
         [
            'label' => esc_html__( 'Display Settings', 'wpopea' )
         ]
      ); 

      $this->add_control(
         'block_layout',
         [
            'label' => esc_html__( 'Block Layout', 'wpopea' ),
            'type' => Controls_Manager::SELECT,
            'options' => [
                       'layout-1'   => esc_html__('Layout1','wpopea'),
                       'layout-2'     => esc_html__('Layout2','wpopea'),
                       'layout-3'     => esc_html__('Layout3','wpopea'),
            ],
            'default' => 'layout-1'
         ]
      );

      $this->end_controls_section();

      /* Query Settings */
      $this->wpopea_query_controls();

      /* Meta Settings */
      $this->wpopea_meta_controls();
      
      /* 
      ** Title Styles 
      **/
      $this->start_controls_section(
        'wpop_title_style_settings',
        [
          'label' => esc_html__( 'Title Style ', 'wpopea' ),
          'tab' => Controls_Manager::TAB_STYLE
        ]
      );

      $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
          'name' => 'wpop_cat_title_typography',
          'selector' => '{{WRAPPER}} .post-list-wraper .post-caption h3',
        ]
      );

      $this->start_controls_tabs( 'wpop_title_tabs' );

        // Normal State Tab
        $this->start_controls_tab( 'wpop_title_normal', [ 'label' => esc_html__( 'Normal', 'wpopea' ) ] );

        $this->add_control(
          'wpop_title_color',
          [
            'label' => esc_html__( 'Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
              '{{WRAPPER}} .post-list-wraper .post-caption h3 a' => 'color: {{VALUE}};',
            ],
          ]
        );

        $this->end_controls_tab();
        // Hover State Tab
        $this->start_controls_tab( 'wpop_title_hover', [ 'label' => esc_html__( 'Hover', 'wpopea' ) ] );

        $this->add_control(
          'wpop_title_hcolor',
          [
            'label' => esc_html__( 'Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
              '{{WRAPPER}} .post-list-wraper .post-caption h3 a:hover' => 'color: {{VALUE}};',
            ],
          ]
        );

        $this->end_controls_tab();

      $this->end_controls_tabs(); 

      $this->add_responsive_control(
        'wpop_title_padding',
        [
          'label' => esc_html__( 'Padding', 'wpopea' ),
          'type' => Controls_Manager::DIMENSIONS,
          'size_units' => [ 'px', 'em', '%' ],
          'selectors' => [
              '{{WRAPPER}} .post-list-wraper .post-caption h3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          ],
        ]
      );

      $this->end_controls_section();

      /* 
      ** Small Title Styles 
      **/
      $this->start_controls_section(
        'wpop_small_title_style_settings',
        [
          'label' => esc_html__( 'Small Title Style ', 'wpopea' ),
          'tab' => Controls_Manager::TAB_STYLE
        ]
      );

      $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
          'name' => 'wpop_cat_small_title_typography',
          'selector' => '{{WRAPPER}} .post-list-wraper .post-caption h3.small-font',
        ]
      );

      $this->start_controls_tabs( 'wpop_small_title_tabs' );

        // Normal State Tab
        $this->start_controls_tab( 'wpop_small_title_normal', [ 'label' => esc_html__( 'Normal', 'wpopea' ) ] );

        $this->add_control(
          'wpop_small_title_color',
          [
            'label' => esc_html__( 'Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
              '{{WRAPPER}} .post-list-wraper .post-caption h3.small-font a' => 'color: {{VALUE}};',
            ],
          ]
        );

        $this->end_controls_tab();
        // Hover State Tab
        $this->start_controls_tab( 'wpop_small_title_hover', [ 'label' => esc_html__( 'Hover', 'wpopea' ) ] );

        $this->add_control(
          'wpop_small_title_hcolor',
          [
            'label' => esc_html__( 'Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
              '{{WRAPPER}} .post-list-wraper .post-caption h3.small-font a:hover' => 'color: {{VALUE}};',
            ],
          ]
        );

        $this->end_controls_tab();

      $this->end_controls_tabs(); 

      $this->add_responsive_control(
        'wpop_small_title_padding',
        [
          'label' => esc_html__( 'Padding', 'wpopea' ),
          'type' => Controls_Manager::DIMENSIONS,
          'size_units' => [ 'px', 'em', '%' ],
          'selectors' => [
              '{{WRAPPER}} .post-list-wraper .post-caption h3.small-font' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          ],
        ]
      );

      $this->end_controls_section();

      /* Meta Styles */
      $this->wpop_meta_styles();

      /* Content Styles */
      $this->start_controls_section(
        'wpop_desc_style_settings',
        [
          'label' => esc_html__( 'Excerpt Style ', 'wpopea' ),
          'tab' => Controls_Manager::TAB_STYLE,
          'condition' => ['show_excerpt' => 'true'],
        ]
      );

      $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
               'name' => 'wpop_cat_desc_typography',
          'selector' => '{{WRAPPER}} .post-list-wraper .post-caption p',
        ]
      );

      $this->add_control(
        'wpop_desc_color',
        [
          'label' => esc_html__( 'Text Color', 'wpopea' ),
          'type' => Controls_Manager::COLOR,
          'selectors' => [
            '{{WRAPPER}} .post-list-wraper .post-caption p' => 'color: {{VALUE}};',
          ],
        ]
      );

      $this->add_responsive_control(
        'wpop_desc_padding',
        [
          'label' => esc_html__( 'Padding', 'wpopea' ),
          'type' => Controls_Manager::DIMENSIONS,
          'size_units' => [ 'px', 'em', '%' ],
          'selectors' => [
              '{{WRAPPER}} .post-list-wraper .post-caption p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          ],
        ]
      );

      $this->end_controls_section();

   }

    protected function render( ) {

	    // get our input from the widget settings.
	    $settings = $this->get_settings();
        
        $query_type = $settings['post_type'];
        $per_page = $settings['per_page'];
        $cat_id = !empty($settings['category']) ? $settings['category'] : null;
        $offset = $settings['offset']; 
        $show_excerpt = $settings['show_excerpt'];
        $excerpt_length = !empty($settings['excerpt_length']) ? $settings['excerpt_length'] : 100;
        $readmore_text = $settings['readmore_text'];
        $block_layout = $settings['block_layout'];

        $cat_show = $settings['show_category'];
        $show_meta = $settings['show_meta'];
        $show_views = $settings['show_views'];
        $show_comment = $settings['show_comment'];

        ?>
       <div class="widget_ultra_seven_posts_list">
       <div class="post-list-wraper <?php echo esc_attr($block_layout);?>">
            <div class="ultra-posts-wrap">
                <?php 
                $block_args = ultra_seven_query_args( $query_type,$per_page,$cat_id,$offset );
                $paged=1;
                $block_query = new \WP_Query( $block_args );
                if( $block_query->have_posts() ) {
                    $count = 0;
                    while( $block_query->have_posts() ) {
                        $count++;
                        $block_query->the_post();
                        $image_id = get_post_thumbnail_id();
                        if($block_layout=='layout-1' || ($block_layout=='layout-2' && $count==1)){
                        $image_path = wp_get_attachment_image_src( $image_id, 'ultra-medium-image' );
                        $class = 'post-large';
                        $font = 'large-font';
                        }else{
                        $image_path = wp_get_attachment_image_src( $image_id, 'ultra-small-image', true );
                        $class = '';
                        $font = 'small-font';
                        }

                        $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                        ?>
                        <div class="single-post <?php echo esc_attr($class);?> clearfix wow fadeInUp" data-wow-duration="0.7s">
                            <div class="post-thumb">
                                <a class="thumb-zoom" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                    <img src="<?php echo esc_url( $image_path[0] ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" title="<?php the_title(); ?>" />
                                    <?php if($block_layout=='layout-1'){ ?>
                                    <div class="image-overlay"></div>
                                    <?php }?>
                                </a>
                            </div>    
                            <div class="post-caption">
                                <h3 class="<?php echo esc_attr($font);?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <div class="post-meta clearfix">
                                    <?php 
                                     if($block_layout=='layout-2' && $count==1 || $show_meta == true){ 
                                        do_action( 'ultra_seven_post_meta' );   
                                      }
                                    ?>
                                </div><!-- .post-meta --> 
                                <?php if($block_layout=='layout-2' && $count==1 && $show_excerpt==true){?>
                                <p> 
                                <?php echo ultra_seven_get_excerpt_content( get_the_content(), $excerpt_length );// WPCS: XSS OK.?>
                                </p> 
                                <?php }?>
                            </div>
                        </div><!-- .single-post  -->
                        <?php
                    }
                }
                wp_reset_postdata();
               ?>
            </div>
        </div><!-- .block-post-wrapper -->
        </div>
        <?php
    }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}

Plugin::instance()->widgets_manager->register_widget_type( new Widget_Wpop_Post_List() );
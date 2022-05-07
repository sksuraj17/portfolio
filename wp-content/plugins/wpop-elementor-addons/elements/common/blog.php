<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Opstore_Blog extends Widget_Base {

   use \Elementor\WPOPEACommonFunctions;

   public function get_title() {
      return esc_html__( 'WPOP Blog', 'wpopea' );
   }

   public function get_icon() {
      return 'eicon-post-list';
   }

   public function get_categories() {
      return [ 'opstore-elements' ];
   }

   public function get_name() {
      return 'opstore-blog';
   }

   protected function _register_controls() {
     
     /* Query Settings */
     $this->wpopea_query_controls();

     /* Display Settings */
      $this->start_controls_section(
         'blog_display_styles',
         [
            'label' => esc_html__( 'Display Settings', 'wpopea' ),
         ]
      );

      $this->add_group_control(
          Group_Control_Image_Size::get_type(),
          [
              'name'              => 'image_size',
              'label'             => esc_html__( 'Image Size', 'wpopea' ),
              'default'           => 'opstore-blog-default',
          ]
      );

        $this->add_control('show_meta',
            [
                'label'         => esc_html__('Show Meta', 'wpopea'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
            ]
        );

      $this->end_controls_section();

      //Styles
      $this->start_controls_section(
         'opstore_latest_posts_styles',
         [
            'label' => esc_html__( 'Colors & Typography', 'wpopea' ),
            'tab' => Controls_Manager::TAB_STYLE
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

      $this->start_controls_tabs( 'title_colors' );

      $this->start_controls_tab( 'tnormal', [ 'label' => esc_html__( 'Normal', 'wpopea' ) ] );
      $this->add_control(
         'opstore_block_title_color',
         [
            'label' => esc_html__( 'Block Title Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#2e2e2d',
            'selectors' => [
               '{{WRAPPER}} h4.entry-title a' => 'color: {{VALUE}}',
            ]

         ]
      );

      $this->end_controls_tab();

      $this->start_controls_tab( 'thover', [ 'label' => esc_html__( 'Hover', 'wpopea' ) ] );
      $this->add_control(
         'opstore_title_hover_color',
         [
            'label' => esc_html__( 'Title Hover Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#89c350',
            'selectors' => [
               '{{WRAPPER}} h4.entry-title a:hover' => 'color: {{VALUE}}',
            ]

         ]
      );

      $this->end_controls_tab();
      $this->end_controls_tabs(); 

      $this->add_group_control(
         Group_Control_Typography::get_type(),
         [
            'name' => 'opstore_block_title_typo',
            'label' => esc_html__( 'Title Typography', 'wpopea' ),
            'selector' => '{{WRAPPER}} h4.entry-title',
         ]
      ); 

        $this->add_control(
            'title_space',
            [
                'label'                 => __( 'Space', 'wpopea' ),
                'description'           => __( 'The space between the title and meta.', 'wpopea' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size'  => '',
                ],
                'range'                 => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 30,
                    ],
                ],
                'selectors'             => [
                    '{WRAPPER} .entry-title'          => 'padding-top: {{SIZE}}{{UNIT}};'
                ]    
            ]
        );

      $this->add_control(
         'opstore_block_meta_color',
         [
            'label' => esc_html__( 'Meta Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'separator' => 'before',
            'selectors' => [
               '{{WRAPPER}} .entry-content.blog .post-info' => 'color: {{VALUE}}',
            ]

         ]
      );

      $this->add_group_control(
         Group_Control_Typography::get_type(),
         [
            'name' => 'opstore_block_meta_typo',
            'label' => esc_html__( 'Meta Typography', 'wpopea' ),
            'selector' => '{{WRAPPER}} .entry-content.blog .post-info',
         ]
      ); 


      $this->add_control(
         'opstore_block_content_style',
         [
            'label' => esc_html__( 'Block Content Styles', 'wpopea' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
         ]
      ); 

      $this->add_control(
         'opstore_block_content_color',
         [
            'label' => esc_html__( 'Content Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#2e2e2d',
            'selectors' => [
               '{{WRAPPER}} .excerpts' => 'color: {{VALUE}}',
            ]

         ]
      ); 

      $this->add_group_control(
         Group_Control_Typography::get_type(),
         [
            'name' => 'opstore_block_content_typo',
            'label' => esc_html__( 'Content Typography', 'wpopea' ),
            'selector' => '{{WRAPPER}} .excerpts',
         ]
      ); 
        $this->add_control(
            'content_space',
            [
                'label'                 => __( 'Space', 'wpopea' ),
                'description'           => __( 'The space between the title and content.', 'wpopea' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size'  => '',
                ],
                'range'                 => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 30,
                    ],
                ],
                'selectors'             => [
                    '{WRAPPER} .excerpts'  => 'padding-top: {{SIZE}}{{UNIT}};'
                ]    
            ]
        );

      $this->end_controls_tabs(); 

      $this->end_controls_section();

   }

   protected function render( ) {

      // get our input from the widget settings.
      $settings = $this->get_settings();
      
        $per_page = $settings['per_page'];
        $offset = $settings['offset'];
        $columns = $settings['columns'];
        $post_type = $settings['post_type'];
        $cat_ids = $settings['category'];
        $order = $settings['order'];
        $orderby = $settings['orderby'];
        $show_excerpt = $settings['show_excerpt'];
        $excerpt_length = $settings['excerpt_length'];
        $readmore = $settings['readmore_text'];
        $show_meta = $settings['show_meta'];


        $args = array(
          'post_type'         =>  'post',
          'posts_per_page'    =>   $per_page,
          'offset'            =>   $offset,
          'order'             =>   $order,
          'orderby'           =>   $orderby,
        );
        if( $post_type == 'category' ){
           $tax_query[] =   array(
                           'taxonomy'      => 'category',
                           'terms'         => explode( ',', $cat_ids ),
                           'field'         => 'ID',
                           'operator'      => 'IN'
                       );
        }


        $col = 12;
        if($columns == 1){
          $col = 12;
        }elseif($columns == 2){
          $col = 6;
        }elseif($columns == 3){
          $col = 4;
        }elseif($columns == 4){
          $col = 3;
        }



        $posts = new \WP_Query( $args );
        if( $posts->have_posts() ):
          ?>
          <div class="row news-wrap <?php echo esc_attr('column-'.$columns);?>">
            <?php 
            while( $posts->have_posts() ): $posts->the_post();
              $wrap_class = 'col-md-'.$col.' col-sm-6 col-xs-12';

              ?>
              <div id="post-<?php the_ID(); ?>" <?php post_class($wrap_class); ?>>
                <div class="wrap blog-list-wrap full-width">
                  <?php 
                  if( has_post_thumbnail() ):
                    $image_id = get_post_thumbnail_id( get_the_ID() );
                    if( $image_id ){
                        $img_src = Group_Control_Image_Size::get_attachment_image_src( $image_id, 'image_size', $settings );
                    }
                    $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                    ?>
                          <figure>
                              <a href="<?php the_permalink(); ?>" class="image-effect">
                                <img src="<?php echo esc_url($img_src);?>" alt="<?php echo esc_attr($image_alt);?>">
                              </a>
                          </figure>
                          <!--figure-->
                          <?php
                          endif;
                          ?>
                            <div class="entry-content blog">
                                <?php if($show_meta == true){?>
                                <div class="post-info">
                                    <span><i class="fa fa-calendar"></i> <?php echo get_the_date(); ?></span>
                                    <span><i class="fa fa-user"></i> <?php echo get_the_author(); ?> </span>
                                </div>
                                <!--post info-->
                                <?php }?>
                                <h4 class="entry-title mb-15">
                                  <?php 
                                  $title = wp_strip_all_tags( get_the_title() );

                                  ?>
                                    <a href="<?php the_permalink(); ?>"><?php echo $title; ?></a>
                                </h4>
                                <?php if($show_excerpt == 'true'){?>
                                <p class="excerpts">
                                    <?php echo wp_trim_words(get_the_content(),$excerpt_length,'...');?>
                                </p>
                                <?php if($readmore!=''){?>
                                <a href="<?php the_permalink(); ?>" class="opstore-btn bdr">
                                    <?php echo esc_html($readmore); ?>
                                </a>
                                <?php }?>
                                <?php }?>
                            </div>
                        </div>
              </div>
              <?php
            endwhile;
            ?>
          </div>
          <?php
        endif;
        wp_reset_postdata();

   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}

Plugin::instance()->widgets_manager->register_widget_type( new Widget_Opstore_Blog() );
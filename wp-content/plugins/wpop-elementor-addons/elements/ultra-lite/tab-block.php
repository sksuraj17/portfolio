<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Wpop_Tab_Block extends Widget_Base {

   use \Elementor\WPOPEACommonFunctions;

   public function get_title() {
      return esc_html__( 'Tab Block', 'wpopea' );
   }

   public function get_icon() {
      return 'eicon-tabs';
   }
   public function get_categories() {
      return [ 'ultra-elements' ];
   }
   public function get_name() {
      return 'wpop-tab-block';
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
        'recent_posts_tab',
        [
          'label' => esc_html__( 'Recent Post Tab', 'wpopea' ),
          'type' => Controls_Manager::SWITCHER,
          'default' => 'true',
          'return_value' => 'true',
        ]
      );
      $this->add_control(
         'recent_tab_title',
         [
         'label' => esc_html__( 'Tab Title', 'wpopea' ),
         'type' => Controls_Manager::TEXT,
         'label_block' => true,
         'default' => esc_html__( 'Recent', 'wpopea' ),
         'condition' => ['recent_posts_tab' => 'true']
         ]
      );

      $this->add_control(
        'popular_posts_tab',
        [
          'label' => esc_html__( 'Popular Post Tab', 'wpopea' ),
          'type' => Controls_Manager::SWITCHER,
          'default' => 'true',
          'return_value' => 'true',
        ]
      );
      $this->add_control(
         'popular_tab_title',
         [
         'label' => esc_html__( 'Tab Title', 'wpopea' ),
         'type' => Controls_Manager::TEXT,
         'label_block' => true,
         'default' => esc_html__( 'Popular', 'wpopea' ),
         'condition' => ['popular_posts_tab' => 'true']
         ]
      );
      $this->add_control(
        'comment_tab',
        [
          'label' => esc_html__( 'Comments Tab', 'wpopea' ),
          'type' => Controls_Manager::SWITCHER,
          'default' => 'true',
          'return_value' => 'true',
        ]
      );
      $this->add_control(
         'comment_tab_title',
         [
         'label' => esc_html__( 'Tab Title', 'wpopea' ),
         'type' => Controls_Manager::TEXT,
         'label_block' => true,
         'default' => esc_html__( 'Comments', 'wpopea' ),
         'condition' => ['comment_tab' => 'true']
         ]
      );

      $this->add_control(
         'posts_per_page',
         [
         'label' => esc_html__( 'No. of Posts', 'wpopea' ),
         'type' => Controls_Manager::NUMBER,
         'label_block' => true,
         'default' => 4,
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

      $this->end_controls_section();
      
       /** 
        * Tabs Styles 
        **/
        $this->start_controls_section(
          'wpop_section_tabs_style_settings',
          [
            'label' => esc_html__( 'Tabs Style', 'wpopea' ),
            'tab' => Controls_Manager::TAB_STYLE,
          ]
        );
        
        $this->add_control(
          'wpop_tabs_bg_color',
          [
            'label' => esc_html__( 'Background Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
              '{{WRAPPER}} .widget_ultra_seven_widget_tabs .widget-tabs-title-container' => 'background: {{VALUE}};',
            ],
          ]
        );

        $this->add_group_control(
          Group_Control_Typography::get_type(),
          [
            'name' => 'wpop_tabs_typography',
            'selector' => '{{WRAPPER}} .widget_ultra_seven_widget_tabs .widget-tab-titles li',
          ]
        );

        $this->start_controls_tabs( 'wpop_tabs_state' );

          // Normal State Tab
          $this->start_controls_tab( 'wpop_tabs_normal', [ 'label' => esc_html__( 'Normal', 'wpopea' ) ] );

          $this->add_control(
            'wpop_tabs_normal_text_color',
            [
              'label' => esc_html__( 'Text Color', 'wpopea' ),
              'type' => Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .widget_ultra_seven_widget_tabs .widget-tab-titles li' => 'color: {{VALUE}};',
              ],
            ]
          );

          $this->add_control(
            'wpop_tabs_normal_bg_color',
            [
              'label' => esc_html__( 'Background Color', 'wpopea' ),
              'type' => Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .widget_ultra_seven_widget_tabs .widget-tab-titles li' => 'background: {{VALUE}};',
              ],
            ]
          );

          $this->end_controls_tab();

          // Hover State Tab
          $this->start_controls_tab( 'wpop_tabs_hover', [ 'label' => esc_html__( 'Hover', 'wpopea' ) ] );

          $this->add_control(
            'wpop_tabs_hover_text_color',
            [
              'label' => esc_html__( 'Text Color', 'wpopea' ),
              'type' => Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .widget_ultra_seven_widget_tabs .widget-tab-titles li:hover' => 'color: {{VALUE}};',
              ],
            ]
          );

          $this->add_control(
            'wpop_tabs_hover_bg_color',
            [
              'label' => esc_html__( 'Background Color', 'wpopea' ),
              'type' => Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .widget_ultra_seven_widget_tabs .widget-tab-titles li:hover' => 'background: {{VALUE}};',
              ],
            ]
          );

          $this->end_controls_tab();

          // Active State Tab
          $this->start_controls_tab( 'wpop_tabs_active', [ 'label' => esc_html__( 'Active', 'wpopea' ) ] );

          $this->add_control(
            'wpop_tabs_active_text_color',
            [
              'label' => esc_html__( 'Text Color', 'wpopea' ),
              'type' => Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .widget_ultra_seven_widget_tabs .widget-tab-titles li.active' => 'color: {{VALUE}};',
              ],
            ]
          );

          $this->add_control(
            'wpop_tabs_active_bg_color',
            [
              'label' => esc_html__( 'Background Color', 'wpopea' ),
              'type' => Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .widget_ultra_seven_widget_tabs .widget-tab-titles li.active' => 'background: {{VALUE}};',
              ],
            ]
          );

          $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
          'wpop_tabs_padding',
          [
            'label' => esc_html__( 'Padding', 'wpopea' ),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors' => [
                '{{WRAPPER}} .widget_ultra_seven_widget_tabs .widget-tab-titles li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
          ]
        );

      $this->end_controls_section();  
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
          'selector' => '{{WRAPPER}} .post-caption h3',
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
              '{{WRAPPER}} .post-caption h3 a' => 'color: {{VALUE}};',
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
            'selectors' => [
              '{{WRAPPER}} .post-caption h3 a:hover' => 'color: {{VALUE}};',
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
              '{{WRAPPER}} .post-caption h3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          ],
        ]
      );

      $this->end_controls_section();

      /* Meta Styles */
      $this->wpop_meta_styles();

   }

   protected function render( ) {

	    // get our input from the widget settings.
	    $settings = $this->get_settings();
    
    $show_meta = $settings['show_meta'];
		$no_of_item = $settings['posts_per_page'];
		$recent_title = $settings['recent_tab_title'];
		$popular_title = $settings['popular_tab_title'];
		$comment_title = $settings['comment_tab_title'];
        

		$args_latest = array(
			'post_type' => 'post',
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $no_of_item		
		);	
        $recent_post = $settings['recent_posts_tab'];
        $popular_post = $settings['popular_posts_tab'];
        $recent_comment = $settings['comment_tab'];

        if(($recent_post != true && $popular_post != true)
            ||($recent_post != true && $recent_comment != true)
            ||$recent_comment != true && $popular_post != true){
            $full_tab = null;
        }else{
            $full_tab = true;
        }
        $uid = uniqid();
        ?>
        <div class="widget_ultra_seven_widget_tabs">
        <div class="widget-tabs-title-container clearfix">
			<ul class="widget-tab-titles clearfix">
                <?php if($recent_post == true) {?>
				    <li class="active"><h3><a href="#widget-tab1-content-<?php echo esc_attr($uid);?>"><?php echo esc_html($recent_title); ?></a></h3></li>
                <?php }?>
                <?php if($popular_post == true) {?>
				    <li class="<?php if($recent_post != true) { echo "active"; }?>"><h3><a href="#widget-tab2-content-<?php echo esc_attr($uid);?>"><?php echo esc_html($popular_title); ?></a></h3></li>
                <?php }?>
                <?php if($recent_comment == true) {?>
				    <li class="<?php if(($recent_post != true) && ($popular_post != true)) { echo "active"; }?>"><h3><a href="#widget-tab3-content-<?php echo esc_attr($uid);?>"><?php echo esc_html($comment_title); ?></a></h3></li>
                <?php }?>
            </ul>
		</div>
        <div class="widget-tabs-content">
            <?php if($recent_post == true) {?>      			
    			<div id="widget-tab1-content-<?php echo esc_attr($uid);?>" class="tab-content" <?php if($recent_post == true) { echo 'style="display: block;"';}?>>	
    				<?php $latest_posts = new \WP_Query( $args_latest ); ?>
    				<?php if ( $latest_posts -> have_posts() ) : ?>
    
    					<ul class="list post-list">
        					<?php while ( $latest_posts -> have_posts() ) : 
        					    $latest_posts -> the_post(); $post_id = get_the_ID(); 
	                            $image_id = get_post_thumbnail_id();
	                            $image_path = wp_get_attachment_image_src( $image_id, 'ultra-small-image', true );
	                            $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
        					      ?>					
        						<li class="content_out small-post clearfix">
                                    <div class="ultra-article-wrapper" itemscope itemtype="http://schema.org/Article">
            							<div class="ultra-mask thumb-zoom">
                                            <img src="<?php echo esc_url( $image_path[0] ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" title="<?php the_title(); ?>" />
                                        </div>        
		                                <div class="post-caption clearfix">
		                                    <h3 class="small-font"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        <?php if($show_meta == true){?>
		                                    <div class="post-meta">
		                                        <?php do_action( 'ultra_seven_post_meta' ); ?>
		                                    </div>
                                        <?php }?>
		                                </div><!-- .post-caption -->	
                                    </div>
        						</li>
        					<?php endwhile; wp_reset_postdata();?>
    					</ul>
    				<?php endif;?>
    			</div>
    		<?php }?>
            <?php if($popular_post == true) {?>
    			<div id="widget-tab2-content-<?php echo esc_attr($uid);?>" class="tab-content" <?php if($recent_post != true) { echo 'style="display: block;"'; }?>>
    				<?php
    					$args_popular = array(
    						'post_type' => 'post',
    						'ignore_sticky_posts' => 1,
    						'posts_per_page' => $no_of_item,
    						'orderby' => 'comment_count'						
    					);	
    				?>
    				<?php $latest_posts = new \WP_Query( $args_popular ); ?>
    				<?php if ( $latest_posts -> have_posts() ) : ?>
    					<ul class="list post-list">
        					<?php while ( $latest_posts -> have_posts() ) : 
        					    $latest_posts -> the_post(); $post_id = get_the_ID(); 
	                            $image_id = get_post_thumbnail_id();
	                            $image_path = wp_get_attachment_image_src( $image_id, 'ultra-small-image', true );
	                            $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
        					    ?>					
        						<li class="content_out small-post clearfix">
                                    <div class="ultra-article-wrapper" itemscope itemtype="http://schema.org/Article">
            							<div class="ultra-mask thumb-zoom">
                                            <img src="<?php echo esc_url( $image_path[0] ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" title="<?php the_title(); ?>" />
                                        </div>
        
 		                                <div class="post-caption clearfix">
		                                    <h3 class="small-font"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        <?php if($show_meta == true){?>
		                                    <div class="post-meta">
		                                        <?php do_action( 'ultra_seven_post_meta' ); ?>
		                                    </div>
                                        <?php }?>
		                                </div><!-- .post-caption -->	
                                    </div>
        						</li>
        					<?php endwhile; wp_reset_postdata();?>
    					</ul>
    			    <?php endif;?>
    			</div>
    		<?php }?>
            <?php if($recent_comment == true) {?>
    			<div id="widget-tab3-content-<?php echo esc_attr($uid);?>" class="tab-content" <?php if(($recent_post != true) && ($popular_post != true)) { echo 'style="display: block;"'; }?>>
    				<ul class="list comment-list">
    					<?php 
    						//get recent comments
    						$args = array(
    							   'status' => 'approve',
    								'number' => $no_of_item
    							);	
    						$comments = get_comments($args);
    						
    						foreach($comments as $comment) :							
    							$commentcontent = strip_tags($comment->comment_content);			
                                $commentcontent = ultra_seven_get_excerpt_content( $commentcontent, 30 );
    
                                
    							$commentauthor = $comment->comment_author;
    							$commentauthor = ultra_seven_get_excerpt_content( $commentauthor, 30 );		
    
    							$commentid = $comment->comment_ID;
    							$commenturl = get_comment_link($commentid); 
                                
                                $ultra_seven_postid = $comment->comment_post_ID;
                                $title = get_the_title($ultra_seven_postid);
                                $short_title = ultra_seven_get_excerpt_content( $title, 30 );
    		                   ?>
                                <li class="clearfix">
                                    <div class="author-comment-wrap">
                                        <div class="avatar thumb-zoom">
                                			<?php echo get_avatar( $comment, '80' ); ?>
                                		</div>
                                        <div class="text-wrap">
                                        <div class="cm-header">
                                            <div class="author-name">
                                                <?php echo esc_attr($commentauthor); ?>
                                            </div>
                                            <span>on</span>
                                            <div class="date">
                                                <?php echo (get_comment_date('', $commentid)); ?>
                                            </div>
                                        </div>
                                        <h4 class="post-title">
                                            <a href="<?php echo esc_url(get_permalink($ultra_seven_postid)) ?>"><?php echo esc_attr($short_title); ?></a>
                                        </h4>   
                                        <div class="comment-text">
                                    		<a href="<?php echo esc_url($commenturl); ?>"><?php echo esc_attr($commentcontent); ?></a>
                                    	</div>
                                        </div> 
                                    </div>
                                </li>
    				<?php endforeach; wp_reset_postdata();?>
    				</ul>
    			</div>
            <?php }?>
        </div>
        </div>
        <?php


   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}

Plugin::instance()->widgets_manager->register_widget_type( new Widget_Wpop_Tab_Block() );
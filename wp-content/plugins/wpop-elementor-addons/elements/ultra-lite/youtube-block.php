<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Wpop_Youtube_Block extends Widget_Base {

   public function get_title() {
      return esc_html__( 'Youtube Block', 'wpopea' );
   }

   public function get_icon() {
      return 'eicon-post-list';
   }
   public function get_categories() {
      return [ 'ultra-elements' ];
   }
   public function get_name() {
      return 'wpop-youtube-block';
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
         'video_ids',
         [
            'label' => esc_html__( 'Video IDs', 'wpopea' ),
            'description' => esc_html__( 'Add youtube Videos Ids seperated by commas.(eg: xrt27dZ7DOA, u8--jALkijM, HusniLw9i68', 'wpopea' ),
            'placeholder' => 'xrt27dZ7DOA, u8--jALkijM, HusniLw9i68',
            'type' => Controls_Manager::TEXTAREA,
         ]
      );

      $this->end_controls_section();

      
      /* Style Settings*/
      $this->start_controls_section(
         'wpop_youtube_styles',
         [
            'label' => esc_html__( 'Display Styles', 'wpopea' ),
            'tab' => Controls_Manager::TAB_STYLE
         ]
      );
      $this->add_control(
         'wpop_block_bg_color',
         [
            'label' => esc_html__( 'Background Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
               '{{WRAPPER}} .video-list-wrapper .video-controls, {{WRAPPER}} .video-list-wrapper .single-list-wrapper .list-thumb.now-playing:before' => 'background-color: {{VALUE}}',
            ]

         ]
      );
      $this->add_control(
         'wpop_block_title_style',
         [
            'label' => esc_html__( 'Title Styles', 'wpopea' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
         ]
      );
      $this->add_group_control(
         Group_Control_Typography::get_type(),
         [
            'name' => 'wpop_block_title_typo',
            'label' => esc_html__( 'Title Typography', 'wpopea' ),
            'selector' => '{{WRAPPER}} .curVideo-title',
         ]
      );     
      $this->add_control(
         'wpop_block_title_color',
         [
            'label' => esc_html__( 'Title Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
               '{{WRAPPER}} .curVideo-title' => 'color: {{VALUE}}',
            ]

         ]
      );

      $this->add_control(
         'wpop_subtitle_style',
         [
            'label' => esc_html__( 'SubTitle Styles', 'wpopea' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
         ]
      ); 
      $this->add_group_control(
         Group_Control_Typography::get_type(),
         [
            'name' => 'wpop_subtitle_typo',
            'label' => esc_html__( 'SubTitle Typography', 'wpopea' ),
            'selector' => '{{WRAPPER}} .list-thumb-details',
         ]
      ); 
      $this->add_control(
         'wpop_block_subtitle_color',
         [
            'label' => esc_html__( 'SubTitle Color', 'wpopea' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
               '{{WRAPPER}} .list-thumb-details' => 'color: {{VALUE}}',
            ]

         ]
      );
      
      
      $this->end_controls_section();

   }

   protected function render( ) {

	    // get our input from the widget settings.
	    $settings = $this->get_settings();
        $ultra_seven_videos_ids = $settings['video_ids'];

        ?>
        <div class="ultra-block-wrapper youtube-video">
            <?php 
            if( !empty( $ultra_seven_videos_ids ) ) {
                $seperate_id = explode( ',', $ultra_seven_videos_ids );
                $init_vid = $seperate_id[0];
                $API = 'AIzaSyDWVq-K0-kEepdgzYa9rRighkvIxeff_Fs';
                $resvid = wp_remote_get( 'https://www.googleapis.com/youtube/v3/videos?id='. $init_vid .'&part=id,contentDetails,snippet&key='.$API, array(
                                'sslverify' => false
                            ) );

                $init_data = wp_remote_retrieve_body($resvid);

                $init_obj = json_decode($init_data, true);
                if(isset($init_obj)){
                    $video_title = $init_obj['items'][0]['snippet']['title'];
                    $video_duration = ultra_seven_covtime( $init_obj['items'][0]['contentDetails']['duration'] );
                    ?>
                    <div class="youtube-inner-wrapper">
                        <input id="initial-video" type="hidden" data-curVideo="<?php echo esc_attr( $init_vid ); ?>" />
                        <div id="video-placeholder"></div>
                        <div class="video-list-wrapper">
                            <div class="video-controls clearfix">
                                <div class="controller">
                                    <span class="ctrl-icon vplay">
                                        <i class="fa fa-play"></i>           
                                    </span>
                                    <span class="ctrl-icon vpause" style="display: none;">
                                        <i class="fa fa-pause"></i>            
                                    </span>
                                </div>
                                <div class="curVideo-info">
                                    <div class="curVideo-title"><?php echo esc_html( $video_title ); ?></div>
                                    <div class="curVideo-time"><?php echo esc_html( $video_duration ); ?></div>
                                </div><!-- .cur-video-info -->
                            </div><!-- .video-controls -->
                            <div class="single-list-wrapper clearfix">
                                <?php 
                                    $tcount = 1;
                                    foreach ( $seperate_id as $key => $value ) {
                                        $API = 'AIzaSyDWVq-K0-kEepdgzYa9rRighkvIxeff_Fs';
                                        $response = wp_remote_get( 'https://www.googleapis.com/youtube/v3/videos?id='. $value .'&part=id,contentDetails,snippet&key='.$API, array(
                                                    'sslverify' => false
                                                ) );

                                        $data = wp_remote_retrieve_body($response);

                                        $obj = json_decode($data, true);
                                        if( is_array($obj) && !empty( $obj[ 'items' ] ) ) {

                                            $video_thumb = $obj['items'][0]['snippet']['thumbnails']['default']['url'];
                                            $video_title = $obj['items'][0]['snippet']['title'];
                                            $video_duration = ultra_seven_covtime( $obj['items'][0]['contentDetails']['duration'] );
                                ?>
                                            <div class="list-thumb clearfix <?php if( $tcount == 1 ){ echo "now-playing"; } ?>" data-videoid="<?php echo esc_attr( $value ); ?>" data-videotitle="<?php echo esc_attr( $video_title ); ?>" data-videotime="<?php echo esc_attr( $video_duration ); ?>">
                                                <figure class="list-thumb-figure">
                                                    <img src="<?php echo esc_url( $video_thumb ); ?>" title="<?php echo esc_attr( $video_title );?>" alt="<?php echo esc_attr( $video_title );?>"/>
                                                </figure>
                                                <div class="list-thumb-details">
                                                    <span class="thumb-title"><?php echo esc_html( $video_title ); ?></span>
                                                    <span class="thumb-time"><?php echo esc_html( $video_duration ) ; ?></span>
                                                </div>
                                            </div><!--.list-thumb-->
                                <?php }else{ ?> 
                                            <div class="ultra-video-list clearfix">  
                                                <div class="ultra-title-duration">
                                                    <h6><i><?php _e( 'Either this video has been removed or you don\'t have access to watch this video', 'wpopea' ); ?></i></h6>
                                                </div>
                                            </div>
                                    <?php }

                                    $tcount++;
                                    }
                                ?>
                            </div><!-- .single-list-wrapper -->
                        </div><!-- .video-list-wrapper -->
                    </div><!-- .youtube-inner-wrapper -->
                <?php }else{ echo '<p>'.esc_html__('No Internet Connection!!','wpopea').'</p>'; }?>
                <?php 
            }else{ echo '<p>'.esc_html__('Invalid ID!!','wpopea').'</p>'; } ?>
        </div><!-- .ultra-block-wrapper -->
        <?php


   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}

Plugin::instance()->widgets_manager->register_widget_type( new Widget_Wpop_Youtube_Block() );
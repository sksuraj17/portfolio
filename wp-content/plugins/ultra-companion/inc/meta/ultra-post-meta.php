<?php
/**
 * Fucntions for rendering metaboxes in post area
 * 
 * @package WPoperation
 * @subpackage Ultra Companion
 * @since 1.0.0
 */

add_action( 'add_meta_boxes', 'ultra_companion_post_metabox' );

if( !function_exists( 'ultra_companion_post_metabox' ) ):
	function ultra_companion_post_metabox() {
		add_meta_box(
			'ultra_companion_post_metabox_settings', // $id
			esc_html__( 'Post Formats', 'ultra-companion' ), // $title
			'ultra_companion_post_metabox_settings_callback', // $callback
			'post', // $page
			'normal', // $context
			'high'
        ); // $priority
	}
endif; //ultra_companion_post_metabox



/**
 * Call back function for post option
 */
if( !function_exists( 'ultra_companion_post_metabox_settings_callback' ) ):

	function ultra_companion_post_metabox_settings_callback() {
		global $post;

		wp_nonce_field( basename( __FILE__ ), 'ultra_companion_post_meta_nonce' );
        $get_post_meta_identity = get_post_meta( $post->ID, 'post_meta_identity', true );
        $post_identity_value = empty( $get_post_meta_identity ) ? 'pg-metabox-format-empty' : $get_post_meta_identity;
?>
	<ul class="ultra-page-meta-tabs">
        <li class="meta-menu-titlebar pg-metabox-format-empty active" atr="pg-metabox-format-empty"><?php esc_html_e( 'Post Formats', 'ultra-companion' ); ?></li>
        <li class="meta-menu-titlebar <?php if( $post_identity_value == 'pg-metabox-format-gallery' ) { echo 'active'; } ?>" atr="pg-metabox-format-gallery"><i class="fa fa-info"></i><?php esc_html_e( 'Gallery', 'ultra-companion' ); ?></li>
        <li class="meta-menu-titlebar <?php if( $post_identity_value == 'pg-metabox-format-video' ) { echo 'active'; } ?>" atr="pg-metabox-format-video"><i class="fa fa-map-o"></i><?php esc_html_e( 'Video', 'ultra-companion' ); ?></li>
        <li class="meta-menu-titlebar <?php if( $post_identity_value == 'pg-metabox-format-audio' ) { echo 'active'; } ?>" atr="pg-metabox-format-audio"><i class="fa fa-cubes"></i><?php esc_html_e( 'Audio', 'ultra-companion' ); ?></li>
    </ul><!--.tmp-page-meta-tabs-->
    <div class="pg-metabox">
        <!-- Post format -->
        <div id="pg-metabox-format-empty" class="pg-metabox-inside">
            <div class="meta-row">
                <div class="meta-title"> <?php esc_html_e( 'Choose Post Format from right side of screen.', 'ultra-companion' ); ?> </div>
                <div class="meta-options">
                    <p><?php esc_html_e( 'You can choose post format Gallery, Audio, Video then add corresponding values from below tabs.', 'ultra-companion' ); ?></p>
                </div>
            </div>
        </div>        
        <div id="pg-metabox-format-gallery" class="pg-metabox-inside">
            <div class="meta-row">
                <div class="meta-title"> <?php esc_html_e( 'Fields for Post Format Gallery', 'ultra-companion' ); ?> </div>
                <div class="meta-options">
                    <div class="format-type-field" id="format-gallery">
                        <?php
                            $post_gallery_images = get_post_meta( $post->ID, 'post_images', true );
                            $post_images_count = get_post_meta( $post->ID, 'post_gallery_image_count', true );
                        ?>
                        <div class="format-label"><strong><?php esc_html_e( 'Embed gallery images.', 'ultra-companion' );?></strong></div>
                        <div class="format-input">
                            <div class="post-gallery-section">
                                <?php
                                    $total_img = 0;
                                    if( !empty( $post_gallery_images ) ){
                                        $total_img = count( $post_gallery_images );
                                        $img_counter = 0;
                                        foreach( $post_gallery_images as $key => $img_value ){
                                           $attachment_id = ultra_companion_get_attachment_id_from_url( $img_value );
                                           $img_url = wp_get_attachment_image_src( $attachment_id, 'thumbnail', true );
                                ?>
                                            <div class="gal-img-block">
                                                <div class="gal-img"><img src="<?php echo esc_url( $img_url[0] ); ?>" /><span class="fig-remove" title="<?php echo esc_attr( 'remove', 'ultra-companion' ); ?>"></span></div>
                                                <input type="hidden" name="post_images[<?php echo absint($img_counter); ?>]" class="hidden-media-gallery" value="<?php echo esc_url( $img_value ); ?>" />
                                            </div>
                                <?php
                                            $img_counter++;
                                        }
                                    }
                                ?>
                            </div><!-- .post-gallery-section -->
                            <input id="post_image_count" type="hidden" name="post_gallery_image_count" value="" />
                            <span class="add-img-btn" id="post_gallery_upload_button" title="<?php esc_html_e( 'Add Images', 'ultra-companion' ); ?>"></span>
                        </div><!-- .format-input -->
                    </div><!-- #format-gallery -->
                </div>
            </div>
        </div> 
        <!-- Post format -->
        <div id="pg-metabox-format-video" class="pg-metabox-inside">
            <div class="meta-row">
                <div class="meta-title"> <?php esc_html_e( 'Fields for Post Format video', 'ultra-companion' ); ?> </div>
                <div class="meta-options">
                    <div class="format-type-field" id="format-video">
                        <?php $video_url_value = get_post_meta( $post->ID, 'post_embed_video_url', true ); ?>

                        <div class="format-label"><strong><?php esc_html_e( 'Embed video url', 'ultra-companion' );?></strong></div>
                        <div class="format-input">
                            <input type="text" name="post_embed_video_url" size="90" class="post-video-url" value="<?php echo esc_url( $video_url_value ); ?>" />
                            <input class="button" type="button" id="reset-video-embed" value="<?php esc_html_e( 'Reset url', 'ultra-companion' ); ?>" />
                        </div><!-- .format-input -->
                        <span><em><?php esc_html_e( 'Please use youtube/vimeo video url ( https://www.youtube.com/watch?v=x7O-uwAJ4Pw ).', 'ultra-companion' ); ?></em></span>
                    </div><!-- #format-video -->  
                </div>
            </div>
        </div>                   
        <!-- Post format -->
        <div id="pg-metabox-format-audio" class="pg-metabox-inside">
            <div class="meta-row">
                <div class="meta-title"> <?php esc_html_e( 'Fields for Post Format Audio', 'ultra-companion' ); ?> </div>
                <div class="meta-options">
                    <div class="format-type-field" id="format-audio">
                        <?php $audio_url_value = get_post_meta( $post->ID, 'post_embed_audio_url', true ); ?>

                        <div class="format-label"><strong><?php esc_html_e( 'Embed audio url', 'ultra-companion' );?></strong></div>
                        <div class="format-input">
                            <input type="text" name="post_embed_audio_url" size="90" class="post-audio-url" value="<?php echo esc_url( $audio_url_value ); ?>" />
                            <input class="button" name="media_upload_button" id="post_audio_upload_button" value="<?php esc_html_e( 'Embed audio', 'ultra-companion' ); ?>" type="button" />
                            <input class="button" type="button" id="reset-audio-embed" value="<?php esc_html_e( 'Reset url', 'ultra-companion' ); ?>" />
                        </div><!-- .format-input -->
                    </div><!-- #format-audio -->
                </div><!-- .meta-options -->
            </div><!-- .meta-row -->
        </div><!-- #pg-metabox-format -->

    </div><!--.pg-metabox-->
    <div class="clear"></div>
    <input type="hidden" id="post-meta-selected" name="post_meta_identity" value="<?php echo esc_attr( $post_identity_value ); ?>" />
<?php
	}
endif;

/**
 * Function for save sidebar layout of post
 */
add_action( 'save_post', 'ultra_companion_save_post_settings' );

if( ! function_exists( 'ultra_companion_save_post_settings' ) ):

function ultra_companion_save_post_settings( $post_id ) {

    global $post;
    // Verify the nonce before proceeding.
    if ( !isset( $_POST[ 'ultra_companion_post_meta_nonce' ] ) || !wp_verify_nonce( $_POST[ 'ultra_companion_post_meta_nonce' ], basename( __FILE__ ) ) )
        return;

    // Stop WP from clearing custom fields on auto save
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) {
    	return;
    }        
        
    if ( 'page' == $_POST['post_type'] ) {
        if ( !current_user_can( 'edit_page', $post_id ) ){
        	return $post_id;  
        }            
    } elseif ( !current_user_can( 'edit_post', $post_id ) ) {  
            return $post_id;  
    }

    /**
     * update post video format
     */
    $prev_video_url = esc_url( get_post_meta( $post_id, 'post_embed_video_url', true ) );
    $new_video_url = esc_url( $_POST['post_embed_video_url'] );

    if ( $new_video_url && '' == $new_video_url ){
        add_post_meta( $post_id, 'post_embed_video_url', $new_video_url );
    }elseif ( $new_video_url && $new_video_url != $prev_video_url ) {
        update_post_meta($post_id, 'post_embed_video_url', $new_video_url );
    } elseif ( '' == $new_video_url && $prev_video_url ) {
        delete_post_meta( $post_id, 'post_embed_video_url', $prev_video_url );
    }

    /**
     * update post audio format
     */
    $prev_audio_url = esc_url( get_post_meta( $post_id, 'post_embed_audio_url', true ) );
    $new_audio_url = esc_url( $_POST['post_embed_audio_url'] );

    if ( $new_audio_url && '' == $new_audio_url ){
        add_post_meta( $post_id, 'post_embed_audio_url', $new_audio_url );
    }elseif ( $new_audio_url && $new_audio_url != $prev_audio_url ) {
        update_post_meta($post_id, 'post_embed_audio_url', $new_audio_url );
    } elseif ( '' == $new_audio_url && $prev_audio_url ) {
        delete_post_meta( $post_id, 'post_embed_audio_url', $prev_audio_url );
    }

    /**
     * update post gallery format
     */
    $stz_post_image = $_POST['post_images'];
    update_post_meta( $post_id, 'post_images', $stz_post_image );

    $image_count = get_post_meta( $post->ID, 'post_gallery_image_count', true );
    $stz_image_count = sanitize_text_field( $_POST['post_gallery_image_count'] );
   
    if ( $stz_image_count && '' == $stz_image_count ){
        add_post_meta( $post_id, 'post_gallery_image_count', $stz_image_count );
    }elseif ($stz_image_count && $stz_image_count != $image_count) {
        update_post_meta($post_id, 'post_gallery_image_count', $stz_image_count);
    } elseif ('' == $stz_image_count && $image_count) {
        delete_post_meta($post_id,'post_gallery_image_count');
    }


    /**
     * post meta identity
     */
    $post_identity = get_post_meta( $post_id, 'post_meta_identity', true );
    $stz_post_identity = sanitize_text_field( $_POST[ 'post_meta_identity' ] );

    if ( $stz_post_identity && '' == $stz_post_identity ){
        add_post_meta( $post_id, 'post_meta_identity', $stz_post_identity );
    }elseif ( $stz_post_identity && $stz_post_identity != $post_identity ) {  
        update_post_meta($post_id, 'post_meta_identity', $stz_post_identity );  
    } elseif ( '' == $stz_post_identity && $post_identity ) {  
        delete_post_meta( $post_id, 'post_meta_identity', $post_identity );  
    }

}
endif;
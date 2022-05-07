<?php


/**
 * Adds additional user fields
 */


add_filter( 'user_contactmethods', 'ultra_companion_author_meta_contact' );
add_filter( 'user_contactmethods', 'ultra_companion_author_designation' );

function ultra_companion_author_meta_contact() {
    $ultra_companion_user_social_array = array(
        'behance' => esc_html__( 'Behance', 'ultra-companion' ),
        'delicious' => esc_html__( 'Delicious', 'ultra-companion' ),
        'deviantart' => esc_html__( 'Deviantart', 'ultra-companion' ),
        'digg' => esc_html__( 'Digg', 'ultra-companion' ),
        'dribbble' => esc_html__( 'Dribbble', 'ultra-companion' ),
        'facebook' => esc_html__( 'Facebook', 'ultra-companion' ),
        'flickr' => esc_html__( 'Flickr', 'ultra-companion' ),
        'github' => esc_html__( 'Github', 'ultra-companion' ),
        'google-plus' => esc_html__( 'Google+', 'ultra-companion' ),
        'html5' => esc_html__( 'Html5', 'ultra-companion' ),
        'instagram' => esc_html__( 'Instagram', 'ultra-companion' ),    
        'linkedin' => esc_html__( 'Linkedin', 'ultra-companion' ),
        'paypal' => esc_html__( 'Paypal', 'ultra-companion' ),
        'pinterest' => esc_html__( 'Pinterest', 'ultra-companion' ),
        'reddit' => esc_html__( 'Reddit', 'ultra-companion' ),
        'rss' => esc_html__( 'RSS', 'ultra-companion' ),
        'share' => esc_html__( 'Share', 'ultra-companion' ),
        'skype' => esc_html__( 'Skype', 'ultra-companion' ),
        'soundcloud' => esc_html__( 'Soundcloud', 'ultra-companion' ),
        'spotify' => esc_html__( 'Spotify', 'ultra-companion' ),
        'stack-exchange' => esc_html__( 'Stackexchange', 'ultra-companion' ),
        'stack-overflow' => esc_html__( 'Stackoverflow', 'ultra-companion' ),
        'steam' => esc_html__(  'Steam', 'ultra-companion' ),
        'stumbleupon' => esc_html__( 'StumbleUpon', 'ultra-companion' ),
        'tumblr' => esc_html__( 'Tumblr', 'ultra-companion' ),
        'twitter' => esc_html__( 'Twitter', 'ultra-companion' ),
        'vimeo' => esc_html__( 'Vimeo', 'ultra-companion' ),
        'vk' => esc_html__( 'VKontakte', 'ultra-companion' ),
        'windows' => esc_html__( 'Windows', 'ultra-companion' ),
        'wordpress' => esc_html__( 'Woordpress', 'ultra-companion' ),
        'yahoo' => esc_html__( 'Yahoo', 'ultra-companion' ),
        'youtube' => esc_html__( 'Youtube', 'ultra-companion' )
    );
    foreach( $ultra_companion_user_social_array as $icon_id => $icon_name ) {
        $contactmethods[$icon_id] = $icon_name;
    }
    return $contactmethods;
}

function ultra_companion_author_designation($author_profile){
	$author_profile['author_designation'] = esc_html__( 'Author Designation', 'ultra-companion' );
	return $author_profile;
}


if(!function_exists('ultra_eleven_setup')){
    
/*-----------------------------------------------------------------------------------*/
# Ultra Get post views
/*-----------------------------------------------------------------------------------*/
if(!function_exists('getPostViews')){
    function getPostViews( $postID ){
        $count_key = 'ultra_companion_post_views_count';
        $count = get_post_meta( $postID, $count_key, true) ;
        if( $count == '' ){
            delete_post_meta( $postID, $count_key );
            add_post_meta( $postID, $count_key, '0' );
            return '0';
        }
        return $count;
    }
}

if(!function_exists('ultra_companion_get_post_views')){
    function ultra_companion_get_post_views( $postID ){
        $count_key = 'ultra_companion_post_views_count';
        $count = get_post_meta( $postID, $count_key, true) ;
        if( $count == '' ){
            delete_post_meta( $postID, $count_key );
            add_post_meta( $postID, $count_key, '0' );
            return '0';
        }
        return $count;
    }
}

/*-----------------------------------------------------------------------------------*/
# Ultra Set post views
/*-----------------------------------------------------------------------------------*/
if(!function_exists('setPostViews')){
    function setPostViews( $postID ) {
        $count_key = 'ultra_companion_post_views_count';
        $count = get_post_meta( $postID, $count_key, true );
        if( $count == '' ){
            $count = 0;
            delete_post_meta( $postID, $count_key );
            add_post_meta( $postID, $count_key, '0' );
        }else{
            $count++;
            update_post_meta( $postID, $count_key, $count );
        }
    }
}

// Remove issues with pref-etching adding extra views
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );


/*
 * Get media attachment id from url
 */ 
if ( ! function_exists( 'ultra_companion_get_attachment_id_from_url' ) ):
    function ultra_companion_get_attachment_id_from_url( $attachment_url ) {     
        global $wpdb;
        $attachment_id = false;

        // If there is no url, return.
        if ( '' == $attachment_url )
            return;

        // Get the upload directory paths
        $upload_dir_paths = wp_upload_dir();

        // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
        if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

            // If this is the URL of an auto-generated thumbnail, get the URL of the original image
            $attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

            // Remove the upload path base directory from the attachment URL
            $attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

            // Finally, run a custom database query to get the attachment ID from the modified attachment URL
            $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

        }     
        return $attachment_id;
    }
endif;

/*========Get all registered sidebars=====*/
if(!function_exists('ultra_companion_get_sidebars')){
    function ultra_companion_get_sidebars(){
        global $wp_registered_sidebars;
        $ultra_sidebars = array();
        foreach ( $wp_registered_sidebars as $sidebars ) {
            $ultra_sidebars[$sidebars['id']] = $sidebars['name'];
        }
        return $ultra_sidebars;
    }
}
/*--------------------------
* Ultra Social Share
*---------------------------
*/
if( !function_exists('ultra_companion_social_share') ){
    function ultra_companion_social_share($share_text = NUll){
        $post_link  = esc_url( get_permalink() );
        $post_title = wp_strip_all_tags( sanitize_title( get_the_title() ) );
        ?>
        <?php if($share_text!=''):?>
        <span class="share-title"><?php echo esc_html($share_text)?></span>
        <?php endif;?>
        <ul class="social-share">
            <li class="Facebook"><a href="http://www.facebook.com/sharer.php?u=<?php echo esc_url($post_link); ?>" class="social-facebook" rel="external" target="_blank" title="<?php echo esc_attr__('Share on Facebook','ultra-companion');?>"><i class="fa fa-facebook"></i></a></li>
            <li class="Twitter"><a href="https://twitter.com/intent/tweet?text=<?php echo esc_attr($post_title); ?>&url=<?php echo esc_url($post_link); ?>" class="social-twitter" rel="external" target="_blank" title="<?php echo esc_attr__('Share on Twitter','ultra-companion');?>"><i class="fa fa-twitter"></i></a></li>
            <li class="Google-plus"><a href="https://plusone.google.com/_/+1/confirm?hl=en&amp;url=<?php echo esc_url($post_link); ?>&amp;name=<?php echo esc_attr($post_title); ?>" class="social-google-plus" rel="external" target="_blank" title="<?php echo esc_attr__('Share on Google Plus','ultra-companion');?>"><i class="fa fa-google-plus"></i></a></li>
            <li class="Linkedin"><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url($post_link); ?>&title=<?php echo esc_attr($post_title); ?>" class="social-linkedin" rel="external" target="_blank" title="<?php echo esc_attr__('Share on LinkedIn','ultra-companion');?>"><i class="fa fa-linkedin"></i></a></li>
            <li class="Pinterest"><a href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url($post_link); ?>&amp;description=<?php echo esc_attr($post_title); ?>" class="social-pinterest" rel="external" target="_blank" title="<?php echo esc_attr__('Share on Pinterest','ultra-companion');?>"><i class="fa fa-pinterest"></i></a></li>
        </ul>
        <?php
    }
}

}

/* Added backward compatibility for WordPress themes before 5.8 */
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
add_filter( 'use_widgets_block_editor', '__return_false' );
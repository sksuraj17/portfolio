<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package arrival
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function arrival_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	$default                = arrival_get_default_theme_options();
    $_blog_layout           = get_theme_mod('arrival_blog_layout',$default['arrival_blog_layout']);
    $_single_post_sidebars  = get_theme_mod('arrival_single_post_sidebars',$default['arrival_single_post_sidebars']);
    $ultra_sidebar_layout   = arrival_get_post_meta('ultra_sidebar_layout','default');
    $_inner_header_image    = get_theme_mod('arrival_inner_header_image');
    $_main_nav_menu_align   = get_theme_mod('arrival_main_nav_menu_align',$default['arrival_main_nav_menu_align']);
    $_after_top_header_align_center = get_theme_mod('arrival_after_top_header_align_center',$default['arrival_after_top_header_align_center']);
    $_top_header_enable             = get_theme_mod('arrival_top_header_enable',$default['arrival_top_header_enable']);
    $_main_nav_layout               = get_theme_mod('arrival_main_nav_layout',$default['arrival_main_nav_layout']);
    $_single_page_sidebars          = get_theme_mod('arrival_single_page_sidebars',$default['arrival_single_page_sidebars']);
    $_blog_page_sidebars            = get_theme_mod('arrival_blog_page_sidebars',$default['arrival_blog_page_sidebars']);

    $classes[] = $_main_nav_menu_align;

    if( true == $_after_top_header_align_center ){
        $classes[] = 'menu-middle-center';
    }    
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
    if(is_admin_bar_showing()){
        $classes[] = 'admin-bar';
    }
    if(class_exists('WooCommerce')){
        $classes[] = 'woocommerce'; 
        
        $_archive_shop_sidebars = get_theme_mod('arrival_archive_shop_sidebars',$default['arrival_archive_shop_sidebars']);
        $_single_shop_sidebars  = get_theme_mod('arrival_single_shop_sidebars',$default['arrival_single_shop_sidebars']);

        if ( is_singular( 'product' ) ) {
            if( $_single_shop_sidebars != 'no_sidebar'){
                $classes[] = 'has-sidebar '.$_single_shop_sidebars;
            }            
        }  

        if ( is_shop() || is_product_category() ) {
            if( $_archive_shop_sidebars != 'no_sidebar'){
                $classes[] = 'has-sidebar '.$_archive_shop_sidebars;
            } 
        }
    }

    if( $_inner_header_image ){
        $classes[] = 'header-bg-image';   
    }

    if( !is_front_page() ){
        $classes[] = 'arrival-inner-page';   
    }

	if( is_home() || is_category() || is_search() ){
		$classes[] = esc_attr($_blog_layout);
	}

	$classes[] = 'active-arrival';


    if( is_singular('post') &&  ('no_sidebar' != $_single_post_sidebars) &&  ('default' == $ultra_sidebar_layout) ){
        $classes[] = 'has-sidebar '.$_single_post_sidebars;
    }

    if( is_page() && ('no_sidebar' != $_single_page_sidebars) &&  ('default' == $ultra_sidebar_layout) ){
        $classes[] = 'has-sidebar '.$_single_page_sidebars;   
    }
    if( (is_home() || is_category()) && ('no_sidebar' != $_blog_page_sidebars) ){
        $classes[] = 'has-sidebar '.$_blog_page_sidebars;   
    }

    if( $_top_header_enable == 'on' && $_main_nav_layout == 'boxed' ){
        $classes[] = 'main-header-overlap';   
    }
	

	return $classes;
}
add_filter( 'body_class', 'arrival_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function arrival_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'arrival_pingback_header' );

/**
 * Adds async/defer attributes to enqueued / registered scripts.
 *
 * If #12009 lands in WordPress, this function can no-op since it would be handled in core.
 *
 * @link https://core.trac.wordpress.org/ticket/12009
 * @param string $tag    The script tag.
 * @param string $handle The script handle.
 * @return array
 */
function arrival_filter_script_loader_tag( $tag, $handle ) {

	foreach ( array( 'async', 'defer' ) as $attr ) {
		if ( ! wp_scripts()->get_data( $handle, $attr ) ) {
			continue;
		}

		// Prevent adding attribute when already added in #12009.
		if ( ! preg_match( ":\s$attr(=|>|\s):", $tag ) ) {
			$tag = preg_replace( ':(?=></script>):', " $attr", $tag, 1 );
		}

		// Only allow async or defer, not both.
		break;
	}

	return $tag;
}

add_filter( 'script_loader_tag', 'arrival_filter_script_loader_tag', 10, 2 );

/**
 * Generate preload markup for stylesheets.
 *
 * @param object $wp_styles Registered styles.
 * @param string $handle The style handle.
 */
function arrival_get_preload_stylesheet_uri( $wp_styles, $handle ) {
	$preload_uri = $wp_styles->registered[ $handle ]->src . '?ver=' . $wp_styles->registered[ $handle ]->ver;
	return $preload_uri;
}

/**
 * Adds preload for in-body stylesheets depending on what templates are being used.
 * Disabled when AMP is active as AMP injects the stylesheets inline.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Preloading_content
 */
function arrival_add_body_style() {

	// If AMP is active, do nothing.
	if ( arrival_is_amp() ) {
		return;
	}

	// Get registered styles.
	$wp_styles = wp_styles();

	$preloads = array();

	// Preload content.css.
	$preloads['arrival-content'] = arrival_get_preload_stylesheet_uri( $wp_styles, 'arrival-content' );


	// Preload comments.css.
	if ( ! post_password_required() && is_singular() && ( comments_open() || get_comments_number() ) ) {
		$preloads['arrival-comments'] = arrival_get_preload_stylesheet_uri( $wp_styles, 'arrival-comments' );
	}

	// Preload front-page.css.
	global $template;
	if ( 'front-page.php' === basename( $template ) ) {
		$preloads['arrival-front-page'] = arrival_get_preload_stylesheet_uri( $wp_styles, 'arrival-front-page' );
	}

	// Output the preload markup in <head>.
	foreach ( $preloads as $handle => $src ) {
		echo '<link rel="preload" id="' . esc_attr( $handle ) . '-preload" href="' . esc_url( $src ) . '" as="style" />';
		echo "\n";
	}

}
add_action( 'wp_head', 'arrival_add_body_style' );

/**
 * Add dropdown symbol to nav menu items with children.
 *
 * Adds the dropdown markup after the menu link element,
 * before the submenu.
 *
 * Javascript converts the symbol to a toggle button.
 *
 * @TODO:
 * - This doesn't work for the page menu because it
 *   doesn't have a similar filter. So the dropdown symbol
 *   is only being added for page menus if JS is enabled.
 *   Create a ticket to add to core?
 *
 * @param string   $item_output The menu item's starting HTML output.
 * @param WP_Post  $item        Menu item data object.
 * @param int      $depth       Depth of menu item. Used for padding.
 * @param stdClass $args        An object of wp_nav_menu() arguments.
 * @return string Modified nav menu HTML.
 */
function arrival_add_primary_menu_dropdown_symbol( $item_output, $item, $depth, $args ) {

	

	// Add the dropdown for items that have children.
	if ( ! empty( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) ) {
		return $item_output . '<span class="dropdown"><i class="dropdown-symbol"></i></span>';
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'arrival_add_primary_menu_dropdown_symbol', 10, 4 );

/**
 * Filters the HTML attributes applied to a menu item's anchor element.
 *
 * Checks if the menu item is the current menu
 * item and adds the aria "current" attribute.
 *
 * @param array   $atts   The HTML attributes applied to the menu item's `<a>` element.
 * @param WP_Post $item  The current menu item.
 * @return array Modified HTML attributes
 */
function arrival_add_nav_menu_aria_current( $atts, $item ) {
	/*
	 * First, check if "current" is set,
	 * which means the item is a nav menu item.
	 *
	 * Otherwise, it's a post item so check
	 * if the item is the current post.
	 */
	if ( isset( $item->current ) ) {
		if ( $item->current ) {
			$atts['aria-current'] = 'page';
		}
	} else if ( ! empty( $item->ID ) ) {
		global $post;
		if ( ! empty( $post->ID ) && $post->ID == $item->ID ) {
			$atts['aria-current'] = 'page';
		}
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'arrival_add_nav_menu_aria_current', 10, 2 );
add_filter( 'page_menu_link_attributes', 'arrival_add_nav_menu_aria_current', 10, 2 );

/**
* Social icons for the theme
*
*/
add_action('arrival_social_icons','arrival_social_icons');
if( ! function_exists('arrival_social_icons')){
	function arrival_social_icons(){
        $default                  = arrival_get_default_theme_options();
		$arrival_icons_value      = get_theme_mod('arrival_social_icons');
	    $arrival_icons            = json_decode($arrival_icons_value);
        $social_icons_new_tab    = get_theme_mod( 'arrival_social_icons_new_tab',$default['arrival_social_icons_new_tab'] );

        $target = '_self';
        if( $social_icons_new_tab ){
            $target = '_blank';
        }
	    ?>
	    <ul class="social">
	    	<?php 
	    	if( $arrival_icons ):
	    	foreach( $arrival_icons as $arrival_icon ){
	    		$social_link = $arrival_icon->social_url;
	    		$social_icon = $arrival_icon->social_icons; ?>
		        <li>
		        	<a href="<?php echo esc_url($social_link);?>" target="<?php echo esc_attr($target);?>">
		        		<?php echo arrival_get_social_icon_svg($social_icon); ?>
		        	</a>
		        </li>
	        <?php }
	        endif; ?>
		</ul>									
	    <?php

	}
}


/**
* Modify default category widget
*
* @return adds span to default category widget counts
*/
add_filter('wp_list_categories', 'arrival_add_span_cat_count');
add_filter('wp_list_archive', 'arrival_add_span_cat_count');
    function arrival_add_span_cat_count($links) {
    $links = str_replace('</a> (', '</a> <span class="count">', $links);
    $links = str_replace(')', '</span>', $links);
    return $links;
}


/**
* Strip whitespace in dynamic style
* @package Arrival
* @since 1.0.1
*/
if( !function_exists('arrival_css_strip_whitespace') ){
    function arrival_css_strip_whitespace($css){
        $replace = array(
        "#/\*.*?\*/#s" => "",  // Strip C style comments.
        "#\s\s+#"      => " ", // Strip excess whitespace.
        );
        $search = array_keys($replace);
        $css = preg_replace($search, $replace, $css);
        
        $replace = array(
        ": "  => ":",
        "; "  => ";",
        " {"  => "{",
        " }"  => "}",
        ", "  => ",",
        "{ "  => "{",
        ";}"  => "}", // Strip optional semicolons.
        ",\n" => ",", // Don't wrap multiple selectors.
        "\n}" => "}", // Don't wrap closing braces.
        //"} "  => "}\n", // Put each rule on it's own line.
        );
        $search = array_keys($replace);
        $css = str_replace($search, $replace, $css);
        
        return trim($css);
    }
}



/**
 * Function for excerpt length
 */
if( ! function_exists( 'arrival_get_excerpt_content' ) ):
    function arrival_get_excerpt_content( $limit ) {

    	$content 			= get_the_content();
        $striped_contents 	= strip_shortcodes( $content );
        $striped_content 	= strip_tags( $striped_contents );
        $limit_content 		= mb_substr( $striped_content, 0 , absint($limit) );
       
        return '<p>'.$limit_content.'</p>';
    }

endif;

/**
* Numeric post navigation for archive pages
*
*/
if( ! function_exists('arrival_numeric_posts_nav')){
    function arrival_numeric_posts_nav() {
     
        if( is_singular() )
            return;
     
        global $wp_query;
     
        /** Stop execution if there's only 1 page */
        if( $wp_query->max_num_pages <= 1 )
            return;
     
        $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
        $max   = intval( $wp_query->max_num_pages );
     
        /** Add current page to the array */
        if ( $paged >= 1 )
            $links[] = $paged;
     
        /** Add the pages around the current page to the array */
        if ( $paged >= 3 ) {
            $links[] = $paged - 1;
            $links[] = $paged - 2;
        }
     
        if ( ( $paged + 2 ) <= $max ) {
            $links[] = $paged + 2;
            $links[] = $paged + 1;
        }
     
        echo '<div class="arrival-archive-navigation clear">';
     
        /** Previous Post Link */
        if ( get_previous_posts_link() )
            printf( '<span class="prev">%s</span>' . "\n", get_previous_posts_link() );

        echo '<ul>';
        /** Link to first page, plus ellipses if necessary */
        if ( ! in_array( 1, $links ) ) {
            $class = 1 == $paged ? ' class="active"' : '';
     
            printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
     
            if ( ! in_array( 2, $links ) )
                echo '<li>...</li>';
        }
     
        /** Link to current page, plus 2 pages in either direction if necessary */
        sort( $links );
        foreach ( (array) $links as $link ) {
            $class = $paged == $link ? ' class="active"' : '';
            printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
        }
     
        /** Link to last page, plus ellipses if necessary */
        if ( ! in_array( $max, $links ) ) {
            if ( ! in_array( $max - 1, $links ) )
                echo '<li>...</li>' . "\n";
     
            $class = $paged == $max ? ' class="active"' : '';
            printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
        }
        echo '</ul>';
        /** Next Post Link */
        if ( get_next_posts_link() )
            printf( '<span class="next">%s</span>' . "\n", get_next_posts_link() );
     
        echo '</div>' . "\n";
     
    }
}


/**
 * Get media attachment id from url
 */ 
if ( ! function_exists( 'arrival_get_attachment_id_from_url' ) ):
    function arrival_get_attachment_id_from_url( $attachment_url ) {     
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
            $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = %s AND wposts.post_type = 'attachment'", $attachment_url ) );

        }     
        return $attachment_id;
    }
    endif;


/**
* Post-format control
* @since 1.0.1
*/
if( ! function_exists('arrival_post_format_display')){
	function arrival_post_format_display(){
		global $post;
        $defaults       = arrival_get_default_theme_options();
        $_blog_layout   = get_theme_mod('arrival_blog_layout',$defaults['arrival_blog_layout']);

        $post_id 		= $post->ID;
        $post_format 	= get_post_format( $post_id );
        $img_size       = 'arrival-blog-list-thumb'; 
        if( $_blog_layout == 'masonry-layout' ){
            $img_size       = 'arrival-blog-masonry-thumb';     
        }

        if( 'audio' == $post_format ){

        	$audio_url_value = get_post_meta( $post->ID, 'post_embed_audio_url', true );
        	echo wp_oembed_get(esc_url($audio_url_value));

        }elseif( 'video' == $post_format ){

        	$video_url_value = get_post_meta( $post->ID, 'post_embed_video_url', true );
			echo wp_oembed_get(esc_url($video_url_value));        	

        }elseif( 'gallery' == $post_format ){
        	$post_gallery_images = get_post_meta( $post->ID, 'post_images', true );
        	if( $post_gallery_images ){
	        	foreach( $post_gallery_images as $post_gallery_image ){

	        		$img_id 	= arrival_get_attachment_id_from_url($post_gallery_image);
	        		$thumb_img 	= wp_get_attachment_image_src( $img_id, $img_size, true );
	        		$image_alt 	= get_post_meta( $img_id, '_wp_attachment_image_alt', true );

	        	 ?>
	        		<div class="img-wrap">
	        			<img src="<?php echo esc_url($thumb_img[0]);?>" alt="<?php echo esc_attr($image_alt);?>">
	        		</div>
				<?php 
	        	}
        	}

        }else{
        	arrival_post_thumbnail($img_size);
        }

	}
}


/**
* Retrieve post meta and default value of metabox
* @since 1.0.9
*/
function arrival_get_post_meta( $key, $defaults = '' ){
  global $post;

  if(! $post )
    return;
    
    $default = $defaults;
    $meta_val =  get_post_meta( $post->ID, $key , true ); 

    if( empty($meta_val) && ($defaults != '') ){
        $meta_val = $default;
    }

    return $meta_val;

}


/**
 * Count number of widgets in a specific sidebar area
 * 
 * @since 1.0.9
 */
if( ! function_exists('arrival_count_widgets') ):
    function arrival_count_widgets( $sidebar_id ) {
      
        global $_wp_sidebars_widgets;

        if ( empty( $_wp_sidebars_widgets ) ) :
            $_wp_sidebars_widgets = get_option( 'sidebars_widgets', array() );
        endif;
        
        $sidebars_widgets_count = $_wp_sidebars_widgets;
        
        if ( isset( $sidebars_widgets_count[ $sidebar_id ] ) ) :

            $widget_count   = count( $sidebars_widgets_count[ $sidebar_id ] );
            $widget_classes = 'col-' . count( $sidebars_widgets_count[ $sidebar_id ] );
            
            return $widget_classes;

        endif;
    }
endif;

/**
* Get all elementor page templates
* @since 1.1.1
*/
function arrival_get_elementor_templates() {
    $args = [
        'post_type' => 'elementor_library',
        'posts_per_page' => -1,
    ];

    $page_templates = get_posts( $args );

    $options = array();

    if ( !empty( $page_templates ) && !is_wp_error( $page_templates ) ) {
        $options['0'] = esc_html__('Select Template','arrival');
        foreach ( $page_templates as $post ) {
            $options[ $post->ID ] = $post->post_title;
        }
    }
    return $options;
}

/**
* Convert HEX to RGBA
* @since 1.1.2
*/
function arrival_hex2rgba($color, $opacity = false) {
     $default = 'rgb(0,0,0)';
     //Return default if no color provided
     if(empty($color))
           return $default;
     //Sanitize $color if "#" is provided
        if ($color[0] == '#' ) {
         $color = substr( $color, 1 );
        }
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
        //Check if opacity is set(rgba or rgb)
        if($opacity){
         if(abs($opacity) > 1)
         $opacity = 1.0;
         $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
         $output = 'rgb('.implode(",",$rgb).')';
        }
        //Return rgb(a) color string
        return $output;
}


/**
 * Add a Sub Nav Toggle to the Expanded Menu and Mobile Menu.
 *
 * @param stdClass $args An array of arguments.
 * @param string   $item Menu item.
 * @param int      $depth Depth of the current menu item.
 *
 * @return stdClass $args An object of wp_nav_menu() arguments.
 * 
 * @since 1.2.7
 */
function arrival_add_sub_toggles_to_main_menu( $args, $item, $depth ) {


    // Add sub menu toggles to the Expanded Menu with toggles.
    if ( isset( $args->show_toggles ) && $args->show_toggles ) {

        
        $args->after  = '';

        // Add a toggle to items with children.
        if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {

            $toggle_target_string = '.menu-modal .menu-item-' . $item->ID . ' > .sub-menu';
            $toggle_duration      = 50;

            // Add the sub menu toggle.
            $args->after .= '<button class="toggle sub-toggle sub-menu-toggle"><span class="screen-reader-text">' . __( 'Show sub menu', 'arrival' ) . '</span>' . arrival_get_icon_svg( 'arrow_down' ) . '</button>';

        }

    } 

    return $args;

}

add_filter( 'nav_menu_item_args', 'arrival_add_sub_toggles_to_main_menu', 10, 3 );



/**
* Remove Archive prefix
*
* @since 1.2.7
*/
add_filter('get_the_archive_title','arrival_archive_prefix');
if( ! function_exists('arrival_archive_prefix')){
    function arrival_archive_prefix($title){
        if ( is_category() ) {    
                $title = single_cat_title( '', false );    
            } elseif ( is_tag() ) {    
                $title = single_tag_title( '', false );    
            } elseif ( is_author() ) {    
                $title = '<span class="vcard">' . get_the_author() . '</span>' ;    
            } elseif ( is_tax() ) { //for custom post types
                $title = sprintf( __( '%1$s','arrival' ), single_term_title( '', false ) );
            } elseif (is_post_type_archive()) {
                $title = post_type_archive_title( '', false );
            }
        return $title; 
    }
}
<?php
/**
 * Ultra Seven Custom Shortcodes
 *
 * @package Ultra Seven
 */
// Allow shortcodes in widgets
add_filter('widget_text', 'do_shortcode');

// Enable font size & font family selects in the editor
if ( ! function_exists( 'ultra_mce_buttons' ) ) {
	function ultra_mce_buttons( $buttons ) {
		array_unshift( $buttons, 'fontsizeselect' ); // Add Font Size Select
		return $buttons;
	}
}
add_filter( 'mce_buttons_2', 'ultra_mce_buttons' );

// Customize mce editor font sizes
if ( ! function_exists( 'ultra_mce_text_sizes' ) ) {
	function ultra_mce_text_sizes( $initArray ){
		$initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px";
		return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'ultra_mce_text_sizes' );

// Add Formats Dropdown Menu To MCE
if ( ! function_exists( 'ultra_style_select' ) ) {
	function ultra_style_select( $buttons ) {
		array_push( $buttons, 'styleselect' );
		return $buttons;
	}
}
add_filter( 'mce_buttons', 'ultra_style_select' );


add_filter( 'mce_external_plugins', 'ultra_add_tinymce_plugin' );
add_filter( 'mce_buttons', 'ultra_register_mce_button' );


// Declare script for new button
function ultra_add_tinymce_plugin( $plugin_array ) {
	$pathe = $plugin_array['ultra_mce_button'] = ULC_URL.'shortcodes/shortcodes.js';
	return $plugin_array;
}

// Register new button in the editor
function ultra_register_mce_button( $buttons ) {
	array_push( $buttons, 'ultra_mce_button' );
	return $buttons;
}


if ( ! function_exists( 'ultra_paragraph_br_fix' ) ){
	function ultra_paragraph_br_fix($content,$paragraph_tag=false,$br_tag=false){
		$content = preg_replace('#^<\/p>|^<br \/>|<p>$#', '', $content);

		$content = preg_replace('#<br \/>#', '', $content);

		if ( $paragraph_tag ) $content = preg_replace('#<p>|</p>#', '', $content);

		return trim($content);
	}
}

if ( ! function_exists( 'ultra_content_helper' ) ){
	function ultra_content_helper($content,$paragraph_tag=false,$br_tag=false){
		return ultra_paragraph_br_fix( do_shortcode(shortcode_unautop($content)), $paragraph_tag );
	}
}


function ultra_social_shortcodes($atts){
	extract(shortcode_atts( 
		array(
			'facebook' => '',
			'twitter' => '',
			'gplus' => '',
			'skype' => '',
			'linkedin' => '',
			'youtube' => '',
			'dribble' => ''
			), $atts, 'ultra_social'));

	$social = '<div class="social-shortcode">';
	if($facebook){
	$social .= '<a href="'.esc_url($facebook).'" class="fb-icon" target="_blank"><i class="fa fa-facebook"></i></a>';
	}
	if($twitter){
	$social .= '<a href="'.esc_url($twitter).'" class="twitter-icon" target="_blank"><i class="fa fa-twitter"></i></a>';
	}
	if($gplus){
	$social .= '<a href="'.esc_url($gplus).'" class="google-icon" target="_blank"><i class="fa fa-google"></i></a>';
	}
	if($skype){
	$social .= '<a href="'.esc_url($skype).'" class="skype-icon" target="_blank"><i class="fa fa-skype"></i></a>';
	}
	if($linkedin){
	$social .= '<a href="'.esc_url($linkedin).'" class="linkedin-icon"  target="_blank"><i class="fa fa-linkedin"></i></a>';
	}
	if($youtube){
	$social .= '<a href="'.esc_url($youtube).'" class="youtube-icon" target="_blank"><i class="fa fa-youtube-play"></i></a>';
	}
	if($dribble){
	$social .= '<a href="'.esc_url($dribble).'" class="dribbble-icon" target="_blank"><i class="fa fa-dribbble"></i></a>';
	}
	$social .='</div>';
	return $social;
}
add_shortcode('ultra_social', 'ultra_social_shortcodes');


function ultra_accordian_shortcode($atts, $content=null){
	extract(shortcode_atts( 
		array(
			'title' => '',
			'icon' => '',
			), $atts, 'ultra_accordian'));

	if($icon){
		$icon = '<i class="fa '.$icon.'"></i>';
	}
	$accordion = '<div class="ultra_accordian">';
	$accordion .='<div class="ultra_accordian_title">'.$icon.' '.$title.'</div>';
	$accordion .='<div class="ultra_accordian_content">'.ultra_content_helper($content).'</div>';
	$accordion .='</div>';
	return $accordion;
}

add_shortcode('ultra_accordian', 'ultra_accordian_shortcode');

function ultra_accordian_shortcode_wrap($atts, $content=null){
	extract(shortcode_atts( 
		array(
			'class' => '',
			), $atts, 'ultra_accordian_wrap'));
	return '<div class="accordion-wrap '.$class.'">'.ultra_content_helper($content).'</div>';
}
add_shortcode('ultra_accordian_wrap', 'ultra_accordian_shortcode_wrap');

function ultra_toggle_shortcode($atts, $content=null){
	extract(shortcode_atts( 
		array(
			'title' => '',
			'status' => 'close'
			), $atts, 'ultra_toggle'));
	$style = '';
	if($status == 'close') {
		$style = 'style="display: none;"';
	}
	$accordion = '<div class="ultra_toggle '.$status.'">';
	$accordion .='<div class="ultra_toggle_title">'.$title.'</div>';
	$accordion .='<div class="ultra_toggle_content" '.$style.'>'.ultra_content_helper($content).'</div>';
	$accordion .='</div>';
	return $accordion;
}

add_shortcode('ultra_toggle', 'ultra_toggle_shortcode');



function ultra_drop_cap_shortcode($atts, $content=null){
	extract(shortcode_atts( 
		array(
			'font_size' => '26',
			), $atts, 'ultra_drop_cap'));

	$drop_cap = '<span class="ultra_drop_cap" style="font-size:'.$font_size.'px">';
	$drop_cap .= $content;
	$drop_cap .='</span>';
	return $drop_cap;
}

add_shortcode('ultra_drop_cap', 'ultra_drop_cap_shortcode');

function ultra_slide_shortcode($atts, $content=null){

	extract(shortcode_atts( 
		array(
			'item' => '1',
			'autoplay' => 'true',
			'caption' => '',
			'link' => '#',
			'target' => '_self'
			), $atts, 'ultra_slide'));
	$ultra_slide = '<div class="ultra-slide">';
	if($link):
	$ultra_slide .= '<a href="'.$link.'" target="'.$target.'">';
	endif;
	$ultra_slide .= '<img title="'.$caption.'" src="'.$content.'">';
	if($link):
	$ultra_slide .= '</a>';
	endif;
	$ultra_slide .= '</div>';
	return $ultra_slide;
}

add_shortcode('ultra_slide', 'ultra_slide_shortcode');

function ultra_slider_shortcode($atts, $content=null){
	wp_enqueue_style('slick');
	wp_enqueue_style('slick-theme');
	wp_enqueue_script('slick');
	extract(shortcode_atts( 
		array(
			'item' => '1',
			'autoplay' => 'true',
			), $atts, 'ultra_slide'));
	$ultra_slider = '<div class="shortcode-slider"><div class="slide_wrap" data-slick=\' { "slidesToShow": '.$item.', "autoplay": '.$autoplay.'}\' >';
	$ultra_slider .= ultra_content_helper($content);
	$ultra_slider .= '</div></div>';
	return $ultra_slider;
}

add_shortcode('ultra_slider', 'ultra_slider_shortcode');

function ultra_tab_shortcode($atts, $content=null){
	extract(shortcode_atts( 
		array(
			'title' => '',
			), $atts, 'ultra_tab'));

	$ultra_tab ='<div class="ultra_tab '.sanitize_title($title).'">';
	$ultra_tab .='<div class="tab-title" id="'.sanitize_title($title).'">'.$title.'</div>';
	$ultra_tab .= ultra_content_helper($content);
	$ultra_tab .='</div>';
	return $ultra_tab;
}

add_shortcode('ultra_tab', 'ultra_tab_shortcode');

function ultra_tab_wrap_shortcode($atts, $content=null){
	extract(shortcode_atts( 
		array(
			'type' => 'horizontal',
			), $atts, 'ultra_tab_group'));
	$ultra_tab_wrap = '<div class="clearfix ultra_tab_wrap '.$type.'">';
	$ultra_tab_wrap .= ultra_content_helper($content);
	$ultra_tab_wrap .= '</div>';
	return $ultra_tab_wrap;
}

add_shortcode('ultra_tab_group', 'ultra_tab_wrap_shortcode');

function ultra_column_shortcode($atts, $content=null){
	extract(shortcode_atts( 
		array(
			'span' => '6',
			), $atts, 'ultra_column'));
	$ultra_column = '<div class="ultra_column ultra-span'.$span.'">';
	$ultra_column .= ultra_content_helper($content);
	$ultra_column .= '</div>';
	return $ultra_column;
}

add_shortcode('ultra_column', 'ultra_column_shortcode');

function ultra_column_wrap_shortcode($atts, $content=null){
	$ultra_column_wrap = '<div class="clearfix ultra-row">';
	$ultra_column_wrap .= ultra_content_helper($content);
	$ultra_column_wrap .= '</div>';
	return $ultra_column_wrap;
}

add_shortcode('ultra_column_wrap', 'ultra_column_wrap_shortcode');

function ultra_list_shortcode($atts, $content=null){
    extract(shortcode_atts( 
		array(
			'list_type' => 'ultra-list1',
			), $atts, 'ultra_list'));
	$ultra_list = '<ul class="ultra-list '.$list_type.'">';
	$ultra_list .= ultra_content_helper($content);
	$ultra_list .= '</ul>';
	return $ultra_list;
}

add_shortcode('ultra_list', 'ultra_list_shortcode');

function ultra_li_shortcode($atts, $content=null){
	$ultra_li = '<li>';
	$ultra_li .= ultra_content_helper($content);
	$ultra_li .= '</li>';
	return $ultra_li;
}

add_shortcode('ultra_li', 'ultra_li_shortcode');

function ultra_dropcaps_shortcode($atts, $content = null) {
    extract(shortcode_atts(
                    array(
        'style' => 'ultra-normal',
                    ), $atts, 'ultra_dropcaps'));
    $ultra_dropcaps = '<span class="ultra-dropcaps '.$style.'">';
    $ultra_dropcaps .= ultra_content_helper($content);
    $ultra_dropcaps .= '</span>';
    return $ultra_dropcaps;
}

add_shortcode('ultra_dropcaps', 'ultra_dropcaps_shortcode');

function ultra_tagline_box_shortcode($atts, $content = null) {
    extract(shortcode_atts(
                    array(
        'ultra_tagline_text' => 'Enter you Tag Line text here',
        'tag_box_style' => 'ultra-all-border-box',
                    ), $atts, 'ultra_tagline_box'));

    $ultra_tagline_box = '<div class="ultra_tagline_box clearfix ' . $tag_box_style . '">';
    $ultra_tagline_box .= ultra_content_helper($content);
    $ultra_tagline_box .='</div>';
    return $ultra_tagline_box;
}

add_shortcode('ultra_tagline_box', 'ultra_tagline_box_shortcode');

/* Current Date Shortcode */
function ultra_current_date_shortcode($atts){
    extract(shortcode_atts(
        array(
        	'format' => 'F j, Y',
        ), $atts, 'ultra-date'));
	?>
	<span class="current-date"><?php echo date($atts['format']);?></span>
	<?php
}
add_shortcode('ultra-date','ultra_current_date_shortcode');
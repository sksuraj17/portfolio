<?php
/**
 * @package ThemeHunk
 * @subpackage Portfoliolite
 * @since 1.0.0
 */
 // custom header background
function portfoliolite_custom_style(){ 
$portfoliolite_style="";
$portfoliolite_theme_color  = esc_html(get_theme_mod('portfoliolite_theme_color',''));
$portfoliolite_style.=".logo h1 a, .logo-cent h1 a, mark, li.current-menu-item a, .menu-item.active a, .navigation .menu > li a:hover,.navigation ul ul a:hover, .navigation ul ul a:link:hover, .navigation ul ul a:visited:hover, .current_page_item a, .sub-menu li:hover,.nav-footer ul li a:hover, .sidebar-inner-widget ul li:before, .post_meta a:hover,.post-previous a:hover:before,
.post-next a:hover:before,button.load-more:hover,.sidebar-inner-widget ul li a:hover,.portfolio-desc .exp-btn button:hover,
.single-product .product_meta a:hover,
.copyright-section a,.portfolio-menu li a:hover, .portfolio-menu .current-menu-item a,.thunk-service-icon i {color:{$portfoliolite_theme_color}} ul.portfolio-navi button.active.is-checked, ul.portfolio-navi button:visited, ul.portfolio-navi button:focus,
ul.portfolio-navi button.is-checked{color:{$portfoliolite_theme_color}; border-color:{$portfoliolite_theme_color}} figure.protfolio-img-efc:after,.blog-info-header h2:after, #respond input#submit,.widget #wp-calendar th,.footer-wrapper tbody>tr>td>a,.menu-item-has-children >a:hover:before,
.menu-item-has-children >a:hover:after,
.th-woocommerce a.button:hover, 
.woocommerce ul.products li.product .button:hover,
.button-ribbon,
.button-news-letter,
#resume-ribbon .download-resume-c a:hover,
#resume-ribbon .view-resume-c a:hover,
.woocommerce #respond input#submit:hover, 
.woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover,
.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,.social-meta li a:hover{background-color:{$portfoliolite_theme_color}} button{background:{$portfoliolite_theme_color}; border:1px solid {$portfoliolite_theme_color}} .arrow-up a:hover:before {
    border-top-color:{$portfoliolite_theme_color}; 
    border-left-color:{$portfoliolite_theme_color}; 
} .footer-widget-column .widget .widgettitle{border-bottom: 1px solid {$portfoliolite_theme_color};} .portfolio-desc button,
.tagcloud a,
.button-ribbon:hover,
.button-news-letter:hover,a:hover{color:{$portfoliolite_theme_color}; 
    border-color:{$portfoliolite_theme_color}} .portfolio-desc .exp-btn button,
.portfolio-desc button:hover,
.tagcloud a:hover{
    background: {$portfoliolite_theme_color}; 
    border-color: {$portfoliolite_theme_color}
  }
.portfolio-menu ul.sub-menu{border-bottom-color:{$portfoliolite_theme_color}} .th-woocommerce a.button, .woocommerce ul.products li.product .button{color:{$portfoliolite_theme_color};border-color:{$portfoliolite_theme_color}} #searchform [type='submit'], button[type='submit']{border-color:{$portfoliolite_theme_color};background-color:{$portfoliolite_theme_color}} .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current,.nav-links .page-numbers.current, .nav-links .page-numbers:hover{background-color:{$portfoliolite_theme_color}}";
return $portfoliolite_style;
}
/*************************************************/
//*******************Typography******************//
/*************************************************/
function portfoliolite_typography_style(){
$thunk_typo_style=""; 
// body
$portfoliolite_body_font = esc_html(get_theme_mod('portfoliolite_body_font'));
$portfoliolite_body_text_transform = esc_html(get_theme_mod('portfoliolite_body_text_transform'));
if(!empty($portfoliolite_body_font)){
portfoliolite_enqueue_google_font($portfoliolite_body_font);
$thunk_typo_style.="body, button, input, select, textarea,#respond.comment-respond #submit, .read-more .alm-button, button, [type='submit'], .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,.almaira-menu li a,.thunk-sortby .sort-radio,.th-check-container{ 
   font-family:{$portfoliolite_body_font};
   text-transform:{$portfoliolite_body_text_transform};
  }";
}

// title
$portfoliolite_title_font = esc_html(get_theme_mod('portfoliolite_title_font'));
$portfoliolite_title_text_transform = esc_html(get_theme_mod('portfoliolite_title_text_transform'));
if(!empty($portfoliolite_title_font)){
portfoliolite_enqueue_google_font($portfoliolite_title_font);
$thunk_typo_style.=".entry-content h1,h1,.entry-content h2,h2,.main-heading,.entry-content h3,h3,#call-ribbon h3,.th-counter-title,.entry-content h4,h4,.widgettitle,
   .footer-widget-column .widget .widgettitle,.entry-content h5,h5,.entry-content h6,h6,.portfolio-desc p.th-slider-heading,.test-cont-heading h3{ 
   font-family:{$portfoliolite_title_font};
   text-transform:{$portfoliolite_title_text_transform};
  }";
}
//H1
$portfoliolite_h1_font = esc_html(get_theme_mod('portfoliolite_h1_font'));
$portfoliolite_h1_text_transform = esc_html(get_theme_mod('portfoliolite_h1_text_transform'));
if(!empty($portfoliolite_h1_font)){
portfoliolite_enqueue_google_font($portfoliolite_h1_font);
$thunk_typo_style.=".entry-content h1,h1{ 
   font-family:{$portfoliolite_h1_font};
   text-transform:{$portfoliolite_h1_text_transform};
  }";
}
//H2
$portfoliolite_h2_font = esc_html(get_theme_mod('portfoliolite_h2_font'));
$portfoliolite_h2_text_transform = esc_html(get_theme_mod('portfoliolite_h2_text_transform'));
if(!empty($portfoliolite_h2_font)){
portfoliolite_enqueue_google_font($portfoliolite_h2_font);
$thunk_typo_style.=".entry-content h2,h2,.main-heading{ 
   font-family:{$portfoliolite_h2_font};
   text-transform:{$portfoliolite_h2_text_transform};
  }";
}
//H3
$portfoliolite_h3_font = esc_html(get_theme_mod('portfoliolite_h3_font'));
$portfoliolite_h3_text_transform = esc_html(get_theme_mod('portfoliolite_h3_text_transform'));
if(!empty($portfoliolite_h3_font)){
portfoliolite_enqueue_google_font($portfoliolite_h3_font);
$thunk_typo_style.=".entry-content h3,h3,#call-ribbon h3,.th-counter-title{ 
   font-family:{$portfoliolite_h3_font};
   text-transform:{$portfoliolite_h3_text_transform};
  }";
}
//H4
$portfoliolite_h4_font = esc_html(get_theme_mod('portfoliolite_h4_font'));
$portfoliolite_h4_text_transform = esc_html(get_theme_mod('portfoliolite_h4_text_transform'));
if(!empty($portfoliolite_h4_font)){
portfoliolite_enqueue_google_font($portfoliolite_h4_font);
$thunk_typo_style.=".entry-content h4,h4,.widgettitle,
   .footer-widget-column .widget .widgettitle{ 
   font-family:{$portfoliolite_h4_font};
   text-transform:{$portfoliolite_h4_text_transform};
  }";
}
//H5
$portfoliolite_h5_font = esc_html(get_theme_mod('portfoliolite_h5_font'));
$portfoliolite_h5_text_transform = esc_html(get_theme_mod('portfoliolite_h5_text_transform'));
if(!empty($portfoliolite_h5_font)){
portfoliolite_enqueue_google_font($portfoliolite_h5_font);
$thunk_typo_style.=".entry-content h5,h5{ 
   font-family:{$portfoliolite_h5_font};
   text-transform:{$portfoliolite_h5_text_transform};
  }";
}
//H6
$portfoliolite_h6_font = esc_html(get_theme_mod('portfoliolite_h6_font'));
$portfoliolite_h6_text_transform = esc_html(get_theme_mod('portfoliolite_h6_text_transform'));
if(!empty($portfoliolite_h6_font)){
portfoliolite_enqueue_google_font($portfoliolite_h6_font);
$thunk_typo_style.=".entry-content h6,h6{ 
   font-family:{$portfoliolite_h6_font};
   text-transform:{$portfoliolite_h6_text_transform};
  }";
}
/********************/
//Content typography
/********************/
function portfoliolite_h1_size_responsive( $value, $dimension = 'desktop' ){
    $custom_css = '';
    switch ( $dimension ){
    case 'desktop':
      $v3 = $value;
      break;
    case 'tablet':
      $v3 = $value;
      break;
    case 'mobile':
      $v3 = $value;
    break;
    }
   $custom_css .= '.entry-content h1,h1{
   font-size: ' . $v3 . 'px;
   }';
   $custom_css = portfoliolite_add_media_query($dimension, $custom_css);
   return $custom_css;
}
function portfoliolite_h1_line_height_responsive( $value, $dimension = 'desktop' ){
    $custom_css = '';
    switch ( $dimension ){
    case 'desktop':
      $v3 = $value;
      break;
    case 'tablet':
      $v3 = $value;
      break;
    case 'mobile':
      $v3 = $value;
    break;
    }
   $custom_css .= '.entry-content h1,h1{
   line-height: ' . $v3 . ';
   }';
   $custom_css = portfoliolite_add_media_query($dimension, $custom_css);
   return $custom_css;
}
function portfoliolite_h1_letter_spacing_responsive( $value, $dimension = 'desktop' ){
    $custom_css = '';
    switch ( $dimension ){
    case 'desktop':
      $v3 = $value;
      break;
    case 'tablet':
      $v3 = $value;
      break;
    case 'mobile':
      $v3 = $value;
    break;
    }
   $custom_css .= '.entry-content h1,h1
   letter-spacing: ' . $v3 . 'px;
   }';
   $custom_css = portfoliolite_add_media_query($dimension, $custom_css);
   return $custom_css;
}
// h2
function portfoliolite_h2_size_responsive( $value, $dimension = 'desktop' ){
    $custom_css = '';
    switch ( $dimension ){
    case 'desktop':
      $v3 = $value;
      break;
    case 'tablet':
      $v3 = $value;
      break;
    case 'mobile':
      $v3 = $value;
    break;
    }
   $custom_css .= '.entry-content h2,h2,.main-heading{
   font-size: ' . $v3 . 'px;
   }';
   $custom_css = portfoliolite_add_media_query($dimension, $custom_css);
   return $custom_css;
}
function portfoliolite_h2_line_height_responsive( $value, $dimension = 'desktop' ){
    $custom_css = '';
    switch ( $dimension ){
    case 'desktop':
      $v3 = $value;
      break;
    case 'tablet':
      $v3 = $value;
      break;
    case 'mobile':
      $v3 = $value;
    break;
    }
   $custom_css .= '.entry-content h2,h2,.main-heading{
   line-height: ' . $v3 . ';
   }';
   $custom_css = portfoliolite_add_media_query($dimension, $custom_css);
   return $custom_css;
}
function portfoliolite_h2_letter_spacing_responsive( $value, $dimension = 'desktop' ){
    $custom_css = '';
    switch ( $dimension ){
    case 'desktop':
      $v3 = $value;
      break;
    case 'tablet':
      $v3 = $value;
      break;
    case 'mobile':
      $v3 = $value;
    break;
    }
   $custom_css .= '.entry-content h2,h2,.main-heading{
   letter-spacing: ' . $v3 . 'px;
   }';
   $custom_css = portfoliolite_add_media_query($dimension, $custom_css);
   return $custom_css;
}
// h3
function portfoliolite_h3_size_responsive( $value, $dimension = 'desktop' ){
    $custom_css = '';
    switch ( $dimension ){
    case 'desktop':
      $v3 = $value;
      break;
    case 'tablet':
      $v3 = $value;
      break;
    case 'mobile':
      $v3 = $value;
    break;
    }
   $custom_css .= '.entry-content h3,h3,#call-ribbon h3,.th-counter-title{
   font-size: ' . $v3 . 'px;
   }';
   $custom_css = portfoliolite_add_media_query($dimension, $custom_css);
   return $custom_css;
}
function portfoliolite_h3_line_height_responsive( $value, $dimension = 'desktop' ){
    $custom_css = '';
    switch ( $dimension ){
    case 'desktop':
      $v3 = $value;
      break;
    case 'tablet':
      $v3 = $value;
      break;
    case 'mobile':
      $v3 = $value;
    break;
    }
   $custom_css .= '.entry-content h3,h3,#call-ribbon h3,.th-counter-title{
   line-height: ' . $v3 . ';
   }';
   $custom_css = portfoliolite_add_media_query($dimension, $custom_css);
   return $custom_css;
}
function portfoliolite_h3_letter_spacing_responsive( $value, $dimension = 'desktop' ){
    $custom_css = '';
    switch ( $dimension ){
    case 'desktop':
      $v3 = $value;
      break;
    case 'tablet':
      $v3 = $value;
      break;
    case 'mobile':
      $v3 = $value;
    break;
    }
   $custom_css .= '.entry-content h3,h3,#call-ribbon h3,.th-counter-title{
   letter-spacing: ' . $v3 . 'px;
   }';
   $custom_css = portfoliolite_add_media_query($dimension, $custom_css);
   return $custom_css;
}
// h4
function portfoliolite_h4_size_responsive( $value, $dimension = 'desktop' ){
    $custom_css = '';
    switch ( $dimension ){
    case 'desktop':
      $v3 = $value;
      break;
    case 'tablet':
      $v3 = $value;
      break;
    case 'mobile':
      $v3 = $value;
    break;
    }
   $custom_css .= '.entry-content h4,h4,.widgettitle,
   .footer-widget-column .widget .widgettitle{
   font-size: ' . $v3 . 'px;
   }';
   $custom_css = portfoliolite_add_media_query($dimension, $custom_css);
   return $custom_css;
}
function portfoliolite_h4_line_height_responsive( $value, $dimension = 'desktop' ){
    $custom_css = '';
    switch ( $dimension ){
    case 'desktop':
      $v3 = $value;
      break;
    case 'tablet':
      $v3 = $value;
      break;
    case 'mobile':
      $v3 = $value;
    break;
    }
   $custom_css .= '.entry-content h4,h4,.widgettitle,
   .footer-widget-column .widget .widgettitle{
   line-height: ' . $v3 . ';
   }';
   $custom_css = portfoliolite_add_media_query($dimension, $custom_css);
   return $custom_css;
}
function portfoliolite_h4_letter_spacing_responsive( $value, $dimension = 'desktop' ){
    $custom_css = '';
    switch ( $dimension ){
    case 'desktop':
      $v3 = $value;
      break;
    case 'tablet':
      $v3 = $value;
      break;
    case 'mobile':
      $v3 = $value;
    break;
    }
   $custom_css .= '.entry-content h4,h4,.widgettitle,
   .footer-widget-column .widget .widgettitle{
   letter-spacing: ' . $v3 . 'px;
   }';
   $custom_css = portfoliolite_add_media_query($dimension, $custom_css);
   return $custom_css;
}
// h5
function portfoliolite_h5_size_responsive( $value, $dimension = 'desktop' ){
    $custom_css = '';
    switch ( $dimension ){
    case 'desktop':
      $v3 = $value;
      break;
    case 'tablet':
      $v3 = $value;
      break;
    case 'mobile':
      $v3 = $value;
    break;
    }
   $custom_css .= '.entry-content h5,h5{
   font-size: ' . $v3 . 'px;
   }';
   $custom_css = portfoliolite_add_media_query($dimension, $custom_css);
   return $custom_css;
}
function portfoliolite_h5_line_height_responsive( $value, $dimension = 'desktop' ){
    $custom_css = '';
    switch ( $dimension ){
    case 'desktop':
      $v3 = $value;
      break;
    case 'tablet':
      $v3 = $value;
      break;
    case 'mobile':
      $v3 = $value;
    break;
    }
   $custom_css .= '.entry-content h5,h5{
   line-height: ' . $v3 . ';
   }';
   $custom_css = portfoliolite_add_media_query($dimension, $custom_css);
   return $custom_css;
}
function portfoliolite_h5_letter_spacing_responsive( $value, $dimension = 'desktop' ){
    $custom_css = '';
    switch ( $dimension ){
    case 'desktop':
      $v3 = $value;
      break;
    case 'tablet':
      $v3 = $value;
      break;
    case 'mobile':
      $v3 = $value;
    break;
    }
   $custom_css .= '.entry-content h5,h5{
   letter-spacing: ' . $v3 . 'px;
   }';
   $custom_css = portfoliolite_add_media_query($dimension, $custom_css);
   return $custom_css;
}
// h6
function portfoliolite_h6_size_responsive( $value, $dimension = 'desktop' ){
    $custom_css = '';
    switch ( $dimension ){
    case 'desktop':
      $v3 = $value;
      break;
    case 'tablet':
      $v3 = $value;
      break;
    case 'mobile':
      $v3 = $value;
    break;
    }
   $custom_css .= '.entry-content h6,h6{
   font-size: ' . $v3 . 'px;
   }';
   $custom_css = portfoliolite_add_media_query($dimension, $custom_css);
   return $custom_css;
}
function portfoliolite_h6_line_height_responsive( $value, $dimension = 'desktop' ){
    $custom_css = '';
    switch ( $dimension ){
    case 'desktop':
      $v3 = $value;
      break;
    case 'tablet':
      $v3 = $value;
      break;
    case 'mobile':
      $v3 = $value;
    break;
    }
   $custom_css .= '.entry-content h6,h6{
   line-height: ' . $v3 . ';
   }';
   $custom_css = portfoliolite_add_media_query($dimension, $custom_css);
   return $custom_css;
}
function portfoliolite_h6_letter_spacing_responsive( $value, $dimension = 'desktop' ){
    $custom_css = '';
    switch ( $dimension ){
    case 'desktop':
      $v3 = $value;
      break;
    case 'tablet':
      $v3 = $value;
      break;
    case 'mobile':
      $v3 = $value;
    break;
    }
   $custom_css .= '.entry-content h6,h6{
   letter-spacing: ' . $v3 . 'px;
   }';
   $custom_css = portfoliolite_add_media_query($dimension, $custom_css);
   return $custom_css;
}
$thunk_typo_style.= portfoliolite_responsive_slider_funct('portfoliolite_h1_size','portfoliolite_h1_size_responsive');
$thunk_typo_style.= portfoliolite_responsive_slider_funct('portfoliolite_h1_line_height','portfoliolite_h1_line_height_responsive');
$thunk_typo_style.= portfoliolite_responsive_slider_funct('portfoliolite_h1_letter_spacing','portfoliolite_h1_letter_spacing_responsive');
$thunk_typo_style.= portfoliolite_responsive_slider_funct('portfoliolite_h2_size','portfoliolite_h2_size_responsive');
$thunk_typo_style.= portfoliolite_responsive_slider_funct('portfoliolite_h2_line_height','portfoliolite_h2_line_height_responsive');
$thunk_typo_style.= portfoliolite_responsive_slider_funct('portfoliolite_h2_letter_spacing','portfoliolite_h2_letter_spacing_responsive');
$thunk_typo_style.= portfoliolite_responsive_slider_funct('portfoliolite_h3_size','portfoliolite_h3_size_responsive');
$thunk_typo_style.= portfoliolite_responsive_slider_funct('portfoliolite_h3_line_height','portfoliolite_h3_line_height_responsive');
$thunk_typo_style.= portfoliolite_responsive_slider_funct('portfoliolite_h3_letter_spacing','portfoliolite_h3_letter_spacing_responsive');
$thunk_typo_style.= portfoliolite_responsive_slider_funct('portfoliolite_h4_size','portfoliolite_h4_size_responsive');
$thunk_typo_style.= portfoliolite_responsive_slider_funct('portfoliolite_h4_line_height','portfoliolite_h4_line_height_responsive');
$thunk_typo_style.= portfoliolite_responsive_slider_funct('portfoliolite_h4_letter_spacing','portfoliolite_h4_letter_spacing_responsive');
$thunk_typo_style.= portfoliolite_responsive_slider_funct('portfoliolite_h5_size','portfoliolite_h5_size_responsive');
$thunk_typo_style.= portfoliolite_responsive_slider_funct('portfoliolite_h5_line_height','portfoliolite_h5_line_height_responsive');
$thunk_typo_style.= portfoliolite_responsive_slider_funct('portfoliolite_h5_letter_spacing','portfoliolite_h5_letter_spacing_responsive');
$thunk_typo_style.= portfoliolite_responsive_slider_funct('portfoliolite_h6_size','portfoliolite_h6_size_responsive');
$thunk_typo_style.= portfoliolite_responsive_slider_funct('portfoliolite_h6_line_height','portfoliolite_h6_line_height_responsive');
$thunk_typo_style.= portfoliolite_responsive_slider_funct('portfoliolite_h6_letter_spacing','portfoliolite_h6_letter_spacing_responsive');
return $thunk_typo_style; 
}
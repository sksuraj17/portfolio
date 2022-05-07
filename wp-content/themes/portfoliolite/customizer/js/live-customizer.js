/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 */
( jQuery(function( $){
/**
 * Dynamic Internal/Embedded Style for a Control
 */
function portfoliolite_add_dynamic_css( control, style ){
      control = control.replace( '[', '-' );
      control = control.replace( ']', '' );
      jQuery( 'style#' + control ).remove();

      jQuery( 'head' ).append(
            '<style id="' + control + '">' + style + '</style>'
      );
}
/**
 * Responsive Spacing CSS
 */
function portfoliolite_responsive_spacing( control, selector, type, side ){
	wp.customize( control, function( value ){
		value.bind( function( value ){
			var sidesString = "";
			var spacingType = "padding";
			if ( value.desktop.top || value.desktop.right || value.desktop.bottom || value.desktop.left || value.tablet.top || value.tablet.right || value.tablet.bottom || value.tablet.left || value.mobile.top || value.mobile.right || value.mobile.bottom || value.mobile.left ) {
				if ( typeof side != undefined ) {
					sidesString = side + "";
					sidesString = sidesString.replace(/,/g , "-");
				}
				if ( typeof type != undefined ) {
					spacingType = type + "";
				}
				// Remove <style> first!
				control = control.replace( '[', '-' );
				control = control.replace( ']', '' );
				jQuery( 'style#' + control + '-' + spacingType + '-' + sidesString ).remove();

				var desktopPadding = '',
					tabletPadding = '',
					mobilePadding = '';

				var paddingSide = ( typeof side != undefined ) ? side : [ 'top','bottom','right','left' ];

				jQuery.each(paddingSide, function( index, sideValue ){
					if ( '' != value['desktop'][sideValue] ) {
						desktopPadding += spacingType + '-' + sideValue +': ' + value['desktop'][sideValue] + value['desktop-unit'] +';';
					}
				});

				jQuery.each(paddingSide, function( index, sideValue ){
					if ( '' != value['tablet'][sideValue] ) {
						tabletPadding += spacingType + '-' + sideValue +': ' + value['tablet'][sideValue] + value['tablet-unit'] +';';
					}
				});

				jQuery.each(paddingSide, function( index, sideValue ){
					if ( '' != value['mobile'][sideValue] ) {
						mobilePadding += spacingType + '-' + sideValue +': ' + value['mobile'][sideValue] + value['mobile-unit'] +';';
					}
				});

				// Concat and append new <style>.
				jQuery( 'head' ).append(
					'<style id="' + control + '-' + spacingType + '-' + sidesString + '">'
					+ selector + '	{ ' + desktopPadding +' }'
					+ '@media (max-width: 768px) {' + selector + '	{ ' + tabletPadding + ' } }'
					+ '@media (max-width: 544px) {' + selector + '	{ ' + mobilePadding + ' } }'
					+ '</style>'
				);

			} else {
				wp.customize.preview.send( 'refresh' );
				jQuery( 'style#' + control + '-' + spacingType + '-' + sidesString ).remove();
			}

		} );
	} );
}
/**
 * Apply CSS for the element
 */
function portfoliolite_css( control, css_property, selector, unit ){

	wp.customize( control, function( value ) {
		value.bind( function( new_value ) {

			// Remove <style> first!
			control = control.replace( '[', '-' );
			control = control.replace( ']', '' );

			if ( new_value ){
				/**
				 *	If ( unit == 'url' ) then = url('{VALUE}')
				 *	If ( unit == 'px' ) then = {VALUE}px
				 *	If ( unit == 'em' ) then = {VALUE}em
				 *	If ( unit == 'rem' ) then = {VALUE}rem.
				 */
				if ( 'undefined' != typeof unit) {
					if ( 'url' === unit ) {
						new_value = 'url(' + new_value + ')';
					} else {
						new_value = new_value + unit;
					}
				}

				// Remove old.
				jQuery( 'style#' + control ).remove();

				// Concat and append new <style>.
				jQuery( 'head' ).append(
					'<style id="' + control + '">'
					+ selector + '	{ ' + css_property + ': ' + new_value + ' }'
					+ '</style>'
				);

			} else {

				wp.customize.preview.send( 'refresh' );

				// Remove old.
				jQuery( 'style#' + control ).remove();
			}

		} );
	} );
}
/*******************************/
// Range slider live customizer
/*******************************/
function portfolioliteGetCss( arraySizes, settings, to ) {
    'use strict';
    var data, desktopVal, tabletVal, mobileVal,
        className = settings.styleClass, i = 1;

    var val = JSON.parse( to );
    if ( typeof( val ) === 'object' && val !== null ) {
        if ('desktop' in val) {
            desktopVal = val.desktop;
        }
        if ('tablet' in val) {
            tabletVal = val.tablet;
        }
        if ('mobile' in val) {
            mobileVal = val.mobile;
        }
    }

    for ( var key in arraySizes ) {
        // skip loop if the property is from prototype
        if ( ! arraySizes.hasOwnProperty( key )) {
            continue;
        }
        var obj = arraySizes[key];
        var limit = 0;
        var correlation = [1,1,1];
        if ( typeof( val ) === 'object' && val !== null ) {

            if( typeof obj.limit !== 'undefined'){
                limit = obj.limit;
            }

            if( typeof obj.correlation !== 'undefined'){
                correlation = obj.correlation;
            }

            data = {
                desktop: ( parseInt(parseFloat( desktopVal ) / correlation[0]) + obj.values[0]) > limit ? ( parseInt(parseFloat( desktopVal ) / correlation[0]) + obj.values[0] ) : limit,
                tablet: ( parseInt(parseFloat( tabletVal ) / correlation[1]) + obj.values[1] ) > limit ? ( parseInt(parseFloat( tabletVal ) / correlation[1]) + obj.values[1] ) : limit,
                mobile: ( parseInt(parseFloat( mobileVal ) / correlation[2]) + obj.values[2] ) > limit ? ( parseInt(parseFloat( mobileVal ) / correlation[2]) + obj.values[2] ) : limit
            };
        } else {
            if( typeof obj.limit !== 'undefined'){
                limit = obj.limit;
            }

            if( typeof obj.correlation !== 'undefined'){
                correlation = obj.correlation;
            }
            data =( parseInt( parseFloat( to ) / correlation[0] ) ) + obj.values[0] > limit ? ( parseInt( parseFloat( to ) / correlation[0] ) ) + obj.values[0] : limit;
        }
        settings.styleClass = className + '-' + i;
        settings.selectors  = obj.selectors;

        portfolioliteSetCss( settings, data );
        i++;
    }
}
function portfolioliteSetCss( settings, to ){
    'use strict';
    var result     = '';
    var styleClass = jQuery( '.' + settings.styleClass );
    if ( to !== null && typeof to === 'object' ) {
        jQuery.each(
            to, function ( key, value ) {
                var style_to_add;
                if ( settings.selectors === '.container' ) {
                    style_to_add = settings.selectors + '{ ' + settings.cssProperty + ':' + value + settings.propertyUnit + '; max-width: 100%; }';
                } else {
                    style_to_add = settings.selectors + '{ ' + settings.cssProperty + ':' + value + settings.propertyUnit + '}';
                }
                switch ( key ) {
                    case 'desktop':
                        result += style_to_add;
                        break;
                    case 'tablet':
                        result += '@media (max-width: 767px){' + style_to_add + '}';
                        break;
                    case 'mobile':
                        result += '@media (max-width: 544px){' + style_to_add + '}';
                        break;
                }
            }
        );
        if ( styleClass.length > 0 ) {
            styleClass.text( result );
        } else {
            jQuery( 'head' ).append( '<style type="text/css" class="' + settings.styleClass + '">' + result + '</style>' );
        }
    } else {
        jQuery( settings.selectors ).css( settings.cssProperty, to + 'px' );
    }
}
//portfoliolite_theme_color
//For multiple css values with the same id
wp.customize( 'portfoliolite_theme_color', function( setting ){
        setting.bind( function( cssval ){
                var dynamicStyle = '';
                dynamicStyle += '.logo h1 a, .logo-cent h1 a,mark,li.current-menu-item a, .menu-item .active, .navigation .menu > li a:hover,.navigation ul ul a:hover, .navigation ul ul a:link:hover, .navigation ul ul a:visited:hover, .current_page_item a,.sub-menu li:hover,.nav-footer ul li a:hover,.sidebar-inner-widget ul li:before,ul.portfolio-navi button.active.is-checked, ul.portfolio-navi button:visited, ul.portfolio-navi button:focus,ul.portfolio-navi button.is-checked,.post_meta a:hover,.post-previous a:hover:before,.post-next a:hover:before,button.load-more:hover,.sidebar-inner-widget ul li a:hover,.portfolio-desc .exp-btn button:hover,.single-product .product_meta a:hover,.copyright-section a,.portfolio-desc button,.tagcloud a,.button-ribbon:hover,.button-news-letter:hover{ color: ' + cssval + '} ';
                dynamicStyle += '.social-meta li a:hover,figure.protfolio-img-efc:after,.blog-info-header h2:after,#respond input#submit,button,.widget #wp-calendar th,.menu-item-has-children >a:hover:before,.menu-item-has-children >a:hover:after,.th-woocommerce a.button:hover, .woocommerce ul.products li.product .button:hover,.button-ribbon,.button-news-letter,#resume-ribbon .download-resume-c a:hover,#resume-ribbon .view-resume-c a:hover,.woocommerce #respond input#submit:hover,.woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover,.portfolio-desc .exp-btn button,.portfolio-desc button:hover,.tagcloud a:hover,.woocommerce-cart .wc-proceed-to-checkout a.checkout-button{ background: ' + cssval + '} ';
                dynamicStyle += 'ul.portfolio-navi button.active.is-checked, ul.portfolio-navi button:visited, ul.portfolio-navi button:focus,ul.portfolio-navi button.is-checked,button,.arrow-up a:hover:before,.footer-widget-column .widget .widgettitle,.footer-wrapper tbody>tr>td>a,.portfolio-desc button,.tagcloud a,.button-ribbon:hover,.button-news-letter:hover,.portfolio-desc .exp-btn button,.portfolio-desc button:hover,.tagcloud a:hover{ border-color: ' + cssval + '} ';
                portfoliolite_add_dynamic_css( 'portfoliolite_theme_color', dynamicStyle );

        } );
    } );
//ribbon secion 
portfoliolite_css( 'ribbonbtm_img_overly_color','background-color', '.frontpage #call-ribbon:before');
portfoliolite_css( 'ribbon_txt_color','color', '.frontpage #call-ribbon h3');
portfoliolite_css( 'ribbon_bnt_hvr_color','background-color', '.frontpage ');
//For multiple css values with the same id
wp.customize( 'ribbon_bnt_color', function( setting ){
        setting.bind( function( cssval ){
                var dynamicStyle = '';
                dynamicStyle += '#call-ribbon .button-ribbon:hover{ color: ' + cssval + '} ';
                dynamicStyle += '#call-ribbon .button-ribbon{ background: ' + cssval + '} ';
                dynamicStyle += '#call-ribbon .button-ribbon{ border-color: ' + cssval + '} ';
                portfoliolite_add_dynamic_css( 'ribbon_bnt_color', dynamicStyle );

        } );
    } );
wp.customize( 'ribbon_bnt_hvr_color', function( setting ){
        setting.bind( function( cssval ){
                var dynamicStyle = '';
                dynamicStyle += '#call-ribbon .button-ribbon{ color: ' + cssval + '} ';
                dynamicStyle += '#call-ribbon .button-ribbon:hover{ background: ' + cssval + '} ';
                portfoliolite_add_dynamic_css( 'ribbon_bnt_hvr_color', dynamicStyle );

        } );
    } );
//top secion 
portfoliolite_css( 'ovrly_color','background', '.frontpage .overlay');
portfoliolite_css( 'parallax_head_color','color', '.frontpage .portfolio-desc p.th-slider-heading');
portfoliolite_css( 'parallax_typer_color','background-color', '.frontpage ');
// portfoliolite_css( 'parallax_button_color','background-color', '.frontpage .portfolio-desc button');
wp.customize( 'parallax_button_color', function( setting ){
        setting.bind( function( cssval ){
                var dynamicStyle = '';
                dynamicStyle += '.frontpage .portfolio-desc button,.frontpage .portfolio-desc .exp-btn button:hover{ color: ' + cssval + '} ';
                dynamicStyle += '.frontpage .portfolio-desc button:hover,.frontpage .portfolio-desc .exp-btn button{ background: ' + cssval + '} ';
                dynamicStyle += '.frontpage .portfolio-desc button,.frontpage .portfolio-desc button:hover,.frontpage .portfolio-desc .exp-btn button{ border-color: ' + cssval + '} ';
                portfoliolite_add_dynamic_css( 'parallax_button_color', dynamicStyle );

        } );
    } );
//portfolio section
portfoliolite_css( 'portfolio_overly_color','background', '.frontpage #portfolio-mywork-section:before');
portfoliolite_css( 'portfo_txt_color','color', '.frontpage #portfolio-mywork-section h2.main-heading');
portfoliolite_css( 'portfo_subtxt_color','color', '.frontpage #portfolio-mywork-section p.sub-heading');
portfoliolite_css( 'portfo_img_ovrly_color','background', '.frontpage figure.protfolio-img-efc:after');
//For multiple css values with the same id
wp.customize( 'portfo_category_color', function( setting ){
        setting.bind( function( cssval ){
                var dynamicStyle = '';
                dynamicStyle += '.frontpage ul.portfolio-navi button{ color: ' + cssval + '} ';
                dynamicStyle += '.frontpage ul.portfolio-navi button{ border-color: ' + cssval + '} ';
                portfoliolite_add_dynamic_css( 'portfo_category_color', dynamicStyle );

        } );
    } );
//For multiple css values with the same id
wp.customize( 'portfo_category_hvr_color', function( setting ){
        setting.bind( function( cssval ){
                var dynamicStyle = '';
                dynamicStyle += '.frontpage ul.portfolio-navi button:hover,.frontpage ul.portfolio-navi button.is-checked{ color: ' + cssval + '} ';
                dynamicStyle += '.frontpage ul.portfolio-navi button:hover,.frontpage ul.portfolio-navi button.is-checked{ border-color: ' + cssval + '} ';
                portfoliolite_add_dynamic_css( 'portfo_category_hvr_color', dynamicStyle );

        } );
    } );

//For multiple css values with the same id
wp.customize( 'portfo_img_capn_color', function( setting ){
        setting.bind( function( cssval ){
                var dynamicStyle = '';
                dynamicStyle += '.frontpage figure.protfolio-img-efc h3{ color: ' + cssval + '} ';
                dynamicStyle += '.frontpage figure.protfolio-img-efc h3:after{ background: ' + cssval + '} ';
                portfoliolite_add_dynamic_css( 'portfo_img_capn_color', dynamicStyle );

        } );
    } );

//Resume Section
portfoliolite_css( 'resume_img_overly_color','background', '.frontpage #resume-ribbon:before');
portfoliolite_css( 'resume_title_color','color', '.frontpage #resume-ribbon h2');
portfoliolite_css( 'button1_bg_color','background', '.frontpage #resume-ribbon .view-resume-c a');
portfoliolite_css( 'button1_bg_hvr_color','background', '.frontpage #resume-ribbon .view-resume-c a:hover');
portfoliolite_css( 'button2_bg_color','background', '.frontpage #resume-ribbon .download-resume-c a');
portfoliolite_css( 'button2_bg_hvr_color','background', '.frontpage #resume-ribbon .download-resume-c a:hover');
//For multiple css values with the same id
wp.customize( 'button1_text_color', function( setting ){
        setting.bind( function( cssval ){
                var dynamicStyle = '';
                dynamicStyle += '.frontpage #resume-ribbon .view-resume-c a{ color: ' + cssval + '} ';
                dynamicStyle += '.frontpage #resume-ribbon .view-resume-c a{ border-color: ' + cssval + '} ';
                portfoliolite_add_dynamic_css( 'button1_text_color', dynamicStyle );

        } );
    } );
//For multiple css values with the same id
wp.customize( 'button1_text_hvr_color', function( setting ){
        setting.bind( function( cssval ){
                var dynamicStyle = '';
                dynamicStyle += '.frontpage #resume-ribbon .view-resume-c a:hover{ color: ' + cssval + '} ';
                dynamicStyle += '.frontpage #resume-ribbon .view-resume-c a:hover{ border-color: ' + cssval + '} ';
                portfoliolite_add_dynamic_css( 'button1_text_hvr_color', dynamicStyle );

        } );
    } );

//For multiple css values with the same id
wp.customize( 'button2_text_color', function( setting ){
        setting.bind( function( cssval ){
                var dynamicStyle = '';
                dynamicStyle += '.frontpage #resume-ribbon .download-resume-c a{ color: ' + cssval + '} ';
                dynamicStyle += '.frontpage #resume-ribbon .download-resume-c a{ border-color: ' + cssval + '} ';
                portfoliolite_add_dynamic_css( 'button2_text_color', dynamicStyle );

        } );
    } );
//For multiple css values with the same id
wp.customize( 'button2_text_hvr_color', function( setting ){
        setting.bind( function( cssval ){
                var dynamicStyle = '';
                dynamicStyle += '.frontpage #resume-ribbon .download-resume-c a:hover{ color: ' + cssval + '} ';
                dynamicStyle += '.frontpage #resume-ribbon .download-resume-c a:hover{ border-color: ' + cssval + '} ';
                portfoliolite_add_dynamic_css( 'button2_text_hvr_color', dynamicStyle );

        } );
    } );


//testimonial
portfoliolite_css( 'testimonial_img_overly_color','background', '.frontpage .testimonials:before');
portfoliolite_css( 'testimonial_title_color','color', '.frontpage .test-cont-heading h3');
portfoliolite_css( 'testimonial_dots_color','background', '.frontpage .bx-wrapper .bx-pager.bx-default-pager a:hover,.frontpage .bx-wrapper .bx-pager.bx-default-pager a.active');
wp.customize( 'testimonial_desc_color', function( setting ){
        setting.bind( function( cssval ){
                var dynamicStyle = '';
                dynamicStyle += '.frontpage .test-cont{ color: ' + cssval + '} ';
                dynamicStyle += '.frontpage .test-cont{ border-color: ' + cssval + '} ';
                portfoliolite_add_dynamic_css( 'testimonial_desc_color', dynamicStyle );

        } );
    } );
//team section
portfoliolite_css( 'team_img_overly_color','background', '.frontpage #team-info:before');
portfoliolite_css( 'team_txt_color','color', '.frontpage #team-info h2.main-heading');
portfoliolite_css( 'team_subtxt_color','color', '.frontpage #team-info p.sub-heading');

//News Section
portfoliolite_css( 'news_img_overly_color','background', '.frontpage #new-letter:before');
portfoliolite_css( 'news_title_color','color', '.frontpage #new-letter .new-letter-block h3');
wp.customize( 'news_button_color', function( setting ){
        setting.bind( function( cssval ){
                var dynamicStyle = '';
                dynamicStyle += '.frontpage #new-letter .button-news-letter:hover{ color: ' + cssval + '} ';
                dynamicStyle += '.frontpage #new-letter .button-news-letter{ background: ' + cssval + '} ';
                dynamicStyle += '.frontpage #new-letter .button-news-letter{ border-color: ' + cssval + '} ';
                portfoliolite_add_dynamic_css( 'news_button_color', dynamicStyle );

        } );
    } );

wp.customize( 'news_button_hvr_color', function( setting ){
        setting.bind( function( cssval ){
                var dynamicStyle = '';
                dynamicStyle += '.frontpage #new-letter .button-news-letter{ color: ' + cssval + '} ';
                dynamicStyle += '.frontpage #new-letter .button-news-letter:hover{ background: ' + cssval + '} ';
                portfoliolite_add_dynamic_css( 'news_button_hvr_color', dynamicStyle );

        } );
    } );


//  Services Section
portfoliolite_css( 'service_img_overly_color','background', '.frontpage .thunk-service:before');
portfoliolite_css( 'service_heading_color','color', '.frontpage .thunk-service h2.main-heading');
portfoliolite_css( 'service_description_color','color', '.frontpage .thunk-service p.sub-heading');
//  Brand Section
portfoliolite_css( 'brand_img_overly_color','background', '.frontpage #th-brand:before');
//  Woocommerce Section
portfoliolite_css( 'woocommerce_img_overly_color','background', '.frontpage .th-woocommerce:before');
portfoliolite_css( 'woocommerce_heading_color','color', '.frontpage .th-woocommerce h2.main-heading');
portfoliolite_css( 'woocommerce_description_color','color', '.frontpage .th-woocommerce p.sub-heading');

// footer color option
portfoliolite_css( 'portfoliolite_footer_bg_color','background', '.company-detail, .footer-wrapper');
portfoliolite_css( 'portfoliolite_footer_copybg_color','background', '.copyright-section');
portfoliolite_css( 'portfoliolite_footer_txt_color','color', '.copyright-section p');
portfoliolite_css( 'portfoliolite_footer_anch_color','color', '.company-social a, .footer a,.company-social a, .footer a,.copyright-section a');
/**************************************/
// Top Section live preview
/**************************************/
wp.customize('parallax_heading', function(value){
         value.bind(function(to){
             $('.th-slider-heading').text(to);
         });
     });
 wp.customize('parallax_button_text1', function(value){
         value.bind(function(to) {
             $('.slider-top .shw-btn button').text(to);
         });
     });
 wp.customize('parallax_button_text2', function(value){
         value.bind(function(to) {
             $('.slider-top .exp-btn button').text(to);
         });
     });

 /**************************************/
// Portfolio Section live preview
/**************************************/
wp.customize('our_port_heading', function(value){
         value.bind(function(to){
             $('#portfolio-mywork-section .main-heading').text(to);
         });
     });
 wp.customize('our_port_subheading', function(value){
         value.bind(function(to) {
             $('#portfolio-mywork-section .sub-heading').text(to);
         });
     });
/**************************************/
// Skill Section live preview
/**************************************/
wp.customize('our_skill_heading', function(value){
         value.bind(function(to){
             $('#skill-info .main-heading').text(to);
         });
     });
 wp.customize('our_skill_subheading', function(value){
         value.bind(function(to) {
             $('#skill-info .sub-heading').text(to);
         });
     });

/**************************************/
// Team Section live preview
/**************************************/
wp.customize('our_team_heading', function(value){
         value.bind(function(to){
             $('#team-info .main-heading').text(to);
         });
     });
 wp.customize('our_team_subheading', function(value){
         value.bind(function(to) {
             $('#team-info .sub-heading').text(to);
         });
     });
/**************************************/
// News Letter Section live preview
/**************************************/
wp.customize('cf_head_', function(value){
         value.bind(function(to){
             $('.new-letter-title').text(to);
         });
     });
 wp.customize('cf_button_text_', function(value){
         value.bind(function(to) {
             $('.button-news-letter').text(to);
         });
     });
 /**************************************/
// Pricing Section live preview
/**************************************/
wp.customize('our_price_heading', function(value){
         value.bind(function(to){
             $('#price-package .main-heading').text(to);
         });
     });
 wp.customize('our_price_subheading', function(value){
         value.bind(function(to) {
             $('#price-package .sub-heading').text(to);
         });
     });

 /**************************************/
// Bottom Ribbon Section live preview
/**************************************/
wp.customize('hb_heading_bottom', function(value){
         value.bind(function(to){
             $('#call-ribbon h3').text(to);
         });
     });
 wp.customize('hb_button_text_bottom', function(value){
         value.bind(function(to) {
             $('#call-ribbon .button-ribbon').text(to);
         });
     });

 /**************************************/
// Services Section live preview
/**************************************/
wp.customize('our_service_heading', function(value){
         value.bind(function(to){
             $('.thunk-service .main-heading').text(to);
         });
     });
 wp.customize('our_service_subheading', function(value){
         value.bind(function(to) {
             $('.thunk-service .sub-heading').text(to);
         });
     });
 /**************************************/
// AboutUS Section live preview
/**************************************/
wp.customize('aboutus_heading', function(value){
         value.bind(function(to){
             $('#thunk-about .main-heading').text(to);
         });
     });
 wp.customize('aboutus_description', function(value){
         value.bind(function(to) {
             $('#thunk-about .sub-heading').text(to);
         });
     });
 /**************************************/
// Custom Section live preview
/**************************************/
wp.customize('customsection1_heading', function(value){
         value.bind(function(to){
             $('#th-custome-1 .main-heading').text(to);
         });
     });
 wp.customize('customsection1_subheading', function(value){
         value.bind(function(to) {
             $('#th-custome-1 .sub-heading').text(to);
         });
     });
 /**************************************/
// WooCommerce Section live preview
/**************************************/
wp.customize('our_woocommerce_heading', function(value){
         value.bind(function(to){
             $('#th-woocommerce .main-heading').text(to);
         });
     });
 wp.customize('our_woocommerce_subheading', function(value){
         value.bind(function(to) {
             $('#th-woocommerce .sub-heading').text(to);
         });
     });
 /**************************************/
// Contact Section live preview
/**************************************/
wp.customize('portfoliolite_eml_txt_', function(value){
         value.bind(function(to){
             $('.contact-list:nth-of-type(1) .contact-title a').text(to);
         });
     });

wp.customize('portfoliolite_add_txt_', function(value){
         value.bind(function(to){
             $('.contact-list:nth-of-type(2) .contact-title a').text(to);
         });
     });

wp.customize('portfoliolite_mob_txt_', function(value){
         value.bind(function(to){
             $('.contact-list:nth-of-type(3) .contact-title a').text(to);
         });
     });
/**************************************/
// Footer live preview
/**************************************/
wp.customize('portfoliolite_thm_txt_', function(value){
         value.bind(function(to){
             $('.company-social a').text(to);
         });
     });
 wp.customize('copyright_textbox', function(value){
         value.bind(function(to) {
             $('.copyright-section p').text(to);
         });
     });
 /*******************/
//Typography
// /*********************/
//Global Heading Font Size
// H1
wp.customize(
    'portfoliolite_h1_size', function (value){
       'use strict';
        value.bind(
            function( to ){
                var settings = {
                    cssProperty: 'font-size',
                    propertyUnit: 'px',
                    styleClass: 'portfoliolite_h1_size'
                };
                var arraySizes = {
                    size3: { selectors:'.entry-content h1', values: ['','',''] }
                };
                portfolioliteGetCss( arraySizes, settings, to );
            }
        );
    }
);
wp.customize(
    'portfoliolite_h1_line_height', function (value){
       'use strict';
        value.bind(
            function( to ){
                var settings = {
                    cssProperty: 'line-height',
                    propertyUnit: '',
                    styleClass: 'portfoliolite_h1_line_height'
                };
                var arraySizes = {
                    size3: { selectors:'.entry-content h1', values: ['','',''] }
                };
                portfolioliteGetCss( arraySizes, settings, to );
            }
        );
    }
);
wp.customize(
    'portfoliolite_h1_letter_spacing', function (value){
       'use strict';
        value.bind(
            function( to ){
                var settings = {
                    cssProperty: 'letter-spacing',
                    propertyUnit: 'px',
                    styleClass: 'portfoliolite_h1_letter_spacing'
                };
                var arraySizes = {
                    size3: { selectors:'.entry-content h1', values: ['','',''] }
                };
                portfolioliteGetCss( arraySizes, settings, to );
            }
        );
    }
);
// H2
wp.customize(
    'portfoliolite_h2_size', function (value){
       'use strict';
        value.bind(
            function( to ){
                var settings = {
                    cssProperty: 'font-size',
                    propertyUnit: 'px',
                    styleClass: 'portfoliolite_h2_size'
                };
                var arraySizes = {
                    size3: { selectors:'.content-wrapper h2', values: ['','',''] }
                };
                portfolioliteGetCss( arraySizes, settings, to );
            }
        );
    }
);
wp.customize(
    'portfoliolite_h2_line_height', function (value){
       'use strict';
        value.bind(
            function( to ){
                var settings = {
                    cssProperty: 'line-height',
                    propertyUnit: '',
                    styleClass: 'portfoliolite_h2_line_height'
                };
                var arraySizes = {
                    size3: { selectors:'.content-wrapper h2', values: ['','',''] }
                };
                portfolioliteGetCss( arraySizes, settings, to );
            }
        );
    }
);
wp.customize(
    'portfoliolite_h2_letter_spacing', function (value){
       'use strict';
        value.bind(
            function( to ){
                var settings = {
                    cssProperty: 'letter-spacing',
                    propertyUnit: 'px',
                    styleClass: 'portfoliolite_h2_letter_spacing'
                };
                var arraySizes = {
                    size3: { selectors:'.content-wrapper h2', values: ['','',''] }
                };
                portfolioliteGetCss( arraySizes, settings, to );
            }
        );
    }
);

// H3
wp.customize(
    'portfoliolite_h3_size', function (value){
       'use strict';
        value.bind(
            function( to ){
                var settings = {
                    cssProperty: 'font-size',
                    propertyUnit: 'px',
                    styleClass: 'portfoliolite_h3_size'
                };
                var arraySizes = {
                    size3: { selectors:'.content-wrapper h3', values: ['','',''] }
                };
                portfolioliteGetCss( arraySizes, settings, to );
            }
        );
    }
);
wp.customize(
    'portfoliolite_h3_line_height', function (value){
       'use strict';
        value.bind(
            function( to ){
                var settings = {
                    cssProperty: 'line-height',
                    propertyUnit: '',
                    styleClass: 'portfoliolite_h3_line_height'
                };
                var arraySizes = {
                    size3: { selectors:'.content-wrapper h3', values: ['','',''] }
                };
                portfolioliteGetCss( arraySizes, settings, to );
            }
        );
    }
);
wp.customize(
    'portfoliolite_h3_letter_spacing', function (value){
       'use strict';
        value.bind(
            function( to ){
                var settings = {
                    cssProperty: 'letter-spacing',
                    propertyUnit: 'px',
                    styleClass: 'portfoliolite_h3_letter_spacing'
                };
                var arraySizes = {
                    size3: { selectors:'.content-wrapper h3', values: ['','',''] }
                };
                portfolioliteGetCss( arraySizes, settings, to );
            }
        );
    }
);

// H4
wp.customize(
    'portfoliolite_h4_size', function (value){
       'use strict';
        value.bind(
            function( to ){
                var settings = {
                    cssProperty: 'font-size',
                    propertyUnit: 'px',
                    styleClass: 'portfoliolite_h4_size'
                };
                var arraySizes = {
                    size3: { selectors:'.content-wrapper h4', values: ['','',''] }
                };
                portfolioliteGetCss( arraySizes, settings, to );
            }
        );
    }
);
wp.customize(
    'portfoliolite_h4_line_height', function (value){
       'use strict';
        value.bind(
            function( to ){
                var settings = {
                    cssProperty: 'line-height',
                    propertyUnit: '',
                    styleClass: 'portfoliolite_h4_line_height'
                };
                var arraySizes = {
                    size3: { selectors:'.content-wrapper h4', values: ['','',''] }
                };
                portfolioliteGetCss( arraySizes, settings, to );
            }
        );
    }
);
wp.customize(
    'portfoliolite_h4_letter_spacing', function (value){
       'use strict';
        value.bind(
            function( to ){
                var settings = {
                    cssProperty: 'letter-spacing',
                    propertyUnit: 'px',
                    styleClass: 'portfoliolite_h4_letter_spacing'
                };
                var arraySizes = {
                    size3: { selectors:'.entry-content h4', values: ['','',''] }
                };
                portfolioliteGetCss( arraySizes, settings, to );
            }
        );
    }
);

// H5
wp.customize(
    'portfoliolite_h5_size', function (value){
       'use strict';
        value.bind(
            function( to ){
                var settings = {
                    cssProperty: 'font-size',
                    propertyUnit: 'px',
                    styleClass: 'portfoliolite_h5_size'
                };
                var arraySizes = {
                    size3: { selectors:'.entry-content h5', values: ['','',''] }
                };
                portfolioliteGetCss( arraySizes, settings, to );
            }
        );
    }
);
wp.customize(
    'portfoliolite_h5_line_height', function (value){
       'use strict';
        value.bind(
            function( to ){
                var settings = {
                    cssProperty: 'line-height',
                    propertyUnit: '',
                    styleClass: 'portfoliolite_h5_line_height'
                };
                var arraySizes = {
                    size3: { selectors:'.entry-content h5', values: ['','',''] }
                };
                portfolioliteGetCss( arraySizes, settings, to );
            }
        );
    }
);
wp.customize(
    'portfoliolite_h5_letter_spacing', function (value){
       'use strict';
        value.bind(
            function( to ){
                var settings = {
                    cssProperty: 'letter-spacing',
                    propertyUnit: 'px',
                    styleClass: 'portfoliolite_h5_letter_spacing'
                };
                var arraySizes = {
                    size3: { selectors:'.entry-content h5', values: ['','',''] }
                };
                portfolioliteGetCss( arraySizes, settings, to );
            }
        );
    }
);

// H6
wp.customize(
    'portfoliolite_h6_size', function (value){
       'use strict';
        value.bind(
            function( to ){
                var settings = {
                    cssProperty: 'font-size',
                    propertyUnit: 'px',
                    styleClass: 'portfoliolite_h6_size'
                };
                var arraySizes = {
                    size3: { selectors:'.entry-content h6', values: ['','',''] }
                };
                portfolioliteGetCss( arraySizes, settings, to );
            }
        );
    }
);
wp.customize(
    'portfoliolite_h6_line_height', function (value){
       'use strict';
        value.bind(
            function( to ){
                var settings = {
                    cssProperty: 'line-height',
                    propertyUnit: '',
                    styleClass: 'portfoliolite_h6_line_height'
                };
                var arraySizes = {
                    size3: { selectors:'.entry-content h6', values: ['','',''] }
                };
                portfolioliteGetCss( arraySizes, settings, to );
            }
        );
    }
);
wp.customize(
    'portfoliolite_h6_letter_spacing', function (value){
       'use strict';
        value.bind(
            function( to ){
                var settings = {
                    cssProperty: 'letter-spacing',
                    propertyUnit: 'px',
                    styleClass: 'portfoliolite_h6_letter_spacing'
                };
                var arraySizes = {
                    size3: { selectors:'.entry-content h6', values: ['','',''] }
                };
                portfolioliteGetCss( arraySizes, settings, to );
            }
        );
    }
);

}));
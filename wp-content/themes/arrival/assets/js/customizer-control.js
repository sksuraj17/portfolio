/**
 * Scripts within the customizer controls window.
 *
 * Contextually shows the color hue control and informs the preview
 * when users open or close the front page sections section.
 */

(function () {
	wp.customize.bind('ready', function () {

		
        /**
        * Top header
        * top right content type
        */

        wp.customize( 'arrival_top_left_content_type', function( setting ) {
            wp.customize.control( 'arrival_top_header_email', function( control ) {
                var visibility = function() {
                    if ( 'contacts' === setting.get() ) {
                        control.container.removeClass( 'arrival-control-hide' );
                    } else {
                        control.container.addClass( 'arrival-control-hide' );
                    }
                };

                visibility();
                setting.bind( visibility );
            });

            wp.customize.control( 'arrival_top_header_phone', function( control ) {
                var visibility = function() {
                    if ( 'contacts' === setting.get() ) {
                        control.container.removeClass( 'arrival-control-hide' );
                    } else {
                        control.container.addClass( 'arrival-control-hide' );
                    }
                };

                visibility();
                setting.bind( visibility );
            });

        });


		/* 
		* Top header 
		* top header right content option
		*/
		wp.customize( 'arrival_top_right_header_content', function( setting ) {
            wp.customize.control( 'arrival_top_right_header_menus', function( control ) {
                var visibility = function() {
                    if ( 'menus' === setting.get() ) {
                        control.container.removeClass( 'arrival-control-hide' );
                    } else {
                        control.container.addClass( 'arrival-control-hide' );
                    }
                };

                visibility();
                setting.bind( visibility );
            });

            wp.customize.control( 'arrival_top_social_redirect_btn', function( control ) {
                var visibility = function() {
                    if ( 'icons' === setting.get() ) {
                        control.container.removeClass( 'arrival-control-hide' );
                    } else {
                        control.container.addClass( 'arrival-control-hide' );
                    }
                };

                visibility();
                setting.bind( visibility );
            });

        });


	/**
	* Main navigation last item show/hide controller
	*
	*/
	wp.customize( 'arrival_main_nav_right_content', function( setting ) {
	            wp.customize.control( 'arrival_main_nav_right_btn_txt', function( control ) {
	                var visibility = function() {
	                    if ( 'button' === setting.get() ) {
	                        control.container.removeClass( 'arrival-control-hide' );
	                    } else {
	                        control.container.addClass( 'arrival-control-hide' );
	                    }
	                };

	                visibility();
	                setting.bind( visibility );
	            });
	});

    wp.customize( 'arrival_main_nav_right_content', function( setting ) {
                wp.customize.control( 'arrival_main_nav_right_btn_url', function( control ) {
                    var visibility = function() {
                        if ( 'button' === setting.get() ) {
                            control.container.removeClass( 'arrival-control-hide' );
                        } else {
                            control.container.addClass( 'arrival-control-hide' );
                        }
                    };

                    visibility();
                    setting.bind( visibility );
                });
    });


    /**
    * Footer social icon show/hide
    *
    */
    wp.customize( 'arrival_footer_icons_enable', function( setting ) {
                wp.customize.control( 'arrival_footer_social_redirect_btn', function( control ) {
                    var visibility = function() {
                        if ( 'yes' === setting.get() ) {
                            control.container.removeClass( 'arrival-control-hide' );
                        } else {
                            control.container.addClass( 'arrival-control-hide' );
                        }
                    };

                    visibility();
                    setting.bind( visibility );
                });
    });


	/**
     * Script for sidebars
     */
      jQuery('body').on('click', '.controls#arrival-img-container li', function () {
        jQuery(this).each(function(){
            jQuery(this).parent().find('img').removeClass ('arrival-radio-img-selected');
        });
        jQuery(this).find('img').addClass ('arrival-radio-img-selected');
    });


	});

/**
* Header Type control script
* @since 1.1.1
*/
wp.customize( 'arrival_site_header_type', function( setting ) {

    var headerSettings = ['arrival_main_nav_layout','arrival_single_nav_enable_sep','arrival_one_page_menus','arrival_main_nav_disable_logo','arrival_cart_display_position','arrival_main_nav_menu_align','arrival_nav_last_item_sep','arrival_main_nav_right_content','arrival_main_nav_last_item_align'];
    
    jQuery.each(headerSettings, function( index, value ) {
        
        wp.customize.control( value, function( control ) {
            var visibility = function() {
                if ( 'custom' === setting.get() ) {
                    control.container.addClass( 'arrival-control-hide' );
                } else {
                    control.container.removeClass( 'arrival-control-hide' );
                }
            };

            visibility();
            setting.bind( visibility );
        });

    });

    wp.customize.control( 'arrival_site_header_custom_template', function( control ) {
        var visibility = function() {
            if ( 'default' === setting.get() ) {
                control.container.addClass( 'arrival-control-hide' );
            } else {
                control.container.removeClass( 'arrival-control-hide' );
            }
        };

        visibility();
        setting.bind( visibility );
    });


});

/**
* Footer Type control script
* @since 1.1.1
*/
wp.customize( 'arrival_site_footer_type', function( setting ) {
     var footerSettings = ['arrival_footer_widget_enable','arrival_footer_copyright_text','arrival_footer_icons_enable','arrival_footer_social_redirect_btn'];
    jQuery.each(footerSettings, function( index, value ) {
        
        wp.customize.control( value, function( control ) {
            var visibility = function() {
                if ( 'custom' === setting.get() ) {
                    control.container.addClass( 'arrival-control-hide' );
                } else {
                    control.container.removeClass( 'arrival-control-hide' );
                }
            };

            visibility();
            setting.bind( visibility );
        });

    });

    wp.customize.control( 'arrival_site_footer_custom_template', function( control ) {
        var visibility = function() {
            if ( 'default' === setting.get() ) {
                control.container.addClass( 'arrival-control-hide' );
            } else {
                control.container.removeClass( 'arrival-control-hide' );
            }
        };

        visibility();
        setting.bind( visibility );
    });


});



})(jQuery);
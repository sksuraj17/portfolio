( function( $ ) {
	"use strict";

	$( document ).on( 'ready', function() {

		// Show/hide sidebars options
		var SidebarsField       = $( 'input[name="butterbean_page_options_setting_ultra_sidebar_layout"]' ),
			SidebarsFieldVal  	= $( 'input[name="butterbean_page_options_setting_ultra_sidebar_layout"]:checked' ).val(),
	        SidebarsSetting 	= $( '#butterbean-control-ultra_sidebar');

		SidebarsSetting.hide();

		if ( (SidebarsFieldVal == 'leftsidebar') || (SidebarsFieldVal == 'rightsidebar') ) {
			SidebarsSetting.show();
		}

		SidebarsField.change( function () {

			SidebarsSetting.hide();

			if ( ($( this ).val() == 'leftsidebar') || ($( this ).val() == 'rightsidebar') ) {
				SidebarsSetting.show();
			}

		} );

		// Show/hide header/footer template list
		var headerLayout       = $( 'input[name="butterbean_page_options_setting_ultra_page_header"]' ),
			headerVal  	= headerLayout.val(),
	        chooseHeader 	= $( '#butterbean-control-ultra_page_custom_header');

		chooseHeader.hide();

		if ( headerVal == 'custom' ) {
			chooseHeader.show();
		}

		headerLayout.change( function () {

			chooseHeader.hide();

			if ( $( this ).val() == 'custom' ) {
				chooseHeader.show();
			}

		} );

		// footer
		var footerLayout       = $( 'input[name="butterbean_page_options_setting_ultra_page_footer"]' ),
			footerVal  	= footerLayout.val(),
	        chooseFooter 	= $( '#butterbean-control-ultra_page_custom_footer');

		chooseFooter.hide();

		if ( footerVal == 'custom' ) {
			chooseFooter.show();
		}

		footerLayout.change( function () {

			chooseFooter.hide();

			if ( $( this ).val() == 'custom' ) {
				chooseFooter.show();
			}

		} );


	} );

} ) ( jQuery );
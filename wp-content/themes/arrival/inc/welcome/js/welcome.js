/**
 *
 * Welcome Page Scripts
 *
 */
jQuery(document).ready(function ($) {

	"use strict";

	/** Ajax Plugin Installation **/
	$(".install").on('click', function (e) {
		e.preventDefault();
		var el = $(this);

		var is_loading = true;
    	el.addClass('installing');
    	var plugin = $(el).attr('data-slug');
    	var plugin_file = $(el).attr('data-file');
    	var ajaxurl = operationWelcomeObject.ajaxurl;

		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'plugin_installer',
				plugin: plugin,
				plugin_file: plugin_file,
				nonce: operationWelcomeObject.admin_nonce,
			},
			success: function(response) {

		   		if(response == 'success'){

				   		el.attr('class', 'installed button');
				   		el.html(operationWelcomeObject.installed_btn);

		   		}

		   		el.removeClass('installing');
		   		is_loading = false;
		   		location.reload();
			},
			error: function(xhr, status, error) {
	  		console.log(status);
	  		el.removeClass('installing');
	  		is_loading = false;
			}
		});
	});

	/** Ajax Plugin Installation (Offlines) **/
	$('.install-offline').on('click', function (e) {
		e.preventDefault();
		var el = $(this);

		var is_loading = true;
    	el.addClass('installing');

		var file_location = el.attr('href');
		var file = el.attr('data-file');
		var host_type = (el.attr('data-host-type') === undefined) ? 'remote' : el.attr('data-host-type');
		var class_name = el.attr('data-class');
		var slug = el.attr('data-slug');
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'plugin_offline_installer',
				offline_install_plugin_nonce: operationWelcomeObject.offline_install_plugin_nonce,
				file_location: file_location,
				file: file,
				host_type: host_type,
				class_name: class_name,
				slug: slug,
				dataType: 'json'
			},
			success: function(response) {

		   		if(response == 'success'){
							
			   		el.attr('class', 'installed button');
			   		el.html(operationWelcomeObject.installed_btn);

		   		}

		   		is_loading = false;
		   		location.reload();
			},
			error: function(xhr, status, error) {
	  		el.removeClass('installing');
	  		is_loading = false;
			}
		});
	});

	/** Ajax Plugin Activation **/
	$(".plugin-action-btn .activate").on('click', function (e) {
		e.preventDefault();
		var el = $(this);
		el.addClass('installing');
		var el = $(this);
		var plugin = $(el).attr('data-slug');
		var plugin_file = $(el).attr('data-file');

    	var ajaxurl = operationWelcomeObject.ajaxurl;

		$.ajax({
	   		type: 'POST',
	   		url: ajaxurl,
	   		data: {
	   			action: 'plugin_activation',
	   			plugin: plugin,
	   			plugin_file: plugin_file,
	   			nonce: operationWelcomeObject.activate_nonce,
	   			dataType: 'json'
	   		},
	   		success: function(response) {
	   			el.removeClass('installing');
		   		if(response == 'success'){
			   		el.attr('class', 'installed button');
			   		el.html(operationWelcomeObject.installed_btn);
		   		}
		   		location.reload();
	   		},
	   	});
	});

	/** Ajax Plugin Deactivation **/
	$(".plugin-action-btn .deactivate").on('click', function (e) {
		e.preventDefault();
		var el = $(this);
		el.addClass('installing');
		var el = $(this);
		var plugin = $(el).attr('data-slug');
		var plugin_file = $(el).attr('data-file');

    	var ajaxurl = operationWelcomeObject.ajaxurl;

		$.ajax({
	   		type: 'POST',
	   		url: ajaxurl,
	   		data: {
	   			action: 'plugin_deactivation',
	   			plugin: plugin,
	   			plugin_file: plugin_file,
	   			nonce: operationWelcomeObject.deactivate_nonce,
	   			dataType: 'json'
	   		},
	   		success: function(response) {
	   			el.removeClass('installing');
		   		if(response == 'success'){
			   		el.attr('class', 'installed button');
			   		el.html(operationWelcomeObject.installed_btn);
		   		}
		   		location.reload();
	   		},
	   	});
	});

});
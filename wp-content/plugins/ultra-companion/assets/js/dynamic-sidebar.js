(function($) {
    'use strict';

    var Raw_Framework_Sidebar = function() {

        this.wrapper = $('.widget-liquid-right');
        this.main_area = $('#widgets-right');
        this.template = $('#uc-tmpl-widget');

        this.render_form();
        this.append_remove_button();
        this.bind_events();
    }

    Raw_Framework_Sidebar.prototype = {
        // our form and display it in the widgets screen
        render_form: function() {
            this.wrapper.append(this.template.html());
            this.name = this.wrapper.find('input[name="widgetname"]');
            this.nonce = this.wrapper.find('input[name="remove-sidebar"]').val();
        },

        // append a remove icon to the custom sidebars
        append_remove_button: function() {
            var area = this.main_area;
            var string = '<span class="ultra-remove-sidebar"><i class="dashicons dashicons-trash"></i></span>';
            area.find('.sidebar-ultra-companion').append(string);
        },

        // bind events to the remove icon so that custom sidebars can be removed
        bind_events: function() {
            this.wrapper.on('click', '.ultra-remove-sidebar', $.proxy(this.delete_sidebar, this));
        },

        //delete the sidebar area with all widgets
        delete_sidebar: function(e) {
            // ask for the confirmation
            var process = confirm(UltraWidgets.sidebarConfirm);

            if (process == false) {
                return false;
            }

            var sidebar = $(e.currentTarget).parents('.widgets-holder-wrap:eq(0)'),
                target = sidebar.find('.sidebar-name h3 , .sidebar-name h2'),
                spinner = target.find('.spinner'),
                widget_name = $.trim(target.text()),
                obj = this;

            // display the spinner
            spinner.addClass('is-active');

            // make the ajax request
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: 'delete_sidebar',
                    name: widget_name,
                    nonce: obj.nonce
                },
                success: function(response) {
                    if (response == 'sidebar-deleted') {
                        spinner.removeClass('is-active');
                        sidebar.slideUp(200, function() {
                            //delete all the contained widgets
                            $('.widget-control-remove', sidebar).trigger('click');
                            sidebar.remove();
                        });
                    }
                }
            });
        }
    };

    new Raw_Framework_Sidebar();

})(jQuery);
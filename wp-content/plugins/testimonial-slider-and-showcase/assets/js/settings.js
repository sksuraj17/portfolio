(function (global, $) {
    'use strict';

    jQuery.browser = {};
    (function () {
        jQuery.browser.msie = false;
        jQuery.browser.version = 0;
        if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
            jQuery.browser.msie = true;
            jQuery.browser.version = RegExp.$1;
        }
    })(); 

    $(function () {
        $("#add-new-port-img").on('click', function (evt) {
            evt.preventDefault();
            renderMediaUploader();
        });
        if ($('.rt-color').length) {
            $('.rt-color').wpColorPicker();
        } 
        checkSocialShare();

        //techlabpro23 
        $("#sc-tabs, #tss_meta_information").on('click', '.pro-field', function (e) {
            e.preventDefault();    
            $('.rtts-pro-alert').show();
        });  

        //pro alert close
        $('.rtts-pro-alert-close').on('click', function(e) {
            e.preventDefault();
            $('.rtts-pro-alert').hide();
        });  
        //end tachlabpro23
    });  

    /* Rating */
    $('.rt-rating').on('click', 'span', function () {
        var self = $(this),
            parent = self.parent(),
            star = parseInt(self.data('star'), 10);
        parent.find('.rating-value').val(star);
        parent.addClass('selected');
        parent.find('span').removeClass('active');
        self.addClass('active');

    });

    /* social media */
    $(".rt-sm-wrapper .rt-sm-sortable-list").sortable({
        connectWith: ".rt-sm-sortable-list",
        helper: "social-item helper",
        placeholder: 'social-item placeholder',
        opacity: 0.65,
        'update': function (e, ui) {
            var self = $(this),
                item = $(ui.item),
                name = self.parents('.rt-sm-wrapper').attr('id');
            if (self.hasClass('rt-sm-active')) { 
                if (item.find('input').length < 1) {
                    var id = item.data('id');
                    $("<input type='text' name='" + name + "[" + id + "]' value=''>").appendTo(item);
                    item.removeClass('available-item').addClass('active-item');
                }
            } else {
                item.find('input').remove();
                item.removeClass('active-item').addClass('available-item');
            }
        }
    }).disableSelection();

    /* rt tab active navigation */
    $(".rt-tab-nav li").on('click', 'a', function (e) {
        e.preventDefault();
        var container = $(this).parents('.rt-tab-container');
        var nav = container.children('.rt-tab-nav');
        var content = container.children(".rt-tab-content");
        var $this, $id;
        $this = $(this);
        $id = $this.attr('href');

        switch ( $id ) {
            case '#sc-layout':
                $('#_rtts_sc_tab').val('layout');
                break;

            case '#sc-filtering':
                $('#_rtts_sc_tab').val('filtering');
                break;

            case '#sc-field-selection':
                $('#_rtts_sc_tab').val('field-selection');
                break; 

            case '#sc-styling':
                $('#_rtts_sc_tab').val('styling');
                break;     
        }

        content.hide();
        nav.find('li').removeClass('active');
        $this.parent().addClass('active');
        container.find($id).show();
    });

    if ($("#sc-item-select").length) {
        $("#sc-item-select").select2({
            placeholder: "Select multiple item",
            allowClear: true
        });
    }
    if ($("select#sc-item-select").length) {
        $("select#sc-item-select").select2({
            placeholder: "Select multiple member",
            allowClear: true,
            width: '100%'
        });
    }
    if ($("select.rt-select2").length) {
        $("select.rt-select2").select2({width: '100px'});
    }
    if ($("select#img-size").length) {
        $("select#img-size").select2({width: '200px'});
    }
    if ($("select#relatedject").length) {
        $("select#relatedject").select2({
            placeholder: "Select related project",
            allowClear: true,
            width: '250px'
        });
    }
    layoutOptShowHide();
    $("#specific-items-action, #layout").on('change', function () {
        layoutOptShowHide();
    });

    SHTarget();
    $('#detail_popup input[name=detail_popup]').on('change', function () {
        SHTarget();
    });

    $("#tss-settings").on('click', '#tss-saveButton', function (event) {
        event.preventDefault();
        tssSyncCss();
        var self = $(this),
            arg = self.parents('form').serialize();
        AjaxCall('', 'tssSettingsAction', arg, function (data) { 
            if (!data.error) {
                $('.rt-response').removeClass('error');
                var holder = $("#license_key_holder");
                if (!$(".license-status", holder).length && $("#license_key", holder).val()) {
                    var bindElement = $("#license_key", holder),
                        target = $(".description", holder);
                    target.find(".rt-licence-msg").remove();
                    AjaxCall(bindElement, 'rt_tss_active_Licence', '', function (data) {
                        if (!data.error) {
                            target.append("<span class='license-status'>" + data.html + "</span>");
                        }
                        if (data.msg) {
                            if (target.find(".rt-licence-msg").length) {
                                target.find(".rt-licence-msg").html(data.msg);
                            } else {
                                target.append("<span class='rt-licence-msg'>" + data.msg + "</span>");
                            }
                            if (!data.error) {
                                target.find(".rt-licence-msg").addClass('success');
                            }
                        }
                    });
                }
                if (!$("#license_key", holder).val()) {
                    $('.license-status, .rt-licence-msg', holder).remove();
                }
                $('.rt-response').addClass('success');
            } else {
                $('.rt-response').addClass('error');
            }
            $('.rt-response').show('slow').text(data.msg);
        });
    });
    $(document).on('click', '#tss-settings .rt-licensing-btn', function (e) {
        e.preventDefault();
        var self = $(this),
            type = self.attr('name'),
            data = 'type=' + type;
        $("#license_key_holder").find(".rt-licence-msg").remove();
        AjaxCall(self, 'rtTssManageLicencing', data, function (data) {
            if (!data.error) {
                self.val(data.value);
                self.attr('name', data.name);
                self.addClass(data.class);
                if (data.name === 'license_deactivate') {
                    self.removeClass('button-primary');
                    self.addClass('danger');
                } else if (data.name === 'license_activate') {
                    self.removeClass('danger');
                    self.addClass('button-primary');
                }
            }
            if (data.msg) {
                $("<div class='rt-licence-msg'>" + data.msg + "</div>").insertAfter(self);
            }
            self.blur();
        });

        return false;
    });

    $("#tss_item_fields-social_share,#field-social_share").on('change', function () {
        checkSocialShare();
    });

    function AjaxCall(element, action, arg, handle) {
        'use strict';
        var data;
        if (action) data = "action=" + action;
        if (arg) data = arg + "&action=" + action;
        if (arg && !action) data = arg;
        var n = data.search(tss.nonceId);
        if (n < 0) {
            data = data + "&" + tss.nonceId + "=" + tss.nonce;
        }
        $.ajax({
            type: "post",
            url: ajaxurl,
            data: data,
            beforeSend: function () {
                $('body').append($("<div id='tss-loading'><span class='tss-loading'>Updating ...</span></div>"));
            },
            success: function (data) {
                $("#tss-loading").remove();
                handle(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#tss-loading").remove();
                // console.log(jqXHR);
                alert(textStatus + ' (' + errorThrown + ')');
            }
        });
    }

    function checkSocialShare() {
        if ($("#tss_item_fields-social_share").is(':checked')) {
            $(".field-holder.tss-social-share-fields").show();
        } else {
            $(".field-holder.tss-social-share-fields").hide();
        }

        if ($("#field-social_share").is(':checked')) {
            $(".field-holder.tss-social-share-fields-single").show();
        } else {
            $(".field-holder.tss-social-share-fields-single").hide();
        }
    }

    function layoutOptShowHide() {
        var id = $("#layout").val();
        if (id && id == "carousel") {
            $(".sc-meta-field-full.carousel").show();
        } else {
            $(".sc-meta-field-full.carousel").hide();
        }
    }

    function SHTarget() {
        var id = $('input[name=detail_popup]:checked', '#detail_popup').val();
        if (id == 'external_page') {
            $('.field-holder.target').show();
        } else {
            $('.field-holder.target').hide();
        }
    }

    function renderMediaUploader() {
        'use strict';
        var file_frame, image_data;
        if (undefined !== file_frame) {
            file_frame.open();
            return;
        }
        file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select or Upload Media For your profile gallery',
            button: {
                text: 'Use this media'
            },
            multiple: false
        });
        file_frame.on('select', function () {
            var attachment = file_frame.state().get('selection').first().toJSON();
            var imgId = attachment.id;
            var imgUrl = (typeof attachment.sizes.thumbnail === "undefined") ? attachment.url : attachment.sizes.thumbnail.url;
            $("ul#tlpp-gallery").append("<li><span class='dashicons dashicons-dismiss'></span><img src='" + imgUrl + "' /><input type='hidden' name='tlp_portfolio_gallery[]' value='" + imgId + "' /></li>");
            $("ul#tlpp-gallery li.no-img").hide();
        });
        // Now display the actual file_frame
        file_frame.open();
    }

    // Custom Css
    var editor,
        syncCSS = function () {
            tssSyncCss();
        },
        loadAce = function () {
            $('.rt-custom-css').each(function () {
                var id = $(this).find('.custom-css').attr('id');
                editor = ace.edit(id);
                global.safecss_editor = editor;
                editor.getSession().setUseWrapMode(true);
                editor.setShowPrintMargin(false);
                editor.getSession().setValue($(this).find('.custom_css_textarea').val());
                editor.getSession().setMode("ace/mode/css");
            });

            $.fn.spin && $('.custom_css_container').spin(false);
            $('#post').submit(syncCSS);
        };
    if ($.browser.msie && parseInt($.browser.version, 10) <= 7) {
        $('.custom_css_container').hide();
        $('.custom_css_textarea').show();
        return false;
    } else {
        $(global).load(loadAce);
    }
    global.aceSyncCSS = syncCSS;

    function tssSyncCss() {
        $('.rt-custom-css').each(function () {
            var e = ace.edit(jQuery(this).find('.custom-css').attr('id'));
            $(this).find('.custom_css_textarea').val(e.getSession().getValue());
        });
    }
})(this, jQuery);
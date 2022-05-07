jQuery(document).ready(function ($) {
    "use strict";

    function arrival_refresh_repeater_values() {
        $(".operation-repeater-field-control-wrap").each(function () {

            var values = [];
            var $this = $(this);

            $this.find(".operation-repeater-field-control").each(function () {
                var valueToPush = {};

                $(this).find('[data-name]').each(function () {
                    var dataName = $(this).attr('data-name');
                    var dataValue = $(this).val();
                    valueToPush[dataName] = dataValue;
                });

                values.push(valueToPush);
            });

            $this.next('.operation-repeater-collector').val(JSON.stringify(values)).trigger('change');
        });
    }
    /**
    * Script for Customizer icons
    */
    $(document).on('click', '.ap-customize-icons li', function () {
        $(this).parents('.ap-customize-icons').find('li').removeClass();
        $(this).addClass('selected');
        var iconVal = $(this).parents('.icons-list-wrapper').find('li.selected').children('i').attr('class');
        var inpiconVal = iconVal.split(' ');
        $(this).parents('.ap-customize-icons').find('.ap-icon-value').val(inpiconVal[1]);
        $(this).parents('.ap-customize-icons').find('.selected-icon-preview').html('<i class="' + iconVal + '"></i>');
        $('.ap-icon-value').trigger('change');
    });
    $(document).on('click', '.removeimage', function () {
        $(this).parent().html("");
        $("#arrival_bread_bg_image").val('');
    });
    $("body").on("click", '.operation-add-control-field', function () {

        var $this = $(this).parent();
        if (typeof $this != 'undefined') {

            var field = $this.find(".operation-repeater-field-control:first").clone();
            if (typeof field != 'undefined') {

                field.find("input[type='text'][data-name]").each(function () {
                    var defaultValue = $(this).attr('data-default');
                    $(this).val(defaultValue);
                });

                field.find("textarea[data-name]").each(function () {
                    var defaultValue = $(this).attr('data-default');
                    $(this).val(defaultValue);
                });

                field.find("select[data-name]").each(function () {
                    var defaultValue = $(this).attr('data-default');
                    $(this).val(defaultValue);
                });

                field.find(".radio-labels input[type='radio']").each(function () {
                    var defaultValue = $(this).closest('.radio-labels').next('input[data-name]').attr('data-default');
                    $(this).closest('.radio-labels').next('input[data-name]').val(defaultValue);

                    if ($(this).val() == defaultValue) {
                        $(this).prop('checked', true);
                    } else {
                        $(this).prop('checked', false);
                    }
                });

                field.find(".selector-labels label").each(function () {
                    var defaultValue = $(this).closest('.selector-labels').next('input[data-name]').attr('data-default');
                    var dataVal = $(this).attr('data-val');
                    $(this).closest('.selector-labels').next('input[data-name]').val(defaultValue);

                    if (defaultValue == dataVal) {
                        $(this).addClass('selector-selected');
                    } else {
                        $(this).removeClass('selector-selected');
                    }
                });

                field.find('.range-input').each(function () {
                    var $dis = $(this);
                    $dis.removeClass('ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all').empty();
                    var defaultValue = parseFloat($dis.attr('data-defaultvalue'));
                    $dis.siblings(".range-input-selector").val(defaultValue);
                    $dis.slider({
                        range: "min",
                        value: parseFloat($dis.attr('data-defaultvalue')),
                        min: parseFloat($dis.attr('data-min')),
                        max: parseFloat($dis.attr('data-max')),
                        step: parseFloat($dis.attr('data-step')),
                        slide: function slide(event, ui) {
                            $dis.siblings(".range-input-selector").val(ui.value);
                            arrival_refresh_repeater_values();
                        }
                    });
                });

                field.find('.onoffswitch').each(function () {
                    var defaultValue = $(this).next('input[data-name]').attr('data-default');
                    $(this).next('input[data-name]').val(defaultValue);
                    if (defaultValue == 'on') {
                        $(this).addClass('switch-on');
                    } else {
                        $(this).removeClass('switch-on');
                    }
                });

                field.find('.operation-color-picker').each(function () {
                    $(this).wpColorPicker({
                        change: function change(event, ui) {
                            setTimeout(function () {
                                arrival_refresh_repeater_values();
                            }, 100);
                        }
                    }).parents('.operation-type-colorpicker').find('.wp-color-result').first().remove();
                });

                field.find(".attachment-media-view").each(function () {
                    var defaultValue = $(this).find('input[data-name]').attr('data-default');
                    $(this).find('input[data-name]').val(defaultValue);
                    if (defaultValue) {
                        $(this).find(".thumbnail-image").html('<img src="' + defaultValue + '"/>').prev('.placeholder').addClass('hidden');
                    } else {
                        $(this).find(".thumbnail-image").html('').prev('.placeholder').removeClass('hidden');
                    }
                });

                field.find(".operation-icon-list").each(function () {
                    var defaultValue = $(this).next('input[data-name]').attr('data-default');
                    $(this).next('input[data-name]').val(defaultValue);
                    $(this).prev('.operation-selected-icon').children('i').attr('class', '').addClass(defaultValue);

                    $(this).find('li').each(function () {
                        var icon_class = $(this).find('i').attr('class');
                        if (defaultValue == icon_class) {
                            $(this).addClass('icon-active');
                        } else {
                            $(this).removeClass('icon-active');
                        }
                    });
                });

                field.find(".operation-multi-category-list").each(function () {
                    var defaultValue = $(this).next('input[data-name]').attr('data-default');
                    $(this).next('input[data-name]').val(defaultValue);

                    $(this).find('input[type="checkbox"]').each(function () {
                        if ($(this).val() == defaultValue) {
                            $(this).prop('checked', true);
                        } else {
                            $(this).prop('checked', false);
                        }
                    });
                });

                field.find('.operation-fields').show();

                $this.find('.operation-repeater-field-control-wrap').append(field);

                field.addClass('expanded').find('.operation-repeater-fields').show();
                $('.accordion-section-content').animate({ scrollTop: $this.height() }, 1000);
                arrival_refresh_repeater_values();
            }
        }
        return false;
    });
    $('body').on('click', '.operation-icon-list li', function () {
        var icon_class  = $(this).attr('data-value');
        var iconSVG     = $(this).html(); 
        $(this).addClass('icon-active').siblings().removeClass('icon-active');
        $(this).parent('.operation-icon-list').prev('.operation-selected-icon').children('.icon-preview').html(iconSVG);
        $(this).parent('.operation-icon-list').next('input').val(icon_class).trigger('change');
        arrival_refresh_repeater_values();
    });
    //MultiCheck box Control JS
    $('body').on('change', '.operation-type-multicategory input[type="checkbox"]', function () {
        var checkbox_values = $(this).parents('.operation-type-multicategory').find('input[type="checkbox"]:checked').map(function () {
            return $(this).val();
        }).get().join(',');
        $(this).parents('.operation-type-multicategory').find('input[type="hidden"]').val(checkbox_values).trigger('change');
        arrival_refresh_repeater_values();
    });

    $('body').on('click', '.operation-selected-icon', function () {
        $(this).next().slideToggle();
    });
    $("#customize-theme-controls").on("click", ".operation-repeater-field-remove", function () {
        if (typeof $(this).parent() != 'undefined') {
            $(this).closest('.operation-repeater-field-control').slideUp('normal', function () {
                $(this).remove();
                arrival_refresh_repeater_values();
            });
        }
        return false;
    });
    $('#customize-theme-controls').on('click', '.operation-repeater-field-close', function () {
        $(this).closest('.operation-repeater-fields').slideUp();;
        $(this).closest('.operation-repeater-field-control').toggleClass('expanded');
    });
    $('#customize-theme-controls').on('click', '.operation-repeater-field-title', function () {
        $(this).next().slideToggle();
        $(this).closest('.operation-repeater-field-control').toggleClass('expanded');
    });
    /*Drag and drop to change order*/

    $(".operation-repeater-field-control-wrap").sortable({
        orientation: "vertical",
        update: function update(event, ui) {
            arrival_refresh_repeater_values();
        }
    });

    $("#customize-theme-controls").on('keyup change', '[data-name]', function () {
        arrival_refresh_repeater_values();
        return false;
    });

    $("#customize-theme-controls").on('change', 'input[type="checkbox"][data-name]', function () {
        if ($(this).is(":checked")) {
            $(this).val('yes');
        } else {
            $(this).val('no');
        }
        arrival_refresh_repeater_values();
        return false;
    });
    // ADD IMAGE LINK
    $('.customize-control-repeater').on('click', '.operation-upload-button', function (event) {
        event.preventDefault();

        var imgContainer = $(this).closest('.operation-fields-wrap').find('.thumbnail-image'),
            placeholder = $(this).closest('.operation-fields-wrap').find('.placeholder'),
            imgIdInput = $(this).siblings('.upload-id');

        // Create a new media frame
        frame = wp.media({
            title: 'Select or Upload Image',
            button: {
                text: 'Use Image'
            },
            multiple: false // Set to true to allow multiple files to be selected
        });

        // When an image is selected in the media frame...
        frame.on('select', function () {

            // Get media attachment details from the frame state
            var attachment = frame.state().get('selection').first().toJSON();

            // Send the attachment URL to our custom image input field.
            imgContainer.html('<img src="' + attachment.url + '" style="max-width:100%;"/>');
            placeholder.addClass('hidden');

            // Send the attachment id to our hidden input
            imgIdInput.val(attachment.url).trigger('change');
        });

        // Finally, open the modal on click
        frame.open();
    });
    // DELETE IMAGE LINK
    $('.customize-control-repeater').on('click', '.operation-delete-button', function (event) {

        event.preventDefault();
        var imgContainer = $(this).closest('.operation-fields-wrap').find('.thumbnail-image'),
            placeholder = $(this).closest('.operation-fields-wrap').find('.placeholder'),
            imgIdInput = $(this).siblings('.upload-id');

        // Clear out the preview image
        imgContainer.find('img').remove();
        placeholder.removeClass('hidden');

        // Delete the image id from the hidden input
        imgIdInput.val('').trigger('change');
    });
});

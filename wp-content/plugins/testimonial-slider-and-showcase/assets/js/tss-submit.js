(function ($) {

    if ($.fn.validate) {
        $('#tss-submit-form').validate({
            submitHandler: function (form) {
                var f = $(form),
                    formData = new FormData(),
                    feature_image = $('#tss_feature_image'),
                    oldData = f.serializeArray(),
                    btn = f.find('.tss-submit-button'),
                    response = $("#tss-submit-response"),
                    recaptcha = $("#tss_recaptcha");
                if (tss.recaptcha.enable && !recaptcha.find('.g-recaptcha-response').val()) {
                    response.addClass('error');
                    recaptcha.focus();
                    response.html("<p>" + tss.error.tss_recaptcha + "</p>");
                    return false;
                }


                oldData.forEach(function (item) {
                    formData.append(item.name, item.value);
                });
                if (feature_image.length) {
                    formData.append('feature_image', feature_image[0].files[0]);
                }
                formData.append('action', 'tss_submit_action');
                formData.append(tss.nonceId, tss.nonce);
                // Post via AJAX
                $.ajax({
                    url: tss.ajaxurl,
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        f.addClass('rtcessing');
                        response.html('');
                        response.removeClass('error');
                        $("<span class='rtcessing rt-animate-spin dashicons dashicons-image-rotate'></span>").insertAfter(btn);
                    },
                    success: function (data) {
                        btn.next('span.rtcessing').remove();
                        f.removeClass('rtcessing');
                        response.html($("<p />").append(data.msg));
                        if (!data.error) {
                            response.addClass('success').removeClass('error');
                            var extraTop = ($('body').hasClass('admin-bar') ? 32 : 0);
                            f[0].reset();
                            // f.slideUp(200, function () {
                            //     $(this).remove();
                            //     $('html, body').animate({
                            //         scrollTop: response.offset().top - 70 - extraTop
                            //     }, 200);
                            // });
                        }else{
                            response.addClass('error').removeClass('success');
                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        btn.next('span.rtcessing').remove();
                        f.removeClass('rtcessing');
                        console.log(textStatus + ' (' + errorThrown + ')');
                    }
                });
            }
        });
    }

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

})(jQuery);
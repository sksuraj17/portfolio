jQuery(document).ready(function($) {
    'use strict';


    /**
     * Reset video embed value
     */
    $('#reset-video-embed').click(function() {
        $('input[name="post_embed_video_url"]').val('');
    });

    /**
     * Reset audio embed value
     */
    $('#reset-audio-embed').click(function() {
        $('input[name="post_embed_audio_url"]').val('');
    });

    /**
     * Add audio file
     */
    $('#post_audio_upload_button').on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        var audio = wp.media.frames.file_frame = wp.media({
                title: 'Upload Audio File',
                button: {
                    text: 'Use this file',
                },
                // multiple: true if you want to upload multiple files at once
                multiple: false,
                library: {
                    type: 'audio'
                }
            }).open()
            .on('select', function(e) {
                // This will return the selected audio from the Media Uploader, the result is an object
                var uploaded_audio = audio.state().get('selection').first();
                // We convert uploaded_audio to a JSON object to make accessing it easier
                // Output to the console uploaded_audio
                var audio_url = uploaded_audio.toJSON().url;
                // Let's assign the url value to the input field
                $this.prev('input').val(audio_url);
            });
        //$('#audiourl_remove').show();
    });

    $('#audiourl_remove').click(function() {
        $('input[name="post_embed_audiourl"]').val('');
    });

    /**
     * Add gallery images
     */
    $(document).on('click', '#post_gallery_upload_button', function(e) {
        var img_count = $('#post_image_count').val();
        var dis = $(this);
        var send_attachment_bkp = wp.media.editor.send.attachment;
        var _custom_media = true;
        wp.media.editor.send.attachment = function(props, attachment) {
            if (_custom_media) {
                var img = attachment.sizes.thumbnail.url;
                $('.post-gallery-section').append('<div class="gal-img-block"><div class="gal-img"><img src="' + img + '" height="150px" width="150px"/><span class="fig-remove" title="remove"></span></div><input type="hidden" name="post_images[' + img_count + ']" class="hidden-media-gallery" value="' + attachment.url + '" /></div>');
                img_count++;
                $('#post_image_count').val(img_count);
            } else {
                return _orig_send_attachment.apply(this, [props, attachment]);
            };
        }

        wp.media.editor.open($(this));
        return false;
    });
    $(document).on('click', '.fig-remove', function(e) {
        $(this).closest('.gal-img-block').remove();
    });


    // Page Metabox section
    var curTab = $('.ultra-page-meta-tabs li.active').attr('atr');
    $('.pg-metabox').find('#' + curTab).show();

    $('ul.ultra-page-meta-tabs li').click(function() {
        var id = $(this).attr('atr');

        $('ul.ultra-page-meta-tabs li').removeClass('active');
        $(this).addClass('active')

        $('.pg-metabox .pg-metabox-inside').hide();
        $('#' + id).fadeIn();
        $('#post-meta-selected').val(id);
    });

    /**
     * Script for image selected from radio option
     */
    $('#ultra-img-container-meta li img').click(function() {
        $('#ultra-img-container-meta li').each(function() {
            $(this).find('img').removeClass('ultra-radio-img-selected');
        });
        $(this).addClass('ultra-radio-img-selected');
    });

    /* Ignore Message */
    $('.wpop_no_thanks').on('click',function(e){
        e.preventDefault();
        var id = $(this).attr('data-user');
        $.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                action: 'wpop_nag_ignore',
                userid: id
            },
            success: function(response) {
                if(response == 'yes'){
                    $('.wpop_admin_notice').hide();
                }
            }
        });
    });

});
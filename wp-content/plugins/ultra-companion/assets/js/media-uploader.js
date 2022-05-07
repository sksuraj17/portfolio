jQuery(document).ready(function($){

var ultra_seven_upload;
var ultra_seven_selector;

function ultra_seven_add_file(event, selector) {

    var upload = $(".uploaded-file"), frame;
    var $el = $(this);
    ultra_seven_selector = selector;

    event.preventDefault();

    // If the media frame already exists, reopen it.
    if ( ultra_seven_upload ) {
        ultra_seven_upload.open();
    } else {
        // Create the media frame.
        ultra_seven_upload = wp.media.frames.ultra_seven_upload =  wp.media({
            // Set the title of the modal.
            title: $el.data('choose'),

            // Customize the submit button.
            button: {
               // Set the text of the button.
               text: $el.data('update'),
               // Tell the button not to close the modal, since we're
               // going to refresh the page when the image is selected.
               close: false
            }
        });

        // When an image is selected, run a callback.
        ultra_seven_upload.on( 'select', function() {
            // Grab the selected attachment.
            var attachment = ultra_seven_upload.state().get('selection').first();
            ultra_seven_upload.close();
            ultra_seven_selector.find('.upload').val(attachment.attributes.url);
            
            if ( attachment.attributes.type == 'image' ) {
               ultra_seven_selector.find('.screenshot').empty().hide().append('<img src="' + attachment.attributes.url + '" style="width:100%;">').slideDown('fast');
            }
            
            ultra_seven_selector.find('.ap-upload-button').unbind().addClass('remove-file').removeClass('ap-upload-button').val(ultra_seven_l10n.remove);
            ultra_seven_selector.find('.of-background-properties').slideDown();
            ultra_seven_selector.find('.remove-image, .remove-file').on('click', function() {
               ultra_seven_remove_file( $(this).parents('.section') );
            });
        });
    }

// Finally, open the modal.
    ultra_seven_upload.open();
}

function ultra_seven_remove_file(selector) {
    selector.find('.remove-image').hide();
    selector.find('.upload').val('');
    selector.find('.of-background-properties').hide();
    selector.find('.screenshot').slideUp();
    selector.find('.remove-file').unbind().addClass('ap-upload-button').removeClass('remove-file').val(ultra_seven_l10n.upload);
    
    // We don't display the upload button if .upload-notice is present
    // This means the user doesn't have the WordPress 3.5 Media Library Support
    if ( $('.section-upload .upload-notice').length > 0 ) {
        $('.ap-upload-button').remove();
    }
    
    selector.find('.ap-upload-button').on('click', function(event) {
        ultra_seven_add_file(event, $(this).parents('.sub-option'));
    });
}

$('body').on('click', '.remove-image, .remove-file', function() {
    ultra_seven_remove_file( $(this).parents('.sub-option') );
});

$('body').on('click', '.ap-upload-button', function( event ) {
    ultra_seven_add_file(event, $(this).parents('.sub-option'));
});

});
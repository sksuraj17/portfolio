(function ($) {

    $(function () {
        if($("select.rt-select2").length){
            $("select.rt-select2").select2({width: '100px'});
        }

        $('#tss-taxonomy').on('change', function () {
            var self = $(this),
                tax = self.val(),
                target = $('#term-wrapper');
            if(tax){
                var data ="tax="+ tax;
                AjaxCall('tss-get-term-list', data, function (data) {
                    if(!data.error) {
                        target.html(data.data);
                        var fixHelper = function (e, ui) {
                            ui.children().children().each(function () {
                                $(this).width($(this).width());
                            });
                            return ui;
                        };
                        $('#order-target').sortable({
                            items: 'li',
                            axis: 'y',
                            helper: fixHelper,
                            placeholder: 'placeholder',
                            opacity: 0.65,
                            update: function (e, ui) {
                                var target = $('#order-target');
                                var taxonomy = target.data('taxonomy'),
                                    terms = target.find('li').map(function () {
                                        return $(this).data('id');
                                    }).get(),
                                    data = "taxonomy="+taxonomy+"&terms="+terms;
                                AjaxCall('tss-update-temp-order', data, function (data) {
                                    if(data.error){
                                        alert('Error !!!');
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });

    });

    function AjaxCall(action, arg, handle) {
        var data;
        if (action) data = "action=" + action;
        if (arg) data = arg + "&action=" + action;
        if (arg && !action) data = arg;
        data = data + "&"+tss.nonceId+"=" + tss.nonce;
        $.ajax({
            type: "post",
            url: ajaxurl,
            data: data,
            beforeSend: function() {
                $('body').append($("<div id='tss-loading'><span class='tss-loading'>Updating ...</span></div>"));
            },
            success: function(data) {
                $("#tss-loading").remove();
                console.log(data);
                handle(data);
            },
            error: function( jqXHR, textStatus, errorThrown ) {
                $("#tss-loading").remove();
                alert( textStatus + ' (' + errorThrown + ')' );
            }
        });
    }
})(jQuery);

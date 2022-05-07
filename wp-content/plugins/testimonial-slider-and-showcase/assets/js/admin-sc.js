(function($){


    $("#tss_image_size").on('change', function () {
        customImageSize();
    });

    $("#tss_pagination").on('change', function () {
        if (this.checked) {
            $(".rt-field-wrapper.tss-pagination-item").show();
        } else {
            $(".rt-field-wrapper.tss-pagination-item").hide();
        }
    });

    $("#tss_carousel_options-autoplay").on('change', function () {
        if (this.checked) {
            $("#tss_carousel_autoplay_timeout_holder").show();
        } else {
            $("#tss_carousel_autoplay_timeout_holder").hide();
        }
    });

    $("#tss_pagination_type").on("click", "input[type='radio']", function () {
        var paginationType = $("#tss_pagination_type").find("input[name=tss_pagination_type]:checked").val();
        if (paginationType == "load_more") {
            $(".rt-field-wrapper.tss-load-more-item").show();
        } else {
            $(".rt-field-wrapper.tss-load-more-item").hide();
        }

    });
    showHideScMeta();

    function layout_style() {
        $("input[name=tss_layout]").on('change', function () {
            showHideScMeta();
        });
    }
    layout_style();

    //dynamic layout list
    dynamicLayoutList();
    $('input[name=layout_type]').on('change', function() {
        dynamicLayoutList();
    });

    function dynamicLayoutList() {
        let layout_type = $('input[name=layout_type]:checked').val(),
        layout = $("#rtts-tss_layout");

        if( layout_type ) {
            let layout_option = '';
            for (const [key, value] of Object.entries(tss_layout.layout_group[layout_type])) {
                let checked = ( tss_layout.layout == value.value) ? 'checked': '';
                layout_option += `<label for="rtts-style-${value.value}">
                <input type="radio" id="rtts-style-${value.value}" name="tss_layout" ${checked} value="${value.value}" data-pro="">
                <div class="rtts-radio-image-pro-wrap">
                <img src="${value.img}" title="${value.name}" alt="${value.value}">
                <div class="rtts-checked"><span class="dashicons dashicons-yes"></span></div>
                </div><div class="rtts-demo-url"><a href="${value.demo}" target="_blank">${value.name}</a></div>
                </label>`;
            }

            layout.empty();
            layout.append(layout_option);
            layout_style();
            showHideScMeta();
        }
    }

    function showHideScMeta() {
        var layout = $("input[name=tss_layout]:checked").val();
        var isIsotope = false,
            isCarousel = false;
        if (layout) {
            isCarousel = layout.match(/^carousel/i);
            isIsotope = layout.match(/^isotope/i);
            $("#tss_pagination_type").find("label[for='tss_pagination_type-pagination'],label[for='tss_pagination_type-pagination_ajax']").show();
            $("#tss_carousel_autoplay_timeout_holder").hide();
            if (isCarousel) {
                $(".rt-field-wrapper.tss-carousel-item").show();
                $(".rt-field-wrapper.tss-isotope-item,.rt-field-wrapper.pagination, #tss_column_holder").hide();

                var autoPlay = $("#tss_carousel_options-autoplay").prop("checked");
                if (autoPlay) {
                    $("#tss_carousel_autoplay_timeout_holder").show();
                }

            } else if (isIsotope) {
                $(".rt-field-wrapper.tss-isotope-item,.rt-field-wrapper.pagination,#tss_column_holder").show();
                $(".rt-field-wrapper.tss-carousel-item").hide();
                $("#tss_pagination_type").find("label[for='tss_pagination_type-pagination'],label[for='tss_pagination_type-pagination_ajax']").hide();
                var paginationType = $("#tss_pagination_type").find("input[name=tss_pagination_type]:checked").val();
                if (paginationType == "pagination" || paginationType == "pagination_ajax") {
                    $("#tss_pagination_type").find("label[for='tss_pagination_type-load_more'] input").prop("checked", true);
                } else if (paginationType == "load_more") {
                    $(".rt-field-wrapper.tss-load-more-item").show();
                }
            }else {
                $(".rt-field-wrapper.tss-isotope-item,.rt-field-wrapper.tss-carousel-item").hide();
                $(".rt-field-wrapper.pagination, #tss_column_holder").show();
            }
        }

        $(".rt-field-wrapper.tss-load-more-item").hide();
        var pagination = $("#tss_pagination").is(':checked');
        if (pagination && !isCarousel) {
            $(".rt-field-wrapper.tss-pagination-item").show();
        } else {
            $(".rt-field-wrapper.tss-pagination-item").hide();
        }
        customImageSize();
    }

    function customImageSize() {
        /* custom image size jquery */
        var fImageSize = $("#tss_image_size").val();
        if (fImageSize == "tss_custom") {
            $("#tss_custom_image_size_holder").show();
        } else {
            $("#tss_custom_image_size_holder").hide();
        }
    }
})(jQuery);

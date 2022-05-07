jQuery(document).ready(function ($) {

    $('.sp-testimonial-free-section').each(function (index) {
        var _this = $(this),
            custom_id = $(this).attr('id'),
            preloader = _this.data('preloader');

        if ('1' == preloader) {
            var parents_class = $('#' + custom_id).parent('.sp-testimonial-free-wrapper'),
                parents_siblings_id = parents_class.find('.sp-testimonial-preloader').attr('id');
            jQuery(window).on('load', function () {
                $('#' + parents_siblings_id).animate({ opacity: 1 }, 600).hide();
                $('#' + custom_id).animate({ opacity: 1 }, 600)
            })
        }

        var tfree_custom_slider_id = $(this).attr('id');
        var tpCarouselData = $(this).data('slick');

        if (tfree_custom_slider_id.length != 0 && !$('#' + tfree_custom_slider_id).hasClass('slick-initialized')) {
            // my slick slider as constant object
            var mySlider = $('#' + tfree_custom_slider_id).on('init', function (slick) {
                if (tpCarouselData.adaptiveHeight == true) {
                    // on init run our multi slide adaptive height function
                    multiSlideAdaptiveHeight(this);
                }
            }).on('beforeChange', function (slick, currentSlide, nextSlide) {

                if (tpCarouselData.adaptiveHeight == true) {
                    // on init run our multi slide adaptive height function
                    multiSlideAdaptiveHeight(this);
                }
            }).slick({
                pauseOnFocus: false,
                slidesToScroll: 1,
                accessibility: true,
                prevArrow: "<button class='slick-prev' data-role='none' aria-label='Previous slide'><i class='fa fa-angle-left'></i></button>",
                nextArrow: "<button class='slick-next' data-role='none' aria-label='Next slide'><i class='fa fa-angle-right'></i></button>",
            });

            // our multi slide adaptive height function passing slider object
            function multiSlideAdaptiveHeight(slider) {

                // set our vars
                let activeSlides = [];
                let tallestSlide = 0;

                // very short delay in order for us get the correct active slides
                setTimeout(function () {

                    // loop through each active slide for our current slider
                    $('.slick-track .slick-active', slider).each(function (i) {

                        // add current active slide height to our active slides array
                        activeSlides[i] = $(this).outerHeight();

                    });

                    // for each of the active slides heights
                    activeSlides.forEach(function (item) {

                        // if current active slide height is greater than tallest slide height
                        if (item > tallestSlide) {

                            // override tallest slide height to current active slide height
                            tallestSlide = item;

                        }
                    });

                    // set the current slider slick list height to current active tallest slide height
                    $('.slick-list', slider).height(tallestSlide).css({
                        transition: 'all .5s ease',
                    });
                }, 10);
            }

            // when window is resized
            $(window).on('resize', function () {
                // run our multi slide adaptive height function incase current slider active slides change height responsively
                if (tpCarouselData.adaptiveHeight == true) {
                    // on init run our multi slide adaptive height function
                    multiSlideAdaptiveHeight(mySlider);
                }
            });
        }
        $('.sp_tpro-preview-box button.slick-next,.sp_tpro-preview-box button.slick-prev').click(function (e) {
            e.preventDefault();
        })
    });
});
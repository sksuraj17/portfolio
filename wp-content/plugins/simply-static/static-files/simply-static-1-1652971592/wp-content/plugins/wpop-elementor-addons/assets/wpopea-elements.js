/** 
 * Opstore Custom Scripts
 */

(function($) {
    'use strict';

    var opstore_products = function($scope, $) {
        var $slider_elem = $scope.find('.wpopea-opstore-products').eq(0),
            $slider_main = $slider_elem.find('.products.product-slide'),
            $slideNo = $slider_elem.data('slide-no'),
            $tslideNo = $slider_elem.data('tslide-no'),
            $mslideNo = $slider_elem.data('mslide-no'),
            $slideItem = $slider_elem.data('slide-item'),
            $tslideItem = $slider_elem.data('tslide-item'),
            $mslideItem = $slider_elem.data('mslide-item'),
            $autoPlay = $slider_elem.data('auto-slide'),
            $pager = $slider_elem.data('show-pager'),
            $arrow = $slider_elem.data('show-arrow'),
            $infiniteSlide = $slider_elem.data('infinite-slide');
        if ($slider_main.length > 0) {
            $slider_main.slick({
                dots: $pager,
                infinite: $infiniteSlide,
                autoplay: $autoPlay,
                arrows: $arrow,
                slidesToShow: $slideNo,
                slidesToScroll: $slideItem,
                responsive: [{
                        breakpoint: 992,
                        settings: {
                            slidesToShow: $tslideNo,
                            slidesToScroll: $tslideItem
                        }
                    }, {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: $mslideNo,
                            slidesToScroll: $mslideItem
                        }
                    }

                ]
            });
        }
    };

    var opstore_isotopes = function($scope, $) {
        if(!isEditMode){
            var tab_element = $scope.find('.product-tab').eq(0);
            if (tab_element.length > 0) {
                var $grid = tab_element.imagesLoaded(function() {
                    // init Isotope after all images have loaded
                    $grid.isotope({
                        itemSelector: '.type-product',
                        layoutMode: 'fitRows'
                    });
                });
                var filter_tab = $scope.find('.product-tab-filter').eq(0);
                filter_tab.on('click', '.filter', function() {
                    $('.product-tab-filter .filter').removeClass('active');
                    $(this).addClass('active');
                    var filterValue = $(this).attr('data-filter');
                    $('.product-tab').isotope({
                        filter: filterValue
                    });
                });
            }
        }
    };


    var opstore_sale_count = function($scope, $) {
        var $SaleWrap = $scope.find('.opstore-sale-slide').eq(0),
            $saleTimer = $SaleWrap.find('.type-product');

        $saleTimer.each(function(){
            var timerSale = $(this).find('.salecount-timer');
            var salesEnd = timerSale.data('date');
            // we need to confirm for the date
            if (salesEnd) {
                var saleCounter = new Countdown(timerSale[0], {
                    date: salesEnd,
                    render: function(data) {
                        $(this.el).html(
                            '<div><span class="no rounded-crcl">' + this.leadingZeros(data.days, 2) + '</span> DAYS</div>' +
                            '<div><span class="no rounded-crcl">' + this.leadingZeros(data.hours, 2) + '</span> HOURS</div>' +
                            '<div><span class="no rounded-crcl">' + this.leadingZeros(data.min, 2) + '</span> MINS</div>' +
                            '<div><span class="no rounded-crcl">' + this.leadingZeros(data.sec, 2) + '</span> SEC</div>'
                        );
                    }
                });
            }
        }); 
    };

    var Wpopea_Advanced_Menu = function($scope, $) {

        new PPAdvancedMenu($scope);

    };

    var Wpopea_cat_dropdown = function($scope, $){
        var cat_drop = $scope.find('.wpopea-category-dropdown').eq(0);
        cat_drop.find('ul.sub-cat').parent('li').addClass('has-child');
        $('<div class="sub-cat-toggle"></div>').insertBefore('li ul.sub-cat');
        $('body').on('vclick touchstart click','.sub-cat-toggle', function()  {
          $(this).next('ul.sub-cat').slideToggle();
        });
        cat_drop.find('.toggle-wrap').on('click',function(){
            $(this).next('ul.main-cat').slideToggle();
        });
    }

    var Wpopea_News_Ticker = function($scope, $){
        var ticker_elem = $scope.find('.ticker-wrap').eq(0),
            $slider_handler = $scope.find('.wpopea-ticker').eq(0),
            $slideNo = $slider_handler.data('slide-no'),
            $tslideNo = $slider_handler.data('tslide-no'),
            $mslideNo = $slider_handler.data('mslide-no'),
            $slideItem = $slider_handler.data('slide-item'),
            $tslideItem = $slider_handler.data('tslide-item'),
            $mslideItem = $slider_handler.data('mslide-item'),
            $autoPlay = $slider_handler.data('auto-slide'),
            $arrow = $slider_handler.data('show-arrow'),
            $slider_type = $slider_handler.data('slide-type'),
            $infiniteSlide = $slider_handler.data('infinite-slide'),
            $rtl = $slider_handler.data('rtl'),
            $scroll = $slider_handler.data('scroll'),
            $slideSpeed = $slider_handler.data('speed');
        if($slider_type == 'fade'){
            var ff = true;
        }else{
            var ff = false;
        }  
        ticker_elem.slick({
            dots: false,
            fade: ff,
            autoplay: $autoPlay,
            autoplaySpeed: $slideSpeed,
            arrows: $arrow,
            slidesToShow: $slideNo,
            slidesToScroll: $slideItem,
            infinite: $infiniteSlide,
            swipe: false,
            touchMove: false,
            vertical: $scroll,
            rtl: $rtl,
            responsive: [{
                    breakpoint: 992,
                    settings: {
                        slidesToShow: $tslideNo,
                        slidesToScroll: $tslideItem
                    }
                }, {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: $mslideNo,
                        slidesToScroll: $mslideItem
                    }
                }

            ]

        });
    };

    var isEditMode = false;
    $(window).on('elementor/frontend/init', function() {
        if (elementorFrontend.isEditMode()) {
            isEditMode = true;

            $('.opstore-loader').fadeOut('slow');
            $('.ultra-seven-loader').fadeOut('slow');

        }
        elementorFrontend.hooks.addAction('frontend/element_ready/wpopea-advanced-menu.default', Wpopea_Advanced_Menu);
        elementorFrontend.hooks.addAction('frontend/element_ready/opstore-products.default', opstore_products);
        elementorFrontend.hooks.addAction('frontend/element_ready/opstore-products.default', opstore_isotopes);
        elementorFrontend.hooks.addAction('frontend/element_ready/opstore-products-sale.default', opstore_sale_count);
        elementorFrontend.hooks.addAction('frontend/element_ready/wpopea-category-dropdown.default', Wpopea_cat_dropdown);
        elementorFrontend.hooks.addAction('frontend/element_ready/wpopea-ticker.default', Wpopea_News_Ticker);

    });

    /* For Ads Banner close */
    $('.ad-close').on('click',function(){
        $('.ad-section').slideUp();
    });


})(jQuery);
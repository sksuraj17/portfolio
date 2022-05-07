(function ($) {
    'use strict';

    $(function(){
        renderTssPreview();
        $("#rt_tss_sc_settings_meta").on('change', 'select,input', function () {
            renderTssPreview();
        });
        $("#rt_tss_sc_settings_meta").on("input propertychange", function () {
            renderTssPreview();
        });
        if ($("#sc-style .rt-color").length) {
            var cOptions = {
                defaultColor: false,
                change: function (event, ui) {
                    renderTssPreview();
                },
                clear: function () {
                    renderTssPreview();
                },
                hide: true,
                palettes: true
            };
            $("#sc-style .rt-color").wpColorPicker(cOptions);
        }


        $(document).on('mouseover', '.tss-isotope-button-wrapper button',
            function () {
                var self = $(this),
                    count = self.attr('data-filter-counter'),
                    id = self.parents('.tss-wrapper').attr('id');
                console.log(count);
                $tooltip = '<div class="tss-tooltip" id="tss-tooltip-' + id + '">' +
                    '<div class="tss-tooltip-content">' + count + '</div>' +
                    '<div class="tss-tooltip-bottom"></div>' +
                    '</div>';
                $('body').append($tooltip);
                var $tooltip = $('body > .tss-tooltip');
                var tHeight = $tooltip.outerHeight();
                var tBottomHeight = $tooltip.find('.tss-tooltip-bottom').outerHeight();
                var tWidth = $tooltip.outerWidth();
                var tHolderWidth = self.outerWidth();
                var top = self.offset().top - (tHeight + tBottomHeight);
                var left = self.offset().left;
                $tooltip.css({
                    'top': top + 'px',
                    'left': left + 'px',
                    'opacity': 1
                }).show();
                if (tWidth <= tHolderWidth) {
                    var itemLeft = (tHolderWidth - tWidth) / 2;
                    left = left + itemLeft;
                    $tooltip.css('left', left + 'px');
                } else {
                    var itemLeft = (tWidth - tHolderWidth) / 2;
                    left = left - itemLeft;
                    if (left < 0) {
                        left = 0;
                    }
                    $tooltip.css('left', left + 'px');
                }
            })
            .on('mouseout', '.tss-isotope-buttons button', function () {
                $('body > .tss-tooltip').remove();
            });
    });

    $(document).on("click", "span.rtAddImage", function (e) {
        var file_frame, image_data;
        var $this = $(this).parents('.rt-image-holder');
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
            $this.find('.hidden-image-id').val(imgId);
            $this.find('.rtRemoveImage').show();
            $this.find('img').remove();
            $this.find('.rt-image-preview').append("<img src='" + imgUrl + "' />");
            renderTssPreview();
        });
        // Now display the actual file_frame
        file_frame.open();
    });

    $(document).on("click", "span.rtRemoveImage", function (e) {
        e.preventDefault();
        if (confirm("Are you sure?")) {
            var $this = $(this).parents('.rt-image-holder');
            $this.find('.hidden-image-id').val('');
            $this.find('.rtRemoveImage').hide();
            $this.find('img').remove();
            renderTssPreview();
        }
    });


    function renderTssPreview() {
        if ($("#rt_tss_sc_settings_meta").length) {
            var data = $("#rt_tss_sc_settings_meta").find('input[name],select[name],textarea[name]').serialize();
            tssPreviewAjaxCall(null, 'tssPreviewAjaxCall', data, function (data) {
                if (!data.error) {
                    $("#tss-preview-container").html(data.data);
                    renderLayout();
                }
            });
        }
    }

    function renderLayout() {
        var elementInstances = [],
            elementThumbInstances = [],
            index = 0;


        var container = $('.tss-wrapper');
        if(container.length) {
            var str = container.attr("data-layout");
            // console.log(str);
            if (str) {
                var qsRegex,
                    buttonFilter,
                    Iso = container.find(".tss-isotope"),
                    caro = container.find('.tss-carousel'),
                    caroThumb = container.find('.tss-carousel-main'),
                    html_loading = '<div class="rt-loading-overlay"></div><div class="rt-loading rt-ball-clip-rotate"><div></div></div>',
                    preLoader = container.find('.tss-pre-loader');
                if (preLoader.find('.rt-loading-overlay').length == 0) {
                    preLoader.append(html_loading);
                }

				if (caroThumb.length) {
					var carouselOptions = {
						items: parseInt(caroThumb.data('items-desktop')),
						tItems: parseInt(caroThumb.data('items-tab')),
						mItems: parseInt(caroThumb.data('items-mobile')),
						loop: caroThumb.data('loop'),
						nav: caroThumb.data('nav'),
						dots: caroThumb.data('dots'),
						autoplay: caroThumb.data('autoplay'),
						autoplayDelay: parseInt(caroThumb.data('autoplay-timeout'), 10),
						autoPlayHoverPause: caroThumb.data('autoplay-hover-pause'),
						autoHeight: caroThumb.data('auto-height'),
						lazyLoad: caroThumb.data('lazy-load'),
						rtl: caroThumb.data('rtl'),
						smartSpeed: parseInt(caroThumb.data('smart-speed'))
					};

					carouselOptions.responsive = {
						0: {
							slidesPerView: carouselOptions.mItems ? carouselOptions.mItems : 3,
						},
						767: {
							slidesPerView: carouselOptions.tItems ? carouselOptions.tItems : 3,
						},
						991: {
							slidesPerView: carouselOptions.items ? carouselOptions.items : 5,
						}
					};

					RTElementThumbCarousel(container, carouselOptions, elementThumbInstances, index);

					caroThumb.parents('.rt-row').removeClass('tss-pre-loader');
					caroThumb.parents('.rt-row').find('.rt-loading-overlay, .rt-loading').fadeOut(100);

					// Updating the sliders
					setTimeout(function() {
						elementThumbInstances.forEach(function(slider) {
							slider.forEach(function(s) {
								s.update();
							});
						});
					}, 50);
				}

                if (caro.length) {
					var carouselEl = {
						container: container.find('.tss-carousel'),
						items: parseInt(caro.data('items-desktop')),
						tItems: parseInt(caro.data('items-tab')),
						mItems: parseInt(caro.data('items-mobile')),
						loop: caro.data('loop'),
						nav: caro.data('nav'),
						dots: caro.data('dots'),
						autoplay: caro.data('autoplay'),
						autoplayDelay: parseInt(caro.data('autoplay-timeout'), 10),
						autoPlayHoverPause: caro.data('autoplay-hover-pause'),
						autoHeight: caro.data('auto-height'),
						lazyLoad: caro.data('lazy-load'),
						rtl: caro.data('rtl'),
						smartSpeed: parseInt(caro.data('smart-speed')),
						navPrev: '.swiper-button-prev',
						navNext: '.swiper-button-next',
						dotsEl: '.swiper-pagination'
					};

					elementCarousel(carouselEl, elementInstances, index);

					// Updating the sliders
					setTimeout(function() {
						elementInstances.forEach(function(slider) {
							slider.update();
						});
					}, 50);

					// Updating the sliders in tab
					$('body').on('shown.bs.tab', 'a[data-bs-toggle="tab"], a[data-bs-toggle="pill"]', function(e) {
						elementInstances.forEach(function(slider) {
							slider.update();
						});
					});

					$('.vc_tta-tabs-list li').on('click', function() {
						setTimeout(function() {
							elementInstances.forEach(function(slider) {
								slider.update();
							});
						}, 100);
					});

					caro.parents('.rt-row').removeClass('tss-pre-loader');
					caro.parents('.rt-row').find('.rt-loading-overlay, .rt-loading').fadeOut(100);
                }

                if (Iso.length) {
                    var IsoButton = container.find(".tss-isotope-button-wrapper");
                    if (!buttonFilter) {
                        buttonFilter = IsoButton.find('button.selected').data('filter');
                    }
                    var isotope = Iso.imagesLoaded(function () {
                        preFunction();
                        Iso.parents('.rt-row').removeClass('tss-pre-loader');
                        Iso.parents('.rt-row').find('.rt-loading-overlay, .rt-loading').remove();
                        isotope.isotope({
                            itemSelector: '.isotope-item',
                            masonry: {columnWidth: '.isotope-item'},
                            filter: function () {
                                var $this = $(this);
                                var searchResult = qsRegex ? $this.text().match(qsRegex) : true;
                                var buttonResult = buttonFilter ? $this.is(buttonFilter) : true;
                                return searchResult && buttonResult;
                            }
                        });
                        isoFilterCounter(container, isotope);
                    });
                    // use value of search field to filter
                    var $quicksearch = container.find('.iso-search-input').keyup(debounce(function () {
                        qsRegex = new RegExp($quicksearch.val(), 'gi');
                        isotope.isotope();
                    }));

                    IsoButton.on('click', 'button', function (e) {
                        e.preventDefault();
                        buttonFilter = $(this).attr('data-filter');
                        isotope.isotope();
                        $(this).parent().find('.selected').removeClass('selected');
                        $(this).addClass('selected');
                    });

                    if (container.find('.tss-utility .tss-load-more').length) {
                        container.find(".tss-load-more").on('click', 'button', function (e) {
                            e.preventDefault(e);
                            alert("This feature not available at preview");
                        });
                    }

                    if (container.find('.tss-utility .tss-scroll-load-more').length) {

                    }
                } else if (container.find('.tss-row.tss-masonry').length) {
                    var masonryTarget = container.find('.tss-row.tss-masonry');
                    preFunction();
                    var isotopeM = masonryTarget.imagesLoaded(function () {
                        isotopeM.isotope({
                            itemSelector: '.masonry-grid-item',
                            masonry: {columnWidth: '.masonry-grid-item'}
                        });
                    });
                    if (container.find('.tss-utility .tss-load-more').length) {
                        container.find(".tss-load-more").on('click', 'button', function (e) {
                            e.preventDefault(e);
                            alert("This feature not available at preview");
                        });
                    }
                    if (container.find('.tss-utility .tss-scroll-load-more').length) {

                    }

                    if (container.find('.tss-utility .tss-pagination.tss-ajax').length) {
                        ajaxPagination(container, isotopeM);
                    }
                } else {
                    if (container.find(".tss-utility  .tss-load-more").length) {
                        container.find(".tss-load-more").on('click', 'button', function (e) {
                            e.preventDefault(e);
                            loadMoreButton($(this), isotopeM, container, 'eLayout');
                        });
                    }
                    if (container.find('.tss-utility .tss-scroll-load-more').length) {
                        $(window).on('scroll', function () {
                            var $this = container.find('.tss-utility .tss-scroll-load-more');
                            if ($this.attr('data-trigger') > 0) {
                                scrollLoadMore($this, isotopeM, container, 'eLayout');
                            }
                        });
                    }
                    if (container.find('.tss-utility .tss-pagination.tss-ajax').length) {
                        ajaxPagination(container);
                    }
                }
            }
        }
    }

	function elementCarousel(elements, instance, index) {
		var slider = elements.container.addClass('instance-' + index);
		elements.container.parent().find('.swiper-button-prev').addClass('prev-' + index);
		elements.container.parent().find('.swiper-button-next').addClass('next-' + index);

		var options = {
			slidesPerView: elements.items ? elements.items : 2,
			slidesPerGroup: elements.items ? elements.items : 2,
			spaceBetween: 0,
			speed: elements.smartSpeed,
			loop: elements.loop,
			autoHeight: elements.autoHeight,

			// Responsive breakpoints
			breakpoints: {
				0: {
					slidesPerView: elements.mItems ? elements.mItems : 1,
					slidesPerGroup: elements.mItems ? elements.mItems : 1
				},
				767: {
					slidesPerView: elements.tItems ? elements.tItems : 2,
					slidesPerGroup: elements.tItems ? elements.tItems : 2
				},
				991: {
					slidesPerView: elements.items ? elements.items : 3,
					slidesPerGroup: elements.items ? elements.items : 3
				}
			}
		};

		if (elements.autoplay) {
			options.autoplay = {
				delay: elements.autoplayDelay,
				pauseOnMouseEnter: elements.autoPlayHoverPause,
				disableOnInteraction: false
			};
		}

		if (elements.lazyLoad) {
			options.preloadImages = false;
			options.lazy = true;
		}

		if (elements.nav) {
			options.navigation = {
				nextEl: elements.navNext,
				prevEl: elements.navPrev
			};
		}

		if (elements.dots) {
			options.pagination = {
				el: elements.dotsEl,
				type: 'bullets',
				clickable: true
			};
		}

		instance[index] = new Swiper(slider[0], options);
	}

	function RTElementThumbCarousel(container, options, instance, index) {
		// Params
		var mainSlider = container.find('.tss-carousel-main').addClass('instance-' + index),
			navSlider = container.find('.tss-carousel-thumb').addClass('instance-' + index),
			navPrev = '.swiper-button-prev',
			navNext = '.swiper-button-next',
			dotsEl = '.swiper-pagination';

		container.find(navPrev).addClass('prev-' + index);
		container.find(navNext).addClass('next-' + index);

		// Main Slider
		var mainSliderOptions = {
			loop: true,
			speed: options.smartSpeed ? options.smartSpeed : 1000,
			loopedSlides: 5,
			autoHeight: options.autoHeight ? options.autoHeight : false
		};

		if (options.nav) {
			mainSliderOptions.navigation = {
				nextEl: navNext,
				prevEl: navPrev
			};
		}

		if (options.dots) {
			mainSliderOptions.pagination = {
				el: dotsEl,
				type: 'bullets',
				clickable: true
			};
		}
		var main = new Swiper(mainSlider[0], mainSliderOptions);

		// Navigation Slider
		var navSliderOptions = {
			loop: true,
			speed: options.smartSpeed ? options.smartSpeed : 1000,
			observer: true,
			observerParents: true,
			slidesPerView: options.items ? options.items : 5,
			centeredSlides: true,
			spaceBetween: 0,
			touchRatio: 0.2,
			slideToClickedSlide: true,
			loopedSlides: 5,
			watchSlidesProgress: true,
			breakpoints: options.responsive
		};

		if (options.autoplay) {
			navSliderOptions.autoplay = {
				delay: options.autoplayDelay,
				pauseOnMouseEnter: options.autoPlayHoverPause,
				disableOnInteraction: false
			};
		}

		if (options.lazyLoad) {
			navSliderOptions.preloadImages = false;
			navSliderOptions.lazy = true;
		}

		var thumb = new Swiper(navSlider[0], navSliderOptions);

		// Matching sliders
		main.controller.control = thumb;
		thumb.controller.control = main;

		instance[index] = [ main, thumb ];
	}

    function isoFilterCounter(container, isotope) {
        var total = 0;
        container.find('.tss-isotope-button-wrapper button').each(function () {
            var self = $(this),
                filter = self.data("filter"),
                itemTotal = isotope.find(filter).length;
            if (filter != "*") {
                self.attr("data-filter-counter", itemTotal);
                total = total + itemTotal
            }
        });
        container.find('.tss-isotope-button-wrapper button[data-filter="*"]').attr("data-filter-counter", total);
    }


    function ajaxPagination(container, isotopeM) {
        $(".tss-pagination.tss-ajax ul li").on('click', 'a', function (e) {
            e.preventDefault();
            alert("This feature not available at preview");
        });
    }

    function preFunction() {
        HeightResize();
    }

    function HeightResize() {
        var wWidth = $(window).width();
        $(".tss-wrapper").each(function () {
            var self = $(this),
                dCol = self.data('desktop-col'),
                tCol = self.data('tab-col'),
                mCol = self.data('mobile-col'),
                target = $(this).find('.rt-row.tss-even'),
                caro = self.find('.tss-carousel');

                if (caro.length > 0) {
                    return false;
                }

            if ((wWidth >= 992 && dCol > 1) || (wWidth >= 768 && tCol > 1) || (wWidth < 768 && mCol > 1)) {
                target.imagesLoaded(function () {
                    var tlpMaxH = 0;
                    target.find('.even-grid-item').height('auto');
                    target.find('.even-grid-item').each(function () {
                        var $thisH = $(this).outerHeight();
                        if ($thisH > tlpMaxH) {
                            tlpMaxH = $thisH;
                        }
                    });
                    target.find('.even-grid-item').height(tlpMaxH + "px");

                    var isoMaxH = 0;
                    target.find('.tss-portfolio-isotope').children('.even-grid-item').height("auto");
                    target.find('.tss-portfolio-isotope').children('.even-grid-item').each(function () {
                        var $thisH = $(this).outerHeight();
                        // console.log($thisH);
                        if ($thisH > isoMaxH) {
                            isoMaxH = $thisH;
                        }
                    });
                    target.find('.tss-portfolio-isotope').children('.even-grid-item').height(isoMaxH + "px");
                });
            } else {
                target.find('.even-grid-item').height('auto');
                target.find('.tss-portfolio-isotope').children('.even-grid-item').height('auto');
            }

        });
    }

    // debounce so filtering doesn't happen every millisecond
    function debounce(fn, threshold) {
        var timeout;
        return function debounced() {
            if (timeout) {
                clearTimeout(timeout);
            }
            function delayed() {
                fn();
                timeout = null;
            }

            setTimeout(delayed, threshold || 100);
        };
    }

    function tssPreviewAjaxCall(element, action, arg, handle) {
        var data;
        if (action) data = "action=" + action;
        if (arg)    data = arg + "&action=" + action;
        if (arg && !action) data = arg;

        var n = data.search(tss.nonceId);
        if (n < 0) {
            data = data + "&" + tss.nonceId + "=" + tss.nonce;
        }
        $.ajax({
            type: "post",
            url: tss.ajaxurl,
            data: data,
            beforeSend: function () {
                $('#tss_sc_preview_meta').addClass('loading');
                $('.tss-response .spinner').addClass('is-active');
            },
            success: function (data) {
                $('#tss_sc_preview_meta').removeClass('loading');
                $('.tss-response .spinner').removeClass('is-active');
                handle(data);
            }
        });
    }

})(jQuery);

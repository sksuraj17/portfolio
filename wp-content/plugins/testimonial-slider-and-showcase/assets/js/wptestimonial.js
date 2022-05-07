(function ($) {
	'use strict';
	$('*')
		.on('touchstart', function () {
			$(this).trigger('hover');
		})
		.on('touchend', function () {
			$(this).trigger('hover');
		});

	$(function () {
		preFunction();
		$(document)
			.on('mouseover', '.tss-isotope-button-wrapper.tooltip-active .rt-iso-button', function () {
				var self = $(this),
					count = self.attr('data-filter-counter'),
					id = self.parents('.tss-wrapper').attr('id');
				$tooltip =
					'<div class="tss-tooltip" id="tss-tooltip-' +
					id +
					'">' +
					'<div class="tss-tooltip-content">' +
					count +
					'</div>' +
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
				$tooltip
					.css({
						top: top + 'px',
						left: left + 'px',
						opacity: 1
					})
					.show();
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
			.on('mouseout', '.tss-isotope-button-wrapper.tooltip-active .rt-iso-button', function () {
				$('body > .tss-tooltip').fadeOut(300, function () { $(this).remove(); });
			});
	});

	$(window).on('load resize', function () {
		preFunction();
	});

	function preFunction() {
		overlayIconResize();
	}

	RTInitCaroIso();

	function RTInitCaroIso() {
		var elementInstances = [];
		var elementThumbInstances = [];

		$('.tss-wrapper').each(function (index) {
			var container = $(this);
			var str = $(this).attr('data-layout');
			if (str) {
				var qsRegex,
					buttonFilter,
					Iso = container.find('.tss-isotope'),
					caro = container.find('.tss-carousel'),
					caroThumb = container.find('.tss-carousel-main'),
					html_loading =
						'<div class="rt-loading-overlay"></div><div class="rt-loading rt-ball-clip-rotate"><div></div></div>',
					preLoader = container.find('.tss-pre-loader');
				if (preLoader.find('.rt-loading-overlay').length == 0) {
					preLoader.append(html_loading);
				}

				if (caroThumb.length) {
					var carouselOptions = RTCarouselOptions(caroThumb);

					carouselOptions.responsive = {
						0: {
							slidesPerView: carouselOptions.mItems ? carouselOptions.mItems : 3
						},
						575: {
							slidesPerView: carouselOptions.tItems ? carouselOptions.tItems : 3
						},
						991: {
							slidesPerView: carouselOptions.items ? carouselOptions.items : 5
						}
					};

					RTElementThumbCarousel(container, carouselOptions, elementThumbInstances, index);

					caroThumb.parents('.rt-row').removeClass('tss-pre-loader');
					caroThumb.parents('.rt-row').find('.rt-loading-overlay, .rt-loading').fadeOut(100);

					// Updating the sliders
					setTimeout(function () {
						elementThumbInstances.forEach(function (sliders) {
							sliders.forEach(function (slider) {
								slider.update();
							});
						});
					}, 50);
				}

				if (caro.length) {
					var carouselEl = {
						container: container.find('.tss-carousel'),
						navPrev: '.swiper-button-prev',
						navNext: '.swiper-button-next',
						dotsEl: '.swiper-pagination'
					};

					var carouselOptions = RTCarouselOptions(caro);

					carouselOptions.responsive = {
						0: {
							slidesPerView: carouselOptions.mItems ? carouselOptions.mItems : 1,
							slidesPerGroup: carouselOptions.mItems ? carouselOptions.mItems : 1
						},
						767: {
							slidesPerView: carouselOptions.tItems ? carouselOptions.tItems : 2,
							slidesPerGroup: carouselOptions.tItems ? carouselOptions.tItems : 2
						},
						991: {
							slidesPerView: carouselOptions.items ? carouselOptions.items : 3,
							slidesPerGroup: carouselOptions.items ? carouselOptions.items : 3
						}
					};

					RTElementCarousel(carouselEl, carouselOptions, elementInstances, index);

					// Updating the sliders
					setTimeout(function () {
						elementInstances.forEach(function (slider) {
							slider.update();
						});
					}, 50);

					// Updating the sliders in tab
					$('body').on('shown.bs.tab', 'a[data-bs-toggle="tab"], a[data-bs-toggle="pill"]', function (e) {
						elementInstances.forEach(function (slider) {
							slider.update();
						});
					});

					$('.vc_tta-tabs-list li').on('click', function () {
						setTimeout(function () {
							elementInstances.forEach(function (slider) {
								slider.update();
							});
						}, 100);
					});

					caro.parents('.rt-row').removeClass('tss-pre-loader');
					caro.parents('.rt-row').find('.rt-loading-overlay, .rt-loading').fadeOut(100);
				} else if (Iso.length) {
					var IsoButton = container.find('.tss-isotope-button-wrapper');
					if (!buttonFilter) {
						buttonFilter = IsoButton.find('.rt-iso-button.selected').data('filter');
					}
					var isotope = Iso.imagesLoaded(function () {
						Iso.parents('.rt-row').removeClass('tss-pre-loader');
						Iso.parents('.rt-row').find('.rt-loading-overlay, .rt-loading').remove();
						preFunction();
						isotope.isotope({
							itemSelector: '.isotope-item',
							masonry: {
								columnWidth: '.isotope-item'
							},
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
					var $quicksearch = container.find('.iso-search-input').keyup(
						debounce(function () {
							qsRegex = new RegExp($quicksearch.val(), 'gi');
							isotope.isotope();
						})
					);

					IsoButton.on('click', '.rt-iso-button', function (e) {
						e.preventDefault();
						buttonFilter = $(this).attr('data-filter');
						isotope.isotope();
						$(this).parent().find('.selected').removeClass('selected');
						$(this).addClass('selected');
					});

					if (container.find('.tss-utility .tss-load-more').length) {
						container.find('.tss-load-more').on('click', '.rt-button', function (e) {
							e.preventDefault(e);
							loadMoreButton($(this), isotope, container, 'isotope', IsoButton);
						});
					}

					if (container.find('.tss-utility .tss-scroll-load-more').length) {
						$(window).on('scroll', function () {
							var $this = container.find('.tss-utility .tss-scroll-load-more');
							scrollLoadMore($this, isotope, container, 'isotope', IsoButton);
						});
					}
				} else if (container.find('.rt-row.tss-masonry').length) {
					var masonryTarget = container.find('.rt-row.tss-masonry');
					preFunction();
					var isotopeM = masonryTarget.imagesLoaded(function () {
						isotopeM.isotope({
							itemSelector: '.masonry-grid-item',
							masonry: {
								columnWidth: '.masonry-grid-item'
							}
						});
					});
					if (container.find('.tss-utility .tss-load-more').length) {
						container.find('.tss-load-more').on('click', '.rt-button', function (e) {
							e.preventDefault(e);
							loadMoreButton($(this), isotopeM, container, 'mLayout');
						});
					}
					if (container.find('.tss-utility .tss-scroll-load-more').length) {
						$(window).on('scroll', function () {
							var $this = container.find('.tss-utility .tss-scroll-load-more');
							if ($this.attr('data-trigger') > 0) {
								scrollLoadMore($this, isotopeM, container, 'mLayout');
							}
						});
					}

					if (container.find('.tss-utility .tss-pagination.tss-ajax').length) {
						ajaxPagination(container, isotopeM);
					}
				} else {
					if (container.find('.tss-utility  .tss-load-more').length) {
						container.find('.tss-load-more').on('click', '.rt-button', function (e) {
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
		});
	}

	function RTCarouselOptions(el) {
		return {
			items: parseInt(el.data('items-desktop')),
			tItems: parseInt(el.data('items-tab')),
			mItems: parseInt(el.data('items-mobile')),
			loop: el.data('loop'),
			nav: el.data('nav'),
			dots: el.data('dots'),
			autoplay: el.data('autoplay'),
			autoplayDelay: parseInt(el.data('autoplay-timeout'), 10),
			autoPlayHoverPause: el.data('autoplay-hover-pause'),
			autoHeight: el.data('auto-height'),
			lazyLoad: el.data('lazy-load'),
			rtl: el.data('rtl'),
			smartSpeed: parseInt(el.data('smart-speed'))
		};
	}

	function RTElementCarousel(elements, carouselOptions, instance, index) {
		var slider = elements.container.addClass('instance-' + index);
		elements.container.parent().find(elements.navPrev).addClass('prev-' + index);
		elements.container.parent().find(elements.navNext).addClass('next-' + index);

		var options = {
			slidesPerView: carouselOptions.items ? carouselOptions.items : 2,
			slidesPerGroup: carouselOptions.items ? carouselOptions.items : 2,
			spaceBetween: 0,
			speed: carouselOptions.smartSpeed ? carouselOptions.smartSpeed : 1000,
			loop: carouselOptions.loop ? carouselOptions.loop : false,
			autoHeight: carouselOptions.autoHeight ? carouselOptions.autoHeight : false,

			// Responsive breakpoints
			breakpoints: carouselOptions.responsive
		};

		if (carouselOptions.autoplay) {
			options.autoplay = {
				delay: carouselOptions.autoplayDelay,
				pauseOnMouseEnter: carouselOptions.autoPlayHoverPause,
				disableOnInteraction: false
			};
		}

		if (carouselOptions.lazyLoad) {
			options.preloadImages = false;
			options.lazy = true;
		}

		if (carouselOptions.nav) {
			options.navigation = {
				nextEl: elements.navNext,
				prevEl: elements.navPrev
			};
		}

		if (carouselOptions.dots) {
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

		// Syncing the sliders
		main.controller.control = thumb;
		thumb.controller.control = main;

		instance[index] = [main, thumb];
	}

	function isoFilterCounter(container, isotope) {
		var total = 0;
		container.find('.tss-isotope-button-wrapper .rt-iso-button').each(function () {
			var self = $(this),
				filter = self.data('filter'),
				itemTotal = isotope.find(filter).length;
			if (filter != '*') {
				self.attr('data-filter-counter', itemTotal);
				total = total + itemTotal;
			}
		});
		container
			.find('.tss-isotope-button-wrapper .rt-iso-button[data-filter="*"]')
			.attr('data-filter-counter', total);
	}

	function loadMoreButton($this, $isotope, container, layout, IsoButton) {
		var $thisText = $this.clone().children().remove().end().text(),
			noMorePostText = $this.data('no-more-post-text'),
			loadingText = $this.data('loading-text'),
			scID = $this.attr('data-sc-id'),
			elData = $this.data('tss-elementor'),
			paged = parseInt($this.attr('data-paged'), 10) + 1,
			totalPages = parseInt($this.data('total-pages'), 10),
			foundPosts = parseInt($this.data('found-posts'), 10),
			postsPerPage = parseInt($this.data('posts-per-page'), 10),
			data = 'scID=' + scID + '&paged=' + paged,
			morePosts = foundPosts - postsPerPage * paged,
			data;

		data = 'scID=' + scID + '&paged=' + paged;

		if (typeof elData !== 'undefined') {
			data = 'elData=' + JSON.stringify(elData) + '&paged=' + paged;
		}

		if (morePosts > 0) {
			$thisText = $thisText + ' <span>(' + morePosts + ')</span>';
		} else {
			$thisText = noMorePostText;
		}
		data = data + '&action=tssLoadMore&' + tss.nonceId + '=' + tss.nonce;
		if (container.data('archive')) {
			data = data + '&archive=' + container.data('archive');
			if (container.data('archive-value')) {
				data = data + '&archive-value=' + container.data('archive-value');
			}
		}

		$.ajax({
			type: 'post',
			url: tss.ajaxurl,
			data: data,
			beforeSend: function () {
				$this.html('<span class="more-loading">' + loadingText + '</span>');
			},
			success: function (data) {
				if (!data.error) {
					$this.attr('data-paged', paged);
					if (layout == 'isotope') {
						renderIsotope(container, $isotope, data.data, IsoButton);
					} else if (layout == 'mLayout') {
						$isotope
							.append(data.data)
							.isotope('appended', data.data)
							.isotope('updateSortData')
							.isotope('reloadItems');
						$isotope.imagesLoaded(function () {
							$isotope.isotope();
						});
					} else {
						container.children('.rt-row').append(data.data);
						container.children('.rt-row').imagesLoaded(function () {
							preFunction();
						});
					}
					$this.html($thisText);
					if (totalPages <= paged) {
						$this.css("pointer-events", "none");
						$this.unbind("click");
					}
				} else {
					$this.text(data.msg);
					$this.attr('disabled', 'disabled');
					$this.parent().hide();
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				container.find('.more-loading').remove();
				alert(textStatus + ' (' + errorThrown + ')');
			}
		});
		return false;
	}

	function renderIsotope(container, $isotope, data, IsoButton) {
		var qsRegexG, buttonFilter;
		if (!buttonFilter) {
			buttonFilter = IsoButton.find('.rt-iso-button.selected').data('filter');
		}

		$isotope.append(data).isotope('appended', data).isotope('reloadItems').isotope('updateSortData');
		$isotope.imagesLoaded(function () {
			preFunction();
			$isotope.isotope();
		});

		$(IsoButton).on('click', '.rt-iso-button', function (e) {
			e.preventDefault();
			buttonFilter = $(this).attr('data-filter');
			$isotope.isotope();
			$(this).parent().find('.selected').removeClass('selected');
			$(this).addClass('selected');
		});
		var $quicksearch = container.find('.iso-search-input').keyup(
			debounce(function () {
				qsRegexG = new RegExp($quicksearch.val(), 'gi');
				$isotope.isotope();
			})
		);
		isoFilterCounter(container, $isotope);
	}

	function scrollLoadMore($this, $isotope, container, layout, IsoButton) {
		var viewportHeight = $(window).height();
		var scrollTop = $(window).scrollTop();
		var targetHeight = $this.offset().top + $this.outerHeight() - 50;
		var targetScroll = scrollTop + viewportHeight;

		if (targetScroll >= targetHeight) {
			var trigger = $this.attr('data-trigger');
			if (trigger == 1) {
				// $this.data('trigger', false);
				$this.attr('data-trigger', 0);
				var data,
					scID = $this.attr('data-sc-id'),
					elData = $this.data('tss-elementor'),
					maxpage = $this.data('max-page'),
					paged = parseInt($this.attr('data-paged'), 10);

				data = 'scID=' + scID + '&paged=' + paged;

				if (typeof elData !== 'undefined') {
					data = 'elData=' + JSON.stringify(elData) + '&paged=' + paged;
				}

				// data = 'scID=' + scID + '&paged=' + paged;
				data = data + '&action=tssLoadMore&' + tss.nonceId + '=' + tss.nonce;

				if (container.data('archive')) {
					data = data + '&archive=' + container.data('archive');
					if (container.data('archive-value')) {
						data = data + '&archive-value=' + container.data('archive-value');
					}
				}
				$.ajax({
					type: 'post',
					url: tss.ajaxurl,
					data: data,
					beforeSend: function () {
						$this.html('<span class="more-loading">Loading ...</span>');
					},
					success: function (data) {
						if (!data.error) {
							$this.attr('data-paged', paged + 1);
							if (layout == 'isotope') {
								renderIsotope(container, $isotope, data.data, IsoButton);
							} else if (layout == 'mLayout') {
								$isotope
									.append(data.data)
									.isotope('appended', data.data)
									.isotope('updateSortData')
									.isotope('reloadItems');
								$isotope.imagesLoaded(function () {
									$isotope.isotope();
								});
							} else {
								container.children('.rt-row').append(data.data);
								container.children('.rt-row').imagesLoaded(function () {
									preFunction();
								});
							}
							$this.html('');
							$this.attr('data-trigger', 1);

							if ($this.attr('data-paged') > maxpage) {
								$this.attr('data-trigger', 0);
							}
						} else {
							$this.html('');
							$this.attr('data-trigger', 0);
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						container.find('.more-loading').remove();
						alert(textStatus + ' (' + errorThrown + ')');
					}
				});
			} // if trigger == 1
		}
	}

	function ajaxPagination(container, isotopeM) {
		container.find('.tss-pagination.tss-ajax ul li').on('click', 'a', function (e) {
			e.preventDefault();
			var data,
				$this = $(this),
				target = $this.parents('li'),
				parent = target.parents('.tss-pagination.tss-ajax'),
				activeLi = parent.find('li.active'),
				activeNumber = parseInt(activeLi.text(), 10),
				replaced = "<a data-paged='" + activeNumber + "' href='#'>" + activeNumber + '</a>',
				scID = parent.data('sc-id'),
				elData = parent.data('tss-elementor'),
				paged = $this.data('paged');
			activeLi.html(replaced);
			parent.find('li').removeClass('active');
			target.addClass('active');
			target.html('<span>' + paged + '</span>');

			data = 'scID=' + scID + '&paged=' + paged;

			if (typeof elData !== 'undefined') {
				data = 'elData=' + JSON.stringify(elData) + '&paged=' + paged;
			}

			data = data + '&action=tssLoadMore&' + tss.nonceId + '=' + tss.nonce;

			if (container.data('archive')) {
				data = data + '&archive=' + container.data('archive');
				if (container.data('archive-value')) {
					data = data + '&archive-value=' + container.data('archive-value');
				}
			}
			$.ajax({
				type: 'post',
				url: tss.ajaxurl,
				data: data,
				beforeSend: function () {
					parent.append(
						'<div class="tss-loading-holder"><span class="more-loading">Loading ...</span></div>'
					);
				},
				success: function (data) {

					if (!data.error) {
						if (typeof isotopeM === 'undefined') {
							container.children('.rt-row').animate({
								opacity: 0
							});
							setTimeout(function () {
								container.children('.rt-row').html(data.data);
								container.children('.rt-row').imagesLoaded(function () {
									preFunction();
									container.children('.rt-row').animate(
										{
											opacity: 1
										},
										1000
									);
								});
							}, 500);
						} else {
							container.children('.rt-row').find('.masonry-grid-item').remove();
							isotopeM
								.append(data.data)
								.isotope('appended', data.data)
								.isotope('updateSortData')
								.isotope('reloadItems');
							isotopeM.imagesLoaded(function () {
								preFunction();
								isotopeM.isotope();
							});
						}

						$('.tss-wrapper').animate({ scrollTop: 0 }, 700);
						$('html, body').animate({
							scrollTop: ($('.tss-wrapper').offset().top - 100)
						}, 700);
					} else {
						alert(data.msg);
					}
					container.find('.tss-loading-holder').remove();
				},
				error: function (jqXHR, textStatus, errorThrown) {
					container.find('.tss-loading-holder').remove();
					alert(textStatus + ' (' + errorThrown + ')');
				}
			});
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

	function overlayIconResize() {
		$('.tlp-item').each(function () {
			var holder_height = $(this).height();
			var a_height = $(this).find('.tlp-overlay .link-icon').height();
			var h = (holder_height - a_height) / 2;
			$(this).find('.link-icon').css('margin-top', h + 'px');
		});
	}

	function RTPromoContent() {
		parent.document.addEventListener("mousedown", function (e) {
			var widgets = parent.document.querySelectorAll(".elementor-element--promotion");

			if (widgets.length > 0) {
				for (var i = 0; i < widgets.length; i++) {
					if (widgets[i].contains(e.target)) {
						var dialog = parent.document.querySelector("#elementor-element--promotion__dialog");
						var icon = widgets[i].querySelector(".icon > i");

						if (icon.classList.toString().indexOf("tss-promotional-element") >= 0) {
							dialog.querySelector(".dialog-buttons-action").style.visibility = "hidden";
							dialog.querySelector(".dialog-buttons-action").style.width = 0;
							dialog.querySelector(".dialog-buttons-action").style.height = 0;
							dialog.querySelector(".dialog-buttons-action").style.opacity = 0;
							dialog.querySelector(".dialog-buttons-action").style.padding = 0;

							if (dialog.querySelector(".rt-dialog-buttons-action") === null) {
								var button = document.createElement("a");
								var buttonText = document.createTextNode("Get Pro");

								button.setAttribute("href", "https://www.radiustheme.com/downloads/wp-testimonial-slider-showcase-pro-wordpress/");
								button.setAttribute("target", "_blank");
								button.classList.add(
									"dialog-button",
									"dialog-action",
									"dialog-buttons-action",
									"elementor-button",
									"elementor-button-success",
									"rt-dialog-buttons-action"
								);
								button.appendChild(buttonText);

								dialog.querySelector(".dialog-buttons-action").insertAdjacentHTML("afterend", button.outerHTML);
							} else {
								dialog.querySelector(".rt-dialog-buttons-action").style.display = "";
							}
						} else {
							dialog.querySelector(".dialog-buttons-action").style.display = "";
							dialog.querySelector(".dialog-buttons-action").style.visibility = "";
							dialog.querySelector(".dialog-buttons-action").style.width = "";
							dialog.querySelector(".dialog-buttons-action").style.height = "";
							dialog.querySelector(".dialog-buttons-action").style.opacity = "";
							dialog.querySelector(".dialog-buttons-action").style.padding = "";

							if (dialog.querySelector(".rt-dialog-buttons-action") !== null) {
								dialog.querySelector(".rt-dialog-buttons-action").style.display = "none";
							}
						}

						break;
					}
				}
			}
		});
	}

	function RTInitIsotope() {
		var container = jQuery('.tss-wrapper');

		if (container.find('.tss-isotope, .tss-isotope2').length) {
			container.find('.tss-isotope, .tss-isotope2').isotope();
		}

		if (container.find('.rt-row.tss-masonry').length) {
			var masonryTarget = container.find('.rt-row.tss-masonry');
			masonryTarget.isotope({
				itemSelector: '.isotope-item',
				masonry: { columnWidth: '.isotope-item' }
			});
		}
	}

	// Elementor Frontend Load
	$(window).on('elementor/frontend/init', function () {
		if (elementorFrontend.isEditMode()) {
			elementorFrontend.hooks.addAction('frontend/element_ready/widget', function () {
				RTInitCaroIso();
				preFunction();
			});

			// Promo Content.
			RTPromoContent();
		}
	});
})(jQuery);

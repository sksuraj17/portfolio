<?php
if ( ! class_exists( 'TSSElementorRender' ) ) :
	/**
	 * Class for Elementor Frontend Render.
	 */
	class TSSElementorRender {
		private $scA = array();

		public function register_scripts() {
			$caro   = false;
			$iso    = false;
			$script = array();
			$style  = array();
			array_push( $script, 'jquery' );

			foreach ( $this->scA as $sc ) {
				if ( isset( $sc ) && is_array( $sc ) ) {
					if ( $sc['isCarousel'] ) {
						$caro = true;
					}
					if ( $sc['isIsotope'] ) {
						$iso = true;
					}
				}
			}

			if ( count( $this->scA ) ) {
				array_push( $script, 'tss-image-load' );
				if ( $caro ) {
					array_push( $style, 'swiper' );
					array_push( $script, 'swiper' );
				}

				if ( $iso ) {
					array_push( $script, 'tss-isotope' );
				}

				array_push( $style, 'tss-fontawsome' );
				array_push( $style, 'dashicons' );
				array_push( $script, 'tss' );

				wp_enqueue_style( $style );
				wp_enqueue_script( $script );

				$ajaxurl = '';
				if ( in_array( 'sitepress-multilingual-cms/sitepress.php', get_option( 'active_plugins' ) ) ) {
					$ajaxurl .= admin_url( 'admin-ajax.php?lang=' . ICL_LANGUAGE_CODE );
				} else {
					$ajaxurl .= admin_url( 'admin-ajax.php' );
				}
				wp_localize_script(
					'tss',
					'tss',
					array(
						'ajaxurl' => $ajaxurl,
						'nonce'   => wp_create_nonce( TSSPro()->nonceText() ),
						'nonceId' => TSSPro()->nonceId(),
					)
				);
			}

		}

		public function testimonialRender( $scMeta ) {
			$rand          = mt_rand();
			$layoutID      = 'tss-container-' . $rand;
			$html          = null;
			$arg           = array();
			$buildMetas    = $this->elMetas( $scMeta );
			$arg['scMeta'] = $scMeta;
			$lazyLoadP     = false;

			if ( $buildMetas ) {
				extract( $buildMetas );
			}

			if ( ! in_array( $dCol, array_keys( TSSPro()->scColumns() ) ) ) {
				$dCol = 3;
			}
			if ( ! in_array( $tCol, array_keys( TSSPro()->scColumns() ) ) ) {
				$tCol = 2;
			}
			if ( ! in_array( $dCol, array_keys( TSSPro()->scColumns() ) ) ) {
				$mCol = 1;
			}

			$dColItems  = $dCol;
			$tColItems  = $tCol;
			$mColItems  = $mCol;
			$isIsotope  = preg_match( '/isotope/', $layout );
			$isCarousel = preg_match( '/carousel/', $layout );
			$isVideo    = preg_match( '/video/', $layout );

			$containerDataAttr  = false;
			$containerDataAttr .= " data-layout='{$layout}' data-desktop-col='{$dCol}'  data-tab-col='{$tCol}'  data-mobile-col='{$mCol}'";

			$dCol = $dCol == 5 ? '24' : round( 12 / $dCol );
			$tCol = $tCol == 5 ? '24' : round( 12 / $tCol );
			$mCol = $mCol == 5 ? '24' : round( 12 / $mCol );

			if ( $isCarousel ) {
				$dCol = $tCol = $mCol = 12;
			}

			$arg['grid']      = "rt-col-md-{$dCol} rt-col-sm-{$tCol} rt-col-xs-{$mCol}";
			$arg['read_more'] = $readMore;
			$arg['class']     = $gridType . '-grid-item';
			$arg['class']    .= ' tss-grid-item';
			$preLoader        = null;

			if ( $isIsotope ) {
				$arg['class'] .= ' isotope-item';
				$preLoader     = 'tss-pre-loader';
			}

			if ( $isCarousel ) {
				$arg['class'] .= ' slide-item swiper-slide';
				$preLoader     = 'tss-pre-loader';
			}

			$masonryG = null;

			if ( $gridType == 'even' ) {
				$masonryG      = ' tss-even';
				$arg['class'] .= ' even-grid-item';
			} elseif ( $gridType == 'masonry' && ! $isIsotope && ! $isCarousel ) {
				$masonryG      = ' tss-masonry';
				$arg['class'] .= ' masonry-grid-item';
			}

			if ( $imageType == 'circle' ) {
				$arg['class'] .= ' tss-img-circle';
			}

			$arg['items']       = $itemFields;
			$arg['shareItems']  = array();
			$arg['anchorClass'] = null;
			$arg['link']        = $link ? true : false;

			// Start layout
			$html .= TSSPro()->layoutStyle( $layoutID, $scMeta );
			$html .= "<div class='rt-container-fluid tss-wrapper' id='{$layoutID}' {$containerDataAttr}>";
			$html .= "<div data-title='" . esc_html__(
				'Loading ...',
				'testimonial-slider-showcase'
			) . "' class='rt-row tss-{$layout}{$masonryG} {$preLoader}'>";

			// WP_Query args.
			$tssArgs = TSSPro()->buildArgs( $buildMetas, $isCarousel );

			$tssQuery = new WP_Query( $tssArgs );

			if ( $tssQuery->have_posts() ) {
				if ( $isIsotope ) {
					$terms = get_terms(
						array(
							'taxonomy'   => TSSPro()->taxonomies['category'],
							'hide_empty' => false,
							'orderby'    => 'meta_value_num',
							'order'      => 'ASC',
							'meta_key'   => '_order',
						)
					);

					$tooltipClass   = $isotopTooltip ? 'tooltip-active' : '';
					$html          .= '<div class="tss-iso-filter"><div id="iso-button-' . $rand . '" class="tss-isotope-button-wrapper ' . $tooltipClass . ' filter-button-group">';
					$htmlButton     = null;
					$fSelectTrigger = false;

					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
						foreach ( $terms as $term ) {
							$fSelect = null;

							if ( $tItem == $term->term_id ) {
								$fSelect        = ' selected';
								$fSelectTrigger = true;
							}

							$htmlButton .= "<span class='rt-iso-button {$fSelect}' data-filter-counter='' data-filter='.iso_{$term->term_id}' {$fSelect}>" . $term->name . '</span>';
						}
					}

					if ( empty( $isotopeShowAll ) ) {
						$fSelect = ( $fSelectTrigger ? null : ' selected' );
						$html   .= "<span class='rt-iso-button{$fSelect}' data-filter-counter='' data-filter='*'>" . esc_html__(
							'Show all',
							'testimonial-slider-showcase'
						) . '</span>';
					}

					$html .= $htmlButton;
					$html .= '</div>';

					if ( ! empty( $isotopeSearchFilter ) ) {
						$html .= "<div class='iso-search'><input type='text' class='iso-search-input' placeholder='" . esc_html__(
							'Search',
							'testimonial-slider-showcase'
						) . "' /></div>";
					}

					$html .= '</div>';

					$html .= '<div class="tss-isotope" id="tss-isotope-' . $rand . '">';
				} elseif ( $isCarousel ) {
					$autoPlay           = ( in_array( 'autoplay', $cOpt ) ? 'true' : 'false' );
					$autoPlayHoverPause = ( in_array( 'autoplayHoverPause', $cOpt ) ? 'true' : 'false' );
					$nav                = ( in_array( 'nav', $cOpt ) ? 'true' : 'false' );
					$dots               = ( in_array( 'dots', $cOpt ) ? 'true' : 'false' );
					$loop               = ( in_array( 'loop', $cOpt ) ? 'true' : 'false' );
					$lazyLoad           = ( in_array( 'lazy_load', $cOpt ) ? 'true' : 'false' );
					$lazyLoadP          = ( in_array( 'lazy_load', $cOpt ) ? true : false );
					$autoHeight         = ( in_array( 'auto_height', $cOpt ) ? 'true' : 'false' );
					$rtl                = ( in_array( 'rtl', $cOpt ) ? 'dir="rtl"' : '' );
					$carouselWrapper    = 'carousel11' === $layout || 'carousel12' === $layout ? 'tss-carousel-main' : 'tss-carousel';

					if ( 'carousel11' === $layout ) {
						$html .= $this->renderThumbSlider( $tssQuery, $scMeta, $arg );
					}

					$html .= '<div class="carousel-wrapper">';
					$html .= "<div {$rtl} class='{$carouselWrapper} swiper'
									data-loop='{$loop}'
									data-items-desktop='{$dColItems}'
									data-items-tab='{$tColItems}'
									data-items-mobile='{$mColItems}'
									data-autoplay='{$autoPlay}'
									data-autoplay-timeout='{$autoplayTimeout}'
									data-autoplay-hover-pause='{$autoPlayHoverPause}'
									data-dots='{$dots}'
									data-nav='{$nav}'
									data-lazy-load='{$lazyLoad}'
									data-auto-height='{$autoHeight}'
									data-smart-speed='{$smartSpeed}'
									>";

					$html .= '<div class="swiper-wrapper">';
				}

				while ( $tssQuery->have_posts() ) :
					$tssQuery->the_post();

					$iID                 = get_the_ID();
					$arg['iID']          = $iID;
					$arg['author']       = get_the_title();
					$arg['testimonial']  = get_the_content();
					$arg['designation']  = get_post_meta( $iID, 'tss_designation', true );
					$arg['company']      = get_post_meta( $iID, 'tss_company', true );
					$arg['location']     = get_post_meta( $iID, 'tss_location', true );
					$arg['rating']       = get_post_meta( $iID, 'tss_rating', true );
					$arg['video']        = get_post_meta( $iID, 'tss_video', true );
					$arg['social_media'] = get_post_meta( $iID, 'tss_social_media', true );
					$arg['pLink']        = get_permalink();
					$aHtml               = null;

					if ( in_array( 'read_more', $arg['items'] ) && function_exists( 'rttsp' ) ) {
						$aHtml = "<a class='rt-read-more' href='" . esc_url( $arg['pLink'] ) . "'>{$arg['read_more']}</a>";
					}

					if ( $enable_testi_limit ) {
						if ( $testi_limit ) {
							$arg['testimonial'] = TSSPro()->tssWordLimit( $testi_limit, $aHtml );
						}
					}

					$arg['video_url'] = get_post_meta( $iID, 'tss_video', true );

					if ( $isIsotope && taxonomy_exists( TSSPro()->taxonomies['category'] ) ) {
						$termAs = wp_get_post_terms(
							$iID,
							TSSPro()->taxonomies['category'],
							array( 'fields' => 'all' )
						);

						$isoFilter = null;

						if ( ! empty( $termAs ) ) {
							foreach ( $termAs as $term ) {
								$isoFilter .= ' ' . 'iso_' . $term->term_id;
								$isoFilter .= ' ' . $term->slug;
							}
						}

						$arg['isoFilter'] = $isoFilter;
					}

					if ( $lazyLoadP ) {
						$arg['lazyLoad'] = true;
						$arg['img']      = TSSPro()->getFeatureImage( $iID, $imgSize, $customImgSize, $defaultImgId, true );
					} else {
						$arg['lazyLoad'] = false;
						$arg['img']      = TSSPro()->getFeatureImage( $iID, $imgSize, $customImgSize, $defaultImgId );
					}

					// Render layout.
					$html .= TSSPro()->render( 'layouts/' . $layout, $arg );

				endwhile;

				if ( $isIsotope ) {
					$html .= '</div>'; // End isotope.
				} elseif ( $isCarousel ) {
					if ( 'grid' !== $scMeta['tss_el_layout_type'] ) {
						$html .= '</div>';

						$html .= 'true' === $nav ? '<div class="swiper-arrow swiper-button-next"><i class="fa fa-chevron-right"></i></div><div class="swiper-arrow swiper-button-prev"><i class="fa fa-chevron-left"></i></div>' : '';
						$html .= 'true' === $dots ? '<div class="swiper-pagination"></div>' : '';

						$html .= '</div>';

						$html .= '</div>'; // End Carousel item holder.

						if ( 'carousel12' === $layout ) {
							$html .= $this->renderThumbSlider( $tssQuery, $scMeta, $arg );
						}
					}
				}
			} else {
				$html .= '<p>' . esc_html__( 'No testimonial found', 'testimonial-slider-showcase' ) . '</p>';
			}

			if ( $isIsotope || $isCarousel ) {
				$html .= '<div class="rt-loading-overlay"></div><div class="rt-loading rt-ball-clip-rotate"><div></div></div>';
			}

			$html .= '</div>'; // End row.

			$maxPages  = $tssQuery->max_num_pages;
			$foundPost = $tssQuery->found_posts;

			if ( $hasPagination && ! $isCarousel ) {
				if ( isset( $scMeta['tss_el_posts_limit'] ) && ! empty( $scMeta['tss_el_posts_limit'] ) ) {
					$foundPost = $tssQuery->found_posts;
					$range     = $scMeta['tss_el_pagination_per_page'];

					if ( $range && $foundPost > $scMeta['tss_el_pagination_per_page'] ) {
						$foundPost = $scMeta['tss_el_posts_limit'];
						$maxPages  = ceil( $foundPost / $range );
					}
				}

				$htmlUtility = null;

				if ( $paginationType == 'pagination' ) {
					$htmlUtility .= TSSPro()->pagination( $maxPages, $tssArgs['posts_per_page'] );
				} elseif ( $paginationType == 'pagination_ajax' && ! $isIsotope ) {
					$htmlUtility .= TSSPro()->pagination(
						$maxPages,
						$tssArgs['posts_per_page'],
						true,
						'elementor',
						$scMeta
					);
				} elseif ( $paginationType == 'load_more' ) {
					$postPp         = $tssQuery->query_vars['posts_per_page'];
					$page           = $tssQuery->query_vars['paged'];
					$foundPosts     = $foundPost;
					$totalPage      = $maxPages;
					$morePosts      = $foundPosts - ( $postPp * $page );
					$noMorePostText = esc_html__( 'No More Post to load', 'testimonial-slider-showcase' );
					$loadingText    = esc_html__( 'Loading ...', 'testimonial-slider-showcase' );
					$htmlUtility   .= "<div class='tss-load-more'>
									<span class='rt-button' data-sc-id='elementor' data-total-pages='{$totalPage}' data-posts-per-page='{$postPp}' data-found-posts='{$foundPosts}' data-paged='1'
									data-no-more-post-text='{$noMorePostText}' data-loading-text='{$loadingText}' {$this->loadMoreArgs($scMeta)}>{$loadMore} <span>({$morePosts})</span></span>
								</div>";
				} elseif ( $paginationType == 'load_on_scroll' ) {
					$htmlUtility .= "<div class='tss-scroll-load-more' data-trigger='1' data-sc-id='elementor' data-paged='2' data-max-page={$maxPages} {$this->loadMoreArgs($scMeta)}></div>";
				}

				if ( $htmlUtility ) {
					$html .= "<div class='tss-utility'>" . $htmlUtility . '</div>';
				}
			}
				$html .= '</div>'; // tss-container.
				wp_reset_postdata();
				$scriptGenerator               = array();
				$scriptGenerator['layout']     = $layoutID;
				$scriptGenerator['rand']       = $rand;
				$scriptGenerator['scMeta']     = $scMeta;
				$scriptGenerator['isIsotope']  = ( $isIsotope || $gridType == 'masonry' ? true : false );
				$scriptGenerator['isCarousel'] = $isCarousel;
				$this->scA[]                   = $scriptGenerator;

				add_action( 'wp_footer', array( $this, 'register_scripts' ) );

				return $html;
		}

		private function elMetas( array $meta ) {
			$cImageSize         = ! empty( $meta['tss_el_image_custom_dimension'] ) ? $meta['tss_el_image_custom_dimension'] : array();
			$cImageSize['crop'] = ! empty( $meta['tss_el_image_crop'] ) ? $meta['tss_el_image_crop'] : '';

			return array(
				'layout'              => ! empty( $meta['tss_el_layout_type'] ) ? esc_attr( $meta['tss_el_layout_type'] ) : 'layout1',
				'dCol'                => isset( $meta['tss_el_cols'] ) && $meta['tss_el_cols'] != '' ? absint( $meta['tss_el_cols'] ) : 3,
				'tCol'                => isset( $meta['tss_el_cols_tablet'] ) && $meta['tss_el_cols_tablet'] != '' ? absint( $meta['tss_el_cols_tablet'] ) : 2,
				'mCol'                => isset( $meta['tss_el_cols_mobile'] ) && $meta['tss_el_cols_mobile'] != '' ? absint( $meta['tss_el_cols_mobile'] ) : 1,
				'customImgSize'       => ! empty( $cImageSize ) ? $cImageSize : array(),
				'defaultImgId'        => ! empty( $meta['tss_el_image_default_preview']['id'] ) ? absint( $meta['tss_el_image_default_preview']['id'] ) : null,
				'imgSize'             => ! empty( $meta['tss_el_image'] ) ? sanitize_text_field( $meta['tss_el_image'] ) : 'medium',
				'enable_testi_limit'  => ! empty( $meta['tss_el_text_limit'] ) ? true : false,
				'testi_limit'         => ! empty( $meta['tss_el_testimonial_text_limit'] ) ? absint( $meta['tss_el_testimonial_text_limit'] ) : null,
				'gridType'            => ! empty( $meta['tss_el_grid_style'] ) ? esc_attr( $meta['tss_el_grid_style'] ) : 'even',
				'readMore'            => ! empty( $meta['tss_el_read_more_text'] ) ? esc_html( $meta['tss_el_read_more_text'] ) : null,
				'loadMore'            => ! empty( $meta['tss_el_load_more_text'] ) ? esc_html( $meta['tss_el_load_more_text'] ) : esc_html__( 'Load More', 'testimonial-slider-showcase' ),
				'imageType'           => ! empty( $meta['tss_el_image_type'] ) ? esc_attr( $meta['tss_el_image_type'] ) : 'cirle',
				'itemFields'          => TSSPro()->tssElContentVisibility( $meta ),
				'link'                => ! empty( $meta['tss_el_detail_page_link'] ) ? true : false,
				'postIn'              => ! empty( $meta['tss_el_include_posts'] ) ? implode( ', ', $meta['tss_el_include_posts'] ) : '',
				'postNotIn'           => ! empty( $meta['tss_el_exclude_posts'] ) ? implode( ', ', $meta['tss_el_exclude_posts'] ) : '',
				'postLimit'           => ! empty( $meta['tss_el_posts_limit'] ) ? absint( $meta['tss_el_posts_limit'] ) : '',
				'postOrderBy'         => $meta['tss_el_posts_order_by'],
				'postOrder'           => $meta['tss_el_posts_order'],
				'postPagination'      => ! empty( $meta['tss_el_pagination'] ) ? $meta['tss_el_pagination'] : '',
				'postsPerPage'        => ! empty( $meta['tss_el_pagination_per_page'] ) ? $meta['tss_el_pagination_per_page'] : 5,
				'postCategories'      => ! empty( $meta['tss_el_categories'] ) ? $meta['tss_el_categories'] : array(),
				'postTags'            => ! empty( $meta['tss_el_tags'] ) ? $meta['tss_el_tags'] : array(),
				'taxonomyRelation'    => ! empty( $meta['tss_el_taxonomy_relation'] ) ? esc_html( $meta['tss_el_taxonomy_relation'] ) : 'OR',
				'hasPagination'       => ! empty( $meta['tss_el_pagination'] ) ? true : false,
				'paginationType'      => ! empty( $meta['tss_el_pagination_type'] ) ? esc_html( $meta['tss_el_pagination_type'] ) : 'pagination',
				'smartSpeed'          => ! empty( $meta['tss_el_slide_speed'] ) ? absint( $meta['tss_el_slide_speed'] ) : 1000,
				'autoplayTimeout'     => ! empty( $meta['tss_el_autoplay_timeout'] ) ? absint( $meta['tss_el_autoplay_timeout'] ) : 5000,
				'cOpt'                => $this->sliderSettings( $meta ),
				'tItem'               => ! empty( $meta['tss_el_isotope_selected'] ) ? absint( $meta['tss_el_isotope_selected'] ) : null,
				'isotopeShowAll'      => ! empty( $meta['tss_el_isotope_show_all'] ) ? false : true,
				'isotopeSearchFilter' => ! empty( $meta['tss_el_isotope_search'] ) ? true : false,
				'isotopTooltip'       => ! empty( $meta['tss_el_isotope_tooltip'] ) ? true : false,
			);
		}

		public function renderThumbSlider( $query, $meta_value, $arg ) {
			$html = '';
			$cOpt = $this->sliderSettings( $meta_value );

			$cImageSize         = ! empty( $meta_value['tss_el_image_custom_dimension'] ) ? $meta_value['tss_el_image_custom_dimension'] : array();
			$cImageSize['crop'] = ! empty( $meta_value['tss_el_image_crop'] ) ? $meta_value['tss_el_image_crop'] : '';

			$customImgSize = ! empty( $cImageSize ) ? $cImageSize : array();
			$defaultImgId  = ! empty( $meta_value['tss_el_image_default_preview']['id'] ) ? absint( $meta_value['tss_el_image_default_preview']['id'] ) : null;
			$imgSize       = ! empty( $meta_value['tss_el_image'] ) ? sanitize_text_field( $meta_value['tss_el_image'] ) : 'medium';

			$rtl = '';

			$rtl = ( in_array( 'rtl', $cOpt ) ? 'dir="rtl"' : '' );

			$html     .= "<div {$rtl} class='tss-carousel-thumb swiper'>";
				$html .= '<div class="swiper-wrapper">';

			while ( $query->have_posts() ) :
				$query->the_post();

				$iID          = get_the_ID();
				$arg['iID']   = $iID;
				$arg['pLink'] = get_permalink();
				$lazyLoadP    = in_array( 'lazy_load', $cOpt ) ? true : false;

				if ( $lazyLoadP ) {
					$arg['lazyLoad'] = true;
					$arg['img']      = TSSPro()->getFeatureImage( $iID, $imgSize, $customImgSize, $defaultImgId, true );
				} else {
					$arg['lazyLoad'] = false;
					$arg['img']      = TSSPro()->getFeatureImage( $iID, $imgSize, $customImgSize, $defaultImgId );
				}

				$html .= TSSPro()->render( 'layouts/carousel_thumb', $arg );

			endwhile;

			$html .= '</div>';
			$html .= '</div>';

			return $html;
		}

		private function sliderSettings( $settings ) {
			$slider = array();

			if ( ! empty( $settings['tss_el_slider_loop'] ) ) {
				$slider[] = 'loop';
			}

			if ( ! empty( $settings['tss_el_slider_nav'] ) ) {
				$slider[] = 'nav';
			}

			if ( ! empty( $settings['tss_el_slider_pagi'] ) ) {
				$slider[] = 'dots';
			}

			if ( ! empty( $settings['tss_el_slider_auto_height'] ) ) {
				$slider[] = 'auto_height';
			}

			if ( ! empty( $settings['tss_el_slider_lazy_load'] ) ) {
				$slider[] = 'lazy_load';
			}

			if ( ! empty( $settings['tss_el_slider_rtl'] ) ) {
				$slider[] = 'rtl';
			}

			if ( ! empty( $settings['tss_el_slide_autoplay'] ) ) {
				$slider[] = 'autoplay';
			}

			if ( ! empty( $settings['tss_el_pause_hover'] ) ) {
				$slider[] = 'autoplayHoverPause';
			}

			return array_map( 'sanitize_text_field', $slider );
		}

		private function loadMoreArgs( $scMeta ) {
			$cImageSize         = ! empty( $scMeta['tss_el_image_custom_dimension'] ) ? $scMeta['tss_el_image_custom_dimension'] : array();
			$cImageSize['crop'] = ! empty( $scMeta['tss_el_image_crop'] ) ? $scMeta['tss_el_image_crop'] : '';

			$elData = array(
				'tss_layout'                => $scMeta['tss_el_layout_type'],
				'tss_desktop_column'        => $scMeta['tss_el_cols'],
				'tss_tab_column'            => isset( $meta['tss_el_cols_tablet'] ) && $meta['tss_el_cols_tablet'] != '' ? absint( $meta['tss_el_cols_tablet'] ) : 2,
				'tss_mobile_column'         => isset( $meta['tss_el_cols_mobile'] ) && $meta['tss_el_cols_mobile'] != '' ? absint( $meta['tss_el_cols_mobile'] ) : 1,
				'tss_image_size'            => $scMeta['tss_el_image'],
				'custom_img_size'           => ! empty( $cImageSize ) ? $cImageSize : array(),
				'default_image'             => ! empty( $scMeta['tss_el_image_default_preview']['id'] ) ? absint( $scMeta['tss_el_image_default_preview']['id'] ) : null,
				'tss_post__in'              => $scMeta['tss_el_include_posts'],
				'tss_post__not_in'          => $scMeta['tss_el_exclude_posts'],
				'tss_limit'                 => $scMeta['tss_el_posts_limit'],
				'tss_pagination'            => $scMeta['tss_el_pagination'],
				'tss_posts_per_page'        => $scMeta['tss_el_pagination_per_page'],
				'tss_categories'            => ! empty( $scMeta['tss_el_categories'] ) ? $scMeta['tss_el_categories'] : array(),
				'tss_tags'                  => ! empty( $scMeta['tss_el_tags'] ) ? $scMeta['tss_el_tags'] : array(),
				'tss_taxonomy_relation'     => ! empty( $scMeta['tss_el_taxonomy_relation'] ) ? $scMeta['tss_el_taxonomy_relation'] : '',
				'tss_order_by'              => $scMeta['tss_el_posts_order_by'],
				'tss_order'                 => $scMeta['tss_el_posts_order'],
				'tss_testimonial_limit'     => $scMeta['tss_el_testimonial_text_limit'],
				'tss_grid_style'            => ! empty( $scMeta['tss_el_grid_style'] ) ? $scMeta['tss_el_grid_style'] : '',
				'tss_read_more_button_text' => ! empty( $scMeta['tss_el_read_more_text'] ) ? $scMeta['tss_el_read_more_text'] : '',
				'tss_item_fields'           => TSSPro()->tssElContentVisibility( $scMeta ),
				'tss_share_fields'          => ! empty( $scMeta['tss_el_social_share_items'] ) ? $scMeta['tss_el_social_share_items'] : array(),
				'tss_detail_page_link'      => ! empty( $scMeta['tss_el_detail_page_link'] ) ? $scMeta['tss_el_detail_page_link'] : '',
			);

			return 'data-tss-elementor=\'' . wp_json_encode( $elData ) . '\'';
		}
	}
			endif;

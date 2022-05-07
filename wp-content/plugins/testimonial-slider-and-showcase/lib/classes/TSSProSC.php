<?php
if ( ! class_exists( 'TSSProSC' ) ) :
	/**
	 * Shortcode Class
	 */
	class TSSProSC {
		private $scA = array();

		function __construct() {
			add_shortcode( 'rt-testimonial', array( $this, 'testimonial_shortcode' ) );
		}

		function register_scripts() {
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

		function testimonial_shortcode( $atts ) {
			$rand     = mt_rand();
			$layoutID = 'tss-container-' . $rand;
			$html     = null;
			$arg      = array();
			$atts     = shortcode_atts(
				array(
					'id' => null,
				),
				$atts,
				'rt-testimonial'
			);
			$scID     = $atts['id'];
			if ( $scID && ! is_null( get_post( $scID ) ) ) {
				$scMeta        = get_post_meta( $scID );
				$buildMetas    = $this->metas( $scMeta, $scID );
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

				/* Argument create */
				$containerDataAttr  = false;
				$containerDataAttr .= " data-layout='{$layout}' data-desktop-col='{$dCol}'  data-tab-col='{$tCol}'  data-mobile-col='{$mCol}'";

				// Validation
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

				if ( $margin == 'no' ) {
					$arg['class'] .= ' no-margin';
				} else {
					$arg['class'] .= ' default-margin';
				}

				if ( $imageType == 'circle' ) {
					$arg['class'] .= ' tss-img-circle';
				}

				$arg['items']       = $itemFields;
				$arg['shareItems']  = array();
				$arg['anchorClass'] = null;
				$arg['link']        = $link ? true : false;

				// Start layout
				$html .= TSSPro()->layoutStyle( $layoutID, get_post_meta( $scID ), $scID );
				$html .= "<div class='rt-container-fluid tss-wrapper {$parentClass}' id='{$layoutID}' {$containerDataAttr}>";
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

						$html          .= '<div class="tss-iso-filter"><div id="iso-button-' . $rand . '" class="tss-isotope-button-wrapper tooltip-active filter-button-group">';
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
							$html .= $this->renderThumbSlider( $scID, $tssQuery, $scMeta, $arg );
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

						if ( $testi_limit ) {
							$arg['testimonial'] = TSSPro()->strip_tags_content( get_the_content(), $testi_limit, $aHtml );
						} else {
							$arg['testimonial'] = get_the_content();
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
						if ( 'grid' !== $scMeta['tss_layout'] ) {
							$html .= '</div>';

							$html .= 'true' === $nav ? '<div class="swiper-arrow swiper-button-next"><i class="fa fa-chevron-right"></i></div><div class="swiper-arrow swiper-button-prev"><i class="fa fa-chevron-left"></i></div>' : '';
							$html .= 'true' === $dots ? '<div class="swiper-pagination"></div>' : '';

							$html .= '</div>';

							$html .= '</div>'; // End Carousel item holder.

							if ( 'carousel12' === $layout ) {
								$html .= $this->renderThumbSlider( $scID, $tssQuery, $scMeta, $arg );
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

				if ( $hasPagination && ! $isCarousel ) {
					$htmlUtility = null;
					$postPp         = $tssQuery->query_vars['posts_per_page'];
					$page           = $tssQuery->query_vars['paged'];
					$foundPosts     = $tssQuery->found_posts;
					$morePosts      = $foundPosts - ( $postPp * $page );
					$totalPage      = $tssQuery->max_num_pages;
					$foundPost = $tssQuery->found_posts;

					if( $scMeta['tss_limit'][0] ){
						$range = $scMeta['tss_posts_per_page'][0];
						$foundPost = $tssQuery->found_posts;

						if($range && $foundPost > $range ){
							$foundPost = $scMeta['tss_limit'][0];
							$totalPage  = ceil( $foundPost / $range );
						}
					}

					$foundPosts = $foundPost;

					if ( $paginationType == 'pagination' ) {
						$htmlUtility .= TSSPro()->pagination( $totalPage, $postPp );
					} elseif ( $paginationType == 'pagination_ajax' && ! $isIsotope ) {
						$htmlUtility .= TSSPro()->pagination(
							$totalPage,
							$postPp,
							true,
							$scID
						);
					} elseif ( $paginationType == 'load_more' ) {
						$morePosts      = $foundPosts - ( $postPp * $page );
						$noMorePostText = esc_html__( 'No More Post to load', 'testimonial-slider-showcase' );
						$loadingText    = esc_html__( 'Loading ...', 'testimonial-slider-showcase' );
						$htmlUtility   .= "<div class='tss-load-more'>
                                        <span class='rt-button' data-sc-id='{$scID}' data-total-pages='{$totalPage}' data-posts-per-page='{$postPp}' data-found-posts='{$foundPosts}' data-paged='1'
                                        data-no-more-post-text='{$noMorePostText}' data-loading-text='{$loadingText}'>{$loadMore} <span>({$morePosts})</span></span>
                                    </div>";
					} elseif ( $paginationType == 'load_on_scroll' ) {
						$htmlUtility .= "<div class='tss-scroll-load-more' data-trigger='1' data-sc-id='{$scID}' data-paged='2'></div>";
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
			} else {
				$html .= '<p>' . esc_html__( 'No shortCode found', 'testimonial-slider-showcase' ) . '</p>';
			}

			return $html;
		}

		private function getItemsId( $itemIds ) {
			$html = null;
			if ( ! empty( $itemIds ) && is_array( $itemIds ) ) {
				$html .= "<span class='tlp-port-item-count'>";
				foreach ( $itemIds as $item ) {
					$html .= "<span>{$item}</span>";
				}
				$html .= '</span>';
			}

			return $html;
		}

		private function metas( array $meta, $pID = null ) {
			return array(
				'layout'              => ! empty( $meta['tss_layout'][0] ) ? esc_attr( $meta['tss_layout'][0] ) : 'layout1',
				'dCol'                => isset( $meta['tss_desktop_column'][0] ) && $meta['tss_desktop_column'][0] != '' ? absint( $meta['tss_desktop_column'][0] ) : 3,
				'tCol'                => isset( $meta['tss_tab_column'][0] ) && $meta['tss_tab_column'][0] != '' ? absint( $meta['tss_tab_column'][0] ) : 2,
				'mCol'                => isset( $meta['tss_mobile_column'][0] ) && $meta['tss_mobile_column'][0] != '' ? absint( $meta['tss_mobile_column'][0] ) : 1,
				'customImgSize'       => get_post_meta( $pID, 'tss_custom_image_size', true ),
				'defaultImgId'        => ! empty( $meta['default_preview_image'][0] ) ? absint( $meta['default_preview_image'][0] ) : null,
				'imgSize'             => ! empty( $meta['tss_image_size'][0] ) ? sanitize_text_field( $meta['tss_image_size'][0] ) : 'medium',
				'testi_limit'         => ! empty( $meta['tss_testimonial_limit'][0] ) ? absint( $meta['tss_testimonial_limit'][0] ) : null,
				'gridType'            => ! empty( $meta['tss_grid_style'][0] ) ? esc_attr( $meta['tss_grid_style'][0] ) : 'even',
				'readMore'            => ! empty( $meta['tss_read_more_button_text'][0] ) ? esc_html( $meta['tss_read_more_button_text'][0] ) : null,
				'loadMore'            => ! empty( $meta['tss_load_more_button_text'][0] ) ? esc_html( $meta['tss_load_more_button_text'][0] ) : esc_html__( 'Load More', 'testimonial-slider-showcase' ),
				'margin'              => ! empty( $meta['tss_margin'][0] ) ? esc_attr( $meta['tss_margin'][0] ) : 'default',
				'imageType'           => ! empty( $meta['tss_image_type'][0] ) ? esc_attr( $meta['tss_image_type'][0] ) : 'normal',
				'itemFields'          => ! empty( $meta['tss_item_fields'] ) ? array_map( 'sanitize_text_field', $meta['tss_item_fields'] ) : array(),
				'link'                => ! empty( $meta['tss_detail_page_link'][0] ) ? true : false,
				'parentClass'         => ! empty( $meta['tss_parent_class'][0] ) ? trim( $meta['tss_parent_class'][0] ) : null,
				'postIn'              => $meta['tss_post__in'][0],
				'postNotIn'           => $meta['tss_post__not_in'][0],
				'postLimit'           => $meta['tss_limit'][0],
				'postOrderBy'         => $meta['tss_order_by'][0],
				'postOrder'           => $meta['tss_order'][0],
				'postPagination'      => $meta['tss_pagination'][0],
				'postsPerPage'        => $meta['tss_posts_per_page'][0],
				'postCategories'      => $meta['tss_categories'],
				'postTags'            => $meta['tss_tags'],
				'taxonomyRelation'    => $meta['tss_taxonomy_relation'][0],
				'hasPagination'       => ! empty( $meta['tss_pagination'][0] ) ? true : false,
				'paginationType'      => ! empty( $meta['tss_pagination_type'][0] ) ? esc_html( $meta['tss_pagination_type'][0] ) : 'pagination',
				'smartSpeed'          => ! empty( $meta['tss_carousel_speed'][0] ) ? absint( $meta['tss_carousel_speed'][0] ) : 250,
				'autoplayTimeout'     => ! empty( $meta['tss_carousel_autoplay_timeout'][0] ) ? absint( $meta['tss_carousel_autoplay_timeout'][0] ) : 5000,
				'cOpt'                => ! empty( $meta['tss_carousel_options'] ) ? array_filter( $meta['tss_carousel_options'] ) : array(),
				'tItem'               => ! empty( $meta['tss_isotope_selected_filter'][0] ) ? absint( $meta['tss_isotope_selected_filter'][0] ) : null,
				'isotopeShowAll'      => ! empty( $meta['tss_isotope_filter_show_all'][0] ) ? true : false,
				'isotopeSearchFilter' => ! empty( $meta['tss_isotope_search_filtering'][0] ) ? true : false,
			);
		}

		public function renderThumbSlider( $scID, $query, $meta_value, $arg ) {
			$html = '';
			$cOpt = ! empty( $meta_value['tss_carousel_options'] ) ? array_filter( $meta_value['tss_carousel_options'] ) : array();

			$customImgSize = get_post_meta( $scID, 'tss_custom_image_size', true );
			$defaultImgId  = ( ! empty( $meta_value['default_preview_image'][0] ) ? absint( $meta_value['default_preview_image'][0] ) : null );
			$imgSize       = ( ! empty( $meta_value['tss_image_size'][0] ) ? sanitize_text_field( $meta_value['tss_image_size'][0] ) : 'medium' );

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
			$html     .= '</div>';

			return $html;
		}
	}
endif;

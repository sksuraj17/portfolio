<?php

if (!class_exists('TSSPreview')):

    class TSSPreview
    {

        function __construct() {
            add_action('wp_ajax_tssPreviewAjaxCall', array($this, 'tssPreviewAjaxCall'));
            add_action('wp_ajax_pfpLoadMorePreview', array($this, 'pfpLoadMorePreview'));
        }

        function tssPreviewAjaxCall() {
            $msg = $html = $scID = null;
            $error = true;
            if (TSSPro()->verifyNonce()) {
                $error = false;
                $scMeta = $_REQUEST;
                $rand = mt_rand();
                $layoutID = "rt-container-" . $rand;
                $layout = (!empty($scMeta['tss_layout']) ? esc_attr( $scMeta['tss_layout'] ) : 'layout1');
                $dCol = (isset($scMeta['tss_desktop_column']) ? absint($scMeta['tss_desktop_column']) : 3);
                $tCol = (isset($scMeta['tss_tab_column']) ? absint($scMeta['tss_tab_column']) : 2);
                $mCol = (isset($scMeta['tss_mobile_column']) ? absint($scMeta['tss_mobile_column']) : 1);
                if (!in_array($dCol, array_keys(TSSPro()->scColumns()))) {
                    $dCol = 3;
                }
                if (!in_array($tCol, array_keys(TSSPro()->scColumns()))) {
                    $tCol = 2;
                }
                if (!in_array($dCol, array_keys(TSSPro()->scColumns()))) {
                    $mCol = 1;
                }
                $dColItems = $dCol;
                $tColItems = $tCol;
                $mColItems = $mCol;

                $customImgSize = get_post_meta($scID, 'tss_custom_image_size', true);
                $imgSize = (!empty($scMeta['tss_image_size']) ? esc_attr( $scMeta['tss_image_size'] ) : "medium");
                $defaultImgId = (!empty($scMeta['default_preview_image']) ? absint($scMeta['default_preview_image']) : null);

                $isIsotope = preg_match('/isotope/', $layout);
                $isCarousel = preg_match('/carousel/', $layout);

                /* Argument create */
                $containerDataAttr = false;
                $args = array();
                $args['post_type'] = [ TSSPro()->post_type ];
                // Common filter
                /* post__in */
                $post__in = (isset($scMeta['tss_post__in']) ? sanitize_text_field(  $scMeta['tss_post__in'] ) : null);
                if ($post__in) {
                    $post__in = explode(',', $post__in);
                    $args['post__in'] = $post__in;
                }
                /* post__not_in */
                $post__not_in = (isset($scMeta['tss_post__not_in']) ? sanitize_text_field( $scMeta['tss_post__not_in'] ) : null);
                if ($post__not_in) {
                    $post__not_in = explode(',', $post__not_in);
                    $args['post__not_in'] = $post__not_in;
                }
                /* LIMIT */
                $limit = ((empty($scMeta['tss_limit']) || $scMeta['tss_limit'] === '-1') ? 10000000 : (int)$scMeta['tss_limit']);
                $args['posts_per_page'] = $limit;
                $pagination = (!empty($scMeta['tss_pagination']) ? true : false);
                $posts_loading_type = (!empty($scMeta['tss_pagination_type']) ? sanitize_text_field( $scMeta['tss_pagination_type'] ) : "pagination");
                if ( $pagination ) {
                    $posts_per_page = (isset($scMeta['tss_posts_per_page']) ? intval($scMeta['tss_posts_per_page']) : $limit);
                    if ($posts_per_page > $limit) {
                        $posts_per_page = $limit;
                    }
                    // Set 'posts_per_page' parameter
                    $args['posts_per_page'] = $posts_per_page;

                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                    $offset = $posts_per_page * ((int)$paged - 1);
                    $args['paged'] = $paged;

                    // Update posts_per_page
                    if (intval($args['posts_per_page']) > $limit - $offset) {
                        $args['posts_per_page'] = $limit - $offset;
                    }

                }
                if ($isCarousel) {
                    $args['posts_per_page'] = $limit;
                }

                // Taxonomy
                $cats = (isset($scMeta['tss_categories']) ? array_filter($scMeta['tss_categories']) : array());
                $tags = (isset($scMeta['tss_tags']) ? array_filter($scMeta['tss_tags']) : array());
                $taxQ = array();
                if (is_array($cats) && !empty($cats)) {
                    $taxQ[] = array(
                        'taxonomy' => TSSPro()->taxonomies['category'],
                        'field'    => 'term_id',
                        'terms'    => $cats,
                    );
                }
                if (is_array($tags) && !empty($tags)) {
                    $taxQ[] = array(
                        'taxonomy' => TSSPro()->taxonomies['tag'],
                        'field'    => 'term_id',
                        'terms'    => $tags,
                    );
                }
                if (!empty($taxQ)) {
                    $args['tax_query'] = $taxQ;
                    if (count($taxQ) > 1) {
                        $taxQ['relation'] = !empty($scFMeta['tss_taxonomy_relation']) ? esc_attr( $scFMeta['tss_taxonomy_relation'] ) : "AND";
                    }
                }


                // Order
                $order_by = (isset($scMeta['tss_order_by']) ? esc_attr( $scMeta['tss_order_by'] ) : null);
                $order = (isset($scMeta['tss_order']) ? esc_attr($scMeta['tss_order']) : null);
                if ($order) {
                    $args['order'] = $order;
                }
                if ($order_by) {
                    $args['orderby'] = $order_by;
                }

                $testi_limit = !empty($scMeta['tss_testimonial_limit']) ? absint($scMeta['tss_testimonial_limit']) : null;
                // Validation
                $containerDataAttr .= " data-layout='{$layout}' data-desktop-col='{$dCol}'  data-tab-col='{$tCol}'  data-mobile-col='{$mCol}'";
                $dCol = round(12 / $dCol);
                $tCol = round(12 / $tCol);
                $mCol = round(12 / $mCol);
                if ($isCarousel) {
                    $dCol = $tCol = $mCol = 12;
                }
                $arg = array();
                $arg['scMeta'] = $scMeta;
                $arg['grid'] = "rt-col-md-{$dCol} rt-col-sm-{$tCol} rt-col-xs-{$mCol}";
                $gridType = !empty($scMeta['tss_grid_style']) ? esc_attr($scMeta['tss_grid_style']) : 'even';
                $arg['read_more'] = !empty($scMeta['tss_read_more_button_text']) ? esc_attr($scMeta['tss_read_more_button_text']) : null;
                $arg['class'] = $gridType . "-grid-item";
                $arg['class'] .= " tss-grid-item";
                $preLoader = null;
                if ($isIsotope) {
                    $arg['class'] .= ' isotope-item';
                    $preLoader = 'tss-pre-loader';
                }
                if ($isCarousel) {
                    $arg['class'] .= ' slide-item swiper-slide';
                    $preLoader = 'tss-pre-loader';
                }
                $masonryG = null;
                if ($gridType == "even") {
                    $masonryG = " tss-even";
                    $arg['class'] .= ' even-grid-item';
                } else if ($gridType == "masonry" && !$isIsotope && !$isCarousel) {
                    $masonryG = " tss-masonry";
                    $arg['class'] .= ' masonry-grid-item';
                }
                $image_type = !empty($scMeta['tss_image_type']) ? esc_attr( $scMeta['tss_image_type'] ) : 'normal';
                if ($image_type == 'circle') {
                    $arg['class'] .= ' tss-img-circle';
                }

                $margin = !empty($scMeta['tss_margin']) ? esc_attr( $scMeta['tss_margin'] ) : 'default';
                if ($margin == 'no') {
                    $arg['class'] .= ' no-margin';
                } else {
                    $arg['class'] .= ' default-margin';
                }

                $image_shape = !empty($scMeta['tss_image_shape']) ? esc_attr($scMeta['tss_image_shape']) : null;
                if ($image_shape == 'circle') {
                    $arg['class'] .= ' tss-img-circle';
                }

                $arg['items'] = !empty($scMeta['tss_item_fields']) ? array_map( 'sanitize_text_field', $scMeta['tss_item_fields'] ) : array();
                $arg['anchorClass'] = null;
                $link = !empty($scMeta['tss_detail_page_link']) ? true : false;
                $arg['link'] = $link ? true : false;

                $parentClass = (!empty($scMeta['tss_parent_class']) ? trim($scMeta['tss_parent_class']) : null);

                $args['post_status'] = 'publish';
                if (is_user_logged_in() && is_super_admin()) {
                    $args['post_status'] = array('publish', 'private');
                }

                // Start layout
                $html .= TSSPro()->layoutStyle($layoutID, $scMeta);
                $html .= "<div class='rt-container-fluid tss-wrapper {$parentClass}' id='{$layoutID}' {$containerDataAttr}>";
                $html .= "<div data-title='" . esc_html__("Loading ...", 'testimonial-slider-showcase') . "' class='rt-row tss-{$layout}{$masonryG} {$preLoader}'>";

                $tssQuery = new WP_Query($args);
                if ($tssQuery->have_posts()) {
                    if ($isIsotope) {
                        $terms = get_terms(array(
                            'taxonomy'   => TSSPro()->taxonomies['category'],
                            'hide_empty' => false,
                            'orderby'    => 'meta_value_num',
                            'order'      => 'ASC',
                            'meta_key'   => '_order'
                        ));

                        $html .= '<div class="tss-iso-filter"><div id="iso-button-' . $rand . '" class="tss-isotope-button-wrapper tooltip-active filter-button-group">';
                        $htmlButton = null;
                        $fSelectTrigger = false;
                        if (!empty($terms) && !is_wp_error($terms)) {
                            foreach ($terms as $term) {
                                $tItem = !empty($scMeta['tss_isotope_selected_filter'][0]) ? absint($scMeta['tss_isotope_selected_filter'][0]) : null;
                                $fSelect = null;
                                if ($tItem == $term->term_id) {
                                    $fSelect = ' selected';
                                    $fSelectTrigger = true;
                                }
                                $htmlButton .= "<span class='rt-iso-button {$fSelect}' data-filter-counter='' data-filter='.iso_{$term->term_id}' {$fSelect}>" . $term->name . "</span>";
                            }
                        }
                        if (empty($scMeta['tss_isotope_filter_show_all'][0])) {
                            $fSelect = ($fSelectTrigger ? null : 'class="selected"');
                            $html .= "<span class='rt-iso-button' data-filter-counter='' data-filter='*' {$fSelect}>" . esc_html__('Show all',
                                    'testimonial-slider-showcase') . "</span>";
                        }
                        $html .= $htmlButton;
                        $html .= '</div>';
                        if (!empty($scMeta['tss_isotope_search_filtering'][0])) {
                            $html .= "<div class='iso-search'><input type='text' class='iso-search-input' placeholder='" . esc_html__('Search', 'testimonial-slider-showcase') . "' /></div>";
                        }
                        $html .= '</div>';

                        $html .= '<div class="tss-isotope" id="tss-isotope-' . $rand . '">';
                    } elseif ($isCarousel) {
						$smartSpeed         = ! empty( $scMeta['tss_carousel_speed'] ) ? absint( $scMeta['tss_carousel_speed'] ) : 250;
						$autoplayTimeout    = ! empty( $scMeta['tss_carousel_autoplay_timeout'] ) ? absint( $scMeta['tss_carousel_autoplay_timeout'] ) : 5000;
						$cOpt               = ! empty( $scMeta['tss_carousel_options'] ) ? array_filter( $scMeta['tss_carousel_options'] ) : array();
						$autoPlay           = ( in_array( 'autoplay', $cOpt ) ? 'true' : 'false' );
						$autoPlayHoverPause = ( in_array( 'autoplayHoverPause', $cOpt ) ? 'true' : 'false' );
						$nav                = ( in_array( 'nav', $cOpt ) ? 'true' : 'false' );
						$dots               = ( in_array( 'dots', $cOpt ) ? 'true' : 'false' );
						$loop               = ( in_array( 'loop', $cOpt ) ? 'true' : 'false' );
						$lazyLoad           = ( in_array( 'lazy_load', $cOpt ) ? 'true' : 'false' );
						$lazyLoadP           = ( in_array( 'lazy_load', $cOpt ) ? true : false );
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

                    while ($tssQuery->have_posts()) : $tssQuery->the_post();
                        $iID = get_the_ID();
                        $arg['iID'] = $iID;
                        $arg['author'] = get_the_title();
                        $arg['designation'] = get_post_meta($iID, 'tss_designation', true);
                        $arg['company'] = get_post_meta($iID, 'tss_company', true);
                        $arg['location'] = get_post_meta($iID, 'tss_location', true);
                        $arg['rating'] = get_post_meta($iID, 'tss_rating', true);
                        $arg['video'] = get_post_meta($iID, 'tss_video', true);
                        $arg['social_media'] = get_post_meta($iID, 'tss_social_media', true);
                        $arg['pLink'] = get_permalink();
                        $aHtml = null;
                        if (in_array('read_more', $arg['items']) && function_exists('rttsp') ) {
                            $aHtml = "<a class='rt-read-more' href='" . esc_url($arg['pLink']) . "'>{$arg['read_more']}</a>";
                        }
                        $arg['testimonial'] = get_the_content();
                        if ($testi_limit) {
                            $arg['testimonial'] = TSSPro()->strip_tags_content(get_the_content(), $testi_limit, $aHtml);
                        }
                        if ($isIsotope) {
                            $termAs = wp_get_post_terms($iID, TSSPro()->taxonomies['category'],
                                array("fields" => "all"));
                            $isoFilter = null;
                            if (!empty($termAs)) {
                                foreach ($termAs as $term) {
                                    $isoFilter .= " " . "iso_" . $term->term_id;
                                    $isoFilter .= " " . $term->slug;
                                }
                            }
                            $arg['isoFilter'] = $isoFilter;
                        }
                        // $arg['img'] = TSSPro()->getFeatureImage($iID, $imgSize, $customImgSize, $defaultImgId);
						if ( $lazyLoadP ) {
							$arg['lazyLoad'] = true;
							$arg['img'] = TSSPro()->getFeatureImage( $iID, $imgSize, $customImgSize, $defaultImgId, true );
						} else {
							$arg['lazyLoad'] = false;
							$arg['img'] = TSSPro()->getFeatureImage( $iID, $imgSize, $customImgSize, $defaultImgId );
						}

                        $html .= TSSPro()->render('layouts/' . $layout, $arg);

                    endwhile;

					if ( $isIsotope ) {
						$html .= '</div>'; // End isotope
					} elseif ( $isCarousel ) {
						if( 'grid' !==  $scMeta['tss_layout'] ) {
							$html .= '</div>';

							$html .= 'true' === $nav ? '<div class="swiper-arrow swiper-button-next"><i class="fa fa-chevron-right"></i></div><div class="swiper-arrow swiper-button-prev"><i class="fa fa-chevron-left"></i></div>' : '';
							$html .= 'true' === $dots ? '<div class="swiper-pagination"></div>' : '';

							$html .= '</div>';

							$html .= '</div>'; // End Carousel item holder

							if ( 'carousel12' === $layout ) {
								$html .= $this->renderThumbSlider( $scID, $tssQuery, $scMeta, $arg );
							}
						}
					}
                } else {
                    $html .= "<p>" . esc_html__("No testimonial found", 'testimonial-slider-showcase') . "</p>";
                }
                if ($isIsotope || $isCarousel) {
                    $html .= '<div class="rt-loading-overlay"></div><div class="rt-loading rt-ball-clip-rotate"><div></div></div>';
                }
                $html .= "</div>"; // End row
//				$html .= $this->getItemsId( $itemIds );

                if ($pagination && !$isCarousel) {
                    $htmlUtility = null;
                    if ($posts_loading_type == "pagination") {
                        $htmlUtility .= TSSPro()->pagination($tssQuery->max_num_pages, $args['posts_per_page']);
                    } elseif ($posts_loading_type == "pagination_ajax" && !$isIsotope) {
                        $htmlUtility .= TSSPro()->pagination($tssQuery->max_num_pages, $args['posts_per_page'], true,
                            $scID);
                    } elseif ($posts_loading_type == "load_more") {
                        $postPp = $tssQuery->query_vars['posts_per_page'];
                        $page = $tssQuery->query_vars['paged'];
                        $foundPosts = $tssQuery->found_posts;
                        $totalPage = $tssQuery->max_num_pages;
                        $morePosts = $foundPosts - ($postPp * $page);
                        $noMorePostText = esc_html__("No More Post to load", 'testimonial-slider-showcase');
                        $loadMoreText = esc_html__('Load More', 'testimonial-slider-showcase');
                        $loadingText = esc_html__('Loading ...', 'testimonial-slider-showcase');
                        $htmlUtility .= "<div class='tss-load-more'>
                                        <span class='rt-button' data-sc-id='{$scID}' data-total-pages='{$totalPage}' data-posts-per-page='{$postPp}' data-found-posts='{$foundPosts}' data-paged='1'
                                        data-no-more-post-text='{$noMorePostText}' data-loading-text='{$loadingText}'>{$loadMoreText} <span>({$morePosts})</span></span>
                                    </div>";
                    } elseif ($posts_loading_type == "load_on_scroll") {
                        $htmlUtility .= "<div class='tss-scroll-load-more' data-trigger='1' data-sc-id='{$scID}' data-paged='2'></div>";
                    }

                    if ($htmlUtility) {
                        $html .= "<div class='tss-utility'>" . $htmlUtility . "</div>";
                    }

                }

                $html .= "</div>"; // container
                wp_reset_postdata();

            } else {
                $msg = esc_html__('Security Error !!', 'testimonial-slider-showcase');
            }

            wp_send_json(array(
                'error' => $error,
                'msg'   => $msg,
                'data'  => $html
            ));

        }

        function pfpLoadMorePreview() {
            global $TLPpPro;
            $error = true;
            $msg = $data = null;
            if ($TLPpPro->verifyNonce()) {
                $scMeta = $_REQUEST;
                $layout = (!empty($scMeta['tss_layout']) ? esc_attr( $scMeta['tss_layout'] ) : 'layout1');
                if (!in_array($layout, array_keys($TLPpPro->scLayout()))) {
                    $layout = 'layout1';
                }
                $dCol = (isset($scMeta['pfp_desktop_column']) ? absint($scMeta['pfp_desktop_column']) : 3);
                $tCol = (isset($scMeta['pfp_tab_column']) ? absint($scMeta['pfp_tab_column']) : 2);
                $mCol = (isset($scMeta['pfp_mobile_column']) ? absint($scMeta['pfp_mobile_column']) : 1);
                if (!in_array($dCol, array_keys($TLPpPro->scColumns()))) {
                    $dCol = 3;
                }
                if (!in_array($tCol, array_keys($TLPpPro->scColumns()))) {
                    $tCol = 2;
                }
                if (!in_array($dCol, array_keys($TLPpPro->scColumns()))) {
                    $mCol = 1;
                }
                $customImgSize = (!empty($scMeta['tss_custom_image_size']) ? esc_attr( $scMeta['tss_custom_image_size'] ) : array());
                $defaultImgId = (!empty($scMeta['default_preview_image']) ? absint($scMeta['default_preview_image']) : null);
                $imgSize = (!empty($scMeta['pfp_image_size']) ? esc_attr( $scMeta['pfp_image_size'] ) : "medium");
                $excerpt_limit = (!empty($scMeta['pfp_excerpt_limit']) ? absint($scMeta['pfp_excerpt_limit']) : 0);


                if ($dCol == 2) {
                    $image_area = "pfp-col-md-5 pfp-col-lg-5 pfp-col-sm-6 paddingl0";
                    $content_area = "pfp-col-md-7 pfp-col-lg-7 pfp-col-sm-6 paddingr0";
                } else {
                    $image_area = "pfp-col-md-3 pfp-col-lg-3 pfp-col-sm-12 paddingl0";
                    $content_area = "pfp-col-md-9 pfp-col-lg-9 pfp-col-sm-12 paddingr0";
                }

                $isIsotope = preg_match('/isotope/', $layout);
                $isCarousel = preg_match('/carousel/', $layout);

                /* Argument create */
                $containerDataAttr = false;
                $args = array();
                $args['post_type'] = [ $TLPpPro->post_type ];
                // Common filter
                /* post__in */
                $post__in = (isset($scMeta['pfp_post__in']) ? sanitize_text_field($scMeta['pfp_post__in']) : null);
                if ($post__in) {
                    $post__in = explode(',', $post__in);
                    $args['post__in'] = $post__in;
                }
                /* post__not_in */
                $post__not_in = (isset($scMeta['pfp_post__not_in']) ? sanitize_text_field($scMeta['pfp_post__not_in']) : null);
                if ($post__not_in) {
                    $post__not_in = explode(',', $post__not_in);
                    $args['post__not_in'] = $post__not_in;
                }

                /* LIMIT */
                $limit = ((empty($scMeta['pfp_limit']) || $scMeta['pfp_limit'] === '-1') ? 10000000 : (int)$scMeta['pfp_limit']);
                $args['posts_per_page'] = $limit;
                $pagination = (!empty($scMeta['pfp_pagination']) ? true : false);

                if ($pagination) {
                    $posts_per_page = (isset($scMeta['pfp_posts_per_page']) ? intval($scMeta['pfp_posts_per_page']) : $limit);
                    if ($posts_per_page > $limit) {
                        $posts_per_page = $limit;
                    }
                    // Set 'posts_per_page' parameter
                    $args['posts_per_page'] = $posts_per_page;

                    $paged = (!empty($_REQUEST['paged'])) ? absint($_REQUEST['paged']) : 2;

                    $offset = $posts_per_page * ((int)$paged - 1);
                    $args['paged'] = $paged;

                    // Update posts_per_page
                    if (intval($args['posts_per_page']) > $limit - $offset) {
                        $args['posts_per_page'] = $limit - $offset;
                    }
                }

                $cats = (isset($scMeta['pfp_categories']) ? array_filter($scMeta['pfp_categories']) : array());
                $tags = (isset($scMeta['pfp_tags']) ? array_filter($scMeta['pfp_tags']) : array());
                $tools = (isset($scMeta['pfp_tools']) ? array_filter($scMeta['pfp_tools']) : array());
                $taxQ = array();
                if (is_array($cats) && !empty($cats)) {
                    $taxQ[] = array(
                        'taxonomy' => $TLPpPro->taxonomies['category'],
                        'field'    => 'term_id',
                        'terms'    => $cats,
                    );
                }
                if (is_array($tags) && !empty($tags)) {
                    $taxQ[] = array(
                        'taxonomy' => $TLPpPro->taxonomies['tag'],
                        'field'    => 'term_id',
                        'terms'    => $tags,
                    );
                }
                if (is_array($tools) && !empty($tools)) {
                    $taxQ[] = array(
                        'taxonomy' => $TLPpPro->taxonomies['tool'],
                        'field'    => 'term_id',
                        'terms'    => $tools,
                    );
                }
                if (!empty($taxQ)) {
                    $args['tax_query'] = $taxQ;
                    if (count($taxQ) > 1) {
                        $taxQ['relation'] = !empty($scFMeta['pfp_taxonomy_relation']) ? esc_attr($scFMeta['pfp_taxonomy_relation']) : "AND";
                    }
                }

                // Order
                $order_by = (isset($scMeta['pfp_order_by']) ? esc_attr($scMeta['pfp_order_by']) : null);
                $order = (isset($scMeta['pfp_order']) ? esc_attr($scMeta['pfp_order']) : null);
                if ($order) {
                    $args['order'] = $order;
                }
                if ($order_by) {
                    if ($order_by == "price") {
                        $args['orderby'] = 'meta_value_num';
                        $args['meta_key'] = '_price';
                    } else {
                        $args['orderby'] = $order_by;
                    }
                }

                // Validation
                $dCol = round(12 / $dCol);
                $tCol = round(12 / $tCol);
                $mCol = round(12 / $mCol);
                if ($isCarousel) {
                    $dCol = $tCol = $mCol = 12;
                }

                $arg['grid'] = "pfp-col-lg-{$dCol} pfp-col-md-{$dCol} pfp-col-sm-{$tCol} pfp-col-xs-{$mCol}";
                $gridType = !empty($scMeta['pfp_grid_style']) ? esc_attr( $scMeta['pfp_grid_style'] ) : 'even';
                $arg['read_more'] = !empty($scMeta['pfp_read_more_button_text']) ? esc_attr($scMeta['pfp_read_more_button_text']) : null;
                $arg['class'] = $gridType . "-grid-item";
                $arg['class'] .= " pfp-grid-item";
                if ($isIsotope) {
                    $arg['class'] .= ' isotope-item';
                }
                if ($isCarousel) {
                    $arg['class'] .= ' slide-item';
                }
                if ($gridType == "even") {
                    $arg['class'] .= ' even-grid-item';
                } else if ($gridType == "masonry" && !$isIsotope && !$isCarousel) {
                    $arg['class'] .= ' masonry-grid-item';
                }

                $image_shape = !empty($scMeta['pfp_image_shape']) ? esc_attr( $scMeta['pfp_image_shape'] ) : null;
                if ($image_shape == 'circle') {
                    $arg['class'] .= ' pfp-img-circle';
                }

                $margin = !empty($scMeta['pfp_margin']) ? esc_attr( $scMeta['pfp_margin'] ) : 'default';
                if ($margin == 'no') {
                    $arg['class'] .= ' no-margin';
                } else {
                    $arg['class'] .= ' default-margin';
                }

                $arg['items'] = !empty($scMeta['pfp_item_fields']) ? array_map( 'sanitize_text_field', $scMeta['pfp_item_fields'] ) : array();
                $arg['anchorClass'] = null;
                $link = !empty($scMeta['pfp_detail_page_link']) ? true : false;
                $popup = !empty($scMeta['pfp_single_popup']) ? true : false;
                if ($link) {
                    if ($popup) {
                        $arg['anchorClass'] .= ' pfp-popup tlp-single-item-popup';
                    }
                    $arg['link'] = true;
                } else {
                    $arg['link'] = false;
                    $arg['anchorClass'] .= ' pfp-disable';
                }

                $portQuery = new WP_Query($args);
                // Start layout
                if ($portQuery->have_posts()) {

                    while ($portQuery->have_posts()) {
                        $portQuery->the_post();

                        $iID = get_the_ID();
                        $arg['iID'] = $iID;
                        $arg['title'] = get_the_title();
                        $arg['image_area'] = $image_area;
                        $arg['content_area'] = $content_area;
                        $arg['client_name'] = get_post_meta($iID, 'client_name', true);
                        $arg['completed_date'] = get_post_meta($iID, 'completed_date', true);
                        $arg['short_desc'] = get_post_meta($iID, 'short_description', true);
                        $arg['short_desc'] = $TLPpPro->strip_tags_content($arg['short_desc'], $excerpt_limit);
                        $arg['project_url'] = get_post_meta($iID, 'project_url', true);
                        $arg['tools'] = strip_tags(get_the_term_list($iID, $TLPpPro->taxonomies['tool'], null, ' | '));
                        $arg['categories'] = strip_tags(get_the_term_list($iID, $TLPpPro->taxonomies['category'], null, ','));
                        $arg['tags'] = strip_tags(get_the_term_list($iID, $TLPpPro->taxonomies['tag'], null, ','));
                        $arg['pLink'] = get_permalink();
                        if ($isIsotope) {
                            $termAs = wp_get_post_terms($iID, $TLPpPro->taxonomies['category'],
                                array("fields" => "all"));
                            $isoFilter = null;
                            if (!empty($termAs)) {
                                foreach ($termAs as $term) {
                                    $isoFilter .= " " . "iso_" . $term->term_id;
                                    $isoFilter .= " " . $term->slug;
                                }
                            }
                            $arg['isoFilter'] = $isoFilter;
                        }
                        $arg['img'] = $TLPpPro->getFeatureImage($iID, $imgSize, $customImgSize, $defaultImgId);
                        $data .= $TLPpPro->render('layouts/' . $layout, $arg);

                    }
                    if (!empty($data)) {
                        $error = false;
                    }

                } else {
                    $msg = esc_html__('No More Post to load', 'testimonial-slider-showcase');
                }
                wp_reset_postdata();

            } else {
                $msg = esc_html__('Security Error !!', 'testimonial-slider-showcase');
            }
            wp_send_json(array(
                'error' => $error,
                'msg'   => $msg,
                'data'  => $data
            ));
            die();

        }

		public function renderThumbSlider($scID, $query, $meta_value, $arg) {
			$html = '';
			$cOpt = ! empty( $meta_value['tss_carousel_options'] ) ? array_filter( $meta_value['tss_carousel_options'] ) : array();

			$customImgSize = get_post_meta( $scID, 'tss_custom_image_size', true );
			$defaultImgId  = ( ! empty( $meta_value['default_preview_image'] ) ? absint( $meta_value['default_preview_image'] ) : null );
			$imgSize       = ( ! empty( $meta_value['tss_image_size'] ) ? sanitize_text_field( $meta_value['tss_image_size'] ) : 'medium' );

			$rtl  = ( in_array( 'rtl', $cOpt ) ? 'dir="rtl"' : '' );

			$html .= "<div {$rtl} class='tss-carousel-thumb swiper'>";
				$html .= '<div class="swiper-wrapper">';

				while ( $query->have_posts() ) :
					$query->the_post();
					$iID                 = get_the_ID();
					$arg['iID']          = $iID;
					$arg['pLink']        = get_permalink();
					$lazyLoadP           = in_array( 'lazy_load', $cOpt ) ? true : false;

					if ( $lazyLoadP ) {
						$arg['lazyLoad'] = true;
						$arg['img'] = TSSPro()->getFeatureImage( $iID, $imgSize, $customImgSize, $defaultImgId, true );
					} else {
						$arg['lazyLoad'] = false;
						$arg['img'] = TSSPro()->getFeatureImage( $iID, $imgSize, $customImgSize, $defaultImgId );
					}

					$html      .= TSSPro()->render( 'layouts/carousel_thumb', $arg );

				endwhile;


				$html .= '</div>';
			$html .= '</div>';

			return $html;
		}
    }

endif;

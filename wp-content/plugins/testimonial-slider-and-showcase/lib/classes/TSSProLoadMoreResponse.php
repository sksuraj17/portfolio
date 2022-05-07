<?php

if ( ! class_exists( 'TSSProLoadMoreResponse' ) ) :

	class TSSProLoadMoreResponse {

		public function __construct() {
			add_action( 'wp_ajax_tssLoadMore', array( $this, 'tssLoadMore' ) );
			add_action( 'wp_ajax_nopriv_tssLoadMore', array( $this, 'tssLoadMore' ) );
		}

		function tssLoadMore() {
			$error = true;
			$msg   = $data = null;
			if ( TSSPro()->verifyNonce() ) {
				$scID = intval( $_REQUEST['scID'] );
				if ( $scID && ! is_null( get_post( $scID ) ) ) {
					$scMeta = get_post_meta( $scID );
					$layout = ( ! empty( $scMeta['tss_layout'][0] ) ? esc_attr( $scMeta['tss_layout'][0] ) : 'layout1' );
					/*
					 if ( ! in_array( $layout, array_keys( TSSPro()->scLayout() ) ) ) {
						$layout = 'layout1';
					} */
					$dCol = ( isset( $scMeta['tss_desktop_column'][0] ) ? absint( $scMeta['tss_desktop_column'][0] ) : 3 );
					$tCol = ( isset( $scMeta['tss_tab_column'][0] ) ? absint( $scMeta['tss_tab_column'][0] ) : 2 );
					$mCol = ( isset( $scMeta['tss_mobile_column'][0] ) ? absint( $scMeta['tss_mobile_column'][0] ) : 1 );
					if ( ! in_array( $dCol, array_keys( TSSPro()->scColumns() ) ) ) {
						$dCol = 3;
					}
					if ( ! in_array( $tCol, array_keys( TSSPro()->scColumns() ) ) ) {
						$tCol = 2;
					}
					if ( ! in_array( $dCol, array_keys( TSSPro()->scColumns() ) ) ) {
						$mCol = 1;
					}

					$customImgSize = get_post_meta( $scID, 'tss_custom_image_size', true );
					$imgSize       = ( ! empty( $scMeta['tss_image_size'][0] ) ? esc_attr( $scMeta['tss_image_size'][0] ) : 'medium' );
					$excerpt_limit = ( ! empty( $scMeta['tss_excerpt_limit'][0] ) ? absint( $scMeta['tss_excerpt_limit'][0] ) : 0 );

					$isIsotope  = preg_match( '/isotope/', $layout );
					$isCarousel = preg_match( '/carousel/', $layout );

					/* Argument create */
					$args              = array();
					$args['post_type'] = array( TSSPro()->post_type );
					// Common filter
					/* post__in */
					$post__in = ( isset( $scMeta['tss_post__in'][0] ) ? sanitize_text_field( $scMeta['tss_post__in'][0] ) : null );
					if ( $post__in ) {
						$post__in         = explode( ',', $post__in );
						$args['post__in'] = $post__in;
					}
					/* post__not_in */
					$post__not_in = ( isset( $scMeta['tss_post__not_in'][0] ) ? sanitize_text_field( $scMeta['tss_post__not_in'][0] ) : null );
					if ( $post__not_in ) {
						$post__not_in         = explode( ',', $post__not_in );
						$args['post__not_in'] = $post__not_in;
					}
					/* LIMIT */
					$limit                  = ( ( empty( $scMeta['tss_limit'][0] ) || $scMeta['tss_limit'][0] === '-1' ) ? 10000000 : (int) $scMeta['tss_limit'][0] );
					$args['posts_per_page'] = $limit;
					$pagination             = ( ! empty( $scMeta['tss_pagination'][0] ) ? true : false );
					if ( $pagination ) {
						$posts_per_page = ( isset( $scMeta['tss_posts_per_page'][0] ) ? intval( $scMeta['tss_posts_per_page'][0] ) : $limit );
						if ( $posts_per_page > $limit ) {
							$posts_per_page = $limit;
						}
						// Set 'posts_per_page' parameter
						$args['posts_per_page'] = $posts_per_page;

						$paged = ( ! empty( $_REQUEST['paged'] ) ) ? absint( $_REQUEST['paged'] ) : 2;

						$offset        = $posts_per_page * ( (int) $paged - 1 );
						$args['paged'] = $paged;

						// Update posts_per_page
						if ( intval( $args['posts_per_page'] ) > $limit - $offset ) {
							$args['posts_per_page'] = $limit - $offset;
						}
					}

					if ( $isCarousel ) {
						$args['posts_per_page'] = $limit;
					}

					// Taxonomy
					$cats = ( isset( $scMeta['tss_categories'] ) ? array_filter( $scMeta['tss_categories'] ) : array() );
					$tags = ( isset( $scMeta['tss_tags'] ) ? array_filter( $scMeta['tss_tags'] ) : array() );
					$taxQ = array();
					if ( is_array( $cats ) && ! empty( $cats ) ) {
						$taxQ[] = array(
							'taxonomy' => TSSPro()->taxonomies['category'],
							'field'    => 'term_id',
							'terms'    => $cats,
						);
					}
					if ( is_array( $tags ) && ! empty( $tags ) ) {
						$taxQ[] = array(
							'taxonomy' => TSSPro()->taxonomies['tag'],
							'field'    => 'term_id',
							'terms'    => $tags,
						);
					}
					if ( ! empty( $taxQ ) ) {
						$args['tax_query'] = $taxQ;
						if ( count( $taxQ ) > 1 ) {
							$taxQ['relation'] = ! empty( $scMeta['tss_taxonomy_relation'][0] ) ? esc_attr( $scMeta['tss_taxonomy_relation'][0] ) : 'AND';
						}
					}

					// Order
					$order_by = ( isset( $scMeta['tss_order_by'][0] ) ? esc_attr( $scMeta['tss_order_by'][0] ) : null );
					$order    = ( isset( $scMeta['tss_order'][0] ) ? esc_attr( $scMeta['tss_order'][0] ) : null );
					if ( $order ) {
						$args['order'] = $order;
					}
					if ( $order_by ) {
						$args['orderby'] = $order_by;
					}

					// Validation
					$dCol = round( 12 / $dCol );
					$tCol = round( 12 / $tCol );
					$mCol = round( 12 / $mCol );
					if ( $isCarousel ) {
						$dCol = $tCol = $mCol = 12;
					}

					$testi_limit      = ! empty( $scMeta['tss_testimonial_limit'][0] ) ? absint( $scMeta['tss_testimonial_limit'][0] ) : null;
					$arg              = array();
					$arg['grid']      = "rt-col-md-{$dCol} rt-col-sm-{$tCol} rt-col-xs-{$mCol}";
					$gridType         = ! empty( $scMeta['tss_grid_style'][0] ) ? esc_attr( $scMeta['tss_grid_style'][0] ) : 'even';
					$arg['read_more'] = ! empty( $scMeta['tss_read_more_button_text'][0] ) ? esc_attr( $scMeta['tss_read_more_button_text'][0] ) : null;
					$arg['class']     = $gridType . '-grid-item';
					$arg['class']    .= ' tss-grid-item';
					$preLoader        = null;
					if ( $isIsotope ) {
						$arg['class'] .= ' isotope-item';
					}
					if ( $isCarousel ) {
						$arg['class'] .= ' slide-item';
					}
					if ( $gridType == 'even' ) {
						$arg['class'] .= ' even-grid-item';
					} elseif ( $gridType == 'masonry' && ! $isIsotope && ! $isCarousel ) {
						$arg['class'] .= ' masonry-grid-item';
					}
					$image_type = ! empty( $scMeta['tss_image_type'][0] ) ? esc_attr( $scMeta['tss_image_type'][0] ) : 'normal';
					if ( $image_type == 'circle' ) {
						$arg['class'] .= ' tss-img-circle';
					}

					$margin = ! empty( $scMeta['tss_margin'][0] ) ? esc_attr( $scMeta['tss_margin'][0] ) : 'default';
					if ( $margin == 'no' ) {
						$arg['class'] .= ' no-margin';
					} else {
						$arg['class'] .= ' default-margin';
					}

					$image_shape = ! empty( $scMeta['tss_image_shape'][0] ) ? esc_attr( $scMeta['tss_image_shape'][0] ) : null;
					if ( $image_shape == 'circle' ) {
						$arg['class'] .= ' tss-img-circle';
					}

					$arg['items']       = ! empty( $scMeta['tss_item_fields'] ) ? array_map( 'sanitize_text_field', $scMeta['tss_item_fields'] ) : array();
					$arg['shareItems'] = ! empty( $scMeta['social_share_items'] ) ? array_map( 'sanitize_text_field', $scMeta['social_share_items'] ) : array();
					$arg['anchorClass'] = null;
					$link               = ! empty( $scMeta['tss_detail_page_link'][0] ) ? true : false;
					$arg['link']        = $link ? true : false;

					$tssQuery = new WP_Query( $args );
					// Start layout
					if ( $tssQuery->have_posts() ) {

						while ( $tssQuery->have_posts() ) {
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
							$imgUrl              = wp_get_attachment_image_src( get_post_thumbnail_id( $iID ), 'full' );
							$arg['img_full_url'] = ( ! empty( $imgUrl ) ? esc_url( $imgUrl[0] ) : null );
							$aHtml               = null;
							if ( in_array( 'read_more', $arg['items'] ) && function_exists( 'rttsp' ) ) {
								$aHtml = "<a class='rt-read-more' href='" . esc_url( $arg['pLink'] ) . "'>{$arg['read_more']}</a>";
							}
							$arg['testimonial'] = get_the_content();
							if ( $testi_limit ) {
								$arg['testimonial'] = TSSPro()->strip_tags_content( get_the_content(), $testi_limit, $aHtml );
							}
							if ( $isIsotope ) {
								$termAs    = wp_get_post_terms( $iID, TSSPro()->taxonomies['category'], array( 'fields' => 'all' ) );
								$isoFilter = null;
								if ( ! empty( $termAs ) ) {
									foreach ( $termAs as $term ) {
										$isoFilter .= ' ' . 'iso_' . $term->term_id;
										$isoFilter .= ' ' . $term->slug;
									}
								}
								$arg['isoFilter'] = $isoFilter;
							}
							$arg['img'] = TSSPro()->getFeatureImage( $iID, $imgSize, $customImgSize );
							$data      .= TSSPro()->render( 'layouts/' . $layout, $arg );

						}
						if ( ! empty( $data ) ) {
							$error = false;
						}
					} else {
						$msg = esc_html__( 'No more testimonial to load', 'testimonial-slider-showcase' );
					}
					wp_reset_postdata();

				} elseif ( 'elementor' == $scID ) {
					$data = $this->tssElLoadMore();

					if ( ! empty( $data ) ) {
						$error = false;
					} else {
						$msg = esc_html__( 'No more testimonial to load', 'testimonial-slider-showcase' );
					}
				} else {
					$msg = esc_html__( 'No more testimonial to load', 'testimonial-slider-showcase' );
				}
			} else {
				$msg = esc_html__( 'Security error', 'testimonial-slider-showcase' );
			}
			wp_send_json(
				array(
					'error' => $error,
					'msg'   => $msg,
					'data'  => $data,
					'q'     => $args,
				)
			);
			die();
		}

		public function tssElLoadMore() {
			$scMeta = json_decode( wp_unslash( $_REQUEST['elData'] ), true );

			$layout = ( ! empty( $scMeta['tss_layout'] ) ? esc_attr( $scMeta['tss_layout'] ) : 'layout1' );
			$dCol   = ( isset( $scMeta['tss_desktop_column'] ) ? absint( $scMeta['tss_desktop_column'] ) : 3 );
			$tCol   = ( isset( $scMeta['tss_tab_column'] ) ? absint( $scMeta['tss_tab_column'] ) : 2 );
			$mCol   = ( isset( $scMeta['tss_mobile_column'] ) ? absint( $scMeta['tss_mobile_column'] ) : 1 );

			if ( ! in_array( $dCol, array_keys( TSSPro()->scColumns() ) ) ) {
				$dCol = 3;
			}

			if ( ! in_array( $tCol, array_keys( TSSPro()->scColumns() ) ) ) {
				$tCol = 2;
			}

			if ( ! in_array( $dCol, array_keys( TSSPro()->scColumns() ) ) ) {
				$mCol = 1;
			}

			$customImgSize = $scMeta['custom_img_size'];
			$defaultImgId  = $scMeta['default_image'];
			$imgSize       = ( ! empty( $scMeta['tss_image_size'] ) ? esc_attr( $scMeta['tss_image_size'] ) : 'medium' );

			$isIsotope  = preg_match( '/isotope/', $layout );
			$isCarousel = preg_match( '/carousel/', $layout );

			/* Argument create */
			$args              = array();
			$args['post_type'] = array( TSSPro()->post_type );
			// Common filter
			/* post__in */
			$post__in = ( ! empty( $scMeta['tss_post__in'] ) ? sanitize_text_field( implode( ', ', $scMeta['tss_post__in'] ) ) : null );

			if ( $post__in ) {
				$post__in         = explode( ',', $post__in );
				$args['post__in'] = $post__in;
			}
			/* post__not_in */
			$post__not_in = ( ! empty( $scMeta['tss_post__not_in'] ) ? sanitize_text_field( implode( ', ', $scMeta['tss_post__not_in'] ) ) : null );
			if ( $post__not_in ) {
				$post__not_in         = explode( ',', $post__not_in );
				$args['post__not_in'] = $post__not_in;
			}
			/* LIMIT */
			$limit                  = ( ( empty( $scMeta['tss_limit'] ) || $scMeta['tss_limit'] === '-1' ) ? 10000000 : (int) $scMeta['tss_limit'] );
			$args['posts_per_page'] = $limit;
			$pagination             = ( ! empty( $scMeta['tss_pagination'] ) ? true : false );
			if ( $pagination ) {
				$posts_per_page = ( isset( $scMeta['tss_posts_per_page'] ) ? intval( $scMeta['tss_posts_per_page'] ) : $limit );
				if ( $posts_per_page > $limit ) {
					$posts_per_page = $limit;
				}
				// Set 'posts_per_page' parameter
				$args['posts_per_page'] = $posts_per_page;

				$paged = ( ! empty( $_REQUEST['paged'] ) ) ? absint( $_REQUEST['paged'] ) : 2;

				$offset        = $posts_per_page * ( (int) $paged - 1 );
				$args['paged'] = $paged;

				// Update posts_per_page
				if ( intval( $args['posts_per_page'] ) > $limit - $offset ) {
					$args['posts_per_page'] = $limit - $offset;
					$args['offset'] = $offset;
				}
			}

			if ( $isCarousel ) {
				$args['posts_per_page'] = $limit;
			}

			// Taxonomy
			$cats = ( isset( $scMeta['tss_categories'] ) ? array_filter( $scMeta['tss_categories'] ) : array() );
			$tags = ( isset( $scMeta['tss_tags'] ) ? array_filter( $scMeta['tss_tags'] ) : array() );
			$taxQ = array();
			if ( is_array( $cats ) && ! empty( $cats ) ) {
				$taxQ[] = array(
					'taxonomy' => TSSPro()->taxonomies['category'],
					'field'    => 'term_id',
					'terms'    => $cats,
				);
			}
			if ( is_array( $tags ) && ! empty( $tags ) ) {
				$taxQ[] = array(
					'taxonomy' => TSSPro()->taxonomies['tag'],
					'field'    => 'term_id',
					'terms'    => $tags,
				);
			}
			if ( ! empty( $taxQ ) ) {
				$args['tax_query'] = $taxQ;
				if ( count( $taxQ ) > 1 ) {
					$taxQ['relation'] = ! empty( $scMeta['tss_taxonomy_relation'] ) ? esc_attr( $scMeta['tss_taxonomy_relation'] ) : 'AND';
				}
			}

			// Order
			$order_by = ( isset( $scMeta['tss_order_by'] ) ? esc_attr( $scMeta['tss_order_by'] ) : null );
			$order    = ( isset( $scMeta['tss_order'] ) ? esc_attr( $scMeta['tss_order'] ) : null );
			if ( $order ) {
				$args['order'] = $order;
			}
			if ( $order_by ) {
				$args['orderby'] = $order_by;
			}

			// Validation
			$dCol = round( 12 / $dCol );
			$tCol = round( 12 / $tCol );
			$mCol = round( 12 / $mCol );
			if ( $isCarousel ) {
				$dCol = $tCol = $mCol = 12;
			}

			$testi_limit      = ! empty( $scMeta['tss_testimonial_limit'] ) ? absint( $scMeta['tss_testimonial_limit'] ) : null;
			$arg              = array();
			$arg['grid']      = "rt-col-md-{$dCol} rt-col-sm-{$tCol} rt-col-xs-{$mCol}";
			$gridType         = ! empty( $scMeta['tss_grid_style'] ) ? esc_attr( $scMeta['tss_grid_style'] ) : 'even';
			$arg['read_more'] = ! empty( $scMeta['tss_read_more_button_text'] ) ? esc_attr( $scMeta['tss_read_more_button_text'] ) : null;
			$arg['class']     = $gridType . '-grid-item';
			$arg['class']    .= ' tss-grid-item';
			$preLoader        = null;
			if ( $isIsotope ) {
				$arg['class'] .= ' isotope-item';
			}
			if ( $isCarousel ) {
				$arg['class'] .= ' slide-item';
			}
			if ( $gridType == 'even' ) {
				$arg['class'] .= ' even-grid-item';
			} elseif ( $gridType == 'masonry' && ! $isIsotope && ! $isCarousel ) {
				$arg['class'] .= ' masonry-grid-item';
			}

			$arg['items']       = ! empty( $scMeta['tss_item_fields'] ) ? array_map( 'sanitize_text_field', $scMeta['tss_item_fields'] ) : array();
			$arg['shareItems'] = ! empty( $scMeta['tss_share_fields'] ) ? array_map( 'sanitize_text_field', $scMeta['tss_share_fields'] ) : array();
			$arg['anchorClass'] = null;
			$link               = ! empty( $scMeta['tss_detail_page_link'] ) ? true : false;
			$arg['link']        = $link ? true : false;

			$tssQuery = new WP_Query( $args );

			// Start layout
			if ( $tssQuery->have_posts() ) {

				while ( $tssQuery->have_posts() ) {
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
					$imgUrl              = wp_get_attachment_image_src( get_post_thumbnail_id( $iID ), 'full' );
					$arg['img_full_url'] = ( ! empty( $imgUrl ) ? esc_url( $imgUrl[0] ) : null );
					$aHtml               = null;
					if ( in_array( 'read_more', $arg['items'] ) && function_exists( 'rttsp' ) ) {
						$aHtml = "<a class='rt-read-more' href='" . esc_url( $arg['pLink'] ) . "'>{$arg['read_more']}</a>";
					}
					$arg['testimonial'] = get_the_content();
					if ( $testi_limit ) {
						$arg['testimonial'] = TSSPro()->strip_tags_content( get_the_content(), $testi_limit, $aHtml );
					}
					if ( $isIsotope ) {
						$termAs    = wp_get_post_terms( $iID, TSSPro()->taxonomies['category'], array( 'fields' => 'all' ) );
						$isoFilter = null;
						if ( ! empty( $termAs ) ) {
							foreach ( $termAs as $term ) {
								$isoFilter .= ' ' . 'iso_' . $term->term_id;
								$isoFilter .= ' ' . $term->slug;
							}
						}
						$arg['isoFilter'] = $isoFilter;
					}

					$arg['img'] = TSSPro()->getFeatureImage( $iID, $imgSize, $customImgSize, $defaultImgId );
					$data      .= TSSPro()->render( 'layouts/' . $layout, $arg );

				}
			} else {
				$msg = esc_html__( 'No more testimonial to load', 'testimonial-slider-showcase' );
			}
			wp_reset_postdata();

			return $data;
		}
	}

endif;

<?php
if (!class_exists('TSSProHelper')) :
	class TSSProHelper
	{

		function verifyNonce() {
			$nonce = !empty($_REQUEST[$this->nonceId()]) ? sanitize_text_field( $_REQUEST[$this->nonceId()] ) : null;
			$nonceText = $this->nonceText();
			if (!wp_verify_nonce($nonce, $nonceText)) {
				return false;
			}

			return true;
		}

		function verifyRecaptcha() {
			$return = false;
			$settings = get_option(TSSPro()->options['settings']);
			$recaptcha_secret = (!empty($settings['tss_secret_key']) ? sanitize_text_field( $settings['tss_secret_key'] ) : null);
			if ($recaptcha_secret) {
				$response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . sanitize_text_field( $_REQUEST['g-recaptcha-response'] ) );
				$response = json_decode($response["body"], true);
				if (true == $response["success"]) {
					$return = true;
				}
			}

			return $return;
		}

		function nonceText() {
			return "tss_nonce_text";
		}

		function nonceId() {
			return "tss_nonce";
		}

		function tssTestimonialAllMetaFields() {
			return array_merge(
				TSSPro()->singleTestimonialFields()
			);
		}

		function pfpScMetaFields() {
			return array_merge(
				TSSPro()->scLayoutMetaFields(),
				TSSPro()->scFilterMetaFields(),
				TSSPro()->scItemMetaFields(),
				TSSPro()->scStyleFields());
		}

		function rtFieldGenerator($fields = array()) {
			$html = null;
			if (is_array($fields) && !empty($fields)) {
				$TSSProField = new TSSProField();
				foreach ($fields as $fieldKey => $field) {
					$html .= $TSSProField->Field($fieldKey, $field);
				}
			}

			return $html;
		}

		function tssAllSettingsFields() {
			return array_merge(
				TSSPro()->generalSettings(),
				TSSPro()->detailFieldControl(),
				TSSPro()->formFieldControl(),
				TSSPro()->recaptchaFields(),
				TSSPro()->othersSettings(),
				TSSPro()->rtLicenceField()
			);
		}

		/**
		 * Sanitize field value
		 *
		 * @param array $field
		 * @param null  $value
		 *
		 * @return array|null
		 * @internal param $value
		 */
		function sanitize($field = array(), $value = null) {
			$newValue = null;
			if (is_array($field)) {
				$type = (!empty($field['type']) ? esc_attr( $field['type'] ) : 'text');
				if (empty($field['multiple'])) {
					if ($type == 'text' || $type == 'number' || $type == 'select' || $type == 'checkbox' ||  $type == 'switch' || $type == 'radio' || $type == 'radio-image') {
						$newValue = sanitize_text_field($value);
					} else if ($type == 'price') {
						$newValue = ('' === $value) ? '' : TSSPro()->format_decimal($value);
					} else if ($type == 'url') {
						$newValue = esc_url($value);
					} else if ($type == 'rating') {
						$newValue = absint($value);
						$newValue = ($newValue > 5 ? 0 : $newValue);
					} else if ($type == 'video') {
						$newValue = esc_url($value);
					} else if ($type == 'slug') {
						$newValue = sanitize_title_with_dashes($value);
					} else if ($type == 'textarea') {
						$newValue = wp_kses_post($value);
					} else if ($type == 'custom_css') {
						$newValue = esc_textarea($value);
					} else if ($type == 'colorpicker') {
						$newValue = $this->sanitize_hex_color($value);
					} else if ($type == 'image') {
						$newValue = absint($value);
					}else if ($field['type'] == "email") {
						$newValue = sanitize_email($value);
					} else if ($type == 'image_size') {
						$newValue = array();
						foreach ($value as $k => $v) {
							$newValue[$k] = esc_attr($v);
						}
					} else if ($type == 'style' || $type == 'multiple_options') {
						$newValue = array();
						foreach ($value as $k => $v) {
							$nV = null;
							if ($k == 'color') {
								$nV = $this->sanitize_hex_color($v);
							} else {
								$nV = $this->sanitize(array('type' => 'text'), $v);
							}
							if ($nV) {
								$newValue[$k] = $nV;
							}
						}
						if (empty($newValue)) {
							$newValue = null;
						}
					} else if ($type == 'socialMedia') {
						if (is_array($value)) {
							foreach ($value as $key => $val) {
								$newValue[$key] = esc_url($val);
							}
						}
					} else {
						$newValue = array();
					}

				} else {
					$newValue = array();
					if (!empty($value)) {
						if (is_array($value)) {
							foreach ($value as $key => $val) {
								if ($type == 'style' && $key == 0) {
									$newValue = $this->sanitize_hex_color($val);
								} else {
									$newValue[] = sanitize_text_field($val);
								}
							}
						} else {
							$newValue[] = sanitize_text_field($value);
						}
					}
				}
			}

			return $newValue;
		}

		function sanitize_hex_color($color) {
			if (function_exists('sanitize_hex_color')) {
				return sanitize_hex_color($color);
			} else {
				if ('' === $color) {
					return '';
				}

				// 3 or 6 hex digits, or the empty string.
				if (preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color)) {
					return $color;
				}
			}
		}


		function getFeatureImage(
			$post_id = null,
			$fImgSize = 'medium',
			$customImgSize = array(),
			$defaultImgId = null,
			$data_src = false
		) {
			global $post;
			$img_class = "rt-responsive-img";
			$imgSrc    = $image = null;
			$cSize     = false;
			$post_id   = ($post_id ? absint($post_id) : $post->ID);
			// $alt = esc_url(get_the_title($post_id));
			$thumb_id = get_post_thumbnail_id( $post_id) ;
			$alt   = trim( wp_strip_all_tags( get_post_meta( $thumb_id, '_wp_attachment_image_alt', true ) ) );

			if( empty( $alt ) ) {
				$alt = esc_html( get_the_title( $post_id ) );
			}

			if ($fImgSize == 'tss_custom') {
				$fImgSize = 'full';
				$cSize = true;
			}

			if ($thumb_id) {
				// $image = wp_get_attachment_image($thumb_id, $fImgSize, '', array("class" => $img_class));
				$imageS = wp_get_attachment_image_src($thumb_id, $fImgSize);
				$imgSrc = $imageS[0];

				$image = "<img alt='{$alt}' class='{$img_class}' src='{$imgSrc}' />";

				if( $data_src ) {
					$image = "<img alt='{$alt}' class='{$img_class} swiper-lazy' data-src='{$imgSrc}' />";
				}
			}
			if (!$imgSrc && $defaultImgId) {
				$image = wp_get_attachment_image_src($defaultImgId, $fImgSize);
				$imgSrc = $image[0];
				$image = "<img alt='{$alt}' class='{$img_class}' src='{$imgSrc}' />";

				if( $data_src ) {
					$image = "<img alt='{$alt}' class='{$img_class} swiper-lazy' data-src='{$imgSrc}' />";
				}
			}

			if ($imgSrc && $cSize) {
				$w = (!empty($customImgSize['width']) ? absint($customImgSize['width']) : null);
				$h = (!empty($customImgSize['height']) ? absint($customImgSize['height']) : null);
				$c = (!empty($customImgSize['crop']) && $customImgSize['crop'] == 'soft' ? false : true);

				$actual_dimension = wp_get_attachment_metadata( $thumb_id, true );

				if ( empty( $actual_dimension ) && $defaultImgId ) {
					$actual_dimension = wp_get_attachment_metadata( $defaultImgId, true );
				}

				$actual_w = $actual_dimension['width'];
				$actual_h = $actual_dimension['height'];

				if ($w && $h) {
					if( $w >= $actual_w || $h >= $actual_h ) {
						$w = 150;
						$h = 150;
					}

					$imgSrc = esc_url(TSSPro()->rtImageReSize($imgSrc, $w, $h, $c));
					$image = "<img alt='{$alt}' class='{$img_class}' src='{$imgSrc}' />";

					if( $data_src ) {
						$image = "<img alt='{$alt}' class='{$img_class} swiper-lazy' data-src='{$imgSrc}' />";
					}
				}
			}

			if (!$image) {
				$imgSrc = esc_url(TSSPro()->placeholder_img_src());
				$image = "<img alt='{$alt}' class='{$img_class} rt-dummy-img' src='{$imgSrc}' />";
			}

			return $image;
		}

		function rtImageReSize($url, $width = null, $height = null, $crop = null, $single = true, $upscale = false) {
			$rtResize = new TSSProReSizer();

			return $rtResize->process($url, $width, $height, $crop, $single, $upscale);
		}

		function strip_tags_content($text, $limit = 0, $link = '') {

			$text = preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
			$text = esc_html($text);
			if ($limit > 0 && strlen($text) > $limit) {
				$text = substr($text, 0, $limit);
				$text = $text . ' ' . $link;
			}

			return $text;
		}

		function getAllTssCategoryList() {

			$terms = array();
			$termList = get_terms(array(TSSPro()->taxonomies['category']), array('hide_empty' => 0));
			if (is_array($termList) && !empty($termList) && empty($termList['errors'])) {
				foreach ($termList as $term) {
					$terms[$term->term_id] = $term->name;
				}
			}

			return $terms;
		}

		function getAllTssCategoryListWithDefault() {

			$terms = array(
				'all' => __( 'Show All', 'testimonial-slider-showcase' )
			);

			$termList = get_terms(array(TSSPro()->taxonomies['category']), array('hide_empty' => 0));
			if (is_array($termList) && !empty($termList) && empty($termList['errors'])) {
				foreach ($termList as $term) {
					$terms[$term->term_id] = $term->name;
				}
			}

			return $terms;
		}

		function getAllTssTagList() {
			$terms = array();
			$termList = get_terms(array(TSSPro()->taxonomies['tag']), array('hide_empty' => 0));
			if (is_array($termList) && !empty($termList) && empty($termList['errors'])) {
				foreach ($termList as $term) {
					$terms[$term->term_id] = $term->name;
				}
			}

			return $terms;
		}

		function getAllTaxonomyObject() {
			$taxonomy_objects = get_object_taxonomies(TSSPro()->post_type, 'objects');
			$taxonomy_list = array();
			if (!empty($taxonomy_objects)) {
				foreach ($taxonomy_objects as $taxonomy) {
					if (!in_array($taxonomy->name, array('language', 'post_translations'))) {
						$taxonomy_list[] = $taxonomy;
					}
				}
			}

			return $taxonomy_list;
		}


		function getPortfolioList() {
			$portfolios = array();
			$portQ = new WP_Query(array(
				'post_type'      => TSSPro()->post_type,
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'orderby'        => 'title',
				'order'          => 'ASC'
			));
			if ($portQ->have_posts()) {
				while ($portQ->have_posts()) {
					$portQ->the_post();
					$portfolios[get_the_ID()] = get_the_title();
				}
			}
			wp_reset_postdata();

			return $portfolios;
		}

		function getPortfolioListExceptId($id = null) {
			$id = ($id ? intval($id) : get_the_ID());
			$portfolios = array();

			if ($id) {
				$portQ = get_posts(array(
					'post_type'      => TSSPro()->post_type,
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'orderby'        => 'title',
					'post__not_in'   => array($id),
					'order'          => 'ASC'
				));
				if (!empty($portQ)) {
					foreach ($portQ as $port) {
						$portfolios[$port->ID] = $port->post_title;
					}
				}
			}

			return $portfolios;
		}

		function TLPhex2rgba($color, $opacity = false) {
			$default = 'rgb(0,0,0)';

			//Return default if no color provided
			if (empty($color)) {
				return $default;
			}

			//Sanitize $color if "#" is provided
			if ($color[0] == '#') {
				$color = substr($color, 1);
			}

			//Check if color has 6 or 3 characters and get values
			if (strlen($color) == 6) {
				$hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
			} elseif (strlen($color) == 3) {
				$hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
			} else {
				return $default;
			}

			//Convert hexadec to rgb
			$rgb = array_map('hexdec', $hex);

			//Check if opacity is set(rgba or rgb)
			if ($opacity) {
				if (abs($opacity) > 1) {
					$opacity = 1.0;
				}
				$output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
			} else {
				$output = 'rgb(' . implode(",", $rgb) . ')';
			}

			//Return rgb(a) color string
			return $output;
		}

		function tlp_custom_pagination($numpages = '', $pagerange = '', $paged = '') {

			if (empty($pagerange)) {
				$pagerange = 2;
			}
			global $paged;
			if (empty($paged)) {
				$paged = 1;
			}
			if ($numpages == '') {
				global $wp_query;
				$numpages = $wp_query->max_num_pages;
				if (!$numpages) {
					$numpages = 1;
				}
			}

			/**
			 * We construct the pagination arguments to enter into our paginate_links
			 * function.
			 */
			$pagination_args = array(
				'base'               => get_pagenum_link(1) . '%_%',
				'format'             => 'page/%#%',
				'total'              => $numpages,
				'current'            => $paged,
				'show_all'           => false,
				'end_size'           => 1,
				'mid_size'           => $pagerange,
				'prev_next'          => true,
				'prev_text'          => esc_html__('&laquo;'),
				'next_text'          => esc_html__('&raquo;'),
				'type'               => 'list',
				'add_args'           => false,
				'add_fragment'       => '',
				'before_page_number' => '',
				'after_page_number'  => ''
			);

			$paginate_links = paginate_links($pagination_args);
			$html = null;
			if ($paginate_links) {
				$html .= "<nav class='tlp-pagination'>";
				$html .= $paginate_links;
				$html .= "</nav>";
			}

			return $html;

		}

		function pagination($pages = '', $range = 4, $ajax = false, $scID = '', $scMeta=null) {

			$html = null;
			$showitems = ($range * 2) + 1;

			global $paged;
			if ( is_front_page() ) {
				$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
			} else {
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			}
			if (empty($paged)) {
				$paged = 1;
			}

			if ($pages == '') {
				global $wp_query;
				$pages = $wp_query->max_num_pages;

				if (!$pages) {
					$pages = 1;
				}
			}
			$ajaxClass = null;
			$dataAttr = null;

			if ($ajax) {
				$ajaxClass = ' tss-ajax';
				$dataAttr = "data-sc-id='{$scID}' data-paged='1'";
			}

			if('elementor' == $scID) {
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
					'tss_categories'            => $scMeta['tss_el_categories'],
					'tss_tags'                  => $scMeta['tss_el_tags'],
					'tss_taxonomy_relation'     => $scMeta['tss_el_taxonomy_relation'],
					'tss_order_by'              => $scMeta['tss_el_posts_order_by'],
					'tss_order'                 => $scMeta['tss_el_posts_order'],
					'tss_testimonial_limit'     => $scMeta['tss_el_testimonial_text_limit'],
					'tss_grid_style'            => $scMeta['tss_el_grid_style'],
					'tss_read_more_button_text' => $scMeta['tss_el_read_more_text'],
					'tss_item_fields'           => $this->tssElContentVisibility( $scMeta ),
					'tss_share_fields'          => $scMeta['tss_el_social_share_items'],
					'tss_detail_page_link'      => $scMeta['tss_el_detail_page_link'],
				);

				$dataAttr = 'data-paged="1" data-tss-elementor=\'' . wp_json_encode($elData) . '\'';
			}

			// echo $showitems;

			if (1 != $pages) {

				$html .= '<div class="tss-pagination' . $ajaxClass . '" ' . $dataAttr . '>';
				$html .= '<ul class="pagination-list">';
				if ($paged > 2 && $paged > $range + 1 && $showitems < $pages) {
					$html .= "<li><a data-paged='1' href='" . get_pagenum_link(1) . "' aria-label='First'>&laquo;</a></li>";
				}

				if ($paged > 1 && $showitems < $pages) {
					$p = $paged - 1;
					$html .= "<li><a data-paged='{$p}' href='" . get_pagenum_link($p) . "' aria-label='Previous'>&lsaquo;</a></li>";
				}

				for ($i = 1; $i <= $pages; $i++) {
					if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
						$html .= ($paged == $i) ? "<li class=\"active\"><span>" . $i . "</span>

	</li>" : "<li><a data-paged='{$i}' href='" . get_pagenum_link($i) . "'>" . $i . "</a></li>";
					}
				}

				if ($paged < $pages && $showitems < $pages) {
					$p = $paged + 1;
					$html .= "<li><a data-paged='{$p}' href=\"" . get_pagenum_link($paged + 1) . "\"  aria-label='Next'>&rsaquo;</a></li>";
				}

				if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages) {
					$html .= "<li><a data-paged='{$pages}' href='" . get_pagenum_link($pages) . "' aria-label='Last'>&raquo;</a></li>";
				}

				$html .= "</ul>";
				$html .= "</div>";
			}

			return $html;

		}

		function rt_pagination($pages = '', $range = 4) {

			$html = null;
			$showitems = ($range * 2) + 1;
			global $paged;
			if (empty($paged)) {
				$paged = 1;
			}
			if ($pages == '') {
				global $wp_query;
				$pages = $wp_query->max_num_pages;
				if (!$pages) {
					$pages = 1;
				}
			}

			if (1 != $pages) {

				$html .= '<div class="rt-pagination">';
				$html .= '<ul class="pagination"><li class="disabled hidden-xs"><span><span aria-hidden="true">Page ' . $paged . ' of ' . $pages . '</span></span></li>';

				if ($paged > 2 && $paged > $range + 1 && $showitems < $pages) {
					$html .= "<li><a href='" . get_pagenum_link(1) . "' aria-label='First'>&laquo;<span class='hidden-xs'> First</span></a></li>";
				}

				if ($paged > 1 && $showitems < $pages) {
					$html .= "<li><a href='" . get_pagenum_link($paged - 1) . "' aria-label='Previous'>&lsaquo;<span class='hidden-xs'> Previous</span></a></li>";
				}


				for ($i = 1; $i <= $pages; $i++) {
					if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
						$html .= ($paged == $i) ? "<li class=\"active\"><span>" . $i . "</span>

	</li>" : "<li><a href='" . get_pagenum_link($i) . "'>" . $i . "</a></li>";

					}

				}

				if ($paged < $pages && $showitems < $pages) {
					$html .= "<li><a href=\"" . get_pagenum_link($paged + 1) . "\"  aria-label='Next'><span class='hidden-xs'>Next </span>&rsaquo;</a></li>";
				}

				if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages) {
					$html .= "<li><a href='" . get_pagenum_link($pages) . "' aria-label='Last'><span class='hidden-xs'>Last </span>&raquo;</a></li>";
				}

				$html .= "</ul>";
				$html .= "</div>";
			}

			return $html;

		}

		function placeholder_img_src() {
			return TSSPro()->assetsUrl . 'images/placeholder.png';
		}

		function get_image_sizes() {
			global $_wp_additional_image_sizes;

			$sizes = array();
			foreach (get_intermediate_image_sizes() as $_size) {
				if (in_array($_size, array('thumbnail', 'medium', 'large'))) {
					$sizes[$_size]['width'] = get_option("{$_size}_size_w");
					$sizes[$_size]['height'] = get_option("{$_size}_size_h");
					$sizes[$_size]['crop'] = (bool)get_option("{$_size}_crop");
				} elseif (isset($_wp_additional_image_sizes[$_size])) {
					$sizes[$_size] = array(
						'width'  => $_wp_additional_image_sizes[$_size]['width'],
						'height' => $_wp_additional_image_sizes[$_size]['height'],
						'crop'   => $_wp_additional_image_sizes[$_size]['crop'],
					);
				}
			}

			$imgSize = array();
			foreach ($sizes as $key => $img) {
				$imgSize[$key] = ucfirst($key) . " ({$img['width']}*{$img['height']})";
			}

			if ( function_exists('rttsp') ) {
				$imgSize['tss_custom'] = esc_html__("Custom image size", "testimonial-slider-showcase");
			}

			return $imgSize;
		}


		function get_shortCode_list() {
			$list = array();
			$scList = get_posts(array(
				'post_type'      => TSSPro()->shortCodePT,
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'orderby'        => 'title',
				'order'          => 'ASC',
			));
			if ($scList && !empty($scList)) {
				foreach ($scList as $sc) {
					$list[$sc->ID] = $sc->post_title;
				}
			}

			return $list;
		}

		function socialShare($pLink) {
			$html = null;
			$html .= "<div class='single-portfolio-share'>
						<div class='fb-share'>
							<div class='fb-share-button' data-href='{$pLink}' data-layout='button_count'></div>
						</div>
						<div class='twitter-share'>
							<a href='{$pLink}' class='twitter-share-button'{count} data-url='https://about.twitter.com/resources/buttons#tweet'>Tweet</a>
						</div>
						<div class='googleplus-share'>
							<div class='g-plusone'></div>
						</div>
						<div class='linkedin-share'>
							<script type='IN/Share' data-counter='right'></script>
						</div>
						<div class='linkedin-share'>
							<a data-pin-do='buttonPin' data-pin-count='beside' href='https://www.pinterest.com/pin/create/button/?url=https%3A%2F%2Fwww.flickr.com%2Fphotos%2Fkentbrew%2F6851755809%2F&media=https%3A%2F%2Ffarm8.staticflickr.com%2F7027%2F6851755809_df5b2051c9_z.jpg&description=Next%20stop%3A%20Pinterest'><img src='//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png' /></a>
						</div>
				   </div>";
			$html .= '<div id="fb-root"></div>
			<script>(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
					fjs.parentNode.insertBefore(js, fjs);
				}(document, "script", "facebook-jssdk"));</script>';
			$html .= "<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			<script>window.___gcfg = { lang: 'en-US', parsetags: 'onload', };</script>";
			$html .= "<script src='https://apis.google.com/js/platform.js' async defer></script>";
			$html .= '<script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script>';
			$html .= '<script async defer src="//assets.pinterest.com/js/pinit.js"></script>';

			return $html;
		}

		function doFlush() {
			if (get_option(TSSPro()->options['flash'])) {
				TSSPro()->flush_rewrite();
				update_option(TSSPro()->options['flash'], false);
			}
		}


		function layoutStyle($layoutID, $meta, $scId = null) {
			$css = null;
			$css .= "<style type='text/css' media='all'>";
			// Variable
			if ($scId) {
				$colorSchema = (!empty($meta['tss_color'][0]) ? unserialize($meta['tss_color'][0]) : null);
				$button = (!empty($meta['tss_button_style'][0]) ? unserialize($meta['tss_button_style'][0]) : null);
				$imgBorder = (!empty($meta['tss_image_border'][0]) ? unserialize($meta['tss_image_border'][0]) : null);
				$tooltipBg = (!empty($meta['tss_iso_counter_tooltip_bg_color'][0]) ? esc_attr($meta['tss_iso_counter_tooltip_bg_color'][0]) : null);
				$tooltipText = (!empty($meta['tss_iso_counter_tooltip_text_color'][0]) ? esc_attr($meta['tss_iso_counter_tooltip_text_color'][0]) : null);
				$gutter = !empty($meta['tss_gutter'][0]) ? absint($meta['tss_gutter'][0]) : null;
				$name = (!empty($meta['tss_author_name_style'][0]) ? unserialize($meta['tss_author_name_style'][0]) : array());
				$author_bio = (!empty($meta['tss_author_bio_style'][0]) ? unserialize($meta['tss_author_bio_style'][0]) : array());

				$rating = (!empty($meta['tss_rating_style'][0]) ? unserialize($meta['tss_rating_style'][0]) : array());
				$social = (!empty($meta['tss_social_style'][0]) ? unserialize($meta['tss_social_style'][0]) : array());
				$testimonial = (!empty($meta['tss_testimonial_style'][0]) ? unserialize($meta['tss_testimonial_style'][0]) : array());
				$overlay = (!empty($meta['tss_overlay_style'][0]) ? unserialize($meta['tss_overlay_style'][0]) : null);
			} else {
				$colorSchema = (!empty($meta['tss_color']) ? array_filter($meta['tss_color']) : null);
				$button = (!empty($meta['tss_button_style']) ? array_filter($meta['tss_button_style']) : null);
				$imgBorder = (!empty($meta['tss_image_border']) ? array_filter($meta['tss_image_border']) : array());
				$tooltipBg = (!empty($meta['tss_iso_counter_tooltip_bg_color']) ? esc_attr($meta['tss_iso_counter_tooltip_bg_color']) : null);
				$tooltipText = (!empty($meta['tss_iso_counter_tooltip_text_color']) ? esc_attr($meta['tss_iso_counter_tooltip_text_color']) : null);
				$gutter = !empty($meta['tss_gutter']) ? absint($meta['tss_gutter']) : null;

				$name = (!empty($meta['tss_author_name_style']) ? array_map( 'sanitize_text_field', $meta['tss_author_name_style'] ) : array());
				$author_bio = (!empty($meta['tss_author_bio_style']) ? array_map( 'sanitize_text_field', $meta['tss_author_bio_style'] ) : array());
				$rating = (!empty($meta['tss_rating_style']) ? array_map( 'sanitize_text_field', $meta['tss_rating_style'] ) : array());
				$social = (!empty($meta['tss_social_style']) ? array_map( 'sanitize_text_field', $meta['tss_social_style'] ) : array());
				$testimonial = (!empty($meta['tss_testimonial_style']) ? array_map( 'sanitize_text_field', $meta['tss_testimonial_style'] ) : array());
				$overlay = (!empty($meta['tss_overlay_style']) ? array_map( 'sanitize_text_field', $meta['tss_overlay_style'] ) : null);
			}

			if ($colorSchema) {
				if (!empty($colorSchema['primary'])) {
					$css .= "#{$layoutID}.tss-wrapper .tss-carousel1,
							#{$layoutID}.tss-wrapper .tss-isotope1 .profile-img-wrapper:after,
							#{$layoutID}.tss-wrapper .tss-layout9 .profile-img-wrapper:after,
							#{$layoutID}.tss-wrapper .tss-isotope4 .profile-img-wrapper:after,
							#{$layoutID}.tss-wrapper .tss-carousel9 .profile-img-wrapper:after {
								background: {$colorSchema['primary']} !important;
							}";
				}
				if (!empty($colorSchema['container_bg'])) {
					$css .= "#{$layoutID}.tss-wrapper {
							background: {$colorSchema['container_bg']};}";
				}
				if (!empty($colorSchema['item_bg'])) {
					$css .= "#{$layoutID}.tss-wrapper .item-content-wrapper,
							#{$layoutID}.tss-wrapper .tss-layout10 .item-content-wrapper .item-content,
							#{$layoutID}.tss-wrapper .tss-carousel10 .item-content-wrapper .item-content,
							#{$layoutID}.tss-wrapper .tss-isotope5 .item-content-wrapper .item-content,
							#{$layoutID}.tss-wrapper .tss-layout4 .profile-img-wrapper,
							#{$layoutID}.tss-wrapper .tss-isotope2 .profile-img-wrapper,
							#{$layoutID}.tss-wrapper .tss-isotope2 .tss-meta-info,
							#{$layoutID}.tss-wrapper .tss-isotope3 .single-item-wrapper,
							#{$layoutID}.tss-wrapper .tss-layout7 .single-item-wrapper,
							#{$layoutID}.tss-wrapper .tss-carousel7 .single-item-wrapper,
							#{$layoutID}.tss-wrapper .tss-carousel8 .single-item-wrapper,
							#{$layoutID}.tss-wrapper .tss-carousel4 .single-item-wrapper,
							#{$layoutID}.tss-wrapper .tss-carousel5 .single-item-wrapper,
							#{$layoutID}.tss-wrapper .tss-layout8 .single-item-wrapper,
							#{$layoutID}.tss-wrapper .tss-layout5 .tss-meta-info{ background: {$colorSchema['item_bg']};}";
					$css .= "#{$layoutID}.tss-wrapper .tss-layout1 .item-content-wrapper:after,
							#{$layoutID}.tss-wrapper .tss-carousel1 .item-content-wrapper:after{
								border-right: 15px solid {$colorSchema['item_bg']};}";
					$css .= "#{$layoutID}.tss-wrapper .tss-carousel2 .item-content-wrapper:after,
							#{$layoutID}.tss-wrapper .tss-layout2 .item-content-wrapper:after{
							border-left: 15px solid {$colorSchema['item_bg']};}";
					$css .= "#{$layoutID}.tss-wrapper .tss-carousel6 .item-content-wrapper:after,
								#{$layoutID}.tss-wrapper .tss-layout6 .item-content-wrapper:after{
								border-top: 15px solid {$colorSchema['item_bg']};}";
					$css .= "#{$layoutID}.tss-wrapper .tss-layout10 .item-content:after,
							#{$layoutID}.tss-wrapper .tss-isotope5 .item-content:after,
							#{$layoutID}.tss-wrapper .tss-carousel10 .item-content:after{ border-color: transparent transparent {$colorSchema['item_bg']} {$colorSchema['item_bg']};}";

				}
			}
			$css .= "#{$layoutID}.tss-wrapper .tss-layout10 .item-content-wrapper,
					#{$layoutID}.tss-wrapper .tss-isotope3 .item-content-wrapper,
					#{$layoutID}.tss-wrapper .tss-isotope5 .item-content-wrapper,
					#{$layoutID}.tss-wrapper .tss-carousel10 .item-content-wrapper{background: transparent;}";
			/* button */
			if ($button) {
				if (!empty($button['bg'])) {
					$css .= "#{$layoutID}.tss-wrapper .tss-utility button,
						#{$layoutID}.tss-wrapper .tss-carousel-main .swiper-arrow,
						#{$layoutID}.tss-wrapper .tss-carousel-main .swiper-pagination-bullet,
						#{$layoutID}.tss-wrapper .tss-carousel .swiper-arrow,
						#{$layoutID}.tss-wrapper .tss-carousel .swiper-pagination-bullet,
						#{$layoutID}.tss-wrapper .tss-utility .rt-button,
						#{$layoutID}.tss-wrapper .tss-pagination ul.pagination-list li a,
						#{$layoutID}.tss-wrapper .tss-isotope-button-wrapper .rt-iso-button{";
					$css .= "background-color: {$button['bg']};";
					$css .= !empty($button['text']) ? "color: {$button['text']};" : null;
					$css .= "}";
				}

				if (!empty($button['hover_bg'])) {
					$css .= "#{$layoutID}.tss-wrapper .tss-carousel-main .swiper-arrow:hover,
							#{$layoutID}.tss-wrapper .tss-carousel-main .swiper-pagination-bullet:hover,
							#{$layoutID}.tss-wrapper .tss-carousel .swiper-arrow:hover,
							#{$layoutID}.tss-wrapper .tss-carousel .swiper-pagination-bullet:hover,
							#{$layoutID}.tss-wrapper .tss-utility button:hover,
							#{$layoutID}.tss-wrapper .tss-utility .rt-button:hover,
							#{$layoutID}.tss-wrapper .tss-pagination ul.pagination-list li a:hover,
							#{$layoutID}.tss-wrapper .tss-isotope-button-wrapper .rt-iso-button:hover{";
					$css .= "background-color: {$button['hover_bg']};";
					$css .= "}";
				}

				if (!empty($button['active_bg'])) {
					$css .= "#{$layoutID}.tss-wrapper .tss-carousel-main .swiper-pagination-bullet-active,
							#{$layoutID}.tss-wrapper .tss-carousel .swiper-pagination-bullet-active,
							#{$layoutID}.tss-wrapper .tss-pagination ul.pagination-list li.active span,
							#{$layoutID}.tss-wrapper .tss-isotope-button-wrapper .rt-iso-button.selected{";
					$css .= "background-color: {$button['active_bg']};";
					$css .= "}";
				}
				if (!empty($button['text'])) {
					$css .= "#{$layoutID}.tss-wrapper .tss-pagination ul.pagination-list li a,
							#{$layoutID}.tss-wrapper .tss-utility .rt-button{";
					$css .= "color: {$button['text']};";
					$css .= "}";
				}
				if (!empty($button['hover_text'])) {
					$css .= "#{$layoutID}.tss-wrapper .tss-pagination ul.pagination-list li a:hover,
								#{$layoutID}.tss-wrapper .tss-isotope-button-wrapper .rt-iso-button:hover,
								#{$layoutID}.tss-wrapper .tss-utility .rt-button:hover{";
					$css .= "color: {$button['hover_text']};";
					$css .= "}";
				}
				if (!empty($button['border'])) {
					$css .= "#{$layoutID}.tss-wrapper .tss-pagination ul.pagination-list li.active span,
								#{$layoutID}.tss-wrapper .tss-pagination ul.pagination-list li a,
								#{$layoutID}.tss-wrapper .tss-carousel-main .swiper-arrow,
								#{$layoutID}.tss-wrapper .tss-carousel .swiper-arrow {";
					$css .= "border-color: {$button['border']};";
					$css .= "}";
				}
			}

			/* Overlay
			.tss-wrapper , .tss-wrapper , .tss-wrapper */

			if ($overlay) {
				if (!empty($overlay['color'])) {
					$opacity = !empty($overlay['opacity']) ? esc_attr( $overlay['opacity'] ) / 100 : .9;
					$css .= "#{$layoutID}.tss-wrapper .tss-layout9 .profile-img-wrapper:before,
						#{$layoutID}.tss-wrapper .tss-isotope4 .profile-img-wrapper:before,
						#{$layoutID}.tss-wrapper .tss-carousel9 .profile-img-wrapper:before{";
					$css .= "background: " . $this->TLPhex2rgba($overlay['color'], $opacity) . ";";
					$css .= "}";
				}
			}

			//* image border style
			if ($imgBorder) {
				if (!empty($imgBorder['width'])) {
					$style = !empty($imgBorder['style']) ? esc_attr( $imgBorder['style'] ) : 'solid';
					$css .= "#$layoutID .profile-img-wrapper img {
							border-width: {$imgBorder['width']}px;
							border-style: {$style};
							}";
				}
				if (!empty($imgBorder['color'])) {
					$css .= "#$layoutID .profile-img-wrapper img { border-color: {$imgBorder['color']};}";
				}
			}


			// Isotope counter tooltip color
			if ($tooltipBg || $tooltipText) {
				$css .= "#tss-tooltip-{$layoutID}, #tss-tooltip-{$layoutID} .tss-tooltip-bottom:after {";
				$css .= ($tooltipBg ? "background: {$tooltipBg}; " : null);
				$css .= ($tooltipText ? "color: {$tooltipText};" : null);
				$css .= "}";
			}

			/* gutter */
			if ($gutter) {
				$css .= "#{$layoutID} [class*='rt-col-'] {";
				$css .= "padding-left : {$gutter}px;";
				$css .= "padding-right : {$gutter}px;";
				$css .= "margin-top : {$gutter}px;";
				$css .= "margin-bottom : {$gutter}px;";
				$css .= "}";
				$css .= "#{$layoutID} .rt-row{";
				$css .= "margin-left : -{$gutter}px;";
				$css .= "margin-right : -{$gutter}px;";
				$css .= "}";
				$css .= "#{$layoutID}.rt-container-fluid,#{$layoutID}.rt-container{";
				$css .= "padding-left : {$gutter}px;";
				$css .= "padding-right : {$gutter}px;";
				$css .= "}";
			}

			// Author name
			if (!empty($name) && is_array($name)) {
				$css .= "#{$layoutID}.tss-wrapper .single-item-wrapper h3.author-name,
						#{$layoutID}.tss-wrapper .single-item-wrapper h3.author-name a{";
				$css .= (!empty($name['color']) ? "color:" . $name['color'] . ";" : null);
				$css .= (!empty($name['align']) ? "text-align:" . $name['align'] . ";" : null);
				$css .= (!empty($name['weight']) ? "font-weight:" . $name['weight'] . ";" : null);
				$css .= (!empty($name['size']) ? "font-size:" . $name['size'] . "px;" : null);
				$css .= "}";
			}

			// Author bio
			if (!empty($author_bio) && is_array($author_bio)) {
				$css .= "#{$layoutID}.tss-wrapper .single-item-wrapper h4.author-bio{";
				$css .= (!empty($author_bio['color']) ? "color:" . $author_bio['color'] . ";" : null);
				$css .= (!empty($author_bio['align']) ? "text-align:" . $author_bio['align'] . ";" : null);
				$css .= (!empty($author_bio['weight']) ? "font-weight:" . $author_bio['weight'] . ";" : null);
				$css .= (!empty($author_bio['size']) ? "font-size:" . $author_bio['size'] . "px;" : null);
				$css .= "}";
			}


			// Rating
			if (!empty($rating) && is_array($rating)) {
				$css .= "#{$layoutID}.tss-wrapper .single-item-wrapper .rating-wrapper span.dashicons{";
				$css .= (!empty($rating['color']) ? "color:" . $rating['color'] . ";" : null);
				$css .= (!empty($rating['weight']) ? "font-weight:" . $rating['weight'] . ";" : null);
				$css .= (!empty($rating['size']) ? "font-size:" . $rating['size'] . "px;" : null);
				$css .= "}";
				$css .= "#{$layoutID}.tss-wrapper .single-item-wrapper .rating-wrapper {";
				$css .= (!empty($rating['align']) ? "text-align:" . $rating['align'] . ";" : null);
				$css .= "}";
			}

			// Social media
			if (!empty($social) && is_array($social)) {
				$css .= "#{$layoutID}.tss-wrapper .single-item-wrapper .author-social span.dashicons,
						#{$layoutID}.tss-wrapper .single-item-wrapper .author-social a:visited,
						#{$layoutID}.tss-wrapper .single-item-wrapper .author-social a{";
				$css .= (!empty($social['color']) ? "color:" . $social['color'] . ";" : null);
				$css .= (!empty($social['weight']) ? "font-weight:" . $social['weight'] . ";" : null);
				$css .= (!empty($social['size']) ? "font-size:" . $social['size'] . "px;" : null);
				$css .= "}";
				$css .= "#{$layoutID}.tss-wrapper .single-item-wrapper .author-social {";
				$css .= (!empty($social['align']) ? "text-align:" . $social['align'] . ";" : null);
				$css .= "}";
			}

			// Testimonial
			if (!empty($testimonial) && is_array($testimonial)) {
				$css .= "#{$layoutID}.tss-wrapper .single-item-wrapper .item-content{";
				$css .= (!empty($testimonial['color']) ? "color:" . $testimonial['color'] . ";" : null);
				$css .= (!empty($testimonial['align']) ? "text-align:" . $testimonial['align'] . ";" : null);
				$css .= (!empty($testimonial['weight']) ? "font-weight:" . $testimonial['weight'] . ";" : null);
				$css .= (!empty($testimonial['size']) ? "font-size:" . $testimonial['size'] . "px;" : null);
				$css .= (!empty($testimonial['style']) ? "font-style:" . $testimonial['style'] . ";" : null);
				$css .= "}";
			}

			// Overlay
			if ($overlay) {
				if (!empty($overlay['color'])) {
					$css .= "#{$layoutID}.tss-wrapper .tss-isotope1 .profile-img-wrapper:before{";
					$css .= "background:" . TSSPro()->TLPhex2rgba($overlay['color'],
							(!empty($overlay['opacity']) ? esc_attr($overlay['opacity']) / 100 : .8)) . ";";
					$css .= "}";
				}
			}
			$css .= "</style>";

			return $css;
		}

		function rtShare($iID, $scMeta, $scEl = null) {
			if (!$iID || (is_array($scMeta) && empty($scMeta))) {
				return;
			}
			if ( !function_exists('rttsp') ) return;

			$ssList = array();

			if( ! empty( $scEl ) ) {
				$ssList = array_map( 'sanitize_text_field', $scEl );
			} else if( ! empty( $scMeta['tss_el_social_share'] ) && ! empty( $scMeta['tss_el_social_share_items'] ) ) {
				$ssList = array_map( 'sanitize_text_field', $scMeta['tss_el_social_share_items'] );
			} else {
				$ssList = isset( $scMeta['social_share_items'] ) ? array_map( 'sanitize_text_field', $scMeta['social_share_items'] ) : [];
			}

			$permalink = get_the_permalink($iID);
			$title = get_the_title($iID);
			$content = get_post_field('post_content', $iID);
			$html = null;

			if (in_array('facebook', $ssList)) {
				$html .= "<a class='facebook' title='" . esc_html__("Share on facebook",
						"testimonial-slider-showcase") . "' target='_blank' href='https://www.facebook.com/sharer/sharer.php?u={$permalink}'><span class='dashicons dashicons-facebook-alt'></span></a>";
			}
			if (in_array('twitter', $ssList)) {
				$html .= "<a class='twitter' title='" . esc_html__("Share on twitter",
						"testimonial-slider-showcase") . "' target='_blank' href='http://www.twitter.com/intent/tweet?url={$permalink}'><i class='dashicons dashicons-twitter'></i></a>";
			}
			if (in_array('linkedin', $ssList)) {
				$html .= "<a class='linkedin' title='" . esc_html__("Share on linkedin",
						"testimonial-slider-showcase") . "' target='_blank' href='https://www.linkedin.com/shareArticle?mini=true&url={$permalink}'><i class='dashicons dashicons-linkedin'></i></a>";
			}
			if (in_array('pinterest', $ssList)) {
				$html .= "<a class='pinterest' title='" . esc_html__("Share on pinterest",
						"testimonial-slider-showcase") . "' target='_blank' href='https://pinterest.com/pin/create/button/?url={$permalink}'><i class='dashicons dashicons-pinterest'></i></a>";
			}
			if (in_array('email', $ssList)) {
				$html .= sprintf('<a class="email" title="%s" href="mailto:?subject=%s&body=%s"><span class="dashicons dashicons-email"></span></a>',
					esc_html__("Share on Email", "testimonial-slider-showcase"),
					$title,
					$content
				);
			}

			if ($html) {
				$html = "<div class='tss-social-share'>{$html}</div>";
			}

			return $html;
		}

		function tssGridLayouts() {
			return apply_filters(
				'rttss_elementor_grid_layouts',
				array(
					'layout1' => array(
						'title' => esc_html__( 'Layout 1', 'testimonial-slider-showcase' ),
						'url'   => TSSPro()->assetsUrl . 'images/layouts/layout1.png',
					),
					'layout2' => array(
						'title' => esc_html__( 'Layout 2', 'testimonial-slider-showcase' ),
						'url'   => TSSPro()->assetsUrl . 'images/layouts/layout2.png',
					),
				)
			);
		}

		function tssSliderLayout() {
			return apply_filters(
				'rttss_elementor_slider_layouts',
				array(
					'carousel1' => array(
						'title' => esc_html__( 'Carousel 1', 'testimonial-slider-showcase' ),
						'url'   => TSSPro()->assetsUrl . 'images/layouts/carousel1.png',
					),
					'carousel3' => array(
						'title' => esc_html__( 'Carousel 2', 'testimonial-slider-showcase' ),
						'url'   => TSSPro()->assetsUrl . 'images/layouts/carousel3.png',
					),
				)
			);
		}

		function tssGetImageTypes() {
			return apply_filters(
				'rttss_image_types',
				array(
					'normal' => __( 'Normal', 'testimonial-slider-showcase' ),
					'circle' => __( 'Circle', 'testimonial-slider-showcase' ),
				)
			);
		}

		function tssAllTestimonialPosts() {
			$posts = array();
			$args  = array(
				'post_type'      => array( TSSPro()->post_type ),
				'post_status'    => array( 'Publish' ),
				'order'          => 'DESC',
				'orderby'        => 'date',
				'posts_per_page' => -1,
			);

			$loop = new WP_Query( $args );

			if ( $loop->have_posts() ) {
				while ( $loop->have_posts() ) {
					$loop->the_post();
					$posts[ get_the_ID() ] = get_the_title();

				}
			} else {
				$posts['no-posts'] = __( 'No testimonials found', 'testimonial-slider-showcase' );
			}

			wp_reset_postdata();

			return $posts;
		}

		function tssPostsOrderBy() {
			$options = array(
				'menu_order' => __( 'Menu Order', 'testimonial-slider-showcase' ),
				'title'      => __( 'Name', 'testimonial-slider-showcase' ),
				'ID'         => __( 'ID', 'testimonial-slider-showcase' ),
				'date'       => __( 'Date', 'testimonial-slider-showcase' ),
			);

			if( function_exists( 'rttsp' ) ) {
				$options['rand'] = __( 'Random', 'testimonial-slider-showcase' );
			}

			return apply_filters(
				'rttss_post_orderby', $options );
		}

		function tssPostsOrder() {
			return array(
				'ASC'  => esc_html__( 'Ascending', 'testimonial-slider-showcase' ),
				'DESC' => esc_html__( 'Descending', 'testimonial-slider-showcase' ),
			);
		}

		function tssSliderAutoplayDelay() {
			return array(
				'8000' => __( '8 Seconds', 'testimonial-slider-showcase' ),
				'7000' => __( '7 Seconds', 'testimonial-slider-showcase' ),
				'6000' => __( '6 Seconds', 'testimonial-slider-showcase' ),
				'5000' => __( '5 Seconds', 'testimonial-slider-showcase' ),
				'4000' => __( '4 Seconds', 'testimonial-slider-showcase' ),
				'3000' => __( '3 Seconds', 'testimonial-slider-showcase' ),
				'2000' => __( '2 Seconds', 'testimonial-slider-showcase' ),
				'1000' => __( '1 Second', 'testimonial-slider-showcase' ),
			);
		}

		public function tssElContentVisibility( $settings ) {
			$visibility = array();

			if ( ! empty( $settings['tss_el_author'] ) ) {
				$visibility[] = 'author';
			}

			if ( ! empty( $settings['tss_el_author_img'] ) ) {
				$visibility[] = 'author_img';
			}

			if ( ! empty( $settings['tss_el_testimonial'] ) ) {
				$visibility[] = 'testimonial';
			}

			if ( ! empty( $settings['tss_el_designation'] ) ) {
				$visibility[] = 'designation';
			}

			if ( ! empty( $settings['tss_el_company'] ) ) {
				$visibility[] = 'company';
			}

			if ( ! empty( $settings['tss_el_location'] ) ) {
				$visibility[] = 'location';
			}

			if ( ! empty( $settings['tss_el_rating'] ) ) {
				$visibility[] = 'rating';
			}

			if ( ! empty( $settings['tss_el_social_media'] ) ) {
				$visibility[] = 'social_media';
			}

			if ( ! empty( $settings['tss_el_social_share'] ) ) {
				$visibility[] = 'social_share';
			}

			if ( ! empty( $settings['tss_el_read_more'] ) ) {
				$visibility[] = 'read_more';
			}

			return array_map( 'sanitize_text_field', $visibility );
		}

		function tssWordLimit( $limit, $link ) {
			$content = get_the_content();
			$limit++;

			$text = '';

			if ( mb_strlen( $content ) > $limit ) {
				$subex = mb_substr( $content, 0, $limit);
				$exwords = explode( ' ', $subex );
				$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );

				if ( $excut < 0 ) {
					$text .= mb_substr( $subex, 0, $excut );
				} else {
					$text .= $subex;
				}
				$text .= '...';
			} else {
				$text .= $content;
			}

			$text = $text . ' ' . $link;

			return $text;
		}
	}
endif;

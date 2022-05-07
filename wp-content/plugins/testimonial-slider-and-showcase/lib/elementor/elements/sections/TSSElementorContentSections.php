<?php
if ( ! class_exists( 'TSSElementorContentSections' ) ) :
	/**
	 * Grid Widget Elementor Content Tab Controls Class
	 */
	class TSSElementorContentSections {

		/**
		 * Accumulates tab fields.
		 *
		 * @access private
		 * @static
		 *
		 * @var array
		 */
		private $fields = array();

		/**
		 * Tab name.
		 *
		 * @access private
		 * @static
		 *
		 * @var array
		 */
		private $tab = \Elementor\Controls_Manager::TAB_CONTENT;

		/**
		 * Layout Section - Grid
		 *
		 * @return array
		 */
		public function gridLayout() {
			$this->fields[] = array(
				'mode'  => 'section_start',
				'id'    => 'tss_el_layout_section',
				'label' => __( 'Layout', 'testimonial-slider-showcase' ),
				'tab'   => $this->tab,
			);

			$this->fields[] = array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'id'              => 'tss_el_layout_note',
				'raw'             => sprintf(
					'<h3 class="tss-elementor-group-heading">%s</h3>',
					__( 'Select Layout', 'testimonial-slider-showcase' )
				),
				'content_classes' => 'elementor-panel-heading-title',
			);

			$this->fields[] = array(
				'type'    => 'tss-image-selector',
				'id'      => 'tss_el_layout_type',
				'options' => TSSPro()->tssGridLayouts(),
				'default' => 'layout1',
			);

			$this->fields[] = array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'id'              => 'tss_el_layout_col_note',
				'raw'             => sprintf(
					'<h3 class="tss-elementor-group-heading">%s</h3>',
					__( 'Responsive Columns', 'testimonial-slider-showcase' )
				),
				'content_classes' => 'elementor-panel-heading-title',
				'separator'       => 'before',
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'id'          => 'tss_el_cols',
				'mode'        => 'responsive',
				'label'       => __( 'Number of Columns', 'testimonial-slider-showcase' ),
				'description' => __( 'Please select the number of columns to show per row.', 'testimonial-slider-showcase' ),
				'options'     => TSSPro()->scColumns(),
				'default'     => 2,
				'required'    => true,
				'device_args' => array(
					\Elementor\Controls_Stack::RESPONSIVE_TABLET => array(
						'required' => false,
						'default'  => 2,
					),
					\Elementor\Controls_Stack::RESPONSIVE_MOBILE => array(
						'required' => false,
						'default'  => 1,
					),
				),
			);

			$this->fields = array_merge( apply_filters( 'rttss_elementor_before_grid_layout_end', $this->fields ) );

			$this->fields[] = array(
				'mode' => 'section_end',
			);

			return $this->fields;
		}

		/**
		 * Layout Section - Slider
		 *
		 * @return array
		 */
		public function sliderLayout() {
			$this->fields[] = array(
				'mode'  => 'section_start',
				'id'    => 'tss_el_layout_section',
				'label' => __( 'Layout', 'testimonial-slider-showcase' ),
				'tab'   => $this->tab,
			);

			$this->fields[] = array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'id'              => 'tss_el_layout_note',
				'raw'             => sprintf(
					'<h3 class="tss-elementor-group-heading">%s</h3>',
					__( 'Select Layout', 'testimonial-slider-showcase' )
				),
				'content_classes' => 'elementor-panel-heading-title',
			);

			$this->fields[] = array(
				'type'    => 'tss-image-selector',
				'id'      => 'tss_el_layout_type',
				'options' => TSSPro()->tssSliderLayout(),
				'default' => 'carousel1',
			);

			$this->fields[] = array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'id'              => 'tss_el_layout_col_note',
				'raw'             => sprintf(
					'<h3 class="tss-elementor-group-heading">%s</h3>',
					__( 'Responsive Columns', 'testimonial-slider-showcase' )
				),
				'content_classes' => 'elementor-panel-heading-title',
				'separator'       => 'before',
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'id'          => 'tss_el_cols',
				'mode'        => 'responsive',
				'label'       => __( 'Number of Columns', 'testimonial-slider-showcase' ),
				'description' => __( 'Please select the number of columns to show per row.', 'testimonial-slider-showcase' ),
				'options'     => TSSPro()->scColumns(),
				'default'     => 2,
				'required'    => true,
				'device_args' => array(
					\Elementor\Controls_Stack::RESPONSIVE_TABLET => array(
						'required' => false,
						'default'  => 2,
					),
					\Elementor\Controls_Stack::RESPONSIVE_MOBILE => array(
						'required' => false,
						'default'  => 1,
					),
				),
			);

			$this->fields = array_merge( apply_filters( 'rttss_elementor_before_slider_layout_end', $this->fields ) );

			$this->fields[] = array(
				'mode' => 'section_end',
			);

			return $this->fields;
		}


		/**
		 * Layout Section - Isotope
		 *
		 * @return array
		 */
		public function isotopeLayout() {
			$this->fields[] = array(
				'mode'  => 'section_start',
				'id'    => 'tss_el_layout_section',
				'label' => __( 'Layout', 'testimonial-slider-showcase' ),
				'tab'   => $this->tab,
			);

			$this->fields = array_merge( apply_filters( 'rttss_elementor_isotope_layouts', $this->fields ) );

			$this->fields[] = array(
				'mode' => 'section_end',
			);

			return $this->fields;
		}

		/**
		 * Isotope Section
		 *
		 * @return array
		 */
		public function isotope() {
			$this->fields[] = array(
				'mode'  => 'section_start',
				'id'    => 'tss_el_isotope_settings_section',
				'label' => __( 'Isotope Settings', 'testimonial-slider-showcase' ),
				'tab'   => $this->tab,
			);

			$this->fields = array_merge( apply_filters( 'rttss_elementor_isotope_settings', $this->fields ) );

			$this->fields[] = array(
				'mode' => 'section_end',
			);

			return $this->fields;
		}

		/**
		 * Pagination Section for Isotope.
		 *
		 * @return array
		 */
		public function paginationIso() {
			$this->fields[] = array(
				'mode'  => 'section_start',
				'id'    => 'tss_el_pagination_section',
				'label' => __( 'Pagination', 'testimonial-slider-showcase' ),
				'tab'   => $this->tab,
			);

			$this->fields[] = array(
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'id'           => 'tss_el_pagination',
				'label'        => __( 'Show Pagination?', 'testimonial-slider-showcase' ),
				'return_value' => 'yes',
				'description'  => __( 'Please enable the switch to display pagination.', 'testimonial-slider-showcase' ),
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'id'          => 'tss_el_pagination_per_page',
				'label'       => __( 'Number of Testimonials Per Page', 'testimonial-slider-showcase' ),
				'default'     => 5,
				'description' => __( 'Please enter the number of posts per page to show.', 'testimonial-slider-showcase' ),
				'separator'   => 'before',
				'condition'   => array( 'tss_el_pagination' => array( 'yes' ) ),
			);

			$this->fields = array_merge( apply_filters( 'rttss_elementor_before_pagination_end_iso', $this->fields ) );

			$this->fields[] = array(
				'mode' => 'section_end',
			);

			return $this->fields;
		}

		/**
		 * Pagination Section
		 *
		 * @return array
		 */
		public function pagination() {
			$this->fields[] = array(
				'mode'  => 'section_start',
				'id'    => 'tss_el_pagination_section',
				'label' => __( 'Pagination', 'testimonial-slider-showcase' ),
				'tab'   => $this->tab,
			);

			$this->fields[] = array(
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'id'           => 'tss_el_pagination',
				'label'        => __( 'Show Pagination?', 'testimonial-slider-showcase' ),
				'return_value' => 'yes',
				'description'  => __( 'Please enable the switch to display pagination.', 'testimonial-slider-showcase' ),
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'id'          => 'tss_el_pagination_per_page',
				'label'       => __( 'Number of Testimonials Per Page', 'testimonial-slider-showcase' ),
				'default'     => 5,
				'description' => __( 'Please enter the number of posts per page to show.', 'testimonial-slider-showcase' ),
				'separator'   => 'before',
				'condition'   => array( 'tss_el_pagination' => array( 'yes' ) ),
			);

			$this->fields = array_merge( apply_filters( 'rttss_elementor_before_pagination_end', $this->fields ) );

			$this->fields[] = array(
				'mode' => 'section_end',
			);

			return $this->fields;
		}

		/**
		 * Image Section
		 *
		 * @return array
		 */
		public function image() {
			$this->fields[] = array(
				'mode'  => 'section_start',
				'id'    => 'tss_el_image_section',
				'label' => __( 'Image', 'testimonial-slider-showcase' ),
				'tab'   => $this->tab,
			);

			$this->fields[] = array(
				'type'            => \Elementor\Controls_Manager::SELECT2,
				'id'              => 'tss_el_image',
				'label'           => __( 'Select Image Size', 'testimonial-slider-showcase' ),
				'options'         => TSSPro()->get_image_sizes(),
				'default'         => 'thumbnail',
				'label_block'     => true,
				'content_classes' => 'elementor-descriptor',
			);

			$this->fields = array_merge( apply_filters( 'rttss_elementor_before_image_end', $this->fields ) );

			$this->fields[] = array(
				'mode' => 'section_end',
			);

			return $this->fields;
		}

		/**
		 * Filtering Section
		 *
		 * @return array
		 */
		public function filtering() {
			$this->fields[] = array(
				'mode'  => 'section_start',
				'id'    => 'tss_el_filtering_section',
				'label' => __( 'Query', 'testimonial-slider-showcase' ),
				'tab'   => $this->tab,
			);

			$this->fields[] = array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'id'              => 'tss_el_filtering_note',
				'raw'             => sprintf(
					'<h3 class="tss-elementor-group-heading">%s</h3>',
					__( 'Filtering', 'testimonial-slider-showcase' )
				),
				'content_classes' => 'elementor-panel-heading-title',
			);

			$this->fields[] = array(
				'mode' => 'tabs_start',
				'id'   => 'tss_el_filtering_tab',
			);

			$this->fields[] = array(
				'mode'  => 'tab_start',
				'id'    => 'tss_el_filtering_include_tab',
				'label' => __( 'Include', 'testimonial-slider-showcase' ),
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'id'          => 'tss_el_include_posts',
				'label'       => __( 'Include Testimonials', 'testimonial-slider-showcase' ),
				'options'     => TSSPro()->tssAllTestimonialPosts(),
				'description' => __( 'Please select the testimonials to show. Leave it blank to include all posts.', 'testimonial-slider-showcase' ),
				'multiple'    => true,
				'label_block' => true,
			);

			$this->fields[] = array(
				'mode' => 'tab_end',
			);

			$this->fields[] = array(
				'mode'  => 'tab_start',
				'id'    => 'tss_el_filtering_exclude_tab',
				'label' => __( 'Exclude', 'testimonial-slider-showcase' ),
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'id'          => 'tss_el_exclude_posts',
				'label'       => __( 'Exclude Testimonials', 'testimonial-slider-showcase' ),
				'options'     => TSSPro()->tssAllTestimonialPosts(),
				'description' => __( 'Please select the testimonials to exclude. Leave it blank to exclude none.', 'testimonial-slider-showcase' ),
				'multiple'    => true,
				'label_block' => true,
			);

			$this->fields[] = array(
				'mode' => 'tab_end',
			);

			$this->fields[] = array(
				'mode' => 'tabs_end',
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'id'          => 'tss_el_posts_limit',
				'label'       => __( 'Posts Limit', 'testimonial-slider-showcase' ),
				'description' => __( 'The number of testimonials to show. Set empty to show all testimonials.', 'testimonial-slider-showcase' ),
				'default'     => 8,
			);

			$this->fields = array_merge( apply_filters( 'rttss_elementor_before_sorting_control', $this->fields ) );

			$this->fields[] = array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'id'              => 'tss_el_sorting_note',
				'raw'             => sprintf(
					'<h3 class="tss-elementor-group-heading">%s</h3>',
					__( 'Sorting', 'testimonial-slider-showcase' )
				),
				'content_classes' => 'elementor-panel-heading-title',
				'separator'       => 'before',
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'id'          => 'tss_el_posts_order_by',
				'label'       => __( 'Order By', 'testimonial-slider-showcase' ),
				'description' => __( 'Please choose to reorder to testimonials.', 'testimonial-slider-showcase' ),
				'options'     => TSSPro()->tssPostsOrderBy(),
				'default'     => 'date',
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'id'          => 'tss_el_posts_order',
				'label'       => __( 'Order', 'testimonial-slider-showcase' ),
				'description' => __( 'Please choose to reorder to testimonials.', 'testimonial-slider-showcase' ),
				'options'     => TSSPro()->tssPostsOrder(),
				'default'     => 'DESC',
			);

			$this->fields[] = array(
				'mode' => 'section_end',
			);

			return $this->fields;
		}

		/**
		 * Content Visibility Section
		 *
		 * @return array
		 */
		public function contentVisibility() {
			$this->fields[] = array(
				'mode'  => 'section_start',
				'id'    => 'tss_el_field_display_section',
				'label' => __( 'Content Visibility', 'testimonial-slider-showcase' ),
				'tab'   => $this->tab,
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'id'          => 'tss_el_author',
				'label'       => __( 'Show Author Name', 'testimonial-slider-showcase' ),
				'label_on'    => __( 'On', 'testimonial-slider-showcase' ),
				'label_off'   => __( 'Off', 'testimonial-slider-showcase' ),
				'default'     => 'yes',
				'description' => __( 'Switch on to display author name.', 'testimonial-slider-showcase' ),
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'id'          => 'tss_el_author_img',
				'label'       => __( 'Show Author Image', 'testimonial-slider-showcase' ),
				'label_on'    => __( 'On', 'testimonial-slider-showcase' ),
				'label_off'   => __( 'Off', 'testimonial-slider-showcase' ),
				'default'     => 'yes',
				'separator'   => 'before',
				'description' => __( 'Switch on to display author image.', 'testimonial-slider-showcase' ),
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'id'          => 'tss_el_testimonial',
				'label'       => __( 'Show Testimonial Text', 'testimonial-slider-showcase' ),
				'label_on'    => __( 'On', 'testimonial-slider-showcase' ),
				'label_off'   => __( 'Off', 'testimonial-slider-showcase' ),
				'default'     => 'yes',
				'separator'   => 'before',
				'description' => __( 'Switch on to display testimonial text.', 'testimonial-slider-showcase' ),
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'id'          => 'tss_el_designation',
				'label'       => __( 'Show Designation', 'testimonial-slider-showcase' ),
				'label_on'    => __( 'On', 'testimonial-slider-showcase' ),
				'label_off'   => __( 'Off', 'testimonial-slider-showcase' ),
				'default'     => 'yes',
				'separator'   => 'before',
				'description' => __( 'Switch on to display author designation.', 'testimonial-slider-showcase' ),
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'id'          => 'tss_el_company',
				'label'       => __( 'Show Company Name', 'testimonial-slider-showcase' ),
				'label_on'    => __( 'On', 'testimonial-slider-showcase' ),
				'label_off'   => __( 'Off', 'testimonial-slider-showcase' ),
				'default'     => 'yes',
				'separator'   => 'before',
				'description' => __( 'Switch on to display company name.', 'testimonial-slider-showcase' ),
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'id'          => 'tss_el_location',
				'label'       => __( 'Show Location Name', 'testimonial-slider-showcase' ),
				'label_on'    => __( 'On', 'testimonial-slider-showcase' ),
				'label_off'   => __( 'Off', 'testimonial-slider-showcase' ),
				'default'     => 'yes',
				'separator'   => 'before',
				'description' => __( 'Switch on to display location name.', 'testimonial-slider-showcase' ),
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'id'          => 'tss_el_rating',
				'label'       => __( 'Show Rating', 'testimonial-slider-showcase' ),
				'label_on'    => __( 'On', 'testimonial-slider-showcase' ),
				'label_off'   => __( 'Off', 'testimonial-slider-showcase' ),
				'default'     => 'yes',
				'separator'   => 'before',
				'description' => __( 'Switch on to display author rating.', 'testimonial-slider-showcase' ),
			);

			$this->fields = array_merge( apply_filters( 'rttss_elementor_before_visibility_end', $this->fields ) );

			$this->fields[] = array(
				'mode' => 'section_end',
			);

			return $this->fields;
		}

		/**
		 * Text Limit Section
		 *
		 * @return array
		 */
		public function textLimit() {
			$this->fields[] = array(
				'mode'  => 'section_start',
				'id'    => 'tss_el_text_limit_section',
				'label' => __( 'Content Limit', 'testimonial-slider-showcase' ),
				'tab'   => $this->tab,
			);

			$this->fields[] = array(
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'id'           => 'tss_el_text_limit',
				'label'        => __( 'Limit Testimonial Content?', 'testimonial-slider-showcase' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'description'  => __( 'Switch on to limit testimonial content.', 'testimonial-slider-showcase' ),
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'id'          => 'tss_el_testimonial_text_limit',
				'label'       => __( 'Content Limit', 'testimonial-slider-showcase' ),
				'description' => __( 'Limits the testimonial text (letter limit). Leave it blank for full text.', 'testimonial-slider-showcase' ),
				'separator'   => 'before',
				'condition'   => array( 'tss_el_text_limit' => array( 'yes' ) ),
			);

			$this->fields = array_merge( apply_filters( 'rttss_elementor_before_content_limit_end', $this->fields ) );

			$this->fields[] = array(
				'mode' => 'section_end',
			);

			return $this->fields;
		}

		/**
		 * Slider Section
		 *
		 * @return array
		 */
		public function slider() {
			$this->fields[] = array(
				'mode'  => 'section_start',
				'id'    => 'tss_el_slider_section',
				'label' => __( 'Slider Settings', 'testimonial-slider-showcase' ),
				'tab'   => $this->tab,
			);

			$this->fields[] = array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'id'              => 'tss_el_slider_control_note',
				'raw'             => sprintf(
					'<h3 class="tss-elementor-group-heading">%s</h3>',
					__( 'Controls', 'testimonial-slider-showcase' )
				),
				'content_classes' => 'elementor-panel-heading-title',
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'id'          => 'tss_el_slider_loop',
				'label'       => __( 'Infinite Loop', 'testimonial-slider-showcase' ),
				'label_on'    => __( 'On', 'testimonial-slider-showcase' ),
				'label_off'   => __( 'Off', 'testimonial-slider-showcase' ),
				'description' => __( 'Switch on to enable slider infinite loop.', 'testimonial-slider-showcase' ),
				'condition'   => array( 'tss_el_layout_type!' => array( 'carousel11', 'carousel12' ) ),
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'id'          => 'tss_el_slider_nav',
				'label'       => __( 'Navigation Arrows', 'testimonial-slider-showcase' ),
				'label_on'    => __( 'On', 'testimonial-slider-showcase' ),
				'label_off'   => __( 'Off', 'testimonial-slider-showcase' ),
				'description' => __( 'Switch on to enable slider navigation arrows.', 'testimonial-slider-showcase' ),
				'default'     => 'yes',
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'id'          => 'tss_el_slider_pagi',
				'label'       => __( 'Dot Pagination', 'testimonial-slider-showcase' ),
				'label_on'    => __( 'On', 'testimonial-slider-showcase' ),
				'label_off'   => __( 'Off', 'testimonial-slider-showcase' ),
				'default'     => 'yes',
				'description' => __( 'Switch on to enable slider dot pagination.', 'testimonial-slider-showcase' ),
				'condition'   => array( 'tss_el_layout_type!' => array( 'carousel11', 'carousel12' ) ),
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'id'          => 'tss_el_slider_auto_height',
				'label'       => __( 'Auto Height', 'testimonial-slider-showcase' ),
				'label_on'    => __( 'On', 'testimonial-slider-showcase' ),
				'label_off'   => __( 'Off', 'testimonial-slider-showcase' ),
				'description' => __( 'Switch on to enable slider dynamic height.', 'testimonial-slider-showcase' ),
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'id'          => 'tss_el_slider_lazy_load',
				'label'       => __( 'Image Lazy Load', 'testimonial-slider-showcase' ),
				'label_on'    => __( 'On', 'testimonial-slider-showcase' ),
				'label_off'   => __( 'Off', 'testimonial-slider-showcase' ),
				'description' => __( 'Switch on to enable slider image lazy load.', 'testimonial-slider-showcase' ),
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'id'          => 'tss_el_slide_speed',
				'label'       => __( 'Slide Speed (in ms)', 'testimonial-slider-showcase' ),
				'description' => __( 'Please enter the duration of transition between slides (in ms).', 'testimonial-slider-showcase' ),
				'default'     => 2000,
			);

			$this->fields[] = array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'id'              => 'tss_el_slider_autoplay_note',
				'raw'             => sprintf(
					'<h3 class="tss-elementor-group-heading">%s</h3>',
					__( 'Autoplay', 'testimonial-slider-showcase' )
				),
				'content_classes' => 'elementor-panel-heading-title',
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'id'          => 'tss_el_slide_autoplay',
				'label'       => __( 'Enable Autoplay?', 'testimonial-slider-showcase' ),
				'label_on'    => __( 'On', 'testimonial-slider-showcase' ),
				'label_off'   => __( 'Off', 'testimonial-slider-showcase' ),
				'default'     => 'yes',
				'description' => __( 'Switch on to enable slider autoplay.', 'testimonial-slider-showcase' ),
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'id'          => 'tss_el_pause_hover',
				'label'       => __( 'Pause on Mouse Hover?', 'testimonial-slider-showcase' ),
				'label_on'    => __( 'On', 'testimonial-slider-showcase' ),
				'label_off'   => __( 'Off', 'testimonial-slider-showcase' ),
				'description' => __( 'Switch on to enable slider autoplay pause on mouse hover.', 'testimonial-slider-showcase' ),
				'default'     => 'yes',
				'condition'   => array( 'tss_el_slide_autoplay' => 'yes' ),
			);

			$this->fields[] = array(
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'id'          => 'tss_el_autoplay_timeout',
				'label'       => __( 'Autoplay Delay', 'testimonial-slider-showcase' ),
				'options'     => TSSPro()->tssSliderAutoplayDelay(),
				'default'     => '5000',
				'description' => __( 'Please select autoplay interval delay', 'testimonial-slider-showcase' ),
				'condition'   => array( 'tss_el_slide_autoplay' => 'yes' ),
			);

			$this->fields[] = array(
				'mode' => 'section_end',
			);

			return $this->fields;
		}
	}
endif;

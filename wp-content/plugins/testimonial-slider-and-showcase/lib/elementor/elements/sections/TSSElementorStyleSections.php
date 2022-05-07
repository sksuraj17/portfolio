<?php
if ( ! class_exists( 'TSSElementorStyleSections' ) ) :
	/**
	 *
	 */
	class TSSElementorStyleSections {

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
		private $tab = \Elementor\Controls_Manager::TAB_STYLE;

		/**
		 * Colors Section
		 *
		 * @return array
		 */
		public function colors( $condition = null ) {
			$this->fields[] = array(
				'mode'  => 'section_start',
				'id'    => 'tss_el_color_section',
				'label' => __( 'Colors', 'testimonial-slider-showcase' ),
				'tab'   => $this->tab,
			);

			$this->fields[] = array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'id'              => 'tss_el_color_note',
				'raw'             => sprintf(
					'<h3 class="tss-elementor-group-heading">%s</h3>',
					__( 'Color Scheme', 'testimonial-slider-showcase' )
				),
				'content_classes' => 'elementor-panel-heading-title',
			);

			$this->fields[] = array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'id'        => 'tss_el_primary_color',
				'label'     => __( 'Quote Icon', 'testimonial-slider-showcase' ),
				'selectors' => array(
					'{{WRAPPER}} .tss-wrapper .tss-isotope1 .profile-img-wrapper:after, {{WRAPPER}} .tss-wrapper .tss-layout9 .profile-img-wrapper:after, {{WRAPPER}} .tss-wrapper .tss-isotope4 .profile-img-wrapper:after, {{WRAPPER}} .tss-wrapper .tss-carousel9 .profile-img-wrapper:after' => 'background: {{VALUE}}',
					'{{WRAPPER}} .tss-wrapper .item-content-wrapper:before, {{WRAPPER}} .tss-wrapper .item-content-wrapper:before, {{WRAPPER}} .tss-wrapper .single-item-wrapper:before' => 'color: {{VALUE}}',
				),
			);

			$this->fields[] = array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'id'        => 'tss_el_author_name_color',
				'label'     => __( 'Author Name', 'testimonial-slider-showcase' ),
				'selectors' => array(
					'{{WRAPPER}} .tss-wrapper .single-item-wrapper h3.author-name, {{WRAPPER}} .tss-wrapper .single-item-wrapper h3.author-name a' => 'color: {{VALUE}}',
				),
			);

			$this->fields[] = array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'id'        => 'tss_el_author_bio_color',
				'label'     => __( 'Author Bio', 'testimonial-slider-showcase' ),
				'selectors' => array(
					'{{WRAPPER}} .tss-wrapper .single-item-wrapper h4.author-bio' => 'color: {{VALUE}}',
				),
			);

			$this->fields[] = array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'id'        => 'tss_el_rating_color',
				'label'     => __( 'Rating', 'testimonial-slider-showcase' ),
				'selectors' => array(
					'{{WRAPPER}} .tss-wrapper .single-item-wrapper .rating-wrapper span.dashicons' => 'color: {{VALUE}}',
				),
			);

			$this->fields[] = array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'id'        => 'tss_el_testimonial_text_color',
				'label'     => __( 'Testimonial Text', 'testimonial-slider-showcase' ),
				'selectors' => array(
					'{{WRAPPER}} .tss-wrapper .single-item-wrapper .item-content' => 'color: {{VALUE}}',
				),
			);

			$this->fields = array_merge( apply_filters( 'rttss_elementor_style_color_scheme', $this->fields ) );

			$this->buttonColors( $condition );

			$this->fields = array_merge( apply_filters( 'rttss_elementor_before_colors_end', $this->fields ) );

			$this->fields[] = array(
				'mode' => 'section_end',
			);

			return $this->fields;
		}

		/**
		 * Button Colors.
		 *
		 * @return array
		 */
		public function buttonColors( $condition = null ) {
			$this->fields[] = array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'id'              => 'tss_el_button_note',
				'raw'             => sprintf(
					'<h3 class="tss-elementor-group-heading">%s</h3>',
					__( 'Button Colors', 'testimonial-slider-showcase' )
				),
				'separator'       => 'before',
				'content_classes' => 'elementor-panel-heading-title',
				'conditions'      => $this->buttonCondition( $condition ),
			);

			$this->fields[] = array(
				'mode'       => 'tabs_start',
				'id'         => 'tss_el_button_colors',
				'conditions' => $this->buttonCondition( $condition ),
			);

			$this->fields[] = array(
				'mode'       => 'tab_start',
				'id'         => 'tss_el_button_colors_normal',
				'label'      => __( 'Normal', 'testimonial-slider-showcase' ),
				'conditions' => $this->buttonCondition( $condition ),
			);

			$this->fields[] = array(
				'type'       => \Elementor\Controls_Manager::COLOR,
				'id'         => 'tss_el_button_bg_color',
				'label'      => __( 'Background Color', 'testimonial-slider-showcase' ),
				'selectors'  => array(
					'{{WRAPPER}} .tss-wrapper .tss-utility button, {{WRAPPER}} .tss-wrapper .tss-carousel-main .swiper-arrow, {{WRAPPER}} .tss-wrapper .tss-carousel-main .swiper-pagination-bullet, {{WRAPPER}} .tss-wrapper .tss-carousel .swiper-arrow, {{WRAPPER}} .tss-wrapper .tss-carousel .swiper-pagination-bullet, {{WRAPPER}} .tss-wrapper .tss-utility .rt-button, {{WRAPPER}} .tss-wrapper .tss-pagination ul.pagination-list li a, {{WRAPPER}} .tss-wrapper .tss-isotope-button-wrapper .rt-iso-button' => 'background-color: {{VALUE}}',
				),
				'conditions' => $this->buttonCondition( $condition ),

			);

			$this->fields[] = array(
				'type'       => \Elementor\Controls_Manager::COLOR,
				'id'         => 'tss_el_button_text_color',
				'label'      => __( 'Text Color', 'testimonial-slider-showcase' ),
				'selectors'  => array(
					'{{WRAPPER}} .tss-wrapper .tss-pagination ul.pagination-list li a, {{WRAPPER}} .tss-wrapper .tss-utility .rt-button, {{WRAPPER}} .tss-carousel-main .swiper-arrow > i, {{WRAPPER}} .tss-carousel .swiper-arrow > i, {{WRAPPER}} .tss-wrapper .tss-utility .rt-button, {{WRAPPER}} .tss-wrapper .tss-isotope-button-wrapper .rt-iso-button' => 'color: {{VALUE}}',
				),
				'conditions' => $this->buttonCondition( $condition ),
			);

			$this->fields[] = array(
				'type'       => \Elementor\Group_Control_Border::get_type(),
				'id'         => 'tss_el_button_border',
				'mode'       => 'group',
				'label'      => __( 'Border', 'testimonial-slider-showcase' ),
				'selector'   => '{{WRAPPER}} .tss-wrapper .tss-pagination ul.pagination-list li.active span, {{WRAPPER}} .tss-wrapper .tss-pagination ul.pagination-list li a, {{WRAPPER}} .tss-wrapper .tss-carousel-main .swiper-arrow, {{WRAPPER}} .tss-wrapper .tss-carousel .swiper-arrow, {{WRAPPER}} .tss-wrapper .tss-utility .rt-button, {{WRAPPER}} .tss-wrapper .tss-utility .rt-button, {{WRAPPER}} .tss-wrapper .tss-isotope-button-wrapper .rt-iso-button',
				'conditions' => $this->buttonCondition( $condition ),
			);

			$this->fields[] = array(
				'mode'       => 'tab_end',
				'conditions' => $this->buttonCondition( $condition ),
			);

			$this->fields[] = array(
				'mode'       => 'tab_start',
				'id'         => 'tss_el_button_colors_hover',
				'label'      => __( 'Hover', 'testimonial-slider-showcase' ),
				'conditions' => $this->buttonCondition( $condition ),
			);

			$this->fields[] = array(
				'type'       => \Elementor\Controls_Manager::COLOR,
				'id'         => 'tss_el_button_bg_color_hover',
				'label'      => __( 'Background Color', 'testimonial-slider-showcase' ),
				'selectors'  => array(
					'{{WRAPPER}} .tss-wrapper .tss-carousel-main .swiper-arrow:hover, {{WRAPPER}} .tss-wrapper .tss-carousel-main .swiper-pagination-bullet:hover, {{WRAPPER}} .tss-wrapper .tss-carousel .swiper-arrow:hover, {{WRAPPER}} .tss-wrapper .tss-carousel .swiper-pagination-bullet:hover, {{WRAPPER}} .tss-wrapper .tss-utility button:hover, {{WRAPPER}} .tss-wrapper .tss-utility .rt-button:hover, {{WRAPPER}} .tss-wrapper .tss-pagination ul.pagination-list li a:hover, {{WRAPPER}} .tss-wrapper .tss-isotope-button-wrapper .rt-iso-button:hover' => 'background-color: {{VALUE}}',
				),
				'conditions' => $this->buttonCondition( $condition ),
			);

			$this->fields[] = array(
				'type'       => \Elementor\Controls_Manager::COLOR,
				'id'         => 'tss_el_button_text_color_hover',
				'label'      => __( 'Text Color', 'testimonial-slider-showcase' ),
				'selectors'  => array(
					'{{WRAPPER}} .tss-wrapper .tss-pagination ul.pagination-list li a:hover, {{WRAPPER}} .tss-wrapper .tss-isotope-button-wrapper .rt-iso-button:hover, {{WRAPPER}} .tss-wrapper .tss-utility .rt-button:hover, {{WRAPPER}} .tss-carousel-main .swiper-arrow:hover > i, {{WRAPPER}} .tss-carousel .swiper-arrow:hover > i' => 'color: {{VALUE}}',
				),
				'conditions' => $this->buttonCondition( $condition ),
			);

			$this->fields[] = array(
				'type'       => \Elementor\Controls_Manager::COLOR,
				'id'         => 'tss_el_button_border_color_hover',
				'label'      => __( 'Border Color', 'testimonial-slider-showcase' ),
				'selectors'  => array(
					'{{WRAPPER}} .tss-wrapper .tss-pagination ul.pagination-list li a:hover, {{WRAPPER}} .tss-wrapper .tss-carousel-main .swiper-arrow:hover, {{WRAPPER}} .tss-wrapper .tss-carousel .swiper-arrow:hover, {{WRAPPER}} .tss-wrapper .tss-utility .rt-button:hover, {{WRAPPER}} .tss-wrapper .tss-utility .rt-button:hover, {{WRAPPER}} .tss-wrapper .tss-isotope-button-wrapper .rt-iso-button:hover' => 'border-color: {{VALUE}}',
				),
				'conditions' => $this->buttonCondition( $condition ),
			);

			$this->fields[] = array(
				'mode'       => 'tab_end',
				'conditions' => $this->buttonCondition( $condition ),
			);

			$this->fields[] = array(
				'mode'       => 'tab_start',
				'id'         => 'tss_el_button_colors_active',
				'label'      => __( 'Active', 'testimonial-slider-showcase' ),
				'conditions' => $this->buttonCondition( $condition ),
			);

			$this->fields[] = array(
				'type'       => \Elementor\Controls_Manager::COLOR,
				'id'         => 'tss_el_button_bg_color_active',
				'label'      => __( 'Background Color', 'testimonial-slider-showcase' ),
				'selectors'  => array(
					'{{WRAPPER}} .tss-wrapper .tss-carousel-main .swiper-pagination-bullet-active, {{WRAPPER}} .tss-wrapper .tss-carousel .swiper-pagination-bullet-active, {{WRAPPER}} .tss-wrapper .tss-pagination ul.pagination-list li.active span, {{WRAPPER}} .tss-wrapper .tss-isotope-button-wrapper .rt-iso-button.selected' => 'background-color: {{VALUE}}',
				),
				'conditions' => $this->buttonCondition( $condition ),
			);

			$this->fields[] = array(
				'type'       => \Elementor\Controls_Manager::COLOR,
				'id'         => 'tss_el_button_text_color_active',
				'label'      => __( 'Text Color', 'testimonial-slider-showcase' ),
				'selectors'  => array(
					'{{WRAPPER}} .tss-wrapper .slick-dots li.slick-active button, {{WRAPPER}} .tss-wrapper .tss-pagination ul.pagination-list li.active span, {{WRAPPER}} .tss-wrapper .tss-isotope-button-wrapper .rt-iso-button.selected' => 'color: {{VALUE}}',
				),
				'conditions' => $this->buttonCondition( $condition ),
			);

			$this->fields[] = array(
				'type'       => \Elementor\Controls_Manager::COLOR,
				'id'         => 'tss_el_button_border_color_active',
				'label'      => __( 'Border Color', 'testimonial-slider-showcase' ),
				'selectors'  => array(
					'{{WRAPPER}} .tss-wrapper .tss-carousel-main .swiper-pagination-bullet-active, {{WRAPPER}} .tss-wrapper .tss-carousel .swiper-pagination-bullet-active, {{WRAPPER}} .tss-wrapper .tss-pagination ul.pagination-list li.active span, {{WRAPPER}} .tss-wrapper .tss-isotope-button-wrapper .rt-iso-button.selected' => 'border-color: {{VALUE}}',
				),
				'conditions' => $this->buttonCondition( $condition ),
			);

			$this->fields[] = array(
				'mode'       => 'tab_end',
				'conditions' => $this->buttonCondition( $condition ),
			);

			$this->fields[] = array(
				'mode'       => 'tabs_end',
				'conditions' => $this->buttonCondition( $condition ),
			);

			return $this->fields;
		}

		/**
		 * Typography Section
		 *
		 * @return array
		 */
		public function typography() {
			$this->fields[] = array(
				'mode'  => 'section_start',
				'id'    => 'tss_el_typography_section',
				'label' => __( 'Typography', 'testimonial-slider-showcase' ),
				'tab'   => $this->tab,
			);

			$this->fields[] = array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'id'              => 'tss_el_author_name_note',
				'raw'             => sprintf(
					'<h3 class="tss-elementor-group-heading">%s</h3>',
					__( 'Author Name', 'testimonial-slider-showcase' )
				),
				'content_classes' => 'elementor-panel-heading-title',
			);

			$this->fields[] = array(
				'mode'     => 'group',
				'id'       => 'tss_el_author_name_typography',
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => '{{WRAPPER}} .tss-wrapper .single-item-wrapper h3.author-name, {{WRAPPER}} .tss-wrapper .single-item-wrapper h3.author-name a',
			);

			$this->fields[] = array(
				'mode'      => 'responsive',
				'id'        => 'tss_el_author_name_alignment',
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'label'     => __( 'Alignment', 'testimonial-slider-showcase' ),
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'testimonial-slider-showcase' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'testimonial-slider-showcase' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'testimonial-slider-showcase' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .tss-wrapper .single-item-wrapper h3.author-name, {{WRAPPER}} .tss-wrapper .single-item-wrapper h3.author-name a' => 'text-align: {{VALUE}}',
				),
			);

			$this->fields[] = array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'id'         => 'tss_el_author_name_margin',
				'mode'       => 'responsive',
				'label'      => __( 'Spacing', 'testimonial-slider-showcase' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .tss-wrapper .single-item-wrapper h3.author-name, {{WRAPPER}} .tss-wrapper .single-item-wrapper h3.author-name a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			);

			$this->fields[] = array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'id'              => 'tss_el_author_bio_note',
				'raw'             => sprintf(
					'<h3 class="tss-elementor-group-heading">%s</h3>',
					__( 'Author Bio', 'testimonial-slider-showcase' )
				),
				'separator'       => 'before',
				'content_classes' => 'elementor-panel-heading-title',
			);

			$this->fields[] = array(
				'mode'     => 'group',
				'id'       => 'tss_el_author_bio_typography',
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => '{{WRAPPER}} .tss-wrapper .single-item-wrapper h4.author-bio',
			);

			$this->fields[] = array(
				'mode'      => 'responsive',
				'id'        => 'tss_el_author_bio_alignment',
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'label'     => __( 'Alignment', 'testimonial-slider-showcase' ),
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'testimonial-slider-showcase' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'testimonial-slider-showcase' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'testimonial-slider-showcase' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .tss-wrapper .single-item-wrapper h4.author-bio' => 'text-align: {{VALUE}}',
				),
			);

			$this->fields[] = array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'id'         => 'tss_el_author_bio_margin',
				'mode'       => 'responsive',
				'label'      => __( 'Spacing', 'testimonial-slider-showcase' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .tss-wrapper .single-item-wrapper h4.author-bio' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			);

			$this->fields[] = array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'id'              => 'tss_el_rating_note',
				'raw'             => sprintf(
					'<h3 class="tss-elementor-group-heading">%s</h3>',
					__( 'Rating', 'testimonial-slider-showcase' )
				),
				'separator'       => 'before',
				'content_classes' => 'elementor-panel-heading-title',
			);

			$this->fields[] = array(
				'mode'     => 'group',
				'id'       => 'tss_el_rating_typography',
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => '{{WRAPPER}} .tss-wrapper .single-item-wrapper .rating-wrapper span.dashicons',
				'exclude'  => array( 'font_family', 'letter_spacing', 'text_transform', 'font_style', 'text_decoration', 'line_height' ),
			);

			$this->fields[] = array(
				'mode'      => 'responsive',
				'id'        => 'tss_el_rating_alignment',
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'label'     => __( 'Alignment', 'testimonial-slider-showcase' ),
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'testimonial-slider-showcase' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'testimonial-slider-showcase' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'testimonial-slider-showcase' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .tss-wrapper .single-item-wrapper .rating-wrapper' => 'text-align: {{VALUE}}',
				),
			);

			$this->fields[] = array(
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'id'         => 'tss_el_rating_spacing',
				'mode'       => 'responsive',
				'label'      => esc_html__( 'Icon Spacing', 'testimonial-slider-showcase' ),
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array( 'max' => 100 ),
					'%'  => array( 'max' => 100 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .tss-wrapper .single-item-wrapper .rating-wrapper span.dashicons' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}  .tss-wrapper .single-item-wrapper .rating-wrapper span.dashicons' => 'margin-right: {{SIZE}}{{UNIT}};',
				),
			);

			$this->fields[] = array(
				'type'               => \Elementor\Controls_Manager::DIMENSIONS,
				'id'                 => 'tss_el_rating_margin',
				'mode'               => 'responsive',
				'label'              => __( 'Spacing', 'testimonial-slider-showcase' ),
				'size_units'         => array( 'px', '%', 'em' ),
				'allowed_dimensions' => array( 'top', 'bottom' ),
				'selectors'          => array(
					'{{WRAPPER}} .tss-wrapper .single-item-wrapper .rating-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			);

			$this->fields[] = array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'id'              => 'tss_el_testimonial_text_note',
				'raw'             => sprintf(
					'<h3 class="tss-elementor-group-heading">%s</h3>',
					__( 'Testimonial Text', 'testimonial-slider-showcase' )
				),
				'separator'       => 'before',
				'content_classes' => 'elementor-panel-heading-title',
			);

			$this->fields[] = array(
				'mode'     => 'group',
				'id'       => 'tss_el_testimonial_text_typography',
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => '{{WRAPPER}} .tss-wrapper .single-item-wrapper .item-content',
			);

			$this->fields[] = array(
				'mode'      => 'responsive',
				'id'        => 'tss_el_testimonial_text_alignment',
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'label'     => __( 'Alignment', 'testimonial-slider-showcase' ),
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'testimonial-slider-showcase' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'testimonial-slider-showcase' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'testimonial-slider-showcase' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'selectors' => array(
					'{{WRAPPER}} .tss-wrapper .single-item-wrapper .item-content' => 'text-align: {{VALUE}}',
				),
			);

			$this->fields[] = array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'id'         => 'tss_el_testimonial_text_margin',
				'mode'       => 'responsive',
				'label'      => __( 'Spacing', 'testimonial-slider-showcase' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .tss-wrapper .single-item-wrapper .item-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			);

			$this->fields = array_merge( apply_filters( 'rttss_elementor_typography_end', $this->fields ) );

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
				'id'    => 'tss_el_image_styles_section',
				'label' => __( 'Image Style', 'testimonial-slider-showcase' ),
				'tab'   => $this->tab,
			);

			$this->fields[] = array(
				'type'     => \Elementor\Group_Control_Border::get_type(),
				'id'       => 'tss_el_image_border',
				'mode'     => 'group',
				'label'    => __( 'Border', 'testimonial-slider-showcase' ),
				'selector' => '{{WRAPPER}} .tss-wrapper .rt-responsive-img',
			);

			$this->fields = array_merge( apply_filters( 'rttss_elementor_before_image_border', $this->fields ) );

			$this->fields[] = array(
				'id'         => 'tss_el_grid_image_border-radius',
				'mode'       => 'responsive',
				'label'      => __( 'Border Radius', 'testimonial-slider-showcase' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'      => '50',
					'right'    => '50',
					'bottom'   => '50',
					'left'     => '50',
					'unit'     => '%',
					'isLinked' => true,
				),
				'separator'  => 'before',
				'selectors'  => array(
					'{{WRAPPER}} .tss-wrapper .rt-responsive-img, {{WRAPPER}} .tss-wrapper .tss-layout9 .profile-img-wrapper:before, {{WRAPPER}} .tss-wrapper .tss-isotope4 .profile-img-wrapper:before, {{WRAPPER}} .tss-wrapper .tss-carousel9 .profile-img-wrapper:before, {{WRAPPER}} .tss-wrapper .tss-layout9 .profile-img-wrapper:after, {{WRAPPER}} .tss-wrapper .tss-isotope4 .profile-img-wrapper:after, {{WRAPPER}} .tss-wrapper .tss-carousel9 .profile-img-wrapper:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			);

			$this->fields[] = array(
				'mode' => 'section_end',
			);

			return $this->fields;
		}

		/**
		 * Grid Colors Section
		 *
		 * @return array
		 */
		public function gridColors() {
			$this->colors( 'with-pagination' );

			return $this->fields;
		}

		/**
		 * Common Colors Section.
		 *
		 * @return array
		 */
		public function commonColors() {
			$this->colors();

			return $this->fields;
		}

		/**
		 * Button Controls Condition.
		 *
		 * @return array
		 */
		private function buttonCondition( $condition = null ) {
			$conditions = array();

			$conditions[] = array(
				'relation' => 'or',
			);

			if ( 'with-pagination' === $condition ) {
				$conditions['terms'][] = array(
					'name'     => 'tss_el_pagination',
					'operator' => '==',
					'value'    => 'yes',
				);
			} else {
				$conditions['terms'] = array();
			}

			return $conditions;
		}
	}
endif;

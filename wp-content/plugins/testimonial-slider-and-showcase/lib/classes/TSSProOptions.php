<?php
if ( ! class_exists( 'TSSProOptions' ) ) :
	class TSSProOptions {

		function generalSettings() {
			$settings = get_option( TSSPro()->options['settings'] );

			return array(
				'slug' => array(
					'label'       => esc_html__( 'Slug', 'testimonial-slider-showcase' ),
					'type'        => 'text',
					'description' => esc_html__( 'Slug configuration', 'testimonial-slider-showcase' ),
					'attr'        => "size='10'",
					'value'       => ( ! empty( $settings['slug'] ) ? sanitize_title_with_dashes( $settings['slug'] ) : 'testimonial' )
				)
			);
		}

		function tssFrontEndSubmitFields() {
			$fields            = $this->formAllFields();
			$settings          = get_option( TSSPro()->options['settings'] );
			$activeFields      = ( ! empty( $settings['form_fields'] ) ? array_map( 'sanitize_text_field', $settings['form_fields'] ) : array() );
			$mergeActiveFields = array_merge( $activeFields, array_keys( $this->frontEndMandatoryFields() ) );
			$newFields         = array();
			foreach ( $fields as $key => $value ) {
				if ( in_array( $key, $mergeActiveFields ) ) {
					$newFields[ $key ] = $value;
				}
			}

			return apply_filters( 'tss_front_end_submit_fields', $newFields, $mergeActiveFields, $activeFields );
		}

		function frontEndMandatoryFields() {
			$fields = $this->frontEndFields();
			if ( isset( $fields['tss_feature_image'] ) ) {
				unset( $fields['tss_feature_image'] );
			}

			return apply_filters( 'tss_front_end_mandatory_fields', $fields );
		}

		function formAllFields() {
			$fields                                 = $this->singleTestimonialFields();
			$fields['tss_social_media']['frontEnd'] = true;
			$fields                                 = $this->frontEndFields() + $fields + $this->frontEndRecaptcha();

			return apply_filters( 'tss_from_all_fields', $fields );
		}

		function frontEndRecaptcha() {
			$fields = array(
				'tss_recaptcha' => array(
					'type' => 'recaptcha'
				),
			);

			return apply_filters( 'tss_from_end_recaptcha_field', $fields );
		}

		function frontEndFields() {
			$fields = array(
				'tss_name'          => array(
					'label'    => esc_html__( 'Name', 'testimonial-slider-showcase' ),
					'type'     => 'text',
					'required' => true,
				),
				'tss_testimonial'   => array(
					'label'    => esc_html__( 'Testimonial', 'testimonial-slider-showcase' ),
					'type'     => 'textarea',
					'required' => true,
				),
				'tss_feature_image' => array(
					'label' => esc_html__( 'Image', 'testimonial-slider-showcase' ),
					'type'  => 'simple_image',
				),
			);

			return apply_filters( 'tss_front_end_fields', $fields );
		}

		function detailFieldControl() {

			$settings = get_option( TSSPro()->options['settings'] );

			$detail_option = $this->single_page_field();
			unset($detail_option['read_more']);

			return array(
				'field'   => array(
					'label'       => esc_html__( 'Select the field', 'testimonial-slider-showcase' ),
					'type'        => 'checkbox',
					'options'     => $detail_option,
					"default"     => array_keys( array(
						'author'      => esc_html__( 'Author', 'testimonial-slider-showcase' ),
						'author_img'  => esc_html__( "Author Image", 'testimonial-slider-showcase' ),
						'testimonial' => esc_html__( "Short Description", 'testimonial-slider-showcase' ),
						'designation' => esc_html__( "Designation", 'testimonial-slider-showcase' ),
						'company' 	  => esc_html__( "Company", 'testimonial-slider-showcase' ),
						'location' 	  => esc_html__( "Location", 'testimonial-slider-showcase' ),
						'rating' 	  => esc_html__( "Rating", 'testimonial-slider-showcase' )
					) ),
					'multiple'    => true,
					'alignment'   => 'vertical',
					'description' => esc_html__( 'Select the option which you like to display',
						'testimonial-slider-showcase' ),
					'value'       => ( ! empty( $settings['field'] ) ? array_map( 'sanitize_text_field', $settings['field'] ) : array() )
				),
				"social_share_items" => array(
					'type'        => 'checkbox',
					'name'        => 'social_share_items',
					"holderClass" => "tss-hidden tss-social-share-fields-single",
					'label'       => 'Social share items',
					'id'          => 'social_share_items',
					'alignment'   => 'vertical',
					'multiple'    => true,
					'options'     => $this->socialShareItemList(),
					'value'       => ( ! empty( $settings['social_share_items'] ) ? array_map( 'sanitize_text_field', $settings['social_share_items'] ) : array() )
				)
			);
		}

		function formFieldControl() {

			$settings = get_option( TSSPro()->options['settings'] );

			return array(
				'form_fields'     => array(
					'label'       => esc_html__( 'Select the field', 'testimonial-slider-showcase' ),
					'type'        => 'checkbox',
					'options'     => $this->get_formFieldControl_fields(),
					'multiple'    => true,
					'alignment'   => 'vertical',
					'description' => esc_html__( 'Select the option which you like to display',
						'testimonial-slider-showcase' ),
					'value'       => ( ! empty( $settings['form_fields'] ) ? array_map( 'sanitize_text_field', $settings['form_fields'] ) : array() )
				),
				'notification_disable'       => array(
					'label'       => esc_html__( 'Disable admin notification', 'testimonial-slider-showcase' ),
					"optionLabel" => esc_html__( 'Disable', 'testimonial-slider-showcase' ),
					"option"      => 1,
					'type'        => 'switch',
					'value'       => ( isset( $settings['notification_disable'] ) && $settings['notification_disable'] === 1 ? 1 : null )
				),
				'notification_email'         => array(
					'label'       => esc_html__( 'Admin Notification to Email', 'testimonial-slider-showcase' ),
					'type'        => 'email',
					'attr'        => 'size="40"',
					'description' => esc_html__( 'If blank this will be the admin email.', 'testimonial-slider-showcase' ),
					'default'     => get_option( 'admin_email' ),
					'value'       => ( isset( $settings['notification_email'] ) ? esc_attr($settings['notification_email']) : null )
				),
				'notification_email_subject' => array(
					'label' => esc_html__( 'Notification Email Subject', 'testimonial-slider-showcase' ),
					'type'  => 'text',
					'attr'  => 'size="50"',
					'value' => ( isset( $settings['notification_email_subject'] ) && $settings['notification_email_subject'] ? esc_html( $settings['notification_email_subject'] ) : esc_html__( '[{site_name}] New Testimonial received', 'testimonial-slider-showcase' ) )
				),
			);
		}

		function get_formFieldControl_fields() {
			$fields   = $this->formAllFields();
			$newField = array();
			foreach ( $fields as $key => $value ) {
				if ( ! in_array( $key, array( 'tss_name', 'tss_testimonial' ) ) ) {
					if ( $key == "tss_recaptcha" ) {
						$newField[ $key ] = esc_html__( "reCAPTCHA", 'testimonial-slider-showcase' );
					} else {
						$newField[ $key ] = $value['label'];
					}
				}
			}

			return $newField;
		}

		function recaptchaFields() {
			$settings = get_option( TSSPro()->options['settings'] );

			return array(
				'tss_site_key'   => array(
					'label' => esc_html__( 'Site Key', 'testimonial-slider-showcase' ),
					'type'  => 'text',
					'class' => 'full-width',
					'value' => ( ! empty( $settings['tss_site_key'] ) ? esc_attr( $settings['tss_site_key'] ) : null )
				),
				'tss_secret_key' => array(
					'label' => esc_html__( 'Secret Key', 'testimonial-slider-showcase' ),
					'type'  => 'text',
					'class' => 'full-width',
					'value' => ( ! empty( $settings['tss_secret_key'] ) ? esc_attr($settings['tss_secret_key']) : null )
				)
			);
		}

		function othersSettings() {
			$settings = get_option( TSSPro()->options['settings'] );

			return array(
				'custom_css' => array(
					'label'       => esc_html__( 'Custom CSS', 'testimonial-slider-showcase' ),
					'type'        => 'custom_css',
					'description' => esc_html__( 'Add your custom css here!!!', 'testimonial-slider-showcase' ),
					'value'       => ( ! empty( $settings['custom_css'] ) ? esc_html( $settings['custom_css'] ) : null )
				)
			);
		}

		function rtLicenceField() {
			$settings       = get_option( TSSPro()->options['settings'] );
			$status         = ! empty( $settings['license_status'] ) && $settings['license_status'] === 'valid' ? true : false;
			$license_status = ! empty( $settings['license_key'] ) ? sprintf( "<span class='license-status'>%s</span>",
				$status ? "<input type='submit' class='button-secondary rt-licensing-btn danger' name='license_deactivate' value='" . esc_html__( "Deactivate License", "testimonial-slider-showcase" ) . "'/>"
					: "<input type='submit' class='button-secondary rt-licensing-btn button-primary' name='license_activate' value='" . esc_html__( "Activate License", "testimonial-slider-showcase" ) . "'/>"
			) : ' ';

			return array(
				"license_key" => array(
					'type'        => 'text',
					'attr'        => 'style="min-width:300px;"',
					'label'       => esc_html__( 'Enter your license key', "testimonial-slider-showcase" ),
					'description' => $license_status,
					'id'          => 'license_key',
					'value'       => isset( $settings['license_key'] ) ? esc_attr($settings['license_key']) : ''
				)
			);
		}

		function socialShareItemList() {
			$list = array(
				'facebook'    => 'Facebook',
				'twitter'     => 'Twitter',
				// 'instagram'   => 'Instagram',
				'linkedin'    => 'LinkedIn',
				'pinterest'   => 'Pinterest',
				'email'       => 'Email',
			);

			return apply_filters( 'tss_social_share_item_list', $list );
		}

		function scItemMetaFields() {
			return array(
				"tss_item_fields"    => array(
					"type"        => "checkbox",
					"label"       => esc_html__( "Field selection", 'testimonial-slider-showcase' ),
					"multiple"    => true,
					"alignment"   => "vertical",
					"default"     => array_keys( $this->sc_fieldSelection_fields() ),
					"options"     => $this->sc_fieldSelection_fields(),
					"description" => esc_html__( 'Check the field which you want to display',
						'testimonial-slider-showcase' )
				),
				"social_share_items" => array(
					'type'        => 'checkbox',
					'name'        => 'social_share_items',
					"holderClass" => "tss-hidden tss-social-share-fields",
					'label'       => 'Social share items',
					"is_pro"      => true,
					'id'          => 'social_share_items',
					'alignment'   => 'vertical',
					'multiple'    => true,
					'options'     => $this->socialShareItemList()
				)
			);
		}

		function scLayout() {
			return array(
				'layout1'   => "Grid",
				'carousel1' => "Slider",
			);
		}

		function scLayoutMetaFields() {
			$layout_option = array(
				"layout_type" => array(
                    "type"    => "radio-image",
                    "label"   => esc_html__("Layout type", 'review-schema'),
                    "id"      => "rtts-layout-type",
                    "options" => apply_filters('rtts_layout_type',
						array(
							array(
								'name' => 'Grid Layout',
								'value' => 'grid',
								'img' => TSSPro()->assetsUrl . 'images/grid.png',
							),
							array(
								'name' => 'Slider Layout',
								'value' => 'slider',
								'img' => TSSPro()->assetsUrl . 'images/slider.png',
							),
						)
					)
                ),
                "tss_layout" => array(
                    "type"        => "radio-image",
                    "label"       => esc_html__("Layout style", 'review-schema'),
                    "description" => esc_html__("Click to the Layout name to see live demo", 'review-schema'),
                    "id"          => "rtts-style",
                    "options" => array()
                ),
				'tss_desktop_column' => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Desktop column', 'testimonial-slider-showcase' ),
					'class'   => 'rt-select2',
					'default' => 3,
					'options' => $this->scColumns()
				),
				'tss_tab_column'     => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Tab column', 'testimonial-slider-showcase' ),
					'class'   => 'rt-select2',
					'default' => 2,
					'options' => $this->scColumns()
				),
				'tss_mobile_column' => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Mobile column', 'testimonial-slider-showcase' ),
					'class'   => 'rt-select2',
					'default' => 1,
					'options' => $this->scColumns()
				),
				'tss_carousel_speed' => array(
					"label"       => esc_html__( "Speed", 'testimonial-slider-showcase' ),
					"holderClass" => "tss-hidden tss-carousel-item",
					"type"        => "number",
					'default'     => 2000,
					"description" => esc_html__( 'Auto play Speed in milliseconds', 'testimonial-slider-showcase' ),
				),
				'tss_carousel_options'          => array(
					"label"       => esc_html__( "Carousel Options", 'testimonial-slider-showcase' ),
					"holderClass" => "tss-hidden tss-carousel-item",
					"type"        => "checkbox",
					"multiple"    => true,
					"alignment"   => "vertical",
					"options"     => $this->owlProperty(),
					"default"     => array( 'autoplay', 'arrows', 'dots', 'responsive', 'infinite' ),
				),
				'tss_carousel_autoplay_timeout' => array(
					"label"       => esc_html__( "Autoplay timeout", 'testimonial-slider-showcase' ),
					"holderClass" => "tss-hidden tss-carousel-auto-play-timeout",
					"type"        => "number",
					'default'     => 5000,
					"description" => esc_html__( 'Autoplay interval timeout', 'testimonial-slider-showcase' ),
				),
				'tss_pagination' => array(
					"type"        => "switch",
					"label"       => esc_html__( "Pagination", 'testimonial-slider-showcase' ),
					'holderClass' => "pagination",
					"optionLabel" => esc_html__( 'Enable', 'testimonial-slider-showcase' ),
					"option"      => 1
				),
				'tss_posts_per_page' => array(
					"type"        => "number",
					"label"       => esc_html__( "Display per page", 'testimonial-slider-showcase' ),
					'holderClass' => "tss-pagination-item tss-hidden",
					"default"     => 5,
					"description" => esc_html__( "If value of Limit setting is not blank (empty), this value should be smaller than Limit value.",
						'testimonial-slider-showcase' )
				),
				'tss_load_more_button_text' => array(
					"type"        => "text",
					"label"       => esc_html__( "Load more button text", 'testimonial-slider-showcase' ),
					'holderClass' => " tss-load-more-item tss-hidden",
					"default"     => esc_html__( "Load more", 'testimonial-slider-showcase' )
				),
				'tss_image_size'     => array(
					"type"    => "select",
					"label"   => esc_html__( "Image Size", 'testimonial-slider-showcase' ),
					"class"   => "rt-select2",
					"options" => TSSPro()->get_image_sizes()
				),
				'tss_custom_image_size'         => array(
					"type"        => "image_size",
					"label"       => esc_html__( "Custom Image Size", 'testimonial-slider-showcase' ),
					'holderClass' => "tss-hidden",
					"description" => __( '<span style="margin-top: 20px; display: block; color: #9A2A2A; font-weight: 400;">Please note that, if you enter image size larger than the actual image iteself, the image sizes will fallback to the default thumbnail dimension (150x150 px)</span>.', 'testimonial-slider-showcase' ),
				),
				'tss_image_type'     => array(
					"type"      => "radio",
					"label"     => esc_html__( "Image Type", 'testimonial-slider-showcase' ),
					"alignment" => "vertical",
					"default"   => 'normal',
					"options"   => $this->get_image_types()
				),
				'tss_testimonial_limit'         => array(
					"type"        => "number",
					'is_pro'  => true,
					"label"       => esc_html__( "Testimonial limit", 'testimonial-slider-showcase' ),
					"description" => esc_html__( "Testimonial limit only integer number is allowed, Leave it blank for full text.",
						'testimonial-slider-showcase' )
				),
				'tss_margin'         => array(
					"type"        => "radio",
					"label"       => esc_html__( "Margin", 'testimonial-slider-showcase' ),
					"alignment"   => "vertical",
					"description" => esc_html__( "Select the margin for layout", 'testimonial-slider-showcase' ),
					"default"     => "default",
					"options"     => $this->scMarginOpt()
				),
				'tss_grid_style'     => array(
					"type"        => "radio",
					"label"       => esc_html__( "Grid style", 'testimonial-slider-showcase' ),
					"alignment"   => "vertical",
					'is_pro'  => true,
					"description" => esc_html__( "Select grid style for layout", 'testimonial-slider-showcase' ),
					"default"     => "even",
					"options"     => $this->scGridStyle()
				),
				'tss_detail_page_link'          => array(
					"type"        => "switch",
					'is_pro'  => true,
					"label"       => esc_html__( "Detail page link", 'testimonial-slider-showcase' ),
					"optionLabel" => esc_html__( "Enable", 'testimonial-slider-showcase' ),
					"option"      => 1
				),
				'default_preview_image'         => array(
					'is_pro'  => true,
					"type"        => "image",
					"label"       => esc_html__( "Default preview  image", 'testimonial-slider-showcase' ),
					"description" => esc_html__( "Add an image for default preview", 'testimonial-slider-showcase' )
				)
			);

			return apply_filters( 'rtts_layout_option', $layout_option );
		}

		function scFilterMetaFields() {

			return array(
				'tss_post__in' => array(
					"label"       => esc_html__( "Include only", 'testimonial-slider-showcase' ),
					"type"        => "text",
					"description" => esc_html__( 'List of post IDs to show (comma-separated values, for example: 1,2,3)', 'testimonial-slider-showcase' )
				),
				'tss_post__not_in' => array(
					"label"       => esc_html__( "Exclude", 'testimonial-slider-showcase' ),
					"type"        => "text",
					"description" => esc_html__( 'List of post IDs to show (comma-separated values, for example: 1,2,3)', 'testimonial-slider-showcase' )
				),
				'tss_limit'  => array(
					"label"       => esc_html__( "Limit", 'testimonial-slider-showcase' ),
					"type"        => "number",
					"description" => esc_html__( 'The number of posts to show. Set empty to show all found posts.',
						'testimonial-slider-showcase' )
				),
				'tss_categories'        => array(
					"label"       => esc_html__( "Categories", 'testimonial-slider-showcase' ),
					"type"        => "select",
					"class"       => "rt-select2",
					"multiple"    => true,
					"is_pro"      => true,
					"description" => esc_html__( 'Select the category you want to filter, Leave it blank for All category',
						'testimonial-slider-showcase' ),
					"options" => TSSPro()->getAllTssCategoryList()
				),
				'tss_tags'   => array(
					"label" => esc_html__( "Tags", 'testimonial-slider-showcase' ),
					"type"  => "select",
					"class"       => "rt-select2",
					"multiple"    => true,
					"is_pro"      => true,
					"description" => esc_html__( 'Select the category you want to filter, Leave it blank for All category',
						'testimonial-slider-showcase' ),
					"options"     => TSSPro()->getAllTssTagList()
				),
				'tss_taxonomy_relation' => array(
					"label"       => esc_html__( "Taxonomy relation", 'testimonial-slider-showcase' ),
					"type"        => "select",
					"is_pro"      => true,
					"class"       => "rt-select2",
					"description" => esc_html__( 'Select this option if you select more than one taxonomy like category and tag, or category , tag and tools',
						'testimonial-slider-showcase' ),
					"options"     => $this->scTaxonomyRelation()
				),
				'tss_order_by'          => array(
					"label"   => esc_html__( "Order By", 'testimonial-slider-showcase' ),
					"type"    => "select",
					"class"   => "rt-select2",
					"default" => "date",
					"options" => $this->scOrderBy()
				),
				'tss_order'  => array(
					"label"     => esc_html__( "Order", 'testimonial-slider-showcase' ),
					"type"      => "radio",
					"options"   => $this->scOrder(),
					"default"   => "DESC",
					"alignment" => "vertical",
				),
			);
		}

		function singleTestimonialFields() {
			return array(
				'tss_designation'  => array(
					'label' => esc_html__( 'Designation', 'testimonial-slider-showcase' ),
					'type'  => 'text',
					'class' => 'full-width'
				),
				'tss_company'      => array(
					'label' => esc_html__( 'Company', 'testimonial-slider-showcase' ),
					'type'  => 'text',
					'class' => 'full-width'
				),
				'tss_location'     => array(
					'label' => esc_html__( 'Location', 'testimonial-slider-showcase' ),
					'type'  => 'text',
					'class' => 'full-width'
				),
				'tss_rating'       => array(
					'label' => esc_html__( 'Rating', 'testimonial-slider-showcase' ),
					'type'  => 'rating'
				),
				'tss_video'        => array(
					'label'       => esc_html__( 'Video URL', 'testimonial-slider-showcase' ),
					'type'        => 'video',
					'is_pro' => true,
					'class'       => 'full-width',
					'description' => 'Only Youtube and Vimeo url allowed'
				),
				'tss_social_media' => array(
					'label'       => esc_html__( 'Social media', 'testimonial-slider-showcase' ),
					'type'        => 'socialMedia',
					'is_pro' => true,
					'description' => "Drag from available list to active list to add social link.<br> Please add your social page URL like (https://www.facebook.com/radiustheme/ or https://twitter.com/radiustheme).",
					'options'     => $this->getSocialMediaList()
				)
			);
		}

		function scStyleFields() {
			$sc_style =  array(
				'tss_parent_class'        => array(
					"type"        => "text",
					"label"       => esc_html__( "Parent class", 'testimonial-slider-showcase' ),
					"class"       => "medium-text",
					"description" => esc_html__( "Parent class for adding custom css", 'testimonial-slider-showcase' )
				),
				'tss_color'               => array(
					"type"    => "multiple_options",
					"label"   => esc_html__( "Color schema", 'testimonial-slider-showcase' ),
					"options" => array(
						'primary'      => array(
							'type'  => 'color',
							'label' => esc_html__( "Primary", 'testimonial-slider-showcase' ),
						)
					)
				),
				'tss_button_style'        => array(
					"type"    => "multiple_options",
					"label"   => "Button color",
					"options" => array(
						'bg'         => array(
							'type'  => 'color',
							'label' => 'Background'
						),
						'hover_bg'   => array(
							'type'  => 'color',
							'label' => 'Hover background'
						),
						'active_bg'  => array(
							'type'  => 'color',
							'label' => 'Active background'
						),
						'text'       => array(
							'type'  => 'color',
							'label' => 'Text'
						),
						'hover_text' => array(
							'type'  => 'color',
							'label' => 'Hover text'
						),
						'border'     => array(
							'type'  => 'color',
							'label' => 'Border'
						)
					)
				),
				'tss_iso_counter_tooltip_bg_color'   => array(
					"type"        => "colorpicker",
					'holderClass' => "tss-isotope-item tss-hidden",
					"label"       => esc_html__( "Isotope counter tooltip background color",
						'testimonial-slider-showcase' ),
				),
				'tss_iso_counter_tooltip_text_color' => array(
					"type"        => "colorpicker",
					'holderClass' => "tss-isotope-item tss-hidden",
					"label"       => esc_html__( "Isotope counter tooltip text color", 'testimonial-slider-showcase' ),
				),
				'tss_gutter' => array(
					"is_pro"      => true,
					'type'        => 'number',
					'label'       => esc_html__( 'Gutter / Padding', 'testimonial-slider-showcase' ),
					'description' => "Unit will be pixel, No need to give any unit. Only integer value will be valid.<br> Leave it blank for default"
				),
				'tss_image_border'        => array(
					"type"    => "multiple_options",
					"label"   => "Image Border Style",
					"is_pro"  => true,
					"options" => array(
						'width' => array(
							'type'        => 'number',
							'label'       => esc_html__( "Border width at pixel", 'testimonial-slider-showcase' ),
							"description" => esc_html__( "Only number is allowed",
								'testimonial-slider-showcase' )
						),
						'color' => array(
							'type'  => 'color',
							'label' => esc_html__( "Border Color", 'testimonial-slider-showcase' ),
						),
						'style' => array(
							'type'    => 'select',
							'label'   => esc_html__( "Border style", 'testimonial-slider-showcase' ),
							"class"   => "rt-select2",
							'options' => array(
								'solid'  => 'Solid',
								'dotted' => "Dotted",
								'dashed' => "Dashed",
								'double' => "Double"
							)
						)
					)
				),
				'tss_author_name_style'   => array(
					'type'  => 'style',
					'label' => esc_html__( 'Author name', 'testimonial-slider-showcase' ),
				),
				'tss_author_bio_style'    => array(
					'type'  => 'style',
					'label' => esc_html__( 'Author bio', 'testimonial-slider-showcase' ),
				),
				'tss_rating_style'   => array(
					'type'  => 'style',
					'label' => esc_html__( 'Rating', 'testimonial-slider-showcase' ),
				),
				'tss_social_style'        => array(
					'type'  => 'style',
					"is_pro" => true,
					'label' => esc_html__( 'Social', 'testimonial-slider-showcase' ),
				),
				'tss_testimonial_style'   => array(
					'type'    => 'multiple_options',
					'label'   => esc_html__( 'Testimonial Style', 'testimonial-slider-showcase' ),
					"options" => array(
						'color'  => array(
							'type'  => 'color',
							'label' => esc_html__( "Color", 'testimonial-slider-showcase' )
						),
					)
				)
			);
			return apply_filters( 'rtts_layout_style',$sc_style );
		}

		function scTaxonomyRelation() {
			return array(
				'OR'  => "OR Relation",
				'AND' => "AND Relation"
			);
		}

		function scTextStyle() {
			return array(
				'normal'  => "Normal",
				'italic'  => "Italic",
				'oblique' => "Oblique"
			);
		}

		function get_image_types() {
			return array(
				'normal' => "Normal",
				'circle' => "Circle"
			);
		}

		function scColumns() {
			return array(
				1 => "1 Column",
				2 => "2 Columns",
				3 => "3 Columns",
				4 => "4 Columns",
				5 => "5 Columns",
				6 => "6 Columns",
			);
		}

		function scOrderBy() {
			$oder_by = array(
				'menu_order' => "Menu Order",
				'title'      => "Name",
				'ID'         => "ID",
				'date'       => "Date",
			);

			if ( function_exists('rttsp') ) {
                $oder_by['rand'] = esc_html__("Random", "testimonial-slider-showcase");
            }

			return $oder_by;
		}

		function scOrder() {
			return array(
				'ASC'  => esc_html__( "Ascending", 'testimonial-slider-showcase' ),
				'DESC' => esc_html__( "Descending", 'testimonial-slider-showcase' ),
			);
		}

		function scGridStyle() {
			return array(
				'even'    => "Even",
				'masonry' => "Masonry"
			);
		}

		function imageCropType() {
			return array(
				'soft' => esc_html__( "Soft Crop", 'testimonial-slider-showcase' ),
				'hard' => esc_html__( "Hard Crop", 'testimonial-slider-showcase' )
			);
		}

		function scFontSize() {
			$num = array();
			for ( $i = 10; $i <= 30; $i ++ ) {
				$num[ $i ] = $i . "px";
			}

			return $num;
		}

		function scMarginOpt() {
			return array(
				'default' => "Bootstrap default",
				'no'      => "No Margin"
			);
		}

		function getSocialMediaList() {
			return apply_filters( 'tss_social_link', array(
				'facebook'  => 'Facebook',
				'twitter'   => 'Twitter',
				'instagram' => 'Instagram',
				'linkedin'  => 'Linkedin',
				'pinterest' => 'Pinterest',
				'email' => 'Email',
			) );
		}


		function scAlignment() {
			return array(
				'left'    => "Left",
				'right'   => "Right",
				'center'  => "Center",
				'justify' => "Justify"
			);
		}

		function scTextWeight() {
			return array(
				'normal'  => "Normal",
				'bold'    => "Bold",
				'bolder'  => "Bolder",
				'lighter' => "Lighter",
				'inherit' => "Inherit",
				'initial' => "Initial",
				'unset'   => "Unset",
				100       => '100',
				200       => '200',
				300       => '300',
				400       => '400',
				500       => '500',
				600       => '600',
				700       => '700',
				800       => '800',
				900       => '900',
			);
		}

		function alignment() {
			return array(
				'left'    => "Left",
				'right'   => "Right",
				'center'  => "Center",
				'justify' => "Justify"
			);
		}

		function tlpOverlayBg() {
			return array(
				'0.1' => "10 %",
				'0.2' => "20 %",
				'0.3' => "30 %",
				'0.4' => "40 %",
				'0.5' => "50 %",
				'0.6' => "60 %",
				'0.7' => "70 %",
				'0.8' => "80 %",
				'0.9' => "90 %"
			);
		}

		function owlProperty() {
			return array(
				'loop'    => esc_html__( 'Loop', 'testimonial-slider-showcase' ),
				'autoplay'=> esc_html__( 'Auto Play', 'testimonial-slider-showcase' ),
				'autoplayHoverPause' => esc_html__( 'Pause on mouse hover', 'testimonial-slider-showcase' ),
				'nav'     => esc_html__( 'Nav Button', 'testimonial-slider-showcase' ),
				'dots'    => esc_html__( 'Pagination', 'testimonial-slider-showcase' ),
				'auto_height' => esc_html__( 'Auto Height', 'testimonial-slider-showcase' ),
				'lazy_load'  => esc_html__( 'Lazy Load', 'testimonial-slider-showcase' ),
				'rtl'     => esc_html__( 'Right to left (RTL)', 'testimonial-slider-showcase' )
			);
		}

		function sc_fieldSelection_fields() {
			if ( function_exists('rttsp') ) {
				$fields      = $this->singleTestimonialFields();
				$fieldsArray = array();
				foreach ( $fields as $index => $field ) {
					$fieldsArray[ str_replace( 'tss_', '', $index ) ] = ( $index == 'tss_video' ? esc_html__( 'Video',
						'testimonial-slider-showcase' ) : $field['label'] );
				}

				$newFields = array(
					'author'      => esc_html__( 'Author', 'testimonial-slider-showcase' ),
					'author_img'  => esc_html__( "Author Image", 'testimonial-slider-showcase' ),
					'testimonial' => esc_html__( "Testimonial", 'testimonial-slider-showcase' ),
					'read_more'   => esc_html__( "Read More", 'testimonial-slider-showcase' )
				);

				return array_merge( $newFields, $fieldsArray, array( 'social_share' => esc_html__( "Social Share", 'testimonial-slider-showcase' ) ) );
			} else {
				return $newFields = array(
					'author'      => esc_html__( 'Author', 'testimonial-slider-showcase' ),
					'author_img'  => esc_html__( "Author Image", 'testimonial-slider-showcase' ),
					'testimonial' => esc_html__( "Short Description", 'testimonial-slider-showcase' ),
					'designation' => esc_html__( "Designation", 'testimonial-slider-showcase' ),
					'company' 	  => esc_html__( "Company", 'testimonial-slider-showcase' ),
					'location' 	  => esc_html__( "Location", 'testimonial-slider-showcase' ),
					'rating' 	  => esc_html__( "Rating", 'testimonial-slider-showcase' ),
				);
			}
		}

		function single_page_field() {
			$fields = $this->sc_fieldSelection_fields();

			return $fields;
		}
	}
endif;

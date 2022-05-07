<?php
/**
 * Real Testimonials form page.
 *
 * @link https://shapedplugin.com
 * @since 2.0.0
 *
 * @package Testimonial_free
 * @subpackage Testimonial_free/admin/views
 */

use ShapedPlugin\TestimonialFree\Admin\Views\Framework\Classes\SPFTESTIMONIAL;

if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
//
// Metabox of the testimonial form generator.
// Set a unique slug-like ID.
//
//
// Metabox of the testimonial form generator.
// Set a unique slug-like ID.
//
$prefix_form_code_opts = 'sp_tfree_form_upper_section';

//
// Form shortcode.
//
SPFTESTIMONIAL::createMetabox(
	$prefix_form_code_opts,
	array(
		'title'           => __( 'How To Use', 'testimonial-free' ),
		'post_type'       => 'spt_testimonial_form',
		'context'         => 'normal',
		'enqueue_webfont' => false,
	)
);

//
// Real Testimonials Form Code section.
//
SPFTESTIMONIAL::createSection(
	$prefix_form_code_opts,
	array(
		'fields' => array(
			array(
				'id'   => 'form_upper_section',
				'type' => 'form_upper_section',
			),

		),
	)
);
$prefix_form_elements_opts = 'sp_tpro_form_elements_options';

//
// Metabox of the testimonial form generator.
// Set a unique slug-like ID.
//
$prefix_form_elements_opts = 'sp_tpro_form_elements_options';

//
// Form metabox.
//
SPFTESTIMONIAL::createMetabox(
	$prefix_form_elements_opts,
	array(
		'title'           => __( 'Form Fields (Pro)', 'testimonial-free' ),
		'post_type'       => 'spt_testimonial_form',
		'context'         => 'side',
		'enqueue_webfont' => false,
	)
);

//
// Form Editor section.
//
SPFTESTIMONIAL::createSection(
	$prefix_form_elements_opts,
	array(
		'fields' => array(
			array(
				'id'         => 'form_elements',
				'type'       => 'checkbox',
				'class'      => 'pro_only_field',
				'attributes' => array( 'disabled' => 'disabled' ),
				'options'    => array(
					'name'              => __( 'Full Name', 'testimonial-free' ),
					'email'             => __( 'E-mail Address', 'testimonial-free' ),
					'position'          => __( 'Identity or Position', 'testimonial-free' ),
					'company'           => __( 'Company Name', 'testimonial-free' ),
					'testimonial_title' => __( 'Testimonial Title', 'testimonial-free' ),
					'testimonial'       => __( 'Testimonial', 'testimonial-free' ),
					'groups'            => __( 'Groups', 'testimonial-free' ),
					'image'             => __( 'Image', 'testimonial-free' ),
					'location'          => __( 'Location', 'testimonial-free' ),
					'phone_mobile'      => __( 'Phone or Mobile', 'testimonial-free' ),
					'website'           => __( 'Website', 'testimonial-free' ),
					'video_url'         => __( 'Video URL', 'testimonial-free' ),
					'rating'            => __( 'Rating', 'testimonial-free' ),
					'social_profile'    => __( 'Social Profile', 'testimonial-free' ),
					'recaptcha'         => __( 'reCAPTCHA', 'testimonial-free' ),
				),
				'default'    => array( 'name', 'email', 'position', 'company', 'website', 'image', 'testimonial_title', 'testimonial', 'rating', 'phone_mobile', 'location', 'groups', 'groups', 'video_url', 'social_profile', 'recaptcha' ),
			),

		),
	)
);


//
// Metabox of the testimonial form generator.
// Set a unique slug-like ID.
//
$prefix_form_code_opts = 'sp_tpro_form_code_options';

//
// Form shortcode.
//
SPFTESTIMONIAL::createMetabox(
	$prefix_form_code_opts,
	array(
		'title'           => __( 'How To Use', 'testimonial-free' ),
		'post_type'       => 'spt_testimonial_form',
		'context'         => 'side',
		'enqueue_webfont' => false,
	)
);

//
// Testimonial Form Code section.
//
SPFTESTIMONIAL::createSection(
	$prefix_form_code_opts,
	array(
		'fields' => array(

			array(
				'id'   => 'form_shortcode',
				'type' => 'shortcode',
			),

		),
	)
);
//
// Metabox of the testimonial form generator.
// Set a unique slug-like ID.
//
$prefix_form_opts = 'sp_tpro_form_options';

//
// Form metabox.
//
SPFTESTIMONIAL::createMetabox(
	$prefix_form_opts,
	array(
		'title'           => __( 'Form Options (Pro)', 'testimonial-free' ),
		'post_type'       => 'spt_testimonial_form',
		'context'         => 'normal',
		'enqueue_webfont' => false,
	)
);

//
// Form Editor section.
//
SPFTESTIMONIAL::createSection(
	$prefix_form_opts,
	array(
		'title'  => __( 'Form Editor (Pro)', 'testimonial-free' ),
		'icon'   => 'fa fa-align-justify',
		'fields' => array(

			array(
				'id'     => 'form_fields',
				'class'  => 'form_fields',
				'type'   => 'sortable',
				'fields' => array(
					array(
						'id'         => 'full_name',
						'type'       => 'accordion',
						'class'      => 'opened_accordion',
						'accordions' => array(
							array(
								'title'  => __( 'Full Name', 'testimonial-free' ),
								'fields' => array(
									array(
										'id'         => 'label',
										'type'       => 'text',
										'class'      => 'pro_only_field',
										'attributes' => array( 'disabled' => 'disabled' ),
										'title'      => __( 'Label', 'testimonial-free' ),
										'desc'       => __( 'To hide this label, leave it empty.', 'testimonial-free' ),
										'default'    => __( 'Full Name', 'testimonial-free' ),
									),
									array(
										'id'         => 'placeholder',
										'type'       => 'text',
										'class'      => 'pro_only_field',
										'attributes' => array( 'disabled' => 'disabled' ),
										'title'      => __( 'Placeholder', 'testimonial-free' ),
										'default'    => __( 'What is your full name?', 'testimonial-free' ),
									),
									array(
										'id'         => 'required',
										'type'       => 'checkbox',
										'class'      => 'pro_only_field',
										'attributes' => array( 'disabled' => 'disabled' ),
										'title'      => __( 'Required', 'testimonial-free' ),
										'default'    => true,
									),
								),
							),
						),
						'dependency' => array( 'form_elements', 'any', 'name', true ),
					),
					array(
						'id'         => 'email_address',
						'type'       => 'accordion',
						'class'      => 'tfree_pro_only',
						'accordions' => array(
							array(
								'title' => __( 'E-mail Address', 'testimonial-free' ),

							),
						),
						'dependency' => array( 'form_elements', 'any', 'email', true ),
					),
					array(
						'id'         => 'identity_position',
						'type'       => 'accordion',
						'class'      => 'tfree_pro_only',
						'accordions' => array(
							array(
								'title' => __( 'Identity or Position', 'testimonial-free' ),

							),
						),
						'dependency' => array( 'form_elements', 'any', 'position', true ),
					),
					array(
						'id'         => 'company_name',
						'type'       => 'accordion',
						'class'      => 'tfree_pro_only',
						'accordions' => array(
							array(
								'title' => __( 'Company Name', 'testimonial-free' ),

							),
						),
						'dependency' => array( 'form_elements', 'any', 'company', true ),
					),
					array(
						'id'         => 'testimonial_title',
						'class'      => 'tfree_pro_only',
						'type'       => 'accordion',
						'accordions' => array(
							array(
								'title' => __( 'Testimonial Title', 'testimonial-free' ),
							),
						),
						'dependency' => array( 'form_elements', 'any', 'testimonial_title', true ),
					),
					array(
						'id'         => 'testimonial',
						'type'       => 'accordion',
						'class'      => 'tfree_pro_only',
						'accordions' => array(
							array(
								'title' => __( 'Testimonial', 'testimonial-free' ),
							),
						),
						'dependency' => array( 'form_elements', 'any', 'testimonial', true ),
					),
					array(
						'id'         => 'groups',
						'type'       => 'accordion',
						'class'      => 'tfree_pro_only',
						'accordions' => array(
							array(
								'title' => __( 'Groups', 'testimonial-free' ),
							),
						),
						'dependency' => array( 'form_elements', 'any', 'groups', true ),
					),
					array(
						'id'         => 'featured_image',
						'type'       => 'accordion',
						'class'      => 'tfree_pro_only',
						'accordions' => array(
							array(
								'title' => __( 'Image', 'testimonial-free' ),
							),
						),
						'dependency' => array( 'form_elements', 'any', 'image', true ),
					),
					array(
						'id'         => 'location',
						'type'       => 'accordion',
						'class'      => 'tfree_pro_only',
						'accordions' => array(
							array(
								'title' => __( 'Location', 'testimonial-free' ),
							),
						),
						'dependency' => array( 'form_elements', 'any', 'location', true ),
					),
					array(
						'id'         => 'phone_mobile',
						'type'       => 'accordion',
						'class'      => 'tfree_pro_only',
						'accordions' => array(
							array(
								'title' => __( 'Phone or Mobile', 'testimonial-free' ),
							),
						),
						'dependency' => array( 'form_elements', 'any', 'phone_mobile', true ),
					),
					array(
						'id'         => 'website',
						'type'       => 'accordion',
						'class'      => 'tfree_pro_only',
						'accordions' => array(
							array(
								'title' => __( 'Website', 'testimonial-free' ),
							),
						),
						'dependency' => array( 'form_elements', 'any', 'website', true ),
					),
					array(
						'id'         => 'video_url',
						'type'       => 'accordion',
						'class'      => 'tfree_pro_only',
						'accordions' => array(
							array(
								'title' => __( 'Video URL', 'testimonial-free' ),
							),
						),
						'dependency' => array( 'form_elements', 'any', 'video_url', true ),
					),
					array(
						'id'         => 'rating',
						'type'       => 'accordion',
						'class'      => 'tfree_pro_only',
						'accordions' => array(
							array(
								'title' => __( 'Rating', 'testimonial-free' ),
							),
						),
						'dependency' => array( 'form_elements', 'any', 'rating', true ),
					),
					array(
						'id'         => 'social_profile',
						'type'       => 'accordion',
						'class'      => 'tfree_pro_only',
						'accordions' => array(
							array(
								'title' => __( 'Social Profile', 'testimonial-free' ),
							),
						),
						'dependency' => array( 'form_elements', 'any', 'social_profile', true ),
					),
					array(
						'id'         => 'recaptcha',
						'type'       => 'accordion',
						'class'      => 'tfree_pro_only',
						'accordions' => array(
							array(
								'title' => __( 'reCAPTCHA', 'testimonial-free' ),
							),
						),
						'dependency' => array( 'form_elements', 'any', 'recaptcha', true ),
					),
					array(
						'id'         => 'submit_btn',
						'type'       => 'accordion',
						'class'      => 'tfree_pro_only',
						'accordions' => array(
							array(
								'title' => __( 'Submit Button', 'testimonial-free' ),
							),
						),
					),

				),
			),

		),
	)
);

//
// Messages section.
//
SPFTESTIMONIAL::createSection(
	$prefix_form_opts,
	array(
		'title' => __( 'Messages (Pro)', 'testimonial-free' ),
		'icon'  => 'fa fa-exclamation-triangle',
	)
);

//
// Notifications section.
//
SPFTESTIMONIAL::createSection(
	$prefix_form_opts,
	array(
		'title' => __( 'Notifications (Pro)', 'testimonial-free' ),
		'icon'  => 'fa fa-bell',
	)
);

//
// Stylization section.
//
SPFTESTIMONIAL::createSection(
	$prefix_form_opts,
	array(
		'title' => __( 'Stylization  (Pro)', 'testimonial-free' ),
		'icon'  => 'fa fa-paint-brush',
	)
);

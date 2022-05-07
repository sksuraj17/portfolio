<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'TSSVCInit' ) ):

	class TSSVCInit {

		function __construct() {
			if ( ! defined( 'WPB_VC_VERSION' ) ) {
				return;
			}
			add_action( 'vc_before_init', array( $this, 'tssIntegrationVc' ));
		}

		function scListA(){
			$sc = array();
			$scQ = get_posts( array('post_type' => 'tss-sc', 'order_by' => 'title', 'order' => 'DESC', 'post_status' => 'publish', 'posts_per_page' => -1) );
			$sc['Default'] = '';
			if ( count($scQ) ) {
				foreach($scQ as $post){
					$sc[$post->post_title] = $post->ID;
				}
			}
			return $sc;
		}


		function tssIntegrationVc() {

			vc_map( array(
					"name" => esc_html__("Testimonial Pro", 'testimonial-slider-showcase'),
					"base" => 'rt-testimonial',
					"class" => "",
					"icon"      => TSSPro()->assetsUrl . 'images/icon-32x32.png',
					"controls" => "full",
					"category" => 'Content',
					'admin_enqueue_js' => '',
					'admin_enqueue_css' => '',
					"params" => array(
						array(
							"type" => "dropdown",
							"heading" => esc_html__("Short Code", 'testimonial-slider-showcase'),
							"param_name" => "id",
							"value" => $this->scListA(),
							"admin_label" => true,
							"description" => esc_html__("Short Code list", 'testimonial-slider-showcase')
						)
					)
				)

			);
		}
	}

endif;
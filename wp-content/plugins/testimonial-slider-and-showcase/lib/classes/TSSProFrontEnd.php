<?php
if ( ! class_exists( 'TSSProFrontEnd' ) ) :

	class TSSProFrontEnd {

		function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'tss_front_end' ) );
			add_action( 'wp_ajax_tlpSingleItem', array( $this, 'tlpSingleItem' ) );
			add_action( 'wp_ajax_nopriv_tlpSingleItem', array( $this, 'tlpSingleItem' ) );
		}

		public function tlpSingleItem() {
			$html    = null;
			$success = false;
			$error   = true;
			if ( TSSPro()->verifyNonce() ) {
				if ( $_REQUEST['id'] ) {
					$settings = get_option( TSSPro()->options['settings'] );
					$field    = ( ! empty( $settings['field'] ) ? array_map( 'sanitize_text_field', $settings['field'] ) : array() );
					global $post;
					$post    = get_post( $_REQUEST['id'] );
					setup_postdata($post);
					$content = apply_filters( 'the_content', get_the_content() );
					$title = get_the_title();
					$html .= "<div class='tss-container tss-portfolio-detail'>";
						$html .= "<div class='rt-row'>";
							$html .= "<div class='rt-col-lg-12 rt-col-md-12 rt-col-sm-12 rt-col-xs-12'>";
								if ( in_array( 'name', $field ) ) {
									$html .= "<h2 class='portfolio-title'>{$title}</h2>";
								}
								$html .= TSSPro()->pfpGallery( $post->ID );
							$html .= '</div>';
							$html .= '<div class="portfolio-detail-desc rt-col-lg-12 rt-col-md-12 rt-col-sm-12 rt-col-xs-12 padding0">';
								$html .= "<div class='rt-col-lg-8 rt-col-md-8 rt-col-sm-6 rt-col-xs-12'>";
									if ( in_array( 'description', $field ) ) {
										$html .="<div class='portfolio-details'>{$content}</div>";
									}
									if ( in_array( 'social_share', $field ) ) {
										$html .= TSSPro()->socialShare( get_permalink( $post->ID ) );
									}
								$html .= "</div>";
								$html .= '<div class="rt-col-lg-4 rt-col-md-4 rt-col-sm-6 rt-col-xs-12">';
									$html .= TSSPro()->singleMeta( $post->ID );
								$html .= '</div>';
							$html .= '</div>';
						if ( in_array( 'related_project', $field ) ) {
							$html .= TSSPro()->relatedProject( $post->ID );
						}
						$html .= "</div>"; // row
					$html .= "</div>"; // container
					$html .= "<script>(function($){ pfpGalleryRender();})(jQuery)</script>";
					$success = true;
				} else {
					$html .= "<p>" . esc_html__( "No item id found", 'tlp-portfolio' ) . "</p>";
					$error = true;
				}
			} else {
				$error = true;
				$html .= "<p>" . esc_html__( 'Security error', 'tlp-portfolio' ) . "</p>";
			}

			wp_send_json(
				array(
					'data'    => $html,
					'error'   => $error,
					'success' => $success
				)
			);
			die();
		}

		function tss_front_end() {
			wp_enqueue_style( 'tss' );
			$settings = get_option( TSSPro()->options['settings'] );
			if ( !empty($settings['custom_css']) ) {
				wp_add_inline_style('tss', esc_html($settings['custom_css']));
			}
		}

	}
endif;

<?php

if ( ! class_exists( 'TSSProTaxMeta' ) ):

	class TSSProTaxMeta {
		function __construct() {
			// Add cat columns
			add_filter( 'manage_edit-testimonial-category_columns', array( $this, 'tss_taxonomy_columns' ) );
			add_filter( 'manage_testimonial-category_custom_column', array( $this, 'tss_taxonomy_column' ), 10, 3 );
			add_filter( 'manage_edit-testimonial-tag_columns', array( $this, 'tss_taxonomy_columns' ) );
			add_filter( 'manage_testimonial-tag_custom_column', array( $this, 'tss_taxonomy_column' ), 10, 3 );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
			add_action( 'wp_ajax_tss-get-term-list', array( $this, 'ajax_get_term_list_taxonomy_slug' ) );
			add_action( 'wp_ajax_tss-update-temp-order', array( $this, 'ajax_update_term_order' ) );
			add_action( 'created_term', array( $this, 'save_taxonomy_fields' ), 10, 3 );
			add_action( 'edit_term', array( $this, 'save_taxonomy_fields' ), 10, 3 );
			add_action( 'admin_init', array( $this, 'save_taxonomy_fields' ), 10, 3 );

		}

		public function save_taxonomy_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
			if ( in_array($taxonomy, TSSPro()->taxonomies) ) {
				if(!TSSPro()->meta_exist($term_id, '_order', 'term')){
					update_term_meta( $term_id, '_order', 0 );
				}
			}
		}

		function ajax_update_term_order(){
			$html  = $msg = null;
			$error = true;
			if ( TSSPro()->verifyNonce() ) {
				$terms = (!empty($_REQUEST['terms']) ? explode(',',$_REQUEST['terms']) : array());
				if($terms && !empty($terms)){
					$error = false;
					foreach ($terms as $key => $term_id){
						update_term_meta($term_id, '_order', $key + 1);
					}
				}else {
					$msg .= "<p>" . esc_html__( 'No term in list', 'testimonial-slider-showcase' ) . "</p>";
				}
			} else {
				$msg .= "<p>" . esc_html__( 'Security error', 'testimonial-slider-showcase' ) . "</p>";
			}

			wp_send_json(
				array(
					'data'  => $html,
					'error' => $error,
					'msg'   => $msg
				)
			);
			die();
		}

		function ajax_get_term_list_taxonomy_slug() {
			$html  = $msg = null;
			$error = true;
			if ( TSSPro()->verifyNonce() ) {
				$tax = (!empty($_REQUEST['tax']) ? esc_attr( $_REQUEST['tax'] ) : null);
				if($tax){
					$error = false;
					$terms = get_terms( $tax, array(
						'orderby'    => 'meta_value_num',
						'meta_key'   => '_order',
						'order'      => 'ASC',
						'hide_empty' => false,
					) );
					if ( ! empty( $terms ) ) {
						$html .= "<ul id='order-target' data-taxonomy='{$tax}'>";
						foreach ( $terms as $term ) {
							$html .=  "<li data-id='{$term->term_id}'><span>{$term->name}</span></li>";
						}
						$html .=  "</ul>";
					}else{
						$html .= "<p>" . esc_html__( 'No term found', 'testimonial-slider-showcase' ) . "</p>";
					}
				}else {
					$html .= "<p>" . esc_html__( 'Select a taxonomy', 'testimonial-slider-showcase' ) . "</p>";
				}
			} else {
				$html .= "<p>" . esc_html__( 'Security error', 'testimonial-slider-showcase' ) . "</p>";
			}

			wp_send_json(
				array(
					'data'  => $html,
					'error' => $error,
					'msg'   => $msg
				)
			);
			die();
		}

		function admin_enqueue_scripts() {
			global $pagenow, $typenow;
			// validate page
			if ( ! in_array( $pagenow, array( 'edit.php' ) ) && !empty($_REQUEST['page']) && $_REQUEST['page'] != 'tss_taxonomy_order' ) {
				return;
			}
			if ( $typenow != TSSPro()->post_type ) {
				return;
			}

			wp_enqueue_script( array(
				'jquery',
				'jquery-ui-core',
				'jquery-ui-sortable',
				'tss-select2',
				'tss-admin-taxonomy'
			) );
			wp_enqueue_style( array(
				'tss-select2',
				'tss-admin'
			) );

			wp_localize_script( 'tss-admin-taxonomy', 'tss',
				array(
					'nonceId' => TSSPro()->nonceId(),
					'nonce'   => wp_create_nonce( TSSPro()->nonceText() ),
					'ajaxurl' => admin_url( 'admin-ajax.php' )
				) );
		}


		public function tss_taxonomy_columns( $columns ) {
			$new_columns = array();
			if ( isset( $columns['cb'] ) ) {
				$new_columns['cb'] = $columns['cb'];
				unset( $columns['cb'] );
			}
			$new_columns_order['order'] = esc_html__( 'Order', 'testimonial-slider-showcase' );
			return array_merge( $new_columns, $columns, $new_columns_order );
		}


		public function tss_taxonomy_column( $columns, $column, $id ) {

			if ( 'order' == $column ) {
				$columns .= get_term_meta( $id, '_order', true );
			}

			return $columns;
		}

	}

endif;
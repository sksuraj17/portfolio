<?php
if (!class_exists('TSSProPostMeta')):

    class TSSProPostMeta
    {

        function __construct() {
            add_action('add_meta_boxes', array($this, 'add_testimonial_meta_box'));
            add_action('save_post', array($this, 'save_testimonial_meta_data'), 10,2);
        }

        function add_testimonial_meta_box() {
            add_meta_box('tss_meta_information', esc_html__('Testimonial\'s Information', 'tlp-portfolio'), array($this, 'tss_meta_information'), TSSPro()->post_type, 'normal', 'high');
        }

        function tss_meta_information() {

            wp_nonce_field(TSSPro()->nonceText(), TSSPro()->nonceId());
			echo '<div class="tss-meta-wrapper">';
				echo TSSPro()->rtFieldGenerator( TSSPro()->singleTestimonialFields() );
			echo '</div>';
        }

        function save_testimonial_meta_data($post_id, $post) {

            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
	        if ( ! TSSPro()->verifyNonce() ) {
		        return $post_id;
	        }

	        if ( TSSPro()->post_type != $post->post_type ) {
		        return $post_id;
	        }

	        $mates = TSSPro()->tssTestimonialAllMetaFields();
	        foreach ( $mates as $metaKey => $field ) {
		        $rawValue = isset( $_REQUEST[ $metaKey ] ) ? $_REQUEST[ $metaKey ] : null; //sanitize data in the next line
		        $sanitizedValue  = TSSPro()->sanitize( $field, $rawValue );
		        if ( empty( $field['multiple'] ) ) {
			        update_post_meta( $post_id, $metaKey, $sanitizedValue );
		        } else {
			        delete_post_meta( $post_id, $metaKey );
			        if ( is_array( $sanitizedValue ) && ! empty( $sanitizedValue ) ) {
				        foreach ( $sanitizedValue as $item ) {
					        add_post_meta( $post_id, $metaKey, $item );
				        }
			        }
		        }
	        }

        }

    }
endif;

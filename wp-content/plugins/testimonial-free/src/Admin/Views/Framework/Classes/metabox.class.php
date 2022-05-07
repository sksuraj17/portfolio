<?php
/**
 * Framework metabox.class file.
 *
 * @link https://shapedplugin.com
 * @since 2.0.0
 *
 * @package Testimonial
 * @subpackage Testimonial/framework
 */

use ShapedPlugin\TestimonialFree\Frontend\Helper;
use ShapedPlugin\TestimonialFree\Admin\Views\Framework\Classes\SPFTESTIMONIAL;

if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.

if ( ! class_exists( 'SPFTESTIMONIAL_Metabox' ) ) {
	/**
	 *
	 * Metabox Class
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SPFTESTIMONIAL_Metabox extends SPFTESTIMONIAL_Abstract {
		/**
		 * Property.
		 *
		 * @var string
		 */
		public $unique = '';
		/**
		 * Properties for metabox.
		 *
		 * @var string
		 */
		public $abstract = 'metabox';
		/**
		 * Pre fields property.
		 *
		 * @var array
		 */
		public $pre_fields = array();
		/**
		 * Sections.
		 *
		 * @var array
		 */
		public $sections = array();
		/**
		 * Post Types.
		 *
		 * @var array
		 */
		public $post_type = array();
		/**
		 * Arguments.
		 *
		 * @var array
		 */
		public $args = array(
			'title'              => '',
			'post_type'          => 'post',
			'data_type'          => 'serialize',
			'context'            => 'advanced',
			'priority'           => 'default',
			'exclude_post_types' => array(),
			'page_templates'     => '',
			'post_formats'       => '',
			'show_reset'         => false,
			'show_restore'       => false,
			'enqueue_webfont'    => true,
			'async_webfont'      => false,
			'output_css'         => true,
			'nav'                => 'normal',
			'theme'              => 'dark',
			'class'              => '',
			'defaults'           => array(),
		);

		/**
		 * Run metabox construct.
		 *
		 * @param mixed $key The metabox key.
		 * @param array $params The metabox parameters.
		 */
		public function __construct( $key, $params = array() ) {

			$this->unique         = $key;
			$this->args           = apply_filters( "spftestimonial_{$this->unique}_args", wp_parse_args( $params['args'], $this->args ), $this );
			$this->sections       = apply_filters( "spftestimonial_{$this->unique}_sections", $params['sections'], $this );
			$this->post_type      = ( is_array( $this->args['post_type'] ) ) ? $this->args['post_type'] : array_filter( (array) $this->args['post_type'] );
			$this->post_formats   = ( is_array( $this->args['post_formats'] ) ) ? $this->args['post_formats'] : array_filter( (array) $this->args['post_formats'] );
			$this->page_templates = ( is_array( $this->args['page_templates'] ) ) ? $this->args['page_templates'] : array_filter( (array) $this->args['page_templates'] );
			$this->pre_fields     = $this->pre_fields( $this->sections );

			add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
			add_action( 'save_post', array( $this, 'save_meta_box' ) );
			add_action( 'edit_attachment', array( $this, 'save_meta_box' ) );

			if ( ! empty( $this->page_templates ) || ! empty( $this->post_formats ) || ! empty( $this->args['class'] ) ) {
				foreach ( $this->post_type as $post_type ) {
					add_filter( 'postbox_classes_' . $post_type . '_' . $this->unique, array( $this, 'add_metabox_classes' ) );
				}
			}

			add_action( 'wp_ajax_sp_tpro_preview_meta_box', array( $this, 'sp_tpro_preview_meta_box' ) );
			// wp enqeueu for typography and output css.
			parent::__construct();

		}

			/**
			 * Instance.
			 *
			 * @param string $key Key of the metabox.
			 * @param array  $params Array of parameters.
			 * @return statement
			 */
		public static function instance( $key, $params = array() ) {
			return new self( $key, $params );
		}
		/**
		 * Pre fields
		 *
		 * @param array $sections The sections.
		 * @return statement
		 */
		public function pre_fields( $sections ) {

			$result = array();

			foreach ( $sections as $key => $section ) {
				if ( ! empty( $section['fields'] ) ) {
					foreach ( $section['fields'] as $field ) {
						$result[] = $field;
					}
				}
			}

			return $result;

		}
		/**
		 * Add metabox classes.
		 *
		 * @param array $classes The metabox classes.
		 */
		public function add_metabox_classes( $classes ) {

			global $post;

			if ( ! empty( $this->post_formats ) ) {

				$saved_post_format = ( is_object( $post ) ) ? get_post_format( $post ) : false;
				$saved_post_format = ( ! empty( $saved_post_format ) ) ? $saved_post_format : 'default';

				$classes[] = 'spftestimonial-post-formats';

				// Sanitize post format for standard to default.
				if ( false !== ( $key = array_search( 'standard', $this->post_formats ) ) ) {
					$this->post_formats[ $key ] = 'default';
				}

				foreach ( $this->post_formats as $format ) {
					$classes[] = 'spftestimonial-post-format-' . $format;
				}

				if ( ! in_array( $saved_post_format, $this->post_formats ) ) {
					$classes[] = 'spftestimonial-metabox-hide';
				} else {
					$classes[] = 'spftestimonial-metabox-show';
				}
			}

			if ( ! empty( $this->page_templates ) ) {

				$saved_template = ( is_object( $post ) && ! empty( $post->page_template ) ) ? $post->page_template : 'default';

				$classes[] = 'spftestimonial-page-templates';

				foreach ( $this->page_templates as $template ) {
					$classes[] = 'spftestimonial-page-' . preg_replace( '/[^a-zA-Z0-9]+/', '-', strtolower( $template ) );
				}

				if ( ! in_array( $saved_template, $this->page_templates ) ) {
					$classes[] = 'spftestimonial-metabox-hide';
				} else {
					$classes[] = 'spftestimonial-metabox-show';
				}
			}

			if ( ! empty( $this->args['class'] ) ) {
				$classes[] = $this->args['class'];
			}

			return $classes;

		}

			/**
			 * Add metabox
			 *
			 * @param array $post_type The post types.
			 */
		public function add_meta_box( $post_type ) {

			if ( ! in_array( $post_type, $this->args['exclude_post_types'] ) ) {
				add_meta_box( $this->unique, $this->args['title'], array( $this, 'add_meta_box_content' ), $this->post_type, $this->args['context'], $this->args['priority'], $this->args );
			}

		}

			/**
			 * Get default value.
			 *
			 * @param array $field The field value.
			 * @return mixed
			 */
		public function get_default( $field ) {

			$default = ( isset( $field['default'] ) ) ? $field['default'] : '';
			$default = ( isset( $this->args['defaults'][ $field['id'] ] ) ) ? $this->args['defaults'][ $field['id'] ] : $default;

			return $default;

		}

		/**
		 * Get meta value.
		 *
		 * @param object $field The field.
		 * @return statement
		 */
		public function get_meta_value( $field ) {

			global $post;

			$value = null;

			if ( is_object( $post ) && ! empty( $field['id'] ) ) {

				if ( 'serialize' !== $this->args['data_type'] ) {
					$meta  = get_post_meta( $post->ID, $field['id'] );
					$value = ( isset( $meta[0] ) ) ? $meta[0] : null;
				} else {
					$meta  = get_post_meta( $post->ID, $this->unique, true );
					$value = ( isset( $meta[ $field['id'] ] ) ) ? $meta[ $field['id'] ] : null;
				}
			}

			$default = ( isset( $field['id'] ) ) ? $this->get_default( $field ) : '';
			$value   = ( isset( $value ) ) ? $value : $default;

			return $value;

		}

		/**
		 * Add metabox content
		 *
		 * @param object $post The post.
		 * @param array  $callback The callback function.
		 * @return void
		 */
		public function add_meta_box_content( $post, $callback ) {
			global $post;
			$has_nav        = ( count( $this->sections ) > 1 && 'side' !== $this->args['context'] ) ? true : false;
			$show_all       = ( ! $has_nav ) ? ' spftestimonial-show-all' : '';
			$post_type      = ( is_object( $post ) ) ? $post->post_type : '';
			$errors         = ( is_object( $post ) ) ? get_post_meta( $post->ID, '_spftestimonial_errors_' . $this->unique, true ) : array();
			$errors         = ( ! empty( $errors ) ) ? $errors : array();
			$theme          = ( $this->args['theme'] ) ? ' spftestimonial-theme-' . $this->args['theme'] : '';
			$nav_type       = ( 'inline' === $this->args['nav'] ) ? 'inline' : 'normal';
			$shortcode_show = isset( $this->args['sp_tpro_shortcode'] ) ? $this->args['sp_tpro_shortcode'] : true;
			$is_preview     = isset( $this->args['preview'] ) ? $this->args['preview'] : false;
			if ( is_object( $post ) && ! empty( $errors ) ) {
				delete_post_meta( $post->ID, '_spftestimonial_errors_' . $this->unique );
			}

			wp_nonce_field( 'spftestimonial_metabox_nonce', 'spftestimonial_metabox_nonce' . $this->unique );
			if ( $is_preview ) {
				?>
			<div id="sp_tpro_live_preview" class="postbox " style="display: none;">
				<div class="postbox-header">
					<h2>Live Preview</h2>
				</div>
				<div class="inside">
					<div class="spftestimonial spftestimonial-metabox spftestimonial-theme-dark">
						<div class="spftestimonial-wrapper spftestimonial-show-all">
							<div class="spftestimonial-content">
								<div class="spftestimonial-sections">
									<div class="spftestimonial-section hidden spftestimonial-onload">
										<div class="spftestimonial-field spftestimonial-field-preview">
											<div class="sp_tpro-preview-box">
												<div id="sp_tpro-preview-box"></div>
											</div>
											<div class="clear"></div>
										</div>
									</div>
								</div><a class="btn btn-success" id="sp-testimonial-show-preview" data-id="<?php esc_attr( $post->ID ); ?>" href=""> <i
								class="fa fa-eye" aria-hidden="true"></i>Show Preview</a>
							</div>
							<div class="clear"></div>
						</div>
					</div>

				</div>
				<div class="sp-testimonial-shortcode-divider"></div>
			</div>
				<?php
			}
			echo '<div class="spftestimonial spftestimonial-metabox' . esc_attr( $theme ) . '">';
			$current_screen        = get_current_screen();
			$the_current_post_type = $current_screen->post_type;
			if ( 'spt_shortcodes' === $the_current_post_type && $shortcode_show ) {
				?>
<div class="sp-testimonial-after-copy-text"><i class="fa fa-check-circle"></i> Shortcode Copied to Clipboard! </div>
<div class="sp-tpro-banner">
	<div class="sp-tpro-logo"><img
			src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/real-testimonials-logo.svg' ); ?>"
			alt="Real Testimonials"></div>
	<div class="sp-tpro-short-links">
		<a href="https://shapedplugin.com/support/" target="_blank"><i class="fa fa-life-ring"></i>Support</a>
	</div>
</div>
<div class="tpro_shortcode text-center">
	<div class="tpro-col-lg-6">
		<div class="tpro_shortcode_content">
			<h2 class="tpro-shortcode-title">
				<?php
				esc_attr_e( 'Shortcode', 'testimonial-free' );
				?>
			</h2>
			<p><?php esc_attr_e( 'Copy and paste this shortcode into your posts or pages:', 'testimonial-free' ); ?></p>
			<div class="tpro-sc-code selectable">[sp_testimonial <?php echo 'id="' . esc_attr( $post->ID ) . '"'; ?>]
			</div>
		</div>
	</div>
	<div class="tpro-col-lg-6">
		<div class="tpro_shortcode_content">
			<h2 class="tpro-shortcode-title">
				<?php
				esc_attr_e( 'Template Include', 'testimonial-free' );
				?>
			</h2>
			<p><?php esc_attr_e( 'Paste the PHP code into your template file:', 'testimonial-free' ); ?></p>
			<div class="tpro-sc-code selectable">&lt;?php echo do_shortcode('[sp_testimonial
				id="<?php echo esc_attr( $post->ID ); ?>"]');?&gt;</div>
		</div>
	</div>
</div>
<div class="sp-testimonial-shortcode-divider"></div>
				<?php
			}
			echo '<div class="spftestimonial-wrapper' . esc_attr( $show_all ) . '">';

			if ( $has_nav ) {

				echo '<div class="spftestimonial-nav spftestimonial-nav-' . esc_attr( $nav_type ) . ' spftestimonial-nav-metabox">';

				echo '<ul>';

				$tab_key = 0;

				foreach ( $this->sections as $section ) {
					if ( ! empty( $section['post_type'] ) && ! in_array( $post_type, array_filter( (array) $section['post_type'] ) ) ) {
						continue;
					}
					$tab_error = ( ! empty( $errors['sections'][ $tab_key ] ) ) ? '<i class="spftestimonial-label-error spftestimonial-error">!</i>' : '';
					$tab_icon  = ( ! empty( $section['icon'] ) ) ? '<i class="spftestimonial-tab-icon ' . esc_attr( $section['icon'] ) . '"></i>' : '';

					echo '<li><a href="#" data-section="' . esc_attr( $this->unique . '_' . $tab_key ) . '">' . wp_kses_post( $tab_icon . $section['title'] . $tab_error ) . '</a></li>';

					$tab_key++;

				}

				echo '</ul>';

				echo '</div>';

			}

			echo '<div class="spftestimonial-content">';

			echo '<div class="spftestimonial-sections">';

			$section_key = 0;

			foreach ( $this->sections as $section ) {

				if ( ! empty( $section['post_type'] ) && ! in_array( $post_type, array_filter( (array) $section['post_type'] ) ) ) {
					continue;
				}

				$section_onload = ( ! $has_nav ) ? ' spftestimonial-onload' : '';
				$section_class  = ( ! empty( $section['class'] ) ) ? ' ' . $section['class'] : '';
				$section_title  = ( ! empty( $section['title'] ) ) ? $section['title'] : '';
				$section_icon   = ( ! empty( $section['icon'] ) ) ? '<i class="spftestimonial-section-icon ' . esc_attr( $section['icon'] ) . '"></i>' : '';

				echo '<div class="spftestimonial-section hidden' . esc_attr( $section_onload . $section_class ) . '">';

				echo ( $section_title || $section_icon ) ? '<div class="spftestimonial-section-title"><h3>' . wp_kses_post( $section_icon . $section_title ) . '</h3></div>' : '';
				echo ( ! empty( $section['description'] ) ) ? '<div class="spftestimonial-field spftestimonial-section-description">' . wp_kses_post( $section['description'] ) . '</div>' : '';

				if ( ! empty( $section['fields'] ) ) {

					foreach ( $section['fields'] as $field ) {

						if ( ! empty( $field['id'] ) && ! empty( $errors['fields'][ $field['id'] ] ) ) {
							$field['_error'] = $errors['fields'][ $field['id'] ];
						}

						if ( ! empty( $field['id'] ) ) {
							$field['default'] = $this->get_default( $field );
						}

						SPFTESTIMONIAL::field( $field, $this->get_meta_value( $field ), $this->unique, 'metabox' );

					}
				} else {

					echo '<div class="spftestimonial-no-option">' . esc_html__( 'No data available.', 'testimonial-free' ) . '</div>';

				}

				echo '</div>';

				$section_key++;

			}

			echo '</div>';
			echo '<a class="btn btn-success" id="sp-testimonial-show-preview" data-id="' . esc_attr( $post->ID ) . '"href=""> <i class="fa fa-eye" aria-hidden="true"></i> Show Preview</a>';

			if ( ! empty( $this->args['show_restore'] ) || ! empty( $this->args['show_reset'] ) ) {

				echo '<div class="spftestimonial-sections-reset">';
				echo '<label>';
				echo '<input type="checkbox" name="' . esc_attr( $this->unique ) . '[_reset]" />';
				echo '<span class="button spftestimonial-button-reset">' . esc_html__( 'Reset', 'testimonial-free' ) . '</span>';
				echo '<span class="button spftestimonial-button-cancel">' . sprintf( '<small>( %s )</small> %s', esc_html__( 'update post', 'testimonial-free' ), esc_html__( 'Cancel', 'testimonial-free' ) ) . '</span>';
				echo '</label>';
				echo '</div>';

			}

			echo '</div>';

			echo ( $has_nav && 'normal' === $nav_type ) ? '<div class="spftestimonial-nav-background"></div>' : '';

			echo '<div class="clear"></div>';

			echo '</div>';

			echo '</div>';

		}

		/**
		 * Save metabox.
		 *
		 * @param array $post_id The post IDs.
		 * @return statement
		 */
		public function save_meta_box( $post_id ) {

			$count    = 1;
			$data     = array();
			$errors   = array();
			$noncekey = 'spftestimonial_metabox_nonce' . $this->unique;
			$nonce    = ( ! empty( $_POST[ $noncekey ] ) ) ? sanitize_text_field( wp_unslash( $_POST[ $noncekey ] ) ) : '';

			if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! wp_verify_nonce( $nonce, 'spftestimonial_metabox_nonce' ) ) {
				return $post_id;
			}

			// XSS ok.
			// No worries, This "POST" requests is sanitizing in the below foreach.
			$request = ( ! empty( $_POST[ $this->unique ] ) ) ? wp_unslash( $_POST[ $this->unique ] ) : array();

			if ( ! empty( $request ) ) {

				foreach ( $this->sections as $section ) {

					if ( ! empty( $section['fields'] ) ) {

						foreach ( $section['fields'] as $field ) {

							if ( ! empty( $field['id'] ) ) {

								$field_id    = $field['id'];
								$field_value = isset( $request[ $field_id ] ) ? $request[ $field_id ] : '';

								// Sanitize "post" request of field.
								if ( isset( $field['sanitize'] ) && is_callable( $field['sanitize'] ) ) {
										$data[ $field_id ] = call_user_func( $field['sanitize'], $field_value );
								} else {
									if ( is_array( $field_value ) ) {
										$data[ $field_id ] = wp_kses_post_deep( $field_value );
									} else {
										$data[ $field_id ] = wp_kses_post( $field_value );
									}
								}

								// Validate "post" request of field.
								if ( isset( $field['validate'] ) && is_callable( $field['validate'] ) ) {

									$has_validated = call_user_func( $field['validate'], $field_value );

									if ( ! empty( $has_validated ) ) {

										$errors['sections'][ $count ]  = true;
										$errors['fields'][ $field_id ] = $has_validated;
										$data[ $field_id ]             = $this->get_meta_value( $field );

									}
								}
							}
						}
					}

					$count++;

				}
			}

			$data = apply_filters( "spftestimonial_{$this->unique}_save", $data, $post_id, $this );

			do_action( "spftestimonial_{$this->unique}_save_before", $data, $post_id, $this );

			if ( empty( $data ) || ! empty( $request['_reset'] ) ) {

				if ( 'serialize' !== $this->args['data_type'] ) {
					foreach ( $data as $key => $value ) {
						delete_post_meta( $post_id, $key );
					}
				} else {
					delete_post_meta( $post_id, $this->unique );
				}
			} else {
				if ( 'serialize' !== $this->args['data_type'] ) {
					foreach ( $data as $key => $value ) {
						update_post_meta( $post_id, $key, $value );
					}
				} else {
					update_post_meta( $post_id, $this->unique, $data );
				}

				if ( ! empty( $errors ) ) {
					update_post_meta( $post_id, '_spftestimonial_errors_' . $this->unique, $errors );
				}
			}
			do_action( "spftestimonial_{$this->unique}_saved", $data, $post_id, $this );
			do_action( "spftestimonial_{$this->unique}_save_after", $data, $post_id, $this );
		}

		/**
		 * Function Backed preview.
		 *
		 * @since 2.2.5
		 */
		public function sp_tpro_preview_meta_box() {
			$nonce = isset( $_POST['ajax_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['ajax_nonce'] ) ) : '';
			if ( ! wp_verify_nonce( $nonce, 'spftestimonial_metabox_nonce' ) ) {
				return;
			}

			$data   = array();
			$count  = 1;
			$errors = array();
			// XSS ok.
			// No worries, This "POST" requests is sanitizing in the below array foreach.
			$request = ! empty( $_POST['data'] ) ? wp_unslash( $_POST['data'] )  : ''; // phpcs:ignore
			parse_str( $request, $request );
			// Preset Layouts.
			$post_id            = absint( $request['post_ID'] );
			$setting_options    = get_option( 'sp_testimonial_pro_options' );
			$main_section_title = wp_kses_post( $request['post_title'] );
			$request            = $request['sp_tpro_shortcode_options'];
			$outline            = '<style>';
			$shortcode_data     = $request;
			include SP_TFREE_PATH . 'Frontend/Views/partials/dynamic-style.php';
			$outline .= '</style>';
			echo $outline;
			if ( ! empty( $request ) ) {

				foreach ( $this->sections as $section ) {

					if ( ! empty( $section['fields'] ) ) {

						foreach ( $section['fields'] as $field ) {

							if ( ! empty( $field['id'] ) ) {

								$field_id    = $field['id'];
								$field_value = isset( $request[ $field_id ] ) ? $request[ $field_id ] : '';

								// Sanitize "post" request of field.
								if ( isset( $field['sanitize'] ) && is_callable( $field['sanitize'] ) ) {
										$data[ $field_id ] = call_user_func( $field['sanitize'], $field_value );
								} else {
									if ( is_array( $field_value ) ) {
										$data[ $field_id ] = wp_kses_post_deep( $field_value );
									} else {
										$data[ $field_id ] = wp_kses_post( $field_value );
									}
								}
								// Validate "post" request of field.
								if ( isset( $field['validate'] ) && is_callable( $field['validate'] ) ) {

									$has_validated = call_user_func( $field['validate'], $field_value );

									if ( ! empty( $has_validated ) ) {

										$errors['sections'][ $count ]  = true;
										$errors['fields'][ $field_id ] = $has_validated;
										$data[ $field_id ]             = $this->get_meta_value( $field );

									}
								}
							}
						}
					}

					$count++;

				}
			}
			Helper::sp_testimonial_html_show( $post_id, $setting_options, $data, $main_section_title );
			die();
		}
	}
}

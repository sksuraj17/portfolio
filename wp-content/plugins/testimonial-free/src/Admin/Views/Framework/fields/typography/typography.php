<?php
/**
 * Framework typography field file.
 *
 * @link https://shapedplugin.com
 * @since 2.0.0
 *
 * @package Testimonial_free
 * @subpackage Testimonial_free/framework
 */

use ShapedPlugin\TestimonialFree\Admin\Views\Framework\Classes\SPFTESTIMONIAL;

if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.

if ( ! class_exists( 'SPFTESTIMONIAL_Field_typography' ) ) {
	/**
	 *
	 * Field: typography
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SPFTESTIMONIAL_Field_typography extends SPFTESTIMONIAL_Fields {
		/**
		 * Chosen
		 *
		 * @var bool
		 */
		public $chosen = false;
		/**
		 * Value
		 *
		 * @var array
		 */
		public $value = array();

		/**
		 * Field constructor.
		 *
		 * @param array  $field The field type.
		 * @param string $value The values of the field.
		 * @param string $unique The unique ID for the field.
		 * @param string $where To where show the output CSS.
		 * @param string $parent The parent args.
		 */
		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		/**
		 * Render field
		 *
		 * @return void
		 */
		public function render() {

			echo wp_kses_post( $this->field_before() );

			$args = wp_parse_args(
				$this->field,
				array(
					'font_family'        => true,
					'font_weight'        => true,
					'font_style'         => true,
					'font_size'          => true,
					'line_height'        => true,
					'letter_spacing'     => true,
					'text_align'         => true,
					'text_transform'     => true,
					'color'              => true,
					'chosen'             => true,
					'preview'            => true,
					'subset'             => true,
					'multi_subset'       => false,
					'extra_styles'       => false,
					'backup_font_family' => false,
					'font_variant'       => false,
					'word_spacing'       => false,
					'text_decoration'    => false,
					'custom_style'       => false,
					'compact'            => false,
					'exclude'            => '',
					'unit'               => 'px',
					'margin_top'         => false,
					'margin_right'       => false,
					'margin_bottom'      => false,
					'margin-left'        => false,
					'line_height_unit'   => '',
					'preview_text'       => 'The quick brown fox jumps over the lazy dog',
				)
			);

			if ( $args['compact'] ) {
				$args['text_transform'] = false;
				$args['text_align']     = false;
				$args['font_size']      = false;
				$args['line_height']    = false;
				$args['letter_spacing'] = false;
				$args['preview']        = false;
				$args['color']          = false;
			}

			$default_value = array(
				'font-family'        => '',
				'font-weight'        => '',
				'font-style'         => '',
				'font-variant'       => '',
				'font-size'          => '',
				'line-height'        => '',
				'letter-spacing'     => '',
				'word-spacing'       => '',
				'text-align'         => '',
				'text-transform'     => '',
				'text-decoration'    => '',
				'backup-font-family' => '',
				'color'              => '',
				'custom-style'       => '',
				'type'               => '',
				'subset'             => '',
				'extra-styles'       => array(),
				'margin-top'         => '',
				'margin-right'       => '',
				'margin-bottom'      => '',
				'margin-left'        => '',
			);

			$default_value    = ( ! empty( $this->field['default'] ) ) ? wp_parse_args( $this->field['default'], $default_value ) : $default_value;
			$this->value      = wp_parse_args( $this->value, $default_value );
			$this->chosen     = $args['chosen'];
			$chosen_class     = ( $this->chosen ) ? ' spftestimonial--chosen' : '';
			$line_height_unit = ( ! empty( $args['line_height_unit'] ) ) ? $args['line_height_unit'] : $args['unit'];

			echo '<div class="spftestimonial--typography' . esc_attr( $chosen_class ) . '" data-depend-id="' . esc_attr( $this->field['id'] ) . '" data-unit="' . esc_attr( $args['unit'] ) . '" data-line-height-unit="' . esc_attr( $line_height_unit ) . '" data-exclude="' . esc_attr( $args['exclude'] ) . '">';

			echo '<div class="spftestimonial--blocks spftestimonial--blocks-selects">';

			//
			// Font Family.
			if ( ! empty( $args['font_family'] ) ) {
				echo '<div class="spftestimonial--block">';
				echo '<div class="spftestimonial--title">' . esc_html__( 'Font Family', 'testimonial-free' ) . '</div>';
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $this->create_select( array( $this->value['font-family'] => $this->value['font-family'] ), 'font-family', esc_html__( 'Select a font', 'testimonial-free' ) );
				echo '</div>';
			}

			//
			// Backup Font Family.
			if ( ! empty( $args['backup_font_family'] ) ) {
				echo '<div class="spftestimonial--block spftestimonial--block-backup-font-family hidden">';
				echo '<div class="spftestimonial--title">' . esc_html__( 'Backup Font Family', 'testimonial-free' ) . '</div>';
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $this->create_select(
					apply_filters(
						'spftestimonial_field_typography_backup_font_family',
						array(
							'Arial, Helvetica, sans-serif',
							"'Arial Black', Gadget, sans-serif",
							"'Comic Sans MS', cursive, sans-serif",
							'Impact, Charcoal, sans-serif',
							"'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
							'Tahoma, Geneva, sans-serif',
							"'Trebuchet MS', Helvetica, sans-serif'",
							'Verdana, Geneva, sans-serif',
							"'Courier New', Courier, monospace",
							"'Lucida Console', Monaco, monospace",
							'Georgia, serif',
							'Palatino Linotype',
						)
					),
					'backup-font-family',
					esc_html__( 'Default', 'testimonial-free' )
				);
				echo '</div>';
			}

			//
			// Font Style and Extra Style Select.
			if ( ! empty( $args['font_weight'] ) || ! empty( $args['font_style'] ) ) {

				//
				// Font Style Select.
				echo '<div class="spftestimonial--block spftestimonial--block-font-style hidden">';
				echo '<div class="spftestimonial--title">' . esc_html__( 'Font Style', 'testimonial-free' ) . '</div>';
				echo '<select class="spftestimonial--font-style-select" data-placeholder="Default">';
				echo '<option value="">' . ( ! $this->chosen ? esc_html__( 'Default', 'testimonial-free' ) : '' ) . '</option>';// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				if ( ! empty( $this->value['font-weight'] ) || ! empty( $this->value['font-style'] ) ) {
					echo '<option value="' . esc_attr( strtolower( $this->value['font-weight'] . $this->value['font-style'] ) ) . '" selected></option>';
				}
				echo '</select>';
				echo '<input type="hidden" name="' . esc_attr( $this->field_name( '[font-weight]' ) ) . '" class="spftestimonial--font-weight" value="' . esc_attr( $this->value['font-weight'] ) . '" />';
				echo '<input type="hidden" name="' . esc_attr( $this->field_name( '[font-style]' ) ) . '" class="spftestimonial--font-style" value="' . esc_attr( $this->value['font-style'] ) . '" />';

				//
				// Extra Font Style Select.
				if ( ! empty( $args['extra_styles'] ) ) {
					echo '<div class="spftestimonial--block-extra-styles hidden">';
					echo ( ! $this->chosen ) ? '<div class="spftestimonial--title">' . esc_html__( 'Load Extra Styles', 'testimonial-free' ) . '</div>' : '';
					$placeholder = ( $this->chosen ) ? esc_html__( 'Load Extra Styles', 'testimonial-free' ) : esc_html__( 'Default', 'testimonial-free' );
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo $this->create_select( $this->value['extra-styles'], 'extra-styles', $placeholder, true );
					echo '</div>';
				}

				echo '</div>';

			}

			//
			// Subset.
			if ( ! empty( $args['subset'] ) ) {
				echo '<div class="spftestimonial--block spftestimonial--block-subset hidden">';
				echo '<div class="spftestimonial--title">' . esc_html__( 'Subset', 'testimonial-free' ) . '</div>';
				$subset = ( is_array( $this->value['subset'] ) ) ? $this->value['subset'] : array_filter( (array) $this->value['subset'] );
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $this->create_select( $subset, 'subset', esc_html__( 'Default', 'testimonial-free' ), $args['multi_subset'] );
				echo '</div>';
			}

			//
			// Text Align.
			if ( ! empty( $args['text_align'] ) ) {
				echo '<div class="spftestimonial--block">';
				echo '<div class="spftestimonial--title">' . esc_html__( 'Text Align', 'testimonial-free' ) . '</div>';
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $this->create_select(
					array(
						'inherit' => esc_html__( 'Inherit', 'testimonial-free' ),
						'left'    => esc_html__( 'Left', 'testimonial-free' ),
						'center'  => esc_html__( 'Center', 'testimonial-free' ),
						'right'   => esc_html__( 'Right', 'testimonial-free' ),
						'justify' => esc_html__( 'Justify', 'testimonial-free' ),
						'initial' => esc_html__( 'Initial', 'testimonial-free' ),
					),
					'text-align',
					esc_html__( 'Default', 'testimonial-free' )
				);
				echo '</div>';
			}

			//
			// Font Variant.
			if ( ! empty( $args['font_variant'] ) ) {
				echo '<div class="spftestimonial--block">';
				echo '<div class="spftestimonial--title">' . esc_html__( 'Font Variant', 'testimonial-free' ) . '</div>';
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $this->create_select(
					array(
						'normal'         => esc_html__( 'Normal', 'testimonial-free' ),
						'small-caps'     => esc_html__( 'Small Caps', 'testimonial-free' ),
						'all-small-caps' => esc_html__( 'All Small Caps', 'testimonial-free' ),
					),
					'font-variant',
					esc_html__( 'Default', 'testimonial-free' )
				);
				echo '</div>';
			}

			//
			// Text Transform.
			if ( ! empty( $args['text_transform'] ) ) {
				echo '<div class="spftestimonial--block">';
				echo '<div class="spftestimonial--title">' . esc_html__( 'Text Transform', 'testimonial-free' ) . '</div>';
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $this->create_select(
					array(
						'none'       => esc_html__( 'None', 'testimonial-free' ),
						'capitalize' => esc_html__( 'Capitalize', 'testimonial-free' ),
						'uppercase'  => esc_html__( 'Uppercase', 'testimonial-free' ),
						'lowercase'  => esc_html__( 'Lowercase', 'testimonial-free' ),
					),
					'text-transform',
					esc_html__( 'Default', 'testimonial-free' )
				);
				echo '</div>';
			}

			//
			// Text Decoration.
			if ( ! empty( $args['text_decoration'] ) ) {
				echo '<div class="spftestimonial--block">';
				echo '<div class="spftestimonial--title">' . esc_html__( 'Text Decoration', 'testimonial-free' ) . '</div>';
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $this->create_select(
					array(
						'none'               => esc_html__( 'None', 'testimonial-free' ),
						'underline'          => esc_html__( 'Solid', 'testimonial-free' ),
						'underline double'   => esc_html__( 'Double', 'testimonial-free' ),
						'underline dotted'   => esc_html__( 'Dotted', 'testimonial-free' ),
						'underline dashed'   => esc_html__( 'Dashed', 'testimonial-free' ),
						'underline wavy'     => esc_html__( 'Wavy', 'testimonial-free' ),
						'underline overline' => esc_html__( 'Overline', 'testimonial-free' ),
						'line-through'       => esc_html__( 'Line-through', 'testimonial-free' ),
					),
					'text-decoration',
					esc_html__( 'Default', 'testimonial-free' )
				);
				echo '</div>';
			}

			echo '</div>';

			echo '<div class="spftestimonial--blocks spftestimonial--blocks-inputs">';

			//
			// Font Size.
			if ( ! empty( $args['font_size'] ) ) {
				echo '<div class="spftestimonial--block">';
				echo '<div class="spftestimonial--title">' . esc_html__( 'Font Size', 'testimonial-free' ) . '</div>';
				echo '<div class="spftestimonial--input-wrap">';
				echo '<input type="number" name="' . esc_attr( $this->field_name( '[font-size]' ) ) . '" class="spftestimonial--font-size spftestimonial--input spftestimonial-input-number" value="' . esc_attr( $this->value['font-size'] ) . '" step="any" />';
				echo '<span class="spftestimonial--unit">' . esc_attr( $args['unit'] ) . '</span>';
				echo '</div>';
				echo '</div>';
			}

			//
			// Line Height.
			if ( ! empty( $args['line_height'] ) ) {
				echo '<div class="spftestimonial--block">';
				echo '<div class="spftestimonial--title">' . esc_html__( 'Line Height', 'testimonial-free' ) . '</div>';
				echo '<div class="spftestimonial--input-wrap">';
				echo '<input type="number" name="' . esc_attr( $this->field_name( '[line-height]' ) ) . '" class="spftestimonial--line-height spftestimonial--input spftestimonial-input-number" value="' . esc_attr( $this->value['line-height'] ) . '" step="any" />';
				echo '<span class="spftestimonial--unit">' . esc_attr( $line_height_unit ) . '</span>';
				echo '</div>';
				echo '</div>';
			}

			//
			// Letter Spacing.
			if ( ! empty( $args['letter_spacing'] ) ) {
				echo '<div class="spftestimonial--block">';
				echo '<div class="spftestimonial--title">' . esc_html__( 'Letter Spacing', 'testimonial-free' ) . '</div>';
				echo '<div class="spftestimonial--input-wrap">';
				echo '<input type="number" name="' . esc_attr( $this->field_name( '[letter-spacing]' ) ) . '" class="spftestimonial--letter-spacing spftestimonial--input spftestimonial-input-number" value="' . esc_attr( $this->value['letter-spacing'] ) . '" step="any" />';
				echo '<span class="spftestimonial--unit">' . esc_attr( $args['unit'] ) . '</span>';
				echo '</div>';
				echo '</div>';
			}

			//
			// Word Spacing.
			if ( ! empty( $args['word_spacing'] ) ) {
				echo '<div class="spftestimonial--block">';
				echo '<div class="spftestimonial--title">' . esc_html__( 'Word Spacing', 'testimonial-free' ) . '</div>';
				echo '<div class="spftestimonial--input-wrap">';
				echo '<input type="number" name="' . esc_attr( $this->field_name( '[word-spacing]' ) ) . '" class="spftestimonial--word-spacing spftestimonial--input spftestimonial-input-number" value="' . esc_attr( $this->value['word-spacing'] ) . '" step="any" />';
				echo '<span class="spftestimonial--unit">' . esc_attr( $args['unit'] ) . '</span>';
				echo '</div>';
				echo '</div>';
			}
			//
			// Margin Top.
			if ( ! empty( $args['margin_top'] ) ) {
				echo '<div class="spftestimonial--block">';
				echo '<div class="spftestimonial--title">' . esc_html__( 'Margin Top', 'testimonial-free' ) . '</div>';
				echo '<div class="spftestimonial--input-wrap">';
				echo '<div class="spftestimonial--block"><input type="number" name="' . esc_attr( $this->field_name( '[margin-top]' ) ) . '" class="spftestimonial--margin-top spftestimonial--input spftestimonial-input-number" value="' . esc_attr( $this->value['margin-top'] ) . '" /></div>';
				echo '<div class="spftestimonial--unit">' . esc_attr( $args['unit'] ) . '</div>';
				echo '</div>';
				echo '</div>';
			}

			//
			// Margin Right.
			if ( ! empty( $args['margin_right'] ) ) {
				echo '<div class="spftestimonial--block">';
				echo '<div class="spftestimonial--title">' . esc_html__( 'Margin Right', 'testimonial-free' ) . '</div>';
				echo '<div class="spftestimonial--input-wrap">';
				echo '<input type="number" name="' . esc_attr( $this->field_name( '[margin-right]' ) ) . '" class="spftestimonial--margin-right spftestimonial--input spftestimonial-input-number" value="' . esc_attr( $this->value['margin-right'] ) . '" />';
				echo '<div class="spftestimonial--unit">' . esc_attr( $args['unit'] ) . '</div>';
				echo '</div>';
				echo '</div>';
			}

			//
			// Margin Bottom.
			if ( ! empty( $args['margin_bottom'] ) ) {
				echo '<div class="spftestimonial--block">';
				echo '<div class="spftestimonial--title">' . esc_html__( 'Margin Bottom', 'testimonial-free' ) . '</div>';
				echo '<div class="spftestimonial--input-wrap">';
				echo '<input type="number" name="' . esc_attr( $this->field_name( '[margin-bottom]' ) ) . '" class="spftestimonial--margin-bottom spftestimonial--input spftestimonial-input-number" value="' . esc_attr( $this->value['margin-bottom'] ) . '" />';
				echo '<div class="spftestimonial--unit">' . esc_attr( $args['unit'] ) . '</div>';
				echo '</div>';
				echo '</div>';
			}

			//
			// Margin Left.
			if ( ! empty( $args['margin_left'] ) ) {
				echo '<div class="spftestimonial--block">';
				echo '<div class="spftestimonial--title">' . esc_html__( 'Margin Left', 'testimonial-free' ) . '</div>';
				echo '<div class="spftestimonial--input-wrap">';
				echo '<input type="number" name="' . esc_attr( $this->field_name( '[margin-left]' ) ) . '" class="spftestimonial--margin-left spftestimonial--input spftestimonial-input-number" value="' . esc_attr( $this->value['margin-left'] ) . '" />';
				echo '<div class="spftestimonial--unit">' . esc_attr( $args['unit'] ) . '</div>';
				echo '</div>';
				echo '</div>';
			}

			echo '</div>';

			//
			// Font Color.
			if ( ! empty( $args['color'] ) ) {
				$default_color_attr = ( ! empty( $default_value['color'] ) ) ? $default_value['color'] : '';
				echo '<div class="spftestimonial--block spftestimonial--block-font-color">';
				echo '<div class="spftestimonial--title">' . esc_html__( 'Font Color', 'testimonial-free' ) . '</div>';
				echo '<div class="spftestimonial-field-color">';
				echo '<input type="text" name="' . esc_attr( $this->field_name( '[color]' ) ) . '" class="spftestimonial-color spftestimonial--color" value="' . esc_attr( $this->value['color'] ) . '" data-default-color="' . esc_attr( $default_color_attr ) . '" />';
				echo '</div>';
				echo '</div>';
			}

			//
			// Custom style.
			if ( ! empty( $args['custom_style'] ) ) {
				echo '<div class="spftestimonial--block spftestimonial--block-custom-style">';
				echo '<div class="spftestimonial--title">' . esc_html__( 'Custom Style', 'testimonial-free' ) . '</div>';
				echo '<textarea name="' . esc_attr( $this->field_name( '[custom-style]' ) ) . '" class="spftestimonial--custom-style">' . esc_attr( $this->value['custom-style'] ) . '</textarea>';
				echo '</div>';
			}

			//
			// Preview.
			$always_preview = ( 'always' !== $args['preview'] ) ? ' hidden' : '';

			if ( ! empty( $args['preview'] ) ) {
				echo '<div class="spftestimonial--block spftestimonial--block-preview' . esc_attr( $always_preview ) . '">';
				echo '<div class="spftestimonial--toggle fa fa-toggle-off"></div>';
				echo '<div class="spftestimonial--preview">' . esc_attr( $args['preview_text'] ) . '</div>';
				echo '</div>';
			}

			echo '<input type="hidden" name="' . esc_attr( $this->field_name( '[type]' ) ) . '" class="spftestimonial--type" value="' . esc_attr( $this->value['type'] ) . '" />';
			echo '<input type="hidden" name="' . esc_attr( $this->field_name( '[unit]' ) ) . '" class="spftestimonial--unit-save" value="' . esc_attr( $args['unit'] ) . '" />';

			echo '</div>';

			echo wp_kses_post( $this->field_after() );

		}
		/**
		 * Create select
		 *
		 * @param  array  $options options.
		 * @param  string $name name.
		 * @param  mixed  $placeholder placeholder.
		 * @param  bool   $is_multiple is_multiple.
		 * @return statement
		 */
		public function create_select( $options, $name, $placeholder = '', $is_multiple = false ) {

			$multiple_name = ( $is_multiple ) ? '[]' : '';
			$multiple_attr = ( $is_multiple ) ? ' multiple data-multiple="true"' : '';
			$chosen_rtl    = ( $this->chosen && is_rtl() ) ? ' chosen-rtl' : '';

			$output  = '<select name="' . esc_attr( $this->field_name( '[' . $name . ']' . $multiple_name ) ) . '" class="spftestimonial--' . esc_attr( $name ) . esc_attr( $chosen_rtl ) . '" data-placeholder="' . esc_attr( $placeholder ) . '"' . $multiple_attr . '>';
			$output .= ( ! empty( $placeholder ) ) ? '<option value="">' . esc_attr( ( ! $this->chosen ) ? $placeholder : '' ) . '</option>' : '';

			if ( ! empty( $options ) ) {
				foreach ( $options as $option_key => $option_value ) {
					if ( $is_multiple ) {
						$selected = ( in_array( $option_value, $this->value[ $name ] ) ) ? ' selected' : '';
						$output  .= '<option value="' . esc_attr( $option_value ) . '"' . esc_attr( $selected ) . '>' . esc_attr( $option_value ) . '</option>';
					} else {
						$option_key = ( is_numeric( $option_key ) ) ? $option_value : $option_key;
						$selected   = ( $option_key === $this->value[ $name ] ) ? ' selected' : '';
						$output    .= '<option value="' . esc_attr( $option_key ) . '"' . esc_attr( $selected ) . '>' . esc_attr( $option_value ) . '</option>';
					}
				}
			}

			$output .= '</select>';

			return $output;

		}
		/**
		 * Enqueue
		 *
		 * @return void
		 */
		public function enqueue() {

			if ( ! wp_script_is( 'spftestimonial-webfontloader' ) ) {

				SPFTESTIMONIAL::include_plugin_file( 'fields/typography/google-fonts.php' );

				// wp_enqueue_script( 'spftestimonial-webfontloader', 'https://cdn.jsdelivr.net/npm/webfontloader@1.6.28/webfontloader.min.js', array( 'spftestimonial' ), '1.6.28', true );.

				$webfonts = array();

				$customwebfonts = apply_filters( 'spftestimonial_field_typography_customwebfonts', array() );

				if ( ! empty( $customwebfonts ) ) {
					$webfonts['custom'] = array(
						'label' => esc_html__( 'Custom Web Fonts', 'testimonial-free' ),
						'fonts' => $customwebfonts,
					);
				}

				$webfonts['safe'] = array(
					'label' => esc_html__( 'Safe Web Fonts', 'testimonial-free' ),
					'fonts' => apply_filters(
						'spftestimonial_field_typography_safewebfonts',
						array(
							'Arial',
							'Arial Black',
							'Helvetica',
							'Times New Roman',
							'Courier New',
							'Tahoma',
							'Verdana',
							'Impact',
							'Trebuchet MS',
							'Comic Sans MS',
							'Lucida Console',
							'Lucida Sans Unicode',
							'Georgia, serif',
							'Palatino Linotype',
						)
					),
				);

				$defaultstyles = apply_filters( 'spftestimonial_field_typography_defaultstyles', array( 'normal', 'italic', '700', '700italic' ) );

				$googlestyles = apply_filters(
					'spftestimonial_field_typography_googlestyles',
					array(
						'100'       => 'Thin 100',
						'100italic' => 'Thin 100 Italic',
						'200'       => 'Extra-Light 200',
						'200italic' => 'Extra-Light 200 Italic',
						'300'       => 'Light 300',
						'300italic' => 'Light 300 Italic',
						'normal'    => 'Normal 400',
						'italic'    => 'Normal 400 Italic',
						'500'       => 'Medium 500',
						'500italic' => 'Medium 500 Italic',
						'600'       => 'Semi-Bold 600',
						'600italic' => 'Semi-Bold 600 Italic',
						'700'       => 'Bold 700',
						'700italic' => 'Bold 700 Italic',
						'800'       => 'Extra-Bold 800',
						'800italic' => 'Extra-Bold 800 Italic',
						'900'       => 'Black 900',
						'900italic' => 'Black 900 Italic',
					)
				);

				$webfonts = apply_filters( 'spftestimonial_field_typography_webfonts', $webfonts );

				wp_localize_script(
					'spftestimonial',
					'spftestimonial_typography_json',
					array(
						'webfonts'      => $webfonts,
						'defaultstyles' => $defaultstyles,
						'googlestyles'  => $googlestyles,
					)
				);

			}

		}
		/**
		 * Enqueue google fonts.
		 *
		 * @param mixed $method method.
		 * @return mixed
		 */
		public function enqueue_google_fonts( $method = 'enqueue' ) {

			$is_google = false;

			if ( ! empty( $this->value['type'] ) ) {
				$is_google = ( 'google' === $this->value['type'] ) ? true : false;
			} else {
				SPFTESTIMONIAL::include_plugin_file( 'fields/typography/google-fonts.php' );
				$is_google = ( array_key_exists( $this->value['font-family'], spftestimonial_get_google_fonts() ) ) ? true : false;
			}

			if ( $is_google ) {

				// set style.
				$font_family = ( ! empty( $this->value['font-family'] ) ) ? $this->value['font-family'] : '';
				$font_weight = ( ! empty( $this->value['font-weight'] ) ) ? $this->value['font-weight'] : '';
				$font_style  = ( ! empty( $this->value['font-style'] ) ) ? $this->value['font-style'] : '';

				if ( $font_weight || $font_style ) {
					$style = $font_weight . $font_style;
					if ( ! empty( $style ) ) {
						$style = ( 'normal' === $style ) ? '400' : $style;
						SPFTESTIMONIAL::$webfonts[ $method ][ $font_family ][ $style ] = $style;
					}
				} else {
					SPFTESTIMONIAL::$webfonts[ $method ][ $font_family ] = array();
				}

				// set extra styles.
				if ( ! empty( $this->value['extra-styles'] ) ) {
					foreach ( $this->value['extra-styles'] as $extra_style ) {
						if ( ! empty( $extra_style ) ) {
							$extra_style = ( 'normal' === $extra_style ) ? '400' : $extra_style;
							SPFTESTIMONIAL::$webfonts[ $method ][ $font_family ][ $extra_style ] = $extra_style;
						}
					}
				}

				// set subsets.
				if ( ! empty( $this->value['subset'] ) ) {
					$this->value['subset'] = ( is_array( $this->value['subset'] ) ) ? $this->value['subset'] : array_filter( (array) $this->value['subset'] );
					foreach ( $this->value['subset'] as $subset ) {
						if ( ! empty( $subset ) ) {
							SPFTESTIMONIAL::$subsets[ $subset ] = $subset;
						}
					}
				}

				return true;

			}

			return false;

		}
		/**
		 * Output
		 *
		 * @return statement
		 */
		public function output() {

			$output    = '';
			$bg_image  = array();
			$important = ( ! empty( $this->field['output_important'] ) ) ? '!important' : '';
			$element   = ( is_array( $this->field['output'] ) ) ? join( ',', $this->field['output'] ) : $this->field['output'];

			$font_family   = ( ! empty( $this->value['font-family'] ) ) ? $this->value['font-family'] : '';
			$backup_family = ( ! empty( $this->value['backup-font-family'] ) ) ? ', ' . $this->value['backup-font-family'] : '';

			if ( $font_family ) {
				$output .= 'font-family:"' . $font_family . '"' . $backup_family . $important . ';';
			}

			// Common font properties.
			$properties = array(
				'color',
				'font-weight',
				'font-style',
				'font-variant',
				'text-align',
				'text-transform',
				'text-decoration',
			);

			foreach ( $properties as $property ) {
				if ( isset( $this->value[ $property ] ) && '' !== $this->value[ $property ] ) {
					$output .= $property . ':' . $this->value[ $property ] . $important . ';';
				}
			}

			$properties = array(
				'font-size',
				'line-height',
				'letter-spacing',
				'word-spacing',
			);

			$unit             = ( ! empty( $this->value['unit'] ) ) ? $this->value['unit'] : 'px';
			$line_height_unit = ( ! empty( $this->value['line_height_unit'] ) ) ? $this->value['line_height_unit'] : $unit;

			foreach ( $properties as $property ) {
				if ( isset( $this->value[ $property ] ) && '' !== $this->value[ $property ] ) {
					$unit    = ( 'line-height' === $property ) ? $line_height_unit : $unit;
					$output .= $property . ':' . $this->value[ $property ] . $unit . $important . ';';
				}
			}

			$custom_style = ( ! empty( $this->value['custom-style'] ) ) ? $this->value['custom-style'] : '';

			if ( $output ) {
				$output = $element . '{' . $output . $custom_style . '}';
			}

			$this->parent->output_css .= $output;

			return $output;

		}

	}
}

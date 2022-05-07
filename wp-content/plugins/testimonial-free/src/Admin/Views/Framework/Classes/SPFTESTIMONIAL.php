<?php
/**
 * Framework setup.class file.
 *
 * @link https://shapedplugin.com
 * @since 2.0.0
 *
 * @package Testimonial_Free
 * @subpackage Testimonial_Free/framework
 */

namespace ShapedPlugin\TestimonialFree\Admin\Views\Framework\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.

	/**
	 *
	 * Setup Class.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
class SPFTESTIMONIAL {

	/**
	 * Premium.
	 *
	 * @var boolean
	 */
	public static $premium = true;
	/**
	 * Version.
	 *
	 * @var string
	 */
	public static $version = '2.2.4';
	/**
	 * Dir.
	 *
	 * @var string
	 */
	public static $dir = '';
	/**
	 * Url.
	 *
	 * @var string
	 */
	public static $url = '';
	/**
	 * CSS.
	 *
	 * @var string
	 */
	public static $css = '';
	/**
	 * File.
	 *
	 * @var string
	 */
	public static $file = '';
	/**
	 * Enqueue.
	 *
	 * @var boolean
	 */
	public static $enqueue = false;
	/**
	 * Webfonts.
	 *
	 * @var array
	 */
	public static $webfonts = array();
	/**
	 * Subsets.
	 *
	 * @var array
	 */
	public static $subsets = array();
	/**
	 * Inited.
	 *
	 * @var array
	 */
	public static $inited = array();
	/**
	 * Fields.
	 *
	 * @var array
	 */
	public static $fields = array();
	/**
	 * Args.
	 *
	 * @var array
	 */
	public static $args = array(
		'admin_options'     => array(),
		'customize_options' => array(),
		'metabox_options'   => array(),
		'nav_menu_options'  => array(),
		'profile_options'   => array(),
		'taxonomy_options'  => array(),
		'widget_options'    => array(),
		'comment_options'   => array(),
		'shortcode_options' => array(),
	);

	/**
	 * Shortcode instances.
	 *
	 * @var array
	 */
	public static $shortcode_instances = array();
	/**
	 * Instance.
	 *
	 * @var string
	 */
	private static $instance = null;

	/**
	 * Init
	 *
	 * @param mixed $file files.
	 * @return statement
	 */
	public static function init( $file = __FILE__ ) {

		// Set file constant.
		self::$file = $file;

		// Set constants.
		self::constants();

		// Include files.
		self::includes();

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	/**
	 * Construct of the class.
	 *
	 * @return void
	 */
	public function __construct() {

		// Init action.
		do_action( 'spftestimonial_init' );

		// Setup textdomain.
		// self::textdomain();

		add_action( 'after_setup_theme', array( $this, 'setup' ) );
		add_action( 'init', array( $this, 'setup' ) );
		add_action( 'switch_theme', array( $this, 'setup' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'add_admin_enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_typography_enqueue_styles' ), 80 );
		add_action( 'wp_head', array( $this, 'add_custom_css' ), 80 );
		add_filter( 'admin_body_class', array( $this, 'add_admin_body_class' ) );

	}

	/**
	 * Setup
	 *
	 * @return void
	 */
	public static function setup() {

		// Configs.
		self::include_plugin_file( 'configs/metaboxs.php' );
		self::include_plugin_file( 'configs/settings.php' );
		self::include_plugin_file( 'configs/tools.php' );
		self::include_plugin_file( 'configs/form.php' );

		// Setup admin option framework.
		$params = array();
		if ( class_exists( 'SPFTESTIMONIAL_Options' ) && ! empty( self::$args['admin_options'] ) ) {
			foreach ( self::$args['admin_options'] as $key => $value ) {
				if ( ! empty( self::$args['sections'][ $key ] ) && ! isset( self::$inited[ $key ] ) ) {

					$params['args']       = $value;
					$params['sections']   = self::$args['sections'][ $key ];
					self::$inited[ $key ] = true;

					\SPFTESTIMONIAL_Options::instance( $key, $params );

					if ( ! empty( $value['show_in_customizer'] ) ) {
						$value['output_css']                     = false;
						$value['enqueue_webfont']                = false;
						self::$args['customize_options'][ $key ] = $value;
						self::$inited[ $key ]                    = null;
					}
				}
			}
		}

		// Setup metabox option framework.
		$params = array();
		if ( class_exists( 'SPFTESTIMONIAL_Metabox' ) && ! empty( self::$args['metabox_options'] ) ) {
			foreach ( self::$args['metabox_options'] as $key => $value ) {
				if ( ! empty( self::$args['sections'][ $key ] ) && ! isset( self::$inited[ $key ] ) ) {

					$params['args']       = $value;
					$params['sections']   = self::$args['sections'][ $key ];
					self::$inited[ $key ] = true;

					\SPFTESTIMONIAL_Metabox::instance( $key, $params );

				}
			}
		}

		// Setup comment option framework.
		$params = array();
		if ( class_exists( 'SPFTESTIMONIAL_Comment_Metabox' ) && ! empty( self::$args['comment_options'] ) ) {
			foreach ( self::$args['comment_options'] as $key => $value ) {
				if ( ! empty( self::$args['sections'][ $key ] ) && ! isset( self::$inited[ $key ] ) ) {

					$params['args']       = $value;
					$params['sections']   = self::$args['sections'][ $key ];
					self::$inited[ $key ] = true;

					\SPFTESTIMONIAL_Comment_Metabox::instance( $key, $params );

				}
			}
		}
		do_action( 'spftestimonial_loaded' );

	}

	// Create options.
	public static function createOptions( $id, $args = array() ) {
		self::$args['admin_options'][ $id ] = $args;
	}

	// Create metabox options.
	public static function createMetabox( $id, $args = array() ) {
		self::$args['metabox_options'][ $id ] = $args;
	}

	// Create comment metabox.
	public static function createCommentMetabox( $id, $args = array() ) {
		self::$args['comment_options'][ $id ] = $args;
	}

	// Create section.
	public static function createSection( $id, $sections ) {
		self::$args['sections'][ $id ][] = $sections;
		self::set_used_fields( $sections );
	}

	/**
	 * Constants
	 *
	 * @return void
	 */
	public static function constants() {

		// We need this path-finder code for set URL of framework.
		$dirname        = str_replace( '//', '/', wp_normalize_path( dirname( dirname( self::$file ) ) ) );
		$theme_dir      = str_replace( '//', '/', wp_normalize_path( get_parent_theme_file_path() ) );
		$plugin_dir     = str_replace( '//', '/', wp_normalize_path( WP_PLUGIN_DIR ) );
		$plugin_dir     = str_replace( '/opt/bitnami', '/bitnami', $plugin_dir );
		$located_plugin = ( preg_match( '#' . self::sanitize_dirname( $plugin_dir ) . '#', self::sanitize_dirname( $dirname ) ) ) ? true : false;
		$directory      = ( $located_plugin ) ? $plugin_dir : $theme_dir;
		$directory_uri  = ( $located_plugin ) ? WP_PLUGIN_URL : get_parent_theme_file_uri();
		$foldername     = str_replace( $directory, '', $dirname );
		$protocol_uri   = ( is_ssl() ) ? 'https' : 'http';
		$directory_uri  = set_url_scheme( $directory_uri, $protocol_uri );

		self::$dir = $dirname;
		self::$url = $directory_uri . $foldername;

	}

	/**
	 * Include plugin files.
	 *
	 * @param  mixed $file file.
	 * @param  mixed $load load.
	 * @return array
	 */
	public static function include_plugin_file( $file, $load = true ) {

		$path     = '';
		$file     = ltrim( $file, '/' );
		$override = apply_filters( 'spftestimonial_override', 'spftestimonial-override' );

		if ( file_exists( get_parent_theme_file_path( $override . '/' . $file ) ) ) {
			$path = get_parent_theme_file_path( $override . '/' . $file );
		} elseif ( file_exists( get_theme_file_path( $override . '/' . $file ) ) ) {
			$path = get_theme_file_path( $override . '/' . $file );
		} elseif ( file_exists( self::$dir . '/' . $override . '/' . $file ) ) {
			$path = self::$dir . '/' . $override . '/' . $file;
		} elseif ( file_exists( self::$dir . '/' . $file ) ) {
			$path = self::$dir . '/' . $file;
		}

		if ( ! empty( $path ) && ! empty( $file ) && $load ) {

			global $wp_query;

			if ( is_object( $wp_query ) && function_exists( 'load_template' ) ) {

				load_template( $path, true );

			} else {

				require_once $path;

			}
		} else {

			return self::$dir . '/' . $file;

		}

	}

	/**
	 * Is active plugin
	 *
	 * @param  mixed $file file.
	 * @return statement
	 */
	public static function is_active_plugin( $file = '' ) {
		return in_array( $file, (array) get_option( 'active_plugins', array() ) );
	}

	/**
	 * Sanitize dirname.
	 *
	 * @param  mixed $dirname dirname.
	 * @return statement
	 */
	public static function sanitize_dirname( $dirname ) {
		return preg_replace( '/[^A-Za-z]/', '', $dirname );
	}

	/**
	 * Set plugin url.
	 *
	 * @param  mixed $file file.
	 * @return string
	 */
	public static function include_plugin_url( $file ) {
		return esc_url( SP_TFREE_URL . 'Admin/Views/Framework' ) . '/' . ltrim( $file, '/' );
	}

	/**
	 * General includes.
	 *
	 * @return void
	 */
	public static function includes() {

		// Helpers.
		self::include_plugin_file( 'functions/actions.php' );
		self::include_plugin_file( 'functions/helpers.php' );
		self::include_plugin_file( 'functions/sanitize.php' );
		self::include_plugin_file( 'functions/validate.php' );

		// Includes free version classes.
		self::include_plugin_file( 'Classes/abstract.class.php' );
		self::include_plugin_file( 'Classes/fields.class.php' );
		self::include_plugin_file( 'Classes/options.class.php' );
		self::include_plugin_file( 'Classes/metabox.class.php' );

		// Include all framework fields.
		$fields = apply_filters(
			'spftestimonial_fields',
			array(
				'accordion',
				'border',
				'button_set',
				'checkbox',
				'code_editor',
				'color',
				'color_group',
				'column',
				'content',
				'custom_import',
				'custom_size',
				'fieldset',
				'form_upper_section',
				'heading',
				'icon_select',
				'image_select',
				'image_sizes',
				'notice',
				'preview',
				'radio',
				'rating',
				'repeater',
				'select',
				'select_f',
				'sortable',
				'sorter',
				'spacing',
				'spinner',
				'subheading',
				'submessage',
				'shortcode',
				'switcher',
				'text',
				'typography',
			)
		);

		if ( ! empty( $fields ) ) {
			foreach ( $fields as $field ) {
				if ( ! class_exists( 'SPFTESTIMONIAL_Field_' . $field ) && class_exists( 'SPFTESTIMONIAL_Fields' ) ) {
					self::include_plugin_file( 'fields/' . $field . '/' . $field . '.php' );
				}
			}
		}

	}

	/**
	 * Textdomain
	 *
	 * @return void
	 */
	// public static function textdomain() {
	// load_textdomain( 'spftestimonial', self::$dir . '/languages/' . get_locale() . '.mo' );
	// }

	/**
	 * Get all of fields.
	 *
	 * @param  mixed $sections sections.
	 * @return void
	 */
	public static function set_used_fields( $sections ) {

		if ( ! empty( $sections['fields'] ) ) {

			foreach ( $sections['fields'] as $field ) {

				if ( ! empty( $field['fields'] ) ) {
					self::set_used_fields( $field );
				}

				if ( ! empty( $field['tabs'] ) ) {
					self::set_used_fields( array( 'fields' => $field['tabs'] ) );
				}

				if ( ! empty( $field['accordions'] ) ) {
					self::set_used_fields( array( 'fields' => $field['accordions'] ) );
				}

				if ( ! empty( $field['type'] ) ) {
					self::$fields[ $field['type'] ] = $field;
				}
			}
		}

	}

	/**
	 * Enqueue admin and fields styles and scripts.
	 *
	 * @return void
	 */
	public static function add_admin_enqueue_scripts() {

		// Loads scripts and styles only when needed.
		$wpscreen = get_current_screen();
		if ( 'spt_testimonial_form' === $wpscreen->post_type || 'spt_shortcodes' === $wpscreen->post_type || 'spt_testimonial' === $wpscreen->post_type ) {
			if ( ! empty( self::$args['admin_options'] ) ) {
				foreach ( self::$args['admin_options'] as $argument ) {
					if ( substr( $wpscreen->id, -strlen( $argument['menu_slug'] ) ) === $argument['menu_slug'] ) {
						self::$enqueue = true;
					}
				}
			}

			if ( ! empty( self::$args['metabox_options'] ) ) {
				foreach ( self::$args['metabox_options'] as $argument ) {
					if ( in_array( $wpscreen->post_type, (array) $argument['post_type'] ) ) {
						self::$enqueue = true;
					}
				}
			}

			if ( ! apply_filters( 'spftestimonial_enqueue_assets', self::$enqueue ) ) {
				return;
			}
			// Check for developer mode.
			$min = ( self::$premium && SCRIPT_DEBUG ) ? '' : '.min';

			// Admin utilities.
			wp_enqueue_media();

			// Wp color picker.
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );

			// Font awesome 4 and 5 loader.
			if ( apply_filters( 'spftestimonial_fa4', true ) ) {
				wp_enqueue_style( 'spftestimonial-fa', 'https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome' . $min . '.css', array(), '4.7.0', 'all' );
			} else {
				wp_enqueue_style( 'spftestimonial-fa5', 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all' . $min . '.css', array(), '5.15.5', 'all' );
				wp_enqueue_style( 'spftestimonial-fa5-v4-shims', 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/v4-shims' . $min . '.css', array(), '5.15.5', 'all' );
			}

			// Main style.
			wp_enqueue_style( 'spftestimonial', self::include_plugin_url( 'assets/css/spftestimonial.css' ), array(), self::$version, 'all' );

			// Main RTL styles.
			if ( is_rtl() ) {
				wp_enqueue_style( 'spftestimonial-rtl', self::include_plugin_url( 'assets/css/spftestimonial-rtl' . $min . '.css' ), array(), self::$version, 'all' );
			}
			// Main scripts.
			wp_enqueue_script( 'spftestimonial-plugins', self::include_plugin_url( 'assets/js/spftestimonial-plugins' . $min . '.js' ), array(), self::$version, true );
			wp_enqueue_script( 'spftestimonial', self::include_plugin_url( 'assets/js/spftestimonial' . $min . '.js' ), array( 'spftestimonial-plugins' ), self::$version, true );

			// Main variables.
			wp_localize_script(
				'spftestimonial',
				'spftestimonial_vars',
				array(
					'color_palette' => apply_filters( 'spftestimonial_color_palette', array() ),
					'previewJS'     => esc_url( SP_TFREE_URL . 'Frontend/assets/js/sp-slick-active' . $min . '.js' ),
					'i18n'          => array(
						'confirm'         => esc_html__( 'Are you sure?', 'testimonial-free' ),
						'typing_text'     => esc_html__( 'Please enter %s or more characters', 'testimonial-free' ),
						'searching_text'  => esc_html__( 'Searching...', 'testimonial-free' ),
						'no_results_text' => esc_html__( 'No results found.', 'testimonial-free' ),
					),
				)
			);

			// Enqueue fields scripts and styles.
			$enqueued = array();

			if ( ! empty( self::$fields ) ) {
				foreach ( self::$fields as $field ) {
					if ( ! empty( $field['type'] ) ) {
						$classname = 'SPFTESTIMONIAL_Field_' . $field['type'];
						if ( class_exists( $classname ) && method_exists( $classname, 'enqueue' ) ) {
							$instance = new $classname( $field );
							if ( method_exists( $classname, 'enqueue' ) ) {
								$instance->enqueue();
							}
							unset( $instance );
						}
					}
				}
			}
		}
		do_action( 'spftestimonial_enqueue' );

	}

	/**
	 * Typography Enqueue admin and fields styles and scripts.
	 *
	 * @return void
	 */
	public static function add_typography_enqueue_styles() {

		if ( ! empty( self::$webfonts ) ) {

			if ( ! empty( self::$webfonts['enqueue'] ) ) {

				$query = array();
				$fonts = array();

				foreach ( self::$webfonts['enqueue'] as $family => $styles ) {
					$fonts[] = $family . ( ( ! empty( $styles ) ) ? ':' . implode( ',', $styles ) : '' );
				}

				if ( ! empty( $fonts ) ) {
					$query['family'] = implode( '%7C', $fonts );
				}

				if ( ! empty( self::$subsets ) ) {
					$query['subset'] = implode( ',', self::$subsets );
				}

				$query['display'] = 'swap';

				wp_enqueue_style( 'spftestimonial-google-web-fonts', esc_url( add_query_arg( $query, '//fonts.googleapis.com/css' ) ), array(), null );

			}

			if ( ! empty( self::$webfonts['async'] ) ) {

				$fonts = array();

				foreach ( self::$webfonts['async'] as $family => $styles ) {
					$fonts[] = $family . ( ( ! empty( $styles ) ) ? ':' . implode( ',', $styles ) : '' );
				}

				wp_enqueue_script( 'spftestimonial-google-web-fonts', esc_url( '//ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js' ), array(), null );

				wp_localize_script( 'spftestimonial-google-web-fonts', 'WebFontConfig', array( 'google' => array( 'families' => $fonts ) ) );

			}
		}

	}

	/**
	 * Admin body class
	 *
	 * @param string $classes admin body class.
	 * @return statement.
	 */
	public static function add_admin_body_class( $classes ) {

		if ( apply_filters( 'spftestimonial_fa4', false ) ) {
			$classes .= 'spftestimonial-fa5-shims';
		}

		return $classes;

	}

	/**
	 * Custom Css
	 *
	 * @return void
	 */
	public static function add_custom_css() {

		if ( ! empty( self::$css ) ) {
			echo '<style type="text/css">' . wp_strip_all_tags( self::$css ) . '</style>';
		}

	}

	/**
	 * Add a new framework field.
	 *
	 * @param  mixed $field Field.
	 * @param  mixed $value value.
	 * @param  mixed $unique unique id.
	 * @param  mixed $where Where.
	 * @param  mixed $parent parent.
	 * @return void
	 */
	public static function field( $field = array(), $value = '', $unique = '', $where = '', $parent = '' ) {

		// Check for unallow fields.
		if ( ! empty( $field['_notice'] ) ) {

			$field_type = $field['type'];

			$field            = array();
			$field['content'] = esc_html__( 'Oops! Not allowed.', 'testimonial-free' ) . ' <strong>(' . $field_type . ')</strong>';
			$field['type']    = 'notice';
			$field['style']   = 'danger';

		}

		$depend     = '';
		$visible    = '';
		$unique     = ( ! empty( $unique ) ) ? $unique : '';
		$class      = ( ! empty( $field['class'] ) ) ? ' ' . esc_attr( $field['class'] ) : '';
		$is_pseudo  = ( ! empty( $field['pseudo'] ) ) ? ' spftestimonial-pseudo-field' : '';
		$field_type = ( ! empty( $field['type'] ) ) ? esc_attr( $field['type'] ) : '';

		if ( ! empty( $field['dependency'] ) ) {

			$dependency      = $field['dependency'];
			$depend_visible  = '';
			$data_controller = '';
			$data_condition  = '';
			$data_value      = '';
			$data_global     = '';

			if ( is_array( $dependency[0] ) ) {
				$data_controller = implode( '|', array_column( $dependency, 0 ) );
				$data_condition  = implode( '|', array_column( $dependency, 1 ) );
				$data_value      = implode( '|', array_column( $dependency, 2 ) );
				$data_global     = implode( '|', array_column( $dependency, 3 ) );
				$depend_visible  = implode( '|', array_column( $dependency, 4 ) );
			} else {
				$data_controller = ( ! empty( $dependency[0] ) ) ? $dependency[0] : '';
				$data_condition  = ( ! empty( $dependency[1] ) ) ? $dependency[1] : '';
				$data_value      = ( ! empty( $dependency[2] ) ) ? $dependency[2] : '';
				$data_global     = ( ! empty( $dependency[3] ) ) ? $dependency[3] : '';
				$depend_visible  = ( ! empty( $dependency[4] ) ) ? $dependency[4] : '';
			}

			$depend .= ' data-controller="' . esc_attr( $data_controller ) . '"';
			$depend .= ' data-condition="' . esc_attr( $data_condition ) . '"';
			$depend .= ' data-value="' . esc_attr( $data_value ) . '"';
			$depend .= ( ! empty( $data_global ) ) ? ' data-depend-global="true"' : '';

			$visible = ( ! empty( $depend_visible ) ) ? ' spftestimonial-depend-visible' : ' spftestimonial-depend-hidden';

		}

		// These attributes has been sanitized above.
		echo '<div class="spftestimonial-field spftestimonial-field-' . esc_attr( $field_type . $is_pseudo . $class . $visible ) . '"' . wp_kses_post( $depend ) . '>';

		if ( ! empty( $field_type ) ) {

			if ( ! empty( $field['fancy_title'] ) ) {
				echo '<div class="spftestimonial-fancy-title">' . wp_kses_post( $field['fancy_title'] ) . '</div>';
			}

			if ( ! empty( $field['title'] ) ) {
				echo '<div class="spftestimonial-title">';
				echo '<h4>' . wp_kses_post( $field['title'] ) . '</h4>';
				echo ( ! empty( $field['subtitle'] ) ) ? '<div class="spftestimonial-subtitle-text">' . wp_kses_post( $field['subtitle'] ) . '</div>' : '';
				echo '</div>';
			}

			echo ( ! empty( $field['title'] ) || ! empty( $field['fancy_title'] ) ) ? '<div class="spftestimonial-fieldset">' : '';

			$value = ( ! isset( $value ) && isset( $field['default'] ) ) ? $field['default'] : $value;
			$value = ( isset( $field['value'] ) ) ? $field['value'] : $value;

			$classname = 'SPFTESTIMONIAL_Field_' . $field_type;

			if ( class_exists( $classname ) ) {
				$instance = new $classname( $field, $value, $unique, $where, $parent );
				$instance->render();
			} else {
				echo '<p>' . esc_html__( 'Field not found!', 'testimonial-free' ) . '</p>';
			}
		} else {
			echo '<p>' . esc_html__( 'Field not found!', 'testimonial-free' ) . '</p>';
		}

		echo ( ! empty( $field['title'] ) || ! empty( $field['fancy_title'] ) ) ? '</div>' : '';
		echo '<div class="clear"></div>';
		echo '</div>';

	}

}

SPFTESTIMONIAL::init( __FILE__ );

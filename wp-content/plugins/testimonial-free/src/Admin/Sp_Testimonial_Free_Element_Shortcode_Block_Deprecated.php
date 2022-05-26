<?php
/**
 * Framework options.class file.
 *
 * @link https://shapedplugin.com
 * @since 2.0.0
 *
 * @package Testimonial_free
 * @subpackage Testimonial_free/Admin
 */

namespace ShapedPlugin\TestimonialFree\Admin;

/**
 * Elementor shortcode block.
 */
class Sp_Testimonial_Free_Element_Shortcode_Block_Deprecated {
	/**
	 * Instance
	 *
	 * @since 2.5.2
	 *
	 * @access private
	 * @static
	 *
	 * @var Sp_Testimonial_Free_Element_Shortcode_Block_Deprecated The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 2.5.2
	 *
	 * @access public
	 * @static
	 *
	 * @return Elementor_Test_Extension An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * @since 2.5.2
	 *
	 * @access public
	 */
	public function __construct() {
		$this->on_plugins_loaded();
		add_action( 'wp_enqueue_scripts', array( $this, 'sprtp_block_enqueue_scripts' ) );
		add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'sprtp_element_block_icon' ) );
	}

	/**
	 * Elementor block icon.
	 *
	 * @since    2.5.2
	 * @return void
	 */
	public function sprtp_element_block_icon() {
		wp_enqueue_style( 'sprtp_element_block_icon', SP_TFREE_URL . 'Admin/assets/css/fontello.min.css', array(), SP_TFREE_VERSION, 'all' );
	}

	/**
	 * Register the JavaScript for the elementor block area.
	 *
	 * @since    2.5.2
	 */
	public function sprtp_block_enqueue_scripts() {

		// JS Files.
		wp_enqueue_script( 'tfree-slick-min-js', SP_TFREE_URL . 'Frontend/assets/js/slick.min.js', array( 'jquery' ), SP_TFREE_VERSION, true );
		wp_enqueue_script( 'tfree-slick-active', SP_TFREE_URL . 'Frontend/assets/js/sp-slick-active.min.js', array( 'jquery' ), SP_TFREE_VERSION, true );
	}

	/**
	 * On Plugins Loaded
	 *
	 * Checks if Elementor has loaded, and performs some compatibility checks.
	 * If All checks pass, inits the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 2.5.2
	 *
	 * @access public
	 */
	public function on_plugins_loaded() {
		add_action( 'elementor/init', array( $this, 'init' ) );
	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 2.5.2
	 *
	 * @access public
	 */
	public function init() {
		// Add Plugin actions.
		add_action( 'elementor/widgets/register', array( $this, 'init_widgets' ) );
	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 2.5.2
	 *
	 * @access public
	 */
	public function init_widgets() {
		// Register widget.
		\Elementor\Plugin::instance()->widgets_manager->register( new ElementAddons_Deprecated\Sp_Testimonial_Free_Shortcode_Widget_Deprecated() );

	}

}

Sp_Testimonial_Free_Element_Shortcode_Block_Deprecated::instance();

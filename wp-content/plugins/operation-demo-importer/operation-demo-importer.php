<?php
/**
 * Wpop Demo Importer
 *
 * @package     WpopDemoImporter
 * @author      WPoperation
 * @copyright   2017 WPoperation
 * @license     GPL-2.0+
 *
 * Plugin Name: Operation Demo Importer
 * Description: Demo Importer For WPoperation Themes
 * Version:     1.1.8
 * Author:      WPoperation
 * Author URI:  https://wpoperation.com
 * Text Domain: wpop-demo-importer
 * Domain Path: /languages/
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Requires at least:	4.5.0
 * Tested up to:		5.8.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the main instance of WOPDI to prevent the need to use globals.
 *
 * @since  1.0.8
 * @return object WOPDI
 */
function WOPDI() {
	return WOPDI::instance();
} // End WOPDI()

WOPDI();

/**
 * Main WOPDI Class
 *
 * @class WOPDI
 * @version	1.0.8
 * @since 1.0.8
 * @package	WOPDI
 */
final class WOPDI {
	/**
	 * WOPDI The single instance of WOPDI.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.8
	 */
	private static $_instance = null;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.8
	 */
	public $token;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.8
	 */
	public $version;

	// Admin - Start
	/**
	 * The admin object.
	 * @var     object
	 * @access  public
	 * @since   1.0.8
	 */
	public $admin;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.8
	 * @return  void
	 */
	public function __construct( $widget_areas = array() ) {
        $this->token 			= 'operation-demo-importer';
		$this->plugin_url 		= plugin_dir_url( __FILE__ );
		$this->plugin_path 		= plugin_dir_path( __FILE__ );
		$this->version 			= '1.1.8';

		define( 'WOPDI_URL', $this->plugin_url );
		define( 'WOPDI_PATH', $this->plugin_path );
		define( 'WOPDI_VERSION', $this->version );
        define( 'WOPDI_FILE_PATH', __FILE__ );
		define( 'WOPDI_ADMIN_PANEL_HOOK_PREFIX', 'theme-panel_page_wopdi-panel' );


		register_activation_hook( __FILE__, array( $this, 'install' ) );

		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

        $mythemes = array('arrival','opstore','wpparallax','ultra-seven','opstore-pro','ultra-eleven');
		$active_theme = wp_get_theme();
		if ( in_array($active_theme->template,$mythemes) ) {

			/**
			 * Load Importer files
			 */
			require_once WOPDI_PATH . '/classes/class-install-demos.php';
			require_once WOPDI_PATH . '/includes/demos.php';
		}
	}

	/**
	 * Main WPODI Instance
	 *
	 * Ensures only one instance of WPODI is loaded or can be loaded.
	 *
	 * @since 1.0.8
	 * @static
	 * @see WPODI()
	 * @return Main WPODI instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) )
			self::$_instance = new self();
		return self::$_instance;
	} // End instance()

	/**
	 * Load the localisation file.
	 * @access  public
	 * @since   1.0.8
	 * @return  void
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'wpop-demo-importer', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.8
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.8
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	}

	/**
	 * Installation.
	 * Runs on activation. Logs the version number and assigns a notice message to a WordPress option.
	 * @access  public
	 * @since   1.0.8
	 * @return  void
	 */
	public function install() {
		$this->_log_version_number();
	}

	/**
	 * Log the plugin version number.
	 * @access  private
	 * @since   1.0.8
	 * @return  void
	 */
	private function _log_version_number() {
		// Log the version number.
		update_option( $this->token . '-version', $this->version );
	}

}// End Class	





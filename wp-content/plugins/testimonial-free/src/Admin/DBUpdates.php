<?php
/**
 * Fired during plugin updates.
 *
 * This class defines all code necessary to run during the plugin's updates.
 *
 * @since      2.1.5
 *
 * @package Testimonial_free.
 * @subpackage Testimonial_free/Admin
 * @author     ShapedPlugin <support@shapedplugin.com>
 */

namespace ShapedPlugin\TestimonialFree\Admin;

// don't call the file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * DBUpdates
 */
class DBUpdates {

	/**
	 * DB updates that need to be run
	 *
	 * @var array
	 */
	private static $updates = array(
		'2.1.5'  => 'updates/update-2.1.5.php',
		'2.2.5'  => 'updates/update-2.2.5.php',
		'2.2.10' => 'updates/update-2.2.10.php',
		'2.5.5'  => 'updates/update-2.5.5.php',
	);

	/**
	 * Binding all events
	 *
	 * @since 2.1.5
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'do_updates' ) );
	}

	/**
	 * Check if need any update
	 *
	 * @since 2.1.5
	 *
	 * @return boolean
	 */
	public function is_needs_update() {
		$installed_version = get_option( 'testimonial_version' );
		$first_version     = get_option( 'testimonial_first_version' );
		$activation_date   = get_option( 'testimonial_activation_date' );

		if ( false === $installed_version ) {
			update_option( 'testimonial_version', SP_TFREE_VERSION );
			update_option( 'testimonial_db_version', SP_TFREE_VERSION );
		}
		if ( false === $first_version ) {
			update_option( 'testimonial_first_version', SP_TFREE_VERSION );
		}
		if ( false === $activation_date ) {
			update_option( 'testimonial_activation_date', current_time( 'timestamp' ) );
		}

		if ( version_compare( $installed_version, SP_TFREE_VERSION, '<' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Do updates.
	 *
	 * @since 2.1.5
	 *
	 * @return void
	 */
	public function do_updates() {
		$this->perform_updates();
	}

	/**
	 * Perform all updates
	 *
	 * @since 2.1.5
	 *
	 * @return void
	 */
	public function perform_updates() {
		if ( ! $this->is_needs_update() ) {
			return;
		}

		$installed_version = get_option( 'testimonial_version' );

		foreach ( self::$updates as $version => $path ) {
			if ( version_compare( $installed_version, $version, '<' ) ) {
				include $path;
				update_option( 'testimonial_version', $version );
			}
		}

		update_option( 'testimonial_version', SP_TFREE_VERSION );

	}

}

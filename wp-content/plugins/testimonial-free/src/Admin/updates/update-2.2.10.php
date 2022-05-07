<?php
/**
 * Update version.
 */
update_option( 'testimonial_version', '2.2.10' );
update_option( 'testimonial_db_version', '2.2.10' );

/**
 * Change the post type sp_tfree_shortcodes to spt_shortcodes.
 */
function sp_change_shortcodes_post_type() {
	global $wpdb;
	$old_post_types = array( 'sp_tfree_shortcodes' => 'spt_shortcodes' );
	foreach ( $old_post_types as $old_type => $type ) {
		$wpdb->query(
			$wpdb->prepare(
				"UPDATE {$wpdb->posts} SET post_type = REPLACE(post_type, %s, %s) 
							WHERE post_type LIKE %s",
				$old_type,
				$type,
				$old_type
			)
		);
		$wpdb->query(
			$wpdb->prepare(
				"UPDATE {$wpdb->posts} SET guid = REPLACE(guid, %s, %s) 
							WHERE guid LIKE %s",
				"post_type={$old_type}",
				"post_type={$type}",
				"%post_type={$type}%"
			)
		);
		$wpdb->query(
			$wpdb->prepare(
				"UPDATE {$wpdb->posts} SET guid = REPLACE(guid, %s, %s) 
							WHERE guid LIKE %s",
				"/{$old_type}/",
				"/{$type}/",
				"%/{$old_type}/%"
			)
		);
	}
}
sp_change_shortcodes_post_type();

/**
 * Update settings page old to new.
 */
$old_settings = get_option( '_sp_testimonial_options' );
update_option( 'sp_testimonial_pro_options', $old_settings );
delete_option( '_sp_testimonial_options' );

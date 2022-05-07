<?php
/**
 * Class for the settings importer.
 */

class WPOP_Settings_Importer {

	/**
	 * Process import file - this parses the settings data and returns it.
	 *
	 * @param string $file path to json file.
	 */
	public function process_import_file( $file ) {

		// Get file contents.
		$data = WPOP_Demos_Helpers::get_remote( $file );

		// Return from this function if there was an error.
		if ( is_wp_error( $data ) ) {
			return $data;
		}
		
		$url = $file;
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        $contents = curl_exec($ch);
        if (curl_errno($ch)) {
          echo curl_error($ch);
          echo "\n<br />";
          $contents = '';
        } else {
          curl_close($ch);
        }
        
        if (!is_string($contents) || !strlen($contents)) {
            echo "Failed to get contents.";
            $contents = '';
        }

		// Get file contents and decode
		$raw  = file_get_contents( $file );
		$data = @unserialize( $raw );

		// Delete import file
		unlink( $file );

		// If wp_css is set then import it.
		if ( function_exists( 'wp_update_custom_css_post' ) && isset( $data['wp_css'] ) && '' !== $data['wp_css'] ) {
			wp_update_custom_css_post( $data['wp_css'] );
		}

		// Import the data
    	return $this->import_data( $data['mods'] );

	}

	/**
	 * Sanitization callback
	 *
	 * @since 1.0.5
	 */
	private function import_data( $file ) {

		// Import the file
		if ( ! empty( $file ) ) {

			if ( '0' == json_last_error() ) {

				// Loop through mods and add them
				foreach ( $file as $mod => $value ) {
					set_theme_mod( $mod, $value );
				}

			}

		}

		// Return file
		return $file;

	}
}

/**
 * A class that extends WP_Customize_Setting so we can access
 * the protected updated method when importing options.
 *
 * Used in the Customizer importer.
 *
 * @since 1.0.0
 * @package ocdi
 */
require_once ABSPATH . 'wp-includes/class-wp-customize-setting.php';
final class CEI_Option extends \WP_Customize_Setting {

	/**
	 * Import an option value for this setting.
	 *
	 * @since 1.0.0
	 * @param mixed $value The option value.
	 * @return void
	 */
	public function import( $value ) 
	{
		$this->update( $value );	
	}
}

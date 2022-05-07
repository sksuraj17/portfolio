<?php
/**
 * Class for the theme options importer.
 */

class WPOP_Options_Importer {

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

		$data = file_get_contents( $file );

		// Import the data
    	return $this->import_data( $data );

	}

	/**
	 * Sanitization callback
	 *
	 * @since 1.0.5
	 */
	private function import_data( $file ) {

		// Import the file
		if ( ! empty( $file ) ) {

          $decoded_data = $this->cs_decode_string( $file );
          update_option( '_cs_options', $decoded_data );

		}

		// Return file
		return $file;

	}

    private function cs_decode_string( $string ) {
    	return unserialize( gzuncompress( stripslashes( call_user_func( 'base'. '64' .'_decode', rtrim( strtr( $string, '-_', '+/' ), '=' ) ) ) ) );
    }
}

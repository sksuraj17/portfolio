<?php
/**
 * Class for the smart slider importer.
 *
 * Thank you very much to SiteGround for the code.
 */

class WPOP_SmartSlider_Importer {

	/**
	 * Process import file - this parses the widget data and returns it.
	 *
	 * @param string $file path to json file.
	 * @global string $widget_import_results
	 */
	public function process_import_file( $file ) {

		$response = WPOP_Demos_Helpers::get_remote( $file );


		// No sample data found
		if ( $response === false ) {
			return new WP_Error( 'xml_import_error', __( 'Can not retrieve sample data xml file. The server may be down at the moment please try again later. If you still have issues contact the theme developer for assistance.', 'wpop-demo-importer' ) );
		}

		// Write slider to temp file
		$temp_slider = WOPDI_PATH .'/classes/importers/slider.ss3';
		file_put_contents( $temp_slider, $response );

		// Set temp xml to attachment url for use
		$data = $temp_slider;

    	return $this->import_slider( $data );

	}

	public function import_slider( $file ) {

      

        
        if( class_exists('SmartSlider3') ){
          SmartSlider3::import($file);
        }

    }
}
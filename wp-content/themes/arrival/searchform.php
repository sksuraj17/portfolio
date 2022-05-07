<?php 	
/**
 * Template for displaying theme search
 *
 *
 *
 * @package Arrival
 * @copyright Copyright (C) 2018 WPoperation
 * @license  http://www.gnu.org/licenses/gpl-2.0.html
 * @author WPoperation <https://wpoperation.com/>
 */

 ?>

<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php esc_html_e('Search for:','arrival')?></span>
		<input type="search" autocomplete="off" class="search-field" placeholder="<?php esc_attr_e( 'Type and hit enter ...', 'arrival' ); ?>" value="" name="s">
	</label>
	<input type="submit" class="search-submit" value="<?php esc_attr_e( 'Search', 'arrival' ); ?>">

</form>


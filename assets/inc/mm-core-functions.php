<?php 
/*
*
*	***** Map Marker *****
*
*	Core Functions
*	
*/
// If this file is called directly, abort. //
if ( ! defined( 'WPINC' ) ) {die;} // end if
/*
*
* Custom Front End Ajax Scripts / Loads In WP Footer
*
*/
/**
 * Mapbox API
 *
 * Copy this to your theme's functions.php preferably at the end
 *
 * @param $api
 *
 * @return mixed
 */
function acf_mapbox_api( $api ) {
	$api['key'] = 'pk.eyJ1IjoiZGFhdC1tYXBib3giLCJhIjoiY2thMjhhOWpwMDA2cTNtbnZxYWV4ZGI3ZSJ9.l1475leuD9RxbBcqXJR6gQ'; // Please obtain an access token from your Mapbox account and replace the dummy value

	return $api;
}

add_filter( 'acf/fields/mapbox/api', 'acf_mapbox_api' );
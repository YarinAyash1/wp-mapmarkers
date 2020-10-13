<?php 
/*
Plugin Name: Map Markers
Plugin URI: https://yarinayyash.co.il
Description: Map Markers - No Description
Version: 1.0.0
Author: Yarin Ayash
Author URI: https://yarinayyash.co.il
Text Domain: mm
*/

// If this file is called directly, abort. //
if ( ! defined( 'WPINC' ) ) {die;} // end if

// Let's Initialize Everything
if ( file_exists( plugin_dir_path( __FILE__ ) . 'core-init.php' ) ) {
    require_once( plugin_dir_path( __FILE__ ) . 'core-init.php' );
}
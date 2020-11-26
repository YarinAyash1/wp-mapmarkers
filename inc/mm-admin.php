<?php 
/*
*	Admin Menu Functions
*/
// If this file is called directly, abort. //
if ( ! defined( 'WPINC' ) ) {die;} // end if
if(!function_exists('MapMarkers_AdminMenu')){

    class MapMarkers_AdminMenu{
        public function __construct(  ) {
            add_action( 'admin_menu', array( $this, 'mapmarkers_add_pages' ) );
            add_action( 'admin_init', array( $this, 'mapmarkers_form_init' ) );
            add_filter( 'acf/fields/mapbox/api', array( $this,'acf_mapbox_api' ) );

        }
        public function acf_mapbox_api( $api ) {
            $option = get_option( 'mapmarkers_form_data' );
            $api['key'] = $option['mapbox_api_key'];
            return $api;
        }
        
        
        public function mapmarkers_add_pages() {

            //Add Settings Page
            add_options_page(
                'Map Markers: Settings', //Page Title
                __( 'Map Markers: Settings', 'mm' ), //Menu Title
                'manage_options', //capability
                'mapmarkers_settings_page', //menu slug
                array( $this, 'mapmarkers_settings_page_content') //The function to be called to output the content for this page.
            );
        
        }


        public function mapmarkers_form_init() {
            register_setting(
                'mapmarkers_form',
                'mapmarkers_form_data',
            );
        
            add_settings_section( 'mapmarkers_section_id', 'Settings', array( $this, 'mapmarkers_section_callback' ), 'mapmarkers_settings_page' );
            add_settings_field( 'mapmarkers_field_name_id', 'Mapbox API Key', array( $this, 'mapmarkers_name_callback' ), 'mapmarkers_settings_page', 'mapmarkers_section_id' );
        }
        
        public function mapmarkers_section_callback() {
            //echo '';
        }
        
        public function mapmarkers_name_callback() {
            $option = get_option( 'mapmarkers_form_data' );
            echo "<input style='width:550px' type='text' name='mapmarkers_form_data[mapbox_api_key]' value='".$option['mapbox_api_key']."' />";
        }
        
        /* Settings Page Content */
        public function mapmarkers_settings_page_content() {
            if ( ! current_user_can( 'manage_options' ) ) {
                wp_die( __( 'You do not have sufficient permissions to access this page.', 'mm' ) );
            }
            ?>
            <div class="wrap">
                <h2>Map Markers: Settings </h2>
        
                <form action="options.php" method="post">
                    <?php
                    settings_fields( 'mapmarkers_form' );
                    do_settings_sections( 'mapmarkers_settings_page' );
                    submit_button( );
                    ?>
                </form>
            </div>
        
        <?php
        }
    }
    new MapMarkers_AdminMenu();
}

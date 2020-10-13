<?php


if (! defined('WPINC')) {
    die;
} // end if

// check if class already exists
if (! class_exists('MapMarkers')) {
    class MapMarkers
    {
        // vars
        public $settings;

        /**
         *  __construct
         *
         *  This function will setup the class functionality
         *
         * @type    function
         * @since    1.0.0
         *
         * @param    void
         *
         * @return    void
         */
        public function __construct()
        {
            // settings
            // - these will be passed into the field class.
            $this->settings = array(
                'version' => '1.0.0',
                'url'     => plugin_dir_url(__FILE__),
                'path'    => plugin_dir_path(__FILE__),
                'inc'     => dirname(__FILE__).'/assets/inc/',
                'imgs'    => plugins_url('assets/img/', __FILE__),
                'css'     => plugins_url('assets/css/', __FILE__),
                'js'      => plugins_url('assets/js/', __FILE__),
                'app'     => dirname(__FILE__).'/app/map-markers/dist/',
            );

            // include field depending on ACF version
            add_action('acf/include_field_types', array( $this, 'include_field' ));
            add_action('acf/register_fields', array( $this, 'include_field' ));
            add_action('plugin_loaded', array( $this, 'load_functions' ));
            add_action('wp_enqueue_scripts', array( $this, 'register_scripts_styles' ));
            add_action('template_include', array( $this, 'include_app' ));

        }

        /**
         *  include_field
         *
         *  This function will include the field type class
         *
         * @type    function
         *
         * @param int $version
         *
         * @since    1.0.0
         *
         * @return    void
         */
        public function include_field($version)
        {
            if (! $version) {
                $version = 4;
            }

            // include file depending on version number
            require_once($this->settings['inc'] . 'mm-acf-field-mapbox.php');
        }
        public function load_functions()
        {
            require_once($this->settings['inc'] . 'mm-rest-api.php');
            require_once($this->settings['inc'] . 'mm-core-functions.php');
            require_once($this->settings['inc'] . 'mm-cpt.php');
            require_once($this->settings['inc'] . 'mm-acf-fields.php');
            
        }

        public function include_app($original_template) {
            // Check Theme Template or Plugin Template for archive-links.php
            $file = trailingslashit(get_template_directory()) . 'archive-markers.php';
    
            if(is_post_type_archive('markers')) {
            // some additional logic goes here^.
    
                    return $this->settings['app'] . 'index.html';
            }
            else if(is_singular('markers')) {
                if(file_exists(get_template_directory_uri() . '/single-marker.php')) {
                    return get_template_directory_uri() . '/single-marker.php';
                } else {
                    return $this->settings['app'] . 'single-marker.php';
                }
            }
            
            return $original_template;
        }
        
        public function register_scripts_styles(){
            wp_enqueue_style('mm-core', $this->settings['css'] . 'mm-core.css', null, time('s'), 'all');
            wp_enqueue_script('mm-core', $this->settings['js'] . 'mm-core.js', 'jquery', time(), true);
            wp_localize_script('mm-core', 'ajax_object', array( 'ajaxurl' => admin_url('admin-ajax.php') ));
        }
    }

    // initialize
    new MapMarkers();
}

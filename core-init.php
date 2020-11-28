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
         * @since    1.0.1
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
                'version' => '1.0.1',
                'url'     => plugin_dir_url(__FILE__),
                'path'    => plugin_dir_path(__FILE__),
                'inc'     => dirname(__FILE__).'/inc/',
                'imgs'    => plugins_url('assets/img/', __FILE__),
                'css'     => plugins_url('assets/css/', __FILE__),
                'js'      => plugins_url('assets/js/', __FILE__),

            );

            // include field depending on ACF version
            add_action('acf/include_field_types', array( $this, 'include_field' ));
            add_action('acf/register_fields', array( $this, 'include_field' ));
            add_action('plugin_loaded', array( $this, 'load_functions' ));
            add_action('wp_enqueue_scripts', array( $this, 'register_scripts_styles' ));
            add_action('template_include', array( $this, 'include_app' ));
            add_shortcode('mapmarkers', array( $this, 'app_init'));
        }


        public function vue_template_components(){

            include( $this->settings['inc'] . 'vue-components/map.template.php');
            include( $this->settings['inc'] . 'vue-components/badge.template.php');

        }

        public function app_init(){
            wp_enqueue_style('mm-app');
            wp_enqueue_style('mm-mapbox-css');
            wp_enqueue_script('mm-vue');
            wp_enqueue_script('mm-main');
            wp_enqueue_script('mm-mapbox');
            wp_enqueue_script('mm-mapbox-lang');
            add_action('wp_footer', array( $this, 'vue_template_components' ));
       
            ob_start();
            include( $this->settings['inc'] . 'vue-components/app.php');

            $output = ob_get_contents();
            ob_end_clean();
            return $output;
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
         * @since    1.0.1
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
            require_once($this->settings['inc'] . 'mm-admin.php');
            
        }

        public function include_app($original_template) {
            // Check Theme Template or Plugin Template for archive-links.php
            $file = trailingslashit(get_template_directory()) . 'archive-markers.php';
    
            if(is_post_type_archive('markers')) {
            // some additional logic goes here^.
                if(file_exists(get_template_directory_uri() . '/archive-markers.php')) {
                    return get_template_directory_uri() . '/archive-markers.php';
                } else {
                    return $this->settings['inc'] . 'templates/archive-markers.php';
                }
            }
            else if(is_singular('markers')) {
                if(file_exists(get_template_directory_uri() . '/single-marker.php')) {
                    return get_template_directory_uri() . '/single-marker.php';
                } else {
                    return $this->settings['inc'] . 'templates/single-marker.php';
                }
            }
            
            return $original_template;
        }
        
        public function register_scripts_styles(){
            wp_register_script('mm-vue', 'https://unpkg.com/vue@next', null, null, true);
            wp_register_script('mm-main', $this->settings['js'] . 'main-vue3.js', 'mm-vue', null, true);
            wp_register_script('mm-mapbox', 'https://api.tiles.mapbox.com/mapbox-gl-js/v0.53.1/mapbox-gl.js', 'mm-vue', null, true);
            wp_register_script('mm-mapbox-lang', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-language/v0.10.1/mapbox-gl-language.js', 'mm-vue', null, true);
            wp_register_style('mm-mapbox-css','https://api.tiles.mapbox.com/mapbox-gl-js/v0.53.1/mapbox-gl.css', null, null, 'all');
            wp_register_style('mm-app', $this->settings['css'] . 'app.css', null, time(), 'all');

            wp_enqueue_script('mm-core', $this->settings['js'] . 'mm-core.js', 'jquery', time(), true);
            wp_localize_script('mm-core', 'ajax_object', array( 'ajaxurl' => admin_url('admin-ajax.php') ));
        }
    }

    // initialize
    new MapMarkers();
}

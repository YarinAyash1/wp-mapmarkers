<?php 

// check if class already exists
if ( ! class_exists( 'MapboxField' ) ) {
	class MapboxField extends acf_field {

		/**
		 *  __construct
		 *
		 *  This function will setup the field type data
		 *
		 * @type    function
		 * @since   1.0.1
		 *
		 * @param $settings
		 */
		function __construct( $settings ) {
			/**
			 *  name (string) Single word, no spaces. Underscores allowed
			 */
			$this->name = 'Mapbox';

			/**
			 * label (string) Multiple words, can include spaces, visible when selecting a field type
			 */
			$this->label = __( 'Mapbox', 'acf-mapbox' );

			/**
			 * category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
			 */
			$this->category = 'jquery';

			/**
			 * defaults (array) Array of default settings which are merged into the field object. These are used later in settings
			 */
			$this->defaults = array(
				'height'              => '',
				'center_lat'          => '',
				'center_lng'          => '',
				'zoom'                => '',
				'styles'              => '',
				'enable_marker'       => '',
				'enable_marker_popup' => '',
				'enable_nav_control'  => ''
			);

			/**
			 * default map values
			 */
			$this->default_values = array(
				'height'     => '400',
				'center_lat' => '-77.01866',
				'center_lng' => '38.888',
				'zoom'       => '12',
				'styles'     => 'streets-v10',
			);

			/**
			 * Default search input box place holder
			 */
			$this->default_search_placeholder = 'Search place...';

			/**
			 * settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
			 */
			$this->settings = $settings;

			// do not delete!
			parent::__construct();
		}


		/**
		 *  render_field_settings()
		 *
		 *  Create extra settings for your field. These are visible when editing a field
		 *
		 * @type    action
		 * @since    1.0.1
		 *
		 * @param    $field (array) the $field being edited
		 *
		 * @return    n/a
		 */
		function render_field_settings( $field ) {
			// Center - latitude
			acf_render_field_setting( $field, array(
				'label'        => __( 'Center', 'acf' ),
				'instructions' => __( 'Center the initial map. lng value must be between -90 and 90', 'acf' ),
				'type'         => 'text',
				'name'         => 'center_lat',
				'prepend'      => 'lat',
				'placeholder'  => $this->default_values['center_lat']
			) );

			// Center - longitude
			acf_render_field_setting( $field, array(
				'label'        => __( 'Center', 'acf' ),
				'instructions' => __( 'Center the initial map', 'acf' ),
				'type'         => 'text',
				'name'         => 'center_lng',
				'prepend'      => 'lng',
				'placeholder'  => $this->default_values['center_lng'],
				'_append'      => 'center_lat'
			) );

			// Zoom level
			acf_render_field_setting( $field, array(
				'label'        => __( 'Zoom', 'acf' ),
				'instructions' => __( 'Set the initial zoom level', 'acf' ),
				'type'         => 'text',
				'name'         => 'zoom',
				'placeholder'  => $this->default_values['zoom']
			) );

			// Map container's width
			acf_render_field_setting( $field, array(
				'label'        => __( 'Width', 'acf' ),
				'instructions' => __( 'Customise the map width. If left empty, default width will be 100%', 'acf' ),
				'type'         => 'text',
				'name'         => 'width',
				'append'       => 'px',
			) );

			// Map container's height
			acf_render_field_setting( $field, array(
				'label'        => __( 'Height', 'acf' ),
				'instructions' => __( 'Customise the map height', 'acf' ),
				'type'         => 'text',
				'name'         => 'height',
				'append'       => 'px',
				'placeholder'  => $this->default_values['height']
			) );

			// Mapbox styles selection
			acf_render_field_setting( $field, array(
				'label'        => __( 'Styles', 'acf' ),
				'instructions' => __( 'Select a Mapbox Styles to use', 'acf' ),
				'type'         => 'select',
				'name'         => 'styles',
				'append'       => 'px',
				'placeholder'  => $this->default_values['styles'],
				'choices'      => array(
					'streets-v10'                  => 'streets-v10',
					'outdoors-v10'                 => 'outdoors-v10',
					'light-v9'                     => 'light-v9',
					'dark-v9'                      => 'dark-v9',
					'satellite-v9'                 => 'satellite-v9',
					'satellite-streets-v10'        => 'satellite-streets-v10',
					'navigation-preview-day-v2'    => 'navigation-preview-day-v2',
					'navigation-preview-night-v2'  => 'navigation-preview-night-v2',
					'navigation-guidance-day-v2'   => 'navigation-guidance-day-v2',
					'navigation-guidance-night-v2' => 'navigation-guidance-night-v2'
				)
			) );

			// Enable/Disable the map marker
			acf_render_field_setting( $field, array(
				'label'        => __( 'Map Marker', 'acf' ),
				'instructions' => __( 'Enable the marker on the map', 'acf' ),
				'type'         => 'true_false',
				'name'         => 'enable_marker',
				'ui'           => 1,
				'class'        => 'conditional-toggle',
			) );

			// Enable/Disable the map marker popup
			acf_render_field_setting( $field, array(
				'label'        => __( 'Map Marker Popup', 'acf' ),
				'instructions' => __( 'Enable the marker popup on the map', 'acf' ),
				'type'         => 'true_false',
				'name'         => 'enable_marker_popup',
				'ui'           => 1,
				'class'        => 'conditional-toggle',
			) );

			// Enable/Disable the map nav control
			acf_render_field_setting( $field, array(
				'label'        => __( 'Navigation Control', 'acf' ),
				'instructions' => __( 'Enable the navigation control on the map', 'acf' ),
				'type'         => 'true_false',
				'name'         => 'enable_nav_control',
				'ui'           => 1,
				'class'        => 'conditional-toggle',
			) );
		}

		/**
		 *  render_field()
		 *
		 *  Create the HTML interface for your field
		 *
		 * @param    $field (array) the $field being rendered
		 *
		 * @type    action
		 * @since    1.0.1
		 *
		 * @param    $field (array) the $field being edited
		 *
		 * @return    n/a
		 */
		function render_field( $field ) {
			// Apply filter from functions.php to use the Mapbox access token
			$api = apply_filters( 'acf/fields/mapbox/api', array() );
			
			// Get the field ID because this will serve as the wrapper element of the map and the hidden fields
			$field_id = $field['id'];

			// validate value
			if ( empty( $field['value'] ) ) {
				$field['value'] = array();
			}

			// Populate fields with default values if they're empty yet
			foreach ( $this->default_values as $k => $v ) {
				if ( empty( $field[ $k ] ) ) {
					$field[ $k ] = $v;
				}
			}

			// The following fields: Zoom, Height, Width, Styles, Map Marker, Map Marker Popup,
			// and Navigation Control should always use the values from the form. But if the form
			// is not yet supplied with values, the $this->default_values will be used.
			//
			// The fields lat and lang will use the user supplied values if already supplied. Else, the $this->default_values will be used.
			//
			// The field address will always use the user supplied value.
			$field['value'] = array(
				'lat'                 => ( ! empty( $field['value']['lat'] ) ) ? $field['value']['lat'] : $field['center_lat'],
				'lng'                 => ( ! empty( $field['value']['lng'] ) ) ? $field['value']['lng'] : $field['center_lng'],
				'address'             => ( ! empty( $field['value']['address'] ) ) ? $field['value']['address'] : '',
				'zoom'                => $field['zoom'],
				'width'               => $field['width'],
				'height'              => $field['height'],
				'styles'              => $field['styles'],
				'enable_marker'       => $field['enable_marker'],
				'enable_marker_popup' => $field['enable_marker_popup'],
				'enable_nav_control'  => $field['enable_nav_control']
			);

			?>
            <div id="<?php echo $field['id']; ?>" class="acf-mapbox">
                <div class="acf-hidden">
					<?php foreach ( $field['value'] as $k => $v ): ?>
                        <input type="hidden" class="input-<?php echo $k; ?>" name="<?php echo esc_attr( $field['name'] ); ?>[<?php echo $k; ?>]" value="<?php echo esc_attr( $v ); ?>"/>
					<?php endforeach; ?>
                </div>

				<?php // Make sure that an access token is available ?>
				<?php if ( isset( $api['key'] ) ): ?>
					<?php $place_holder = ( isset( $field['value']['address'] ) ) ? $field['value']['address'] : $this->default_search_placeholder; // Use the selected place as a placeholder or use the default ?>
                    <div id="map_<?php echo $field_id; ?>"
                         style="<?php if ( $field['width'] ): ?>width: <?php echo $field['width']; ?>px;<?php endif; ?><?php if ( $field['height'] ): ?>height: <?php echo $field['height']; ?>px;<?php endif; ?>"></div>
                    <script type="text/javascript">
                        if (typeof mapboxgl !== 'undefined') {
                            // Set the access token
                            mapboxgl.accessToken = '<?php echo $api['key']; ?>';

                            // Create the map using all the values we gathered
                            if (typeof create_map !== 'undefined') {
                                create_map(
                                    '<?php echo $field_id; ?>',
									<?php echo ( ! empty( $field['value']['lat'] ) ) ? $field['value']['lat'] : $field['center_lat']; ?>,
									<?php echo ( ! empty( $field['value']['lng'] ) ) ? $field['value']['lng'] : $field['center_lng']; ?>,
                                    '<?php echo $place_holder; ?>',
									<?php echo $field['zoom']; ?>,
                                    '<?php echo $field['styles']; ?>',
									<?php echo ( $field['enable_nav_control'] == 1 ) ? 'true' : 'false'; ?>,
									<?php echo ( $field['enable_marker'] == 1 ) ? 'true' : 'false'; ?>,
									<?php echo ( $field['enable_marker_popup'] == 1 ) ? 'true' : 'false'; ?>,
                                );
                            }
                        }
                    </script>
				<?php endif; ?>
            </div>
			<?php
		}

		/**
		 *  input_admin_enqueue_scripts()
		 *
		 *  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
		 *  Use this action to add CSS + JavaScript to assist your render_field() action.
		 *
		 * @type    action (admin_enqueue_scripts)
		 * @since    1.0.1
		 *
		 * @param    n/a
		 *
		 * @return    n/a
		 */
		function input_admin_enqueue_scripts() {
			// vars
			$url     = $this->settings['url'];
			$version = $this->settings['version'];

			// Register & include JS
			wp_enqueue_script( 'mm-mapbox-js', '//api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.js', array( 'acf-input' ), $version );
			wp_enqueue_script( 'mm-acf-mapbox-geocoder-js', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.3.0/mapbox-gl-geocoder.min.js', array( 'acf-input' ), $version );
			wp_enqueue_script( 'mm-acf-mapbox-core-js', "{$url}assets/js/mm-core.js", array( 'acf-input' ), $version );

			// Register & include CSS
			wp_enqueue_style( 'mm-mapbox-css', '//api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.css', array( 'acf-input' ), $version );
			wp_enqueue_style( 'mm-acf-mapbox-geocoder-css', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.3.0/mapbox-gl-geocoder.css', array( 'acf-input' ), $version );
			wp_enqueue_style( 'mm-acf-mapbox-css', "{$url}assets/css/mm-core.css", array( 'acf-input' ), $version );

		}

		function update_value( $value, $post_id, $field ) {
			if ( empty( $value ) || empty( $value['lat'] ) || empty( $value['lng'] ) ) {
				return false;
			}

			return $value;
		}

		function validate_value( $valid, $value, $field, $input ) {

			if ( ! $field['required'] ) {
				return $valid;
			}

			if ( empty( $value ) || empty( $value['lat'] ) || empty( $value['lng'] ) ) {
				return false;
			}

			return $valid;
		}
	}

	// initialize
	new MapboxField( $this->settings );
}
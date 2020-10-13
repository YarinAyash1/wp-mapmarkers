/*
 * Mapbox JS
 */

/**
 * Create the custom map
 *
 * @param id
 * @param center_lat
 * @param center_lng
 * @param address
 * @param zoom
 * @param styles
 * @param enable_nav_control
 * @param enable_marker
 * @param enable_marker_popup
 */
function create_map(id, center_lat, center_lng, address, zoom, styles, enable_nav_control, enable_marker, enable_marker_popup) {
    // bail early if Mapbox required JS is not available
    if (typeof mapboxgl === 'undefined') {
        return;
    }

    try {
        // Create the map coordinates using the values from the form or from the user's selected location
        let map = new mapboxgl.Map({
            container: 'map_' + id,
            zoom: (zoom) ? zoom : '16',
            center: [center_lat, center_lng],
            style: 'mapbox://styles/mapbox/' + styles
        });

        // Add the navigation control if it is set to be enabled ?>
        if (enable_nav_control) {
            let navControl = new mapboxgl.NavigationControl();
            map.addControl(navControl, 'top-left');
        }

        // Add the geocoder to search for places using Mapbox Geocoding API
        map.addControl(new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            placeholder: address
        }).on('result', function(geocoder) {
            let field_id = jQuery('#' + id);
            hidden_input_lat = jQuery('.input-lat', field_id),
                hidden_input_lng = jQuery('.input-lng', field_id),
                hidden_input_address = jQuery('.input-address', field_id),
                hidden_input_zoom = jQuery('.input-zoom', field_id),
                center_lat = (geocoder.result.center[0]) ? geocoder.result.center[0] : null,
                center_lng = (geocoder.result.center[1]) ? geocoder.result.center[1] : null,
                address = (geocoder.result.place_name) ? geocoder.result.place_name : null;

            // Update the hidden elements using the values from the search result
            if (hidden_input_lat.length > 0 && center_lat) {
                // Update center_lat
                hidden_input_lat.val(center_lat);
            }
            if (hidden_input_lng.length > 0 && center_lng) {
                // Update center_lng
                hidden_input_lng.val(center_lng)
            }
            if (hidden_input_address.length > 0 && address) {
                // Update address
                hidden_input_address.val(address)
            }

            // Create the marker on the searched location
            if (center_lat && center_lng && address) {
                create_marker(map, center_lat, center_lng, address, enable_marker, enable_marker_popup);
            }
        }));

        // Create the map marker
        create_marker(map, center_lat, center_lng, address, enable_marker, enable_marker_popup);
    } catch (error) {
        // Log important error message
        console.log(error.message);
    }
}

/**
 * Create the map marker
 *
 * @param map
 * @param center_lat
 * @param center_lng
 * @param address
 * @param enable_marker
 * @param enable_marker_popup
 */
function create_marker(map, center_lat, center_lng, address, enable_marker, enable_marker_popup) {
    // Add the marker if it is set to be enabled
    if (enable_marker) {
        // This GeoJSON will be used to determine where the marker will appear on the map
        let geoJSON = {
            type: 'FeatureCollection',
            features: [{
                type: 'Feature',
                geometry: {
                    type: 'Point',
                    coordinates: [center_lat, center_lng]
                },
                properties: {
                    title: 'Mapbox',
                    description: address
                }
            }]
        };

        // Add marker to the location
        geoJSON.features.forEach(function(marker) {
            // Create an HTML element for each feature
            let el = document.createElement('div');
            el.className = 'marker';

            let width = '41';
            let height = '41';

            // Make a marker for the feature and add to the map
            let map_marker = new mapboxgl.Marker(el, {
                anchor: 'bottom'
            }).setLngLat(marker.geometry.coordinates);

            // Set the popup if the marker popup is set to be enabled
            if (enable_marker_popup) {
                map_marker.setPopup(new mapboxgl.Popup({ offset: 25 }) // adds popup
                    .setHTML('<h3>' + marker.properties.title + '</h3><p>' + marker.properties.description + '</p>'));
            }

            // Add the marker to the map
            map_marker.addTo(map);
        });
    }
}
<?php


if (! defined('WPINC')) {
    die;
} // end if

?>
<div id="mapmarkers">
    <div class="map-marker">
        <div class="side-map">
            <div class="badge-container">
                <div v-for="(badge, key) in markers" :key="key">
                    <badge :Name="badge.marker_name" :id="badge.marker_id" :Types="badge.marker_types" :Image="badge.marker_logo ? badge.marker_logo.sizes.thumbnail : false" />
                </div>
            </div>
        </div>
        <div class="">
            <mapbox-map v-if="markers.length > 0" api_key="<?php echo get_option('mapmarkers_form_data')['mapbox_api_key'] ?>" :markers="markers" />
        </div>
    </div>
</div>
<?php


if (! defined('WPINC')) {
    die;
} // end if

?>
<div id="mapmarkers">
    <div class="map-marker">
        <div class="side-map">
            <div class="badge-container">
                <badge 
                    v-for="(badge, key) in markers"
                    v-bind:key="key"
                    v-bind:marker="badge" 
                />
            </div>
        </div>
        <mapbox-map v-if="markers.length > 0" api_key="<?php echo get_option('mapmarkers_form_data')['mapbox_api_key'] ?>" :markers="markers" />
    </div>
</div>
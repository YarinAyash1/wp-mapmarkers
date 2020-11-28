<?php


if (! defined('WPINC')) {
    die;
} // end if

?>
<template id="badge-component">
    <div class="badge" :id="marker.marker_id">
        <div v-if="marker.marker_name" class="badge-image">
            <img v-if="marker.marker_logo" :src="marker.marker_logo.sizes.thumbnail" alt="">
        </div>
        <div class="badge-meta">
            <h2>{{ marker.marker_name }}</h2>
            <div class="types">
                <div :class="'type type-' + type.term_id" v-for="(type, key) in marker.marker_types" :key="key">
                    {{ type.name }}
                </div>
            </div>
        </div>
    </div>
</template>
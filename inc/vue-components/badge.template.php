<?php


if (! defined('WPINC')) {
    die;
} // end if

?>
<template id="badge-component">
    <div class="badge">
        <div v-if="Image" class="badge-image"><img :src="Image" alt=""></div>
        <div class="badge-meta">
            <h2>{{ Name }}</h2>
            <div class="types">
            <div :class="'type type-' + type.term_id" v-for="(type, key) in Types" :key="key">
                {{ type.name }}
            </div>
            </div>
        </div>
    </div>
</template>
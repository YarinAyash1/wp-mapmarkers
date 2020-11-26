<?php


if (! defined('WPINC')) {
    die;
} // end if

get_header();
    echo do_shortcode( '[mapmarkers]' );
get_footer();


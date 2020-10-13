<?php

function mm_save_marker_title($post_id)
{
    if (get_post_type() == 'markers') {
        $my_post = array();
        $my_post['ID'] = $post_id;
        $my_post['post_title'] = get_field('marker_name', $post_id);
        $my_post['post_name'] = sanitize_title(get_field('marker_name', $post_id));
        wp_update_post($my_post);
    }
}

add_action('acf/save_post', 'mm_save_marker_title', 20);

if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_5dfaa66d82f92',
        'title' => 'Marker Settings',
        'fields' => array(
            array(
                'key' => 'field_5dfaa684471bc',
                'label' => 'Marker Name',
                'name' => 'marker_name',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5dfaa6a5471bd',
                'label' => 'Marker Logo',
                'name' => 'marker_logo',
                'type' => 'image',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
            ),
            array(
                'key' => 'field_5dfaa7d3471be',
                'label' => 'Marker Color',
                'name' => 'marker_color',
                'type' => 'color_picker',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
            ),
            array(
                'key' => 'field_5eb9c40e3df42',
                'label' => 'Map Marker',
                'name' => 'map',
                'type' => 'Mapbox',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'center_lat' => '',
                'center_lng' => '',
                'zoom' => '',
                'width' => '',
                'height' => '',
                'styles' => 'light-v9',
                'enable_marker' => 1,
                'enable_marker_popup' => 0,
                'enable_nav_control' => 0,
            ),

        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'markers',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'acf_after_title',
        'style' => 'seamless',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => array(
            0 => 'permalink',
            1 => 'the_content',
            2 => 'excerpt',
            3 => 'discussion',
            4 => 'comments',
            5 => 'revisions',
            6 => 'slug',
            7 => 'author',
            8 => 'format',
            9 => 'page_attributes',
            10 => 'featured_image',
            11 => 'categories',
            12 => 'tags',
            13 => 'send-trackbacks',
        ),
        'active' => true,
        'description' => '',
    ));
    
endif;



add_action('rest_api_init', function () {
    register_rest_route('map_marker/v1', '/markers/', array(
        'methods' => 'GET',
        'callback' => 'markers_endpoint'
    ));
});


function my_acf_init()
{
    acf_update_setting('google_api_key', 'AIzaSyCG9PXHx3IIs8l8RynCqe_eI9nB3PfAefU');
}

add_action('acf/init', 'my_acf_init');



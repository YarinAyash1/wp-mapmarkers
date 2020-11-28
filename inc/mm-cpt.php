<?php


 function mm_post_type() {
 
    // Set UI labels for Custom Post Type
        $labels = array(
            'name'                => _x( 'Map Markers', 'Post Type General Name', 'twentythirteen' ),
            'singular_name'       => _x( 'Marker', 'Post Type Singular Name', 'twentythirteen' ),
            'menu_name'           => __( 'Map Markers', 'twentythirteen' ),
            'parent_item_colon'   => __( 'Parent Event', 'twentythirteen' ),
            'all_items'           => __( 'All Map Markers', 'twentythirteen' ),
            'view_item'           => __( 'View Marker', 'twentythirteen' ),
            'add_new_item'        => __( 'Add New Marker', 'twentythirteen' ),
            'add_new'             => __( 'Add New', 'twentythirteen' ),
            'edit_item'           => __( 'Edit Marker', 'twentythirteen' ),
            'update_item'         => __( 'Update Marker', 'twentythirteen' ),
            'search_items'        => __( 'Search Marker', 'twentythirteen' ),
            'not_found'           => __( 'Not Found', 'twentythirteen' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
        );
         
    // Set other options for Custom Post Type
         
        $args = array(
            'label'               => __( 'Map Markers', 'twentythirteen' ),
            'description'         => __( 'Marker news and reviews', 'twentythirteen' ),
            'labels'              => $labels,
            // Features this CPT supports in Post Editor
            'supports'            => array( 'custom-fields', ),
            // You can associate this CPT with a taxonomy or custom taxonomy. 
            'taxonomies'          => array( 'business_type' ),
            /* A hierarchical CPT is like Pages and can have
            * Parent and child items. A non-hierarchical CPT
            * is like Posts.
            */ 
            'query_var' => false,
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
            'show_in_rest'        => true
        );
         
        // Registering your Custom Post Type
        register_post_type( 'markers', $args );
     
    }
// Register Custom Taxonomy
function mm_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Business Types', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Business Type', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Business Types', 'text_domain' ),
		'all_items'                  => __( 'All Business Types', 'text_domain' ),
		'parent_item'                => __( 'Parent Business Type', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Business Type:', 'text_domain' ),
		'new_item_name'              => __( 'New Business Type Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Business Type', 'text_domain' ),
		'edit_item'                  => __( 'Edit Business Type', 'text_domain' ),
		'update_item'                => __( 'Update Business Type', 'text_domain' ),
		'view_item'                  => __( 'View Business Type', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate Business Types with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove Business Types', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Business Types', 'text_domain' ),
		'search_items'               => __( 'Search Business Types', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No Business Types', 'text_domain' ),
		'items_list'                 => __( 'Business Types list', 'text_domain' ),
		'items_list_navigation'      => __( 'Business Types list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => false,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
        'query_var' => true 
	);
	register_taxonomy( 'business_type', array( 'markers' ), $args );

}
add_action( 'init', 'mm_taxonomy', 0 );
add_action( 'init', 'mm_post_type', 0 );
    
?>


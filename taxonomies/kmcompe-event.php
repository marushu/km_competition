<?php

function km_event_init() {
	register_taxonomy( 'km-event', array( 'km-competition' ), array(
		'hierarchical'      => true,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'show_admin_column' => false,
		'query_var'         => true,
		'rewrite'           => true,
		'capabilities'      => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts'
		),
		'labels'            => array(
			'name'                       => __( 'Km events', 'km-competition' ),
			'singular_name'              => _x( 'Km event', 'taxonomy general name', 'km-competition' ),
			'search_items'               => __( 'Search km events', 'km-competition' ),
			'popular_items'              => __( 'Popular km events', 'km-competition' ),
			'all_items'                  => __( 'All km events', 'km-competition' ),
			'parent_item'                => __( 'Parent km event', 'km-competition' ),
			'parent_item_colon'          => __( 'Parent km event:', 'km-competition' ),
			'edit_item'                  => __( 'Edit km event', 'km-competition' ),
			'update_item'                => __( 'Update km event', 'km-competition' ),
			'add_new_item'               => __( 'New km event', 'km-competition' ),
			'new_item_name'              => __( 'New km event', 'km-competition' ),
			'separate_items_with_commas' => __( 'Separate km events with commas', 'km-competition' ),
			'add_or_remove_items'        => __( 'Add or remove km events', 'km-competition' ),
			'choose_from_most_used'      => __( 'Choose from the most used km events', 'km-competition' ),
			'not_found'                  => __( 'No km events found.', 'km-competition' ),
			'menu_name'                  => __( 'Km events', 'km-competition' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'km-event',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'km_event_init' );

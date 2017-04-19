<?php

function km_competition_init() {
	register_post_type( 'km-competition', array(
		'labels'            => array(
			'name'                => __( 'Competitions', 'km-tournament' ),
			'singular_name'       => __( 'Competition', 'km-tournament' ),
			'all_items'           => __( 'All Competitions', 'km-tournament' ),
			'new_item'            => __( 'New competition', 'km-tournament' ),
			'add_new'             => __( 'Add New', 'km-tournament' ),
			'add_new_item'        => __( 'Add New competition', 'km-tournament' ),
			'edit_item'           => __( 'Edit competition', 'km-tournament' ),
			'view_item'           => __( 'View competition', 'km-tournament' ),
			'search_items'        => __( 'Search competitions', 'km-tournament' ),
			'not_found'           => __( 'No competitions found', 'km-tournament' ),
			'not_found_in_trash'  => __( 'No competitions found in trash', 'km-tournament' ),
			'parent_item_colon'   => __( 'Parent competition', 'km-tournament' ),
			'menu_name'           => __( 'Competitions', 'km-tournament' ),
		),
		'public'            => true,
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'supports'          => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'author' ),
		'has_archive'       => true,
		'rewrite'           => true,
		'query_var'         => true,
		'menu_icon'         => 'dashicons-admin-post',
		'show_in_rest'      => true,
		'rest_base'         => 'km-competition',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'menu_position'     => 5,
	) );

}
add_action( 'init', 'km_competition_init' );

function km_competition_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['km-competition'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Competition updated. <a target="_blank" href="%s">View competition</a>', 'km-tournament'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'km-tournament'),
		3 => __('Custom field deleted.', 'km-tournament'),
		4 => __('Competition updated.', 'km-tournament'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Competition restored to revision from %s', 'km-tournament'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Competition published. <a href="%s">View competition</a>', 'km-tournament'), esc_url( $permalink ) ),
		7 => __('Competition saved.', 'km-tournament'),
		8 => sprintf( __('Competition submitted. <a target="_blank" href="%s">Preview competition</a>', 'km-tournament'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Competition scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview competition</a>', 'km-tournament'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Competition draft updated. <a target="_blank" href="%s">Preview competition</a>', 'km-tournament'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'km_competition_updated_messages' );

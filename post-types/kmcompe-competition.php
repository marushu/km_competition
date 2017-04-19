<?php

$post_type_slug = $kmcompe_competition->options['post_type'];

$custom_posts = array(
	"slug" => $post_type_slug,
	"name" => $post_type_slug,
	"singular_name" => $post_type_slug,
	"is_public" => true,
	"has_archive" => false,
);

$var = new KMpost_type ( $custom_posts );

class KMpost_type {

	function __construct( $init ) {

		$this->settings = $init;
		add_action( 'init', array( $this, 'km_competition_init' ) );
		add_filter( 'post_updated_messages', array( $this, 'km_competition_updated_messages' ) );

	}


	public function km_competition_init(  ) {

		register_post_type( esc_attr( $this->settings['slug'] ), array(
			'labels'                => array(
				'name'               => __( $this->settings['name'], 'km-competition' ),
				'singular_name'      => __( $this->settings['name'], 'km-competition' ),
				'all_items'          => __( 'All Competitions', 'km-competition' ),
				'new_item'           => __( 'New competition', 'km-competition' ),
				'add_new'            => __( 'Add New', 'km-competition' ),
				'add_new_item'       => __( 'Add New competition', 'km-competition' ),
				'edit_item'          => __( 'Edit competition', 'km-competition' ),
				'view_item'          => __( 'View competition', 'km-competition' ),
				'search_items'       => __( 'Search competitions', 'km-competition' ),
				'not_found'          => __( 'No competitions found', 'km-competition' ),
				'not_found_in_trash' => __( 'No competitions found in trash', 'km-competition' ),
				'parent_item_colon'  => __( 'Parent competition', 'km-competition' ),
				'menu_name'          => __( 'Competitions', 'km-competition' ),
			),
			'public'                => true,
			'hierarchical'          => true,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'author' ),
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_icon'             => 'dashicons-admin-post',
			'show_in_rest'          => true,
			'rest_base'             => esc_attr( $this->settings['name'] ),
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'menu_position'         => 5,
		) );

	}

	public function km_competition_updated_messages( $messages ) {
		global $post;

		$permalink = get_permalink( $post );

		$messages[ esc_attr( $this->settings['slug'] ) ] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => sprintf( __( 'Competition updated. <a target="_blank" href="%s">View competition</a>', 'km-competition' ), esc_url( $permalink ) ),
			2  => __( 'Custom field updated.', 'km-competition' ),
			3  => __( 'Custom field deleted.', 'km-competition' ),
			4  => __( 'Competition updated.', 'km-competition' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Competition restored to revision from %s', 'km-competition' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => sprintf( __( 'Competition published. <a href="%s">View competition</a>', 'km-competition' ), esc_url( $permalink ) ),
			7  => __( 'Competition saved.', 'km-competition' ),
			8  => sprintf( __( 'Competition submitted. <a target="_blank" href="%s">Preview competition</a>', 'km-competition' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
			9  => sprintf( __( 'Competition scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview competition</a>', 'km-competition' ),
				// translators: Publish box date format, see http://php.net/date
				date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
			10 => sprintf( __( 'Competition draft updated. <a target="_blank" href="%s">Preview competition</a>', 'km-competition' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		);

		return $messages;
	}

}

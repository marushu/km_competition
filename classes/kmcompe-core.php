<?php
class KMcompeclass {

	function __construct() {

		//add_action( 'transition_post_status', array( $this, 'post_published_notification' ), 10, 3 );
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		//add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		//add_action( 'admin_init', array( $this, 'settings_init' ) );
		//add_filter( 'wp_mail_from_name', array( $this, 'set_mail_from_name' ) );
		//add_filter( 'wp_mail_from', array( $this, 'set_mail_from' ) );

		//register_activation_hook( __FILE__, array( $this, 'activate' ) );

	}


	/**
	 * Load textdomain
	 */
	public function load_textdomain() {
		load_plugin_textdomain(
			'km-competition',
			false,
			KMTDIR . '/languages'
		);
	}

}
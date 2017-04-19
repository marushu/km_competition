<?php

/**
 * Summary.
 *
 * @since  0.1.0
 * @access public
 */
class KMadmin {

	protected $options;

	/**
	 * Post_Notifier constructor.
	 */
	function __construct() {

		$this->options = get_option( 'kmcompe_settings' );

		//add_action( 'transition_post_status', array( $this, 'post_published_notification' ), 10, 3 );
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'settings_init' ) );
		//add_filter( 'wp_mail_from_name', array( $this, 'set_mail_from_name' ) );
		//add_filter( 'wp_mail_from', array( $this, 'set_mail_from' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'km_compe_admin_enqueue_scripts' ) );

		register_activation_hook( __FILE__, array( $this, 'activate' ) );

	}

	/**
	 * Activation.
	 */
	public function activate() {

		$kmcompe_settings = get_option( 'kmcompe_settings' );
		if ( empty( $kmcompe_settings ) ) {
			$default_value = array(
				'post_type_field'    => '',
				'child_post'         => array(),
			);
			update_option( 'kmcompe_settings', $default_value );
		}

	}

	/**
	 * Load textdomain
	 */
	public function load_textdomain() {
		load_plugin_textdomain(
			'km-competition',
			false,
			plugin_basename( dirname( __FILE__ ) ) . '/languages'
		);
	}

	public function km_compe_admin_enqueue_scripts( $hook_suffix ) {

		if ( false === strpos( $hook_suffix, 'kmcompe_competition' ) )
			return;

		wp_enqueue_script(
			'km_compe-js',
			KMCOMPEURL . 'js/km_compe.js',
			array( 'jquery' ),
			'',
			true
		);

	}

	/**
	 * Add admin menu
	 */
	public function admin_menu() {
		add_options_page(
			'KM Competition',
			'KM Competition',
			'manage_options',
			'kmcompe_competition',
			array( $this, 'kmcompe_competition_options_page' )
		);
	}

	/**
	 * Register settings.
	 */
	public function settings_init() {

		register_setting(
			'kmcompepage',
			'kmcompe_settings',
			array( $this, 'data_sanitize' )
		);

		add_settings_section(
			'km_compe_competition_section',
			__( 'KM Competition settings', 'km-competition' ),
			array( $this, 'kmcompe_settings_section_callback' ),
			'kmcompepage'
		);

		add_settings_field(
			'post_type_field',
			__( 'Set post-type slug', 'km-competition' ),
			array( $this, 'post_type_render' ),
			'kmcompepage',
			'km_compe_competition_section'
		);

		add_settings_field(
			'child_post_field',
			__( 'Set post-type slug', 'km-competition' ),
			array( $this, 'child_post_render' ),
			'kmcompepage',
			'km_compe_competition_section'
		);

	}

	/**
	 * Add description of Post Notifier.
	 */
	public function kmcompe_settings_section_callback() {

		echo esc_attr__( 'Set post type slug, author, taxonomy slug', 'km-competition' );

	}

	/**
	 * Output post-type checkbox.
	 */
	public function post_type_render() {

		$post_type = isset( $this->options['post_type'] )
			? trim( $this->options['post_type'] )
			: '';

		?>

			<p>
				<input type="text" name="kmcompe_settings[post_type]" value="<?php echo esc_html( $post_type ); ?>">
			</p>

		<?php

	}

	public function child_post_render() {

		$child_post_slug = isset( $this->options['child_post'] )
			? $this->options['child_post']
			: '';

		var_dump( $child_post_slug );

		$child_count = isset( $child_post_slug['slug'] ) ? count( (array) $child_post_slug['slug'] ) : 0;
		var_dump( $child_count );

		$html = '';

		if ( empty( $child_post_slug ) ) {

			$html .= '<ul class="post_slug_container">';
			$html .= '<li>';

			$html .= '<label for="post_title_' . intval( $child_count + 1 ) . '">Child post title : </label>';
			$html .= '<input type="text" name="kmcompe_settings[child_post][title][]" value="" id="post_title_' . intval( $child_count + 1 ) . '">';

			$html .= '<label for="post_slug_' . intval( $child_count + 1 ) . '">Child post slug : </label>';
			$html .= '<input type="text" name="kmcompe_settings[child_post][slug][]" value="" id="post_slug_' . intval( $child_count + 1 ) . '">';

			$html .= '<span class="add_child_post">＋</span>';
			$html .= '<span class="remove_child_post">-</span>';

			$html .= '</li>';
			$html .= '</ul>';

		} else {

			$child_post_slug['title'] = array_filter( $child_post_slug['title'], 'strlen' );
			$child_post_slug['slug'] = array_filter( $child_post_slug['slug'], 'strlen' );

			$html .= '<ul class="post_slug_container">';
			$html .= '<li>';

			for ( $i = 0; $i < $child_count; $i++ ) {

				if ( ! empty( $child_post_slug['title'][ $i ] ) ) {

					$html .= '<li class="post_slug_container">';

					$html .= '<label for="post_title_' . ( $i + 1 ) . '">Child post title : </label>';
					$html .= '<input type="text" name="kmcompe_settings[child_post][title][]" value="' . $child_post_slug['title'][ $i ] . '" id="post_title_' . ( $i + 1 ) . '">';

					$html .= '<label for="post_slug_' . ( $i + 1 ) . '">Child post slug : </label>';
					$html .= '<input type="text" name="kmcompe_settings[child_post][slug][]" value="' . $child_post_slug['slug'][ $i ] . '" id="post_slug_' . ( $i + 1 ) . '">';

					$html .= '<span class="add_child_post">＋</span>';
					$html .= '<span class="remove_child_post">-</span>';
					$html .= '</li>';

				}

			}

			//$child_post_slug['title'] = implode( ',', $child_post_slug['title'] );
			//array_filter( $child_post_slug['title'], 'strlen' );
			//var_dump( $child_post_slug['title'] );
			//$child_post_slug['title'] = array_filter( $child_post_slug['title'], 'strlen' );
			//$child_post_slug['title'] = array_values( $child_post_slug['title'] );
			//$child_post_slug['slug'] = array_filter( $child_post_slug['slug'], 'strlen' );
			//$child_post_slug['slug'] = array_values( $child_post_slug['slug'] );


			$html .= '</li>';
			$html .= '</ul>';

		}

		echo $html;

	}

	/**
	 * Output Post Notifier page form.
	 */
	public function kmcompe_competition_options_page() {

		?>
		<form action='options.php' method='post'>

			<?php
			settings_fields( 'kmcompepage' );
			do_settings_sections( 'kmcompepage' );
			submit_button();
			?>

		</form>
		<?php
	}
}
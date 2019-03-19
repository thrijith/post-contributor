<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class OptionClass {
	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;

	/**
	 * Start up
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'post_contributor_plugin_option_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
	}

	/**
	 * Add options page
	 */
	public function post_contributor_plugin_option_page() {
		add_options_page(
			'Settings Admin',
			'Post Contributor',
			'manage_options',
			'post-contributor',
			array( $this, 'post_contributor_option' )
		);
	}

	/**
	 * Options page callback
	 */
	public function post_contributor_option() {
		wp_register_style(
			'post-contributor-css',
			POST_CONTRIBUTOR_ASSETS . 'css/main.css'
		);
		wp_enqueue_style( 'post-contributor-css' );

		if ( get_option( 'all_posts_type' ) ) {
			$this->options = explode( ',', get_option( 'all_posts_type' ) );
		}
		?>
		<div class="wrap">
			<h2>Post Contributor</h2>
			<form method="post" action="options.php">
				<?php
				// This prints out all hidden setting fields
				settings_fields( 'all_posts_type_group' );
				do_settings_sections( 'post-contributor' );
				submit_button( 'Save Setting' );
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Register and add settings
	 */
	public function page_init() {
		register_setting(
			'all_posts_type_group', // Option group
			'all_posts_type', // Option name
			array( $this, 'field_sanitize' ) // Sanitize
		);

		add_settings_section(
			'setting_section_id', // ID
			'', // Title
			[], // Callback
			'post-contributor' // Page
		);

		add_settings_field(
			'post_label', // ID
			'All Post Type', // Title
			[ $this, 'post_type_callback' ], // Callback
			'post-contributor',
			'setting_section_id' // Section
		);
	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function field_sanitize( $input ) {
		$new_input = array();
		if ( isset( $_POST['post_label'] ) ) {
			$new_input = implode( ',', $_POST['post_label'] );
		}

		return $new_input;
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function post_type_callback() {
		$call_post_types = get_post_types();
		$builtin         = [ 'attachment', 'revision', 'nav_menu_item' ];
		foreach ( $call_post_types as $post_type ) {
			if ( ! in_array( $post_type, $builtin ) ) {
				if ( is_array( $this->options ) AND in_array( $post_type, $this->options ) ) {
					printf( '<div class="checkboxDist"><input type="checkbox" checked="checked" id="post_label" name="post_label[]" value="%s" />%s</div>', $post_type, $post_type );
				} else {
					printf( '<div class="checkboxDist"><input type="checkbox" id="post_label" name="post_label[]" value=' . '"%s"' . ' />%s</div>', $post_type, $post_type );
				}
			}
		}
	}
}

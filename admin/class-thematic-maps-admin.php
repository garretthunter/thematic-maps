<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/garretthunter
 * @since      1.0.0
 *
 * @package    Thematic_Maps
 * @subpackage Thematic_Maps/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Thematic_Maps
 * @subpackage Thematic_Maps/admin
 * @author     Garrett Hunter <garrett.hunter@blacktower.com>
 */
class Thematic_Maps_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The title of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_title    The string used in menus and pages to display this plugin's title.
	 */
	protected $plugin_title;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	private $plugin_directory;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version The version of this plugin.
	 * @param $plugin_title
	 * @param $plugin_directory
	 */
	public function __construct( $loader, $plugin_name, $version, $plugin_title, $plugin_directory ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->plugin_title = $plugin_title;
		$this->loader = $loader;

		$this->plugin_directory = $plugin_directory;}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Thematic_Maps_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Thematic_Maps_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// Add the color picker css file
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/thematic-maps-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Thematic_Maps_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Thematic_Maps_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/thematic-maps-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, false );

	}

	/**
     * Set default values for the api options.
     *
	 * @since 1.0.0
	 * 
     * @return array
     */
    public function set_default_api_options()
    {

        $defaults = [
	        'maps_apikey' => '',
        ];

        return $defaults;
	}

	/**
	 * Set default values for the new maps.
	 *
	 * @since 1.1.0
	 *
	 * @return array
	 */
	public function set_default_new_map_options()
	{

		$defaults = [
			'default_map' =>
				[
					'nf_form_id'       => '',
					'nf_field'         => '',
					'ca_default_color' => '#F5F5F5',
					'ca_min_color'     => '#DEF2FC',
					'ca_max_color'     => '#003767',
				]
		];

		return $defaults;
	}

	/**
	 * Add a Setting link to WordPress plugin list page
	 *
	 * @since 1.0.3
	 *
	 * @return array
	 */
	public function add_plugin_links( $links, $plugin_file ) {

		$plugin_links = array(
			'<a href="' . admin_url( 'admin.php?page=thematic_maps' ) . '">' . __( 'Settings', 'thematic_maps_plugin' ) . '</a>',
		);

		return array_merge( $plugin_links, $links );

    }

	/**
	 * Save the form data
	 */
	public function save() {
		exit("hello world");
	}

	/**
	 * Define the admin menu structure
	 */
	public function tm_admin_menu() {
		add_menu_page(
			'Settings',
			'Thematic Maps',
			'manage_options', 					// Capability / Permissions
			$this->plugin_name.'_general', 			    // Menu slug, unique, lowercase
			array ($this, 'render_tm_general_page'),	// Output / render
			'dashicons-analytics'
		);

		add_submenu_page(
			$this->plugin_name.'_general',
			'New Map',
			'New Map',
			'manage_options', 					// Capability / Permissions
			$this->plugin_name.'_add', 			    // Menu slug, unique, lowercase
			array ($this, 'render_new_map_page')	// Output / render
		);
	}

	/**
	 * Initialize global settings
	 */
	public function tm_global_settings_init () {

		if( false == get_option( $this->plugin_name.'_plugin' ) ) {
			$defaults = $this->set_default_api_options();
			add_option( $this->plugin_name.'_plugin', $defaults['maps_apikey']  );
		}

		add_settings_section(
			$this->plugin_name.'_general',			                // ID used to identify this section and with which to register options
			__( $this->plugin_title.' Global Settings', 'thematic_maps_plugin' ),	// Title to be displayed on the administration page
			array( $this, 'global_settings_description_callback'),	        // Callback used to render the description of the section
			$this->plugin_name.'_general'		                // Page on which to add this section of options
		);

		/**
		 * Google Maps API Key
		 */
		add_settings_field(
			'option_maps_apikey',						        // ID used to identify the field throughout the theme
			__( 'Google Maps API Key', 'thematic_maps_plugin' ),					// The label to the left of the option interface element
			array( $this, 'render_maps_apikey'),	// The name of the function responsible for rendering the option interface
			$this->plugin_name.'_general',	            // The page on which this option will be displayed
			$this->plugin_name.'_general'			        // The name of the section to which this field belongs
		);

		register_setting(
			$this->plugin_name.'_general',					// Settings group name
			$this->plugin_name.'_general',						// Option to save
			array( $this, 'validate_options_global_settings')   // Sanitize callback
		);

	}

	/**
	 * Initialize New Map settings page
	 */
	public function tm_new_map_settings_init () {

		if( false == get_option( $this->plugin_name.'_maps' ) ) {
			$defaults = $this->set_default_new_map_options();
			add_option( $this->plugin_name.'_maps', $defaults['default_map']  );
		}

		add_settings_section(
			$this->plugin_name.'_new_map',			                // ID used to identify this section and with which to register options
			__( $this->plugin_title.' Add New Map', 'thematic_maps_plugin' ),	// Title to be displayed on the administration page
			array( $this, 'new_map_description_callback'),	        // Callback used to render the description of the section
			$this->plugin_name.'_add'		                // Page on which to add this section of options
		);

		/**
		 * Ninja Forms form selector
		 */
		add_settings_field(
			'option_nf_form_id',						        // ID used to identify the field throughout the theme
			__( 'Ninja Forms', 'thematic_maps_plugin' ),					// The label to the left of the option interface element
			array( $this, 'render_nf_form_id'),	// The name of the function responsible for rendering the option interface
			$this->plugin_name.'_add',	            // The page on which this option will be displayed
			$this->plugin_name.'_new_map'			        // The name of the section to which this field belongs
		);

		/**
		 * Ninja Form Field to measure
		 */
		add_settings_field(
			'option_nf_field',						        // ID used to identify the field throughout the theme
			__( 'Ninja Forms Field', 'thematic_maps_plugin' ),					// The label to the left of the option interface element
			array( $this, 'render_nf_field'),	// The name of the function responsible for rendering the option interface
			$this->plugin_name.'_add',	                // The page on which this option will be displayed
			$this->plugin_name.'_new_map',			        // The name of the section to which this field belongs
			array(								        // The array of arguments to pass to the callback. In this case, just a description.
				__( 'Ninja Forms field to measure.', $this->plugin_name.'plugin' ),
			)
		);

		/**
		 * Color Axis Min Color
		 */
		add_settings_field(
			'option_ca_min_color',						        // ID used to identify the field throughout the theme
			__( 'Color Axis Min Color', 'thematic_maps_plugin' ),					// The label to the left of the option interface element
			array( $this, 'render_ca_min_color'),	// The name of the function responsible for rendering the option interface
			$this->plugin_name.'_add',	            // The page on which this option will be displayed
			$this->plugin_name.'_new_map'			        // The name of the section to which this field belongs
		);

		/**
		 * Color Axis Max Color
		 */
		add_settings_field(
			'option_ca_min_value',						        // ID used to identify the field throughout the theme
			__( 'Color Axis Max Color', 'thematic_maps_plugin' ),					// The label to the left of the option interface element
			array( $this, 'render_ca_max_color'),	// The name of the function responsible for rendering the option interface
			$this->plugin_name.'_add',	            // The page on which this option will be displayed
			$this->plugin_name.'_new_map'			        // The name of the section to which this field belongs
		);

		/**
		 * Color Axis Default Color
		 */
		add_settings_field(
			'option_ca_default_value',						        // ID used to identify the field throughout the theme
			__( 'Color Axis Default Color', 'thematic_maps_plugin' ),					// The label to the left of the option interface element
			array( $this, 'render_ca_default_color'),	// The name of the function responsible for rendering the option interface
			$this->plugin_name.'_add',	            // The page on which this option will be displayed
			$this->plugin_name.'_new_map'			        // The name of the section to which this field belongs
		);

		register_setting(
			$this->plugin_name.'_new_map',					// Settings group name
			$this->plugin_name.'_maps',						// Option to save
			array( $this, 'validate_options_new_map')   // Sanitize callback
		);

	}

	public function render_tm_general_page( $active_tab = '' ) {

		require_once plugin_dir_path( __FILE__ ) . 'partials/tm-general-page.php';

	}

	public function render_new_map_page( $active_tab = '' ) {

		require_once plugin_dir_path( __FILE__ ) . 'partials/new-map-page.php';

	}

	public function global_settings_description_callback () {

		/**
		 * Add an echo here to output text at the top of the API settings page
		 */

	}

	public function new_map_description_callback () {

		/**
		 * Add an echo here to output text at the top of the New Map settings page
		 */

	}

	/**
	 * This function renders the Maps API Key option
	 *
	 * It's called from the 'initialize_plugin_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function render_maps_apikey ( $messages ) {

		require_once plugin_dir_path( __FILE__ ) . 'partials/maps-apikey.php';

	}

	/**
	 * This function renders the Ninja Form selection option
	 *
	 * It's called from the 'initialize_plugin_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function render_nf_form_id ( $messages ) {

		require_once $this->plugin_directory . 'includes/class-thematic-maps-ninja-forms.php';
		require_once plugin_dir_path( __FILE__ ) . 'partials/nf-form-id.php';

	}

	/**
	 * This function renders the Ninja Form Field option
	 *
	 * It's called from the 'initialize_plugin_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function render_nf_field ( $messages ) {

		require_once plugin_dir_path( __FILE__ ) . 'partials/nf-field.php';

	}

	/**
	 * This function renders the Color Axis Min Color option
	 *
	 * It's called from the 'initialize_plugin_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function render_ca_min_color ( $messages ) {

		require_once plugin_dir_path( __FILE__ ) . 'partials/ca-min-color.php';

	}

	/**
	 * This function renders the Color Axis Max Color option
	 *
	 * It's called from the 'initialize_plugin_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function render_ca_max_color ( $messages ) {

		require_once plugin_dir_path( __FILE__ ) . 'partials/ca-max-color.php';

	}

	/**
	 * This function renders the Color Axis Default Color option
	 *
	 * It's called from the 'initialize_plugin_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function render_ca_default_color ( $messages ) {

		require_once plugin_dir_path( __FILE__ ) . 'partials/ca-default-color.php';

	}

// TODO fix this action callback
	function sample_admin_notice__error() {
		$class = 'notice notice-error';
		$message = __( 'Irks! An error has occurred.', $this->plugin_name );

		$this->my_error = new WP_Error( 'toy', 'my favorite toy is dolly', 'best toy' );

		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
	}
	/**
	 * Callback for the options. Sanitized text inputs, this function loops through the incoming option and strips all tags and slashes from the value
	 * before serializing it.
	 *
	 * @params	$input	The unsanitized collection of options.
	 *
	 * @returns	$input	The collection of sanitized values.
	 */
	public function validate_options_global_settings() {

		$this->loader->add_action( 'admin_notices', $this, 'sample_admin_notice__error' );
						add_settings_error(
							$this->plugin_name . '_plugin',
							'maps_apikey',
							__( 'Please enter a valid API Key to continue.', $this->plugin_name ),
							'error' );

		// First, validate the nonce and verify the user as permission to save.
		if ( ! ( $this->has_valid_nonce() && current_user_can( 'manage_options' ) ) ) {
			// TODO: Display an error message.
			add_settings_error(
				$this->plugin_name . '_plugin',
				$key,
				__( 'Please enter a valid API Key to continue.', $this->plugin_name ),
				'error' );
		}

		// If the above are valid, sanitize and save the option.
		if ( null !== wp_unslash( $_POST['maps_apikey'] ) ) {

			$value = sanitize_text_field( $_POST['maps_apikey'] );
			update_option( $this->plugin_name . '_plugin', $value );

		}
		/**
		 * Save the orginal options until the input is validated
		 */
//		$current_options = get_option( $this->plugin_name . '_plugin' );
//		$new_options     = array();
//
//		foreach ( $input as $key => $val ) {
//			if ( ! empty ( trim( $input[ $key ] ) ) ) {
//				$new_options[ $key ] = strip_tags( stripslashes( $input[ $key ] ) );
//			} else {
//				switch ( $key ) {
//					case 'maps_apikey':
//						add_settings_error(
//							$this->plugin_name . '_plugin',
//							$key,
//							__( 'Please enter a valid API Key to continue.', $this->plugin_name ),
//							'error' );
//						break;
//				}
//				$new_options[ $key ] = $current_options[ $key ];
//			}
//		}

		$this->redirect();
//		return apply_filters( 'validate_options_global_settings', $new_options, $input );
	} // end validate_options

	/**
	 * Redirect to the page from which we came (which should always be the
	 * admin page. If the referred isn't set, then we redirect the user to
	 * the login page.
	 *
	 * @access private
	 */
	private function redirect() {

		// To make the Coding Standards happy, we have to initialize this.
		if ( ! isset( $_POST['_wp_http_referer'] ) ) { // Input var okay.
			$_POST['_wp_http_referer'] = wp_login_url();
		}

		// Sanitize the value of the $_POST collection for the Coding Standards.
		$url = sanitize_text_field(
			wp_unslash( $_POST['_wp_http_referer'] ) // Input var okay.
		);

		// Finally, redirect back to the admin page.
		wp_safe_redirect( urldecode( $url ) );
		exit;

	}

	/**
	 * Callback for the options. Sanitized text inputs, this function loops through the incoming option and strips all tags and slashes from the value
	 * before serializing it.
	 *
	 * @params	$input	The unsanitized collection of options.
	 *
	 * @returns	$input	The collection of sanitized values.
	 */
	public function validate_options_new_map( $input ) {

		// First, validate the nonce and verify the user as permission to save.
		if ( ! ( $this->has_valid_nonce() && current_user_can( 'manage_options' ) ) ) {
			// TODO: Display an error message.

			// If the above are valid, save the option.
			/**
			 * Save the orginal options until the input is validated
			 */
			$current_options = get_option($this->plugin_name.'_maps');
			$new_options = array();

			foreach( $input as $key => $val ) {
				if( !empty ( trim($input[$key]) ) ) {
					$new_options[$key] = strip_tags( stripslashes( $input[$key] ) );
				} else {
					switch( $key ) {
						case 'nf_form_id':
							add_settings_error(
								$this->plugin_name.'_plugin',
								$key,
								__('Please select a Ninja Form.', $this->plugin_name),
								'error' );
							break;
						case 'nf_field':
							add_settings_error(
								$this->plugin_name.'_plugin',
								$key,
								__('Please enter Ninja Form Field.', $this->plugin_name),
								'error' );
							break;
					}
					$new_options[$key] = $current_options[$key];
				}
			}
			return apply_filters( 'validate_options_new_map', $new_options, $input );

		}
	} // end validate_options

	private function has_valid_nonce() {

		// If the field isn't even in the $_POST, then it's invalid.
		if ( ! isset( $_POST['maps_apikey'] ) ) { // Input var okay.
			return false;
		}

		$field  = wp_unslash( $_POST['maps_apikey'] );
		$action = 'validate_global_settings';

		return wp_verify_nonce( $field, $action );
	}
}

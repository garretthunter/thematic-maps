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

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $plugin_title ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->plugin_title = $plugin_title;

	}

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/thematic-maps-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function tm_admin_menu() {
		add_menu_page( 
			$this->plugin_title,
			$this->plugin_title, 
			'manage_options', 					// Capability / Permissions
			$this->plugin_name, 			    // Menu slug, unique, lowercase
			array ($this, 'tm_options_page'),	// Output / render
			'dashicons-analytics'
		);	
	}

	public function tm_settings_init () {

		if( false == get_option( $this->plugin_name.'_plugin' ) ) {
            add_option( $this->plugin_name.'_plugin', array( 'maps_apikey' => '' ) );
        }

        add_settings_section(
            $this->plugin_name.'_settings',			                // ID used to identify this section and with which to register options
            __( $this->plugin_title.' Settings', 'thematic_maps_plugin' ),	// Title to be displayed on the administration page
            array( $this, 'settings_description_callback'),	        // Callback used to render the description of the section
            $this->plugin_name		                // Page on which to add this section of options
        );

        add_settings_field(
            'option_maps_apikey',						        // ID used to identify the field throughout the theme
            __( 'Maps API Key', 'thematic_maps_plugin' ),					// The label to the left of the option interface element
            array( $this, 'maps_apikey_option_callback'),	// The name of the function responsible for rendering the option interface
            $this->plugin_name,	            // The page on which this option will be displayed
            $this->plugin_name.'_settings',			        // The name of the section to which this field belongs
            array(								        // The array of arguments to pass to the callback. In this case, just a description.
                __( 'Provided by the Google Developer\'s console', $this->plugin_name.'_plugin' ),
            )
        );

        register_setting(
            $this->plugin_name.'_settings',					// Settings group name
			$this->plugin_name.'_plugin',						// Option to save
			array( $this, 'validate_options')   // Sanitize callback
        );

	}

	public function tm_options_page() 
	{   ?>
        <div class="wrap">
			<form method="post" action="options.php">
				<?php 
        	    settings_errors();
				settings_fields( $this->plugin_name.'_settings' );
				do_settings_sections( $this->plugin_name);
                submit_button();
                ?>
            </form>
        </div><!-- /.wrap -->
        <?php
    }
	
    public function settings_description_callback () {

        /**
         * Add an echo here to output text at the top of the API settings page
         */
		echo "$this->plugin_title uses the Google GeoCharts which requires mapsApiKey for your project.<br />";
		echo "See <a target=\"_blank\" href=\"https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings\">https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings</a>";

	}	

    /**
     * This function renders the Maps API Key option
     *
     * It's called from the 'initialize_plugin_options' function by being passed as a parameter
     * in the add_settings_section function.
     */
	public function maps_apikey_option_callback ( $messages ) {

		$options = get_option($this->plugin_name.'_plugin');
        ?>
            <input type="text" name="<?php echo $this->plugin_name; ?>_plugin[maps_apikey]" value="<?php echo esc_attr($options['maps_apikey']); ?>" maxlength="255" size="40"/>
            <?php echo $messages[0];

	}	

    /**
     * Callback for the options. Sanitized text inputs, this function loops through the incoming option and strips all tags and slashes from the value
     * before serializing it.
     *
     * @params	$input	The unsanitized collection of options.
     *
     * @returns			The collection of sanitized values.
     */
    public function validate_options( $input ) {

		/**
		 * Save the orginal options until the input is validated
		 */
		$current_options = get_option($this->plugin_name.'_plugin');
		$new_options = array();

		foreach( $input as $key => $val ) {
            if( !empty ( trim($input[$key]) ) ) {
                $new_options[$key] = strip_tags( stripslashes( $input[$key] ) );
            } else {
				add_settings_error(
					$this->plugin_name.'_plugin',
					$key,
					'Please enter a valid API Key to continue',
					'error' );
				$new_options = $current_options;
			}
        } 
        return apply_filters( 'validate_options', $new_options, $input );
    } // end validate_options
	
}

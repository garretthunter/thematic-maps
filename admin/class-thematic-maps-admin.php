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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

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

	/**
	 * Retrieve the options prefix of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The options prefix of the plugin.
	 */
	public function get_options_prefix() {
		return strtolower( $this->plugin_name )."_";
	}

	public function thematic_maps_plugin_menu() {
		add_options_page( 
			__($this->plugin_name.' Settings', 'thematic_maps_plugin'), 
			$this->plugin_name, 
			'administrator', 
			'thematic_maps_plugin', 
			array ($this, 'thematic_maps_options'));
	}

	public function thematic_maps_options() 
	{ ?>
        <div class="wrap">
			<form method="post" action="options.php">
				<?php 
				do_settings_sections( 'thematic_maps_options');
        	    settings_errors();
                submit_button();
                ?>
            </form>
        </div><!-- /.wrap -->
        <?php
    }
	
	public function initialize_plugin_options () {

        if( false == get_option( 'thematic_maps_options' ) ) {
            add_option( 'thematic_maps_options', array( 'maps_apikey' => '' ) );
        }

        add_settings_section(
            'thematic_maps_settings_section',			                // ID used to identify this section and with which to register options
            __( $this->plugin_name.' Settings', 'thematic_maps_plugin' ),	// Title to be displayed on the administration page
            array( $this, 'settings_description_callback'),	        // Callback used to render the description of the section
            'general'		                // Page on which to add this section of options
        );

        add_settings_field(
            'option_maps_apikey',						        // ID used to identify the field throughout the theme
            __( 'Maps API Key', 'thematic_maps_plugin' ),					// The label to the left of the option interface element
            array( $this, 'maps_apikey_option_callback'),	// The name of the function responsible for rendering the option interface
            'general',	            // The page on which this option will be displayed
            'thematic_maps_settings_section',			        // The name of the section to which this field belongs
            array(								        // The array of arguments to pass to the callback. In this case, just a description.
                __( 'Provided from your Google Developer\'s console', 'thematic_maps_plugin' ),
            )
        );

        register_setting(
            'general',
			'thematic_maps_options',
			array( $this, 'validate_options')
        );

	}

    public function settings_description_callback () {

        /**
         * Add an echo here to output text at the top of the API settings page
         */
		echo "$this->plugin_name uses the Google GeoCharts which requires mapsApiKey for your project.<br />";
		echo "See <a target=\"_blank\" href=\"https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings\">https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings</a>";

	}	

    /**
     * This function renders the Maps API Key option
     *
     * It's called from the 'initialize_plugin_options' function by being passed as a parameter
     * in the add_settings_section function.
     */
	public function maps_apikey_option_callback ( $messages ) {

		$options = get_option('thematic_maps_options');
        ?>
            <input type="text" name="thematic_maps_options[maps_apikey]" value="<?php echo esc_attr($options['maps_apikey']); ?>" maxlength="255" size="40"/>
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

        $output = array();

		foreach( $input as $key => $val ) {
            if( isset ( $input[$key] ) ) {
                $output[$key] = strip_tags( stripslashes( $input[$key] ) );
            } // end if
        } // end foreach
        // Return the new collection
        return apply_filters( 'validate_options', $output, $input );
    } // end validate_options

	
}

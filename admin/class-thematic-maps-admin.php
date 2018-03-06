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
     * Set default values for the plugin options.
     *
	 * @since 1.0.0
	 * 
     * @return array
     */
    public function set_default_options()
    {

        $defaults = array(
            'maps_apikey'      => '',
			'nf_form_id'       => '',
			'nf_field'         => '',
			'ca_default_color' => '#F5F5F5',
			'ca_min_color'     => '#DEF2FC',
			'ca_max_color'     => '#003767',
        );

        return $defaults;
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
            add_option( $this->plugin_name.'_plugin', $this->set_default_options() );
        }

        add_settings_section(
            $this->plugin_name.'_settings',			                // ID used to identify this section and with which to register options
            __( $this->plugin_title.' Settings', 'thematic_maps_plugin' ),	// Title to be displayed on the administration page
            array( $this, 'settings_description_callback'),	        // Callback used to render the description of the section
            $this->plugin_name		                // Page on which to add this section of options
        );

		/**
		 * Google Maps API Key
		 */
        add_settings_field(
            'option_maps_apikey',						        // ID used to identify the field throughout the theme
            __( 'Google Maps API Key', 'thematic_maps_plugin' ),					// The label to the left of the option interface element
            array( $this, 'maps_apikey_option_callback'),	// The name of the function responsible for rendering the option interface
            $this->plugin_name,	            // The page on which this option will be displayed
            $this->plugin_name.'_settings'			        // The name of the section to which this field belongs
        );

		/**
		 * Ninja Forms form selector
		 */
        add_settings_field(
            'option_nf_form_id',						        // ID used to identify the field throughout the theme
            __( 'Ninja Forms', 'thematic_maps_plugin' ),					// The label to the left of the option interface element
            array( $this, 'nf_form_id_option_callback'),	// The name of the function responsible for rendering the option interface
            $this->plugin_name,	            // The page on which this option will be displayed
            $this->plugin_name.'_settings'			        // The name of the section to which this field belongs
        );

		/**
		 * Ninja Form Field to measure
		 */
        add_settings_field(
            'option_nf_field',						        // ID used to identify the field throughout the theme
            __( 'Ninja Forms Field', 'thematic_maps_plugin' ),					// The label to the left of the option interface element
            array( $this, 'nf_field_option_callback'),	// The name of the function responsible for rendering the option interface
            $this->plugin_name,	            // The page on which this option will be displayed
			$this->plugin_name.'_settings',			        // The name of the section to which this field belongs
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
            array( $this, 'ca_min_color_option_callback'),	// The name of the function responsible for rendering the option interface
            $this->plugin_name,	            // The page on which this option will be displayed
            $this->plugin_name.'_settings'			        // The name of the section to which this field belongs
        );

		/**
		 * Color Axis Max Color
		 */
        add_settings_field(
            'option_ca_min_value',						        // ID used to identify the field throughout the theme
            __( 'Color Axis Max Color', 'thematic_maps_plugin' ),					// The label to the left of the option interface element
            array( $this, 'ca_max_color_option_callback'),	// The name of the function responsible for rendering the option interface
            $this->plugin_name,	            // The page on which this option will be displayed
            $this->plugin_name.'_settings'			        // The name of the section to which this field belongs
        );

		/**
		 * Color Axis Default Color
		 */
        add_settings_field(
            'option_ca_default_value',						        // ID used to identify the field throughout the theme
            __( 'Color Axis Default Color', 'thematic_maps_plugin' ),					// The label to the left of the option interface element
            array( $this, 'ca_default_color_option_callback'),	// The name of the function responsible for rendering the option interface
            $this->plugin_name,	            // The page on which this option will be displayed
            $this->plugin_name.'_settings'			        // The name of the section to which this field belongs
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

	}	

    /**
     * This function renders the Maps API Key option
     *
     * It's called from the 'initialize_plugin_options' function by being passed as a parameter
     * in the add_settings_section function.
     */
	public function maps_apikey_option_callback ( $messages ) {

		$options = get_option($this->plugin_name.'_plugin');

        echo '<input type="text" name="' . $this->plugin_name . '_plugin[maps_apikey]" value="' . esc_attr($options['maps_apikey']) . '" maxlength="255" size="40"/>';
        echo 'Get your API key at <a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">Google</a>';
		echo $messages[0];

	}	

    /**
     * This function renders the Ninja Form selection option
     *
     * It's called from the 'initialize_plugin_options' function by being passed as a parameter
     * in the add_settings_section function.
     */
	public function nf_form_id_option_callback ( $messages ) {

		$options = get_option($this->plugin_name.'_plugin');
		global $wpdb;
		$results = $wpdb->get_results( "
			SELECT forms.id,
				   forms.title
			FROM {$wpdb->prefix}nf3_forms forms
			order by forms.title");

		if( empty( $results ) ) {
			echo __('You must install the <a href="https://wordpress.org/plugins/ninja-forms/" target="_blank">Ninja Forms</a> plugin and create a form before using this plugin.', $this->plugin_name);
		} else { ?>
			<select name="<?php echo $this->plugin_name; ?>_plugin[nf_form_id]">
				<option value=""></option> <?php
			foreach( $results as $form ) { ?>
				<option value="<?php echo $form->id; ?>"<?php if ( $form->id === $options['nf_form_id'] ) :?> SELECTED <?php endif ?>><?php echo esc_attr($form->title); ?></option> <?php
			} ?>
			</select> <?php 
		}
        echo $messages[0];

	}	

    /**
     * This function renders the Ninja Form Field option
     *
     * It's called from the 'initialize_plugin_options' function by being passed as a parameter
     * in the add_settings_section function.
     */
	public function nf_field_option_callback ( $messages ) {

		$options = get_option($this->plugin_name.'_plugin');
        echo '<input type="text" name="' . $this->plugin_name . '_plugin[nf_field]" value="' . esc_attr($options['nf_field']) . '" maxlength="255" size="40"/>';
        echo $messages[0];
	}	

    /**
     * This function renders the Color Axis Min Color option
     *
     * It's called from the 'initialize_plugin_options' function by being passed as a parameter
     * in the add_settings_section function.
     */
	public function ca_min_color_option_callback ( $messages ) {

		$options = get_option($this->plugin_name.'_plugin');
        echo '<input type="text" class="tm-color-picker" name="' . $this->plugin_name . '_plugin[ca_min_color]" value="' . esc_attr($options['ca_min_color']) . '" maxlength="7" size="10"/>';
		echo $messages[0];
	}

    /**
     * This function renders the Color Axis Max Color option
     *
     * It's called from the 'initialize_plugin_options' function by being passed as a parameter
     * in the add_settings_section function.
     */
	public function ca_max_color_option_callback ( $messages ) {

		$options = get_option($this->plugin_name.'_plugin');
        echo '<input type="text" class="tm-color-picker" name="' . $this->plugin_name . '_plugin[ca_max_color]" value="' . esc_attr($options['ca_max_color']) . '" maxlength="7" size="10"/>';
        echo $messages[0];
	}	

    /**
     * This function renders the Color Axis Default Color option
     *
     * It's called from the 'initialize_plugin_options' function by being passed as a parameter
     * in the add_settings_section function.
     */
	public function ca_default_color_option_callback ( $messages ) {

		$options = get_option($this->plugin_name.'_plugin');
        echo '<input type="text" class="tm-color-picker" name="' . $this->plugin_name . '_plugin[ca_default_color]" value="' . esc_attr($options['ca_default_color']) . '" maxlength="7" size="10"/>';
        echo $messages[0];
	}	

    /**
     * Callback for the options. Sanitized text inputs, this function loops through the incoming option and strips all tags and slashes from the value
     * before serializing it.
     *
     * @params	$input	The unsanitized collection of options.
     *
     * @returns	$input	The collection of sanitized values.
     */
    public function validate_options( $input ) {

		/**
		 * Save the orginal options until the input is validated
		 */
		$current_options = get_option($this->plugin_name.'_plugin');
		$new_options = array();

		print_r( $input );
		foreach( $input as $key => $val ) {
            if( !empty ( trim($input[$key]) ) ) {
                $new_options[$key] = strip_tags( stripslashes( $input[$key] ) );
            } else {
				switch( $key ) {
					case 'maps_apikey':
						add_settings_error(
							$this->plugin_name.'_plugin',
							$key,
							__('Please enter a valid API Key to continue.', $this->plugin_name),
							'error' );
						break;
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
        return apply_filters( 'validate_options', $new_options, $input );
    } // end validate_options

}

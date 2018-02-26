<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/garretthunter
 * @since      1.0.0
 *
 * @package    Thematic_Maps
 * @subpackage Thematic_Maps/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Thematic_Maps
 * @subpackage Thematic_Maps/public
 * @author     Garrett Hunter <garrett.hunter@blacktower.com>
 */
class Thematic_Maps_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/thematic-maps-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/thematic-maps-public.js', array( 'jquery' ), $this->version, false );

	}

	public function show_thematic_maps() {

		$options = get_option('thematic_maps_options');

		global $wpdb;
		$results = $wpdb->get_results( "
			SELECT PostMeta.meta_value as axis,
				   count(*) as axis_count
			FROM {$wpdb->prefix}posts Posts,
				 {$wpdb->prefix}postmeta PostMeta
			WHERE PostMeta.meta_key = concat ('_field_',(select id from {$wpdb->prefix}nf3_fields where `key` = 'state')) AND
				  Posts.post_type='nf_sub' AND
				  Posts.id = PostMeta.post_id AND
				  Posts.post_status = 'publish'
			group by PostMeta.meta_value");
	    ?>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<div id="geochart-colors" ></div>
	<script type="text/javascript">
		  google.charts.load('current', {
			'packages': ['geochart'],
			'mapsApiKey': '<?php echo $options['maps_apikey']; ?>'
		  });
		  google.charts.setOnLoadCallback(drawRegionsMap);
	
		  function drawRegionsMap() {
			var data = google.visualization.arrayToDataTable([
			  ['Axis', 'Count'],
	    <?php
		foreach( $results as $result ) {
		}
		$total_axis_count = 0;
		foreach ($results as $result)
		{
			$total_axis_count += $result->axis_count;
			echo sprintf ("['%s', %d],\n", $result->axis,$result->axis_count);
		}
	    ?>
			]);
	
			var options = {
			  region: 'US',
			  resolution: 'provinces',
			  colorAxis: {
				minValue: 0,
				maxValue: <?php echo $total_axis_count; ?>,
				colors: ['#DEF2FC', '#003767']
			  },
			  defaultColor: '#f5f5f5',
			};
	
			var chart = new google.visualization.GeoChart(document.getElementById('geochart-colors'));
			chart.draw(data, options);
		  };
	</script>
	    <?php
	}

}

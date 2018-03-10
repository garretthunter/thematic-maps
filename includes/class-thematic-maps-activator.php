<<<<<<< HEAD
<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/garretthunter
 * @since      1.0.0
 *
 * @package    Thematic_Maps
 * @subpackage Thematic_Maps/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Thematic_Maps
 * @subpackage Thematic_Maps/includes
 * @author     Garrett Hunter <garrett.hunter@blacktower.com>
 */
class Thematic_Maps_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

	}

}
=======
<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/garretthunter
 * @since      1.0.0
 *
 * @package    Thematic_Maps
 * @subpackage Thematic_Maps/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Thematic_Maps
 * @subpackage Thematic_Maps/includes
 * @author     Garrett Hunter <garrett.hunter@blacktower.com>
 */
class Thematic_Maps_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		global $wpdb;
		$iso_regions_table = $wpdb->prefix . 'tm_iso_regions';
		$charset_collate = $wpdb->get_charset_collate();

		/**
		 * Create the ISO regions table
		 */
		$sql = "CREATE TABLE $iso_regions_table (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			country_name tinytext NOT NULL,
			country_code CHAR(2) NOT NULL,
			region_name TINYTEXT,
			region_code CHAR(3),
			sub_region_name TINYTEXT,
			sub_region_code CHAR(3),
			is_supported BOOLEAN,
			PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $sql );

		/**
		 * Load static listing of all ISO 3166 region and country codes
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/iso-regions.php';

		$sql = "INSERT INTO $iso_regions_table (id, country_name, country_code, region_name, region_code, sub_region_name, sub_region_code, is_supported ) VALUES \n";

		foreach( $iso_regions as $iso_region ) {
			$sql = $sql . $iso_region . "\n";
		}
		$sql = $sql . ";";
		dbDelta( $sql );

	}

}
>>>>>>> iso regions added

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
	 * Called at plugin activation
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		global $wpdb;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$charset_collate = $wpdb->get_charset_collate();

		/**
		 * Create the ISO regions table and load it with default values
		 */
		$iso_regions_table = $wpdb->prefix . "tm_iso_regions";
		$sql = "CREATE TABLE {$wpdb->prefix}tm_iso_regions (
			 id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
			 region_name TINYTEXT NOT NULL,
			 region_code CHAR(3) NOT NULL,
			 region_type TINYTEXT NOT NULL,
			 PRIMARY KEY  (id)
			 ) {$charset_collate};";

		dbDelta( $sql );

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/iso-regions.php';
		$sql = "INSERT INTO $iso_regions_table (id, country_name, country_code, region_name, region_code, sub_region_name, sub_region_code, is_supported ) VALUES \n";
		foreach( $iso_regions_table as $iso_region ) {
			$sql = $sql . $iso_region . "\n";
		}
		$sql = $sql . ";";
		dbDelta( $sql );

		/*
		 * Create a table to store each map and its values
		 */
		$sql = "CREATE TABLE {$wpdb->prefix}tm_maps (
			 id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
			 map_name TINYTEXT NOT NULL,
			 region_code CHAR(3) NOT NULL,
			 ninja_form LONGTEXT NOT NULL,
			 color_access LONGTEXT NOT NULL,
			 PRIMARY KEY (id)
			 ) {$charset_collate};";

		dbDelta( $sql );

	}

}

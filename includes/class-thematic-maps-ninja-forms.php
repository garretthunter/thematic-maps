<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * @link       https://github.com/garretthunter
 * @since      1.0.0
 *
 * @package    Thematic_Maps
 * @subpackage Thematic_Maps/includes
 */

/**
 * Read-only data access class for accessing Google region names and codes
 *
 * @package    Thematic_Maps
 * @subpackage Thematic_Maps/includes
 * @author     Garrett Hunter <garrett.hunter@blacktower.com>
 */
class Thematic_Maps_Ninja_Form {

	/**
	 * @var db
	 */
	protected $db;

	public function __construct() {

		global $wpdb;
		$this->db = $wpdb;

	}

	/**
	 * @return mixed
	 */
	public function get_forms() {

		$results = $this->db->get_results( "
    	SELECT forms.id,
		   forms.title
	    FROM {$this->db->prefix}nf3_forms forms
	    order by forms.title");

		return $results;

	}
}

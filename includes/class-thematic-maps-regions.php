<?php
/**
 * Read-only data access class for accessing Google region names and codes
 *
 * @link       https://github.com/garretthunter
 * @since      1.1.0
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
class Thematic_Maps_Region {

	/**
	 * Database primary key
	 *
	 * @since   1.1.0
	 * @access  private
	 * @var     string   $id  Database primary key
	 */
	private $id;

	/**
	 * ISO 3166 continent name
	 *
	 * @since   1.1.0
	 * @access  private
	 * @var     string   $region_code  ISO 3166 continent name
	 */
	private $continent_name;

	/**
	 * ISO 3166 three digit continent code
	 *
	 * @since   1.1.0
	 * @access  private
	 * @var     string   $region_code  ISO 3166 three digit continent code
	 */
	private $continent_code;

	/**
	 * ISO 3166 sub-continent name
	 *
	 * @since   1.1.0
	 * @access  private
	 * @var     string   $region_code  ISO 3166 sub-continent name
	 */
	private $sub_continent_name;

	/**
	 * ISO 3166 three digit sub-continent code
	 *
	 * @since   1.1.0
	 * @access  private
	 * @var     string   $sub_continent_code  ISO 3166 three digit sub-continent code
	 */
	private $sub_continent_code;

	/**
	 * ISO 3166 country name
	 *
	 * @since   1.1.0
	 * @access  private
	 * @var     string   $country_name  ISO 3166 country name
	 */
	private $country_name;

	/**
	 * ISO 3166 alpha-2 country code
	 *
	 * @since   1.1.0
	 * @access  private
	 * @var     string   $country_code  ISO 3166 alpha-2 country code
	 */
	private $country_code;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   1.1.0
	 * @param   string  $region_type    The type of region to be instantiated
	 */
	public function __construct( $region_type = '' ) {

		switch ( $region_type ) {
			case 'continent':
				/**
				 * Get the list of all continents
				 * Use Case: I want to select one continent from a list of all continents
				 */
				break;
			case 'sub-continent':
				/**
				 * Get the list of all sub-continents
				 * Use Case: I want to select one sub-continent from a list of all sub-continents
				 */
				break;
			case 'country':
				/**
				 * Get the list of all countries
				 * USe Case: I want to select one country from a list of all countries
				 */
				break;
		}

		/**
		 * Nothing to do unless the "new is to get the list of things"
		 */
		$this->region = array();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Thematic_Maps_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_continents( ) {
		$continents = array();
		foreach( $this->region as $region ) {
			$continent['code'] = $region['code'];
			$continent['title'] = $region['title'];
			$continents[] = $continent;
		}
		return $continents;
	}
	public function get_subcontinents( $region = '' ) {
		$subcontinents = array();
		if( empty( $region ) ) {
			$region = $this->region;
		} else {
		}
		foreach( $region as $continent ) {
			foreach( $continent['subcontinent'] as $subcontinent ) {
				$result['title'] = $subcontinent['title'];
				$result['code']  = $subcontinent['code'];
			}
			$subcontinents[] = $result;
		}
		return( $subcontinents );
	}
}
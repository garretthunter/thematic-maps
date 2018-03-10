<?php
/**
 * Continent data accessor class
 *
 * @link       https://github.com/garretthunter
 * @since      1.1.0
 *
 * @package    Thematic_Maps
 * @subpackage Thematic_Maps/includes
 */

/**
 * Continent data accessor class
 *
 * @package    Thematic_Maps
 * @subpackage Thematic_Maps/includes
 * @author     Garrett Hunter <garrett.hunter@blacktower.com>
 */
class Thematic_Maps_Continent {

	public function get_continents() {
		/**
		 * get me a list of all continents
		 * SELECT DISTINCT continent, continent_code from table
		 */
	}

	public function get_sub_continents() {
		/**
		 * Get the list of all member subcontinents for this continent
		 * SELECT sub_continent, sub_continent_code where continent = $this->continent
		 * return all sub-continents
		 */
	}

	public function get_countries() {
		/**
		 * Get the list of all member countries for this continent
		 * SELECT country, country_code where continent = $this->continent
		 * return all sub-continents
		 */
	}

}
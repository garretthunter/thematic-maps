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
class Thematic_Maps_Continent {

	/**
	 * @var string
	 */
	const AFRICA = '002';

	protected static $continents = [
		self::AFRICA => [
			'name' => 'Africa',
		]
	];

	/**
	 * @var string
	 */
	protected $continent;

	/**
	 * @param string $continent
	 */

//'002' => 'Africa',
//'009' => 'Oceania',
//'019' => 'Americas',
//'142' => 'Asia',
//'150' => 'Europe',

}
<?php
/**
 * Register all actions and filters for the plugin
 *
 * @link       https://developers.google.com/chart/interactive/docs/gallery/geochart
 * @since      1.0.0
 *
 * @package    Thematic_Maps
 * @subpackage Thematic_Maps/includes
 */
/**
 * Help class for accessing Google region names and codes
 *
 * Maintain the list of all Google GeoMap region codes and names
 * along with access methods
 *
 * @package    Thematic_Maps
 * @subpackage Thematic_Maps/includes
 * @author     Garrett Hunter <garrett.hunter@blacktower.com>
 */
class Thematic_Maps_Regions {
	/**
	 * The list of Google GeoMap regions
	 *
	 * @since    1.1.0
	 * @access   protected
	 * @var      Thematic_Maps_Regions    $region    Holds list of all valid region codes.
	 */
	protected $region;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.1.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( ) {
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
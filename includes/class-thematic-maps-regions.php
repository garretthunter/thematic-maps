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
	 * @since    1.0.0
	 * @access   protected
	 * @var      Thematic_Maps_Regions    $region    Holds list of all valid region codes.
	 */
	protected $region;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( ) {
		$this->region = array(
			[
				'title'          => 'Africa',
				'code'           => '002',
				'subcontinent' => [
					[
						'title'     => 'North Africa',
						'code'      => '015',
						'countries' => [ 'DZ', 'EG', 'EH', 'LY', 'MA', 'SD', 'SS', 'TN' ]
					],
					[
						'title'     => 'Western Africa',
						'code'      => '011',
						'countries' => [
							'BF',
							'BJ',
							'CI',
							'CV',
							'GH',
							'GM',
							'GN',
							'GW',
							'LR',
							'ML',
							'MR',
							'NE',
							'NG',
							'SH',
							'SL',
							'SN',
							'TG'
						]
					],
					[
						'title'     => 'Middle Africa',
						'code'      => '017',
						'countries' => [ 'AO', 'CD', 'ZR', 'CF', 'CG', 'CM', 'GA', 'GQ', 'ST', 'TD' ]
					],
					[
						'title'     => 'Eastern Africa',
						'code'      => '014',
						'countries' => [
							'BI',
							'DJ',
							'ER',
							'ET',
							'KE',
							'KM',
							'MG',
							'MU',
							'MW',
							'MZ',
							'RE',
							'RW',
							'SC',
							'SO',
							'TZ',
							'UG',
							'YT',
							'ZM',
							'ZW'
						]
					],
					[
						'title'     => 'Southern Africa',
						'code'      => '018',
						'countries' => [ 'BW', 'LS', 'NA', 'SZ', 'ZA' ]
					],
				]
			],
			[
				'title'          => 'Europe',
				'code'           => '150',
				'subcontinent' => [
					[
						'title'     => 'Northern Europe',
						'code'      => '154',
						'countries' => [
							'GG',
							'JE',
							'AX',
							'DK',
							'EE',
							'FI',
							'FO',
							'GB',
							'IE',
							'IM',
							'IS',
							'LT',
							'LV',
							'NO',
							'SE',
							'SJ'
						]
					],
					[
						'title'     => 'Western Europe',
						'code'      => '155',
						'countries' => [ 'AT', 'BE', 'CH', 'DE', 'DD', 'FR', 'FX', 'LI', 'LU', 'MC', 'NL' ]
					],
					[
						'title'     => 'Eastern Europe',
						'code'      => '151',
						'countries' => [ 'BG', 'BY', 'CZ', 'HU', 'MD', 'PL', 'RO', 'RU', 'SU', 'SK', 'UA' ]
					],
					[
						'title'     => 'Southern Europe',
						'code'      => '039',
						'countries' => [
							'AD',
							'AL',
							'BA',
							'ES',
							'GI',
							'GR',
							'HR',
							'IT',
							'ME',
							'MK',
							'MT',
							'CS',
							'RS',
							'PT',
							'SI',
							'SM',
							'VA',
							'YU'
						]
					],
				]
			],
		);
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
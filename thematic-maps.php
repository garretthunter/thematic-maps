<?php

/**
 * Thematic MAps bootstrap file
 *
 * @link              https://github.com/garretthunter
 * @since             1.0.0
 * @package           Thematic_Maps
 *
 * @wordpress-plugin
 * Plugin Name:       Thematic Maps
 * Plugin URI:        https://github.com/garretthunter/thematic-maps
 * Description:       Displays a thematic map of the United States of America showing each state shaded in proportion to the measurement of a statistical variable, such as population density or per-capita income. Requires the <a href="https://wordpress.org/plugins/ninja-forms/">Ninja Forms</a> plugin.
 * Version:           1.1.0
 * Author:            Garrett Hunter
 * Author URI:        https://github.com/garretthunter
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       thematic-maps
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'THEMATIC_MAPS_VERSION', '1.1.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-thematic-maps-activator.php
 */
function activate_thematic_maps() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-thematic-maps-activator.php';
    Thematic_Maps_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-thematic-maps-deactivator.php
 */
function deactivate_thematic_maps() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-thematic-maps-deactivator.php';
    Thematic_Maps_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_thematic_maps' );
register_deactivation_hook( __FILE__, 'deactivate_thematic_maps' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-thematic-maps.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_thematic_maps() {

    $plugin = new Thematic_Maps();
    $plugin->run();

}
run_thematic_maps();

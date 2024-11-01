<?php
/**
 * The plugin bootstrap file
 *
 * @since             1.0.0
 * @package           ultimate-loan-mortgage-calculator
 *
 * @wordpress-plugin
 * Plugin Name:       Ultimate Loan & Mortgage Calculator
 * Description:       Loan Calculator gives you the shortcode with the flexible settings that you can place into the page, post or sidebar widget. Or actually anywhere you can place the shortcode.
 * Version:           1.0.2
 * Requires at least: 4.7
 * Requires PHP:      5.6
 * Author:            Belov Digital Agency
 * Author URI:        https://belovdigital.agency
 * License:           GPL-3.0+
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       ultimate-loan-mortgage-calculator
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Plugin constants
 */
define( 'ULMC_VERSION', '1.0.2' );
define( 'ULMC_PLUGIN_FILE', plugin_basename( __FILE__ ) );
define( 'ULMC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'ULMC_PLUGIN_NAME', 'ultimate-loan-mortgage-calculator' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ulmc.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function ulmc_run() {

	$plugin = new ULMC();
	$plugin->run();

}
ulmc_run();

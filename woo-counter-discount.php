<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://weekdays.te.ua
 * @since             1.0.0
 * @package           Woo_Counter_Discount
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Discount Counter
 * Plugin URI:        #
 * Description:       Change discount amount after use
 * Version:           1.1.0
 * Author:            Olexandr Chimera
 * Author URI:        https://weekdays.te.ua
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-counter-discount
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
define( 'PLUGIN_NAME_VERSION', '1.1.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-counter-discount-activator.php
 */
function activate_woo_counter_discount() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-counter-discount-activator.php';
	Woo_Counter_Discount_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-counter-discount-deactivator.php
 */
function deactivate_woo_counter_discount() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-counter-discount-deactivator.php';
	Woo_Counter_Discount_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woo_counter_discount' );
register_deactivation_hook( __FILE__, 'deactivate_woo_counter_discount' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-counter-discount.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_counter_discount() {

	$plugin = new Woo_Counter_Discount();
	$plugin->run();

}
run_woo_counter_discount();

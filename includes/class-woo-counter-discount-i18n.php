<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://weekdays.te.ua
 * @since      1.0.0
 *
 * @package    Woo_Counter_Discount
 * @subpackage Woo_Counter_Discount/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woo_Counter_Discount
 * @subpackage Woo_Counter_Discount/includes
 * @author     Olexandr Chimera <myrror555@gmail.com>
 */
class Woo_Counter_Discount_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woo-counter-discount',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

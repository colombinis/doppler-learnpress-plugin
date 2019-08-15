<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Fired during plugin activation
 *
 * @link       www.fromdoppler.com
 * @since      1.0.0
 *
 * @package    Doppler_For_Learnpress
 * @subpackage Doppler_For_Learnpress/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Doppler_For_Learnpress
 * @subpackage Doppler_For_Learnpress/includes
 * @author     Doppler <hgalvan@makingsense.com>
 */
class Doppler_For_Learnpress_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		update_option('dplrlp_version', DOPPLER_FOR_LEARNPRESS_VERSION);

	}


}

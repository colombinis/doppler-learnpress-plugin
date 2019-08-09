<?php

/**
 *
 * @link              www.fromdoppler.com
 * @since             1.0.0
 * @package           Doppler_For_Learnpress
 *
 * @wordpress-plugin
 * Plugin Name:       Doppler for LearnPress
 * Plugin URI:        www.fromdoppler.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Doppler
 * Author URI:        www.fromdoppler.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       doppler-for-learnpress
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'DOPPLER_FOR_LEARNPRESS_VERSION', '1.0.0' );
define( 'DOPPLER_FOR_LEARNPRESS_URL', plugin_dir_url(__FILE__) );
define( 'DOPPLER_PLUGINS_PATH', plugin_dir_path(__DIR__));
define( 'DOPPLER_PLUGINS_URL', plugins_url().'/doppler-form');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-doppler-for-learnpress-activator.php
 */
function activate_doppler_for_learnpress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-doppler-for-learnpress-activator.php';
	Doppler_For_Learnpress_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-doppler-for-learnpress-deactivator.php
 */
function deactivate_doppler_for_learnpress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-doppler-for-learnpress-deactivator.php';
	Doppler_For_Learnpress_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_doppler_for_learnpress' );
register_deactivation_hook( __FILE__, 'deactivate_doppler_for_learnpress' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-doppler-for-learnpress.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_doppler_for_learnpress() {

	$plugin = new Doppler_For_Learnpress();
	$plugin->run();

}
run_doppler_for_learnpress();

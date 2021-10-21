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
 * Description:       Submit your LearnPress students to a Doppler Lists.
 * Version:           1.0.4
 * Author:            Doppler
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       doppler-for-learnpress
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'DOPPLER_FOR_LEARNPRESS_VERSION', '1.0.4' );
define( 'DOPPLER_FOR_LEARNPRESS_PLUGIN_FILE', plugin_basename( __FILE__ ));
define( 'DOPPLER_FOR_LEARNPRESS_URL', plugin_dir_url(__FILE__) );
if(!defined('DOPPLER_PLUGINS_PATH')):
	define( 'DOPPLER_PLUGINS_PATH', plugin_dir_path(__DIR__));
endif;

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-doppler-for-learnpress-activator.php
 */
function activate_doppler_for_learnpress() {
	if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
		include_once( ABSPATH . '/wp-admin/includes/plugin.php' );
	}
	if ( current_user_can( 'activate_plugins' ) && ! class_exists( 'LearnPress' ) ) {
		// Deactivate the plugin.
		deactivate_plugins( plugin_basename( __FILE__ ) );
		// Throw an error in the WordPress admin console.
		$error_message = '<p style="font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Oxygen-Sans,Ubuntu,Cantarell,\'Helvetica Neue\',sans-serif;font-size: 13px;line-height: 1.5;color:#444;">' . esc_html__( 'This plugin requires ', 'doppler-for-learnpress' ) . '<a href="' . esc_url( 'https://wordpress.org/plugins/learnpress/' ) . '" target="_blank">LearnPress</a>' . esc_html__( ' plugin to be active.', 'doppler-for-learnpress' ) . '</p>';
		die( $error_message ); // WPCS: XSS ok.
	}
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

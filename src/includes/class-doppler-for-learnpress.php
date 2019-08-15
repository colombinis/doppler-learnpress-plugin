<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       www.fromdoppler.com
 * @since      1.0.0
 *
 * @package    Doppler_For_Learnpress
 * @subpackage Doppler_For_Learnpress/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Doppler_For_Learnpress
 * @subpackage Doppler_For_Learnpress/includes
 * @author     Doppler <hgalvan@makingsense.com>
 */
class Doppler_For_Learnpress {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Doppler_For_Learnpress_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;


	/**
	 * The service class.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $doppler_service;
	
	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		
		require_once( DOPPLER_PLUGINS_PATH . 'doppler-form\\includes\\DopplerApiClient\\DopplerService.php' );
		$this->doppler_service = new Doppler_Service();

		if ( defined( 'DOPPLER_FOR_LEARNPRESS_VERSION' ) ) {
			$this->version = DOPPLER_FOR_LEARNPRESS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'doppler-for-learnpress';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Doppler_For_Learnpress_Loader. Orchestrates the hooks of the plugin.
	 * - Doppler_For_Learnpress_i18n. Defines internationalization functionality.
	 * - Doppler_For_Learnpress_Admin. Defines all hooks for the admin area.
	 * - Doppler_For_Learnpress_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-doppler-for-learnpress-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-doppler-for-learnpress-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-doppler-for-learnpress-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-doppler-for-learnpress-public.php';

		$this->loader = new Doppler_For_Learnpress_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Doppler_For_Learnpress_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Doppler_For_Learnpress_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Doppler_For_Learnpress_Admin( $this->get_plugin_name(), $this->get_version(), $this->doppler_service );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'dplrlp_check_parent');
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		//$this->loader->add_action( 'admin_init', $plugin_admin, 'dplr_learnpress_settings_init' );
		$this->loader->add_action( 'dplr_add_extension_submenu', $plugin_admin, 'dplr_init_menu' );
		//$this->loader->add_action( 'wp_ajax_dplr_ajax_connect', $plugin_admin, 'dplr_api_connect' );
		//$this->loader->add_action( 'wp_ajax_dplr_ajax_get_lists', $plugin_admin, 'dplr_get_lists' );
		$this->loader->add_action( 'wp_ajax_dplr_ajax_save_list', $plugin_admin, 'dplr_save_list' );
		//$this->loader->add_action( 'wp_ajax_dplr_ajax_delete_list', $plugin_admin, 'dplr_delete_list' );
		$this->loader->add_action( 'wp_ajax_dplr_lp_ajax_synch', $plugin_admin, 'dplr_learnpress_synch' );
		$this->loader->add_action( 'wp_ajax_dplr_ajax_update_counter', $plugin_admin, 'update_subscribers_count' );
		//When customer subscribe to a course
		$this->loader->add_action( 'learn-press/payment-complete', $plugin_admin, 'dplr_after_customer_subscription' );
		//When order status changes (applys to new order and updated, becouse new order at first saves autodraft, and completed is an update)
		$this->loader->add_action( 'learn-press/order/status-changed', $plugin_admin, 'dplr_after_order_completed' );
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'show_admin_notice' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Doppler_For_Learnpress_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Doppler_For_Learnpress_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

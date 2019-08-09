<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.fromdoppler.com
 * @since      1.0.0
 *
 * @package    Doppler_For_Learnpress
 * @subpackage Doppler_For_Learnpress/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Doppler_For_Learnpress
 * @subpackage Doppler_For_Learnpress/admin
 * @author     Doppler <hgalvan@makingsense.com>
 */
class Doppler_For_Learnpress_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The service.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $doppler_service;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $doppler_service ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->doppler_service = $doppler_service;
		$this->connectionStatus = $this->check_connection_status();
		$this->success_message = false;
		$this->error_message = false;

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

	public function set_error_message($message) {
		$this->error_message = $message;
	}

	public function set_success_message($message) {
		$this->success_message = $message;
	}

	public function get_error_message() {
		return $this->error_message;
	}

	public function get_success_message() {
		return $this->success_message;
	}

	public function display_error_message() {
		if($this->get_error_message()!=''):
		?>
		<div id="displayErrorMessage" class="messages-container blocker">
			<p><?php echo $this->get_error_message(); ?></p>
		</div>
		<?php
		endif;
	}

	public function display_success_message() {
		if($this->get_success_message()!=''):
		?>
		<div id="displaySuccessMessage" class="messages-container info">
			<p><?php echo $this->get_success_message(); ?></p>
		</div>
		<?php
		endif;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'wp-jquery-ui-dialog' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/doppler-for-learnpress-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
    wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/doppler-for-learnpress-admin.js', array( 'jquery', 'jquery-ui-dialog'), $this->version, false );
	}

	/**
	 * Register the admin menu
	 * 
	 * @since 1.0.0
	 */
	public function dplr_init_menu() {
		add_submenu_page(
			'doppler_forms_menu',
			__('Doppler for LearnPress', 'dplr-learnpress'),
		    __('Doppler for LearnPress', 'dplr-learnpress'),
			'manage_options',
			'doppler_learnpress_menu',
			array($this, 'dplr_learnpress_admin')
		);	
	}

	/**
	 * Register the admin page
	 * 
	 * @since 1.0.0
	 */
	public function dplr_learnpress_admin() {
		include "partials/doppler-for-learnpress-admin-display.php";
	}

	public function check_connection_status() {

		$options = get_option('dplr_settings');
		
		if( empty($options) ){
			return false;
		}

		$user = $options['dplr_option_useraccount'];
		$key = $options['dplr_option_apikey'];

		if( !empty($user) && !empty($key) ){
			if(empty($this->doppler_service->config['crendentials'])){
				$this->doppler_service->setCredentials(array('api_key' => $key, 'user_account' => $user));
			}
			if( is_admin() ){ //... if we are at the backend.
				$response =  $this->doppler_service->connectionStatus();
				if( is_array($response) && $response['response']['code']>=400 ){
					 $this->admin_notice = array('error', '<strong>Doppler API Connection error.</strong> ' . $response['response']['message']);
					 return false;
				}
			}
			return true;
		}

		return false;

	}

	/**
	 * Shows user field.
	 * 
	 * @since 1.0.0
	 * 
	 */
	function display_user_field( $args ) {
		$option = get_option( 'dplr_learnpress_user' );
		?>
			<input type="email" value="<?php echo $option ?>" name="dplr_learnpress_user" />
		<?php
	}

	/**
	 * Shows API Key field
	 * 
	 * @since 1.0.0
	 * 
	 */
	function display_key_field( $args ) {
		$option = get_option( 'dplr_learnpress_key' );
		?>
			<input type="text" value="<?php echo $option ?>" name="dplr_learnpress_key" maxlength="32" />
		<?php
	}


	/**
	 * Synch subscribers
	 * 
	 * @since 1.0.0
	 */
	public function dplr_learnpress_synch(){
		$lists = get_option('dplr_subsribers_list');
		$list_id = $lists['buyers'];
		$user = get_option('dplr_learnpress_user');
		$key = get_option('dplr_learnpress_key');
		$items = array();

		if(empty($_POST['subscribers']) ||  empty($lists)){
			exit();
		}
		
		foreach($_POST['subscribers'] as $k=>$email){
			//$item['email'] = $email;
			//$item['fields'] = array();
			$items[] = array("email"=>$email, "fields" => array() );
		}
		
		$json = json_encode(array('items'=>$items, 'fields' => array()));
		
		// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
		$ch = curl_init();
		$api = 'https://restapi.fromdoppler.com/accounts/';
		$api = 'http://newapiqa.fromdoppler.net/accounts/';

		curl_setopt($ch, CURLOPT_URL, $api.$user.'/lists/'.$list_id.'/subscribers/import?api_key='.$key);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_POST, 1);

		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Accept: application/json';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close ($ch);
		echo '1';
		exit();
	}

		/**
	 * Subscribe customer to list after 
	 * course subscription from fromt-end
	 * 
	 * @since 1.0.0
	 */
	public function dplr_after_customer_subscription( $order_id ) {
		$order = new LP_Order( $order_id );
		$lists = get_option('dplr_subsribers_list');
		if(!empty($lists)){
			$list_id = $lists['buyers'];
			$order = new LP_Order( $order_id );
			$user_data = get_userdata($order->user_id);
			$user_email = $user_data->data->user_email;
			$this->subscribe_customer( $list_id, $user_email, array() );
		}
	}

	/**
	 * Subscribe customer/s to list after 
	 * course subscription from backend-end
	 * 
	 * @since 1.0.0
	 */
	public function dplr_after_order_completed( $order_id ){
		$order = new LP_Order( $order_id );
		if( $order->has_status( 'completed' ) && !$order->is_child() ){
			$users = get_post_meta( $order_id, '_user_id', true);
			if(!empty($users)){
				$lists = get_option('dplr_subsribers_list');
				$list_id = $lists['buyers'];
				if(is_array($users)){
					foreach($users as $k=>$user_id){
						$user_email = get_userdata($user_id)->data->user_email;
						$this->subscribe_customer( $list_id, $user_email, array() );
					}
				}else{
					  $user_id = $users;
						$user_email = get_userdata($user_id)->data->user_email;
						$resp = $this->subscribe_customer( $list_id, $user_email, array() );
				}				
			}
		}
	}

	/**
	* Update Subscribers count
	*
	* After synchronizing update 
	* the subscribers counter
	* next to the lists selector.
	* 
	* @since 1.0.0
	*/
	public function update_subscribers_count() {
		$b_count = 0;
		$this->doppler_service->setCredentials( $this->credentials );
		$list_resource = $this->doppler_service->getResource( 'lists' );

		$b_list_id = get_option('dplr_subsribers_list')['buyers'];
		if(!empty($b_list_id)){
			$b_count = $list_resource->getList($b_list_id)->subscribersCount;
		}
		echo json_encode(array('contacts'=>$c_count, 'buyers'=>$b_count));
		exit();
	}

	/**
	 * Get students who
	 * bougth courses and orders 
	 * are completed.
	 * 
	 * @since 1.0.0
	 */
  public function get_students(){
		global $wpdb;
		$query = "SELECT u.user_email, u.user_nicename FROM wp_posts p 
		JOIN wp_postmeta pm ON p.ID = pm.post_id
		JOIN wp_users u ON u.id = pm.meta_value
		WHERE p.post_type = 'lp_order'AND
		pm.meta_key = '_user_id'
		GROUP BY u.id
		";
		return  $wpdb->get_results($query);
	}

	/**
	 * Create a list.
	 * 
	 * @since 1.0.0
	 */
	public function dplr_save_list() {

		/**
		 * TODO: Validar nombre de la lista
		 * largo, mínimo, etc.
		 */
		if(!empty($_POST['listName'])){
			$this->doppler_service->setCredentials($this->credentials);
			$subscriber_resource = $this->doppler_service->getResource('lists');
			echo $subscriber_resource->saveList( $_POST['listName'] )['body'];
		}
		exit();

	}

	/**
	 * Get lists
	 * 
	 * @since 1.0.0
	 */
	public function get_alpha_lists() {
		$list_resource = $this->doppler_service->getResource('lists');
		$dplr_lists = $list_resource->getAllLists();
		if(is_array($dplr_lists)){
			foreach($dplr_lists as $k=>$v){
			  if(is_array($v)):
				foreach($v as $i=>$j){
				  $dplr_lists_aux[$j->listId] = array('name'=>trim($j->name), 'subscribersCount'=>$j->subscribersCount);
				}
			  endif;
			}
			$dplr_lists_arr = $dplr_lists_aux;
		}
		return $dplr_lists_arr;
	}

	/**
	 * Send email and fields to a Doppler List
	 * 
	 * @since 1.0.0
	 */
	private function subscribe_customer( $list_id, $email, $fields ){
		if( !empty($list_id) && !empty($email) ){
			$subscriber['email'] = $email;
			$subscriber['fields'] = $fields; 
			$this->doppler_service->setCredentials($this->credentials);
			$subscriber_resource = $this->doppler_service->getResource('subscribers');
			$result = $subscriber_resource->addSubscriber($list_id, $subscriber);
		}
	}

	/**
	 * Shows an admin message, 
	 * set $this->admin_notice = array( $class, $text), 
	 * where class is success, warning, etc.
	 * 
	 * @since 1.0.0
	 * 
	 */
	public function show_admin_notice() {	
		$class = $this->admin_notice[0];
		$text = $this->admin_notice[1];
		if( !empty($class) && !empty($class) ){
			?>
				<div class="notice notice-<?php echo $class?> is-dismissible">
					<p><?php echo $text ?></p>
				</div>
			<?php
		}
	}

}
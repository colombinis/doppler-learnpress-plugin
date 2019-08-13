<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       www.fromdoppler.com
 * @since      1.0.0
 *
 * @package    Doppler_For_Learnpress
 * @subpackage Doppler_For_Learnpress/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php

 if ( ! current_user_can( 'manage_options' ) ) {
 return;
 }

 if( isset($_GET['tab']) ) {
    $active_tab = $_GET['tab'];
 }else{
    $active_tab = 'settings';
 } 

 $connected = $this->connectionStatus;

 ?>

<div class="wrap dplr_settings">

    <a href="<?php _e('https://www.fromdoppler.com/en/?utm_source=landing&utm_medium=integracion&utm_campaign=wordpress', 'doppler-for-learnpress')?>" target="_blank" class="dplr-logo-header"><img src="<?php echo DOPPLER_PLUGINS_URL?>/admin/img/logo-doppler.svg" alt="Doppler logo"/></a>
    <h2 class="main-title"><?php _e('Doppler for LearnPress', 'doppler-for-learnpress')?> <?php echo $this->get_version()?></h2> 

    <h1 class="screen-reader-text"></h1>

    <?php

    switch($active_tab){

        case 'mapping':
            /*   
            $lists = $this->get_alpha_lists();
            $subscribers_lists = get_option('dplr_subsribers_list');
            require_once('lists.php');
            */
            break;
        default:

            if( isset($_POST['dplr_learnpress_subscribers_list']) && current_user_can('manage_options') && check_admin_referer('map-lists') ){
                update_option( 'dplr_learnpress_subscribers_list', $_POST['dplr_learnpress_subscribers_list'] );
                $this->set_success_message(__('Subscribers list saved succesfully', 'doppler-for-woocommerce'));
            }

            $lists = $this->get_alpha_lists();
            $subscribers_lists = get_option('dplr_learnpress_subscribers_list');
            require_once('sync.php');
            break;
    }

    ?>
    
</div>
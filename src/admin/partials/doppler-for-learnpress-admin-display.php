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

<div class="wrap doppler-learnpress-settings">

    <h2 class="main-title"><?php _e('Doppler for LearnPress', 'doppler-for-learnpress')?> <?php echo $this->get_version()?></h2> 

    <h2 class="nav-tab-wrapper">
        <a href="?page=dplr_learnpress_menu&tab=settings" class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>"><?php _e('Settings', 'doppler-for-learnpress')?></a>
        <?php if ($connected) :?>
            <!--
                <a href="?page=dplr_learnpress_menu&tab=fields" class="nav-tab <?php echo $active_tab == 'fields' ? 'nav-tab-active' : ''; ?>"><?php _e('Fields', 'doppler-for-learnpress')?></a>
            -->
            <!--
            <a href="?page=dplr_learnpress_menu&tab=lists" class="nav-tab <?php echo $active_tab == 'lists' ? 'nav-tab-active' : ''; ?>"><?php _e('Lists subscriptions', 'doppler-for-learnpress')?></a>
            -->
            <a href="?page=dplr_learnpress_menu&tab=sync" class="nav-tab <?php echo $active_tab == 'sync' ? 'nav-tab-active' : ''; ?>"><?php _e('Synchronize students', 'doppler-for-learnpress')?></a>
            <a href="?page=dplr_learnpress_menu&tab=lists_crud" class="nav-tab <?php echo $active_tab == 'lists_crud' ? 'nav-tab-active' : ''; ?>"><?php _e('Manage Lists', 'doppler-for-learnpress')?></a>
        <?php endif; ?>
    </h2>

    <h1 class="screen-reader-text"></h1>

    <?php

    switch($active_tab){

        case 'lists':
            /*   
            $lists = $this->get_alpha_lists();
            $subscribers_lists = get_option('dplr_subsribers_list');
            require_once('lists.php');
            break;
            */
        case 'lists_crud':
                
            $lists = $this->get_alpha_lists();
            require_once('lists_crud.php');
            break;

        case 'fields':
            /*
            $wc_fields = $this->get_checkout_fields();
            $this->doppler_service->setCredentials($this->credentials);
            $fields_resource = $this->doppler_service->getResource('fields');
            $dplr_fields = $fields_resource->getAllFields();
            $dplr_fields = isset($dplr_fields->items) ? $dplr_fields->items : [];
            $maps = get_option('dplrwoo_mapping');
            require_once('mapping.php');
            */
            break;
        case 'sync':
            $lists = $this->get_alpha_lists();
            $subscribers_lists = get_option('dplr_subsribers_list');
            if(!empty($subscribers_lists)){
                $students = $this->get_students();
            }
            require_once('sync.php');
            break;

        default:
            require_once('settings.php');
            break;
    }

    ?>
    
</div>
<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$scount = '';

?>

<div class="dplr-tab-content" style="max-width: 600px">

    <?php $this->display_success_message() ?>

    <?php $this->display_error_message() ?>

    <div id="showSuccessResponse" class="messages-container info d-none">
    </div>

    <div id="showErrorResponse" class="messages-container blocker d-none">
    </div>
    <form id="dplr-lp-form-list" action="" method="post">

        <?php wp_nonce_field( 'map-lists' );?>   

        <p>
         <input type="checkbox" value="1" name="dplr_learnpress_enabled" <?php if($dplr_enabled) echo 'checked' ?>/> <label class="d-inline-block"><?php _e('Enable Doppler for LearnPress', 'doppler-for-learnpress') ?></label>
        </p>         

        <hr/>

        <p><?php _e('Select the list you want to populate.', 'doppler-for-learnpress') ?></p>

        <p>
            <label><?php _e('Doppler List to send Customers') ?></label>
            <select name="dplr_learnpress_subscribers_list[buyers]" class="dplr-lp-lists">
            <?php 
            if(!empty($lists)){
                foreach($lists as $k=>$v){
                    ?>
                    <option value="<?php echo esc_attr($k)?>" 
                        <?php if($subscribers_lists['buyers']==$k){ echo 'selected'; $scount = $v['subscribersCount']; } ?>
                        data-subscriptors="<?php echo esc_attr($v['subscribersCount'])?>">
                        <?php echo esc_html($v['name'])?>
                    </option>
                    <?php
                }
            }   
            ?>
            </select>
        </p>

        <p>
            <label><?php _e('Syncrhonize Customers', 'doppler-for-learnpress') ?></label>
            <button id="btn-lp-synch" class="dp-button button-small"><?php _e('Sync', 'doppler-for-learnpress')?>
                <img class="doing-synch d-none" src="<?php echo DOPPLER_FOR_LEARNPRESS_URL . 'admin/img/ajax-synch.gif' ?>" alt="<?php _e('Synchronizing', 'doppler-for-learnpress')?>"/>
            </button>
            <span class="synch-ok dashicons dashicons-yes text-dark-green opacity-0"></span>
            <i class="text-small ml-1">Last synch: 04-22-2019 hh:mm:ss</i>
        </p>
<!--
        <table class="grid panel w-100" cellspacing="0">
            
            <thead>
                <tr class="panel-header">
                <th class="text-white semi-bold"><?php _e('Type', 'doppler-for-learnpress') ?></th>
                    <th class="text-white semi-bold"><?php _e('List Name', 'doppler-for-learnpress') ?></th>
                    <th class="text-white semi-bold"><?php _e('Subscriptors', 'doppler-for-learnpress')?></th>
                </tr>
            </thead>
            <tbody class="panel-body">
                <tr>
                    <th>
                        <?php _e('Enrolled students', 'doppler-for-learnpress')?>
                    </th>
                    <td>
                        <select name="dplr_learnpress_subscribers_list[buyers]" class="dplr-lp-lists">
                            <option value=""></option>
                            <?php 
                            if(!empty($lists)){
                                foreach($lists as $k=>$v){
                                    ?>
                                    <option value="<?php echo esc_attr($k)?>" 
                                        <?php if($subscribers_lists['buyers']==$k){ echo 'selected'; $scount = $v['subscribersCount']; } ?>
                                        data-subscriptors="<?php echo esc_attr($v['subscribersCount'])?>">
                                        <?php echo esc_html($v['name'])?>
                                    </option>
                                    <?php
                                }
                            }   
                            ?>
                        </select>
                    </td>
                    <td class="text-center td-sm">
                        <span class="buyers-count"><?php echo $scount?></span>
                    </td>
                </tr>
            </tbody>
        </table> -->

        <hr/>

        <p class="text-right" style="text-align: right">
        
            <button id="dplr-lp-lists-btn" class="dp-button button-medium primary-green">
                <?php _e('Save config', 'doppler-for-learnpress') ?>
            </button>

        </p>

    </form>

    <!--
    <hr/>

    <a id="btn-lp-synch" class="small-text pointer green-link"><?php _e('Synchronize', 'doppler-for-learnpress')?></a>
    <img class="doing-synch d-none" src="<?php echo DOPPLER_FOR_LEARNPRESS_URL . 'admin/img/ajax-synch.gif' ?>" alt="<?php _e('Synchronizing', 'doppler-for-learnpress')?>"/>
    <span class="synch-ok dashicons dashicons-yes text-dark-green opacity-0"></span> -->

</div>
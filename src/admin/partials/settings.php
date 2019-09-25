<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<div class="dplr-tab-content">

    <?php $this->display_success_message() ?>

    <?php $this->display_error_message() ?>

    <div id="showSuccessResponse" class="messages-container info d-none">
    </div>

    <div id="showErrorResponse" class="messages-container blocker d-none">
    </div>

    <div class="d-flex flex-row">

        <div class="flex-grow-1">
            <p class="size-medium" id="dplr-settings-text">
                <?php
                if(!empty($subscribers_lists['buyers'])){
                    _e('Your Customers will be sent automatically to the selected Doppler List when enrolling to a Course.', 'doppler-for-learnpress');
                }else{
                    if(empty($lists)){
                        _e('Currently you don’t have any list in Doppler, create a New List by entering a list name and pressing Create List.','doppler-for-learnpress');

                    }else{
                        _e('Select the list you want to populate.', 'doppler-for-learnpress');
                    }
                }
                ?>
            </p>
        </div>
        <div class="flex-grow-1">
            <form id="dplr-form-list-new" class="text-right" action="" method="post">

                <input type="text" value="" class="d-inline-block"  maxlength="100" placeholder="<?php _e('Write the List name', 'doppler-for-woocommerce')?>"/>

                <button id="dplrlp-save-list" class="dp-button dp-button--inline button-medium primary-green" disabled="disabled">
                    <?php _e('Create List', 'doppler-form') ?>
                </button>

            </form>
        </div>
        
    </div>

    <form id="dplr-lp-form-list" action="" method="post">

        <?php wp_nonce_field( 'map-lists' );?>         
        <p>
            <label><?php _e('Doppler List to send Customers') ?></label>
            <select name="dplr_learnpress_subscribers_list[buyers]" class="dplr-lp-lists">
            <option value=""><?php _e('Select a List to connect with Doppler', 'doppler-for-learnpress')?></option>
            <?php 
            if(!empty($lists)){
                foreach($lists as $k=>$v){
                    ?>
                    <option value="<?php echo esc_attr($k)?>" 
                        <?php if(!empty($subscribers_lists['buyers']) && $subscribers_lists['buyers']==$k) echo 'selected' ?>
                        data-subscriptors="<?php echo esc_attr($v['subscribersCount'])?>">
                        <?php echo esc_html($v['name'])?>
                    </option>
                    <?php
                }
            }   
            ?>
            </select>
        </p>

        <p class="d-flex justify-end">

            <button id="dplr-lp-clear" class="dp-button button-medium primary-grey" <?php echo empty($subscribers_lists['buyers'])? 'disabled' : '' ?>>
                <?php _e('Clear selection', 'doppler-for-learnpress') ?>
            </button>
        
            <button id="dplr-lp-lists-btn" class="dp-button button-medium primary-green ml-1" disabled>
                <?php _e('Synchronize', 'doppler-for-learnpress') ?>
            </button>

        </p>

    </form>

</div>
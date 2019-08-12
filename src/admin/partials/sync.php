<div class="dplr-tab-content">

    <?php $this->display_success_message() ?>

    <?php $this->display_error_message() ?>

    <div id="showSuccessResponse" class="messages-container info">
    </div>

    <div id="showErrorResponse" class="messages-container blocker">
    </div>

    <form id="dplr-form-list" action="" method="post">

        <?php wp_nonce_field( 'map-lists' );?>

       
        <p><?php _e('Select the list you want to populate.', 'doppler-for-learnpress') ?></p>
            

        <table class="grid panel w-100" cellspacing="0">
            
            <thead>
                <tr class="panel-header">
                <th class="text-white semi-bold"><?php _e('Type', 'dplr-learnpress') ?></th>
                    <th class="text-white semi-bold"><?php _e('List Name', 'dplr-learnpress') ?></th>
                    <th class="text-white semi-bold"><?php _e('Subscriptors', 'dplr-learnpress')?></th>
                </tr>
            </thead>
            <tbody class="panel-body">
                <tr>
                    <th>
                        <?php _e('Buyers', 'doppler-for-learnpress')?>
                    </th>
                    <td>
                        <select name="dplr_learnpress_subscriberes_list[buyers]">
                            <option value=""></option>
                            <?php 
                            if(!empty($lists)){
                                foreach($lists as $k=>$v){
                                    ?>
                                    <option value="<?php echo $k?>" 
                                        <?php if($subscribers_lists['buyers']==$k){ echo 'selected'; $scount = $v['subscribersCount']; } ?>
                                        data-subscriptors="<?php echo $v['subscribersCount']?>">
                                        <?php echo $v['name']?>
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
        </table>

        <button id="dplr-lists-btn" class="dp-button button-medium primary-green">
            <?php _e('Save', 'doppler-for-learnpress') ?>
        </button>

    </form>

    <hr/>

    <a id="btn-synch" class="small-text pointer green-link"><?php _e('Synchronize', 'doppler-for-learnpress')?></a>
    <img class="doing-synch d-none" src="<?php echo DOPPLER_FOR_LEARNPRESS_URL . 'admin/img/ajax-synch.gif' ?>" alt="<?php _e('Synchronizing', 'doppler-for-learnpress')?>"/>
    <span class="synch-ok dashicons dashicons-yes text-dark-green opacity-0"></span>

</div>
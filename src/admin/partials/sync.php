<div class="dplr-tab-content">

    <form id="dplr-form-list" action="" method="post">

        <?php wp_nonce_field( 'map-lists' );?>

        <?php
        if(empty($subscribers_lists['buyers'])){
            ?>
            <p>Please select the list where you want to subscribe your students.</p>
            <?php
        }
        ?>

        <table class="grid">
            
            <tbody>

                <tr>
                    <th colspan="2"></th>
                    <th class="text-right td-sm"><?php _e('Subscriptors', 'doppler-for-learnpress')?></th>
                    <th></th>
                </tr>

                <tr>
                    <th>
                        <?php _e('Buyers', 'doppler-for-learnpress')?>
                    </th>
                    <td>
                        <select name="dplr_subsribers_list[buyers]">
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
                    <td class="text-right td-sm">
                        <span class="buyers-count"><?php echo $scount?></span>
                    </td>
                    <td>
                    </td>
                </tr>

            </tbody>

        </table>

        <button id="dplr-lists-btn" class="dplr-button">
            <?php _e('Save', 'doppler-for-learnpress') ?>
        </button>

    </form>

    <hr/>

    <?php
    if(!empty($subscribers_lists['buyers'])):
        if(!empty($students)){
            ?>
                <h4><?php _e('Total LearnPress students', 'doppler-for-learnpress')?>: <span>(<?php echo count($students)?>)</span> <a id="view-students-list">View</a></h4>
                <div id="students-frame">
                    <?php
                    $cont = 0;
                    foreach($students as $k=>$student){
                        $cont++;
                        echo '#'.$cont.' - '.$student->user_nicename.', '.$student->user_email.'<br>';
                        ?>
                        <input class="subscribers-item" type="hidden" name="subscribers[]" value="<?php echo $student->user_email?>"/>
                        <?php
                    } 
                    ?>
                </div>
            <?php 
        }
    ?>
        <button id="btn-synch" class="pointer dplr-button dplr-button--alt"><?php _e('Synchronize', 'doppler-for-learnpress')?></button>
        <img class="doing-synch" src="<?php echo DOPPLER_FOR_LEARNPRESS_URL . 'admin/img/ajax-synch.gif' ?>" alt="<?php _e('Synchronizing', 'doppler-for-learnpress')?>"/>
        <span class="doing-synch"><?php _e('Synchronizing students', 'doppler-for-learnpress')?>...</span>
        <span class="synch-ok dashicons dashicons-yes text-dark-green"></span>
        <span class="synch-ok text-dark-green"><?php _e('Synchronization has ended!', 'doppler-for-learnpress')?></span>
    <?php
    endif;
    ?>

</div>
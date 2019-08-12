<div class="dplr-tab-content">

<?php 
    
    if(!$connected){

        ?>

        <form id="dplr-form-connect" action="options.php" method="post" easy-validate>
            
            <?php
            settings_fields( 'dplr_learnpress_menu' );
            do_settings_sections( 'dplr_learnpress_menu' );
            ?>

            <button id="dplr-connect" class="dplr-button dplr-button--rounded">
                <div class="loading"></div>
                <span><?php _e('Connect', 'doppler-for-learnpress') ?></span>
            </button>

            <div id="dplr-messages" class="mt-30 text-red">
            </div>

        </form>

        <?php

    }else if($connected){
        
        ?>
        <form id="dplr-form-disconnect" action="options.php" method="post">

            <?php settings_fields( 'dplr_learnpress_menu' ); ?>

            <input type="hidden" name="dplr_learnpress_user" value="" />
            <input type="hidden" name="dplr_learnpress_key" value="" />

            <div class="connected-status">
                <p>
                    <?php _e('You\'re connetcted to Doppler') ?>
                </p>
                <p>
                User Email: <strong><?php echo get_option('dplr_learnpress_user')?></strong> <br />
                Api Key: <strong><?php echo get_option('dplr_learnpress_key')?></strong>
                </p>
            </div>

            <button id="dplr-disconnect" class="dplr-button">
                <?php _e('Disconnect', 'doppler-for-learnpress') ?>
            </button>

        </form>

        <?php
    }

?>

</div>
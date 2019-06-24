<div id="dplr-crud" class="dplr-tab-content">

    <form id="dplr-form-list-crud" action="" method="post">

        <label><?php _e('Create new List')?></label>
        <input type="text" value="" maxlength="20" disabled="disabled" maxlength="100" placeholder="<?php _e('Enter List name', 'doppler-for-learnpress')?>"/>

        <button id="dplr-save-list" class="dplr-button" disabled="disabled">
            <?php _e('Create list', 'doppler-for-learnpress') ?>
        </button>

    </form>

    <div class="dplr-loading"></div>

    <table id="dplr-tbl-lists" class="grid widefat mt-30">
        <thead>
            <tr>
                <th><?php _e('List ID', 'doppler-for-learnpress')?></th>
                <th><?php _e('Name', 'doppler-for-learnpress')?></th>
                <th><?php _e('Subscribers', 'doppler-for-learnpress')?></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

</div>

<div id="dplr-dialog-confirm" title="<?php _e('Are you sure you want to delete the List? ', 'doppler-for-learnpress'); ?>">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span> <?php _e('It\'ll be deleted and can\'t be recovered.', 'doppler-for-learnpress')?></p>
</div>
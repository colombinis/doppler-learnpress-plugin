<?php
$courses = $this->get_courses();
$courses_map = get_option('dplr_learnpress_courses_map');
$actions = array(   '1'=> __('Student subscribes to course', 'doppler-for-learnpress'),
                    '2'=>  __('Student finishes course', 'doppler-for-learnpress'));
?>
<hr>

<form id="course-mapping-form">
    <label><?php _e('Courses Mapping','doppler-for-learnpress') ?></label>
    <p>
        Lorem ipsum
    </p>
    <p>
        <select id="map-course" class="ml-0">
            <option value=""><?php _e('Select course','doppler-for-learnpress')?></option>
            <?php
                if(!empty($courses)){
                    foreach($courses as $course):
                    ?>
                        <option value="<?php echo $course->ID?>">
                            <?php echo $course->post_title?>
                        </option>
                    <?php
                    endforeach;
                }
            ?>
        </select>

        <select id="map-list">
            <option value=""><?php _e('Select List','doppler-for-learnpress')?></option>
            <?php
                if(!empty($lists)){
                    foreach($lists as $k=>$v):
                    ?>
                        <option value="<?php echo esc_attr($k)?>">
                            <?php echo esc_html($v['name'])?>
                        </option>
                    <?php
                    endforeach;
                } 
            ?>
        </select>

        <select id="map-action">
            <option value=""><?php _e('Select condition','doppler-for-learnpress')?></option>
            <?php
            foreach($actions as $k=>$v):
                ?>
                    <option value="<?php echo esc_attr($k)?>">
                        <?php echo esc_html($v)?>
                    </option>
                <?php
            endforeach;
            ?>
        </select>

        <button class="dp-button dp-button--inline button-medium primary-green ml-1" disabled><?php _e('Associate List', 'doppler-for-learnpress')?></button>
    </p>
</form>

<table id="associated-lists-tbl" class="fixed widefat <?php if(empty($courses_map)) echo 'd-none'?>">
    <thead>
        <tr>
            <th><?php _e('Course', 'doppler-for-learnpress')?></th>
            <th><?php _e('Associated List', 'doppler-for-learnpress')?></th>
            <th><?php _e('Action', 'doppler-for-learnpress')?></th>
            <th class="tool-col"></th>
        </tr>
    </thead>
    <tbody>
<?php
    if(!empty($courses_map)):
        foreach($courses_map as $key=>$value):
            $list_id = $value['list_id'];
            $action_id = $value['action_id'];
            $course_post = get_post($value['course_id']);
            ?>
                <tr>
                    <td><?php echo $course_post->post_title ?></td>
                    <td><?php echo isset($lists[$list_id])?$lists[$list_id]['name']:__('Warning: list is missing', 'doppler-for-learnpress')?></td>
                    <td><?php echo $actions[$action_id]?></td>
                    <td><a class="pointer" data-assoc="<?php echo $value['course_id']?>-<?php echo $action_id?>">Delete</a></td>
                </tr>
            <?php
        endforeach;
    endif;
?>
    </tbody>
</table>

<div id="dplr-lp-dialog-confirm" title="<?php _e('Are you sure? ', 'doppler-for-learnpress'); ?>">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span> <?php _e('If you proceed, the Course will no longer send subscriptors to the List.', 'doppler-for-learnpress')?></p>
</div>
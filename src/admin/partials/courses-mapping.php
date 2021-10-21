<?php
$courses = $this->get_courses();
$courses_map = get_option('dplr_learnpress_courses_map');
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

        <button class="dp-button dp-button--inline button-medium primary-green ml-1" disabled><?php _e('Associate List', 'doppler-for-learnpress')?></button>
    </p>
</form>

<?php //var_dump($courses_map) ?>
<table id="associated-lists-tbl" class="fixed widefat <?php if(empty($courses_map)) echo 'd-none'?>">
    <thead>
        <tr>
            <th><?php _e('Course', 'doppler-for-learnpress')?></th>
            <th><?php _e('Associated List', 'doppler-for-learnpress')?></th>
            <th colspan="2" class="tool-col"></th>
        </tr>
    </thead>
    <tbody>
<?php
    if(!empty($courses_map)):
    foreach($courses_map as $k=>$value):
        ?>
        <tr>
            <td><?php print_r($value); echo get_post($value[0])->post_title ?></td>
            <td><?php echo $lists[$value[1]]?></td>
            <td><a class="pointer">Sync</a></td>
            <td><a class="pointer">Delete</a></td>
        </tr>
        <?php
    endforeach;
    endif;
?>
    </tbody>
</table>
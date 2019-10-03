<?php
$courses = $this->get_courses();
?>

<hr>

<form id="course-mapping-form">
    <label><?php _e('Courses Mapping','doppler-for-learnpress') ?></label>
    <p>
        Lorem ipsum
    </p>
    <p>
        <select class="ml-0">
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

        <select>
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

        <button class="dp-button button-medium primary-green ml-1"><?php _e('Associate List', 'doppler-for-learnpress')?></button>
    </p>
</form>
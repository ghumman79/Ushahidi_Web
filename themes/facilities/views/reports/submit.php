<div id="middle" class="scroll">
    <div id="content">
        <?php print form::open(NULL, array('enctype' => 'multipart/form-data', 'id' => 'reportForm', 'name' => 'reportForm', 'class' => 'gen_forms')); ?>
        <input type="hidden" name="latitude" id="latitude" value="<?php echo $form['latitude']; ?>">
        <input type="hidden" name="longitude" id="longitude" value="<?php echo $form['longitude']; ?>">
        <input type="hidden" name="country_name" id="country_name" value="<?php echo $form['country_name']; ?>" />
        <input type="hidden" name="incident_zoom" id="incident_zoom" value="<?php echo $form['incident_zoom']; ?>" />

        <h1><?php echo Kohana::lang('ui_main.reports_submit_new'); ?></h1>
        <?php if ($form_error): ?>
        <div class="red-box">
            <h3><?php echo Kohana::lang('ui_main.error'); ?></h3>
            <ul>
                <?php
                foreach ($errors as $error_item => $error_description) {
                    print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
                }
                ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if ($site_submit_report_message != ''): ?>
        <div class="green-box">
            <h3><?php echo $site_submit_report_message; ?></h3>
        </div>
            <?php endif; ?>

        <input type="hidden" name="form_id" id="form_id" value="<?php echo $id?>">

        <div class="column">
            <?php if(count($forms) > 1){ ?>
               <div class="box">
                   <label><?php echo Kohana::lang('ui_main.select_form_type');?></label>
                   <span><?php print form::dropdown('form_id', $forms, $form['form_id'],
                       ' onchange="formSwitch(this.options[this.selectedIndex].value, \''.$id.'\')"') ?></span>
               </div>
            <?php } ?>
            <div class="box">
                <label><b class="required">*</b>&nbsp;<?php echo Kohana::lang('ui_main.reports_title'); ?></label>
                <span><?php print form::input('incident_title', $form['incident_title'], ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.reports_title')) . '" '); ?></span>
            </div>

            <br/>

            <div class="box">
                <label><b class="required">*</b>&nbsp;<?php echo Kohana::lang('ui_main.reports_description'); ?></label>
                <span><?php print form::textarea('incident_description', $form['incident_description'], ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.reports_description')) . '" ') ?></span>
            </div>

            <br/>

            <div class="box">
                <label><b class="required">*</b>&nbsp;<?php echo Kohana::lang('ui_main.reports_date'); ?></label>
                <span class="date">
                    <?php print form::input('incident_date', $form['incident_date'], ' class="text"'); ?>
                    <script type="text/javascript">
                        $().ready(function() {
                            $("#incident_date").datepicker({
                                showOn: "both",
                                buttonImage: "<?php echo url::file_loc('img'); ?>media/img/icon-calendar.gif",
                                buttonImageOnly: true
                            });
                        });
                    </script>
                </span>
            </div>

            <br/>

            <div class="box">
                <label><b class="required">*</b>&nbsp;<?php echo Kohana::lang('ui_main.reports_time'); ?></label>
                <span class="time">
                  <?php
                    for ($i=1; $i <= 12 ; $i++) {
                        $hour_array[sprintf("%02d", $i)] = sprintf("%02d", $i);	 // Add Leading Zero
                    }
                    for ($j=0; $j <= 59 ; $j++) {
                        $minute_array[sprintf("%02d", $j)] = sprintf("%02d", $j);	// Add Leading Zero
                    }
                    $ampm_array = array('pm'=>'pm','am'=>'am');
                    print form::dropdown('incident_hour',$hour_array,$form['incident_hour']);
                    print '<b> : </b>';
                    print form::dropdown('incident_minute',$minute_array,$form['incident_minute']);
                    print '<b> : </b>';
                    print form::dropdown('incident_ampm',$ampm_array,$form['incident_ampm']);
                    ?>
                </span>
            </div>

            <br/>

            <div id="submit-categories" class="box">
                <label><b class="required">*</b>&nbsp;<?php echo Kohana::lang('ui_main.reports_categories'); ?></label>
                <span>
                    <?php foreach ($categories as $category): ?>
                    <?php if($category->category_visible == 1) { ?>
                        <ul class="horizontal">
                            <li class="parent">
                                <?php print form::checkbox('incident_category[]', $category->id, false); ?>
                                <?php echo $category->category_title; ?>
                            </li>
                            <?php foreach ($category->children as $child) { ?>
                            <li>
                                <?php print form::checkbox('incident_category[]', $child->id, false); ?>
                                <?php echo $child->category_title; ?>
                            </li>
                            <?php }  ?>
                        </ul>
                        <?php } ?>
                    <?php endforeach; ?>


                </span>
            </div>

            <?php Event::run('ushahidi_action.report_form'); ?>

            <br/>

            <?php echo $custom_forms ?>

            <div class="box" >
                <h3><?php echo Kohana::lang('ui_main.reports_optional'); ?></h3>

                <label><?php echo Kohana::lang('ui_main.reports_first'); ?></label>
                <span><?php print form::input('person_first', $form['person_first'], ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.reports_first')) . '" '); ?></span><br/>

                <label><?php echo Kohana::lang('ui_main.reports_last'); ?></label>
                <span><?php print form::input('person_last', $form['person_last'], ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.reports_last')) . '" '); ?></span><br/>


                <label><?php echo Kohana::lang('ui_main.reports_email'); ?></label>
                <span><?php print form::input('person_email', $form['person_email'], ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.reports_email')) . '" '); ?></span><br/>

                <?php Event::run('ushahidi_action.report_form_optional'); ?>
            </div>

            <br/>

        </div>

        <div class="column">
            <div class="box">
                <?php if ( ! $multi_country AND count($cities) > 1): ?>
                    <label><?php echo Kohana::lang('ui_main.location'); ?></label>
                    <span> <?php print form::dropdown('select_city',$cities,'', ' class="select" '); ?></span><br/>
                <?php endif; ?>
                <div id="divMap" class="report-map"></div>
                <div class="location-left">
                    <div>
                        <?php print form::input('location_find', '', ' title="'.Kohana::lang('ui_main.location_example').'" class="findtext"'); ?>
                    </div>
                </div>
                <div class="location-right">
                    <input type="button" name="button" id="button" value="<?php echo Kohana::lang('ui_main.find_location'); ?>" class="button" />
                    <div id="find_loading" class="report-find-loading"></div>
                </div>
                <div class="clear"></div>
            </div>
            <?php Event::run('ushahidi_action.report_form_location', $id); ?>

            <br/>

            <div class="box">
                <label><?php echo Kohana::lang('ui_main.reports_location_name'); ?></label>
                <span><?php print form::input('location_name', $form['location_name'], ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.detailed_location_example')) . '" '); ?></span>
            </div>

            <br/>

            <div id="submit-news" class="box">
                <label><?php echo Kohana::lang('ui_main.reports_news'); ?></label>
                <?php
                $this_parent = "submit-news";
                $this_field = "incident_news";
                $this_start = "news_id";
                $this_type = "text";
                if (empty($form[$this_field])) {
                    $i = 1;
                    print "<span class=\"dynamic\">";
                    print form::input($this_field . '[]', '', ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.url')) . '" ');
                    print "<a href=\"#\" class=\"button dynamic-add\" onClick=\"addFormField('$this_parent','$this_field','$this_start','$this_type'); return false;\">+</a>";
                    print "</span>";
                }
                else {
                    $i = 0;
                    foreach ($form[$this_field] as $value) {
                        print "<label id=\"label_$i\"></label><span id=\"$i\" class=\"dynamic\">\n";
                        print form::input($this_field . '[]', $value, ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.url')) . '" ');
                        print "<a href=\"#\" class=\"button dynamic-add\" onClick=\"addFormField('$this_parent','$this_field','$this_start','$this_type'); return false;\">+</a>";
                        if ($i != 0) {
                            print "<a href=\"#\" class=\"button dynamic-remove\" onClick='removeFormField(\"#" . $this_field . "_" . $i . "\"); removeFormField(\"#label_" . $this_field . "_" . $i . "\"); return false;'>-</a>";
                        }
                        print "</span>\n";
                        $i++;
                    }
                }
                print "<input type=\"hidden\" name=\"$this_start\" value=\"$i\" id=\"$this_start\">";
                ?>
            </div>

            <br/>

            <div id="submit-video" class="box">
                <label><?php echo Kohana::lang('ui_main.external_video_link'); ?></label>
                <?php
                $this_parent = "submit-video";
                $this_field = "incident_video";
                $this_start = "video_id";
                $this_type = "text";
                if (empty($form[$this_field])) {
                    $i = 1;
                    print "<span class=\"dynamic\">";
                    print form::input($this_field . '[]', '', ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.url')) . '" ');
                    print "<a href=\"#\" class=\"button dynamic-add\" onClick=\"addFormField('$this_parent','$this_field','$this_start','$this_type'); return false;\">+</a>";
                    print "</span>";
                }
                else {
                    $i = 0;
                    foreach ($form[$this_field] as $value) {
                        print "<label id=\"label_$i\"></label><span id=\"$i\" class=\"dynamic\">\n";
                        print form::input($this_field . '[]', $value, ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.url')) . '" ');
                        print "<a href=\"#\" class=\"button dynamic-add\" onClick=\"addFormField('$this_parent','$this_field','$this_start','$this_type'); return false;\">+</a>";
                        if ($i != 0) {
                            print "<a href=\"#\" class=\"button dynamic-remove\" onClick='removeFormField(\"#" . $this_field . "_" . $i . "\"); removeFormField(\"#label_" . $this_field . "_" . $i . "\"); return false;'>-</a>";
                        }
                        print "</span>\n";
                        $i++;
                    }
                }
                print "<input type=\"hidden\" name=\"$this_start\" value=\"$i\" id=\"$this_start\">";
                ?>
            </div>
            <?php Event::run('ushahidi_action.report_form_after_video_link'); ?>
            <br/>
            <div id="submit-photo" class="box">
                <label><?php echo Kohana::lang('ui_main.reports_photos'); ?></label>
                <?php
                $this_parent = "submit-photo";
                $this_field = "incident_photo";
                $this_start = "photo_id";
                $this_type = "file";
                if (empty($form[$this_field]['name'][0])) {
                    $i = 1;
                    print "<span class=\"dynamic\">";
                    print form::upload($this_field . '[]', '', ' class="file"');
                    print "<a href=\"#\" class=\"button dynamic-add\" onClick=\"addFormField('$this_parent','$this_field','$this_start','$this_type'); return false;\">+</a>";
                    print "</span>";
                }
                else {
                    $i = 0;
                    foreach ($form[$this_field]['name'] as $value) {
                        print "<label id=\"label_$i\"></label><span id=\"$i\" class=\"dynamic\">\n";
                        print form::upload($this_field . '[]', $value, ' class="file long2"');
                        print "<a href=\"#\" class=\"button dynamic-add\" onClick=\"addFormField('$this_parent','$this_field','$this_start','$this_type'); return false;\">+</a>";
                        if ($i != 0)
                        {
                            print "<a href=\"#\" class=\"button dynamic-remove\" onClick='removeFormField(\"#" . $this_field . "_" . $i . "\"); return false;'>-</a>";
                        }
                        print "</span>\n";
                        $i++;
                    }
                }
                print "<input type=\"hidden\" name=\"$this_start\" value=\"$i\" id=\"$this_start\">";
                ?>
            </div>
            <br/>
            <div class="box">
                <input name="submit" type="submit" class="button" value="<?php echo Kohana::lang('ui_main.reports_btn_submit'); ?>" />
            </div>
        </div>
       <?php print form::close(); ?>
    </div>
</div>
<script type="text/javascript">
    function addFormField(parent, field, hidden, type) {
        var id = document.getElementById(hidden).value;
        $("#" + parent).append("<label id=\"label_" + field + "_" + id + "\"></label><span class=\"dynamic\" id=\"" + field + "_" + id + "\">" +
            "<input type=\"" + type + "\" name=\"" + field + "[]\" class=\"" + type + " \" />" +
            "<a href=\"#\" class=\"button dynamic-add\" onClick=\"addFormField('" + parent + "','" + field + "','" + hidden + "','" + type + "'); return false;\">+</a>" +
            "<a href=\"#\" class=\"button dynamic-remove\"  onClick='removeFormField(\"#" + field + "_" + id + "\"); removeFormField(\"#label_" + field + "_" + id + "\");return false;'>-</a></span>");
        id = (id - 1) + 2;
        document.getElementById(hidden).value = id;
    }
    function removeFormField(id) {
        $(id).remove();
    }
</script>

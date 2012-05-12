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
                <span><?php print form::input('incident_title', $form['incident_title'], ' class="text long"'); ?></span>
            </div>

            <br/>

            <div class="box">
                <label><b class="required">*</b>&nbsp;<?php echo Kohana::lang('ui_main.reports_description'); ?></label>
                <span><?php print form::textarea('incident_description', $form['incident_description'], ' rows="10" class="textarea long" ') ?></span>
            </div>

            <br/>

            <div class="box">
                <label><?php echo Kohana::lang('ui_main.reports_date'); ?></label>
                <span>
                    <?php print form::input('incident_date', $form['incident_date'], ' class="text short"'); ?>
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
                <label><?php echo Kohana::lang('ui_main.reports_time'); ?></label>
                <span>
                  <?php
                    for ($i=1; $i <= 12 ; $i++) {
                        $hour_array[sprintf("%02d", $i)] = sprintf("%02d", $i);	 // Add Leading Zero
                    }
                    for ($j=0; $j <= 59 ; $j++) {
                        $minute_array[sprintf("%02d", $j)] = sprintf("%02d", $j);	// Add Leading Zero
                    }
                    $ampm_array = array('pm'=>'pm','am'=>'am');
                    print form::dropdown('incident_hour',$hour_array,$form['incident_hour']);
                    print '<b class="dots">:</b>';
                    print form::dropdown('incident_minute',$minute_array,$form['incident_minute']);
                    print '<b class="dots">:</b>';
                    print form::dropdown('incident_ampm',$ampm_array,$form['incident_ampm']);
                    ?>
                    <?php if ($site_timezone != NULL): ?>
                    <small>(<?php echo $site_timezone; ?>)</small>
                    <?php endif; ?>
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

            <div class="box">
                <?php echo $custom_forms ?>
            </div>

            <br/>

            <div class="box" >
                <h3><?php echo Kohana::lang('ui_main.reports_optional'); ?></h3>

                <label><?php echo Kohana::lang('ui_main.reports_first'); ?></label>
                <span><?php print form::input('person_first', $form['person_first'], ' class="text long"'); ?></span><br/>

                <label><?php echo Kohana::lang('ui_main.reports_last'); ?></label>
                <span><?php print form::input('person_last', $form['person_last'], ' class="text long"'); ?></span><br/>


                <label><?php echo Kohana::lang('ui_main.reports_email'); ?></label>
                <span><?php print form::input('person_email', $form['person_email'], ' class="text long"'); ?></span><br/>

                <?php Event::run('ushahidi_action.report_form_optional'); ?>
            </div>

        </div>

        <div class="column">
            <div class="box">
                <?php if ( ! $multi_country AND count($cities) > 1): ?>
                    <label><?php echo Kohana::lang('ui_main.location'); ?></label>
                    <span> <?php print form::dropdown('select_city',$cities,'', ' class="select" '); ?></span><br/>
                <?php endif; ?>
                <div id="divMap" class="report-map"></div>
                <div>
                    <label><?php echo Kohana::lang('ui_main.find_location'); ?></label>
                    <input type="button" name="button" id="button" value="<?php echo Kohana::lang('ui_main.find_location'); ?>" class="btn_find" />
                        <div id="find_loading" class="report-find-loading"></div>
                    <span><?php print form::input('location_find', '', ' title="'.Kohana::lang('ui_main.location_example').'" class="findtext"'); ?></span>
                </div>
            </div>
            <?php Event::run('ushahidi_action.report_form_location', $id); ?>

            <br/>

            <div class="box">

                <label><?php echo Kohana::lang('ui_main.reports_location_name'); ?></label>
                <span><?php print form::input('location_name', $form['location_name'], ' class="text long"'); ?></span>

                <label></label>
                <span><i><?php echo Kohana::lang('ui_main.detailed_location_example'); ?></i></span>
            </div>

            <br/>

            <div id="divNews" class="box">
                <label><?php echo Kohana::lang('ui_main.reports_news'); ?></label>
                <?php
                $this_div = "divNews";
                $this_field = "incident_news";
                $this_startid = "news_id";
                $this_field_type = "text";
                if (empty($form[$this_field])) {
                    $i = 1;
                    print "<span>";
                    print form::input($this_field . '[]', '', ' class="text long2"');
                    print "<a href=\"#\" class=\"add\" onClick=\"addFormField('$this_div','$this_field','$this_startid','$this_field_type'); return false;\">add</a>";
                    print "</span>";
                }
                else {
                    $i = 0;
                    foreach ($form[$this_field] as $value) {
                        print "<span id=\"$i\">\n";

                        print form::input($this_field . '[]', $value, ' class="text long2"');
                        print "<a href=\"#\" class=\"add\" onClick=\"addFormField('$this_div','$this_field','$this_startid','$this_field_type'); return false;\">add</a>";
                        if ($i != 0)
                        {
                            print "<a href=\"#\" class=\"rem\"	onClick='removeFormField(\"#" . $this_field . "_" . $i . "\"); return false;'>remove</a>";
                        }
                        print "</span>\n";
                        $i++;
                    }
                }
                print "<input type=\"hidden\" name=\"$this_startid\" value=\"$i\" id=\"$this_startid\">";
                ?>
            </div>

            <br/>

            <div id="divVideo" class="box">
                <label><?php echo Kohana::lang('ui_main.external_video_link'); ?></label>
                <?php
                $this_div = "divVideo";
                $this_field = "incident_video";
                $this_startid = "video_id";
                $this_field_type = "text";

                if (empty($form[$this_field])) {
                    $i = 1;
                    print "<span>";
                    print form::input($this_field . '[]', '', ' class="text"');
                    print "<a href=\"#\" class=\"add\" onClick=\"addFormField('$this_div','$this_field','$this_startid','$this_field_type'); return false;\">add</a>";
                    print "</span>";
                }
                else {
                    $i = 0;
                    foreach ($form[$this_field] as $value) {
                        print "<span id=\"$i\">\n";

                        print form::input($this_field . '[]', $value, ' class="text"');
                        print "<a href=\"#\" class=\"add\" onClick=\"addFormField('$this_div','$this_field','$this_startid','$this_field_type'); return false;\">add</a>";
                        if ($i != 0)
                        {
                            print "<a href=\"#\" class=\"rem\"	onClick='removeFormField(\"#" . $this_field . "_" . $i . "\"); return false;'>remove</a>";
                        }
                        print "</span>\n";
                        $i++;
                    }
                }
                print "<input type=\"hidden\" name=\"$this_startid\" value=\"$i\" id=\"$this_startid\">";
                ?>
            </div>

            <?php Event::run('ushahidi_action.report_form_after_video_link'); ?>

            <br/>

            <div id="divPhoto" class="box">
                <label><?php echo Kohana::lang('ui_main.reports_photos'); ?></label>
                <?php
                $this_div = "divPhoto";
                $this_field = "incident_photo";
                $this_startid = "photo_id";
                $this_field_type = "file";

                if (empty($form[$this_field]['name'][0])) {
                    $i = 1;
                    print "<span>";
                    print form::upload($this_field . '[]', '', ' class="file long2"');
                    print "<a href=\"#\" class=\"add\" onClick=\"addFormField('$this_div','$this_field','$this_startid','$this_field_type'); return false;\">add</a>";
                    print "</span>";
                }
                else {
                    $i = 0;
                    foreach ($form[$this_field]['name'] as $value)
                    {
                        print "<span id=\"$i\">\n";

                        // print "\"<strong>" . $value . "</strong>\"" . "<BR />";
                        print form::upload($this_field . '[]', $value, ' class="file long2"');
                        print "<a href=\"#\" class=\"add\" onClick=\"addFormField('$this_div','$this_field','$this_startid','$this_field_type'); return false;\">add</a>";
                        if ($i != 0)
                        {
                            print "<a href=\"#\" class=\"rem\"	onClick='removeFormField(\"#" . $this_field . "_" . $i . "\"); return false;'>remove</a>";
                        }
                        print "</span>\n";
                        $i++;
                    }
                }
                print "<input style='' type=\"hidden\" name=\"$this_startid\" value=\"$i\" id=\"$this_startid\">";
                ?>
            </div>

            <br/>

            <div class="box">
                <input name="submit" type="submit" class="button" value="<?php echo Kohana::lang('ui_main.reports_btn_submit'); ?>" class="btn_submit" />
            </div>

        </div>
       <?php print form::close(); ?>

    </div>

</div>
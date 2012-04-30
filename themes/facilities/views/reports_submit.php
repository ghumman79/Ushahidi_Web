<div id="content">

    <div class="content-bg">

        <?php if ($site_submit_report_message != ''): ?>
        <div class="green-box" style="margin: 25px 25px 0px 25px">
            <h3><?php echo $site_submit_report_message; ?></h3>
        </div>
        <?php endif; ?>

        <!-- start report form block -->
        <?php print form::open(NULL, array('enctype' => 'multipart/form-data', 'id' => 'reportForm', 'name' => 'reportForm', 'class' => 'gen_forms')); ?>
        <input type="hidden" name="latitude" id="latitude" value="<?php echo $form['latitude']; ?>">
        <input type="hidden" name="longitude" id="longitude" value="<?php echo $form['longitude']; ?>">
        <input type="hidden" name="country_name" id="country_name" value="<?php echo $form['country_name']; ?>" />
        <input type="hidden" name="incident_zoom" id="incident_zoom" value="<?php echo $form['incident_zoom']; ?>" />

        <div class="big-block">

           <!--  report title-->
            <h1><?php echo Kohana::lang('ui_main.reports_submit_new'); ?></h1>
            <?php if ($form_error): ?>
            <!-- red-box -->
            <div class="red-box">
                <h3>Error!</h3>
                <ul>
                    <?php
                    foreach ($errors as $error_item => $error_description)
                    {
                        // print "<li>" . $error_description . "</li>";
                        print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
                    }
                    ?>
                </ul>
            </div>
            <?php endif; ?>

            <div class="row">
                <input type="hidden" name="form_id" id="form_id" value="<?php echo $id?>">
            </div>

            <!--  left side of the report page-->
            <div class="report_left">
                <div class="report_row" style="width:100%;">
                    <?php if(count($forms) > 1){ ?>
                    <div class="row">
                        <h4><span><?php echo Kohana::lang('ui_main.select_form_type');?></span>
						<span class="sel-holder">
							<?php print form::dropdown('form_id', $forms, $form['form_id'],
                            ' onchange="formSwitch(this.options[this.selectedIndex].value, \''.$id.'\')"') ?>
						</span>
                            <div id="form_loader" style="float:left;"></div>
                        </h4>
                    </div>
                    <?php } ?>
                    <h4 style="font-size: 12px"><?php echo Kohana::lang('ui_main.reports_title'); ?> <span class="required">*</span> </h4>
                    <?php print form::input('incident_title', $form['incident_title'], ' class="text long"'); ?>
                </div>

                <br/>

                <div class="report_row" style="width:100%;">
                    <h4 style="font-size: 12px"><?php echo Kohana::lang('ui_main.reports_description'); ?> <span class="required">*</span> </h4>
                    <?php print form::textarea('incident_description', $form['incident_description'], ' rows="10" class="textarea long" ') ?>
                </div>

            </div>



            <div class="report_right"></div>
        </div>
    </div>

</div>
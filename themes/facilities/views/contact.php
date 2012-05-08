<div id="middle" >
    <div class="content-bg">
        <!-- start contacts block -->
        <div class="big-block">
            <h1><?php echo Kohana::lang('ui_main.contact'); ?></h1>
            <div id="contact_us">
                <?php
                if ($form_error)
                {
                    ?>
                    <!-- red-box -->
                    <div class="red-box">
                        <h3>Error!</h3>
                        <ul>
                            <?php
                            foreach ($errors as $error_item => $error_description)
                            {
                                print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
                            }
                            ?>
                        </ul>
                    </div>
                    <?php
                }

                if ($form_sent)
                {
                    ?>
                    <!-- green-box -->
                    <div class="green-box">
                        <h3><?php echo Kohana::lang('ui_main.contact_message_has_send'); ?></h3>
                    </div>
                    <?php
                }
                ?>
                <?php print form::open(NULL, array('id' => 'contactForm', 'name' => 'contactForm')); ?>

                <div class="box_light" style="text-align: right; width: 60%">

                <div id="report_row1" style="text-align: right; width: 80%">
                    <?php echo Kohana::lang('ui_main.contact_name'); ?>
                    <?php print form::input('contact_name', $form['contact_name'], ' size="50%" class="text"'); ?><br/>

                </div>
                <div id="report_row1" style=" text-align: right;right; width: 80%"">
                    <?php echo Kohana::lang('ui_main.contact_email'); ?>
                    <?php print form::input('contact_email', $form['contact_email'], ' size="50%" class="text"'); ?>
                </div>
                <div id="report_row1" style=" text-align: right; right; width: 80%"">
                    <?php echo Kohana::lang('ui_main.contact_phone'); ?>
                    <?php print form::input('contact_phone', $form['contact_phone'], ' size="50%" class="text"'); ?>
                </div>
                <div id="report_row1" style=" text-align: right; right; width: 80%"">
                    <?php echo Kohana::lang('ui_main.contact_subject'); ?>
                    <?php print form::input('contact_subject', $form['contact_subject'], ' size="50%" class="text"'); ?>
                </div>
                <div id="report_row1" style=" text-align: right; right; width: 80%"">
                    <?php echo Kohana::lang('ui_main.contact_message'); ?>
                    <?php print form::input('contact_message', $form['contact_message'], ' size="50%"  class="text" ') ?>
                </div>
                <div id="report_row1" style=" text-align: right; right; width: 80%"">
                    <?php print $captcha->render(); ?><br/>
                    <?php echo Kohana::lang('ui_main.contact_code'); ?>
                    <?php print form::input('captcha', $form['captcha'], ' size="50%" class="text"'); ?>

                </div>
                <div id="report_row1" style=" text-align: right; right; width: 80%">
                    <input name="submit" type=button value="<?php echo Kohana::lang('ui_main.contact_send'); ?>" />
                </div>
                <?php print form::close(); ?>

                </div>

            </div>

        </div>
        <!-- end contacts block -->
    </div>
</div>
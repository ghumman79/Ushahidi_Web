<div id="middle" >
    <div class="content-bg">
        <!-- start contacts block -->
        <div class="big-block">
            <h1><?php echo Kohana::lang('ui_main.contact'); ?></h1>
            <div id="contact_us">
                <?php
                if ($form_error) {
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

                if ($form_sent) {
                    ?>
                    <!-- green-box -->
                    <div class="green-box">
                        <h3><?php echo Kohana::lang('ui_main.contact_message_has_send'); ?></h3>
                    </div>
                    <?php
                }
                ?>
                <div class="contact_form box_light">
                    <?php print form::open(NULL, array('id' => 'contactForm', 'name' => 'contactForm')); ?>

                    <label><?php echo Kohana::lang('ui_main.contact_name'); ?></label>
                    <span><?php print form::input('contact_name', $form['contact_name'], ' size="50%" class="text"'); ?></span><br/>

                    <label><?php echo Kohana::lang('ui_main.contact_email'); ?></label>
                    <span><?php print form::input('contact_email', $form['contact_email'], ' size="50%" class="text"'); ?></span><br/>

                    <label><?php echo Kohana::lang('ui_main.contact_phone'); ?></label>
                    <span><?php print form::input('contact_phone', $form['contact_phone'], ' size="50%" class="text"'); ?></span><br/>

                    <label><?php echo Kohana::lang('ui_main.contact_subject'); ?></label>
                    <span><?php print form::input('contact_subject', $form['contact_subject'], ' size="50%" class="text"'); ?></span><br/>

                    <label><?php echo Kohana::lang('ui_main.contact_message'); ?></label>
                    <span><?php print form::input('contact_message', $form['contact_message'], ' size="50%"  class="text" ') ?></span><br/>

                    <label><?php echo Kohana::lang('ui_main.contact_code'); ?></label>
                    <span><?php print form::input('captcha', $form['captcha'], ' size="50%" class="text"'); ?></span>

                    <label> </label>
                    <span><?php print $captcha->render(); ?></span><br/>

                    <label> </label>
                    <span><input  name="submit" type="submit" type=button value="<?php echo Kohana::lang('ui_main.contact_send'); ?>" /></span>

                    <?php print form::close(); ?>
                </div>

            </div>

        </div>
        <!-- end contacts block -->
    </div>
</div>
<div id="middle" >
    <div id="content">
        <div class="content-bg">
            <!-- start block -->
            <div class="big-block">
                <h1>Confirm Alerts</h1>
                <?php if($show_mobile == TRUE): ?>
                    <!-- Mobile Alert -->
                    <div class="alerts_confirm_mobile box_light">
                        <?php if ($alert_mobile): ?>
                            <?php	echo "<h3>".Kohana::lang('alerts.mobile_ok_head')."</h3>"; ?>
                        <?php endif; ?>
                       <?php if ($alert_mobile) {
                                echo Kohana::lang('alerts.mobile_alert_request_created')."<u><strong>".
                                    $alert_mobile."</strong></u>.".
                                    Kohana::lang('alerts.verify_code');
                        } ?>
                        <?php print form::open('/alerts/verify'); ?>

                        <label>Verification Code</label>
                        <span><?php print form::input('alert_code', '', ' class="text"'); ?></span><br/>

                        <label>Mobile Phone</label>
                        <span><?php print form::input('alert_mobile', $alert_mobile, ' class="text"'); ?></span><br/>

                        <label></label>
                        <span><?php print form::submit('button', 'Confirm Alert Request', ' class="btn_submit"'); ?></span>
                        <?php print form::close(); ?>
                    </div>
                <!-- / Mobile Alert -->
                <?php endif; ?>

                <!-- Email Alert -->
                <div class="alerts_confirm_email box_light">
                    <?php
                    if ($alert_email) {
                        echo "<h3>".Kohana::lang('alerts.email_ok_head')."</h3>";
                    }
                    ?>
                    <?php
                    if ($alert_email) {
                        echo Kohana::lang('alerts.email_alert_request_created')."<u><strong>".
                            $alert_email."</strong></u>.".
                            Kohana::lang('alerts.verify_code');
                    }
                    ?>
                    <?php print form::open('/alerts/verify'); ?>

                    <label>Verification Code</label>
                    <span><?php print form::input('alert_code', '', ' class="text"'); ?></span><br/>

                    <label>Mobile Phone</label>
                    <span><?php print form::input('alert_email', $alert_email, ' class="text"'); ?></span><br/>

                    <label></label>
                    <span><?php print form::submit('button', 'Confirm Alert Request', ' class="btn_submit"'); ?></span>
                    <?php print form::close(); ?>
                </div>
                <!-- / Email Alert -->

                <div class="alerts_confirm_return box_light">
                    <b>
                        <a href="<?php echo url::site().'alerts'?>"><?php echo Kohana::lang('alerts.create_more_alerts'); ?></a>
                    </b>
                </div>

            </div>
            <!-- end block -->
        </div>
    </div>
</div>
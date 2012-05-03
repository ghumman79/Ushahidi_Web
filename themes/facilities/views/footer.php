<div id="footer">
    <!-- footer credits -->
    <div class="footer-credits">
        <a href="http://www.ushahidi.com" title="Ushahidi"><img id="ushahidi" border="0" /></a>
    </div>
    <!-- / footer credits -->

    <!-- footer menu -->
    <div class="footermenu">
        <ul class="clearingfix">
            <li><a class="item1" href="/main"><?php echo Kohana::lang('ui_main.home'); ?></a></li>
            <li><a href="/reports"><?php echo Kohana::lang('ui_main.reports'); ?></a></li>
            <?php if(Kohana::config('settings.allow_reports')) { ?>
                <li><a href="<?php echo url::site()."reports/submit"; ?>"><?php echo Kohana::lang('ui_main.submit'); ?></a></li>
            <?php } ?>
            <?php if(Kohana::config('settings.allow_alerts')) { ?>
                <li><a href="<?php echo url::site()."alerts"; ?>"><?php echo Kohana::lang('ui_main.alerts'); ?></a></li>
            <?php } ?>
            <?php if(Kohana::config('settings.site_contact_page')) { ?>
                <li><a href="<?php echo url::site()."contact"; ?>"><?php echo Kohana::lang('ui_main.contact'); ?></a></li>
            <?php } ?>
            <?php Event::run('ushahidi_action.nav_main_bottom'); ?>
            <li><a href="/feed/"><?php echo Kohana::lang('ui_main.rss'); ?></a></li>
        </ul>
        <?php if($site_copyright_statement != '') { ?>
            <span class="copyright"><?php echo $site_copyright_statement; ?></span>
        <?php } ?>
    </div>
    <!-- / footer menu -->
    <!-- / footer content -->
</div>

<?php
echo $footer_block;
Event::run('ushahidi_action.main_footer');
?>
</body>
</html>
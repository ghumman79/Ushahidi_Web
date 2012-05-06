<div id="footer">
    <!-- footer credits -->
    <div class="footer-credits">
        <a href="http://www.ushahidi.com" title="Ushahidi"><img id="ushahidi" border="0" /></a>
    </div>
    <!-- / footer credits -->

    <!-- footer menu -->
    <div class="footermenu">
        <ul class="clearingfix">
            <li><a class="item1" title="<?php echo Kohana::lang('ui_main.home'); ?>" href="/main"><?php echo Kohana::lang('ui_main.home'); ?></a></li>
            <li><a title="<?php echo Kohana::lang('ui_main.reports'); ?>" href="/reports"><?php echo Kohana::lang('ui_main.reports'); ?></a></li>
            <?php if(Kohana::config('settings.allow_reports')) { ?>
                <li><a title="<?php echo Kohana::lang('ui_main.submit'); ?>" href="<?php echo url::site()."reports/submit"; ?>"><?php echo Kohana::lang('ui_main.submit'); ?></a></li>
            <?php } ?>
            <?php if(Kohana::config('settings.allow_alerts')) { ?>
                <li><a title="<?php echo Kohana::lang('ui_main.alerts'); ?>" href="<?php echo url::site()."alerts"; ?>"><?php echo Kohana::lang('ui_main.alerts'); ?></a></li>
            <?php } ?>
            <?php if(Kohana::config('settings.site_contact_page')) { ?>
                <li><a title="<?php echo Kohana::lang('ui_main.contact'); ?>" href="<?php echo url::site()."contact"; ?>"><?php echo Kohana::lang('ui_main.contact'); ?></a></li>
            <?php } ?>
            <?php foreach (ORM::factory('page')->where('page_active', '1')->find_all() as $page) { ?>
                <li><a title="<?php echo $page->page_tab; ?>" href="<?php echo url::site()."page/index/".$page->id; ?>"><?php echo $page->page_tab; ?></a></li>
            <?php }?>
            <li><a title="<?php echo Kohana::lang('ui_main.rss'); ?>" href="/feed/"><?php echo Kohana::lang('ui_main.rss'); ?></a></li>
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
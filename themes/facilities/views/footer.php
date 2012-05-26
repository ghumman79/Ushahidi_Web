<div id="footer">
    <div id="footer-credits">
        <a href="http://www.ushahidi.com" title="Powered by Ushahidi"><img id="ushahidi" src="<?php echo url::site(); ?>themes/facilities/images/footer-logo.png"/></a>
    </div>
    <div id="footer-links">
        <ul>
            <li class="first"><a title="<?php echo Kohana::lang('ui_main.home'); ?>" href="<?php echo url::site(); ?>main"><?php echo Kohana::lang('ui_main.home'); ?></a></li>
            <li><a title="<?php echo Kohana::lang('ui_main.reports'); ?>" href="<?php echo url::site(); ?>reports"><?php echo Kohana::lang('ui_main.reports'); ?></a></li>
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
            <?php if (ORM::factory('feed_item')->find_all()->count() > 0) { ?>
                <li><a title="<?php echo Kohana::lang('ui_main.news'); ?>" href="<?php echo url::site(); ?>feeds/"><?php echo Kohana::lang('ui_main.news'); ?></a></li>
            <?php }?>
            <?php if(Kohana::config('settings.allow_feed')) { ?>
                <li><a title="<?php echo Kohana::lang('ui_main.rss'); ?>" href="<?php echo url::site(); ?>feed/"><?php echo Kohana::lang('ui_main.rss'); ?></a></li>
            <?php }?>
        </ul>
    </div>
    <?php if($site_copyright_statement != '') { ?>
        <div id="footer-copyright"><?php echo $site_copyright_statement; ?></div>
    <?php } ?>
</div>
<?php echo $footer_block; ?>
<?php Event::run('ushahidi_action.main_footer'); ?>
</body>
</html>
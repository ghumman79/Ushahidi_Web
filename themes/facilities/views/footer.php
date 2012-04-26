<div id="footer">
    <!-- footer credits -->
    <div class="footer-credits">
        <a href="http://www.ushahidi.com" title="Ushahidi"><img id="ushahidi" border="0" /></a>
    </div>
    <!-- / footer credits -->

    <!-- footer menu -->
    <div class="footermenu">
        <ul class="clearingfix">
            <li><a class="item1" href="/feed/"><?php echo Kohana::lang('ui_main.rss'); ?></a></li>
            <li><a href="/main"><?php echo Kohana::lang('ui_main.home'); ?></a></li>
            <li><a href="/reports"><?php echo Kohana::lang('ui_main.reports'); ?></a></li>
            <?php
            Event::run('ushahidi_action.nav_main_bottom');
            ?>
        </ul>
        <?php if($site_copyright_statement != '') { ?>
        <p><?php echo $site_copyright_statement; ?></p>
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
</div>
</div>
<!-- / main body -->
</div>
<!-- / wrapper -->

<!-- footer -->
<div id="footer" class="clearingfix">

    <div id="underfooter"></div>

    <!-- footer content -->
    <div class="rapidxwpr floatholder">

        <!-- footer credits -->
        <div class="footer-credits">
            <a href="http://www.ushahidi.com" title="Ushahidi"><img src="../images/footer-logo.png" alt="Ushahidi" style="vertical-align:middle" /></a>
        </div>
        <!-- / footer credits -->

        <!-- footer menu -->
        <div class="footermenu">
            <ul class="clearingfix">
                <li><a class="item1" href="<?php echo url::site(); ?>"><?php echo Kohana::lang('ui_main.home'); ?></a></li>
                <li><a href="/feed/"><?php echo Kohana::lang('ui_main.rss'); ?></a></li>
                <?php
                // Action::nav_main_bottom - Add items to the bottom links
                Event::run('ushahidi_action.nav_main_bottom');
                ?>
            </ul>
            <?php if($site_copyright_statement != '') { ?>
            <p><?php echo $site_copyright_statement; ?></p>
            <?php } ?>
        </div>
        <!-- / footer menu -->
    </div>
    <!-- / footer content -->
</div>
<!-- / footer -->

<?php
echo $footer_block;
// Action::main_footer - Add items before the </body> tag
Event::run('ushahidi_action.main_footer');
?>
</body>
</html>
<div id="middle" class="scroll">
    <div id="content">
       <div id="main-welcome" class="column">
             <?php if($site_message != '') { ?>
            <div class="box">
                <?php echo $site_message; ?>
            </div>
            <?php } ?>
        </div>
        <div id="main-categories" class="column">
            <?php foreach ($categories as $category => $category_info) {
                $category_title = $category_info[0];
                if ($category_title !== 'Trusted Reports') {
                    echo '<ul class="box">';
                    echo '<li class="title"><a title="'. $category_title . '" href="' . url::site() . 'reports/?c=' . $category . '">' . $category_title . '</a></li>';
                    if (sizeof($category_info[3]) != 0) {
                        foreach ($category_info[3] as $child => $child_info) {
                            $child_title = $child_info[0];
                            echo '<li><a title="'. $child_title . '" href="' . url::site() . 'reports/?c=' . $child . '">' . $child_title . '</a></li>';
                        }
                    }
                    echo '</ul>';
                }
            } ?>
        </div>
        <div class="clear"></div>
        <?php blocks::render(); ?>
    </div>
    <div id="mapProjection" style="display:none;"></div>
</div>
<script type="text/javascript">
    var $PHRASES = <?php echo json_encode(
        array('server' => url::site(),
              'reports' => Kohana::lang('ui_main.reports'),
              'checkins' => Kohana::lang('ui_admin.checkins'),
              'no_checkins' => Kohana::lang('ui_main.no') . " " .Kohana::lang('ui_admin.checkins'),
              'previous' => Kohana::lang('ui_main.previous'),
              'next' => Kohana::lang('ui_main.next'))); ?>;
    $(function(){
        <?php if ( Kohana::config('settings.checkins') ) { ?>
        listCheckins(10,0);
        <?php } ?>
    });
    function showCheckins() {}
    function smartColumns() {}
</script>
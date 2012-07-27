<div id="middle" class="scroll">
    <div id="content">
       <div id="main-welcome" class="column">
            <div class="box">
             <?php if($site_message != '') { ?>
                <?php echo $site_message; ?>
            <?php } else { ?>
                <?php echo Kohana::lang('ui_main.no') . " " . Kohana::lang('ui_main.description'); ?>
            <?php } ?>
            </div>
        </div>
        <div id="main-categories" class="column">
            <?php
                if (count(Kohana::config('settings.categories')) > 0) {
                    foreach (Kohana::config('settings.categories') as $category) {
                        echo '<ul class="box">';
                        echo '<li class="title"><a title="'. $category->category_description . '" href="' . url::site() . 'reports/?c=' . $category->id . '">';
                        if ($category->category_image_thumb != NULL) {
                            echo '<img src="' . url::convert_uploaded_to_abs($category->category_image_thumb) . '"/>';
                        }
                        echo $category->category_title . '</a></li>';
                        foreach ($category->children as $child) {
                            echo '<li><a title="'. $child->category_description . '" href="' . url::site() . 'reports/?c=' . $child->id . '">';
                            if ($child->category_image_thumb != NULL) {
                                echo '<img src="' . url::convert_uploaded_to_abs($child->category_image_thumb) . '"/>';
                            }
                            echo $child->category_title . '</a></li>';
                        }
                        echo '</ul>';
                    }
                }
                else {
                    echo '<div class="box">';
                    echo '<h3>' . Kohana::lang('ui_main.categories') . '</h3>';
                    echo '<ul><li>' . Kohana::lang('ui_main.no') . ' '  . Kohana::lang('ui_main.categories') . '</li></ul>';
                    echo '</div>';
                }
             ?>
        </div>
        <div class="clear"></div>
        <?php blocks::render(); ?>
    </div>
</div>
<script type="text/javascript">
    var $PHRASES = <?php echo json_encode(
        array('server' => url::site(),
              'reports' => Kohana::lang('ui_main.reports'),
              'checkins' => Kohana::lang('ui_admin.checkins'),
              'no_checkins' => Kohana::lang('ui_main.no') . " " . Kohana::lang('ui_admin.checkins'),
              'previous' => Kohana::lang('ui_main.previous'),
              'next' => Kohana::lang('ui_main.next'))); ?>;
    <?php if (Kohana::config('settings.checkins')) { ?>
        $(function(){
            listCheckins(10,0);
        });
    <?php } ?>
</script>
<div id="middle">
    <div id="main">
        <div class="column_welcome">
             <?php if($site_message != '') { ?>
            <div class="box_light">
                <?php echo $site_message; ?>
            </div>
            <?php } ?>

        </div>
        <div class="column_categories">
            <?php foreach ($categories as $category => $category_info) {
                $category_title = $category_info[0];
                echo '<ul class="box_light">';
                echo '<li class="title"><a title="'. $category_title . '" href="' . url::site() . 'reports/?c=' . $category . '">' . $category_title . '</a></li>';
                if(sizeof($category_info[3]) != 0) {
                    foreach ($category_info[3] as $child => $child_info) {
                        $child_title = $child_info[0];
                        echo '<li><a title="'. $child_title . '" href="' . url::site() . 'reports/?c=' . $child . '">' . $child_title . '</a></li>';
                    }
                }
                echo '</ul>';
            } ?>
        </div>
        <div class="clearfix"/>
        <?php blocks::render(); ?>
    </div>
</div>
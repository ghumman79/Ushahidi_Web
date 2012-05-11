<div id="main-news" class="column">
    <div class="box-light">
        <h3>News</h3>
        <ul class="box-light">
         <?php
            if ($feeds->count() == 0) {
                ?>
                <li>No news</li>
                <?php
            }
            else if ($feeds->count() != 0) {
                foreach ($feeds as $feed) {
                    $feed_id = $feed->id;
                    $feed_title = $feed->item_title;
                    $feed_link = $feed->item_link;
                    $feed_source = $feed->feed->feed_name;
                    ?>
                <li>
                    <a href="<?php echo $feed_link; ?>" target="_blank"><?php echo $feed_title ?></a>
                    -
                    <?php echo $feed_source; ?>
                </li>
                    <?php
                }
            }
            ?>
        <li class="more">
            <a title="<?php echo Kohana::lang('ui_main.view_more'); ?>" href="<?php echo url::site() . 'feeds' ?>">
                <?php echo Kohana::lang('ui_main.view_more'); ?>
            </a>
        </li>
        </ul>
    </div>
</div>
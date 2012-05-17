<div id="middle">
    <table id="titlebar">
        <tr>
            <td class="titlebar-previous">
                <?php // TODO disable PREVIOUS button if report does not exist ?>
                <span><a class="previous" href="<?php echo url::site().'reports/view/'.($incident_id - 1)?>">Previous</a></span>
            </td>
            <td class="titlebar-title">
                <span class="report-title">
                    <?php echo $incident_title;
                    if ($logged_in) {
                        echo " [&nbsp;<a href=\"".url::site()."admin/reports/edit/".$incident_id."\">".Kohana::lang('ui_main.edit')."</a>&nbsp;]";
                    }
                    ?>
                </span>
            </td>
            <td class="titlebar-location">
                <span class="report-location"><?php echo $incident_location; ?></span>
            </td>
            <td class="titlebar-categories">
                <span class="report-categories">
                    <?php
                    foreach($incident_category as $category){
                        if($category->category->category_visible == 0) {
                            continue;
                        }
                        if ($category->category->category_image_thumb) { ?>
                            <span>
                    <a title="<?php echo $category->category->category_description; ?>" href="<?php echo url::site()."reports/?c=".$category->category->id; ?>">
                        <img src="<?php echo url::base().Kohana::config('upload.relative_directory')."/".$category->category->category_image_thumb; ?>"/>
                        <?php echo $category->category->category_title; ?>
                    </a>
                    </span>
                            <?php
                        }
                        else {
                            ?>
                            <span>
                    <a title="<?php echo $category->category->category_description; ?>" href="<?php echo url::site()."reports/?c=".$category->category->id; ?>">
                        <?php echo $category->category->category_title; ?>
                    </a>
                    </span>
                            <?php
                        }
                    }
                    ?>
                </span>
            </td>
            <td class="titlebar-next">
                <?php // TODO disable NEXT button if report does not exist ?>
                <span><a class="next" href="<?php echo url::site().'reports/view/'.($incident_id + 1)?>">Next</a></span>
            </td>
        </tr>
    </table>

    <div id="details" class="scroll">
        <div id="content">
            <div class="column">
                <?php if (empty($incident_description) == false) { ?>
                    <div class="report-desc box">
                        <?php echo $incident_description; ?>
                    </div>
                <?php } ?>

                <?php foreach( $incident_news as $incident_new) { ?>
                    <div class="report-custom box">
                        <div class="report-label">
                            <?php echo Kohana::lang('ui_main.url');?>
                        </div>
                        <div class="report-value">
                            <a href="<?php echo $incident_new; ?> " target="_blank">
                                <?php echo $incident_new;?>
                            </a>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php } ?>

                <?php if(strlen($custom_forms) > 0) { ?>
                <div class="report-extras">
                    <?php Event::run('ushahidi_action.report-extra', $incident_id); ?>
                    <?php echo $custom_forms; ?>
                </div>
                <?php } ?>

                <?php Event::run('ushahidi_action.report-display-media', $incident_id); ?>

                <div class="report-media box <?php if(count($incident_photos) == 0){ echo "hidden";}?>">
                    <?php
                    if(count($incident_photos) > 0) {
                        foreach ($incident_photos as $photo) {
                            echo '<div class="report-media-image"><a class="photothumb" rel="lightbox-group1" href="'.$photo['large'].'"><img src="'.$photo['thumb'].'"/></a></div>';
                        };
                    }
                    ?>
                    <div class="clear"></div>
                </div>

                <div class="report-media box <?php if(count($incident_videos) == 0){ echo "hidden";}?>">
                    <?php
                    if(count($incident_videos) > 0 ){
                        foreach( $incident_videos as $incident_video) {
                            $videos_embed->embed($incident_video,'');
                        };
                    }
                    ?>
                </div>

                <?php Event::run('ushahidi_filter.comment_block', $comments); ?>
                <?php if(isset($comments) && count($comments) > 0 && trim($comments) !== ''){ ?>
                   <div class="report-comments">
                       <?php echo $comments; ?>
                    </div>
                <?php } ?>

                <?php if (Kohana::config('settings.allow_comments') ) { ?>
                <div class="report-comment-form box">
                    <?php Event::run('ushahidi_filter.comment_form_block', $comments_form); ?>
                    <?php echo $comments_form; ?>
                </div>
                <?php } ?>
            </div>
            <div class="column">
                    <div id="report-map" class="report-map">
                        <div class="map-holder" id="map"></div>
                    </div>
                    <?php Event::run('ushahidi_action.report-meta', $incident_id); ?>
                <?php Event::run('ushahidi_action.report-view_sidebar', $incident_id); ?>

                <div class="report-nearbys">
                    <?php foreach($incident_neighbors as $neighbor) { ?>
                    <div class="report-nearby box">
                        <div class="report-label">
                            <a title="<?php echo $neighbor->incident_title; ?>" href="<?php echo url::site(); ?>reports/view/<?php echo $neighbor->id; ?>">
                                <?php echo $neighbor->incident_title; ?>
                            </a>
                        </div>
                        <div class="report-value">
                            <a title="<?php echo $neighbor->incident_title; ?>" href="<?php echo url::site(); ?>reports/view/<?php echo $neighbor->id; ?>">
                                <?php echo $neighbor->location_name.", ".round($neighbor->distance, 2); ?> kms
                            </a>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $(window).resize(function() {
            adjustThumbnails();
        });
        adjustThumbnails();
    });
    function adjustThumbnails() {
        $('.report-media_image').each(function() {
            var width = $(this).width();
            $(this).height(width*0.65);
            $(this).css("height", width*0.65);
            $(this).css("minHeight", width*0.65);
            $(this).css("maxHeight", width*0.65);
        });
        $('.report-media object').each(function() {
            var width = $(this).width();
            $(this).height(width*0.65);
            $(this).css("height", width*0.65);
            $(this).css("minHeight", width*0.65);
            $(this).css("maxHeight", width*0.65);
        });
        $('.report-media object embed').each(function() {
            var width = $(this).width();
            $(this).height(width*0.65);
            $(this).css("height", width*0.65);
            $(this).css("minHeight", width*0.65);
            $(this).css("maxHeight", width*0.65);
        });
    }
</script>
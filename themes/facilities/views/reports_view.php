<div id="middle">
    <table id="titlebar">
        <tr>
            <td class="titlebar_previous">
                <?php // TODO disable PREVIOUS button if report does not exist ?>
                <a class="previous box_medium" href="<?php echo url::site().'reports/view/'.($incident_id - 1)?>">Previous</a>
            </td>
            <td class="titlebar_title">
                <span class="report_title">
                    <?php echo $incident_title;
                    if ($logged_in) {
                        echo " [&nbsp;<a href=\"".url::site()."admin/reports/edit/".$incident_id."\">".Kohana::lang('ui_main.edit')."</a>&nbsp;]";
                    }
                    ?>
                </span>
            </td>
            <td class="titlebar_categories">
                <span class="report_categories">
                    <?php
                    foreach($incident_category as $category){
                        // don't show hidden categoies
                        if($category->category->category_visible == 0) {
                            continue;
                        }
                        if ($category->category->category_image_thumb) {
                            ?>
                            <span class="box_light">
                    <a href="<?php echo url::site()."reports/?c=".$category->category->id; ?>">
                        <img src="<?php echo url::base().Kohana::config('upload.relative_directory')."/".$category->category->category_image_thumb; ?>"/>
                        <?php echo $category->category->category_title; ?>
                    </a>
                    </span>
                            <?php
                        }
                        else {
                            ?>
                            <span class="box_medium">
                    <a href="<?php echo url::site()."reports/?c=".$category->category->id; ?>">
                        <?php echo $category->category->category_title; ?>
                    </a>
                    </span>
                            <?php
                        }
                    }
                    ?>
                </span>
            </td>
            <td class="titlebar_next">
                <?php // TODO disable NEXT button if report does not exist ?>
                <a class="next box_medium" href="<?php echo url::site().'reports/view/'.($incident_id + 1)?>">Next</a>
            </td>
        </tr>
    </table>

    <div id="details">
    <!--    left column starts-->
        <div id="left-column">
            <?php if (empty($incident_description) == false) { ?>
                <div class="report_description box_light">
                    <?php echo $incident_description; ?>
                </div>
            <?php } ?>

            <?php foreach( $incident_news as $incident_new) { ?>
                <div class="report_custom box_light">
                    <div class="report_custom_name">
                        <?php echo Kohana::lang('ui_main.url');?>
                    </div>
                    <div class="report_custom_value">
                        <a href="<?php echo $incident_new; ?> " target="_blank">
                            <?php echo $incident_new;?>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php } ?>

            <?php if(strlen($custom_forms) > 0) { ?>
            <div class="report_extras">
                <?php Event::run('ushahidi_action.report_extra', $incident_id); ?>
                <?php echo $custom_forms; ?>
            </div>
            <?php } ?>

            <?php Event::run('ushahidi_action.report_display_media', $incident_id); ?>

            <!-- start report media with photos and videos-->
            <div class="report_media box_light <?php if(count($incident_photos) == 0){ echo "hidden";}?>">
                <?php
                if(count($incident_photos) > 0) {
                    foreach ($incident_photos as $photo) {
                        echo '<div class="report_media_image"><a class="photothumb" rel="lightbox-group1" href="'.$photo['large'].'"><img src="'.$photo['thumb'].'"/></a></div>';
                    };
                }
                ?>
                <div class="clearfix"></div>
            </div>

            <div class="report_media box_light <?php if(count($incident_videos) == 0){ echo "hidden";}?>">
                <?php
                if(count($incident_videos) > 0 ){
                    foreach( $incident_videos as $incident_video) {
                        $videos_embed->embed($incident_video,'');
                    };
                }
                ?>
            </div>

           <?php Event::run('ushahidi_filter.comment_block', $comments); ?>
           <div class="report_comments box_light <?php if(count($comments) == 0 || !isset($comments) || trim($comments)===''){ echo "hidden";}?>">
               <?php echo $comments; ?>
            </div>

            <div class="report_comment_form box_light">
                <?php Event::run('ushahidi_filter.comment_form_block', $comments_form); ?>
                <?php echo $comments_form; ?>
            </div>

        </div>

    <!--  / left column ends -->


    <!--    right column starts-->

        <div id="right-column">
            <!-- map display starts-->
            <div id="report-map" class="report-map">
                <div class="map-holder" id="map"></div>
            </div>
            <!-- /map display ends-->

            <?php Event::run('ushahidi_action.report_meta', $incident_id); ?>

        <!--  DESCRIPTION(DETAILS)-->

        <?php
        // Action::report_view_sidebar - This gives plugins the ability to insert into the sidebar (below the map and above additional reports)
        Event::run('ushahidi_action.report_view_sidebar', $incident_id);
        ?>

        <div class="report_nearbys">
            <?php foreach($incident_neighbors as $neighbor) { ?>
            <div class="report_nearby box_light">
                <div class="report_nearby_title">
                    <a title="<?php echo $neighbor->incident_title; ?>" href="<?php echo url::site(); ?>reports/view/<?php echo $neighbor->id; ?>">
                        <?php echo $neighbor->incident_title; ?>
                    </a>
                </div>
                <div class="report_nearby_location">
                    <a title="<?php echo $neighbor->incident_title; ?>" href="<?php echo url::site(); ?>reports/view/<?php echo $neighbor->id; ?>">
                        <?php echo $neighbor->location_name.", ".round($neighbor->distance, 2); ?> kms
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
            <?php } ?>
        </div>

    <!-- /   right column ends-->

</div>

<script type="text/javascript">
    $(function(){
        $(window).resize(function() {
            adjustThumbnails();
        });
        adjustThumbnails();
    });
    function adjustThumbnails() {
        $('.report_media_image').each(function() {
            var width = $(this).width();
            $(this).height(width*0.65);
            $(this).css("height", width*0.65);
            $(this).css("minHeight", width*0.65);
            $(this).css("maxHeight", width*0.65);
        });
        $('.report_media object').each(function() {
            var width = $(this).width();
            $(this).height(width*0.65);
            $(this).css("height", width*0.65);
            $(this).css("minHeight", width*0.65);
            $(this).css("maxHeight", width*0.65);
        });
        $('.report_media object embed').each(function() {
            var width = $(this).width();
            $(this).height(width*0.65);
            $(this).css("height", width*0.65);
            $(this).css("minHeight", width*0.65);
            $(this).css("maxHeight", width*0.65);
        });
    }
</script>
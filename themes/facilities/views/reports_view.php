<div id="middle" style="overflow:auto;">
    <div id="details">
    <!--    left column starts-->
        <div id="left-column">
            <h1 class="report-title"><?php
                echo $incident_title;
                // If Admin is Logged In - Allow For Edit Link
                if ($logged_in) {
                    echo " [&nbsp;<a href=\"".url::site()."admin/reports/edit/".$incident_id."\">".Kohana::lang('ui_main.edit')."</a>&nbsp;]";
                }
                ?>
            </h1>

            <div class="report_categories">
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
                        <span class="box_light">
                        <a href="<?php echo url::site()."reports/?c=".$category->category->id; ?>">
                            <?php echo $category->category->category_title; ?>
                        </a>
                        </span>
                        <?php
                    }
                }
                ?>
            </div>

            <div class="report_description box_light">
                <?php echo $incident_description; ?>
            </div>

            <!-- report media with photos and videos ends-->

           <div class="report_extras box_light">
                <?php Event::run('ushahidi_action.report_extra', $incident_id); ?>
           </div>

            <?php Event::run('ushahidi_action.report_display_media', $incident_id); ?>

            <!-- start report media with photos and videos-->
            <div class="report_media box_light <?php if( count($incident_photos) == 0 && count($incident_videos) == 0){ echo "hidden";}?>">
                <?php
                // if there are images, show them
                if(count($incident_photos) > 0) {
                    foreach ($incident_photos as $photo) {
                        echo '<a class="photothumb" rel="lightbox-group1" href="'.$photo['large'].'"><img width="200" src="'.$photo['large'].'"/></a> ';
                    };
                }
                // if there are videos, show those too
                if( count($incident_videos) > 0 ){
                    echo '<div id="report-video"><ol>';
                    // embed the video codes
                    foreach( $incident_videos as $incident_video) {
                        echo '<li>';
                        $videos_embed->embed($incident_video,'');
                        echo '</li>';
                    };
                    echo '</ol></div>';

                }
                ?>
            </div>

           <?php Event::run('ushahidi_filter.comment_block', $comments); ?>
           <div class="report_comments box_light <?php if(count($comments) == 0){ echo "hidden";}?>">
               <?php echo $comments; ?>
            </div>

            <div class="report_comment_form box_light">
                <?php
                // Filter::comments_form_block - The block that contains the comments form
                Event::run('ushahidi_filter.comment_form_block', $comments_form);
                echo $comments_form;
                ?>
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


        <div class="report-description-text">
            <?php if ($features_count) { ?>
            <br /><br /><h5><?php echo Kohana::lang('ui_main.reports_features');?></h5>
            <?php
            foreach ($features as $feature) {
                echo ($feature->geometry_label) ?
                    "<div class=\"feature_label\"><a href=\"javascript:getFeature($feature->id)\">$feature->geometry_label</a></div>" : "";
                echo ($feature->geometry_comment) ?
                    "<div class=\"feature_comment\">$feature->geometry_comment</div>" : "";
            }
        }?>

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

        <!-- / end DESCRIPTION(DETAILS)-->

    <!-- /   right column ends-->
    </div>
</div>
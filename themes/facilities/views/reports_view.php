<div id="middle"  style="overflow: scroll;">

<!--    left column starts-->

    <div id="left-column" style="margin-left:20px; margin-top: 20px">

        <!-- map display starts-->
        <div id="report-map" class="report-map">
            <div class="map-holder" id="map">

            </div>
        </div>
        <!-- /map display ends-->

        <!-- report media box starts-->
        <div class="report-media-box-content">
            <?php
            // Action::report_display_media - Add content just above media section
            Event::run('ushahidi_action.report_display_media', $incident_id);
            ?>

            <!-- start report media with photos and videos-->
            <div class="<?php if( count($incident_photos) > 0 || count($incident_videos) > 0){ echo "report-media";}?>">
                <?php
                // if there are images, show them
                if( count($incident_photos) > 0 )
                {
                    echo '<div id="report-images">';
                    foreach ($incident_photos as $photo)
                    {
                        echo '<a class="photothumb" rel="lightbox-group1" href="'.$photo['large'].'"><img src="'.$photo['thumb'].'"/></a> ';
                    };
                    echo '</div>';
                }

                // if there are videos, show those too
                if( count($incident_videos) > 0 )
                {
                    echo '<div id="report-video"><ol>';

                    // embed the video codes
                    foreach( $incident_videos as $incident_video)
                    {
                        echo '<li>';
                        $videos_embed->embed($incident_video,'');
                        echo '</li>';
                    };
                    echo '</ol></div>';

                }
                ?>
            </div>

            <!-- report media with photos and videos ends-->


            <?php
            // Action::report_extra - Allows you to target an individual report right after the description
            Event::run('ushahidi_action.report_extra', $incident_id);

            // Filter::comments_block - The block that contains posted comments
            Event::run('ushahidi_filter.comment_block', $comments);
            echo $comments;
            ?>

            <?php
            // Filter::comments_form_block - The block that contains the comments form
            Event::run('ushahidi_filter.comment_form_block', $comments_form);
            echo $comments_form;
            ?>

        </div>
        <!-- /report media box ends-->

    </div>

<!--  / left column ends -->


<!--    right column starts-->

    <div id="right-column">


    <!--  DESCRIPTION(DETAILS)-->

    <!-- start report descrition-->

    <div class="report-description-text">
        <h5><?php echo Kohana::lang('ui_main.reports_description');?></h5>
        <?php echo $incident_description; ?>
        <br/>
    <!--/  end reports description-->


        <!-- start news source link -->
        <?php if( count($incident_news) > 0 ) { ?>
        <div class="credibility">
            <h5><?php echo Kohana::lang('ui_main.reports_news');?></h5>
            <?php
            foreach( $incident_news as $incident_new)
            {
                ?>
                <a href="<?php echo $incident_new; ?> " target="_blank"><?php
                    echo $incident_new;?></a>
                <br/>
                <?php
            }
            ?>
        </div>
        <?php } ?>
        <!-- end news source link -->


        <?php
        // Action::report_view_sidebar - This gives plugins the ability to insert into the sidebar (below the map and above additional reports)
        Event::run('ushahidi_action.report_view_sidebar', $incident_id);
        ?>

        <div class="report-additional-reports">
            <h4><?php echo Kohana::lang('ui_main.additional_reports');?></h4>
            <?php foreach($incident_neighbors as $neighbor) { ?>
            <div class="rb_report">
                <h5><a href="<?php echo url::site(); ?>reports/view/<?php echo $neighbor->id; ?>"><?php echo $neighbor->incident_title; ?></a></h5>
                <p class="r_date r-3 bottom-cap"><?php echo date('H:i M d, Y', strtotime($neighbor->incident_date)); ?></p>
                <p class="r_location"><?php echo $neighbor->location_name.", ".round($neighbor->distance, 2); ?> Kms</p>
            </div>
            <?php } ?>

    </div>


    <!-- / end DESCRIPTION(DETAILS)-->


<!-- /   right column ends-->

</div>
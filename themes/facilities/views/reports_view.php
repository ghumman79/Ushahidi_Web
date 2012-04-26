<div id="left-col" style="float: left; width:45%; background: #000000" >

    <div class="report-map" style="margin-top: 120px; margin-left: 20px">
    <div class="map-holder" id="map"></div>

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


    </div>
</div>


    <div id="right-col" style="margin-top: 120px; float: right; padding-right: 20px; width:45%; background: #ff0000">
        <div class="report-description-text" >
            <h5><?php echo Kohana::lang('ui_main.reports_description');?></h5>
            <?php echo $incident_description; ?>
            <br/>
        </div>


        <div class="report-additional-reports" style="margin-right: 40px">
            <h4><?php echo Kohana::lang('ui_main.additional_reports');?></h4>
            <?php foreach($incident_neighbors as $neighbor) { ?>
            <div class="rb_report">
                <h5><a href="<?php echo url::site(); ?>reports/view/<?php echo $neighbor->id; ?>"><?php echo $neighbor->incident_title; ?></a></h5>
                <p class="r_date r-3 bottom-cap"><?php echo date('H:i M d, Y', strtotime($neighbor->incident_date)); ?></p>
                <p class="r_location"><?php echo $neighbor->location_name.", ".round($neighbor->distance, 2); ?> Kms</p>
            </div>
            <?php } ?>
        </div>


    </div>



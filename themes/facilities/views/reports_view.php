<div id="middle">


 <div id="left-col" style="float: left; width:45%; background: transparent" >

   <div class="report-map" style="margin-top: 100px; margin-left: 20px; position: fixed;">
    <div class="map-holder" id="map">
        <div class="report-category-list">
            <p>
                <?php
                foreach($incident_category as $category)
                {

                    // don't show hidden categoies
                    if($category->category->category_visible == 0)
                    {
                        continue;
                    }

                    if ($category->category->category_image_thumb)
                    {
                        ?>
                        <a href="<?php echo url::site()."reports/?c=".$category->category->id; ?>"><span class="r_cat-box" style="background:transparent url(<?php echo url::base().Kohana::config('upload.relative_directory')."/".$category->category->category_image_thumb; ?>) 0 0 no-repeat;">&nbsp;</span> <?php echo $category->category->category_title; ?></a>

                        <?php
                    }
                    else
                    {
                        ?>
                        <a href="<?php echo url::site()."reports/?c=".$category->category->id; ?>"><span class="r_cat-box" style="background-color:#<?php echo $category->category->category_color; ?>">&nbsp;</span> <?php echo $category->category->category_title; ?></a>
                        <?php
                    }
                }
                ?>
            </p>
            <?php
            // Action::report_meta - Add Items to the Report Meta (Location/Date/Time etc.)
            Event::run('ushahidi_action.report_meta', $incident_id);
            ?>
        </div>
    </div>

        <div class="<?php if( count($incident_photos) > 0 || count($incident_videos) > 0){ echo "report-media";}?>" style="margin-top: 50px">
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

        <!-- start additional fields -->
        <?php if(strlen($custom_forms) > 0) { ?>
        <div class="credibility">
            <h5><?php echo Kohana::lang('ui_main.additional_data');?></h5>
            <?php

            echo $custom_forms;

            ?>
            <br/>
        </div>
        <?php } ?>
        <!-- end additional fields -->

        <?php if ($features_count)
    {
        ?>
        <br /><br /><h5><?php echo Kohana::lang('ui_main.reports_features');?></h5>
        <?php
        foreach ($features as $feature)
        {
            echo ($feature->geometry_label) ?
                "<div class=\"feature_label\"><a href=\"javascript:getFeature($feature->id)\">$feature->geometry_label</a></div>" : "";
            echo ($feature->geometry_comment) ?
                "<div class=\"feature_comment\">$feature->geometry_comment</div>" : "";
        }
    }?>




    <div style="margin-bottom: 40px">
        <?php
        // Action::report_extra - Allows you to target an individual report right after the description
        Event::run('ushahidi_action.report_extra', $incident_id);

        // Filter::comments_block - The block that contains posted comments
        Event::run('ushahidi_filter.comment_block', $comments);
        echo $comments;
        ?>
    </div>

    <div style="margin-bottom: 20px;>
      <?php
      // Filter::comments_form_block - The block that contains the comments form
      Event::run('ushahidi_filter.comment_form_block', $comments_form);
      echo $comments_form;
      ?>
    </div>

 </div>







    <div id="right-col" style="margin-top: 80px; float: right; padding-right: 20px; width:45%; background: transparent">
        <div class="report-description-text" style="padding-top:2px " >
            <h5><?php echo Kohana::lang('ui_main.reports_description');?></h5>
            <?php echo $incident_description; ?>
            <br/>
        </div>


        <div class="report-category-list">
            <p>
                <?php
                foreach($incident_category as $category)
                {

                    // don't show hidden categoies
                    if($category->category->category_visible == 0)
                    {
                        continue;
                    }

                    if ($category->category->category_image_thumb)
                    {
                        ?>
                        <a href="<?php echo url::site()."reports/?c=".$category->category->id; ?>"><span class="r_cat-box" style="background:transparent url(<?php echo url::base().Kohana::config('upload.relative_directory')."/".$category->category->category_image_thumb; ?>) 0 0 no-repeat;">&nbsp;</span> <?php echo $category->category->category_title; ?></a>

                        <?php
                    }
                    else
                    {
                        ?>
                        <a href="<?php echo url::site()."reports/?c=".$category->category->id; ?>"><span class="r_cat-box" style="background-color:#<?php echo $category->category->category_color; ?>">&nbsp;</span> <?php echo $category->category->category_title; ?></a>
                        <?php
                    }
                }
                ?>
            </p>
            <?php
            // Action::report_meta - Add Items to the Report Meta (Location/Date/Time etc.)
            Event::run('ushahidi_action.report_meta', $incident_id);
            ?>
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
    </div>

</div>



<div id="navigation">
    <ul class="toggle report-list-toggle">
        <li class="active"><a href="#rb_list-view" class="navigation_list"><?php echo Kohana::lang('ui_main.list'); ?></a></li>
        <li><a href="#rb_map-view" class="navigation_map"><?php echo Kohana::lang('ui_main.map'); ?></a></li>
        <li><a href="#rb_gallery-view" class="navigation_gallery">Gallery</a></li>
    </ul>
    <div class="pagination"><?php echo $pagination; ?></div>
    <div class="breadcrumb"><?php echo $stats_breadcrumb; ?></div>
</div>

<div id="reports">
    <div class="rb_list-and-map-box">
        <div id="rb_list-view">
        <?php
            foreach ($incidents as $incident) {
                $incident = ORM::factory('incident', $incident->incident_id);
                $incident_id = $incident->id;
                $incident_title = $incident->incident_title;
                $incident_description = $incident->incident_description;
                $location_id = $incident->location_id;
                $location_name = $incident->location->location_name;
                $incident_thumb = url::file_loc('img')."media/img/report-thumb-default.jpg";
                $media = $incident->media;
                if ($media->count()) {
                    foreach ($media as $photo) {
                        if ($photo->media_thumb) { // Get the first thumb
                            $incident_thumb = url::convert_uploaded_to_abs($photo->media_thumb);
                            break;
                        }
                    }
                }
            ?>
            <div id="<?php echo $incident_id ?>" class="report_card">
                <a title="<?php echo $incident_title; ?>" href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>">
                    <img src="<?php echo $incident_thumb; ?>" />
                </a>
                <div class="report_details">
                    <div class="report_title">
                        <a title="<?php echo $incident_title; ?>" href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>">
                            <?php echo $incident_title; ?>
                        </a>
                    </div>
                    <div class="report_location">
                        <a title="<?php echo $location_name; ?>" href="<?php echo url::site(); ?>reports/?l=<?php echo $location_id; ?>">
                            <?php echo $location_name; ?>
                        </a>
                    </div>
                    <div class="report_categories">
                        <?php foreach ($incident->category as $category): ?>
                        <?php if($category->category_visible == 0) continue; ?>
                        <?php if ($category->category_image_thumb): ?>
                            <?php $category_image = url::base().Kohana::config('upload.relative_directory')."/".$category->category_image_thumb; ?>
                            <a href="<?php echo url::site(); ?>reports/?c=<?php echo $category->id; ?>">
                                <span><img src="<?php echo $category_image; ?>" height="16" width="16" /></span>
                                <span><?php echo $localized_categories[(string)$category->category_title];?></span>
                            </a>
                            <?php else:	?>
                            <a href="<?php echo url::site(); ?>reports/?c=<?php echo $category->id; ?>">
                                <span style="background-color:#<?php echo $category->category_color;?>;"></span>
                                <span><?php echo $localized_categories[(string)$category->category_title];?></span>
                            </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="report_description"><?php echo $incident_description; ?></div>
                    <div class="clearfix"></div>
                </div>
            </div>
        <?php } ?>
        </div>
        <div id="rb_map-view" style="display:none;width:100%;height:900px;margin:0;"></div>
        <div id="rb_gallery-view" style="display:none;">
            <?php
            foreach ($incidents as $incident) {
                $incident = ORM::factory('incident', $incident->incident_id);
                $incident_id = $incident->id;
                $incident_title = $incident->incident_title;
                $incident_description = $incident->incident_description;
                $location_id = $incident->location_id;
                $incident_thumb = url::site() . "/themes/facilities/images/report-gallery.jpg";
                $media = $incident->media;
                if ($media->count()) {
                    foreach ($media as $photo) {
                        if ($photo->media_thumb) { // Get the first thumb
                            $incident_thumb = url::convert_uploaded_to_abs($photo->media_medium);
                            break;
                        }
                    }
                }
                ?>
                <div class="report_thumbnail">
                    <a title="<?php echo $incident_title . ' - ' . $incident_description; ?>" href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>">
                        <img src="<?php echo $incident_thumb; ?>" />
                    </a>
                </div>
                <?php } ?>
        </div>
    </div>
</div>
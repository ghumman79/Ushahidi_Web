<div id="reports" class="scroll">
    <div id="list">
        <?php
            $incidentsCount = count($incidents);
            $incidentIndex = 0;
            foreach ($incidents as $incident) {
                $incidentIndex += 1;
                $incidentPane = ($incidentIndex % 2 == 0) ? "column-right" : "column-left";
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
                        if ($photo->media_thumb) {
                            $incident_thumb = url::convert_uploaded_to_abs($photo->media_thumb);
                            break;
                        }
                    }
                }
            ?>
            <div class="report-item box <?php echo $incidentPane ?>">
                <a title="<?php echo $incident_title; ?>" href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>">
                    <img class="report-image" src="<?php echo $incident_thumb; ?>" />
                </a>
                <div class="report-title">
                    <a title="<?php echo $incident_title; ?>" href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>">
                        <?php echo $incident_title; ?>
                    </a>
                </div>
                <div class="report-categories">
                    <?php foreach ($incident->category as $category): ?>
                        <?php if($category->category_visible == 0) continue; ?>
                        <span class="report-category">
                            <a title="<?php echo $category->category_description;?>" href="<?php echo url::site(); ?>reports/?c=<?php echo $category->id; ?>">
                                <?php if ($category->category_image_thumb): ?>
                                    <img src="<?php echo url::base().Kohana::config('upload.relative_directory')."/".$category->category_image_thumb; ?>" />
                                <?php endif; ?>
                                <span><?php echo $localized_categories[(string)$category->category_title];?></span>
                            </a>
                        </span>
                    <?php endforeach; ?>
                </div>
                <div class="report-location">
                    <?php echo $location_name; ?>
                </div>
                <div class="report-description"><?php echo $incident_description; ?></div>
                <div class="clear"></div>

            </div>
        <?php } ?>
    </div>
    <div id="map" style="display:none;"></div>
    <div id="gallery" style="display:none;">
        <div id="content">
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
                        if ($photo->media_thumb) {
                            $incident_thumb = url::convert_uploaded_to_abs($photo->media_medium);
                            break;
                        }
                    }
                }
                ?>
                <div class="report-thumbnail">
                    <a title="<?php echo $incident_title . ' - ' . $incident_description; ?>"
                       href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>">
                        <img src="<?php echo $incident_thumb; ?>" />
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div id="pagination">
    <ul class="toggle report-list-toggle">
        <li class="active"><a href="#list" class="pagination_list"><?php echo Kohana::lang('ui_main.list'); ?></a></li>
        <li><a href="#map" class="pagination_map"><?php echo Kohana::lang('ui_main.map'); ?></a></li>
        <li><a href="#gallery" class="pagination_gallery">Gallery</a></li>
    </ul>
    <div class="pagination"><?php echo $pagination; ?></div>
    <div class="breadcrumb"><?php echo $stats_breadcrumb; ?></div>
</div>

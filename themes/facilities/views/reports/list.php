<div id="reports" class="scroll">
    <div id="list" style="display:none;">
        <?php
            $incidentsCount = count($incidents);
            $incidentIndex = 0;
            foreach ($incidents as $incident) {
                $incidentIndex += 1;
                $incident = ORM::factory('incident', $incident->incident_id);
                $incident_id = $incident->id;
                $incident_sort = "" . $incidentIndex;
                $incident_title = $incident->incident_title;
                $incident_description = $incident->incident_description;
                $incident_tooltip = $incident_title . '&#13;' . strip_tags(str_replace('<br/>', '&#13;', $incident_description));
                $location_name = $incident->location->location_name;
                $incident_thumb = null;
                if ($incident->media->count()) {
                    foreach ($incident->media as $photo) {
                        if ($photo->media_thumb) {
                            $incident_thumb = url::convert_uploaded_to_abs($photo->media_thumb);
                            break;
                        }
                    }
                }
            ?>
            <div class="report-item box" title="<?php echo $incident_sort; ?>">
                <?php if (!empty($incident_thumb)) { ?>
                    <a title="<?php echo $incident_tooltip; ?>" href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>">
                        <img class="report-image" src="<?php echo $incident_thumb; ?>" />
                    </a>
                <?php } ?>
                <div class="report-title">
                    <a title="<?php echo $incident_tooltip; ?>" href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>">
                        <?php echo $incident_title; ?>
                    </a>
                </div>
                <div class="report-categories">
                    <?php foreach ($incident->category as $category): ?>
                        <?php if($category->category_visible == 0) continue; ?>
                        <span class="category">
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
                $location_name = $incident->location->location_name;
                $incident_tooltip = $incident_title . '&#13;' . strip_tags(str_replace('<br/>', '&#13;', $incident_description));
                $incident_thumb = url::site() . "/themes/facilities/images/placeholder-report.png";
                if ($incident->media->count()) {
                    foreach ($incident->media as $photo) {
                        if ($photo->media_thumb) {
                            $incident_thumb = url::convert_uploaded_to_abs($photo->media_medium);
                            break;
                        }
                    }
                }
                ?>
                <div class="report-thumbnail">
                    <a title="<?php echo $incident_tooltip; ?>"
                       href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>">
                        <?php if ($incident_thumb != null) { ?>
                            <img src="<?php echo $incident_thumb; ?>" />
                        <?php } ?>
                        <div class="report-title"><?php echo $incident_title; ?></div>
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
<script type="text/javascript">
<?php
    $reports = array();
    foreach ($incidents as $incident) {
        $incident = ORM::factory('incident', $incident->incident_id);
        $item = array();
        $item['id'] = $incident->id;
        $item['date'] = date('H:ia F j, Y', strtotime($incident->incident_date));
        $item['link'] = url::site().'reports/view/'.$incident->id;
        $item['title'] = $incident->incident_title;
        $item['description'] = $incident->incident_description;
        $item['location'] = $incident->location->location_name;
        $item['latitude'] = $incident->location->latitude;
        $item['longitude'] = $incident->location->longitude;
        if ($incident->media->count()) {
            foreach ($incident->media as $media) {
                if ($media->media_thumb) {
                    $item['thumb'] = url::convert_uploaded_to_abs($media->media_thumb);
                    break;
                }
            }
            $photos = array();
            foreach ($incident->media as $media) {
                $photo = array();
                if ($media->media_thumb) {
                    $photo['thumb'] = $media->media_thumb;
                }
                if ($media->media_link) {
                    $photo['large'] = $media->media_link;
                }
                array_push($photos, $photo);
            }
            $item['photos'] = $photos;
        }
        $categories = array();
        foreach ($incident->category as $category) {
            $cat = array();
            $cat['id'] = $category->id;
            $cat['title'] = $category->category_title;
            $cat['color'] = "#".$category->category_color;
            $cat['description'] = $category->category_description;
            if ($category->category_image_thumb) {
                $cat['image'] = url::convert_uploaded_to_abs($category->category_image);
                $cat['thumb'] = url::convert_uploaded_to_abs($category->category_image_thumb);
                $item['icon'] = url::convert_uploaded_to_abs($category->category_image);
            }
            array_push($categories, $cat);
        }
        $item['categories'] = $categories;
        array_push($reports, $item);
    }
?>
    var $INCIDENTS = <?php echo json_encode($reports); ?>;
</script>

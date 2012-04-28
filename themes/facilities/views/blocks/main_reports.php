<div></div>
<ul class="column">
    <li class="title">Facilities</li>
    <?php
    if ($total_items == 0) {
        ?>
    <li>No facilities</li>
        <?php
    }
    foreach ($incidents as $incident) {
        $incident_id = $incident->id;
        $incident_title = $incident->incident_title;
        $location_id = $incident->location->id;
        $location_name = $incident->location->location_name;
        ?>
    <li>
        <a href="<?php echo url::site() . 'reports/view/' . $incident_id; ?>">
            <?php echo $incident_title ?>
        </a>
        -
        <a href="<?php echo url::site() . 'reports/?l=' . $location_id; ?>">
            <?php echo $location_name ?>
        </a>
    </li>
        <?php
    }
    ?>
<li>
    <a href="<?php echo url::site() . 'reports/' ?>"><?php echo Kohana::lang('ui_main.view_more'); ?></a>
</li>
</ul>
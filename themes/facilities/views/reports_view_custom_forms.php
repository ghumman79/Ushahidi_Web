<?php if (count($form_field_names) > 0) { ?>
<?php
foreach ($form_field_names as $field_id => $field_property) {

//    if ($field_property['field_type'] == 8) {
//        if (isset($field_propeerty['field_default'])) {
//            echo "<div class=\"" . $field_property['field_name'] . "\">";
//        }
//        else {
//            echo "<div class=\"custom_div\">";
//        }
//        echo "<h2>" . $field_property['field_name'] . "</h2>";
//        continue;
//    }
//    elseif ($field_property['field_type'] == 9) {
//        continue;
//    }
//
//    // Get the value for the form field
    $value = $field_property['field_response'];

    // Check if a value was fetched
    if ($value == "")
        continue;

    echo '<div class="report_nearby box_light" style="height:20px;">';

    if ($field_property['field_type'] == 1 OR $field_property['field_type'] > 3) {
        // Text Field
        echo '<div class="report_nearby_title">'.html::specialchars($field_property['field_name']).'</div>';
        echo '<div class="report_nearby_location">'.$value.'</div>';
    }
    elseif ($field_property['field_type'] == 2) {
        // TextArea Field
        echo '<div class="report_nearby_title">'.html::specialchars($field_property['field_name']).'</div>';
        echo '<div class="report_nearby_location">'.$value.'</div>';
    }
    elseif ($field_property['field_type'] == 3) {
        echo '<div class="report_nearby_title">'.html::specialchars($field_property['field_name']).'</div>';
        echo '<div class="report_nearby_location">'.date('M d Y', strtotime($value)).'</div>';
    }
    echo '</div>';
}
?>
<?php } ?>
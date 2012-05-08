<div class="map">
    <?php $css_class = (isset($css_class))? $css_class : "map-holder"; ?>
    <div class="<?php echo $css_class; ?>" id="divMap"></div>
</div>
<div class="alert_slider">
    <select name="alert_radius" id="alert_radius" style="visibility:hidden;">
        <option value="1">1 KM</option>
        <option value="5">5 KM</option>
        <option value="10">10 KM</option>
        <option value="20" selected="selected">20 KM</option>
        <option value="50">50 KM</option>
        <option value="100">100 KM</option>
    </select>
</div>
<?php if ($enable_find_location): ?>
<div class="alert_location">
    <div class="alert_location_left">
        <div>
            <?php print form::input('location_find', '', ' title="City, State and/or Country" class="findtext"'); ?>
        </div>
    </div>
    <div class="alert_location_right">
        <input type="button" name="button" id="button" value="<?php echo Kohana::lang('ui_main.find_location'); ?>" class="btn_find" />
        <div id="find_loading" class="report-find-loading"></div>
    </div>
</div>
<?php endif; ?>
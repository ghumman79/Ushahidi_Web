<div id="middle">
    <div id="filters">
        <?php
            foreach (Kohana::config('settings.categories') as $category) {
                echo '<ul class="categories">';
                echo '<li class="parent"><a id="category_' . $category->id . '" title="'. $category->category_description . '">';
                if ($category->category_image_thumb != NULL) {
                    echo '<img src="' . url::convert_uploaded_to_abs($category->category_image_thumb) . '"/>';
                }
                echo $category->category_title . '</a></li>';
                foreach ($category->children as $child) {
                    echo '<li><a id="category_' . $child->id . '" title="'. $child->category_description . '">';
                    if ($child->category_image_thumb != NULL) {
                        echo '<img src="' . url::convert_uploaded_to_abs($child->category_image_thumb) . '"/>';
                    }
                    echo $child->category_title . '</a></li>';
                }
                echo '</ul>';
            }
            ?>
    </div>

    <div id="reports-box">
        <?php echo $report_listing_view; ?>
    </div>

</div>
<script type="text/javascript">
    var $PHRASES = <?php echo json_encode(
        array('server' => url::site(),
              'reports' => Kohana::lang('ui_main.reports'),
              'checkins' => Kohana::lang('ui_admin.checkins'))); ?>;
    $(function(){
        $(window).resize(function() {
            adjustCategories();
            splitListView();
        });
        markSelectedCategories();
        adjustCategories();
        attachCategorySelected();
        addReportViewOptionsEvents();
        removeListStrFromBreadcrumb();
        loadSelectedViewFromHashTag();
    });
<?php
    $layers = array();
    foreach (ORM::factory('layer')->where('layer_visible', 1)->find_all() as $layer) {
        $lay = array();
        $lay['id'] = $layer->id;
        $lay['name'] = $layer->layer_name;
        $lay['color'] = $layer->layer_color;
        if ($layer->layer_url) {
            $lay['url'] = $layer->layer_url;
        }
        else {
            $lay['url'] = url::convert_uploaded_to_abs($layer->layer_file);
        }
        array_push($layers, $lay);
    } ?>
    var $LAYERS = <?php echo json_encode($layers); ?>;
</script>
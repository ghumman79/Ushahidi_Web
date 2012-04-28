<div id="middle">
    <div id="reports-box">
        <?php echo $report_listing_view; ?>
    </div>
    <div id="categories">
        <ul>
            <?php echo $category_tree_view; ?>
        </ul>
    </div>

    <?php
    // Action, allows plugins to add custom filters
    Event::run('ushahidi_action.report_filters_ui');
    ?>

    <div class="hidden">
        <?php
        // Filter::report_stats - The block that contains reports list statistics
        Event::run('ushahidi_filter.report_stats', $report_stats);
        echo $report_stats; ?>
    </div>

    <script type="text/javascript">
        $(function(){
            $(".cat_selected").click(function(){
                if ($(this).hasClass("selected")) {
                    $(this).removeClass("selected");
                    $(this).parent().removeClass("selected");
                }
                else {
                    $(this).addClass("selected");
                    $(this).parent().addClass("selected");
                }
                var category_ids = [];
                $.each($("#categories li a.selected"), function(i, item){
                    itemId = item.id.substring("filter_link_cat_".length);
                    category_ids.push(itemId);
                });
                if (category_ids.length > 0) {
                    urlParameters["c"] = category_ids;
                }
                else {
                    urlParameters = [];
                }
                fetchReports();
            });
        });
    </script>
</div>
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
            var active;
            $(".cat_selected").click(function(){
                $.each($(".report-list-toggle .active a"), function(i, item){
                    active = item.href;
                });
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
                    urlParameters["c"] = category_ids.join();
                }
                else {
                    urlParameters = [];
                }
                $.each($(".report-list-toggle .active a"), function(i, item){
                    //alert(item.href);
                });

                mapLoaded = 0;

                var loadingURL = "<?php echo url::file_loc('img').'media/img/loading_g.gif'; ?>";
                var statusHtml = "<div style=\"width: 100%; margin-top: 100px;\" align=\"center\">" +
                    "<div><img src=\""+loadingURL+"\" border=\"0\"></div>" +
                    "<p style=\"padding: 10px 2px;\"><h3><?php echo Kohana::lang('ui_main.loading_reports'); ?>...</h3></p>" +
                    "</div>";

                $("#reports-box").html(statusHtml);

                // Check if there are any parameters
                if ($.isEmptyObject(urlParameters))
                {
                    urlParameters = {show: "all"}
                }

                // Get the content for the new page
                $.get('<?php echo url::site().'reports/fetch_reports'?>',
                    urlParameters,
                    function(data) {
                        if (data != null && data != "" && data.length > 0) {
                            setTimeout(function(){
                                $("#reports-box").html(data);
                                attachPagingEvents();
                                addReportHoverEvents();
                                deSelectedFilters = [];
                                debugger;
                                if (active.search('#rb_list-view') > 0) {
                                    switchViews($("#navigation .report-list-toggle .navigation_list"));
                                }
                                else if (active.search('#rb_map-view') > 0) {
                                    switchViews($("#navigation .report-list-toggle .navigation_map"));
                                }
                                else if (active.search('#rb_gallery-view') > 0) {
                                    switchViews($("#navigation .report-list-toggle .navigation_gallery"));
                                }
                            }, 400);
                        }
                    }
                );
            });
        });
    </script>
</div>
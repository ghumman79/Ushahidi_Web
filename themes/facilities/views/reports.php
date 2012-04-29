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
        function resizeListItems() {
            var min_height = 999;
            $(".report_card").each(function (index) {
                var element_height = $(this).height();
                if (element_height < min_height) {
                    min_height = element_height;
                }
            });
            $(".report_card").each(function (index) {
                var element_height = $(this).height();
                if (element_height > min_height) {
                    $(this).css("height", ((min_height + 20) * 2 ) + 12);
                }
            });
        }
        $(function(){
            var active;
            if($(".report-list-toggle .active a").hasClass("navigation_list")){
                resizeListItems();
            }
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
                                if (active.search('#rb_list-view') > 0) {
                                    switchViews($("#navigation .report-list-toggle .navigation_list"));
                                    resizeListItems();
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

        function onFeatureSelect(event) {
            selectedFeature = event.feature;
            zoom_point = event.feature.geometry.getBounds().getCenterLonLat();
            lon = zoom_point.lon;
            lat = zoom_point.lat;
            if (event.feature.popup != null) {
                map.removePopup(event.feature.popup);
            }
            $.get('<?php echo url::site().'api?task=incidents&by=incidentid&id='?>' + event.feature.attributes.id,
                null, function(json) {
                    if (json.payload.incidents.length > 0) {
                        var incidents = json.payload.incidents;
                        var incident = incidents[0].incident;

                        var content = "<div id=\"popup\">";
                        if (incidents[0].media.length > 0) {
                            var media = incidents[0].media[0];
                            content += "<div id=\"popup_image\">";
                            content += "<a title=\"" + incident.incidenttitle + "\" href=\"/reports/view/" + incident.incidentid + "\">";
                            content += "<img src=\"/media/uploads/" + media.thumb + "\" height=\"59\" width=\"89\" />";
                            content += "</a></div>";
                        }
                        content += "<div id=\"popup_title\">" + event.feature.attributes.name + "</div>";
                        if (incidents[0].categories.length > 0) {
                            content += "<div id=\"popup_category\">";
                            var categories = incidents[0].categories;
                            for (var i = 0; i < categories.length; i++) {
                                if (i > 0) {
                                    content += ", ";
                                }
                                content += categories[0].category.title;
                            }
                            content += "</div>";
                        }
                        if (incident.locationname && incident.locationname!='') {
                            content += "<div id=\"popup_location\">" + incident.locationname + "</div>";
                        }
                        if (incident.incidentdescription && incident.incidentdescription!='') {
                            content += "<div id=\"popup_description\">" + incident.incidentdescription + "</div>";
                        }
                        content += "<div style=\"clear:both;\"></div></div>";

                        popup = new OpenLayers.Popup.FramedCloud("popup",
                            event.feature.geometry.getBounds().getCenterLonLat(),
                            new OpenLayers.Size(200,300),
                            content,
                            null, true, onPopupClose);
                        event.feature.popup = popup;
                        map.addPopup(popup);
                    }
                }
            );
        }
    </script>
</div>
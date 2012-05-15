<div id="middle">
    <div id="filters">
        <ul>
            <?php echo $category_tree_view; ?>
        </ul>
    </div>

    <div id="reports-box">
        <?php echo $report_listing_view; ?>
    </div>

    <?php Event::run('ushahidi_action.report_filters_ui'); ?>

    <div class="hidden">
        <?php
        // Filter::report_stats - The block that contains reports list statistics
        Event::run('ushahidi_filter.report_stats', $report_stats);
        echo $report_stats; ?>
    </div>

    <script type="text/javascript">
        $(function(){
            splitParentCategories();
            $(window).resize(function() {
                adjustCategories();
            });
            adjustCategories();
            attachCategorySelected();
            removeListStrFromBreadcrumb();
            splitListView();
        });
        function splitParentCategories() {
            var $categoryDiv = $("div#filters");
            var $categoryList = $categoryDiv.find("ul");
            var $ul;
            $categoryList.children().each(function (item) {
                if (!($(this).hasClass("report-listing-category-child"))) {
                    $ul = $("<ul>");
                    $ul.appendTo($categoryDiv);
                }
                $(this).appendTo($ul);
            });
            $categoryList.remove();
        }
        function splitListView() {
            var $listView = $("div#rb_list-view");
            var $leftPane = $("<div id='column-left' class='column'>");
            var $rightPane = $("<div id='column-right' class='column'>");
            $('.column-left').each(function (item) {
                $(this).appendTo($rightPane);
            });
            $('.column-right').each(function (item) {
                $(this).appendTo($leftPane);
            });
            $leftPane.appendTo($listView);
            $rightPane.appendTo($listView);
        }
        function adjustCategories() {
            var $top = $("#filters").css('height');
            $("#reports").css('top', $top);
        }
        function removeListStrFromBreadcrumb() {
            var $divBreadcrumb = $("div.breadcrumb");
            var strBreadcrumb = $divBreadcrumb.html();
            $("div.breadcrumb").html(strBreadcrumb.replace(" List", ""));
        }
        function addReportViewOptionsEvents() {
            $("#pagination .report-list-toggle a").click(function(){
                return switchViews($(this));
            });
        }
        function fetchReports() {
            var activeView;
            var categoryIDs = [];
            $.each($("#filters li a.selected"), function(i, item){
                var itemId = item.id.substring("filter_link_cat_".length);
                categoryIDs.push(itemId);
            });
            if (categoryIDs.length > 0) {
                urlParameters["c"] = categoryIDs.join();
            }
            $.each($(".report-list-toggle .active a"), function(i, item){
                activeView = item.href;
            });
            $("#reports-box").html("<img id=\"loading\" src=\"/themes/facilities/images/loading_large.gif\" border=\"0\"/>");
            if ($.isEmptyObject(urlParameters)) {
                urlParameters = {show: "all"}
            }
            //alert(JSON.stringify(urlParameters));
            $.get('<?php echo url::site().'reports/fetch_reports'?>',
                urlParameters,
                function(data) {
                    if (data != null && data != "" && data.length > 0) {
                        setTimeout(function(){
                            $("#reports-box").html(data);
                            attachPagingEvents();
                            adjustCategories();
                            if (activeView.search('#rb_list-view') > 0) {
                                switchViews($("#pagination .pagination_list"));
                            }
                            else if (activeView.search('#rb_map-view') > 0) {
                                switchViews($("#pagination .pagination_map"));
                            }
                            else if (activeView.search('#rb_gallery-view') > 0) {
                                switchViews($("#pagination .pagination_gallery"));
                            }
                            splitListView();
                        }, 400);
                    }
                }
            );
        }
        function attachCategorySelected() {
            $(".cat_selected").click(function(){
                if ($(this).hasClass("selected")) {
                    $(this).removeClass("selected");
                    $(this).parent().removeClass("selected");
                    if(! ($(this).parent().hasClass('report-listing-category-child'))){
                        $(this).parent().parent().children().each(function(){
                            $(this).removeClass("selected");
                            $(this).find("a").removeClass("selected");
                        });
                    }
                }
                else {
                    $(this).addClass("selected");
                    $(this).parent().addClass("selected");
                    if(! ($(this).parent().hasClass('report-listing-category-child'))){
                        $(this).parent().parent().children().each(function(){
                            $(this).addClass("selected");
                            $(this).find("a").addClass("selected");
                        });
                    }
                }
                fetchReports();
            });
        }
        function attachPagingEvents() {
            addReportViewOptionsEvents();
            $("ul.pager a").attr("href", "#");
            $("ul.pager a").click(function() {
                urlParameters["page"] = $(this).html();
                fetchReports();
                return false;

            });
            $("td.last li a").click(function(){
                pageNumber = $(this).attr("id").substr("page_".length);
                if (Number(pageNumber) > 0) {
                    urlParameters["page"] = Number(pageNumber);
                    fetchReports();
                }
                return false;
            });
            return false;
        }
        function switchViews(view) {
            $("#rb_list-view, #rb_map-view, #rb_gallery-view").hide();
            $($(view).attr("href")).show();
            $("#pagination .report-list-toggle a").parent().removeClass("active");
            $("."+$(view).attr("class")).parent().addClass("active");
            if ($("#rb_map-view").css("display") == "block") {
                $("#reports").removeClass("scroll");
                $("#reports").css("overflow-y","hidden");
                urlParameters["page"] = $(".pager li a.active").html();
                if ($('#rb_map-view').children().length == 0) {
                    createIncidentMap();
                }
                setTimeout(function(){showIncidentMap();}, 400);
                setTimeout(function(){showCheckins();}, 400);
            }
            else {
                $("#reports").addClass("scroll");
                $("#reports").css("overflow-y","auto");
            }
            return false;
        }
        function showCheckins() {
            $(document).ready(function(){
                var ci_styles = new OpenLayers.StyleMap({
                    "default": new OpenLayers.Style({
                        pointRadius: "5",
                        fillColor: "${fillcolor}",
                        strokeColor: "${strokecolor}",
                        fillOpacity: "${fillopacity}",
                        strokeOpacity: 0.75,
                        strokeWidth: 1.5
                    })
                });

                var checkinLayer = new OpenLayers.Layer.Vector('<?php echo Kohana::lang('ui_admin.checkins')?>', {styleMap: ci_styles});
                map.addLayers([checkinLayer]);

                var highlightControl = new OpenLayers.Control.SelectFeature(checkinLayer, {
                    hover: true,
                    highlightOnly: true,
                    renderIntent: "temporary"
                });
                map.addControl(highlightControl);
                highlightControl.activate();

                var selectControls = [];
                $.each(map.layers, function(i, layer) {
                    if (layer.name  == '<?php echo Kohana::lang('ui_main.reports')?>') {
                        selectControls.push(layer);
                        layer.events.on({
                            "featureselected": showReportData,
                            "featureunselected": onFeatureUnselect
                        });
                    }
                    else if (layer.name == '<?php echo Kohana::lang('ui_admin.checkins')?>') {
                        selectControls.push(layer);
                        layer.events.on({
                            "featureselected": showCheckinData,
                            "featureunselected": onFeatureUnselect
                        });
                    }
                });

                var selectControl = new OpenLayers.Control.SelectFeature(selectControls);
                map.addControl(selectControl);
                selectControl.activate();

                $.getJSON("<?php echo url::site()."api/?task=checkin&action=get_ci&mapdata=1&sqllimit=1000&orderby=checkin.checkin_date&sort=ASC"?>", function(data) {
                    var user_colors = new Array();
                    $.each(data["payload"]["users"], function(i, payl) {
                        user_colors[payl.id] = payl.color;
                    });
                    $.each(data["payload"]["checkins"], function(key, ci) {
                        var cipoint = new OpenLayers.Geometry.Point(parseFloat(ci.lon), parseFloat(ci.lat));
                        cipoint.transform(proj_4326, proj_900913);
                        var media_link = '';
                        var media_medium = '';
                        var media_thumb = '';
                        if(ci.media === undefined) {
                            // No image
                        }
                        else {
                            // Image!
                            media_link = ci.media[0].link;
                            media_medium = ci.media[0].medium;
                            media_thumb = ci.media[0].thumb;
                        }
                        var checkinPoint = new OpenLayers.Feature.Vector(cipoint, {
                            fillcolor: "#"+user_colors[ci.user],
                            strokecolor: "#FFFFFF",
                            fillopacity: ci.opacity,
                            ci_id: ci.id,
                            ci_msg: ci.msg,
                            ci_media_link: media_link,
                            ci_media_medium: media_medium,
                            ci_media_thumb: media_thumb
                        });
                        checkinLayer.addFeatures([checkinPoint]);
                    });
                });
            });
        }

        function showReportData(event) {
            selectedFeature = event.feature;
            zoom_point = event.feature.geometry.getBounds().getCenterLonLat();
            lon = zoom_point.lon;
            lat = zoom_point.lat;
            if (event.feature.popup != null) {
                map.removePopup(event.feature.popup);
            }
            $.get('<?php echo url::site().'api?task=incidents&by=incidentid&id='?>' + event.feature.attributes.id, null, function(json) {
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

        function showCheckinData(event) {
            selectedFeature = event.feature;
            zoom_point = event.feature.geometry.getBounds().getCenterLonLat();
            lon = zoom_point.lon;
            lat = zoom_point.lat;

            var content = "<div class=\"infowindow\" style=\"color:#000000\"><div class=\"infowindow_list\">";
            if(event.feature.attributes.ci_media_medium !== "") {
                content += "<a href=\""+event.feature.attributes.ci_media_link+"\" rel=\"lightbox-group1\" title=\""+event.feature.attributes.ci_msg+"\">";
                content += "<img src=\""+event.feature.attributes.ci_media_medium+"\" /><br/>";
            }

            content += event.feature.attributes.ci_msg+"</div><div style=\"clear:both;\"></div>";
            content += "<div class=\"infowindow_meta\">";
            content += "</div>";

            if (content.search("<?php echo '<'; ?>script") != -1) {
                //content = "Content contained Javascript! Escaped content below.<br />" + content.replace(/<?php echo '<'; ?>/g, "&lt;");
            }

            popup = new OpenLayers.Popup.FramedCloud("chicken",
                event.feature.geometry.getBounds().getCenterLonLat(),
                new OpenLayers.Size(100,100),
                content,
                null, true, onPopupClose);
            event.feature.popup = popup;
            map.addPopup(popup);
        }
    </script>
</div>
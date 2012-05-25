function loadSelectedViewFromHashTag() {
    if (window.location.hash == "#map") {
        switchViews($("#pagination .pagination_map"));
    }
    else if (window.location.hash == "#list") {
        switchViews($("#pagination .pagination_list"));
    }
    else if (window.location.hash == "#gallery") {
        switchViews($("#pagination .pagination_gallery"));
    }
    else {
        splitListView();
    }
}
function splitParentCategories() {
    var $categoryDiv = $("div#filters");
    var $categoryList = $categoryDiv.find("ul");
    $categoryList.css("visibility","hidden");
    var $ul;
    $categoryList.children().each(function (item) {
        if (!($(this).hasClass("report-listing-category-child"))) {
            $ul = $("<ul>");
            $ul.appendTo($categoryDiv);
        }
        $(this).appendTo($ul);
    });
    $categoryList.remove();
    $categoryList.css("visibility","visible");
}
function splitListView() {
    var $listView = $("div#list");
    if (!/android|iphone|ipod|series60|symbian|windows ce|blackberry/i.test(navigator.userAgent)) {
        if ($("#column-left").length == 0 &&
            $("#column-right").length == 0) {
            $listView.css("visibility", "hidden");
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
            $listView.css("visibility", "visible");
        }
    }
    else {
        $listView.css("visibility", "visible");
    }
}
function adjustCategories() {
    var $top = $("#filters").css('height');
    $("#reports").css('top', $top);
}
function removeListStrFromBreadcrumb() {
    var $divBreadcrumb = $("div.breadcrumb");
    var strBreadcrumb = $divBreadcrumb.html();
    if (strBreadcrumb) {
        $("div.breadcrumb").html(strBreadcrumb.replace(" List", ""));
    }
}
function addReportViewOptionsEvents() {
    $("#pagination .report-list-toggle a").click(function(){
        return switchViews($(this));
    });
}
function fetchReports() {
    var activeView;
    $.each($(".report-list-toggle .active a"), function(i, item){
        activeView = item.href;
    });
    var categoryIDs = [];
    $.each($("#filters li a.selected"), function(i, item){
        var itemId = item.id.substring("filter_link_cat_".length);
        categoryIDs.push(itemId);
    });
    if (categoryIDs.length > 0) {
        urlParameters["c"] = categoryIDs.join();
    }
    else {
        delete urlParameters["c"];
    }
    if ($.isEmptyObject(urlParameters)) {
        urlParameters = {show: "all"}
    }
    $("#pagination").css("display", "none");
    $("#reports").css("bottom", "0");
    $("#reports").html("<img id=\"loading\" src=\"/themes/facilities/images/loading_large.gif\" border=\"0\"/>");
    $.get('/reports/fetch_reports',
        urlParameters,
        function(data) {
            if (data != null && data != "" && data.length > 0) {
                setTimeout(function(){
                    $("#reports-box").html(data);
                    attachPagingEvents();
                    adjustCategories();
                    if (activeView.search('#list') > 0) {
                        switchViews($("#pagination .pagination_list"));
                    }
                    else if (activeView.search('#map') > 0) {
                        switchViews($("#pagination .pagination_map"));
                    }
                    else if (activeView.search('#gallery') > 0) {
                        switchViews($("#pagination .pagination_gallery"));
                    }
                }, 400);
            }
        }
    );
}
function attachCategorySelected() {
    $("#filters li a").click(function(){
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
    $("#list, #map, #gallery").hide();
    $("#pagination .report-list-toggle li").removeClass("active");
    $($(view).attr("href")).show();
    $(view).parent().addClass("active");
    if ($(view).attr("href") == "#map") {
        $("#reports").removeClass("scroll");
        $("#reports").css("overflow-y","hidden");
        urlParameters["page"] = $(".pager li a.active").html();
        if ($('#map').children().length == 0) {
            createIncidentMap();
        }
        setTimeout(function(){showIncidentMap();}, 400);
        setTimeout(function(){showCheckins();}, 400);
    }
    else if ($(view).attr("href") == "#list") {
        $("#reports").addClass("scroll");
        $("#reports").css("overflow-y","auto");
        splitListView();
    }
    else if ($(view).attr("href") == "#gallery") {
        $("#reports").addClass("scroll");
        $("#reports").css("overflow-y","auto");
    }
    return false;
}
function showIncidentMap() {
    $.each($LAYERS, function(i, layer) {
        var kmlLayers = map.getLayersByName(layer.name);
        for (var j = 0; j < kmlLayers.length; j++) {
            map.removeLayer(kmlLayers[j]);
        }
        var kmlLayer = new OpenLayers.Layer.Vector(layer.name, {
            projection: map.displayProjection,
            strategies: [new OpenLayers.Strategy.Fixed()],
            protocol: new OpenLayers.Protocol.HTTP({
                url: layer.url,
                format: new OpenLayers.Format.KML({
                    extractStyles: true,
                    extractAttributes: true})
            })
        });
        map.addLayer(kmlLayer);
        addFeatureSelectionEvents(map, kmlLayer);
    });

    var currentLayers = map.getLayersByName($PHRASES.reports);
    for (var i = 0; i < currentLayers.length; i++) {
        map.removeLayer(currentLayers[i]);
    }
    var reportLayer = new OpenLayers.Layer.Vector($PHRASES.reports, {
        projection: map.displayProjection,
        extractAttributes: true,
        styleMap: new OpenLayers.StyleMap({
            'default' : new OpenLayers.Style({
                cursor: "pointer",
                graphicOpacity: 0.8,
                graphicWidth: 30,
                graphicHeight: 30,
                externalGraphic: "${externalGraphic}"
            })})
    });
    map.addLayer(reportLayer);
    addFeatureSelectionEvents(map, reportLayer);

    $.each($INCIDENTS, function(i, incident) {
        var point = new OpenLayers.Geometry.Point(parseFloat(incident.longitude), parseFloat(incident.latitude));
        point.transform(proj_4326, proj_900913);
        var externalGraphic = "/themes/facilities/images/report.png";
        if (incident.icon) {
            externalGraphic = incident.icon;
        }
        var vector = new OpenLayers.Feature.Vector(point, {
            id:incident.id,
            link:incident.link,
            date:incident.date,
            title:incident.title,
            description:incident.description,
            location:incident.location,
            latitude:incident.latitude,
            longitude:incident.longitude,
            categories:incident.categories,
            photos:incident.photos,
            externalGraphic:externalGraphic
        });
        reportLayer.addFeatures([vector]);
    });
}
function showCheckins() {
    $(document).ready(function(){
        var checkinStyles = new OpenLayers.StyleMap({
            "default": new OpenLayers.Style({
                cursor: "pointer",
                graphicOpacity: 0.8,
                graphicWidth: 30,
                graphicHeight: 30,
                externalGraphic: "/themes/facilities/images/checkin.png"
            })
        });

        var currentLayers = map.getLayersByName($PHRASES.checkins);
        for (var i = 0; i < currentLayers.length; i++){
            map.removeLayer(currentLayers[i]);
        }

        var checkinLayer = new OpenLayers.Layer.Vector($PHRASES.checkins, {styleMap: checkinStyles});
        map.addLayers([checkinLayer]);

        var selectControls = [];
        $.each(map.layers, function(i, layer) {
            if (layer.name  === $PHRASES.reports) {
                selectControls.push(layer);
                layer.events.on({
                    "featureselected": showReportData,
                    "featureunselected": onFeatureUnselect
                });
            }
            else if (layer.name === $PHRASES.checkins) {
                selectControls.push(layer);
                layer.events.on({
                    "featureselected": showCheckinData,
                    "featureunselected": onFeatureUnselect
                });
            }
            else  {
                $.each($LAYERS, function(i, item) {
                    if (layer.name === item.name) {
                        selectControls.push(layer);
                        layer.events.on({
                            "featureselected": onFeatureSelect,
                            "featureunselected": onFeatureUnselect
                        });
                    }
                });
            }
        });
        var selectFeatures = new OpenLayers.Control.SelectFeature(selectControls);
        map.addControl(selectFeatures);
        selectFeatures.activate();

        $.getJSON("/api/?task=checkin&action=get_ci&mapdata=1&sqllimit=1000&orderby=checkin.checkin_date&sort=ASC", function(data) {
            if (data && data["payload"]["checkins"]) {
                $.each(data["payload"]["checkins"], function(key, checkin) {
                    var checkinPoint = new OpenLayers.Geometry.Point(parseFloat(checkin.lon), parseFloat(checkin.lat));
                    checkinPoint.transform(proj_4326, proj_900913);
                    var media_link = '';
                    var media_medium = '';
                    var media_thumb = '';
                    if (checkin.media !== undefined) {
                        media_link = checkin.media[0].link;
                        media_medium = checkin.media[0].medium;
                        media_thumb = checkin.media[0].thumb;
                    }
                    var checkinVector = new OpenLayers.Feature.Vector(checkinPoint, {
                        ci_id: checkin.id,
                        ci_msg: checkin.msg,
                        ci_media_link: media_link,
                        ci_media_medium: media_medium,
                        ci_media_thumb: media_thumb
                    });
                    checkinLayer.addFeatures([checkinVector]);
                });
            }
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
    var content = "<div id=\"popup\">";
    var incident = event.feature.attributes;
    if (incident.photos && incident.photos.length > 0) {
        var photo = incident.photos[0];
        content += "<div id=\"popup-image\">";
        content += "<a title=\"" + incident.title + "\" href=\"/reports/view/" + incident.id + "\">";
        content += "<img src=\"/media/uploads/" + photo.thumb + "\" height=\"59\" width=\"89\" />";
        content += "</a></div>";
    }
    content += "<div id=\"popup-title\">";
    content += "<a title=\"" + incident.title + "\" href=\"/reports/view/" + incident.id + "\">" + incident.title + "</a></div>";
    if (incident.categories && incident.categories.length > 0) {
        content += "<div id=\"popup-category\">";
        $.each(incident.categories, function(i, category) {
            content += "<span>";
            if (category.thumb) {
                content += "<img src=\"" + category.thumb + "\"/>";
            }
            content += category.title + "</span>";
        });
        content += "</div>";
    }
    if (incident.location && incident.location!='') {
        content += "<div id=\"popup-location\">" + incident.location + "</div>";
    }
    if (incident.description && incident.description!='') {
        content += "<div id=\"popup-description\">" + incident.description + "</div>";
    }
    content += "<div style=\"clear:both;\"></div></div>";
    var popup = new OpenLayers.Popup.FramedCloud("popup",
        event.feature.geometry.getBounds().getCenterLonLat(),
        new OpenLayers.Size(200,300),
        content,
        null, true, onPopupClose);
    event.feature.popup = popup;
    map.addPopup(popup);
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

    popup = new OpenLayers.Popup.FramedCloud("chicken",
        event.feature.geometry.getBounds().getCenterLonLat(),
        new OpenLayers.Size(100,100),
        content,
        null, true, onPopupClose);
    event.feature.popup = popup;
    map.addPopup(popup);
}
function createIncidentMap() {
    map = createMap('map', latitude, longitude, defaultZoom);
    map.addControl(new OpenLayers.Control.LoadingPanel({minSize: new OpenLayers.Size(573, 366)}) );
}
function markSelectedCategories() {
    var parameters = getParameter('c');
    if (parameters) {
        var items = parameters.split(',');
        for(var i = 0; i < items.length; i++){
            var category = $("#filter_link_cat_" + items[i]);
            category.addClass("selected");
            category.parent().addClass("selected");
        }
    }
}
function getParameter(name) {
   return decodeURI((RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
}
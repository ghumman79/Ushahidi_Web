<div id="main-reports" class="column">
    <div class="box">
        <?php if ( Kohana::config('settings.checkins') ) { ?>
            <h3><?php echo Kohana::lang('ui_admin.checkins'); ?></h3>
            <ul></ul>
        <?php } else { ?>
            <h3><?php echo Kohana::lang('ui_admin.reports'); ?></h3>
            <ul>
            <?php
            if ($total_items == 0) {
                ?>
                <li><?php echo Kohana::lang('ui_main.no_reports'); ?></li>
                <?php
            }
            foreach ($incidents as $incident) {
                $incident_id = $incident->id;
                $incident_title = $incident->incident_title;
                $incident_description = strip_tags($incident->incident_description);
                $location_id = $incident->location->id;
                $location_name = $incident->location->location_name;
                ?>
                <li>
                    <a title="<?php echo $incident_description; ?>" href="<?php echo url::site() . 'reports/view/' . $incident_id; ?>">
                        <?php echo $incident_title ?>
                    </a>
                    <span>(<?php echo $location_name; ?>)</span>
                </li>
            <?php } ?>
            <li class="more">
                <a href="<?php echo url::site() . 'reports/' ?>"><?php echo Kohana::lang('ui_main.view_more'); ?></a>
            </li>
            </ul>
        <?php } ?>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">
    <?php if (Kohana::config('settings.checkins')) { ?>
    function cilisting(sqllimit,sqloffset) {
        $.getJSON("<?php echo url::site(); ?>api/?task=checkin&action=get_ci&sqllimit="+sqllimit+"&sqloffset="+sqloffset+"&orderby=checkin.checkin_date&sort=DESC", function(data) {
            if(data.payload.checkins == undefined) {
                if (sqloffset != 0) {
                    var newoffset = sqloffset - sqllimit;
                    $('#main-reports ul').html("<li><?php echo Kohana::lang('ui_main.no_checkins'); ?><br/><br/><a href=\"javascript:cilisting("+sqllimit+","+newoffset+");\">&lt;&lt; <?php echo Kohana::lang('ui_main.previous'); ?></a></li>");
                }
                else{
                    $('#main-reports ul').html("<li><?php echo Kohana::lang('ui_main.no_checkins'); ?></li>");
                }
                return;
            }
            var user_colors = new Array();
            $.each(data.payload.users, function(i, payl) {
                user_colors[payl.id] = payl.color;
            });
            var $ul = $('#main-reports ul');
            $.each(data.payload.checkins, function(i,item){
                var $li = $('<li class="checkin">');
                if (item.media !== undefined) {
                    $.each(item.media, function(j,media){
                        var $div = $('<div class="checkin-image">');
                        var $href = $('<a rel="lightbox-group1">');
                        $href.attr("href", media.link);
                        $href.attr("title", item.msg);
                        var $img = $('<img>');
                        $img.attr("src", media.thumb);
                        $img.appendTo($href);
                        $href.appendTo($div);
                        $div.appendTo($li);
                    });
                }
                else {
                    var $div = $('<div class="checkin-image">');
                    var $img = $('<img src="/themes/facilities/images/checkin.png">');
                    $img.appendTo($div);
                    $div.appendTo($li);
                }
                if (item.msg !== undefined) {
                    var message = $('<div class="checkin-message">').text("\"" + item.msg + "\"");
                    message.appendTo($li);
                }
                $.each(data.payload.users, function(j,useritem){
                    if(useritem.id == item.user){
                        var user = $('<div class="checkin-user">').html(" - <a href=\"<?php echo url::site(); ?>profile/user/"+useritem.username+"\">"+useritem.name+"</a>");
                        user.appendTo($li);
                        return false;
                    }
                });
                var utcDate = item.date.replace(" ","T")+"Z";
                var date = $('<div class="checkin-date">').text(" (" + $.timeago(utcDate) + ")");
                date.appendTo($li);
                if (item.comments !== undefined) {
                    $.each(item.comments, function(j,comment){
                        var comment = $('<div class="checkin-comment">');
                        var description = $('<div class="checkin-message">').text("\"" + comment.description + "\"");
                        description.appendTo(comment);
                        var user = $('<div class="checkin-user">');
                        if (item.user_id != 0){
                            user.html(" - <a href=\"<?php echo url::site(); ?>profile/user/"+comment.username+"\">"+comment.author+"</a>");
                        }
                        else {
                            user.html(" - "+comment.author);
                        }
                        user.appendTo(comment);
                        var commentDate = comment.date.replace(" ","T")+"Z";
                        var date = $('<div class="checkin-date">').text(" (" + $.timeago(commentDate) + ")");
                        date.appendTo(comment);
                        comment.appendTo($li);
                    });
                }
                $li.appendTo($ul);
            });
        });
    }
    cilisting(10,0);
    showCheckins();
    <?php } ?>
</script>
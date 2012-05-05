<div class="column_reports">
        <ul class="box_light">
        <?php if ( Kohana::config('settings.checkins') ) { ?>
            <li class="title"><?php echo Kohana::lang('ui_admin.checkins'); ?></li>
        <?php } else { ?>
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
            <li class="view_more">
                <a href="<?php echo url::site() . 'reports/' ?>"><?php echo Kohana::lang('ui_main.view_more'); ?></a>
            </li>
        <?php } ?>
    </ul>
</div>

<script type="text/javascript">
    <?php if (Kohana::config('settings.checkins')) { ?>

    function cilisting(sqllimit,sqloffset) {
        jsonurl = "<?php echo url::site(); ?>api/?task=checkin&action=get_ci&sqllimit="+sqllimit+"&sqloffset="+sqloffset+"&orderby=checkin.checkin_date&sort=DESC";

        var showncount = 0;
        $.getJSON(jsonurl, function(data) {
            if(data.payload.checkins == undefined) {
                if (sqloffset != 0) {
                    var newoffset = sqloffset - sqllimit;
                    $('.column_reports ul').html("<li><?php echo Kohana::lang('ui_main.no_checkins'); ?><br/><br/><a href=\"javascript:cilisting("+sqllimit+","+newoffset+");\">&lt;&lt; <?php echo Kohana::lang('ui_main.previous'); ?></a></li>");
                }
                else{
                    $('.column_reports ul').html("<li><?php echo Kohana::lang('ui_main.no_checkins'); ?></li>");
                }
                return;
            }

            var user_colors = new Array();
            $.each(data.payload.users, function(i, payl) {
                user_colors[payl.id] = payl.color;
            });

            var ul = $('.column_reports ul');
            $.each(data.payload.checkins, function(i,item){
                var li = $('<li>');
                if (item.msg !== undefined) {
                    var message = $('<span class="ci_message">').text("\"" + item.msg + "\"");
                    message.appendTo(li);
                }
                $.each(data.payload.users, function(j,useritem){
                    if(useritem.id == item.user){
                        var user = $('<span class="ci_user">').html(" - <a href=\"<?php echo url::site(); ?>profile/user/"+useritem.username+"\">"+useritem.name+"</a>");
                        user.appendTo(li);
                        return false;
                    }
                });
                var utcDate = item.date.replace(" ","T")+"Z";
                var time = $('<span class="ci_date">').text(", " + $.timeago(utcDate));
                time.appendTo(li);
                li.appendTo(ul);
            });


        });

    }

    cilisting(3,0);
    showCheckins();

    <?php } ?>
</script>
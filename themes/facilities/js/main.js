function listCheckins(sqllimit,sqloffset) {
    $.getJSON("/api/?task=checkin&action=get_ci&sqllimit=" + sqllimit + "&sqloffset=" + sqloffset + "&orderby=checkin.checkin_date&sort=DESC", function(data) {
        if(data.payload.checkins == undefined) {
            $('#main-reports ul').html("<li>" + $PHRASES.no_checkins + "</li>");
        }
        else {
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
                    var $img = $('<img src="/themes/facilities/images/placeholder-checkin.png">');
                    $img.appendTo($div);
                    $div.appendTo($li);
                }
                if (item.msg !== undefined) {
                    var message = $('<div class="checkin-message">').text("\"" + item.msg + "\"");
                    message.appendTo($li);
                }
                $.each(data.payload.users, function(j,useritem){
                    if(useritem.id == item.user){
                        var user = $('<div class="checkin-user">').html(" - <a href=\"/profile/user/"+useritem.username+"\">"+useritem.name+"</a>");
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
                            user.html(" - <a href=\"/profile/user/"+comment.username+"\">"+comment.author+"</a>");
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
        }
        $("div.checkin-image a").picbox();
    });
}
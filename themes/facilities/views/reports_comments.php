<?php if(count($incident_comments) > 0): ?>
    <?php foreach($incident_comments as $comment): ?>
    <div class="report-comment box">
        <div class="report-label">
            <i>"<?php echo $comment->comment_description; ?>"</i>
            -
            <span><strong><?php echo $comment->comment_author; ?></strong>&nbsp;
        </div>
        <div class="report-value"><?php echo date('M j Y', strtotime($comment->comment_date)); ?></div>
        <div class="clear"></div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>
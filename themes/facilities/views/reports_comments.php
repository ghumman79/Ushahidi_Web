<?php if(count($incident_comments) > 0): ?>
<div class="report-comments">
    <?php foreach($incident_comments as $comment): ?>
    <div class="report-comment box">
        <div>"<?php echo $comment->comment_description; ?>"</div>
        -
        <span><strong><?php echo $comment->comment_author; ?></strong>&nbsp;(<?php echo date('M j Y', strtotime($comment->comment_date)); ?>)</span>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
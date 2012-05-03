<?php if(count($incident_comments) > 0): ?>

<div class="report_comments">

    <h5><?php echo Kohana::lang('ui_main.comments'); ?></h5>

    <?php foreach($incident_comments as $comment): ?>
    <div class="report_comment box_light">
        <div>"<?php echo $comment->comment_description; ?>"</div>
        -
        <span><strong><?php echo $comment->comment_author; ?></strong>&nbsp;(<?php echo date('M j Y', strtotime($comment->comment_date)); ?>)</span>
    </div>
    <?php endforeach; ?>

</div>

<?php endif; ?>
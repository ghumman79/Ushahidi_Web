<?php
if ($form_error) { ?>
    <fieldset>
    <div class="red-box">
        <h3><?php echo Kohana::lang('ui_main.error');?></h3>
        <ul>
            <?php
            foreach ($errors as $error_item => $error_description) {
                print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
            }
            ?>
        </ul>
    </div>
    <?php
} ?>
<?php print form::open(NULL, array('id' => 'commentForm', 'name' => 'commentForm')); ?>
<?php
if (!$user) { ?>
        <label for="comment_author"><?php echo Kohana::lang('ui_main.name');?></label>
        <span><?php print form::input('comment_author', $form['comment_author'], ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.name')) . '" '); ?></span>
        <br/>

        <label for="comment_email"><?php echo Kohana::lang('ui_main.email'); ?></label>
        <span><?php print form::input('comment_email', $form['comment_email'], ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.email')) . '" '); ?></span>
        <br/>
    <?php
}
else {
    ?>
        <label><?php echo Kohana::lang('ui_main.user');?>:</label>
        <strong><?php echo $user->name; ?></strong>
    <br/>
<?php } ?>

    <label for="comment_description"><?php echo Kohana::lang('ui_main.comment'); ?></label>
    <span><?php print form::input('comment_description', $form['comment_description'], ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.comment')) . '" ') ?></span>
    <br/>

    <label for="captcha"><?php echo Kohana::lang('ui_main.security_code'); ?></label>
    <span class="captcha"><?php print form::input('captcha', $form['captcha'], ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.security_code')) . '" '); ?><?php print $captcha->render(); ?></span>

    <br/>

    <?php Event::run('ushahidi_action.comment_form'); ?>
    <label> </label>
    <span><input name="submit" type="submit" class="button" value="<?php echo Kohana::lang('ui_main.reports_btn_submit'); ?> <?php echo Kohana::lang('ui_main.comment'); ?>"  /></span>

</fieldset>

<?php print form::close(); ?>

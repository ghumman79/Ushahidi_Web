<div id="middle" class="scroll">
    <div id="content">
        <h1><?php echo Kohana::lang('ui_main.browse_profiles'); ?></h1>
        <ul>
            <?php foreach($users as $user){ ?>
            <li><h3><a href="<?php echo url::site();?>profile/user/<?php echo $user->username; ?>"><?php echo $user->name; ?></a></h3></li>
            <?php } ?>
        </ul>
    </div>
</div>
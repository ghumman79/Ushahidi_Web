<div id="middle" class="scroll">
    <div id="content">
        <div class="profile-picture">
            <h2><?php echo $user->name; ?></h2>
            <div><img src="<?php echo members::gravatar($user->email,160); ?>" width="160" height="160" /></div>
            <div style="width:160px;height:20px;background-color:#<?php echo $user->color; ?>"></div>
            <?php if($logged_in_user){ ?>
            <div><?php echo Kohana::lang('ui_main.this_is_your_profile'); ?><br/><a href="<?php echo url::site();?>members/"><?php echo Kohana::lang('ui_main.manage_your_account'); ?></a></div>
            <?php }else{ ?>
            <div><?php echo Kohana::lang('ui_main.is_this_your_profile'); ?>
                <?php if($logged_in_id){ ?>
                    <a href="<?php echo url::site();?>logout/front"><?php echo Kohana::lang('ui_admin.logout');?></a>
                    <?php }else{ ?>
                    <a href="<?php echo url::site();?>members/"><?php echo Kohana::lang('ui_main.login'); ?></a>
                    <?php } ?>
            </div>
            <?php } ?>
        </div>

        <div class="profile-details">
            <div>
                <h3><?php echo Kohana::lang('ui_main.reports');?></h3>
                <?php if(count($reports) > 0) { ?>
                    <?php foreach($reports as $report) { ?>
                        <div class="rb_report">
                            <h5><a href="<?php echo url::site(); ?>reports/view/<?php echo $report->id; ?>"><?php echo $report->incident_title; ?></a></h5>
                            <p class="r_date r-3 bottom-cap"><?php echo date('H:i M d, Y', strtotime($report->incident_date)); ?></p>
                            <p class="r_location"><?php echo $report->location->location_name; ?></p>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                     <strong><?php echo Kohana::lang('ui_main.no_reports');?></strong>
                <?php } ?>
            </div>
        </div>

        <div class="profile-badges">
        <h3><?php echo Kohana::lang('ui_main.badges');?></h3>
        <?php if(count($badges) > 0) { ?>
            <?php foreach($badges as $badge) { ?>
            <div class="badge r-5">
                <img src="<?php echo $badge['img_m']; ?>" alt="<?php echo Kohana::lang('ui_main.badge').' '.$badge['id'];?>" width="80" height="80" style="margin:5px;" />
                <br/><strong><?php echo $badge['name']; ?></strong>
            </div>
            <?php } ?>
        <?php } else { ?>
            <strong><?php echo Kohana::lang('ui_main.sorry_no_badges');?></strong>
        <?php } ?>
            <div style="clear:both;"></div>
        </div>
        <div style="clear:both;"></div>
    </div>
</div>

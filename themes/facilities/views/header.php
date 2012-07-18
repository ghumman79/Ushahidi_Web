<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title><?php echo $page_title.$site_name; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php echo $header_block; ?>
    <?php Event::run('ushahidi_action.header_scripts'); ?>
    <?php if (Router::$controller == 'main') { ?>
    <script type="text/javascript" src="<?php echo url::site(); ?>media/js/picbox.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo url::site(); ?>media/css/picbox/picbox.css">
    <?php } ?>
    <?php
        //Optionally change the theme color by passing 'theme' parameter with values {green, blue, yellow, red}
        $param = isset($_GET['theme']) ? $_GET['theme'] : null;
        $cookie = !isset($param) && isset($_COOKIE['theme']) ? $_COOKIE['theme'] : null;
        $expire = time() + (20 * 365 * 24 * 60 * 60);
        if ($param == "green" || $cookie == "green") {
            setcookie('theme', "green", $expire);
            echo '<link rel="stylesheet" type="text/css" href="'.url::site().'themes/facilities/colors/green.css">';
        }
        else if ($param == "blue" || $cookie == "blue") {
            setcookie('theme', "blue", $expire);
            echo '<link rel="stylesheet" type="text/css" href="'.url::site().'themes/facilities/colors/blue.css">';
        }
        else if ($param == "yellow" || $cookie == "yellow") {
            setcookie('theme', "yellow", $expire);
            echo '<link rel="stylesheet" type="text/css" href="'.url::site().'themes/facilities/colors/yellow.css">';
        }
        else if ($param == "red" || $cookie == "red") {
            setcookie('theme', "red", $expire);
            echo '<link rel="stylesheet" type="text/css" href="'.url::site().'themes/facilities/colors/red.css">';
        }
        else {
            setcookie('theme', "", $expire);
        }
    ?>
</head>
<body id="page">
    <div id="header">
        <div id="header-language">
           <?php echo $languages;?>
        </div>
        <div id="header-search">
           <?php echo $search; ?>
        </div>
        <div id="header-login">
            <?php if (Kohana::config('settings.user_id') != NULL) { ?>
                <?php if (Kohana::config('settings.user_username') != NULL) { ?>
                     <a title="<?php echo Kohana::lang('ui_main.public_profile'); ?>" href="<?php echo url::site() . "profile/user/" . Kohana::config('settings.user_username') ;?>"><?php echo Kohana::config('settings.user_username'); ?></a>
                <?php } ?>
                &nbsp;
                <a title="<?php echo Kohana::lang('ui_admin.logout');?>" href="<?php echo url::site()."logout/front";?>"><?php echo Kohana::lang('ui_admin.logout');?></a>
            <?php } else { ?>
                <a title="<?php echo Kohana::lang('ui_main.login'); ?>" href="<?php echo url::site()."login";?>"><?php echo Kohana::lang('ui_main.login'); ?></a>
            <?php } ?>
        </div>
        <?php if(Kohana::config('settings.allow_reports')) { ?>
        <div id="header-submit">

        </div>
        <? } ?>
        <div id="header-logo">
            <?php if($banner == NULL){ ?>
                <h1><a href="<?php echo url::site();?>"><?php echo $site_name; ?></a></h1>
                <span><?php echo $site_tagline; ?></span>
            <?php } else { ?>
                <a title="<?php echo $site_name; ?>" href="<?php echo url::site();?>">
                    <img src="<?php echo $banner; ?>" alt="<?php echo $site_name; ?>" />
                </a>
            <?php } ?>
        </div>
    </div>

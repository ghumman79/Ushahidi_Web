<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title><?php echo $page_title.$site_name; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php echo $header_block; ?>
    <?php Event::run('ushahidi_action.header_scripts'); ?>
    <?php if (Router::$controller == 'main') { ?>
    <script type="text/javascript" src="/media/js/picbox.js"></script>
    <link rel="stylesheet" type="text/css" href="/media/css/picbox/picbox.css">
    <?php } ?>
    <link rel="stylesheet" type="text/css" href="/themes/facilities/css/uofs.css">
    <link rel="icon" type="image/png" href="/themes/facilities/images/uofs/favicon.ico">

    <script type="text/javascript" src="/themes/facilities/js/reports.js"></script>
    <script type="text/javascript" src="/themes/facilities/js/main.js"></script>
</head>
<body id="page">
    <div id="header">
        <div id="header-language">
           <?php echo $languages;?>
        </div>
        <div id="header-search">
           <?php echo $search; ?>
        </div>
        <?php if(Kohana::config('settings.allow_reports')) { ?>
        <div id="header-submit">
            <?php echo $submit_btn; ?>
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
    <?php Event::run('ushahidi_action.header_item'); ?>

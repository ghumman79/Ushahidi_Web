<!-- main body -->
<div id="main" class="clearingfix">

    <?php if($site_message != '') { ?>
        <div class="green-box">
            <h3><?php echo $site_message; ?></h3>
        </div>
    <?php } ?>

    <div id="content" class="clearingfix">
        <?php
        // Map and Timeline Blocks
        echo $div_map;
        echo $div_timeline;
        ?>
    </div>

        <div class="clearingfix">

            <!-- how to report -->
            <?php if (Kohana::config('settings.allow_reports')) { ?>
                <div class="how-to-report">
                    <h3><?php echo Kohana::lang('ui_main.how_to_report'); ?></h3>
                    <ul>
                        <!-- Phone -->
                        <?php if (!empty($phone_array)) { ?>
                            <?php foreach ($phone_array as $phone) { ?>
                                <li><?php echo $phone; ?></li>
                            <?php } ?>
                        <?php } ?>
                        <!-- External Apps -->
                        <?php if (count($external_apps) > 0) { ?>
                            <?php foreach ($external_apps as $app) { ?>
                            <li><a href="<?php echo $app->url; ?>"><?php echo $app->name; ?></a></li>
                            <?php } ?>
                        <?php } ?>
                        <!-- Email -->
                        <?php if (!empty($report_email)) { ?>
                            <li><a href="mailto:<?php echo $report_email?>"><?php echo $report_email?></a></li>
                        <?php } ?>
                        <!-- Twitter -->
                        <?php if (!empty($twitter_hashtag_array)) { ?>
                            <?php foreach ($twitter_hashtag_array as $twitter_hashtag) { ?>
                                <li>#<?php echo $twitter_hashtag; ?></li>
                            <?php } ?>
                        <?php } ?>
                        <!-- Web Form -->
                        <li><a href="<?php echo url::site() . 'reports/submit/'; ?>"><?php echo Kohana::lang('ui_main.web_form'); ?></a></li>
                    </ul>
                </div>
            <?php } ?>

            <!-- / how to report -->

            <!-- category filters -->
            <div id="report-categories">
                <?php
                foreach ($categories as $category => $category_info)
                {
                    $category_title = $category_info[0];
                    $category_color = $category_info[1];
                    $category_image = ($category_info[2] != NULL) ? url::convert_uploaded_to_abs($category_info[2]) : NULL;
                    if($category_info[2] != NULL) {
                        $category_image = html::image(array(
                            'src'=>$category_image,
                            'style'=>'padding-right:5px;'
                        ));
                    }
                    echo '<ul>';
                    echo '<li style="border:2px solid #'. $category_color . ';"><a href="#" id="cat_'. $category .'">'.$category_image.'<span>'.$category_title.'</span></a></li>';
                    if( sizeof($category_info[3]) != 0) {
                        foreach ($category_info[3] as $child => $child_info) {
                            $child_title = $child_info[0];
                            $child_color = $child_info[1];
                            $child_image = ($child_info[2] != NULL) ? url::convert_uploaded_to_abs($child_info[2]) : NULL;
                            if($child_info[2] != NULL) {
                                $child_image = html::image(array(
                                    'src'=>$child_image,
                                    'style'=>'padding-right:5px;'
                                ));
                            }
                            echo '<li style="border:2px solid #'. $category_color . ';"><a href="#" id="cat_'. $child .'">'.$child_image.'<span>'.$child_title.'</span></a></li>';
                        }
                    }
                    echo '</ul><br/>';
                }
                ?>
            </div>
            <!-- / category filters -->

            <?php
            if ($layers)
            {
                ?>
                <!-- Layers (KML/KMZ) -->
                <div class="cat-filters clearingfix" style="margin-top:20px;">
                    <strong><?php echo Kohana::lang('ui_main.layers_filter');?> <span>[<a href="javascript:toggleLayer('kml_switch_link', 'kml_switch')" id="kml_switch_link"><?php echo Kohana::lang('ui_main.hide'); ?></a>]</span></strong>
                </div>
                <ul id="kml_switch" class="category-filters">
                    <?php
                    foreach ($layers as $layer => $layer_info)
                    {
                        $layer_name = $layer_info[0];
                        $layer_color = $layer_info[1];
                        $layer_url = $layer_info[2];
                        $layer_file = $layer_info[3];
                        $layer_link = (!$layer_url) ?
                            url::base().Kohana::config('upload.relative_directory').'/'.$layer_file :
                            $layer_url;
                        echo '<li><a href="#" id="layer_'. $layer .'"
						onclick="switchLayer(\''.$layer.'\',\''.$layer_link.'\',\''.$layer_color.'\'); return false;"><div class="swatch" style="background-color:#'.$layer_color.'"></div>
						<div>'.$layer_name.'</div></a></li>';
                    }
                    ?>
                </ul>
                <br/>
                <!-- /Layers -->
                <?php
            }
            ?>

            <!-- Checkins -->
            <?php if ( Kohana::config('settings.checkins') ) { ?>
            <br/>
            <div class="additional-content">
                <h5><?php echo Kohana::lang('ui_admin.checkins'); ?></h5>
                <div id="cilist"></div>
            </div>
            <?php } ?>
            <!-- /Checkins -->

            <?php
            // Action::main_sidebar - Add Items to the Entry Page Sidebar
            Event::run('ushahidi_action.main_sidebar');
            ?>

        </div>

</div>
<!-- / main body -->
<div id="middle">
<<<<<<< HEAD

=======
    <div id="container">
>>>>>>> dc816bacb77ac2f7579b4426426a1c18ad005d91
    <?php
    foreach ($categories as $category => $category_info) {
        $category_title = $category_info[0];
        echo '<ul class="row">';
        echo '<li class="title"><a title="'. $category_title . '" href="' . url::site() . 'reports/?c=' . $category . '">' . $category_title . '</a></li>';
        if( sizeof($category_info[3]) != 0) {
            foreach ($category_info[3] as $child => $child_info) {
                $child_title = $child_info[0];
                echo '<li><a title="'. $child_title . '" href="' . url::site() . 'reports/?c=' . $child . '">' . $child_title . '</a></li>';
            }
        }
        echo '</ul>';
    }
    ?>
    <?php blocks::render(); ?>
    </div>
</div>
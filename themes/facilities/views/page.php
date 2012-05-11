<div id="middle" class="scroll">
    <div id="content">
        <h1><?php echo $page_title ?></h1>
        <div class="page_text"><?php
            echo htmlspecialchars_decode($page_description);
            Event::run('ushahidi_action.page_extra', $page_id);
            ?>
        </div>
    </div>
</div>

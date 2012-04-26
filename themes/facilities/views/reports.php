<div id="middle">
    <?php echo $report_listing_view; ?>

    <div id="categories">
        <ul>
            <?php echo $category_tree_view; ?>
        </ul>
    </div>

    <div class="hidden">
        <?php
        // Filter::report_stats - The block that contains reports list statistics
        Event::run('ushahidi_filter.report_stats', $report_stats);
        echo $report_stats; ?>
    </div>
</div>
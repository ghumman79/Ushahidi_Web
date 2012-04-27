<div id="middle">
    <div id="reports-box">
        <?php echo $report_listing_view; ?>
    </div>
    <div id="categories">
        <ul>
            <?php echo $category_tree_view; ?>
        </ul>
        <a href="#" id="applyFilters" class="filter-button"><?php echo Kohana::lang('ui_main.filter_reports'); ?></a>
    </div>

    <?php
    // Action, allows plugins to add custom filters
    Event::run('ushahidi_action.report_filters_ui');
    ?>

    <div class="hidden">
        <?php
        // Filter::report_stats - The block that contains reports list statistics
        Event::run('ushahidi_filter.report_stats', $report_stats);
        echo $report_stats; ?>
    </div>
</div>
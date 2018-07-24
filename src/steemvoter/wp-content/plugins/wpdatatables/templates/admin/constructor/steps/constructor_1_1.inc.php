<?php defined('ABSPATH') or die('Access denied.'); ?>

<div class="col-sm-12 p-0 wdt-constructor-step hidden" data-step="1-1">

    <div class="alert alert-info alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <span class="wdt-alert-title f-600"><?php _e('Please provide some initial structure metadata before the table will be created.', 'wpdatatables'); ?>
            <br></span>
        <span class="wdt-alert-subtitle"><?php _e('This constructor will help you to create a table from scratch. You will be able to edit the table content and metadata later manually at any time.', 'wpdatatables'); ?></span>
    </div>

    <div class="row">

        <div class="col-sm-6">
            <h4 class="c-black m-b-20">
                <?php _e('Table name', 'wpdatatables'); ?>
                <i class="zmdi zmdi-help-outline" data-toggle="tooltip" data-placement="right"
                   title="<?php _e('What is the header of the table that will be visible to the site visitors', 'wpdatatables'); ?>?"></i>
            </h4>
            <div class="form-group">
                <div class="fg-line">
                    <input type="text" class="form-control input-sm" value="New wpDataTable"
                           id="wdt-constructor-manual-table-name">
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <h4 class="c-black m-b-20">
                <?php _e('Number of columns', 'wpdatatables'); ?>
                <i class="zmdi zmdi-help-outline" data-toggle="tooltip" data-placement="right"
                   title="<?php _e('How many columns table will it have? You can also modify it below with + and x buttons', 'wpdatatables'); ?>."></i>
            </h4>
            <div class="form-group">
                <div class="fg-line">
                    <input type="number" min="0" class="form-control input-sm" value="4"
                           id="wdt-constructor-number-of-columns">
                </div>
            </div>
        </div>

    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-sm-11 ">
            <h4 class="c-black m-b-20">
                <span><?php _e('Column names and types', 'wpdatatables'); ?></span><br>
                <small><?php _e('Drag and drop to reorder columns', 'wpdatatables'); ?>.</small>
            </h4>
        </div>
        <div class="col-sm-1">
            <button class="btn bgm-gray waves-effect pull-right" id="wdt-constructor-add-column">
                <?php _e('Add column', 'wpdatatables'); ?>
            </button>
        </div>
    </div>
    <!-- /.row -->

    <div class="row wdt-constructor-columns-container">

    </div>

    <div class="row m-b-30">
        <div class="col-sm-1 pull-right">
            <button class="btn bgm-gray waves-effect pull-right" id="wdt-constructor-add-column">
                <?php _e('Add column', 'wpdatatables'); ?>
            </button>
        </div>
    </div>

</div>
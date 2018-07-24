<?php defined('ABSPATH') or die('Access denied.'); ?>

<div class="col-sm-12 p-0 wdt-constructor-step hidden" data-step="2-2">

    <div class="alert alert-info alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <span class="wdt-alert-title f-600"><?php _e('Please check which columns would you like to import and make sure that the column types were imported correctly.', 'wpdatatables'); ?></span>
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
                           id="wdt-constructor-file-table-name">
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
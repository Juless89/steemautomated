<?php defined('ABSPATH') or die('Access denied.'); ?>

<?php /** @var WPDataTable $this */ ?>
<div id="<?php echo $this->getId() ?>_edit_dialog" style="display: none">
    <?php do_action('wpdatatables_before_editor_dialog', $this->getWpId()); ?>

    <!-- .wdt-edit-dialog-alert-block -->
    <div class="wdt-edit-dialog-alert-block">
        <div class="wdt-no-editor-inputs-selected-alert alert alert-danger" style="display: none">
            <?php _e('Please choose input type for columns that you want to edit', 'wpdatatables'); ?>
        </div>
    </div>
    <!--/ .wdt-edit-dialog-alert-block -->

    <!-- .wdt-edit-dialog-fields-block -->
    <div class="row wdt-edit-dialog-fields-block">
        <?php
        /** @var WDTColumn $dataColumn */
        foreach( $this->getColumnsByHeaders() as $dataColumn_key=>$dataColumn ) {
        ?>
        <!-- .form-group -->
        <div
            <?php
            if (($dataColumn_key == $this->getIdColumnKey()) ||
            ($dataColumn->getInputType() == 'none') ||
            (($this->getUserIdColumn() != '') && ($dataColumn_key == $this->getUserIdColumn()))) { ?>
                style="display: none"
                <?php if ($dataColumn_key == $this->getIdColumnKey()) { ?>
                    class="idRow"
                <?php } ?>
            <?php } else { ?>
                class="form-group col-xs-12"
        <?php } ?>

        <!-- .control-label -->
        <label for="<?php echo $this->getId() ?>_<?php echo $dataColumn_key ?>" class="col-sm-3 control-label">
            <?php echo $dataColumn->getTitle(); ?>:<?php if ($dataColumn->isNotNull()) { ?> * <?php } ?>
        </label>
        <!--/ .control-label -->

        <?php
        if ($dataColumn->getPossibleValuesAjax() === -1) {
            $possibleValues = $dataColumn->getJSFilterDefinition();
            $possibleValues = $possibleValues->values;
        }
        ?>

        <!-- .col-sm-9 -->
        <div class="col-sm-9">
            <div class="fg-line">
                <?php
                if ($dataColumn->getInputType() === 'textarea' ||
                    $dataColumn->getInputType() === 'mce-editor'
                ) { ?>
                    <textarea data-input_type="<?php echo $dataColumn->getInputType(); ?>"
                              class="form-control editDialogInput <?php if ($dataColumn->isNotNull()) { ?>mandatory<?php } ?> <?php if ($dataColumn->getInputType() == 'mce-editor') { ?>wpdt-tiny-mce<?php } ?>"
                              id="<?php echo $this->getId() ?>_<?php echo $dataColumn_key ?>"
                              data-key="<?php echo $dataColumn_key ?>" rows="5"
                              data-column_header="<?php echo $dataColumn->getTitle(); ?>"></textarea>
                    <?php
                } elseif (($dataColumn->getInputType() === 'selectbox') ||
                    ($dataColumn->getInputType() === 'multi-selectbox')
                ) { ?>
                    <select id="<?php echo $this->getId() ?>_<?php echo $dataColumn_key ?>"
                            data-input_type="<?php echo $dataColumn->getInputType(); ?>"
                            data-key="<?php echo $dataColumn_key ?>"
                            class="form-control editDialogInput selectpicker <?php if ($dataColumn->isNotNull()) { ?>mandatory <?php }
                            if ($dataColumn->getForeignKeyRule() != null) { ?>wdt-foreign-key-select <?php };
                            if ($dataColumn->getPossibleValuesAjax() !== -1) { ?>wdt-possible-values-ajax<?php }; ?>"
                            <?php if ($dataColumn->getInputType() === 'multi-selectbox') { ?>multiple="multiple"<?php } ?>
                            <?php if ($dataColumn->getPossibleValuesAjax() !== -1) { ?>data-live-search="true" data-live-search-placeholder="Search..."<?php } ?>
                            data-column_header="<?php echo $dataColumn->getTitle(); ?>">
                        <?php
                        if ($dataColumn->getPossibleValuesAjax() === -1) {
                            if ($dataColumn->getInputType() === 'selectbox') { ?>
                                <option value=""></option><?php } ?>
                            <?php foreach ($possibleValues as $possibleValue) {
                                if ($possibleValue['value'] !== 'possibleValuesAddEmpty') { ?>
                                    <option value="<?php echo $possibleValue['value'] ?>"
                                            data-label="<?php echo $possibleValue['label'] ?>"><?php echo $possibleValue['label'] ?></option>

                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </select>
                    <?php
                } elseif ($dataColumn->getInputType() == 'attachment') { ?>
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <?php if ($dataColumn->getDataType() == 'icon') { ?>
                        <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                             style="line-height: 150px;"></div>
                        <div>
                            <?php } ?>
                            <span class="btn bgm-gray m-r-10 fileupload-<?php echo $this->getId() ?>"
                                  id="<?php echo $this->getId() ?>_<?php echo $dataColumn_key ?>_button"
                                  data-column_type="<?php echo $dataColumn->getDataType(); ?>"
                                  data-input_type="<?php echo $dataColumn->getInputType(); ?>"
                                  data-rel_input="<?php echo $this->getId() ?>_<?php echo $dataColumn_key ?>"
                            >
                                <span class="fileinput-new">Select file</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="hidden"
                                       id="<?php echo $this->getId() ?>_<?php echo $dataColumn_key ?>"
                                       data-key="<?php echo $dataColumn_key ?>"
                                       data-input_type="<?php echo $dataColumn->getInputType(); ?>"
                                       data-column_header="<?php echo $dataColumn->getTitle(); ?>"
                                       class="editDialogInput <?php if ($dataColumn->isNotNull()) { ?>mandatory<?php } ?>"
                                />
                            </span>
                            <?php if ($dataColumn->getDataType() == 'icon') { ?>
                            <a href="#" class="btn btn-danger fileinput-exists waves-effect wdt-detach-attachment-file"
                               data-dismiss="fileinput">Remove</a>
                        </div>
                    <?php } else { ?>
                        <span class="fileinput-filename"></span>
                        <a href="#" class="close fileinput-exists wdt-detach-attachment-file"
                           data-dismiss="fileinput">×</a>
                    <?php } ?>
                    </div>
                    <?php
                } else { ?>
                    <input type="text"
                           value=""
                           id="<?php echo $this->getId() ?>_<?php echo $dataColumn_key ?>"
                           data-key="<?php echo $dataColumn_key ?>"
                           data-column_type="<?php echo $dataColumn->getDataType(); ?>"
                           data-column_header="<?php echo $dataColumn->getTitle(); ?>"
                           data-input_type="<?php echo $dataColumn->getInputType(); ?>"
                           class="form-control input-sm editDialogInput
                                        <?php if ($dataColumn->isNotNull()) { ?>mandatory<?php } ?>
                                        <?php if ($dataColumn->getDataType() == 'float' || $dataColumn->getDataType() == 'int') { ?>wdt-maskmoney<?php } ?>
                                        <?php if ($dataColumn->getInputType() == 'date') { ?>wdt-datepicker<?php } ?>
                                        <?php if ($dataColumn->getInputType() == 'time') { ?>wdt-timepicker<?php } ?>
                                        <?php if ($dataColumn->getInputType() == 'datetime') { ?>wdt-datetimepicker<?php } ?>"
                    />
                <?php } ?>
            </div>
        </div>
        <!-- .col-sm-9 -->
    </div>
    <!--/ .form-group -->
    <?php } ?>
</div>
<!--/ .wdt-edit-dialog-fields-block -->

<?php do_action('wpdatatables_after_editor_dialog', $this->getWpId()); ?>
</div>

<div id="<?php echo $this->getId() ?>_edit_dialog_buttons" class="wdt-edit-dialog-button-block"
     style="display: none">
    <button class="btn btn-danger btn-icon-text waves-effect" data-toggle="modal" data-target="#wdt-frontend-modal">
        <i class="zmdi zmdi-close"></i>
        <?php _e('Cancel', 'wpdatatables'); ?>
    </button>
    <button id="<?php echo $this->getId() ?>_prev_edit_dialog" class="btn bgm-gray btn-icon-text waves-effect">
        <i class="zmdi zmdi-skip-previous"></i>
        <?php _e('Prev', 'wpdatatables'); ?>
    </button>
    <button id="<?php echo $this->getId() ?>_next_edit_dialog" class="btn bgm-gray btn-icon-text waves-effect">
        <?php _e('Next', 'wpdatatables'); ?>
        <i class="zmdi zmdi-skip-next"></i>
    </button>
    <button id="<?php echo $this->getId() ?>_apply_edit_dialog" class="btn btn-success btn-icon-text waves-effect">
        <i class="zmdi zmdi-check"></i>
        <?php _e('Apply and add new', 'wpdatatables'); ?>
    </button>
    <button id="<?php echo $this->getId() ?>_ok_edit_dialog" class="btn btn-success btn-icon-text waves-effect">
        <i class="zmdi zmdi-check-all"></i>
        <?php _e('OK', 'wpdatatables'); ?>
    </button>
</div>
<script type='text/javascript' src='<?php echo site_url(); ?>/wp-includes/js/tinymce/tinymce.min.js'></script>

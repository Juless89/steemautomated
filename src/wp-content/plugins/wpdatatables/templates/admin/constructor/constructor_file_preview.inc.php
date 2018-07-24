<?php defined('ABSPATH') or die('Access denied.'); ?>

<?php foreach ($headingsArray as $header) { ?>
    <?php $header = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $header))); ?>
    <?php if ($header !== null) { ?>
        <div class="wdt-constructor-column-block wdt-constructor-column-block-file col-sm-3">

            <div class="card">

                <div class="card-header col-sm-12 ch-alt p-t-10 p-b-10 p-r-0 p-l-0">

                    <div class="col-sm-10 p-l-25">
                        <div class="fg-line">
                            <input type="text" class="form-control input-sm wdt-constructor-column-name"
                                   value="<?php echo $header ?>">
                            <i class="zmdi zmdi-edit"></i>
                        </div>
                    </div>

                    <ul class="actions wdt-constructor-remove-column">
                        <li>
                            <a>
                                <i class="zmdi zmdi-close"></i>
                            </a>
                        </li>
                    </ul>

                </div>

                <div class="card-body card-padding">

                    <div class="col-sm-12 p-t-5 p-0">
                        <h5 class="c-black m-b-10">
                            <?php _e('Type', 'wpdatatables'); ?>
                        </h5>
                        <div class="form-group">
                            <div class="fg-line">
                                <div class="select">
                                    <select class="selectpicker wdt-constructor-column-type">
                                        <?php foreach ($possibleColumnTypes as $columnTypeKey => $columnTypeName) { ?>
                                            <option value="<?php echo $columnTypeKey ?>"
                                                    <?php if ($columnTypeKey == $columnTypeArray[$header]) { ?>selected="selected"<?php } ?> ><?php echo $columnTypeName ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 wdt-constructor-date-input-format-block p-0" style="display: none;">
                        <h5 class="c-black m-b-20">
                            <?php _e('Date input format', 'wpdatatables'); ?>
                        </h5>

                        <div class="form-group">
                            <div class="fg-line">
                                <div class="select">
                                    <select class="selectpicker wdt-constructor-date-input-format">
                                        <option value=""></option>
                                        <option value="d/m/Y">15/07/2005 (d/m/Y)</option>
                                        <option value="m/d/Y">07/15/2005 (m/d/Y)</option>
                                        <option value="d.m.Y">15.07.2005 (d.m.Y)</option>
                                        <option value="m.d.Y">07.15.2005 (m.d.Y)</option>
                                        <option value="d-m-Y">15-07-2005 (d-m-Y)</option>
                                        <option value="m-d-Y">07-15-2005 (m-d-Y)</option>
                                        <option value="d M Y">15 July 2005 (d Mon Y)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 wdt-constructor-possible-values-block p-0" style="display: none;">
                        <h5 class="c-black m-b-10">
                            <?php _e('Possible values', 'wpdatatables'); ?>
                        </h5>
                        <div class="form-group">
                            <div class="fg-line">
                                <input class="form-control input-sm wdt-constructor-possible-values" value=""/>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12  p-0">
                        <h5 class="c-black m-b-10">
                            <?php _e('Editor predefined value', 'wpdatatables'); ?>
                        </h5>
                        <div class="form-group">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm wdt-constructor-default-value" value="">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 wdt-constructor-data-preview  p-0">
                        <h5 class="c-black m-b-10">
                            <?php _e('Data preview', 'wpdatatables'); ?>
                        </h5>
                        <div class="form-group">
                            <div class="fg-line">
                                <table class="table table-condensed">
                                    <tbody>
                                    <?php foreach ($namedDataArray as $row) { ?>
                                        <tr>
                                            <td><?php echo $row[$header] ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    <?php } ?>
<?php } ?>
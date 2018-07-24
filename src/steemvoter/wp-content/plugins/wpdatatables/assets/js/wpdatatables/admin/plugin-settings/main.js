/**
 * Main jQuery elements controller for the plugin settings page
 *
 * Binds the jQuery control elements for manipulating the config object, binds jQuery plugins
 *
 * @author Miljko Milosevic
 * @since 23.11.2016
 */

(function($) {
    $(function(){

        /**
         * Toggle Separate MySQL Connection
         */
        $('#wdt-separate-connection').change(function(e){
            wpdatatable_plugin_config.setSeparateConnection( $(this).is(':checked') ? 1 : 0 );
        });

        /**
         * Change MySQL host - "MySQL host"
         */
        $('#wdt-my-sql-host').change(function (e) {
            wpdatatable_plugin_config.setMysqlHost( $(this).val() );
        });

        /**
         * Change MySQL DB - "MySQL database"
         */
        $('#wdt-my-sql-db').change(function (e) {
            wpdatatable_plugin_config.setMysqlDb( $(this).val() );
        });

        /**
         * Change MySQL User - "MySQL user"
         */
        $('#wdt-my-sql-user').change(function (e) {
            wpdatatable_plugin_config.setMysqlUser( $(this).val() );
        });

        /**
         * Change MySQL Password - "MySQL password"
         */
        $('#wdtMySqlPwd').change(function (e) {
            wpdatatable_plugin_config.setMysqlPass( $(this).val() );
        });

        /**
         * Change MySQL port - "MySQL port"
         */
        $('#wdt-my-sql-port').change(function (e) {
            wpdatatable_plugin_config.setMysqlPort( $(this).val() );
        });

        /**
         * Change language on select change - "Interface language"
         */
        $('#wdt-interface-language').change(function(e){
            wpdatatable_plugin_config.setLanguage( $(this).val() );
        });

        /**
         * Change date format - "Date format"
         */
        $('#wdt-date-format').change(function(e){
            wpdatatable_plugin_config.setDateFormat( $(this).val() );
        });

        /**
         * Number of tables on admin page - "Tables per admin page"
         */
        $('#wdt-tables-per-page').change(function(e){
            wpdatatable_plugin_config.setTablesAdmin( $(this).val() );
        });

        /**
         * Change time format - "Date time"
         */
        $('#wdt-time-format').change(function(e){
            wpdatatable_plugin_config.setTimeFormat( $(this).val() );
        });

        /**
         * Change base skin - "Base skin"
         */
        $('#wdt-base-skin').change(function(e){
            wpdatatable_plugin_config.setBaseSkin( $(this).val() );
        });

        /**
         * Change number format - "Number format"
         */
        $('#wdt-number-format').change(function(e){
            wpdatatable_plugin_config.setNumberFormat( $(this).val() );
        });

        /**
         * Change CSV delimiter - "CSV delimiter"
         */
        $('#wdt-csv-delimiter').change(function(e){
            wpdatatable_plugin_config.setCSVDelimiter( $(this).val() );
        });

        /**
         * Change position of advance filter - "Render advanced filter"
         */
        $('#wp-render-filter').change(function(e){
            wpdatatable_plugin_config.setRenderPosition( $(this).val() );
        });

        /**
         * Set number of decimal places - "Decimal places"
         */
        $('#wdt-decimal-places').change(function(e){
            wpdatatable_plugin_config.setDecimalPlaces( $(this).val() );
        });

        /**
         * Set Tablet width - "Tablet width"
         */
        $('#wdt-tablet-width').change(function(e){
            wpdatatable_plugin_config.setTabletWidth( $(this).val() );
        });

        /**
         * Set Mobile width - "Tablet width"
         */
        $('#wdt-mobile-width').change(function(e){
            wpdatatable_plugin_config.setMobileWidth( $(this).val() );
        });

        /**
         * Set Timepicker step in minutes - "Timepicker step"
         */
        $('#wdt-timepicker-range').change(function(e){
            wpdatatable_plugin_config.setTimepickerStep( $(this).val() );
        });

        /**
         * Set Purchase code - "Purchase code"
         */
        $('#wdt-purchase-code').change(function(e){
            wpdatatable_plugin_config.setPurchaseCode( $(this).val() );
        });

        /**
         * Set Include Bootstrap
         */
        $('#wdt-include-bootstrap').change(function(e){
            wpdatatable_plugin_config.setIncludeBootstrap( $(this).is(':checked') ? 1 : 0 );
        });

        /**
         * Set Include Bootstrap on back-end
         */
        $('#wdt-include-bootstrap-back-end').change(function(e){
            wpdatatable_plugin_config.setIncludeBootstrapBackEnd( $(this).is(':checked') ? 1 : 0 );
        });

        /**
         * Set SUM functions label
         */
        $('#wdt-sum-function-label').change(function(e){
            wpdatatable_plugin_config.setSumFunctionsLabel( $(this).val() );
        });

        /**
         * Set AVG functions label
         */
        $('#wdt-avg-function-label').change(function(e){
            wpdatatable_plugin_config.setAvgFunctionsLabel( $(this).val() );
        });

        /**
         * Set MIN functions label
         */
        $('#wdt-min-function-label').change(function(e){
            wpdatatable_plugin_config.setMinFunctionsLabel( $(this).val() );
        });

        /**
         * Set MAX functions label
         */
        $('#wdt-max-function-label').change(function(e){
            wpdatatable_plugin_config.setMaxFunctionsLabel( $(this).val() );
        });

        /**
         * Toggle Parse shortcodes in strings
         */
        $('#wdt-parse-shortcodes').change(function(e){
            wpdatatable_plugin_config.setParseShortcodes( $(this).is(':checked') ? 1 : 0 );
        });

        /**
         * Toggle Align numbers
         */
        $('#wdt-numbers-align').change(function(e){
            wpdatatable_plugin_config.setAlignNumber( $(this).is(':checked') ? 1 : 0 );
        });

        /**
         * Change table font
         */
        $('#wdt-table-font').change(function(e){
            wpdatatable_plugin_config.setColorFontSetting( $(this).data('name'), $(this).val() );
        });

        /**
         * Change table font size
         */
        $('#wdt-font-size').change(function (e) {
            wpdatatable_plugin_config.setColorFontSetting( $(this).data('name'), $(this).val() );

        });

        /**
         * Change table font color
         */
        $('.color-picker').on('changeColor', function(e) {
            wpdatatable_plugin_config.setColorFontSetting( $(this).find('.cp-value').data('name'), $(this).find('input').val() );
        });

        /**
         * Change border input radius
         */
        $('#wdt-border-input-radius').change(function(e){
            wpdatatable_plugin_config.setColorFontSetting( $(this).prop('id'), $(this).val() );
        });

        /**
         * Remove borders from table
         */
        $('#wdt-remove-borders').change(function(e){
            wpdatatable_plugin_config.setBorderRemoval( $(this).is(':checked') ? 1 : 0 );
        });

        /**
         * Remove borders from header
         */
        $('#wdt-remove-borders-header').change(function(e){
            wpdatatable_plugin_config.setBorderRemovalHeader( $(this).is(':checked') ? 1 : 0 );
        });
        /**
         * Set Custom Js - "Custom wpDataTables JS"
         */
        $('#wdt-custom-js').change(function(e){
            wpdatatable_plugin_config.setCustomJs( $(this).val() );
        });

        /**
         * Set Custom CSS - "Custom wpDataTables CSS"
         */
        $('#wdt-custom-css').change(function(e){
            wpdatatable_plugin_config.setCustomCss( $(this).val() );
        });

        /**
         * Toggle minified JS - "Use minified wpDataTables Javascript"
         */
        $('#wdt-minified-js').change(function(e){
            wpdatatable_plugin_config.setMinifiedJs( $(this).is(':checked') ? 1 : 0 );
        });



        /**
         * Load current config on load
         */
        wpdatatable_plugin_config.setSeparateConnection         ( wdt_current_config.wdtUseSeparateCon == 1 ? 1 : 0 );
        wpdatatable_plugin_config.setMysqlHost                  ( wdt_current_config.wdtMySQLHost );
        wpdatatable_plugin_config.setMysqlDb                    ( wdt_current_config.wdtMySqlDB );
        wpdatatable_plugin_config.setMysqlUser                  ( wdt_current_config.wdtMySqlUser );
        wpdatatable_plugin_config.setMysqlPass                  ( wdt_current_config.wdtMySqlPwd );
        wpdatatable_plugin_config.setMysqlPort                  ( wdt_current_config.wdtMySqlPort );
        wpdatatable_plugin_config.setLanguage                   ( wdt_current_config.wdtInterfaceLanguage );
        wpdatatable_plugin_config.setDateFormat                 ( wdt_current_config.wdtDateFormat );
        wpdatatable_plugin_config.setTablesAdmin                ( wdt_current_config.wdtTablesPerPage );
        wpdatatable_plugin_config.setTimeFormat                 ( wdt_current_config.wdtTimeFormat );
        wpdatatable_plugin_config.setBaseSkin                   ( wdt_current_config.wdtBaseSkin );
        wpdatatable_plugin_config.setNumberFormat               ( wdt_current_config.wdtNumberFormat );
        wpdatatable_plugin_config.setCSVDelimiter               ( wdt_current_config.wdtCSVDelimiter );
        wpdatatable_plugin_config.setRenderPosition             ( wdt_current_config.wdtRenderFilter );
        wpdatatable_plugin_config.setDecimalPlaces              ( wdt_current_config.wdtDecimalPlaces );
        wpdatatable_plugin_config.setTabletWidth                ( wdt_current_config.wdtTabletWidth );
        wpdatatable_plugin_config.setMobileWidth                ( wdt_current_config.wdtMobileWidth );
        wpdatatable_plugin_config.setPurchaseCode               ( wdt_current_config.wdtPurchaseCode );
        wpdatatable_plugin_config.setIncludeBootstrap           ( wdt_current_config.wdtIncludeBootstrap == 1 ? 1 : 0 );
        wpdatatable_plugin_config.setIncludeBootstrapBackEnd    ( wdt_current_config.wdtIncludeBootstrapBackEnd == 1 ? 1 : 0 );
        wpdatatable_plugin_config.setParseShortcodes            ( wdt_current_config.wdtParseShortcodes == 1 ? 1 : 0 );
        wpdatatable_plugin_config.setAlignNumber                ( wdt_current_config.wdtNumbersAlign == 1 ? 1 : 0  );
        wpdatatable_plugin_config.setCustomCss                  ( wdt_current_config.wdtCustomCss );
        wpdatatable_plugin_config.setCustomJs                   ( wdt_current_config.wdtCustomJs );
        wpdatatable_plugin_config.setMinifiedJs                 ( wdt_current_config.wdtMinifiedJs == 1 ? 1 : 0  );
        wpdatatable_plugin_config.setSumFunctionsLabel          ( wdt_current_config.wdtSumFunctionsLabel );
        wpdatatable_plugin_config.setAvgFunctionsLabel          ( wdt_current_config.wdtAvgFunctionsLabel );
        wpdatatable_plugin_config.setMinFunctionsLabel          ( wdt_current_config.wdtMinFunctionsLabel );
        wpdatatable_plugin_config.setMaxFunctionsLabel          ( wdt_current_config.wdtMaxFunctionsLabel );
        wpdatatable_plugin_config.setBorderRemoval              ( wdt_current_config.wdtBorderRemoval == 1 ? 1 : 0  );
        wpdatatable_plugin_config.setBorderRemovalHeader        ( wdt_current_config.wdtBorderRemovalHeader == 1 ? 1 : 0  );

        for (var value in wdt_current_config.wdtFontColorSettings) {
            wpdatatable_plugin_config.setColorFontSetting ( value , wdt_current_config.wdtFontColorSettings[value] );
        }

        /**
         * Show "Reset colors and fonts to default" when "Color and font settings" tab is active
         */
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href");
            if (target == '#color-and-font-settings') {
                $('.reset-color-settings').show();
            } else {
                $('.reset-color-settings').hide();
            }
        });

        /**
         * Reset color settings
         */
        $('.reset-color-settings').click(function(e){
            e.preventDefault();
            $('#color-and-font-settings input.cp-value').val('').change();
            wdt_current_config.wdtFontColorSettings = _.mapObject(
                    wdt_current_config.wdtFontColorSettings,
                    function( color ){ return ''; }
                );
            $('#color-and-font-settings .selectpicker').selectpicker('val', '');
            $('input#wdt-border-input-radius').val('');
            $('input#wdt-font-size').val('');
        });

        /**
         * Test MySQL settings
         */
        $('#wp-my-sql-test').click(function () {
            testMySQL(false);
        });

        /**
         * Save settings on Apply button
         */
        $('button.wdt-apply').click(function(e){

            $('.wdt-preload-layer').animateFadeIn();
            //Test if MySQL credentials works
            testMySQL(true);
        });

        function testMySQL(trigerSave) {
            if (wdt_current_config.wdtUseSeparateCon == 1) {
                var mysql_settings = {
                    host: $('#wdt-my-sql-host').val(),
                    db: $('#wdt-my-sql-db').val(),
                    user: $('#wdt-my-sql-user').val(),
                    password: $('#wdtMySqlPwd').val(),
                    port: $('#wdt-my-sql-port').val()
                };
                $('.wdt-preload-layer').animateFadeIn();
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'wpdatatables_test_mysql_settings',
                        mysql_settings: mysql_settings
                    },
                    success: function (data) {
                        $('.wdt-preload-layer').animateFadeOut();
                        if (data.errors.length > 0) {
                            var errorMessage = '';
                            for (var i in data.errors) {
                                errorMessage += data.errors[i] + '<br/>';
                            }
                            // Show error if returned
                            $('#wdt-error-modal .modal-body').html(errorMessage);
                            $('#wdt-error-modal').modal('show');
                            return;

                        } else if (data.success.length > 0) {
                            var successMessage = '';
                            for (var i in data.success) {
                                successMessage += data.success[i] + '<br/>';
                            }
                            if (trigerSave) {
                                savePluginSettings();
                            }
                            // Show success message
                            wdtNotify(
                                wpdatatables_edit_strings.success,
                                successMessage,
                                'success'
                            );
                        }
                    }
                })
            } else {
                if (trigerSave) {
                    savePluginSettings();
                }
            }
        }

        function savePluginSettings() {
            $.ajax({
                url: ajaxurl,
                dataType: 'json',
                method: 'POST',
                data: {
                    action: 'wpdatatables_save_plugin_settings',
                    settings: wdt_current_config
                },
                success: function () {
                    $('.wdt-preload-layer').animateFadeOut();
                    wdtNotify(
                        wpdatatables_edit_strings.success,
                        wpdatatables_edit_strings.settings_saved_successful,
                        'success'
                    );
                }
            })
        }
    });
})(jQuery);

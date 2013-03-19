/**
 * Piwik - Web Analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

/**
 * jQuery Plugin for Barometer widgets
 */

(function($) {
    $.extend({
        barometerWidget: new function() {

            /**
             * Default settings for widgetPreview
             */
            var settings = {
                // minimal time in microseconds to wait between updates
                interval: 3000,
                // maximum time to wait between requests
                maxInterval: 300000,
                // url params to use for data request
                dataUrlParams: null,
                // callback triggered on a successfull update (content of widget changed)
                onUpdate: null
            };

            var currentInterval, updated, updateInterval, barometerWidget;
            /**
             * Update the widget
             */
            function update() {

                // is content updated (eg new visits/views)
                updated = false;

                var ajaxRequest = new ajaxHelper();
                ajaxRequest.addParams(settings.dataUrlParams, 'GET');
                ajaxRequest.setFormat('json');
                ajaxRequest.setCallback(function(r) {
                    console.log(r);

                    if(settings.onUpdate) settings.onUpdate(r);

                    // check new interval doesn't reach the defined maximum
                    if(settings.maxInterval < currentInterval) {
                        currentInterval = settings.maxInterval;
                    }

                    window.clearTimeout(updateInterval);
                    if($(barometerWidget).closest('body').length) {
                        updateInterval = window.setTimeout(update, currentInterval);
                    }
                });
                ajaxRequest.send(false);
            };

            /**
             * Constructor
             *
             * @param userSettings Settings to be used
             * @return void
             */
            this.construct = function(userSettings) {
                settings = jQuery.extend(settings, userSettings);

                if(!settings.dataUrlParams) {
                    console && console.error('barometerWidget error: dataUrlParams needs to be defined in settings.');
                    return;
                }

                barometerWidget = this;

                currentInterval = settings.interval;

                updateInterval = window.setTimeout(update, currentInterval);
            };

            /**
             * Triggers an update for the widget
             *
             * @return void
             */
            this.update = function() {
                update();
            };
        }
    });

    /**
     * Makes barometerWidget available with $().barometerWidget()
     */
    $.fn.extend({
        barometerWidget: $.barometerWidget.construct
    });
})(jQuery);
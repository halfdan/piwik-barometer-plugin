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
                // valueName
                valueName: null,
                // maxValueName
                maxValueName: null,
                // label to show beneath widget
                label: null
            };

            var currentInterval, updateInterval, barometerWidget, barometerPlot;
            /**
             * Update the widget
             */
            function update() {
                var ajaxRequest = new ajaxHelper();
                ajaxRequest.addParams(settings.dataUrlParams, 'GET');
                ajaxRequest.setFormat('json');
                ajaxRequest.setCallback(function(r) {
                    var current= r[0][settings.valueName];
                    var max = r[0][settings.maxValueName];

                    drawBarometerPlot(current, max);

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

            function drawBarometerPlot(current, max) {
                var intervals = [max*0.25, max*0.75, max];
                if(barometerPlot) {
                    barometerPlot.destroy();
                }
                barometerPlot = $.jqplot(barometerWidget[0].id,[[current]],{
                    seriesDefaults: {
                        renderer: $.jqplot.MeterGaugeRenderer,
                        rendererOptions: {
                            label: settings.label,
                            labelPosition: 'bottom',
                            intervalOuterRadius: 85,
                            intervals: intervals,
                            intervalColors:['#cc6666', '#E7E658', '#66cc66'],
                            min: 0,
                            max: max
                        }
                    }
                });
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

                if(!settings.label) {
                    console && console.error('barometerWidget error: label needs to be defined in settings.');
                    return;
                }

                barometerWidget = this;

                currentInterval = settings.interval;

                updateInterval = window.setTimeout(update, currentInterval);

                // start update
                update();
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
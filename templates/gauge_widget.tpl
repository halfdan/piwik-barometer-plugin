<div id="visitorGauge"></div>

{literal}
<script type="text/javascript" charset="utf-8">
function drawVisitorGaugePlot(current, max) {
    var intervals = [max*0.25, max*0.75, max];
    $.jqplot('visitorGauge',[[current]],{
        seriesDefaults: {
            renderer: $.jqplot.MeterGaugeRenderer,
            rendererOptions: {
                label: 'Visits in last 30 minutes',
                labelPosition: 'bottom',
                intervalOuterRadius: 85,
                intervals: intervals,
                intervalColors:['#cc6666', '#E7E658', '#66cc66'],
                min: 0,
                max: max
            }
        }
    });
}
$(document).ready(function() {
    $('#visitorGauge').barometerWidget({
        interval: 5000,
        dataUrlParams: {
            module: 'API',
            method: 'Barometer.getVisitorCounter',
            format: 'json',
            lastMinutes: 30,
            lastDays: 30
        },
        onUpdate: function(r) {
            var current= r[0].visits;
            var max = r[0].maxvisits;

            $('#visitorGauge').empty();
            drawVisitorGaugePlot(current, max);
        }
    });

    drawVisitorGaugePlot({/literal}{$currentVisits},{$maxVisits}{literal});
});
</script>
{/literal}
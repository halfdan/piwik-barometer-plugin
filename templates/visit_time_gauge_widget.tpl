<div id="visitTimeGauge"></div>

{literal}
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
    $('#visitTimeGauge').barometerWidget({
        interval: 5000,
        dataUrlParams: {
            module: 'API',
            method: 'Barometer.getAverageVisitTimeData',
            format: 'json',
            lastMinutes: 30,
            lastDays: 30
        },
        label: '{/literal}{"Barometer_VisitTimeInLastNMinutes"|translate}{literal}',
        valueName: 'average_time',
        maxValueName: 'maxtime'
    });
});
</script>
{/literal}
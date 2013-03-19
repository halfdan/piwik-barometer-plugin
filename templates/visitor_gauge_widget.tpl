<div id="visitorGauge"></div>

{literal}
<script type="text/javascript" charset="utf-8">
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
        label: '{/literal}{"Barometer_VisitsInLastNMinutes"|translate}{literal}',
        valueName: 'visits',
        maxValueName: 'maxvisits'
    });
});
</script>
{/literal}
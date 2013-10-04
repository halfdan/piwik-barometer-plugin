<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://github.com/halfdan/piwik-barometer-plugin
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 * @category Piwik_Plugins
 * @package Piwik_Barometer
 */
namespace Piwik\Plugins\Barometer;

use Piwik\WidgetsList;

/**
 * Barometer Plugin definition.
 */
class Barometer extends \Piwik\Plugin
{
    /**
     * Return the registered hooks
     *
     * @return array
     */
    public function getListHooksRegistered()
    {
        return array(
            'AssetManager.getJavaScriptFiles' => 'getJavaScriptFiles',
            'WidgetsList.addWidgets' => 'addWidgets'
        );
    }

    /**
     * Add Widget to Live! >
     */
    public function addWidgets()
    {
        WidgetsList::add( 'Live!', 'Barometer_VisitorBarometer', 'Barometer', 'getVisitorGauge');
        WidgetsList::add( 'Live!', 'Barometer_VisitTimeBarometer', 'Barometer', 'getVisitTimeGauge');
    }

    /**
     * Add jqplot.GaugeMeterRenderer to list of js files
     * for the AssetManager.
     *
     * @param $jsFiles array List of JavaScript files
     */
    public function getJavaScriptFiles(&$jsFiles)
    {
        $jsFiles[] = "plugins/Barometer/templates/barometer.js";
        $jsFiles[] = "plugins/Barometer/templates/jqplot.meterGaugeRenderer.js";
    }
}
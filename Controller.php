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

class Controller extends \Piwik\Plugin\Controller
{
    /**
     *
     */
    public function getVisitorGauge()
    {
        $view = new \Piwik\View('@Barometer/visitor_gauge_widget');
        echo $view->render();
    }

    /**
     *
     */
    public function getVisitTimeGauge()
    {
        $view = new \Piwik\View('@Barometer/visit_time_gauge_widget');
        echo $view->render();
    }

}

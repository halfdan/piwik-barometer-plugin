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

class Piwik_Barometer_Controller extends Piwik_Controller
{
    /**
     *
     */
    public function getVisitorGauge()
    {
        $view = Piwik_View::factory('visitor_gauge_widget');
        echo $view->render();
    }

    /**
     *
     */
    public function getVisitTimeGauge()
    {
        $view = Piwik_View::factory('visit_time_gauge_widget');
        echo $view->render();
    }

}
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
    public function getGauge()
    {
        $view = Piwik_View::factory('gauge_widget');

        $idSite = Piwik_Common::getRequestVar('idSite', '', 'int');
        $data = Piwik_Barometer_API::getInstance()->getVisitorCounter($idSite, 30, 30);
        $view->currentVisits = $data['visits'];
        $view->maxVisits = $data['maxvisits'];

        echo $view->render();
    }

}
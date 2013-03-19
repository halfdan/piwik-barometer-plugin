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

/**
 * Barometer Plugin definition.
 */
class Piwik_Barometer extends Piwik_Plugin
{
    /**
     * Return information about this plugin.
     *
     * @see Piwik_Plugin
     *
     * @return array
     */
    public function getInformation()
    {
        return array(
            'description' => Piwik_Translate('Barometer_PluginDescription'),
            'author' => 'Fabian Becker <halfdan@xnorfz.de>',
            'author_homepage' => 'http://geekproject.eu/',
            'license' => 'GPL v3 or later',
            'license_homepage' => 'http://www.gnu.org/licenses/gpl.html',
            'version' => '0.1',
            'translationAvailable' => true,
        );
    }

    /**
     * Return the registered hooks
     *
     * @return array
     */
    public function getListHooksRegistered()
    {
        return array(
            'AssetManager.getJsFiles' => 'getJsFiles',
            'WidgetsList.add' => 'addWidgets'
        );
    }

    /**
     * Add Widget to Live! >
     */
    public function addWidgets()
    {
        Piwik_AddWidget( 'Live!', 'Barometer_VisitorBarometer', 'Barometer', 'getGauge');
    }

    /**
     * Add jqplot.GaugeMeterRenderer to list of js files
     * for the AssetManager.
     *
     * @param $notification Event_Notification
     */
    public function getJsFiles($notification)
    {
        $jsFiles = &$notification->getNotificationObject();
        $jsFiles[] = "plugins/Barometer/templates/barometer.js";
        $jsFiles[] = "plugins/Barometer/templates/jqplot.meterGaugeRenderer.js";
    }
}
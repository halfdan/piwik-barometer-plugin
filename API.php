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

class Piwik_Barometer_API {
    static private $instance = null;
    /**
     * @return Piwik_Barometer_API
     */
    static public function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Retrieves visit count from lastMinutes and peak visit count from lastDays
     * in lastMinutes interval for site with idSite.
     *
     * @param int $idSite
     * @param int $lastMinutes
     * @param int $lastDays
     * @return int
     */
    public function getVisitorCounter($idSite, $lastMinutes = 30, $lastDays = 30)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $lastMinutes = (int)$lastMinutes;
        $lastDays = (int)$lastDays;

        $sql = "SELECT MAX(g.concurrent) AS maxvisit
                FROM (
                  SELECT    COUNT(idvisit) as concurrent
                  FROM      ". Piwik_Common::prefixTable("log_visit")."
                  WHERE     DATE_SUB(NOW(), INTERVAL ? DAY) < visit_first_action_time
                  AND       idsite = ?
                  GROUP BY  round(UNIX_TIMESTAMP(visit_first_action_time) / ?)
        ) g";

        $maxvisits = Piwik_FetchOne($sql, array(
            $lastDays, $idSite, $lastMinutes * 60
        ));

        $sql = "SELECT COUNT(*)
                FROM ".Piwik_Common::prefixTable(("log_visit"))."
                WHERE idsite = ?
                AND DATE_SUB(NOW(), INTERVAL ? MINUTE) < visit_last_action_time";

        $visits = Piwik_FetchOne($sql, array(
            $idSite, $lastMinutes
        ));

        return array(
            'maxvisits' => $maxvisits,
            'visits' => $visits
        );
    }

}
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

use Piwik\Date;

class API extends \Piwik\Plugin\API {

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
        \Piwik\Piwik::checkUserHasViewAccess($idSite);
        $lastMinutes = (int)$lastMinutes;
        $lastDays = (int)$lastDays;

        /* Time is UTC in database. */
		$refNow = Date::factory('now');
        $timeLimit = $refNow->subDay($lastDays)->toString('Y-m-d H:i:s');
        $sql = "SELECT MAX(g.concurrent) AS maxvisit
                FROM (
                  SELECT    COUNT(idvisit) as concurrent
                  FROM      ". \Piwik\Common::prefixTable("log_visit") . "
                  WHERE     visit_last_action_time >= ?
                  AND       idsite = ?
                  GROUP BY  round(UNIX_TIMESTAMP(visit_last_action_time) / ?)
        ) g";


        $maxvisits = \Piwik\Db::fetchOne($sql, array(
            $timeLimit, $idSite, $lastMinutes * 60
        ));

        $timeLimit = $refNow->subHour($lastMinutes / 60)->toString('Y-m-d H:i:s');
        $sql = "SELECT COUNT(*)
                FROM " . \Piwik\Common::prefixTable("log_visit") . "
                WHERE idsite = ?
                AND visit_last_action_time >= ?";

        $visits = \Piwik\Db::fetchOne($sql, array(
            $idSite, $timeLimit
        ));

        return array(
            'maxvisits' => (int)$maxvisits,
            'visits' => (int)$visits
        );
    }

    public function getAverageVisitTimeData($idSite, $lastMinutes = 30, $lastDays = 30)
    {
        \Piwik\Piwik::checkUserHasViewAccess($idSite);
        $lastMinutes = (int)$lastMinutes;
        $lastDays = (int)$lastDays;

        /* Time is UTC in database. */
        $refNow = Date::factory('now');
        $timeLimit = $refNow->subDay($lastDays)->toString('Y-m-d H:i:s');
        $sql = "SELECT MAX(g.average_time) AS maxtime
                FROM (
                  SELECT    AVG(visit_total_time) as average_time
                  FROM      ". \Piwik\Common::prefixTable("log_visit") . "
                  WHERE     visit_last_action_time >= ?
                  AND       idsite = ?
                  GROUP BY  round(UNIX_TIMESTAMP(visit_last_action_time) / ?)
        ) g";

        $maxtime = \Piwik\Db::fetchOne($sql, array(
                $timeLimit, $idSite, $lastMinutes * 60
            ));

        $timeLimit = $refNow->subHour($lastMinutes / 60)->toString('Y-m-d H:i:s');
        $sql = "SELECT AVG(visit_total_time)
                FROM " . \Piwik\Common::prefixTable("log_visit") . "
                WHERE idsite = ?
                AND visit_last_action_time >= ?";

        $average_time = \Piwik\Db::fetchOne($sql, array(
                $idSite, $timeLimit
        ));

        return array(
            'maxtime' => (int)$maxtime,
            'average_time' => (int)$average_time
        );
    }
}

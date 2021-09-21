<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

/**
 * @package    OpenXDal
 * @subpackage Statistics
 */

// Required classes
require_once MAX_PATH . '/lib/OA/Dal/Statistics.php';

/**
 * The Data Abstraction Layer (DAL) class for statistics for Banner.
 *
 */
class OA_Dal_Statistics_Banner extends OA_Dal_Statistics
{
    /**
     * This method returns statistics for a given banner, broken down by day.
     *
     * @access public
     *
     * @param integer $bannerId The ID of the banner to view statistics
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     *
     * @return array Each row containing:
     *   <ul>
     *   <li><b>day date</b> The day
     *   <li><b>requests integer</b> The number of requests for the day
     *   <li><b>impressions integer</b> The number of impressions for the day
     *   <li><b>clicks integer</b> The number of clicks for the day
     *   <li><b>revenue decimal</b> The revenue earned for the day
     *   </ul>
     *
     */
    public function getBannerDailyStatistics($bannerId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $bannerId = $this->oDbh->quote($bannerId, 'integer');
        $tableBanners = $this->quoteTableName('banners');
        $tableSummary = $this->quoteTableName('data_summary_ad_hourly');

        $aConf = $GLOBALS['_MAX']['CONF'];

        $query = "
            SELECT
                SUM(s.impressions) AS impressions,
                SUM(s.clicks) AS clicks,
                SUM(s.requests) AS requests,
                SUM(s.total_revenue) AS revenue,
                DATE_FORMAT(s.date_time, '%Y-%m-%d') AS day,
                HOUR(s.date_time) AS hour
            FROM
                $tableBanners AS b,
                $tableSummary AS s
            WHERE
                b.bannerid = $bannerId
                AND
                b.bannerid = s.ad_id
                " . $this->getWhereDate($oStartDate, $oEndDate, $localTZ) . "
            GROUP BY
                day,
                hour
        ";

        return $this->getDailyStatsAsArray($query, $localTZ);
    }

    /**
     * This method returns statistics for a given banner, broken down by day and hour.
     *
     * @access public
     *
     * @param integer $bannerId The ID of the banner to view statistics
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     *
     * @return array Each row containing:
     *   <ul>
     *   <li><b>day date</b> The day
     *   <li><b>requests integer</b> The number of requests for the day
     *   <li><b>impressions integer</b> The number of impressions for the day
     *   <li><b>clicks integer</b> The number of clicks for the day
     *   <li><b>revenue decimal</b> The revenue earned for the day
     *   </ul>
     *
     */
    public function getBannerHourlyStatistics($bannerId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $bannerId = $this->oDbh->quote($bannerId, 'integer');
        $tableBanners = $this->quoteTableName('banners');
        $tableSummary = $this->quoteTableName('data_summary_ad_hourly');

        $aConf = $GLOBALS['_MAX']['CONF'];

        $query = "
            SELECT
                SUM(s.impressions) AS impressions,
                SUM(s.clicks) AS clicks,
                SUM(s.requests) AS requests,
                SUM(s.total_revenue) AS revenue,
                DATE_FORMAT(s.date_time, '%Y-%m-%d') AS day,
                HOUR(s.date_time) AS hour
            FROM
                $tableBanners AS b,
                $tableSummary AS s
            WHERE
                b.bannerid = $bannerId
                AND
                b.bannerid = s.ad_id
                " . $this->getWhereDate($oStartDate, $oEndDate, $localTZ) . "
            GROUP BY
                day,
                hour
            ORDER BY
                day,
                hour
        ";

        return $this->getHourlyStatsAsArray($query, $localTZ);
    }

    /**
     * This method returns statistics for a given banner, broken down by publisher.
     *
     * @access public
     *
     * @param integer $bannerId The ID of the banner to view statistics
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     *
     * @return RecordSet
     *   <ul>
     *   <li><b>publisherID integer</b> The ID of the publisher
     *   <li><b>publisherName string (255)</b> The name of the publisher
     *   <li><b>requests integer</b> The number of requests for the day
     *   <li><b>impressions integer</b> The number of impressions for the day
     *   <li><b>clicks integer</b> The number of clicks for the day
     *   <li><b>revenue decimal</b> The revenue earned for the day
     *   </ul>
     *
     */
    public function getBannerPublisherStatistics($bannerId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $bannerId = $this->oDbh->quote($bannerId, 'integer');
        $tableBanners = $this->quoteTableName('banners');
        $tableZones = $this->quoteTableName('zones');
        $tableAffiliates = $this->quoteTableName('affiliates');
        $tableSummary = $this->quoteTableName('data_summary_ad_hourly');

        $query = "
            SELECT
                SUM(s.impressions) AS impressions,
                SUM(s.clicks) AS clicks,
                SUM(s.requests) AS requests,
                SUM(s.total_revenue) AS revenue,
                p.affiliateid AS publisherID,
                p.name AS publisherName
            FROM
                $tableBanners AS b,

                $tableZones AS z,
                $tableAffiliates AS p,

                $tableSummary AS s
            WHERE
                b.bannerid = $bannerId
                AND
                b.bannerid = s.ad_id

                AND
                p.affiliateid = z.affiliateid
                AND
                z.zoneid = s.zone_id
                " . $this->getWhereDate($oStartDate, $oEndDate, $localTZ) . "
            GROUP BY
                p.affiliateid, p.name
        ";

        return DBC::NewRecordSet($query);
    }

    /**
     * This method returns statistics for a given banner, broken down by zone.
     *
     * @access public
     *
     * @param integer $bannerId The ID of the banner to view statistics
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     *
     * @return RecordSet
     *   <ul>
     *   <li><b>publisherID integer</b> The ID of the publisher
     *   <li><b>publisherName string (255)</b> The name of the publisher
     *   <li><b>zoneID integer</b> The ID of the zone
     *   <li><b>zoneName string (255)</b> The name of the zone
     *   <li><b>requests integer</b> The number of requests for the day
     *   <li><b>impressions integer</b> The number of impressions for the day
     *   <li><b>clicks integer</b> The number of clicks for the day
     *   <li><b>revenue decimal</b> The revenue earned for the day
     *   </ul>
     *
     */
    public function getBannerZoneStatistics($bannerId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $bannerId = $this->oDbh->quote($bannerId, 'integer');
        $tableBanners = $this->quoteTableName('banners');
        $tableZones = $this->quoteTableName('zones');
        $tableAffiliates = $this->quoteTableName('affiliates');
        $tableSummary = $this->quoteTableName('data_summary_ad_hourly');

        $query = "
            SELECT
                SUM(s.impressions) AS impressions,
                SUM(s.clicks) AS clicks,
                SUM(s.requests) AS requests,
                SUM(s.total_revenue) AS revenue,
                SUM(s.conversions) AS conversions,
                p.affiliateid AS publisherID,
                p.name AS publisherName,
                z.zoneid AS zoneID,
                z.zonename AS zoneName
            FROM
                $tableBanners AS b,

                $tableZones AS z,
                $tableAffiliates AS p,

                $tableSummary AS s
            WHERE
                b.bannerid = $bannerId
                AND
                b.bannerid = s.ad_id

                AND
                p.affiliateid = z.affiliateid
                AND
                z.zoneid = s.zone_id
                " . $this->getWhereDate($oStartDate, $oEndDate, $localTZ) . "
            GROUP BY
                p.affiliateid, p.name,
                z.zoneid, z.zonename
        ";

        return DBC::NewRecordSet($query);
    }
}

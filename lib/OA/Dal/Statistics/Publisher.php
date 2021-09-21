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
 * The Data Abstraction Layer (DAL) class for statistics for Publisher.
 *
 */
class OA_Dal_Statistics_Publisher extends OA_Dal_Statistics
{
    /**
     * This method returns statistics for a given publisher, broken down by day.
     *
     * @access public
     *
     * @param integer $publisherId The ID of the agency to view statistics
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
    public function getPublisherDailyStatistics($publisherId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $publisherId = $this->oDbh->quote($publisherId, 'integer');
        $tableZones = $this->quoteTableName('zones');
        $tableAffiliates = $this->quoteTableName('affiliates');
        $tableSummary = $this->quoteTableName('data_summary_ad_hourly');

        $query = "
            SELECT
                SUM(s.impressions) AS impressions,
                SUM(s.clicks) AS clicks,
                SUM(s.requests) AS requests,
                SUM(s.total_revenue) AS revenue,
                DATE_FORMAT(s.date_time, '%Y-%m-%d') AS day,
                HOUR(s.date_time) AS hour
            FROM
                $tableZones AS z,
                $tableAffiliates AS p,

                $tableSummary AS s
            WHERE
                p.affiliateid = $publisherId

                AND
                p.affiliateid = z.affiliateid
                AND
                z.zoneid = s.zone_id

                " . $this->getWhereDate($oStartDate, $oEndDate, $localTZ) . "
            GROUP BY
                day,
                hour
        ";

        return $this->getDailyStatsAsArray($query, $localTZ);
    }

    /**
     * This method returns statistics for a given publisher, broken down by day and hour.
     *
     * @access public
     *
     * @param integer $publisherId The ID of the agency to view statistics
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
    public function getPublisherHourlyStatistics($publisherId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $publisherId = $this->oDbh->quote($publisherId, 'integer');
        $tableZones = $this->quoteTableName('zones');
        $tableAffiliates = $this->quoteTableName('affiliates');
        $tableSummary = $this->quoteTableName('data_summary_ad_hourly');

        $query = "
            SELECT
                SUM(s.impressions) AS impressions,
                SUM(s.clicks) AS clicks,
                SUM(s.requests) AS requests,
                SUM(s.total_revenue) AS revenue,
                DATE_FORMAT(s.date_time, '%Y-%m-%d') AS day,
                HOUR(s.date_time) AS hour
            FROM
                $tableZones AS z,
                $tableAffiliates AS p,

                $tableSummary AS s
            WHERE
                p.affiliateid = $publisherId

                AND
                p.affiliateid = z.affiliateid
                AND
                z.zoneid = s.zone_id

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
     * This method returns statistics for a given publisher, broken down by zone.
     *
     * @access public
     *
     * @param integer $publisherId The ID of the publisher to view statistics
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     *
     * @return RecordSet
     *   <ul>
     *   <li><b>zoneID integer</b> The ID of the zone
     *   <li><b>zoneName string (255)</b> The name of the zone
     *   <li><b>requests integer</b> The number of requests for the zone
     *   <li><b>impressions integer</b> The number of impressions for the zone
     *   <li><b>clicks integer</b> The number of clicks for the zone
     *   <li><b>revenue decimal</b> The revenue earned for the zone
     *   </ul>
     *
     */
    public function getPublisherZoneStatistics($publisherId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $publisherId = $this->oDbh->quote($publisherId, 'integer');
        $tableZones = $this->quoteTableName('zones');
        $tableAffiliates = $this->quoteTableName('affiliates');
        $tableSummary = $this->quoteTableName('data_summary_ad_hourly');

        $query = "
            SELECT
                SUM(s.impressions) AS impressions,
                SUM(s.clicks) AS clicks,
                SUM(s.requests) AS requests,
                SUM(s.total_revenue) AS revenue,
                z.zoneid AS zoneID,
                z.zonename AS zoneName
            FROM
                $tableZones AS z,
                $tableAffiliates AS p,

                $tableSummary AS s
            WHERE
                p.affiliateid = $publisherId

                AND
                p.affiliateid = z.affiliateid
                AND
                z.zoneid = s.zone_id

                " . $this->getWhereDate($oStartDate, $oEndDate, $localTZ) . "
            GROUP BY
                z.zoneid, z.zonename
        ";

        return DBC::NewRecordSet($query);
    }


    /**
     * This method returns statistics for a given publisher, broken down by advertiser.
     *
     * @access public
     *
     * @param integer $publisherId The ID of the publisher to view statistics
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     *
     * @return RecordSet
     *   <ul>
     *   <li><b>advertiser ID integer</b> The ID of the advertiser
     *   <li><b>advertiserName string (255)</b> The name of the advertiser
     *   <li><b>requests integer</b> The number of requests for the advertiser
     *   <li><b>impressions integer</b> The number of impressions for the advertiser
     *   <li><b>clicks integer</b> The number of clicks for the advertiser
     *   <li><b>revenue decimal</b> The revenue earned for the advertiser
     *   </ul>
     *
     */
    public function getPublisherAdvertiserStatistics($publisherId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $publisherId = $this->oDbh->quote($publisherId, 'integer');
        $tableZones = $this->quoteTableName('zones');
        $tableAffiliates = $this->quoteTableName('affiliates');
        $tableClients = $this->quoteTableName('clients');
        $tableCampaigns = $this->quoteTableName('campaigns');
        $tableBanners = $this->quoteTableName('banners');
        $tableSummary = $this->quoteTableName('data_summary_ad_hourly');

        $query = "
            SELECT
                SUM(s.impressions) AS impressions,
                SUM(s.clicks) AS clicks,
                SUM(s.requests) AS requests,
                SUM(s.total_revenue) AS revenue,
                c.clientid AS advertiserID,
                c.clientname AS advertiserName
            FROM
                $tableZones AS z,
                $tableAffiliates AS p,

                $tableClients AS c,
                $tableCampaigns AS m,
                $tableBanners AS b,

                $tableSummary AS s
            WHERE
                p.affiliateid = $publisherId

                AND
                c.clientid = m.clientid
                AND
                m.campaignid = b.campaignid
                AND
                b.bannerid = s.ad_id

                AND
                p.affiliateid = z.affiliateid
                AND
                z.zoneid = s.zone_id

                " . $this->getWhereDate($oStartDate, $oEndDate, $localTZ) . "
            GROUP BY
                c.clientid, c.clientname
        ";

        return DBC::NewRecordSet($query);
    }

    /**
     * This method returns statistics for a given publisher, broken down by campaign.
     *
     * @access public
     *
     * @param integer $publisherId The ID of the publisher to view statistics
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     *
     * @return RecordSet
     *   <ul>
     *   <li><b>campaignID integer</b> The ID of the campaign
     *   <li><b>campaignName string (255)</b> The name of the campaign
     *   <li><b>advertiserID integer</b> The ID of the advertiser
     *   <li><b>advertiserName string</b> The name of the advertiser
     *   <li><b>requests integer</b> The number of requests for the campaign
     *   <li><b>impressions integer</b> The number of impressions for the campaign
     *   <li><b>clicks integer</b> The number of clicks for the campaign
     *   <li><b>revenue decimal</b> The revenue earned for the campaign
     *   </ul>
     *
     */
    public function getPublisherCampaignStatistics($publisherId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $publisherId = $this->oDbh->quote($publisherId, 'integer');
        $tableZones = $this->quoteTableName('zones');
        $tableAffiliates = $this->quoteTableName('affiliates');
        $tableClients = $this->quoteTableName('clients');
        $tableCampaigns = $this->quoteTableName('campaigns');
        $tableBanners = $this->quoteTableName('banners');
        $tableSummary = $this->quoteTableName('data_summary_ad_hourly');

        $query = "
            SELECT
                SUM(s.impressions) AS impressions,
                SUM(s.clicks) AS clicks,
                SUM(s.requests) AS requests,
                SUM(s.total_revenue) AS revenue,
                SUM(s.conversions) AS conversions,
                m.campaignid AS campaignID,
                m.campaignname AS campaignName,
                c.clientid AS advertiserID,
                c.clientname AS advertiserName
            FROM
                $tableZones AS z,
                $tableAffiliates AS p,

                $tableClients AS c,
                $tableCampaigns AS m,
                $tableBanners AS b,

                $tableSummary AS s
            WHERE
                p.affiliateid = $publisherId

                AND
                c.clientid = m.clientid
                AND
                m.campaignid = b.campaignid
                AND
                b.bannerid = s.ad_id

                AND
                p.affiliateid = z.affiliateid
                AND
                z.zoneid = s.zone_id

                " . $this->getWhereDate($oStartDate, $oEndDate, $localTZ) . "
            GROUP BY
                m.campaignid, m.campaignname,
                c.clientid, c.clientname
        ";

        return DBC::NewRecordSet($query);
    }

    /**
     * This method returns statistics for a given publisher, broken down by banner.
     *
     * @access public
     *
     * @param integer $publisherId The ID of the publisher to view statistics
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     *
     * @return RecordSet
     *   <ul>
     *   <li><b>bannerID integer</b> The ID of the banner
     *   <li><b>bannerName string (255)</b> The name of the banner
     *   <li><b>campaignID integer</b> The ID of the banner
     *   <li><b>campaignName string (255)</b> The name of the banner
     *   <li><b>advertiserID integer</b> The ID of the advertiser
     *   <li><b>advertiserName string</b> The name of the advertiser
     *   <li><b>requests integer</b> The number of requests for the banner
     *   <li><b>impressions integer</b> The number of impressions for the banner
     *   <li><b>clicks integer</b> The number of clicks for the banner
     *   <li><b>revenue decimal</b> The revenue earned for the banner
     *   </ul>
     *
     */
    public function getPublisherBannerStatistics($publisherId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $publisherId = $this->oDbh->quote($publisherId, 'integer');
        $tableZones = $this->quoteTableName('zones');
        $tableAffiliates = $this->quoteTableName('affiliates');
        $tableClients = $this->quoteTableName('clients');
        $tableCampaigns = $this->quoteTableName('campaigns');
        $tableBanners = $this->quoteTableName('banners');
        $tableSummary = $this->quoteTableName('data_summary_ad_hourly');

        $query = "
            SELECT
                SUM(s.impressions) AS impressions,
                SUM(s.clicks) AS clicks,
                SUM(s.requests) AS requests,
                SUM(s.total_revenue) AS revenue,
                SUM(s.conversions) AS conversions,
                m.campaignid AS campaignID,
                m.campaignname AS campaignName,
                c.clientid AS advertiserID,
                c.clientname AS advertiserName,
                b.bannerid AS bannerID,
                b.description AS bannerName
            FROM
                $tableZones AS z,
                $tableAffiliates AS p,

                $tableClients AS c,
                $tableCampaigns AS m,
                $tableBanners AS b,

                $tableSummary AS s
            WHERE
                p.affiliateid = $publisherId

                AND
                c.clientid = m.clientid
                AND
                m.campaignid = b.campaignid
                AND
                b.bannerid = s.ad_id

                AND
                p.affiliateid = z.affiliateid
                AND
                z.zoneid = s.zone_id

                " . $this->getWhereDate($oStartDate, $oEndDate, $localTZ) . "
            GROUP BY
                b.bannerid, b.description,
                m.campaignid, m.campaignname,
                c.clientid, c.clientname
        ";

        return DBC::NewRecordSet($query);
    }
}

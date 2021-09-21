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
 * The Data Abstraction Layer (DAL) class for statistics for Agency.
 */
class OA_Dal_Statistics_Agency extends OA_Dal_Statistics
{
    /**
     * This method returns statistics for a given agency, broken down by day.
     *
     * @access public
     *
     * @param integer $agencyId The ID of the agency to view statistics
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     *
     * @return array Each row containing:
     * <ul>
     *   <li><b>day date</b>  The day
     *   <li><b>requests integer</b>  The number of requests for the day
     *   <li><b>impressions integer</b>  The number of impressions for the day
     *   <li><b>clicks integer</b>  The number of clicks for the day
     *   <li><b>revenue decimal</b>  The revenue earned for the day
     * </ul>
     *
     */
    public function getAgencyDailyStatistics($agencyId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $agencyId = $this->oDbh->quote($agencyId, 'integer');
        $tableAgency = $this->quoteTableName('agency');
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
                DATE_FORMAT(s.date_time, '%Y-%m-%d') AS day,
                HOUR(s.date_time) AS hour
            FROM
                $tableAgency AS g,
                $tableClients AS c,
                $tableCampaigns AS m,
                $tableBanners AS b,

                $tableSummary AS s
            WHERE
                g.agencyid = $agencyId
                AND
                g.agencyid = c.agencyid
                AND
                c.clientid = m.clientid
                AND
                m.campaignid = b.campaignid
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
     * This method returns statistics for a given agency, broken down by day and hour.
     *
     * @access public
     *
     * @param integer $agencyId The ID of the agency to view statistics
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     *
     * @return array Each row containing:
     * <ul>
     *   <li><b>day date</b>  The day
     *   <li><b>requests integer</b>  The number of requests for the day
     *   <li><b>impressions integer</b>  The number of impressions for the day
     *   <li><b>clicks integer</b>  The number of clicks for the day
     *   <li><b>revenue decimal</b>  The revenue earned for the day
     * </ul>
     *
     */
    public function getAgencyHourlyStatistics($agencyId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $agencyId = $this->oDbh->quote($agencyId, 'integer');
        $tableAgency = $this->quoteTableName('agency');
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
                DATE_FORMAT(s.date_time, '%Y-%m-%d') AS day,
                HOUR(s.date_time) AS hour
            FROM
                $tableAgency AS g,
                $tableClients AS c,
                $tableCampaigns AS m,
                $tableBanners AS b,

                $tableSummary AS s
            WHERE
                g.agencyid = $agencyId
                AND
                g.agencyid = c.agencyid
                AND
                c.clientid = m.clientid
                AND
                m.campaignid = b.campaignid
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
    * This method returns statistics for a given agency, broken down by
    *   advertiser.
    *
    * @access public
    *
    * @param integer $agencyId The ID of the agency to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param bool $localTZ Should stats be using the manager TZ or UTC?
    *
    * @return RecordSet
    * <ul>
    *   <li><b>advertiserID integer</b> The ID of the advertiser
    *   <li><b>advertiserName string (255)</b> The name of the advertiser
    *   <li><b>requests integer</b> The number of requests for the day
    *   <li><b>impressions integer</b> The number of impressions for the day
    *   <li><b>clicks integer</b> The number of clicks for the day
    *   <li><b>revenue decimal</b> The revenue earned for the day
    * </ul>
    *
    */
    public function getAgencyAdvertiserStatistics($agencyId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $agencyId = $this->oDbh->quote($agencyId, 'integer');
        $tableAgency = $this->quoteTableName('agency');
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
                $tableAgency AS g,
                $tableClients AS c,
                $tableCampaigns AS m,
                $tableBanners AS b,

                $tableSummary AS s
            WHERE
                g.agencyid = $agencyId
                AND
                g.agencyid = c.agencyid
                AND
                c.clientid = m.clientid
                AND
                m.campaignid = b.campaignid
                AND
                b.bannerid = s.ad_id

                " . $this->getWhereDate($oStartDate, $oEndDate, $localTZ) . "
            GROUP BY
                c.clientid, c.clientname
        ";

        return DBC::NewRecordSet($query);
    }

    /**
    * This method returns statistics for a given agency, broken down by
    *   campaign.
    *
    * @access public
    *
    * @param integer $agencyId The ID of the agency to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param bool $localTZ Should stats be using the manager TZ or UTC?
    *
    * @return RecordSet
    * <ul>
    *   <li><b>advertiserID integer</b> The ID of the advertiser
    *   <li><b>advertiserName string (255)</b> The name of the advertiser
    *   <li><b>campaignID integer</b> The ID of the campaign
    *   <li><b>campaignName string (255)</b> The name of the campaign
    *   <li><b>requests integer</b> The number of requests for the day
    *   <li><b>impressions integer</b> The number of impressions for the day
    *   <li><b>clicks integer</b> The number of clicks for the day
    *   <li><b>revenue decimal</b> The revenue earned for the day
    * </ul>
    *
    */
    public function getAgencyCampaignStatistics($agencyId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $agencyId = $this->oDbh->quote($agencyId, 'integer');
        $tableAgency = $this->quoteTableName('agency');
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
                c.clientname AS advertiserName,
                m.campaignid AS campaignID,
                m.campaignname AS campaignName
            FROM
                $tableAgency AS g,
                $tableClients AS c,
                $tableCampaigns AS m,
                $tableBanners AS b,

                $tableSummary AS s
            WHERE
                g.agencyid = $agencyId
                AND
                g.agencyid = c.agencyid
                AND
                c.clientid = m.clientid
                AND
                m.campaignid = b.campaignid
                AND
                b.bannerid = s.ad_id

                " . $this->getWhereDate($oStartDate, $oEndDate, $localTZ) . "
            GROUP BY
                m.campaignid, m.campaignname,
                c.clientid, c.clientname
        ";

        return DBC::NewRecordSet($query);
    }

    /**
    * This method returns statistics for a given agency, broken down by banner.
    *
    * @access public
    *
    * @param integer $agencyId The ID of the agency to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param bool $localTZ Should stats be using the manager TZ or UTC?
    *
    * @return RecordSet
    * <ul>
    *   <li><b>advertiserID integer</b> The ID of the advertiser
    *   <li><b>advertiserName string (255)</b> The name of the advertiser
    *   <li><b>campaignID integer</b> The ID of the campaign
    *   <li><b>campaignName string (255)</b> The name of the campaign
    *   <li><b>bannerID integer</b> The ID of the banner
    *   <li><b>bannerName string (255)</b> The name of the banner
    *   <li><b>requests integer</b> The number of requests for the day
    *   <li><b>impressions integer</b> The number of impressions for the day
    *   <li><b>clicks integer</b> The number of clicks for the day
    *   <li><b>revenue decimal</b> The revenue earned for the day
    * </ul>
    *
    */
    public function getAgencyBannerStatistics($agencyId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $agencyId = $this->oDbh->quote($agencyId, 'integer');
        $tableAgency = $this->quoteTableName('agency');
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
                c.clientname AS advertiserName,
                m.campaignid AS campaignID,
                m.campaignname AS campaignName,
                b.bannerid AS bannerID,
                b.description AS bannerName
            FROM
                $tableAgency AS g,
                $tableClients AS c,
                $tableCampaigns AS m,
                $tableBanners AS b,

                $tableSummary AS s
            WHERE
                g.agencyid = $agencyId
                AND
                g.agencyid = c.agencyid
                AND
                c.clientid = m.clientid
                AND
                m.campaignid = b.campaignid
                AND
                b.bannerid = s.ad_id

                " . $this->getWhereDate($oStartDate, $oEndDate, $localTZ) . "
            GROUP BY
                b.bannerid, b.description,
                c.clientid, c.clientname,
                m.campaignid, m.campaignname
        ";

        return DBC::NewRecordSet($query);
    }

    /**
    * This method returns statistics for a given agency, broken down by
    *       publisher.
    *
    * @access public
    *
    * @param integer $agencyId The ID of the agency to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param bool $localTZ Should stats be using the manager TZ or UTC?
    *
    * @return RecordSet
    * <ul>
    *   <li><b>publisherID integer</b> The ID of the publisher
    *   <li><b>publisherName string (255)</b> The name of the publisher
    *   <li><b>requests integer</b> The number of requests for the day
    *   <li><b>impressions integer</b> The number of impressions for the day
    *   <li><b>clicks integer</b> The number of clicks for the day
    *   <li><b>revenue decimal</b> The revenue earned for the day
    * </ul>
    *
    */
    public function getAgencyPublisherStatistics($agencyId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $agencyId = $this->oDbh->quote($agencyId, 'integer');
        $tableAgency = $this->quoteTableName('agency');
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
                $tableAgency AS g,

                $tableZones AS z,
                $tableAffiliates AS p,

                $tableSummary AS s
            WHERE
                g.agencyid = $agencyId

                AND
                g.agencyid = p.agencyid
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
     * This method returns statistics for a given agency, broken down by zone.
     *
     * @access public
     *
     * @param integer $agencyId The ID of the agency to view statistics
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     *
     * @return RecordSet
     * <ul>
     *   <li><b>publisherID integer</b> The ID of the publisher
     *   <li><b>publisherName string (255)</b> The name of the publisher
     *   <li><b>zoneID integer</b> The ID of the zone
     *   <li><b>zoneName string (255)</b> The name of the zone
     *   <li><b>requests integer</b> The number of requests for the day
     *   <li><b>impressions integer</b> The number of impressions for the day
     *   <li><b>clicks integer</b> The number of clicks for the day
     *   <li><b>revenue decimal</b> The revenue earned for the day
     * </ul>
     *
     */
    public function getAgencyZoneStatistics($agencyId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $agencyId = $this->oDbh->quote($agencyId, 'integer');
        $tableAgency = $this->quoteTableName('agency');
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
                p.name AS publisherName,
                z.zoneid AS zoneID,
                z.zonename AS zoneName
            FROM
                $tableAgency AS g,

                $tableZones AS z,
                $tableAffiliates AS p,

                $tableSummary AS s
            WHERE
                g.agencyid = $agencyId

                AND
                g.agencyid = p.agencyid
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

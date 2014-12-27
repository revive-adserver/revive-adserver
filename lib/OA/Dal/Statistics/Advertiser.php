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
 * The Data Abstraction Layer (DAL) class for statistics for Advertiser.
 */
class OA_Dal_Statistics_Advertiser extends OA_Dal_Statistics
{
   /**
    * This method returns statistics for a given advertiser, broken down by day.
    *
    * @access public
    *
    * @param integer $advertiserId The ID of the advertiser to view statistics
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
    function getAdvertiserDailyStatistics($advertiserId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $advertiserId   = $this->oDbh->quote($advertiserId, 'integer');

        $tableClients   = $this->quoteTableName('clients');
        $tableCampaigns = $this->quoteTableName('campaigns');
        $tableBanners   = $this->quoteTableName('banners');
        $tableSummary   = $this->quoteTableName('data_summary_ad_hourly');

		$query = "
            SELECT
                SUM(s.impressions) AS impressions,
                SUM(s.clicks) AS clicks,
                SUM(s.requests) AS requests,
                SUM(s.total_revenue) AS revenue,
                DATE_FORMAT(s.date_time, '%Y-%m-%d') AS day,
                HOUR(s.date_time) AS hour
            FROM
                $tableClients AS c,
                $tableCampaigns AS m,
                $tableBanners AS b,
                $tableSummary AS s
            WHERE
                c.clientid = $advertiserId
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
    * This method returns statistics for a given advertiser, broken down by campaign.
    *
    * @access public
    *
    * @param integer $advertiserId The ID of the advertiser to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param bool $localTZ Should stats be using the manager TZ or UTC?
    *
    * @return RecordSet
    *   <ul>
    *   <li><b>campaignID integer</b> The ID of the campaign
    *   <li><b>campaignName string (255)</b> The name of the campaign
    *   <li><b>requests integer</b> The number of requests for the day
    *   <li><b>impressions integer</b> The number of impressions for the day
    *   <li><b>clicks integer</b> The number of clicks for the day
    *   <li><b>revenue decimal</b> The revenue earned for the day
    *   </ul>
    *
    */
    function getAdvertiserCampaignStatistics($advertiserId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $advertiserId   = $this->oDbh->quote($advertiserId, 'integer');

        $tableClients   = $this->quoteTableName('clients');
        $tableCampaigns = $this->quoteTableName('campaigns');
        $tableBanners   = $this->quoteTableName('banners');
        $tableSummary   = $this->quoteTableName('data_summary_ad_hourly');

		$query = "
            SELECT
                SUM(s.impressions) AS impressions,
                SUM(s.clicks) AS clicks,
                SUM(s.requests) AS requests,
                SUM(s.total_revenue) AS revenue,
                m.campaignid AS campaignID,
                m.campaignname AS campaignName
            FROM
                $tableClients AS c,
                $tableCampaigns AS m,
                $tableBanners AS b,
                $tableSummary AS s
            WHERE
                c.clientid = $advertiserId
                AND
                c.clientid = m.clientid
                AND
                m.campaignid = b.campaignid
                AND
                b.bannerid = s.ad_id
                " . $this->getWhereDate($oStartDate, $oEndDate, $localTZ) . "
            GROUP BY
                m.campaignid, m.campaignname
        ";

        return DBC::NewRecordSet($query);
    }

   /**
    * This method returns statistics for a given advertiser, broken down by banner.
    *
    * @access public
    *
    * @param integer $advertiserId The ID of the advertiser to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param bool $localTZ Should stats be using the manager TZ or UTC?
    *
    * @return RecordSet
    *   <ul>
    *   <li><b>campaignID integer</b> The ID of the campaign
    *   <li><b>campaignName string (255)</b> The name of the campaign
    *   <li><b>bannerID integer</b> The ID of the banner
    *   <li><b>bannerName string (255)</b> The name of the banner
    *   <li><b>requests integer</b> The number of requests for the day
    *   <li><b>impressions integer</b> The number of impressions for the day
    *   <li><b>clicks integer</b> The number of clicks for the day
    *   <li><b>revenue decimal</b> The revenue earned for the day
    *   </ul>
    *
    */
    function getAdvertiserBannerStatistics($advertiserId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $advertiserId   = $this->oDbh->quote($advertiserId, 'integer');

        $tableClients   = $this->quoteTableName('clients');
        $tableCampaigns = $this->quoteTableName('campaigns');
        $tableBanners   = $this->quoteTableName('banners');
        $tableSummary   = $this->quoteTableName('data_summary_ad_hourly');

		$query = "
            SELECT
                SUM(s.impressions) AS impressions,
                SUM(s.clicks) AS clicks,
                SUM(s.requests) AS requests,
                SUM(s.total_revenue) AS revenue,
                m.campaignid AS campaignID,
                m.campaignname AS campaignName,
                b.bannerid AS bannerID,
                b.description AS bannerName
            FROM
                $tableClients AS c,
                $tableCampaigns AS m,
                $tableBanners AS b,
                $tableSummary AS s
            WHERE
                c.clientid = $advertiserId
                AND
                c.clientid = m.clientid
                AND
                m.campaignid = b.campaignid
                AND
                b.bannerid = s.ad_id
                " . $this->getWhereDate($oStartDate, $oEndDate, $localTZ) . "
            GROUP BY
                b.bannerid, b.description, m.campaignid, m.campaignname
        ";

        return DBC::NewRecordSet($query);
    }

   /**
    * This method returns statistics for a given advertiser, broken down by publisher.
    *
    * @access public
    *
    * @param integer $advertiserId The ID of the advertiser to view statistics
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
    function getAdvertiserPublisherStatistics($advertiserId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $advertiserId    = $this->oDbh->quote($advertiserId, 'integer');

        $tableClients    = $this->quoteTableName('clients');
        $tableCampaigns  = $this->quoteTableName('campaigns');
        $tableBanners    = $this->quoteTableName('banners');
        $tableSummary    = $this->quoteTableName('data_summary_ad_hourly');
        $tableZones      = $this->quoteTableName('zones');
        $tableAffiliates = $this->quoteTableName('affiliates');

		$query = "
            SELECT
                SUM(s.impressions) AS impressions,
                SUM(s.clicks) AS clicks,
                SUM(s.requests) AS requests,
                SUM(s.total_revenue) AS revenue,
                p.affiliateid AS publisherID,
                p.name AS publisherName
            FROM
                $tableClients AS c,
                $tableCampaigns AS m,
                $tableBanners AS b,

                $tableZones AS z,
                $tableAffiliates AS p,

                $tableSummary AS s
            WHERE
                c.clientid = $advertiserId
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
                p.affiliateid, p.name
        ";

        return DBC::NewRecordSet($query);
    }

   /**
    * This method returns statistics for a given advertiser, broken down by zone.
    *
    * @access public
    *
    * @param integer $advertiserId The ID of the advertiser to view statistics
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
    function getAdvertiserZoneStatistics($advertiserId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $advertiserId    = $this->oDbh->quote($advertiserId, 'integer');

        $tableClients    = $this->quoteTableName('clients');
        $tableCampaigns  = $this->quoteTableName('campaigns');
        $tableBanners    = $this->quoteTableName('banners');
        $tableSummary    = $this->quoteTableName('data_summary_ad_hourly');
        $tableZones      = $this->quoteTableName('zones');
        $tableAffiliates = $this->quoteTableName('affiliates');

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
                $tableClients AS c,
                $tableCampaigns AS m,
                $tableBanners AS b,

                $tableZones AS z,
                $tableAffiliates AS p,

                $tableSummary AS s
            WHERE
                c.clientid = $advertiserId
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
                p.affiliateid, p.name,
                z.zoneid, z.zonename
        ";

        return DBC::NewRecordSet($query);
    }

}

?>
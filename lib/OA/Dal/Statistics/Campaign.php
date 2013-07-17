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
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 */

// Required classes
require_once MAX_PATH . '/lib/OA/Dal/Statistics.php';

/**
 * The Data Abstraction Layer (DAL) class for statistics for Campaign.
*
 */
class OA_Dal_Statistics_Campaign extends OA_Dal_Statistics
{
    /**
    * This method returns statistics for a given campaign, broken down by day.
    *
    * @access public
    *
    * @param integer $campaignId The ID of the campaign to view statistics
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
    function getCampaignDailyStatistics($campaignId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $campaignId     = $this->oDbh->quote($campaignId, 'integer');
        $tableCampaigns = $this->quoteTableName('campaigns');
        $tableBanners   = $this->quoteTableName('banners');
        $tableSummary   = $this->quoteTableName('data_summary_ad_hourly');

        $aConf = $GLOBALS['_MAX']['CONF'];

		$query = "
            SELECT
                SUM(s.requests) AS requests,
                SUM(s.impressions) AS impressions,
                SUM(s.clicks) AS clicks,
                SUM(s.total_revenue) AS revenue,
                DATE_FORMAT(s.date_time, '%Y-%m-%d') AS day,
                HOUR(s.date_time) AS hour
            FROM
                $tableCampaigns AS m,
                $tableBanners AS b,

                $tableSummary AS s
            WHERE
                m.campaignid = $campaignId
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
    * This method returns statistics for a given campaign, broken down by banner.
    *
    * @access public
    *
    * @param integer $campaignId The ID of the campaign to view statistics
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
    function getCampaignBannerStatistics($campaignId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $campaignId     = $this->oDbh->quote($campaignId, 'integer');
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
                $tableCampaigns AS m,
                $tableBanners AS b,

                $tableSummary AS s
            WHERE
                m.campaignid = $campaignId
                AND
                m.campaignid = b.campaignid
                AND
                b.bannerid = s.ad_id
                " . $this->getWhereDate($oStartDate, $oEndDate, $localTZ) . "
            GROUP BY
                b.bannerid, b.description,
                m.campaignid, m.campaignname
        ";

        return DBC::NewRecordSet($query);
    }

    /**
    * This method returns statistics for a given campaign, broken down by
    *       publisher.
    *
    * @access public
    *
    * @param integer $campaignId The ID of the campaign to view statistics
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
    function getCampaignPublisherStatistics($campaignId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $campaignId      = $this->oDbh->quote($campaignId, 'integer');
        $tableCampaigns  = $this->quoteTableName('campaigns');
        $tableBanners    = $this->quoteTableName('banners');
        $tableZones      = $this->quoteTableName('zones');
        $tableAffiliates = $this->quoteTableName('affiliates');
        $tableSummary    = $this->quoteTableName('data_summary_ad_hourly');

		$query = "
            SELECT
                SUM(s.impressions) AS impressions,
                SUM(s.clicks) AS clicks,
                SUM(s.requests) AS requests,
                SUM(s.total_revenue) AS revenue,
                SUM(s.conversions) AS conversions,
                p.affiliateid AS publisherID,
                p.name AS publisherName
            FROM
                $tableCampaigns AS m,
                $tableBanners AS b,

                $tableZones AS z,
                $tableAffiliates AS p,

                $tableSummary AS s
            WHERE
                m.campaignid = $campaignId
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
    * This method returns statistics for a given campaign, broken down by zone.
    *
    * @access public
    *
    * @param integer $campaignId The ID of the campaign to view statistics
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
    function getCampaignZoneStatistics($campaignId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $campaignId      = $this->oDbh->quote($campaignId, 'integer');
        $tableCampaigns  = $this->quoteTableName('campaigns');
        $tableBanners    = $this->quoteTableName('banners');
        $tableZones      = $this->quoteTableName('zones');
        $tableAffiliates = $this->quoteTableName('affiliates');
        $tableSummary    = $this->quoteTableName('data_summary_ad_hourly');

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
                $tableCampaigns AS m,
                $tableBanners AS b,

                $tableZones AS z,
                $tableAffiliates AS p,

                $tableSummary AS s
            WHERE
                m.campaignid = $campaignId
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

    /**
     * This method returns conversion statistics for a given campaign.
     *
     * @param integer $campaignId The ID of the campaign to view statistics
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     *
     * @return MDB2_Result_Common
     *<ul>
     *  <li><b>campaignID integer</b> The ID of the campaign
     *  <li><b>trackerID integer</b> The ID of the tracker
     *  <li><b>bannerID integer</b> The ID of the banner
     *  <li><b>conversionTime date</b> The time of the conversion
     *  <li><b>conversionStatus integer</b> The conversion status
     *  <li><b>userIp string</b> The IP address of the conversion
     *  <li><b>action integer</b> The conversion event type
     *  <li><b>window integer</b> The conversion window
     *  <li><b>variables array</b> Array of variables for this conversion
     *                             with each variable as an array('variableName' => 'variableValue')
     *</ul>
     */
    public function getCampaignConversionStatistics($campaignId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $tableBanners = $this->quoteTableName('banners');
        $tableVariables = $this->quoteTableName('variables');
        $tableDataIntermadiateAdConnection = $this->quoteTableName('data_intermediate_ad_connection');
        $tableDataIntermadiateAdVariableValue = $this->quoteTableName('data_intermediate_ad_variable_value');        

        $localTZ = false;
        $dateField = 'd.tracker_date_time';
        
        $query = "
            SELECT
                d.data_intermediate_ad_connection_id as conversionid,
                b.campaignid as campaignid,                
                d.tracker_id as trackerid,
                d.ad_id as bannerid,
                d.tracker_date_time as tracker_date_time,
                d.connection_date_time as connection_date_time,
                d.connection_status as conversionstatus,
                d.tracker_ip_address as userip,
                d.connection_action as action,                
                v.name as variablename,
                i.value as variablevalue
            FROM
                {$tableBanners} AS b
                JOIN {$tableDataIntermadiateAdConnection} AS d ON (b.bannerid = d.ad_id)
                left JOIN {$tableDataIntermadiateAdVariableValue} AS i ON (d.data_intermediate_ad_connection_id = i.data_intermediate_ad_connection_id)
                left JOIN {$tableVariables} AS v ON (i.tracker_variable_id = v.variableid)
            WHERE
                TRUE " . // Bit of a hack due to how getWhereDate works.
                $this->getWhereDate($oStartDate, $oEndDate, $localTZ, $dateField) . "
                AND b.campaignid = " . $campaignId . "
            ";

        OX::disableErrorHandling();        
        $rsResult = $this->oDbh->query($query);
        OX::enableErrorHandling();

        $aResult = array();
        while (($row = $rsResult->fetchRow())) {            
            $aResult[$row['conversionid']] = array('campaignID' => $row['campaignid'],
                                                   'trackerID' =>  $row['trackerid'],
                                                   'bannerID' => $row['bannerid'],
                                                   'conversionTime' => $row['tracker_date_time'],
                                                   'conversionStatus' => $row['conversionstatus'],
                                                   'userIp' => $row['userip'],
                                                   'action' => $row['action'],
                                                   'window' => strtotime($row['tracker_date_time']." ") - strtotime($row['connection_date_time']." "),
                                                   'variables' => null,
                                                  );
           if (!empty($row['variablename'])) {
               $aVariables[$row['conversionid']][] = array('name' => $row['variablename'],
                                                       'value' => $row['variablevalue']);
           }
        }

        if (isset ($aVariables)) {
            foreach ($aVariables as $conversionId => $aConversionVariables) {
                foreach ($aConversionVariables as $key => $aVariable) {
                  $aResult[$conversionId]['variables'][$aVariable['name']] = $aVariable['value'];
                }
            }
        }

        // array_values function used for not being affected by a PEAR bug
        // https://pear.php.net/bugs/bug.php?id=16780
        $aResult = array_values($aResult);

        return $aResult;
    }
}

?>
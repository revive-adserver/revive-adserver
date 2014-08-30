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
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 */

// Required classes
require_once MAX_PATH . '/lib/OA/Dal/Statistics.php';

/**
 * The Data Abstraction Layer (DAL) class for statistics for Zone.
 *
 */
class OA_Dal_Statistics_Zone extends OA_Dal_Statistics
{
   /**
    * This method returns statistics for a given zone, broken down by day.
    *
    * @access public
    *
    * @param integer $zoneId The ID of the agency to view statistics
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
    function getZoneDailyStatistics($zoneId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $zoneId       = $this->oDbh->quote($zoneId, 'integer');
        $tableZones   = $this->quoteTableName('zones');
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
                $tableSummary AS s
            WHERE
                s.zone_id = $zoneId

                " . $this->getWhereDate($oStartDate, $oEndDate, $localTZ) . "
             GROUP BY
                day,
                hour
        ";

        return $this->getDailyStatsAsArray($query, $localTZ);
    }

    /**
    * This method returns statistics for a given zone, broken down by advertiser.
    *
    * @access public
    *
    * @param integer $zoneId The ID of the zone to view statistics
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
    function getZoneAdvertiserStatistics($zoneId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $zoneId         = $this->oDbh->quote($zoneId, 'integer');
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
                c.clientid AS advertiserID,
                c.clientname AS advertiserName
            FROM
                $tableClients AS c,
                $tableCampaigns AS m,
                $tableBanners AS b,

                $tableSummary AS s
            WHERE
                s.zone_id = $zoneId

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
    * This method returns statistics for a given zone, broken down by campaign.
    *
    * @access public
    *
    * @param integer $zoneId The ID of the zone to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param bool $localTZ Should stats be using the manager TZ or UTC?
    *
    * @return RecordSet
    *   <ul>
    *   <li><b>campaignID integer</b> The ID of the campaign
    *   <li><b>campaignName string</b> The name of the campaign
    *   <li><b>advertiserID integer</b> The ID of the advertiser
    *   <li><b>advertiserName string</b> The name of the advertiser
    *   <li><b>requests integer</b> The number of requests for the campaign
    *   <li><b>impressions integer</b> The number of impressions for the campaign
    *   <li><b>clicks integer</b> The number of clicks for the campaign
    *   <li><b>revenue decimal</b> The revenue earned for the campaign
    *   </ul>
    *
    */
    function getZoneCampaignStatistics($zoneId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $zoneId         = $this->oDbh->quote($zoneId, 'integer');
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
                c.clientid AS advertiserID,
                c.clientname AS advertiserName
            FROM
                $tableClients AS c,
                $tableCampaigns AS m,
                $tableBanners AS b,

                $tableSummary AS s
            WHERE
                s.zone_id = $zoneId

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
    * This method returns statistics for a given zone, broken down by banner.
    *
    * @access public
    *
    * @param integer $zoneId The ID of the zone to view statistics
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
    function getZoneBannerStatistics($zoneId, $oStartDate, $oEndDate, $localTZ = false)
    {
        $zoneId         = $this->oDbh->quote($zoneId, 'integer');
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
                c.clientid AS advertiserID,
                c.clientname AS advertiserName,
                b.bannerid AS bannerID,
                b.description AS bannerName
            FROM
                $tableClients AS c,
                $tableCampaigns AS m,
                $tableBanners AS b,

                $tableSummary AS s
            WHERE
                s.zone_id = $zoneId

                AND
                c.clientid = m.clientid
                AND
                m.campaignid = b.campaignid
                AND
                b.bannerid = s.ad_id

                " . $this->getWhereDate($oStartDate, $oEndDate, $localTZ) . "
            GROUP BY
                b.bannerid, b.description,
                m.campaignid, m.campaignname,
                c.clientid, c.clientname
        ";

        return DBC::NewRecordSet($query);
    }

    /**
     * This method returns performance statistics for a given zones.
     *
     * @access public
     *
     * @param array $aZonesIds array of IDs of the zones to view statistics
     * @param int $campaignId The ID of the campaing for which zones statistic are calculated (if null, then global zone statistic are calculated)
     * @param PEAR::Date $oStartDate The date from which to get statistics (inclusive)
     * @param PEAR::Date $oEndDate The date to which to get statistics (inclusive)
     * @param int $impressionsThreshold  Minimum number of impressions needed to calculate performance statistics (eCPM, CR, CTR)
     * @param int $daysIntervalThreshold  Minimum period of time (in days) needed to calculate performance statistics (eCPM, CR, CTR)
     * @return array
     *   <ul>
     *   <li><b>zone_id integer</b> key The ID of the zone
     *   <li><b>array<b> with statistics
     *      <ul>
     *      <li><b>CTR decimal</b> CTR - Click Through Rate
     *      <li><b>eCPM decimal</b> eCPM - effective cost per mille
     *      <li><b>CR decimal</b> CR - Conversion Rate
     *      </ul>
     *   </li>
     *   </ul>
     */
    function getZonesPerformanceStatistics( $aZonesIds,
                                            $campaignId = null,
                                            $oStartDate = null,
                                            $oEndDate = null,
                                            $impressionsThreshold = null,
                                            $daysIntervalThreshold = null)
    {
        if (!is_array($aZonesIds) || count($aZonesIds)==0) {
            return array();
        }
        if (is_null($oEndDate)) {
            $oEndDate = new Date();
        }

        if (is_null($oStartDate)) {
            $oStartDate = new Date($oEndDate);
            $oStartDate->subtractSpan(new Date_Span("30, 0, 0, 0")); // Set start date to 30 days before end date is start date is null
        }
        // Initial setting of result array
        $aZonesStatistics = array();
        foreach ($aZonesIds as $zoneId) {
            $aZonesStatistics[$zoneId] = array ('CTR' => null, 'eCPM' => null, 'CR' => null);
        }

        // If time span for given dates is greater that daysIntervalThreshold there isn't any statistics to calculate
        if ($this->_checkDaysIntervalThreshold($oStartDate, $oEndDate, $daysIntervalThreshold) == false) {
            return $aZonesStatistics;
        }

        // Query DB for all statistics and catch errors if any
        $rsZonesConversionRateStatistics = $this->getZonesConversionRateStatistics($aZonesIds, $oStartDate, $oEndDate, $campaignId, $impressionsThreshold, $daysIntervalThreshold);
        if (PEAR::isError($rsZonesConversionRateStatistics)) {
            return $rsZonesConversionRateStatistics;
        }
        $rsZonesEcpmStatistics = $this->getZonesEcpmStatistics($aZonesIds, $oStartDate, $oEndDate, $campaignId, $impressionsThreshold, $daysIntervalThreshold);
        if (PEAR::isError($rsZonesEcpmStatistics)) {
            return $rsZonesEcpmStatistics;
        }
        $rsZonesCtrStatistics = $this->getZonesCtrStatistics($aZonesIds, $oStartDate, $oEndDate, $campaignId, $impressionsThreshold, $daysIntervalThreshold);
        if (PEAR::isError($rsZonesCtrStatistics)) {
            return $rsZonesCtrStatistics;
        }

        // fill result array with statistics
        $aZonesEcpmStatistics = $rsZonesEcpmStatistics->getAll();
        foreach ($aZonesEcpmStatistics as $aZoneStatistics) {
            if (!is_null($aZoneStatistics['total_revenue']) &&
                !is_null($aZoneStatistics['impressions']) &&
                $aZoneStatistics['impressions']!=0)
            {
                $aZonesStatistics[$aZoneStatistics['zone_id']]['eCPM'] = $aZoneStatistics['total_revenue']*1000/$aZoneStatistics['impressions'];
            }
        }
        $aZonesConversionRateStatistics = $rsZonesConversionRateStatistics->getAll();
        foreach ($aZonesConversionRateStatistics as $aZoneStatistics) {
            if (!is_null($aZoneStatistics['conversions']) &&
                !is_null($aZoneStatistics['impressions']) &&
                $aZoneStatistics['impressions']!=0)
            {
                $aZonesStatistics[$aZoneStatistics['zone_id']]['CR'] = $aZoneStatistics['conversions']/$aZoneStatistics['impressions'];
            }
        }
        $aZonesCtrStatistics = $rsZonesCtrStatistics->getAll();
        foreach ($aZonesCtrStatistics as $aZoneStatistics) {
            if (!is_null($aZoneStatistics['clicks']) &&
                !is_null($aZoneStatistics['impressions']) &&
                $aZoneStatistics['impressions']!=0)
            {
                $aZonesStatistics[$aZoneStatistics['zone_id']]['CTR'] = $aZoneStatistics['clicks']/$aZoneStatistics['impressions'];
            }
        }
        return $aZonesStatistics;
    }

    /**
     * This method returns data to calculate Conversion Rate statistics for a given zones.
     *
     * Click Rate is calculated using statistics related to campaigns with revenue type CPA
     * Returned RecordSet contain only that zones for which statistics can be calculated.
     *
     * @param array $aZonesIds array of IDs of the zones to view statistics
     * @param PEAR::Date $oStartDate The date from which to get statistics (inclusive)
     * @param PEAR::Date $oEndDate The date to which to get statistics (inclusive)
     * @param int $campaignId The ID of the campaing for which zones statistic are calculated (if null, then global zone statistic are calculated)
     * @param int $impressionsThreshold  Minimum number of impressions needed to calculate performance statistics (eCPM, CR, CTR)
     * @param int $daysIntervalThreshold  Minimum period of time (in days) needed to calculate performance statistics (eCPM, CR, CTR)
     * @return RecordSet
     *   <ul>
     *   <li><b>zone_id integer</b> The ID of the zone
     *   <li><b>conversions decimal</b> sum of conversions
     *   <li><b>impressions decimal</b> sum of impressions
     *   </ul>
     */
    function getZonesConversionRateStatistics( $aZonesIds,
                                               $oStartDate,
                                               $oEndDate,
                                               $campaignId = null,
                                               $impressionsThreshold = null,
                                               $daysIntervalThreshold = null)
    {
        $tableCampaigns = $this->quoteTableName('campaigns');
        $tableBanners   = $this->quoteTableName('banners');
        $tableSummary   = $this->quoteTableName('data_summary_ad_hourly');

        $impressionsThreshold = $this->_setImpressionsThreshold($impressionsThreshold);

        if ($this->_checkDaysIntervalThreshold($oStartDate, $oEndDate, $daysIntervalThreshold) == false) {
            return $this->_emptyRecordSet();
        }

        $query = "
             SELECT
                s.zone_id AS zone_id,
                SUM(s.conversions) AS conversions,
                SUM(s.impressions) AS impressions
            FROM
                $tableCampaigns AS c,
                $tableBanners AS b,
                $tableSummary AS s
            WHERE
                s.zone_id IN (" . implode(',', $aZonesIds) . ")
                " . ((isset($campaignId)) ? ("AND b.campaignid = " . $this->oDbh->quote($campaignId, 'integer')) : ("")) . "

                AND
                c.revenue_type = ". $this->oDbh->quote(MAX_FINANCE_CPA) . "


                AND
                b.bannerid = s.ad_id
                AND
                b.campaignid = c.campaignid

                " . $this->getWhereDate($oStartDate, $oEndDate, $localTZ) . "
            GROUP BY
                s.zone_id
            HAVING
                SUM(s.impressions) >= " . $impressionsThreshold . "
        ";

        return DBC::NewRecordSet($query);
    }

    /**
     * This method returns data to calculate eCPM (efficient Cost Per Mille) statistics for a given zones.
     *
     * Click Rate is calculated using statistics related to campaigns with revenue type different from Monthly Tennancy and null
     * Returned RecordSet contain only that zones for which statistics can be calculated.
     *
     * @param array $aZonesIds array of IDs of the zones to view statistics
     * @param PEAR::Date $oStartDate The date from which to get statistics (inclusive)
     * @param PEAR::Date $oEndDate The date to which to get statistics (inclusive)
     * @param int $campaignId The ID of the campaing for which zones statistic are calculated (if null, then global zone statistic are calculated)
     * @param int $impressionsThreshold  Minimum number of impressions needed to calculate performance statistics (eCPM, CR, CTR)
     * @param int $daysIntervalThreshold  Minimum period of time (in days) needed to calculate performance statistics (eCPM, CR, CTR)
     * @return RecordSet
     *   <ul>
     *   <li><b>zone_id integer</b> The ID of the zone
     *   <li><b>total_revenue decimal</b> sum of total_revenue
     *   <li><b>impressions decimal</b> sum of impressions
     *   </ul>
     */
    function getZonesEcpmStatistics( $aZonesIds,
                                     $oStartDate,
                                     $oEndDate,
                                     $campaignId = null,
                                     $impressionsThreshold = null,
                                     $daysIntervalThreshold = null)
    {
        $tableCampaigns = $this->quoteTableName('campaigns');
        $tableBanners   = $this->quoteTableName('banners');
        $tableSummary   = $this->quoteTableName('data_summary_ad_hourly');

        $impressionsThreshold = $this->_setImpressionsThreshold($impressionsThreshold);
        if ($this->_checkDaysIntervalThreshold($oStartDate, $oEndDate, $daysIntervalThreshold) == false) {
            return $this->_emptyRecordSet();
        }

        $query = "
            SELECT
                s.zone_id AS zone_id,
                SUM(s.total_revenue) AS total_revenue,
                SUM(s.impressions) AS impressions
            FROM
                $tableCampaigns AS c,
                $tableBanners AS b,
                $tableSummary AS s
            WHERE
                s.zone_id IN (" . implode(',', $aZonesIds) . ")
                " . ((isset($campaignId)) ? ("AND b.campaignid = " . $this->oDbh->quote($campaignId, 'integer')) : ("")) . "

                AND
                c.revenue_type <> ". $this->oDbh->quote(MAX_FINANCE_MT) . "
                AND
                c.revenue_type is not null

                AND
                b.bannerid = s.ad_id
                AND
                b.campaignid = c.campaignid

                " . $this->getWhereDate($oStartDate, $oEndDate, $localTZ) . "
            GROUP BY
                s.zone_id
            HAVING
                SUM(s.impressions) >= " . $impressionsThreshold . "
        ";
        return DBC::NewRecordSet($query);
    }

     /**
     * This method returns data to calculate CTR (Click Through Rate) statistics for a given zones.
     * Returned RecordSet contain only that zones for which statistics can be calculated.
     *
     * Statistics threshold:
     *  - 10.000 impressions in given
     *
     * @param array $aZonesIds array of IDs of the zones to view statistics
     * @param PEAR::Date $oStartDate The date from which to get statistics (inclusive)
     * @param PEAR::Date $oEndDate The date to which to get statistics (inclusive)
     * @param int $campaignId The ID of the campaing for which zones statistic are calculated (if null, then global zone statistic are calculated)
     * @param int $impressionsThreshold  Minimum number of impressions needed to calculate performance statistics (eCPM, CR, CTR)
     * @param int $daysIntervalThreshold  Minimum period of time (in days) needed to calculate performance statistics (eCPM, CR, CTR)
     * @return RecordSet
     *   <ul>
     *   <li><b>zone_id integer</b> The ID of the zone
     *   <li><b>clics decimal</b> sum of clics
     *   <li><b>impressions decimal</b> sum of impressions
     *   </ul>
     */
    function getZonesCtrStatistics( $aZonesIds,
                                    $oStartDate,
                                    $oEndDate,
                                    $campaignId = null,
                                    $impressionsThreshold = null,
                                    $daysIntervalThreshold = null)
    {
        $tableCampaigns = $this->quoteTableName('campaigns');
        $tableBanners   = $this->quoteTableName('banners');
        $tableSummary   = $this->quoteTableName('data_summary_ad_hourly');

        $impressionsThreshold = $this->_setImpressionsThreshold($impressionsThreshold);
        if ($this->_checkDaysIntervalThreshold($oStartDate, $oEndDate, $daysIntervalThreshold) == false) {
            return $this->_emptyRecordSet();
        }

        if (isset($campaignId)) {
            $query = "
                SELECT
                    s.zone_id AS zone_id,
                    SUM(s.clicks) AS clicks,
                    SUM(s.impressions) AS impressions
                FROM
                    $tableBanners AS b,
                    $tableSummary AS s
                WHERE
                    s.zone_id IN (" . implode(',', $aZonesIds) . ")
                    AND
                    b.campaignid = " . $this->oDbh->quote($campaignId, 'integer') . "

                    AND
                    b.bannerid = s.ad_id

                    " . $this->getWhereDate($oStartDate, $oEndDate, $localTZ) . "
                GROUP BY
                    s.zone_id
                HAVING
                    SUM(s.impressions) >= " . $impressionsThreshold . "
            ";
        } else {
            $query = "
                SELECT
                    s.zone_id AS zone_id,
                    SUM(s.clicks) AS clicks,
                    SUM(s.impressions) AS impressions
                FROM
                    $tableSummary AS s
                WHERE
                    s.zone_id IN (" . implode(',', $aZonesIds) . ")

                    " . $this->getWhereDate($oStartDate, $oEndDate, $localTZ) . "
                GROUP BY
                    s.zone_id
                HAVING
                    SUM(s.impressions) >= " . $impressionsThreshold . "
            ";
        }
        return DBC::NewRecordSet($query);
    }

    /**
     * This method returns quoted impressionsThreshold value.
     * If parametr is null or just isn't numeric the value for treshold is set from config file
     *
     * @param int $impressionThreshold
     * @return unknown
     */
    function _setImpressionsThreshold($impressionsThreshold = null)
    {
        if (!is_numeric($impressionsThreshold)) {
            $impressionsThreshold = $GLOBALS['_MAX']['CONF']['performanceStatistics']['defaultImpressionsThreshold'];
        }
        return $this->oDbh->quote($impressionsThreshold, 'integer');
    }

    /**
     * This method check if time span for given dates is greater that daysIntervalThreshold
     *
     * @param PEAR:Date $oStartDate
     * @param PEAR:Date $oEndDate
     * @param int $daysIntervalThreshold
     * @return boolean true if time span in days is greater or equal to daysIntervalThreshold, else false
     */
    function _checkDaysIntervalThreshold($oStartDate, $oEndDate, $daysIntervalThreshold = null)
    {
        if (!is_numeric($daysIntervalThreshold)) {
            $daysIntervalThreshold = $GLOBALS['_MAX']['CONF']['performanceStatistics']['defaultDaysIntervalThreshold'];
        }
        $span = new Date_Span();
        $span->setFromDateDiff($oStartDate, $oEndDate);

        return ($span->toDays()>=$daysIntervalThreshold);
    }

    /**
     * Just generate empty RecordSet
     *
     * @return RecordSet always empty
     */
    function _emptyRecordSet() {
        $tableCampaigns = $this->quoteTableName('campaigns');
        return DBC::NewRecordSet("select * from $tableCampaigns where 1=0");
    }
}

?>

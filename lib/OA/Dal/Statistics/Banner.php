<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id:$
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
    *
    * @return RecordSet
    *   <ul>
    *   <li><b>day date</b> The day
    *   <li><b>requests integer</b> The number of requests for the day
    *   <li><b>impressions integer</b> The number of impressions for the day
    *   <li><b>clicks integer</b> The number of clicks for the day
    *   <li><b>revenue decimal</b> The revenue earned for the day
    *   </ul>
    *
    */
    function getBannerDailyStatistics($bannerId, $oStartDate, $oEndDate)
    {
        $bannerId     = $this->oDbh->quote($bannerId, 'integer');
        $tableBanners = $this->quoteTableName('banners');
        $tableSummary = $this->quoteTableName('data_summary_ad_hourly');

        $aConf = $GLOBALS['_MAX']['CONF'];

		$query = "
            SELECT
                SUM(s.impressions) AS impressions,
                SUM(s.clicks) AS clicks,
                SUM(s.requests) AS requests,
                SUM(s.total_revenue) AS revenue,
                DATE_FORMAT(s.date_time, '%Y-%m-%d') AS day
            FROM
                $tableBanners AS b,
                $tableSummary AS s
            WHERE
                b.bannerid = $bannerId
                AND
                b.bannerid = s.ad_id
                " . $this->getWhereDate($oStartDate, $oEndDate) . "
            GROUP BY
                day
        ";

        return DBC::NewRecordSet($query);
    }

   /**
    * This method returns statistics for a given banner, broken down by publisher.
    *
    * @access public
    *
    * @param integer $bannerId The ID of the banner to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
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
    function getBannerPublisherStatistics($bannerId, $oStartDate, $oEndDate)
    {
        $bannerId     = $this->oDbh->quote($bannerId, 'integer');
        $tableBanners = $this->quoteTableName('banners');
        $tableZones      = $this->quoteTableName('zones');
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
                " . $this->getWhereDate($oStartDate, $oEndDate) . "
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
    function getBannerZoneStatistics($bannerId, $oStartDate, $oEndDate)
    {
        $bannerId     = $this->oDbh->quote($bannerId, 'integer');
        $tableBanners = $this->quoteTableName('banners');
        $tableZones      = $this->quoteTableName('zones');
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
                " . $this->getWhereDate($oStartDate, $oEndDate) . "
            GROUP BY
                p.affiliateid, p.name,
                z.zoneid, z.zonename
        ";

        return DBC::NewRecordSet($query);
    }

}

?>
<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
$Id$
*/

require_once MAX_PATH . '/lib/max/Admin/Reporting/ReportScope.php';
require_once MAX_PATH . '/lib/max/Dal/Reporting.php';
require_once MAX_PATH . '/plugins/reports/lib.php';
require_once MAX_PATH . '/constants.php';

/**
 * Reporting DAL for Openads (proprietary)
 *
 * @TODO Remove any Excel-specific output
 * @TODO Move all DAL code into the real DAL!!!!!
 */
class MAX_Dal_Reporting_Proprietary extends MAX_Dal_Reporting
{

    /**
     * Local locking object for ensuring MPE only runs once.
     *
     * @var OA_DB_AdvisoryLock
     */
    var $oLock;

    /**
     * Finds the views and clicks for a zone grouped by day.
     *
     * @return Array of arrays Row data
     */
    function getEffectivenessForZoneByDay($zone_id, $oDaySpan, $minimum_impressions)
    {
        $aWhere = array();
        if (!is_null($oDaySpan)) {
            $start = $oDaySpan->getStartDateString();
            $end = $oDaySpan->getEndDateString();
            $aWhere[] = "day >= '$start' AND day <= '$end'";
        }
        $aWhere[] = "zone_id=". $this->oDbh->quote($zone_id, 'integer');
        $data_summary_ad_hourly_table = $this->getFullTableName('data_summary_ad_hourly');
        $where = sizeof($aWhere) == 0 ? '' : "
WHERE
    " . implode("\n    AND ", $aWhere);

        $query = "
SELECT
    day,
    sum(impressions) as impressions,
    sum(clicks) as clicks
FROM
    $data_summary_ad_hourly_table
$where
GROUP BY
    day
HAVING
    sum(impressions) >= ". $this->oDbh->quote($minimum_impressions, 'integer') ."
ORDER BY
    day ASC
";
        $results = $this->oDbh->getAll($query);
        if (PEAR::isError($results)) {
            MAX::raiseError($results);
        }
        return $results;

    }

    function getEffectivenessForZoneByDomain($zone_id, $oDaySpan, $minimum_impressions)
    {
        $aWhere = array();
        if (!is_null($oDaySpan)) {
            $start = $oDaySpan->getStartDateString();
            $end = $oDaySpan->getEndDateString();
            $aWhere[] = "day >= '$start' AND day <= '$end'";
        }
        $aWhere[] = "zone_id=". $this->oDbh->quote($zone_id, 'integer');
        $data_summary_zone_domain_page_daily_table = $this->getFullTableName('data_summary_zone_domain_page_daily');
        $where = sizeof($aWhere) == 0 ? '' : "
WHERE
    " . implode("\n    AND ", $aWhere);

        $query = "
SELECT
    domain,
    sum(impressions) as impressions
FROM
    $data_summary_zone_domain_page_daily_table AS dszidp
$where
GROUP BY
    domain
HAVING
    sum(impressions) >= ". $this->oDbh->quote($minimum_impressions, 'integer') ."
ORDER BY
    impressions DESC,
    domain ASC
";
        $res = $this->oDbh->query($query);
        if (PEAR::isError($res)) {
            return $res;
        }

        $count = 0;
        while ($row = $res->fetchRow()) {
            $effectiveness[$count][0] = $row['domain'];
            $effectiveness[$count][1] = $row['impressions'];
            $count++;
        }
        return $effectiveness;

    }

    function getEffectivenessForZoneByPage($zone_id, $oDaySpan, $minimum_impressions)
    {
        $aWhere = array();
        if (!is_null($oDaySpan)) {
            $start = $oDaySpan->getStartDateString();
            $end = $oDaySpan->getEndDateString();
            $aWhere[] = "day >= '$start' AND day <= '$end'";
        }
        $aWhere[] = "zone_id=". $this->oDbh->quote($zone_id, 'integer');
        $data_summary_zone_domain_page_daily_table = $this->getFullTableName('data_summary_zone_domain_page_daily');
        $where = sizeof($aWhere) == 0 ? '' : "
WHERE
    " . implode("\n    AND ", $aWhere);

        assert($data_summary_zone_domain_page_daily_table);
        assert($zone_id > 0);
        $query = "
SELECT
    dszidp.domain AS domain,
    dszidp.page AS page,
    sum(dszidp.impressions) as impressions
FROM
    $data_summary_zone_domain_page_daily_table AS dszidp
$where
GROUP BY
    dszidp.domain,
    dszidp.page
HAVING
    sum(dszidp.impressions) >= ". $this->oDbh->quote($minimum_impressions, 'integer') ."
ORDER BY
    impressions DESC,
    domain,
    page
";
        $res = $this->oDbh->query($query);
        if (PEAR::isError($res)) {
            return $res;
        }

        $count = 0;
        while ($row = $res->fetchRow()) {
            $effectiveness[$count][0] = $row['domain'];
            $effectiveness[$count][1] = $row['page'];
            $effectiveness[$count][2] = $row['impressions'];
            $count++;
        }
        return $effectiveness;

    }


    /**
     * Finds impressions and clicks for a zone grouped by day, domain and page
     *
     * @return Array of arrays Row data
     */
    function getEffectivenessForZoneByDayDomainPage($zone_id, $oDaySpan, $row_limit)
    {
        $aWhere = array();
        if (!is_null($oDaySpan)) {
            $start = $oDaySpan->getStartDateString();
            $end = $oDaySpan->getEndDateString();
            $aWhere[] = "day BETWEEN '$start' AND '$end'";
        }
        $aWhere[] = "zone_id=". $this->oDbh->quote($zone_id, 'integer');
        $data_summary_table = $this->getFullTableName('data_summary_zone_domain_page_daily');
        $where = sizeof($aWhere) == 0 ? '' : "
WHERE
    " . implode("\n    AND ", $aWhere);

        $query = "
SELECT
    day,
    domain,
    page,
    impressions,
    clicks
FROM
    $data_summary_table
$where
ORDER BY
    impressions DESC,
    clicks DESC,
    domain,
    page,
    day
    ";
        if (is_numeric($row_limit)) $query .= " LIMIT $row_limit";
        $results = $this->oDbh->getAll($query);
        if (PEAR::isError($results)) {
            MAX::raiseError($results);
        }
        return $results;
    }


    /**
     * Finds impressions and clicks for a zone grouped by day and country
     *
     * @return Array of arrays Row data
     */
    function getEffectivenessForZoneByDayCountry($zone_id, $oDaySpan, $row_limit)
    {
        $aWhere = array();
        if (!is_null($oDaySpan)) {
            $start = $oDaySpan->getStartDateString();
            $end = $oDaySpan->getEndDateString();
            $aWhere[] = "day BETWEEN '$start' AND '$end'";
        }
        $aWhere[] = "zone_id=". $this->oDbh->quote($zone_id, 'integer');
        $data_summary_table = $this->getFullTableName('data_summary_zone_country_daily');
        $where = sizeof($aWhere) == 0 ? '' : "
WHERE
    " . implode("\n    AND ", $aWhere);

        $query = "
SELECT
    day,
    country,
    impressions,
    clicks
FROM
    $data_summary_table
$where
ORDER BY
    impressions DESC,
    clicks DESC,
    country,
    day
    ";
        if (is_numeric($row_limit)) $query .= " LIMIT $row_limit";
        $results = $this->oDbh->getAll($query);
        if (PEAR::isError($results)) {
            MAX::raiseError($results);
        }
        return $results;
    }


    /**
     * Finds impressions and clicks for a zone grouped by day and source
     *
     * @return Array of arrays Row data
     */
    function getEffectivenessForZoneByDaySource($zone_id, $oDaySpan, $row_limit)
    {
        $aWhere = array();
        if (!is_null($oDaySpan)) {
            $start = $oDaySpan->getStartDateString();
            $end = $oDaySpan->getEndDateString();
            $aWhere[] = "day BETWEEN '$start' AND '$end'";
        }
        $aWhere[] = "zone_id=". $this->oDbh->quote($zone_id, 'integer');
        $data_summary_table = $this->getFullTableName('data_summary_zone_source_daily');
        $where = sizeof($aWhere) == 0 ? '' : "
WHERE
    " . implode("\n    AND ", $aWhere);

        $query = "
SELECT
    day,
    source,
    impressions,
    clicks
FROM
    $data_summary_table
$where
ORDER BY
    impressions DESC,
    clicks DESC,
    source,
    day
    ";
        if (is_numeric($row_limit)) $query .= " LIMIT $row_limit";
        $results = $this->oDbh->getAll($query);
        if (PEAR::isError($results)) {
            MAX::raiseError($results);
        }
        return $results;
    }


    /**
     * Finds impressions and clicks for a zone grouped by day, site and keyword
     *
     * @return Array of arrays Row data
     */
    function getEffectivenessForZoneByDaySiteKeyword($zone_id, $oDaySpan, $row_limit)
    {
        $aWhere = array();
        if (!is_null($oDaySpan)) {
            $start = $oDaySpan->getStartDateString();
            $end = $oDaySpan->getEndDateString();
            $aWhere[] = "day BETWEEN '$start' AND '$end'";
        }
        $aWhere[] = "zone_id=". $this->oDbh->quote($zone_id, 'integer');
        $data_summary_table = $this->getFullTableName('data_summary_zone_site_keyword_daily');
        $where = sizeof($aWhere) == 0 ? '' : "
WHERE
    " . implode("\n    AND ", $aWhere);

        $query = "
SELECT
    day,
    site,
    keyword,
    impressions,
    clicks
FROM
    $data_summary_table
$where
ORDER BY
    impressions DESC,
    clicks DESC,
    site,
    keyword,
    day
    ";
        if (is_numeric($row_limit)) $query .= " LIMIT $row_limit";
        $results = $this->oDbh->getAll($query);
        if (PEAR::isError($results)) {
            MAX::raiseError($results);
        }
        return $results;
    }


    /**
     * Finds impressions and clicks for a zone grouped by month, domain and page
     *
     * @return Array of arrays Row data
     */
    function getEffectivenessForZoneByMonthDomainPage($zone_id, $start, $end, $row_limit)
    {
        $aWhere = array();
        $start = str_replace(' ', '', $start);
        $end = str_replace(' ', '', $end);
        if (!empty($start) && !empty($end)) {
            $aWhere[] = "yearmonth BETWEEN '".str_replace('/','',$this->oDbh->quote($start, 'integer'))."' AND '".str_replace('/','',$this->oDbh->quote($end, 'integer'))."'";
        } else if (!empty($start)) {
            $aWhere[] = "yearmonth >= '".str_replace('/','',$this->oDbh->quote($start, 'integer'))."'";
        } else if (!empty($end)) {
            $aWhere[] = "yearmonth <= '".str_replace('/','',$this->oDbh->quote($end, 'integer'))."'";
        }
        $aWhere[] = "zone_id=". $this->oDbh->quote($zone_id, 'integer');
        $data_summary_table = $this->getFullTableName('data_summary_zone_domain_page_monthly');
        $where = sizeof($aWhere) == 0 ? '' : "
WHERE
    " . implode("\n    AND ", $aWhere);

        $query = "
SELECT
    yearmonth,
    domain,
    page,
    impressions,
    clicks
FROM
    $data_summary_table
$where
ORDER BY
    impressions DESC,
    clicks DESC,
    domain,
    page,
    yearmonth
    ";
        if (is_numeric($row_limit)) $query .= " LIMIT $row_limit";
        $results = $this->oDbh->getAll($query);
        if (PEAR::isError($results)) {
            MAX::raiseError($results);
        }
        return $results;
    }


    /**
     * Finds impressions and clicks for a zone grouped by month and country
     *
     * @return Array of arrays Row data
     */
    function getEffectivenessForZoneByMonthCountry($zone_id, $start, $end, $row_limit)
    {
        $aWhere = array();
        $start = str_replace(' ', '', $start);
        $end = str_replace(' ', '', $end);
        if (!empty($start) && !empty($end)) {
            $aWhere[] = "yearmonth BETWEEN '".str_replace('/','',$this->oDbh->quote($start, 'integer'))."' AND '".str_replace('/','',$this->oDbh->quote($end, 'integer'))."'";
        } else if (!empty($start)) {
            $aWhere[] = "yearmonth >= '".str_replace('/','',$this->oDbh->quote($start, 'integer'))."'";
        } else if (!empty($end)) {
            $aWhere[] = "yearmonth <= '".str_replace('/','',$this->oDbh->quote($end, 'integer'))."'";
        }
        $aWhere[] = "zone_id=". $this->oDbh->quote($zone_id, 'integer');
        $data_summary_table = $this->getFullTableName('data_summary_zone_country_monthly');
        $where = sizeof($aWhere) == 0 ? '' : "
WHERE
    " . implode("\n    AND ", $aWhere);

        $query = "
SELECT
    yearmonth,
    country,
    impressions,
    clicks
FROM
    $data_summary_table
$where
ORDER BY
    impressions DESC,
    clicks DESC,
    country,
    yearmonth
    ";
        if (is_numeric($row_limit)) $query .= " LIMIT $row_limit";
        $results = $this->oDbh->getAll($query);
        if (PEAR::isError($results)) {
            MAX::raiseError($results);
        }
        return $results;
    }


    /**
     * Finds impressions and clicks for a zone grouped by month and country
     *
     * @return Array of arrays Row data
     */
    function getEffectivenessForZoneByMonthSource($zone_id, $start, $end, $row_limit)
    {
        $aWhere = array();
        $start = str_replace(' ', '', $start);
        $end = str_replace(' ', '', $end);
        if (!empty($start) && !empty($end)) {
            $aWhere[] = "yearmonth BETWEEN '".str_replace('/','',$this->oDbh->quote($start, 'integer'))."' AND '".str_replace('/','',$this->oDbh->quote($end,'integer'))."'";
        } else if (!empty($start)) {
            $aWhere[] = "yearmonth >= '".str_replace('/','',$this->oDbh->quote($start, 'integer'))."'";
        } else if (!empty($end)) {
            $aWhere[] = "yearmonth <= '".str_replace('/','',$this->oDbh->quote($end, 'integer'))."'";
        }
        $aWhere[] = "zone_id=". $this->oDbh->quote($zone_id, 'integer');
        $data_summary_table = $this->getFullTableName('data_summary_zone_source_monthly');
        $where = sizeof($aWhere) == 0 ? '' : "
WHERE
    " . implode("\n    AND ", $aWhere);

        $query = "
SELECT
    yearmonth,
    source,
    impressions,
    clicks
FROM
    $data_summary_table
$where
ORDER BY
    impressions DESC,
    clicks DESC,
    source,
    yearmonth
    ";
        if (is_numeric($row_limit)) $query .= " LIMIT $row_limit";
        $results = $this->oDbh->getAll($query);
        if (PEAR::isError($results)) {
            MAX::raiseError($results);
        }
        return $results;
    }


    /**
     * Finds impressions and clicks for a zone grouped by month, site and keyword
     *
     * @return Array of arrays Row data
     */
    function getEffectivenessForZoneByMonthSiteKeyword($zone_id, $start, $end, $row_limit)
    {
        $aWhere = array();
        $start = str_replace(' ', '', $start);
        $end = str_replace(' ', '', $end);
        if (!empty($start) && !empty($end)) {
            $aWhere[] = "yearmonth BETWEEN '".str_replace('/','',$this->oDbh->quote($start, 'integer'))."' AND '".str_replace('/','',$this->oDbh->quote($end, 'integer'))."'";
        } else if (!empty($start)) {
            $aWhere[] = "yearmonth >= '".str_replace('/','',$this->oDbh->quote($start, 'integer'))."'";
        } else if (!empty($end)) {
            $aWhere[] = "yearmonth <= '".str_replace('/','',$this->oDbh->quote($end, 'integer'))."'";
        }
        $aWhere[] = "zone_id=". $this->oDbh->quote($zone_id, 'integer');
        $data_summary_table = $this->getFullTableName('data_summary_zone_site_keyword_monthly');
        $where = sizeof($aWhere) == 0 ? '' : "
WHERE
    " . implode("\n    AND ", $aWhere);

        $query = "
SELECT
    yearmonth,
    site,
    keyword,
    impressions,
    clicks
FROM
    $data_summary_table
$where
ORDER BY
    impressions DESC,
    clicks DESC,
    site,
    keyword,
    yearmonth
    ";
        if (is_numeric($row_limit)) $query .= " LIMIT $row_limit";
        $results = $this->oDbh->getAll($query);
        if (PEAR::isError($results)) {
            MAX::raiseError($results);
        }
        return $results;
    }


    /**
     * Get the parent publisher ID for a given zone ID.
     *
     * @param unknown_type $zoneId
     * @todo This method should not be here - a quick fix for the inventoryReport.
     * @return $publisherId
     */
    function getPublisherIdByZoneId($zoneId)
    {
        $zones_table = $this->getFullTableName('zones');
        $query = "
SELECT
    affiliateid AS publisher_id
FROM
    $zones_table AS z
WHERE
    z.zoneid=". $this->oDbh->quote($zoneId, 'integer');

        $res = $this->oDbh->query($query);
        if (PEAR::isError($res)) {
            return $res;
        }

        if ($row = $res->fetchRow()) {
            $publisherId = $row['publisher_id'];
        } else {
            $publisherId = false;
        }

        return $publisherId;
    }


    /**
     * Get the parent advertiser ID for a given campaign ID.
     *
     * @param unknown_type $campaignId
     * @todo This method should not be here - a quick fix for the campaignAnalysisReport
     * @return $advertiserId
     */
    function getAdvertiserIdByCampaignId($campaignId)
    {
        $campaigns_table = $this->getFullTableName('campaigns');
        $query = "
SELECT
    clientid AS advertiser_id
FROM
    $campaigns_table AS c
WHERE
    c.campaignid=". $this->oDbh->quote($campaignId, 'integer');

        $res = $this->oDbh->query($query);
        if (PEAR::isError($res)) {
            return $res;
        }

        if ($row = $res->fetchRow()) {
            $advertiserId = $row['advertiser_id'];
        } else {
            $advertiserId = false;
        }

        return $advertiserId;
    }


    function getEffectivenessForAllPublisherZonesByDomain($publisher_id, $oDaySpan, $minimum_impressions = 0)
    {
        if (!is_null($oDaySpan)) {
            $start = $oDaySpan->getStartDateString();
            $end = $oDaySpan->getEndDateString();
            $dateLimitation = "dszidp.day >= '$start' AND dszidp.day <= '$end' AND";
        } else {
            $dateLimitation = '';
        }
        $data_summary_zone_domain_page_daily_table = $this->getFullTableName('data_summary_zone_domain_page_daily');
        $zones_table = $this->getFullTableName('zones');
        $query = "
SELECT
    domain,
    sum(impressions) as impressions
FROM
    $data_summary_zone_domain_page_daily_table AS dszidp
    INNER JOIN $zones_table AS z
        ON z.zoneid = dszidp.zone_id
WHERE
    $dateLimitation
    z.affiliateid = ". $this->oDbh->quote($publisher_id, 'integer') ."
GROUP BY
    domain
HAVING
    sum(impressions) >= " . $this->oDbh->quote($minimum_impressions, 'integer') . "
ORDER BY
    impressions DESC,
    domain
";
        $res = $this->oDbh->getAll($query);
        if (PEAR::isError($res)) {
            return $res;
        }

        $count = 0;
        while ($row = $res->fetchRow()) {
            $effectiveness[$count][0] = $row['domain'];
            $effectiveness[$count][1] = $row['impressions'];
            $count++;
        }
        return $effectiveness;
    }

    /**
     * @todo Deprecate this and use getEffectivenessForScopeByDay() instead
     *       (once Scope can handle zones)
     * @todo Remove Excel specific bits
     */
    function getEffectivenessForAllPublisherZonesByDay($publisher_id, $oDaySpan, $minimum_impressions = 0)
    {
        $this->_buildQueryForEverythingByDay($oDaySpan);
        $this->_restrictEffectivenessQueryToPublisher($publisher_id);
        $results = $this->queryBuilder->getAll();

        return $results;
    }

    /**
     * @todo get rid of Excel-specific bits
     * @todo convert SQL to QueryBuilder syntax
     */
    function getEffectivenessForAllPublisherZonesByZone($publisher_id, $oDaySpan, $minimum_impressions = 0)
    {
        $data_summary_ad_hourly_table = $this->getFullTableName('data_summary_ad_hourly');
        $this->_buildQueryForEverythingByZone($this->queryBuilder, $oDaySpan);
        $this->_restrictZoneQueryToPublisher($publisher_id);

        $this->queryBuilder->addHaving("SUM($data_summary_ad_hourly_table.impressions) >= $minimum_impressions");
        $effectiveness = $this->queryBuilder->getAll();
        return $effectiveness;

    }

    /**
     * @todo convert SQL to QueryBuilder syntax
     */
    function getEffectivenessForAllPublisherZonesByPage($publisher_id, $oDaySpan, $minimum_impressions)
    {
        if (!is_null($oDaySpan)) {
            $start = $oDaySpan->getStartDateString();
            $end = $oDaySpan->getEndDateString();
            $dateLimitation = "dszidp.day >= '$start' AND dszidp.day <= '$end' AND";
        } else {
            $dateLimitation = '';
        }
        $data_summary_zone_domain_page_daily_table = $this->getFullTableName('data_summary_zone_domain_page_daily');
        $zones_table = $this->getFullTableName('zones');
        assert($data_summary_zone_domain_page_daily_table);
        assert($publisher_id > 0);
        $query = "
SELECT
    dszidp.domain AS domain,
    dszidp.page AS page,
    sum(dszidp.impressions) as impressions
FROM
    $data_summary_zone_domain_page_daily_table AS dszidp
    INNER JOIN $zones_table z ON
        z.zoneid = dszidp.zone_id
WHERE
    $dateLimitation
    z.affiliateid = ". $this->oDbh->quote($publisher_id, 'integer') ."
GROUP BY
    dszidp.domain,
    dszidp.page
HAVING
    sum(dszidp.impressions) >= ". $this->oDbh->quote($minimum_impressions, 'integer') ."
ORDER BY
    impressions DESC,
    domain,
    page
";
        $res = phpAds_dbQuery($query)
            or phpAds_sqlDie();

        $count = 0;
        while ($row = phpAds_dbFetchArray($res)) {
            $effectiveness[$count][0] = $row['domain'];
            $effectiveness[$count][1] = $row['page'];
            $effectiveness[$count][2] = $row['impressions'];
            $count++;
        }
        return $effectiveness;
    }

    /**
     * @param int $publisher_id
     * @param DaySpan $oDaySpan
     * @param int $minimum_impressions
     */
    function getEffectivenessForAllPublisherZonesByDayZoneDomain($publisher_id, $oDaySpan, $minimum_impressions = 0)
    {
        $data_summary_zone_domain_page_daily_table = $this->getFullTableName('data_summary_zone_domain_page_daily');
        $zone_table = $this->getFullTableName('zones');

        $this->queryBuilder->reset();
        $this->queryBuilder->setSelect($data_summary_zone_domain_page_daily_table . '.day AS day');
        $this->queryBuilder->addSelect($zone_table . '.zonename AS zone');
        $this->queryBuilder->addSelect($data_summary_zone_domain_page_daily_table . '.domain AS domain');
        $this->queryBuilder->addSelect('SUM(impressions) AS impressions');
        $this->queryBuilder->setTable($data_summary_zone_domain_page_daily_table);
        $this->queryBuilder->addJoin($zone_table, $data_summary_zone_domain_page_daily_table . '.zone_id = ' . $zone_table  . '.zoneid');
        if (!is_null($oDaySpan)) {
            $start = $oDaySpan->getStartDateString();
            $end = $oDaySpan->getEndDateString();
            $this->queryBuilder->setWhere("day >= '$start' and day <= '$end'");
        }
        $this->queryBuilder->addWhere($zone_table . '.affiliateid = ' . $publisher_id);
        $this->queryBuilder->setGroup('day, zone_id, domain, day');
        if ($minimum_impressions > 0) {
            $this->queryBuilder->setHaving('SUM(impressions) >= ' . $minimum_impressions);
        }

        $effectiveness = $this->queryBuilder->getAll();
        return $effectiveness;
    }

    /**
     * @param int $advertisier_id
     * @param DaySpan $oDaySpan
     */
    function getEffictivenessForAllAdvertiserAdsByDay($advertiser_id, $oDaySpan)
    {
        $data_summary_ad_hourly_table = $this->getFullTableName('data_summary_ad_hourly');

        $this->_buildQueryForEverythingByDay($oDaySpan);
        $this->queryBuilder->addSelect("SUM($data_summary_ad_hourly_table.clicks)/SUM($data_summary_ad_hourly_table.impressions) AS day_ctr");
        $this->_restrictEffectivenessQueryToAdvertiser($advertiser_id);

        $effectiveness = $this->queryBuilder->getAll();
        return $effectiveness;
    }

    /**
     * @todo Ensure that access controls are followed
     * @todo Convert raw SQL to QueryBuilder syntax
     */
    function getEffectivenessForCampaignByDay($campaign_id, $oDaySpan)
    {
        assert($campaign_id > 0);

        $data_summary_ad_hourly_table = $this->getFullTableName('data_summary_ad_hourly');
        $ad_table = $this->getFullTableName('banners');

        $this->_buildQueryForEverythingByDay($oDaySpan);
        $this->_restrictEffectivenessQueryToCampaign($campaign_id);

        $effectiveness = $this->queryBuilder->getAll();

        return $effectiveness;
    }

    function getEffectivenessForAllEverythingByDay($oDaySpan)
    {
        $this->_buildQueryForEverythingByDay($oDaySpan);
        $effectiveness = $this->queryBuilder->getAll();
        return $effectiveness;
    }

    function groupByTracker($flat)
    {
        $unkeyed_trackers = $this->splitArrayByKey($flat, 'tracker_name');
        $keyed_trackers = array();
        foreach ($unkeyed_trackers as $tracker) {
            $key = $tracker[0]['tracker_name'];
            $keyed_trackers[$key] = $tracker;
        }
        return $keyed_trackers;
    }

    /**
     * Perform SQL-style GROUP BY after values have been retrieved.
     *
     * @param array $source Array of arrays to split (must be sorted already)
     * @param string key
     *
     * Copied wholesale from Admin DAL.
     * @todo Pull the Admin DAL up to common and use that.
     */
    function splitArrayByKey($source, $grouping_key)
    {
        $all_chunks = array();

        foreach($source as $current_record) {
            $current_key = $current_record[$grouping_key];
            if (!key_exists($current_key, $all_chunks)) {
                $all_chunks[$current_key] = array();
            }
            array_push($all_chunks[$current_key], $current_record);
        }

        return array_values($all_chunks);
    }

    function _buildQueryForAllTrackersByDay(&$query_builder, $oDaySpan)
    {
        $tracker_table = $this->getFullTableName('trackers');
        $data_intermediate_ad_connection_table = $this->getFullTableName('data_intermediate_ad_connection');

        $this->_buildQueryForAllTrackers($query_builder, $oDaySpan);

        $approved_status = MAX_CONNECTION_STATUS_APPROVED;
        $query_builder->addSelect("DATE_FORMAT($data_intermediate_ad_connection_table.tracker_date_time, '%Y-%m-%d') AS day");
        $query_builder->addSelect("COUNT(*) AS total_count");
        $query_builder->addSelect("SUM(IF(connection_status = $approved_status, 1, 0)) AS approved_count");
        $query_builder->addSelect("SUM(IF(connection_status = $approved_status, 1, 0)) / COUNT(*) AS approved_ratio");
        $query_builder->setGroup("$tracker_table.trackername, day, action");
        $query_builder->addOrder("day");
    }

    function _buildQueryForAllTrackers(&$query_builder, $oDaySpan)
    {
        $start = $oDaySpan->getStartDateString() . ' 00:00:00';
        $end = $oDaySpan->getEndDateString() . ' 23:59:59';
        $tracker_table = $this->getFullTableName('trackers');
        $data_intermediate_ad_connection_table = $this->getFullTableName('data_intermediate_ad_connection');

        $query_builder->reset();
        $query_builder->setTable($tracker_table);
        $query_builder->setSelect("$tracker_table.trackerid AS tracker_id");
        $query_builder->addSelect("$tracker_table.trackername AS tracker_name");
        $query_builder->addJoin($data_intermediate_ad_connection_table, "$tracker_table.trackerid = $data_intermediate_ad_connection_table.tracker_id");
        $query_builder->addSelect("$data_intermediate_ad_connection_table.connection_action AS action");
        $query_builder->setWhere("$data_intermediate_ad_connection_table.inside_window = 1");
        if (!is_null($oDaySpan)) {
            $start = $oDaySpan->getStartDateString() . ' 00:00:00';
            $end = $oDaySpan->getEndDateString() . ' 23:59:59';

            $query_builder->setWhere("$data_intermediate_ad_connection_table.tracker_date_time BETWEEN '$start' and '$end'");
        }
        $query_builder->addOrder("$tracker_table.trackername");
    }

    function _buildQueryForEverythingByDay($oDaySpan)
    {
        $data_summary_ad_hourly_table = $this->getFullTableName('data_summary_ad_hourly');

        $this->queryBuilder->setTable($data_summary_ad_hourly_table);
        $this->queryBuilder->setSelect("$data_summary_ad_hourly_table.day AS day");
        $this->queryBuilder->addSelect("SUM($data_summary_ad_hourly_table.impressions) AS impressions");
        $this->queryBuilder->addSelect("SUM($data_summary_ad_hourly_table.clicks) AS clicks");
        $this->queryBuilder->addSelect("SUM($data_summary_ad_hourly_table.clicks)/SUM($data_summary_ad_hourly_table.impressions) AS ctr");

        if (!is_null($oDaySpan)) {
            $start = $oDaySpan->getStartDateString();
            $end = $oDaySpan->getEndDateString();
            $this->queryBuilder->addWhere("$data_summary_ad_hourly_table.day >= '$start' AND $data_summary_ad_hourly_table.day <= '$end'");
        }

        $this->queryBuilder->setGroup("$data_summary_ad_hourly_table.day");
        $this->queryBuilder->addOrder("$data_summary_ad_hourly_table.day");
    }

    /**
     * @access private
     * @param DB_QueryTool_Query $query_builder
     * @param DaySpan $oDaySpan
     */
    function _buildQueryForEverythingByZone(&$query_builder, $oDaySpan)
    {
        $data_summary_ad_hourly_table = $this->getFullTableName('data_summary_ad_hourly');
        $zone_table = $this->getFullTableName('zones');

        $query_builder->reset();
        $this->_selectZoneInformation();
        $query_builder->addSelect("SUM($data_summary_ad_hourly_table.impressions) AS zone_impressions");
        $query_builder->addSelect("SUM($data_summary_ad_hourly_table.clicks) AS zone_clicks");
        $query_builder->addSelect("SUM($data_summary_ad_hourly_table.clicks)/SUM($data_summary_ad_hourly_table.impressions) AS zone_ctr");
        $query_builder->setTable($data_summary_ad_hourly_table);
        $query_builder->setLeftJoin($zone_table, "$data_summary_ad_hourly_table.zone_id = $zone_table.zoneid");
        if (!is_null($oDaySpan)) {
            $start = $oDaySpan->getStartDateString();
            $end = $oDaySpan->getEndDateString();
            $query_builder->setWhere("day >= '$start' AND day <= '$end'");
        }
        $query_builder->setOrder('zone_ctr', true);
        $query_builder->addOrder('zone_impressions', true);
        $query_builder->addOrder('zone_clicks', true);
        $query_builder->setGroup("$data_summary_ad_hourly_table.zone_id");
    }

    function _buildQueryForLinkedDetailByAdvert($oDaySpan)
    {
        $data_summary_ad_hourly_table = $this->getFullTableName('data_summary_ad_hourly');
        $ad_table = $this->getFullTableName('banners');
        $campaign_table = $this->getFullTableName('campaigns');
        $advertiser_table = $this->getFullTableName('clients');
        $zone_table = $this->getFullTableName('zones');
        $publisher_table = $this->getFullTableName('affiliates');

        $this->queryBuilder->reset();
        $this->queryBuilder->setTable($data_summary_ad_hourly_table);
        $this->queryBuilder->addLeftJoin($zone_table, "$data_summary_ad_hourly_table.zone_id = $zone_table.zoneid");
        $this->queryBuilder->addLeftJoin($publisher_table, "$zone_table.affiliateid = $publisher_table.affiliateid");
        $this->queryBuilder->addJoin($ad_table, "$ad_table.bannerid = $data_summary_ad_hourly_table.ad_id");
        $this->queryBuilder->addJoin($campaign_table, "$campaign_table.campaignid = $ad_table.campaignid");
        $this->queryBuilder->addJoin($advertiser_table, "$advertiser_table.clientid = $campaign_table.clientid");
        if (!is_null($oDaySpan)) {
            $start = $oDaySpan->getStartDateString();
            $end = $oDaySpan->getEndDateString();
            $this->queryBuilder->setWhere("$data_summary_ad_hourly_table.day BETWEEN '$start' AND '$end'");
        }
        $this->queryBuilder->setSelect("$advertiser_table.clientname AS advertiser_name");
        $this->queryBuilder->addSelect("$campaign_table.campaignname AS campaign_name");
        $this->queryBuilder->addSelect("$campaign_table.campaignid AS campaign_id");
        $this->queryBuilder->addSelect("$campaign_table.views AS booked_impressions");
        $this->queryBuilder->addSelect("$ad_table.description AS ad_name");
        $this->queryBuilder->addSelect("$publisher_table.name AS publisher_name");
        $this->queryBuilder->addSelect("$zone_table.zonename AS zone_name");
        $this->queryBuilder->addSelect("$ad_table.width AS ad_width");
        $this->queryBuilder->addSelect("$ad_table.height AS ad_height");
        $this->queryBuilder->addSelect("SUM($data_summary_ad_hourly_table.impressions) AS impressions");
        $this->queryBuilder->addSelect("SUM($data_summary_ad_hourly_table.clicks) AS clicks");
        $this->queryBuilder->addSelect("SUM($data_summary_ad_hourly_table.conversions) AS conversions");

        $this->queryBuilder->addSelect("$campaign_table.activate AS campaign_start");
        $this->queryBuilder->addSelect("$campaign_table.expire AS campaign_end");
        $this->queryBuilder->addSelect("IF(COALESCE($ad_table.compiledlimitation, '') IN ('', 'true'), 0, 1) AS banner_is_targeted");

        $this->queryBuilder->setGroup("$ad_table.campaignid, $data_summary_ad_hourly_table.zone_id");
        $this->queryBuilder->setOrder("advertiser_name");
        $this->queryBuilder->addOrder("campaign_name");
        $this->queryBuilder->addOrder("publisher_name");
        $this->queryBuilder->addOrder("zone_name");
    }


    function getCampaignDeliveryPerformanceForScopeByCampaignsActiveWithinPeriod($scope, $oDaySpan)
    {
        $this->_buildQueryForEverythingByCampaign($this->queryBuilder);
        $this->_restrictEffectivenessQueryCampaignsActiveDuringPeriod($oDaySpan);
        $this->_restrictEffectivenessQueryToScope($scope);
        $this->_addSelectionForCampaignDeliveryPerformanceFields();
        $performance = $this->queryBuilder->getAll();
        return $performance;
    }

    function getCampaignDeliveryPerformanceForScopeByCampaign($scope, $oDaySpan)
    {
        $this->_buildQueryForEverythingByCampaign($this->queryBuilder);
        $this->_restrictEffectivenessQueryToDataCollectedDuringPeriod($oDaySpan);
        $this->_restrictEffectivenessQueryToScope($scope);
        $this->_addSelectionForCampaignDeliveryPerformanceFields();
        $performance = $this->queryBuilder->getAll();
        return $performance;
    }

    function _addSelectionForCampaignDeliveryPerformanceFields()
    {
        $data_summary_ad_hourly_table = $this->getFullTableName('data_summary_ad_hourly');
        $campaign_table = $this->getFullTableName('campaigns');

        $this->queryBuilder->addSelect("$campaign_table.priority AS campaign_priority");
        $this->queryBuilder->addSelect("$campaign_table.active AS campaign_is_active");
        $this->queryBuilder->addSelect("$campaign_table.activate AS campaign_start");
        $this->queryBuilder->addSelect("$campaign_table.expire AS campaign_end");
        $this->queryBuilder->addSelect("$campaign_table.views AS campaign_booked_views");
        $this->queryBuilder->addSelect("MAX($data_summary_ad_hourly_table.day) as stats_most_recent_day");
        $this->queryBuilder->addSelect("MAX($data_summary_ad_hourly_table.hour) as stats_most_recent_hour");

    }

    /**
     * @access private
     * @param DB_QueryTool_Query $query_builder
     * @param DaySpan $oDaySpan
     * @todo Ensure that clickthrough ratio is accurate to at least 3 decimal places
     */
    function _buildQueryForEverythingByCampaign(&$query_builder)
    {
        $data_summary_ad_hourly_table = $this->getFullTableName('data_summary_ad_hourly');
        $ad_table = $this->getFullTableName('banners');
        $campaign_table = $this->getFullTableName('campaigns');

        $query_builder->reset();
        $query_builder->setSelect("$campaign_table.campaignid AS campaign_id");
        $query_builder->addSelect("$campaign_table.campaignname AS campaign_name");
        $query_builder->addSelect("SUM($data_summary_ad_hourly_table.impressions) AS campaign_impressions");
        $query_builder->addSelect("SUM($data_summary_ad_hourly_table.clicks) AS campaign_clicks");
        $query_builder->addSelect("SUM($data_summary_ad_hourly_table.clicks)/SUM($data_summary_ad_hourly_table.impressions) AS campaign_ctr");
        $query_builder->setTable($data_summary_ad_hourly_table);
        $query_builder->setLeftJoin($ad_table, "$data_summary_ad_hourly_table.ad_id = $ad_table.bannerid");
        $query_builder->addJoin($campaign_table, "$ad_table.campaignid = $campaign_table.campaignid");
        $query_builder->setOrder('campaign_ctr', true);
        $query_builder->addOrder('campaign_impressions', true);
        $query_builder->addOrder('campaign_clicks', true);
        $query_builder->setGroup("$ad_table.campaignid");
    }

    /**
     * Determines whether a campaign has any targeting specified.
     *
     * The easiest way to check this to see if there are any adverts
     * that have compiled delivery limitations.
     *
     * @param int $campaign_id
     * @return bool True if the campaign has any targeted adverts.
     */
    function isCampaignTargeted($campaign_id)
    {
        assert ($campaign_id > 0);

        $ad_table = $this->getFullTableName('banners');
        $query = "
            SELECT
                COUNT(*) AS targeted_campaigns
            FROM
                $ad_table AS ad
            WHERE
                ad.campaignid = ". $this->oDbh->quote($campaign_id, 'integer') ."
            AND
                ad.compiledlimitation NOT IN ('', 'true')
        ";
        $results = $this->oDbh->getOne($query);
        $targeted_campaigns = $results['targeted_campaigns'];
        if ($targeted_campaigns > 0) {
            return true;
        }
        return false;
    }

    /**
     * @todo Remove excel-specific stuff
     */
    function getEffectivenessForScopeByDay($oDaySpan, $scope)
    {
        $this->_buildQueryForEverythingByDay($oDaySpan);
        $advertiser_id = $scope->getAdvertiserId();
        $publisher_id = $scope->getPublisherId();
        $agency_id = $scope->getAgencyId();

        if ($advertiser_id) {
            $this->_restrictEffectivenessQueryToAdvertiser($advertiser_id);
        }
        if ($publisher_id) {
            $this->_restrictEffectivenessQueryToPublisher($publisher_id);
        }
        if ($agency_id) {
            $this->_restrictEffectivenessQueryToAgency($agency_id);
        }
        $effectiveness = $this->queryBuilder->getAll();
        return $effectiveness;
    }

    /**
     * @param DaySpan $oDaySpan
     * @param ReportScope $scope
     *
     * @todo Reduce code repetition between this and getEffectivenessForScopeByZone
     */
    function getEffectivenessForScopeByCampaign($oDaySpan, $scope)
    {
        $this->_buildQueryForEverythingByCampaign($this->queryBuilder);
        $this->_restrictEffectivenessQueryToDataCollectedDuringPeriod($oDaySpan);
        $this->_restrictEffectivenessQueryToScope($scope);
        $effectiveness = $this->queryBuilder->getAll();
        return $effectiveness;
    }

    /**
     * @param DaySpan $oDaySpan
     * @param ReportScope $scope
     *
     * @todo Reduce code repetition between this and getEffectivenessForScopeByCampaign
     */
    function getEffectivenessForScopeByZone($oDaySpan, $scope)
    {
        $this->_buildQueryForEverythingByZone($this->queryBuilder, $oDaySpan);
        $advertiser_id = $scope->getAdvertiserId();
        $publisher_id = $scope->getPublisherId();
        $agency_id = $scope->getAgencyId();

        if ($advertiser_id) {
            $this->_restrictEffectivenessQueryToAdvertiser($advertiser_id);
        }
        if ($publisher_id) {
            $this->_restrictZoneQueryToPublisher($publisher_id);
        }
        if ($agency_id) {
            $this->_restrictZoneQueryToAgency($agency_id);
        }
        $effectiveness = $this->queryBuilder->getAll();
        return $effectiveness;
    }

    /**
     * @todo Ensure that access controls are followed
     * @todo Order by SUM(impressions) maybe
     */
    function getEffectivenessForCampaignByAdvert($campaign_id, $oDaySpan)
    {
        assert($campaign_id > 0);

        $campaign_table = $this->getFullTableName('campaigns');
        $data_summary_ad_hourly_table = $this->getFullTableName('data_summary_ad_hourly');
        $ad_table = $this->getFullTableName('banners');

        $this->_buildQueryForEverythingByDay($oDaySpan);
        $this->_restrictEffectivenessQueryToCampaign($campaign_id);
        $this->queryBuilder->addSelect("$data_summary_ad_hourly_table.ad_id AS id");
        $this->queryBuilder->addSelect("$ad_table.description AS description");
        $this->queryBuilder->setGroup("$data_summary_ad_hourly_table.ad_id, $ad_table.description");

        $effectiveness = $this->queryBuilder->getAll();
        return $effectiveness;
    }

    function getDetailedEffectivenessForScopeByAdvert($scope, $date_range)
    {
        $ad_table = $this->getFullTableName('banners');

        $this->_buildQueryForLinkedDetailByAdvert($date_range);
        $this->_restrictDetailedEffectivenessQueryToScope($scope);

        $group_clause = $this->queryBuilder->getGroup();
        $group_clause .= ", $ad_table.bannerid";
        $this->queryBuilder->setGroup($group_clause);

        $results = $this->queryBuilder->getAll();
        return $results;
    }

    function getEffectivenessForCampaignByZone($campaign_id, $oDaySpan)
    {
        assert($campaign_id > 0);

        $data_summary_ad_hourly_table = $this->getFullTableName('data_summary_ad_hourly');
        $zone_table = $this->getFullTableName('zones');

        $this->_buildQueryForEverythingByDay($oDaySpan);
        $this->_restrictEffectivenessQueryToCampaign($campaign_id);

        $this->queryBuilder->addJoin($zone_table, "$data_summary_ad_hourly_table.zone_id = $zone_table.zoneid");
        $this->queryBuilder->addSelect("SUM($data_summary_ad_hourly_table.impressions) AS zone_impressions");
        $this->queryBuilder->addSelect("SUM($data_summary_ad_hourly_table.clicks) AS zone_clicks");
        $this->_selectZoneInformation();
        $this->queryBuilder->setGroup("$zone_table.zoneid");

        $results = $this->queryBuilder->getAll();
        return $results;
    }

    function _selectZoneInformation()
    {
        $zone_table = $this->getFullTableName('zones');

        $this->queryBuilder->addSelect("$zone_table.zoneid AS zone_id");
        $this->queryBuilder->addSelect("$zone_table.zonename AS zone_name");
        $this->queryBuilder->addSelect("$zone_table.zonename AS zone_description");
        $this->queryBuilder->addSelect("$zone_table.width AS zone_width");
        $this->queryBuilder->addSelect("$zone_table.height AS zone_height");
    }

    function isTrackerLinkedToAnonymousCampaign($trackerId)
    {
        $tracker_table = $this->getFullTableName('trackers');
        $campaign_table = $this->getFullTableName('campaigns');
        $campaign_tracker_table = $this->getFullTableName('campaigns_trackers');

        $query = "
SELECT
    c.anonymous
FROM
    $tracker_table AS t
    JOIN $campaign_tracker_table AS ct ON (
        t.trackerid = ct.trackerid
    )
    JOIN $campaign_table AS c ON (
        c.campaignid = ct.campaignid
    )
WHERE
    t.trackerid = ". $this->oDbh->quote($trackerId, 'integer');

        $res = phpAds_dbQuery($query)
            or phpAds_sqlDie();

        $anonymous = false;
        while ($row = phpAds_dbFetchArray($res)) {
            if ($row['anonymous'] == 't') {
                $anonymous = true;
                break;
            }
        }

        return $anonymous;
    }

    function getTrackersVariablesByTrackerId($aTrackers)
    {
        $tracker_table = $this->getFullTableName('trackers');
        $tracker_variable_table = $this->getFullTableName('variables');
        $tracker_variable_publisher_table = $this->getFullTableName('variable_publisher');

        $aTrackersVariables = array();

        if (phpAds_isUser(phpAds_Affiliate)) {
            $publisherId = phpAds_getUserId();
        } else {
            $publisherId = 0;
        }

        if (sizeof($aTrackers) > 0) {
            $trackerIds = implode(',',array_keys($aTrackers));
            $where = "
WHERE
    t.trackerid IN (". $this->oDbh->escape($trackerIds) .")";
            $query = "
SELECT
    t.trackerid AS tracker_id,
    t.trackername AS tracker_name,
    v.variableid AS tracker_variable_id,
    v.name AS tracker_variable_name,
    v.description AS tracker_variable_description,
    v.datatype AS tracker_variable_data_type,
    v.purpose AS tracker_variable_purpose,
    v.is_unique AS tracker_variable_is_unique,
    v.hidden AS tracker_variable_hidden,
    vp.visible AS tracker_variable_visible
FROM
    $tracker_table AS t
    LEFT JOIN $tracker_variable_table AS v ON (
        t.trackerid = v.trackerid
    )
    LEFT JOIN $tracker_variable_publisher_table AS vp ON (
        v.variableid = vp.variable_id AND vp.publisher_id = $publisherId
    )
$where
ORDER BY
    tracker_id";

            $res = phpAds_dbQuery($query)
                or phpAds_sqlDie();

            while ($row = phpAds_dbFetchArray($res)) {
                $trackerId = $row['tracker_id'];
                if (!isset($aTrackersVariables[$trackerId])) {
                    $aTrackersVariables[$trackerId]['tracker_id'] = $trackerId;
                    $aTrackersVariables[$trackerId]['tracker_name'] = $row['tracker_name'];
                }

                $trackerVariableId = $row['tracker_variable_id'];
                if (!empty($trackerVariableId)) {
                    $aTrackersVariables[$trackerId]['variables'][$trackerVariableId]['tracker_variable_id'] = $trackerVariableId;
                    $aTrackersVariables[$trackerId]['variables'][$trackerVariableId]['tracker_variable_name'] = $row['tracker_variable_name'];
                    $aTrackersVariables[$trackerId]['variables'][$trackerVariableId]['tracker_variable_description'] = $row['tracker_variable_description'];
                    $aTrackersVariables[$trackerId]['variables'][$trackerVariableId]['tracker_variable_data_type'] = $row['tracker_variable_data_type'];
                    $aTrackersVariables[$trackerId]['variables'][$trackerVariableId]['tracker_variable_purpose'] = $row['tracker_variable_purpose'];
                    $aTrackersVariables[$trackerId]['variables'][$trackerVariableId]['tracker_variable_is_unique'] = $row['tracker_variable_is_unique'];
                    $aTrackersVariables[$trackerId]['variables'][$trackerVariableId]['tracker_variable_hidden'] = $row['tracker_variable_hidden'];
                    if (!is_null($row['tracker_variable_visible'])) {
                        $aTrackersVariables[$trackerId]['variables'][$trackerVariableId]['tracker_variable_hidden'] = $row['tracker_variable_visible'] ? 'f' : 't';
                    }
                }
            }
        }

        return $aTrackersVariables;
    }

    function getTrackerConnections($scope, $oDaySpan)
    {
        $aWhere = array();
        //$aWhere[] = "diac.connection_status != 1";
        if (!empty($oDaySpan)) {
            $startDate = $oDaySpan->getStartDateString() . ' 00:00:00';
            $endDate = $oDaySpan->getEndDateString() . ' 23:59:59';
            $aWhere[] = "diac.tracker_date_time BETWEEN '$startDate' AND '$endDate'";
        }

        $ad_table = $this->getFullTableName('banners');
        $advertiser_table = $this->getFullTableName('clients');
        $campaign_table = $this->getFullTableName('campaigns');
        $data_intermediate_ad_connection_table = $this->getFullTableName('data_intermediate_ad_connection');
        $data_intermediate_ad_variable_value_table = $this->getFullTableName('data_intermediate_ad_variable_value');
        $publisher_table = $this->getFullTableName('affiliates');
        $zone_table = $this->getFullTableName('zones');


        $publisher_id = $scope->getPublisherId();
        $advertiser_id = $scope->getAdvertiserId();
        $agency_id = $scope->getAgencyId();

        $where = '';
        if ($publisher_id) {
            $aWhere[] = "z.affiliateid=$publisher_id";
        }
        if ($advertiser_id) {
            $aWhere[] = "a.clientid=$advertiser_id";
        }
        if ($agency_id) {
            $aWhere[] = "a.agencyid=$agency_id";
        }

        $aWhere[] = "diac.inside_window = 1";

        if (!empty($aWhere)) {
            $where = "
WHERE
    " . implode("\n    AND ", $aWhere);
        } else {
            $where = '';
        }
        $query = "
SELECT
    diac.data_intermediate_ad_connection_id AS data_intermediate_ad_connection_id,
    diac.tracker_date_time AS tracker_date_time,
    DATE_FORMAT(diac.tracker_date_time, '%Y-%m-%d') AS tracker_day,
    diac.tracker_id AS tracker_id,
    diac.connection_date_time AS connection_date_time,
    diac.connection_status AS connection_status,
    diac.connection_channel AS connection_channel,
    diac.connection_action AS connection_action,
    diac.connection_date_time AS connection_date_time,
    diac.connection_ip_address AS connection_ip_address,
    diac.connection_country AS connection_country,
    diac.connection_domain AS connection_domain,
    diac.connection_language AS connection_language,
    diac.connection_os AS connection_os,
    diac.connection_browser AS connection_browser,
    diac.comments AS connection_comments,
    z.zoneid AS zone_id,
    z.zonename AS zone_name,
    p.affiliateid AS publisher_id,
    p.name AS publisher_name,
    a.clientid AS advertiser_id,
    a.clientname AS advertiser_name,
    c.campaignid AS placement_id,
    c.campaignname AS campaign_name,
    b.bannerid AS ad_id,
    b.description AS ad_name,
    b.alt AS ad_alt,
    diavv.tracker_variable_id AS tracker_variable_id,
    diavv.value AS tracker_variable_value
FROM
    $data_intermediate_ad_connection_table AS diac
    JOIN $ad_table AS b ON (
        diac.ad_id=b.bannerid
    )
    JOIN $campaign_table AS c ON (
        b.campaignid=c.campaignid
    )
    JOIN $advertiser_table AS a ON (
        c.clientid=a.clientid
    )
    LEFT JOIN $zone_table AS z ON (
        diac.zone_id=z.zoneid
    )
    LEFT JOIN $publisher_table AS p ON (
        z.affiliateid=p.affiliateid
    )
    LEFT JOIN $data_intermediate_ad_variable_value_table AS diavv ON (
        diac.data_intermediate_ad_connection_id=diavv.data_intermediate_ad_connection_id
    )
$where
ORDER BY
    tracker_id,
    data_intermediate_ad_connection_id
";
        $res = phpAds_dbQuery($query)
            or phpAds_sqlDie();

        $aConnections = array();
        while ($row = phpAds_dbFetchArray($res)) {
            $trackerId = $row['tracker_id'];
            $connectionId = $row['data_intermediate_ad_connection_id'];

            if (!isset($aConnections[$trackerId]['connections'][$connectionId])) {
                $aConnections[$trackerId]['connections'][$connectionId] = array (
                    'data_intermediate_ad_connection_id' => $connectionId,
                    'tracker_date_time' => $row['tracker_date_time'],
                    'tracker_day' => $row['tracker_day'],
                    'connection_date_time' => $row['connection_date_time'],
                    'connection_status' => $row['connection_status'],
                    'connection_channel' => $row['connection_channel'],
                    'connection_action' => $row['connection_action'],
                    'connection_date_time' => $row['connection_date_time'],
                    'connection_ip_address' => $row['connection_ip_address'],
                    'connection_country' => $row['connection_country'],
                    'connection_domain' => $row['connection_domain'],
                    'connection_language' => $row['connection_language'],
                    'connection_os' => $row['connection_os'],
                    'connection_browser' => $row['connection_browser'],
                    'connection_comments' => $row['connection_comments'],
                    'advertiser_id' => $row['advertiser_id'],
                    'advertiser_name' => $row['advertiser_name'],
                    'placement_id' => $row['placement_id'],
                    'placement_name' => $row['placement_name'],
                    'ad_id' => $row['ad_id'],
                    'ad_name' => $row['ad_name'],
                    'ad_alt' => $row['ad_alt'],
                    'publisher_id' => $row['publisher_id'],
                    'publisher_name' => $row['publisher_name'],
                    'zone_id' => $row['zone_id'],
                    'zone_name' => $row['zone_name'],
                    'tracker_id' => $row['tracker_id'],
                );
            }
            $trackerVariableId = $row['tracker_variable_id'];
            if (!empty($trackerVariableId)) {
                $aConnections[$trackerId]['connections'][$connectionId]['variables'][$trackerVariableId] = array (
                    'tracker_variable_id' => $trackerVariableId,
                    'tracker_variable_value' => $row['tracker_variable_value'],
                );
            }
        }

        return $aConnections;
    }

    function _restrictTrackerQueryToAgency($agency_id)
    {
        $tracker_table = $this->getFullTableName('trackers');
        $advertiser_table = $this->getFullTableName('clients');
        $agency_table = $this->getFullTableName('agency');
        $this->queryBuilder->addJoin($advertiser_table, "$tracker_table.clientid = $advertiser_table.clientid");
        $this->queryBuilder->addJoin($agency_table, "$advertiser_table.agencyid = $agency_table.agencyid");
        $this->queryBuilder->addWhere("$agency_table.agencyid = $agency_id");
    }

    function _restrictEffectivenessQueryToAdvertiser($advertiser_id)
    {
        assert($advertiser_id > 0);
        $data_summary_ad_hourly_table = $this->getFullTableName('data_summary_ad_hourly');
        $ad_table = $this->getFullTableName('banners');
        $campaign_table = $this->getFullTableName('campaigns');

        $this->queryBuilder->setLeftJoin($ad_table, "$data_summary_ad_hourly_table.ad_id = $ad_table.bannerid");
        $this->queryBuilder->addJoin($campaign_table, "$ad_table.campaignid = $campaign_table.campaignid");
        $this->queryBuilder->addWhere("$campaign_table.clientid = $advertiser_id");
    }

    function _restrictEffectivenessQueryToScope($scope)
    {
        $advertiser_id = $scope->getAdvertiserId();
        $publisher_id = $scope->getPublisherId();
        $agency_id = $scope->getAgencyId();
        if ($advertiser_id) {
            $campaign_table = $this->getFullTableName('campaigns');
            $this->queryBuilder->addWhere($campaign_table . '.clientid = ' . $advertiser_id);
        }
        if ($publisher_id) {
            $zone_table = $this->getFullTableName('zones');
            $data_summary_ad_hourly_table = $this->getFullTableName('data_summary_ad_hourly');
            $this->queryBuilder->addJoin($zone_table, $data_summary_ad_hourly_table . '.zone_id = ' . $zone_table . '.zoneid');
            $this->queryBuilder->addWhere($zone_table . '.affiliateid = ' . $publisher_id);
        }
        if ($agency_id) {
            $advertiser_table = $this->getFullTableName('clients');
            $campaign_table = $this->getFullTableName('campaigns');
            $this->queryBuilder->addJoin($advertiser_table, "$advertiser_table.clientid = $campaign_table.clientid");
            $this->queryBuilder->addWhere("$advertiser_table.agencyid = $agency_id");
        }
    }

    /**
     * @todo Eliminate duplication with _restrictEffectivenessQueryToScope()
     */
    function _restrictDetailedEffectivenessQueryToScope($scope)
    {
        $advertiser_table = $this->getFullTableName('clients');
        $ad_table = $this->getFullTableName('banners');
        $publisher_table = $this->getFullTableName('affiliates');

        $advertiser_id = $scope->getAdvertiserId();
        $publisher_id = $scope->getPublisherId();
        $agency_id = $scope->getAgencyId();

        if ($advertiser_id) {
            $this->queryBuilder->addWhere("$advertiser_table.clientid = $advertiser_id");
        }
        if ($publisher_id) {
            $this->queryBuilder->addWhere("$publisher_table.affiliateid = $publisher_id");
        }
        if ($agency_id) {
            $this->queryBuilder->addWhere("$advertiser_table.agencyid = $agency_id");
        }

    }


    /**
     * @todo Consider reusability -- could the join be skipped if already present?
     */
    function _restrictEffectivenessQueryToPublisher($publisher_id)
    {
        $data_summary_ad_hourly_table = $this->getFullTableName('data_summary_ad_hourly');
        $zone_table = $this->getFullTableName('zones');
        $this->queryBuilder->addJoin($zone_table, "$zone_table.zoneid = $data_summary_ad_hourly_table.zone_id");
        $this->queryBuilder->addWhere("$zone_table.affiliateid = $publisher_id");
    }

    function _restrictEffectivenessQueryToCampaign($campaign_id)
    {
        $data_summary_ad_hourly_table = $this->getFullTableName('data_summary_ad_hourly');
        $ad_table = $this->getFullTableName('banners');

        $this->queryBuilder->addJoin($ad_table, "$data_summary_ad_hourly_table.ad_id = $ad_table.bannerid");
        $this->queryBuilder->addWhere("$ad_table.campaignid = $campaign_id");
    }

    function _restrictEffectivenessQueryToDataCollectedDuringPeriod($oDaySpan)
    {
        if (!is_null($oDaySpan)) {
            $start = $oDaySpan->getStartDateString();
            $end = $oDaySpan->getEndDateString();
            $this->queryBuilder->setWhere("day BETWEEN '$start' AND '$end'");
        }
    }

    function _restrictEffectivenessQueryCampaignsActiveDuringPeriod($oDaySpan)
    {
        $data_summary_ad_hourly_table = $this->getFullTableName('data_summary_ad_hourly');
        $campaign_table = $this->getFullTableName('campaigns');

        if (!is_null($oDaySpan)) {
            $start = $oDaySpan->getStartDateString();
            $end = $oDaySpan->getEndDateString();
            $this->queryBuilder->setWhere("($campaign_table.activate <= '$end' OR $campaign_table.activate='0000-00-00')");
            $this->queryBuilder->addWhere("($campaign_table.expire >= '$start' OR $campaign_table.expire='0000-00-00')");
        }
    }

    /**
     * @todo Consider renaming this method
     */
    function _restrictZoneQueryToPublisher($publisher_id)
    {
        $zones_table = $this->getFullTableName('zones');
        $this->queryBuilder->addWhere("$zones_table.affiliateid = $publisher_id");
    }

    function _restrictZoneQueryToAgency($agency_id)
    {
        $zone_table = $this->getFullTableName('zones');
        $publisher_table = $this->getFullTableName('affiliates');

        $this->queryBuilder->addJoin($publisher_table, "$zone_table.affiliateid = $publisher_table.affiliateid");
        $this->queryBuilder->addWhere("$publisher_table.agencyid = $agency_id");
    }

    function _restrictEffectivenessQueryToAgency($agency_id)
    {
        $data_summary_ad_hourly_table = $this->getFullTableName('data_summary_ad_hourly');
        $zone_table = $this->getFullTableName('zones');
        $publisher_table = $this->getFullTableName('affiliates');

        $this->queryBuilder->addJoin($zone_table, "$zone_table.zoneid = $data_summary_ad_hourly_table.zone_id");
        $this->queryBuilder->addJoin($publisher_table, "$zone_table.affiliateid = $publisher_table.affiliateid");
        $this->queryBuilder->addWhere("$publisher_table.agencyid = $agency_id");
    }


    function _buildQueryForTrackerVariables($tracker_id)
    {
        $variable_table = $this->getFullTableName('variables');
        $variable_publisher_table = $this->getFullTableName('variable_publisher');

        if (phpAds_isUser(phpAds_Affiliate)) {
            $publisherId = phpAds_getUserId();
        } else {
            $publisherId = 0;
        }

        $this->queryBuilder->reset();
        $this->queryBuilder->setSelect("$variable_table.name AS name");
        $this->queryBuilder->addSelect("$variable_table.variableid AS id");
        $this->queryBuilder->addSelect("$variable_table.purpose AS purpose");
        $this->queryBuilder->addSelect("$variable_table.hidden AS hidden");
        $this->queryBuilder->addSelect("$variable_publisher_table.visible AS visible");
        $this->queryBuilder->setTable($variable_table);
        $this->queryBuilder->setLeftJoin($variable_publisher_table, "$variable_table.variable_id = $variable_publisher_table.variable_id AND $variable_publisher_table.publisher_id = $publihserId");
        $this->queryBuilder->setWhere("$variable_table.trackerid = $tracker_id");
        $this->queryBuilder->addOrder("$variable_table.variableid");
    }

    function getVariablesForTracker($tracker_id)
    {
        $this->_buildQueryForTrackerVariables($tracker_id);
        $results = $this->queryBuilder->getAll();
        $variables = $this->_createVariableArrayFromDatabaseResults($results);
        return $variables;
    }

    function getVariablesForConnection($connection_id, $tracker_id)
    {
        $this->_buildQueryForTrackerVariables($tracker_id);

        $variable_table = $this->getFullTableName('variables');
        $value_table = $this->getFullTableName('data_intermediate_ad_variable_value');

        $this->queryBuilder->addSelect("$value_table.value AS value");
        $this->queryBuilder->addJoin($value_table, "$variable_table.variableid = $value_table.tracker_variable_id");
        $this->queryBuilder->setWhere("$value_table.data_intermediate_ad_connection_id = $connection_id");

        $results = $this->queryBuilder->getAll();
        $variables = $this->_createVariableArrayFromDatabaseResults($results);
        return $variables;
    }

    function _createVariableArrayFromDatabaseResults($db_results)
    {
        $variables = array();
        foreach ($db_results as $flat) {
            $variable = TrackerVariable::createFromArray($flat);
            $variables[] = $variable;
        }
        return $variables;
    }

    function getTrackerSummaryForScopeByTrackerByDay($oDaySpan, $scope)
    {
        $this->_buildQueryForAllTrackersByDay($this->queryBuilder, $oDaySpan);
        $publisher_id = $scope->getPublisherId();
        $advertiser_id = $scope->getAdvertiserId();
        $agency_id = $scope->getAgencyId();
        $anonymous = $scope->getAnonymous();

        if ($publisher_id) {
            $tracker_table = $this->getFullTableName('trackers');
            $campaign_tracker_table = $this->getFullTableName('campaigns_trackers');
            $ad_table = $this->getFullTableName('banners');
            $ad_zone_assoc_table = $this->getFullTableName('ad_zone_assoc');
            $zone_table = $this->getFullTableName('zones');

            $this->queryBuilder->addJoin($campaign_tracker_table, "$campaign_tracker_table.trackerid = $tracker_table.trackerid");
            $this->queryBuilder->addJoin($ad_table, "$ad_table.campaignid = $campaign_tracker_table.campaignid");
            $this->queryBuilder->addJoin($ad_zone_assoc_table, "$ad_zone_assoc_table.ad_id = $ad_table.bannerid");
            $this->queryBuilder->addJoin($zone_table, "$ad_zone_assoc_table.zone_id = $zone_table.zoneid");
            $this->queryBuilder->addWhere("$zone_table.affiliateid = $publisher_id");
        }
        if ($advertiser_id) {
            $tracker_table = $this->getFullTableName('trackers');
            $this->queryBuilder->addWhere("$tracker_table.clientid = $advertiser_id");
        }
        if ($agency_id) {
            $this->_restrictTrackerQueryToAgency($agency_id);
        }
        if ($anonymous) {
            $campaign_table = $this->getFullTableName('campaigns');
            $campaign_tracker_table = $this->getFullTableName('campaigns_trackers');
            $this->queryBuilder->addJoin($campaign_tracker_table, "$campaign_tracker_table.trackerid = $tracker_table.trackerid");
            $this->queryBuilder->addJoin($campaign_table, "$campaign_table.campaignid=$campaign_tracker_table.campaignid");
            $this->queryBuilder->addWhere("$campaign_table.anonymous = 't'");
        }

        $all_trackers_summary = $this->queryBuilder->getAll();
        $trackers = $this->groupByTracker($all_trackers_summary);
        return $trackers;
    }


    /**
     * Find the full SQL table name to use for a given internal name.
     *
     * This method handles prefixes and aliasing, based on settings in conf.php
     *
     * @return string The fully-qualified table name, ready for use in an SQL FROM clause
     * @todo Pull up this method to the common DAL
     */
    function getFullTableName($shorthand)
    {
        $full_name = $this->prefix . $this->conf['table'][$shorthand];
        return $full_name;
    }

    function getPublisherAndAgencyNamesForPublisherId($publisher_id)
    {
        assert($publisher_id > 0);

        $conf = & $GLOBALS['_MAX']['CONF'];

        $query = "
            SELECT
                g.name AS agency_name,
                p.name AS publisher_name,
                'All zones' AS zone_name
            FROM
                {$conf['table']['affiliates']} AS p LEFT JOIN
                {$conf['table']['agency']} AS g USING (agencyid)
            WHERE
              p.affiliateid = ". $this->oDbh->quote($publisher_id, 'integer');

        $res = phpAds_dbQuery($query)
            or phpAds_sqlDie();
        $row = phpAds_dbFetchArray($res);
        return $row;
    }

    function getOwnerNamesForCampaignId($campaign_id)
    {
        $campaign_table = $this->getFullTableName('campaigns');
        $advertiser_table = $this->getFullTableName('clients');

        $query = "
            SELECT
                campaign.campaignname AS campaign_name,
                advertiser.clientname AS advertiser_name
            FROM
                $campaign_table AS campaign
                JOIN $advertiser_table AS advertiser
                    ON advertiser.clientid = campaign.clientid
            WHERE
                campaign.campaignid = ?
        ";
        $result = $this->oDbh->getRow($query, array($campaign_id));
        if (PEAR::isError($result)) {
            MAX::raiseError('An Openads report asked for the name matching a campaign ID number, but the database had no record of that number.');
        }
        return $result;
    }

    function getNameForCampaign($campaign_id)
    {
        $names = $this->getOwnerNamesForCampaignId($campaign_id);
        $campaign_name = $names['campaign_name'];
        return $campaign_name;
    }

    function getAdvertiserNameForCampaign($campaign_id)
    {
        $names = $this->getOwnerNamesForCampaignId($campaign_id);
        $advertiser_name = $names['advertiser_name'];
        return $advertiser_name;
    }

    function getNameForPublisher($publisher_id)
    {
        $names = $this->getPublisherAndAgencyNamesForPublisherId($publisher_id);
        $publisher_name = $names['publisher_name'];
        return $publisher_name;
    }

    function getNameForAdvertiser($advertiser_id)
    {
        $advertiser_table = $this->getFullTableName('clients');
        $query = "SELECT advertiser.clientname AS advertiser_name FROM $advertiser_table AS advertiser WHERE advertiser.clientid = $advertiser_id";
        $result = $this->oDbh->getOne($query);
        if (PEAR::isError($result)) {
            MAX::raiseError('An Openads report asked for the name matching an advertiser ID number, but the had no record of that number.');
        }
        $advertiser_name = $result;
        return $advertiser_name;
    }

    /**
     * Retrieve the publisher and agency names for a zone.
     *
     * @param Integer $publisherId The publisher id
     * @return array Array of publisher related values.
     */
    function getZoneOwnerNames($zoneId)
    {
        $agency_table = $this->getFullTableName('agency');
        $affiliates_table = $this->getFullTableName('affiliates');
        $zones_table = $this->getFullTableName('zones');
        $query = "
            SELECT
                g.name AS agency_name,
                p.name AS publisher_name,
                z.zonename AS zone_name
            FROM
                $agency_table AS g,
                $affiliates_table AS p,
                $zones_table AS z
            WHERE
              p.agencyid = g.agencyid
              AND p.affiliateid = z.affiliateid
              AND z.zoneid=". $this->oDbh->quote($zoneId, 'integer');

        $res = phpAds_dbQuery($query)
            or phpAds_sqlDie();
        $row = phpAds_dbFetchArray($res);
        return $row;
    }

    function getImpressionsPerPageFromTempTable($minimum_impressions)
    {
        $query = "
            SELECT
                domain AS domain,
                page AS page,
                SUM(impressions) AS impressions,
                '-' AS allocated,
                '-' AS available
            FROM
                tmp_zone_inventory_forecast
            GROUP BY
                domain,
                page
            HAVING
                SUM(impressions) >= ". $this->oDbh->quote($minimum_impressions, 'impression') ."
            ORDER BY
                domain,
                page
        ";

        $res = mysql_query($query)
            or phpAds_sqlDie();

        $count = 0;
        while ($row = phpAds_dbFetchArray($res)) {
            $aInventoryData[$count][0] = $row['domain'];
            $aInventoryData[$count][1] = $row['page'];
            $aInventoryData[$count][2] = $row['impressions'];
            $aInventoryData[$count][3] = 0;
            $aInventoryData[$count][4] = "={column2}{row}-{column3}{row}";
            $count++;
        }
        /*
        $aInventoryData[0][0] = 'www.cheapflights.com';
        $aInventoryData[0][1] = 'index.html';
        $aInventoryData[0][2] = 3453212;
        $aInventoryData[0][3] = 324234;
        $aInventoryData[0][4] = "={column2}{row}-{column3}{row}";
        $aInventoryData[1][0] = 'www.cheapflights.com';
        $aInventoryData[1][1] = 'flights/newyork';
        $aInventoryData[1][2] = 43265;
        $aInventoryData[1][3] = 3234;
        $aInventoryData[1][4] = "={column2}{row}-{column3}{row}";
        */
        return $aInventoryData;
    }

    /**
     * Obtains a database-level lock for a report, to ensure it is not
     * generated by more than one user at a time.
     *
     * @param string $name A report lock name to obtain.
     * @return boolean True if lock was obtained, false otherwise.
     */
    function obtainReportLock($name)
    {
        $this->oLock =& OA_DB_AdvisoryLock::factory();
        return $oLock->get($name, 1);
    }

    /**
     * Releases the current database-level report lock.
     *
     * @param string $name A report lock name to release.
     * @return mixed True if lock was released, a PEAR Error otherwise.
     */
    function releaseReportLock($name)
    {
        if (empty($this->oLock)) {
            MAX::debug('Lock wasn\'t acquired by the same DB connection', PEAR_LOG_ERR);
            return false;
        } elseif (!$this->oLock->hasSameId($name)) {
            MAX::debug('Lock names to not match', PEAR_LOG_ERR);
            return false;
        }
        return $this->oLock->release();
    }
}
?>

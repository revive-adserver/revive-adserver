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
$Id$
*/

require_once MAX_PATH . '/lib/max/Dal/Common.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * The non-DB specific Data Access Layer (DAL) class for the User Interface (Admin).
 *
 * @package    MaxDal
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Robert Hunter <roh@m3.net>
 */
class MAX_Dal_Admin extends MAX_Dal_Common
{

    function MAX_Dal_Admin()
    {
        parent :: MAX_Dal_Common();
        $this->initialiseTableNames();
    }

    /**
     * A method for obtaining the information required for the placement overview level
     * targeting statistics screen.
     *
     * @param integer $placementId      The placement ID.
     * @param PEAR::Date $oStartDate    The start date of the range required.
     * @param PEAR::Date $oEndDate      The end date the range required.
     *
     * @return mixed Returns false in the event of incorrect input, or in the case
     *               of being unable to connect to the database, otherwise, returns
     *               an array of arrays:
     * array(
     *     [$oDate] => array(
     *                     ['impressions_requested'] => integer
     *                     ['actual_impressions']    => integer
     *                 )
     *      .
     *      .
     *      .
     * )
     *
     * For the placement and date range specified, returns an array for each day
     * in the date range, consisting of the total number of impressions requested
     * by all ads in the placement (for all zones the ads are linked to), as well
     * as the total number of impressions actually delivered by all ads in the
     * placement (for all zones the ads are linked to).
     *
     * The individual ad/zone impressions requested values may need to be
     * calculated as an "averge" value, in the event that there are multiple,
     * differing values for an ad in a zone for an operation interval -- in
     * much the same way as is done in
     * MAX_Dal_Maintenance::getPreviousAdDeliveryInfo() -- before
     * the total impressions requested value can be calculated.
     *
     * @todo Ensure query is database-agnostic
     */
    function getPlacementOverviewTargetingStatistics($placementId, $oStartDate, $oEndDate)
    {
    	if (!(is_object($oStartDate) && is_object($oEndDate)))
        {
            return false;
        }

        $results = $this->getRawPlacementOverviewInformation($placementId, $oStartDate, $oEndDate);
        $interval = new FragmentAwareOperationInterval();
        $unified_results = $interval->unifyStats($results);

        $day_results = $this->summariseIntervals($unified_results, 'day');
        return $day_results;
    }

    function summariseIntervals($detailed_info, $grouping_key = 'interval_start')
    {
        $results = array();
        $oInterval = new FragmentAwareOperationInterval();

        $intervals = $oInterval->splitArrayByKey($detailed_info, $grouping_key);
        foreach ($intervals as $interval) {
            $impressions_requested = 0;
            $actual_impressions = 0;
            $rows = 0;
            foreach ($interval as $interval_data) {
            	$impressions_requested = $this->addPotentiallyNullValues($impressions_requested, $interval_data['impressions_requested']);
                $actual_impressions += $interval_data['actual_impressions'];
                $rows += $interval_data['rows'];
            }
            $summarised_interval = array(
                'day' => $interval[0]['day'],
                'interval_start' => $interval[0]['interval_start'],
                'interval_end' => $interval[0]['interval_end'],
                'rows' => $rows,
                'impressions_requested' => $impressions_requested,
                'additional_details' => $interval[0]['additional_details'],
                'actual_impressions' => $actual_impressions);
            array_push($results, $summarised_interval);
        }
        return $results;
    }

    function addPotentiallyNullValues($value1, $value2)
    {
        if (is_null($value1) || is_null($value2)) {
    	    return null;
        }
        return $value1 + $value2;
    }

    /**
     * A method for obtaining the information required for the placement daily level
     * targeting statistics screen.
     *
     * @param integer $placementId      The placement ID.
     * @param PEAR::Date $oDate         A date representing the day required.
     *
     * @return mixed Returns false in the event of incorrect input, or in the case
     *               of being unable to connect to the database, otherwise, returns
     *               an array of arrays:
     * array(
     *     [$operationIntervalId] => array(
     *                                   ['interval_start']        => PEAR::Date
     *                                   ['interval_end']          => PEAR::Date
     *                                   ['impressions_requested'] => integer
     *                                   ['actual_impressions']    => integer
     *                               )
     *      .
     *      .
     *      .
     * )
     *
     * For the placement and day specified, returns an array for each operation
     * interval in the day, consisting of the operation interval start and end
     * dates, and the total number of impressions requested by all ads in the
     * placement (for all zones the ads are linked to), as well as the total
     * number of impressions actually delivered by all ads in the placement
     * (for all zones the ads are linked to).
     *
     * The individual ad/zone impressions requested values may need to be
     * calculated as an "averge" value, in the event that there are multiple,
     * differing values for an ad in a zone for an operation interval -- in
     * much the same way as is done in
     * MAX_Dal_Maintenance::getPreviousAdDeliveryInfo() -- before
     * the total impressions requested value can be calculated.
     */
    function getPlacementDailyTargetingStatistics($placementId, $oDate)
    {
        if (!is_object($oDate))
        {
            return false;
        }

        $complete_db_results = $this->getRawPlacementDailyIntervalInformation($placementId, $oDate);
        $all_intervals_stats = $this->unifyAndSummariseDailyIntervalInformation($complete_db_results);
        return $all_intervals_stats;
    }

    /**
     * Prepares raw database results.
     *
     * @todo Consider moving this to a StatisticsController class
     */
    function unifyAndSummariseDailyIntervalInformation($complete_db_results)
    {
        $interval = new FragmentAwareOperationInterval();
        $unified_results = $interval->unifyStats($complete_db_results);
        $summarised_interval_stats = $this->summariseIntervals($unified_results);
        $all_intervals_stats = $this->convertDateStringsInStatisticsToDateObjects($summarised_interval_stats);

        return $all_intervals_stats;
    }

    function convertDateStringsInStatisticsToDateObjects($summarised_interval_stats)
    {
    	$all_intervals_stats = array ();
        foreach($summarised_interval_stats as $row)
        {
            $interval_start = new Date($row['interval_start']);
            $interval_end = new Date($row['interval_end']);
            $single_interval_stats = $row;
            $single_interval_stats['interval_start'] = $interval_start;
            $single_interval_stats['interval_end'] = $interval_end;
            array_push($all_intervals_stats, $single_interval_stats);
        }

        return $all_intervals_stats;
    }

    /**
     * @todo Ensure query is database-agnostic
     */

    function getRawPlacementOverviewInformation($placementId, $oStartDate, $oEndDate)
    {
        $ad_table = $this->ad_table;
        $data_table = $this->intermediate_data_table_name;
        $adzone_table = $this->ad_zone_table_name;

        $start_sql = $oStartDate->format("'%Y-%m-%d %H:%M:%S'");
        $end_sql = $oEndDate->format("'%Y-%m-%d %H:%M:%S'");

        $sql = "
                SELECT
                    date_format(interm.interval_start, '%Y-%m-%d') as `day`,
                    adzone.interval_start as interval_start,
                    adzone.expired as expired,
                    adzone.impressions_requested as impressions_requested,
                    interm.impressions as actual_impressions,
                    adzone.ad_id as ad_id,
                    adzone.zone_id as zone_id,
                    1 as `rows`
                FROM
                    `{$ad_table}` ads,
                    `{$data_table}` interm
                LEFT JOIN
                    `{$adzone_table}` adzone
                    ON
                        interm.ad_id = adzone.ad_id
                    AND interm.zone_id = adzone.zone_id
                    AND interm.interval_start = adzone.interval_start
                WHERE
                    ads.bannerid = interm.ad_id
                    AND ads.campaignid = ". $this->oDbh->quote($placementId, 'integer') ."
                    AND interm.interval_start >= ". $this->oDbh->quote($start_sql, 'timestamp') ."
                    AND interm.interval_end <= ". $this->oDbh->quote($end_sql, 'timestamp');

        $results = $this->oDbh->extended->getAll($sql);
        return $results;
    }

    /**
     * Actually pull a day's data from the database.
     *
     * This is the real core of the DAL. This method does process the data
     * at all; that is left to summarising and unifying methods.
     *
     * Note that the SQL uses date_format() to group by whole days,
     * because day() was not available in early MySQL versions.
     *
     * Note that the ORDER BY clause looks odd because IFNULL()
     * is not available to MySQL GROUP BY sections, and NULL
     * expiry dates must be sorted after non-null ones.
     *
     * @todo Ensure that the hard-coded SQL is database-agnostic.
     */
    function getRawPlacementDailyIntervalInformation($placement_id, $oDate)
    {
        $day_sql = $oDate->format("'%Y-%m-%d %H:%M:%S'");

        $data_table = $this->intermediate_data_table_name;
        $ads_table = $this->ad_table;
        $adzone_table = $this->ad_zone_table_name;

        $sql = "
                SELECT
                    interm.interval_start as interval_start,
                    interm.interval_end as interval_end,
                    adzone.impressions_requested as impressions_requested,
                    sum(interm.impressions) as actual_impressions,
                    adzone.ad_id as ad_id,
                    adzone.zone_id as zone_id,
                    adzone.expired as expired
                FROM
                    `{$ads_table}` ads,
                    `{$data_table}` interm
                LEFT JOIN
                    `{$adzone_table}` adzone
                    ON
                        interm.ad_id = adzone.ad_id
                    AND interm.zone_id = adzone.zone_id
                    AND interm.interval_start = adzone.interval_start
                WHERE
                    ads.bannerid = interm.ad_id
                    AND ads.campaignid = ". $this->oDbh->quote($placement_id, 'integer') ."
                    AND date_format(interm.interval_start, '%Y-%m-%d') = date_format(". $this->oDbh->quote($day_sql, 'date') .", '%Y-%m-%d')
                GROUP BY
                    interm.interval_start,
                    adzone.expired,
                    interm.ad_id,
                    interm.zone_id
                ORDER BY
                    interm.interval_start,
                    adzone.expired IS NULL,
                    adzone.expired
                ";

        $complete_db_results = $this->oDbh->extended->getAll($sql);
        return $complete_db_results;
    }

    /**
     * A method for obtaining the information required for the ad view targeting
     * statistics screen.
     *
     * @param integer $adId             The ad ID.
     * @param PEAR::Date $oStartDate    The start date of the operation interval.
     * @param PEAR::Date $oEndDate      The end date of the operation interval.
     *
     * @return mixed Returns false in the event of incorrect input, or in the case
     *               of being unable to connect to the database, otherwise, returns
     *               an array of arrays:
     * array(
     *     [$zoneId] => array(
     *                      ['impressions_requested'] => integer
     *                      ['priority']              => double
     *                      ['priority_factor']       => double
     *                      ['actual_impressions']    => integer
     *                  )
     *         .
     *         .
     *         .
     * )
     *
     * For the operation interval specified by the start end end dates, the method
     * should return the impressions requested, priority, priority factor and
     * actual impressions delivered for each possible zone the ad was linked to.
     * This requires searching the data_intermediate_ad table for the zones the ad
     * delivered in, to get the number of acutal impressions, and also searching the
     * data_summary_ad_zone_assoc table for the zones the ad was targeted to deliver
     * in.
     *
     * The impressions requested, priority and priority factor may need to be
     * calculated as an "averge" value, in the event that there are multiple, differing
     * values for the ad in a zone, in much the same way as is done in
     * MAX_Dal_Maintenance::getPreviousAdDeliveryInfo().
     */
    function getAdTargetingStatistics($ad_id, & $oStartDate, & $oEndDate)
    {
        $data_table = $this->intermediate_data_table_name;
        $adzone_table_name = $this->ad_zone_table_name;

        $start_sql = $oStartDate->format("'%Y-%m-%d %H:%M:%S'");
        $end_sql = $oEndDate->format("'%Y-%m-%d %H:%M:%S'");

        $sql = "
                SELECT
                    interm.ad_id,
                    interm.zone_id as zone_id,
                    adzone.impressions_requested as impressions_requested,
                    interm.impressions as actual_impressions,
                    adzone.priority as priority,
                    adzone.priority_factor as priority_factor
                FROM
                    {$data_table} interm,
                    {$adzone_table_name} adzone
                WHERE interm.zone_id = adzone.zone_id
                    and interm.ad_id = adzone.ad_id
                    and interm.interval_start = adzone.interval_start
                    and interm.ad_id = ". $this->oDbh->quote($ad_id, 'integer') ."
                    and interm.interval_start >= ". $this->oDbh->quote($start_sql, 'timestamp') ."
                    and interm.interval_end <= ". $this->oDbh->quote($end_sql, 'timestamp');

        $results = $this->oDbh->extended->getAll($sql);

        $stats = array ();
        foreach ($results as $result)
        {
            $zone_id = $result['zone_id'];
            $stats[$zone_id] = $result;
        }
        return $stats;
    }

    /**
     * A method for obtaining the information required for the zone view targeting
     * statistics screen.
     *
     * @param integer $zoneId           The zone ID.
     * @param PEAR::Date $oStartDate    The start date of the operation interval.
     * @param PEAR::Date $oEndDate      The end date of the operation interval.
     *
     * @return mixed Returns false in the event of incorrect input, or in the case
     *               of being unable to connect to the database, otherwise, returns
     *               an array of arrays:
     * array(
     *     [$adId] => array(
     *                    ['impressions_requested'] => integer
     *                    ['priority']              => double
     *                    ['priority_factor']       => double
     *                    ['actual_impressions']    => integer
     *                )
     *        .
     *        .
     *        .
     * )
     *
     * For the operation interval specified by the start end end dates, the method
     * should return the impressions requested, priority, priority factor and
     * actual impressions delivered for each possible ad that was linked to the
     * specified zone. This requires searching the data_intermediate_ad table for
     * the ads which delivered in the zone, to get the number of acutal impressions,
     * and also searching the data_summary_ad_zone_assoc table for the ads which were
     * targeted to deliver in the zone.
     *
     * The impressions requested, priority and priority factor may need to be
     * calculated as an "averge" value, in the event that there are multiple, differing
     * values for the ad in a zone, in much the same way as is done in
     * MAX_Dal_Maintenance::getPreviousAdDeliveryInfo().
     *
     * @todo Detect and handle multiple (overlapping) intervals
     * @todo Read and return priority and priority factor
     */
    function getZoneTargetingStatistics($zone_id, & $oStartDate, & $oEndDate)
    {
        $data_table = $this->intermediate_data_table_name;
        $adzone_table_name = $this->ad_zone_table_name;

        $start_sql = $oStartDate->format("'%Y-%m-%d %H:%M:%S'");
        $end_sql = $oEndDate->format("'%Y-%m-%d %H:%M:%S'");

        $sql = "
                SELECT
                    interm.ad_id,
                    impressions_requested as impressions_requested,
                    impressions as actual_impressions,
                    adzone.priority as priority
                FROM
                    {$data_table} interm,
                    {$adzone_table_name} adzone
                WHERE interm.zone_id = adzone.zone_id
                    and interm.ad_id = adzone.ad_id
                    and interm.interval_start = adzone.interval_start
                    and interm.zone_id = ". $this->oDbh->quote($zone_id, 'integer') ."
                    and interm.interval_start >= ". $this->oDbh->quote($start_sql, 'timestamp') ."
                    and interm.interval_end <= ". $this->oDbh->quote($end_sql, 'timestamp') ."
                GROUP BY ad_id
                ";
        $results = $this->oDbh->extended->getAll($sql);
        $stats = array ();
        foreach ($results as $result)
        {
            $ad_id = $result['ad_id'];
            $stats[$ad_id] = $result;
        }
        return $stats;
    }

    /**
     * Insert a summary record into the database.
     */
    function addOperationIntervalSummary($interval_start, $interval_end, $impressions_requested, $impressions_delivered, $ad_id, $zone_id)
    {
        $start_sql = $interval_start->format("'%Y-%m-%d %H:%M:%S'");
        $end_sql = $interval_end->format("'%Y-%m-%d %H:%M:%S'");

        $this->_addIntermediateDataSummary($start_sql, $end_sql, $impressions_requested, $impressions_delivered, $ad_id, $zone_id);
        $this->_addAdZonePriority($start_sql, $end_sql, $ad_id, $zone_id);
    }

    function _addIntermediateDataSummary($start_sql, $end_sql, $ad_id, $impressions_delivered, $ad_id, $zone_id)
    {
        $data_table_name = $this->intermediate_data_table_name;

        $sql = "
            INSERT INTO {$data_table_name}
                (interval_start, interval_end, ad_id, zone_id, impressions)
            VALUES (
                ". $this->oDbh->quote($start_sql, 'timestamp') .",
                ". $this->oDbh->quote($end_sql, 'timestamp') .",
                ". $this->oDbh->quote($ad_id, 'integer') .",
                ". $this->oDbh->quote($zone_id, 'integer') .",
                ". $this->oDbh->quote(50, 'integer') ."
            )";

        $this->oDbh->exec($sql);
    }

    function _addAdZonePriority($start_sql, $end_sql, $ad_id, $zone_id)
    {
        $adzone_table_name = $this->ad_zone_table_name;

        $sql = "
                INSERT INTO {$adzone_table_name}
                    (interval_start, interval_end, ad_id, zone_id, impressions_requested)
                VALUES (
                    ". $this->oDbh->quote($start_sql, 'timestamp') .",
                    ". $this->oDbh->quote($end_sql, 'timestamp') .",
                    ". $this->oDbh->quote($ad_id, 'integer') .",
                    ". $this->oDbh->quote($zone_id, 'integer') .",
                    ". $this->oDbh->quote(50, 'integer') ."
                )";

        $this->oDbh->exec($sql);

    }

    /**
     * Count each time a particular combination of Ad and Zone IDs appear in the database.
     *
     * @todo Consider removing this method
     */
    function countOperationIntervalsForAdZoneCombo($ad_id, $zone_id)
    {
        $data_table = $this->intermediate_data_table_name;
        $adzone_table = $this->ad_zone_table_name;
        $sql = "
                SELECT COUNT(DISTINCT adzone.interval_start)
                FROM
                    {$data_table} interm,
                    {$adzone_table} adzone
                WHERE
                    interm.interval_start = adzone.interval_start
                    AND interm.ad_id = adzone.ad_id
                    AND interm.zone_id = adzone.zone_id
                    AND interm.ad_id = ". $this->oDbh->quote($ad_id, 'integer') ."
                    AND interm.zone_id = ". $this->oDbh->quote($zone_id, 'integer');

        $results = $this->oDbh->getOne($sql);
        return (int) $results[0];
    }

    function findAdsInPlacement()
    {
        return array(40);
    }

    function findZonesInPlacement($placement_id)
    {
    	$data_table = $this->intermediate_data_table_name;
        $adzone_table = $this->ad_zone_table_name;
        $ad_table = $this->ad_table;

        $sql = "
                SELECT DISTINCT adzone.zone_id as zone_id
                FROM
                    {$ad_table} ad,
                    {$adzone_table} adzone
                WHERE
                    ad.bannerid = adzone.ad_id
                    AND ad.campaignid = ". $this->oDbh->quote($placement_id, 'integer');

    	$results = $this->oDbh->extended->getAll($sql);
    	$zones = array();
    	foreach($results as $row) {
    	    array_push($zones, $row['zone_id']);
    	}
        return $zones;
    }

    function countAdsInDatabase()
    {
        $ad_table = $this->ad_table;
        $sql = "SELECT COUNT(bannerid) FROM `{$ad_table}` ads";
        $results = $this->oDbh->getOne($sql);
        return (int) $results[0];
    }

    /**
     * Keep track of the fully-qualified table names for data access.
     *
     * This method provides convenience members for table names,
     * so that SQL query methods can be clearer.
     */
    function initialiseTableNames()
    {
        $this->table_prefix = $this->conf['table']['prefix'];
        $this->intermediate_data_table_name = $this->table_prefix.$this->conf['table']['data_intermediate_ad'];
        $this->ad_zone_table_name = $this->table_prefix.$this->conf['table']['data_summary_ad_zone_assoc'];
        $this->ad_table = $this->table_prefix.$this->conf['table']['banners'];
    }
}

class FragmentAwareOperationInterval
{
    function unifyStats($fragmented_stats)
    {
        // Guard condition: Don't touch empty statistics.
        if (count($fragmented_stats) < 1) {
            return $fragmented_stats;
        }

        $unified_stats = array();
        $zones = $this->splitArrayByKeyList($fragmented_stats, array('interval_start', 'ad_id', 'zone_id'));
        foreach ($zones as $zone) {
            $unified_zone = $this->_unify_single_interval($zone);
            array_push($unified_stats, $unified_zone);
        }

        return $unified_stats;
    }

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

    /**
     * Split an array into chunks based on unique combinations of keys.
     *
     * @todo Replace semi-recursive implementation with proper recursion.
     */
    function splitArrayByKeyList($source, $grouping_keys)
    {
        $results = array();
        $this->_splitArrayRecursively($source, $grouping_keys, $results);
        return $results;
    }

    //TODO: Replace the array reference currently used as a
    //      result collector with a return value.
    function _splitArrayRecursively($source, $grouping_keys, &$ongoing_results) {
        $key = array_shift($grouping_keys);
        $pieces = $this->splitArrayByKey($source, $key);
        if (count($grouping_keys) > 0) {
            foreach ($pieces as $piece) {
                $this->_splitArrayRecursively($piece, $grouping_keys, $ongoing_results);
            }
        } else {
            $ongoing_results = array_merge($ongoing_results, $pieces);
        }
    }

    function _unify_single_interval($fragmented_stats)
    {
    	// Guard clause: There must be structured data to work on.
        if (!(is_array($fragmented_stats) && (count($fragmented_stats[0]) > 0)))
        {
            return false;
        }

        // Without expiry and interval_start, unification is meaningless
        if (!$this->_isUnificationMeaningfulForIntervalData($fragmented_stats)) {
            return $fragmented_stats[0];
        }

        $impressions = $this->_weightedImpressionsForFragments($fragmented_stats);
        $additional_details = new TargetingStatistics();
        $this->calculateRangeOfImpressionsForFragments($fragmented_stats, $additional_details);

        // Use first fragment's values for everything except impressions
        $collected_results = $fragmented_stats[0];
        $collected_results['impressions_requested'] = $impressions;
        $collected_results['additional_details'] = $additional_details;
        return $collected_results;
    }

    function _weightedImpressionsForFragments($fragmented_stats)
    {
        $interval_length = 60;
        $impressions = 0;
        $nulls_found = 0;

        $fragment_start = $fragmented_stats[0]['interval_start'];
        foreach ($fragmented_stats as $fragment)
        {
        	$interval_start = $fragment['interval_start'];
        	$interval_end = $this->addMinutes($interval_start, $interval_length);
        	$fragment_expiry = $fragment['expired'];
        	$fragment_end = $this->_fragmentEnd($interval_end, $fragment_expiry);

            $scale = $this->_scaleForFragment($interval_start, $interval_end, $fragment_start, $fragment_end, $interval_length);
            $fragment_impressions = $fragment['impressions_requested'];
            if (is_null($fragment_impressions)) {
                $nulls_found++;
            }
            $weighted_impressions = $fragment_impressions * $scale;
            $impressions += $weighted_impressions;

            // The next fragment begins where this one ends
            $fragment_start = $fragment_end;
        }

        if ($nulls_found > 0) {
        	return null;
        }

        return $impressions;
    }

    function calculateRangeOfImpressionsForFragments($fragmented_stats, &$additional_info)
    {
        $interval_length = 60;
        $minimum_impressions = null;
        $maximum_impressions = null;
        $nulls_found = 0;

        $fragment_start = $fragmented_stats[0]['interval_start'];
        foreach ($fragmented_stats as $fragment)
        {
        	$interval_start = $fragment['interval_start'];
        	$interval_end = $this->addMinutes($interval_start, $interval_length);
        	$fragment_expiry = $fragment['expired'];
        	$fragment_end = $this->_fragmentEnd($interval_end, $fragment_expiry);

            $fragment_length = $this->innerLengthForFragment($interval_start, $interval_end, $fragment_start, $fragment_end, $interval_length);
            $scale = $fragment_length / $interval_length;

            $fragment_impressions = $fragment['impressions_requested'];
            if (is_null($fragment_impressions)) {
                $nulls_found++;
            }
            if ($scale > 0) {
                $weighted_impressions = $fragment_impressions / $scale;
            } else {
                $weighted_impressions = null;
            }

            $minimum_impressions = $this->minimumOfPotentiallyNullValues($minimum_impressions, $weighted_impressions);
            $maximum_impressions = $this->maximumOfPotentiallyNullValues($maximum_impressions, $weighted_impressions);

            // The next fragment begins where this one ends
            $fragment_start = $fragment_end;
        }

        if ($nulls_found > 0) {
        	$additional_info->setMinimumRequestRate(null);
        	$additional_info->setMaximumRequestRate(null);
        	return;
        }

        $additional_info->setMinimumRequestRate($minimum_impressions);
    	$additional_info->setMaximumRequestRate($maximum_impressions);

        return;
    }

    function maximumOfPotentiallyNullValues($a, $b)
    {
        if (is_null($a)) {
            return $b;
        }
        if (is_null($b)) {
            return $a;
        }
        return max($a, $b);
    }

    function minimumOfPotentiallyNullValues($a, $b)
    {
        if (is_null($a)) {
            return $b;
        }
        if (is_null($b)) {
            return $a;
        }
        return min($a, $b);
    }

    /**
     * Unifying data only makes sense for certain data.
     *
     * Specifically, all data should have the same interval_start
     * but potentially differ on expiry time.
     *
     * Without this information, unifying won't work.
     */
    function _isUnificationMeaningfulForIntervalData($interval_data)
    {
    	if (!key_exists('interval_start', $interval_data[0])) {
    		return false;
    	}
        if (!key_exists('expired', $interval_data[0])) {
        	return false;
        }
        return true;
    }

    /**
     * Calculate how much of a contribution a fragment makes.
     *
     * @todo Check that logic is actually correct.
     *       Specifically, it seems that cross-hour fragments
     *       do not take the fragment length into account at all.
     */
    function _scaleForFragment($interval_start, $interval_end, $fragment_start, $fragment_end, $interval_length)
    {
        $outer_fragment_length = $this->outerLengthForFragment($interval_start, $interval_end, $fragment_start, $fragment_end, $interval_length);
        $inner_fragment_length = $this->innerLengthForFragment($interval_start, $interval_end, $fragment_start, $fragment_end, $interval_length);
        if ($fragment_end <= $interval_end) {
            $scale = $outer_fragment_length / $interval_length;
        } else {
            $scale = $inner_fragment_length / $outer_fragment_length;
        }

        return $scale;
    }

    function outerLengthForFragment($interval_start, $interval_end, $fragment_start, $fragment_end, $interval_length)
    {
        return $this->minutesBetweenDateStrings($fragment_start, $fragment_end);
    }

    function innerLengthForFragment($interval_start, $interval_end, $fragment_start, $fragment_end, $interval_length)
    {
    	$cutoff = min($fragment_end, $interval_end);
        return $this->minutesBetweenDateStrings($fragment_start, $cutoff);
    }

    function _fragmentEnd($interval_end, $fragment_expiry)
    {
        if (empty($fragment_expiry)) {
            $fragment_end = $interval_end;
        } else {
            $fragment_end = $fragment_expiry;
        }
        return $fragment_end;
    }

    function addMinutes($datestring, $minutes)
    {
        $datetime = new Date($datestring);
        $datetime->addSeconds($minutes * 60);
        return $datetime->format('%Y-%m-%d %H:%M:%S');
    }

    /**
     * Calculates the length of time between to datetimes.
     *
     * @param string start_datestring The start of the period to be considered
     *                                Should be an ISO 8601 format datetime,
     *                                like '2001-12-31 23:59:59'.
     *
     * @param string end_datestring The end of the period to be considered
     *                                Should be an ISO 8601 format datetime,
     *                                like '2001-12-31 23:59:59'.
     *
     * @return int The number of minutes between the two dates
     */
    function minutesBetweenDateStrings($start_datestring, $end_datestring)
    {
        //XXX: This is a pretty naive implementation
        //TODO: Move to a Date or Date_Span class
        $start_date = new Date($start_datestring);
        $end_date = new Date($end_datestring);
        $days_diff = $end_date->getJulianDate() - $start_date->getJulianDate();
        $hours_diff = $end_date->getHour() - $start_date->getHour();
        $minutes_diff = $end_date->getMinute() - $start_date->getMinute();
        return ($days_diff * 1440) + ($hours_diff * 60)+$minutes_diff;
    }

    function isLargeChangeInNumbers($set)
    {
    	$max = max($set);
    	$range = $this->calculateRange($set);

    	$percentage_change = $range / $max;

    	if ($percentage_change > 0.10) {
    		return true;
    	}
        return false;
    }

    function calculateRange($set)
    {
    	$min = min($set);
    	$max = max($set);

        return $max - $min;
    }
}
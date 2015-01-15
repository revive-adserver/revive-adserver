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

require_once MAX_PATH . '/lib/max/SqlBuilder.php';
require_once MAX_PATH . '/lib/max/other/common.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';

/**
 * @package    MaxDal
 */

$GLOBALS['_MAX']['Admin_DA']['cacheGroups'] = array(
    'getAdvertisersStats'    => 'stats',
    'getConversions'         => 'stats',
    'getConnectionVariables' => 'stats',
    'getPlacementsStats'     => 'stats',
    'getPublishersStats'     => 'stats',
    'getZonesStats'          => 'stats',
    'getAdsStats'            => 'stats',
    'getEntitiesStats'       => 'stats',
    'getHistorySpan'         => 'stats',
    'getDayHistory'          => 'stats',
    'getMonthHistory'        => 'stats',
    'getDayOfWeekHistory'    => 'stats',
    'getHourHistory'         => 'stats',
);

/**
 * Tables which have to update they "updated" timestamp
 */
$GLOBALS['_MAX']['Admin_DA']['updateEntities'] = array(
    'banners',
    'clients',
    'agency',
    'campaigns',
    'affiliates',
    'trackers',
    'variables',
    'zones',
);

class Admin_DA
{
    // +---------------------------------------+
    // | entity builder methods                |
    // |                                       |
    // | private methods for entity            |
    // | manipulation                          |
    // +---------------------------------------+

    /**
     * Retrieves the data from the database table $table using a set of
     * conditions provided in $aConditions. The method uses
     * DataObject::getAll() method to perform its task.
     *
     * @param string $table
     * @param array $aConditions Map column => value.
     * @return array
     */
    function getADataRows($table, $aConditions)
    {
        $do = OA_Dal::factoryDO($table);
        if ($do === false) {
            return false;
        }
        foreach($aConditions as $column => $value) {
            if (!$do->fromValue($column, $value)) {
                return false;
            }
        }
        $success = $do->find();
        if (!is_int($success) && !$success) {
            return false;
        }
        return $do->getAll(array(), true, false);
    }


    /**
     * Retrieves the data from the database about a particular row selected
     * with $aConditions.
     *
     * @param string $table
     * @param array $aConditions
     * @return array An array object with column => value entries for
     * the matching selected data row.
     */
    function getDataRow($table, $aConditions)
    {
        $aDataRows = Admin_DA::getADataRows($table, $aConditions);
        if ($aDataRows === false || empty($aDataRows)) {
            return false;
        }
        foreach($aDataRows as $dataRow) {
            return $dataRow;
        }
    }


    /**
     * Retrieves a single row data from the $table table using $column column
     * with a $id value.
     *
     * @param string $table
     * @param string $column
     * @param string $id
     * @return array
     */
    function _getDataRowFromId($table, $column, $id)
    {
        $aDataRows = Admin_DA::_getEntities($table, array($column => $id), true);
        return $aDataRows[$id];
    }

    /**
     * Creates a new data row in the database.
     *
     * @param string $table Name of the table.
     * @param array  $aVariables Map of column name to value.
     * @return integer The inserted entity's ID.
     */
    function _addEntity($table, $aVariables)
    {
        Admin_DA::_updateEntityTimestamp($table, $aVariables);
        return SqlBuilder::_insert($table, $aVariables);
    }

    /**
     * Update "updated" status of entity (if necessesary)
     *
     * @param string $entity
     * @param array  $aVariables
     */
    function _updateEntityTimestamp($entity, &$aVariables)
    {
        if(in_array($entity, $GLOBALS['_MAX']['Admin_DA']['updateEntities'])) {
            $aVariables['updated'] = OA::getNow();
        }
    }

    /**
     * Retrieves an entity.
     *
     * @param string  $entity The name of the entity to get (e.g. "agency").
     * @param integer $id The ID of the entity.
     * @return array  An array representing the attributes of an entity
     */
    function _getEntity($entity, $id)
    {
        $entityIdName = "{$entity}_id";
        $aParams = array($entityIdName => $id);
        $aRows = Admin_DA::_getEntities($entity, $aParams, true, $entityIdName);

        if (!empty($aRows[$id])) {
            $aRow = $aRows[$id];
        } elseif (!($aRows === false)) {
            $aRow = false;
        } else {
            $aRow = array();
        }
        return $aRow;
    }


    /**
     * Returns an array of entity arrays, where the keys are the entity IDs.
     *
     * @param string  $entity The name of the entities to get (e.g. "agency").
     * @param array   $aParams Map column => value.
     * @param boolean $allFields Return *all* fields the entity has, or just the default fields?
     * @param string  $key The primary key field name.
     * @return array  An array of entity records.
     */
    function _getEntities($entity, $aParams, $allFields = false, $key = null)
    {
        if (empty($key)) {
            $key = "{$entity}_id";
        }
        $aColumns = SqlBuilder::_getColumns($entity, $aParams, $allFields);
        $aTables = SqlBuilder::_getTables($entity, $aParams);
        $aLimitations = array_merge(
            SqlBuilder::_getLimitations($entity, $aParams),
            SqlBuilder::_getTableLimitations($aTables, $aParams)
        );
        $aGroupColumns = SqlBuilder::_getGroupColumns($entity, $aParams);
        $aLeftJoinedTables = SqlBuilder::_getLeftJoinedTables($entity, $aParams);
        return SqlBuilder::_select($aColumns, $aTables, $aLimitations, $aGroupColumns, $key, $aLeftJoinedTables);
    }

    /**
     * Returns an array of the entity's children.
     *
     * @param string  $entity The name of the entity, for which the children are desired (e.g. "agency").
     * @param array   $aParams
     * @param boolean $allFields Return *all* fields the entity has, or just the default fields?
     * @param string  $key The primary key field name.
     * @return array  An array of entity records.
     */
    function _getEntitiesChildren($entity, $aParams, $allFields=false, $key=null)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        if (empty($key)) {
            $key = "{$entity}_id";
        }
        $aColumns = SqlBuilder::_getColumns($entity, $aParams, $allFields);
        $aTables = SqlBuilder::_getTables($entity, $aParams);
        $aLeftJoinedTables = array();
        switch ($entity) {

        case 'agency' : $aLeftJoinedTables[$conf['table']['prefix'].$conf['table']['clients']] = 'a';
            $aGroupBy = array_keys($aColumns);
            $aColumns['COUNT(a.clientid)'] = 'num_children';
            break;

        case 'advertiser' : $aLeftJoinedTables[$conf['table']['prefix'].$conf['table']['campaigns']] = 'm';
            $aGroupBy = array_keys($aColumns);
            $aColumns['COUNT(m.campaignid)'] = 'num_children';
            break;

        case 'placement' : $aLeftJoinedTables[$conf['table']['prefix'].$conf['table']['banners']] = 'd';
            $aGroupBy = array_keys($aColumns);
            $aGroupBy['m.status'] = 'm.status'; // Hack to allow this to work with Postgres
            $aColumns['COUNT(d.bannerid)'] = 'num_children';
            break;

        case 'publisher' : $aLeftJoinedTables[$conf['table']['prefix'].$conf['table']['zones']] = 'z';
            $aGroupBy = array_keys($aColumns);
            $aColumns['COUNT(z.zoneid)'] = 'num_children';
            break;

        default :
            $aGroupBy = null;
        }
        $aLimitations = array_merge(
            SqlBuilder::_getLimitations($entity, $aParams),
            SqlBuilder::_getTableLimitations($aTables + $aLeftJoinedTables, $aParams));
        return SqlBuilder::_select($aColumns, $aTables, $aLimitations, $aGroupBy, $key, $aLeftJoinedTables);
    }

    /**
     * Get stats by entity.
     *
     * @param string $entity
     * @param array $aParams
     * @param boolean $allFields
     * @param string $key   The primary key field name
     * @return array    An array of entity records
     */
    function _getEntitiesStats($entity, $aParams, $allFields=false, $key=null)
    {
        if (empty($key)) {
            $key = "{$entity}_id";
        }
        $aColumns = SqlBuilder::_getStatsColumns($entity);
        $aTables = SqlBuilder::_getTables($entity, $aParams, true);
        $aLimitations = array_merge(SqlBuilder::_getStatsLimitations($entity, $aParams),
            SqlBuilder::_getTableLimitations($aTables, $aParams));

        $aGroupBy = array($key);

        return SqlBuilder::_select($aColumns, $aTables, $aLimitations, $aGroupBy, $key);
    }

    // +---------------------------------------+
    // | Helper methods                        |
    // |                                       |
    // +---------------------------------------+

    /**
     * Returns a unique name for an entity.
     *
     * @param array $aEntity
     * @param array $aOtherEntities
     * @param string $str               The string 'copy' localised
     */
    function _getUniqueName(&$aEntity, $aOtherEntities, $str)
    {
        $same = false;
        if (!isset($str)) {
            $str = 'copy';
        }
        $name = $aEntity['name'];
        foreach ($aOtherEntities as $aOtherEntity) {
            if ($name == $aOtherEntity['name']) {
                $same = true;
                // Three cases:
                // a. 'joe' => 'joe (copy)'
                // b. 'joe (copy)' => 'joe (copy 2)'
                // c. 'joe (copy n)' => 'joe (copy n+1)'
                if (preg_match("/(.*)\($str (\d+)\)/", $name, $matches)) {
                    $n = $matches[2] + 1;
                    $name = "{$matches[1]}($str $n)";
                } elseif (preg_match("/(.*)\($str\)/", $name, $matches)) {
                    $name = "{$matches[1]}($str 2)";
                } else {
                    $name = "$name ($str)";
                }
                $aEntity['name'] = $name;
                break;
            }
        }
        if ($same) {
            Admin_DA::_getUniqueName($aEntity, $aOtherEntities, $str);
        }
    }

    /**
     * Swaps the field name with legacy table name.
     *
     * @param array $aParams    A hash of values to be switched
     * @param string $name
     * @param string $legacyName
     */
    function _switch(&$aParams, $name, $legacyName)
    {
        if (isset($aParams[$name])) {
            $aParams[$legacyName] = $aParams[$name];
            unset($aParams[$name]);
        }
    }

    function fromCache()
    {
        //  parse variable args
            //  method, id, timeout
            //  method, aParams, allFields, key, timeout
        $numArgs = func_num_args();
        if ($numArgs < 2 || $numArgs > 5) {
            return PEAR::raiseError('incorrect args passed');
        }
        $aArgs = func_get_args();

        //  initialise cache object
        $conf = $GLOBALS['_MAX']['CONF'];
        require_once 'Cache/Lite/Function.php';

        //  manually determine timeout required to instantiate cache object
        switch ($numArgs) {

        case 3:
            $timeout = $aArgs[2];
            break;
        case 5:
            $timeout = $aArgs[4];
            break;
        default:
            $timeout = null;
        }

        $method = $aArgs[0];

        $options = array(
                'cacheDir' => MAX_CACHE,
                'lifeTime' => ((isset($timeout)) ? $timeout : $conf['delivery']['cacheExpire']));

        // check if this method has defined different cache group
        $cacheGroups = $GLOBALS['_MAX']['Admin_DA']['cacheGroups'];
        // Note: if you change this key, also change the key when clearing the cache in connections-modify.php
        $options['defaultGroup'] = OX_getHostName();
        if(isset($cacheGroups[$method])) {
            $options['defaultGroup'] .= $cacheGroups[$method];
        }
        $cache = new Cache_Lite_Function($options);

        switch ($numArgs) {

        case 2:
        case 3:
            $id = $aArgs[1];
            $timeout = @$aArgs[2]; // timeout may not be supplied

            // catch stats case
            if (is_array($aArgs[1])) {
                $aParams = $aArgs[1];
                $allFields = isset($aArgs[2]) ? $aArgs[2] : false;
                $ret = $cache->call("Admin_DA::".$method, $aParams, $allFields);
            } else {
                $ret = $cache->call("Admin_DA::".$method, $id);
            }
            break;

            case 4:
            case 5:
            $aParams = $aArgs[1];
            $allFields = $aArgs[2];
            $key = @$aArgs[3];
            $timeout = @$aArgs[4];

            $ret = $cache->call("Admin_DA::".$method, $aParams, $allFields, $key);
            break;

        default:
            return PEAR::raiseError('incorrect args passed');
        }
        return $ret;
    }

    /**
     * Reads the zone data and returns an information about the zone.
     * You have to look into the method to see what it actually
     * returns and when.
     *
     * @param integer $zoneId
     * @return array
     */
    function getLinkedAdParams($zoneId)
    {
        $aParams = array();
        $aZone = Admin_DA::getZone($zoneId);
        if ($aZone['type'] == phpAds_ZoneText) {
            $aParams['ad_type'] = 'txt';
        } else {
            if ($aZone['width'] != -1) {
                $aParams['ad_width'] = $aZone['width'];
            }
            if ($aZone['height'] != -1) {
                $aParams['ad_height'] = $aZone['height'];
            }
        }
        // Allow linking *x* banners
        $aParams['ad_nosize'] = true;
        return $aParams;
    }

    // +---------------------------------------+
    // | stats methods                         |
    // |                                       |
    // | All methods related to gathering      |
    // | statistics                            |
    // +---------------------------------------+

    /**
     * Returns an array of stats for ageneric entity.
     *
     * @param array $aParams
     * @param boolean $allFields
     * @param integer $timeout
     * @return array
     */
    function getEntitiesStats($aParams, $allFields=false)
    {
        $aEntities = Admin_DA::_getEntities('stats_by_entity', $aParams, false, 'pkey');

        return $aEntities;
    }

    /**
     * Returns an array of stats for an advertiser.
     *
     * @param array $aParams
     * @param boolean $allFields
     * @param integer $timeout
     * @return array
     */
    function getAdvertisersStats($aParams, $allFields=false)
    {
        $aAdvertisers = Admin_DA::_getEntitiesChildren('advertiser', $aParams);
        $aAdvertisersStats = Admin_DA::_getEntitiesStats('advertiser', $aParams);
        $aActiveParams = array('placement_active' => 't', 'ad_active' => 't');
        $aActiveAdvertisers = Admin_DA::_getEntities('advertiser', $aParams + $aActiveParams);
        foreach ($aAdvertisers as $advertiserId => $aAdvertiser) {
            foreach (array('sum_requests', 'sum_views', 'sum_clicks', 'sum_conversions') as $item) {
                $aAdvertisers[$advertiserId][$item] = !empty($aAdvertisersStats[$advertiserId][$item]) ? $aAdvertisersStats[$advertiserId][$item] : 0;
            }
            $aAdvertisers[$advertiserId]['active'] = isset($aActiveAdvertisers[$advertiserId]);
        }
        return $aAdvertisers;
    }

    /**
     * Returns an array of conversions.
     *
     * @param array $aParams
     * @return array
     */
    function getConversions($aParams)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();

        $where = '';
        if (!empty($aParams['day'])) {
            $aParams['day_begin'] = $aParams['day_end'] = $aParams['day'];
        }
        if (!empty($aParams['day_begin'])) {
            $oStart = new Date($aParams['day_begin']);
            $oStart->setHour(0);
            $oStart->setMinute(0);
            $oStart->setSecond(0);
            $oStart->toUTC();
            $where .= ' AND ac.tracker_date_time >= '. $oDbh->quote($oStart->format('%Y-%m-%d %H:%M:%S'), 'timestamp');
        }
        if (!empty($aParams['day_end'])) {
            $oEnd = new Date($aParams['day_end']);
            $oEnd->setHour(23);
            $oEnd->setMinute(59);
            $oEnd->setSecond(59);
            $oEnd->toUTC();
            $where .= ' AND ac.tracker_date_time <= '. $oDbh->quote($oEnd->format('%Y-%m-%d %H:%M:%S'), 'timestamp');
        }
        if (!empty($aParams['month'])) {
            $oStart = new Date("{$aParams['month']}-01");
            $oStart->setHour(0);
            $oStart->setMinute(0);
            $oStart->setSecond(0);
            $oEnd = new Date(Date_Calc::beginOfNextMonth($oStart->getDay(), $oStart->getMonth, $oStart->getYear(), '%Y-%m-%d'));
            $oEnd->setHour(0);
            $oEnd->setMinute(0);
            $oEnd->setSecond(0);
            $oEnd->subtractSeconds(1);
            $oStart->toUTC();
            $oEnd->toUTC();
            $where .= ' AND ac.tracker_date_time >= '. $oDbh->quote($oStart->format('%Y-%m-%d %H:%M:%S'), 'timestamp');
            $where .= ' AND ac.tracker_date_time <= '. $oDbh->quote($oEnd->format('%Y-%m-%d %H:%M:%S'), 'timestamp');
        }
        if (!empty($aParams['day_hour'])) {
            $oStart = new Date("{$aParams['day_hour']}:00:00");
            $oStart->setMinute(0);
            $oStart->setSecond(0);
            $oEnd = new Date($oStart);
            $oStart->setMinute(59);
            $oStart->setSecond(59);
            $where .= ' AND ac.tracker_date_time >= '. $oDbh->quote($oStart->format('%Y-%m-%d %H:%M:%S'), 'timestamp');
            $where .= ' AND ac.tracker_date_time <= '. $oDbh->quote($oEnd->format('%Y-%m-%d %H:%M:%S'), 'timestamp');
        }
        if (!empty($aParams['agency_id'])) {
            $where .= ' AND c.agencyid='. $oDbh->quote($aParams['agency_id'], 'integer');
        }
        if (!empty($aParams['clientid'])) {
            $where .= ' AND c.clientid='. $oDbh->quote($aParams['clientid'], 'integer');
        }
        if (isset($aParams['zonesIds'])) {
            $where .= ' AND ac.zone_id IN ('. $oDbh->escape(implode(',', $aParams['zonesIds'])) .")";
        }
        if (!empty($aParams['campaignid'])) {
            $where .= ' AND m.campaignid='. $oDbh->quote($aParams['campaignid'], 'integer');
        }
        if (!empty($aParams['bannerid'])) {
            $where .= ' AND d.bannerid='. $oDbh->quote($aParams['bannerid'], 'integer');
        }
        if (!empty($aParams['statuses'])) {
            $where .= ' AND ac.connection_status IN ('. $oDbh->escape(implode(',', $aParams['statuses'])).')';
        }

        if (isset($aParams['startRecord']) && is_numeric($aParams['startRecord']) && is_numeric($aParams['perPage'])) {
            $limit = ' LIMIT ' .  $oDbh->quote($aParams['perPage'], 'text', false) . ' OFFSET ' . $oDbh->quote($aParams['startRecord'], 'text', false);
        } elseif (!empty($aParams['perPage'])) {
            $limit = ' LIMIT ' .  $oDbh->quote($aParams['perPage'], 'integer', false) . ' OFFSET 0';
        } else {
            $limit = '';
        }

        $query =
        "SELECT
            ac.data_intermediate_ad_connection_id as connection_id,
            c.clientid,
            m.campaignid,
            m.campaignname AS campaignname,
            ac.tracker_id as tracker_id,
            ac.connection_status,
            ac.connection_date_time AS connection_date_time,
            ac.tracker_date_time as date_time,
            t.trackername,
            ac.tracker_ip_address,
            ac.tracker_country,
            ac.connection_action,
            t.type AS connection_type,
            ac.tracker_country,
            ac.ad_id,
            ac.creative_id,
            ac.zone_id,
            ac.comments
        FROM
            {$conf['table']['prefix']}{$conf['table']['clients']} AS c,
            {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']} AS ac,
            {$conf['table']['prefix']}{$conf['table']['banners']} AS d,
            {$conf['table']['prefix']}{$conf['table']['campaigns']} AS m,
            {$conf['table']['prefix']}{$conf['table']['trackers']} AS t
        WHERE
            c.clientid=m.clientid
            AND m.campaignid=d.campaignid
            AND d.bannerid=ac.ad_id
            AND t.trackerid=ac.tracker_id
            AND ac.inside_window = 1
            ". $where ."
        ORDER BY
            ac.tracker_date_time
        $limit";

        $aStats = $oDbh->queryAll($query, null, MDB2_FETCHMODE_DEFAULT, true);

        $oNow = new Date();
        foreach (array_keys($aStats) as $k) {
            $oDate = new Date($aStats[$k]['date_time']);
            $oDate->setTZbyID('UTC');
            $oDate->convertTZ($oNow->tz);
            $aStats[$k]['date_time'] = $oDate->format('%Y-%m-%d %H:%M:%S');

            $oDate = new Date($aStats[$k]['connection_date_time']);
            $oDate->setTZbyID('UTC');
            $oDate->convertTZ($oNow->tz);
            $aStats[$k]['connection_date_time'] = $oDate->format('%Y-%m-%d %H:%M:%S');
        }

        return $aStats;
    }

    /**
     * Returns zones ids linked with affiliate.
     *
     * @param int $affiliateId  Affiliate ID
     * @return array
     */
    function getZonesIdsByAffiliateId($affiliateId)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $query =
            "SELECT
                zoneid
            FROM
                ".$conf['table']['prefix'].$conf['table']['zones']."
            WHERE
                affiliateid = '".$affiliateId."'";
        $rsZoneIds = DBC::NewRecordSet($query);
        if (PEAR::isError($rsZoneIds)) {
            return false;
        }
        return $rsZoneIds->getAll();
    }

    /**
     * Returns an array of variables connected to specific connection.
     *
     * @param array $aParams
     * @return array
     */
    function getConnectionVariables($connectionId)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $where = '';
        if (empty($connectionId)) {
            return false;
        } else {
            $connectionId = (int)$connectionId;
        }

        if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $publisherId = OA_Permission::getEntityId();
        } else {
            $publisherId = 0;
        }

        $query =
        "SELECT
            v.variableid,
            v.name,
            v.description,
            vv.value,
            v.purpose,
            v.hidden,
            vp.visible
        FROM
            {$conf['table']['prefix']}{$conf['table']['variables']} AS v JOIN
            {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']} AS vv ON (vv.tracker_variable_id = v.variableid) LEFT JOIN
            {$conf['table']['prefix']}{$conf['table']['variable_publisher']} AS vp ON (vp.variable_id =  v.variableid AND vp.publisher_id = {$publisherId})
        WHERE
            vv.data_intermediate_ad_connection_id='". DBC::makeLiteral($connectionId) ."'
        ORDER BY
            v.name";
        $rsVariables = DBC::NewRecordSet($query);
        if (!$rsVariables->find()) {
            return false;
        }
        $aDataVariables = array();
        while($rsVariables->fetch()) {
            $dataVariable = $rsVariables->toArray();
            if (!is_null($dataVariable['visible'])) {
                $dataVariable['hidden'] = $dataVariable['visible'] ? 'f' : 't';
            }
            unset($dataVariable['visible']);
            $aDataVariables[$dataVariable['variableid']] = $dataVariable;
        }
        return $aDataVariables;
    }

    function getPlacementsStats($aParams, $allFields=false)
    {
        $aPlacements = Admin_DA::_getEntitiesChildren('placement', $aParams);
        $aPlacementsStats = Admin_DA::_getEntitiesStats('placement', $aParams);
        foreach ($aPlacements as $placementId => $aPlacement) {
            foreach (array('sum_requests', 'sum_views', 'sum_clicks', 'sum_conversions') as $item) {
                $aPlacements[$placementId][$item] = (!empty($aPlacementsStats[$placementId][$item]))
                    ? $aPlacementsStats[$placementId][$item]
                    : 0;
            }
        }
        return $aPlacements;
    }

    function getPublishersStats($aParams, $allFields=false)
    {
        $aPublishers = Admin_DA::_getEntitiesChildren('publisher', $aParams);
        $aPublishersStats = Admin_DA::_getEntitiesStats('publisher', $aParams);
        foreach ($aPublishers as $publisherId => $aPublisher) {
            foreach (array('sum_requests', 'sum_views', 'sum_clicks', 'sum_conversions') as $item) {
                $aPublishers[$publisherId][$item] = !empty($aPublishersStats[$publisherId][$item]) ? $aPublishersStats[$publisherId][$item] : 0;
            }
        }
        return $aPublishers;
    }

    function getZonesStats($aParams, $allFields=false)
    {
        $aZones = Admin_DA::_getEntitiesChildren('zone', $aParams);
        $aZonesStats = Admin_DA::_getEntitiesStats('zone', $aParams);
        foreach ($aZones as $zoneId => $aZone) {
            foreach (array('sum_requests', 'sum_views', 'sum_clicks', 'sum_conversions') as $item) {
                $aZones[$zoneId][$item] = !empty($aZonesStats[$zoneId][$item]) ? $aZonesStats[$zoneId][$item] : 0;
            }
        }
        return $aZones;
    }

    function getAdsStats($aParams, $allFields=false)
    {
        $aAds = Admin_DA::_getEntities('ad', $aParams);
        $aAdsStats = Admin_DA::_getEntitiesStats('ad', $aParams);
        foreach ($aAds as $adId => $aAd) {
            foreach (array('sum_requests', 'sum_views', 'sum_clicks', 'sum_conversions') as $item) {
                $aAds[$adId][$item] = !empty($aAdsStats[$adId][$item]) ? $aAdsStats[$adId][$item] : 0;
            }
        }
        return $aAds;
    }

    function getHistorySpan($aParams)
    {
        $span = Admin_DA::_getEntities('history_span', $aParams, false, 'start_date');

        return current($span);
    }

    function getDayHourHistory($aParams)
    {
        return Admin_DA::_getEntities('history_day_hour', $aParams, false, 'date_time');
    }

    function getDayHistory($aParams)
    {
        return Admin_DA::_getHistoryTz(
            'history_day',
            $aParams,
            'day',
            'format',
            array('%Y-%m-%d'),
            $GLOBALS['date_format']
        );
    }

    function getMonthHistory($aParams)
    {
        return Admin_DA::_getHistoryTz(
            'history_month',
            $aParams,
            'month',
            'format',
            array('%Y-%m'),
            $GLOBALS['month_format']
        );
    }

    function getDayOfWeekHistory($aParams)
    {
        return Admin_DA::_getHistoryTz(
            'history_dow',
            $aParams,
            'dow',
            'getDayOfWeek'
        );
    }

    function getHourHistory($aParams)
    {
        return Admin_DA::_getHistoryTz(
            'history_hour',
            $aParams,
            'hour',
            'getHour'
        );
    }

    function _getHistoryTz($entity, $aParams, $name, $method, $args = array(), $formatted = null)
    {
        if (empty($aParams['tz'])) {
            return Admin_DA::_getEntities($entity, $aParams, false, $name);
        }

        $aStats = Admin_DA::fromCache('getDayHourHistory', $aParams);

        return Admin_DA::_convertStatsArrayToTz($aStats, $aParams, $name, $method, $args, $formatted);
    }

    function _convertStatsArrayToTz($aStats, $aParams, $name, $method, $args = array(), $formatted = null)
    {
        $aResult = array();
        foreach ($aStats as $k => $v) {
            unset($v['date_time']);
            $oDate = new Date($k);
            $oDate->setTZbyID('UTC');
            $oDate->convertTZbyID($aParams['tz']);
            $key = call_user_func_array(array(&$oDate, $method), $args);
            if (!isset($aResult[$key])) {
                $v[$name] = $key;
                if ($formatted) {
                    $v['date_f'] = $oDate->format($formatted);
                }
                $aResult[$key] = $v;
            } else {
                foreach ($v as $kk => $vv) {
                    $aResult[$key][$kk] += $vv;
                }
            }
        }

        return $aResult;
    }

    // +---------------------------------------+
    // | generic DA methods                    |
    // |                                       |
    // +---------------------------------------+

    function addCategory($aVariables)
    {
        return Admin_DA::_addEntity('category', $aVariables);
    }

    function addAdCategory($aVariables)
    {
        return Admin_DA::_addEntity('ad_category_assoc', $aVariables);
    }

    // +---------------------------------------+
    // | ad - zone associations                |
    // +---------------------------------------+
    function addAdZone($aVariables)
    {
        $result = false;
        PEAR::pushErrorHandling(null);
        $canAddAdZone = Admin_DA::_isValidAdZoneAssoc($aVariables);
        if (PEAR::isError($canAddAdZone)) {
            $result = $canAddAdZone;
        } else {
            // Add the banner
            if ($aVariables['zone_id'] === 0) {
                $result = Admin_DA::_addEntity('ad_zone_assoc', array('ad_id' => $aVariables['ad_id'], 'zone_id' => $aVariables['zone_id'], 'priority_factor' => '1', 'link_type' => MAX_AD_ZONE_LINK_DIRECT));
            } else {
                $result = Admin_DA::_addEntity('ad_zone_assoc', array('ad_id' => $aVariables['ad_id'], 'zone_id' => $aVariables['zone_id'], 'priority_factor' => '1'));
            }
        }
        PEAR::popErrorHandling();
        return $result;
    }


    /**
     * ???
     *
     * @param integer $zoneId The ID of the zone to be tested.
     * @param unknown_type $campaignid ???
     * @param unknown_type $newStart ???
     * @param unknown_type $newEnd ???
     * @return unknown ???
     */
    function _checkEmailZoneAdAssoc($zoneId, $campaignid, $newStart = false, $newEnd = false)
    {
        // Suppress PEAR error handling for this method...
        PEAR::pushErrorHandling(null);
        require_once('Date.php');
        // This is an email zone, so check all current linked ads for active date ranges
        $aOtherAds = Admin_DA::getAdZones(array('zone_id' => $zoneId));
        $campaignVariables = Admin_DA::getPlacement($campaignid);
        if ($newStart) {
            $campaignVariables['activate_time'] = $newStart;
        }
        if ($newEnd) {
            $campaignVariables['expire_time'] = $newEnd;
        }

        if (empty($campaignVariables['activate_time']) && empty($campaignVariables['expire_time'])) {
            return PEAR::raiseError(sprintf($GLOBALS['strEmailNoDates'], PRODUCT_NAME), MAX_ERROR_EMAILNODATES);
        }
        $campaignStart = new Date($campaignVariables['activate_time']);
        $campaignStart->setTZbyID('UTC');
        $campaignEnd = new Date($campaignVariables['expire_time']);
        $campaignEnd->setTZbyID('UTC');

        $okToLink = true;
        foreach ($aOtherAds as $azaID => $aAdVariables) {
            $aOtherAdVariables = Admin_DA::getAd($aAdVariables['ad_id']);
            if ($aOtherAdVariables['placement_id'] == $campaignid) {
                continue;
            }
            $otherCampaignVariables = Admin_DA::getPlacement($aOtherAdVariables['placement_id']);

            if(empty($otherCampaignVariables['activate_time'])
                || empty($otherCampaignVariables['expire_time'])) {
                $okToLink = false;
                break;
            }
            // Do not allow link if either start or end date is within another linked campaign dates
            $otherCampaignStart = new Date($otherCampaignVariables['activate_time']);
            $otherCampaignStart->setTZbyID('UTC');
            $otherCampaignEnd = new Date($otherCampaignVariables['expire_time']);
            $otherCampaignEnd->setTZbyID('UTC');

            if (($campaignStart->after($otherCampaignStart) && $campaignStart->before($otherCampaignEnd)) || ($campaignStart->equals($otherCampaignStart))) {
                $okToLink = false;
                break;
            }
            if (($campaignEnd->after($otherCampaignStart) && $campaignEnd->before($otherCampaignEnd)) || ($campaignEnd->equals($otherCampaignEnd))) {
                $okToLink = false;
                break;
            }
        }
        if (!$okToLink) {
            $link = "campaign-edit.php?clientid={$otherCampaignVariables['advertiser_id']}&campaignid={$otherCampaignVariables['placement_id']}";
            return PEAR::raiseError($GLOBALS['strDatesConflict'] . ": <a href='{$link}'>" . $otherCampaignVariables['name'] . "</a>", MAX_ERROR_EXISTINGCAMPAIGNFORDATES);
        }
        PEAR::popErrorHandling();
        return true;
    }

    function _checkBannerZoneAdAssoc($aZone, $bannerType, $contentType = null)
    {
        $aAllowedBannerType = array();
        switch ($aZone['type']) {
        case MAX_ZoneEmail:
            $aAllowedBannerType = array('sql', 'web', 'url');
            $aAllowedContentType = array('gif', 'jpeg', 'png');
            break;
        case phpAds_ZoneText:
            $aAllowedBannerType = array('txt');
            break;
        }
        //  return false if banner is not allowed to be linked to selected zone type
        if((($aZone['type'] != MAX_ZoneEmail) && !in_array($bannerType, $aAllowedBannerType)) ||
           (($aZone['type'] == MAX_ZoneEmail) && (!in_array($bannerType, $aAllowedBannerType) || !in_array($contentType, $aAllowedContentType)))) {
            return PEAR::raiseError('This banner is the wrong type for this zone - <a href="zone-edit.php?affiliateid='. $aZone['publisher_id'] .'&zoneid='. $aZone['zone_id'] .'">'. $aZone['name'] .'</a>', MAX_ERROR_INVALIDBANNERTYPE);
        }
        return true;
    }

    function _isValidAdZoneAssoc($aVariables)
    {
        $aAdZone = Admin_DA::getAdZones($aVariables);
        if (empty($aAdZone))  {
            if (!$aVariables['zone_id']) {
                // Direct selection zone, always allow
                return true;
            }
            $azParams = Admin_DA::getLinkedAdParams($aVariables['zone_id']);
            $azParams['ad_id'] = $aVariables['ad_id'];
            $azParams['market_ads_include'] = true;
            $azAds = Admin_DA::getAds($azParams);
            if (!empty($azAds)) {
                // Ad seems OK to link, check if this is an email zone, and
                // enforce only a single active linked ad at a time
                $aZone = Admin_DA::getZone($aVariables['zone_id']);
                if ($aZone['type'] == MAX_ZoneEmail) {
                    $aAd = Admin_DA::getAd($azParams['ad_id']);
                    $okToLink = Admin_DA::_checkEmailZoneAdAssoc($aZone['zone_id'], $aAd['placement_id']);
                    if (PEAR::isError($okToLink)) {
                        return $okToLink;
                    }
                    PEAR::pushErrorHandling(null);
                    $okToLink = Admin_DA::_checkBannerZoneAdAssoc($aZone, $aAd['type'], $aAd['contenttype']);
                    PEAR::popErrorHandling();
                    if (PEAR::isError($okToLink)) {
                        return $okToLink;
                    }
                }
                if ($aZone['type'] != phpAds_ZoneText && $azAds[$azParams['ad_id']]['type'] == 'txt') {
                    return PEAR::raiseError('Text banner can be linked only to text zone', MAX_ERROR_INVALIDBANNERSIZE);
                }
                return true;
            } else {
                return PEAR::raiseError('This banner is the wrong size for this zone', MAX_ERROR_INVALIDBANNERSIZE);
            }
        } else {
            // If already linked...
            return PEAR::raiseError('This banner is already linked to this zone', MAX_ERROR_ALREADYLINKED);
        }
    }

    function duplicateAdZone($aAdZone)
    {
        unset($aAdZone['zone_ad_id']);
        return Admin_DA::_addEntity('ad_zone_assoc', $aAdZone);
    }

    function getAdZones($aParams, $allFields = false, $key = null)
    {
        return Admin_DA::_getEntities('ad_zone_assoc', $aParams, $allFields, $key);
    }

    function deleteAdZones($aParams, $allFields = false)
    {
        return SqlBuilder::_doDelete('ad_zone_assoc', $aParams);
    }

    // Advertisers

    /**
     * A method to add advertisers to the database.
     *
     * @TODO Document what parameters can be passed into the method.
     */
    function addAdvertiser($aVariables)
    {
        return Admin_DA::_addEntity('clients', $aVariables);
    }

    // +---------------------------------------+
    // | ads                                   |
    // +---------------------------------------+

    function getAd($adId)
    {
        return Admin_DA::_getDataRowFromId('ad', 'ad_id', $adId);
    }

    function getAds($aParams, $allFields = false)
    {
        // Return Advert object
        return Admin_DA::_getEntities('ad', $aParams, $allFields);
    }

    function getChannel($channelId)
    {
        // Return channel object
        return Admin_DA::_getEntity('channel', $channelId);
    }

    function getChannels($aParams, $allFields = false)
    {
        if (!isset($aParams['channel_type'])) {
            if (!empty($aParams['publisher_id'])) {
                $aParams['channel_type'] = 'publisher';
            } elseif ((isset($aParams['publisher_id']) && !$aParams['publisher_id']) || (isset($aParams['agency_id']))) {
                $aParams['channel_type'] = 'agency';
            } else {
                // Backwards-compatible
                $aParams['channel_type'] = 'publisher';
            }
        } elseif (!in_array($aParams['channel_type'], array('all', 'publisher', 'agency'))) {
            return PEAR::raiseError('Wrong channel_type.', MAX_ERROR_INVALIDMETHODPERMS);
        }

        // Return channel object
        return Admin_DA::_getEntities('channel', $aParams, $allFields);
    }

    function getChannelLimitations($aParams, $allFields = false)
    {
        return Admin_DA::_getEntities('channel_limitation', $aParams, $allFields, 'executionorder');
    }

    function addAd($aParams)
    {
        return Admin_DA::_addEntity('banners', $aParams);
    }

    function duplicateAd($adId)
    {
        $aAd = Admin_DA::getAd($adId);
        return Admin_DA::_duplicateAd($aAd, true);
    }

    function _duplicateAd($aAd, $checkUniqueNames = false)
    {
        require_once MAX_PATH . '/www/admin/lib-storage.inc.php';
        // Copy the linked creative
        $newFile = phpAds_ImageDuplicate($aAd['type'], $aAd['filename']);
        if ($newFile !== false) {
            $aAd['filename'] = $newFile;
        }
        // Remove the existing advert id
        $adId = $aAd['ad_id'];
        unset($aAd['ad_id']);
        // Check for unique names
        if ($checkUniqueNames) {
            $aAds = Admin_DA::getAds(array('placement_id' => $aAd['placement_id']));
            Admin_DA::_getUniqueName($aAd, $aAds, $GLOBALS['strCopy']);
        }
        // Add the new ad
        $newAdId = Admin_DA::addAd($aAd);
        // Copy the limitations
        $aLimitations = Admin_DA::getDeliveryLimitations(array('ad_id' => $adId));
        foreach ($aLimitations as $aLimitation) {
            $aLimitation['ad_id'] = $newAdId;
            Admin_DA::addLimitation($aLimitation);
        }
        // Copy the zone ad associations
        $aAdZones = Admin_DA::getAdZones(array('ad_id' => $adId));
        foreach ($aAdZones as $aAdZone) {
            $aAdZone['ad_id'] = $newAdId;
            Admin_DA::duplicateAdZone($aAdZone);
        }
        return $newAdId;
    }

/* REDUNDANT
    function updateAd($id, $aVariables)
    {
        return Admin_DA::_updateEntity('ad', $id, $aVariables);
    }*/

    function getAdvertisers($aParams, $allFields = false)
    {
        return Admin_DA::_getEntities('advertiser', $aParams, $allFields);
    }

    function getAdvertisersChildren($aParams, $allFields = false)
    {
        return Admin_DA::_getEntitiesChildren('advertiser', $aParams, $allFields);
    }

    function getAgency($agencyId)
    {
        return Admin_DA::_getEntity('agency', $agencyId);
    }

    function getAgencies($aParams, $allFields = false)
    {
        return Admin_DA::_getEntities('agency', $aParams, $allFields);
    }

    function addAgency($aParams)
    {
        return Admin_DA::_addEntity('agency', $aParams);
    }

   /**
    * Method to return the total number of clicks and impressions
    * received by an agencies ads for hours inclusive of a given date range.
    *
    * see {@link Admin_DA::getAdsStatsByDate()} for date information
    *
    * @param integer $id agency id
    * @param object $oStart start of date range
    * @param object $oEnd end of date range
    * @return mixed array or PEAR::Error object
    */
    function getAgencyAdStats($id, $oStart, $oEnd)
    {
        // Validate args
        if (!empty($id) && is_a($oStart, 'Date') && is_a($oEnd, 'Date')) {
            if ($oEnd->after($oStart)) {
                $aAds = &Admin_DA::getAdsByAgencyId($id);
                if (PEAR::isError($aAds)) {
                    return $aAds;
                }
                return Admin_DA::getAdsStatsByDate($aAds, $oStart, $oEnd);
            } else {
                return MAX::raiseError("Invalid arguments passed to " . __CLASS__ . '::' . __FUNCTION__ . '
                end date is before or equal to start date.', MAX_ERROR_INVALIDARGS);
            }
        } else {
            return MAX::raiseError("Invalid arguments passed to " . __CLASS__ . '::' . __FUNCTION__ , MAX_ERROR_INVALIDARGS);
        }
    }


    // +---------------------------------------+
    // | placements                            |
    // +---------------------------------------+
    function addPlacement($aParams)
    {
        return Admin_DA::_addEntity('campaigns', $aParams);
    }

    function getCampaigns($aParams, $allFields = false)
    {
        return Admin_DA::_getEntities('campaign', $aParams, $allFields);
    }

    function getPlacement($placementId)
    {
        return Admin_DA::_getDataRowFromId('placement', 'placement_id', $placementId);
    }

    function getPlacements($aParams, $allFields = false, $key = null)
    {
        return Admin_DA::_getEntities('placement', $aParams, $allFields, $key);
    }

    function getPlacementsChildren($aParams, $allFields = false, $key = null)
    {
        return Admin_DA::_getEntitiesChildren('placement', $aParams, $allFields, $key);
    }

    function duplicatePlacement($placementId)
    {
        $aPlacement = Admin_DA::getPlacement($placementId);
        return Admin_DA::_duplicatePlacement($aPlacement, true);
    }

    function _duplicatePlacement($aPlacement, $checkUniqueNames = false)
    {
        $placementId = $aPlacement['placement_id'];
        unset($aPlacement['placement_id']);
        if ($checkUniqueNames) {
            $aPlacements = Admin_DA::getPlacements(array('advertiser_id' => $aPlacement['advertiser_id']));
            Admin_DA::_getUniqueName($aPlacement, $aPlacements, @$GLOBALS['strCopy']);
        }
        // FIXME: get rid of this
        $aPlacement = MAX_commonSlashArray($aPlacement);
        // Massage to real field names
        Admin_DA::_switch($aPlacement, 'advertiser_id', 'clientid');
        Admin_DA::_switch($aPlacement, 'name', 'campaignname');
        $newPlacementId = Admin_DA::addPlacement($aPlacement);
        $aPlacementTrackers = Admin_DA::getPlacementTrackers(array('placement_id' => $placementId));
        foreach ($aPlacementTrackers as $aPlacementTracker) {
            $aPlacementTracker['placement_id'] = $newPlacementId;
            Admin_DA::duplicatePlacementTracker($aPlacementTracker);
        }
        $aPlacementZones = Admin_DA::_getEntities('placement_zone_assoc', array('placement_id' => $placementId));
        foreach ($aPlacementZones as $aPlacementZone) {
            $aPlacementZone['placement_id'] = $newPlacementId;
            Admin_DA::duplicatePlacementZone($aPlacementZone);
        }
        $aAds = Admin_DA::getAds(array('placement_id' => $placementId));
        foreach ($aAds as $aAd) {
            $aAd['placement_id'] = $newPlacementId;
            Admin_DA::duplicateAd($aAd, $aAds);
        }
        return $newPlacementId;
    }

    // +---------------------------------------+
    // | placement - zone associations         |
    // +---------------------------------------+

    function duplicatePlacementZone($aPlacementZone)
    {
        unset($aPlacementZone['placement_zone_assoc_id']);
        return Admin_DA::_addEntity('placement_zone_assoc', $aPlacementZone);
    }

    function getPlacementZones($aParams, $allFields = false, $key = null)
    {
        return Admin_DA::_getEntities('placement_zone_assoc', $aParams, $allFields, $key);
    }

    function addPlacementZone($aVariables, $autoLinkMatchingBanners = true)
    {
        if (!($pzaId = Admin_DA::_addEntity('placement_zone_assoc', $aVariables))) {
            return false;
        }
        if (!$autoLinkMatchingBanners) {
            return $pzaId;
        }
        // Selects ads which belongs to the campaign (placement) and fit into
        // the zone. Then links all those ads to the zone if they are not linked already.
        $azParams = Admin_DA::getLinkedAdParams($aVariables['zone_id']);
        $azParams['placement_id'] = $aVariables['placement_id'];
        $azAds = Admin_DA::getAds($azParams);
        $azLinkedAds = Admin_DA::getAdZones(array('zone_id' => $aVariables['zone_id']), false, 'ad_id');
        foreach ($azAds as $adId => $azAd) {
            if (!isset($azLinkedAds[$adId])) {
                Admin_DA::addAdZone(array('zone_id' => $aVariables['zone_id'], 'ad_id' => $adId));
            }
        }
        return $pzaId;
    }

    /**
 	 * @param array $aParams
 	 * @param bool $allFields
 	 * @return mixed 0 if no rows affected, true on success, false otherwise
 	 */
    function deletePlacementZones($aParams, $allFields = false)
    {
        $result = SqlBuilder::_doDelete('placement_zone_assoc', $aParams);

        // Unlink any ads in the campaign that are linked to the zone.
        $pAds = Admin_DA::getAds(array('placement_id' => $aParams['placement_id']));
        foreach ($pAds as $adId => $pAd)
        {
            SqlBuilder::_doDelete('ad_zone_assoc',array('zone_id' => $aParams['zone_id'], 'ad_id' => $adId));
        }
        return $result;
    }


    // +---------------------------------------+
    // | placement - tracker associations      |
    // +---------------------------------------+
    function duplicatePlacementTracker($aPlacementTracker)
    {
        unset($aPlacementTracker['placement_tracker_id']);
        return Admin_DA::addPlacementTracker($aPlacementTracker);
    }

    function addPlacementTracker($aVariables)
    {
        return Admin_DA::_addEntity('placement_tracker', $aVariables);
    }

    function getPlacementTrackers($aParams, $allFields = false)
    {
        return Admin_DA::_getEntities('placement_tracker', $aParams, $allFields);
    }

/* REDUNDANT
    function deletePlacementTrackers($aParams, $allFields = false)
    {
        return Admin_DA::_deleteEntities('placement_tracker', $aParams, $allFields);
    }
*/
    // Publishers

    /**
     * A method to add publishers (affiliates) to the database.
     *
     * @TODO Document what parameters can be passed into the method.
     */
    function addPublisher($aVariables)
    {
        return Admin_DA::_addEntity('affiliates', $aVariables);
    }

    // +---------------------------------------+
    // | trackers                              |
    // +---------------------------------------+


    /**
     * Returns an array of column => value for the tracker identified by
     * $trackerId.
     *
     * @param string $trackerId
     * @return array with the data or false on failure.
     */
    function getTracker($trackerId)
    {
        return Admin_DA::_getDataRowFromId('tracker', 'trackerid', $trackerId);
    }


    function getTrackers($aParams, $allFields = false, $key = null)
    {
        return Admin_DA::_getEntities('tracker', $aParams, $allFields, $key);
    }

    function duplicateTracker($trackerId)
    {
        $aTracker = Admin_DA::_getEntity('tracker', $trackerId);
        return Admin_DA::_duplicateTracker($aTracker, true);
    }

    /**
     * Inserts a row into 'trackers' table using values provided as an
     * argument to the method.
     *
     * @param array $aParams Map column => value.
     * @return integer ID of the created tracker.
     */
    function addTracker($aParams)
    {
        return Admin_DA::_addEntity('trackers', $aParams);
    }

    function _duplicateTracker($aTracker, $checkUniqueNames = false)
    {
        $trackerId = $aTracker['tracker_id'];
        unset($aTracker['tracker_id']);
        if ($checkUniqueNames) {
            $aTrackers = Admin_DA::getTrackers(array('advertiser_id' => $aTracker['advertiser_id']));
            Admin_DA::_getUniqueName($aTracker, $aTrackers, @$GLOBALS['strCopy']);
        }
        // Massage to real field names
        Admin_DA::_switch($aTracker, 'advertiser_id', 'clientid');
        Admin_DA::_switch($aTracker, 'name', 'trackername');
        $newTrackerId = Admin_DA::addTracker($aTracker);
        if (PEAR::isError($newTrackerId)) {
            return PEAR::raiseError('failed to add tracker in ' . __FILE__ .','.__LINE__);
        }
        $aPlacementTrackers = Admin_DA::getPlacementTrackers(array('tracker_id' => $trackerId));
        foreach ($aPlacementTrackers as $aPlacementTracker) {
            $aPlacementTracker['tracker_id'] = $newTrackerId;
            Admin_DA::duplicatePlacementTracker($aPlacementTracker);
        }
        $aVariables = Admin_DA::getVariables(array('tracker_id' => $trackerId));
        foreach ($aVariables as $aVariable) {
            $aVariable['tracker_id'] = $newTrackerId;
            Admin_DA::duplicateVariable($aVariable);
        }
        return $newTrackerId;
    }

    // +---------------------------------------+
    // | zones                                 |
    // +---------------------------------------+
    function getZone($zoneId)
    {
        return Admin_DA::_getDataRowFromId('zone', 'zone_id', $zoneId);
    }

    function getZones($aParams, $allFields = false)
    {
        return Admin_DA::_getEntities('zone', $aParams, $allFields);
    }

    /*
    possible zones type IDs are:
        define ("phpAds_ZoneBanner", 0);
        define ("phpAds_ZoneInterstitial", 1);
        define ("phpAds_ZonePopup", 2);
        define ("phpAds_ZoneText", 3);
    */
    function addZone($aVariables)
    {
        Admin_DA::_switch($aVariables, 'publisher_id', 'affiliateid');
        Admin_DA::_switch($aVariables, 'name', 'zonename');
        Admin_DA::_switch($aVariables, 'type', 'delivery');
        return Admin_DA::_addEntity('zones', $aVariables);
    }

    function duplicateZone($zoneId)
    {
        $aZone = Admin_DA::getZone($zoneId);
        return Admin_DA::_duplicateZone($aZone, true);
    }

    function _duplicateZone($aZone, $checkUniqueNames = false)
    {
        $zoneId = $aZone['zone_id'];
        unset($aZone['zone_id']);

        if ($checkUniqueNames) {
            $aZones = Admin_DA::getZones(array('publisher_id' => $aZone['publisher_id']));
            Admin_DA::_getUniqueName($aZone, $aZones, @$GLOBALS['strCopy']);
        }

        $newZoneId = Admin_DA::addZone($aZone);

        //  FIXME
        $aPlacementZones = Admin_DA::_getEntities('placement_zone_assoc', array('zone_id' => $zoneId));
        foreach($aPlacementZones as $aPlacementZone) {
            $aPlacementZone['zone_id'] = $newZoneId;
            Admin_DA::duplicatePlacementZone($aPlacementZone);
        }

        $aAdZones = Admin_DA::getAdZones(array('zone_id' => $zoneId));
        foreach ($aAdZones as $aAdZone) {
            $aAdZone['zone_id'] = $newZoneId;
            Admin_DA::duplicateAdZone($aAdZone);
        }
        return $newZoneId;
    }

    // +---------------------------------------+
    // | limitations                           |
    // +---------------------------------------+
    function getDeliveryLimitations($aParams, $allFields = false)
    {
        return Admin_DA::_getEntities('limitation', $aParams, $allFields, 'executionorder');
    }

    function addLimitation($aVariable)
    {
        return Admin_DA::_addEntity('limitation', $aVariable);
    }

    // +---------------------------------------+
    // | variables                             |
    // +---------------------------------------+
    function getVariables($aParams, $allFields = false)
    {
        return Admin_DA::getADataRows('variables', $aParams);
    }

    function addVariable($aVariable)
    {
        return Admin_DA::_addEntity('variables', $aVariable);
    }

    function duplicateVariable($aVariable)
    {
        unset($aVariable['variable_id']);
        return Admin_DA::addVariable($aVariable);
    }

/* REDUNDANT
    function deleteImage($id)
    {
        return Admin_DA::_deleteEntity('image', $id);
    }
*/
    function getPublisher($publisherId)
    {
        return Admin_DA::_getEntity('publisher', $publisherId);
    }

    function getPublishers($aParams, $allFields = false)
    {
        return Admin_DA::_getEntities('publisher', $aParams, $allFields);
    }

    function getPublishersChildren($aParams, $allFields = false)
    {
        return Admin_DA::_getEntitiesChildren('publisher', $aParams, $allFields);
    }

    function getPrefix()
    {
        return $GLOBALS['_MAX']['CONF']['table']['prefix'];
    }
}

?>

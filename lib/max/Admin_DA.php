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

require_once MAX_PATH . '/lib/max/SqlBuilder.php';
require_once MAX_PATH . '/lib/max/other/common.php';

/**
 * @package    MaxDal
 * @author     Scott Switzer <scott@m3.net>
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
            $aVariables['updated'] = date('Y-m-d H:i:s');
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
            SqlBuilder::_getTableLimitations($aTables)
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
        switch ($entity) {

        case 'agency' : $aTables[$conf['table']['prefix'].$conf['table']['clients']] = 'a';
            $aGroupBy = $aColumns;
            $aColumns['COUNT(a.clientid)'] = 'num_children';
            break;

        case 'advertiser' : $aTables[$conf['table']['prefix'].$conf['table']['campaigns']] = 'm';
            $aGroupBy = $aColumns;
            $aColumns['COUNT(m.campaignid)'] = 'num_children';
            break;

        case 'placement' : $aTables[$conf['table']['prefix'].$conf['table']['banners']] = 'd';
            $aGroupBy = $aColumns;
            $aGroupBy['m.active'] = 'm.active'; // Hack to allow this to work with Postgres
            $aColumns['COUNT(d.bannerid)'] = 'num_children';
            break;

        case 'publisher' : $aTables[$conf['table']['prefix'].$conf['table']['zones']] = 'z';
            $aGroupBy = $aColumns;
            $aColumns['COUNT(z.zoneid)'] = 'num_children';
            break;

        default :
            $aGroupBy = null;
        }
        $aLimitations = array_merge(
            SqlBuilder::_getLimitations($entity, $aParams),
            SqlBuilder::_getTableLimitations($aTables));
        return SqlBuilder::_select($aColumns, $aTables, $aLimitations, $aGroupBy, $key);
    }

    /**
     * Modifies an entity's properties.
     *
     * @param string $entity
     * @param integer $id
     * @param array $aVariables
     * @return integer  The number of rows affected by the update
     */
    function _updateEntity($entity, $id, $aVariables)
    {
        $aParams = array("{$entity}_id" => $id);
        return Admin_DA::_updateEntities($entity, $aParams, $aVariables);
    }


    /**
     * Modifies multiple entities.
     *
     * @param string $entity
     * @param array $aParams
     * @param array $aVariables
     */
    function _updateEntities($entity, $aParams, $aVariables)
    {
        Admin_DA::_updateEntityTimestamp($entity, $aVariables);
        $aTable = $this->_getPrimaryTablePrefixed($entity);
        $aLimitations = SqlBuilder::_getLimitations($entity, $aParams);
        SqlBuilder::_update($aTable, $aVariables, $aLimitations);
    }
    
    
    function _getPrimaryTablePrefixed($entity)
    {
        $aTable = SqlBuilder::_getPrimaryTable($entity);
        reset($aTable);
        $tableName = key($aTable);
        $tableNamePrefixed = $conf = $GLOBALS['_MAX']['CONF'] . $tableName;
        $aTable[$tableNamePrefixed] = $aTable[$tableName];
        unset($aTable[$tableName]);
        return $aTable;
    }

    //  MAX_removeEntity
    /**
     * Remove the entity from the system.
     *
     * @param string $entity
     * @param integer $id
     * @return integer  The number of rows affected by the update
     */
    function _deleteEntity($entity, $id)
    {
        $aParams = array("{$entity}_id" => $id);
        return Admin_DA::_deleteEntities($entity, $aParams);
    }

    //  MAX_removeEntities
    /**
     * Remove a list of entities from the system.
     *
     * @param string $entity
     * @param array $aParams
     * @return integer  The number of rows affected by the update
     */
    function _deleteEntities($entity, $aParams)
    {
        $aTable = $this->_getPrimaryTablePrefixed($entity);
        $aOtherTables = SqlBuilder::_getTables($entity, $aParams);
        $aLimitations = array_merge(SqlBuilder::_getLimitations($entity, $aParams),
            SqlBuilder::_getTableLimitations($aOtherTables));
        return SqlBuilder::_delete($aTable, $aLimitations, $aOtherTables);
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
            SqlBuilder::_getTableLimitations($aTables));
        
        // An ugly hack to get the alias used for the entity table so
        // the query works with Postgres.
        end($aColumns);
        $groupByColumn = key($aColumns);
        reset($aColumns);
        
        $aGroups = array($groupByColumn);
        
        return SqlBuilder::_select($aColumns, $aTables, $aLimitations, $aGroups, $key);
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
        if(isset($cacheGroups[$method])) {
            $options['defaultGroup'] = $cacheGroups[$method];
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
            if ($aZone['width'] > -1) {
                $aParams['ad_width'] = $aZone['width'];
            }
            if ($aZone['height'] > -1) {
                $aParams['ad_height'] = $aZone['height'];
            }
        }
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

        $where = '';
        if (!empty($aParams['agency_id'])) {
            $where .= ' AND c.agencyid='.$aParams['agency_id'];
        }
        if (!empty($aParams['day_begin'])) {
            $where .= ' AND DATE_FORMAT(ac.tracker_date_time,"%Y-%m-%d")>="'.$aParams['day_begin'].'"';
        }
        if (!empty($aParams['day_end'])) {
            $where .= ' AND DATE_FORMAT(ac.tracker_date_time,"%Y-%m-%d")<="'.$aParams['day_end'].'"';
        }
        if (!empty($aParams['day'])) {
            $where .= ' AND DATE_FORMAT(ac.tracker_date_time,"%Y-%m-%d")="'.$aParams['day'].'"';
        }
        if (!empty($aParams['month'])) {
            $where .= ' AND DATE_FORMAT(ac.tracker_date_time,"%Y-%m")="'.$aParams['month'].'"';
        }
        if (!empty($aParams['day_hour'])) {
            $where .= ' AND DATE_FORMAT(ac.tracker_date_time,"%Y-%m-%d %H")="'.$aParams['day_hour'].'"';
        }
        if (!empty($aParams['clientid'])) {
            $where .= ' AND c.clientid="'.$aParams['clientid'].'"';
        }
        if (isset($aParams['zonesIds'])) {
            $where .= " AND ac.zone_id IN (".implode(',', $aParams['zonesIds']).")";
        }
        if (!empty($aParams['campaignid'])) {
            $where .= ' AND m.campaignid="'.$aParams['campaignid'].'"';
        }
        if (!empty($aParams['bannerid'])) {
            $where .= ' AND d.bannerid="'.$aParams['bannerid'].'"';
        }
        if (!empty($aParams['statuses'])) {
            $where .= ' AND ac.connection_status IN ('.implode(',', $aParams['statuses']).')';
        }


        if (isset($aParams['startRecord']) && is_numeric($aParams['startRecord']) && is_numeric($aParams['perPage'])) {
            $limit = ' LIMIT ' . $aParams['startRecord'] . ', ' . $aParams['perPage'];
        } else {
            $limit = ' LIMIT 0, ' . $aParams['perPage'];
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

        $dbh = &OA_DB::singleton();
        return $dbh->queryAll($query, null, MDB2_FETCHMODE_DEFAULT, true);
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

        if (phpAds_isUser(phpAds_Affiliate)) {
            $publisherId = phpAds_getUserId();
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
            vv.data_intermediate_ad_connection_id='".$connectionId."'
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

    function getDayHistory($aParams)
    {
        return Admin_DA::_getEntities('history_day', $aParams, false, 'day');
    }

    function getMonthHistory($aParams)
    {
        return Admin_DA::_getEntities('history_month', $aParams, false, 'month');
    }

    function getDayOfWeekHistory($aParams)
    {
        return Admin_DA::_getEntities('history_dow', $aParams, false, 'dow');
    }

    function getHourHistory($aParams)
    {
        return Admin_DA::_getEntities('history_hour', $aParams, false, 'hour');
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
                $result = Admin_DA::_addEntity('ad_zone_assoc', array('ad_id' => $aVariables['ad_id'], 'zone_id' => $aVariables['zone_id'], 'link_type' => MAX_AD_ZONE_LINK_DIRECT));
            } else {
                $result = Admin_DA::_addEntity('ad_zone_assoc', array('ad_id' => $aVariables['ad_id'], 'zone_id' => $aVariables['zone_id']));
            }
        }
        PEAR::popErrorHandling();
        return $result;
    }


    function _checkEmailZoneAdAssoc($aZone, $campaignid, $newStart = false, $newEnd = false)
    {
        // Suppress PEAR error handling for this method...
        PEAR::pushErrorHandling(null);
        require_once('Date.php');
        // This is an email zone, so check all current linked ads for active date ranges
        $aOtherAds = Admin_DA::getAdZones(array('zone_id' => $aZone['zone_id']));
        $campaignVariables = Admin_DA::getPlacement($campaignid);
        if ($newStart) {
            $campaignVariables['activate'] = $newStart;
        }
        if ($newEnd) {
            $campaignVariables['expire'] = $newEnd;
        }

        if ($campaignVariables['activate'] == '0000-00-00' || $campaignVariables['expire'] == '0000-00-00') {
            return PEAR::raiseError($GLOBALS['strEmailNoDates'], MAX_ERROR_EMAILNODATES);
        }
        $campaignStart = new Date($campaignVariables['activate'] . ' 00:00:00');
        $campaignEnd = new Date($campaignVariables['expire'] . ' 23:59:59');

        $okToLink = true;
        foreach ($aOtherAds as $azaID => $aAdVariables) {
            $aOtherAdVariables = Admin_DA::getAd($aAdVariables['ad_id']);
            if ($aOtherAdVariables['placement_id'] == $campaignid) {
                continue;
            }
            $otherCampaignVariables = Admin_DA::getPlacement($aOtherAdVariables['placement_id']);

            // Do not allow link if either start or end date is within another linked campaign dates
            $otherCampaignStart = new Date($otherCampaignVariables['activate'] . ' 00:00:00');
            $otherCampaignEnd = new Date($otherCampaignVariables['expire'] . ' 23:59:59');

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

    function _isValidAdZoneAssoc($aVariables)
    {
        $aAdZone = Admin_DA::getAdZones($aVariables);
        if (empty($aAdZone))  {
            $azParams = Admin_DA::getLinkedAdParams($aVariables['zone_id']);
            $azParams['ad_id'] = $aVariables['ad_id'];
            $azAds = Admin_DA::getAds($azParams);
            if (!empty($azAds)) {
                // Ad seems OK to link, check if this is an email zone, and enforce only a single active linked ad at a time
                $aZone = Admin_DA::getZone($aVariables['zone_id']);
                if ($aZone['type'] == MAX_ZoneEmail) {
                    $aAd = Admin_DA::getAd($azParams['ad_id']);
                    $okToLink = Admin_DA::_checkEmailZoneAdAssoc($aZone, $aAd['placement_id']);
                    if (PEAR::isError($okToLink)) {
                        return $okToLink;
                    }
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
        return Admin_DA::_deleteEntities('ad_zone_assoc', $aParams, $allFields);
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
        return Admin_DA::_getDataRowFromId('ad', 'bannerid', $adId);
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
        if (isset($aParams['channel_type']) && $aParams['channel_type'] == 'admin'){
            $aParams['channel_type'] = 'agency';
        }
        elseif (!isset($aParams['channel_type'])) {
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

    function updateAd($id, $aVariables)
    {
        return Admin_DA::_updateEntity('ad', $id, $aVariables);
    }

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
    * Method to change active status of a given
    * agency to active.
    *
    * @param $id agency id
    * @return bool true on success false on failure
    * @access public
    */
    function enableAgency($id)
    {
        return Admin_DA::_updateAgencyActiveStatus($id, true);
    }

   /**
    * Method to change active status of a given
    * agency to inactive.
    *
    * @param $id agency id
    * @return bool true on success false on failure
    * @access public
    */
    function disableAgency($id)
    {
        return Admin_DA::_updateAgencyActiveStatus($id, false);
    }

   /**
    * Method to change the active status of a given
    * agency to inactive.
    *
    * @param    $id agency id
    * @param    bool $active true active false inactive
    * @return   mixed true for successful update, false on no change,
    *           PAR::Error on failure
    * @access   private
    */
    function _updateAgencyActiveStatus($id, $active)
    {
        // XXX The error returning behaviour when $result == 0 is only possible
        // in mysql. In other databases exec() returns the number of updated
        // rows, not of the affected
        if (!empty($id) && is_bool($active)) {
            $status = ($active === true) ? 1 : 0;
            $dbh =& OA_DB::singleton();
            $result = $dbh->exec('UPDATE agency SET active = ' . $status . ' WHERE agencyid = ' . $id);
            if (PEAR::isError($result)) {
                return $result;
            }
            if ($result > 0) {
                return true;
            } else {
                // no rows affected by update - nothing to change
                return PEAR::raiseError('No affected rows.', MAX_ERROR_NOAFFECTEDROWS);
            }
        } else {
            // ERROR - id or status args missing
            return PEAR::raiseError("Invalid arguments passed to " . __CLASS__ . '::' . __FUNCTION__ ,
                MAX_ERROR_INVALIDARGS);
        }
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

   /**
    * Mathod to return ad click and impression hourly totals
    * for an array of agency ids over a given date range.
    *
    * Please note stats are evaluated once per hour, the start and end
    * date objects should span the hours you wish to get stats for.
    *
    * Example:
    *   Single hour - 2005-05-23 10:00:00 - 2005-05-23 10:59:59
    *   Single hour - 2005-05-23 10:00:00 - 2005-05-23 10:00:01
    *   Two hours   - 2005-05-23 10:00:00 - 2005-05-23 11:00:00
    *
    * @param array $aAds ad ids
    * @param object $oStart start of date range
    * @param object $oEnd end of date range
    */
    function getAgenciesCampaignStats($aAgencyId, $startDate, $endDate)
    {
        require_once 'Date.php';
        $oStart = new Date($startDate);
        $oEnd = new Date($endDate);
        if (is_array($aAgencyId) && count($aAgencyId)) {
            $aAgencyStats = array();
            if (!$oEnd->after($oStart)) {
                return PEAR::raiseError("Invalid arguments passed to " . __CLASS__ . '::' . __FUNCTION__ .
                    'end date is before or equal to start date.', MAX_ERROR_INVALIDARGS);
            }
            $db = &OA_DB::singleton();
            // Get list of ad ids to include
            $agencyIds = implode(',', $aAgencyId);
            // Is start and end date in same day? - different operator required
            // in SQL for start and end date spanning multiple days
            if ($oStart->format('%Y-%m-%e') == $oEnd->format('%Y-%m-%e')) {
                $operator = 'AND';
            } else {
                $operator = 'OR';
            }
            $query = '
            SELECT
                clients.agencyid, clients.clientid,
                campaigns.campaignid,
                data_summary_ad_hourly.day, data_summary_ad_hourly.hour,
                SUM(data_summary_ad_hourly.impressions) AS totalImpressions, SUM(data_summary_ad_hourly.clicks) AS totalClicks
            FROM clients, campaigns, banners, data_summary_ad_hourly
            WHERE
                clients.agencyid in (' . $agencyIds . ')
                AND clients.clientid = campaigns.clientid
                AND campaigns.campaignid = banners.campaignid
                AND banners.bannerid = data_summary_ad_hourly.ad_id
                AND (
                        (data_summary_ad_hourly.day = \'' . $oStart->format('%Y-%m-%e')  . '\'
                            AND data_summary_ad_hourly.hour >= \'' . $oStart->getHour()  .'\')

                        ' . $operator . ' (data_summary_ad_hourly.day = \'' . $oEnd->format('%Y-%m-%e')  . '\'
                            AND data_summary_ad_hourly.hour <= \'' . $oEnd->getHour()  .'\')

                        OR (data_summary_ad_hourly.day > \'' . $oStart->format('%Y-%m-%e')  . '\'
                            AND data_summary_ad_hourly.day < \'' . $oEnd->format('%Y-%m-%e')  .'\')
                    )
            GROUP BY clients.agencyid, clients.clientid, campaigns.campaignid, data_summary_ad_hourly.day, data_summary_ad_hourly.hour';
            $aCampaigns = $db->queryAll($query);
            if (PEAR::isError($aCampaigns)) {
                return $aCampaigns;
            }
            foreach($aCampaigns as $campaign) {
                $aAgencyStats[$campaign['day']][$campaign['hour']][$campaign['agencyid']]['totalImpressions'] += $campaign['totalimpressions'];
                $aAgencyStats[$campaign['day']][$campaign['hour']][$campaign['agencyid']]['totalClicks'] += $campaign['totalclicks'];
            }
        } else {
            return PEAR::raiseError("Invalid arguments passed to " . __CLASS__ . '::' . __FUNCTION__ , MAX_ERROR_INVALIDARGS);
        }
        return $aAgencyStats;
    }


    // +---------------------------------------+
    // | placements                            |
    // +---------------------------------------+
    function addPlacement($aParams)
    {
        return Admin_DA::_addEntity('campaigns', $aParams);
    }

    function getPlacement($placementId)
    {
        return Admin_DA::_getDataRowFromId('placement', 'campaignid', $placementId);
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

    function addPlacementZone($aVariables)
    {
        if (!($pzaId = Admin_DA::_addEntity('placement_zone_assoc', $aVariables))) {
            return false;
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

    function deletePlacementZones($aParams, $allFields = false)
    {
        $sucess = true;
        if (!Admin_DA::_deleteEntities('placement_zone_assoc', $aParams, $allFields)) { $sucess = false; }
        $pAds = Admin_DA::getAds(array('placement_id' => $aParams['placement_id']));
        foreach ($pAds as $adId => $pAd) {
            Admin_DA::deleteAdZones(array('zone_id' => $aParams['zone_id'], 'ad_id' => $adId));
        }
        return $sucess;
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

    function deletePlacementTrackers($aParams, $allFields = false)
    {
        return Admin_DA::_deleteEntities('placement_tracker', $aParams, $allFields);
    }

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
        return Admin_DA::_getDataRowFromId('zone', 'zoneid', $zoneId);
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

    function deleteImage($id)
    {
        return Admin_DA::_deleteEntity('image', $id);
    }

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
}

?>

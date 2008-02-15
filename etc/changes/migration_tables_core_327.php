<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_327 extends Migration
{

    function Migration_327()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__zones__category';
		$this->aTaskList_constructive[] = 'afterAddField__zones__category';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__ad_selection';
		$this->aTaskList_constructive[] = 'afterAddField__zones__ad_selection';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__inventory_forecast_type';
		$this->aTaskList_constructive[] = 'afterAddField__zones__inventory_forecast_type';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__comments';
		$this->aTaskList_constructive[] = 'afterAddField__zones__comments';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__cost';
		$this->aTaskList_constructive[] = 'afterAddField__zones__cost';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__cost_type';
		$this->aTaskList_constructive[] = 'afterAddField__zones__cost_type';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__cost_variable_id';
		$this->aTaskList_constructive[] = 'afterAddField__zones__cost_variable_id';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__technology_cost';
		$this->aTaskList_constructive[] = 'afterAddField__zones__technology_cost';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__technology_cost_type';
		$this->aTaskList_constructive[] = 'afterAddField__zones__technology_cost_type';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__updated';
		$this->aTaskList_constructive[] = 'afterAddField__zones__updated';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__block';
		$this->aTaskList_constructive[] = 'afterAddField__zones__block';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__capping';
		$this->aTaskList_constructive[] = 'afterAddField__zones__capping';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__session_capping';
		$this->aTaskList_constructive[] = 'afterAddField__zones__session_capping';


		$this->aObjectMap['zones']['category'] = array('fromTable'=>'zones', 'fromField'=>'category');
		$this->aObjectMap['zones']['ad_selection'] = array('fromTable'=>'zones', 'fromField'=>'ad_selection');
		$this->aObjectMap['zones']['inventory_forecast_type'] = array('fromTable'=>'zones', 'fromField'=>'inventory_forecast_type');
		$this->aObjectMap['zones']['comments'] = array('fromTable'=>'zones', 'fromField'=>'comments');
		$this->aObjectMap['zones']['cost'] = array('fromTable'=>'zones', 'fromField'=>'cost');
		$this->aObjectMap['zones']['cost_type'] = array('fromTable'=>'zones', 'fromField'=>'cost_type');
		$this->aObjectMap['zones']['cost_variable_id'] = array('fromTable'=>'zones', 'fromField'=>'cost_variable_id');
		$this->aObjectMap['zones']['technology_cost'] = array('fromTable'=>'zones', 'fromField'=>'technology_cost');
		$this->aObjectMap['zones']['technology_cost_type'] = array('fromTable'=>'zones', 'fromField'=>'technology_cost_type');
		$this->aObjectMap['zones']['updated'] = array('fromTable'=>'zones', 'fromField'=>'updated');
		$this->aObjectMap['zones']['block'] = array('fromTable'=>'zones', 'fromField'=>'block');
		$this->aObjectMap['zones']['capping'] = array('fromTable'=>'zones', 'fromField'=>'capping');
		$this->aObjectMap['zones']['session_capping'] = array('fromTable'=>'zones', 'fromField'=>'session_capping');
    }



	function beforeAddField__zones__category()
	{
		return $this->beforeAddField('zones', 'category');
	}

	function afterAddField__zones__category()
	{
		return $this->afterAddField('zones', 'category');
	}

	function beforeAddField__zones__ad_selection()
	{
		return $this->beforeAddField('zones', 'ad_selection');
	}

	function afterAddField__zones__ad_selection()
	{
		return $this->afterAddField('zones', 'ad_selection');
	}

	function beforeAddField__zones__inventory_forecast_type()
	{
		return $this->beforeAddField('zones', 'inventory_forecast_type');
	}

	function afterAddField__zones__inventory_forecast_type()
	{
		return $this->afterAddField('zones', 'inventory_forecast_type');
	}

	function beforeAddField__zones__comments()
	{
		return $this->beforeAddField('zones', 'comments');
	}

	function afterAddField__zones__comments()
	{
		return $this->afterAddField('zones', 'comments');
	}

	function beforeAddField__zones__cost()
	{
		return $this->beforeAddField('zones', 'cost');
	}

	function afterAddField__zones__cost()
	{
		return $this->afterAddField('zones', 'cost');
	}

	function beforeAddField__zones__cost_type()
	{
		return $this->beforeAddField('zones', 'cost_type');
	}

	function afterAddField__zones__cost_type()
	{
		return $this->afterAddField('zones', 'cost_type');
	}

	function beforeAddField__zones__cost_variable_id()
	{
		return $this->beforeAddField('zones', 'cost_variable_id');
	}

	function afterAddField__zones__cost_variable_id()
	{
		return $this->afterAddField('zones', 'cost_variable_id');
	}

	function beforeAddField__zones__technology_cost()
	{
		return $this->beforeAddField('zones', 'technology_cost');
	}

	function afterAddField__zones__technology_cost()
	{
		return $this->afterAddField('zones', 'technology_cost');
	}

	function beforeAddField__zones__technology_cost_type()
	{
		return $this->beforeAddField('zones', 'technology_cost_type');
	}

	function afterAddField__zones__technology_cost_type()
	{
		return $this->afterAddField('zones', 'technology_cost_type');
	}

	function beforeAddField__zones__updated()
	{
		return $this->beforeAddField('zones', 'updated');
	}

	function afterAddField__zones__updated()
	{
		return $this->afterAddField('zones', 'updated');
	}

	function beforeAddField__zones__block()
	{
		return $this->beforeAddField('zones', 'block');
	}

	function afterAddField__zones__block()
	{
		return $this->afterAddField('zones', 'block');
	}

	function beforeAddField__zones__capping()
	{
		return $this->beforeAddField('zones', 'capping');
	}

	function afterAddField__zones__capping()
	{
		return $this->afterAddField('zones', 'capping');
	}

	function beforeAddField__zones__session_capping()
	{
		return $this->beforeAddField('zones', 'session_capping');
	}

	function afterAddField__zones__session_capping()
	{
		return $this->afterAddField('zones', 'session_capping') && $this->migrateData();
	}

	function migrateData()
	{
	    $prefix = $this->getPrefix();
	    $query = "SELECT * FROM {$prefix}zones";
	    $rsZones = DBC::NewRecordSet($query);
	    $result = $rsZones->find();
	    if (PEAR::isError($result)) {
	        return $this->_logErrorAndReturnFalse('Error migrating Zones data during migration 327: '.$result->getUserInfo());
	    }

	    $aZoneAdObjectHandlers = array();
	    while($result = $rsZones->fetch()) {
	        if (PEAR::isError($result)) {
	            return $this->_logErrorAndReturnFalse('Error migrating Zones data during migration 327: '.$result->getUserInfo());
	        }
	        $zonetype = $rsZones->get('zonetype');
	        $what = $rsZones->get('what');
	        $zoneid = $rsZones->get('zoneid');
	        $zoneAdObjectHandler = OA_upgrade_getZoneAdObjectHandler($prefix, $zonetype, $zoneid, $what);
	        if (!$zoneAdObjectHandler) {
	            // Either zonetype 2 - keywords, which shouldn't be modified
	            // or unknown / unused zone type.
	            continue;
	        }
	        $aZoneAdObjectHandlers []= $zoneAdObjectHandler;
	    }

	    foreach ($aZoneAdObjectHandlers as $zoneAdObjectHandler) {
	        $result = $zoneAdObjectHandler->insertAssocs($this->oDBH);
	        if (PEAR::isError($result)) {
	            return $this->_logErrorAndReturnFalse('Error migrating Zones data during migration 327: '.$result->getUserInfo());
	        }
	        if (is_array($result))
	        {
	            foreach ($result as $k => $v)
	            {
	                $this->_log($v);
	            }
	        }
	    }

	    $tableAdZoneAssoc = "{$prefix}ad_zone_assoc";
	    $tablePlacementZoneAssoc = "{$prefix}placement_zone_assoc";
	    $tableBanners = "{$prefix}banners";
	    $tableZones = "{$prefix}zones";

	    $sql = "
	    INSERT INTO $tableAdZoneAssoc (zone_id, ad_id)
	    SELECT zoneid, bannerid
	       FROM $tableBanners b, $tableZones z, $tablePlacementZoneAssoc
    	   WHERE campaignid = placement_id
    	   AND zoneid = zone_id
    	   AND ((delivery = 3 AND storagetype = 'txt')
    	       OR (delivery <> 3 AND storagetype <> 'txt'
    	           AND (z.height < 0 OR z.height = b.height)
    	           AND (z.width < 0 OR z.width = b.width)))";
	    $result = $this->oDBH->exec($sql);
	    if (PEAR::isError($result)) {
	        return $this->_logErrorAndReturnFalse('Error inserting AdZoneAssoc data during migration 327: '.$result->getUserInfo());
	    }

	    $sql = "INSERT INTO $tableAdZoneAssoc (zone_id, ad_id, link_type)
	     SELECT 0 zone_id, bannerid ad_id, 0 link_type FROM $tableBanners";

	    $result = $this->oDBH->exec($sql);
	    if (PEAR::isError($result)) {
	        return $this->_logErrorAndReturnFalse('Error inserting AdZoneAssoc data during migration 327: '.$result->getUserInfo());
	    }
	    return true;
	}
}


function OA_upgrade_getAdObjectIds($sIdList, $adObjectType)
{
    if (empty($sIdList)) {
        return array();
    }
    $aAdObjectIdsHolders = explode(",", $sIdList);
    $aIds = array();
    $idxStart = strlen($adObjectType) + 1;
    foreach ($aAdObjectIdsHolders as $idHolder) {
        $id = substr($idHolder, $idxStart);
        $aIds []= $id;
    }
    return $aIds;
}

function OA_upgrade_getZoneAdObjectHandler($prefix, $zonetype, $zone_id, $sIdList)
{
    if ($zonetype == 0) {
        return new ZoneBannerHandler($prefix, $zone_id, $sIdList);
    }
    else if ($zonetype == 3) {
        return new ZoneCampaignHandler($prefix, $zone_id, $sIdList);
    }
    else {
        return false; // Unknown / unused zone type
    }
}

class ZoneAdObjectHandler
{
    var $zone_id;
    var $aAdObjectIds;
    var $prefix;

    function ZoneAdObjectHandler($prefix, $zone_id, $sIdList, $adObjectType)
    {
        $this->zone_id = $zone_id;
        $this->aAdObjectIds = OA_upgrade_getAdObjectIds($sIdList, $adObjectType);
        $this->prefix = $prefix;
    }

    /**
     * Inserts associations between zone and ad objects (campaign or banner)
     * represented by this handler.
     *
     * @param MDB2_Driver_Common $oDbh
     */
    function insertAssocs($oDbh)
    {
        $assocTable = $this->getAssocTable();
        $adObjectColumn = $this->getAdObjectColumn();
        $result = true;
        foreach($this->aAdObjectIds as $adObjectId) {
            $sql = "
                INSERT INTO {$this->prefix}$assocTable (zone_id, $adObjectColumn)
                VALUES ({$this->zone_id}, $adObjectId)";
            if (is_numeric($adObjectId))
            {
                $result = $oDbh->exec($sql);
                if (PEAR::isError($result)) {
                    return $result;
                }
            }
            else
            {
                $aResult[] = 'Invalid data found during migration_tables_core_127: '.$sql;
            }
            $result = $aResult;
        }
        return true;
    }
}

class ZoneBannerHandler extends ZoneAdObjectHandler
{
    function ZoneBannerHandler($prefix, $zone_id, $sIdList)
    {
        $this->ZoneAdObjectHandler($prefix, $zone_id, $sIdList, 'bannerid');
    }


    function getAssocTable()
    {
        return 'ad_zone_assoc';
    }

    function getAdObjectColumn()
    {
        return 'ad_id';
    }
}

class ZoneCampaignHandler extends ZoneAdObjectHandler
{
    function ZoneCampaignHandler($prefix, $zone_id, $sIdList)
    {
        $this->ZoneAdObjectHandler($prefix, $zone_id, $sIdList, 'campaignid');
    }


    function getAssocTable()
    {
        return 'placement_zone_assoc';
    }

    function getAdObjectColumn()
    {
        return 'placement_id';
    }
}

?>
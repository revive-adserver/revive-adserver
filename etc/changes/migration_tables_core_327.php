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

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_327 extends Migration
{
    public function __construct()
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


        $this->aObjectMap['zones']['category'] = ['fromTable' => 'zones', 'fromField' => 'category'];
        $this->aObjectMap['zones']['ad_selection'] = ['fromTable' => 'zones', 'fromField' => 'ad_selection'];
        $this->aObjectMap['zones']['inventory_forecast_type'] = ['fromTable' => 'zones', 'fromField' => 'inventory_forecast_type'];
        $this->aObjectMap['zones']['comments'] = ['fromTable' => 'zones', 'fromField' => 'comments'];
        $this->aObjectMap['zones']['cost'] = ['fromTable' => 'zones', 'fromField' => 'cost'];
        $this->aObjectMap['zones']['cost_type'] = ['fromTable' => 'zones', 'fromField' => 'cost_type'];
        $this->aObjectMap['zones']['cost_variable_id'] = ['fromTable' => 'zones', 'fromField' => 'cost_variable_id'];
        $this->aObjectMap['zones']['technology_cost'] = ['fromTable' => 'zones', 'fromField' => 'technology_cost'];
        $this->aObjectMap['zones']['technology_cost_type'] = ['fromTable' => 'zones', 'fromField' => 'technology_cost_type'];
        $this->aObjectMap['zones']['updated'] = ['fromTable' => 'zones', 'fromField' => 'updated'];
        $this->aObjectMap['zones']['block'] = ['fromTable' => 'zones', 'fromField' => 'block'];
        $this->aObjectMap['zones']['capping'] = ['fromTable' => 'zones', 'fromField' => 'capping'];
        $this->aObjectMap['zones']['session_capping'] = ['fromTable' => 'zones', 'fromField' => 'session_capping'];
    }



    public function beforeAddField__zones__category()
    {
        return $this->beforeAddField('zones', 'category');
    }

    public function afterAddField__zones__category()
    {
        return $this->afterAddField('zones', 'category');
    }

    public function beforeAddField__zones__ad_selection()
    {
        return $this->beforeAddField('zones', 'ad_selection');
    }

    public function afterAddField__zones__ad_selection()
    {
        return $this->afterAddField('zones', 'ad_selection');
    }

    public function beforeAddField__zones__inventory_forecast_type()
    {
        return $this->beforeAddField('zones', 'inventory_forecast_type');
    }

    public function afterAddField__zones__inventory_forecast_type()
    {
        return $this->afterAddField('zones', 'inventory_forecast_type');
    }

    public function beforeAddField__zones__comments()
    {
        return $this->beforeAddField('zones', 'comments');
    }

    public function afterAddField__zones__comments()
    {
        return $this->afterAddField('zones', 'comments');
    }

    public function beforeAddField__zones__cost()
    {
        return $this->beforeAddField('zones', 'cost');
    }

    public function afterAddField__zones__cost()
    {
        return $this->afterAddField('zones', 'cost');
    }

    public function beforeAddField__zones__cost_type()
    {
        return $this->beforeAddField('zones', 'cost_type');
    }

    public function afterAddField__zones__cost_type()
    {
        return $this->afterAddField('zones', 'cost_type');
    }

    public function beforeAddField__zones__cost_variable_id()
    {
        return $this->beforeAddField('zones', 'cost_variable_id');
    }

    public function afterAddField__zones__cost_variable_id()
    {
        return $this->afterAddField('zones', 'cost_variable_id');
    }

    public function beforeAddField__zones__technology_cost()
    {
        return $this->beforeAddField('zones', 'technology_cost');
    }

    public function afterAddField__zones__technology_cost()
    {
        return $this->afterAddField('zones', 'technology_cost');
    }

    public function beforeAddField__zones__technology_cost_type()
    {
        return $this->beforeAddField('zones', 'technology_cost_type');
    }

    public function afterAddField__zones__technology_cost_type()
    {
        return $this->afterAddField('zones', 'technology_cost_type');
    }

    public function beforeAddField__zones__updated()
    {
        return $this->beforeAddField('zones', 'updated');
    }

    public function afterAddField__zones__updated()
    {
        return $this->afterAddField('zones', 'updated');
    }

    public function beforeAddField__zones__block()
    {
        return $this->beforeAddField('zones', 'block');
    }

    public function afterAddField__zones__block()
    {
        return $this->afterAddField('zones', 'block');
    }

    public function beforeAddField__zones__capping()
    {
        return $this->beforeAddField('zones', 'capping');
    }

    public function afterAddField__zones__capping()
    {
        return $this->afterAddField('zones', 'capping');
    }

    public function beforeAddField__zones__session_capping()
    {
        return $this->beforeAddField('zones', 'session_capping');
    }

    public function afterAddField__zones__session_capping()
    {
        return $this->afterAddField('zones', 'session_capping') && $this->migrateData();
    }

    public function migrateData()
    {
        $prefix = $this->getPrefix();
        $query = "SELECT * FROM {$prefix}zones";
        $rsZones = DBC::NewRecordSet($query);
        $result = $rsZones->find();
        if (PEAR::isError($result)) {
            return $this->_logErrorAndReturnFalse('Error migrating Zones data during migration 327: ' . $result->getUserInfo());
        }

        $aZoneAdObjectHandlers = [];
        while ($result = $rsZones->fetch()) {
            if (PEAR::isError($result)) {
                return $this->_logErrorAndReturnFalse('Error migrating Zones data during migration 327: ' . $result->getUserInfo());
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
            $aZoneAdObjectHandlers [] = $zoneAdObjectHandler;
        }

        /** @var ZoneAdObjectHandler $zoneAdObjectHandler */
        foreach ($aZoneAdObjectHandlers as $zoneAdObjectHandler) {
            $result = $zoneAdObjectHandler->insertAssocs($this->oDBH);
            if (PEAR::isError($result)) {
                return $this->_logErrorAndReturnFalse('Error migrating Zones data during migration 327: ' . $result->getUserInfo());
            }
            if (is_array($result)) {
                foreach ($result as $k => $v) {
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
            return $this->_logErrorAndReturnFalse('Error inserting AdZoneAssoc data during migration 327: ' . $result->getUserInfo());
        }

        $sql = "INSERT INTO $tableAdZoneAssoc (zone_id, ad_id, link_type)
	     SELECT 0 zone_id, bannerid ad_id, 0 link_type FROM $tableBanners";

        $result = $this->oDBH->exec($sql);
        if (PEAR::isError($result)) {
            return $this->_logErrorAndReturnFalse('Error inserting AdZoneAssoc data during migration 327: ' . $result->getUserInfo());
        }
        return true;
    }
}


function OA_upgrade_getAdObjectIds($sIdList, $adObjectType)
{
    if (empty($sIdList)) {
        return [];
    }
    $aAdObjectIdsHolders = explode(",", $sIdList);
    $aIds = [];
    $idxStart = strlen($adObjectType) + 1;
    foreach ($aAdObjectIdsHolders as $idHolder) {
        $id = substr($idHolder, $idxStart);
        $aIds [] = $id;
    }
    return $aIds;
}

function OA_upgrade_getZoneAdObjectHandler($prefix, $zonetype, $zone_id, $sIdList)
{
    if ($zonetype == 0) {
        return new ZoneBannerHandler($prefix, $zone_id, $sIdList);
    } elseif ($zonetype == 3) {
        return new ZoneCampaignHandler($prefix, $zone_id, $sIdList);
    } else {
        return false; // Unknown / unused zone type
    }
}

class ZoneAdObjectHandler
{
    public $zone_id;
    public $aAdObjectIds;
    public $prefix;

    public function __construct($prefix, $zone_id, $sIdList, $adObjectType)
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
     *
     * @return true|string[] True or array of error strings
     */
    public function insertAssocs($oDbh)
    {
        $assocTable = $oDbh->quoteIdentifier($this->prefix . $this->getAssocTable(), true);
        $adObjectColumn = $this->getAdObjectColumn();
        $aErrors = [];
        foreach ($this->aAdObjectIds as $adObjectId) {
            if (is_numeric($adObjectId)) {
                $sql = "
                    INSERT INTO {$assocTable} (zone_id, $adObjectColumn)
                    VALUES ({$this->zone_id}, $adObjectId)";
                $result = $oDbh->exec($sql);
                if (PEAR::isError($result)) {
                    return $result;
                }
            } else {
                $aErrors[] = "Invalid data found during migration_tables_core_327: '{$adObjectId}'";
            }
        }

        return count($aErrors) ? $aErrors : true;
    }
}

class ZoneBannerHandler extends ZoneAdObjectHandler
{
    public function __construct($prefix, $zone_id, $sIdList)
    {
        parent::__construct($prefix, $zone_id, $sIdList, 'bannerid');
    }


    public function getAssocTable()
    {
        return 'ad_zone_assoc';
    }

    public function getAdObjectColumn()
    {
        return 'ad_id';
    }
}

class ZoneCampaignHandler extends ZoneAdObjectHandler
{
    public function __construct($prefix, $zone_id, $sIdList)
    {
        parent::__construct($prefix, $zone_id, $sIdList, 'campaignid');
    }


    public function getAssocTable()
    {
        return 'placement_zone_assoc';
    }

    public function getAdObjectColumn()
    {
        return 'placement_id';
    }
}

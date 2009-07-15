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

/**
 * Table Definition for zones
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Zones extends DB_DataObjectCommon
{
    var $onDeleteCascade = true;
    var $dalModelName = 'zones';
    var $refreshUpdatedFieldIfExists = true;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'zones';                           // table name
    public $zoneid;                          // MEDIUMINT(9) => openads_mediumint => 129 
    public $affiliateid;                     // MEDIUMINT(9) => openads_mediumint => 1 
    public $zonename;                        // VARCHAR(245) => openads_varchar => 130 
    public $description;                     // VARCHAR(255) => openads_varchar => 130 
    public $delivery;                        // SMALLINT(6) => openads_smallint => 129 
    public $zonetype;                        // SMALLINT(6) => openads_smallint => 129 
    public $category;                        // TEXT() => openads_text => 162 
    public $width;                           // SMALLINT(6) => openads_smallint => 129 
    public $height;                          // SMALLINT(6) => openads_smallint => 129 
    public $ad_selection;                    // TEXT() => openads_text => 162 
    public $chain;                           // TEXT() => openads_text => 162 
    public $prepend;                         // TEXT() => openads_text => 162 
    public $append;                          // TEXT() => openads_text => 162 
    public $appendtype;                      // TINYINT(4) => openads_tinyint => 129 
    public $forceappend;                     // ENUM('t','f') => openads_enum => 2 
    public $inventory_forecast_type;         // SMALLINT(6) => openads_smallint => 129 
    public $comments;                        // TEXT() => openads_text => 34 
    public $cost;                            // DECIMAL(10,4) => openads_decimal => 1 
    public $cost_type;                       // SMALLINT(6) => openads_smallint => 1 
    public $cost_variable_id;                // VARCHAR(255) => openads_varchar => 2 
    public $technology_cost;                 // DECIMAL(10,4) => openads_decimal => 1 
    public $technology_cost_type;            // SMALLINT(6) => openads_smallint => 1 
    public $updated;                         // DATETIME() => openads_datetime => 142 
    public $block;                           // INT(11) => openads_int => 129 
    public $capping;                         // INT(11) => openads_int => 129 
    public $session_capping;                 // INT(11) => openads_int => 129 
    public $what;                            // TEXT() => openads_text => 162 
    public $as_zone_id;                      // INT(11) => openads_int => 1 
    public $is_in_ad_direct;                 // TINYINT(1) => openads_tinyint => 145 
    public $rate;                            // DECIMAL(19,2) => openads_decimal => 1 
    public $pricing;                         // VARCHAR(50) => openads_varchar => 130 
    public $oac_category_id;                 // INT(11) => openads_int => 1 
    public $ext_adselection;                 // VARCHAR(255) => openads_varchar => 130 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Zones',$k,$v); }

    var $defaultValues = array(
                'zonename' => '',
                'description' => '',
                'delivery' => 0,
                'zonetype' => 0,
                'category' => '',
                'width' => 0,
                'height' => 0,
                'ad_selection' => '',
                'chain' => '',
                'prepend' => '',
                'append' => '',
                'appendtype' => 0,
                'forceappend' => 'f',
                'inventory_forecast_type' => 0,
                'updated' => '%DATE_TIME%',
                'block' => 0,
                'capping' => 0,
                'session_capping' => 0,
                'what' => '',
                'is_in_ad_direct' => 0,
                'pricing' => 'CPM',
                'ext_adselection' => '',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    /**
     * ON DELETE CASCADE is handled by parent class but we have
     * to also make sure here that we are handling here:
     * - zone chaining
     * - zone appending
     *
     * @param boolean $useWhere
     * @param boolean $cascadeDelete
     * @return boolean
     * @see DB_DataObjectCommon::delete()
     */
    function delete($useWhere = false, $cascadeDelete = true, $parentid = null)
    {
    	// Handle all "appended" zones
    	$doZones = $this->factory('zones');
    	$doZones->init();
    	$doZones->appendtype = phpAds_ZoneAppendZone;
    	$doZones->whereAdd("append LIKE '%zone:".$this->zoneid."%'");
    	$doZones->find();

    	while($doZones->fetch()) {
			$doZoneUpdate = clone($doZones);
			$doZoneUpdate->appendtype = phpAds_ZoneAppendRaw;
			$doZoneUpdate->append = '';
			$doZoneUpdate->update();
    	}

    	// Handle all "chained" zones
    	$doZones = $this->factory('zones');
    	$doZones->init();
    	$doZones->chain = 'zone:'.$this->zoneid;
    	$doZones->find();

    	while($doZones->fetch()) {
			$doZoneUpdate = clone($doZones);
			$doZoneUpdate->chain = '';
			$doZoneUpdate->update();
    	}

    	return parent::delete($useWhere, $cascadeDelete, $parentid);
    }

    function update()
    {
        return parent::update();
    }

    function insert()
    {
        return parent::insert();
    }

    function duplicate()
    {
        // Get unique name
        $this->zonename = $GLOBALS['strCopyOf'] . ' ' . $this->zonename;

        $this->zoneid = null;
        $newZoneid = $this->insert();
        return $newZoneid;
    }

    function _auditEnabled()
    {
        return true;
    }

    function _getContextId()
    {
        return $this->zoneid;
    }

    function _getContext()
    {
        return 'Zone';
    }

    /**
     * A method to return an array of account IDs of the account(s) that
     * should "own" any audit trail entries for this entity type; these
     * are NOT related to the account ID of the currently active account
     * (which is performing some kind of action on the entity), but is
     * instead related to the type of entity, and where in the account
     * heirrachy the entity is located.
     *
     * @return array An array containing up to three indexes:
     *                  - "OA_ACCOUNT_ADMIN" or "OA_ACCOUNT_MANAGER":
     *                      Contains the account ID of the manager account
     *                      that needs to be able to see the audit trail
     *                      entry, or, the admin account, if the entity
     *                      is a special case where only the admin account
     *                      should see the entry.
     *                  - "OA_ACCOUNT_ADVERTISER":
     *                      Contains the account ID of the advertiser account
     *                      that needs to be able to see the audit trail
     *                      entry, if such an account exists.
     *                  - "OA_ACCOUNT_TRAFFICKER":
     *                      Contains the account ID of the trafficker account
     *                      that needs to be able to see the audit trail
     *                      entry, if such an account exists.
     */
    function getOwningAccountIds()
    {
        // Zones don't have an account_id, get it from the parent
        // website account (stored in the "affiliates" table) using
        // the "affiliateid" key
        return parent::getOwningAccountIds('affiliates', 'affiliateid');
    }

    /**
     * build a campaign specific audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc']   = $this->zonename;
        switch ($actionid)
        {
            case OA_AUDIT_ACTION_UPDATE:
                        if (!$this->affiliateid)
                        {
                            $this->find(true);
                        }
                        $aAuditFields['affiliateid']    = $this->affiliateid;
                        break;
        }
    }

}

?>
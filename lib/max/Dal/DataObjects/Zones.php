<?php
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

    var $__table = 'zones';                           // table name
    var $zoneid;                          // int(9)  not_null primary_key auto_increment
    var $affiliateid;                     // int(9)  multiple_key
    var $zonename;                        // string(245)  not_null multiple_key
    var $description;                     // string(255)  not_null
    var $delivery;                        // int(6)  not_null
    var $zonetype;                        // int(6)  not_null
    var $category;                        // blob(65535)  not_null blob
    var $width;                           // int(6)  not_null
    var $height;                          // int(6)  not_null
    var $ad_selection;                    // blob(65535)  not_null blob
    var $chain;                           // blob(65535)  not_null blob
    var $prepend;                         // blob(65535)  not_null blob
    var $append;                          // blob(65535)  not_null blob
    var $appendtype;                      // int(4)  not_null
    var $forceappend;                     // string(1)  enum
    var $inventory_forecast_type;         // int(6)  not_null
    var $comments;                        // blob(65535)  blob
    var $cost;                            // real(12)  
    var $cost_type;                       // int(6)  
    var $cost_variable_id;                // string(255)  
    var $technology_cost;                 // real(12)  
    var $technology_cost_type;            // int(6)  
    var $updated;                         // datetime(19)  not_null binary
    var $block;                           // int(11)  not_null
    var $capping;                         // int(11)  not_null
    var $session_capping;                 // int(11)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Zones',$k,$v); }

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
    function delete($useWhere = false, $cascadeDelete = true)
    {
    	// Handle all "appended" zones
    	$doZones = $this->factory('zones');
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
    	$doZones->chain = 'zone:'.$this->zoneid;
    	$doZones->find();
    	
    	while($doZones->fetch()) {
			$doZoneUpdate = clone($doZones);
			$doZoneUpdate->chain = '';
			$doZoneUpdate->update();
    	}
    	
    	return parent::delete($useWhere, $cascadeDelete);
    }
    
    function duplicate()
    {
        // Get unique name
        $this->zonename = $this->getUniqueNameForDuplication('zonename');
        
        $this->zoneid = null;
        $newZoneid = $this->insert();
        return $newZoneid;
    }
    
}

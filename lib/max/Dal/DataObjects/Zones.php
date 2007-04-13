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

    public $__table = 'zones';                           // table name
    public $zoneid;                          // int(9)  not_null primary_key auto_increment
    public $affiliateid;                     // int(9)  multiple_key
    public $zonename;                        // string(245)  not_null multiple_key
    public $description;                     // string(255)  not_null
    public $delivery;                        // int(6)  not_null
    public $zonetype;                        // int(6)  not_null
    public $category;                        // blob(65535)  not_null blob
    public $width;                           // int(6)  not_null
    public $height;                          // int(6)  not_null
    public $ad_selection;                    // blob(65535)  not_null blob
    public $chain;                           // blob(65535)  not_null blob
    public $prepend;                         // blob(65535)  not_null blob
    public $append;                          // blob(65535)  not_null blob
    public $appendtype;                      // int(4)  not_null
    public $forceappend;                     // string(1)  enum
    public $inventory_forecast_type;         // int(6)  not_null
    public $comments;                        // blob(65535)  blob
    public $cost;                            // real(12)  
    public $cost_type;                       // int(6)  
    public $cost_variable_id;                // string(255)  
    public $technology_cost;                 // real(12)  
    public $technology_cost_type;            // int(6)  
    public $updated;                         // datetime(19)  not_null binary
    public $block;                           // int(11)  not_null
    public $capping;                         // int(11)  not_null
    public $session_capping;                 // int(11)  not_null

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

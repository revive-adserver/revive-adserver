<?php
/**
 * Table Definition for ext_market_zone_pref
 */
require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

class DataObjects_Ext_market_zone_pref extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ext_market_zone_pref';            // table name
    public $zoneid;                          // MEDIUMINT(9) => openads_mediumint => 129 
    public $is_enabled;                      // TINYINT(1) => openads_tinyint => 17 
    public $original_chain;                  // TEXT() => openads_text => 162 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ext_market_zone_pref',$k,$v); }

    var $defaultValues = array(
                'is_enabled' => 0,
                'original_chain' => '',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
	
	/**
	* Table has no autoincrement/sequence so we override sequenceKey().
	*
	* @return array
	*/
	function sequenceKey() {
        return array(false, false, false);
    }

    function _auditEnabled()
    {
        return false;
    }
    
    
    /**
     * Updates zone's market opt in status to the given one.
     * 
     * @param int $zoneId 
     * @package boolean $optedIn indicates whether this zone has market enabled
     * @return DataObjects_Ext_market_zone_pref or false if zone doesn't exist
     */
    function updateZoneStatus($zoneId, $optedIn)
    {
        $doZones = OA_Dal::factoryDO('zones');
        if ($doZones->get($zoneId) == 0) {
            return false; // do not opt in not existings zones (e.g. deleted)
        }
        
        $oExt_market_zone_pref = OA_Dal::factoryDO('ext_market_zone_pref');
        $recordExist = (bool)($oExt_market_zone_pref->get($zoneId));
        $oExt_market_zone_pref->is_enabled = $optedIn == true ? 1 : 0;
        
        if ($optedIn) {
            $originalChain = $doZones->chain; 
            $doZones->chain = ''; //clear the chain
            $oExt_market_zone_pref->original_chain = $originalChain; 
        }
        else if ($recordExist) {
            $doZones->chain = $oExt_market_zone_pref->original_chain;    
        }
        $doZones->update();
        
        if ($recordExist) {
            $oExt_market_zone_pref->update();
        } 
        else {
            $oExt_market_zone_pref->insert();
        }
        
        return $oExt_market_zone_pref;
    }    
}
?>
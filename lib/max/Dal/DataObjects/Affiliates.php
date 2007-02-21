<?php
/**
 * Table Definition for affiliates (Affiliate is often called Publisher)
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Affiliates extends DB_DataObjectCommon 
{
    var $onDeleteCascade = true;
    
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'affiliates';                      // table name
    var $affiliateid;                     // int(9)  not_null primary_key auto_increment
    var $agencyid;                        // int(9)  not_null multiple_key
    var $name;                            // string(255)  not_null
    var $mnemonic;                        // string(5)  not_null
    var $comments;                        // blob(65535)  blob
    var $contact;                         // string(255)  
    var $email;                           // string(64)  not_null
    var $website;                         // string(255)  
    var $username;                        // string(64)  
    var $password;                        // string(64)  
    var $permissions;                     // int(9)  
    var $language;                        // string(64)  
    var $publiczones;                     // string(1)  not_null enum
    var $last_accepted_agency_agreement;    // datetime(19)  binary
    var $updated;                         // datetime(19)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Affiliates',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    /**
     * Check if affiliate exists
     *
     * @param int $affiliateId
     * @param int $agencyId
     * @return boolean
     */
    function affiliateExists($affiliateId, $agencyId = null)
    {
        $this->affiliateid = $affiliateId;
        if ($agencyId !== null) {
            $this->agencyid = $agencyId;
        }
        
        return (bool) ($this->count() > 0);
    }
    
    function delete($useWhere = false, $cascadeDelete = true)
    {
    	// get all zones ids
    	$doZone = DB_DataObject::factory('zones');
    	$doZone->affiliateid = $this->affiliateid;
    	$doZone->find();
    	$aZonesIds = array();
    	while ($doZone->find()) {
    		$aZonesIds[] = $doZone->zoneid;
    	}
    	
    	$doZone = DB_DataObject::factory('zones');
    	$doZone->appendtype = phpAds_ZoneAppendZone;
    	$doZone->whereAdd('affiliateid <> ' . $this->affiliateid);
    	$doZone->find();
    	
    	while($doZone->fetch()) {
    		$append = phpAds_ZoneParseAppendCode($doZone->append);
    		if (in_array($append[0]['zoneid'], $aZonesIds)) {
    			$doZoneUpdate = DB_DataObject::factory('zones');
    			$doZoneUpdate->get($append[0]['zoneid']);
    			
    			$doZoneUpdate->appendtype = phpAds_ZoneAppendRaw;
    			$doZoneUpdate->append = '';
    			$doZoneUpdate->update();
    		}
    	}
    	
    	return parent::delete($useWhere, $cascadeDelete);
    }
}

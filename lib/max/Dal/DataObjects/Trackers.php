<?php
/**
 * Table Definition for trackers
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Trackers extends DB_DataObjectCommon 
{
    var $onDeleteCascade = true;
    var $refreshUpdatedFieldIfExists = true;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'trackers';                        // table name
    var $trackerid;                       // int(9)  not_null primary_key auto_increment
    var $trackername;                     // string(255)  not_null
    var $description;                     // string(255)  not_null
    var $clientid;                        // int(9)  not_null multiple_key
    var $viewwindow;                      // int(9)  not_null
    var $clickwindow;                     // int(9)  not_null
    var $blockwindow;                     // int(9)  not_null
    var $status;                          // int(1)  not_null unsigned
    var $type;                            // int(1)  not_null unsigned
    var $linkcampaigns;                   // string(1)  not_null enum
    var $variablemethod;                  // string(7)  not_null enum
    var $appendcode;                      // blob(65535)  not_null blob
    var $updated;                         // datetime(19)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Trackers',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    function duplicate()
    {
        // Get unique name
        $this->trackername = $this->getUniqueNameForDuplication('trackername');
        
        $this->trackerid = null;
        $newTrackerid = $this->insert();
        if (!$newTrackerid) {
            return $newTrackerid;
        }
        
        // Copy any linked campaigns
        $doCampaign_trackers = $this->factory('campaigns_trackers');
        $doCampaign_trackers->trackerid = $this->trackerid;
        $doCampaign_trackers->find();
        while ($doCampaign_trackers->fetch()) {
            $doCampaign_trackersClone = clone($doCampaign_trackers);
            $doCampaign_trackersClone->campaign_tracker_id = null;
            $doCampaign_trackersClone->tracker_id = $newTrackerid;
            $doCampaign_trackersClone->insert();
        }
        
        // Copy any variables
        $doVariables = $this->factory('variables');
        $doVariables->trackerid = $this->trackerid;
        $doVariables->find();
        while ($doVariables->fetch()) {
            $doVariablesClone = clone($doVariables);
            $doVariablesClone->vriableid = null;
            $doVariablesClone->trackerid = $newTrackerid;
            $doVariablesClone->insert();
        }
        
        return $newTrackerid;
    }
}

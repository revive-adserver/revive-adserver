<?php
/**
 * Table Definition for campaigns
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Campaigns extends DB_DataObjectCommon 
{
    var $onDeleteCascade = true;
    var $dalModelName = 'Campaigns';
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'campaigns';                       // table name
    var $campaignid;                      // int(9)  not_null primary_key auto_increment
    var $campaignname;                    // string(255)  not_null
    var $clientid;                        // int(9)  not_null multiple_key
    var $views;                           // int(11)  
    var $clicks;                          // int(11)  
    var $conversions;                     // int(11)  
    var $expire;                          // date(10)  binary
    var $activate;                        // date(10)  binary
    var $active;                          // string(1)  not_null enum
    var $priority;                        // int(11)  not_null
    var $weight;                          // int(4)  not_null
    var $target_impression;               // int(11)  not_null
    var $target_click;                    // int(11)  not_null
    var $target_conversion;               // int(11)  not_null
    var $anonymous;                       // string(1)  not_null enum
    var $companion;                       // int(1)  
    var $comments;                        // blob(65535)  blob
    var $revenue;                         // unknown(12)  
    var $revenue_type;                    // int(6)  
    var $updated;                         // datetime(19)  not_null binary
    var $block;                           // int(11)  not_null
    var $capping;                         // int(11)  not_null
    var $session_capping;                 // int(11)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Campaigns',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    function insert()
    {
        $id = parent::insert();
        if (!$id) {
            return $id;
        }
        
        // Initalise any tracker based plugins
        $plugins = array();
        $invocationPlugins = &MAX_Plugin::getPlugins('invocationTags');
        foreach($invocationPlugins as $pluginKey => $plugin) {
            if ($plugin->trackerEvent) {
                $plugins[] = $plugin;
            }
        }

        $doTrackers = $this->factory('trackers');
        $doTrackers->clientid = $this->clientid;
        $doTrackers->linkcampaigns = 't';
        $doTrackers->find();

        while ($doTrackers->fetch()) {
            $doCampaign_trackers = $this->factory('campaigns_trackers');
            
            $doCampaign_trackers->trackerid = $doTrackers->trackerid;
            $doCampaign_trackers->campaignid = $this->campaignid;
            $doCampaign_trackers->clickwindow = $doTrackers->clickwindow;
            $doCampaign_trackers->viewwindow = $doTrackers->viewwindow;
            $doCampaign_trackers->status = $doTrackers->status;
            foreach ($plugins as $plugin) {
                $fieldName = strtolower($plugin->trackerEvent);
                $doCampaign_trackers->$fieldName = $doTrackers->$fieldName;
            }
            $doCampaign_trackers->insert();
        }
        
        return $id;
    }
}

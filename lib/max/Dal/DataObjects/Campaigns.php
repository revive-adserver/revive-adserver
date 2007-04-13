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

    public $__table = 'campaigns';                       // table name
    public $campaignid;                      // int(9)  not_null primary_key auto_increment
    public $campaignname;                    // string(255)  not_null
    public $clientid;                        // int(9)  not_null multiple_key
    public $views;                           // int(11)  
    public $clicks;                          // int(11)  
    public $conversions;                     // int(11)  
    public $expire;                          // date(10)  binary
    public $activate;                        // date(10)  binary
    public $active;                          // string(1)  not_null enum
    public $priority;                        // int(11)  not_null
    public $weight;                          // int(4)  not_null
    public $target_impression;               // int(11)  not_null
    public $target_click;                    // int(11)  not_null
    public $target_conversion;               // int(11)  not_null
    public $anonymous;                       // string(1)  not_null enum
    public $companion;                       // int(1)  
    public $comments;                        // blob(65535)  blob
    public $revenue;                         // real(12)  
    public $revenue_type;                    // int(6)  
    public $updated;                         // datetime(19)  not_null binary
    public $block;                           // int(11)  not_null
    public $capping;                         // int(11)  not_null
    public $session_capping;                 // int(11)  not_null

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
            if (!empty($plugin->trackerEvent)) {
                $plugins[] = $plugin;
            }
        }

        // Link automatically any trackers which are marked as "link with any new campaigns"
        $doTrackers = $this->factory('trackers');
        $doTrackers->clientid = $this->clientid;
        $doTrackers->linkcampaigns = 't';
        $doTrackers->find();

        while ($doTrackers->fetch()) {
            $doCampaigns_trackers = $this->factory('campaigns_trackers');
            
            $doCampaigns_trackers->trackerid = $doTrackers->trackerid;
            $doCampaigns_trackers->campaignid = $this->campaignid;
            $doCampaigns_trackers->clickwindow = $doTrackers->clickwindow;
            $doCampaigns_trackers->viewwindow = $doTrackers->viewwindow;
            $doCampaigns_trackers->status = $doTrackers->status;
            foreach ($plugins as $plugin) {
                $fieldName = strtolower($plugin->trackerEvent);
                $doCampaigns_trackers->$fieldName = $doTrackers->$fieldName;
            }
            $doCampaigns_trackers->insert();
        }
        
        return $id;
    }
}

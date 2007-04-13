<?php
/**
 * Table Definition for campaigns_trackers
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Campaigns_trackers extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'campaigns_trackers';              // table name
    public $campaign_trackerid;              // int(9)  not_null primary_key auto_increment
    public $campaignid;                      // int(9)  not_null multiple_key
    public $trackerid;                       // int(9)  not_null multiple_key
    public $viewwindow;                      // int(9)  not_null
    public $clickwindow;                     // int(9)  not_null
    public $status;                          // int(1)  not_null unsigned

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Campaigns_trackers',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

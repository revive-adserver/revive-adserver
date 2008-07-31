<?php
/**
 * Table Definition for banners_demo
 */
require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

class DataObjects_Banners_demo extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'banners_demo';                    // table name
    public $banners_demo_id;                 // MEDIUMINT(9) => openads_mediumint => 129 
    public $banners_demo_desc;               // VARCHAR(16) => openads_varchar => 130 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Banners_demo',$k,$v); }

    var $defaultValues = array(
                'banners_demo_desc' => '',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>
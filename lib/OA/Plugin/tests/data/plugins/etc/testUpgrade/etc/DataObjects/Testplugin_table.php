<?php
/**
 * Table Definition for testplugin_table
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Testplugin_table extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'testplugin_table';                // table name
    public $testplugin_id;                   // int(10)  not_null primary_key unsigned auto_increment
    public $testplugin_desc;                 // string(128)  
    public $updated;                         // datetime(19)  binary
    public $test_newfield;                   // int(4)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Testplugin_table',$k,$v); }

    var $defaultValues = array(
                'test_newfield' => 0,
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

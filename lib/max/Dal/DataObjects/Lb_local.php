<?php
/**
 * Table Definition for lb_local
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Lb_local extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'lb_local';                        // table name
    public $last_run;                        // int(11)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Lb_local',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

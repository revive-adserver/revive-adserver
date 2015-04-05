<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

/**
 * Table Definition for targetstats
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Targetstats extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'targetstats';                     // table name
    public $day;                             // DATE() => openads_date => 134 
    public $campaignid;                      // MEDIUMINT(9) => openads_mediumint => 129 
    public $target;                          // INT(11) => openads_int => 129 
    public $views;                           // INT(11) => openads_int => 129 
    public $modified;                        // TINYINT(4) => openads_tinyint => 129 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGetFromClassName('DataObjects_Targetstats',$k,$v); }

    var $defaultValues = array(
                'day' => '%NO_DATE_TIME%',
                'campaignid' => 0,
                'target' => 0,
                'views' => 0,
                'modified' => 0,
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
}

?>
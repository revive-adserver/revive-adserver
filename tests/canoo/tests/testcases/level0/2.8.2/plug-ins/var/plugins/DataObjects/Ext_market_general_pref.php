<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id: demoUI-page.php 30820 2009-01-13 19:02:17Z andrew.hill $
*/

/**
 * Table Definition for ext_market_general_pref
 */
require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

class DataObjects_Ext_market_general_pref extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ext_market_general_pref';         // table name
    public $account_id;                      // MEDIUMINT(9) => openads_mediumint => 129 
    public $name;                            // VARCHAR(255) => openads_varchar => 130 
    public $value;                           // TEXT() => openads_text => 162 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ext_market_general_pref',$k,$v); }

    var $defaultValues = array(
                'name' => '',
                'value' => '',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
                
    /**
     * This is extended get() method to find preference by account_id and name (pkey) 
     *
     * @param int $account_id
     * @param string $name
     * @return int Number of rows (1 for success)
     */
    function findByAccountIdAndName($account_id, $name)
    {
        $this->account_id = $account_id;
        $this->name = $name;
        $this->find();
        if ($this->fetch()) {
            return 1;
        }
        return 0;
    }
    
    
    /**
     * Get value of given preference for given account_id
     *
     * @param int $account_id
     * @param string $name
     * @return string can return null if preference doesn't exit
     */
    function findAndGetValue($account_id, $name)
    {
        $oGeneralPref = OA_Dal::factoryDO('ext_market_general_pref');
        if ($oGeneralPref->findByAccountIdAndName($account_id, $name)>0) {
            return $oGeneralPref->value;
        }
        return null;
    }
    
    
    /**
     * Set value for given account_id, preference pair
     *
     * @param int $account_id
     * @param string $name
     * @param string $value
     * @return bool true on success
     */
    function insertOrUpdateValue($account_id, $name, $value)
    {
        $oGeneralPref = OA_Dal::factoryDO('ext_market_general_pref');
        $count = $oGeneralPref->findByAccountIdAndName($account_id, $name);
        $oGeneralPref->value = (string)$value;
        if ($count>0) {
            if ($oGeneralPref->update()=== false){
                return false;
            }
        } else {
            $oGeneralPref->insert();
        }
        return true;
    }
}
?>
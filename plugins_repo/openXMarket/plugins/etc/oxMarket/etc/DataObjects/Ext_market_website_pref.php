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
 * Table Definition for ext_market_website_pref
 */
require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';
require_once MAX_PATH.'/lib/max/Dal/DataObjects/Accounts.php';

class DataObjects_Ext_market_website_pref extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ext_market_website_pref';         // table name
    public $affiliateid;                     // MEDIUMINT(9) => openads_mediumint => 129
    public $website_id;                      // CHAR(36) => openads_char => 130
    public $is_url_synchronized;             // ENUM('t','f') => openads_enum => 2

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ext_market_website_pref',$k,$v); }

    var $defaultValues = array(
                'affiliateid' => 0,
                'website_id' => '',
                'is_url_synchronized' => 't',
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

    function _auditEnabled()
    {
        return false;
    }
    
    /**
     * Get array of website_id stored in database 
     *
     * @param int $accountId manager or admin account (for admin account all websites are returned)
     * @return array of strings (website Ids)
     */
    function getRegisteredWebsitesIds($accountId)
    {
        if (isset($accountId) && 
            $accountId !== DataObjects_Accounts::getAdminAccountId())
        {
            $agency = OA_Dal::factoryDO('agency');
            $agency->account_id = $accountId;
            $affiliates = OA_Dal::factoryDO('affiliates');
            $affiliates->joinAdd($agency);
            $this->joinAdd($affiliates);
        }
        $this->selectAdd();
        $this->selectAdd('website_id');
        return $this->getAll();
    }
}
?>

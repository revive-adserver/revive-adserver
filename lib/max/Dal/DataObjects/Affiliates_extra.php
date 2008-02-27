<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
$Id$
*/

/**
 * Table Definition for affiliates_extra
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Affiliates_extra extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'affiliates_extra';                // table name
    var $affiliateid;                     // int(9)  not_null primary_key
    var $address;                         // blob(65535)  blob
    var $city;                            // string(255)
    var $postcode;                        // string(64)
    var $country;                         // string(255)
    var $phone;                           // string(64)
    var $fax;                             // string(64)
    var $account_contact;                 // string(255)
    var $payee_name;                      // string(255)
    var $tax_id;                          // string(64)
    var $mode_of_payment;                 // string(64)
    var $currency;                        // string(64)
    var $unique_users;                    // int(11)
    var $unique_views;                    // int(11)
    var $page_rank;                       // int(11)
    var $category;                        // string(255)
    var $help_file;                       // string(255)

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Affiliates_extra',$k,$v); }

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
        return true;
    }

    function _getContextId()
    {
        return $this->affiliateid;
    }

    function _getContext()
    {
        return 'Affiliate Extra';
    }

    /**
     * A private method to return the account ID of the
     * account that should "own" audit trail entries for
     * this entity type; NOT related to the account ID
     * of the currently active account performing an
     * action.
     *
     * @return integer The account ID to insert into the
     *                 "account_id" column of the audit trail
     *                 database table.
     */
    function getOwningAccountId()
    {
        return $this->_getOwningAccountIdFromParent('affiliates', 'affiliateid');
    }

    /**
     * build an affiliates specific audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc']       = '';
    }

}

?>
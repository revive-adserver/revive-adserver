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

    public $__table = 'affiliates_extra';                // table name
    public $affiliateid;                     // MEDIUMINT(9) => openads_mediumint => 129 
    public $address;                         // TEXT() => openads_text => 34 
    public $city;                            // VARCHAR(255) => openads_varchar => 2 
    public $postcode;                        // VARCHAR(64) => openads_varchar => 2 
    public $country;                         // VARCHAR(255) => openads_varchar => 2 
    public $phone;                           // VARCHAR(64) => openads_varchar => 2 
    public $fax;                             // VARCHAR(64) => openads_varchar => 2 
    public $account_contact;                 // VARCHAR(255) => openads_varchar => 2 
    public $payee_name;                      // VARCHAR(255) => openads_varchar => 2 
    public $tax_id;                          // VARCHAR(64) => openads_varchar => 2 
    public $mode_of_payment;                 // VARCHAR(64) => openads_varchar => 2 
    public $currency;                        // VARCHAR(64) => openads_varchar => 2 
    public $unique_users;                    // INT(11) => openads_int => 1 
    public $unique_views;                    // INT(11) => openads_int => 1 
    public $page_rank;                       // INT(11) => openads_int => 1 
    public $category;                        // VARCHAR(255) => openads_varchar => 2 
    public $help_file;                       // VARCHAR(255) => openads_varchar => 2 

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
     * A method to return an array of account IDs of the account(s) that
     * should "own" any audit trail entries for this entity type; these
     * are NOT related to the account ID of the currently active account
     * (which is performing some kind of action on the entity), but is
     * instead related to the type of entity, and where in the account
     * heirrachy the entity is located.
     *
     * @return array An array containing up to three indexes:
     *                  - "OA_ACCOUNT_ADMIN" or "OA_ACCOUNT_MANAGER":
     *                      Contains the account ID of the manager account
     *                      that needs to be able to see the audit trail
     *                      entry, or, the admin account, if the entity
     *                      is a special case where only the admin account
     *                      should see the entry.
     *                  - "OA_ACCOUNT_ADVERTISER":
     *                      Contains the account ID of the advertiser account
     *                      that needs to be able to see the audit trail
     *                      entry, if such an account exists.
     *                  - "OA_ACCOUNT_TRAFFICKER":
     *                      Contains the account ID of the trafficker account
     *                      that needs to be able to see the audit trail
     *                      entry, if such an account exists.
     */
    function getOwningAccountIds()
    {
        // Extra "affiliate" info doesn't have an account_id, get it
        // from the parent advertiser account (stored in the "affiliates"
        // table) using the "affiliateid" key
        return parent::getOwningAccountIds('affiliates', 'affiliateid');
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
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
 * Table Definition for placement_zone_assoc
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Placement_zone_assoc extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'placement_zone_assoc';            // table name
    public $placement_zone_assoc_id;         // MEDIUMINT(9) => openads_mediumint => 129
    public $zone_id;                         // MEDIUMINT(9) => openads_mediumint => 1
    public $placement_id;                    // MEDIUMINT(9) => openads_mediumint => 1

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGetFromClassName('DataObjects_Placement_zone_assoc',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    function _auditEnabled()
    {
        return true;
    }

    function _getContextId()
    {
        return $this->placement_zone_assoc_id;
    }

    function _getContext()
    {
        return 'Campaign Zone Association';
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
    public function getOwningAccountIds($resetCache = false)
    {
        // Placement/zone associations are a special case, as both the
        // advertiser and the website accounts should be able to see
        // the audit entries, so the results of two calls need to be
        // merged
        $aAdvertiserAccountIds = array();
        if (!empty($this->placement_id)) {
            // Placement/zone assocs don't have an account_id, get it from
            // the parent campaign (stored in the "campaigns" table) using
            // the "placement_id" key
            $aAdvertiserAccountIds = $this->_getOwningAccountIds('campaigns', 'placement_id');
        }
        $aWebsiteAccountIds = array();
        if (!empty($this->zone_id)) {
            // Placement/zone assocs don't have an account_id, get it from
            // the parent zone (stored in the "zones" table) using
            // the "zone_id" key
            $aWebsiteAccountIds = $this->_getOwningAccountIds('zones', 'zone_id');
        }
        // Check that the manager account IDs match from the two results
        if (isset($aAdvertiserAccountIds[OA_ACCOUNT_MANAGER]) && isset($aWebsiteAccountIds[OA_ACCOUNT_MANAGER])) {
            if ($aAdvertiserAccountIds[OA_ACCOUNT_MANAGER] != $aWebsiteAccountIds[OA_ACCOUNT_MANAGER]) {
                $message = "Cannot locate owning account IDs for ad/zone association, as manager account IDs, " .
                            "do not match, where ad ID was {$this->ad_id} and zone ID was {$this->zone_id}.";
                MAX::raiseError($message, PEAR_LOG_ERR);
            }
        }
        // Merge the arrays and return
        $aResult = array_merge($aAdvertiserAccountIds, $aWebsiteAccountIds);
        return $aResult;
    }

    /**
     * build an agency specific audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc']     = 'Campaign #'.$this->placement_id.' -> Zone #'.$this->zone_id;
    }

}

?>
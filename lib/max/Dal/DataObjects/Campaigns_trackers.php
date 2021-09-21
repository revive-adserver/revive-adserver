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
 * Table Definition for campaigns_trackers
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Campaigns_trackers extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'campaigns_trackers';              // table name
    public $campaign_trackerid;              // MEDIUMINT(9) => openads_mediumint => 129
    public $campaignid;                      // MEDIUMINT(9) => openads_mediumint => 129
    public $trackerid;                       // MEDIUMINT(9) => openads_mediumint => 129
    public $status;                          // SMALLINT(1) => openads_smallint => 145

    /* Static get */
    public static function staticGet($k, $v = null)
    {
        return DB_DataObject::staticGetFromClassName('DataObjects_Campaigns_trackers', $k, $v);
    }

    public $defaultValues = [
        'campaignid' => 0,
        'trackerid' => 0,
        'status' => 1,
    ];

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    public function _auditEnabled()
    {
        return true;
    }

    public function _getContextId()
    {
        return $this->campaign_trackerid;
    }

    public function _getContext()
    {
        return 'Campaign Tracker';
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
        // Campaign trackers don't have an account_id, get it from
        // the parent tracker (stored in the "trackers" table) using
        // the "trackerid" key -- note, this could equally be done
        // via the parent campaign, but the end result is the same
        return $this->_getOwningAccountIds('trackers', 'trackerid');
    }

    /**
     * build a campaign-trackers specific audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    public function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc'] = 'Campaign #' . $this->campaignid . ' -> Tracker #' . $this->trackerid;
        switch ($actionid) {
            case OA_AUDIT_ACTION_UPDATE:
                        $aAuditFields['campaignid'] = $this->campaignid;
                        break;
        }
    }
}

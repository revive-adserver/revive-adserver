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
 * @package    OpenadsDll
 */

// Require the following classes:
require_once 'Date.php';

require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Audit.php';
require_once MAX_PATH . '/lib/max/language/Loader.php';
require_once MAX_PATH . '/lib/max/other/lib-userlog.inc.php';
Language_Loader::load('default');
Language_Loader::load('userlog');

/**
 * The OA_Dll_Audit class extends the OA_Dll class.
 *
 */
class OA_Dll_Audit extends OA_Dll
{
    /**
     * Retrieves audit data for the selected context type
     *
     * @param int $auditId Audit ID
     * @return array assoc array containing audit data
     */
    public function getAuditDetail($auditId)
    {
        $oAudit = OA_Dal::factoryDO('audit');
        $oAudit->get($auditId);

        $oAudit->details = unserialize($oAudit->details);
        $aAudit = $oAudit->toArray();
        $aAudit['name'] = $aAudit['details']['key_desc'] ?? null;
        $aAudit['contextDescription'] = $this->getContextDescription($aAudit['context']);
        unset($aAudit['details']['key_desc']);

        // remove parent context id
        $this->_removeParentContextId($aAudit);

        //  get children details
        if ($this->hasChildren($aAudit['auditid'], $aAudit['context'])) {
            $aAudit['children'] = $this->getChildren($aAudit['auditid'], $aAudit['context']);
        }

        $aAudit['action'] = $this->getActionName($aAudit['actionid']);

        return $aAudit;
    }

    /**
     * Gets a log of audit events
     *
     * @param array $aParam An optional associative array containing various parameters to
     *                      filter the audit trail results. Possible keys / values are:
     *
     *                  - account_id                Filter the results by manager account ID.
     *                  - advertiser_account_id     Filter the results by advertiser account ID.
     *                  - website_account_id        Filter the results by website account ID.
     *
     *                  - start_date & end_date     Only display results between dates, in
     *                                              "YYYY-MM-DD" string formats.
     *
     *                  - advertiser_id             Filter the results by advertiser ID.
     *                  - campaign_id               Also filter the results by campaign ID;
     *                                              requires advertiser_id to be set.
     *
     *                  - publisher_id              Filter the results by publisher ID.
     *                  - zone_id                   Also filter the results by zone ID;
     *                                              requires publisher_id to be set.
     *
     *                      NOTE: The advertiser and publisher filtering types cannot be
     *                              combined, if they are, the advertiser filters will
     *                              be used.
     *
     *
     *
     *                  - order                     Set to "down" to have in descending order.
     *                  - listorder                 The audit trail column to order by.
     *
     *                  - startRecord               Record to begin paging?
     *                  - perPage                   Number of items displayed per page?
     *
     * @return array An associative array containing the audit events for the specified parameters
     */
    public function getAuditLog($aParam = null)
    {
        // Prepare the audit trail table DB_DataObject
        $doAudit = OA_Dal::factoryDO('audit');

        // Are there any parameters?
        if (!empty($aParam) && is_array($aParam)) {

            // Check for, and apply, as required, any filters to ensure
            // that the results displayed are those that the current
            // account has access to
            if (!empty($aParam['account_id'])) {
                $where = "account_id = {}";
                $doAudit->account_id = $aParam['account_id'];
            }
            if (!empty($aParam['advertiser_account_id'])) {
                $doAudit->advertiser_account_id = $aParam['advertiser_account_id'];
            }
            if (!empty($aParam['website_account_id'])) {
                $doAudit->website_account_id = $aParam['website_account_id'];
            }

            // Check for, and apply, as required, any filters to ensure
            // that the results displayed are those in the desired date range
            if (!empty($aParam['start_date']) && !empty($aParam['end_date'])) {
                $oStartDate = new Date($aParam['start_date']);
                $oStartDate->toUTC();
                $oEndDate = new Date($aParam['end_date']);
                $oEndDate->addSpan(new Date_Span('1-0-0-0'));
                $oEndDate->toUTC();
                $doAudit->whereAdd('updated >= ' . DBC::makeLiteral($oStartDate->format('%Y-%m-%d %H:%M:%S')));
                $doAudit->whereAdd('updated < ' . DBC::makeLiteral($oEndDate->format('%Y-%m-%d %H:%M:%S')));
            }

            // Check for, and apply, as required, any filters to ensure
            // that the results displayed are those in the desired advertiser ID;
            // OR, check for, and apply, as required, and filters to ensure
            // that the results displayed are those in the desired publisher ID.
            if (!empty($aParam['advertiser_id']) && is_numeric($aParam['advertiser_id']) && ($aParam['advertiser_id'] > 0)) {
                $aWhere = [];
                $campaignIdSet = true;
                // Also check for, and apply, as required and filters to
                // ensure that the results displayed are ALSO for the
                // desired campaign ID
                if (empty($aParam['campaign_id']) || !is_numeric($aParam['campaign_id']) || ($aParam['campaign_id'] <= 0)) {
                    // The campaign ID is not set, so filtering by advertiser ID only
                    //  - Unset the fact that the campaign ID is set; and
                    //  - Add the where clause to include advertiser ID level events
                    $campaignIdSet = false;
                    $aWhere[] = "(context = 'clients' AND contextid = " . $doAudit->quote($aParam['advertiser_id']) . ")";
                }
                // Add the where clause to include campaign level events
                $aCampaignIds = [];
                // Find all campaigns in the advertiser
                $doCampaigns = OA_Dal::factoryDO('campaigns');
                $doCampaigns->clientid = $aParam['advertiser_id'];
                if ($campaignIdSet) {
                    // Also limit to the set campaign ID
                    $doCampaigns->campaignid = $aParam['campaign_id'];
                }
                $doCampaigns->find();
                if ($doCampaigns->getRowCount() > 0) {
                    while ($doCampaigns->fetch()) {
                        // Add the campaign ID to the list of campaigns in the advertiser
                        $aCampaignIds[] = $doAudit->quote($doCampaigns->campaignid);
                    }
                }
                if (!empty($aCampaignIds)) {
                    $aWhere[] = "(context = 'campaigns' AND contextid IN (" . implode(',', $aCampaignIds) . "))";
                }
                // Add the where clause to include banner level events
                $aBannerIds = [];
                // Find all banners in the advertiser's campaigns
                if (!empty($aCampaignIds)) {
                    $doBanners = OA_Dal::factoryDO('banners');
                    $doBanners->whereAdd('campaignid IN (' . implode(',', $aCampaignIds) . ')');
                    $doBanners->find();
                    if ($doBanners->getRowCount() > 0) {
                        while ($doBanners->fetch()) {
                            $aBannerIds[] = $doAudit->quote($doBanners->bannerid);
                        }
                    }
                    if (!empty($aBannerIds)) {
                        $aWhere[] = "(context = 'banners' AND contextid IN (" . implode(',', $aBannerIds) . "))";
                    }
                }
                // Combine and add above filters
                if (!empty($aWhere)) {
                    $where = '(' . implode(' OR ', $aWhere) . ')';
                    $doAudit->whereAdd($where);
                }
            } elseif (!empty($aParam['publisher_id']) && is_numeric($aParam['publisher_id']) && ($aParam['publisher_id'] > 0)) {
                $aWhere = [];
                $zoneIdSet = true;
                // Also check for, and apply, as required and filters to
                // ensure that the results displayed are ALSO for the
                // desired zone ID
                if (empty($aParam['zone_id']) || !is_numeric($aParam['zone_id']) || ($aParam['zone_id'] <= 0)) {
                    // The zone ID is not set, so filtering by publisher ID only
                    //  - Unset the fact that the zone ID is set; and
                    //  - Add the where clause to include publisher ID level events
                    $zoneIdSet = false;
                    $aWhere[] = "(context = 'affiliates' AND contextid = " . $doAudit->quote($aParam['publisher_id']) . ")";
                }
                // Add the where clause to include zone level events
                $aZoneIds = [];
                // Find all zones in the publisher
                $doZones = OA_Dal::factoryDO('zones');
                $doZones->affiliateid = $aParam['publisher_id'];
                if ($zoneIdSet) {
                    // Also limit to the set zone ID
                    $doZones->zone_id = $aParam['zone_id'];
                }
                $doZones->find();
                if ($doZones->getRowCount() > 0) {
                    while ($doZones->fetch()) {
                        // Add the zone ID to the list of zones in the publisher
                        $aZoneIds[] = $doAudit->quote($doZones->zoneid);
                    }
                }
                if (!empty($aZoneIds)) {
                    $aWhere[] = "(context = 'zones' AND contextid IN (" . implode(',', $aZoneIds) . "))";
                }
                // Combine and add above filters
                if (!empty($aWhere)) {
                    $where = '(' . implode(' OR ', $aWhere) . ')';
                    $doAudit->whereAdd($where);
                }
            }

            //  Make sure that items that are children are not displayed
            $doAudit->whereAdd('parentid IS NULL');

            if (isset($aParam['order'])) {
                if ($aParam['order'] == 'down') {
                    $doAudit->orderBy($aParam['listorder'] . ' ASC');
                } else {
                    $doAudit->orderBy($aParam['listorder'] . ' DESC');
                }
            }

            if ((!empty($aParam['startRecord']) || $aParam['startRecord'] >= 0) && $aParam['perPage']) {
                $doAudit->limit($aParam['startRecord'], $aParam['perPage']);
            } else {
                $doAudit->limit(0, 500); //force to a limit, to avoid unlimited querie
            }

            $numRows = $doAudit->find();

            $oNow = new Date();
            while ($doAudit->fetch()) {
                $aAudit = $doAudit->toArray();
                $aAudit['details'] = unserialize($aAudit['details']);

                //  format date
                $oDate = new Date($aAudit['updated']);
                $oDate->setTZbyID('UTC');
                $oDate->convertTZ($oNow->tz);
                $aAudit['updated'] = $oDate->format($GLOBALS['date_format'] . ', ' . $GLOBALS['time_format']);
                //  set action type
                $aAudit['action'] = $this->getActionName($aAudit['actionid']);
                $result = $this->getParentContextData($aAudit);
                $aAudit['hasChildren'] = $this->hasChildren($aAudit['auditid'], $aAudit['contextid']);

                if (empty($aAudit['username'])) {
                    $aAudit['username'] = $GLOBALS['strAuditSystem'];
                }
                $aAudit['contextDescription'] = $this->getContextDescription($aAudit['context']);

                $aAuditInfo[] = $aAudit;
            }
        }
        return $aAuditInfo;
    }

    /**
     * Returns context for given table name
     *
     * @param string $tableName
     * @return string  Context
     */
    public function getContextDescription($tableName)
    {
        static $contexts = [];
        if (isset($contexts[$tableName])) {
            return $contexts[$tableName];
        }
        $contexts[$tableName] = $tableName;
        if (OA_Dal::checkIfDoExists($tableName)) {
            $do = OA_Dal::factoryDO($tableName);
            if ($do) {
                $contexts[$tableName] = $do->_getContext();
            }
        }
        return $contexts[$tableName];
    }


    /**
     * Returns the associated action name based on the specified action id
     *
     * @var int action id
     *
     * @return string action name
     */
    public function getActionName($actionId)
    {
        switch ($actionId) {
        case OA_AUDIT_ACTION_INSERT:
             $action = $GLOBALS['strInserted'];
            break;
        case OA_AUDIT_ACTION_UPDATE:
            $action = $GLOBALS['strUpdated'];
            break;
        case OA_AUDIT_ACTION_DELETE:
            $action = $GLOBALS['strDeleted'];
            break;
        }

        return $action;
    }

    /**
     * Sets the parent context type and parent context id
     *
     * @var int context type
     *
     * @return boolean  true on success / false on failure
     */
    public function getParentContextData(&$aContext)
    {
        switch ($aContext['context']) {
        case 'banners':
            $aContext['parentcontext'] = $GLOBALS['strCampaign'];
            $aContext['parentcontextid'] = $aContext['details']['campaignid'] ?? null;
            return true;
        case 'campaigns':
            $aContext['parentcontext'] = $GLOBALS['strClient'];
            $aContext['parentcontextid'] = $aContext['details']['clientid'] ?? null;
            return true;
        case 'channel':
        case 'zones':
            $aContext['parentcontext'] = $GLOBALS['strAffiliate'];
            $aContext['parentcontextid'] = $aContext['details']['affiliateid'] ?? null;
            return true;
        }
        return false;
    }

    /**
     * Gets the children for the selected audit event
     *
     * @param int $auditID Audit ID
     * @param string $itemContext item context type
     *
     * @return array an array containing the children for the specified audit event
     */
    public function getChildren($auditID, $itemContext)
    {
        if ('banners' === $itemContext) {
            $context = $GLOBALS['strAdZoneAssociation'];
        } else {
            $context = null;
        }

        $oAudit = OA_Dal::factoryDO('audit');
        $oAudit->parentid = $auditID;
        $oAudit->context = $context;
        $numRows = $oAudit->find();

        while ($oAudit->fetch()) {
            $aAudit = $oAudit->toArray();
            $aAudit['action'] = $this->getActionName($aAudit['actionid']);
            $aAudit['contextDescription'] = $this->getContextDescription($aAudit['context']);

            //  check if child has children
            if ($this->hasChildren($aAudit['auditid'], $aAudit['context'])) {
                $aAudit['children'] = $this->getChildren($aAudit['auditid'], $aAudit['context']);
            }
            $aChildren[] = $aAudit;
        }

        return (!empty($aChildren)) ? $aChildren : false;
    }

    /**
     * Check if the specified audit event has children events
     *
     * @param int $auditID Audit ID
     * @param string $itemContext item context type
     *
     * @return boolan true if event has children else false
     */
    public function hasChildren($auditID, $itemContext)
    {
        if ('banners' === $itemContext) {
            $context = $GLOBALS['strAdZoneAssociation'];
        } else {
            $context = null;
        }

        $oAudit = OA_Dal::factoryDO('audit');
        $oAudit->parentid = $auditID;
        $oAudit->context = $context;
        $numRows = $oAudit->find();

        return ($numRows > 0) ? true : false;
    }

    /**
     * Removes parent context id
     *
     * @param array $aAudit assoc array which to remove the parent context id from
     *
     * @return boolean true on succes else false on failure
     */
    public function _removeParentContextId(&$aAudit)
    {
        switch ($aAudit['context']) {
        case 'ad_zone_assoc':
        case 'acls':
        case 'images':
            if (isset($aAudit['details']['bannerid']) && !is_array($aAudit['details']['bannerid'])) {
                unset($aAudit['details']['bannerid']);
            }
            return true;
        case 'banners':
        case 'campaigns_trackers':
            if (isset($aAudit['details']['campaignid']) && !is_array($aAudit['details']['campaignid'])) {
                unset($aAudit['details']['campaignid']);
            }
            return true;
        case 'campaigns':
        case 'trackers':
            if (isset($aAudit['details']['clientid']) && !is_array($aAudit['details']['clientid'])) {
                unset($aAudit['details']['clientid']);
            }
            return true;
        case 'channel':
        case 'zones':
            if (isset($aAudit['details']['affiliateid']) && !is_array($aAudit['details']['affiliateid'])) {
                unset($aAudit['details']['affiliateid']);
            }
            return true;
        }
        return false;
    }

    /**
     * requires permission checks
     *
     * @param array $aParam
     * @return array
     */
    public function getAuditLogForAuditWidget($aParam = [])
    {
        $oAudit = OA_Dal::factoryDO('audit');

        // Apply account level filters
        if (!empty($aParam['account_id'])) {
            $oAudit->account_id = $aParam['account_id'];
        }
        if (!empty($aParam['advertiser_account_id'])) {
            $oAudit->advertiser_account_id = $aParam['advertiser_account_id'];
        }
        if (!empty($aParam['website_account_id'])) {
            $oAudit->website_account_id = $aParam['website_account_id'];
        }

        $oDate = new Date();
        $oDate->toUTC();
        $oDate->subtractSpan(new Date_Span('7-0-0-0'));
        $oAudit->whereAdd("username <> 'Maintenance'");
        $oAudit->whereAdd('parentid IS NULL');
        $oAudit->whereAdd("updated >= " . DBC::makeLiteral($oDate->format('%Y-%m-%d %H:%M:%S')));
        $oAudit->orderBy('auditid DESC');
        $oAudit->limit(0, 5);

        $numRows = $oAudit->find();

        $oNow = new Date();
        $aResult = [];
        while ($oAudit->fetch()) {
            $aAudit = $oAudit->toArray();
            $oDate = new Date($aAudit['updated']);
            $oDate->setTZbyID('UTC');
            $oDate->convertTZ($oNow->tz);
            $aAudit['updated'] = $oDate->format('%Y-%m-%d %H:%M:%S');
            $aAudit['details'] = unserialize($aAudit['details']);
            $aAudit['context'] = $this->getContextDescription($aAudit['context']);
            $aResult[] = $aAudit;
        }
        return $aResult;
    }
}

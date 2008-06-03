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
 * Table Definition for campaigns
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Campaigns extends DB_DataObjectCommon
{
    var $onDeleteCascade = true;
    var $dalModelName = 'Campaigns';
    var $refreshUpdatedFieldIfExists = true;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'campaigns';                       // table name
    public $campaignid;                      // int(9)  not_null primary_key auto_increment
    public $campaignname;                    // string(255)  not_null
    public $clientid;                        // int(9)  not_null multiple_key
    public $views;                           // int(11)  
    public $clicks;                          // int(11)  
    public $conversions;                     // int(11)  
    public $expire;                          // date(10)  binary
    public $activate;                        // date(10)  binary
    public $priority;                        // int(11)  not_null
    public $weight;                          // int(4)  not_null
    public $target_impression;               // int(11)  not_null
    public $target_click;                    // int(11)  not_null
    public $target_conversion;               // int(11)  not_null
    public $anonymous;                       // string(1)  not_null enum
    public $companion;                       // int(1)  
    public $comments;                        // blob(65535)  blob
    public $revenue;                         // real(12)  
    public $revenue_type;                    // int(6)  
    public $updated;                         // datetime(19)  not_null binary
    public $block;                           // int(11)  not_null
    public $capping;                         // int(11)  not_null
    public $session_capping;                 // int(11)  not_null
    public $an_campaign_id;                  // int(11)  
    public $as_campaign_id;                  // int(11)  
    public $status;                          // int(11)  not_null
    public $an_status;                       // int(11)  not_null
    public $as_reject_reason;                // int(11)  not_null
    public $hosted_views;                    // int(11)  not_null
    public $hosted_clicks;                   // int(11)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Campaigns',$k,$v); }

    var $defaultValues = array(
                'clientid' => 0,
                'views' => -1,
                'clicks' => -1,
                'conversions' => -1,
                'expire' => '%NO_DATE_TIME%',
                'activate' => '%NO_DATE_TIME%',
                'priority' => 0,
                'weight' => 1,
                'target_impression' => 0,
                'target_click' => 0,
                'target_conversion' => 0,
                'anonymous' => 'f',
                'companion' => 0,
                'block' => 0,
                'capping' => 0,
                'session_capping' => 0,
                'status' => 0,
                'an_status' => 0,
                'as_reject_reason' => 0,
                'hosted_views' => 0,
                'hosted_clicks' => 0,
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    /**
     * A method to set the correct status based on the other campaign properties
     *
     * If you ever need to disable this in a test, please use a Mock overriding this method
     *
     * @param DataObjects_Campaigns $oldDoCampaigns
     */
    function setStatus($oldDoCampaigns = null)
    {
        $this->_coalesce($oldDoCampaigns, array('expire'));
        if ($this->_isExpired()) {
            $this->status = OA_ENTITY_STATUS_EXPIRED;
            return;
        }

        $this->_coalesce($oldDoCampaigns, array('views', 'clicks', 'conversions'));
        if ($this->_hasExceeededBookings()) {
            $this->status = OA_ENTITY_STATUS_EXPIRED;
            return;
        }

        $this->_coalesce($oldDoCampaigns, array('activate'));
        if ($this->_isAwaiting()) {
            $this->status = OA_ENTITY_STATUS_AWAITING;
            return;
        }

        $this->_coalesce($oldDoCampaigns, array('status'));
        if ($this->status == OA_ENTITY_STATUS_EXPIRED || $this->status == OA_ENTITY_STATUS_AWAITING) {
            if (isset($oldDoCampaigns)) {
                if ($oldDoCampaigns->status == OA_ENTITY_STATUS_EXPIRED || $oldDoCampaigns->status == OA_ENTITY_STATUS_AWAITING) {
                    $this->status = OA_ENTITY_RUNNING;
                } else {
                    $this->status = $oldDoCampaigns->status;
                }
            } else {
                $this->status = OA_ENTITY_RUNNING;
            }
        }

        // Set campaign inactive if weight and target are both null and autotargeting is disabled
        $this->_coalesce($oldDoCampaigns, array('target_impression', 'target_click', 'target_conversion', 'weight'));
        $targetOk     = $this->target_impression > 0 || $this->target_click > 0 || $this->target_conversion > 0;
        $weightOk     = $this->weight > 0;
        $autotargeted = OA_Dal::isValidDate($this->expire) && ($this->views > 0 || $this->clicks > 0 || $this->conversions > 0);
        if ($this->status == OA_ENTITY_STATUS_RUNNING && !$autotargeted && !($targetOk || $weightOk)) {
            $this->status = OA_ENTITY_STATUS_INACTIVE;
        } elseif ($this->status == OA_ENTITY_STATUS_INACTIVE && !$autotargeted && ($targetOk || $weightOk)) {
            $this->status = OA_ENTITY_STATUS_RUNNING;
        }
    }

    /**
     * A method to replace null fields with the content of another DO instance
     *
     * @param DataObjects_Campaigns $oldDoCampaigns
     * @param array $aFields
     */
    function _coalesce($oldDoCampaigns, $aFields)
    {
        foreach ($aFields as $fieldName) {
            if (!isset($this->$fieldName) && isset($oldDoCampaigns)) {
                $this->$fieldName = $oldDoCampaigns->$fieldName;
            }
        }
    }

    /**
     * A method to check if the campaign is awaiting activation
     *
     * @return bool
     */
    function _isAwaiting()
    {
        static $oServiceLocator;

        // MySQL null date hardcoded for optimisation
        if (!empty($this->activate) && $this->activate != '0000-00-00') {
            if (!isset($oServiceLocator)) {
                $oServiceLocator = &OA_ServiceLocator::instance();
            }
            if ((!$oNow = $oServiceLocator->get('now'))) {
                $oNow = new Date();
            }
            $oActivate = new Date($this->activate);
            if (!empty($this->clientid)) {
                // Set timezone
                $aAccounts = $this->getOwningAccountIds();
                $aPrefs = OA_Preferences::loadAccountPreferences($aAccounts[OA_ACCOUNT_ADVERTISER], true);
                if (isset($aPrefs['timezone'])) {
                    $oActivate->setTZbyID($aPrefs['timezone']);
                }
            }
            if ($oNow->before($oActivate)) {
                return true;
            }
        }

        return false;
    }

    /**
     * A method to check if the campaign is expired
     *
     * @return bool
     */
    function _isExpired()
    {
        static $oServiceLocator;

        // MySQL null date hardcoded for optimisation
        if (!empty($this->expire) && $this->expire != '0000-00-00') {
            if (!isset($oServiceLocator)) {
                $oServiceLocator = &OA_ServiceLocator::instance();
            }
            if ((!$oNow = $oServiceLocator->get('now'))) {
                $oNow = new Date();
            }
            $oExpire = new Date($this->expire);
            $oExpire->setHour(23);
            $oExpire->setMinute(59);
            $oExpire->setSecond(59);
            if (!empty($this->clientid)) {
                // Set timezone
                $aAccounts = $this->getOwningAccountIds();
                $aPrefs = OA_Preferences::loadAccountPreferences($aAccounts[OA_ACCOUNT_ADVERTISER], true);
                if (isset($aPrefs['timezone'])) {
                    $oExpire->setTZbyID($aPrefs['timezone']);
                }
            }
            if ($oNow->after($oExpire)) {
                return true;
            }
        }

        return false;
    }

    /**
     * A method to check if the campaign has exceeded the booked values
     *
     * @return bool
     */
    function _hasExceeededBookings()
    {
        if (!empty($this->campaignid)) {
            if ($this->views > 0 || $this->clicks > 0 || $this->conversions > 0) {
                $doBanners = OA_Dal::factoryDO('banners');
                $doBanners->campaignid = $this->campaignid;
                $doDia = OA_Dal::factoryDO('data_intermediate_ad');
                $doDia->selectAdd();
                $doDia->selectAdd('SUM(impressions) AS impressions');
                $doDia->selectAdd('SUM(clicks) AS clicks');
                $doDia->selectAdd('SUM(conversions) AS conversions');
                $doDia->joinAdd($doBanners);
                $aStats = $doDia->getAll(array());

                if (isset($aStats[0])) {
                    if ($this->views > 0 && $aStats[0]['impressions'] >= $this->views) {
                        return true;
                    }
                    if ($this->clicks > 0 && $aStats[0]['clicks'] >= $this->clicks) {
                        return true;
                    }
                    if ($this->conversions > 0 && $aStats[0]['conversions'] >= $this->conversions) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    function update($dataObject = false)
    {
        if (isset($this->campaignid)) {
            // Set the correct campaign status, loading the old data
            $this->setStatus(OA_Dal::staticGetDO('campaigns', $this->campaignid));
        }

        return parent::update($dataObject);
    }

    function insert()
    {
        // Set the correct campaign status
        $this->setStatus();

        $id = parent::insert();
        if (!$id) {
            return $id;
        }

        // Initalise any tracker based plugins
        $plugins = array();
        require_once MAX_PATH.'/lib/max/Plugin.php';
        $invocationPlugins = &MAX_Plugin::getPlugins('invocationTags');
        foreach($invocationPlugins as $pluginKey => $plugin) {
            if (!empty($plugin->trackerEvent)) {
                $plugins[] = $plugin;
            }
        }

        // Link automatically any trackers which are marked as "link with any new campaigns"
        $doTrackers = $this->factory('trackers');
        $doTrackers->clientid = $this->clientid;
        $doTrackers->linkcampaigns = 't';
        $doTrackers->find();

        while ($doTrackers->fetch()) {
            $doCampaigns_trackers = $this->factory('campaigns_trackers');
            $doCampaigns_trackers->init();
            $doCampaigns_trackers->trackerid = $doTrackers->trackerid;
            $doCampaigns_trackers->campaignid = $this->campaignid;
            $doCampaigns_trackers->clickwindow = $doTrackers->clickwindow;
            $doCampaigns_trackers->viewwindow = $doTrackers->viewwindow;
            $doCampaigns_trackers->status = $doTrackers->status;
            foreach ($plugins as $oPlugin) {
                $fieldName = strtolower($oPlugin->trackerEvent);
                $doCampaigns_trackers->$fieldName = $doTrackers->$fieldName;
            }
            $doCampaigns_trackers->insert();
        }

        return $id;
    }

    /**
     * A method to duplicate: The campaign, the placement-zone-associations,
     * the placement-tracker-associations and the campaign's banners.
     *
     * @return integer The new campaignid
     */
    function duplicate()
    {
    	// Duplicate campaign
        $old_campaignId = $this->campaignid;
        $this->campaignname = 'Copy of ' . $this->campaignname;
        unset($this->campaignid);
        $new_campaignId = $this->insert();

        // Duplicate placement-zone-associations (Do this before duplicating banners to ensure an exact copy of ad-zone-assocs
     	MAX_duplicatePlacementZones($old_campaignId, $new_campaignId);

        // Duplicate original campaign's banners
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $old_campaignId;
        $doBanners->find();
        while ($doBanners->fetch()) {
        	$doOriginalBanner = OA_Dal::factoryDO('banners');
         	$doOriginalBanner->get($doBanners->bannerid);
         	$new_bannerid = $doOriginalBanner->duplicate($new_campaignId);
        }

        return $new_campaignId;
    }

    function _auditEnabled()
    {
        return true;
    }

    function _getContextId()
    {
        return $this->campaignid;
    }

    function _getContext()
    {
        return 'Campaign';
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
        // Campaigns don't have an account_id, get it from the parent
        // advertiser account (stored in the "clients" table) using
        // the "clientid" key
        return parent::getOwningAccountIds('clients', 'clientid');
    }

   /**
     * build a campaign specific audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc']     = $this->campaignname;
        switch ($actionid)
        {
            case OA_AUDIT_ACTION_UPDATE:
                        $aAuditFields['clientid']   = $this->clientid;
                        break;
        }
    }

    /**
     * perform post-audit actions
     *
     * @param int $actionid
     * @param DataObjects_Campaigns $dataobjectOld
     * @param int $auditId
     */
    function _postAuditTrigger($actionid, $dataobjectOld, $auditId)
    {
        $aActionMap = array();
        $aActionMap[OA_ENTITY_STATUS_RUNNING][OA_ENTITY_STATUS_AWAITING] = 'started';
        $aActionMap[OA_ENTITY_STATUS_RUNNING]['']  = 'restarted';
        $aActionMap[OA_ENTITY_STATUS_EXPIRED]['']  = 'completed';
        $aActionMap[OA_ENTITY_STATUS_PAUSED]['']   = 'paused';
        $aActionMap[OA_ENTITY_STATUS_AWAITING][''] = 'paused';

        switch ($actionid)
        {
            case OA_AUDIT_ACTION_INSERT:
                $actionType = 'added';
            case OA_AUDIT_ACTION_UPDATE:
                if (isset($this->status) && $this->status != $dataobjectOld->status) {
                    if (isset($aActionMap[$this->status][$dataobjectOld->status])) {
                        $actionType = $aActionMap[$this->status][$dataobjectOld->status];
                    } elseif (isset($aActionMap[$this->status][''])) {
                        $actionType = $aActionMap[$this->status][''];
                    }
                }
                break;
            case OA_AUDIT_ACTION_DELETE:
            	$actionType = 'deleted';
            	break;
        }
        if (isset($actionType)) {
            // Prepare action array
            $maxItems = 6;
            $aAction = array(
                'campaignid' => $this->campaignid,
                'name'       => $this->campaignname,
                'clientid'   => $this->clientid,
                'auditid'    => $auditId,
                'action'     => $actionType
            );
            // Load cache
            require_once MAX_PATH . '/lib/OA/Cache.php';
            $oCache = new OA_Cache('campaignOverview', 'Widgets');
            $aCache = $oCache->load(true);
            if (!$aCache) {
                // No cache, initialise
                $aCache = array(
                    'maxItems'  => $maxItems,
                    'aAccounts' => array()
                );
            }
            // Get owning account id
            $accountId = $this->doAudit->account_id;
            if (!isset($aCache['aAccounts'][$accountId])) {
                // No cached array for this account id, initialise
                $aCache['aAccounts'][$accountId] = array();
            }

            // Add current action as first item
            array_unshift($aCache['aAccounts'][$accountId], $aAction);

            //if current campaign is deleted, delete campaignid in all messages concernig this campaign
            if ($actionType=='deleted') {
            	//var_dump($aCache['aAccounts'][$accountId]);
             	foreach ($aCache['aAccounts'][$accountId] as $k => $v) {
                    if ($v['campaignid'] == $aAction['campaignid']) {
                        $aCache['aAccounts'][$accountId][$k]['campaignid'] = "";
                    }
                }
            }

            // Only store most recent $maxItems actions, rekeying the array
            $aCache['aAccounts'][$accountId] = array_slice($aCache['aAccounts'][$accountId], 0, $maxItems);
            // Save cache
            $oCache->save($aCache);
        }
    }
}

?>

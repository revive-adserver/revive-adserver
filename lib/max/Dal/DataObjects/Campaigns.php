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
 * Table Definition for campaigns
 */
require_once 'DB_DataObjectCommon.php';
require_once MAX_PATH . '/lib/OX/Util/Utils.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

class DataObjects_Campaigns extends DB_DataObjectCommon
{
    public $onDeleteCascade = true;
    public $dalModelName = 'Campaigns';
    public $refreshUpdatedFieldIfExists = true;

    public const PRIORITY_REMNANT = 0;
    public const PRIORITY_ECPM = -2;
    public const PRIORITY_MARKET_REMNANT = -3;

    /**
     * Defines which campaigns priorities can be used together
     * with eCPM feature. (PRIORITY_ECPM_FROM should be smaller than
     * PRIORITY_ECPM_TO)
     */
    public const PRIORITY_ECPM_FROM = 6;
    public const PRIORITY_ECPM_TO = 9;

    /**
     * Defines campaign types
     */
    public const CAMPAIGN_TYPE_DEFAULT = 0;
    public const CAMPAIGN_TYPE_MARKET_CAMPAIGN_OPTIN = 1;
    public const CAMPAIGN_TYPE_MARKET_ZONE_OPTIN = 2;
    public const CAMPAIGN_TYPE_MARKET_CONTRACT = 3;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'campaigns';                       // table name
    public $campaignid;                      // MEDIUMINT(9) => openads_mediumint => 129
    public $campaignname;                    // VARCHAR(255) => openads_varchar => 130
    public $clientid;                        // MEDIUMINT(9) => openads_mediumint => 129
    public $views;                           // INT(11) => openads_int => 1
    public $clicks;                          // INT(11) => openads_int => 1
    public $conversions;                     // INT(11) => openads_int => 1
    public $priority;                        // INT(11) => openads_int => 129
    public $weight;                          // TINYINT(4) => openads_tinyint => 129
    public $target_impression;               // INT(11) => openads_int => 129
    public $target_click;                    // INT(11) => openads_int => 129
    public $target_conversion;               // INT(11) => openads_int => 129
    public $anonymous;                       // ENUM('t','f') => openads_enum => 130
    public $companion;                       // SMALLINT(1) => openads_smallint => 17
    public $comments;                        // TEXT() => openads_text => 34
    public $revenue;                         // DECIMAL(10,4) => openads_decimal => 1
    public $revenue_type;                    // SMALLINT(6) => openads_smallint => 1
    public $updated;                         // DATETIME() => openads_datetime => 142
    public $block;                           // INT(11) => openads_int => 129
    public $capping;                         // INT(11) => openads_int => 129
    public $session_capping;                 // INT(11) => openads_int => 129
    public $status;                          // INT(11) => openads_int => 129
    public $hosted_views;                    // INT(11) => openads_int => 129
    public $hosted_clicks;                   // INT(11) => openads_int => 129
    public $viewwindow;                      // MEDIUMINT(9) => openads_mediumint => 129
    public $clickwindow;                     // MEDIUMINT(9) => openads_mediumint => 129
    public $ecpm;                            // DECIMAL(10,4) => openads_decimal => 1
    public $min_impressions;                 // INT(11) => openads_int => 129
    public $ecpm_enabled;                    // TINYINT(4) => openads_tinyint => 129
    public $activate_time;                   // DATETIME() => openads_datetime => 14
    public $expire_time;                     // DATETIME() => openads_datetime => 14
    public $type;                            // TINYINT(4) => openads_tinyint => 129
    public $show_capped_no_cookie;           // TINYINT(4) => openads_tinyint => 129

    /* Static get */
    public static function staticGet($k, $v = null)
    {
        return DB_DataObject::staticGetFromClassName('DataObjects_Campaigns', $k, $v);
    }

    public $defaultValues = [
        'campaignname' => '',
        'clientid' => 0,
        'views' => -1,
        'clicks' => -1,
        'conversions' => -1,
        'priority' => 0,
        'weight' => 1,
        'target_impression' => 0,
        'target_click' => 0,
        'target_conversion' => 0,
        'anonymous' => 'f',
        'companion' => 0,
        'updated' => '%DATE_TIME%',
        'block' => 0,
        'capping' => 0,
        'session_capping' => 0,
        'status' => 0,
        'hosted_views' => 0,
        'hosted_clicks' => 0,
        'viewwindow' => 0,
        'clickwindow' => 0,
        'min_impressions' => 0,
        'ecpm_enabled' => 0,
        'type' => 0,
        'show_capped_no_cookie' => 0,
    ];

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    public function __construct()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        // Set default connection windows
        if (!empty($aConf['logging']['defaultImpressionConnectionWindow'])) {
            $this->defaultValues['viewwindow'] = $aConf['logging']['defaultImpressionConnectionWindow'];
        }

        if (!empty($aConf['logging']['defaultClickConnectionWindow'])) {
            $this->defaultValues['clickwindow'] = $aConf['logging']['defaultClickConnectionWindow'];
        }
    }

    /**
     * A method to set the correct status based on the other campaign properties
     *
     * If you ever need to disable this in a test, please use a Mock overriding this method
     *
     * @param DataObjects_Campaigns $oldDoCampaigns
     */
    public function recalculateStatus($oldDoCampaigns = null)
    {
        // special market campaigns are always active
        if ($this->type == self::CAMPAIGN_TYPE_MARKET_ZONE_OPTIN ||
            $this->type == self::CAMPAIGN_TYPE_MARKET_CAMPAIGN_OPTIN) {
            $this->status = OA_ENTITY_STATUS_RUNNING;
            return;
        }

        $this->_coalesce($oldDoCampaigns, ['expire_time']);
        if ($this->_isExpired()) {
            $this->status = OA_ENTITY_STATUS_EXPIRED;
            return;
        }

        $this->_coalesce($oldDoCampaigns, ['views', 'clicks', 'conversions']);
        if ($this->_hasExceeededBookings()) {
            $this->status = OA_ENTITY_STATUS_EXPIRED;
            return;
        }

        $this->_coalesce($oldDoCampaigns, ['activate_time']);
        if ($this->_isAwaiting()) {
            $this->status = OA_ENTITY_STATUS_AWAITING;
            return;
        }

        $this->_coalesce($oldDoCampaigns, ['status']);
        if ($this->status == OA_ENTITY_STATUS_EXPIRED || $this->status == OA_ENTITY_STATUS_AWAITING) {
            if (isset($oldDoCampaigns)) {
                if ($oldDoCampaigns->status == OA_ENTITY_STATUS_EXPIRED || $oldDoCampaigns->status == OA_ENTITY_STATUS_AWAITING) {
                    $this->status = OA_ENTITY_STATUS_RUNNING;
                } else {
                    $this->status = $oldDoCampaigns->status;
                }
            } else {
                $this->status = OA_ENTITY_STATUS_RUNNING;
            }
        }

        if ($this->priority == self::PRIORITY_ECPM || $this->ecpm_enabled == 1) {
            $ecpmOk = floatval($this->revenue) > 0;
            if ($this->status == OA_ENTITY_STATUS_RUNNING && !$ecpmOk) {
                $this->status = OA_ENTITY_STATUS_INACTIVE;
            } elseif ($this->status == OA_ENTITY_STATUS_INACTIVE && $ecpmOk) {
                $this->status = OA_ENTITY_STATUS_RUNNING;
            }
        } else {
            // Set campaign inactive if weight and target are both null and autotargeting is disabled
            $this->_coalesce($oldDoCampaigns, ['target_impression', 'target_click', 'target_conversion', 'weight']);
            $targetOk = $this->target_impression > 0 || $this->target_click > 0 || $this->target_conversion > 0;
            $weightOk = $this->weight > 0;
            $autotargeted = !empty($this->expire_time) && $this->expire_time != 'NULL' &&
                ($this->views > 0 || $this->clicks > 0 || $this->conversions > 0);
            if ($this->status == OA_ENTITY_STATUS_RUNNING && !$autotargeted && !($targetOk || $weightOk)) {
                $this->status = OA_ENTITY_STATUS_INACTIVE;
            } elseif ($this->status == OA_ENTITY_STATUS_INACTIVE && ($autotargeted || $targetOk || $weightOk)) {
                $this->status = OA_ENTITY_STATUS_RUNNING;
            }
        }
    }

    /**
     * A method to replace null fields with the content of another DO instance
     *
     * @param DataObjects_Campaigns $oldDoCampaigns
     * @param array $aFields
     */
    public function _coalesce($oldDoCampaigns, $aFields)
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
    public function _isAwaiting()
    {
        static $oServiceLocator;

        if (!empty($this->activate_time) && $this->activate_time != OX_DATAOBJECT_NULL) {
            if (!isset($oServiceLocator)) {
                $oServiceLocator = OA_ServiceLocator::instance();
            }
            if ((!$oNow = $oServiceLocator->get('now'))) {
                $oNow = new Date();
            }
            $oNow->toUTC();
            $oActivate = new Date($this->activate_time);
            $oActivate->setTZbyID('UTC');
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
    public function _isExpired()
    {
        static $oServiceLocator;

        if (!empty($this->expire_time) && $this->expire_time != OX_DATAOBJECT_NULL) {
            if (!isset($oServiceLocator)) {
                $oServiceLocator = OA_ServiceLocator::instance();
            }
            if ((!$oNow = $oServiceLocator->get('now'))) {
                $oNow = new Date();
            }
            $oNow->toUTC();
            $oExpire = new Date($this->expire_time);
            $oExpire->setTZbyID('UTC');
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
    public function _hasExceeededBookings()
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
                $aStats = $doDia->getAll([]);

                if (isset($aStats[0])) {
                    if ($this->views > 0 && ($aStats[0]['impressions'] ?? 0) >= $this->views) {
                        return true;
                    }
                    if ($this->clicks > 0 && ($aStats[0]['clicks'] ?? 0) >= $this->clicks) {
                        return true;
                    }
                    if ($this->conversions > 0 && ($aStats[0]['conversions'] ?? 0) >= $this->conversions) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function update($dataObject = false)
    {
        if ($this->priority == self::PRIORITY_ECPM || $this->ecpm_enabled) {
            $this->ecpm = $this->calculateEcpm();
        }

        if (isset($this->campaignid)) {
            // Set the correct campaign status, loading the old data
            $this->recalculateStatus(OA_Dal::staticGetDO('campaigns', $this->campaignid));
        }

        return parent::update($dataObject);
    }

    public function insert()
    {
        if ($this->priority == self::PRIORITY_ECPM || $this->ecpm_enabled) {
            $this->ecpm = $this->calculateEcpm();
            ;
        }

        // Set the correct campaign status
        $this->recalculateStatus();

        $id = parent::insert();
        if (!$id) {
            return $id;
        }

        // Initalise any tracker based plugins
        $plugins = [];
        require_once LIB_PATH . '/Plugin/Component.php';
        $invocationPlugins = OX_Component::getComponents('invocationTags');
        foreach ($invocationPlugins as $pluginKey => $plugin) {
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
    public function duplicate()
    {
        // Duplicate campaign
        $old_campaignId = $this->campaignid;
        $this->campaignname = $GLOBALS['strCopyOf'] . ' ' . $this->campaignname;
        unset($this->campaignid);
        $new_campaignId = $this->insert();

        // Duplicate original campaign's banners
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $old_campaignId;
        $doBanners->find();
        while ($doBanners->fetch()) {
            $doOriginalBanner = OA_Dal::factoryDO('banners');
            $doOriginalBanner->get($doBanners->bannerid);
            $new_bannerid = $doOriginalBanner->duplicate($new_campaignId);
        }

        // Duplicate placement-zone-associations (Do this after duplicating tbe banners (and associated ad-zone-links)
        // The duplicatePlacementZones method will not trigger the auto-linking mechanism so you end up with a 1:1 duplicate of ad-zone links
        MAX_duplicatePlacementZones($old_campaignId, $new_campaignId);

        return $new_campaignId;
    }

    public function _auditEnabled()
    {
        return true;
    }

    public function _getContextId()
    {
        return $this->campaignid;
    }

    public function _getContext()
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
    public function getOwningAccountIds($resetCache = false)
    {
        // Campaigns don't have an account_id, get it from the parent
        // advertiser account (stored in the "clients" table) using
        // the "clientid" key
        return $this->_getOwningAccountIds('clients', 'clientid');
    }

    /**
      * build a campaign specific audit array
      *
      * @param integer $actionid
      * @param array $aAuditFields
      */
    public function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc'] = $this->campaignname;
        switch ($actionid) {
            case OA_AUDIT_ACTION_UPDATE:
                        $aAuditFields['clientid'] = $this->clientid;
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
    public function _postAuditTrigger($actionid, $dataobjectOld, $auditId)
    {
        $aActionMap = [];
        $aActionMap[OA_ENTITY_STATUS_RUNNING][OA_ENTITY_STATUS_AWAITING] = 'started';
        $aActionMap[OA_ENTITY_STATUS_RUNNING][''] = 'restarted';
        $aActionMap[OA_ENTITY_STATUS_EXPIRED][''] = 'completed';
        $aActionMap[OA_ENTITY_STATUS_PAUSED][''] = 'paused';
        $aActionMap[OA_ENTITY_STATUS_AWAITING][''] = 'paused';

        switch ($actionid) {
            case OA_AUDIT_ACTION_INSERT:
                $actionType = 'added';
                // no break
            case OA_AUDIT_ACTION_UPDATE:
                if (isset($this->status) && $dataobjectOld && $this->status != $dataobjectOld->status) {
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
            $aAction = [
                'campaignid' => $this->campaignid,
                'name' => $this->campaignname,
                'clientid' => $this->clientid,
                'auditid' => $auditId,
                'action' => $actionType
            ];
            // Load cache
            require_once MAX_PATH . '/lib/OA/Cache.php';
            $oCache = new OA_Cache('campaignOverview', 'Widgets');
            $aCache = $oCache->load(true);
            if (!$aCache) {
                // No cache, initialise
                $aCache = [
                    'maxItems' => $maxItems,
                    'aAccounts' => []
                ];
            }
            // Get owning account id
            $accountId = $this->doAudit->account_id;
            if (!isset($aCache['aAccounts'][$accountId])) {
                // No cached array for this account id, initialise
                $aCache['aAccounts'][$accountId] = [];
            }

            // Add current action as first item
            array_unshift($aCache['aAccounts'][$accountId], $aAction);

            //if current campaign is deleted, delete campaignid in all messages concernig this campaign
            if ($actionType == 'deleted') {
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

    public function calculateEcpm()
    {
        if ($this->campaignid) {
            $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();
            $result = $oMaxDalMaintenance->getCampaignDeliveryToDate($this->campaignid);
            $impressionsToDate = $result[0]['sum_views'] ?? 0;
            $clicksToDate = $result[0]['sum_clicks'] ?? 0;
            $conversionsToDate = $result[0]['sum_conversions'] ?? 0;
        } else {
            $impressionsToDate = $clicksToDate = $conversionsToDate = 0;
        }
        return OX_Util_Utils::getEcpm(
            $this->revenue_type,
            $this->revenue,
            $impressionsToDate,
            $clicksToDate,
            $conversionsToDate,
            $this->activate_time,
            $this->expire_time
        );
    }

    /**
     * Sets whether contract eCPM is enabled for this campaign depending
     * on the account preference and the campaign priority.
     *
     *
     */
    public function setEcpmEnabled()
    {
        $ecpmEnabled = !empty($GLOBALS['_MAX']['PREF']['contract_ecpm_enabled']);

        if ($ecpmEnabled && $this->priority >= self::PRIORITY_ECPM_FROM && $this->priority <= self::PRIORITY_ECPM_TO) {
            $this->ecpm_enabled = 1;
        } else {
            $this->ecpm_enabled = 0;
        }
    }
}

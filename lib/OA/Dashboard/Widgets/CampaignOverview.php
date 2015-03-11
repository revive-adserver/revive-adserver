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

require_once MAX_PATH . '/lib/OA/Dashboard/Widget.php';
require_once MAX_PATH . '/lib/OA/Dll/Audit.php';
require_once MAX_PATH . '/lib/OA/Cache.php';

/**
 * A dashboard widget to diplay an Campaigns
 *
 */
class OA_Dashboard_Widget_CampaignOverview extends OA_Dashboard_Widget
{
    /**
     * @var OA_Admin_Template
     */
    var $oTpl;

    /**
     * The class constructor
     *
     * @param array $aParams The parameters array, usually $_REQUEST
     * @return OA_Dashboard_Widget_Campaign_Overview
     */
    function __construct($aParams)
    {
        parent::__construct($aParams);
        $this->oTpl = new OA_Admin_Template('dashboard/campaign-overview.html');
    }

    /**
     * A method to launch and display the widget
     *
     * @param array $aParams The parameters array, usually $_REQUEST
     */
    function display()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        if (!$conf['audit']['enabled']) {
            $this->oTpl->assign('screen',       'disabled');
            $this->oTpl->assign('siteTitle',    $GLOBALS['strCampaignAuditTrailSetup']);
            $this->oTpl->assign('siteUrl',      MAX::constructUrl(MAX_URL_ADMIN, 'account-settings-debug.php'));
        } else {
            $oCache = new OA_Cache('campaignOverview', 'Widgets');
            $aCache = $oCache->load(true);
            $aCampaign = array();
            if (isset($aCache['maxItems'])) {
                if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
                    foreach ($aCache['aAccounts'] as $aActions) {
                        foreach ($aActions as $aAction) {
                            $aCampaign[$aAction['auditid']] = $aAction;
                        }
                    }
                } else {
                    $aAccountsId = OA_Permission::getOwnedAccounts(OA_Permission::getAccountId());
                    foreach ($aAccountsId as $accountId) {
                        if (isset($aCache['aAccounts'][$accountId])) {
                            foreach ($aCache['aAccounts'][$accountId] as $aAction){
                                $aCampaign[$aAction['auditid']] = $aAction;
                            }
                        }
                    }
                }
                krsort($aCampaign);
                $aCampaign = array_slice($aCampaign, 0, $aCache['maxItems']);
            }
            if (count($aCampaign)) {
                $aActionMap = array(
                    'added'     => $GLOBALS['strCampaignStatusAdded'],
                    'started'   => $GLOBALS['strCampaignStatusStarted'],
                    'restarted' => $GLOBALS['strCampaignStatusRestarted'],
                    'completed' => $GLOBALS['strCampaignStatusExpired'],
                    'paused'    => $GLOBALS['strCampaignStatusPaused'],
                	'deleted'   => $GLOBALS['strCampaignStatusDeleted'],
                );
                foreach ($aCampaign as $k => $v) {
                    if (isset($aActionMap[$v['action']])) {
                        $aCampaign[$k]['actionDesc'] = $aActionMap[$v['action']];
                    }
                }
            } else {
                // Check if the account has any campaign in its realm
                $doCampaigns = OA_Dal::factoryDO('campaigns');
                if (!empty($aParam['account_id'])) {
                    $doClients = OA_Dal::factoryDO('clients');
                    $doAgency  = OA_Dal::factoryDO('agency');
                    $doAgency->account_id = $aParam['account_id'];
                    $doClients->joinAdd($doAgency);
                    $doCampaigns->joinAdd($doClients);
                }
                $doCampaigns->limit(1);

                $this->oTpl->assign('hasCampaigns', $doCampaigns->count());
                if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
                    $this->oTpl->assign('isAdmin', true);
                }
            }

            $this->oTpl->assign('screen',       'enabled');
            $this->oTpl->assign('aCampaign',    $aCampaign);
            $this->oTpl->assign('siteUrl',      MAX::constructURL(MAX_URL_ADMIN, 'advertiser-campaigns.php'));
            $this->oTpl->assign('baseUrl',      MAX::constructURL(MAX_URL_ADMIN, 'campaign-edit.php'));
        }

        $this->oTpl->display();
    }

}
?>

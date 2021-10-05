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
require_once MAX_PATH . '/lib/OX/Translation.php';

/**
 * A dashboard widget to diplay an RSS feed of the OpenX Blog
 *
 */
class OA_Dashboard_Widget_Audit extends OA_Dashboard_Widget
{
    /** @var OX_Translation */
    public $oTrans;

    /** @var OA_Admin_Template */
    public $oTpl;

    /**
     * The class constructor
     *
     * @param array $aParams The parameters array, usually $_REQUEST
     */
    public function __construct($aParams)
    {
        parent::__construct($aParams);

        $aConf = $GLOBALS['_MAX']['CONF'];

        $this->oTpl = new OA_Admin_Template('dashboard/audit.html');
        $this->oTrans = new OX_Translation();
    }

    public function display($aParams = [])
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        if (!$conf['audit']['enabled']) {
            $this->oTpl->assign('screen', 'disabled');
            $this->oTpl->assign('siteTitle', $GLOBALS['strAuditTrailSetup']);
            $this->oTpl->assign('siteUrl', MAX::constructUrl(MAX_URL_ADMIN, 'account-settings-debug.php'));
        } else {
            // Account security
            if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
                $aParams['account_id'] = OA_Permission::getAccountId();
            }
            if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
                $aParams['advertiser_account_id'] = OA_Permission::getAccountId();
            }
            if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
                $aParams['website_account_id'] = OA_Permission::getAccountId();
            }

            $oAudit = new OA_Dll_Audit();
            $aAuditData = $oAudit->getAuditLogForAuditWidget($aParams);
            if (count($aAuditData) > 0) {
                foreach ($aAuditData as $key => $aValue) {
                    $aValue['action'] = $this->oTrans->translate($oAudit->getActionName($aValue['actionid']));
                    $result = $oAudit->getParentContextData($aValue);

                    $str = "{$aValue['username']} {$GLOBALS['strHas']} {$aValue['action']} {$aValue['context']}";
                    if (!empty($aValue['contextid'])) {
                        $str .= " ({$aValue['contextid']})";
                    }
                    if (!empty($aValue['parentcontext'])) {
                        $str .= " {$GLOBALS['strFor']} {$aValue['parentcontext']} ({$aValue['parentcontextid']})";
                    }
                    if (!empty($aValue['hasChildren'])) {
                        $str .= " {$GLOBALS['strAdditionItems']}";
                    }
                    $aAuditData[$key]['desc'] = (strlen($str) > 30) ? substr($str, 0, 30) . '...' : $str;
                }
            } else {
                $this->oTpl->assign('noData', $GLOBALS['strAuditNoData']);
            }

            $this->oTpl->assign('screen', 'enabled');
            $this->oTpl->assign('aAuditData', $aAuditData);
            $this->oTpl->assign('siteUrl', MAX::constructUrl(MAX_URL_ADMIN, 'userlog-index.php'));
            $this->oTpl->assign('siteTitle', $GLOBALS['strAuditTrailGoTo']);
        }
        $this->oTpl->display();
    }
}

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
$Id$
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
    var $oTrans;

    /**
     * The class constructor
     *
     * @param array $aParams The parameters array, usually $_REQUEST
     * @return OA_Dashboard_Widget_BlogFeed
     */
    function OA_Dashboard_Widget_Audit($aParams)
    {
        parent::OA_Dashboard_Widget($aParams);

        $aConf = $GLOBALS['_MAX']['CONF'];

        $this->oTpl = new OA_Admin_Template('dashboard/audit.html');
        $this->oTrans = new OX_Translation();
    }

    function display()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        if (!$conf['audit']['enabled']) {
            $this->oTpl->assign('screen',       'disabled');
            $this->oTpl->assign('siteTitle',    $GLOBALS['strAuditTrailSetup']);
            $this->oTpl->assign('siteUrl',      MAX::constructUrl(MAX_URL_ADMIN, 'account-settings-debug.php'));
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
                $this->oTpl->assign('noData',   $GLOBALS['strAuditNoData']);
            }

            $this->oTpl->assign('screen',       'enabled');
            $this->oTpl->assign('aAuditData',   $aAuditData);
            $this->oTpl->assign('siteUrl',      MAX::constructUrl(MAX_URL_ADMIN, 'userlog-index.php'));
            $this->oTpl->assign('siteTitle',    $GLOBALS['strAuditTrailGoTo']);
        }
        $this->oTpl->display();
    }
}

?>
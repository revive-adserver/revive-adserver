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

require_once MAX_PATH . '/lib/OA/Dashboard/Widget.php';
require_once MAX_PATH . '/lib/OA/Dll/Audit.php';

/**
 * A dashboard widget to diplay an Campaign overview
 *
 */
class OA_Dashboard_Widget_CampaignOverview extends OA_Dashboard_Widget
{
    /**
     * @var OA_Admin_Template
     */
    var $oTpl;

    /**
     * @var Total items to display
     */
    var $totalItems = 6;

    /**
     * The class constructor
     *
     * @param array $aParams The parameters array, usually $_REQUEST
     * @return OA_Dashboard_Widget_Campaign_Overview
     */
    function OA_Dashboard_Widget_CampaignOverview($aParams)
    {
        parent::OA_Dashboard_Widget($aParams);
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
            if (!OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
                $aParam['account_id'] = OA_Permission::getAccountId();
            }

            $oAudit = & new OA_Dll_Audit();
            $aCampaign = $oAudit->getAuditLogForCampaignWidget($aParam);
            if (count($aCampaign) > 0) {
                foreach ($aCampaign as $key => $aValue) {
                    $aCampaign[$key]['details']['campaignname'] = (strlen($aValue['details']['key_desc']) > 35) ? substr($aValue['details']['key_desc'], 0, 35).'...' : $aValue['details']['key_desc'];
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
            }

            $this->oTpl->assign('screen',       'enabled');
            $this->oTpl->assign('aCampaign',    $aCampaign);
            $this->oTpl->assign('siteUrl',      MAX::constructURL(MAX_URL_ADMIN, 'advertiser-index.php'));
            $this->oTpl->assign('baseUrl',      MAX::constructURL(MAX_URL_ADMIN, 'campaign-edit.php'));
        }

        $this->oTpl->display();
    }

}
?>

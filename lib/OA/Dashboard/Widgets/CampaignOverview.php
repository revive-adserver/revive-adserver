<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
        $oCampaign = & OA_Dal::factoryDO($GLOBALS['_MAX']['CONF']['table']['campaigns']);
        $oCampaign->orderBy('updated');
        $oCampaign->limit($this->totalItems);
        $numRows = $oCampaign->find();
        if ($numRows > 0) {
            while ($oCampaign->fetch()) {
                $oCampaign->campaignname = (strlen($oCampaign->campaignname) > 35) ? substr($oCampaign->campaignname, 0, 35).'...' : $oCampaign->campaignname;
                $aCampaign[] = $oCampaign->toArray();
            }
        }
        $this->oTpl->assign('aCampaign',    $aCampaign);
        $this->oTpl->assign('baseUrl',      MAX::constructURL(MAX_URL_ADMIN, 'campaign-edit.php'));
        $this->oTpl->assign('siteUrl',      MAX::constructURL(MAX_URL_ADMIN, 'advertiser-index.php'));

        $this->oTpl->display();
    }

}
?>

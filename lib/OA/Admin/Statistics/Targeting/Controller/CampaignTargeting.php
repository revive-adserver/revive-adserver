<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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

require_once MAX_PATH . '/lib/OA/Admin/Targeting/Controller.php';

class OA_Admin_Targeting_Controller_CampaignTargeting extends OA_Admin_Targeting_Controller
{

    /**
     * A PHP5-style constructor that can be used to perform common
     * class instantiation by children classes.
     *
     * @param array $aParams An array of parameters. The array should
     *                       be indexed by the name of object variables,
     *                       with the values that those variables should
     *                       be set to. For example, the parameter:
     *                       $aParams = array('foo' => 'bar')
     *                       would result in $this->foo = bar.
     */
    function __construct($aParams)
    {
        $this->showDaySpanSelector = true;
        parent::__construct($aParams);
    }

    /**
     * PHP4-style constructor
     *
     * @param array $aParams An array of parameters. The array should
     *                       be indexed by the name of object variables,
     *                       with the values that those variables should
     *                       be set to. For example, the parameter:
     *                       $aParams = array('foo' => 'bar')
     *                       would result in $this->foo = bar.
     */
    function OA_Admin_Targeting_Controller_CampaignTargeting($aParams)
    {
        $this->__construct($aParams);
    }

    function start()
    {
        // Get the preferences
        $pref = $GLOBALS['_MAX']['PREF'];

        // Get parameters
        if (phpAds_isUser(phpAds_Client)) {
            $advertiserId = phpAds_getUserId();
        } else {
            $advertiserId = (int)MAX_getValue('clientid', '');
        }
        $placementId   = (int)MAX_getValue('campaignid', '');

        // Security check
        phpAds_checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Client);
        if (!MAX_checkPlacement($advertiserId, $placementId)) {
            phpAds_PageHeader('2');
            phpAds_Die ($GLOBALS['strAccessDenied'], $GLOBALS['strNotAdmin']);
        }

        // Add standard page parameters
        $this->aPageParams = array('clientid' => $advertiserId, 'campaignid' => $placementId,
                                  'entity' => 'campaign', 'breakdown' => 'targeting');

        $this->_loadParams();

        // HTML Framework
        if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
            $this->pageId = '2.1.2.4';
            $this->aPageSections = array('2.1.2.1', '2.1.2.2', '2.1.2.3', '2.1.2.4');
        } elseif (phpAds_isUser(phpAds_Client)) {
            $this->pageId = '1.2.1';
            $this->aPageSections = array('1.2.1', '1.2.2', '1.2.3');
        }

        $this->_addBreadcrumbs('campaign', $placementId);

        // Add context
        $this->pageContext = array('campaigns', $placementId);

        // Add shortcuts
        if (!phpAds_isUser(phpAds_Client)) {
            $this->_addShortcut(
                $GLOBALS['strClientProperties'],
                'advertiser-edit.php?clientid='.$advertiserId,
                'images/icon-advertiser.gif'
            );
        }
        $this->_addShortcut(
            $GLOBALS['strCampaignProperties'],
            'campaign-edit.php?clientid='.$advertiserId.'&campaignid='.$placementId,
            'images/icon-campaign.gif'
        );

        $aParams = array();
        $aParams['placement_id'] = $placementId;

        $this->aPageParams['entity']    = 'campaign';
        $this->aPageParams['breakdown'] = 'daily';


        $this->prepareTargeting($aParams, 'stats.php');

        $this->aPageParams = array('clientid' => $advertiserId, 'campaignid' => $placementId,
                                  'entity' => 'campaign', 'breakdown' => 'targeting');

        $this->_loadParams();

    }
}

?>
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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Targeting/CommonPlacement.php';

/**
 * The class to display the targeting statistcs for the page:
 *
 * Statistics -> Advertisers & Campaigns -> Campaigns -> Targeting Statistics -> Daily Statistics
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsTargeting
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Admin_Statistics_Targeting_Controller_CampaignTargetingDaily extends OA_Admin_Statistics_Targeting_CommonPlacement
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
        // Set this page's entity/breakdown values
        $this->entity    = 'campaign';
        $this->breakdown = 'targeting-daily';

        // Use the OA_Admin_Statistics_Daily helper class
        $this->useDailyClass = true;

        parent::__construct($aParams);

        // Special requirement for targeting statistics - activate required columns
        // in the plugins
        foreach (array_keys($this->aPlugins) as $key) {
            $this->aPlugins[$key]->_aFields['placement_required_impressions']['active'] = true;
            $this->aPlugins[$key]->_aFields['placement_requested_impressions']['active'] = true;
            $this->aPlugins[$key]->_aFields['placement_actual_impressions']['active'] = true;
            $this->aPlugins[$key]->_aFields['zones_forecast_impressions']['active'] = true;
            $this->aPlugins[$key]->_aFields['zones_actual_impressions']['active'] = true;
            $this->aPlugins[$key]->_aFields['target_ratio']['active'] = true;
        }
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
    function OA_Admin_Statistics_Targeting_Controller_CampaignTargeting($aParams)
    {
        $this->__construct($aParams);
    }

    /**
     * The final "child" implementation of the parental abstract method.
     *
     * @see OA_Admin_Statistics_Common::start()
     */
    function start()
    {
        // Get parameters
        $advertiserId = $this->_getId('advertiser');
        $placementId  = $this->_getId('placement');

        // Security check
        OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER);
        $this->_checkAccess(array('advertiser' => $advertiserId, 'placement'  => $placementId));

        // Add standard page parameters
        $this->aPageParams = array(
            'clientid'   => $advertiserId,
            'campaignid' => $placementId
        );

        // Load $_GET parameters
        $this->_loadParams();

        // Prepare HTML Framework
        $this->pageId = '2.1.2.4.1';
        $this->aPageSections = array($this->pageId);

        // Add breadcrumbs
        $this->_addBreadcrumbs('campaign', $placementId);

        // Add shortcuts
        if (!OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
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

        // Prepare the data for display by output() method
        $aParams = array(
            'placement_id' => $placementId
        );
        $this->prepare($aParams);
    }

}

?>
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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Targeting/CommonAd.php';

/**
 * The class to display the targeting statistcs for the page:
 *
 * Statistics -> Advertisers & Campaigns -> Banner History -> Targeting Statistics
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsTargeting
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Admin_Statistics_Targeting_Controller_BannerTargeting extends OA_Admin_Statistics_Targeting_CommonAd
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
        $this->entity    = 'banner';
        $this->breakdown = 'targeting';

        // Set this page's left hand column link breakdown values
        $this->dayLinkBreakdown = 'targeting-daily';

        // This page uses the day span selector element
        $this->showDaySpanSelector = true;

        parent::__construct($aParams);

        // Special requirement for targeting statistics - activate required columns
        // in the plugins
        foreach (array_keys($this->aPlugins) as $key) {
            $this->aPlugins[$key]->_aFields['ad_required_impressions']['active'] = true;
            $this->aPlugins[$key]->_aFields['ad_requested_impressions']['active'] = true;
            $this->aPlugins[$key]->_aFields['ad_actual_impressions']['active'] = true;
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
    function OA_Admin_Statistics_Targeting_Controller_BannerTargeting($aParams)
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
        $adId         = $this->_getId('ad');

        // Security check
        OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER);
        $this->_checkAccess(array('advertiser' => $advertiserId, 'placement' => $placementId, 'ad' => $adId));

        // Add standard page parameters
        $this->aPageParams = array(
            'clientid'   => $advertiserId,
            'campaignid' => $placementId,
            'bannerid'   => $adId
        );

        // Load the period preset and stats breakdown parameters
        $this->_loadPeriodPresetParam();
        $this->_loadStatsBreakdownParam();

        // Load $_GET parameters
        $this->_loadParams();

        // Prepare HTML Framework
        $this->pageId = '2.1.2.2.3';
        $this->aPageSections = array('2.1.2.2.1', '2.1.2.2.2', '2.1.2.2.3');

        // Add breadcrumbs
        $this->_addBreadcrumbs('banner', $adId);

        // Add context
        $this->aPageContext = array('banners', $adId);

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
        $this->_addShortcut(
            $GLOBALS['strBannerProperties'],
            'banner-edit.php?clientid='.$advertiserId.'&campaignid='.$placementId.'&bannerid='.$adId,
            'images/icon-banner-stored.gif'
        );
        $this->_addShortcut(
            $GLOBALS['strModifyBannerAcl'],
            'banner-acl.php?clientid='.$advertiserId.'&campaignid='.$placementId.'&bannerid='.$adId,
            'images/icon-acl.gif'
        );

        // Prepare the data for display by output() method
        $aParams = array(
            'ad_id' => $adId
        );
        $this->prepare($aParams, 'stats.php');
    }

    /**
     * A private method that can be inherited and used by children classes to
     * calculate the total sum of all data rows, and store it in the
     * {@link $this->aTotal} array.
     *
     * Also sets {@link $this->showTotals} to true, if required.
     *
     * @access private
     * @param array $aRows An array of rows of statistics to summarise.
     */
    function _summariseTotals(&$aRows)
    {
        parent::_summariseTotals($aRows);

        $this->_summarizeStats($this->aTotal);
    }
}

?>

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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Delivery/CommonCrossHistory.php';

/**
 * The class to display the delivery statistcs for the page:
 *
 * Statistics -> Advertisers & Campaigns -> Campaign Overview -> Banner Overview -> Publisher Distribution -> Distribution History
 *
 * @package    OpenadsAdmin
 * @subpackage StatisticsDelivery
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class OA_Admin_Statistics_Delivery_Controller_BannerAffiliateHistory extends OA_Admin_Statistics_Delivery_CommonCrossHistory
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
    function OA_Admin_Statistics_Delivery_Controller_BannerAffiliateHistory($aParams)
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
        $placementId  = (int)MAX_getValue('campaignid', '');
        $adId         = (int)MAX_getValue('bannerid', '');

        // Cross-entity
        $publisherId = (int)MAX_getValue('affiliateid', '');

        // Security check
        phpAds_checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Client);
        if (!MAX_checkAd($advertiserId, $placementId, $adId)) {
            phpAds_PageHeader('2');
            phpAds_Die ($GLOBALS['strAccessDenied'], $GLOBALS['strNotAdmin']);
        }

        // Fetch campaigns
        $aPublishers = $this->getBannerPublishers($adId, $placementId);

        // Cross-entity security check
        if (!isset($aPublishers[$publisherId])) {
            $this->noStatsAvailable = true;
        }

        // Add standard page parameters
        $this->aPageParams = array('clientid' => $advertiserId, 'campaignid' => $placementId, 'bannerid' => $adId);
        $this->aPageParams['affiliateid'] = $publisherId;
        $this->aPageParams['period_preset']  = MAX_getStoredValue('period_preset', 'today');
        $this->aPageParams['statsBreakdown'] = MAX_getStoredValue('statsBreakdown', 'day');

        $this->_loadParams();

        // HTML Framework
        if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
            $this->pageId = '2.1.2.2.2.1';
            $this->aPageSections = array($this->pageId);
        } elseif (phpAds_isUser(phpAds_Client)) {
            $this->pageId = '1.2.2.4.1';
            $this->aPageSections = array($this->pageId);
        }

        $this->_addBreadcrumbs('banner', $adId);
        $this->addCrossBreadcrumbs('publisher', $publisherId);

        // Add context
        $params = $this->aPageParams;
        foreach ($aPublishers as $k => $v){
            $params['affiliateid'] = $k;
            phpAds_PageContext (
                phpAds_buildName($k, MAX_getPublisherName($v['name'], null, $v['anonymous'], $k)),
                $this->_addPageParamsToURI($this->pageName, $params, true),
                $publisherId == $k
            );
        }

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

        $aParams = array();
        $aParams['ad_id']        = $adId;
        $aParams['publisher_id'] = $publisherId;

        $this->prepareHistory($aParams, 'stats.php?entity=banner&breakdown=daily');
    }

}

?>
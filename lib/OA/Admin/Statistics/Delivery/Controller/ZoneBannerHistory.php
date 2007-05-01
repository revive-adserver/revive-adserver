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
 * Statistics -> Publishers & Zones -> Zone Overview -> Campaign Distribution -> Distribution History
 *
 * @package    OpenadsAdmin
 * @subpackage StatisticsDelivery
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class OA_Admin_Statistics_Delivery_Controller_ZoneBannerHistory extends OA_Admin_Statistics_Delivery_CommonCrossHistory
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
    function OA_Admin_Statistics_Delivery_Controller_ZoneBannerHistory($aParams)
    {
        $this->__construct($aParams);
    }

    function start()
    {
        // Get the preferences
        $pref = $GLOBALS['_MAX']['PREF'];

        // Get parameters
        if (phpAds_isUser(phpAds_Affiliate)) {
            $publisherId = phpAds_getUserId();
        } else {
            $publisherId = (int)MAX_getValue('affiliateid', '');
        }
        $zoneId      = (int)MAX_getValue('zoneid', '');

        // Cross-entity
        $adId = (int)MAX_getValue('bannerid', 0);

        // Security check
        phpAds_checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Affiliate);
        if (!MAX_checkZone($publisherId, $zoneId)) {
            phpAds_PageHeader('2');
            phpAds_Die ($GLOBALS['strAccessDenied'], $GLOBALS['strNotAdmin']);
        }

        // Fetch campaigns
        $aAds = $this->getZoneBanners($zoneId);

        // Cross-entity security check
        if (!isset($aAds[$adId])) {
            $this->noStatsAvailable = true;
        }

        // Add standard page parameters
        $this->aPageParams = array('affiliateid' => $publisherId, 'zoneid' => $zoneId,
                                  'entity' => 'zone', 'breakdown' => 'banner-history'
                                 );
        $this->aPageParams['campaignid'] = $aAds[$adId]['placement_id'];
        $this->aPageParams['bannerid']   = $adId;
        $this->aPageParams['period_preset'] = MAX_getStoredValue('period_preset', 'today');
        $this->aPageParams['statsBreakdown'] = MAX_getStoredValue('statsBreakdown', 'day');

        $this->_loadParams();

        // HTML Framework
        if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
            $this->pageId = '2.4.2.2.2';
            $this->aPageSections = array($this->pageId);
        } elseif (phpAds_isUser(phpAds_Affiliate)) {
            $this->pageId = '1.2.2.2';
            $this->aPageSections = array($this->pageId);
        }

        $this->_addBreadcrumbs('zone', $zoneId);
        $this->addCrossBreadcrumbs('banner', $adId);

        // Add context
        $params = $this->aPageParams;
        foreach ($aAds as $k => $v){
            $params['campaignid'] = $v['placement_id'];
            $params['bannerid'] = $k;
            phpAds_PageContext (
                phpAds_buildName($k, MAX_getAdName($v['name'], null, null, $v['anonymous'], $k)),
                $this->_addPageParamsToURI($this->pageName, $params, true),
                $adId == $k
            );
        }

        // Add shortcuts
        if (!phpAds_isUser(phpAds_Affiliate)) {
            $this->_addShortcut(
                $GLOBALS['strAffiliateProperties'],
                'affiliate-edit.php?affiliateid='.$publisherId,
                'images/icon-affiliate.gif'
            );
        }

        $this->_addShortcut(
            $GLOBALS['strZoneProperties'],
            'zone-edit.php?affiliateid='.$publisherId.'&zoneid='.$zoneId,
            'images/icon-zone.gif'
        );

        $aParams = array();
        $aParams['zone_id'] = $zoneId;
        $aParams['ad_id'] = $adId;


        $this->aPageParams['breakdown'] = 'daily';

        $this->prepareHistory($aParams, 'stats.php');

        $this->aPageParams['breakdown'] = 'banner-history';
    }
}

?>

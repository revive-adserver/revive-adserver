<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
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

require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsHistoryController.php';



class StatsAffiliateHistoryController extends StatsHistoryController
{
    function start()
    {
        // Get the preferences
        $pref = $GLOBALS['_MAX']['PREF'];

        // Get parameters
        if (phpAds_isUser(phpAds_Affiliate)) {
            $publisherId = phpAds_getUserId();
            
            // Entry page for publishers
            if (!phpAds_isAllowed(MAX_AffiliateIsReallyAffiliate)) {
                $this->showPublisherWelcome();
            }
        } else {
            $publisherId = (int)MAX_getValue('affiliateid', '');
        }
        
        // Security check
        phpAds_checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Affiliate);
        if (!MAX_checkPublisher($publisherId)) {
            phpAds_PageHeader('2');
            phpAds_Die ($GLOBALS['strAccessDenied'], $GLOBALS['strNotAdmin']);
        }

        // Add standard page parameters
        $this->pageParams = array('affiliateid' => $publisherId,
                                  'entity'    => 'affiliate',
                                  'breakdown' => 'history',
                                  'statsBreakdown' => MAX_getStoredValue('statsBreakdown', 'history'));
        
        // HTML Framework
        if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
            $this->pageId = '2.4.1';
            $this->pageSections = array('2.4.1', '2.4.2', '2.4.3');
        } elseif (phpAds_isUser(phpAds_Affiliate)) {
            $this->pageId = '1.1';
            $this->pageSections[] = '1.1';
            if (phpAds_isAllowed(MAX_AffiliateViewZoneStats)) {
                $this->pageSections[] = '1.2';
            }
            $this->pageSections[] = '1.3';
        }
        
        $this->addBreadcrumbs('publisher', $publisherId);
        
        // Add context
        $this->pageContext = array('publishers', $publisherId);
        
        // Add shortcuts
        if (!phpAds_isUser(phpAds_Affiliate)) {
            $this->addShortcut(
                $GLOBALS['strAffiliateProperties'],
                'affiliate-edit.php?affiliateid='.$publisherId,
                'images/icon-affiliate.gif'
            );
        }
        
        // Use the day span selector
        $this->initDaySpanSelector();
        
        $aParams = array();
        $aParams['publisher_id'] = $publisherId;
        
        // Limit by advertiser
        $advertiserId = (int)MAX_getValue('clientid', '');
        if (!empty($advertiserId)) {
            $aParams['advertiser_id'] = $advertiserId;
        }

        $this->prepareHistory($aParams, 'stats.php?entity=affiliate&breakdown=daily');
    }
}

?>

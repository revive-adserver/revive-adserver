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

require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsCrossEntityController.php';



class StatsAffiliateCampaignsController extends StatsCrossEntityController
{
    function start()
    {
        // Get the preferences
        $pref = $GLOBALS['_MAX']['PREF'];

        // Get parameters
        if (phpAds_isUser(phpAds_Affiliate)) {
            $publisherId = phpAds_getUserId();
            
            // Entry page for affiliates
            if (phpAds_isAllowed(MAX_AffiliateIsReallyAffiliate)) {
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
        $this->pageParams = array('affiliateid' => $publisherId);
        $this->pageParams['period_preset']  = MAX_getStoredValue('period_preset', 'today');
        $this->pageParams['statsBreakdown'] = MAX_getStoredValue('statsBreakdown', 'day');

        $this->loadParams();

        // HTML Framework
        if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
            $this->pageId = '2.4.3';
            $this->pageSections = array('2.4.1', '2.4.2', '2.4.3');
        } elseif (phpAds_isUser(phpAds_Affiliate)) {
            $this->pageId = '1.3';
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

        // Fix entity links
        $this->entityLinks['c'] = 'stats.php?entity=affiliate&breakdown=campaign-history';
        $this->entityLinks['b'] = 'stats.php?entity=affiliate&breakdown=banner-history';

        // Use the day span selector
        $this->initDaySpanSelector();

        $this->hideInactive = MAX_getStoredValue('hideinactive', ($pref['gui_hide_inactive'] == 't'));
        $this->showHideInactive = true;

        $this->startLevel = MAX_getStoredValue('startlevel', 0);

        // Init nodes
        $this->aNodes   = MAX_getStoredArray('nodes', array());
        $expand         = MAX_getValue('expand', '');
        $collapse       = MAX_getValue('collapse');

        // Adjust which nodes are opened closed...
        MAX_adjustNodes($this->aNodes, $expand, $collapse);

        $aParams = array();
        $aParams['publisher_id'] = $publisherId;

        // Limit by advertiser
        $advertiserId = (int)MAX_getValue('clientid', '');
        if (!empty($advertiserId)) {
            $aParams['advertiser_id'] = $advertiserId;
        }
        
        // Limit by advertiser
        $advertiserId = (int)MAX_getValue('clientid', '');
        if (!empty($advertiserId)) {
            $aParams['advertiser_id'] = $advertiserId;
        }
        
        switch ($this->startLevel)
        {
            case 1:
                $this->entities = $this->getBanners($aParams, $this->startLevel, $expand, true);
                break;
            default:
                $this->startLevel = 0;
                $this->entities = $this->getCampaigns($aParams, $this->startLevel, $expand);
                break;
        }

        $this->summarizeTotals($this->entities);

        $this->showHideLevels = array();
        switch ($this->startLevel)
        {
            case 1:
                $this->showHideLevels = array(
                    0 => array('text' => $GLOBALS['strShowParentCampaigns'], 'icon' => 'images/icon-campaign.gif')
                );
                $this->hiddenEntitiesText = "{$this->hiddenEntities} {$GLOBALS['strInactiveBannersHidden']}";
                break;
            case 0:
                $this->showHideLevels = array(
                    1 => array('text' => $GLOBALS['strHideParentCampaigns'], 'icon' => 'images/icon-campaign-d.gif')
                );
                $this->hiddenEntitiesText = "{$this->hiddenEntities} {$GLOBALS['strInactiveCampaignsHidden']}";
                break;
        }


        // Save prefs
        $this->pagePrefs['startlevel']     = $this->startLevel;
        $this->pagePrefs['nodes']          = implode (",", $this->aNodes);
        $this->pagePrefs['hideinactive']   = $this->hideInactive;
        $this->pagePrefs['startlevel']     = $this->startLevel;
    }

}

?>

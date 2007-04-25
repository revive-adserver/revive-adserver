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

require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsByEntityController.php';



class StatsGlobalAdvertiserController extends StatsByEntityController
{
    function start()
    {
        // Security check
        phpAds_checkAccess(phpAds_Admin + phpAds_Agency);

        // Get the preferences
        $pref = $GLOBALS['_MAX']['PREF'];

        // HTML Framework
        $this->pageId = '2.1';
        $this->pageSections = array('2.1', '2.4', '2.2');

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
        if (!phpAds_isUser(phpAds_Admin)) {
            $aParams['agency_id'] = phpAds_getAgencyID();
        }

        switch ($this->startLevel)
        {
            case 2:
                $this->entities = $this->getBanners($aParams, $this->startLevel, $expand);
                break;
            case 1:
                $this->entities = $this->getCampaigns($aParams, $this->startLevel, $expand);
                break;
            default:
                $this->startLevel = 0;
                $this->entities = $this->getAdvertisers($aParams, $this->startLevel, $expand);
                break;
        }

        $this->summarizeTotals($this->entities);

        $this->showHideLevels = array();
        switch ($this->startLevel)
        {
            case 2:
                $this->showHideLevels = array(
                    0 => array('text' => $GLOBALS['strShowParentAdvertisers'], 'icon' => 'images/icon-advertiser.gif'),
                    1 => array('text' => $GLOBALS['strShowParentCampaigns'], 'icon' => 'images/icon-campaign.gif')
                );
                $this->hiddenEntitiesText = "{$this->hiddenEntities} {$GLOBALS['strInactiveBannersHidden']}";
                break;
            case 1:
                $this->showHideLevels = array(
                    0 => array('text' => $GLOBALS['strShowParentAdvertisers'], 'icon' => 'images/icon-advertiser.gif'),
                    2 => array('text' => $GLOBALS['strHideParentCampaigns'], 'icon' => 'images/icon-campaign-d.gif')
                );
                $this->hiddenEntitiesText = "{$this->hiddenEntities} {$GLOBALS['strInactiveCampaignsHidden']}";
                break;
            case 0:
                $this->showHideLevels = array(
                    1 => array('text' => $GLOBALS['strHideParentAdvertisers'], 'icon' => 'images/icon-advertiser-d.gif'),
                    2 => array('text' => $GLOBALS['strHideParentCampaigns'], 'icon' => 'images/icon-campaign-d.gif')
                );
                $this->hiddenEntitiesText = "{$this->hiddenEntities} {$GLOBALS['strInactiveAdvertisersHidden']}";
                break;
        }

        //location params
        $this->pageParams['entity']    = 'global';
        $this->pageParams['breakdown'] = 'advertiser';
        $this->pageParams['period_preset'] = MAX_getStoredValue('period_preset', 'today');
        $this->pageParams['statsBreakdown'] = MAX_getStoredValue('statsBreakdown', 'day');
        $this->pageParams['period_start'] = MAX_getStoredValue('period_start', date('Y-m-d'));
        $this->pageParams['period_end'] = MAX_getStoredValue('period_end', date('Y-m-d'));
        $this->loadParams();

        unset($this->pageParams['expand']);
        unset($this->pageParams['clientid']);
        unset($this->pageParams['collapse']);

        // Save prefs
        $this->pagePrefs['startlevel']   = $this->startLevel;
        $this->pagePrefs['nodes']        = implode (",", $this->aNodes);
        $this->pagePrefs['hideinactive'] = $this->hideInactive;
        $this->pagePrefs['startlevel']   = $this->startLevel;
    }

}

?>

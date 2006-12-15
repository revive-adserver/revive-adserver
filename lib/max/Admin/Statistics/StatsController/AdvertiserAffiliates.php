<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: AdvertiserAffiliates.php 5724 2006-10-16 06:03:30Z arlen $
*/

require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsCrossEntityController.php';



class StatsAdvertiserAffiliatesController extends StatsCrossEntityController
{
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


        // Security check
        phpAds_checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Client);
        if (!MAX_checkAdvertiser($advertiserId)) {
            phpAds_PageHeader('2');
            phpAds_Die ($GLOBALS['strAccessDenied'], $GLOBALS['strNotAdmin']);
        }

        // Add standard page parameters
        $this->pageParams = array('clientid' => $advertiserId,
                                  'period_preset' => MAX_getStoredValue('period_preset', 'today')
                                  );
        $this->loadParams();

        // HTML Framework
        if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
            $this->pageId = '2.1.3';
            $this->pageSections = array('2.1.1', '2.1.2', '2.1.3');
        } elseif (phpAds_isUser(phpAds_Client)) {
            $this->pageId = '1.3';
            $this->pageSections = array('1.1', '1.2', '1.3');
        }

        $this->addBreadcrumbs('advertiser', $advertiserId);

        // Add context
        $this->pageContext = array('advertisers', $advertiserId);

        // Add shortcuts
        if (!phpAds_isUser(phpAds_Client)) {
            $this->addShortcut(
                $GLOBALS['strClientProperties'],
                'advertiser-edit.php?clientid='.$advertiserId,
                'images/icon-advertiser.gif'
            );
        }

        // Fix entity links
        $this->entityLinks['p'] = 'stats.php?entity=advertiser&breakdown=affiliate-history';
        $this->entityLinks['z'] = 'stats.php?entity=advertiser&breakdown=zone-history';

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
        $aParams['advertiser_id'] = $advertiserId;

        // Limit by publisher
        $publisherId = (int)MAX_getValue('affiliateid', '');
        if (!empty($publisherId)) {
            $aParams['publisher_id'] = $publisherId;
        }
        
        // Limit by publisher
        $publisherId = (int)MAX_getValue('affiliateid', '');
        if (!empty($publisherId)) {
            $aParams['publisher_id'] = $publisherId;
        }
        
        switch ($this->startLevel)
        {
            case 1:
                $this->entities = $this->getZones($aParams, $this->startLevel, $expand, true);
                break;
            default:
                $this->startLevel = 0;
                $this->entities = $this->getPublishers($aParams, $this->startLevel, $expand);
                break;
        }

        $this->summarizeTotals($this->entities);

        $this->showHideLevels = array();
        switch ($this->startLevel)
        {
            case 1:
                $this->showHideLevels = array(
                    0 => array('text' => $GLOBALS['strShowParentAffiliates'], 'icon' => 'images/icon-affiliate.gif'),
                );
                $this->hiddenEntitiesText = "{$this->hiddenEntities} {$GLOBALS['strInactiveZonesHidden']}";
                break;
            case 0:
                $this->showHideLevels = array(
                    1 => array('text' => $GLOBALS['strHideParentAffiliates'], 'icon' => 'images/icon-affiliate-d.gif'),
                );
                $this->hiddenEntitiesText = "{$this->hiddenEntities} {$GLOBALS['strInactiveAffiliatesHidden']}";
                break;
        }


        // Save prefs
        $this->pagePrefs['startlevel']     = $this->startLevel;
        $this->pagePrefs['nodes']          = implode (",", $this->aNodes);
        $this->pagePrefs['hideinactive']   = $this->hideInactive;
    }

}

?>

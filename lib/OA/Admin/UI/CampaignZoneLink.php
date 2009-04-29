<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

/**
 * Helper methods for campaign zone linking
 */
class OA_Admin_UI_CampaignZoneLink
{
    const WEBSITES_PER_PAGE = 10;


    public static function createTemplateWithModel($panel, $single = true)
    {
        $agencyId   = OA_Permission::getAgencyId();
        $oDalZones  = OA_Dal::factoryDAL('zones');
        $infix = ($single ? '' : '-' . $panel);
        phpAds_registerGlobalUnslashed('action', 'campaignid', 'clientid', "category$infix", 
            "category$infix-text", "text$infix", "page$infix");
        
        $campaignId   = $GLOBALS['campaignid'];
        $category     = $GLOBALS["category$infix"]; 
        $categoryText = $GLOBALS["category$infix-text"]; 
        $text         = $GLOBALS["text$infix"];
        $linked       = ($panel == 'linked');
        
        $websites = $oDalZones->getWebsitesAndZonesListByCategory($agencyId, $category, $campaignId, $linked, $text);

        $pagerFileName = 'campaign-zone-zones.php';
        $pagerParams = array(
            'clientid' => $GLOBALS['clientid'],
            'campaignid' => $GLOBALS['campaignid'],
            'status' => $panel,
            'category' => $category,
            'category-text' => $categoryText,
            'text' => $text
        );
        
        $currentPage = null;
        if (!$single) {
            $currentPage = $GLOBALS["page$infix"];
        }
        
        $oTpl = new OA_Admin_Template('campaign-zone-zones.html');
        $oPager = OX_buildPager($websites, self::WEBSITES_PER_PAGE, true, 'websites', 
            2, $currentPage, $pagerFileName, $pagerParams);
        $oTopPager = OX_buildPager($websites, self::WEBSITES_PER_PAGE, false, 'websites', 
            2, $currentPage, $pagerFileName, $pagerParams);
        
        list ($itemsFrom, $itemsTo) = $oPager->getOffsetByPageId();
        $websites = array_slice($websites, $itemsFrom - 1, self::WEBSITES_PER_PAGE, true);
        
        $aZonesCounts = array (
                'all' => $oDalZones->countZones($agencyId, null, $campaignId, $linked),
                'matching' => $oDalZones->countZones($agencyId, $category, $campaignId, $linked, $text));
        $showingCount = 0;
        
        // TODO: currently we're calculating the number in PHP code. Once
        // MAX_Dal_Admin_Zones::countZones() supports the limit parameter, we can remove
        // the code below and use the dal.
        foreach ($websites as $website) {
            $showingCount += count($website['zones']);
        }
        $aZonesCounts['showing'] = $showingCount;
        
        $oTpl->assign('pager', $oPager);
        $oTpl->assign('topPager', $oTopPager);
        
        $oTpl->assign('websites', $websites);
        $oTpl->assign('zonescounts', $aZonesCounts);
        $oTpl->assign('category', $categoryText);
        $oTpl->assign('text', $text);
        $oTpl->assign('status', $panel);
        $oTpl->assign('page', $oTopPager->getCurrentPageID());
        
        return $oTpl;
    }
}

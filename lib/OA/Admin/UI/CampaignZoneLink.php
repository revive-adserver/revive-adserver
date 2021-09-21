<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

/**
 * Helper methods for campaign zone linking
 */
class OA_Admin_UI_CampaignZoneLink
{
    public const WEBSITES_PER_PAGE = 10;


    public static function createTemplateWithModel($panel, $single = true)
    {
        $agencyId = OA_Permission::getAgencyId();
        $oDalZones = OA_Dal::factoryDAL('zones');
        $infix = ($single ? '' : '-' . $panel);
        phpAds_registerGlobalUnslashed('action', 'campaignid', 'clientid', "text$infix", "page$infix");

        $campaignId = $GLOBALS['campaignid'];
        $text = $GLOBALS["text$infix"];
        $linked = ($panel == 'linked');
        $showStats = !empty($GLOBALS['_MAX']['CONF']['ui']['zoneLinkingStatistics']);

        $websites = $oDalZones->getWebsitesAndZonesList($agencyId, $campaignId, $linked, $text);

        $matchingZones = 0;
        foreach ($websites as $aWebsite) {
            $matchingZones += count($aWebsite['zones']);
        }

        $aZonesCounts = [
                'all' => $oDalZones->countZones($agencyId, null, $campaignId, $linked),
                'matching' => $matchingZones
        ];

        $pagerFileName = 'campaign-zone-zones.php';
        $pagerParams = [
            'clientid' => $GLOBALS['clientid'],
            'campaignid' => $GLOBALS['campaignid'],
            'status' => $panel,
            'text' => $text
        ];

        $currentPage = null;
        if (!$single) {
            $currentPage = $GLOBALS["page$infix"];
        }

        $oTpl = new OA_Admin_Template('campaign-zone-zones.html');
        $oPager = OX_buildPager(
            $websites,
            self::WEBSITES_PER_PAGE,
            true,
            'websites',
            2,
            $currentPage,
            $pagerFileName,
            $pagerParams
        );
        $oTopPager = OX_buildPager(
            $websites,
            self::WEBSITES_PER_PAGE,
            false,
            'websites',
            2,
            $currentPage,
            $pagerFileName,
            $pagerParams
        );

        list($itemsFrom, $itemsTo) = $oPager->getOffsetByPageId();
        $websites = array_slice($websites, $itemsFrom - 1, self::WEBSITES_PER_PAGE, true);

        // Add statistics for the displayed zones if required
        if ($showStats) {
            $oDalZones->mergeStatistics($websites, $campaignId);
        }

        // Count how many zone are displayed
        $showingCount = 0;
        foreach ($websites as $website) {
            $showingCount += count($website['zones']);
        }
        $aZonesCounts['showing'] = $showingCount;

        $oTpl->assign('pager', $oPager);
        $oTpl->assign('topPager', $oTopPager);

        $oTpl->assign('websites', $websites);
        $oTpl->assign('zonescounts', $aZonesCounts);
        $oTpl->assign('text', $text);
        $oTpl->assign('status', $panel);
        $oTpl->assign('page', $oTopPager->getCurrentPageID());

        $oTpl->assign('showStats', $showStats);
        $oTpl->assign('colspan', ($showStats ? 6 : 3));

        return $oTpl;
    }
}

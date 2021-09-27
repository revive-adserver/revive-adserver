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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/Search.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-gui.inc.php';

phpAds_registerGlobalUnslashed('keyword', 'client', 'campaign', 'banner', 'zone', 'affiliate', 'compact');

OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);


// Check Searchselection
if (!isset($client) || ($client != 't')) {
    $client = false;
}
if (!isset($campaign) || ($campaign != 't')) {
    $campaign = false;
}
if (!isset($banner) || ($banner != 't')) {
    $banner = false;
}
if (!isset($zone) || ($zone != 't')) {
    $zone = false;
}
if (!isset($affiliate) || ($affiliate != 't')) {
    $affiliate = false;
}


if ($client == false && $campaign == false &&
    $banner == false && $zone == false &&
    $affiliate == false) {
    $client = true;
    $campaign = true;
    $banner = true;
    $zone = true;
    $affiliate = true;
}

if (!isset($compact)) {
    $compact = false;
}

if (!isset($keyword)) {
    $keyword = '';
}

OA_Dal::factoryDO('Campaigns');
OA_Dal::factoryDO('Clients');

// Send header with charset info
header("Content-Type: text/html" . (isset($phpAds_CharSet) && $phpAds_CharSet != "" ? "; charset=" . $phpAds_CharSet : ""));

$agencyId = OA_Permission::getAgencyId();

$aZones = $aAffiliates = $aClients = $aBanners = $aCampaigns = [];

if ($client != false) {
    $dalClients = OA_Dal::factoryDAL('clients');
    $rsClients = $dalClients->getClientByKeyword($keyword, $agencyId);
    $rsClients->find();

    while ($rsClients->fetch()) {
        $aClient = $rsClients->toArray();
        $aClient['clientname'] = phpAds_breakString($aClient['clientname'], '30');
        $aClient['campaigns'] = [];

        if (!$compact) {
            $dalCampaigns = OA_Dal::factoryDAL('campaigns');
            $aClientCampaigns = $dalCampaigns->getClientCampaigns($aClient['clientid']);

            foreach ($aClientCampaigns as $campaignId => $aCampaign) {
                $aCampaign['campaignname'] = phpAds_breakString($aCampaign['campaignname'], '30');
                $aCampaign['campaignid'] = $campaignId;
                $aCampaign['banners'] = [];
                $dalBanners = OA_Dal::factoryDAL('banners');
                $aCampaignBanners = $dalBanners->getAllBannersUnderCampaign($campaignId, '', '');
                foreach ($aCampaignBanners as $aBanner) {
                    $aBanner['name'] = $GLOBALS['strUntitled'];
                    if (!empty($aBanner['alt'])) {
                        $aBanner['name'] = $aBanner['alt'];
                    }
                    if (!empty($aBanner['description'])) {
                        $aBanner['name'] = $aBanner['description'];
                    }

                    $aBanner['name'] = phpAds_breakString($aBanner['name'], '30');
                    $aCampaign['banners'][] = $aBanner;
                }
                $aClient['campaigns'][] = $aCampaign;
            }
        }
        $aClients[] = $aClient;
    }
}

if ($campaign != false) {
    $dalCampaigns = OA_Dal::factoryDAL('campaigns');
    $rsCampaigns = $dalCampaigns->getCampaignAndClientByKeyword($keyword, $agencyId);
    $rsCampaigns->find();
    while ($rsCampaigns->fetch()) {
        $aCampaign = $rsCampaigns->toArray();
        $aCampaign['campaignname'] = phpAds_breakString($aCampaign['campaignname'], '30');
        $aCampaign['banners'] = [];

        if (!$compact) {
            $dalBanners = OA_Dal::factoryDAL('banners');
            $aCampaignBanners = $dalBanners->getAllBannersUnderCampaign($aCampaign['campaignid'], '', '');
            foreach ($aCampaignBanners as $aBanner) {
                $aBanner['name'] = $GLOBALS['strUntitled'];
                if (!empty($aBanner['alt'])) {
                    $aBanner['name'] = $aBanner['alt'];
                }
                if (!empty($aBanner['description'])) {
                    $aBanner['name'] = $aBanner['description'];
                }
                $aBanner['name'] = phpAds_breakString($aBanner['name'], '30');

                $aCampaign['banners'][] = $aBanner;
            }
        }
        $aCampaigns[] = $aCampaign;
    }
}


if ($banner != false) {
    $dalBanners = OA_Dal::factoryDAL('banners');
    $rsBanners = $dalBanners->getBannerByKeyword($keyword, $agencyId);
    $rsBanners->reset();
    while ($rsBanners->fetch()) {
        $aBanner = $rsBanners->toArray();

        $aBanner['name'] = $GLOBALS['strUntitled'];
        if (isset($aBanner['alt']) && $aBanner['alt']) {
            $aBanner['name'] = $aBanner['alt'];
        }
        if (isset($aBanner['description']) && $aBanner['description']) {
            $aBanner['name'] = $aBanner['description'];
        }
        $aBanner['name'] = phpAds_breakString($aBanner['name'], '30');

        $aBanners[] = $aBanner;
    }
}

if ($affiliate != false) {
    $dalAffiliates = OA_Dal::factoryDAL('affiliates');
    $rsAffiliates = $dalAffiliates->getAffiliateByKeyword($keyword, $agencyId);
    $rsAffiliates->reset();

    while ($rsAffiliates->fetch()) {
        $aAffiliate = $rsAffiliates->toArray();
        $aAffiliate['name'] = phpAds_breakString($aAffiliate['name'], '30');

        if (!$compact) {
            $doZones = OA_Dal::factoryDO('zones');
            $doZones->affiliateid = $aAffiliate['affiliateid'];
            $doZones->find();

            while ($doZones->fetch()) {
                $aZone = $doZones->toArray();
                $aZone['zonename'] = phpAds_breakString($aZone['zonename'], '30');

                $aAffiliate['zones'][] = $aZone;
            }
        }

        $aAffiliates[] = $aAffiliate;
    }
}

if ($zone != false) {
    $dalZones = OA_Dal::factoryDAL('zones');
    $rsZones = $dalZones->getZoneByKeyword($keyword, $agencyId);
    $rsZones->find();
    while ($rsZones->fetch()) {
        $aZone = $rsZones->toArray();
        $aZone['zonename'] = phpAds_breakString($aZone['zonename'], '30');

        $aZones[] = $aZone;
    }
}

$matchesFound = !(empty($aZones) && empty($aAffiliates) && empty($aClients) && empty($aBanners) && empty($aCampaigns));

$oTpl = new OA_Admin_Template('admin-search.html');

$oTpl->assign('matchesFound', $matchesFound);

$oTpl->assign('keyword', $keyword);
$oTpl->assign('compact', $compact);

$oTpl->assign('client', $client);
$oTpl->assign('campaign', $campaign);
$oTpl->assign('banner', $banner);
$oTpl->assign('affiliate', $affiliate);
$oTpl->assign('zone', $zone);

$oTpl->assign('aClients', $aClients);
$oTpl->assign('aCampaigns', $aCampaigns);
$oTpl->assign('aBanners', $aBanners);
$oTpl->assign('aAffiliates', $aAffiliates);
$oTpl->assign('aZones', $aZones);


$oUI = new OA_Admin_UI_Search();

$oUI->showSearchHeader($keyword);
$oTpl->display();
$oUI->showFooter();

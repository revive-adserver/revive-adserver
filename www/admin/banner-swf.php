<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-storage.inc.php';
require_once MAX_PATH . '/www/admin/lib-swf.inc.php';
require_once MAX_PATH . '/www/admin/lib-banner.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';

// Register input variables
phpAds_registerGlobalUnslashed('convert', 'cancel', 'compress', 'convert_links',
                       'chosen_link', 'overwrite_link', 'overwrite_target',
                       'overwrite_source');


/*-------------------------------------------------------*/
/* Client interface security                             */
/*-------------------------------------------------------*/

MAX_Permission::checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Client);
MAX_Permission::checkIsAllowed(phpAds_ModifyBanner);
if (phpAds_isUser(phpAds_Agency)) {
    MAX_Permission::checkAccessToObject('banners', $bannerid);
    MAX_Permission::checkAccessToObject('campaigns', $campaignid);
    MAX_Permission::checkAccessToObject('clients', $clientid);
}
if (phpAds_isUser(phpAds_Client)) {
    MAX_Permission::checkAccessToObject('banners', $bannerid);
    $doBanners = OA_Dal::factoryDO('banners');
    $doBanners->get($bannerid);
    $campaignid = $doBanners->campaignid;
}

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/

if (isset($convert)) {
    $doBanners = OA_Dal::factoryDO('banners');
    $doBanners->get($bannerid);
    $row = $doBanners->toArray();

    if ($row['storagetype'] == 'sql' || $row['storagetype'] == 'web') {
        $swf_file = phpAds_ImageRetrieve ($row['storagetype'], $row['filename']);
    }
    if ($swf_file) {
        if (phpAds_SWFVersion($swf_file) >= 3 && phpAds_SWFInfo($swf_file)) {
            // SWF's requiring player version 6+ which are already compressed should stay compressed
            if (phpAds_SWFVersion($swf_file) >= 6 && phpAds_SWFCompressed($swf_file)) {
                $compress = true;
            } elseif (isset($compress)) {
                $compress = true;
            } else {
                $compress = false;
            }

            if (!isset($convert_links)) {
                $convert_links = array();
            }

            list($result, $parameters) = phpAds_SWFConvert($swf_file, $compress, $convert_links);

            if ($result != $swf_file) {
                if (count($parameters) > 0) {
                    // Set default link
                    $row['url']    = $overwrite_link[$chosen_link];
                    $row['target'] = $overwrite_target[$chosen_link];

                    // Prepare the parameters
                    $parameters_complete = array();

                    while (list($key, $val) = each($parameters)) {
                        if (isset($overwrite_source) && $overwrite_source[$val] != '') {
                            $overwrite_link[$val] .= '|source:'.$overwrite_source[$val];
                        }
                        $parameters_complete[$key] = array(
                            'link' => $overwrite_link[$val],
                            'tar'  => $overwrite_target[$val]
                        );
                    }
                    $parameters = array('swf' => $parameters_complete);
                } else {
                    $parameters = '';
                }

                $row['pluginversion'] = phpAds_SWFVersion($result);
                $row['htmltemplate']  = $row['htmltemplate'];

                // Store the HTML Template
                $doBanners = OA_Dal::factoryDO('banners');
                $doBanners->get($bannerid);
                $doBanners->url = $row['url'];
                $doBanners->target = $row['target'];
                $doBanners->pluginversion = $row['pluginversion'];
                $doBanners->htmltemplate = $row['htmltemplate'];
                $doBanners->parameters = empty($parameters) ? null : serialize($parameters);
                $doBanners->update();

                // Store the banner
                phpAds_ImageStore ($row['storagetype'], $row['filename'], $result, true);

                // Rebuild cache
                // require_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
                // phpAds_cacheDelete();
            }
        }
    }

    if (phpAds_isUser(phpAds_Client)) {
        header('Location: stats.php?entity=campaign&breakdown=banners&clientid='.$clientid.'&campaignid='.$campaignid);
    } else {
        header('Location: banner-acl.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid);
    }
    exit;
}

if (isset($cancel)) {
    if (phpAds_isUser(phpAds_Client)) {
        header('Location: stats.php?entity=campaign&breakdown=banners&clientid='.$clientid.'&campaignid='.$campaignid);
    } else {
        header('Location: banner-acl.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid);
    }
    exit;
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if ($bannerid != '') {
    if (isset($session['prefs']['campaign-banners.php'][$campaignid]['listorder'])) {
        $navorder = $session['prefs']['campaign-banners.php'][$campaignid]['listorder'];
    } else {
        $navorder = '';
    }
    if (isset($session['prefs']['campaign-banners.php'][$campaignid]['orderdirection'])) {
        $navdirection = $session['prefs']['campaign-banners.php'][$campaignid]['orderdirection'];
    } else {
        $navdirection = '';
    }

    // Get other banners
    $doBanners = OA_Dal::factoryDO('banners');
    $doBanners->campaignid = $campaignid;
    $doBanners->addListOrderBy($navorder, $navdirection);
    $doBanners->find();

    while ($doBanners->fetch() && $row = $doBanners->toArray()) {
        phpAds_PageContext (
            phpAds_buildBannerName ($row['bannerid'], $row['description'], $row['alt']),
            "banner-edit.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$row['bannerid'],
            $bannerid == $row['bannerid']
        );
    }

    if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
        phpAds_PageShortcut($strClientProperties, 'advertiser-edit.php?clientid='.$clientid, 'images/icon-advertiser.gif');
        phpAds_PageShortcut($strCampaignProperties, 'campaign-edit.php?clientid='.$clientid.'&campaignid='.$campaignid, 'images/icon-campaign.gif');
        phpAds_PageShortcut($strBannerHistory, 'stats.php?entity=banner&breakdown=history&clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid, 'images/icon-statistics.gif');

        phpAds_PageHeader("4.1.3.4.5");
        echo "<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;".phpAds_getParentClientName($campaignid);
        echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
        echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getCampaignName($campaignid);
        echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
        echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerid)."</b><br /><br />";
        echo phpAds_buildBannerCode($bannerid)."<br /><br /><br /><br />";
        phpAds_ShowSections(array("4.1.3.4.5"));
    } else {
        phpAds_PageHeader("1.2.2.3");
        echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getCampaignName($campaignid);
        echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
        echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerid)."</b><br /><br />";
        echo phpAds_buildBannerCode($bannerid)."<br /><br /><br /><br />";
        phpAds_ShowSections(array("1.2.2.3"));
    }

    $doBanners = OA_Dal::factoryDO('banners');
    $doBanners->get($bannerid);
    $row = $doBanners->toArray();

    if ($row['contenttype'] == 'swf') {
        if ($row['storagetype'] == 'sql' || $row['storagetype'] == 'web') {
            $swf_file = phpAds_ImageRetrieve ($row['storagetype'], $row['filename']);
        }
    } else {
        // Banner is not a flash banner, return to banner-edit.php
        header("Location: banner-edit.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$bannerid);
        exit;
    }
} else {
    // Banner does not exist, return to banner-edit.php
    header("Location: banner-edit.php?clientid=".$clientid."&campaignid=".$campaignid);
    exit;
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$result = phpAds_SWFInfo($swf_file);
$version = phpAds_SWFVersion($swf_file);
$compressed = phpAds_SWFCompressed($swf_file);

if ($result) {
    echo $strConvertSWF.'<br />';
    echo "<table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='#F6F6F6'>";
    echo "<form action='banner-swf.php' method='post'>";
    echo "<input type='hidden' name='clientid' value='$clientid'>";
    echo "<input type='hidden' name='campaignid' value='$campaignid'>";
    echo "<input type='hidden' name='bannerid' value='$bannerid'>";

    echo "<tr><td height='25' colspan='4' bgcolor='#FFFFFF'><img src='images/".$phpAds_TextDirection."/icon-undo.gif' align='absmiddle'>&nbsp;<b>".$strHardcodedLinks."</b></td></tr>";
    echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
    echo "<tr><td height='10' colspan='4'>&nbsp;</td></tr>";

    $i=0;
    while (list($key, $val) = each($result)) {
        list ($url, $target) = $val;

        if ($i > 0) {
            echo "<tr><td height='20' colspan='4'>&nbsp;</td></tr>";
            echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
            echo "<tr><td height='10' colspan='4'>&nbsp;</td></tr>";
        }

        echo "<tr><td width='30'>&nbsp;</td><td width='30'><input type='checkbox' name='convert_links[]' value='".$key."' checked></td>";
        echo "<td width='200'>".$strURL."</td>";
        echo "<td><input class='flat' size='35' type='text' name='overwrite_link[".$key."]' style='width:300px;' dir='ltr' ";
        echo " value='".phpAds_htmlQuotes($url)."'>";
        echo "<input type='radio' name='chosen_link' value='".$key."'".($i == 0 ? ' checked' : '')."></td></tr>";

        echo "<tr><td colspan='2'><img src='images/spacer.gif' height='1' width='100%'></td>";
        echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

        echo "<tr><td width='30'>&nbsp;</td><td width='30'>&nbsp;</td>";
        echo "<td width='200'>".$strTarget."</td>";
        echo "<td><input class='flat' size='16' type='text' name='overwrite_target[".$key."]' style='width:150px;' dir='ltr' ";
        echo " value='".phpAds_htmlQuotes($target)."'>";
        echo "</td></tr>";

        if (count($result) > 1) {
            echo "<tr><td colspan='2'><img src='images/spacer.gif' height='1' width='100%'></td>";
            echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

            echo "<tr><td width='30'>&nbsp;</td><td width='30'>&nbsp;</td>";
            echo "<td width='200'>".$strOverwriteSource."</td>";
            echo "<td><input class='flat' size='50' type='text' name='overwrite_source[".$key."]' style='width:150px;' dir='ltr' value=''>";
            echo "</td></tr>";
        }
        $i++;
    }

    echo "<tr><td height='20' colspan='4'>&nbsp;</td></tr>";
    echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
    echo "</table>";
    echo "<br /><br />";

    echo "<input type='submit' name='cancel' value='".$strCancel."'>&nbsp;&nbsp;";
    echo "<input type='submit' name='convert' value='".$strConvert."'>";

    if (function_exists('gzcompress')) {
        echo "&nbsp;&nbsp;<input type='checkbox' name='compress' value='true'".($compressed ? ' checked' : '').($version >= 6 && $compressed ? ' disabled' : '').">";
        echo "&nbsp;".$strCompressSWF;
    }
    echo "</form>";
    echo "<br /><br />";
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>

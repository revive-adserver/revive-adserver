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
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
OA_Permission::enforceAccessToObject('banners', $bannerid);

$aBanner = Admin_DA::getAd((int) $bannerid);

if (!empty($aBanner)) {
    $conf = $GLOBALS['_MAX']['CONF'];
    $bannerName = phpAds_buildBannerName($bannerid, $aBanner['name'], $aBanner['alt'], 30, false);
    [$width, $height, $autoSize] = MAX_bannerPreviewSize($aBanner);
    // Frames of banners without a specified size are resized to their content, so don't constrain the cell
    $cellWidth = $autoSize ? '' : " width='{$width}'";
    $rowHeight = $autoSize ? '' : " height='{$height}'";
    $sizeDescription = ($aBanner['type'] == 'txt' || $autoSize) ? '&nbsp;' : "&nbsp;&nbsp;&nbsp;width: {$width}&nbsp;&nbsp;height: {$height}";
    $bannerCode = MAX_bannerPreview($bannerid, $aBanner);
    echo "
<html>
<head>
<title>$bannerName</title>
<link rel='stylesheet' href='" . OX::assetPath() . "/css/interface-$phpAds_TextDirection.css'>
<script src='" . OX::assetPath() . "/js/ox.bannerpreview.js'></script>
</head>
<body marginheight='0' marginwidth='0' leftmargin='0' topmargin='0' bgcolor='#EFEFEF' data-revive-preview-popup='1'>
<table cellpadding='0' cellspacing='0' border='0'>
<tr height='32'>
    <td width='32'><img src='" . OX::assetPath() . "/images/cropmark-tl.gif' width='32' height='32'></td>
    <td background='" . OX::assetPath() . "/images/ruler-top.gif'>&nbsp;</td>
    <td width='32'><img src='" . OX::assetPath() . "/images/cropmark-tr.gif' width='32' height='32'></td>
</tr>
<tr{$rowHeight}>
    <td width='32' background='" . OX::assetPath() . "/images/ruler-left.gif'>&nbsp;</td>
    <td bgcolor='#FFFFFF'{$cellWidth}>
        $bannerCode
    </td>
    <td width='32'>&nbsp;</td>
</tr>
<tr height='32'>
    <td width='32'><img src='" . OX::assetPath() . "/images/cropmark-bl.gif' width='32' height='32'></td>
    <td>$sizeDescription</td>
    <td width='32'><img src='" . OX::assetPath() . "/images/cropmark-br.gif' width='32' height='32'></td>
</tr>
</table>
</body>
</html>";
}

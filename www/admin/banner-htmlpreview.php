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
require_once MAX_PATH . '/lib/max/Delivery/adRender.php';
require_once MAX_PATH . '/lib/max/Admin_DA.php';

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$aBanner = Admin_DA::getAd((int) $bannerid);
$aBanner['bannerid'] = $aBanner['ad_id'];

if (!empty($aBanner))
{
    $conf               = $GLOBALS['_MAX']['CONF'];
    $bannerName         = strip_tags(phpAds_buildBannerName ($bannerid, $aBanner['name'], $aBanner['alt']));
    $sizeDescription    = ($aBanner['type'] == 'txt') ? '&nbsp;' : "&nbsp;&nbsp;&nbsp;width: {$aBanner['width']}&nbsp;&nbsp;height: {$aBanner['height']}";
    $bannerCode         = MAX_adRender($aBanner, 0, '', '', '', true, '', false, false);
    $protocol           = $GLOBALS['_MAX']['SSL_REQUEST'] ? "https" : "http";
    $deliveryUrl        = $protocol .':'. MAX_commonConstructPartialDeliveryUrl($conf['file']['flash']);
    echo "
<html>
<head>
<title>$bannerName</title>
<link rel='stylesheet' href='" . OX::assetPath() . "/css/interface-$phpAds_TextDirection.css'>
<script type='text/javascript' src='$deliveryUrl'></script>
</head>
<body marginheight='0' marginwidth='0' leftmargin='0' topmargin='0' bgcolor='#EFEFEF'>
<table cellpadding='0' cellspacing='0' border='0'>
<tr height='32'>
    <td width='32'><img src='" . OX::assetPath() . "/images/cropmark-tl.gif' width='32' height='32'></td>
    <td background='" . OX::assetPath() . "/images/ruler-top.gif'>&nbsp;</td>
    <td width='32'><img src='" . OX::assetPath() . "/images/cropmark-tr.gif' width='32' height='32'></td>
</tr>
<tr height='{$aBanner['height']}'>
    <td width='32' background='" . OX::assetPath() . "/images/ruler-left.gif'>&nbsp;</td>
    <td bgcolor='#FFFFFF' width='{$aBanner['width']}'>
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


?>

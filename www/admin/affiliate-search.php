<?php // $Revision: 1.0

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-gui.inc.php';

// Register input variables
phpAds_registerGlobal ('keyword', 'client', 'campaign', 'banner', 'zone', 'affiliate', 'compact');

// Security check
MAX_Permission::checkAccess(phpAds_Affiliate);

// Check Searchselection
if (!isset($campaign))  $campaign  = false;
if (!isset($banner))    $banner    = false;
if (!isset($zone))      $zone      = false;

if ($campaign == false && $banner == false && $zone == false) {
    $campaign = true;
    $banner = true;
    $zone = true;
}

// Disable some entities
$client    = false;
$affiliate = false;


if (!isset($compact))
    $compact = false;

if (!isset($keyword))
    $keyword = '';

?>

<html<?php echo $phpAds_TextDirection != 'ltr' ? " dir='".$phpAds_TextDirection."'" : '' ?>>
    <head>
        <title><?php echo strip_tags($strSearch); ?></title>
        <meta http-equiv='Content-Type' content='text/html<?php echo isset($phpAds_CharSet) && $phpAds_CharSet != "" ? "; charset=".$phpAds_CharSet : "" ?>'>
        <meta name='author' content='Max Media Manager - http://sourceforge.net/projects/max'>
        <link rel='stylesheet' href='images/<?php echo $phpAds_TextDirection; ?>/interface.css'>
        <script language='JavaScript' src='interface.js'></script>
        <script language='JavaScript'>
        <!--
            function GoOpener(url, reload)
            {
                opener.location.href = url;

                if (reload == true)
                {
                    // Reload
                    document.search.submit();
                }
            }
        //-->
        </script>
    </head>

<body bgcolor='#FFFFFF' text='#000000' leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>
<?php
    phpAds_writeHeader(true, true, $client, $campaign, $banner, $zone, $affiliate, $compact);
?>
<!-- Top -->
<br />

<!-- Search selection -->
<table width='100%' cellpadding='0' cellspacing='0' border='0'>
    <tr><td width='20'>&nbsp;</td><td>

    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
        <form name='searchselection' action=''>
        <input type='hidden' name='keyword' value='<?php echo htmlspecialchars($keyword); ?>'>
        <tr>
            <td nowrap><input type='checkbox' name='campaign' value='t'<?php echo ($campaign ? ' checked': ''); ?> onClick='this.form.submit()'>
                <?php echo $strCampaign; ?>&nbsp;&nbsp;&nbsp;</td>
            <td nowrap><input type='checkbox' name='banner' value='t'<?php echo ($banner ? ' checked': ''); ?> onClick='this.form.submit()'>
                <?php echo $strBanners; ?>&nbsp;&nbsp;&nbsp;</td>
            <td nowrap><input type='checkbox' name='zone' value='t'<?php echo ($zone ? ' checked': ''); ?> onClick='this.form.submit()'>
                <?php echo $strZones; ?>&nbsp;&nbsp;&nbsp;</td>
            <td width='100%'>&nbsp;</td>
            <td nowrap align='right'><input type='checkbox' name='compact' value='t'<?php echo ($compact ? ' checked': ''); ?> onClick='this.form.submit()'>
                <?php echo $strCompact; ?>&nbsp;&nbsp;&nbsp;</td>
        </tr>
        </form>
    </table>

    </td><td width='20'>&nbsp;</td></tr>
</table>

<!-- Seperator -->
<img src='images/break-el.gif' height='1' width='100%' vspace='5'>
<br /><br />

<!-- Search Results -->
<table width='100%' cellpadding='0' cellspacing='0' border='0'>
<tr><td width='20'>&nbsp;</td><td>

<?php
    $publisherId = phpAds_getUserID();    
    
    $dalBanners = MAX_DB::factoryDAL('banners');
    $rsBanners = $dalBanners->getBannerByKeyword($keyword);
    $rsBanners->find();
    
    $dalCampaigns = MAX_DB::factoryDAL('campaigns');
    $rsCampaigns = $dalCampaigns->getCampaignAndClientByKeyword($keyword);
    $rsCampaigns->find();
    
    $dalZones = MAX_DB::factoryDAL('zones');
    $rsZones = $dalZones->getZoneByKeyword($keyword, null, $publisherId);
    $rsZones->find();
    
    $foundMatches = false;
    if ($rsCampaigns->getRowCount() ||
        $rsBanners->getRowCount() ||
        $rsZones->getRowCount())
    {
        $foundMatches = true;
        
        echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
        echo "<tr height='25'>";
        echo "<td height='25'><b>&nbsp;&nbsp;".$GLOBALS['strName']."</b></td>";
        echo "<td height='25'><b>".$GLOBALS['strID']."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
        echo "<td height='25'>&nbsp;</td>";
        echo "<td height='25'>&nbsp;</td>";
        echo "<td height='25'>&nbsp;</td>";
        echo "</tr>";

        echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
    }


    $i=0;


    if ($campaign && $rsCampaigns->getRowCount())
    {
        while ($rsCampaigns->fetch() && $row_campaigns = $rsCampaigns->toArray())
        {
            $doPlacement_zone_assoc = MAX_DB::factoryDO('placement_zone_assoc');
            $doPlacement_zone_assoc->publisher_id = $publisherId;
            $doPlacement_zone_assoc->placement_id = $row_campaigns['campaignid'];
            if (!$doPlacement_zone_assoc->count()) {
                continue;
            }

            if ($i > 0) echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";

            echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";

            echo "<td height='25'>";
            echo "&nbsp;&nbsp;";
            echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;";
            echo $row_campaigns['campaignname'];
            echo "</td>";

            echo "<td height='25'>".$row_campaigns['campaignid']."</td>";

            // Empty
            echo "<td>&nbsp;</td>";

            // Button 1
            echo "<td height='25'>";
            echo "<a href='JavaScript:GoOpener(\"stats.php?entity=affiliate&breakdown=campaign-history&affiliateid=".phpAds_getUserId()."&clientid=".$row_campaigns['clientid']."&campaignid=".$row_campaigns['campaignid']."\")'><img src='images/icon-statistics.gif' border='0' align='absmiddle' alt='$strStats'>&nbsp;$strStats</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "</td>";


            if (!$compact)
            {
                $doBanners = MAX_DB::factoryDO('banners');
                $doBanners->campaignid = $row_campaigns['campaignid'];
                $doBanners->find();

                $doAd_zone_assoc = MAX_DB::factoryDO('ad_zone_assoc');
                $doAd_zone_assoc->publisher_id = $publisherId;
                $doAd_zone_assoc->placement_id = $row_campaigns['campaignid'];
                $aAds = $doAd_zone_assoc->getAll(array('ad_id'));
                
                while ($doBanners->fetch() && $row_b_expand = $doBanners->toArray())
                {
                    if (!isset($aAds[$row_b_expand['bannerid']])) {
                        continue;
                    }

                    $name = $strUntitled;
                    if (isset($row_b_expand['alt']) && $row_b_expand['alt'] != '') $name = $row_b_expand['alt'];
                    if (isset($row_b_expand['description']) && $row_b_expand['description'] != '') $name = $row_b_expand['description'];

                    $name = phpAds_breakString ($name, '30');

                    echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";

                    echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";

                    echo "<td height='25'>";
                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

                    if ($row_b_expand['type'] == 'html')
                    {
                        echo "<img src='images/icon-banner-html.gif' align='absmiddle'>&nbsp;";
                    }
                    elseif ($row_b_expand['type'] == 'url')
                    {
                        echo "<img src='images/icon-banner-url.gif' align='absmiddle'>&nbsp;";
                    }
                    else
                    {
                        echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";
                    }
                    echo $name;
                    echo "</td>";

                    echo "<td height='25'>".$row_b_expand['bannerid']."</td>";

                    // Empty
                    echo "<td>&nbsp;</td>";

                    // Button 1
                    echo "<td height='25'>";
                    echo "<a href='JavaScript:GoOpener(\"stats.php?entity=affiliate&breakdown=banner-history&affiliateid=".phpAds_getUserId()."&clientid=".$row_campaigns['clientid']."&campaignid=".$row_campaigns['campaignid']."&bannerid=".$row_b_expand['bannerid']."\")'><img src='images/icon-statistics.gif' border='0' align='absmiddle' alt='$strStats'>&nbsp;$strStats</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                    echo "</td>";
                }
            }

            $i++;
        }
    }

    if ($banner && $rsBanners->getRowCount())
    {
        while ($rsBanners->fetch() && $row_banners = $rsBanners->toArray())
        {
            $doAd_zone_assoc = MAX_DB::factoryDO('ad_zone_assoc');
            $doAd_zone_assoc->publisher_id = $publisherId;
            $doAd_zone_assoc->ad_id = $row_banners['bannerid'];
            if(!$doAd_zone_assoc->count()) {
                continue;
            }

            $name = $strUntitled;
            if (isset($row_banners['alt']) && $row_banners['alt'] != '') $name = $row_banners['alt'];
            if (isset($row_banners['description']) && $row_banners['description'] != '') $name = $row_banners['description'];

            $name = phpAds_breakString ($name, '30');

            if ($i > 0) echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";

            echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";

            echo "<td height='25'>";
            echo "&nbsp;&nbsp;";

            if ($row_banners['type'] == 'html')
            {
                echo "<img src='images/icon-banner-html.gif' align='absmiddle'>&nbsp;";
            }
            elseif ($row_banners['type'] == 'url')
            {
                echo "<img src='images/icon-banner-url.gif' align='absmiddle'>&nbsp;";
            }
            else
            {
                echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";
            }
            echo $name;
            echo "</td>";

            echo "<td height='25'>".$row_banners['bannerid']."</td>";

            // Empty
            echo "<td>&nbsp;</td>";

            // Button 1
            echo "<td height='25'>";
            echo "<a href='JavaScript:GoOpener(\"stats.php?entity=affiliate&breakdown=banner-history&affiliateid=".phpAds_getUserId()."&clientid=".$row_banners['clientid']."&campaignid=".$row_banners['campaignid']."&bannerid=".$row_banners['bannerid']."\")'><img src='images/icon-statistics.gif' border='0' align='absmiddle' alt='$strStats'>&nbsp;$strStats</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "</td>";

            $i++;
        }
    }


    if ($zone && $rsZones->getRowCount())
    {
        while ($rsZones->fetch() && $row_zones = $rsZones->toArray())
        {
            $name = $row_zones['zonename'];
            $name = phpAds_breakString ($name, '30');

            if ($i > 0) echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";

            echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";

            echo "<td height='25'>";
            echo "&nbsp;&nbsp;";

            echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;";
            echo $name;
            echo "</td>";

            echo "<td height='25'>".$row_zones['zoneid']."</td>";

            // Empty
            echo "<td>&nbsp;</td>";

            // Button 1
            echo "<td height='25'>";
            if (phpAds_isAllowed(MAX_AffiliateViewZoneStats)) {
                echo "<a href='JavaScript:GoOpener(\"stats.php?entity=affiliate&breakdown=zones&affiliateid=".phpAds_getUserId()."&zoneid=".$row_zones['zoneid']."\")'><img src='images/icon-statistics.gif' border='0' align='absmiddle' alt='$strStats'>&nbsp;$strStats</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            } else {
                echo '&nbsp;';
            }
            echo "</td>";

            $i++;
        }
    }

    if ($foundMatches)
    {
        echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
    }
    else
    {
        echo $strNoMatchesFound;
    }
?>
</table>

</td><td width='20'>&nbsp;</td></tr>
</table>

<br /><br />

</body>
</html>

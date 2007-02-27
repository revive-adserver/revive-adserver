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
phpAds_checkAccess(phpAds_Admin + phpAds_Agency);


// Check Searchselection
if (!isset($client)) $client = false;
if (!isset($campaign)) $campaign = false;
if (!isset($banner)) $banner= false;
if (!isset($zone)) $zone = false;
if (!isset($affiliate)) $affiliate = false;


if ($client == false &&    $campaign == false &&
    $banner == false &&    $zone == false &&
    $affiliate == false)
{
    $client = true;
    $campaign = true;
    $banner = true;
    $zone = true;
    $affiliate = true;
}

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
        <form name='searchselection' action='admin-search.php'>
        <input type='hidden' name='keyword' value='<?php echo htmlspecialchars($keyword); ?>'>
        <tr>
            <td nowrap><input type='checkbox' name='client' value='t'<?php echo ($client ? ' checked': ''); ?> onClick='this.form.submit()'>
                <?php echo $strClients; ?>&nbsp;&nbsp;&nbsp;</td>
            <td nowrap><input type='checkbox' name='campaign' value='t'<?php echo ($campaign ? ' checked': ''); ?> onClick='this.form.submit()'>
                <?php echo $strCampaign; ?>&nbsp;&nbsp;&nbsp;</td>
            <td nowrap><input type='checkbox' name='banner' value='t'<?php echo ($banner ? ' checked': ''); ?> onClick='this.form.submit()'>
                <?php echo $strBanners; ?>&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
            <td nowrap><input type='checkbox' name='affiliate' value='t'<?php echo ($affiliate ? ' checked': ''); ?> onClick='this.form.submit()'>
                <?php echo $strAffiliates; ?>&nbsp;&nbsp;&nbsp;</td>
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

    $agencyId = null;
    if (phpAds_isUser(phpAds_Agency)) {
        $agencyId = phpAds_getAgencyID();
    }
    
    $dalZones = MAX_DB::factoryDAL('zones');
    $rsZones = $dalZones->getZoneByKeyword($keyword, $agencyId);
    $rsZones->reset(); // Reset RecordSet (execute the query on database)

    $dalAffiliates = MAX_DB::factoryDAL('affiliates');
    $rsAffiliates = $dalAffiliates->getAffiliateByKeyword($keyword, $agencyId);
    $rsAffiliates->reset();
    
    $dalBanners = MAX_DB::factoryDAL('banners');
    $rsBanners = $dalBanners->getBannerByKeyword($keyword, $agencyId);
    $rsBanners->reset();
    
    $dalClients = MAX_DB::factoryDAL('clients');
    $rsClients = $dalClients->getClientByKeyword($keyword, $agencyId);
    $rsClients->reset();
    
    $dalCampaigns = MAX_DB::factoryDAL('campaigns');
    $rsCampaigns = $dalCampaigns->getCampaignAndClientByKeyword($keyword, $agencyId);
    $rsCampaigns->reset();
       
    $matchesFound = false;
    if ($rsClients->getRowCount() ||
        $rsCampaigns->getRowCount() ||
        $rsBanners->getRowCount() ||
        $rsAffiliates->getRowCount() ||
        $rsZones->getRowCount())
    {
        echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
        echo "<tr height='25'>";
        echo "<td height='25'><b>&nbsp;&nbsp;".$GLOBALS['strName']."</b></td>";
        echo "<td height='25'><b>".$GLOBALS['strID']."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
        echo "<td height='25'>&nbsp;</td>";
        echo "<td height='25'>&nbsp;</td>";
        echo "<td height='25'>&nbsp;</td>";
        echo "</tr>";
        
        echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
        $matchesFound = true;
    }
    
    
    $i=0;
    
    
    if ($client && $rsClients->getRowCount())
    {
        while ($rsClients->next() && $row_clients = $rsClients->export())
        {
            if ($i > 0) echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
            
            echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
            
            echo "<td height='25'>";
            echo "&nbsp;&nbsp;";
            echo "<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;";
            echo "<a href='JavaScript:GoOpener(\"advertiser-edit.php?clientid=".$row_clients['clientid']."\")'>".$row_clients['clientname']."</a>";
            echo "</td>";
            
            echo "<td height='25'>".$row_clients['clientid']."</td>";
            
            // Empty
            echo "<td>&nbsp;</td>";
               
            // Button 1
            echo "<td height='25'>";
            echo "<a href='JavaScript:GoOpener(\"advertiser-campaigns.php?clientid=".$row_clients['clientid']."\")'><img src='images/icon-overview.gif' border='0' align='absmiddle' alt='$strOverview'>&nbsp;$strOverview</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "</td>";
             
            // Button 2
            echo "<td height='25'>";
            echo "<a href='JavaScript:GoOpener(\"advertiser-delete.php?clientid=".$row_clients['clientid']."\", true)'".phpAds_DelConfirm($strConfirmDeleteClient)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "</td>";
             
            // Button 3
            echo "<td height='25'>";
            echo "<a href='JavaScript:GoOpener(\"stats.php?entity=advertiser&breakdown=history&clientid=".$row_clients['clientid']."\")'><img src='images/icon-statistics.gif' border='0' align='absmiddle' alt='$strStats'>&nbsp;$strStats</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "</td></tr>";
            
            
            
            if (!$compact)
            {
                $doCampaign = MAX_DB::factoryDO('campaigns');
                $doCampaign->clientid = $row_clients['clientid'];
                $doCampaign->find();

                while ($doCampaign->fetch() && $row_c_expand = $doCampaign->toArray())
                {
                    echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
                    
                    echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
                    
                    echo "<td height='25'>";
                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;";
                    echo "<a href='JavaScript:GoOpener(\"campaign-edit.php?clientid=".$row_clients['clientid']."&campaignid=".$row_c_expand['campaignid']."\")'>".$row_c_expand['campaignname']."</a>";
                    echo "</td>";
                    
                    echo "<td height='25'>".$row_c_expand['campaignid']."</td>";
                    
                    // Empty
                    echo "<td>&nbsp;</td>";
                       
                    // Button 1
                    echo "<td height='25'>";
                    echo "<a href='JavaScript:GoOpener(\"campaign-banners.php?clientid=".$row_clients['clientid']."&campaignid=".$row_c_expand['campaignid']."\")'><img src='images/icon-overview.gif' border='0' align='absmiddle' alt='$strOverview'>&nbsp;$strOverview</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                    echo "</td>";
                     
                    // Button 2
                    echo "<td height='25'>";
                    echo "<a href='JavaScript:GoOpener(\"campaign-delete.php?clientid=".$row_clients['clientid']."&campaignid=".$row_c_expand['campaignid']."\", true)'".phpAds_DelConfirm($strConfirmDeleteCampaign)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                    echo "</td>";
                     
                    // Button 3
                    echo "<td height='25'>";
                    echo "<a href='JavaScript:GoOpener(\"stats.php?entity=campaign&breakdown=history&clientid=".$row_clients['clientid']."&campaignid=".$row_c_expand['campaignid']."\")'><img src='images/icon-statistics.gif' border='0' align='absmiddle' alt='$strStats'>&nbsp;$strStats</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                    echo "</td></tr>";
                    
                    
                    $doBanner = MAX_DB::factoryDO('banners');
                    $doBanner->campaignid = $row_c_expand['campaignid'];
                    $doBanner->find();
                    
                    while ($doBanner->fetch() && $row_b_expand = $doBanner->toArray())
                    { 
                        $name = $strUntitled;
                        if (isset($row_b_expand['alt']) && $row_b_expand['alt'] != '') $name = $row_b_expand['alt'];
                        if (isset($row_b_expand['description']) && $row_b_expand['description'] != '') $name = $row_b_expand['description'];
                        
                        $name = phpAds_breakString ($name, '30');
                        
                        echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
                        
                        echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
                        
                        echo "<td height='25'>";
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                        
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
                        
                        echo "<a href='JavaScript:GoOpener(\"banner-edit.php?clientid=".$row_clients['clientid']."&campaignid=".$row_b_expand['campaignid']."&bannerid=".$row_b_expand['bannerid']."\")'>".$name."</a>";
                        echo "</td>";
                        
                        echo "<td height='25'>".$row_b_expand['bannerid']."</td>";
                        
                        // Empty
                        echo "<td>&nbsp;</td>";
                           
                        // Button 1
                        echo "<td height='25'>";
                        echo "<a href='JavaScript:GoOpener(\"banner-acl.php?clientid=".$row_clients['clientid']."&campaignid=".$row_b_expand['campaignid']."&bannerid=".$row_b_expand['bannerid']."\")'><img src='images/icon-acl.gif' border='0' align='absmiddle' alt='$strACL'>&nbsp;$strACL</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                        echo "</td>";
                        
                        // Button 2
                        echo "<td height='25'>";
                        echo "<a href='JavaScript:GoOpener(\"banner-delete.php?clientid=".$row_clients['clientid']."&campaignid=".$row_b_expand['campaignid']."&bannerid=".$row_b_expand['bannerid']."\", true)'".phpAds_DelConfirm($strConfirmDeleteBanner)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                        echo "</td>";
                         
                        // Button 3
                        echo "<td height='25'>";
                        echo "<a href='JavaScript:GoOpener(\"stats.php?entity=banner&breakdown=history&clientid=".$row_clients['clientid']."&campaignid=".$row_b_expand['campaignid']."&bannerid=".$row_b_expand['bannerid']."\")'><img src='images/icon-statistics.gif' border='0' align='absmiddle' alt='$strStats'>&nbsp;$strStats</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                        echo "</td></tr>";
                    }
                }
            }
            
            $i++;
        }
    }
    
    if ($campaign)
    {
        while ($rsCampaigns->next() && $row_campaigns = $rsCampaigns->export())
        {
            if ($i > 0) echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
            
            echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
            
            echo "<td height='25'>";
            echo "&nbsp;&nbsp;";
            echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;";
            echo "<a href='JavaScript:GoOpener(\"campaign-edit.php?clientid=".$row_campaigns['clientid']."&campaignid=".$row_campaigns['campaignid']."\")'>".$row_campaigns['campaignname']."</a>";
            echo "</td>";
            
            echo "<td height='25'>".$row_campaigns['campaignid']."</td>";
            
            // Empty
            echo "<td>&nbsp;</td>";
               
            // Button 1
            echo "<td height='25'>";
            echo "<a href='JavaScript:GoOpener(\"campaign-banners.php?clientid=".$row_campaigns['clientid']."&campaignid=".$row_campaigns['campaignid']."\")'><img src='images/icon-overview.gif' border='0' align='absmiddle' alt='$strOverview'>&nbsp;$strOverview</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "</td>";
             
            // Button 2
            echo "<td height='25'>";
            echo "<a href='JavaScript:GoOpener(\"campaign-delete.php?clientid=".$row_campaigns['clientid']."&campaignid=".$row_campaigns['campaignid']."\", true)'".phpAds_DelConfirm($strConfirmDeleteCampaign)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "</td>";
             
            // Button 3
            echo "<td height='25'>";
            echo "<a href='JavaScript:GoOpener(\"stats.php?entity=campaign&breakdown=history&clientid=".$row_campaigns['clientid']."&campaignid=".$row_campaigns['campaignid']."\")'><img src='images/icon-statistics.gif' border='0' align='absmiddle' alt='$strStats'>&nbsp;$strStats</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "</td></tr>";
            
            
            if (!$compact)
            {
                $doBanner = MAX_DB::factoryDO('banners');
                $doBanner->campaignid = $row_campaigns['campaignid'];
                $doBanner->find();
                
                while ($doBanner->fetch() && $row_b_expand = $doBanner->toArray())
                {
                    $name = $strUntitled;
                    if (isset($row_b_expand['alt']) && $row_b_expand['alt'] != '') $name = $row_b_expand['alt'];
                    if (isset($row_b_expand['description']) && $row_b_expand['description'] != '') $name = $row_b_expand['description'];
                    
                    $name = phpAds_breakString ($name, '30');
                    
                    echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
                    
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
                    echo "<a href='JavaScript:GoOpener(\"banner-edit.php?clientid=".$row_campaigns['clientid']."&campaignid=".$row_b_expand['campaignid']."&bannerid=".$row_b_expand['bannerid']."\")'>".$name."</a>";
                    echo "</td>";
                    
                    echo "<td height='25'>".$row_b_expand['bannerid']."</td>";
                    
                    // Empty
                    echo "<td>&nbsp;</td>";
                       
                    // Button 1
                    echo "<td height='25'>";
                    echo "<a href='JavaScript:GoOpener(\"banner-acl.php?clientid=".$row_campaigns['clientid']."&campaignid=".$row_b_expand['campaignid']."&bannerid=".$row_b_expand['bannerid']."\")'><img src='images/icon-acl.gif' border='0' align='absmiddle' alt='$strACL'>&nbsp;$strACL</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                    echo "</td>";
                    
                    // Button 2
                    echo "<td height='25'>";
                    echo "<a href='JavaScript:GoOpener(\"banner-delete.php?clientid=".$row_campaigns['clientid']."&campaignid=".$row_b_expand['campaignid']."&bannerid=".$row_b_expand['bannerid']."\", true)'".phpAds_DelConfirm($strConfirmDeleteBanner)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                    echo "</td>";
                     
                    // Button 3
                    echo "<td height='25'>";
                    echo "<a href='JavaScript:GoOpener(\"stats.php?entity=banner&breakdown=history&clientid=".$row_campaigns['clientid']."&campaignid=".$row_b_expand['campaignid']."&bannerid=".$row_b_expand['bannerid']."\")'><img src='images/icon-statistics.gif' border='0' align='absmiddle' alt='$strStats'>&nbsp;$strStats</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                    echo "</td></tr>";
                }
            }
            
            $i++;
        }
    }
    
    if ($banner && $rsBanners->getRowCount())
    {
        while ($rsBanners->next() && $row_banners = $rsBanners->export())
        {
            $name = $strUntitled;
            if (isset($row_banners['alt']) && $row_banners['alt'] != '') $name = $row_banners['alt'];
            if (isset($row_banners['description']) && $row_banners['description'] != '') $name = $row_banners['description'];
            
            $name = phpAds_breakString ($name, '30');
            
            if ($i > 0) echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
            
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
            echo "<a href='JavaScript:GoOpener(\"banner-edit.php?clientid=".$row_banners['clientid']."&campaignid=".$row_banners['campaignid']."&bannerid=".$row_banners['bannerid']."\")'>".$name."</a>";
            echo "</td>";
            
            echo "<td height='25'>".$row_banners['bannerid']."</td>";
            
            // Empty
            echo "<td>&nbsp;</td>";
               
            // Button 1
            echo "<td height='25'>";
            echo "<a href='JavaScript:GoOpener(\"banner-acl.php?clientid=".$row_banners['clientid']."&campaignid=".$row_banners['campaignid']."&bannerid=".$row_banners['bannerid']."\")'><img src='images/icon-acl.gif' border='0' align='absmiddle' alt='$strACL'>&nbsp;$strACL</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "</td>";
            
            // Button 2
            echo "<td height='25'>";
            echo "<a href='JavaScript:GoOpener(\"banner-delete.php?clientid=".$row_banners['clientid']."&campaignid=".$row_banners['campaignid']."&bannerid=".$row_banners['bannerid']."\", true)'".phpAds_DelConfirm($strConfirmDeleteBanner)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "</td>";
             
            // Button 3
            echo "<td height='25'>";
            echo "<a href='JavaScript:GoOpener(\"stats.php?entity=banner&breakdown=history&clientid=".$row_banners['clientid']."&campaignid=".$row_banners['campaignid']."&bannerid=".$row_banners['bannerid']."\")'><img src='images/icon-statistics.gif' border='0' align='absmiddle' alt='$strStats'>&nbsp;$strStats</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "</td></tr>";
            
            $i++;
        }
    }
    
    if ($affiliate && $rsAffiliates->getRowCount())
    {
        while ($rsAffiliates->next() && $row_affiliates = $rsAffiliates->export())
        {
            $name = $row_affiliates['name'];
            $name = phpAds_breakString ($name, '30');
            
            if ($i > 0) echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
            
            echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
            
            echo "<td height='25'>";
            echo "&nbsp;&nbsp;";
            
            echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;";
            echo "<a href='JavaScript:GoOpener(\"affiliate-edit.php?affiliateid=".$row_affiliates['affiliateid']."\")'>".$name."</a>";
            echo "</td>";
            
            echo "<td height='25'>".$row_affiliates['affiliateid']."</td>";
            
            // Empty
            echo "<td>&nbsp;</td>";
               
            // Button 1
            echo "<td height='25'>";
            echo "<a href='JavaScript:GoOpener(\"affiliate-zones.php?affiliateid=".$row_affiliates['affiliateid']."\")'><img src='images/icon-overview.gif' border='0' align='absmiddle' alt='$strOverview'>&nbsp;$strOverview</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "</td>";
            
            // Button 2
            echo "<td height='25'>";
            echo "<a href='JavaScript:GoOpener(\"affiliate-delete.php?affiliateid=".$row_affiliates['affiliateid']."\", true)'".phpAds_DelConfirm($strConfirmDeleteAffiliate)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "</td>";
             
            // Button 3
            echo "<td height='25'>";
            echo "<a href='JavaScript:GoOpener(\"stats.php?entity=affiliate&breakdown=history&affiliateid=".$row_affiliates['affiliateid']."\")'><img src='images/icon-statistics.gif' border='0' align='absmiddle' alt='$strStats'>&nbsp;$strStats</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "</td></tr>";
            
            $i++;
            
            
            if (!$compact)
            {
                $doZone = MAX_DB::factoryDO('zones');
                $doZone->affiliateid = $row_affiliates['affiliateid'];
                $doZone->find();
                
                while ($doZone->fetch() && $row_z_expand = $doZone->toArray())
                {
                    $name = $row_z_expand['zonename'];
                    $name = phpAds_breakString ($name, '30');
                    
                    if ($i > 0) echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
                    
                    echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
                    
                    echo "<td height='25'>";
                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    
                    echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;";
                    echo "<a href='JavaScript:GoOpener(\"zone-edit.php?affiliateid=".$row_z_expand['affiliateid']."&zoneid=".$row_z_expand['zoneid']."\")'>".$name."</a>";
                    echo "</td>";
                    
                    echo "<td height='25'>".$row_z_expand['zoneid']."</td>";
                    
                    // Empty
                    echo "<td>&nbsp;</td>";
                       
                    // Button 1
                    echo "<td height='25'>";
                    echo "<a href='JavaScript:GoOpener(\"zone-include.php?affiliateid=".$row_z_expand['affiliateid']."&zoneid=".$row_z_expand['zoneid']."\")'><img src='images/icon-zone-linked.gif' border='0' align='absmiddle' alt='$strIncludedBanners'>&nbsp;$strIncludedBanners</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                    echo "</td>";
                    
                    // Button 2
                    echo "<td height='25'>";
                    echo "<a href='JavaScript:GoOpener(\"zone-delete.php?affiliateid=".$row_z_expand['affiliateid']."&zoneid=".$row_z_expand['zoneid']."\", true)'".phpAds_DelConfirm($strConfirmDeleteZone)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                    echo "</td>";
                     
                    // Button 3
                    echo "<td height='25'>";
                    echo "<a href='JavaScript:GoOpener(\"stats.php?entity=zone&breakdown=history&affiliateid=".$row_affiliates['affiliateid']."&zoneid=".$row_z_expand['zoneid']."\")'><img src='images/icon-statistics.gif' border='0' align='absmiddle' alt='$strStats'>&nbsp;$strStats</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                    echo "</td></tr>";
                }
            }
        }
    }
    
    if ($zone && $rsZones->getRowCount())
    {
        while ($rsZones->next() && $row_zones = $rsZones->export())
        {
            $name = $row_zones['zonename'];
            $name = phpAds_breakString ($name, '30');
            
            if ($i > 0) echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
            
            echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
            
            echo "<td height='25'>";
            echo "&nbsp;&nbsp;";
            
            echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;";
            echo "<a href='JavaScript:GoOpener(\"zone-edit.php?affiliateid=".$row_zones['affiliateid']."&zoneid=".$row_zones['zoneid']."\")'>".$name."</a>";
            echo "</td>";
            
            echo "<td height='25'>".$row_zones['zoneid']."</td>";
            
            // Empty
            echo "<td>&nbsp;</td>";
               
            // Button 1
            echo "<td height='25'>";
            echo "<a href='JavaScript:GoOpener(\"zone-include.php?affiliateid=".$row_zones['affiliateid']."&zoneid=".$row_zones['zoneid']."\")'><img src='images/icon-zone-linked.gif' border='0' align='absmiddle' alt='$strIncludedBanners'>&nbsp;$strIncludedBanners</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "</td>";
            
            // Button 2
            echo "<td height='25'>";
            echo "<a href='JavaScript:GoOpener(\"zone-delete.php?affiliateid=".$row_zones['affiliateid']."&zoneid=".$row_zones['zoneid']."\", true)'".phpAds_DelConfirm($strConfirmDeleteZone)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "</td>";
             
            // Button 3
            echo "<td height='25'>";
            echo "<a href='JavaScript:GoOpener(\"stats.php?entity=zone&breakdown=history&affiliateid=".$row_zones['affiliateid']."&zoneid=".$row_zones['zoneid']."\")'><img src='images/icon-statistics.gif' border='0' align='absmiddle' alt='$strStats'>&nbsp;$strStats</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "</td></tr>";
            
            $i++;
        }
    }
    
    if ($matchesFound)
    {
        echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
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

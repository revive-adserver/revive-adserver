<?php // $Revision: 1.0 

/************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-statistics.inc.php");


// Register input variables
phpAds_registerGlobal ('keyword', 'client', 'campaign', 'banner', 'zone', 'affiliate', 'compact');


// Security check
phpAds_checkAccess(phpAds_Admin);


// Check Searchselection
if (!isset($client)) $client = false;
if (!isset($campaign)) $campaign = false;
if (!isset($banner)) $banner= false;
if (!isset($zone)) $zone = false;
if (!isset($affiliate)) $affiliate = false;


if ($client == false &&	$campaign == false &&
	$banner == false &&	$zone == false &&
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
		<meta name='author' content='phpAdsNew - http://sourceforge.net/projects/phpadsnew'>
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

<!-- Top -->
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
<?php
 	if ($phpAds_config['name'] != "")
	{
		echo "<tr><td colspan='2' height='48' bgcolor='#000063' valign='middle'>";
		echo "<span class='phpAdsNew'>&nbsp;&nbsp;&nbsp;".$phpAds_config['name']." &nbsp;&nbsp;&nbsp;</span>";
	}
	else
	{
		echo "<tr><td colspan='2' height='48' bgcolor='#000063' valign='bottom'>";
		echo "&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/logo.gif' width='163' height='34'>";
	}
?>
</td></tr>

<!-- Spacer -->
<tr><td colspan='2' height='24' bgcolor='#000063'><img src='images/spacer.gif' height='1' width='1'></td></tr>

<!-- Tabbar -->
<tr>
	<td colspan='2' height='24' bgcolor="#000063"> 
		<table cellpadding='0' cellspacing='0' border='0' bgcolor='#FFFFFF' height='24'>
			<form name='search' action='admin-search.php' method='post'>
			<input type='hidden' name='client' value='<?php echo $client; ?>'>
			<input type='hidden' name='campaign' value='<?php echo $campaign; ?>'>
			<input type='hidden' name='banner' value='<?php echo $banner; ?>'>
			<input type='hidden' name='zone' value='<?php echo $zone; ?>'>
			<input type='hidden' name='affiliate' value='<?php echo $affiliate; ?>'>
			<input type='hidden' name='compact' value='<?php echo $compact; ?>'>
			<tr height='24'>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td class='tab-s' valign='bottom'><?php echo $strSearch; ?>:&nbsp;<input type='text' name='keyword' size='15' value='<?php echo htmlspecialchars($keyword); ?>' accesskey='<? print $keySearch ?>'>&nbsp;
				<input type='image' src='images/<?php echo $phpAds_TextDirection; ?>/go_blue.gif' border='0'></td>
				<td height='24'><img src='images/<?php echo $phpAds_TextDirection; ?>/tab-ew.gif' height='24' width='10'></td>
			</tr>
			</form>
		</table>
	</td>
</tr>
</table>

<br>

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
<br><br>

<!-- Search Results -->	
<table width='100%' cellpadding='0' cellspacing='0' border='0'>
<tr><td width='20'>&nbsp;</td><td>
	
<?php
	$query_clients = "SELECT * FROM ".$phpAds_config['tbl_clients']." WHERE clientname LIKE '%".$keyword."%' AND parent = 0";
  	$res_clients = phpAds_dbQuery($query_clients) or phpAds_sqlDie();
	
	$query_campaigns = "SELECT * FROM ".$phpAds_config['tbl_clients']." WHERE clientname LIKE '%".$keyword."%' AND parent > 0";
  	$res_campaigns = phpAds_dbQuery($query_campaigns) or phpAds_sqlDie();
	
	$query_banners = "SELECT * FROM ".$phpAds_config['tbl_banners']." WHERE keyword LIKE '%".$keyword."%' OR alt LIKE '%".$keyword."%' OR description LIKE '%".$keyword."%'";
  	$res_banners = phpAds_dbQuery($query_banners) or phpAds_sqlDie();
	
	$query_affiliates = "SELECT * FROM ".$phpAds_config['tbl_affiliates']." WHERE name LIKE '%".$keyword."%'";
  	$res_affiliates = phpAds_dbQuery($query_affiliates) or phpAds_sqlDie();
	
	$query_zones = "SELECT * FROM ".$phpAds_config['tbl_zones']." WHERE zonename LIKE '%".$keyword."%' OR description LIKE '%".$keyword."%'";
  	$res_zones = phpAds_dbQuery($query_zones) or phpAds_sqlDie();
	
	
	if (phpAds_dbNumRows($res_clients) > 0 ||
		phpAds_dbNumRows($res_campaigns) > 0 ||
		phpAds_dbNumRows($res_banners) > 0 ||
		phpAds_dbNumRows($res_affiliates) > 0 ||
		phpAds_dbNumRows($res_zones) > 0)
	{
		echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
		echo "<tr height='25'>";
		echo "<td height='25'><b>&nbsp;&nbsp;".$GLOBALS['strName']."</b></td>";
		echo "<td height='25'><b>".$GLOBALS['strID']."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
		echo "<td height='25'>&nbsp;</td>";
		echo "<td height='25'>&nbsp;</td>";
		echo "<td height='25'>&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	}
	
	
	$i=0;
	
	
	if ($client && phpAds_dbNumRows($res_clients) > 0)
	{
		while ($row_clients = phpAds_dbFetchArray($res_clients))
	    {
			if ($i > 0) echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
			
	    	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
			
			echo "<td height='25'>";
			echo "&nbsp;&nbsp;";
			echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;";
			echo "<a href='JavaScript:GoOpener(\"client-edit.php?clientid=".$row_clients['clientid']."\")'>".$row_clients['clientname']."</a>";
			echo "</td>";
			
			echo "<td height='25'>".$row_clients['clientid']."</td>";
			
			// Empty
			echo "<td>&nbsp;</td>";
		   	
			// Button 1
			echo "<td height='25'>";
			echo "<a href='JavaScript:GoOpener(\"client-campaigns.php?clientid=".$row_clients['clientid']."\")'><img src='images/icon-overview.gif' border='0' align='absmiddle' alt='$strOverview'>&nbsp;$strOverview</a>&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "</td>";
		 	
			// Button 2
			echo "<td height='25'>";
			echo "<a href='JavaScript:GoOpener(\"client-delete.php?clientid=".$row_clients['clientid']."\", true)'".phpAds_DelConfirm($strConfirmDeleteClient)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "</td></tr>";
			
			
			
			if (!$compact)
			{
				$query_c_expand = "SELECT * FROM ".$phpAds_config['tbl_clients']." WHERE parent=".$row_clients['clientid'];
	  			$res_c_expand = phpAds_dbQuery($query_c_expand) or phpAds_sqlDie();
				
				while ($row_c_expand = phpAds_dbFetchArray($res_c_expand))
				{
					echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
					
			    	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
					
					echo "<td height='25'>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;";
					echo "<a href='JavaScript:GoOpener(\"campaign-edit.php?clientid=".$row_clients['clientid']."&campaignid=".$row_c_expand['clientid']."\")'>".$row_c_expand['clientname']."</a>";
					echo "</td>";
					
					echo "<td height='25'>".$row_c_expand['clientid']."</td>";
					
					// Empty
					echo "<td>&nbsp;</td>";
				   	
					// Button 1
					echo "<td height='25'>";
					echo "<a href='JavaScript:GoOpener(\"campaign-banners.php?clientid=".$row_clients['clientid']."&campaignid=".$row_c_expand['clientid']."\")'><img src='images/icon-overview.gif' border='0' align='absmiddle' alt='$strOverview'>&nbsp;$strOverview</a>&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "</td>";
				 	
					// Button 2
					echo "<td height='25'>";
					echo "<a href='JavaScript:GoOpener(\"campaign-delete.php?clientid=".$row_clients['clientid']."&campaignid=".$row_c_expand['clientid']."\", true)'".phpAds_DelConfirm($strConfirmDeleteCampaign)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "</td></tr>";
					
					
					
					
					$query_b_expand = "SELECT * FROM ".$phpAds_config['tbl_banners']." WHERE clientid=".$row_c_expand['clientid'];
		  			$res_b_expand = phpAds_dbQuery($query_b_expand) or phpAds_sqlDie();
					
					while ($row_b_expand = phpAds_dbFetchArray($res_b_expand))
					{
						$name = $strUntitled;
						if (isset($row_b_expand['alt']) && $row_b_expand['alt'] != '') $name = $row_b_expand['alt'];
						if (isset($row_b_expand['description']) && $row_b_expand['description'] != '') $name = $row_b_expand['description'];
						
						$name = phpAds_breakString ($name, '30');
						
						echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
						
				    	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
						
						echo "<td height='25'>";
						echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						
						if ($row_b_expand['storagetype'] == 'html')
						{
							echo "<img src='images/icon-banner-html.gif' align='absmiddle'>&nbsp;";
						}
						elseif ($row_b_expand['storagetype'] == 'url')
						{
							echo "<img src='images/icon-banner-url.gif' align='absmiddle'>&nbsp;";
						}
						else
						{
							echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";
						}
						
						echo "<a href='JavaScript:GoOpener(\"banner-edit.php?clientid=".$row_clients['clientid']."&campaignid=".$row_b_expand['clientid']."&bannerid=".$row_b_expand['bannerid']."\")'>".$name."</a>";
						echo "</td>";
						
						echo "<td height='25'>".$row_b_expand['bannerid']."</td>";
						
						// Empty
						echo "<td>&nbsp;</td>";
					   	
						// Button 1
						echo "<td height='25'>";
						echo "<a href='JavaScript:GoOpener(\"banner-acl.php?clientid=".$row_clients['clientid']."&campaignid=".$row_b_expand['clientid']."&bannerid=".$row_b_expand['bannerid']."\")'><img src='images/icon-acl.gif' border='0' align='absmiddle' alt='$strACL'>&nbsp;$strACL</a>&nbsp;&nbsp;&nbsp;&nbsp;";
						echo "</td>";
						
						// Button 2
						echo "<td height='25'>";
						echo "<a href='JavaScript:GoOpener(\"banner-delete.php?clientid=".$row_clients['clientid']."&campaignid=".$row_b_expand['clientid']."&bannerid=".$row_b_expand['bannerid']."\", true)'".phpAds_DelConfirm($strConfirmDeleteBanner)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
						echo "</td></tr>";
					}
				}
			}
			
			$i++;
	    }
	}
	
	if ($campaign && phpAds_dbNumRows($res_campaigns) > 0)
	{
		while ($row_campaigns = phpAds_dbFetchArray($res_campaigns))
	    {
			if ($i > 0) echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
			
	    	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
			
			echo "<td height='25'>";
			echo "&nbsp;&nbsp;";
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;";
			echo "<a href='JavaScript:GoOpener(\"campaign-edit.php?clientid=".$row_campaigns['parent']."&campaignid=".$row_campaigns['clientid']."\")'>".$row_campaigns['clientname']."</a>";
			echo "</td>";
			
			echo "<td height='25'>".$row_campaigns['clientid']."</td>";
			
			// Empty
			echo "<td>&nbsp;</td>";
		   	
			// Button 1
			echo "<td height='25'>";
			echo "<a href='JavaScript:GoOpener(\"campaign-banners.php?clientid=".$row_campaigns['parent']."&campaignid=".$row_campaigns['clientid']."\")'><img src='images/icon-overview.gif' border='0' align='absmiddle' alt='$strOverview'>&nbsp;$strOverview</a>&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "</td>";
		 	
			// Button 2
			echo "<td height='25'>";
			echo "<a href='JavaScript:GoOpener(\"campaign-delete.php?clientid=".$row_campaigns['parent']."&campaignid=".$row_campaigns['clientid']."\", true)'".phpAds_DelConfirm($strConfirmDeleteCampaign)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "</td></tr>";
			
			
			if (!$compact)
			{
				$query_b_expand = "SELECT * FROM ".$phpAds_config['tbl_banners']." WHERE clientid=".$row_campaigns['clientid'];
	  			$res_b_expand = phpAds_dbQuery($query_b_expand) or phpAds_sqlDie();
				
				while ($row_b_expand = phpAds_dbFetchArray($res_b_expand))
				{
					$name = $strUntitled;
					if (isset($row_b_expand['alt']) && $row_b_expand['alt'] != '') $name = $row_b_expand['alt'];
					if (isset($row_b_expand['description']) && $row_b_expand['description'] != '') $name = $row_b_expand['description'];
					
					$name = phpAds_breakString ($name, '30');
					
					echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
					
			    	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
					
					echo "<td height='25'>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					
					if ($row_b_expand['storagetype'] == 'html')
					{
						echo "<img src='images/icon-banner-html.gif' align='absmiddle'>&nbsp;";
					}
					elseif ($row_b_expand['storagetype'] == 'url')
					{
						echo "<img src='images/icon-banner-url.gif' align='absmiddle'>&nbsp;";
					}
					else
					{
						echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";
					}
					
					echo "<a href='JavaScript:GoOpener(\"banner-edit.php?clientid=".$row_campaigns['parent']."&campaignid=".$row_b_expand['clientid']."&bannerid=".$row_b_expand['bannerid']."\")'>".$name."</a>";
					echo "</td>";
					
					echo "<td height='25'>".$row_b_expand['bannerid']."</td>";
					
					// Empty
					echo "<td>&nbsp;</td>";
				   	
					// Button 1
					echo "<td height='25'>";
					echo "<a href='JavaScript:GoOpener(\"banner-acl.php?clientid=".$row_campaigns['parent']."&campaignid=".$row_b_expand['clientid']."&bannerid=".$row_b_expand['bannerid']."\")'><img src='images/icon-acl.gif' border='0' align='absmiddle' alt='$strACL'>&nbsp;$strACL</a>&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "</td>";
					
					// Button 2
					echo "<td height='25'>";
					echo "<a href='JavaScript:GoOpener(\"banner-delete.php?clientid=".$row_campaigns['parent']."&bannerid=".$row_b_expand['bannerid']."&campaignid=".$row_b_expand['clientid']."\", true)'".phpAds_DelConfirm($strConfirmDeleteBanner)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "</td></tr>";
				}
			}
			
			$i++;
	    }
	}
	
	if ($banner && phpAds_dbNumRows($res_banners) > 0)
	{
		while ($row_banners = phpAds_dbFetchArray($res_banners))
	    {
			$name = $strUntitled;
			if (isset($row_banners['alt']) && $row_banners['alt'] != '') $name = $row_banners['alt'];
			if (isset($row_banners['description']) && $row_banners['description'] != '') $name = $row_banners['description'];
			
			$name = phpAds_breakString ($name, '30');
			
			if ($i > 0) echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
			
	    	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
			
			echo "<td height='25'>";
			echo "&nbsp;&nbsp;";
			
			if ($row_banners['storagetype'] == 'html')
			{
				echo "<img src='images/icon-banner-html.gif' align='absmiddle'>&nbsp;";
			}
			elseif ($row_banners['storagetype'] == 'url')
			{
				echo "<img src='images/icon-banner-url.gif' align='absmiddle'>&nbsp;";
			}
			else
			{
				echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";
			}
			
			echo "<a href='JavaScript:GoOpener(\"banner-edit.php?clientid=".phpAds_getParentID($row_banners['clientid'])."&campaignid=".$row_banners['clientid']."&bannerid=".$row_banners['bannerid']."\")'>".$name."</a>";
			echo "</td>";
			
			echo "<td height='25'>".$row_banners['bannerid']."</td>";
			
			// Empty
			echo "<td>&nbsp;</td>";
		   	
			// Button 1
			echo "<td height='25'>";
			echo "<a href='JavaScript:GoOpener(\"banner-acl.php?clientid=".phpAds_getParentID($row_banners['clientid'])."&campaignid=".$row_banners['clientid']."&bannerid=".$row_banners['bannerid']."\")'><img src='images/icon-acl.gif' border='0' align='absmiddle' alt='$strACL'>&nbsp;$strACL</a>&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "</td>";
			
			// Button 2
			echo "<td height='25'>";
			echo "<a href='JavaScript:GoOpener(\"banner-delete.php?clientid=".phpAds_getParentID($row_banners['clientid'])."&campaignid=".$row_banners['clientid']."&bannerid=".$row_banners['bannerid']."\", true)'".phpAds_DelConfirm($strConfirmDeleteBanner)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "</td></tr>";
			
			$i++;
	    }
	}
	
	if ($affiliate && phpAds_dbNumRows($res_affiliates) > 0)
	{
		while ($row_affiliates = phpAds_dbFetchArray($res_affiliates))
	    {
			$name = $row_affiliates['name'];
			$name = phpAds_breakString ($name, '30');
			
			if ($i > 0) echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
			
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
			echo "</td></tr>";
			
			$i++;
			
			
			if (!$compact)
			{
				$query_z_expand = "SELECT * FROM ".$phpAds_config['tbl_zones']." WHERE affiliateid=".$row_affiliates['affiliateid'];
	  			$res_z_expand = phpAds_dbQuery($query_z_expand) or phpAds_sqlDie();
				
				while ($row_z_expand = phpAds_dbFetchArray($res_z_expand))
				{
					$name = $row_z_expand['zonename'];
					$name = phpAds_breakString ($name, '30');
					
					if ($i > 0) echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
					
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
					echo "</td></tr>";
				}
			}
	    }
	}
	
	if ($zone && phpAds_dbNumRows($res_zones) > 0)
	{
		while ($row_zones = phpAds_dbFetchArray($res_zones))
	    {
			$name = $row_zones['zonename'];
			$name = phpAds_breakString ($name, '30');
			
			if ($i > 0) echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
			
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
			echo "</td></tr>";
			
			$i++;
	    }
	}
	
	if (phpAds_dbNumRows($res_clients) > 0 ||
		phpAds_dbNumRows($res_campaigns) > 0 ||
		phpAds_dbNumRows($res_banners) > 0 ||
		phpAds_dbNumRows($res_affiliates) > 0 ||
		phpAds_dbNumRows($res_zones) > 0)
	{
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	}
	else
	{
		echo $strNoMatchesFound;
	}
?>
</table>

</td><td width='20'>&nbsp;</td></tr>
</table>

<br><br> 

</body>
</html>
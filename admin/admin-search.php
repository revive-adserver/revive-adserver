<?php // $Revision: 1.0 
/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-statistics.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin);

?>

<html>
	<head>
		<title><?php echo $strSearch; ?></title>
		<meta http-equiv='Content-Type' content='text/html<?php echo $phpAds_CharSet != "" ? "; charset=".$phpAds_CharSet : "" ?>'>
		<meta name='author" content='phpAdsNew - http://sourceforge.net/projects/phpadsnew'>
		<link rel='stylesheet' href='interface.css'>
		<script language='JavaScript' src='interface.js'></script>
		<script language='JavaScript'>
		<!--
			function GoOpener(url)
			{
				opener.location.href = url;
			}
		//-->
		</script>
	</head>
	
<body bgcolor='#FFFFFF' text='#000000' leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>

<!-- Top -->
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
<?php
 	if ($phpAds_name != "")
	{
		echo "<tr><td colspan='2' height='48' bgcolor='#000063' valign='middle'>";
		echo "<span class='phpAdsNew'>&nbsp;&nbsp;&nbsp;$phpAds_name &nbsp;&nbsp;&nbsp;</span>";
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
			<tr height='24'>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td class='tab-s' valign='middle'><?php echo $strSearch; ?>:&nbsp;<input type='text' name='keyword' size='15' value='<?php print $keyword ?>'>&nbsp;
				<input type='image' src='images/go_blue.gif' border='0'></td>
				<td height='24'><img src='images/tab-ew.gif' height='24' width='10'></td>
			</tr>
			</form>
		</table>
	</td>
</tr>
</table>

<br><br>

<table width='100%' cellpadding='0' cellspacing='0' border='0'>
<tr><td width='20'>&nbsp;</td><td>

<?php
	$query_clients = "SELECT * from $phpAds_tbl_clients where clientname LIKE '%" . $keyword . "%' AND parent = 0";
  	$res_clients = db_query($query_clients) or mysql_die();
	
	$query_campaigns = "SELECT * from $phpAds_tbl_clients where clientname LIKE '%" . $keyword . "%' AND parent > 0";
  	$res_campaigns = db_query($query_campaigns) or mysql_die();
	
	$query_banners = "SELECT * from $phpAds_tbl_banners where alt LIKE '%" . $keyword . "%' OR description LIKE '%" . $keyword . "%'";
  	$res_banners = db_query($query_banners) or mysql_die();
	
	
	if (@mysql_num_rows($res_clients) > 0 ||
		@mysql_num_rows($res_campaigns) > 0 ||
		@mysql_num_rows($res_banners) > 0)
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
	
	
	if (@mysql_num_rows($res_clients) > 0)
	{
		while ($row_clients = mysql_fetch_array($res_clients))
	    {
			if ($i > 0) echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
			
	    	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
			
			echo "<td height='25'>";
			echo "&nbsp;&nbsp;";
			echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;";
			echo "<a href='JavaScript:GoOpener(\"client-edit.php?clientID=".$row_clients['clientID']."\")'>".$row_clients['clientname']."</a>";
			echo "</td>";
			
			echo "<td height='25'>".$row_clients['clientID']."</td>";
			
			// Empty
			echo "<td>&nbsp;</td>";
		   	
			// Empty
			echo "<td>&nbsp;</td>";
		 	
			// Button 1
			echo "<td height='25'>";
			echo "<a href='JavaScript:GoOpener(\"client-delete.php?clientID=".$row_clients['clientID']."\")'".phpAds_DelConfirm($strConfirmDeleteClient)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "</td></tr>";
			
			
			
			
			$query_c_expand = "SELECT * from $phpAds_tbl_clients where parent=".$row_clients['clientID'];
  			$res_c_expand = db_query($query_c_expand) or mysql_die();
			
			while ($row_c_expand = mysql_fetch_array($res_c_expand))
			{
				echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
				
		    	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
				
				echo "<td height='25'>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;";
				echo "<a href='JavaScript:GoOpener(\"campaign-index.php?campaignID=".$row_c_expand['clientID']."\")'>".$row_c_expand['clientname']."</a>";
				echo "</td>";
				
				echo "<td height='25'>".$row_c_expand['clientID']."</td>";
				
				// Empty
				echo "<td>&nbsp;</td>";
			   	
				// Empty
				echo "<td height='25'>";
				echo "<a href='JavaScript:GoOpener(\"campaign-edit.php?campaignID=".$row_c_expand['clientID']."\")'><img src='images/icon-edit.gif' border='0' align='absmiddle' alt='$strEdit'>&nbsp;$strEdit</a>&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "</td>";
			 	
				// Button 1
				echo "<td height='25'>";
				echo "<a href='JavaScript:GoOpener(\"campaign-delete.php?campaignID=".$row_c_expand['clientID']."\")'".phpAds_DelConfirm($strConfirmDeleteCampaign)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "</td></tr>";
				
				
				
				
				$query_b_expand = "SELECT * from $phpAds_tbl_banners where clientID=".$row_c_expand['clientID'];
	  			$res_b_expand = db_query($query_b_expand) or mysql_die();
				
				while ($row_b_expand = mysql_fetch_array($res_b_expand))
				{
					$name = $strUntitled;
					if (isset($row_b_expand['alt']) && $row_b_expand['alt'] != '') $name = $row_b_expand['alt'];
					if (isset($row_b_expand['description']) && $row_b_expand['description'] != '') $name = $row_b_expand['description'];
					
					$name = phpAds_breakString ($name, '30');
					
					echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
					
			    	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
					
					echo "<td height='25'>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					
					if ($row_b_expand['format'] == 'html')
					{
						echo "<img src='images/icon-banner-html.gif' align='absmiddle'>&nbsp;";
					}
					elseif ($row_b_expand['format'] == 'url')
					{
						echo "<img src='images/icon-banner-url.gif' align='absmiddle'>&nbsp;";
					}
					else
					{
						echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";
					}
					
					echo "<a href='JavaScript:GoOpener(\"banner-edit.php?bannerID=".$row_b_expand['bannerID']."&campaignID=".$row_b_expand['clientID']."\")'>".$name."</a>";
					echo "</td>";
					
					echo "<td height='25'>".$row_b_expand['bannerID']."</td>";
					
					// Empty
					echo "<td>&nbsp;</td>";
				   	
					// Empty
					echo "<td height='25'>";
					if ($phpAds_acl == '1')
						echo "<a href='JavaScript:GoOpener(\"banner-acl.php?bannerID=".$row_b_expand['bannerID']."&campaignID=".$row_b_expand['clientID']."\")'><img src='images/icon-acl.gif' border='0' align='absmiddle' alt='$strACL'>&nbsp;$strACL</a>&nbsp;&nbsp;&nbsp;&nbsp;";
					else
						echo "&nbsp;";
					echo "</td>";
					
					// Button 1
					echo "<td height='25'>";
					echo "<a href='JavaScript:GoOpener(\"banner-delete.php?bannerID=".$row_b_expand['bannerID']."&campaignID=".$row_b_expand['clientID']."\")'".phpAds_DelConfirm($strConfirmDeleteBanner)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "</td></tr>";
				}
			}
			
			$i++;
	    }
	}
	
	if (@mysql_num_rows($res_campaigns) > 0)
	{
		while ($row_campaigns = mysql_fetch_array($res_campaigns))
	    {
			if ($i > 0) echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
			
	    	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
			
			echo "<td height='25'>";
			echo "&nbsp;&nbsp;";
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;";
			echo "<a href='JavaScript:GoOpener(\"campaign-index.php?campaignID=".$row_campaigns['clientID']."\")'>".$row_campaigns['clientname']."</a>";
			echo "</td>";
			
			echo "<td height='25'>".$row_campaigns['clientID']."</td>";
			
			// Empty
			echo "<td>&nbsp;</td>";
		   	
			// Empty
			echo "<td height='25'>";
			echo "<a href='JavaScript:GoOpener(\"campaign-edit.php?campaignID=".$row_campaigns['clientID']."\")'><img src='images/icon-edit.gif' border='0' align='absmiddle' alt='$strEdit'>&nbsp;$strEdit</a>&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "</td>";
		 	
			// Button 1
			echo "<td height='25'>";
			echo "<a href='JavaScript:GoOpener(\"campaign-delete.php?campaignID=".$row_campaigns['clientID']."\")'".phpAds_DelConfirm($strConfirmDeleteCampaign)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "</td></tr>";
			
			
			
			$query_b_expand = "SELECT * from $phpAds_tbl_banners where clientID=".$row_campaigns['clientID'];
  			$res_b_expand = db_query($query_b_expand) or mysql_die();
			
			while ($row_b_expand = mysql_fetch_array($res_b_expand))
			{
				$name = $strUntitled;
				if (isset($row_b_expand['alt']) && $row_b_expand['alt'] != '') $name = $row_b_expand['alt'];
				if (isset($row_b_expand['description']) && $row_b_expand['description'] != '') $name = $row_b_expand['description'];
				
				$name = phpAds_breakString ($name, '30');
				
				echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
				
		    	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
				
				echo "<td height='25'>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				
				if ($row_b_expand['format'] == 'html')
				{
					echo "<img src='images/icon-banner-html.gif' align='absmiddle'>&nbsp;";
				}
				elseif ($row_b_expand['format'] == 'url')
				{
					echo "<img src='images/icon-banner-url.gif' align='absmiddle'>&nbsp;";
				}
				else
				{
					echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";
				}
				
				echo "<a href='JavaScript:GoOpener(\"banner-edit.php?bannerID=".$row_b_expand['bannerID']."&campaignID=".$row_b_expand['clientID']."\")'>".$name."</a>";
				echo "</td>";
				
				echo "<td height='25'>".$row_b_expand['bannerID']."</td>";
				
				// Empty
				echo "<td>&nbsp;</td>";
			   	
				// Empty
				echo "<td height='25'>";
				if ($phpAds_acl == '1')
					echo "<a href='JavaScript:GoOpener(\"banner-acl.php?bannerID=".$row_b_expand['bannerID']."&campaignID=".$row_b_expand['clientID']."\")'><img src='images/icon-acl.gif' border='0' align='absmiddle' alt='$strACL'>&nbsp;$strACL</a>&nbsp;&nbsp;&nbsp;&nbsp;";
				else
					echo "&nbsp;";
				echo "</td>";
				
				// Button 1
				echo "<td height='25'>";
				echo "<a href='JavaScript:GoOpener(\"banner-delete.php?bannerID=".$row_b_expand['bannerID']."&campaignID=".$row_b_expand['clientID']."\")'".phpAds_DelConfirm($strConfirmDeleteBanner)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "</td></tr>";
			}
			
			$i++;
	    }
	}
	
	if (@mysql_num_rows($res_banners) > 0)
	{
		while ($row_banners = mysql_fetch_array($res_banners))
	    {
			$name = $strUntitled;
			if (isset($row_banners['alt']) && $row_banners['alt'] != '') $name = $row_banners['alt'];
			if (isset($row_banners['description']) && $row_banners['description'] != '') $name = $row_banners['description'];
			
			$name = phpAds_breakString ($name, '30');
			
			if ($i > 0) echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
			
	    	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
			
			echo "<td height='25'>";
			echo "&nbsp;&nbsp;";
			
			if ($row_banners['format'] == 'html')
			{
				echo "<img src='images/icon-banner-html.gif' align='absmiddle'>&nbsp;";
			}
			elseif ($row_banners['format'] == 'url')
			{
				echo "<img src='images/icon-banner-url.gif' align='absmiddle'>&nbsp;";
			}
			else
			{
				echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";
			}
			
			echo "<a href='JavaScript:GoOpener(\"banner-edit.php?bannerID=".$row_banners['bannerID']."&campaignID=".$row_banners['clientID']."\")'>".$name."</a>";
			echo "</td>";
			
			echo "<td height='25'>".$row_banners['bannerID']."</td>";
			
			// Empty
			echo "<td>&nbsp;</td>";
		   	
			// Empty
			echo "<td height='25'>";
			if ($phpAds_acl == '1')
				echo "<a href='JavaScript:GoOpener(\"banner-acl.php?bannerID=".$row_banners['bannerID']."&campaignID=".$row_banners['clientID']."\")'><img src='images/icon-acl.gif' border='0' align='absmiddle' alt='$strACL'>&nbsp;$strACL</a>&nbsp;&nbsp;&nbsp;&nbsp;";
			else
				echo "&nbsp;";
			echo "</td>";
			
			// Button 1
			echo "<td height='25'>";
			echo "<a href='JavaScript:GoOpener(\"banner-delete.php?bannerID=".$row_banners['bannerID']."&campaignID=".$row_banners['clientID']."\")'".phpAds_DelConfirm($strConfirmDeleteBanner)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "</td></tr>";
			
			$i++;
	    }
	}
	
	if (@mysql_num_rows($res_clients) > 0 ||
		@mysql_num_rows($res_campaigns) > 0 ||
		@mysql_num_rows($res_banners) > 0)
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
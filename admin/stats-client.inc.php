<?
$i = 0;


// Get statistics

$tmp_views = array();
$tmp_clicks = array();
$tmp_alt = array();
$tmp_crt = array();

if ($phpAds_compact_stats)
{
	$res_query = "
		SELECT
			$phpAds_tbl_banners.bannerID as bannerID,
			IF ($phpAds_tbl_banners.description='', $phpAds_tbl_banners.description, $phpAds_tbl_banners.alt) as alt,
			sum($phpAds_tbl_adstats.views) as adviews,
			sum($phpAds_tbl_adstats.clicks) as adclicks
		FROM
			$phpAds_tbl_banners
			LEFT JOIN $phpAds_tbl_adstats USING (bannerID)
		WHERE
			$phpAds_tbl_banners.clientID = $clientID
		GROUP BY
			$phpAds_tbl_banners.bannerID
		";
	
	$res_banners = db_query($res_query) or mysql_die();
	
	while ($row_banners = mysql_fetch_array($res_banners))
	{
		$tmp_views[$row_banners[bannerID]] = $row_banners[adviews];
		$tmp_clicks[$row_banners[bannerID]] = $row_banners[adclicks];
		$tmp_alt[$row_banners[bannerID]] = strtolower($row_banners[alt]);
		$tmp_ctr[$row_banners[bannerID]] = 0;
	}
}
else
{
	$res_query = "
		SELECT
			$phpAds_tbl_banners.bannerID as bannerID,
			IF ($phpAds_tbl_banners.description='', $phpAds_tbl_banners.description, $phpAds_tbl_banners.alt) as alt,
			count($phpAds_tbl_adviews.bannerID) as adviews
		FROM
			$phpAds_tbl_banners
			LEFT JOIN $phpAds_tbl_adviews USING (bannerID)
		WHERE
			$phpAds_tbl_banners.clientID = $clientID
		GROUP BY
			$phpAds_tbl_banners.bannerID
		";
	
	$res_banners = db_query($res_query) or mysql_die();
	
	while ($row_banners = mysql_fetch_array($res_banners))
	{
		$tmp_views[$row_banners[bannerID]] = $row_banners[adviews];
		$tmp_clicks[$row_banners[bannerID]] = 0;
		$tmp_alt[$row_banners[bannerID]] = strtolower($row_banners[alt]);
		$tmp_ctr[$row_banners[bannerID]] = 0;
	}
	
	$res_query = "
		SELECT
			$phpAds_tbl_banners.bannerID as bannerID,
			count($phpAds_tbl_adclicks.bannerID) as adclicks
		FROM
			$phpAds_tbl_banners
			LEFT JOIN $phpAds_tbl_adclicks USING (bannerID)
		WHERE
			$phpAds_tbl_banners.clientID = $clientID
		GROUP BY
			$phpAds_tbl_banners.bannerID
		";
	
	$res_banners = db_query($res_query) or mysql_die();
	
	while ($row_banners = mysql_fetch_array($res_banners))
	{
		$tmp_clicks[$row_banners[bannerID]] = $row_banners[adclicks];
	}
}

if (count($tmp_clicks) > 0)
{
	reset ($tmp_clicks);
	while (list ($key,) = each ($tmp_clicks)) 
	{
		if ($tmp_clicks[$key] != 0 && $tmp_views[$key] != 0)
			$tmp_ctr[$key] = 100 / $tmp_views[$key] / $tmp_clicks[$key];
		else
			$tmp_ctr[$key] = 0;
	}
}


if ($order == "adviews")
{
	if (count($tmp_views) > 0) arsort ($tmp_views, SORT_NUMERIC);
	$tmp_order = $tmp_views;
}
elseif ($order == "adclicks")
{
	if (count($tmp_clicks) > 0) arsort ($tmp_clicks, SORT_NUMERIC);
	$tmp_order = $tmp_clicks;
}
elseif ($order == "ctr")
{
	if (count($tmp_ctr) > 0) arsort ($tmp_ctr, SORT_NUMERIC);
	$tmp_order = $tmp_ctr;
}
elseif ($order == "alt")
{
	if (count($tmp_alt) > 0) asort ($tmp_alt, SORT_STRING);
	$tmp_order = $tmp_alt;
}
else
{
	$tmp_order = $tmp_views;
}

?>


<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='2'><b><?echo $strClientName.': '.phpAds_getClientName($clientID);?></b></td></tr>
	<tr height='1'><td colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr>
		<form action='<? echo $GLOBALS['PHP_SELF']; ?>'>
		<td height='35' align='left'>
			<input type='hidden' name='clientID' value='<? echo $clientID; ?>'>
			<select name='view' onChange='this.form.submit();'>
				<option value='all'<? echo $view=='all' ? " selected" : ""?>><? echo $strShowAllBanners ?></option>
				<option value='adclicks'<? echo $view=='adclicks' ? " selected" : ""?>><? echo $strShowBannersNoAdClicks ?></option>
				<option value='adviews'<? echo $view=='adviews' ? " selected" : ""?>><? echo $strShowBannersNoAdViews ?></option>
			</select>
			&nbsp;<? echo $strOrderBy ?>&nbsp;
			<select name='order' onChange='this.form.submit();'>
				<option value='bannerid'<? echo $order=='bannerid' ? " selected" : ""?>><? echo $strID ?></option>
				<option value='alt'<? echo $order=='alt' ? " selected" : ""?>><? echo $strDescription ?></option>
				<option value='adviews'<? echo $order=='adviews' ? " selected" : ""?>><? echo $strViews ?></option>
				<option value='adclicks'<? echo $order=='adclicks' ? " selected" : ""?>><? echo $strClicks ?></option>
				<option value='ctr'<? echo $order=='ctr' ? " selected" : ""?>><? echo $strCTRShort ?></option>
			</select>
			<input type="image" border="0" name='submit' src="images/go_blue.gif">
		</td>
		<td height='35' align='right'>
			<select name='compact' onChange='this.form.submit();'>
				<option value='false'<? echo $compact!='true' ? " selected" : ""?>><? echo $strVerbose ?></option>
				<option value='true'<? echo $compact=='true' ? " selected" : ""?>><? echo $strCompact ?></option>
			</select>
		</td>
		</form>
	</tr>
</table>


<br><br>
<br><br>


<script language="JavaScript">
<!--
function findObj(n, d) { 
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function showHideLayers(obj) { 
	bannerobj = findObj('banner'+obj);
	caretobj = findObj('caret'+obj);

	if (bannerobj.style)
	{
		if (bannerobj.style.visibility=='hidden')
		{
			bannerobj.style.visibility='visible';
			bannerobj.style.overflow='visible';
			if (caretobj) caretobj.src = 'images/caret-d.gif'
		}
		else
		{
			bannerobj.style.visibility='hidden';
			bannerobj.style.overflow='hidden';
			if (caretobj) caretobj.src = 'images/caret-r.gif'
		}	
	}
}
//-->
</script>


<?

if (count($tmp_order) > 0)
{
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
	
	if ($compact == "true")
	{
		// Legend
		echo "<tr bgcolor='#FFFFFF' height='25'>";
		echo "<td>&nbsp;</td>";
		echo "<td align='left' nowrap height='25'><b><a class='black' href='$PHP_SELF?clientID=$clientID&view=$view&order=id&compact=$compact'>$strID</a></b></td>";
		echo "<td align='left' nowrap height='25'><b><a class='black' href='$PHP_SELF?clientID=$clientID&view=$view&order=alt&compact=$compact'>$strDescription</a></b></td>";
		echo "<td align='left' nowrap height='25'><b><a class='black' href='$PHP_SELF?clientID=$clientID&view=$view&order=adviews&compact=$compact'>$strViews</a></b></td>";
		echo "<td align='left' nowrap height='25'><b><a class='black' href='$PHP_SELF?clientID=$clientID&view=$view&order=adclicks&compact=$compact'>$strClicks</a></b></td>";
		echo "<td align='left' nowrap height='25'><b><a class='black' href='$PHP_SELF?clientID=$clientID&view=$view&order=ctr&compact=$compact'>$strCTRShort</a></b></td>";
		echo "</tr>";
	}
	
	$totaladviews = 0;
	$totaladclicks = 0;
	$where = "";
	
	
	reset ($tmp_order);
	while (list ($bannerID,) = each ($tmp_order)) 
	{
	    $adviews  = $tmp_views[$bannerID];
	    $adclicks = $tmp_clicks[$bannerID];
	    $adctr    = $tmp_ctr[$bannerID];
		
		if ($adclicks != 0 && $view == 'adclicks') continue;	// Don't show banners without adclicks
		if ($adviews != 0 && $view == 'adviews') continue;	// Don't show banners without adclicks
		
		
		$totaladviews += $adviews;
		$totaladclicks += $adclicks;
			
		$res_query = "
			SELECT
				banner,
				bannerID,
				width,
				height,
				format,
				active,
				alt,
				description,
				bannertext
			FROM
				$phpAds_tbl_banners
			WHERE
				bannerID = $bannerID
			";
		
		$res_banners = db_query($res_query) or mysql_die();
		$row_banners = mysql_fetch_array($res_banners);
		
		
		$grayedout = $row_banners["active"] == "true" ? "" : "class='gray'";
		$grayedtext = $row_banners["active"] == "true" ? "black" : "gray";
		
		$where .= " bannerID = $row_banners[bannerID] OR";
		
		if ($compact != "true")
		{
			// Background color
			$i % 2 ? $bgcolor="#F6F6F6": $bgcolor= "#F6F6F6";
			$i++;
			
			// Divider
			echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
			
			
			// Banner
			echo "<tr><td height='10' colspan='4' bgcolor='$bgcolor'>&nbsp;</td></tr>";
			echo "<tr bgcolor='$bgcolor'>";
		   	echo "<td colspan='4' align='center'>";
			echo phpAds_buildBannerCode ($row_banners[bannerID], $row_banners[banner], $row_banners[active], $row_banners[format], $row_banners[width], $row_banners[height], $row_banners[bannertext]);
			echo "</td></tr>";
			echo "<tr><td height='10' colspan='4' bgcolor='$bgcolor'>&nbsp;</td></tr>";
		  	
			
		    if ($adclicks > 0 || $adviews > 0)
		    {
				// Stats
				echo "<tr bgcolor='$bgcolor'>";
				echo "<td height='25' align='left' nowrap $grayedout>&nbsp;$strID: <b>$row_banners[bannerID]</b></td>";
				echo "<td height='25' align='left' nowrap $grayedout>$strViews: <b>$adviews</b></td>";
				echo "<td height='25' align='left' nowrap $grayedout>$strClicks: <b>$adclicks</b></td>";
				echo "<td height='25' align='left' nowrap $grayedout>$strRatio: <b>";
				printf(" %.2f%%", $adctr);
				echo "<b></td>";
				echo "</tr>";
			}
			else
			{
				echo "<tr bgcolor='$bgcolor'>";
				echo "<td height='25' align='left' nowrap $grayedout>&nbsp;ID: <b>$row_banners[bannerID]</b></td>";
				echo "<td height='25' bgcolor='$bgcolor' colspan='3' $grayedout>$strBannerNoStats</td>";
				echo "</tr>";
			}
			
			
			// Divider
			echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
			
			
			// Buttons
			echo "<tr><td colspan='4' height='25'>";
			
			if ($adclicks > 0 || $adviews > 0)
			{
				echo "<img src='images/go_blue.gif'>&nbsp;";
				echo "<a href='stats-details.php?clientID=$clientID&bannerID=$row_banners[bannerID]'>$strDetailStats</a>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				
				if (phpAds_isUser(phpAds_Admin)) // only for the admin
				{
					echo "<img src='images/go_blue.gif'>&nbsp;";
					echo "<a href='stats-reset.php?clientID=$clientID&bannerID=$row_banners[bannerID]'>$strResetStats</a>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				}
			}
			if (phpAds_isUser(phpAds_Admin) || (phpAds_isUser(phpAds_Client) && phpAds_isAllowed(phpAds_ModifyBanner))) // only for the admin
			{
				echo "<img src='images/go_blue.gif'>&nbsp;";
				echo "<a href='banner-edit.php?clientID=$clientID&bannerID=$row_banners[bannerID]'>$strModifyBanner</a>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			echo "</td></tr>";
			
			echo "<tr><td height='35' colspan='4' bgcolor='#FFFFFF'>&nbsp;</td></tr>";
		}
		else
		{
			// Background color
			$i % 2 ? $bgcolor="#FFFFFF": $bgcolor= "#F6F6F6";
			$i++;
			
			
			echo "<tr><td height='1' colspan='6' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
			
			echo "<tr bgcolor='$bgcolor'>";
			
			echo "<td height='25' align='left'>&nbsp;";
			if (!ereg ("Mozilla/4", $HTTP_USER_AGENT) || ereg ("IE", $HTTP_USER_AGENT))
				echo "<img name='caret$row_banners[bannerID]' src='images/caret-r.gif' onClick=\"showHideLayers('$row_banners[bannerID]');\">&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "</td>";
			
			echo "<td height='25' align='left' nowrap $grayedout>$row_banners[bannerID]</td>";
			
			if ($row_banners[description] != '')
				echo "<td height='25' align='left' nowrap $grayedout>$row_banners[description]</td>";
			else
				echo "<td height='25' align='left' nowrap $grayedout>$row_banners[alt]</td>";
			
		    if ($adclicks > 0 || $adviews > 0)
		    {
				// Stats
				echo "<td height='25' align='left' nowrap $grayedout>";
				echo "<a class='$grayedtext' height='25' href='stats-details.php?clientID=$clientID&bannerID=$row_banners[bannerID]'>$adviews</a>";
				echo "</td>";
	
				echo "<td height='25' align='left' nowrap $grayedout>";
				echo "<a class='$grayedtext' height='25' href='stats-details.php?clientID=$clientID&bannerID=$row_banners[bannerID]'>$adclicks</a>";
				echo "</td>";
	
				echo "<td height='25' align='left' nowrap $grayedout>";
				echo "<a class='$grayedtext' height='25' href='stats-details.php?clientID=$clientID&bannerID=$row_banners[bannerID]'>";
				printf(" %.2f%%", $adctr);
				echo "</a>";
				echo "</td>";
			}
			else
			{
				echo "<td height='25' bgcolor='$bgcolor' colspan='3' $grayedout>$strBannerNoStats</td>";
			}
			
			echo "</tr>";
			
			echo "<tr bgcolor='$bgcolor'>";
			echo "<td height='1'><img src='images/spacer.gif' width='1' height='1'></td>";
			echo "<td colspan='5'>";
			
			if (!ereg ("Mozilla/4", $HTTP_USER_AGENT) || ereg ("IE", $HTTP_USER_AGENT))
			{
				echo "<div id='banner$row_banners[bannerID]' style='position:relative; height: 1px; overflow: hidden; visibility: hidden;'>";
				
				echo "<table width='100%' cellpadding=0 cellspacing=0 border=0><tr><td align='left'>";
				echo "<tr><td height='1'><img src='images/break-l.gif' height='1' width='100%' vspace='0'></tr><td>";
				echo "<tr><td height='10'>&nbsp;</tr><td>";
				echo "<tr><td>";
					echo phpAds_buildBannerCode ($row_banners[bannerID], $row_banners[banner], $row_banners[active], $row_banners[format], $row_banners[width], $row_banners[height], $row_banners[bannertext]);
				echo "</tr><td>";
				echo "<tr><td height='10'>&nbsp;</tr><td>";
				echo "<tr><td height='1'><img src='images/break-l.gif' height='1' width='100%' vspace='0'></tr><td>";
				echo "<tr><td height='25'>";
				
			    if ($adclicks > 0 || $adviews > 0)
				{
					echo "<a href='stats-details.php?clientID=$clientID&bannerID=$row_banners[bannerID]'>[&nbsp;$strDetailStats&nbsp;]</a>";
					echo "&nbsp;&nbsp;&nbsp;";
					
					if (phpAds_isUser(phpAds_Admin)) // only for the admin
					{
						echo "<a href='stats-reset.php?clientID=$clientID&bannerID=$row_banners[bannerID]'>[&nbsp;$strResetStats&nbsp;]</a>";
						echo "&nbsp;&nbsp;&nbsp;";
					}
				}
				
				if (phpAds_isUser(phpAds_Admin) || (phpAds_isUser(phpAds_Client) && phpAds_isAllowed(phpAds_ModifyBanner))) // only for the admin
				{
					echo "<a href='banner-edit.php?clientID=$clientID&bannerID=$row_banners[bannerID]'>[&nbsp;$strModifyBanner&nbsp;]</a>";
					echo "&nbsp;&nbsp;&nbsp;";
				}
				echo "</tr><td>";
				echo "</table>";
				
				echo "</div>";
			}
			
			echo "</td></tr>";
		}
	}
	
	if ($compact == "true")
	{
		echo "<tr><td height='1' colspan='6' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		echo "<tr><td height='35' colspan='6' bgcolor='#FFFFFF'>&nbsp;</td></tr>";
	}
	
	echo "</table>";
	echo "<br><br>";
}



?>

<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='2'><b><?echo $strCreditStats;?></b></td></tr>
	<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>

<?
if (phpAds_GDImageFormat() != "none" && $totaladviews > 0 && !$phpAds_compact_stats)
{
?>
	<tr><td height='20' colspan='2'>&nbsp;</td></tr>	
	<tr>
		<td bgcolor="#FFFFFF" colspan=2><img src="graph-hourly.php?where=<?$where = ereg_replace("OR$", "", $where); echo urlencode("$where");?>" border="0" width="385" height="150"></td>
	</tr>
	<tr><td height='10' colspan='2'>&nbsp;</td></tr>	
	<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
<?
}
?>

<?
list($desc,$enddate,$daysleft)=days_left($clientID);
$adclicksleft = adclicks_left($clientID);
$adviewsleft  = adviews_left($clientID);
?>
	<tr>
		<td height='25'><?echo $strTotalViews;?>: <b><?echo $totaladviews;?></b></td>
		<td height='25'><?echo $strViewCredits;?>: <b><?echo $adviewsleft;?></b></td>
	</tr>
	<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>
	<tr>
		<td height='25'><?echo $strTotalClicks;?>: <b><?echo $totaladclicks;?></b></td>
		<td height='25'><?echo $strClickCredits;?>: <b><?echo $adclicksleft;?></b></td>
	</tr>
	<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>
	<tr>
		<td height='25' colspan='2'><? echo $desc; ?></td>
	</tr>
	<?
		if ($adviewsleft != $strUnlimited || $adclicksleft != $strUnlimited) {
	?>
	<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr>
		<td height='60' align='left'>
		<?
		if ($adviewsleft == $strUnlimited)
			print "&nbsp;";
		else
			print "<img src='graph-daily.php?width=200&data=Views^$totaladviews^^Credits^$adviewsleft^^'></td>\n";
		print "<td height='60'>";
		if ($adclicksleft == $strUnlimited)
			print "&nbsp;";
		else
			print "<img src='graph-daily.php?width=200&data=Clicks^$totaladclicks^^Credits^$adclicksleft^^'></td>\n";
		?>
	</tr>
	<?
		}
	?>
	<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr>
		<td colspan='2' height='25'>
		<?
		if ($totaladclicks > 0 || $totaladviews > 0)
		{
			print "<img src='images/go_blue.gif'>&nbsp;<a href=\"stats-weekly.php?clientID=$clientID\">$strWeeklyStats</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		?>
		</td>
	</tr>
</table>

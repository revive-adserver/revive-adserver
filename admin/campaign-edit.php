<?php // $Revision$

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



/*********************************************************/
/* Process submitted form                                */
/*********************************************************/

if (isset($submit))
{ 
	// If ID is not set, it should be a null-value for the auto_increment
	
	if (empty($campaignid))
	{
		$campaignid = "null";
	}
	
	// set expired
	if ($views == '-')
		$views = 0;
	if ($clicks == '-')
		$clicks = 0;
	
	// set unlimited
	if (strtolower ($unlimitedviews) == "on")
		$views = -1;
	if (strtolower ($unlimitedclicks) == "on")
		$clicks = -1;
	
	if ($priority == 't')
	{
		// set target
		if (isset($target))
		{
			if ($target == '-')
				$target = 0;
			elseif ($target == '')
				$target = 0;
		}
		else
			$target = 0;
		
		$weight = 0;
	}
	else
	{
		// set weight
		if (isset($weight))
		{
			if ($weight == '-')
				$weight = 0;
			elseif ($weight == '')
				$weight = 0;
		}
		else
			$weight = 0;
		
		$target = 0;
	}
	
	if ($expireSet == 't')
	{
		if ($expireDay != '-' && $expireMonth != '-' && $expireYear != '-')
		{
			$expire = $expireYear."-".$expireMonth."-".$expireDay;
		}
		else
			$expire = "0000-00-00";
	}
	else
		$expire = "0000-00-00";
	
	
	if ($activateSet == 't')
	{
		if ($activateDay != '-' && $activateMonth != '-' && $activateYear != '-')
		{
			$activate = $activateYear."-".$activateMonth."-".$activateDay;
		}
		else
			$activate = "0000-00-00";
	}
	else
		$activate = "0000-00-00";
	
	
	$active = "t";
	
	if ($clicks == 0 || $views==0)
		$active = "f";
	
	if ($activateDay != '-' && $activateMonth != '-' && $activateYear != '-')
		if (time() < mktime(0, 0, 0, $activateMonth, $activateDay, $activateYear))
			$active = "f";
	
	if ($expireDay != '-' && $expireMonth != '-' && $expireYear != '-')
		if (time() > mktime(0, 0, 0, $expireMonth, $expireDay, $expireYear))
			$active = "f";
	
	
	$query = "
		REPLACE INTO
			".$phpAds_config['tbl_clients']."
		   (clientid,
			clientname,
			parent,
			views,
			clicks,
			expire,
			activate,
			active,
			weight,
			target)
		VALUES
			('$campaignid',
			'$clientname',
			'$clientid',
			'$views',
			'$clicks',
			'$expire',
			'$activate',
			'$active',
			'$weight',
			'$target')";
	
	
	$res = phpAds_dbQuery($query) or phpAds_sqlDie();  
	if (isset($move) && $move == 't')
	{
		// We are moving a client to a campaign
		// Get ID of new campaign
		$campaignid = phpAds_dbInsertID();
		
		// Update banners
		$res = phpAds_dbQuery("
			UPDATE
				".$phpAds_config['tbl_banners']."
			SET
				clientid=$campaignid
			WHERE
				clientid=$clientid  
			") or phpAds_sqlDie();
	}
	
	Header("Location: client-index.php?expand=$clientid&message=".urlencode($message));
	exit;
}




/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if ($campaignid != "")
{
	// Edit and existing campaign
	
	$extra = '';
	
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_clients']."
		WHERE
			parent != 0  
		") or phpAds_sqlDie();
		
	while ($row = phpAds_dbFetchArray($res))
	{
		if ($campaignid == $row['clientid'])
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
		else
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
		
		$extra .= "<a href=campaign-edit.php?campaignid=". $row['clientid'].">".phpAds_buildClientName ($row['clientid'], $row['clientname'])."</a>";
		$extra .= "<br>"; 
	}
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	
	$extra .= "<form action='campaign-modify.php'>";
	$extra .= "<input type='hidden' name='campaignid' value='$campaignid'>";
	$extra .= "<input type='hidden' name='returnurl' value='campaign-edit.php'>";
	$extra .= "<br><br>";
	$extra .= "<b>$strModifyCampaign</b><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-move-campaign.gif' align='absmiddle'>&nbsp;$strMoveTo<br>";
	$extra .= "<img src='images/spacer.gif' height='1' width='160' vspace='2'><br>";
	$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	$extra .= "<select name='moveto' style='width: 110;'>";
	
	$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_clients']." WHERE parent = 0 AND clientid != ".phpAds_getParentID ($campaignid)) or phpAds_sqlDie();
	while ($row = phpAds_dbFetchArray($res))
		$extra .= "<option value='".$row['clientid']."'>".phpAds_buildClientName($row['clientid'], $row['clientname'])."</option>";
	
	$extra .= "</select>&nbsp;<input type='image' src='images/go_blue.gif'><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-recycle.gif' align='absmiddle'>&nbsp;<a href='campaign-delete.php?campaignid=$campaignid&returnurl=client-index.php'".phpAds_DelConfirm($strConfirmDeleteCampaign).">$strDelete</a><br>";
	$extra .= "</form>";
	
	
	$extra .= "<br><br><br>";
	$extra .= "<b>$strShortcuts</b><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<a href=client-edit.php?clientid=".phpAds_getParentID ($campaignid).">$strClientProperties</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-statistics.gif' align='absmiddle'>&nbsp;<a href=stats-campaign.php?campaignid=$campaignid>$strStats</a><br>";
	$extra .= "<img src='images/break-el.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/icon-weekly.gif' align='absmiddle'>&nbsp;<a href=stats-weekly.php?campaignid=$campaignid>$strWeeklyStats</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	phpAds_PageHeader("4.1.4", $extra);
		echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
		echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($campaignid)."</b><br><br><br>";
		phpAds_ShowSections(array("4.1.4", "4.1.5"));
}
else
{
	if (isset($move) && $move == 't')
	{
		// Convert client to campaign
		phpAds_PageHeader("4.1.4");
			echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($clientid);
			echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".$strUntitled."</b><br><br><br>";
			phpAds_ShowSections(array("4.1.4"));
	}
	else
	{
		// New campaign
		phpAds_PageHeader("4.1.3");   
			echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($clientid);
			echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".$strUntitled."</b><br><br><br>";
			phpAds_ShowSections(array("4.1.3"));
	}
}

if ($campaignid != "" || (isset($move) && $move == 't'))
{
	// Edit or Convert
	// Fetch exisiting settings
	// Parent setting for converting, campaign settings for editing
	if ($campaignid != "") $ID = $campaignid;
	if (isset($clientid) && $clientid != "") $ID = $clientid;
	
	$res = phpAds_dbQuery("
		SELECT
			*,
			to_days(expire) as expire_day,
			to_days(curdate()) as cur_date,
			UNIX_TIMESTAMP(expire) as timestamp,
			DATE_FORMAT(expire, '$date_format') as expire_f,
			dayofmonth(expire) as expire_dayofmonth,
			month(expire) as expire_month,
			year(expire) as expire_year,
			DATE_FORMAT(activate, '$date_format') as activate_f,
			dayofmonth(activate) as activate_dayofmonth,
			month(activate) as activate_month,
			year(activate) as activate_year
		FROM
			".$phpAds_config['tbl_clients']."
		WHERE
			clientid = $ID
		") or phpAds_sqlDie();
		
	$row = phpAds_dbFetchArray($res);
	
	if ($row['weight'] > 0 && $row['target'] <= 0)
	{
		$priority = 'f';
		$row['target'] = '-';
	}
	elseif ($row['target'] > 0 && $row['weight'] <= 0)
	{
		$priority = 't';
		$row['weight'] = '-';
	}
	
	// Set parent when editing an campaign, don't set it
	// when moving an campaign.
	if ($campaignid != "" && isset($row["parent"]))
		$clientid = $row["parent"];
	
	// Set default activation settings
	if (!isset($row["activate_dayofmonth"]))
		$row["activate_dayofmonth"] = 0;
	if (!isset($row["activate_month"]))
		$row["activate_month"] = 0;
	if (!isset($row["activate_year"]))
		$row["activate_year"] = 0;
	if (!isset($row["activate_f"]))
		$row["activate_f"] = "-";
	
	// Set default expiration settings
	if (!isset($row["expire_dayofmonth"]))
		$row["expire_dayofmonth"] = 0;
	if (!isset($row["expire_month"]))
		$row["expire_month"] = 0;
	if (!isset($row["expire_year"]))
		$row["expire_year"] = 0;
	if (!isset($row["expire_f"]))
		$row["expire_f"] = "-";
	
	// Check if timestamp is in the past or future
	if ($row["timestamp"] < time())
	{
		if ($row["timestamp"] > 0)
			$days_left = "0";
		else
			$days_left = -1;
	}
	else
		$days_left=$row["expire_day"] - $row["cur_date"];
}
else
{
	// New
	
	$row["views"] = '';
	$row["clicks"] = '';
	$days_left = '';
	$priority = 'f';
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (!isset($row['views']) || (isset($row['views']) && $row['views'] == ""))
	$row["views"] = -1;
if (!isset($row['clicks']) || (isset($row['clicks']) && $row['clicks'] == ""))
	$row["clicks"] = -1;

if ($days_left == "")
	$days_left = -1;

function phpAds_showDateEdit($name, $day=0, $month=0, $year=0, $edit=true)
{
	global $strMonth, $strDontExpire, $strActivateNow;
	
	if ($day == 0 && $month == 0 && $year == 0)
	{
		$day = '-';
		$month = '-';
		$year = '-';
		$set = false;
	}
	else
	{
		$set = true;
	}
	
	if ($name == 'expire')
		$caption = $strDontExpire;
	elseif ($name == 'activate')
		$caption = $strActivateNow;
	
	if ($edit)
	{
		echo "<table><tr><td>";
		echo "<input type='radio' name='".$name."Set' value='f' onclick=\"disableradio('".$name."', false);\"".($set==false?' checked':'').">";
		echo "&nbsp;$caption";
		echo "</td></tr><tr><td>";
		echo "<input type='radio' name='".$name."Set' value='t' onclick=\"disableradio('".$name."', true);\"".($set==true?' checked':'').">";
		echo "&nbsp;";
		
		echo "<select name='".$name."Day' onchange=\"checkdate('".$name."');\">\n";
		echo "<option value='-'".($day=='-' ? ' selected' : '').">-</option>\n";
		for ($i=1;$i<=31;$i++)
			echo "<option value='$i'".($day==$i ? ' selected' : '').">$i</option>\n";
		echo "</select>&nbsp;\n";
		
		echo "<select name='".$name."Month' onchange=\"checkdate('".$name."');\">\n";
		echo "<option value='-'".($month=='-' ? ' selected' : '').">-</option>\n";
		for ($i=1;$i<=12;$i++)
			echo "<option value='$i'".($month==$i ? ' selected' : '').">".$strMonth[$i-1]."</option>\n";
		echo "</select>&nbsp;\n";
		
		if ($year != '-')
			$start = $year < date('Y') ? $year : date('Y');
		else
			$start = date('Y');
		
		echo "<select name='".$name."Year' onchange=\"checkdate('".$name."');\">\n";
		echo "<option value='-'".($year=='-' ? ' selected' : '').">-</option>\n";
		for ($i=$start;$i<=($start+4);$i++)
			echo "<option value='$i'".($year==$i ? ' selected' : '').">$i</option>\n";
		echo "</select>\n";
		
		echo "</td></tr></table>";
	}
	else
	{
		if ($set == true)
		{
			echo $day." ".$strMonth[$month-1]." ".$year;
		}
		else
		{
			echo $caption;
		}
	}
}
?>


<script language="JavaScript">
<!--
	function disableradio(o, value)
	{
		day = eval ("document.clientform." + o + "Day.value");
		month = eval ("document.clientform." + o + "Month.value");
		year = eval ("document.clientform." + o + "Year.value");

		if (value == false)
		{
			eval ("document.clientform." + o + "Day.selectedIndex = 0");
			eval ("document.clientform." + o + "Month.selectedIndex = 0");
			eval ("document.clientform." + o + "Year.selectedIndex = 0");
		}
		
		if (value == true && (day=='-' || month=='-' || year=='-'))
		{
			eval ("document.clientform." + o + "Set[0].checked = true");
		}
	}

	function checkdate(o)
	{
		day = eval ("document.clientform." + o + "Day.value");
		month = eval ("document.clientform." + o + "Month.value");
		year = eval ("document.clientform." + o + "Year.value");
		
		if (day=='-' || month=='-' || year=='-')
		{
			eval ("document.clientform." + o + "Set[0].checked = true");
		}
		else
		{
			eval ("document.clientform." + o + "Set[1].checked = true");
		}
	}
	
	function valid(form)
	{
		var views=form.views.value;
		var clicks=form.clicks.value;

		if (!parseInt(views))
		{
			if (eval(form.unlimitedviews.checked) == false && views != '-')
			{
				alert("<?print $GLOBALS['strErrorViews'];?>");
				return false;
			}
		} 
		else if (parseInt(views) < 0)
		{
			alert("<?print $GLOBALS['strErrorNegViews'];?>");
			return false;
		}
		
		if (!parseInt(clicks))
		{
			if (eval(form.unlimitedclicks.checked) == false && clicks != '-')
			{
				alert("<?print $GLOBALS['strErrorClicks'];?>");
				return false;
			}
		} 
		else if (parseInt(clicks) < 0)
		{
			alert("<?print $GLOBALS['strErrorNegClicks'];?>");
			return false;
		}
	}
	
	
	function validate_form_campaign()
	{
		return validate_form('clientname','strName','R',
							 'views','strViewsPurchased','Ris+NumOR-',
							 'clicks','strClicksPurchased','Ris+NumOR-',
							 'weight', 'strWeight', 'Ris+Num');
	}

	
//-->
</script>


<br><br>
  

<form name="clientform" method="post" action="<?php echo basename($PHP_SELF);?>" onSubmit="return validate_form_campaign();">
<input type="hidden" name="campaignid" value="<?php if(isset($campaignid)) echo $campaignid;?>">
<input type="hidden" name="clientid" value="<?php if(isset($clientid)) echo $clientid;?>">
<input type="hidden" name="expire" value="<?php if(isset($row["expire"])) echo $row["expire"];?>">
<input type="hidden" name="move" value="<?php if(isset($move)) echo $move;?>">

<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='3'><b><?php echo $strBasicInformation;?></b></td></tr>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>

	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strName;?></td>
		<td><input type="text" name="clientname" size='35' style="width:350px;" value="<?php if(isset($row["clientname"])) echo $row["clientname"]; else echo $strDefault;?>"></td>
	</tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>

	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
</table>

<br><br>
<br><br>
<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='3'><b><?php echo $strContractInformation;?></b></td></tr>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>

	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
	<?php
		if (isset($row['active']) && $row['active'] == 'f') {
	?>
	<tr>
		<td width='30' valign='top'><img src='images/info.gif'></td>
		<td width='200' colspan='2'>
		<?php
			echo $strClientDeactivated;
			
			$expire_ts = mktime(0, 0, 0, $row["expire_month"], $row["expire_dayofmonth"], $row["expire_year"]);
			
			if ($row['clicks'] == 0) echo ", $strNoMoreClicks";
			if ($row['views'] == 0) echo ", $strNoMoreViews";
			if (time() < mktime(0, 0, 0, $row["activate_month"], $row["activate_dayofmonth"], $row["activate_year"]))
				echo ", $strBeforeActivate";
			if (time() > $expire_ts && $expire_ts > 0)
				echo ", $strAfterExpire";
			
			echo ".<br><br>";
		?>
		</td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<?php
		}
	?>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strViewsPurchased;?></td>
		<td>
			<input type="text" name="views" size='25' value="<?php if($row["views"]>0) echo $row["views"]; else echo '-';?>" onKeyUp="disable_checkbox('unlimitedviews', 'views');">
			<input type="checkbox" name="unlimitedviews"<?php if($row["views"]==-1) print " CHECKED";?> onClick="click_checkbox('unlimitedviews', 'views');">
			<?php echo $GLOBALS['strUnlimited']; ?>
		</td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strClicksPurchased;?></td>
		<td>
			<input type="text" name="clicks" size='25' value="<?php if($row["clicks"]>0) echo $row["clicks"]; else echo '-';?>" onKeyUp="disable_checkbox('unlimitedclicks', 'clicks');">
			<input type="checkbox" name="unlimitedclicks"<?php if($row["clicks"]==-1) print " CHECKED";?> onClick="click_checkbox('unlimitedclicks', 'clicks');">
			<?php echo $GLOBALS['strUnlimited']; ?>
		</td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $GLOBALS['strActivationDate']; ?></td>
		<td>
			<?php phpAds_showDateEdit('activate', isset($row["activate_dayofmonth"]) ? $row["activate_dayofmonth"] : 0, 
											   	  isset($row["activate_month"]) ? $row["activate_month"] : 0, 
											   	  isset($row["activate_year"]) ? $row["activate_year"] : 0); ?>
		</td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strExpirationDate; ?></td>
		<td>
			<?php phpAds_showDateEdit('expire', isset($row["expire_dayofmonth"]) ? $row["expire_dayofmonth"] : 0, 
											 	isset($row["expire_month"]) ? $row["expire_month"] : 0, 
											 	isset($row["expire_year"]) ? $row["expire_year"] : 0); ?>
		</td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200' valign='top'><?php echo $strPriority; ?></td>
		<td>
			<table><tr><td valign='top'>
			<input type="radio" name="priority" value="t" <?php echo $priority != 'f' ? 'checked' : ''; ?>>
			</td><td valign='top'>
			<?php echo $strHighPriority; ?><br>
			<img src='images/break-l.gif' height='1' width='100%' vspace='6'><br>
			<?php echo $strTargetLimitAdviews; ?> 
			<input type="text" name="target" size='7' value="<?php echo isset($row["target"]) ? $row["target"] : '-';?>"> <?php echo $strTargetPerDay; ?><br><br>
			</td></tr><tr><td valign='top'>
			<input type="radio" name="priority" value="f" <?php echo $priority == 'f' ? 'checked' : ''; ?>>			
			</td><td valign='top'>
			<?php echo $strLowPriority; ?><br>
			<img src='images/break-l.gif' height='1' width='100%' vspace='6'><br>
			<?php echo $strCampaignWeight; ?>: 
			<input type="text" name="weight" size='7' value="<?php echo isset($row["weight"]) ? $row["weight"] : $phpAds_config['default_campaign_weight'];?>">
			</td></tr></table>
		</td>
	</tr>

	<tr><td height='10' colspan='3'>&nbsp;</td></tr>

	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
</table>

<br><br>
		
<input type="submit" name="submit" value="<?php echo $strSaveChanges;?>">
</form>



<?php

/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>

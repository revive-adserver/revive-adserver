<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-statistics.inc.php");


// Register input variables
phpAds_registerGlobal ('move', 'submit', 'clientname', 'views', 'clicks', 'unlimitedviews', 'unlimitedclicks', 'priority', 
					   'targetviews', 'weight', 'expire', 'expireSet', 'expireDay', 'expireMonth', 'expireYear', 'activateSet', 
					   'activateDay', 'activateMonth', 'activateYear');


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
	if (isset($unlimitedviews) && strtolower ($unlimitedviews) == "on")
		$views = -1;
	if (isset($unlimitedclicks) && strtolower ($unlimitedclicks) == "on")
		$clicks = -1;
	
	
	if ($priority == 't')
	{
		// set target
		if (isset($targetviews))
		{
			if ($targetviews == '-')
				$targetviews = 0;
			elseif ($targetviews == '')
				$targetviews = 0;
		}
		else
			$targetviews = 0;
		
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
		
		$targetviews = 0;
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
			'$targetviews')";
	
	
	$res = phpAds_dbQuery($query) or phpAds_sqlDie();  
	
	// Get ID of campaign
	if ($campaignid == "null")
		$campaignid = phpAds_dbInsertID();
	
	
	// Auto-target campaign if adviews purchased and expiration set
	if ($active == 't' && $expire != '0000-00-00' && $views > 0)
	{
		phpAds_dbQuery("
			UPDATE ".$phpAds_config['tbl_clients']."
			SET
				target = ".
					ceil($views/(((mktime(0, 0, 0, $expireMonth, $expireDay, $expireYear) -
					mktime(0, 0, 0, date('m'), date('d'), date('Y'))) / (double)(60*60*24))))."
			WHERE
				clientid = ".$campaignid
		);
	}
	
	if (isset($move) && $move == 't')
	{
		// We are moving a client to a campaign
		// Update banners
		$res = phpAds_dbQuery("
			UPDATE
				".$phpAds_config['tbl_banners']."
			SET
				clientid='".$campaignid."'
			WHERE
				clientid='".$clientid."'
			") or phpAds_sqlDie();
	}
	
	
	require ("../lib-priority.inc.php");
	phpAds_PriorityCalculate ();
	
	require ("lib-zones.inc.php");
	phpAds_RebuildZoneCache ();
	
	
	Header("Location: campaign-zone.php?clientid=".$clientid."&campaignid=".$campaignid);
	exit;
}




/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if ($campaignid != "")
{
	if (isset($Session['prefs']['client-campaigns.php'][$clientid]['listorder']))
		$navorder = $Session['prefs']['client-campaigns.php'][$clientid]['listorder'];
	else
		$navorder = '';
	
	if (isset($Session['prefs']['client-campaigns.php'][$clientid]['orderdirection']))
		$navdirection = $Session['prefs']['client-campaigns.php'][$clientid]['orderdirection'];
	else
		$navdirection = '';
	
	
	// Get other campaigns
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_clients']."
		WHERE
			parent = ".$clientid."
		".phpAds_getListOrder ($navorder, $navdirection)."
	");
	
	while ($row = phpAds_dbFetchArray($res))
	{
		phpAds_PageContext (
			phpAds_buildClientName ($row['clientid'], $row['clientname']),
			"campaign-edit.php?clientid=".$clientid."&campaignid=".$row['clientid'],
			$campaignid == $row['clientid']
		);
	}
	
	phpAds_PageShortcut($strClientProperties, 'client-edit.php?clientid='.$clientid, 'images/icon-client.gif');
	phpAds_PageShortcut($strCampaignHistory, 'stats-campaign-history.php?clientid='.$clientid.'&campaignid='.$campaignid, 'images/icon-statistics.gif');
	
	
	
	$extra  = "<form action='campaign-modify.php'>";
	$extra .= "<input type='hidden' name='campaignid' value='$campaignid'>";
	$extra .= "<input type='hidden' name='clientid' value='$clientid'>";
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
	
	$extra .= "</select>&nbsp;<input type='image' src='images/".$phpAds_TextDirection."/go_blue.gif'><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-recycle.gif' align='absmiddle'>&nbsp;<a href='campaign-delete.php?clientid=".$clientid."&campaignid=".$campaignid."&returnurl=client-index.php'".phpAds_DelConfirm($strConfirmDeleteCampaign).">$strDelete</a><br>";
	$extra .= "</form>";
	
	
	
	phpAds_PageHeader("4.1.3.2", $extra);
		echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($campaignid)."</b><br><br><br>";
		phpAds_ShowSections(array("4.1.3.2", "4.1.3.3", "4.1.3.4"));
}
else
{
	if (isset($move) && $move == 't')
	{
		// Convert client to campaign
		
		phpAds_PageHeader("4.1.3.2");
			echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($clientid);
			echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".$strUntitled."</b><br><br><br>";
			phpAds_ShowSections(array("4.1.3.2"));
	}
	else
	{
		// New campaign
		
		phpAds_PageHeader("4.1.3.1");
			echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($clientid);
			echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".$strUntitled."</b><br><br><br>";
			phpAds_ShowSections(array("4.1.3.1"));
	}
}

if ($campaignid != "" || (isset($move) && $move == 't'))
{
	// Edit or Convert
	// Fetch exisiting settings
	// Parent setting for converting, campaign settings for editing
	if ($campaignid != "") $ID = $campaignid;
	if (isset($move) && $move == 't')
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
	
	if ($row['target'] > 0)
	{
		$priority = 't';
		$row['weight'] = '-';
	}
	else
	{
		$priority = 'f';
		$row['target'] = '-';
	}
	
	// Set parent when editing an campaign, don't set it
	// when moving an campaign.
	//if ($campaignid != "" && isset($row["parent"]))
	//	$clientid = $row["parent"];
	
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
	// New campaign
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_clients']."
		WHERE
			clientid = '".$clientid."'
	");
	
	if ($client = phpAds_dbFetchArray($res))
		$row["clientname"] = $client['clientname'].' - ';
	else
		$row["clientname"] = '';
	
	
	$row["clientname"] .= $strDefault;
	$row["views"] 		= '';
	$row["clicks"] 		= '';
	$row["active"] 		= '';
	
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

if ($row['active'] == 't' && $row['expire'] != '0000-00-00' && $row['views'] > 0)
	$autotarget = true;
else
	$autotarget = false;


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
		echo "<input type='radio' name='".$name."Set' value='f' onclick=\"phpAds_formDateClick('".$name."', false);\"".($set==false?' checked':'').">";
		echo "&nbsp;$caption";
		echo "</td></tr><tr><td>";
		echo "<input type='radio' name='".$name."Set' value='t' onclick=\"phpAds_formDateClick('".$name."', true);\"".($set==true?' checked':'').">";
		echo "&nbsp;";
		
		echo "<select name='".$name."Day' onchange=\"phpAds_formDateCheck('".$name."');\">\n";
		echo "<option value='-'".($day=='-' ? ' selected' : '').">-</option>\n";
		for ($i=1;$i<=31;$i++)
			echo "<option value='$i'".($day==$i ? ' selected' : '').">$i</option>\n";
		echo "</select>&nbsp;\n";
		
		echo "<select name='".$name."Month' onchange=\"phpAds_formDateCheck('".$name."');\">\n";
		echo "<option value='-'".($month=='-' ? ' selected' : '').">-</option>\n";
		for ($i=1;$i<=12;$i++)
			echo "<option value='$i'".($month==$i ? ' selected' : '').">".$strMonth[$i-1]."</option>\n";
		echo "</select>&nbsp;\n";
		
		if ($year != '-')
			$start = $year < date('Y') ? $year : date('Y');
		else
			$start = date('Y');
		
		echo "<select name='".$name."Year' onchange=\"phpAds_formDateCheck('".$name."');\">\n";
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



echo "<br><br>";

echo "<form name='clientform' method='post' action='campaign-edit.php' onSubmit='return phpAds_formCheck(this);'>";
echo "<input type='hidden' name='campaignid' value='".(isset($campaignid) ? $campaignid : '')."'>";
echo "<input type='hidden' name='clientid' value='".(isset($clientid) ? $clientid : '')."'>";
echo "<input type='hidden' name='expire' value='".(isset($row["expire"]) ? $row["expire"] : '')."'>";
echo "<input type='hidden' name='move' value='".(isset($move) ? $move : '')."'>";

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strBasicInformation."</b></td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strName."</td><td>";
echo "<input onBlur='phpAds_formUpdate(this);' class='flat' type='text' name='clientname' size='35' style='width:350px;' value='".phpAds_htmlQuotes($row["clientname"])."'></td>";
echo "</tr><tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";



echo "<br><br>";
echo "<br><br>";



echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strContractInformation."</b></td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

if (isset($row['active']) && $row['active'] == 'f') 
{
	echo "<tr><td width='30' valign='top'><img src='images/info.gif'></td>";
	echo "<td width='200' colspan='2'>".$strClientDeactivated;
	
	$expire_ts = mktime(0, 0, 0, $row["expire_month"], $row["expire_dayofmonth"], $row["expire_year"]);
	
	if ($row['clicks'] == 0) echo ", $strNoMoreClicks";
	if ($row['views'] == 0) echo ", $strNoMoreViews";
	if (time() < mktime(0, 0, 0, $row["activate_month"], $row["activate_dayofmonth"], $row["activate_year"])) echo ", $strBeforeActivate";
	if (time() > $expire_ts && $expire_ts > 0) echo ", $strAfterExpire";
	
	echo ".<br><br>";
	echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
}


echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strViewsPurchased."</td><td>";
echo "<input class='flat' type='text' name='views' size='25' value='".($row["views"] > 0 ? $row["views"] : '-')."' onBlur='phpAds_formUpdate(this);' onKeyUp=\"phpAds_formUnlimitedCheck('unlimitedviews', 'views');\">&nbsp;";
echo "<input type='checkbox' name='unlimitedviews'".($row["views"] == -1 ? " CHECKED" : '')." onClick=\"phpAds_formUnlimitedClick('unlimitedviews', 'views');\">&nbsp;";
echo $strUnlimited;
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strClicksPurchased."</td><td>";
echo "<input class='flat' type='text' name='clicks' size='25' value='".($row["clicks"] > 0 ? $row["clicks"] : '-')."' onBlur='phpAds_formUpdate(this);' onKeyUp=\"phpAds_formUnlimitedCheck('unlimitedclicks', 'clicks');\">&nbsp;";
echo "<input type='checkbox' name='unlimitedclicks'".($row["clicks"] == -1 ? " CHECKED" : '')." onClick=\"phpAds_formUnlimitedClick('unlimitedclicks', 'clicks');\">&nbsp;";
echo $strUnlimited;
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";


echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strActivationDate."</td><td>";
phpAds_showDateEdit('activate', isset($row["activate_dayofmonth"]) ? $row["activate_dayofmonth"] : 0, 
						   	    isset($row["activate_month"]) ? $row["activate_month"] : 0, 
								isset($row["activate_year"]) ? $row["activate_year"] : 0);
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strExpirationDate."</td><td>";
phpAds_showDateEdit('expire', isset($row["expire_dayofmonth"]) ? $row["expire_dayofmonth"] : 0, 
							  isset($row["expire_month"]) ? $row["expire_month"] : 0, 
							  isset($row["expire_year"]) ? $row["expire_year"] : 0);
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";


echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>".$strPriority."</td><td><table>";

echo "<tr><td valign='top'>";
echo "<input type='radio' name='priority' value='-'".($autotarget ? ' checked' : '').">";
echo "</td><td valign='top'>".$strPriorityAutoTargeting."<br><br></td></tr>";

echo "<tr><td valign='top'>";
echo "<input type='radio' name='priority' value='t'".($priority != 'f' && !$autotarget ? ' checked' : '')." onClick='phpAds_formPriorityClick(this.form, true)'>";
echo "</td><td valign='top'>".$strHighPriority."<br><img src='images/break-l.gif' height='1' width='100%' vspace='6'><br>";
echo $strTargetLimitAdviews." ";
echo "<input onBlur='phpAds_formUpdate(this);' class='flat' type='text' name='targetviews' size='7' value='".(isset($row["target"]) ? $row["target"] : '-')."'> ";
echo $strTargetPerDay."<br><br></td></tr>";

echo "<tr><td valign='top'>";
echo "<input type='radio' name='priority' value='f'".($priority == 'f' && !$autotarget ? ' checked' : '')." onClick='phpAds_formPriorityClick(this.form, true)'>";
echo "</td><td valign='top'>".$strLowPriority."<br><img src='images/break-l.gif' height='1' width='100%' vspace='6'><br>";
echo $strCampaignWeight.": ";
echo "<input onBlur='phpAds_formUpdate(this);' class='flat' type='text' name='weight' size='7' value='".(isset($row["weight"]) ? $row["weight"] : $phpAds_config['default_campaign_weight'])."'>";

echo "<input type='hidden' name='previousweight' value='".(isset($row["weight"]) ? $row["weight"] : '')."'>";
echo "<input type='hidden' name='previousactive' value='".(isset($row["active"]) ? $row["active"] : '')."'>";
echo "</td></tr></table>";
echo "</td></tr>";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";


echo "<br><br>";
echo "<input type='submit' name='submit' value='".$strSaveChanges."'>";
echo "</form>";



/*********************************************************/
/* Form requirements                                     */
/*********************************************************/

// Get unique affiliate
$unique_names = array();

$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_clients']." WHERE parent = ".$clientid." AND clientid != '".$campaignid."'");
while ($row = phpAds_dbFetchArray($res))
	$unique_names[] = $row['clientname'];

?>

<script language='JavaScript'>
<!--
	phpAds_formSetRequirements('clientname', '<?php echo addslashes($strName); ?>', true, 'unique');
	phpAds_formSetRequirements('views', '<?php echo addslashes($strViewsPurchased); ?>', false, 'number+');
	phpAds_formSetRequirements('clicks', '<?php echo addslashes($strClicksPurchased); ?>', false, 'number+');
	phpAds_formSetRequirements('weight', '<?php echo addslashes($strCampaignWeight); ?>', false, 'number+');
	phpAds_formSetRequirements('targetviews', '<?php echo addslashes($strTargetLimitAdviews.' x '.$strTargetPerDay); ?>', false, 'number+');
	
	phpAds_formSetUnique('clientname', '|<?php echo addslashes(implode('|', $unique_names)); ?>|');


	
	var previous_target = '';
	var previous_weight = '';
	var previous_priority = '';

	function phpAds_formDateClick (o, value)
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
		
		if (o == 'expire')
			phpAds_formPriorityUpdate(document.clientform);
	}

	function phpAds_formDateCheck (o)
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

		if (o == 'expire')
			phpAds_formPriorityUpdate(document.clientform);
	}
	
	function phpAds_formUnlimitedClick (oc,oe)
	{
		e = findObj(oe);
		c = findObj(oc);
		
		if (c.checked == true) 
		{
			e.value = "-";
		} 
		else 
		{
			e.value = "";
			e.focus();
		}
		
		// Update check
		phpAds_formUpdate(e);
		phpAds_formPriorityUpdate(e.form);
	}	
	
	function phpAds_formUnlimitedCheck (oc,oe)
	{
		e = findObj(oe);
		c = findObj(oc);
	
		c.checked = e.value != '-' ? false : true;
		phpAds_formPriorityUpdate(e.form);
	}
	
	function phpAds_formPriorityClick (f, s)
	{
		if (f.priority[1].checked)
		{
			if (f.weight.value != '-')
				previous_weight = f.weight.value;
			
			previous_priority = 1;
			
			f.weight.value = '-';
			
			f.weight.disabled 	   = true;
			f.targetviews.disabled = false;			
			
			phpAds_formUpdate(f.weight);
			
			if (f.targetviews.value == '-')
				f.targetviews.value = previous_target;
			
			if (s)
			{
				f.targetviews.select()	
				f.targetviews.focus();
			}
		}
		else
		{
			if (f.targetviews.value != '-')
				previous_target = f.targetviews.value;
			
			previous_priority = 2;

			f.targetviews.value = '-';
			
			f.targetviews.disabled = true;
			f.weight.disabled 	   = false;

			phpAds_formUpdate(f.targetviews);
			
			if (f.weight.value == '-')
				f.weight.value = previous_weight;
			
			if (s)
			{
				f.weight.select()	
				f.weight.focus();
			}
		}
	}

	function phpAds_formPriorityUpdate (f)
	{
		if (f.expireSet[0].checked == true ||
			isNaN(f.views.value) || f.views.value == '' ||
			f.unlimitedviews.checked == true)
		{
			// Autotarget == false
			if (previous_priority == 1 || f.priority[1].checked)
				f.priority[1].checked  = true;
			else
				f.priority[2].checked  = true;
			
			f.priority[0].disabled = true;
			f.priority[1].disabled = false;
			f.priority[2].disabled = false;
			
			phpAds_formPriorityClick (f, false);
		}
		else
		{
			// Autotarget == true
			if (f.weight.value != '-')
				previous_weight = f.weight.value;
			
			if (f.targetviews.value != '-')
				previous_target = f.targetviews.value;
			
			// Disable weight and targetviews
			f.targetviews.value    = '-';
			f.weight.value 		   = '-';
			
			f.targetviews.disabled = true;
			f.weight.disabled 	   = true;
			
			f.priority[0].disabled = false;
			f.priority[0].checked  = true;
			
			f.priority[1].disabled = true;
			f.priority[2].disabled = true;
		}
	}
	
	// Set default values for priority
	phpAds_formPriorityUpdate(document.clientform);
	
//-->
</script>

<?php



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
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
phpAds_checkAccess(phpAds_Admin+phpAds_Client);



/*********************************************************/
/* Client interface security                             */
/*********************************************************/

if (phpAds_isUser(phpAds_Client))
{
	if (!phpAds_isAllowed(phpAds_ModifyInfo))
	{
		phpAds_PageHeader("$phpAds_name");
		phpAds_ShowNav("2.3");
		php_die ($strAccessDenied, $strNotAdmin);
	}

	$clientID = $Session["clientID"];
}



/*********************************************************/
/* Process submitted form                                */
/*********************************************************/

if (isset($submit))
{ 
	if (phpAds_isUser(phpAds_Admin))
	{
		// If ID is not set, it should be a null-value for the auto_increment
		$message = $strClientModified;
		
		if (empty($clientID))
		{
			$clientID = "null";
			$message = $strClientAdded;
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
		
		if ($expireSet == 'true')
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
		
		
		if ($activateSet == 'true')
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
		
		
		$active = "true";
		
		if ($clicks == 0 || $views==0)
			$active = "false";
		
		if ($activateDay != '-' && $activateMonth != '-' && $activateYear != '-')
			if (time() < mktime(0, 0, 0, $activateMonth, $activateDay, $activateYear))
				$active = "false";
		
		if ($expireDay != '-' && $expireMonth != '-' && $expireYear != '-')
			if (time() > mktime(0, 0, 0, $expireMonth, $expireDay, $expireYear))
				$active = "false";
		
		
		
		$permissions = 0;
		for ($i=0;$i<sizeof($clientpermissions);$i++)
		{
			$permissions += $clientpermissions[$i];
		}
		
		$query = "
			REPLACE INTO
				$phpAds_tbl_clients(clientID,
				clientname,
				contact,
				email,
				views,
				clicks,
				clientusername,
				clientpassword,
				expire,
				activate,
				active,
				weight,
				permissions,
				language)
			VALUES
				('$clientID',
				'$clientname',
				'$contact',
				'$email',
				'$views',
				'$clicks',
				'$clientusername',
				'$clientpassword',
				'$expire',
				'$activate',
				'$active',
				'$weight',
				$permissions,
				'$clientlanguage')";
		
		
		$res = db_query($query) or mysql_die();  
		
		Header("Location: admin.php?message=".urlencode($message));
		exit;
	}
	
	if (phpAds_isUser(phpAds_Client))
	{
		$message = $strClientModified;
		$res = db_query("
			UPDATE 
				$phpAds_tbl_clients
			SET
				clientname = '$clientname',
				contact = '$contact',
				email = '$email',
				clientpassword = '$clientpassword',
				language = '$clientlanguage'
			WHERE
				clientID = '$clientID'")
			or mysql_die();  
		
		$Session[language] = $clientlanguage;
		phpAds_SessionDataStore();
		
		Header("Location: index.php?message=".urlencode($message));
		exit;
	}
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if ($clientID != "")
{
	if (phpAds_isUser(phpAds_Admin))
	{
		phpAds_PageHeader("$strModifyClient");
		
		$extra = '';
		
		$res = db_query("
			SELECT
				*
			FROM
				$phpAds_tbl_clients  
			") or mysql_die();
		
		while ($row = mysql_fetch_array($res))
		{
			if ($clientID == $row['clientID'])
				$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
			else
				$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
			
			$extra .= "<a href=client-edit.php?clientID=". $row['clientID'].">".phpAds_buildClientName ($row['clientID'], $row['clientname'])."</a>";
			$extra .= "<br>"; 
		}
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		
		$extra .= "<br><br><br><br><br>";
		$extra .= "<b>$strShortcuts</b><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "<img src='images/caret-rs.gif'>&nbsp;<a href=banner-client.php?clientID=$clientID>$strBannerAdmin</a><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "<img src='images/caret-rs.gif'>&nbsp;<a href=stats-client.php?clientID=$clientID>$strStats</a><br>";
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/caret-rs.gif'>&nbsp;<a href=stats-weekly.php?clientID=$clientID>$strWeeklyStats</a><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		
		phpAds_ShowNav("1.2", $extra);
	}
	else
	{
		phpAds_PageHeader("$strPreferences");
		phpAds_ShowNav("2.3");
	}
	
	$res = db_query("
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
			$phpAds_tbl_clients
		WHERE
			clientID = $clientID
		") or mysql_die();
	$row = mysql_fetch_array($res);
	
	
	if ($row["timestamp"] < time())
	{
		if ($row["timestamp"] > 0)
		{
			$days_left = "0";
		}
		else
		{
			$days_left = -1;
		}
	}
	else
	{
		$days_left=$row["expire_day"] - $row["cur_date"];
	}
}
else
{
	phpAds_PageHeader("$strAddClient");
	phpAds_ShowNav("1.1");   
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if ($row["views"] == "")
	$row["views"] = -1;
if ($row["clicks"] == "")
	$row["clicks"] = -1;

if ($days_left == "")
	$days_left = -1;

function phpAds_showDateEdit($name, $day=0, $month=0, $year=0)
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
	
	echo "<table><tr><td>";
	echo "<input type='radio' name='".$name."Set' value='false' onclick=\"disableradio('".$name."', false);\"".($set==false?' checked':'').">";
	echo "&nbsp;$caption";
	echo "</td></tr><tr><td>";
	echo "<input type='radio' name='".$name."Set' value='true' onclick=\"disableradio('".$name."', true);\"".($set==true?' checked':'').">";
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




if (phpAds_isUser(phpAds_Admin))
{
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
	//-->
	</script>
	<?
}
?>





<form name="clientform" method="post" action="<?echo basename($PHP_SELF);?>" onSubmit="return valid(this)">
<input type="hidden" name="clientID" value="<?if(isset($clientID)) echo $clientID;?>">
<input type="hidden" name="expire" value="<?if(isset($row["expire"])) echo $row["expire"];?>">

<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='3'><b><?echo $strBasicInformation;?></b></td></tr>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>

	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $strClientName;?></td>
		<td><input type="text" name="clientname" size='35' style="width:350px;" value="<?if(isset($row["clientname"]))echo $row["clientname"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $strContact;?></td>
		<td><input type="text" name="contact" size='35' style="width:350px;" value="<?if(isset($row["contact"]))echo $row["contact"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $strEMail;?></td>
		<td><input type="text" name="email" size='35' style="width:350px;" value="<?if(isset($row["email"]))echo $row["email"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $GLOBALS['strLanguage']; ?></td>	
		<td>
			<select name="clientlanguage">
		<?
		echo "<option value='' SELECTED>".$GLOBALS['strDefault']."</option>\n"; 

		$langdir = opendir ("../language/");
		while ($langfile = readdir ($langdir))
		{
			if (ereg ("^([a-zA-Z0-9\-]*)\.inc\.php$", $langfile, $matches))
			{
				$option = $matches[1];
				if ($row['language'] == $option)
					echo "<option value='$option' SELECTED>".ucfirst($option)."</option>\n";
				else
					echo "<option value='$option'>".ucfirst($option)."</option>\n";
			}
		}
		closedir ($langdir);
		?>
			</select>
		</td>
	</tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>

	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
</table>

<br><br>
<br><br>
<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='3'><b><?echo $strContractInformation;?></b></td></tr>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>

	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
	<?
		if ($row['active'] == 'false') {
	?>
	<tr>
		<td width='30' valign='top'><img src='images/info.gif'></td>
		<td width='200' colspan='2'>
		<?
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
	<?
		}
	?>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $strViewsPurchased;?></td>
		<?
		if (phpAds_isUser(phpAds_Admin))
		{
			?>
			<td>
				<input type="text" name="views" size='25' value="<?if($row["views"]>0)echo $row["views"];else echo '-';?>" onKeyUp="disable_checkbox('unlimitedviews');">
				<input type="checkbox" name="unlimitedviews"<?if($row["views"]==-1)print " CHECKED";?> onClick="click_checkbox('unlimitedviews', 'views');">
				<? echo $GLOBALS['strUnlimited']; ?>
			</td>
			<?
		}
		else {
			?>
			<td><?if($row["views"]!=-1)echo $row["views"];else echo $GLOBALS['strUnlimited'];?></td>
			<?
		}
		?>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $strClicksPurchased;?></td>
		<?
		if (phpAds_isUser(phpAds_Admin))
		{
			?>
			<td>
				<input type="text" name="clicks" size='25' value="<?if($row["clicks"]>0)echo $row["clicks"];else echo '-';?>" onKeyUp="disable_checkbox('unlimitedclicks');">
				<input type="checkbox" name="unlimitedclicks"<?if($row["clicks"]==-1)print " CHECKED";?> onClick="click_checkbox('unlimitedclicks', 'clicks');">
				<? echo $GLOBALS['strUnlimited']; ?>
			</td>
			<?
		}
		else {
			?>
			<td><?if($row["clicks"]!=-1)echo $row["clicks"];else echo $GLOBALS['strUnlimited'];?></td>
			<?
		}
		?>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><? echo $strActivationDate; ?></td>
		<?
		if (phpAds_isUser(phpAds_Admin))
		{
			?>
			<td>
				<? phpAds_showDateEdit('activate', $row["activate_dayofmonth"], $row["activate_month"], $row["activate_year"]); ?>
			</td>
			<?
		}
		else 
		{
			?>
			<td><? echo $row["activate_f"]; ?></td>
			<?
		}
		?>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><? echo $strExpirationDate; ?></td>
		<?
		if (phpAds_isUser(phpAds_Admin))
		{
			?>
			<td>
				<? phpAds_showDateEdit('expire', $row["expire_dayofmonth"], $row["expire_month"], $row["expire_year"]); ?>
			</td>
			<?
		}
		else 
		{
			?>
			<td><? echo $row["expire_f"]; ?></td>
			<?
		}
		?>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $strWeight;?></td>
		<?
		if (phpAds_isUser(phpAds_Admin))
		{
			?>
			<td>
				<input type="text" name="weight" size='25' value="<?echo $row["weight"];?>">
			</td>
			<?
		}
		else {
			?>
			<td><?echo $row["weight"];?></td>
			<?
		}
		?>
	</tr>

	<tr><td height='10' colspan='3'>&nbsp;</td></tr>

	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
</table>

<br><br>
<br><br>

<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='3'><b><?echo $strLoginInformation;?></b></td></tr>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>

	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $strUsername;?></td>
		<?
		if (phpAds_isUser(phpAds_Admin))
		{
			?>
			<td><input type="text" name="clientusername" size='25' value="<?if(isset($row["clientusername"]))echo $row["clientusername"];?>">
			<?
		}
		else 
		{
			?>
			<td><?if(isset($row["clientusername"]))echo $row["clientusername"];?>
			<?
		}
		?>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $strPassword;?></td>
		<td><input type="text" name="clientpassword" size='25' value="<?if(isset($row["clientpassword"]))echo $row["clientpassword"];?>">
	</tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
		<?
		if (phpAds_isUser(phpAds_Admin))
		{
			?>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>

	<tr>
		<td width='30'>&nbsp;</td>
		<td colspan='2'>
			<input type="checkbox" name="clientpermissions[]" value="<?echo phpAds_ModifyInfo; ?>"<?echo (phpAds_ModifyInfo & $row["permissions"]) ? " CHECKED" : ""; ?>>
			<?echo $GLOBALS['strAllowClientModifyInfo']; ?>
		</td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td colspan='2'>
			<input type="checkbox" name="clientpermissions[]" value="<?echo phpAds_ModifyBanner; ?>"<?echo (phpAds_ModifyBanner & $row["permissions"]) ? " CHECKED" : ""; ?>>
			<?echo $GLOBALS['strAllowClientModifyBanner']; ?>
		</td>
	</tr>	
	<!-- Still working on this (Niels)
	<tr>
		<td width='30'>&nbsp;</td>
		<td colspan='2'>
			<input type="checkbox" name="clientpermissions[]" value="<?echo phpAds_AddBanner; ?>"<?echo (phpAds_AddBanner & $row["permissions"]) ? " CHECKED" : ""; ?>>
			<?echo $GLOBALS['strAllowClientAddBanner']; ?>
		</td>
	</tr>	
	-->
			<?
		}
		?>
	<tr><td height='10' colspan='2'>&nbsp;</td></tr>
</table>
		
<br><br>
		
<input type="submit" name="submit" value="<?echo $strSaveChanges;?>">
</form>



<?

/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>

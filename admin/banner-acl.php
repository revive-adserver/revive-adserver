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
require ("banner-acl.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* Process submitted form                                */
/*********************************************************/


// Convert weekday and time to usable string
if (isset($acl_data) && isset($acl_type) &&
	($acl_type == 'time' || $acl_type == 'weekday'))
{
	if (is_array($acl_data))
		$acl_data = implode (',', $acl_data);
}


if (isset($btndel_x))
{
	if (!isset($acl_order)) 
		phpAds_Die("hu?", "Where is my acl_order? I've lost my acl_orde! Moooommmeee... I want my acl_order back!");
	
	$res = phpAds_dbQuery("
      	DELETE FROM ".$phpAds_config['tbl_acls']." WHERE
        bannerid = $bannerid AND acl_order = $acl_order ") or phpAds_sqlDie();
	
	// get banner-acl after the deleted one
	$res = phpAds_dbQuery("
		SELECT * FROM ".$phpAds_config['tbl_acls']." WHERE
		bannerid = $bannerid AND acl_order > $acl_order") or phpAds_sqlDie();
    
	// decrement every following acl
	while ($row = phpAds_dbFetchArray($res)) 
	{
		$old_order = $row['acl_order'];
		$res1 = phpAds_dbQuery("
			UPDATE ".$phpAds_config['tbl_acls']." SET
			acl_order = acl_order - 1 WHERE
			acl_order = $old_order
            AND bannerid = $bannerid") or phpAds_sqlDie();
	}
	
	header ("Location: banner-acl.php?campaignid=$campaignid&bannerid=$bannerid");
	exit;
}

if (isset($btnsave_x))
{
	if ($update)
	{
		$res = phpAds_dbQuery("
			UPDATE ".$phpAds_config['tbl_acls']." SET
			acl_type = '$acl_type', acl_data = '$acl_data',
			acl_ad = '$acl_ad', acl_con = '$acl_con' 
			where bannerid = $bannerid 
			AND acl_order = $acl_order") or phpAds_sqlDie();
		
		header ("Location: banner-acl.php?campaignid=$campaignid&bannerid=$bannerid");
		exit;
	} 
	else
	{
		$res = phpAds_dbQuery("
			INSERT INTO ".$phpAds_config['tbl_acls']." SET
			acl_order = $acl_order, bannerid = $bannerid,
			acl_type = '$acl_type', acl_data = '$acl_data',
			acl_ad = '$acl_ad', acl_con = '$acl_con'") or phpAds_sqlDie();
		
		header ("Location: banner-acl.php?campaignid=$campaignid&bannerid=$bannerid");
		exit;
	}
}

if (isset($btnup_x))
{
	if ($acl_order < 1)
		 phpAds_Die("oops", $strNoMoveUp);
	
    // delete current acl
	$res = phpAds_dbQuery("
		DELETE FROM ".$phpAds_config['tbl_acls']." WHERE
		bannerid = $bannerid AND acl_order = $acl_order ") or phpAds_sqlDie();
	
	// increment previous acl
	$new_acl_order = $acl_order - 1;
	$res = phpAds_dbQuery("
		UPDATE ".$phpAds_config['tbl_acls']." SET
		acl_order = acl_order + 1 WHERE 
		acl_order = $new_acl_order 
		AND bannerid = $bannerid") or phpAds_sqlDie();
	
	// insert actual acl with decremented order
	$res = phpAds_dbQuery("
		INSERT INTO ".$phpAds_config['tbl_acls']." SET
		acl_order = $new_acl_order, bannerid = $bannerid,
		acl_type = '$acl_type', acl_data = '$acl_data',
		acl_ad = '$acl_ad', acl_con = '$acl_con'") or phpAds_sqlDie();
	
	header ("Location: banner-acl.php?campaignid=$campaignid&bannerid=$bannerid");
	exit;
}

if (isset($btndown_x))
{
	$res = phpAds_dbQuery("
		DELETE FROM ".$phpAds_config['tbl_acls']." WHERE
		bannerid = $bannerid AND acl_order = $acl_order ") or phpAds_sqlDie();
	
	$new_acl_order = $acl_order + 1;
	$res = phpAds_dbQuery("
		UPDATE ".$phpAds_config['tbl_acls']." SET
		acl_order = acl_order - 1 WHERE 
		acl_order = $new_acl_order
		AND bannerid = $bannerid") or phpAds_sqlDie();
	
	$res = phpAds_dbQuery("
		INSERT INTO ".$phpAds_config['tbl_acls']." SET
		acl_order = $new_acl_order, bannerid = $bannerid,
		acl_type = '$acl_type', acl_data = '$acl_data',
		acl_ad = '$acl_ad', acl_con = '$acl_con'") or phpAds_sqlDie();
	
	header ("Location: banner-acl.php?campaignid=$campaignid&bannerid=$bannerid");
	exit;
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (!isset($bannerid)) 
	phpAds_Die("This page can't be displayed",	"There was no bannerid suppied");

$extra = '';

$res = phpAds_dbQuery("
	SELECT
		*
	FROM
		".$phpAds_config['tbl_banners']."
	WHERE
		clientid = $campaignid
") or phpAds_sqlDie();

while ($row = phpAds_dbFetchArray($res))
{
	if ($bannerid == $row['bannerid'])
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
	else
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
	$extra .= "<a href='banner-acl.php?campaignid=$campaignid&bannerid=".$row['bannerid']."'>";
	$extra .= phpAds_buildBannerName ($row['bannerid'], $row['description'], $row['alt']);
	$extra .= "</a>";
	$extra .= "<br>"; 
}
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";

$extra .= "<form action='banner-modify.php'>";
$extra .= "<input type='hidden' name='bannerid' value='$bannerid'>";
$extra .= "<input type='hidden' name='campaignid' value='$campaignid'>";
$extra .= "<input type='hidden' name='returnurl' value='banner-acl.php'>";
$extra .= "<br><br>";
$extra .= "<b>$strModifyBanner</b><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-duplicate-banner.gif' align='absmiddle'>&nbsp;<a href='banner-modify.php?campaignid=$campaignid&bannerid=$bannerid&duplicate=true&returnurl=banner-acl.php'>$strDuplicate</a><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-move-banner.gif' align='absmiddle'>&nbsp;$strMoveTo<br>";
$extra .= "<img src='images/spacer.gif' height='1' width='160' vspace='2'><br>";
$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$extra .= "<select name='moveto' style='width: 110;'>";

$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_clients']." WHERE parent != 0 AND clientid != ".$campaignid."") or phpAds_sqlDie();
while ($row = phpAds_dbFetchArray($res))
	$extra .= "<option value='".$row['clientid']."'>".phpAds_buildClientName($row['clientid'], $row['clientname'])."</option>";

$extra .= "</select>&nbsp;<input type='image' name='moveto' src='images/go_blue.gif'><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-duplicate-acl.gif' align='absmiddle'>&nbsp;$strApplyLimitationsTo<br>";
$extra .= "<img src='images/spacer.gif' height='1' width='160' vspace='2'><br>";
$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$extra .= "<select name='applyto' style='width: 110;'>";

$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_banners']." WHERE bannerid != ".$bannerid." AND clientid = ".$campaignid."") or phpAds_sqlDie();
while ($row = phpAds_dbFetchArray($res))
	$extra .= "<option value='".$row['bannerid']."'>".phpAds_buildBannerName ($row['bannerid'], $row['description'], $row['alt'])."</option>";

$extra .= "</select>&nbsp;<input type='image' name='applyto' src='images/go_blue.gif'><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-recycle.gif' align='absmiddle'>&nbsp;<a href='banner-delete.php?campaignid=$campaignid&bannerid=$bannerid'".phpAds_DelConfirm($strConfirmDeleteBanner).">$strDelete</a><br>";
$extra .= "</form>";


$extra .= "<br><br><br>";
$extra .= "<b>$strShortcuts</b><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<a href=client-edit.php?clientid=".phpAds_getParentID ($campaignid).">$strClientProperties</a><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<a href=campaign-edit.php?campaignid=$campaignid>$strCampaignProperties</a><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-statistics.gif' align='absmiddle'>&nbsp;<a href=stats-campaign.php?campaignid=$campaignid>$strStats</a><br>";
$extra .= "<img src='images/break-el.gif' height='1' width='160' vspace='4'><br>";
$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/icon-weekly.gif' align='absmiddle'>&nbsp;<a href=stats-weekly.php?campaignid=$campaignid>$strWeeklyStats</a><br>";
$extra .= "<img src='images/break-el.gif' height='1' width='160' vspace='4'><br>";
$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/icon-zoom.gif' align='absmiddle'>&nbsp;<a href=stats-details.php?campaignid=$campaignid&bannerid=$bannerid>$strDetailStats</a><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";

phpAds_PageHeader("4.1.5.3", $extra);
	echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
	echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
	echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignid);
	echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
	echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerid)."</b><br><br>";
	echo phpAds_getBannerCode($bannerid)."<br><br><br><br>";
	phpAds_ShowSections(array("4.1.5.2", "4.1.5.3", "4.1.5.4"));




/*********************************************************/
/* Main code                                             */
/*********************************************************/

echo "<br><br>";


// Fetch all ACLs from the database
$res = phpAds_dbQuery("
	SELECT
		*
	FROM
		".$phpAds_config['tbl_acls']."
	WHERE
		bannerid = $bannerid ORDER BY acl_order
	") or phpAds_sqlDie();

$count = phpAds_dbNumRows ($res);



// Show header
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='4'><b>".$strOnlyDisplayWhen."</b></td></tr>";
echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

// Display all ACLs
if ($count > 0)
{
	$i = 0;
	$previous_type = '';
	
	// Get next ACL
	while ($row = phpAds_dbFetchArray ($res))
	{
		if ($row['acl_con'] == 'or')
		{
			echo "<tr><td colspan='4'><img src='images/break.gif' width='100%' height='1'></td></tr>";
			$i++;
		}
		else
			if ($previous_type != '') echo "<tr><td colspan='4'><img src='images/break-el.gif' width='100%' height='1'></td></tr>";
		
		// Show Row
		phpAds_ShowRow ($row, $count, 1, $i);
		
		$previous_type = $row['acl_type'];
	}
	
	// Show Footer
	if ($row['acl_type'] != $previous_type && $previous_type != '')
	{
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	}
}
else
{
	echo "<tr><td height='24' colspan='4' bgcolor='#F6F6F6'>&nbsp;&nbsp;$strNoLimitations</td></tr>";
	echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

echo "<form action='".basename($PHP_SELF)."' method='get'>";
echo "<input type='hidden' name='campaignid' value='".(isset($campaignid) ? $campaignid : '')."'>";
echo "<input type='hidden' name='bannerid' value='".(isset($bannerid) ? $bannerid : '')."'>";
echo "<input type='hidden' name='update' value='".(isset($update) ? $update : '')."'>";
echo "<input type='hidden' name='acl_order' value='".(isset($count) ? $count : '')."'>";
echo "<input type='hidden' name='acl_con' value='and'>";
echo "<input type='hidden' name='acl_type' value='allow'>";
echo "<input type='hidden' name='acl_data' value=''>";
echo "<input type='hidden' name='acl_ad' value=''>&nbsp;";

echo "<tr height='30'><td colspan='4' align='right'>";
	echo $strACLAdd;
	echo "&nbsp;&nbsp;";
	phpAds_ACLTypeSelect ('clientip');
	echo "&nbsp;&nbsp;";
	echo "<input type='image' name='btnsave' src='images/go_blue.gif' border='0' align='absmiddle' alt='$strSave'>";
echo "</td></tr>";

echo "</form>";
echo "</table>";
echo "<br><br>";


// Show Acl help file
//include("../language/banneracl.".$phpAds_config['language']."/banneracl.lang.php");



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>

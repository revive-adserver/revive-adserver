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
      			DELETE FROM $phpAds_tbl_acls WHERE
        		bannerID = $bannerID AND acl_order = $acl_order ") or
		phpAds_sqlDie();
	
	// get banner-acl after the deleted one
	$res = phpAds_dbQuery("
		SELECT * FROM $phpAds_tbl_acls WHERE
		bannerID = $bannerID AND acl_order > $acl_order") or
		phpAds_sqlDie();
    
	// decrement every following acl
	while ($row = phpAds_dbFetchArray($res)) 
	{
		$old_order = $row['acl_order'];
		$res1 = phpAds_dbQuery("
			UPDATE $phpAds_tbl_acls SET
			acl_order = acl_order - 1 WHERE
			acl_order = $old_order
               AND bannerID = $bannerID
               ") or phpAds_sqlDie();
	}
	
	header ("Location: banner-acl.php?campaignID=$campaignID&bannerID=$bannerID");
	exit;
}

if (isset($btnsave_x))
{
	if ($update)
	{
		$res = phpAds_dbQuery("
			UPDATE $phpAds_tbl_acls SET
			acl_type = '$acl_type', acl_data = '$acl_data',
			acl_ad = '$acl_ad', acl_con = '$acl_con' 
			where bannerID = $bannerID 
			AND acl_order = $acl_order") or phpAds_sqlDie();
		
		header ("Location: banner-acl.php?campaignID=$campaignID&bannerID=$bannerID");
		exit;
	} 
	else
	{
		$res = phpAds_dbQuery("
			INSERT into $phpAds_tbl_acls SET
			acl_order = $acl_order, bannerID = $bannerID,
			acl_type = '$acl_type', acl_data = '$acl_data',
			acl_ad = '$acl_ad', acl_con = '$acl_con'") or phpAds_sqlDie();
		header ("Location: banner-acl.php?campaignID=$campaignID&bannerID=$bannerID");
		exit;
	}
}

if (isset($btnup_x))
{
	if ($acl_order < 1)
		 phpAds_Die("oops", $strNoMoveUp);
	
       // delete current acl
	$res = phpAds_dbQuery("
		DELETE FROM $phpAds_tbl_acls WHERE
		bannerID = $bannerID AND acl_order = $acl_order ") or
		phpAds_sqlDie();		
	
	// increment previous acl
	$new_acl_order = $acl_order - 1;
	$res = phpAds_dbQuery("
		UPDATE $phpAds_tbl_acls SET
		acl_order = acl_order + 1 WHERE 
		acl_order = $new_acl_order 
		AND bannerID = $bannerID
		") or phpAds_sqlDie();	 
	
	// insert actual acl with decremented order
	$res = phpAds_dbQuery("
		INSERT into $phpAds_tbl_acls SET
		acl_order = $new_acl_order, bannerID = $bannerID,
		acl_type = '$acl_type', acl_data = '$acl_data',
		acl_ad = '$acl_ad', acl_con = '$acl_con'") or phpAds_sqlDie();
	
	header ("Location: banner-acl.php?campaignID=$campaignID&bannerID=$bannerID");
	exit;
}

if (isset($btndown_x))
{
	$res = phpAds_dbQuery("
		DELETE FROM $phpAds_tbl_acls WHERE
		bannerID = $bannerID AND acl_order = $acl_order ") or
	phpAds_sqlDie();
	
	$new_acl_order = $acl_order + 1;
	$res = phpAds_dbQuery("
		UPDATE $phpAds_tbl_acls SET
		acl_order = acl_order - 1 WHERE 
		acl_order = $new_acl_order
		AND bannerID = $bannerID
		") or phpAds_sqlDie();
	
	$res = phpAds_dbQuery("
		INSERT into $phpAds_tbl_acls SET
		acl_order = $new_acl_order, bannerID = $bannerID,
		acl_type = '$acl_type', acl_data = '$acl_data',
		acl_ad = '$acl_ad', acl_con = '$acl_con'") or phpAds_sqlDie();
	
	header ("Location: banner-acl.php?campaignID=$campaignID&bannerID=$bannerID");
	exit;
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (!isset($bannerID)) 
	phpAds_Die("This page can't be displayed",	"There was no bannerID suppied");

$extra = '';

$res = phpAds_dbQuery("
	SELECT
		*
	FROM
		$phpAds_tbl_banners
	WHERE
		clientID = $campaignID
") or phpAds_sqlDie();

while ($row = phpAds_dbFetchArray($res))
{
	if ($bannerID == $row['bannerID'])
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
	else
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
	$extra .= "<a href='banner-acl.php?campaignID=$campaignID&bannerID=".$row['bannerID']."'>";
	$extra .= phpAds_buildBannerName ($row['bannerID'], $row['description'], $row['alt']);
	$extra .= "</a>";
	$extra .= "<br>"; 
}
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";

$extra .= "<br><br><br><br><br>";
$extra .= "<b>$strShortcuts</b><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<a href=client-edit.php?clientID=".phpAds_getParentID ($campaignID).">$strModifyClient</a><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-edit.gif' align='absmiddle'>&nbsp;<a href=campaign-edit.php?campaignID=$campaignID>$strModifyCampaign</a><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-statistics.gif' align='absmiddle'>&nbsp;<a href=stats-campaign.php?campaignID=$campaignID>$strStats</a><br>";
$extra .= "<img src='images/break-el.gif' height='1' width='160' vspace='4'><br>";
$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/icon-weekly.gif' align='absmiddle'>&nbsp;<a href=stats-weekly.php?campaignID=$campaignID>$strWeeklyStats</a><br>";
$extra .= "<img src='images/break-el.gif' height='1' width='160' vspace='4'><br>";
$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/icon-zoom.gif' align='absmiddle'>&nbsp;<a href=stats-details.php?campaignID=$campaignID&bannerID=$bannerID>$strDetailStats</a><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";

phpAds_PageHeader("4.1.5.3", $extra);
phpAds_ShowSections(array("4.1.5.2", "4.1.5.3", "4.1.5.4"));




/*********************************************************/
/* Main code                                             */
/*********************************************************/


echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
echo "<tr><td height='25'><img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignID);
echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignID);
echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
if ($bannerID != '')
	echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerID)."</b></td></tr>";
else
	echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;".$strUntitled."</td></tr>";

if ($bannerID != '')
{
	echo "<tr><td height='1' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td align='left'><br>".phpAds_getBannerCode($bannerID)."</td></tr>";
}

echo "</table>";

echo "<br><br>";
echo "<br><br>";
echo "<br><br>";


// Fetch all ACLs from the database
$res = phpAds_dbQuery("
	SELECT
		*
	FROM
		$phpAds_tbl_acls
	WHERE
		bannerID = $bannerID ORDER by acl_order
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
echo "<input type='hidden' name='campaignID' value='".$campaignID."'>";
echo "<input type='hidden' name='bannerID' value='".$bannerID."'>";
echo "<input type='hidden' name='update' value='".$update."'>";
echo "<input type='hidden' name='acl_order' value='".$count."'>";
echo "<input type='hidden' name='acl_con' value='and'>&nbsp;";
echo "<input type='hidden' name='acl_type' value='allow'>&nbsp;";

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
//include("../language/banneracl.".$phpAds_language.".inc.php");



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>

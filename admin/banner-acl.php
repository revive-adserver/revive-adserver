<?

require ("config.php");
require ("lib-statistics.inc.php");
require ("banner-acl.inc.php");



phpAds_checkAccess(phpAds_Admin);

phpAds_PageHeader("$strModifyBannerAcl");


// If the form is being submitted, add a new record to banners
if (isset($submit)) 
{
	if ($submit == $strDelete) 
	{
		if (!isset($acl_order)) 
			php_die("hu?", "Where is my acl_order? I've lost my acl_orde! Moooommmeee... I want my acl_order back!");
		$res = db_query("
       			DELETE FROM $phpAds_tbl_acls WHERE
         		bannerID = $bannerID AND acl_order = $acl_order ") or
			mysql_die();
		
		// get banner-acl after the deleted one
		$res = db_query("
			SELECT * FROM $phpAds_tbl_acls WHERE
			bannerID = $bannerID AND acl_order > $acl_order") or
			mysql_die();
	    
		// decrement every following acl
		while ($row = mysql_fetch_array($res)) 
		{
			$old_order = $row['acl_order'];
			$res1 = db_query("
				UPDATE $phpAds_tbl_acls SET
				acl_order = acl_order - 1 WHERE
				acl_order = $old_order
                AND bannerID = $bannerID
                ") or mysql_die();
		}
		
		phpAds_ShowMessage("$strACL $strDeleted");
	}
	
	if ($submit == $strSave)
	{
		if ($update)
		{
			$res = db_query("
				UPDATE $phpAds_tbl_acls SET
				acl_type = '$acl_type', acl_data = '$acl_data',
				acl_ad = '$acl_ad' where bannerID = $bannerID 
				AND acl_order = $acl_order") or mysql_die();
			
			phpAds_ShowMessage("$strACL $strUpdated");
		} 
		else
		{
			$res = db_query("
				INSERT into $phpAds_tbl_acls SET
				acl_order = $acl_order, bannerID = $bannerID,
				acl_type = '$acl_type', acl_data = '$acl_data',
				acl_ad = '$acl_ad'") or mysql_die();
			phpAds_ShowMessage("$strACL $strSaved");
		}
	}
	
	if ($submit == $strUp)
	{
		if ($acl_order < 1)
			 php_die("oops", $strNoMoveUp);
		
        // delete current acl
		$res = db_query("
			DELETE FROM $phpAds_tbl_acls WHERE
			bannerID = $bannerID AND acl_order = $acl_order ") or
			mysql_die();		
		
		// increment previous acl
		$new_acl_order = $acl_order - 1;
		$res = db_query("
			UPDATE $phpAds_tbl_acls SET
			acl_order = acl_order + 1 WHERE 
			acl_order = $new_acl_order 
			AND bannerID = $bannerID
			") or mysql_die();	 
		
		// insert actual acl with decremented order
		$res = db_query("
			INSERT into $phpAds_tbl_acls SET
			acl_order = $new_acl_order, bannerID = $bannerID,
			acl_type = '$acl_type', acl_data = '$acl_data',
			acl_ad = '$acl_ad'") or mysql_die();
		
		phpAds_ShowMessage("$strACL $strMovedUp");
	}
	
	if ($submit == $strDown) 
	{
		$res = db_query("
			DELETE FROM $phpAds_tbl_acls WHERE
			bannerID = $bannerID AND acl_order = $acl_order ") or
		mysql_die();
		
		$new_acl_order = $acl_order + 1;
		$res = db_query("
			UPDATE $phpAds_tbl_acls SET
			acl_order = acl_order - 1 WHERE 
			acl_order = $new_acl_order
			AND bannerID = $bannerID
			") or mysql_die();
		
		$res = db_query("
			INSERT into $phpAds_tbl_acls SET
			acl_order = $new_acl_order, bannerID = $bannerID,
			acl_type = '$acl_type', acl_data = '$acl_data',
			acl_ad = '$acl_ad'") or mysql_die();
		
		phpAds_ShowMessage("$strACL $strMovedDown");
	}
}



// If we find an ID, means that we're in update mode  
if (!isset($bannerID)) 
{
	php_die("hu?",
	"Where is my ID? I've lost my ID! Moooommmeee... I want my ID back!");
}


	$res = db_query("
	SELECT
		*
	FROM
		$phpAds_tbl_banners
	WHERE
		clientID = $GLOBALS[clientID]
	") or mysql_die();
	
	while ($row = mysql_fetch_array($res))
	{
		if ($bannerID == $row[bannerID])
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
		else
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
		
		$extra .= "<a href='banner-acl.php?clientID=$clientID&bannerID=$row[bannerID]'>";
		$extra .= phpAds_buildBannerName ($row[bannerID], $row[description], $row[alt]);
		$extra .= "</a>";
		$extra .= "<br>"; 
	}
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";

	$extra .= "<br><br><br><br><br>";
	$extra .= "<b>$strShortcuts</b><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/caret-rs.gif'>&nbsp;<a href=client-edit.php?clientID=$clientID>$strModifyClient</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/caret-rs.gif'>&nbsp;<a href=stats-client.php?clientID=$clientID>$strStats</a><br>";
	$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/caret-rs.gif'>&nbsp;<a href=stats-details.php?clientID=$clientID&bannerID=$bannerID>$strDetailStats</a><br>";
	$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/caret-rs.gif'>&nbsp;<a href=stats-weekly.php?clientID=$clientID>$strWeeklyStats</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";

	phpAds_ShowNav("1.3.3", $extra);
?>






<table width='100%' border="0" align="center" cellspacing="0" cellpadding="0">
  <tr><td height='25' colspan='4'>
  	<b><?echo $strBanner.': '.phpAds_getBannerName($bannerID);?></b>
	<img src='images/caret-rs.gif'>
	<?echo $strClientName.': '.phpAds_getClientName($clientID);?>
  </td></tr>
  <tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
  <tr><td colspan='4' align='left'><br><?echo phpAds_getBannerCode($bannerID);?><br><br></td></tr>
</table>

<br><br>

<?

$res = db_query("
	SELECT
		*
	FROM
		$phpAds_tbl_acls
	WHERE
		bannerID = $bannerID ORDER by acl_order
	") or mysql_die();

$count = mysql_num_rows($res);
if ($count > 0)
{
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
	echo "<tr><td height='25' colspan='7'><b>$strACLExist</b></td></tr>";
	echo "<tr height='1'><td colspan='7' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	$i = 0;
	while ($row = mysql_fetch_array($res))	// acl array already sorted by select
	{
		showaclrow($row, $count, 1, $i);
		$i++;
	}
	
	echo "</table>";
	echo "<br><br>";
}

?>


<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='7'><b><? echo $strACLAdd; ?></b></td></tr>
	<tr height='1'><td colspan='7' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<?
	$newdata['acl_order'] = $count;
	$newdata['bannerID'] = $bannerID;
	showaclrow($newdata, 0, 0, 0);
?>
</table>

<br><br>


<?	
// show acl help file
include("../language/banneracl.".$phpAds_language.".inc.php");

phpAds_PageFooter();
?>

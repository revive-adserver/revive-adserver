<?

require ("config.php");
require("kcsm.php");
require("banneracl.inc.php");


kc_auth_admin();
page_header("$phpAds_name: $strBannerAdminAcl");

if (!empty($bannerID)) 
{
	$Session["bannerID"] = "$bannerID";
}

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
		show_message("$strACL $strDeleted");
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
			show_message("$strACL $strUpdated");
		} 
		else 
		{
			$res = db_query("
				INSERT into $phpAds_tbl_acls SET
				acl_order = $acl_order, bannerID = $bannerID,
				acl_type = '$acl_type', acl_data = '$acl_data',
				acl_ad = '$acl_ad'") or mysql_die();
			show_message("$strACL $strSaved");
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
		show_message("$strACL $strMovedUp");
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
		show_message("$strACL $strMovedDown");
	}
}
// If we find an ID, means that we're in update mode  
if (!isset($bannerID)) 
{
	php_die("hu?",
	"Where is my ID? I've lost my ID! Moooommmeee... I want my ID back!");
}

show_nav("1.3.3");
$res = db_query("
	SELECT
		*
	FROM
		$phpAds_tbl_acls
	WHERE
		bannerID = $bannerID ORDER by acl_order
	") or mysql_die();
?>
<TABLE>
<?
$count = mysql_num_rows($res);
if ($count > 0)
{
	?>
	<TR>
		<TD COLSPAN="7"><BR><? echo $strACLExist; ?></TD>
	</TR>
	<?
	while ($row = mysql_fetch_array($res))	// acl array already sorted by select
	{
		showaclrow($row, $count, 1);
	}
}
?>
<TR>
	<TD COLSPAN="7"><HR SIZE="1"><? echo $strACLAdd; ?></TD>
</TR>
<?
$newdata['acl_order'] = $count;
$newdata['bannerID'] = $bannerID;
showaclrow($newdata, 0, 0);
?>
</TABLE>
<?	
// show acl help file
include("language/banneracl.".$phpAds_language.".inc.php");
page_footer();
?>

<?

require ("config.php");
require("kcsm.php");
require("banneracl.inc.php");


kc_auth_admin();
page_header("$strBannerAdminAcl");

if (!empty($bannerID))
{
	$Session["bannerID"] = "$bannerID";
}

// If the form is being submitted, add a new record to banners
if (isset($submit))
{
	if ($submit == "Delete")
	{
		if (!isset($acl_order))
		{
			php_die("hu?", "Where is my acl_order? I've lost my acl_order! Moooommmeee... I want my acl_order back!");
		}
		$res = mysql_db_query($phpAds_db, "
       			DELETE FROM $phpAds_tbl_acls WHERE
         		bannerID = $bannerID AND acl_order = $acl_order ") or
			mysql_die();
		$res = mysql_db_query($phpAds_db, "
			SELECT * FROM $phpAds_tbl_acls WHERE
			bannerID = $bannerID AND acl_order > $acl_order") or
			mysql_die();
		while ($row = mysql_fetch_array($res))
		{
			$old_order = $row['acl_order'];
			$res1 = mysql_db_query($phpAds_db, "
				UPDATE $phpAds_tbl_acls SET
				acl_order = acl_order - 1 WHERE
				acl_order = $old_order
				AND bannerID = $bannerID
				") or mysql_die();
		}
		show_message("ACL was deleted");
	}
	if ($submit == 'Save')
	{
		if ($update)
		{
			$res = mysql_db_query($phpAds_db, "
				UPDATE $phpAds_tbl_acls SET
				acl_type = '$acl_type', acl_data = '$acl_data',
				acl_ad = '$acl_ad' where bannerID = $bannerID 
				AND acl_order = $acl_order") or mysql_die();
			show_message("ACL was updated");
		}
		else
		{
			$res = mysql_db_query($phpAds_db, "
				INSERT into $phpAds_tbl_acls SET
				acl_order = $acl_order, bannerID = $bannerID,
				acl_type = '$acl_type', acl_data = '$acl_data',
				acl_ad = '$acl_ad'") or mysql_die();
			show_message("ACL was saved");

		}
	}
	if ($submit == 'UP')
	{
		if ($acl_order < 1) 
			 php_die("oops",
				"Can't move up first row");
                $res = mysql_db_query($phpAds_db, "
                        DELETE FROM $phpAds_tbl_acls WHERE
                        bannerID = $bannerID AND acl_order = $acl_order ") or
                        mysql_die();
		$new_acl_order = $acl_order - 1;
		$res = mysql_db_query($phpAds_db, "
			UPDATE $phpAds_tbl_acls SET
			acl_order = acl_order + 1 WHERE 
			acl_order = $new_acl_order
			AND bannerID = $bannerID
			") or mysql_die();
                $res = mysql_db_query($phpAds_db, "
                        INSERT into $phpAds_tbl_acls SET
                        acl_order = $new_acl_order, bannerID = $bannerID,
                        acl_type = '$acl_type', acl_data = '$acl_data',
                        acl_ad = '$acl_ad'") or mysql_die();
		show_message("ACL was moved UP");
	}
	if ($submit == 'DOWN')
	{
                $res = mysql_db_query($phpAds_db, "
                        DELETE FROM $phpAds_tbl_acls WHERE
                        bannerID = $bannerID AND acl_order = $acl_order ") or
                        mysql_die();
		$new_acl_order = $acl_order + 1;
		$res = mysql_db_query($phpAds_db, "
			UPDATE $phpAds_tbl_acls SET
			acl_order = acl_order - 1 WHERE 
			acl_order = $new_acl_order
			AND bannerID = $bannerID
			") or mysql_die();
                $res = mysql_db_query($phpAds_db, "
                        INSERT into $phpAds_tbl_acls SET
                        acl_order = $new_acl_order, bannerID = $bannerID,
                        acl_type = '$acl_type', acl_data = '$acl_data',
                        acl_ad = '$acl_ad'") or mysql_die();
		show_message("ACL was moved UP");
	}
}
// If we find an ID, means that we're in update mode  
if (isset($bannerID))
{
	show_nav("1.3.3");
	$res = mysql_db_query($phpAds_db, "
          SELECT
            *
          FROM
            $phpAds_tbl_acls
          WHERE
            bannerID = $bannerID ORDER by acl_order
          ") or mysql_die();
}
else
{
	php_die("hu?",
	"Where is my ID? I've lost my ID! Moooommmeee... I want my ID back!");
}
?>
<TABLE>
<?
$data = array();
while ($row = mysql_fetch_array($res))
{
	$data[$row['acl_order'].'a'] =  $row; // Trick for sorting
}
ksort($data);
$count = count($data);
$i = 0;
for (reset($data); $key = key($data); next($data))
{
	showaclrow($data[$key], $count, 1);
	$i++;
}
$newdata['acl_order'] = $i;
$newdata['bannerID'] = $bannerID;
showaclrow($newdata, 0, 0);
?>
</TABLE>
<?
page_footer();
?>

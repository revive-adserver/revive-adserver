<?

require ("config.php");
require("kcsm.php");

kc_auth_admin();
if (!empty($clientID))
   {
   $Session["clientID"] = "$clientID";
   }
else
   {
   unset($Session["clientID"]);
   }
// If submit is set, shove the data into the database (well, after some error checking)
if (isset($submit))
   {
   // Do error checking
   
   // If ID is not set, it should be a null-value for the auto_increment
   $message = $strClientModified;
   if (empty($Session["clientID"]))
      {
      $Session["clientID"] = "null";
      $message = $strClientAdded;
      }

   if (strtolower($unlimitedviews)=="on")
       $views=-1;
   if (strtolower($unlimitedclicks)=="on")
       $clicks=-1;
   if (strtolower($unlimiteddays_left)=="on")
       $expire = '0000-00-00';
   else
       $expire = "DATE_ADD(CURDATE(), INTERVAL $days_left DAY)";

   if($clicks>0 OR $views>0 OR $clicks==-1 OR $views==-1)
   {
       $active="true";
       mysql_db_query($phpAds_db, "UPDATE $phpAds_tbl_banners SET active='$active' WHERE clientID='$clientID'");
   }

   $clientID=$Session[clientID];
   $res = mysql_db_query($phpAds_db, "REPLACE INTO $phpAds_tbl_clients(clientID,
		clientname,
		contact,
		email,
		views,
		clicks,
		clientusername,
		clientpassword,
		expire) VALUES
		('$clientID',
		'$clientname',
		'$contact',
		'$email',
		'$views',
		'$clicks',
		'$clientusername',
		'$clientpassword',
		$expire)")
	or mysql_die();  
   Header("Location: admin.php$fncpageid&message=".urlencode($message));
   exit;
   }

page_header("$phpAds_name");

// If we find an ID, means that we're in update mode  
if (isset($clientID))
   {
   show_nav("1.2");
   $res = mysql_db_query($phpAds_db, "
          SELECT
           *,
           to_days(expire) as expire_day,
           to_days(curdate()) as cur_date
          FROM
            $phpAds_tbl_clients
          WHERE
            clientID = $clientID
          ") or mysql_die();
   $row = mysql_fetch_array($res);
   if ($row["expire"]=="0000-00-00")
       $days_left=-1;
   else
       $days_left=$row["expire_day"] - $row["cur_date"];
#   $days_left = if ($row["expire"]=="0000-00-00") isset($row["expire_day"]) ? $row["expire_day"] - $row["cur_date"] : "0";
   }
else
   {
   show_nav("1.1");   
   }

if (strlen($row["views"])==0)
	$row["views"]=-1;
if (strlen($row["clicks"])==0)
	$row["clicks"]=-1;
if (strlen($days_left)==0)
	$days_left=-1;

?>

<script language="JavaScript">
<!--
	function checkunlimitedviews()
	{
		if (eval(document.clientform.unlimitedviews.checked) == true)
		{
			document.clientform.views.value="Unlimited-->";
		} else
		{
			document.clientform.views.value="";
			document.clientform.views.focus();
		}
	}
	function checkunlimitedclicks()
	{
		if (eval(document.clientform.unlimitedclicks.checked) == true)
		{
			document.clientform.clicks.value="Unlimited-->";
		} else
		{
			document.clientform.clicks.value="";
			document.clientform.clicks.focus();
		}
	}
	function checkunlimiteddays_left()
	{
		if (eval(document.clientform.unlimiteddays_left.checked) == true)
		{
			document.clientform.days_left.value="Unlimited-->";
		} else
		{
			document.clientform.days_left.value="";
			document.clientform.days_left.focus();
		}
	}
//-->
</script>

<form name="clientform" method="post" action="<?echo basename($PHP_SELF);?>">
<input type="hidden" name="clientID" value="<?if(IsSet($clientID)) echo $clientID;?>">
<table>
 <tr>
  <td></td><td></td><td>Unlimited</td></tr>
 <tr>
  <td><?echo $strClientName;?>:</td>
  <td><input type="text" name="clientname" value="<?if(isset($row["clientname"]))echo $row["clientname"];?>"></td>
 <input type="hidden" name="pageid" value="<? if(isset($pageid))echo ($pageid) ?>">
 </tr>
 <tr>
  <td><?echo $strContact;?>:</td>
  <td><input type="text" name="contact" value="<?if(isset($row["contact"]))echo $row["contact"];?>"></td>
 </tr>
 <tr>
  <td><?echo $strEMail;?>:</td>
  <td><input type="text" name="email" value="<?if(isset($row["email"]))echo $row["email"];?>"></td>
 </tr>
 <tr>
  <td><?echo $strViewsPurchased;?>:</td>
  <td><input type="text" name="views" value="<?if($row["views"]!=-1)echo $row["views"];else echo "Unlimited-->";?>"></td>
  <td align=center><input type="checkbox" name="unlimitedviews"<?if($row["views"]==-1)print " CHECKED";?> onClick="checkunlimitedviews();"></td>
 </tr>
 <tr>
  <td><?echo $strClicksPurchased;?>:</td>
  <td><input type="text" name="clicks" value="<?if($row["clicks"]!=-1)echo $row["clicks"];else echo "Unlimited-->";?>"></td>
  <td align=center><input type="checkbox" name="unlimitedclicks"<?if($row["clicks"]==-1)print " CHECKED";?> onClick="checkunlimitedclicks();"></td>
 </tr>
 <tr>
  <td><?echo $strDaysPurchased;?>:</td>
  <td><input type="text" name="days_left" value="<?if($days_left!=-1)echo $days_left;else echo "Unlimited-->";?>"></td>
  <td align=center><input type="checkbox" name="unlimiteddays_left"<?if($days_left==-1)print " CHECKED";?> onClick="checkunlimiteddays_left();"></td>
 </tr>
 <tr>
  <td><?echo $strUsername;?>:</td>
  <td><input type="text" name="clientusername" value="<?if(isset($row["clientusername"]))echo $row["clientusername"];?>">
 </tr>
 <tr>
  <td><?echo $strPassword;?>:</td>
  <td><input type="text" name="clientpassword" value="<?if(isset($row["clientpassword"]))echo $row["clientpassword"];?>">
 </tr>
 <tr>
  <td></td>
  <td><input type="submit" name="submit" value="<?echo $strGo;?>"></td>
 </tr>
</table>
</form>

<?
 page_footer();
?>

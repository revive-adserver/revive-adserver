<?

require ("config.php");


phpAds_checkAccess(phpAds_Admin+phpAds_Client);


if (phpAds_isUser(phpAds_Client))
{
	if (!phpAds_isAllowed(phpAds_ModifyInfo))
	{
		page_header("$phpAds_name");
		show_nav("2.3");
		php_die ($strAccessDenied, $strNotAdmin);
	}

	$clientID = $Session["clientID"];
}


// If submit is set, shove the data into the database (well, after some error checking)
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
			db_query("UPDATE $phpAds_tbl_banners SET active='$active' WHERE clientID='$clientID'");
		}
		
		$permissions = 0;
		for ($i=0;$i<sizeof($clientpermissions);$i++)
		{
			$permissions += $clientpermissions[$i];
		}
		
		
		$res = db_query("
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
				$expire,
				$permissions,
				'$clientlanguage')")
			or mysql_die();  
		
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

page_header("$phpAds_name");

// If we find an ID, means that we're in update mode  
if ($clientID != "")
{
	if (phpAds_isUser(phpAds_Admin))
	{
		show_nav("1.2");
	}
	else
	{
		show_nav("2.3");
	}
	
	$res = db_query("
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
}
else
{
	show_nav("1.1");   
}

if (empty($row["views"]))
	$row["views"]=-1;
if (empty($row["clicks"]))
	$row["clicks"]=-1;
if (empty($days_left))
	$days_left=-1;

if (phpAds_isUser(phpAds_Admin))
{
	?>

	<script language="JavaScript">
	<!--
		function checkunlimitedviews()
		{
			if (eval(document.clientform.unlimitedviews.checked) == true)
			{
				document.clientform.views.value="<?print $GLOBALS['strUnlimited'];?>-->";
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
				document.clientform.clicks.value="<?print $GLOBALS['strUnlimited'];?>-->";
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
				document.clientform.days_left.value="<?print $GLOBALS['strUnlimited'];?>-->";
			} else
			{
				document.clientform.days_left.value="";
				document.clientform.days_left.focus();
			}
		}
		function valid(form)
		{
			var views=parseInt(form.views.value);
			if (!views)
			{
				if (eval(form.unlimitedviews.checked) == false)
				{
					alert("You must enter the number of views or select the unlimited box !");
					return false;
				}
			} else if (views < 0)
			{
				alert("Negative views are not allowed");
				return false;
			}
			var clicks=parseInt(form.clicks.value);
			if (!clicks)
			{
				if (eval(form.unlimitedclicks.checked) == false)
				{
					alert("You must enter the number of clicks or select the unlimited box !");
					return false;
				}
			} else if (clicks < 0)
			{
				alert("Negative clicks are not allowed");
				return false;
			}
			var days_left=parseInt(form.days_left.value);
			if (!days_left)
			{
				if (eval(form.unlimiteddays_left.checked) == false)
				{
					alert("You must enter the number of days or select the unlimited box !");
					return false;
				}
			} else if (days_left < 0)
			{
				alert("Negative days are not allowed");
				return false;
			}
		}
	//-->
	</script>
	<?
}
?>
<form name="clientform" method="post" action="<?echo basename($PHP_SELF);?>" onSubmit="return valid(this)">
<input type="hidden" name="clientID" value="<?if(IsSet($clientID)) echo $clientID;?>">
<table>
	<tr>
		<td></td><td></td><td>
		<?
		if (phpAds_isUser(phpAds_Admin))
		print $GLOBALS['strUnlimited'];
		?>
		</td>
	</tr>
	<tr>
		<td><?echo $strClientName;?>:</td>
		<td><input type="text" name="clientname" value="<?if(isset($row["clientname"]))echo $row["clientname"];?>"></td>
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
		<td><?echo $GLOBALS[strLanguage]; ?>:</td>	
		<td>
			<select name="clientlanguage">
		<?
		echo "<option value='' SELECTED>".$GLOBALS[strDefault]."</option>\n";

		$langdir = opendir ("./language/");
		while ($langfile = readdir ($langdir))
		{
			if (ereg ("^([a-zA-Z]*)\.inc\.php$", $langfile, $matches))
			{
				$option = $matches[1];
				if ($row["language"] == $option)
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
	<tr>
		<td><?echo $strViewsPurchased;?>:</td>
		<?
		if (phpAds_isUser(phpAds_Admin))
		{
			?>
			<td><input type="text" name="views" value="<?if($row["views"]!=-1)echo $row["views"];else echo $GLOBALS['strUnlimited'].'-->';?>"></td>
			<td align=center><input type="checkbox" name="unlimitedviews"<?if($row["views"]==-1)print " CHECKED";?> onClick="checkunlimitedviews();"></td>
			<?
		}
		else {
			?>
			<td bgcolor= "#ECECFF"><?if($row["views"]!=-1)echo $row["views"];else echo $GLOBALS['strUnlimited'];?></td>
			<td align=center></td>
			<?
		}
		?>
	</tr>
	<tr>
		<td><?echo $strClicksPurchased;?>:</td>
		<?
		if (phpAds_isUser(phpAds_Admin))
		{
			?>
			<td><input type="text" name="clicks" value="<?if($row["clicks"]!=-1)echo $row["clicks"];else echo $GLOBALS['strUnlimited'].'-->';?>"></td>
			<td align=center><input type="checkbox" name="unlimitedclicks"<?if($row["clicks"]==-1)print " CHECKED";?> onClick="checkunlimitedclicks();"></td>
			<?
		}
		else {
			?>
			<td bgcolor= "#ECECFF"><?if($row["clicks"]!=-1)echo $row["clicks"];else echo $GLOBALS['strUnlimited'];?></td>
			<td align=center></td>
			<?
		}
		?>
	</tr>
	<tr>
		<td><?echo $strDaysPurchased;?>:</td>
		<?
		if (phpAds_isUser(phpAds_Admin))
		{
			?>
			<td><input type="text" name="days_left" value="<?if($days_left!=-1)echo $days_left;else echo $GLOBALS['strUnlimited'].'-->';?>"></td>
			<td align=center><input type="checkbox" name="unlimiteddays_left"<?if($days_left==-1)print " CHECKED";?> onClick="checkunlimiteddays_left();"></td>
			<?
		}
		else 
		{
			?>
			<td bgcolor= "#ECECFF"><?if($days_left!=-1)echo $days_left;else echo $GLOBALS['strUnlimited'];?></td>
			<td align=center></td>
			<?
		}
		?>
	</tr>
	<tr>
		<td><?echo $strUsername;?>:</td>
		<?
		if (phpAds_isUser(phpAds_Admin))
		{
			?>
			<td><input type="text" name="clientusername" value="<?if(isset($row["clientusername"]))echo $row["clientusername"];?>">
			<?
		}
		else 
		{
			?>
			<td bgcolor= "#ECECFF"><?if(isset($row["clientusername"]))echo $row["clientusername"];?>
			<?
		}
		?>
	</tr>
	<tr>
		<td><?echo $strPassword;?>:</td>
		<td><input type="text" name="clientpassword" value="<?if(isset($row["clientpassword"]))echo $row["clientpassword"];?>">
	</tr>
</table>
		<?
		if (phpAds_isUser(phpAds_Admin))
		{
			?>
<hr>
<table>
	<tr>
		<td><input type="checkbox" name="clientpermissions[]" value="<?echo phpAds_ModifyInfo; ?>"<?echo (phpAds_ModifyInfo & $row["permissions"]) ? " CHECKED" : ""; ?>></td>
		<td><?echo $GLOBALS[strAllowClientModifyInfo]; ?></td>
	</tr>
	<!-- Still working on this (Niels)
	<tr>
		<td><input type="checkbox" name="clientpermissions[]" value="<?echo phpAds_ModifyBanner; ?>"<?echo (phpAds_ModifyBanner & $row["permissions"]) ? " CHECKED" : ""; ?>></td>
		<td><?echo $GLOBALS[strAllowClientModifyBanner]; ?></td>
	</tr>	
	<tr>
		<td><input type="checkbox" name="clientpermissions[]" value="<?echo phpAds_AddBanner; ?>"<?echo (phpAds_AddBanner & $row["permissions"]) ? " CHECKED" : ""; ?>></td>
		<td><?echo $GLOBALS[strAllowClientAddBanner]; ?></td>
	</tr>	
	-->
</table>
<hr>
			<?
		}
		?>
<table>
	<tr>
		<td></td>
		<td><input type="submit" name="submit" value="<?echo $strGo;?>"></td>
	</tr>
</table>
</form>

<?
page_footer();
?>

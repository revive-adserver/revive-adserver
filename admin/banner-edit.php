<?

require ("config.php");
require ("lib-statistics.inc.php");

phpAds_checkAccess(phpAds_Admin+phpAds_Client);


if (phpAds_isUser(phpAds_Client))
{
	$result = db_query("
		SELECT
			clientID
		FROM
			$phpAds_tbl_banners
		WHERE
			bannerID = $bannerID
		") or mysql_die();
	$row = mysql_fetch_array($result);
	
	if($row["clientID"] != phpAds_clientID())
	{
		phpAds_PageHeader($strModifyBanner);
		phpAds_ShowNav("2.4");
		php_die ($strAccessDenied, $strNotAdmin);
	}
	else
	{
		$clientID = phpAds_clientID();
	}
}





// If the form is being submitted, add a new record to banners
if (isset($submit))
{
	switch($bannertype) 
	{
		case "mysql":
			if (!empty($mysql_banner) && $mysql_banner != "none")
			{
				$size = GetImageSize($mysql_banner);
				$final["width"] = $size[0];
				$final["height"] = $size[1];
				$ext = substr($mysql_banner_name, strrpos($mysql_banner_name, ".")+1);
				switch (strtoupper($ext)) 
				{
					case "JPEG":
						$final["format"] = "jpeg";
						break;
					case "JPG":
						$final["format"] = "jpeg";
						break;
					case "HTML":
						$final["format"] = "html";
						break;
					case "PNG":
						$final["format"] = "png";
						break;
					case "GIF":
						$final["format"] = "gif";
						break;
				}
				$final["banner"] = addslashes(fread(fopen($mysql_banner, "rb"), filesize($mysql_banner)));
			}
			$final["alt"] = $mysql_alt;
			$final["bannertext"] = $mysql_bannertext;
			$final["url"] = $mysql_url;
			break;
		case "url":
			$final["width"] = $url_width;
			$final["height"] = $url_height;
			$final["format"] = "url";
			$final["banner"] = $url_banner;
			$final["alt"] = $url_alt;
			$final["bannertext"] = $url_bannertext;
			$final["url"] = $url_url;
			break;
		case "html";
			$final["width"] = $html_width;
			$final["height"] = $html_height;
			$final["format"] = "html";
			$final["banner"] = $html_banner;
			$final["alt"] = "";
			$final["bannertext"] = "";
			$final["url"] = $html_url;
			break;
	}
	$final["clientID"] = $clientID;
	$final["bannerID"] = $bannerID;
	
	if (phpAds_isUser(phpAds_Admin)) 
	{
		$final["active"] = "true";
		$final["keyword"] = $keyword;
		$final["description"] = $description;
		$final["weight"] = $weight;
	}

	// Don't add an empty banner
	if (empty($final["banner"]) || $final["banner"] == "none")
		unset($final["banner"]);

	$message = $bannerID=='' ? $strBannerAdded : $strBannerModified;

	// Construct appropiate SQL query
	// If bannerID==null, then this is an INSERT, else it's an UPDATE
	if ($final["bannerID"] == '')
	{ 
		// INSERT
		$values_fields = "";
		$values = "";
		while (list($name, $value) = each($final))
		{
			$values_fields .= "$name, ";
			$values .= "'$value', ";
		}
		
		// Cut trailing commas
		$values_fields = ereg_replace(", $", "", $values_fields);
		$values = ereg_replace(", $", "", $values);
   		
		// Execute query
		$sql_query = "
			INSERT INTO
				$phpAds_tbl_banners
				($values_fields)
			VALUES
			($values)";
		$res = db_query($sql_query) or mysql_die();     
	}
	else 
	{
		// UPDATE
		$set = "";
		while (list($name, $value) = each($final))
		{
			$set .= "$name = '$value', ";
		}
		
		// Cut trailing commas
		$set = ereg_replace(", $", "", $set);
		
		// Execute query
		$sql_query = "
			UPDATE
				$phpAds_tbl_banners
			SET
				$set
			WHERE
				bannerID = $final[bannerID]";
		$res = db_query($sql_query) or mysql_die();     
	}
	
	
	if (phpAds_isUser(phpAds_Client))
	{
		Header("Location: stats-client.php?clientID=$clientID&message=".urlencode($message));
	}
	else
	{
		Header("Location: banner-client.php?clientID=$clientID&message=".urlencode($message));
	}
	
	exit;
}




// If we find an ID, means that we're in update mode  
if ($bannerID != '')
{
	phpAds_PageHeader("$strModifyBanner");
	
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
		
		$extra .= "<a href='banner-edit.php?clientID=$clientID&bannerID=$row[bannerID]'>";
		$extra .= phpAds_buildBannerName ($row[bannerID], $row[description], $row[alt]);		
		$extra .= "</a>";
		$extra .= "<br>"; 
	}
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";

	if (phpAds_isUser(phpAds_Admin))
	{
		$extra .= "<br><br><br><br><br>";
		$extra .= "<b>$strShortcuts</b><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "<img src='images/caret-rs.gif'>&nbsp;<a href=client-edit.php?clientID=$clientID>$strModifyClient</a><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "<img src='images/caret-rs.gif'>&nbsp;<a href=stats-client.php?clientID=$clientID>$strStats</a><br>";
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/caret-rs.gif'>&nbsp;<a href=stats-details.php?clientID=$clientID&bannerID=$bannerID>$strDetailStats</a><br>";
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/caret-rs.gif'>&nbsp;<a href=stats-weekly.php?clientID=$clientID>$strWeeklyStats</a><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		
		phpAds_ShowNav("1.3.2", $extra);
	}
	else
	{
		phpAds_ShowNav("2.4", $extra);
	}
	
	
	$res = db_query("
		SELECT
			*
		FROM
			$phpAds_tbl_banners
		WHERE
			bannerID = $bannerID
		") or mysql_die();
	$row = mysql_fetch_array($res);
	
	if (ereg("gif|png|jpeg", $row["format"]))
		$type = "mysql";
	else
		$type = $row["format"];
}
else
{
	phpAds_PageHeader("$strAddBanner");
	phpAds_ShowNav("1.3.1");   
}


// determine if we're running IE 
$isiepos = strpos($HTTP_USER_AGENT,"MSIE"); 
$isie = ( $isiepos>0 ? substr($HTTP_USER_AGENT,$isiepos+5,3) : 0 ); 
?>

<? if ($isie) { ?>

    <SCRIPT>
    function show(n)
    {
        ss="none"; sh="none"; su="none";
        if (n==1) {
          ss="";
        } else if (n==2) {
          su="";
        } else {
          sh="";
        }
        mysqlForm.style.display=ss; 
        htmlForm.style.display=sh; 
        urlForm.style.display=su; 
    }
    
    </SCRIPT>
    
    <SCRIPT FOR=window EVENT=onload LANGUAGE="JScript">
      <?php
        if (!isset($type) || $type == "mysql") echo "  show(1);\n";
        if (isset($type) && $type == "url") echo "  show(2);\n";
        if (isset($type) && $type == "html") echo "  show(3);\n";
      ?>
    </SCRIPT>
    
<? } ?>






<table width='100%' border="0" align="center" cellspacing="0" cellpadding="0">
  <tr><td height='25' colspan='4'>
  <? 
	if ($bannerID != '')
		echo "<b>$strBanner: ".phpAds_getBannerName($bannerID)."</b> <img src='images/caret-rs.gif'> ";
		echo $strClientName.': '.phpAds_getClientName($clientID);
  ?>
  </td></tr>
  <tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
  <?
	if ($bannerID != '')
		echo "<tr><td colspan='4' align='left'><br>".phpAds_getBannerCode($bannerID)."<br><br></td></tr>";
  ?>
</table>

<br><br>

<form action="<?echo basename($PHP_SELF);?>" method="POST" enctype="multipart/form-data">
<input type="hidden" name="return" value="<? echo ($return) ?>">
<input type="hidden" name="clientID" value="<? echo ($clientID) ?>">
<input type="hidden" name="bannerID" value="<? echo ($bannerID) ?>">

<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='3'><b><?echo $strChooseBanner;?></b></td></tr>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr height='35'>
		<td>
			<select name='bannertype' onchange='show(this.selectedIndex+1)'>
				<option value='mysql'<?if ($type == "mysql") echo " selected";?>><?echo $strMySQLBanner;?></option>
				<option value='url'<?if ($type == "url") echo " selected";?>><?echo $strURLBanner;?></option>
				<option value='html'<?if ($type == "html") echo " selected";?>><?echo $strHTMLBanner;?></option>
			</select>
		</td>
	</tr>	
</table>
	
<br><br>

<div id="mysqlForm" <?if (isset($type) && $type != "mysql") echo 'style="display:none"'; ?> >
<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='3'><b><?echo $strMySQLBanner;?></b></td></tr>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr height='35'>
		<td width='200'><?echo $strNewBannerFile;?></td>
		<td colspan='2'><input size="50" type="file" name="mysql_banner"></td>
	</tr>
	<tr height='35'>
		<td width='200'><?echo $strURL;?></td>
    	<td colspan='2'><input size="50" type="text" name="mysql_url" value="<?if (isset($type) && $type == "mysql") echo $row["url"];?>"></td>
	</tr>
	<tr height='35'>
		<td width='200'><?echo $strAlt;?></td>
		<td colspan='2'><input size="50" type="text" name="mysql_alt" value="<?if (isset($type) && $type == "mysql") echo $row["alt"];?>"></td>
	</tr>
	<tr height='35'>
		<td width='200'><?echo $strTextBelow;?></td>
		<td colspan='2'><input size="50" type="text" name="mysql_bannertext" value="<?if (isset($type) && $type == "mysql") echo $row["bannertext"];?>"></td>
	</tr>
</table>
<br><br>
</div>	

<div id="urlForm" <?if (!isset($type) || $type != "url") echo 'style="display:none"'; ?> >
<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='3'><b><?echo $strURLBanner;?></b></td></tr>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr height='35'>
		<td width='200'><?echo $strURL;?></td>
		<td colspan='2'><input size="50" type="text" name="url_url" value="<?if (isset($type) && $type == "url") echo $row["url"];?>"></td>
	</tr>
	<tr height='35'>
		<td width='200'><?echo $strWidth;?></td>
		<td colspan='2'><input size="50" type="text" name="url_width" value="<?if (isset($type) && $type == "url") echo $row["width"];?>"></td>
	</tr>
	<tr height='35'>
		<td width='200'><?echo $strHeight;?></td>
		<td colspan='2'><input size="50" type="text" name="url_height" value="<?if (isset($type) && $type == "url") echo $row["height"];?>"></td>
	</tr>
	<tr height='35'>
		<td width='200'><?echo $strAlt;?></td>
		<td colspan='2'><input size="50" type="text" name="url_alt" value="<?if (isset($type) && $type == "url") echo $row["alt"];?>"></td>
	</tr>
	<tr height='35'>
		<td width='200'><?echo $strTextBelow;?></td>
		<td colspan='2'><input size="50" type="text" name="url_bannertext" value="<?if (isset($type) && $type == "url") echo $row["bannertext"];?>"></td>
	</tr>
</table>
<br><br>	
</div>	

<div id="htmlForm" <?if (!isset($type) || $type != "html") echo 'style="display:none"'; ?> >
<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='3'><b><?echo $strHTMLBanner;?></b></td></tr>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr height='35'>
		<td width='200' valign='top'><br><?echo $strHTML;?></td>
		<td colspan='2'><br><textarea cols="50" rows="8" name="html_banner"><?if (isset($type) && $type == "html") echo $row["banner"];?></textarea></td>
	</tr>
	<tr height='35'>
		<td width='200'><?echo $strURL;?></td>
    	<td colspan='2'><input size="50" type="text" name="html_url" value="<?if (isset($type) && $type == "html") echo $row["url"];?>"></td>
	</tr>
	<tr height='35'>
		<td width='200'><?echo $strWidth;?></td>
		<td colspan='2'><input size="50" type="text" name="html_width" value="<?if (isset($type) && $type == "html") echo $row["width"];?>"></td>
	</tr>
	<tr height='35'>
		<td width='200'><?echo $strHeight;?></td>
		<td colspan='2'><input size="50" type="text" name="html_height" value="<?if (isset($type) && $type == "html") echo $row["height"];?>"></td>
	</tr>
</table>
<br><br>
</div>	

<table border='0' width='100%' cellpadding='0' cellspacing='0'>
<? if (phpAds_isUser(phpAds_Admin)) { ?>
	<tr><td height='25' colspan='3'><b><?echo $strGeneralSettings;?></b></td></tr>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr height='35'>
		<td width='200'><?echo $strKeyword;?></td>
    	<td colspan='2'><input size="50" type="text" name="keyword" value="<?if(isset($row["keyword"]))echo $row["keyword"];?>"></td>
	</tr>
	<tr height='35'>
		<td width='200'><?echo $strDescription;?></td>
    	<td colspan='2'><input size="50" type="text" name="description" value="<?if(isset($row["description"]))echo $row["description"];?>"></td>
	</tr>
	<tr height='35'>
		<td width='200'><?echo $strWeight;?></td>
    	<td colspan='2'><input size="6" type="text" name="weight" value="<?if(isset($row["weight"])){echo $row["weight"];}else{print "1";}?>"></td>
	</tr>
	<tr height='35'><td colspan='3'>&nbsp;</td></tr>
<? } ?>
	<tr height='35'>
		<td colspan='3'><input type="submit" name="submit" value="<?echo $strSubmit;?>"></td>
	</tr>
</table>
</form>

	
<br><br>
<br><br>	

	
<?
phpAds_PageFooter();
?>

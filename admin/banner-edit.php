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
require ("lib-storage.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Client);



/*********************************************************/
/* Client interface security                             */
/*********************************************************/

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




/*********************************************************/
/* Process submitted form                                */
/*********************************************************/

if (isset($submit))
{
	// Clean up old webserver stored banner
	if (isset($web_banner_cleanup) && $web_banner_cleanup != "")
	{
		if (($bannertype == "web" && !empty($web_banner) && $web_banner != "none") OR ($bannertype != "web"))
		{
			phpAds_Cleanup($web_banner_cleanup);
		}
	}
	
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
			$final["alt"] = addslashes($mysql_alt);
			$final["bannertext"] = addslashes($mysql_bannertext);
			$final["url"] = $mysql_url;
			break;
		case "web":
			if (!empty($web_banner) && $web_banner != "none")
			{
				$size = GetImageSize($web_banner);
				$final["width"] = $size[0];
				$final["height"] = $size[1];
				
				// upload $web_banner file to location
				// set banner to web location
				$final["banner"] = phpAds_Store($web_banner, basename($web_banner_name));
			}
			$final["format"] = "web";
			$final["alt"] = addslashes($web_alt);
			$final["bannertext"] = addslashes($web_bannertext);
			$final["url"] = $web_url;
			break;
		case "url":
			$final["width"] = $url_width;
			$final["height"] = $url_height;
			$final["format"] = "url";
			$final["banner"] = $url_banner;
			$final["alt"] = addslashes($url_alt);
			$final["bannertext"] = addslashes($url_bannertext);
			$final["url"] = $url_url;
			break;
		case "html";
			$final["width"] = $html_width;
			$final["height"] = $html_height;
			$final["format"] = "html";
			$final["banner"] = addslashes($html_banner);
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
		$final["description"] = addslashes($description);
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
				bannerID = ".$final['bannerID'];
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



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if ($bannerID != '')
{
	$extra = '';
	
	$res = db_query("
	SELECT
		*
	FROM
		$phpAds_tbl_banners
	WHERE
		clientID = ".$GLOBALS['clientID']."
	") or mysql_die();

	$extra = "";	
	while ($row = mysql_fetch_array($res))
	{
		if ($bannerID == $row['bannerID'])
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
		else
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
		
		$extra .= "<a href='banner-edit.php?clientID=$clientID&bannerID=".$row['bannerID']."'>";
		$extra .= phpAds_buildBannerName ($row['bannerID'], $row['description'], $row['alt']);		
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
		
		phpAds_PageHeader("4.1.2", $extra);
	}
	else
	{
		phpAds_PageHeader("1.3", $extra);
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
	phpAds_PageHeader("4.1.1");   

	$type = "mysql";
	$row['alt'] = "";
	$row['bannertext'] = "";
	$row['url'] = "";
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

// Determine if the browser supports DHTML

if (!ereg ("Mozilla/4", $HTTP_USER_AGENT) || ereg ("IE", $HTTP_USER_AGENT))
	$dhtml = true;
else
	$dhtml = false;

// Determine which bannertypes to show
$show_sql  = $phpAds_type_sql_allow;
$show_web  = $phpAds_type_web_allow;
$show_url  = $phpAds_type_url_allow;
$show_html = $phpAds_type_html_allow;
if ($type == "mysql") $show_sql  = true;
if ($type == "web")   $show_web  = true;
if ($type == "url")   $show_url  = true;
if ($type == "html")  $show_html = true;

?>


<script language='Javascript'>
<!--
    function show(n)
    {
		mysqlObject = findObj ('mysqlForm');
		htmlObject = findObj ('htmlForm');
		urlObject = findObj ('urlForm');
		webObject = findObj ('webForm');
	
        ss="none"; sh="none"; su="none"; sw="none"
        if (n=='mysql') {
          ss="";
        } else if (n=='web') {
          sw="";
        } else if (n=='url') {
          su="";
        } else {
          sh="";
        }
		
        if (mysqlObject) mysqlObject.style.display=ss; 
        if (htmlObject)  htmlObject.style.display=sh; 
        if (urlObject)   urlObject.style.display=su; 
		if (webObject)   webObject.style.display=sw;
    }
//-->
</script>
    



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
<input type="hidden" name="clientID" value="<? echo ($clientID) ?>">
<input type="hidden" name="bannerID" value="<? echo ($bannerID) ?>">

<? if ($dhtml) { ?>
<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='3'><b><?echo $strChooseBanner;?></b></td></tr>
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr>
		<td height='35'>
			<select name='bannertype' onChange='show(this.options[this.selectedIndex].value);'>
				<?if ($show_sql) { ?><option value='mysql'<?if ($type == "mysql") echo " selected";?>><?echo $strMySQLBanner;?></option><? } ?>
				<?if ($show_web) { ?><option value='web'<?if ($type == "web") echo " selected";?>><?echo $strWebBanner;?></option><? } ?>
				<?if ($show_url) { ?><option value='url'<?if ($type == "url") echo " selected";?>><?echo $strURLBanner;?></option><? } ?>
				<?if ($show_html) { ?><option value='html'<?if ($type == "html") echo " selected";?>><?echo $strHTMLBanner;?></option><? } ?>
			</select>
		</td>
	</tr>	
</table>
<br><br>
<? }?>	


<?if ($show_sql) {?>
<?if ($dhtml) {?><div id="mysqlForm" <?if (isset($type) && $type != "mysql") echo 'style="display:none"';?>><?}?>
<table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='#F6F6F6'>
	<?if ($dhtml) {?>
		<tr><td height='25' colspan='3' bgcolor='#FFFFFF'><b><?echo $strMySQLBanner;?></b></td></tr>
	<?} else {?>
		<tr><td height='25' colspan='3' bgcolor='#FFFFFF'>
		<input type='radio' name='bannertype' value='mysql'<? if ($type == "mysql") echo " checked";?>>
		<b><?echo $strMySQLBanner;?></b></td></tr>
	<?}?>
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>

	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $strNewBannerFile;?></td>
		<td><input size="26" type="file" name="mysql_banner" style="width:350px;"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $strURL;?></td>
    	<td><input size="35" type="text" name="mysql_url" style="width:350px;" value="<?if (isset($type) && $type == "mysql") echo $row["url"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $strAlt;?></td>
		<td><input size="35" type="text" name="mysql_alt" style="width:350px;" value="<?if (isset($type) && $type == "mysql") echo $row["alt"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $strTextBelow;?></td>
		<td><input size="35" type="text" name="mysql_bannertext" style="width:350px;" value="<?if (isset($type) && $type == "mysql") echo $row["bannertext"];?>"></td>
	</tr>

	<tr><td height='20' colspan='3'>&nbsp;</td></tr>
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
</table>
<?if ($dhtml) {?></div><?} else {?><br><br><?}?>
<?}?>


<?if ($show_web) {?>
<?if ($dhtml) {?><div id="webForm" <?if (isset($type) && $type != "web") echo 'style="display:none"';?>><?}?>
<table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='#F6F6F6'>
	<?if ($dhtml) {?>
		<tr><td height='25' colspan='3' bgcolor='#FFFFFF'><b><?echo $strWebBanner;?></b></td></tr>
	<?} else {?>
		<tr><td height='25' colspan='3' bgcolor='#FFFFFF'>
		<input type='radio' name='bannertype' value='web'<?if ($type == "web") echo " checked";?>>
		<b>Banner stored on the webserver</b></td></tr>
	<?}?>
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>

	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $strNewBannerFile;?></td>
		<td><input size="26" type="file" name="web_banner" style="width:350px;">
			<input type="hidden" name="web_banner_cleanup" value="<?if (isset($type) && $type == "web") echo basename($row["banner"]);?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $strURL;?></td>
    	<td><input size="35" type="text" name="web_url" style="width:350px;" value="<?if (isset($type) && $type == "web") echo $row["url"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $strAlt;?></td>
		<td><input size="35" type="text" name="web_alt" style="width:350px;" value="<?if (isset($type) && $type == "web") echo $row["alt"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $strTextBelow;?></td>
		<td><input size="35" type="text" name="web_bannertext" style="width:350px;" value="<?if (isset($type) && $type == "web") echo $row["bannertext"];?>"></td>
	</tr>

	<tr><td height='20' colspan='3'>&nbsp;</td></tr>
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
</table>
<?if ($dhtml) {?></div><?} else {?><br><br><?}?>
<?}?>


<?if ($show_url) {?>
<?if ($dhtml) {?><div id="urlForm" <?if (!isset($type) || $type != "url") echo 'style="display:none"';?>><?}?>
<table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='#F6F6F6'>
	<?if ($dhtml) {?>
		<tr><td height='25' colspan='3' bgcolor='#FFFFFF'><b><?echo $strURLBanner;?></b></td></tr>
	<?} else {?>
		<tr><td height='25' colspan='3' bgcolor='#FFFFFF'>
		<input type='radio' name='bannertype' value='url'<?if ($type == "url") echo " checked";?>>
		<b><?echo $strURLBanner;?></b></td></tr>
	<?}?>
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>

	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $strNewBannerURL;?></td>
		<td><input size="35" type="text" name="url_banner" style="width:350px;" value="<?if (isset($type) && $type == "url") echo $row["banner"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $strURL;?></td>
		<td><input size="35" type="text" name="url_url" style="width:350px;" value="<?if (isset($type) && $type == "url") echo $row["url"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $strAlt;?></td>
		<td><input size="35" type="text" name="url_alt" style="width:350px;" value="<?if (isset($type) && $type == "url") echo $row["alt"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $strTextBelow;?></td>
		<td><input size="35" type="text" name="url_bannertext" style="width:350px;" value="<?if (isset($type) && $type == "url") echo $row["bannertext"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>	
		<td width='200'><?echo $strSize;?></td>
		<td>
			<?echo $strWidth;?>: <input size="5" type="text" name="url_width" value="<?if (isset($type) && $type == "url") echo $row["width"];?>">
			&nbsp;&nbsp;&nbsp;
			<?echo $strHeight;?>: <input size="5" type="text" name="url_height" value="<?if (isset($type) && $type == "url") echo $row["height"];?>">
		</td>
	</tr>

	<tr><td height='20' colspan='3'>&nbsp;</td></tr>
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
</table>
<?if($dhtml) {?></div><?} else {?><br><br><?}?>
<?}?>


<?if ($show_html) {?>
<?if ($dhtml) {?><div id="htmlForm" <?if (!isset($type) || $type != "html") echo 'style="display:none"';?>><?}?>
<table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='#F6F6F6'>
	<?if ($dhtml) {?>
		<tr><td height='25' colspan='3' bgcolor='#FFFFFF'><b><?echo $strHTMLBanner;?></b></td></tr>
	<?} else {?>
		<tr><td height='25' colspan='3' bgcolor='#FFFFFF'>
		<input type='radio' name='bannertype' value='html'<?if ($type == "html") echo " checked";?>>
		<b><?echo $strHTMLBanner;?></b></td></tr>
	<?}?>
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
	
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200' valign='top'><?echo $strHTML;?></td>
		<td><textarea cols="35" rows="8" name="html_banner" style="width:350px;"><?if (isset($type) && $type == "html") echo stripslashes($row["banner"]);?></textarea></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>	
		<td width='200'><?echo $strURL;?></td>
    	<td><input size="35" type="text" name="html_url" style="width:350px;" value="<?if (isset($type) && $type == "html") echo $row["url"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>	
		<td width='200'><?echo $strSize;?></td>
		<td>
			<?echo $strWidth;?>: <input size="5" type="text" name="html_width" value="<?if (isset($type) && $type == "html") echo $row["width"];?>">
			&nbsp;&nbsp;&nbsp;
			<?echo $strHeight;?>: <input size="5" type="text" name="html_height" value="<?if (isset($type) && $type == "html") echo $row["height"];?>">
		</td>
	</tr>

	<tr><td height='20' colspan='3'>&nbsp;</td></tr>
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
</table>
<?if ($dhtml) {?></div><?} else {?><br><br><?}?>
<?}?>


<table border='0' width='100%' cellpadding='0' cellspacing='0'>
<?if (phpAds_isUser(phpAds_Admin)) {?>
<?if (!$dhtml) {?>
	<tr><td height='25' colspan='3' bgcolor='#FFFFFF'><b><?echo $strGeneralSettings;?></b></td></tr>
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
<?}?>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
	<tr>
		<td width='30'>&nbsp;</td>	
		<td width='200'><?echo $strKeyword;?></td>
    	<td><input size="35" type="text" name="keyword" style="width:350px;" value="<?if(isset($row["keyword"]))echo $row["keyword"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>	
		<td width='200'><?echo $strDescription;?></td>
    	<td><input size="35" type="text" name="description" style="width:350px;" value="<?if(isset($row["description"]))echo $row["description"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>	
		<td width='200'><?echo $strWeight;?></td>
    	<td><input size="6" type="text" name="weight" value="<?if(isset($row["weight"])){echo $row["weight"];}else{print "1";}?>"></td>
	</tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	
</table>
<br><br>
<?}?>

<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr>
		<td height='35' colspan='3'><input type="submit" name="submit" value="<?echo $strSubmit;?>"></td>
	</tr>
</table>
</form>

	
<br><br>
<br><br>	

	
<?

/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>

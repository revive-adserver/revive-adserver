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
	if (phpAds_isAllowed(phpAds_ModifyBanner))
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
		
		if ($row["clientID"] == '' || phpAds_clientID() != phpAds_getParentID ($row["clientID"]))
		{
			phpAds_PageHeader("1");
			php_die ($strAccessDenied, $strNotAdmin);
		}
		else
		{
			$campaignID = $row["clientID"];
		}
	}
	else
	{
			phpAds_PageHeader("1");
			php_die ($strAccessDenied, $strNotAdmin);
	}
}




/*********************************************************/
/* Process submitted form                                */
/*********************************************************/

if (isset($submit))
{
	// Delete uploaded var for security
	if (isset($uploaded)) unset ($uploaded);
	
	// Get information about uploaded file
	// and make selection if multiple files are uploaded
	if (isset($HTTP_POST_FILES))
	{
		if ($bannertype == 'mysql' && isset($HTTP_POST_FILES['sqlupload']) && $HTTP_POST_FILES['sqlupload']['tmp_name'] != "none")
		{
			$uploaded = $HTTP_POST_FILES['sqlupload'];
		}
		elseif ($bannertype == 'web' && isset($HTTP_POST_FILES['webupload']) && $HTTP_POST_FILES['webupload']['tmp_name'] != "none")
		{
			$uploaded = $HTTP_POST_FILES['webupload'];
		}
	}
	else
	{
		if ($bannertype == 'mysql' && !empty($sqlupload) && $sqlupload != "none")
		{
			$uploaded = array (
				'name'		=> $sqlupload_name,
				'type'		=> $sqlupload_type,
				'size'		=> $sqlupload_size,
				'tmp_name'	=> $sqlupload
			);
		}
		elseif ($bannertype == 'web' && !empty($webupload) && $webupload != "none")
		{
			$uploaded = array (
				'name'		=> $webupload_name,
				'type'		=> $webupload_type,
				'size'		=> $webupload_size,
				'tmp_name'	=> $webupload
			);
		}
	}
	
	// Check if uploaded file is really uploaded
	if (isset($uploaded))
	{
		if (function_exists("is_uploaded_file"))
		{
			$upload_valid = is_uploaded_file($uploaded['tmp_name']);
		}
		else
		{
			if (!$tmp_file = get_cfg_var('upload_tmp_dir')) 
			{
				$tmp_file = tempnam('',''); 
				@unlink($tmp_file); 
				$tmp_file = dirname($tmp_file);
			}
			
			$tmp_file .= '/' . basename($uploaded['tmp_name']);
			$tmp_file = str_replace('\\', '/', $tmp_file);
			$tmp_file  = ereg_replace('/+', '/', $tmp_file);
			
			$up_file = str_replace('\\', '/', $uploaded['tmp_name']);
			$up_file = ereg_replace('/+', '/', $up_file);
			
			$upload_valid = ($tmp_file == $up_file);
		}
		
		// Don't use file in case of exploit
		if (!$upload_valid)
		{
			unset ($uploaded);
		}
	}
	
	// Clean up old webserver stored banner
	if (isset($web_banner_cleanup) && $web_banner_cleanup != "")
	{
		if (($bannertype == "web" && isset($uploaded)) OR ($bannertype != "web"))
		{
			phpAds_Cleanup($web_banner_cleanup);
		}
	}
	
	
	
	
	switch($bannertype) 
	{
		case 'mysql':
			if (isset($uploaded))
			{
				$size = @getimagesize($uploaded['tmp_name']);
				$final['width'] = $size[0];
				$final['height'] = $size[1];
				$ext = substr($uploaded['name'], strrpos($uploaded['name'], ".")+1);
				switch (strtoupper($ext)) 
				{
					case 'JPEG':
						$final['format'] = 'jpeg';
						break;
					case 'JPG':
						$final['format'] = 'jpeg';
						break;
					case 'HTML':
						$final['format'] = 'html';
						break;
					case 'PNG':
						$final['format'] = 'png';
						break;
					case 'GIF':
						$final['format'] = 'gif';
						break;
					case 'SWF':
						$final['format'] = 'swf';
						break;
				}
				$final['banner'] = addslashes(fread(fopen($uploaded['tmp_name'], "rb"), filesize($uploaded['tmp_name'])));
			}
			else
			{
				$final['width'] = $sqlwidth;
				$final['height'] = $sqlheight;
			}
			$final['alt'] = addslashes($sqlalt);
			$final['status'] = addslashes($sqlstatus);
			$final['bannertext'] = addslashes($sqlbannertext);
			$final['url'] = $sqlurl;
			break;
		case 'web':
			if (isset($uploaded))
			{
				$size = @getimagesize($uploaded['tmp_name']);
				$final['width'] = $size[0];
				$final['height'] = $size[1];
				
				// upload image to location
				// set banner to web location
				$final['banner'] = phpAds_Store($uploaded['tmp_name'], basename($uploaded['name']));
				
				if ($final['banner'] == false)
				{
					phpAds_PageHeader("1");
					php_die ('Error', 'An error occcured while uploading the banner to the ftp server');
				}
			}
			else
			{
				$final['width'] = $webwidth;
				$final['height'] = $webheight;
			}
			$final['format'] = "web";
			$final['alt'] = addslashes($webalt);
			$final['status'] = addslashes($webstatus);
			$final['bannertext'] = addslashes($webbannertext);
			$final['url'] = $weburl;
			break;
		case 'url':
			$final['width'] = $urlwidth;
			$final['height'] = $urlheight;
			$final['format'] = "url";
			$final['banner'] = $urlbanner;
			$final['alt'] = addslashes($urlalt);
			$final['status'] = addslashes($urlstatus);
			$final['bannertext'] = addslashes($urlbannertext);
			$final['url'] = $urlurl;
			break;
		case 'html';
			$final['width'] = $htmlwidth;
			$final['height'] = $htmlheight;
			$final['format'] = "html";
			$final['banner'] = addslashes($htmlbanner);
			$final['alt'] = "";
			$final['bannertext'] = "";
			$final['url'] = $htmlurl;
			$final['autohtml'] = $htmlauto;
			break;
	}
	$final['clientID'] = $campaignID;
	$final['bannerID'] = $bannerID;
	
	if (phpAds_isUser(phpAds_Admin)) 
	{
		$final['active'] = "true";
		$final['keyword'] = $keyword;
		$final['description'] = addslashes($description);
		$final['weight'] = $weight;
	}
	
	
	$message = $bannerID=='' ? $strBannerAdded : $strBannerModified;
	
	// Construct appropiate SQL query
	// If bannerID==null, then this is an INSERT, else it's an UPDATE
	if (isset($bannerID) && trim($bannerID) != '')
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
	else
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
	
	
	
	// Remove temporary file
	if (isset($uploaded))
	{
		if (@file_exists($uploaded['tmp_name']))
			@unlink ($uploaded['tmp_name']);
	}
	
	
	
	
	if (phpAds_isUser(phpAds_Client))
	{
		Header("Location: stats-campaign.php?campaignID=$campaignID&message=".urlencode($message));
	}
	else
	{
		Header("Location: campaign-index.php?campaignID=$campaignID&message=".urlencode($message));
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
		clientID = $campaignID
	") or mysql_die();

	$extra = "";	
	while ($row = mysql_fetch_array($res))
	{
		if ($bannerID == $row['bannerID'])
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
		else
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
		
		$extra .= "<a href='banner-edit.php?campaignID=$campaignID&bannerID=".$row['bannerID']."'>";
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
		
		phpAds_PageHeader("4.1.2", $extra);
	}
	else
	{
		phpAds_PageHeader("1.1.3", $extra);
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
	
	if (ereg("gif|png|jpeg|swf", $row["format"]))
		$type = "mysql";
	else
		$type = $row["format"];
	
	if (isset($row['alt']))
		$row['alt']			= htmlentities(stripslashes($row['alt']));
	
	if (isset($row['status']))
		$row['status']		= htmlentities(stripslashes($row['status']));
	
	if (isset($row['bannertext']))
		$row['bannertext'] 	= htmlentities(stripslashes($row['bannertext']));
	
	if (isset($row['description']))
		$row['description'] = htmlentities(stripslashes($row['description']));
}
else
{
	phpAds_PageHeader("4.1.1");   
	
	$row['alt'] = "";
	$row['status'] = "";
	$row['bannertext'] = "";
	$row['url'] = "";
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

// Determine if the browser supports DHTML

$BrowserNS6 	= ereg ("Mozilla/5", $HTTP_USER_AGENT);
$BrowserIE  	= ereg ("IE", $HTTP_USER_AGENT);

if ($BrowserNS6 || $BrowserIE)
	$dhtml = true;
else
	$dhtml = false;


// Determine which bannertypes to show
$show_sql  = $phpAds_type_sql_allow;
$show_web  = $phpAds_type_web_allow;
$show_url  = $phpAds_type_url_allow;
$show_html = $phpAds_type_html_allow;

if (isset($type) && $type == "mysql") $show_sql  = true;
if (isset($type) && $type == "web")   $show_web  = true;
if (isset($type) && $type == "url")   $show_url  = true;
if (isset($type) && $type == "html")  $show_html = true;

// If adding a new banner or used storing type is disabled
// determine which bannertype to show as default

if (!isset($type))
{
	if ($show_html) $type = "html"; 
	if ($show_url)  $type = "url"; 
	if ($show_web)  $type = "web"; 
	if ($show_sql)  $type = "mysql"; 
}


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
	<tr><td height='25' colspan='4'><img src='images/icon-client.gif' align='absmiddle'>&nbsp;<?php echo phpAds_getParentName($campaignID);?>
									&nbsp;<img src='images/caret-rs.gif'>&nbsp;
									<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<?php echo phpAds_getClientName($campaignID);?>
									&nbsp;<img src='images/caret-rs.gif'>&nbsp;
									<?php if ($bannerID != '') { ?>
									<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b><?php echo phpAds_getBannerName($bannerID);?></b></td></tr>
									<?php } else { ?>
									<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<?php echo $strUntitled; ?></td></tr>
									<?php } ?>
  <tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
  <?php
	if ($bannerID != '')
		echo "<tr><td colspan='4' align='left'><br>".phpAds_getBannerCode($bannerID)."<br><br></td></tr>";
  ?>
</table>

<br><br>

<form action="<?php echo basename($PHP_SELF);?>" method="POST" enctype="multipart/form-data">
<input type="hidden" name="campaignID" value="<?php echo ($campaignID) ?>">
<input type="hidden" name="bannerID" value="<?php echo ($bannerID) ?>">

<?php if ($dhtml) { ?>
<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='3'><b><?php echo $strChooseBanner;?></b></td></tr>
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr>
		<td height='35'>
			<select name='bannertype' onChange='show(this.options[this.selectedIndex].value);'>
				<?php if ($show_sql) { ?><option value='mysql'<?php if ($type == "mysql") echo " selected";?>><?php echo $strMySQLBanner;?></option><? } ?>
				<?php if ($show_web) { ?><option value='web'<?php if ($type == "web") echo " selected";?>><?php echo $strWebBanner;?></option><? } ?>
				<?php if ($show_url) { ?><option value='url'<?php if ($type == "url") echo " selected";?>><?php echo $strURLBanner;?></option><? } ?>
				<?php if ($show_html) { ?><option value='html'<?php if ($type == "html") echo " selected";?>><?php echo $strHTMLBanner;?></option><? } ?>
			</select>
		</td>
	</tr>	
</table>
<br><br>
<?php }?>


<?php if ($show_sql) {?>
<?php if ($dhtml) {?><div id="mysqlForm" <?php if (isset($type) && $type != "mysql") echo 'style="display:none"';?>><?php }?>
<table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='#F6F6F6'>
	<?php if ($dhtml) {?>
		<tr><td height='25' colspan='3' bgcolor='#FFFFFF'><img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b><?php echo $strMySQLBanner;?></b></td></tr>
	<?php } else {?>
		<tr><td height='25' colspan='3' bgcolor='#FFFFFF'>
		<input type='radio' name='bannertype' value='mysql'<?php if ($type == "mysql") echo " checked";?>>
		<b><?php echo $strMySQLBanner;?></b></td></tr>
	<?php }?>
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
	
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strNewBannerFile;?></td>
		<td><input size="26" type="file" name="sqlupload" style="width:350px;"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strURL;?></td>
		<td><input size="35" type="text" name="sqlurl" style="width:350px;" value="<?php if (isset($type) && $type == "mysql") echo $row["url"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strAlt;?></td>
		<td><input size="35" type="text" name="sqlalt" style="width:350px;" value="<?php if (isset($type) && $type == "mysql") echo $row["alt"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strStatusText;?></td>
		<td><input size="35" type="text" name="sqlstatus" style="width:350px;" value="<?php if (isset($type) && $type == "mysql") echo $row["status"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strTextBelow;?></td>
		<td><input size="35" type="text" name="sqlbannertext" style="width:350px;" value="<?php if (isset($type) && $type == "mysql") echo $row["bannertext"];?>"></td>
	</tr>
	<?php if (isset($bannerID) && $bannerID != '') {?>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>	
		<td width='200'><?php echo $strSize;?></td>
		<td>
			<?php echo $strWidth;?>: <input size="5" type="text" name="sqlwidth" value="<?php if (isset($type) && $type == "mysql") echo $row["width"];?>">
			&nbsp;&nbsp;&nbsp;
			<?php echo $strHeight;?>: <input size="5" type="text" name="sqlheight" value="<?php if (isset($type) && $type == "mysql") echo $row["height"];?>">
		</td>
	</tr>
	<?php }?>
	<tr><td height='20' colspan='3'>&nbsp;</td></tr>
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
</table>
<?php if ($dhtml) {?></div><?php } else {?><br><br><?php }?>
<?php }?>


<?php if ($show_web) {?>
<?php if ($dhtml) {?><div id="webForm" <?php if (isset($type) && $type != "web") echo 'style="display:none"';?>><?php }?>
<table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='#F6F6F6'>
	<?php if ($dhtml) {?>
		<tr><td height='25' colspan='3' bgcolor='#FFFFFF'><img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b><?php echo $strWebBanner;?></b></td></tr>
	<?php } else {?>
		<tr><td height='25' colspan='3' bgcolor='#FFFFFF'>
		<input type='radio' name='bannertype' value='web'<?php if ($type == "web") echo " checked";?>>
		<b><?php echo $strWebBanner;?></b></td></tr>
	<?php }?>
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>

	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strNewBannerFile;?></td>
		<td><input size="26" type="file" name="webupload" style="width:350px;">
			<input type="hidden" name="webcleanup" value="<?php if (isset($type) && $type == "web" && isset($row['banner'])) echo basename($row['banner']);?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strURL;?></td>
		<td><input size="35" type="text" name="weburl" style="width:350px;" value="<?php if (isset($type) && $type == "web") echo $row["url"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strAlt;?></td>
		<td><input size="35" type="text" name="webalt" style="width:350px;" value="<?php if (isset($type) && $type == "web") echo $row["alt"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strStatusText;?></td>
		<td><input size="35" type="text" name="webstatus" style="width:350px;" value="<?php if (isset($type) && $type == "web") echo $row["status"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strTextBelow;?></td>
		<td><input size="35" type="text" name="webbannertext" style="width:350px;" value="<?php if (isset($type) && $type == "web") echo $row["bannertext"];?>"></td>
	</tr>
	<?php if (isset($bannerID) && $bannerID != '') {?>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>	
		<td width='200'><?php echo $strSize;?></td>
		<td>
			<?php echo $strWidth;?>: <input size="5" type="text" name="webwidth" value="<?php if (isset($type) && $type == "web") echo $row["width"];?>">
			&nbsp;&nbsp;&nbsp;
			<?php echo $strHeight;?>: <input size="5" type="text" name="webheight" value="<?php if (isset($type) && $type == "web") echo $row["height"];?>">
		</td>
	</tr>
	<?php }?>
	<tr><td height='20' colspan='3'>&nbsp;</td></tr>
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
</table>
<?php if ($dhtml) {?></div><?php } else {?><br><br><?php }?>
<?php }?>


<?php if ($show_url) {?>
<?php if ($dhtml) {?><div id="urlForm" <?php if (!isset($type) || $type != "url") echo 'style="display:none"';?>><?php }?>
<table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='#F6F6F6'>
	<?php if ($dhtml) {?>
		<tr><td height='25' colspan='3' bgcolor='#FFFFFF'><img src='images/icon-banner-url.gif' align='absmiddle'>&nbsp;<b><?php echo $strURLBanner;?></b></td></tr>
	<?php } else {?>
		<tr><td height='25' colspan='3' bgcolor='#FFFFFF'>
		<input type='radio' name='bannertype' value='url'<?php if ($type == "url") echo " checked";?>>
		<b><?php echo $strURLBanner;?></b></td></tr>
	<?php }?>
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>

	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strNewBannerURL;?></td>
		<td><input size="35" type="text" name="urlbanner" style="width:350px;" value="<?php if (isset($type) && $type == "url") echo $row["banner"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strURL;?></td>
		<td><input size="35" type="text" name="urlurl" style="width:350px;" value="<?php if (isset($type) && $type == "url") echo $row["url"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strAlt;?></td>
		<td><input size="35" type="text" name="urlalt" style="width:350px;" value="<?php if (isset($type) && $type == "url") echo $row["alt"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strStatusText;?></td>
		<td><input size="35" type="text" name="urlstatus" style="width:350px;" value="<?php if (isset($type) && $type == "url") echo $row["status"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strTextBelow;?></td>
		<td><input size="35" type="text" name="urlbannertext" style="width:350px;" value="<?php if (isset($type) && $type == "url") echo $row["bannertext"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>	
		<td width='200'><?php echo $strSize;?></td>
		<td>
			<?php echo $strWidth;?>: <input size="5" type="text" name="urlwidth" value="<?php if (isset($type) && $type == "url") echo $row["width"];?>">
			&nbsp;&nbsp;&nbsp;
			<?php echo $strHeight;?>: <input size="5" type="text" name="urlheight" value="<?php if (isset($type) && $type == "url") echo $row["height"];?>">
		</td>
	</tr>

	<tr><td height='20' colspan='3'>&nbsp;</td></tr>
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
</table>
<?php if($dhtml) {?></div><?php } else {?><br><br><?php }?>
<?php }?>


<?php if ($show_html) {?>
<?php if ($dhtml) {?><div id="htmlForm" <?php if (!isset($type) || $type != "html") echo 'style="display:none"';?>><?php }?>
<table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='#F6F6F6'>
	<?php if ($dhtml) {?>
		<tr><td height='25' colspan='3' bgcolor='#FFFFFF'><img src='images/icon-banner-html.gif' align='absmiddle'>&nbsp;<b><?php echo $strHTMLBanner;?></b></td></tr>
	<?php } else {?>
		<tr><td height='25' colspan='3' bgcolor='#FFFFFF'>
		<input type='radio' name='bannertype' value='html'<?php if ($type == "html") echo " checked";?>>
		<b><?php echo $strHTMLBanner;?></b></td></tr>
	<?php }?>
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
	
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200' valign='top'><?php echo $strHTML;?></td>
		<td><textarea cols="35" rows="8" name="htmlbanner" style="width:350px;"><?php if (isset($type) && $type == "html") echo stripslashes($row["banner"]);?></textarea></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200' valign='top'>&nbsp;</td>
		<td><input type='checkbox' name='htmlauto' value='true'<?php echo (!isset($row["autohtml"]) || $row["autohtml"] == 'true') ? ' checked' : ''; ?>> <?php echo $strAutoChangeHTML; ?></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>	
		<td width='200'><?php echo $strURL;?></td>
    	<td><input size="35" type="text" name="htmlurl" style="width:350px;" value="<?php if (isset($type) && $type == "html") echo $row["url"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>	
		<td width='200'><?php echo $strSize;?></td>
		<td>
			<?php echo $strWidth;?>: <input size="5" type="text" name="htmlwidth" value="<?php if (isset($type) && $type == "html") echo $row["width"];?>">
			&nbsp;&nbsp;&nbsp;
			<?php echo $strHeight;?>: <input size="5" type="text" name="htmlheight" value="<?php if (isset($type) && $type == "html") echo $row["height"];?>">
		</td>
	</tr>

	<tr><td height='20' colspan='3'>&nbsp;</td></tr>
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
</table>
<?php if ($dhtml) {?></div><?php } else {?><br><br><?php }?>
<?php }?>


<table border='0' width='100%' cellpadding='0' cellspacing='0'>
<?php if (phpAds_isUser(phpAds_Admin)) {?>
<?php if (!$dhtml) {?>
	<tr><td height='25' colspan='3' bgcolor='#FFFFFF'><b><?php echo $strGeneralSettings;?></b></td></tr>
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
<?php }?>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
	<tr>
		<td width='30'>&nbsp;</td>	
		<td width='200'><?php echo $strKeyword;?></td>
    	<td><input size="35" type="text" name="keyword" style="width:350px;" value="<?php if(isset($row["keyword"]))echo $row["keyword"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>	
		<td width='200'><?php echo $strDescription;?></td>
    	<td><input size="35" type="text" name="description" style="width:350px;" value="<?php if(isset($row["description"]))echo $row["description"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>	
		<td width='200'><?php echo $strWeight;?></td>
    	<td><input size="6" type="text" name="weight" value="<?php if(isset($row["weight"])){echo $row["weight"];}else{print "1";}?>"></td>
	</tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	
</table>
<?php }?>
<br><br>

<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr>
		<td height='35' colspan='3'><input type="submit" name="submit" value="<?php echo $strSubmit;?>"></td>
	</tr>
</table>
</form>

	
<br><br>
<br><br>	

	
<?php

/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>

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


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Client);



/*********************************************************/
/* Client interface security                             */
/*********************************************************/

if (phpAds_isUser(phpAds_Client))
{
	if (!phpAds_isAllowed(phpAds_ModifyInfo))
	{
		phpAds_PageHeader("2");
		php_die ($strAccessDenied, $strNotAdmin);
	}

	$clientID = phpAds_clientID();
}



/*********************************************************/
/* Process submitted form                                */
/*********************************************************/

if (isset($submit))
{
	if (phpAds_isUser(phpAds_Admin))
	{
		$error = false;
		$errormessage ='';
		
		$message = $strClientModified;
		
		
		if (isset($clientusername) && $clientusername != '')
		{
			if ($clientID == '')
			{
				$res = @db_query("SELECT
								 	*
							 	  FROM
								 	$phpAds_tbl_clients
								  WHERE
								 	clientusername = '$clientusername'
								") or mysql_die(); 
				
				if (@mysql_num_rows($res) > 0)
				{
					$error = true;
					$errormessage = 'duplicateclientname';
					
					$clientusername = '';
					$clientpassword = '';
				}
			}
			else
			{
				$res = @db_query("SELECT
								 	*
							 	  FROM
								 	$phpAds_tbl_clients
								  WHERE
								 	clientusername = '$clientusername' AND
									clientID != '$clientID'
								") or mysql_die(); 
				
				if (@mysql_num_rows($res) > 0)
				{
					$error = true;
					$errormessage = 'duplicateclientname';
					
					$clientusername = '';
					$clientpassword = '';
				}
			}
		}
		
		
		if (empty($clientID))
		{
			$clientID = "null";
			$message = $strClientAdded;
		}
		
		$permissions = 0;
		if (isset($clientpermissions) && is_array($clientpermissions))
		{
			for ($i=0;$i<sizeof($clientpermissions);$i++)
			{
				$permissions += $clientpermissions[$i];
			}
		}
		
		if (!isset($clientreport)) $clientreport = false;
		
		if ($clientreportlastdate == '' || $clientreportlastdate == '0000-00-00' || $clientreportprevious != $clientreport)
		{
			// Set last date to today when
			// Reporting is turned on today
			// Last date is unknown
			$clientreportlastdate = date ("Y-m-d");
		}
		
		$query = "
			REPLACE INTO
				$phpAds_tbl_clients(clientID,
				clientname,
				contact,
				email,
				clientusername,
				clientpassword,
				permissions,
				language,
				report,
				reportinterval,
				reportlastdate,
				reportdeactivate)
			VALUES
				('$clientID',
				'$clientname',
				'$contact',
				'$email',
				'$clientusername',
				'$clientpassword',
				$permissions,
				'$clientlanguage',
				'$clientreport',
				'$clientreportinterval',
				'$clientreportlastdate',
				'$clientreportdeactivate')";
		
		$res = db_query($query) or mysql_die();  
		
		
		if ($error == false)
		{
			if ($clientID == "null")
			{
				$clientID = @mysql_insert_id ($phpAds_db_link);
				Header("Location: campaign-edit.php?clientID=$clientID");
				exit;
			}
			else
			{
				Header("Location: client-index.php?message=".urlencode($message));
				exit;
			}
		}
		else
		{
			if ($clientID == "null")
				$clientID = @mysql_insert_id ($phpAds_db_link);
			
			Header("Location: client-edit.php?clientID=$clientID&errormessage=".urlencode($errormessage));
			exit;
		}
	}
	
	if (phpAds_isUser(phpAds_Client))
	{
		if ($clientreportlastdate == '' || $clientreportlastdate == '0000-00-00' || $clientreportprevious != $clientreport)
		{
			// Set last date to today when
			// Reporting is turned on today
			// Last date is unknown
			$clientreportlastdate = date ("Y-m-d");
		}
		
		$message = $strClientModified;
		$res = db_query("
			UPDATE 
				$phpAds_tbl_clients
			SET
				clientname = '$clientname',
				contact = '$contact',
				email = '$email',
				clientpassword = '$clientpassword',
				language = '$clientlanguage',
				report = '$clientreport',
				reportinterval = '$clientreportinterval',
				reportlastdate = '$clientreportlastdate',
				reportdeactivate = '$clientreportdeactivate'
			WHERE
				clientID = '$clientID'")
			or mysql_die();  
		
		$Session['language'] = $clientlanguage;
		phpAds_SessionDataStore();
		
		Header("Location: index.php?message=".urlencode($message));
		exit;
	}
}




/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if ($clientID != "")
{
	if (phpAds_isUser(phpAds_Admin))
	{
		$extra = '';
		
		$res = db_query("
			SELECT
				*
			FROM
				$phpAds_tbl_clients
			WHERE
				parent = 0  
			") or mysql_die();
		
		$extra = "";
		while ($row = mysql_fetch_array($res))
		{
			if ($clientID == $row['clientID'])
				$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
			else
				$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
			
			$extra .= "<a href=client-edit.php?clientID=". $row['clientID'].">".phpAds_buildClientName ($row['clientID'], $row['clientname'])."</a>";
			$extra .= "<br>"; 
		}
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		
		phpAds_PageHeader("4.1.2", $extra);
		phpAds_ShowSections(array("4.1.2"));
	}
	else
	{
		phpAds_PageHeader("2");
	}
	
	$res = db_query("
		SELECT
			*
		FROM
			$phpAds_tbl_clients
		WHERE
			clientID = $clientID
		") or mysql_die();
	$row = mysql_fetch_array($res);
	
	if (!isset($row["permissions"])) $row["permissions"] = "";
}
else
{
	phpAds_PageHeader("4.1.1");   
	phpAds_ShowSections(array("4.1.1"));
	
	$row["permissions"] 		= "";
	$row["reportdeactivate"] 	= 'true';
	$row["report"] 				= 'true';
	$row["reportinterval"] 		= 7;
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (phpAds_isUser(phpAds_Admin))
	echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($clientID)."</b><br>";

echo "<br><br>";
echo "<br><br>";
echo "<br><br>";

?>

<form name="clientform" method="post" action="<?php echo basename($PHP_SELF);?>">
<input type="hidden" name="clientID" value="<?php if(isset($clientID)) echo $clientID;?>">

<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='3'><b><?php echo $strBasicInformation;?></b></td></tr>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>

	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strClientName;?></td>
		<td><input type="text" name="clientname" size='35' style="width:350px;" value="<?php if(isset($row["clientname"]))echo $row["clientname"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strContact;?></td>
		<td><input type="text" name="contact" size='35' style="width:350px;" value="<?php if(isset($row["contact"]))echo $row["contact"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strEMail;?></td>
		<td><input type="text" name="email" size='35' style="width:350px;" value="<?php if(isset($row["email"]))echo $row["email"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $GLOBALS['strLanguage']; ?></td>	
		<td>
			<select name="clientlanguage">
		<?php
		echo "<option value='' SELECTED>".$GLOBALS['strDefault']."</option>\n"; 
		
		$langdir = opendir ("../language/");
		while ($langfile = readdir ($langdir))
		{
			if (ereg ("^([a-zA-Z0-9\-]*)\.inc\.php$", $langfile, $matches))
			{
				$languages[] = $matches[1];
			}
		}
		closedir ($langdir);
		
		sort ($languages);
		for ($i=0;$i<sizeof($languages);$i++)
		{
			if ($row['language'] == $languages[$i])
				echo "<option value='".$languages[$i]."' SELECTED>".ucfirst($languages[$i])."</option>\n";
			else
				echo "<option value='".$languages[$i]."'>".ucfirst($languages[$i])."</option>\n";
		}
		?>
			</select>
		</td>
	</tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>

	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
</table>


<br><br>
<br><br>

<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='3'><b><?php echo $strMailSubject;?></b></td></tr>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>

	<input type='hidden' name='clientreportlastdate' value='<?php if(isset($row["reportlastdate"]))echo $row["reportlastdate"];?>'>
	<input type='hidden' name='clientreportprevious' value='<?php if(isset($row["report"]))echo $row["report"];?>'>
	
	<tr>
		<td width='30'>&nbsp;</td>
		<td colspan='2'>
			<input type="checkbox" name="clientreportdeactivate" value="true"<?php echo ($row["reportdeactivate"]) ? " CHECKED" : ""; ?>>
			<?php echo $strSendDeactivationWarning;?>
		</td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td colspan='2'>
			<input type="checkbox" name="clientreport" value="true"<?php echo ($row["report"]) ? " CHECKED" : ""; ?>>
			<?php echo $strSendAdvertisingReport;?>
		</td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strNoDaysBetweenReports;?></td>
		<td><input type="text" name="clientreportinterval" size='25' value="<?php if(isset($row["reportinterval"]))echo $row["reportinterval"];?>"></td>
	</tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
</table>


<br><br>
<br><br>

<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='3'><b><?php echo $strLoginInformation;?></b></td></tr>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>

	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
			<?php
				if (isset($errormessage) && $errormessage == 'duplicateclientname')
				{
					?>
	<tr><td width='30'>&nbsp;</td>
	    <td height='10' colspan='2'><img src='images/error.gif' align='absmiddle'>&nbsp;<font color='#AA0000'><b><?php echo $strDuplicateClientName; ?></b></font></td></tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>	
					<?php
				}
			?>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $strUsername;?></td>
		<?php
		if (phpAds_isUser(phpAds_Admin))
		{
			?>
			<td width='370'><input type="text" name="clientusername" size='25' value="<?php if(isset($row["clientusername"])) echo $row["clientusername"];?>">
			<?php
		}
		else 
		{
			?>
			<td width='370'><?php if(isset($row["clientusername"]))echo $row["clientusername"];?>
			<?php
		}
		?>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strPassword;?></td>
		<td width='370'><input type="text" name="clientpassword" size='25' value="<?php if(isset($row["clientpassword"])) echo $row["clientpassword"];?>">
	</tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
		<?php
		if (phpAds_isUser(phpAds_Admin))
		{
			?>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>

	<tr>
		<td width='30'>&nbsp;</td>
		<td colspan='2'>
			<input type="checkbox" name="clientpermissions[]" value="<?php echo phpAds_ModifyInfo; ?>"<?php echo (phpAds_ModifyInfo & $row["permissions"]) ? " CHECKED" : ""; ?>>
			<?php echo $GLOBALS['strAllowClientModifyInfo']; ?>
		</td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td colspan='2'>
			<input type="checkbox" name="clientpermissions[]" value="<?php echo phpAds_ModifyBanner; ?>"<?php echo (phpAds_ModifyBanner & $row["permissions"]) ? " CHECKED" : ""; ?>>
			<?php echo $GLOBALS['strAllowClientModifyBanner']; ?>
		</td>
	</tr>	
	<tr>
		<td width='30'>&nbsp;</td>
		<td colspan='2'>
			<input type="checkbox" name="clientpermissions[]" value="<?php echo phpAds_DisableBanner; ?>"<?php echo (phpAds_DisableBanner & $row["permissions"]) ? " CHECKED" : ""; ?>>
			<?php echo $GLOBALS['strAllowClientDisableBanner']; ?>
		</td>
	</tr>	
	<tr>
		<td width='30'>&nbsp;</td>
		<td colspan='2'>
			<input type="checkbox" name="clientpermissions[]" value="<?php echo phpAds_ActivateBanner; ?>"<?php echo (phpAds_ActivateBanner & $row["permissions"]) ? " CHECKED" : ""; ?>>
			<?php echo $GLOBALS['strAllowClientActivateBanner']; ?>
		</td>
	</tr>	
	<!-- Still working on this (Niels)
	<tr>
		<td width='30'>&nbsp;</td>
		<td colspan='2'>
			<input type="checkbox" name="clientpermissions[]" value="<?php echo phpAds_AddBanner; ?>"<?php echo (phpAds_AddBanner & $row["permissions"]) ? " CHECKED" : ""; ?>>
			<?php echo $GLOBALS['strAllowClientAddBanner']; ?>
		</td>
	</tr>	
	-->
			<?php
		}
		?>
	<tr><td height='10' colspan='2'>&nbsp;</td></tr>
</table>
		
<br><br>
		
<input type="submit" name="submit" value="<?php echo $strSaveChanges;?>">
</form>



<?php

/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>

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
require ("lib-languages.inc.php");


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
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}

	$clientid = phpAds_getUserID();
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
			$res = phpAds_dbQuery("
				SELECT
					*
				FROM
					".$phpAds_config['tbl_affiliates']."
				WHERE
					username = '$clientusername'
			") or phpAds_sqlDie();
			
			$duplicateaffiliate = (phpAds_dbNumRows($res) > 0);
			$duplicateadmin  = ($phpAds_config['admin'] == $clientusername);
			
			if ($clientid == '')
			{
				$res = phpAds_dbQuery("
					SELECT
						*
					FROM
						".$phpAds_config['tbl_clients']."
					WHERE
						clientusername = '$clientusername'
				") or phpAds_sqlDie(); 
				
				if (phpAds_dbNumRows($res) > 0 || $duplicateaffiliate || $duplicateadmin)
				{
					$error = true;
					$errormessage = 'duplicateclientname';
					
					$clientusername = '';
					$clientpassword = '';
				}
			}
			else
			{
				$res = phpAds_dbQuery("
					SELECT
						*
					FROM
						".$phpAds_config['tbl_clients']."
					WHERE
						clientusername = '$clientusername' AND
						clientid != '$clientid'
					") or phpAds_sqlDie(); 
				
				if (phpAds_dbNumRows($res) > 0 || $duplicateaffiliate || $duplicateadmin)
				{
					$error = true;
					$errormessage = 'duplicateclientname';
					
					$clientusername = '';
					$clientpassword = '';
				}
			}
		}
		
		
		if (empty($clientid))
		{
			$clientid = "null";
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
				".$phpAds_config['tbl_clients']."
			   (clientid,
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
				('$clientid',
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
		
		$res = phpAds_dbQuery($query) or phpAds_sqlDie();  
		
		
		if ($error == false)
		{
			if ($clientid == "null")
			{
				$clientid = phpAds_dbInsertID();
				Header("Location: campaign-edit.php?clientid=$clientid");
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
			if ($clientid == "null")
				$clientid = phpAds_dbInsertID();
			
			Header("Location: client-edit.php?clientid=$clientid&errormessage=".urlencode($errormessage));
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
		$res = phpAds_dbQuery("
			UPDATE 
				".$phpAds_config['tbl_clients']."
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
				clientid = '$clientid'")
			or phpAds_sqlDie();  
		
		$Session['language'] = $clientlanguage;
		phpAds_SessionDataStore();
		
		Header("Location: index.php?message=".urlencode($message));
		exit;
	}
}




/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if ($clientid != "")
{
	if (phpAds_isUser(phpAds_Admin))
	{
		$extra = '';
		
		$res = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$phpAds_config['tbl_clients']."
			WHERE
				parent = 0  
			") or phpAds_sqlDie();
		
		$extra = "";
		while ($row = phpAds_dbFetchArray($res))
		{
			if ($clientid == $row['clientid'])
				$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
			else
				$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
			
			$extra .= "<a href=client-edit.php?clientid=". $row['clientid'].">".phpAds_buildClientName ($row['clientid'], $row['clientname'])."</a>";
			$extra .= "<br>"; 
		}
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		
		phpAds_PageHeader("4.1.2", $extra);
			echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($clientid)."</b><br><br><br>";
			phpAds_ShowSections(array("4.1.2"));
	}
	else
	{
		phpAds_PageHeader("2");
	}
	
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_clients']."
		WHERE
			clientid = $clientid
		") or phpAds_sqlDie();
	$row = phpAds_dbFetchArray($res);
	
	if (!isset($row["permissions"])) $row["permissions"] = "";
}
else
{
	phpAds_PageHeader("4.1.1");   
		echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($clientid)."</b><br><br><br>";
		phpAds_ShowSections(array("4.1.1"));
	
	$row["permissions"] 		= "";
	$row["reportdeactivate"] 	= 't';
	$row["report"] 				= 't';
	$row["reportinterval"] 		= 7;
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

echo "<br><br>";

?>


<script language="JavaScript">
<!--
	function validate_form_client()
	{
		return validate_form('clientname','strClientName','R',
							 'email','strEMail','NisEmail',
							 'clientreportinterval', 'strNoDaysBetweenReports', 'NisNum');
	}
//-->
</script>

<form name="clientform" method="post" action="<?php echo basename($PHP_SELF);?>" onSubmit="return validate_form_client();">
<input type="hidden" name="clientid" value="<?php if(isset($clientid)) echo $clientid;?>">

<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='3'><b><?php echo $strBasicInformation;?></b></td></tr>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>

	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strClientName;?></td>
		<td><input class='flat' type="text" name="clientname" size='35' style="width:350px;" value="<?php if(isset($row["clientname"]))echo $row["clientname"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strContact;?></td>
		<td><input class='flat' type="text" name="contact" size='35' style="width:350px;" value="<?php if(isset($row["contact"]))echo $row["contact"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strEMail;?></td>
		<td><input class='flat' type="text" name="email" size='35' style="width:350px;" value="<?php if(isset($row["email"]))echo $row["email"];?>"></td>
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
		
		$languages = phpAds_AvailableLanguages();
		
		while (list($k, $v) = each($languages))
		{
			if (isset($row['language']) && $row['language'] == $k)
				echo "<option value='$k' selected>$v</option>\n";
			else
				echo "<option value='$k'>$v</option>\n";
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
			<input type="checkbox" name="clientreportdeactivate" value="t"<?php echo ($row["reportdeactivate"]) ? " CHECKED" : ""; ?>>
			<?php echo $strSendDeactivationWarning;?>
		</td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td colspan='2'>
			<input type="checkbox" name="clientreport" value="t"<?php echo ($row["report"]) ? " CHECKED" : ""; ?>>
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
		<td><input class='flat' type="text" name="clientreportinterval" size='25' value="<?php if(isset($row["reportinterval"]))echo $row["reportinterval"];?>"></td>
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
			<td width='370'><input class='flat' type="text" name="clientusername" size='25' value="<?php if(isset($row["clientusername"])) echo $row["clientusername"];?>">
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
		<td width='370'><input class='flat' type="password" name="clientpassword" size='25' value="<?php if(isset($row["clientpassword"])) echo $row["clientpassword"];?>">
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

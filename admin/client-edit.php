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
			$clientid = "null";
		
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
				Header("Location: client-campaigns.php?clientid=$clientid");
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
		
		Header("Location: index.php");
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
		$res = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$phpAds_config['tbl_clients']."
			WHERE
				parent = 0  
			") or phpAds_sqlDie();
		
		while ($row = phpAds_dbFetchArray($res))
		{
			phpAds_PageContext (
				phpAds_buildClientName ($row['clientid'], $row['clientname']),
				"client-edit.php?clientid=".$row['clientid'],
				$clientid == $row['clientid']
			);
		}
		
		phpAds_PageShortcut($strClientHistory, 'stats-client-history.php?clientid='.$clientid, 'images/icon-statistics.gif');
		
		phpAds_PageHeader("4.1.2");
			echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($clientid)."</b><br><br><br>";
			phpAds_ShowSections(array("4.1.2", "4.1.3"));
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
	
	$row["clientname"]			= $strUntitled;
	$row["contact"]				= '';
	$row["email"]				= '';
	
	$row["reportdeactivate"] 	= 't';
	$row["report"] 				= 't';
	$row["reportinterval"] 		= 7;
	
	$row["clientusername"]		= '';
	$row["clientpassword"]		= '';
	$row["permissions"] 		= '';
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

echo "<br><br>";

echo "<form name='clientform' method='post' action='client-edit.php' onSubmit='return phpAds_formCheck(this);'>";
echo "<input type='hidden' name='clientid' value='".(isset($clientid) ? $clientid : '')."'>";




// Header
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strBasicInformation."</b></td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

// Clientname
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strName."</td><td>";
echo "<input onBlur='phpAds_formUpdate(this);' class='flat' type='text' name='clientname' size='25' value='".phpAds_htmlQuotes($row['clientname'])."' style='width: 350px;'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

// Contact
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strContact."</td><td>";
echo "<input onBlur='phpAds_formUpdate(this);' class='flat' type='text' name='contact' size='25' value='".phpAds_htmlQuotes($row['contact'])."' style='width: 350px;'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

// Email
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strEMail."</td><td>";
echo "<input onBlur='phpAds_formUpdate(this);' class='flat' type='text' name='email' size='25' value='".phpAds_htmlQuotes($row['email'])."' style='width: 350px;'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

// Language
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strLanguage."</td><td>";
echo "<select name='clientlanguage'>";
echo "<option value='' SELECTED>".$strDefault."</option>"; 

$languages = phpAds_AvailableLanguages();
while (list($k, $v) = each($languages))
{
	if (isset($row['language']) && $row['language'] == $k)
		echo "<option value='$k' selected>$v</option>";
	else
		echo "<option value='$k'>$v</option>";
}

echo "</select></td></tr><tr><td height='10' colspan='3'>&nbsp;</td></tr>";

// Footer
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";




// Spacer
echo "<br><br>";
echo "<br><br>";

// Header
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strMailSubject."</b></td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

// Reports
echo "<input type='hidden' name='clientreportlastdate' value='".(isset($row['reportlastdate']) ? $row['reportlastdate'] : '')."'>";
echo "<input type='hidden' name='clientreportprevious' value='".(isset($row['report']) ? $row['report'] : '')."'>";

echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
echo "<input type='checkbox' name='clientreportdeactivate' value='t'".($row['reportdeactivate'] ? ' CHECKED' : '').">&nbsp;";
echo $strSendDeactivationWarning;
echo "</td></tr>";

// Interval
echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
echo "<input type='checkbox' name='clientreport' value='t'".($row['report'] ? ' CHECKED' : '').">&nbsp;";
echo $strSendAdvertisingReport;
echo "</td></tr>";

echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strNoDaysBetweenReports."</td><td>";
echo "<input onBlur='phpAds_formUpdate(this);' class='flat' type='text' name='clientreportinterval' size='25' value='".$row['reportinterval']."'>";
echo "</td></tr><tr><td height='10' colspan='3'>&nbsp;</td></tr>";

// Footer
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";




// Spacer
echo "<br><br>";
echo "<br><br>";

// Header
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strLoginInformation."</b></td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

if (isset($errormessage) && $errormessage == 'duplicateclientname')
{
	echo "<tr><td width='30'>&nbsp;</td>";
    echo "<td height='10' colspan='2'><img src='images/error.gif' align='absmiddle'>&nbsp;";
	echo "<font color='#AA0000'><b>".$strDuplicateClientName."</b></font></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
}

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strUsername."</td>";

if (phpAds_isUser(phpAds_Admin))
	echo "<td><input onBlur='phpAds_formUpdate(this);' class='flat' type='text' name='clientusername' size='25' value='".phpAds_htmlQuotes($row['clientusername'])."'></td>";
else 
	echo "<td>".(isset($row['clientusername']) ? $row['clientusername'] : '')."</td>";

echo "</tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strPassword."</td>";
echo "<td><input class='flat' type='password' name='clientpassword' size='25' value='".phpAds_htmlQuotes($row['clientpassword'])."'></td>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

if (phpAds_isUser(phpAds_Admin))
{
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
	echo "<input type='checkbox' name='clientpermissions[]' value='".phpAds_ModifyInfo."'".(phpAds_ModifyInfo & $row['permissions'] ? ' CHECKED' : '').">&nbsp;";
	echo $strAllowClientModifyInfo;
	echo "</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
	echo "<input type='checkbox' name='clientpermissions[]' value='".phpAds_ModifyBanner."'".(phpAds_ModifyBanner & $row['permissions'] ? ' CHECKED' : '').">&nbsp;";
	echo $strAllowClientModifyBanner;
	echo "</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
	echo "<input type='checkbox' name='clientpermissions[]' value='".phpAds_DisableBanner."'".(phpAds_DisableBanner & $row['permissions'] ? ' CHECKED' : '').">&nbsp;";
	echo $strAllowClientDisableBanner;
	echo "</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
	echo "<input type='checkbox' name='clientpermissions[]' value='".phpAds_ActivateBanner."'".(phpAds_ActivateBanner & $row['permissions'] ? ' CHECKED' : '').">&nbsp;";
	echo $strAllowClientActivateBanner;
	echo "</td></tr>";
}

echo "<tr><td height='10' colspan='2'>&nbsp;</td></tr>";
echo "</table>";

echo "<br><br>";
echo "<input type='submit' name='submit' value='".(isset($clientid) && $clientid != '' ? $strSaveChanges : ' Next > ')."'>";
echo "</form>";



/*********************************************************/
/* Form requirements                                     */
/*********************************************************/

// Get unique clientname
$unique_names = array();

$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_clients']." WHERE parent = 0 AND clientid != '".$clientid."'");
while ($row = phpAds_dbFetchArray($res))
	$unique_names[] = $row['clientname'];


// Get unique username
$unique_users = array($phpAds_config['admin']);

$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_clients']." WHERE clientusername != '' AND parent = 0 AND clientid != '".$clientid."'");
while ($row = phpAds_dbFetchArray($res))
	$unique_users[] = $row['clientusername'];

$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_affiliates']." WHERE username != ''");
while ($row = phpAds_dbFetchArray($res))
	$unique_users[] = $row['username'];

?>

<script language='JavaScript'>
<!--
	phpAds_formSetRequirements('clientname', '<?php echo $strName; ?>', true, 'unique');
	phpAds_formSetRequirements('contact', '<?php echo $strContact; ?>', true);
	phpAds_formSetRequirements('email', '<?php echo $strEMail; ?>', true, 'email');
	phpAds_formSetRequirements('clientreportinterval', '<?php echo $strNoDaysBetweenReports; ?>', true, 'number+');
	phpAds_formSetRequirements('clientusername', '<?php echo $strUsername; ?>', false, 'unique');
	
	phpAds_formSetUnique('clientname', '|<?php echo addslashes(implode('|', $unique_names)); ?>|');
	phpAds_formSetUnique('clientusername', '|<?php echo addslashes(implode('|', $unique_users)); ?>|');
//-->
</script>

<?php



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>

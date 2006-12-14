<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2006 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-statistics.inc.php");
require ("lib-languages.inc.php");


// Register input variables
phpAds_registerGlobal ('errormessage', 'clientname', 'contact', 'email', 'clientlanguage', 'clientreportlastdate', 
					   'clientreportprevious', 'clientreportdeactivate', 'clientreport', 'clientreportinterval', 
					   'clientusername', 'clientpassword', 'clientpermissions', 'pw', 'pw2', 'pwold', 'submit');


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
	$errormessage = array();
	
	
	// Get previous values
	if (isset($clientid))
	{
		$res = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$phpAds_config['tbl_clients']."
			WHERE
				clientid = '".$clientid."'
			") or phpAds_sqlDie();
		
		if (phpAds_dbNumRows($res))
		{
			$client = phpAds_dbFetchArray($res);
		}
	}
	
	
	// Name
	if (phpAds_isUser(phpAds_Admin))
		$client['clientname'] = trim($clientname);
	
	// Default fields
	$client['contact'] 	 = trim($contact);
	$client['email'] 	 = trim($email);
	$client['language']   = trim($clientlanguage);
	
	
	// Reports
	$client['report'] = isset($clientreport) ? 't' : 'f';
	$client['reportdeactivate'] = isset($clientreportdeactivate) ? 't' : 'f';
	$client['reportinterval'] = (int)$clientreportinterval;
	
	if ($clientreportlastdate == '' || $clientreportlastdate == '0000-00-00' || 
		$clientreportprevious != $client['report'])
	{
		$client['reportlastdate'] = date ("Y-m-d");
	}
	
	
	
	if (phpAds_isUser(phpAds_Admin))
	{
		// Password
		if (isset($clientpassword))
		{
			if ($clientpassword == '')
				$client['clientpassword'] = '';
			elseif ($clientpassword != '********')
				$client['clientpassword'] = md5($clientpassword);
		}
		
		
		// Username
		if (isset($clientusername) && $clientusername != '')
		{
			$res = phpAds_dbQuery("
				SELECT
					*
				FROM
					".$phpAds_config['tbl_affiliates']."
				WHERE
					LOWER(username) = '".strtolower($clientusername)."'
			") or phpAds_sqlDie();
			
			$duplicateaffiliate = (phpAds_dbNumRows($res) > 0);
			$duplicateadmin  = (strtolower($phpAds_config['admin']) == strtolower($clientusername));
			
			if ($clientid == '')
			{
				$res = phpAds_dbQuery("
					SELECT
						*
					FROM
						".$phpAds_config['tbl_clients']."
					WHERE
						LOWER(clientusername) = '".strtolower($clientusername)."'
				") or phpAds_sqlDie(); 
				
				if (phpAds_dbNumRows($res) > 0 || $duplicateaffiliate || $duplicateadmin)
					$errormessage[] = $strDuplicateClientName;
			}
			else
			{
				$res = phpAds_dbQuery("
					SELECT
						*
					FROM
						".$phpAds_config['tbl_clients']."
					WHERE
						LOWER(clientusername) = '".strtolower($clientusername)."' AND
						clientid != '$clientid'
					") or phpAds_sqlDie(); 
				
				if (phpAds_dbNumRows($res) > 0 || $duplicateaffiliate || $duplicateadmin)
					$errormessage[] = $strDuplicateClientName;
			}
			
			if (count($errormessage) == 0)
			{
				// Set username
				$client['clientusername'] = $clientusername;
			}
		}
		
		
		// Permissions
		$client['permissions'] = 0;
		if (isset($clientpermissions) && is_array($clientpermissions))
		{
			for ($i=0;$i<sizeof($clientpermissions);$i++)
			{
				$client['permissions'] += $clientpermissions[$i];
			}
		}
	}
	else
	{
		// Password
		if (isset($pwold) && strlen($pwold) ||
			isset($pw) && strlen($pw) ||
			isset($pw2) && strlen($pw2))
		{
			if (md5($pwold) != $client['clientpassword'])
				$errormessage[] = $strPasswordWrong;
			elseif (!strlen($pw) || strstr("\\", $pw))
				$errormessage[] = $strInvalidPassword;
			elseif (strcmp($pw, $pw2))
				$errormessage[] = $strNotSamePasswords;
			else
				$client['clientpassword'] = md5($pw);
		}
	}
	
	
	/*
	echo "<pre>";
	var_dump ($final);
	echo "</pre><hr>";
	*/
	
	
	if (count($errormessage) == 0)
	{
		if (!isset($clientid) || $clientid == '')
		{
			$keys = array();
			$values = array();
			
			while (list($key, $value) = each($client))
			{
				$keys[] = $key;
				$values[] = $value;
			}
			
			$query  = "INSERT INTO ".$phpAds_config['tbl_clients']." (";
			$query .= implode(", ", $keys);
			$query .= ") VALUES ('";
			$query .= implode("', '", $values);
			$query .= "')";
			
			// Insert
			phpAds_dbQuery($query) 
				or phpAds_sqlDie();
			
			$clientid = phpAds_dbInsertID();
			
			// Go to next page
			header ("Location: campaign-edit.php?clientid=".$clientid);
		}
		else
		{
			$pairs = array();
			
			while (list($key, $value) = each($client))
				$pairs[] = " ".$key."='".$value."'";
			
			$query  = "UPDATE ".$phpAds_config['tbl_clients']." SET ";
			$query .= trim(implode(",", $pairs))." ";
			$query .= "WHERE clientid = ".$clientid;
			
			// Update
			phpAds_dbQuery($query) 
				or phpAds_sqlDie();
			
			// Go to next page
			if (phpAds_isUser(phpAds_Client))
			{
				// Set current session to new language
				$Session['language'] = $clientlanguage;
				phpAds_SessionDataStore();
				
				header ("Location: index.php");
			}
			else
			{
				header ("Location: client-campaigns.php?clientid=".$clientid);
			}
		}
		
		exit;
	}
	else
	{
		// If an error occured set the password back to its previous value
		$client['clientpassword'] = $password;
	}
}




/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if ($clientid != "")
{
	if (phpAds_isUser(phpAds_Admin))
	{
		if (isset($Session['prefs']['client-index.php']['listorder']))
			$navorder = $Session['prefs']['client-index.php']['listorder'];
		else
			$navorder = '';
		
		if (isset($Session['prefs']['client-index.php']['orderdirection']))
			$navdirection = $Session['prefs']['client-index.php']['orderdirection'];
		else
			$navdirection = '';
		
		
		// Get other clients
		$res = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$phpAds_config['tbl_clients']."
			WHERE
				parent = 0
			".phpAds_getListOrder ($navorder, $navdirection)."
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
	
	
	// Do not get this information if the page
	// is the result of an error message
	if (!isset($client))
	{
		$res = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$phpAds_config['tbl_clients']."
			WHERE
				clientid = '".$clientid."'
			") or phpAds_sqlDie();
		
		if (phpAds_dbNumRows($res))
		{
			$client = phpAds_dbFetchArray($res);
		}
		
		// Set password to default value
		if ($client['clientpassword'] != '')
			$client['clientpassword'] = '********';
	}
}
else
{
	phpAds_PageHeader("4.1.1");   
		echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($clientid)."</b><br><br><br>";
		phpAds_ShowSections(array("4.1.1"));
	
	// Do not set this information if the page
	// is the result of an error message
	if (!isset($client))
	{
		$client['clientname']			= $strUntitled;
		$client['contact']				= '';
		$client['email']				= '';
		
		$client['reportdeactivate'] 	= 't';
		$client['report'] 				= 't';
		$client['reportinterval'] 		= 7;
		
		$client['clientusername']		= '';
		$client['clientpassword']		= '';
		$client['permissions'] 			= 0;
	}
}

$tabindex = 1;



/*********************************************************/
/* Main code                                             */
/*********************************************************/

echo "<br><br>";
echo "<form name='clientform' method='post' action='client-edit.php' onSubmit='return phpAds_formCheck(this);'>";
echo "<input type='hidden' name='clientid' value='".(isset($clientid) && $clientid != '' ? $clientid : '')."'>";


// Header
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strBasicInformation."</b></td></tr>";
echo "<tr height='1'><td width='30'><img src='images/break.gif' height='1' width='30'></td>";
echo "<td width='200'><img src='images/break.gif' height='1' width='200'></td>";
echo "<td width='100%'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

// Clientname
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strName."</td>";

if (phpAds_isUser(phpAds_Admin))
	echo "<td><input onBlur='phpAds_formUpdate(this);' class='flat' type='text' name='clientname' size='25' value='".phpAds_htmlQuotes($client['clientname'])."' style='width: 350px;' tabindex='".($tabindex++)."'></td>";
else 
	echo "<td>".(isset($client['clientname']) ? $client['clientname'] : '')."</td>";

echo "</tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";


// Contact
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strContact."</td><td>";
echo "<input onBlur='phpAds_formUpdate(this);' class='flat' type='text' name='contact' size='25' value='".phpAds_htmlQuotes($client['contact'])."' style='width: 350px;' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

// Email
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strEMail."</td><td>";
echo "<input onBlur='phpAds_formUpdate(this);' class='flat' type='text' name='email' size='25' value='".phpAds_htmlQuotes($client['email'])."' style='width: 350px;' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

// Language
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strLanguage."</td><td>";
echo "<select name='clientlanguage' tabindex='".($tabindex++)."'>";
echo "<option value='' SELECTED>".$strDefault."</option>"; 

$languages = phpAds_AvailableLanguages();
while (list($k, $v) = each($languages))
{
	if (isset($client['language']) && $client['language'] == $k)
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
echo "<tr height='1'><td width='30'><img src='images/break.gif' height='1' width='30'></td>";
echo "<td width='200'><img src='images/break.gif' height='1' width='200'></td>";
echo "<td width='100%'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

// Reports
echo "<input type='hidden' name='clientreportlastdate' value='".(isset($client['reportlastdate']) ? $client['reportlastdate'] : '')."'>";
echo "<input type='hidden' name='clientreportprevious' value='".(isset($client['report']) ? $client['report'] : '')."'>";

echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
echo "<input type='checkbox' name='clientreportdeactivate' value='t'".($client['reportdeactivate'] == 't' ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;";
echo $strSendDeactivationWarning;
echo "</td></tr>";

// Interval
echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
echo "<input type='checkbox' name='clientreport' value='t'".($client['report'] == 't' ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;";
echo $strSendAdvertisingReport;
echo "</td></tr>";

echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strNoDaysBetweenReports."</td><td>";
echo "<input onBlur='phpAds_formUpdate(this);' class='flat' type='text' name='clientreportinterval' size='25' value='".$client['reportinterval']."' tabindex='".($tabindex++)."'>";
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
echo "<tr height='1'><td width='30'><img src='images/break.gif' height='1' width='30'></td>";
echo "<td width='200'><img src='images/break.gif' height='1' width='200'></td>";
echo "<td width='100%'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";


// Error message?
if (isset($errormessage) && count($errormessage))
{
	echo "<tr><td>&nbsp;</td><td height='10' colspan='2'>";
	echo "<table cellpadding='0' cellspacing='0' border='0'><tr><td>";
	echo "<img src='images/error.gif' align='absmiddle'>&nbsp;";
	
	while (list($k,$v) = each($errormessage))
		echo "<font color='#AA0000'><b>".$v."</b></font><br>";
	
	echo "</td></tr></table></td></tr><tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
}


echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strUsername."</td>";

if (phpAds_isUser(phpAds_Admin))
	echo "<td><input onBlur='phpAds_formUpdate(this);' class='flat' type='text' name='clientusername' size='25' value='".phpAds_htmlQuotes($client['clientusername'])."' tabindex='".($tabindex++)."'></td>";
else 
	echo "<td>".(isset($client['clientusername']) ? $client['clientusername'] : '')."</td>";

echo "</tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";


// Password
if (phpAds_isUser(phpAds_Admin))
{
	echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strPassword."</td>";
	echo "<td width='370'><input class='flat' type='password' name='clientpassword' size='25' value='".$client['clientpassword']."' tabindex='".($tabindex++)."'></td>";
	echo "</tr><tr><td height='10' colspan='3'>&nbsp;</td></tr>";
}
else
{
	echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strOldPassword."</td><td width='100%'>";
	echo "<input onBlur='phpAds_formUpdate(this);' class='flat' type='password' name='pwold' size='25' value='' tabindex='".($tabindex++)."'>";
	echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
	echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strNewPassword."</td><td width='100%'>";
	echo "<input onBlur='phpAds_formUpdate(this);' class='flat' type='password' name='pw' size='25' value='' tabindex='".($tabindex++)."'>";
	echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
	echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strRepeatPassword."</td><td width='100%'>";
	echo "<input onBlur='phpAds_formUpdate(this);' class='flat' type='password' name='pw2' size='25' value='' tabindex='".($tabindex++)."'>";
	echo "</td></tr>";
}

// Permissions
if (phpAds_isUser(phpAds_Admin))
{
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
	echo "<input type='checkbox' name='clientpermissions[]' value='".phpAds_ModifyInfo."'".(phpAds_ModifyInfo & $client['permissions'] ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;";
	echo $strAllowClientModifyInfo;
	echo "</td></tr>";
	
	/*
	  Deactivated for now because of security reasons -- Niels
	  
	  echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
	  echo "<input type='checkbox' name='clientpermissions[]' value='".phpAds_ModifyBanner."'".(phpAds_ModifyBanner & $client['permissions'] ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;";
	  echo $strAllowClientModifyBanner;
	  echo "</td></tr>";
	*/
	
	echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
	echo "<input type='checkbox' name='clientpermissions[]' value='".phpAds_DisableBanner."'".(phpAds_DisableBanner & $client['permissions'] ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;";
	echo $strAllowClientDisableBanner;
	echo "</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
	echo "<input type='checkbox' name='clientpermissions[]' value='".phpAds_ActivateBanner."'".(phpAds_ActivateBanner & $client['permissions'] ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;";
	echo $strAllowClientActivateBanner;
	echo "</td></tr>";
}

echo "<tr><td height='10' colspan='2'>&nbsp;</td></tr>";
echo "</table>";

echo "<br><br>";
echo "<input type='submit' name='submit' value='".(isset($clientid) && $clientid != '' ? $strSaveChanges : $strNext.' >')."' tabindex='".($tabindex++)."'>";
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
	phpAds_formSetRequirements('contact', '<?php echo addslashes($strContact); ?>', true);
	phpAds_formSetRequirements('email', '<?php echo addslashes($strEMail); ?>', true, 'email');
	phpAds_formSetRequirements('clientreportinterval', '<?php echo addslashes($strNoDaysBetweenReports); ?>', true, 'number+');
<?php if (phpAds_isUser(phpAds_Admin)) { ?>
	phpAds_formSetRequirements('clientname', '<?php echo addslashes($strName); ?>', true, 'unique');
	phpAds_formSetRequirements('clientusername', '<?php echo addslashes($strUsername); ?>', false, 'unique');
	
	phpAds_formSetUnique('clientname', '|<?php echo addslashes(implode('|', $unique_names)); ?>|');
	phpAds_formSetUnique('clientusername', '|<?php echo addslashes(implode('|', $unique_users)); ?>|');
<?php } ?>
//-->
</script>

<?php



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-statistics.inc.php");
require ("lib-zones.inc.php");
require ("lib-languages.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Affiliate);



/*********************************************************/
/* Affiliate interface security                          */
/*********************************************************/

if (phpAds_isUser(phpAds_Affiliate))
{
	if (phpAds_isAllowed(phpAds_ModifyInfo))
	{
		$affiliateid = phpAds_getUserID();
	}
	else
	{
		phpAds_PageHeader("1");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
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
		
		if (isset($website) && $website == 'http://')
			$website = '';
		
		if (isset($username) && $username != '')
		{
			$res = phpAds_dbQuery("
				SELECT
					*
				FROM
					".$phpAds_config['tbl_clients']."
				WHERE
					LOWER(clientusername) = '".strtolower($username)."'
			") or phpAds_sqlDie(); 
			
			$duplicateclient = (phpAds_dbNumRows($res) > 0);
			$duplicateadmin  = (strtolower($phpAds_config['admin']) == strtolower($username));
			
			if ($affiliateid == '')
			{
				$res = phpAds_dbQuery("
					SELECT
						*
					FROM
						".$phpAds_config['tbl_affiliates']."
					WHERE
						LOWER(username) = '".strtolower($username)."'
				") or phpAds_sqlDie(); 
				
				if (phpAds_dbNumRows($res) > 0 || $duplicateclient || $duplicateadmin)
				{
					$error = true;
					$errormessage = 'duplicateusername';
					
					$username = '';
					$password = '';
				}
			}
			else
			{
				$res = phpAds_dbQuery("
					SELECT
						*
					FROM
						".$phpAds_config['tbl_affiliates']."
					WHERE
						LOWER(username) = '".strtolower($username)."' AND
						affiliateid != '$affiliateid'
					") or phpAds_sqlDie(); 
				
				if (phpAds_dbNumRows($res) > 0 || $duplicateclient || $duplicateadmin)
				{
					$error = true;
					$errormessage = 'duplicateusername';
					
					$username = '';
					$password = '';
				}
			}
		}
		
		$permissions = 0;
		if (isset($affiliatepermissions) && is_array($affiliatepermissions))
		{
			for ($i=0;$i<sizeof($affiliatepermissions);$i++)
			{
				$permissions += $affiliatepermissions[$i];
			}
		}
		
		$res = phpAds_dbQuery("
			REPLACE INTO
				".$phpAds_config['tbl_affiliates']."
				(
				affiliateid,
				name,
				website,
				contact,
				email,
				language,
				username,
				password,
				permissions,
				publiczones
				)
			 VALUES (
			 	'".$affiliateid."',
				'".$name."',
				'".$website."',
				'".$contact."',
				'".$email."',
				'".$language."',
				'".$username."',
				'".$password."',
				'".$permissions."',
				'".$publiczones."'
				)
			") or phpAds_sqlDie();
		
		if ($error == false)
		{
			if (!$affiliateid)
			{
				$affiliateid = phpAds_dbInsertID();
				
				if (isset($move) && $move == 't')
				{
					// Move loose zones to this affiliate
					
					$res = phpAds_dbQuery("
						UPDATE
							".$phpAds_config['tbl_zones']."
						SET
							affiliateid = '".$affiliateid."'
						WHERE
							ISNULL(affiliateid) OR
							affiliateid = 0
					");
					
					header ("Location: affiliate-zones.php?affiliateid=".$affiliateid);
					exit;
				}
				else
				{
					header ("Location: zone-edit.php?affiliateid=".$affiliateid);
					exit;
				}
			}
			else
			{
				header ("Location: affiliate-zones.php?affiliateid=".$affiliateid);
				exit;
			}
		}
		else
		{
			if (!$affiliateid)
				$affiliateid = phpAds_dbInsertID();
			
			header ("Location: affiliate-edit.php?affiliateid=".$affiliateid."&errormessage=".urlencode($errormessage));
			exit;
		}
	}
	else
	{
		$res = phpAds_dbQuery("
			UPDATE
				".$phpAds_config['tbl_affiliates']."
			SET
				name='".$name."',
				website='".$website."',
				contact='".$contact."',
				email='".$email."',
				language='".$language."',
				password='".$password."'
			WHERE
				affiliateid=".$affiliateid."
			") or phpAds_sqlDie();
		
		$Session['language'] = $language;
		phpAds_SessionDataStore();
		
		header ("Location: affiliate-zones.php?affiliateid=".$affiliateid);
		exit;
	}
}


/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if ($affiliateid != "")
{
	if (phpAds_isUser(phpAds_Admin))
	{
		if (isset($Session['prefs']['affiliate-index.php']['listorder']))
			$navorder = $Session['prefs']['affiliate-index.php']['listorder'];
		else
			$navorder = '';
		
		if (isset($Session['prefs']['affiliate-index.php']['orderdirection']))
			$navdirection = $Session['prefs']['affiliate-index.php']['orderdirection'];
		else
			$navdirection = '';
		
		
		// Get other affiliates
		$res = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$phpAds_config['tbl_affiliates']."
			".phpAds_getAffiliateListOrder ($navorder, $navdirection)."
		") or phpAds_sqlDie();
		
		while ($row = phpAds_dbFetchArray($res))
		{
			phpAds_PageContext (
				phpAds_buildAffiliateName ($row['affiliateid'], $row['name']),
				"affiliate-edit.php?affiliateid=".$row['affiliateid'],
				$affiliateid == $row['affiliateid']
			);
		}
		
		phpAds_PageShortcut($strAffiliateHistory, 'stats-affiliate-history.php?affiliateid='.$affiliateid, 'images/icon-statistics.gif');	
		
		phpAds_PageHeader("4.2.2");
			echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>".phpAds_getAffiliateName($affiliateid)."</b><br><br><br>";
			phpAds_ShowSections(array("4.2.2", "4.2.3"));
	}
	else
	{
		phpAds_PageHeader("2.2");
			echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>".phpAds_getAffiliateName($affiliateid)."</b><br><br><br>";
			phpAds_ShowSections(array("2.1", "2.2"));
	}
	
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_affiliates']."
		WHERE
			affiliateid = ".$affiliateid."
		") or phpAds_sqlDie();
	
	if (phpAds_dbNumRows($res))
	{
		$affiliate = phpAds_dbFetchArray($res);
	}
}
else
{
	phpAds_PageHeader("4.2.1");
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>".phpAds_getAffiliateName($affiliateid)."</b><br><br><br>";
		phpAds_ShowSections(array("4.2.1"));
	
	$affiliate['name'] 			= $strUntitled;
	$affiliate['website'] 		= 'http://';
	$affiliate['contact'] 		= '';
	$affiliate['email'] 		= '';
	$affiliate['publiczones']	= 'f';
	
	$affiliate['username'] 		= '';
	$affiliate['password'] 		= '';
	$affiliate['permissions'] 	= 0;
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

echo "<br><br>";
echo "<form name='affiliateform' method='post' action='affiliate-edit.php' onSubmit='return phpAds_formCheck(this);'>";
echo "<input type='hidden' name='affiliateid' value='".(isset($affiliateid) && $affiliateid != '' ? $affiliateid : '')."'>";
echo "<input type='hidden' name='move' value='".(isset($move) && $move != '' ? $move : '')."'>";

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strBasicInformation."</b></td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strName."</td><td>";
echo "<input onBlur='phpAds_formUpdate(this);' class='flat' type='text' name='name' size='35' style='width:350px;' value='".phpAds_htmlQuotes($affiliate['name'])."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".'Website'."</td><td>";
echo "<input onBlur='phpAds_formUpdate(this);' class='flat' type='text' name='website' size='35' style='width:350px;' value='".phpAds_htmlQuotes($affiliate['website'])."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strContact."</td><td>";
echo "<input onBlur='phpAds_formUpdate(this);' class='flat' type='text' name='contact' size='35' style='width:350px;' value='".phpAds_htmlQuotes($affiliate['contact'])."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strEMail."</td><td>";
echo "<input onBlur='phpAds_formUpdate(this);' class='flat' type='text' name='email' size='35' style='width:350px;' value='".phpAds_htmlQuotes($affiliate['email'])."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strLanguage."</td><td>";
echo "<select name='language'>";
echo "<option value='' SELECTED>".$strDefault."</option>\n"; 

$languages = phpAds_AvailableLanguages();
while (list($k, $v) = each($languages))
{
	if (isset($affiliate['language']) && $affiliate['language'] == $k)
		echo "<option value='$k' selected>$v</option>\n";
	else
		echo "<option value='$k'>$v</option>\n";
}

echo "</select></td></tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
echo "<input type='checkbox' name='publiczones' value='t'".($affiliate['publiczones'] == 't' ? ' CHECKED' : '').">&nbsp;";
echo $strMakePublisherPublic;
echo "</td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";




echo "<br><br>";
echo "<br><br>";

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strLoginInformation."</b></td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

if (isset($errormessage) && $errormessage == 'duplicateusername')
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
	echo "<td width='370'><input onBlur='phpAds_formUpdate(this);' class='flat' type='text' name='username' size='25' value='".phpAds_htmlQuotes($affiliate['username'])."'></td>";
else
	echo "<td width='370'>".(isset($affiliate['username']) ? $affiliate['username'] : '');

echo "</tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strPassword."</td>";
echo "<td width='370'><input class='flat' type='password' name='password' size='25' value='".phpAds_htmlQuotes($affiliate['password'])."'></td>";
echo "</tr><tr><td height='10' colspan='3'>&nbsp;</td></tr>";

if (phpAds_isUser(phpAds_Admin))
{
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
	echo "<input type='checkbox' name='affiliatepermissions[]' value='".phpAds_ModifyInfo."'".(phpAds_ModifyInfo & $affiliate['permissions'] ? ' CHECKED' : '').">&nbsp;";
	echo $strAllowAffiliateModifyInfo;
	echo "</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
	echo "<input type='checkbox' name='affiliatepermissions[]' value='".phpAds_EditZone."'".(phpAds_EditZone & $affiliate['permissions'] ? ' CHECKED' : '').">&nbsp;";
	echo $strAllowAffiliateModifyZones;
	echo "</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
	echo "<input type='checkbox' name='affiliatepermissions[]' value='".phpAds_LinkBanners."'".(phpAds_LinkBanners & $affiliate['permissions'] ? ' CHECKED' : '').">&nbsp;";
	echo $strAllowAffiliateLinkBanners;
	echo "</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
	echo "<input type='checkbox' name='affiliatepermissions[]' value='".phpAds_AddZone."'".(phpAds_AddZone & $affiliate['permissions'] ? ' CHECKED' : '').">&nbsp;";
	echo $strAllowAffiliateAddZone;
	echo "</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
	echo "<input type='checkbox' name='affiliatepermissions[]' value='".phpAds_DeleteZone."'".(phpAds_DeleteZone & $affiliate['permissions'] ? ' CHECKED' : '').">&nbsp;";
	echo $strAllowAffiliateDeleteZone;
	echo "</td></tr>";
}

echo "<tr><td height='10' colspan='2'>&nbsp;</td></tr>";
echo "</table>";

echo "<br><br>";
echo "<input type='submit' name='submit' value='".(isset($affiliateid) && $affiliateid != '' ? $strSaveChanges : ' Next > ')."'>";
echo "</form>";



/*********************************************************/
/* Form requirements                                     */
/*********************************************************/

// Get unique affiliate
$unique_names = array();

$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_affiliates']." WHERE affiliateid != '".$affiliateid."'");
while ($row = phpAds_dbFetchArray($res))
	$unique_names[] = $row['name'];


// Get unique username
$unique_users = array($phpAds_config['admin']);

$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_affiliates']." WHERE username != '' AND affiliateid != '".$affiliateid."'");
while ($row = phpAds_dbFetchArray($res))
	$unique_users[] = $row['username'];

$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_clients']." WHERE clientusername != '' AND parent = 0");
while ($row = phpAds_dbFetchArray($res))
	$unique_users[] = $row['clientusername'];

?>

<script language='JavaScript'>
<!--
	phpAds_formSetRequirements('name', '<?php echo $strName; ?>', true, 'unique');
	phpAds_formSetRequirements('contact', '<?php echo $strContact; ?>', true);
	phpAds_formSetRequirements('website', '<?php echo 'Website'; ?>', true, 'url');
	phpAds_formSetRequirements('email', '<?php echo $strEMail; ?>', true, 'email');
	phpAds_formSetRequirements('username', '<?php echo $strUsername; ?>', false, 'unique');
	
	phpAds_formSetUnique('name', '|<?php echo addslashes(implode('|', $unique_names)); ?>|');
	phpAds_formSetUnique('username', '|<?php echo addslashes(implode('|', $unique_users)); ?>|');
//-->
</script>

<?php



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>

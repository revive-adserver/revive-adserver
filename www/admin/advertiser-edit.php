<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/max/Admin/Languages.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/DB.php';

// Register input variables
phpAds_registerGlobal (
	 'errormessage'
	,'clientname'
	,'contact'
	,'comments'
	,'email'
	,'clientlanguage'
	,'clientreportlastdate'
	,'clientreportprevious'
	,'clientreportdeactivate'
	,'clientreport'
	,'clientreportinterval'
	,'clientusername'
	,'clientpassword'
	,'clientpermissions'
	,'pwold'
	,'pw'
	,'pw2'
	,'submit'
);


// Security check
MAX_Permission::checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Client);
MAX_Permission::checkIsAllowed(phpAds_ModifyInfo);
MAX_Permission::checkAccessToObject('clients', $clientid);

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/

if (isset($submit)) {
	$errormessage = array();
	// Get previous values
	if (!empty($clientid)) {
        $doClients = MAX_DB::factoryDO('clients');
		if ($doClients->get($clientid)) {
			$client = $doClients->toArray();
		}
	}
	// Name
	if ( phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency) ) {
		$client['clientname'] = trim($clientname);
	}
	// Default fields
	$client['contact'] 	 = trim($contact);
	$client['email'] 	 = trim($email);
	$client['language']   = trim($clientlanguage);
	$client['comments']  = trim($comments);

	// Reports
	$client['report'] = isset($clientreport) ? 't' : 'f';
	$client['reportdeactivate'] = isset($clientreportdeactivate) ? 't' : 'f';
	$client['reportinterval'] = (int)$clientreportinterval;
	if ($clientreportlastdate == '' || $clientreportlastdate == '0000-00-00' ||  $clientreportprevious != $clientreport) {
		$client['reportlastdate'] = date ("Y-m-d");
	}
	if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
		// Password
		if (isset($clientpassword)) {
			if ($clientpassword == '') {
				$client['clientpassword'] = '';
			} elseif ($clientpassword != '********') {
				$client['clientpassword'] = md5($clientpassword);
			}
		}
		// Username
		if (!empty($clientusername)) {
            if (!MAX_Permission::isUsernameAllowed($client['username'], $clientusername)) {
                $errormessage[] = $strDuplicateAgencyName;
            } else {
				// Set username
				$client['clientusername'] = $clientusername;
			}
		}
		// Permissions
		$client['permissions'] = 0;
		if (isset($clientpermissions) && is_array($clientpermissions)) {
			for ($i=0;$i<sizeof($clientpermissions);$i++) {
				$client['permissions'] += $clientpermissions[$i];
			}
		}
		// Agency
		if (phpAds_isUser(phpAds_Agency)) {
			$client['agencyid'] = phpAds_getUserID();
		}
	} else {
		// Password
		if (isset($pwold) && strlen($pwold) ||
			isset($pw) && strlen($pw) ||
			isset($pw2) && strlen($pw2)) {
			if (md5($pwold) != $client['clientpassword']) {
				$errormessage[] = $strPasswordWrong;
			} elseif (!strlen($pw) || strstr("\\", $pw)) {
				$errormessage[] = $strInvalidPassword;
			} elseif (strcmp($pw, $pw2)) {
				$errormessage[] = $strNotSamePasswords;
			} else {
				$client['clientpassword'] = md5($pw);
			}
		}
	}
	/*
	echo "<pre>";
	var_dump ($final);
	echo "</pre><hr>";
	*/
	if (count($errormessage) == 0) {
		if (empty($clientid)) {
            $doClients = MAX_DB::factoryDO('clients');
            $doClients->setFrom($client);
            $doClients->updated = date('Y-m-d H:i:s');

			// Insert
			$clientid = $doClients->insert();

			// Go to next page
			MAX_Admin_Redirect::redirect("campaign-edit.php?clientid=$clientid");
		} else {
            $doClients = MAX_DB::factoryDO('clients');
            $doClients->get($clientid);
            $doClients->setFrom($client);
            $doClients->updated = date('Y-m-d H:i:s');

			// Update
			$doClients->update();

            // Go to next page
			if (phpAds_isUser(phpAds_Client)) {
				// Set current session to new language
				$session['language'] = $clientlanguage;
				phpAds_SessionDataStore();
				MAX_Admin_Redirect::redirect('index.php');
			} else {
				MAX_Admin_Redirect::redirect("advertiser-campaigns.php?clientid=$clientid");
			}
		}
		exit;
	} else {
		// If an error occured set the password back to its previous value
		$client['clientpassword'] = $password;
	}
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if ($clientid != "") {
	if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
		if (isset($session['prefs']['advertiser-index.php']['listorder'])) {
			$navorder = $session['prefs']['advertiser-index.php']['listorder'];
		} else {
			$navorder = '';
		}
		if (isset($session['prefs']['advertiser-index.php']['orderdirection'])) {
			$navdirection = $session['prefs']['advertiser-index.php']['orderdirection'];
		} else {
			$navdirection = '';
		}

		// Get other clients
		$doClients = MAX_DB::factoryDO('clients');

		// Unless admin, restrict results
		if (phpAds_isUser(phpAds_Agency)) {
            $doClients->agencyid = $session['userid'];
		}
        
        $doClients->addListorderBy($navorder, $navdirection);
        $doClients->find();

		while ($doClients->fetch() && $row = $doClients->toArray()) {
			phpAds_PageContext (
				phpAds_buildName ($row['clientid'], $row['clientname']),
				"advertiser-edit.php?clientid=".$row['clientid'],
				$clientid == $row['clientid']
			);
		}
		phpAds_PageShortcut($strClientHistory, 'stats.php?entity=advertiser&breakdown=history&clientid='.$clientid, 'images/icon-statistics.gif');
		phpAds_PageHeader("4.1.2");
		echo "<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($clientid)."</b><br /><br /><br />";
		phpAds_ShowSections(array("4.1.2", "4.1.3", "4.1.4"));
	} else {
		phpAds_PageHeader("4");
	}

	// Do not get this information if the page
	// is the result of an error message
	if (!isset($client)) {
        $doClients = MAX_DB::factoryDO('clients');
		if ($doClients->get($clientid)) {
			$client = $doClients->toArray();
		}

		// Set password to default value
		if ($client['clientpassword'] != '') {
			$client['clientpassword'] = '********';
		}
	}
} else {
	phpAds_PageHeader("4.1.1");
	echo "<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($clientid)."</b><br /><br /><br />";
	phpAds_ShowSections(array("4.1.1"));
	// Do not set this information if the page
	// is the result of an error message
	if (!isset($client)) {
		$client['clientname']			= $strUntitled;
		$client['contact']				= '';
		$client['email']				= '';
		$client['reportdeactivate'] 	= 't';
		$client['report'] 				= 'f';
		$client['reportinterval'] 		= 7;
		$client['clientusername']		= '';
		$client['clientpassword']		= '';
		$client['permissions'] 			= 0;
	}
}
$tabindex = 1;

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

echo "<br /><br />";
echo "<form name='clientform' method='post' action='advertiser-edit.php' onSubmit='return max_formValidate(this);'>";
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

if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
	echo "<td><input onBlur='max_formValidateElement(this);' class='flat' type='text' name='clientname' size='25' value='".phpAds_htmlQuotes($client['clientname'])."' style='width: 350px;' tabindex='".($tabindex++)."'></td>";
} else {
	echo "<td>".(isset($client['clientname']) ? $client['clientname'] : '')."</td>";
}

echo "</tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

// Contact
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strContact."</td><td>";
echo "<input onBlur='max_formValidateElement(this);' class='flat' type='text' name='contact' size='25' value='".phpAds_htmlQuotes($client['contact'])."' style='width: 350px;' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

// Email
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strEMail."</td><td>";
echo "<input onBlur='max_formValidateElement(this);' class='flat' type='text' name='email' size='25' value='".phpAds_htmlQuotes($client['email'])."' style='width: 350px;' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

// Language
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strLanguage."</td><td>";
echo "<select name='clientlanguage' tabindex='".($tabindex++)."'>";
echo "<option value='' SELECTED>".$strDefault."</option>";

$languages = MAX_Admin_Languages::AvailableLanguages();
while (list($k, $v) = each($languages)) {
	if (isset($client['language']) && $client['language'] == $k) {
		echo "<option value='$k' selected>$v</option>";
	} else {
		echo "<option value='$k'>$v</option>";
	}
}

echo "</select></td></tr><tr><td height='10' colspan='3'>&nbsp;</td></tr>";

// Footer
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";

// Spacer
echo "<br /><br />";
echo "<br /><br />";

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
echo "<input onBlur='max_formValidateElement(this);' class='flat' type='text' name='clientreportinterval' size='25' value='".$client['reportinterval']."' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td height='10' colspan='3'>&nbsp;</td></tr>";

// Footer
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";

// Spacer
echo "<br /><br />";
echo "<br /><br />";

// Header
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strLoginInformation."</b></td></tr>";
echo "<tr height='1'><td width='30'><img src='images/break.gif' height='1' width='30'></td>";
echo "<td width='200'><img src='images/break.gif' height='1' width='200'></td>";
echo "<td width='100%'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

// Error message?
if (isset($errormessage) && count($errormessage)) {
	echo "<tr><td>&nbsp;</td><td height='10' colspan='2'>";
	echo "<table cellpadding='0' cellspacing='0' border='0'><tr><td>";
	echo "<img src='images/error.gif' align='absmiddle'>&nbsp;";

	while (list($k,$v) = each($errormessage))
		echo "<font color='#AA0000'><b>".$v."</b></font><br />";

	echo "</td></tr></table></td></tr><tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
}

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strUsername."</td>";

if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
	echo "<td><input onBlur='max_formValidateElement(this);' class='flat' type='text' name='clientusername' size='25' value='".phpAds_htmlQuotes($client['clientusername'])."' tabindex='".($tabindex++)."'></td>";
} else {
	echo "<td>".(isset($client['clientusername']) ? $client['clientusername'] : '')."</td>";
}

echo "</tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";


// Password
if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
	echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strPassword."</td>";
	echo "<td width='370'><input class='flat' type='password' name='clientpassword' size='25' value='".$client['clientpassword']."' tabindex='".($tabindex++)."'></td>";
	echo "</tr><tr><td height='10' colspan='3'>&nbsp;</td></tr>";
} else {
	echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strOldPassword."</td><td width='100%'>";
	echo "<input onBlur='max_formValidateElement(this);' class='flat' type='password' name='pwold' size='25' value='' tabindex='".($tabindex++)."'>";
	echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
	echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

	echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strNewPassword."</td><td width='100%'>";
	echo "<input onBlur='max_formValidateElement(this);' class='flat' type='password' name='pw' size='25' value='' tabindex='".($tabindex++)."'>";
	echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
	echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

	echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strRepeatPassword."</td><td width='100%'>";
	echo "<input onBlur='max_formValidateElement(this);' class='flat' type='password' name='pw2' size='25' value='' tabindex='".($tabindex++)."'>";
	echo "</td></tr>";
}

// Permissions
if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency))
{
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

	echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
	echo "<input type='checkbox' name='clientpermissions[]' value='".phpAds_ModifyInfo."'".(phpAds_ModifyInfo & $client['permissions'] ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;";
	echo $strAllowClientModifyInfo;
	echo "</td></tr>";

	echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
	echo "<input type='checkbox' name='clientpermissions[]' value='".phpAds_ModifyBanner."'".(phpAds_ModifyBanner & $client['permissions'] ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;";
	echo $strAllowClientModifyBanner;
	echo "</td></tr>";

	// Allow this user to deactivate his own banners
	echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
	echo "<input type='checkbox' name='clientpermissions[]' value='".phpAds_DisableBanner."'".(phpAds_DisableBanner & $client['permissions'] ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;";
	echo $strAllowClientDisableBanner;
	echo "</td></tr>";

	// Allow this user to activate his own banners
	echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
	echo "<input type='checkbox' name='clientpermissions[]' value='".phpAds_ActivateBanner."'".(phpAds_ActivateBanner & $client['permissions'] ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;";
	echo $strAllowClientActivateBanner;
	echo "</td></tr>";

	// Allow this user to view targeting statistics
	echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
	echo "<input type='checkbox' name='clientpermissions[]' value='".phpAds_ViewTargetingStats."'".(phpAds_ViewTargetingStats & $client['permissions'] ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;";
	echo $strAllowClientViewTargetingStats;
	echo "</td></tr>";

	// Allow importing of CSV Files
	echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
	echo "<input type='checkbox' name='clientpermissions[]' value='".phpAds_CsvImport."'".(phpAds_CsvImport & $client['permissions'] ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;";
	echo $strCsvImportConversions;
	echo "</td></tr>";

}

echo "</td>"."\n";
echo "</tr>"."\n";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";
echo "<tr><td height='25' colspan='3'><b>".$strMiscellaneous."</b></td></tr>"."\n";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>"."\n";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";

echo "<tr>"."\n";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr><td width='30'>&nbsp;</td>";
echo "<td width='200'>".$strComments."</td>";

echo "<td><textarea class='code' cols='45' rows='6' name='comments' wrap='off' dir='ltr' style='width:350px;";
echo "' tabindex='".($tabindex++)."'>".htmlentities($client['comments'])."</textarea></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td height='10' colspan='2'>&nbsp;</td></tr>";
echo "</table>";

echo "<br /><br />";
echo "<input type='submit' name='submit' value='".(isset($clientid) && $clientid != '' ? $strSaveChanges : $strNext.' >')."' tabindex='".($tabindex++)."'>";
echo "</form>";

/*-------------------------------------------------------*/
/* Form requirements                                     */
/*-------------------------------------------------------*/

// Get unique clientname
$doClients = MAX_DB::factoryDO('clients');
$unique_names = $doClients->getUniqueValuesFromColumn('clientname', $client['clientname']);

$unique_users = MAX_Permission::getUniqueUserNames($client['clientusername']);

?>

<script language='JavaScript'>
<!--
	max_formSetRequirements('contact', '<?php echo addslashes($strContact); ?>', true);
	max_formSetRequirements('email', '<?php echo addslashes($strEMail); ?>', true, 'email');
	max_formSetRequirements('clientreportinterval', '<?php echo addslashes($strNoDaysBetweenReports); ?>', true, 'number+');
<?php if (phpAds_isUser(phpAds_Admin)) { ?>
	max_formSetRequirements('clientname', '<?php echo addslashes($strName); ?>', true, 'unique');
	max_formSetRequirements('clientusername', '<?php echo addslashes($strUsername); ?>', false, 'unique');

	max_formSetUnique('clientname', '|<?php echo addslashes(implode('|', $unique_names)); ?>|');
	max_formSetUnique('clientusername', '|<?php echo addslashes(implode('|', $unique_users)); ?>|');
<?php } ?>
//-->
</script>

<?php

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>

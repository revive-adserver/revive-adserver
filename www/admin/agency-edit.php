<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Admin/Languages.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';

// Register input variables
phpAds_registerGlobal (
	 'errormessage'
	,'agencyid'
	,'name'
	,'contact'
	,'email'
	,'language'
	,'username'
	,'password'
	,'submit'
	,'logout_url'
	,'agencypermissions'
);

// Security check
MAX_Permission::checkAccess(phpAds_Admin);

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/

if (isset($submit)) {
	$errormessage = array();
	// Get previous values
	if (!empty($agencyid)) {
	    $doAgency = OA_Dal::factoryDO('agency');
	    $doAgency->get($agencyid);
	    $agency = $doAgency->toArray();
	}
	// Name
	$agency['name'] = trim($name);
	// Default fields
	$agency['contact'] 	 	= trim($contact);
	$agency['email'] 	 	= trim($email);
	$agency['language']   	= trim($language);
	$agency['logout_url']   = trim($logout_url);
	// Permissions
	$agency['permissions'] = 0;
	if (isset($agencypermissions) && is_array($agencypermissions)) {
		for ($i=0;$i<sizeof($agencypermissions);$i++) {
			$agency['permissions'] += $agencypermissions[$i];
		}
	}
	// Password
	if (isset($password)) {
		if ($password == '') {
			$agency['password'] = '';
		} elseif ($password != '********') {
			$agency['password'] = md5($password);
		}
	}
	// Username
	if (!empty($username)) {
        if (!MAX_Permission::isUsernameAllowed($agency['username'], $username)) {
            $errormessage[] = $strDuplicateAgencyName;
        }
	}
	if (count($errormessage) == 0) {
		$agency['username'] = $username;
	}
	// Password
	if (isset($pwold) && strlen($pwold) || isset($pw) && strlen($pw) ||	isset($pw2) && strlen($pw2)) {
		if (md5($pwold) != $agency['password']) {
			$errormessage[] = $strPasswordWrong;
		} elseif (!strlen($pw) || strstr("\\", $pw)) {
			$errormessage[] = $strInvalidPassword;
		} elseif (strcmp($pw, $pw2)) {
			$errormessage[] = $strNotSamePasswords;
		} else {
			$agency['password'] = md5($pw);
		}
	}
	if (count($errormessage) == 0) {
	    $doAgency = OA_Dal::factoryDO('agency');
		if (empty($agencyid)) {
		    $doAgency->setFrom($agency);
		    $agencyid = $doAgency->insert();
		} else {
		    $doAgency->get($agencyid);
		    $doAgency->setFrom($agency);
		    $doAgency->update();
		}
		// Go to next page
		MAX_Admin_Redirect::redirect('agency-index.php');
	} else {
		// If an error occured set the password back to its previous value
		$agency['password'] = $password;
	}
}

/*-------------------------------------------------------*/
/* Process submitted form  END                           */
/*-------------------------------------------------------*/

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if ($agencyid != '') {
	if (isset($session['prefs']['agency-index.php']['listorder'])) {
		$navorder = $session['prefs']['agency-index.php']['listorder'];
	} else {
		$navorder = '';
	}
	if (isset($session['prefs']['agency-index.php']['orderdirection'])) {
		$navdirection = $session['prefs']['agency-index.php']['orderdirection'];
	} else {
		$navdirection = '';
	}
	$doAgency = OA_Dal::factoryDO('agency');
	$doAgency->find();
	while ($doAgency->fetch() && $row = $doAgency->toArray()) {
		phpAds_PageContext(
			phpAds_buildName ($row['agencyid'], $row['name']),
			"agency-edit.php?agencyid=".$row['agencyid'],
			$agencyid == $row['agencyid']
		);
	}
	phpAds_PageHeader("5.5.2");
	$doAgency = OA_Dal::staticGetDO('agency', $agencyid);
	echo "<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;<b>".$doAgency->name."</b><br /><br /><br />";
	phpAds_ShowSections(array("5.5.2"));
	// Do not get this information if the page
	// is the result of an error message
	if (!isset($agency)) {
	    $doAgency = OA_Dal::factoryDO('agency');
	    if ($doAgency->get($agencyid)) {
	        $agency = $doAgency->toArray();
	    }
		// Set password to default value
		if ($agency['password'] != '') {
			$agency['password'] = '********';
		}
	}
} else {
	phpAds_PageHeader("5.5.1");
	echo "<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($agencyid)."</b><br /><br /><br />";
	// phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2", "5.5"));
	phpAds_ShowSections(array("5.5.1"));
	// Do not set this information if the page
	// is the result of an error message
	if (!isset($agency)) {
		$agency['name']			= $strUntitled;
		$agency['contact']		= '';
		$agency['email']		= '';
		$agency['username']		= '';
		$agency['password']		= '';
		$agency['logout_url']   = '';
		$agency['permissions']  = '';
	}
}
$tabindex = 1;

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

echo "<br /><br />";
echo "<form name='agencyform' method='post' action='agency-edit.php' onSubmit='return max_formValidate(this);'>";
echo "<input type='hidden' name='agencyid' value='".(isset($agencyid) && $agencyid != '' ? $agencyid : '')."'>";

// Header
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strBasicInformation."</b></td></tr>";
echo "<tr height='1'><td width='30'><img src='images/break.gif' height='1' width='30'></td>";
echo "<td width='200'><img src='images/break.gif' height='1' width='200'></td>";
echo "<td width='100%'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

// Agency Name
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strName."</td>";
echo "<td><input onBlur='max_formValidateElement(this);' class='flat' type='text' name='name' size='25' value='".phpAds_htmlQuotes($agency['name'])."' style='width: 350px;' tabindex='".($tabindex++)."'></td>";
echo "</tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

// Contact
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strContact."</td><td>";
echo "<input onBlur='max_formValidateElement(this);' class='flat' type='text' name='contact' size='25' value='".phpAds_htmlQuotes($agency['contact'])."' style='width: 350px;' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

// Email
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strEMail."</td><td>";
echo "<input onBlur='max_formValidateElement(this);' class='flat' type='text' name='email' size='25' value='".phpAds_htmlQuotes($agency['email'])."' style='width: 350px;' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

// Language
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strLanguage."</td><td>";
echo "<select name='language' tabindex='".($tabindex++)."'>";
echo "<option value='' SELECTED>".$strDefault."</option>";

$languages = MAX_Admin_Languages::AvailableLanguages();
while (list($k, $v) = each($languages)) {
	if (isset($agency['language']) && $agency['language'] == $k) {
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

	while (list($k,$v) = each($errormessage)) {
		echo "<font color='#AA0000'><b>".$v."</b></font><br />";
	}

	echo "</td></tr></table></td></tr><tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
}

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strUsername."</td>";
echo "<td><input onBlur='max_formValidateElement(this);' class='flat' type='text' name='username' size='25' value='".phpAds_htmlQuotes($agency['username'])."' tabindex='".($tabindex++)."'></td>";
echo "</tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

// Password
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strPassword."</td>";
echo "<td width='370'><input class='flat' type='password' name='password' size='25' value='".$agency['password']."' tabindex='".($tabindex++)."'></td>";
echo "</tr><tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

// Logout URL
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strLogoutURL."</td>";
echo "<td width='370'><input class='flat' type='text' name='logout_url' size='25' value='".$agency['logout_url']."' tabindex='".($tabindex++)."'></td>";
echo "</tr><tr><td height='10' colspan='3'>&nbsp;</td></tr>";

// Permissions
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td width='30'>&nbsp;</td><td width='200'><br/></td>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

// Allow this user to edit conversions
echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
echo "<input type='checkbox' name='agencypermissions[]' value='".phpAds_EditConversions."'".(phpAds_EditConversions & $agency['permissions'] ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;";
echo $strAllowAgencyEditConversions;
echo "</td></tr>";

// Footer
echo "<tr><td height='10' colspan='3'><br/>&nbsp;</td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";

echo "<br /><br />";
echo "<input type='submit' name='submit' value='".$strSaveChanges."' tabindex='".($tabindex++)."'>";
echo "</form>";

/*-------------------------------------------------------*/
/* Form requirements                                     */
/*-------------------------------------------------------*/

// Get unique agencyname
$doAgency = OA_Dal::factoryDO('agency');
$unique_names = $doAgency->getUniqueValuesFromColumn('name', $agency['name']);
$unique_users = MAX_Permission::getUniqueUserNames($agency['username']);

?>

<script language='JavaScript'>
<!--
	max_formSetRequirements('contact', '<?php echo addslashes($strContact); ?>', true);
	max_formSetRequirements('email', '<?php echo addslashes($strEMail); ?>', true, 'email');
<?php if (phpAds_isUser(phpAds_Admin)) { ?>
	max_formSetRequirements('name', '<?php echo addslashes($strName); ?>', true, 'unique');
	max_formSetRequirements('username', '<?php echo addslashes($strUsername); ?>', false, 'unique');

	max_formSetUnique('name', '|<?php echo addslashes(implode('|', $unique_names)); ?>|');
	max_formSetUnique('username', '|<?php echo addslashes(implode('|', $unique_users)); ?>|');
<?php } ?>
//-->
</script>

<?php

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>

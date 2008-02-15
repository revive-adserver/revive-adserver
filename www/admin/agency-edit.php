<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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
require_once MAX_PATH . '/lib/OA/Admin/Menu.php';

// Register input variables
phpAds_registerGlobalUnslashed (
	 'errormessage'
	,'agencyid'
	,'name'
	,'contact'
	,'email'
	,'agencylanguage'
	,'submit'
	,'logout_url'
);

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

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
	$agency['name']           = trim($name);
	// Default fields
	$agency['contact'] 	 	  = trim($contact);
	$agency['email'] 	 	  = trim($email);
	$agency['agencylanguage'] = trim($agencylanguage);
	$agency['logout_url']     = trim($logout_url);
	// Permissions
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
	}
}

/*-------------------------------------------------------*/
/* Process submitted form  END                           */
/*-------------------------------------------------------*/

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if ($agencyid != '') {
	OA_Admin_Menu::setAgencyPageContext($agencyid, 'agency-edit.php');
	phpAds_PageHeader("4.1.2");
	$doAgency = OA_Dal::staticGetDO('agency', $agencyid);
	echo "<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;<b>".$doAgency->name."</b><br /><br /><br />";
	phpAds_ShowSections(array("4.1.2", "4.1.3"));
	// Do not get this information if the page
	// is the result of an error message
	if (!isset($agency)) {
	    $doAgency = OA_Dal::factoryDO('agency');
	    if ($doAgency->get($agencyid)) {
	        $agency = $doAgency->toArray();
	    }
	}
} else {
	phpAds_PageHeader("4.1.1");
	echo "<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($agencyid)."</b><br /><br /><br />";
	phpAds_ShowSections(array("4.1.1"));
	// Do not set this information if the page
	// is the result of an error message
	if (!isset($agency)) {
		$agency['name']			= $strUntitled;
		$agency['contact']		= '';
		$agency['email']		= '';
		$agency['logout_url']   = '';
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
echo "<select name='agencylanguage' tabindex='".($tabindex++)."'>";
echo "<option value='' SELECTED>".$strDefault."</option>";

$languages = MAX_Admin_Languages::AvailableLanguages();
foreach ($languages as $k => $v) {
	if (isset($agency['agencylanguage']) && $agency['agencylanguage'] == $k) {
		echo "<option value='$k' selected>$v</option>";
	} else {
		echo "<option value='$k'>$v</option>";
	}
}

echo "</select></td></tr><tr><td height='10' colspan='3'>&nbsp;</td></tr>";

// Footer
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

?>

<script language='JavaScript'>
<!--
	max_formSetRequirements('contact', '<?php echo addslashes($strContact); ?>', true);
	max_formSetRequirements('email', '<?php echo addslashes($strEMail); ?>', true, 'email');
<?php if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) { ?>
	max_formSetRequirements('name', '<?php echo addslashes($strName); ?>', true, 'unique');
	max_formSetRequirements('agencyusername', '<?php echo addslashes($strUsername); ?>', false, 'unique');

	max_formSetUnique('name', '|<?php echo addslashes(implode('|', $unique_names)); ?>|');
	max_formSetUnique('agencyusername', '|<?php echo addslashes(implode('|', $unique_users)); ?>|');
<?php } ?>
//-->
</script>

<?php

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>

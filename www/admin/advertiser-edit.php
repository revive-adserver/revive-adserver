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
require_once MAX_PATH . '/lib/OA/Admin/Menu.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';

// Register input variables
phpAds_registerGlobalUnslashed(
     'errormessage'
    ,'clientname'
    ,'contact'
    ,'comments'
    ,'email'
    ,'clientreportlastdate'
	,'advertiser_limitation'
    ,'clientreportprevious'
    ,'clientreportdeactivate'
    ,'clientreport'
    ,'clientreportinterval'
    ,'submit'
);


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients', $clientid, true);

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/

if (isset($submit)) {
    $errormessage = array();
    // Get previous values
    if (!empty($clientid)) {
        $doClients = OA_Dal::factoryDO('clients');
        if ($doClients->get($clientid)) {
            $aClient = $doClients->toArray();
        }
    }
    // Name
    if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER) ) {
        $aClient['clientname'] = trim($clientname);
    }
    // Default fields
    $aClient['contact']  = trim($contact);
    $aClient['email']    = trim($email);
    $aClient['comments'] = trim($comments);

	// Same advertiser limitation
	$aClient['advertiser_limitation']  = isset($advertiser_limitation) ? 1 : 0;

    // Reports
    $aClient['report'] = isset($clientreport) ? 't' : 'f';
    $aClient['reportdeactivate'] = isset($clientreportdeactivate) ? 't' : 'f';
    $aClient['reportinterval'] = (int)$clientreportinterval;
    if ($clientreportlastdate == '' || $clientreportlastdate == '0000-00-00' ||  $clientreportprevious != $aClient['report']) {
        $aClient['reportlastdate'] = date ("Y-m-d");
    }
    if (count($errormessage) == 0) {
        if (empty($clientid)) {
            // Set agency ID
            $aClient['agencyid'] = OA_Permission::getAgencyId();

            $doClients = OA_Dal::factoryDO('clients');
            $doClients->setFrom($aClient);
            $doClients->updated = OA::getNow();

            // Insert
            $clientid = $doClients->insert();

            // Go to next page
            MAX_Admin_Redirect::redirect("campaign-edit.php?clientid=$clientid");
        } else {
            $doClients = OA_Dal::factoryDO('clients');
            $doClients->get($clientid);
            $doClients->setFrom($aClient);
            $doClients->updated = OA::getNow();
            $doClients->update();

            // Go to next page
            if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
                MAX_Admin_Redirect::redirect('index.php');
            } else {
                MAX_Admin_Redirect::redirect("advertiser-campaigns.php?clientid=$clientid");
            }
        }
        exit;
    }
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if ($clientid != "") {
    if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
        OA_Admin_Menu::setAdvertiserPageContext($clientid, 'advertiser-index.php');
        phpAds_PageShortcut($strClientHistory, 'stats.php?entity=advertiser&breakdown=history&clientid='.$clientid, 'images/icon-statistics.gif');
        phpAds_PageHeader("4.1.2");

        MAX_displayAdvertiserBreadcrumbs($clientid);
                
        $aTabSections = array("4.1.2", "4.1.3");
        // Conditionally display conversion tracking values
				if ($conf['logging']['trackerImpressions']) {
				    $aTabSections[] = "4.1.4";
				}
        $aTabSections[] = "4.1.5";
        phpAds_ShowSections($aTabSections);
    } else {
        phpAds_PageHeader("4");
    }

    // Do not get this information if the page
    // is the result of an error message
    if (!isset($aClient)) {
        $doClients = OA_Dal::factoryDO('clients');
        if ($doClients->get($clientid)) {
            $aClient = $doClients->toArray();
        }

        // Set password to default value
        if ($aClient['clientpassword'] != '') {
            $aClient['clientpassword'] = '********';
        }
    }
} else {
    phpAds_PageHeader("4.1.1");
    MAX_displayAdvertiserBreadcrumbs($clientid);
    phpAds_ShowSections(array("4.1.1"));
    // Do not set this information if the page
    // is the result of an error message
    if (!isset($aClient)) {
        $aClient['clientname']       = $strUntitled;
        $aClient['contact']          = '';
        $aClient['comments']         = '';
        $aClient['email']            = '';
        $aClient['reportdeactivate'] = 't';
        $aClient['report']           = 'f';
        $aClient['reportinterval']   = 7;
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
echo "<tr height='1'><td width='30'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='30'></td>";
echo "<td width='200'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='200'></td>";
echo "<td width='100%'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

// Clientname
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strName."</td>";

if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    echo "<td><input onBlur='max_formValidateElement(this);' class='flat' type='text' name='clientname' size='25' value='".phpAds_htmlQuotes($aClient['clientname'])."' style='width: 350px;' tabindex='".($tabindex++)."'></td>";
} else {
    echo "<td>".(isset($aClient['clientname']) ? $aClient['clientname'] : '')."</td>";
}

echo "</tr><tr><td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

// Contact
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strContact."</td><td>";
echo "<input onBlur='max_formValidateElement(this);' class='flat' type='text' name='contact' size='25' value='".phpAds_htmlQuotes($aClient['contact'])."' style='width: 350px;' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

// Email
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strEMail."</td><td>";
echo "<input onBlur='max_formValidateElement(this);' class='flat' type='text' name='email' size='25' value='".phpAds_htmlQuotes($aClient['email'])."' style='width: 350px;' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
echo "<tr><td height='20' colspan='3'>&nbsp;</td></tr>";

// Footer
echo "</table>";

// Header
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strMailSubject."</b></td></tr>";
echo "<tr height='1'><td width='30'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='30'></td>";
echo "<td width='200'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='200'></td>";
echo "<td width='100%'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

// Reports
echo "<input type='hidden' name='clientreportlastdate' value='".(isset($aClient['reportlastdate']) ? $aClient['reportlastdate'] : '')."'>";
echo "<input type='hidden' name='clientreportprevious' value='".(isset($aClient['report']) ? $aClient['report'] : '')."'>";

echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
echo "<input type='checkbox' id='clientreportdeactivate' name='clientreportdeactivate' value='t'".($aClient['reportdeactivate'] == 't' ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;<label for='clientreportdeactivate'>";
echo $strSendDeactivationWarning;
echo "</label></td></tr>";

// Interval
echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
echo "<input type='checkbox' id='clientreport' name='clientreport' value='t'".($aClient['report'] == 't' ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;<label for='clientreport'>";
echo $strSendAdvertisingReport;
echo "</label></td></tr>";

echo "<tr><td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strNoDaysBetweenReports."</td><td>";
echo "<input onBlur='max_formValidateElement(this);' class='flat' type='text' name='clientreportinterval' size='25' value='".$aClient['reportinterval']."' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td height='10' colspan='3'>&nbsp;</td></tr>";

// Footer
echo "</table>";

// Header
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";

// Error message?
if (isset($errormessage) && count($errormessage)) {
    echo "<tr><td>&nbsp;</td><td height='10' colspan='2'>";
    echo "<table cellpadding='0' cellspacing='0' border='0'><tr><td>";
    echo "<img src='" . MAX::assetPath() . "/images/error.gif' align='absmiddle'>&nbsp;";
    foreach ($errormessage as $k => $v)
        echo "<font color='#AA0000'><b>".$v."</b></font><br />";

    echo "</td></tr></table></td></tr><tr><td height='10' colspan='3'>&nbsp;</td></tr>";
		$client['advertiser_limitation']= 'f';
    echo "<tr><td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
    echo "<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
}

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";
echo "<tr><td height='25' colspan='3'><b>".$strMiscellaneous."</b></td></tr>"."\n";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>"."\n";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";

echo "<tr>"."\n";

// Enable advertiser exclusion
echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
echo "<input type='checkbox' name='advertiser_limitation' value='1'".($aClient['advertiser_limitation'] == '1' ? ' checked="checked"' : '')." tabindex='".($tabindex++)."'>&nbsp;";
echo $strAdvertiserLimitation;
echo "</td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
echo "<img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'>";
echo "</td></tr>";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr><td width='30'>&nbsp;</td>";
echo "<td width='200'>".$strComments."</td>";

echo "<td><textarea class='flat' cols='45' rows='6' name='comments' wrap='off' dir='ltr' style='width:350px;";
echo "' tabindex='".($tabindex++)."'>".htmlspecialchars($aClient['comments'])."</textarea></td></tr>";
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
$doClients = OA_Dal::factoryDO('clients');
$unique_names = $doClients->getUniqueValuesFromColumn('clientname', $aClient['clientname']);

?>

<script language='JavaScript'>
<!--
    max_formSetRequirements('contact', '<?php echo addslashes($strContact); ?>', true);
    max_formSetRequirements('email', '<?php echo addslashes($strEMail); ?>', true, 'email');
    max_formSetRequirements('clientreportinterval', '<?php echo addslashes($strNoDaysBetweenReports); ?>', true, 'number+');
<?php if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) { ?>
    max_formSetRequirements('clientname', '<?php echo addslashes($strName); ?>', true, 'unique');

    max_formSetUnique('clientname', '|<?php echo addslashes(implode('|', $unique_names)); ?>|');
<?php } ?>
//-->
</script>

<?php

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>

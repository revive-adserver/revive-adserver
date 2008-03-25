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

require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-maintenance.inc.php';
require_once MAX_PATH . '/plugins/invocationTags/InvocationTagsOptions.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("5.5");
phpAds_ShowSections(array("5.1", "5.2", "5.3", "5.5", "5.6", "5.4", "5.7"));
phpAds_MaintenanceSelection("encoding");

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

// Note: Taken from EncodingMigration.php (with the idfields and joinon arrays removed and updated for use with DataObjects)
$aTableFields = array(
    'acls' => array('fields' => array('data')),
    'acls_channel' => array('fields'    => array('data')),
    'affiliates' =>  array('fields' =>  array('name', 'mnemonic', 'comments', 'contact', 'email', 'website')),
    'agency' => array('fields' => array('name', 'contact', 'email', 'username', 'logout_url')),
    'application_variable' => array('fields' => array('name', 'value')),
    'banners' => array('fields' => array('htmltemplate','htmlcache','target','url','alt','bannertext','description','append','comments','keyword','statustext')),
    'campaigns' => array('fields' => array('campaignname','comments')),
    'channel' => array('fields' => array('name','description','comments')),
    'clients' => array('fields' => array('clientname','contact','email','comments')),
    'tracker_append' => array('fields' => array('tagcode')),
    'trackers' => array('fields' => array('trackername','description','appendcode')),
    'userlog' => array('fields' => array('details')),
    'variables' => array('fields' => array('name','description','variablecode')),
    'zones' => array('fields' => array('zonename','description','prepend','append','comments','what')),
    'users' => array('fields' => array('contact_name', 'email_address', 'username', 'comments')),
);

if (!empty($_POST['encTest'])) {
    echo "<form action='maintenance-encoding.php' method='POST'>";
    echo "<input type='hidden' name='encFrom' value='{$_POST['encFrom']}' />\n";
    echo "{$GLOBALS['strConvertThese']}<br /><br /><table border='1' padding='1'><tr><th>{$GLOBALS['strFrom']}</th><th>" . ucfirst($GLOBALS['strTo']) . "</th></tr>\n";
    $aChanged = _iterateTableFields($aTableFields, false);

    foreach ($aChanged as $changed) {
        echo "<tr>
                    <td>" . (htmlspecialchars($changed['from'])) . "</td>
                    <td>" . (htmlspecialchars($changed['to'])) . "</td>
                </tr>\n";
    }
    echo "</table><br />";
    echo "<input type='submit' name='encConfirm' value='{$GLOBALS['strConvert']}' /> <input type='button' name='encCancel' value='{$GLOBALS['strCancel']}' onclick='javascript:document.location = \"" . $_SERVER['PHP_SELF'] . "\";' />";
    phpAds_ShowBreak();
    phpAds_PageFooter();

    exit;
} elseif (!empty($_POST['encConfirm'])) {
    _iterateTableFields($aTableFields, true);
    Header("Location: maintenance-maintenance.php");
}

/**
 * This function iterates over the table fields, and either gathers data which would be changed, or changes the data
 *
 * @param unknown_type $aTableFields
 * @return unknown
 */
function _iterateTableFields($aTableFields, $execute = false)
{
    $aChanged = array();
    foreach ($aTableFields as $table => $tableData)
    {
        $doTable = OA_Dal::factoryDO($table);
        $doTable->find();
        while ($doTable->fetch()) {
            $changed = false;
            foreach ($tableData['fields'] as $field) {
                $converted = MAX_commonConvertEncoding($doTable->$field, 'UTF-8', $_POST['encFrom']);
                if ($converted === $doTable->$field) { continue; }
                $aChanged[] = array('from' => $doTable->$field, 'to' => $converted);
                $doTable->$field = $converted;
                $changed = true;
            }
            if ($changed && $execute) { $doTable->update(); }
        }
    }
   return $aChanged;
}
/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

echo "<br />";
echo $strEncodingExplaination;
echo "<br /><br />";

phpAds_ShowBreak();
echo "<form action='maintenance-encoding.php' method='POST'>";
echo $strEncodingConvertFrom . " <select name='encFrom'>\n";
$oOptions = new Plugins_InvocationTagsOptions();
$aEncodings = $oOptions->_getAvailableCharsets();
foreach ($aEncodings as $encCode => $encName) {
    echo "    <option value='{$encCode}'>{$encName}</option>\n";
}
echo "</select> ";

echo "<input type='submit' name='encTest' value='{$strEncodingConvertTest}' />";
echo "</form>";

phpAds_ShowBreak();

phpAds_PageFooter();

?>

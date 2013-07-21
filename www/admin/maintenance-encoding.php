<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

// Require the initialisation file
require_once '../../init.php';

require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-maintenance.inc.php';
require_once LIB_PATH . '/Extension/invocationTags/InvocationTagsOptions.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("maintenance-index");
phpAds_MaintenanceSelection("encoding");

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

// Note: Taken from EncodingMigration.php (with the idfields and joinon arrays removed and updated for use with DataObjects)
/**
 * An array to hold all the tables and fields that should be converted
 *
 * @var array of arrays(
 *  'fields' => array: field names that should be converted,
 *  'idfields' => array: fields identifying the primary (multi?) key used for the WHERE clause on update
 *  'joinon' string: Identifies which field in the table should be used to build the join up (to get the agency ID where applicable)
 */
$aTableFields = array(
    'acls' => array(
        'fields' => array('data'),
        'idfields' => array('bannerid', 'executionorder'),
    ),
    'acls_channel' => array(
        'fields'    => array('data'),
        'idfields'  => array('channelid', 'executionorder'),
    ),
    'affiliates' =>  array(
        'fields' =>  array('name', 'mnemonic', 'comments', 'contact', 'email', 'website'),
        'idfields'  => array('affiliateid'),
    ),
    'agency' => array(
        'fields' => array('name', 'contact', 'email'),
        'idfields'  => array('agencyid'),
    ),
    'application_variable' => array(
        'fields' => array('name', 'value'),
        'idfields'  => array('name'),
    ),
    'banners' => array(
        'fields' => array('htmltemplate','htmlcache','target','url','alt','bannertext','description','append','comments','keyword','statustext'),
        'idfields'  => array('bannerid'),
    ),
    'campaigns' => array(
        'fields' => array('campaignname','comments'),
        'idfields'  => array('campaignid'),
    ),
    'channel' => array(
        'fields' => array('name','description','comments'),
        'idfields'  => array('channelid'),
    ),
    'clients' => array(
        'fields' => array('clientname','contact','email','comments'),
        'idfields'  => array('clientid'),
    ),
    'tracker_append' => array(
        'fields' => array('tagcode'),
        'idfields'  => array('tracker_append_id'),
    ),
    'trackers' => array(
        'fields' => array('trackername','description','appendcode'),
        'idfields'  => array('trackerid'),
    ),
    'userlog' => array(
        'fields' => array('details'),
        'idfields'  => array('userlogid'),
    ),
    'users' => array(
        'fields' => array('contact_name', 'email_address', 'comments'),
        'idfields'  => array('user_id'),
    ),

    'variables' => array(
        'fields' => array('name','description','variablecode'),
        'idfields'  => array('variableid'),
    ),
    'zones' => array(
        'fields' => array('zonename','description','prepend','append','comments','what'),
        'idfields'  => array('zoneid'),
    ),
);

if (!empty($_POST['encConfirm'])) {
    _iterateTableFields($aTableFields, true);
    Header("Location: maintenance-maintenance.php");
}

/**
 * This function iterates over the table fields, and either gathers data which would be changed, or changes the data
 *
 * @param array $aTableFields
 * @return array
 */
function _iterateTableFields($aTableFields, $execute = false)
{
    $aChanged = array();
    $encTo =   (!empty($_POST['encTo']))   ? $_POST['encTo']   : 'UTF-8';
    $encFrom = (!empty($_POST['encFrom'])) ? $_POST['encFrom'] : 'UTF-8';

    foreach ($aTableFields as $table => $tableData)
    {
        $doTable = OA_Dal::factoryDO($table);
        $doTable->find();
        while ($doTable->fetch()) {
            $changed = false;
            foreach ($tableData['fields'] as $field) {
                $converted = MAX_commonConvertEncoding($doTable->$field, $encTo, $encFrom);
                if ($converted === $doTable->$field) { continue; }
                $id = array();
                foreach ($tableData['idfields'] as $idField) {
                    $id[$idField] = $doTable->$idField;
                }
                if ($execute && !in_array(implode('.', $id), $_POST['aExecute'][$table][$field])) {
                    continue;
                }

                $aChanged[$table][$field][] = array('from' => $doTable->$field, 'to' => $converted, 'id' => $id);
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
$oOptions = new Plugins_InvocationTagsOptions();
$aEncodings = $oOptions->_getAvailableCharsets();

$selectedFrom = (!empty($_POST['encFrom'])) ? $_POST['encFrom'] : 'UTF-8';
$selectedTo   = (!empty($_POST['encTo']))   ? $_POST['encTo']   : 'UTF-8';

echo $strEncodingConvertFrom . " <select name='encFrom'>\n";
foreach ($aEncodings as $encCode => $encName) {
    $selected = ($encCode == $selectedFrom) ? " selected='selected'" : '';
    echo "    <option value='{$encCode}' {$selected}>{$encName}</option>\n";
}
echo "</select> ";

//echo $strEncodingConvertTo . " <select name='encTo'>\n";
//foreach ($aEncodings as $encCode => $encName) {
//    $selected = ($encCode == $selectedTo) ? " selected='selected'" : '';
//    echo "    <option value='{$encCode}' {$selected}>{$encName}</option>\n";
//}
//echo "</select> ";

echo "<input type='submit' name='encTest' value='{$strEncodingConvertTest}' />";

// Show the results of the encoding
if (!empty($_POST['encTest'])) {
    phpAds_ShowBreak();

    $aChanged = _iterateTableFields($aTableFields, false);

    echo "{$GLOBALS['strConvertThese']}<br /><br />
        <table border='1' padding='1'>
            <tr><th>{$GLOBALS['strInclude']}</th><th>{$GLOBALS['strFrom']}</th><th>" . ucfirst($GLOBALS['strTo']) . "</th></tr>\n";

    foreach ($aChanged as $table => $aFields) {
        foreach ($aFields as $field => $aItems) {
            foreach ($aItems as $idx => $aItem) {
                echo "<tr>
                            <td><input type='checkbox' name='aExecute[{$table}][{$field}][]' value='" . implode('.', $aItem['id']) . "' checked='checked' /></td>
                            <td>" . (htmlspecialchars($aItem['from'])) . "</td>
                            <td>" . (htmlspecialchars($aItem['to'])) . "</td>
                        </tr>\n";
            }
        }
    }
    echo "</table><br />";
    echo "<input type='submit' name='encConfirm' value='{$GLOBALS['strConvert']}' /> <input type='button' name='encCancel' value='{$GLOBALS['strCancel']}' onclick='javascript:document.location = \"" . $_SERVER['SCRIPT_NAME'] . "\";' />";
}

phpAds_ShowBreak();

phpAds_PageFooter();

?>

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

/**
 * integrity check utility
 */

require_once './init.php';

require_once MAX_PATH.'/lib/OA/Upgrade/DB_Integrity.php';

if (array_key_exists('xajax', $_POST))
{
}
require_once MAX_PATH.'/www/devel/lib/xajax.inc.php';

$oIntegrity = new OA_DB_Integrity();
$aAppInfo = $oIntegrity->getVersion();

if (array_key_exists('btn_integ_check', $_POST))
{
    $version = $_POST['version'];
    if ($oIntegrity->init($version))
    {
        $oIntegrity->checkIntegrity();
        $aTasksConstructive = $oIntegrity->aTasksConstructiveAll;
        $aTasksDestructive  = $oIntegrity->aTasksDestructiveAll;
        $aMessages          = $oIntegrity->getMessages();
        $file_schema        = $oIntegrity->getFileSchema();
        $file_changes       = $oIntegrity->getFileChanges();
    }
}
else if (array_key_exists('btn_integ_exec', $_POST))
{
    $version = $_POST['changes_version'];
    if ($oIntegrity->init($version))
    {
        $oIntegrity->aTasksConstructiveSelected = (isset($_POST['constructive']) ? $_POST['constructive'] : array());
        $oIntegrity->aTasksDestructiveSelected  = (isset($_POST['destructive']) ? $_POST['destructive'] : array());
        $oIntegrity->compileExecuteTasklist('prune', 'execute');
    }
    if ($oIntegrity->init($version))
    {
        $oIntegrity->checkIntegrity();
        $aTasksConstructive = $oIntegrity->aTasksConstructiveAll;
        $aTasksDestructive  = $oIntegrity->aTasksDestructiveAll;
        $aMessages          = $oIntegrity->getMessages();
        $file_schema        = $oIntegrity->getFileSchema();
        $file_changes       = $oIntegrity->getFileChanges();
    }
}

$options = getChangesetOptions($version);

function getChangesetOptions($selected)
{
    $aFiles = array();
    $changePath = MAX_PATH.'/etc/changes/';
    $dh = opendir($changePath);
    if ($dh)
    {
        while (false !== ($file = readdir($dh)))
        {
            if (preg_match('/changes_tables_core_(?P<version>[\d]+)\.xml/', $file, $aMatches))
            {
                $aFiles[$file] = $aMatches['version'];
            }
        }
        krsort($aFiles);
        foreach ($aFiles AS $file => $version)
        {
            if ($selected != $version)
            {
                $opts.= '<option value="'.$version.'">'.$file.'</option>'."\n";
            }
            else
            {
                $opts.= '<option value="'.$version.'" selected>'.$file.'</option>'."\n";
            }
        }
        closedir($dh);
    }
    return $opts;
}

include 'templates/integ.html';


?>



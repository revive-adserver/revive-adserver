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

if (array_key_exists('btn_data_load_dryrun', $_POST))
{
    $options = array(
                    'dryrun'    => true,
                    'directory' => MAX_PATH.'/tests/datasets/mdb2schema/',
                    'datafile'  => $_POST['datafile'],
                    'prefix'    => $GLOBALS['_MAX']['CONF']['table']['prefix'],
                    'dbname'    => $GLOBALS['_MAX']['CONF']['database']['name'],
                    'appver'    => $aAppInfo['versionApp'],
                    'schema'    => $aAppInfo['versionSchema'],
                    );
    $aMessages = $oIntegrity->loadData($options);
    if (PEAR::isError($aMessages))
    {
        $aMessages[] = $aMessages->getUserInfo();
    }
}
else if (array_key_exists('btn_data_load', $_POST))
{
    $options = array(
                    'dryrun'    => false,
                    'directory' => MAX_PATH.'/tests/datasets/mdb2schema/',
                    'datafile'  => $_POST['datafile'],
                    'prefix'    => $GLOBALS['_MAX']['CONF']['table']['prefix'],
                    'dbname'    => $GLOBALS['_MAX']['CONF']['database']['name'],
                    'appver'    => $aAppInfo['versionApp'],
                    'schema'    => $aAppInfo['versionSchema'],
                    );
    $aMessages = $oIntegrity->loadData($options);
    if (PEAR::isError($aMessages))
    {
        $aMessages[] = $aMessages->getUserInfo();
    }
}
include 'templates/dataload.html';


?>



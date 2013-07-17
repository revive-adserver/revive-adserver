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

if (array_key_exists('btn_data_dump', $_POST))
{
    $oIntegrity->init($aAppInfo['versionSchema']);
    $aAppInfoMap = array(
        'schema'  => $aAppInfo['versionSchema'],
        'appver'  => $aAppInfo['versionApp'],
        'exclude' => $_POST['exclude'],
    );
    $aMessages = $oIntegrity->dumpData($aAppInfoMap);
    if (PEAR::isError($aMessages))
    {
        $aMessages[] = $aMessages->getUserInfo();
    }
}
include 'templates/datadump.html';


?>



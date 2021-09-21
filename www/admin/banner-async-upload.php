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

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/OA/Creative/File.php';

/*-------------------------------------------------------*/
/* Client interface security                             */
/*-------------------------------------------------------*/
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
OA_Permission::enforceAccessToObject('clients', $clientid);
OA_Permission::enforceAccessToObject('campaigns', $campaignid);

if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
    OA_Permission::enforceAllowed(OA_PERM_BANNER_EDIT);
    OA_Permission::enforceAccessToObject('banners', $bannerid);
} else {
    OA_Permission::enforceAccessToObject('banners', $bannerid, true);
}

MAX_header('Access-Control-Allow-Origin: http://revive.local.dev');
MAX_header('Access-Control-Allow-Credentials: true');

$oFile = OA_Creative_File::factoryUploadedFile('file');

if (PEAR::isError($oFile)) {
    MAX_sendStatusCode(500);
    exit;
}

$oFile->store('web');

$aFile = $oFile->getFileDetails();

if (empty($aFile['filename'])) {
    MAX_sendStatusCode(500);
    exit;
}

echo json_encode(['location' => $aFile['filename']]);

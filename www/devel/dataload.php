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



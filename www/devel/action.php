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
 *
 * @package    Max
 * @subpackage SimulationSuite
 * @author
 */


function checkPermissions($aFiles)
{
    if (($aErrs = OX_DevToolbox::checkFilePermissions($aFiles)) !== true)
    {
        setcookie('schemaFile', '');
        setcookie('schemaPath', '');
        $errorMessage =
            join("<br />\n", $aErrs['errors']) . "<br /><br ><hr /><br />\n" .
            'To fix, please execute the following commands:' . "<br /><br >\n" .
            join("<br />\n", $aErrs['fixes']);
        die($errorMessage);
    }
}

require_once './init.php';

$action = $_REQUEST['action'];

switch ($action)
{
    case 'about':
        $item = $_REQUEST['item'];
        include 'templates/frameheader.html';
        switch ($item)
        {
            case 'upgrade_packages':
                include 'templates/about_uppkg.html';
                break;
            case 'plugins':
                include 'templates/about_plugins.html';
                break;
            case 'schema':
                include 'templates/about_schema.html';
                break;
            case 'dataobjects':
                include 'templates/about_dataobjects.html';
                break;
            case 'core_utils':
                include 'templates/about_core_utils.html';
                break;
            case 'upgrade_array':
                include 'templates/about_uparray.html';
                break;
        }
        break;
    case 'upgrade_package':
        checkPermissions(array(MAX_PATH.'/etc/changes'));
        include 'uppkg.php';
        break;
    case 'create_plugin':
        include 'plugin.php';
        break;
    case 'schema_editor':
        include 'schema.php';
        break;
    case 'schema_changesets':
        include 'archive.php';
        break;
    case 'schema_integ':
        include 'integ.php';
        break;
    case 'schema_datadump':
        include 'datadump.php';
        break;
    case 'schema_dataload':
        include 'dataload.php';
        break;
    case 'schema_analysis':
        include 'explain.php';
        break;
    case 'upgrade_array':
        global $readPath, $writeFile;
        $readPath  = (array_key_exists('read' ,$_REQUEST) ? MAX_PATH.$_REQUEST['read']  : MAX_PATH.'/etc/changes');
        $writeFile = (array_key_exists('write',$_REQUEST) ? MAX_PATH.$_REQUEST['write'] : MAX_PATH.'/etc/changes/openads_upgrade_array.txt');
        checkPermissions(array($writeFile));
        include MAX_PATH.'/scripts/upgrade/buildPackagesArray.php';
        $array = file_get_contents($writeFile);
        $aVersions = unserialize($array);
        $info = print_r($aVersions, true);
        break;
    case 'generate_dataobjects':
        global $schema, $pathdbo;
        $GLOBALS['_MAX']['CONF']['debug']['priority'] = PEAR_LOG_INFO;
        $schema  = (array_key_exists('schema' ,$_REQUEST)  ? MAX_PATH.$_REQUEST['schema']  : MAX_PATH . '/etc/tables_core.xml');
        $pathdbo = (array_key_exists('dbopath' ,$_REQUEST) ? MAX_PATH.$_REQUEST['dbopath'] : MAX_PATH . '/lib/max/Dal/DataObjects');
        checkPermissions(array($pathdbo));
        include MAX_PATH.'/scripts/db_dataobject/rebuild.php';
        break;
    default:
        include 'templates/index.html';
        break;
}

include 'templates/body_action.html';


?>

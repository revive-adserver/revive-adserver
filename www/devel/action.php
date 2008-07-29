<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once './init.php';

$action = $_REQUEST['action'];

switch ($action)
{
    case 'upgrade_package': //&name=".$name,
        include 'uppkg.php';
        break;
    case 'create_plugin':
        include 'plugin.php';
        break;
    case 'schema_editor':
        include 'schema.php';
        break;
    case 'about_index':
        include 'templates/frameheader.html';
        include 'templates/index.html';
        break;
    case 'about_schema':
        include 'templates/frameheader.html';
        include 'templates/schema_about.html';
        break;
    case 'about_integ':
        include 'templates/frameheader.html';
        include 'templates/schema_about.html';
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

        include MAX_PATH.'/scripts/db_dataobject/rebuild.php';
        break;
    default:
        break;
}

include 'templates/body_action.html';


?>

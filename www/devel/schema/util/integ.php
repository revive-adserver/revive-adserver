<?php
/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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
 * db upgrade class demonstration script
 */

require_once '../../../../init.php';
require_once MAX_PATH.'/lib/OA/Upgrade/Upgrade.php';

$oUpgrader = new OA_Upgrade();

if (array_key_exists('btn_integ_check', $_REQUEST))
{
    $oUpgrader->initDatabaseConnection();
    $oUpgrader->oDBUpgrader->init('constructive', 'tables_core', 500);
    $oUpgrader->oDBUpgrader->prefix   = $GLOBALS['_MAX']['CONF']['table']['prefix'];
    $oUpgrader->oDBUpgrader->database = $GLOBALS['_MAX']['CONF']['database']['name'];
//    $oUpgrader->oDBUpgrader->file_schema = MAX_PATH.'/etc/changes/schema_tables_core_500.xml';
    $oUpgrader->oLogger->logClear();
    $aChanges = $oUpgrader->oDBUpgrader->checkSchemaIntegrity();
    $oUpgrader->oDBUpgrader->aChanges = $aChanges;
    $oUpgrader->oDBUpgrader->aDBTables = $oUpgrader->oDBUpgrader->_listTables();
    if ($oUpgrader->oDBUpgrader->_verifyTasks())
    {
        $aTasksConstructive = $oUpgrader->oDBUpgrader->aTaskList;
    }
    $oUpgrader->oDBUpgrader->init('destructive', 'tables_core', 500, true);
    $oUpgrader->oDBUpgrader->aDBTables = $oUpgrader->oDBUpgrader->_listTables();
    if ($oUpgrader->oDBUpgrader->_verifyTasks())
    {
        $aTasksDestructive = $oUpgrader->oDBUpgrader->aTaskList;
    }
}
include 'tpl/integ.html';


?>



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
$Id $
*/

class OA_UpgradePrescript
{
    var $oUpgrade;

    function OA_UpgradePrescript()
    {
    }

    function execute($aParams)
    {
        $this->oUpgrade = & $aParams[0];
        if (PEAR::isError($this->backupSchemaTablesCore()))
        {
            return false;
        }
        return true;
    }

    function backupSchemaTablesCore()
    {
        if (file_exists(MAX_PATH.'/etc/tables_core.xml'))
        {
            $this->oUpgrade->oLogger->log('copying tables_core.xml to tables_core.xml.backup');
            return @copy(MAX_PATH.'/etc/tables_core.xml', MAX_PATH.'/etc/tables_core.xml.backup');
        }
        $this->oUpgrade->oLogger->log('failed to backup tables_core.xml');
        return true;
    }

}
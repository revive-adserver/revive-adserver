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

$className = 'OA_UpgradePostscript_2_5_67';

require_once MAX_PATH . '/lib/OA/DB/Table.php';

class OA_UpgradePostscript_2_5_67
{
    var $oUpgrade;

    function OA_UpgradePostscript_2_5_67()
    {

    }

    function execute($aParams)
    {
        $this->oUpgrade = & $aParams[0];
        return $this->updateAuditContext();
    }

    function logOnly($msg)
    {
        $this->oUpgrade->oLogger->logOnly($msg);
    }

    function logError($msg)
    {
        $this->oUpgrade->oLogger->logError($msg);
    }

    /**
     * Replaces the existing "context" column in "audit" table with apropriate table names
     *
     * @return boolean
     */
    function updateAuditContext()
    {
        $doAudit = OA_Dal::factoryDO('audit');
        $aTables = OA_DB_Table::listOATablesCaseSensitive($prefix);

        foreach ($aTables as $prefixedTableName) {
            $tableName = $doAudit->getTableWithoutPrefix($prefixedTableName);
            $do = OA_Dal::factoryDO($tableName);
            if ($do) {
                $context = $do->_getContext();
                if ($context) {
                    $GLOBALS['_MAX']['CONF']['audit']['enabled'] = false;
                    $doAudit = OA_Dal::factoryDO('audit');
                    $doAudit->context = $do->getTableWithoutPrefix();
                    $doAudit->whereAdd("context = '".$context."'");
                    $ret = $doAudit->update(DB_DATAOBJECT_WHEREADD_ONLY);
                    $GLOBALS['_MAX']['CONF']['audit']['enabled'] = true;
                    if ($ret === false) {
                        $this->logError(
                            'Error while updating context for table: '
                                .$do->getTableWithoutPrefix());
                        return false;
                    }
                }
            }
        }

        $this->logOnly('audit log updated');
        return true;
    }

}
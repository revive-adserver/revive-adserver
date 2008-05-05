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

$className = 'OA_UpgradePostscript_2_5_67_RC8';

require_once MAX_PATH . '/lib/OA/DB/Table.php';

class OA_UpgradePostscript_2_5_67_RC8
{
    /**
     * @var OA_Upgrade
     */
    var $oUpgrade;

    /**
     * @var MDB2_Driver_Common
     */
    var $oDbh;

    function OA_UpgradePostscript_2_5_67_RC8()
    {

    }

    function execute($aParams)
    {
        $this->oUpgrade = & $aParams[0];
        $this->oDbh = &OA_DB::singleton();
        $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        if ($this->oDbh->dbsyntax == 'pgsql') {
            $oTable = &$this->oUpgrade->oDBUpgrader->oTable;
            foreach ($oTable->aDefinition['tables'] as $tableName => $aTable) {
                foreach ($aTable['fields'] as $fieldName => $aField) {
                    if (!empty($aField['autoincrement'])) {
                        // Check actual sequence name
                        $oldSequenceName = $this->getLinkedSequence($prefix.$tableName, $fieldName);
                        if ($oldSequenceName) {
                            $newSequenceName = OA_DB::getSequenceName($this->oDbh, $tableName, $fieldName);
                            if ($oldSequenceName != $newSequenceName) {
                                $this->logOnly("Non standard sequence name found: ".$oldSequenceName);
                                $qTable = $this->oDbh->quoteIdentifier($prefix.$tableName, true);
                                $qField = $this->oDbh->quoteIdentifier($fieldName, true);
                                $qOldSequence = $this->oDbh->quoteIdentifier($oldSequenceName, true);
                                $qNewSequence = $this->oDbh->quoteIdentifier($newSequenceName, true);
                                OA::disableErrorHandling();
                                $result = $this->oDbh->exec("ALTER TABLE {$qOldSequence} RENAME TO {$qNewSequence}");
                                if (PEAR::isError($result)) {
                                    $this->logError("Could not rename {$oldSequenceName} to {$newSequenceName}");
                                    return false;
                                }
                                $result = $this->oDbh->exec("ALTER TABLE {$qTable} ALTER {$qField} SET DEFAULT nextval(".$this->oDbh->quote($qNewSequence).")");
                                if (PEAR::isError($result)) {
                                    $this->logError("Could not set column default to sequence {$newSequenceName}");
                                    return false;
                                }
                                OA::enableErrorHandling();
                                $this->logOnly("Successfully renamed {$oldSequenceName} to {$newSequenceName}");
                            }
                        } else {
                            $this->logOnly("No sequence found for {$tableName}.{$fieldName}");
                        }
                    }
                }
            }
        }
        return true;
    }

    function getLinkedSequence($table, $field_name)
    {
        $query = "SELECT
                    (SELECT substring(pg_get_expr(d.adbin, d.adrelid) for 128)
                        FROM pg_attrdef d
                        WHERE d.adrelid = a.attrelid AND d.adnum = a.attnum AND a.atthasdef) as default
                    FROM pg_attribute a, pg_class c
                    WHERE c.relname = ".$this->oDbh->quote($table, 'text')."
                        AND c.oid = a.attrelid
                        AND NOT a.attisdropped
                        AND a.attnum > 0
                        AND a.attname = ".$this->oDbh->quote($field_name, 'text')."
                    ORDER BY a.attnum";
        $column = $this->oDbh->queryRow($query, null, MDB2_FETCHMODE_ASSOC);
        if (!PEAR::isError($column)) {
            if (preg_match('/nextval\(\'(.*?)\'/', $column['default'], $m)) {
                return $m[1];
            }
        }

        return false;
    }

    function logOnly($msg)
    {
        $this->oUpgrade->oLogger->logOnly($msg);
    }

    function logError($msg)
    {
        $this->oUpgrade->oLogger->logError($msg);
    }
}

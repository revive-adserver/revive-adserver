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

    function __construct()
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
                                    if ($result->getCode() == MDB2_ERROR_ALREADY_EXISTS) {
                                        $result = $this->oDbh->exec("DROP SEQUENCE {$qNewSequence}");
                                        if (PEAR::isError($result)) {
                                            $this->logError("Could not drop existing sequence {$newSequenceName}: ".$result->getUserInfo());
                                            return false;
                                        }
                                        $result = $this->oDbh->exec("ALTER TABLE {$qOldSequence} RENAME TO {$qNewSequence}");
                                    }
                                }
                                if (PEAR::isError($result)) {
                                    $this->logError("Could not rename {$oldSequenceName} to {$newSequenceName}: ".$result->getUserInfo());
                                    return false;
                                }
                                $result = $this->oDbh->exec("ALTER TABLE {$qTable} ALTER {$qField} SET DEFAULT nextval(".$this->oDbh->quote($qNewSequence).")");
                                if (PEAR::isError($result)) {
                                    $this->logError("Could not set column default to sequence {$newSequenceName}: ".$result->getUserInfo());
                                    return false;
                                }
                                OA::enableErrorHandling();
                                $result = $oTable->resetSequenceByData($tableName, $fieldName);
                                if (PEAR::isError($result)) {
                                    $this->logError("Could not reset sequence value for {$newSequenceName}: ".$result->getUserInfo());
                                    return false;
                                }
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

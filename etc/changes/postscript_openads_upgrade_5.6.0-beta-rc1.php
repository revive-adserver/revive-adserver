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

$className = 'RV_UpgradePostscript_5_6_0_beta_rc1';

require_once MAX_PATH . '/lib/OA/DB/Table.php';
require_once MAX_PATH . '/lib/OA/Upgrade/UpgradeLogger.php';

class RV_UpgradePostscript_5_6_0_beta_rc1
{
    /** @var MDB2_Driver_Common */
    public $oDbh;

    public function execute($aParams): bool
    {
        $this->oDbh = OA_DB::singleton();

        if ('pgsql' !== $this->oDbh->dbsyntax) {
            return true;
        }

        return $this->deleteUpdateBucketFunctions();
    }

    private function deleteUpdateBucketFunctions(): bool
    {
        $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];

        $aFunctions = array_filter($this->oDbh->manager->listFunctions(), function (string $func) use ($prefix) {
            return str_starts_with($func, "bucket_update_{$prefix}");
        });

        foreach ($aFunctions as $function) {
            $args = $this->oDbh->queryOne("
                SELECT
                    pg_catalog.pg_get_function_arguments(p.oid)
                FROM pg_catalog.pg_proc p
                WHERE
                    p.proname = " . $this->oDbh->quote($function) . " AND
                    pg_catalog.pg_function_is_visible(p.oid)
            ");

            if (PEAR::isError($args)) {
                $this->logError("Error: {$args->getMessage()}");
                continue;
            }

            $this->logOnly("Dropping function {$function}({$args})");

            $res = $this->oDbh->exec("DROP FUNCTION " . $this->oDbh->quoteIdentifier($function) . "({$args})");

            if (PEAR::isError($res)) {
                $this->logError("Error: {$res->getMessage()}");
            }
        }

        return true;
    }

    private function logOnly($msg)
    {
        if (isset($this->oUpgrade->oLogger)) {
            $this->oUpgrade->oLogger->logOnly($msg);
        }
    }

    private function logError($msg)
    {
        if (isset($this->oUpgrade->oLogger)) {
            $this->oUpgrade->oLogger->logError($msg);
        }
    }
}

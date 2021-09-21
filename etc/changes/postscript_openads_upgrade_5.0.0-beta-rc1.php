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

$className = 'RV_UpgradePostscript_5_0_0_beta_rc1';

require_once MAX_PATH . '/lib/OA/DB/Table.php';
require_once MAX_PATH . '/lib/OA/Upgrade/UpgradeLogger.php';

class RV_UpgradePostscript_5_0_0_beta_rc1
{
    /**
     * @var OA_Upgrade
     */
    public $oUpgrade;

    /**
     * @var MDB2_Driver_Common
     */
    public $oDbh;

    public function execute($aParams)
    {
        $this->oUpgrade = $aParams[0];

        $this->oDbh = OA_DB::singleton();

        $this->oDbh->beginTransaction();

        $this->migrateConfiguration();

        $this->migrateTable('acls', 'bannerid');
        $this->migrateTable('acls_channel', 'channelid');

        RV::disableErrorHandling();
        $this->oDbh->commit();
        RV::enableErrorHandling();

        // Rebuild ACLs
        $this->oUpgrade->addPostUpgradeTask('Recompile_Acls');

        return true;
    }

    private function migrateConfiguration()
    {
        $oSettings = new OA_Admin_Settings();

        $plugins = [
            'geoTargeting:oxMaxMindGeoIP:oxMaxMindGeoIP' => true,
            'geoTargeting:oxMaxMindModGeoIP:oxMaxMindModGeoIP' => true,
        ];

        unset($oSettings->aConf['oxMaxMindGeoIP']);
        $this->logOnly("Removing old MaxMind GeoIP settings");

        if (isset($plugins[$oSettings->aConf['geotargeting']['type']])) {
            $oSettings->aConf['geotargeting']['type'] = 'geoTargeting:rvMaxMindGeoIP2:rvMaxMindGeoIP2';

            $this->logOnly("Updating geotargeting settings to MaxMind GeoIP2");
        }
        if ($oSettings->writeConfigChange()) {
            $this->logOnly("Updated the configuration file");
        } else {
            $this->logError("Failed to update the configuration file");
        }
    }

    private function migrateTable(string $tableName, string $idName)
    {
        $aConf = $GLOBALS['_MAX']['CONF']['table'];

        $tblAcls = $aConf['prefix'] . ($aConf[$tableName] ? $aConf[$tableName] : $tableName);
        $qTblAcls = $this->oDbh->quoteIdentifier($tblAcls, true);
        $qId = $this->oDbh->quoteIdentifier($idName, true);

        $qTypes = array_map([$this->oDbh, 'quote'], \RV\Upgrade\GeoIp2Migration::RULE_TYPES);
        $where = "type IN (" . implode(', ', $qTypes) . ")";

        $deletedRows = [];

        /** @var MDB2_Statement_Common $updateStmt */
        $updateStmt = $this->oDbh->prepare("UPDATE {$qTblAcls} SET type = :type, data = :data, logical = :logical WHERE {$qId} = :{$idName} AND executionorder = :executionorder");

        /** @var MDB2_Result_Common $result */
        $result = $this->oDbh->query("SELECT {$qId}, type, data, executionorder, logical FROM {$qTblAcls} WHERE {$where} ORDER BY {$qId}, executionorder");

        if (PEAR::isError($result)) {
            $this->logError($result->getUserInfo());
            return false;
        }

        while ($row = $result->fetchRow()) {
            try {
                $new = \RV\Upgrade\GeoIp2Migration::migrate($row);

                $this->logOnly("Migrating {$tableName} [id{$row[$idName]},{$row['executionorder']}]: {$row['type']} to {$new['type']} -> " . print_r($new, true));

                $ret = $updateStmt->execute($new);

                if (PEAR::isError($ret)) {
                    $this->oDbh->rollback();
                    $this->logError($ret->getUserInfo());

                    return false;
                }
            } catch (\RV\Upgrade\Exception\DeliveryRuleDeletedException $e) {
                if (!isset($deletedRows[$row[$idName]])) {
                    $deletedRows[$row[$idName]] = [];
                }

                $deletedRows[$row[$idName]][] = $row;
            } catch (\Exception $e) {
                $this->oDbh->rollback();
                $this->logError($e->getMessage());

                return false;
            }
        }

        foreach ($deletedRows as $id => $aclIds) {
            rsort($aclIds);

            foreach ($aclIds as $row) {
                $executionOrder = $row['executionorder'];

                $this->logOnly("Deleting {$tableName} [id{$id},{$executionOrder}] and compacting subsequent rules");

                $ret = $this->oDbh->exec("DELETE FROM {$qTblAcls} WHERE {$qId} = {$id} AND executionorder = {$executionOrder}");

                if (PEAR::isError($ret)) {
                    $this->oDbh->rollback();
                    $this->logError($ret->getUserInfo());

                    return false;
                }

                // If the deleted entry was "AND" and the following one is "OR", change it to "AND" when moving it up
                $logical = "IF(logical = 'or', {$this->oDbh->quote($row['logical'])}, logical)";

                do {
                    $ret = $this->oDbh->exec("UPDATE {$qTblAcls} SET executionorder = executionorder - 1, logical = {$logical} WHERE {$qId} = {$id} AND executionorder = " . ++$executionOrder);

                    if (PEAR::isError($ret)) {
                        $this->oDbh->rollback();
                        $this->logError($ret->getUserInfo());

                        return false;
                    }

                    // Only the first rule requires updating the logical field
                    $logical = 'logical';
                } while ($ret > 0);
            }
        }
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

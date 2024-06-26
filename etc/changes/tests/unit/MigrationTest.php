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

require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once(MAX_PATH . '/lib/OA/Upgrade/UpgradeLogger.php');
require_once MAX_PATH . '/lib/OA/Upgrade/DB_Upgrade.php';
require_once MAX_PATH . '/lib/OA/Upgrade/DB_UpgradeAuditor.php';
require_once MAX_PATH . '/tests/testClasses/DbTestCase.php';

define('TEST_CONFIG_PATH', MAX_PATH . '/etc/changes/tests/data/config_2_0_12.inc.php');
define('CONFIG_PATH', MAX_PATH . '/var/config.inc.php');
define('TMP_CONFIG_PATH', MAX_PATH . '/var/config.inc.php.tmp');

/**
 * Test for migration class #127.
 *
 * @package    changes
 * @subpackage TestSuite
 */
abstract class MigrationTest extends DbTestCase
{
    /**
     * The MDB2 driver handle.
     *
     * @var MDB2_Driver_Common
     *
     */
    public $oDbh;

    /**
     * Upgrade class.
     *
     * @var OA_DB_Upgrade
     */
    public $oDBUpgrader;

    public function setUp()
    {
        $this->oDbh = OA_DB::singleton();
    }


    public function tearDown()
    {
        if (isset($this->oaTable)) {
            $this->oaTable->dropAllTables();
            $this->_dropAllBackupTables();
        }
    }

    /**
     * A method to allow the database to be initialised so that:
     * - It is created at a given database schema version, so that upgrades can be
     *   tested; and
     * - Only required tables are created.
     *
     * @param integer $schemaVersion The database schema version to initialise
     *                               the database with.
     * @param array $aTables An array of table names (no prefix) to create.
     * @return boolean True on success, false otherwise.
     */
    public function initDatabase($schemaVersion, $aTables)
    {
        $prefix = $this->getPrefix();
        $this->initOaTable("/etc/changes/schema_tables_core_{$schemaVersion}.xml");

        $aExistingTables = $this->oDbh->manager->listTables();

        foreach ($aTables as $table) {
            if (in_array($prefix . $table, $aExistingTables)) {
                if (!$this->oaTable->dropTable($prefix . $table)) {
                    return false;
                }
            }
            if (!$this->oaTable->createTable($table)) {
                return false;
            }
            if (!$this->oaTable->truncateTable($prefix . $table)) {
                return false;
            }
        }
        return true;
    }

    public function upgradeToVersion($version)
    {
        Mock::generatePartial(
            'OA_UpgradeLogger',
            $mockLogger = 'OA_UpgradeLogger' . rand(),
            ['logOnly', 'logError', 'log'],
        );

        $oLogger = new $mockLogger($this);
        $oLogger->setReturnValue('logOnly', true);
        $oLogger->setReturnValue('logError', true);
        $oLogger->setReturnValue('log', true);

        $this->oDBUpgrader = new OA_DB_Upgrade($oLogger);
        $this->oDBUpgrader->logFile = MAX_PATH . '/var/DB_Upgrade.test.log';
        $this->oDBUpgrader->initMDB2Schema();
        $auditor = new OA_DB_UpgradeAuditor();
        $this->oDBUpgrader->oAuditor = &$auditor;
        $this->assertTrue($auditor->init($this->oDBUpgrader->oSchema->db), 'error initialising upgrade auditor, probable error creating database action table');
        // execute all database upgrade actions for a given schema version
        // constructive first
        $this->oDBUpgrader->init('constructive', 'tables_core', $version);
        $this->oDBUpgrader->doBackups = false;
        $this->assertTrue($this->oDBUpgrader->upgrade(), 'constructive');
        // use same changeset, switch timing only to execute destructive
        $this->oDBUpgrader->init('destructive', 'tables_core', $version, true);
        $this->assertTrue($this->oDBUpgrader->upgrade(), 'destructive');
    }

    public function _dropAllBackupTables()
    {
        if (isset($this->oDBUpgrader)) {
            $aDBTables = $this->oDBUpgrader->_listTables('z_');
            foreach ($aDBTables as $table) {
                $this->oDBUpgrader->_dropBackup($table);
            }
        }
    }

    public function setupPanConfig()
    {
        if (file_exists(CONFIG_PATH)) {
            rename(CONFIG_PATH, TMP_CONFIG_PATH);
        }

        copy(TEST_CONFIG_PATH, CONFIG_PATH);
    }


    public function restorePanConfig()
    {
        unlink(CONFIG_PATH);

        if (file_exists(TMP_CONFIG_PATH)) {
            rename(TMP_CONFIG_PATH, CONFIG_PATH);
        }
    }
}

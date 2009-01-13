<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once(MAX_PATH.'/lib/OA/Upgrade/UpgradeLogger.php');
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
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openx.org>
 */
class MigrationTest extends DbTestCase
{
    /**
     * The MDB2 driver handle.
     *
     * @var MDB2_Driver_Common
     *
     */
    var $oDbh;

    /**
     * Upgrade class.
     *
     * @var OA_DB_Upgrade
     */
    var $oDBUpgrader;

    function setUp()
    {
        $this->oDbh = &OA_DB::singleton();
    }


    function tearDown()
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
    function initDatabase($schemaVersion, $aTables)
    {
        $prefix = $this->getPrefix();
        $this->initOaTable("/etc/changes/schema_tables_core_{$schemaVersion}.xml");

        $aExistingTables = $this->oDbh->manager->listTables();

        foreach ($aTables as $table)
        {
            if (in_array($prefix . $table, $aExistingTables))
            {
                if (!$this->oaTable->dropTable($prefix . $table))
                {
                    return false;
                }
            }
            if (!$this->oaTable->createTable($table))
            {
                return false;
            }
            if (!$this->oaTable->truncateTable($prefix . $table))
            {
                return false;
            }
        }
        return true;
    }

    function upgradeToVersion($version)
    {
        Mock::generatePartial(
            'OA_UpgradeLogger',
            $mockLogger = 'OA_UpgradeLogger'.rand(),
            array('logOnly', 'logError', 'log')
        );

        $oLogger = new $mockLogger($this);
        $oLogger->setReturnValue('logOnly', true);
        $oLogger->setReturnValue('logError', true);
        $oLogger->setReturnValue('log', true);

        $this->oDBUpgrader = new OA_DB_Upgrade($oLogger);
        $this->oDBUpgrader->logFile = MAX_PATH.'/var/DB_Upgrade.test.log';
        $this->oDBUpgrader->initMDB2Schema();
        $auditor   = new OA_DB_UpgradeAuditor();
        $this->oDBUpgrader->oAuditor = &$auditor;
        $this->assertTrue($auditor->init($this->oDBUpgrader->oSchema->db), 'error initialising upgrade auditor, probable error creating database action table');
        // execute all database upgrade actions for a given schema version
        // constructive first
        $this->oDBUpgrader->init('constructive', 'tables_core', $version);
        $this->oDBUpgrader->doBackups = false;
        $this->assertTrue($this->oDBUpgrader->upgrade(),'constructive');
        // use same changeset, switch timing only to execute destructive
        $this->oDBUpgrader->init('destructive', 'tables_core', $version, true);
        $this->assertTrue($this->oDBUpgrader->upgrade(),'destructive');
    }

    function _dropAllBackupTables()
    {
        if (isset($this->oDBUpgrader)) {
            $aDBTables = $this->oDBUpgrader->_listTables('z_');
            foreach ($aDBTables AS $table)
            {
                $this->oDBUpgrader->_dropBackup($table);
            }
        }
    }

    function setupPanConfig()
    {
        if (file_exists(CONFIG_PATH)) {
            rename(CONFIG_PATH, TMP_CONFIG_PATH);
        }

        copy(TEST_CONFIG_PATH, CONFIG_PATH);
    }


    function restorePanConfig()
    {
        unlink(CONFIG_PATH);

        if (file_exists(TMP_CONFIG_PATH)) {
            rename(TMP_CONFIG_PATH, CONFIG_PATH);
        }
    }
}
?>
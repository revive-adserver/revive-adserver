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

require_once MAX_PATH . '/lib/OA/Upgrade/Upgrade.php';

class OA_Upgrade_IntegritySchema_TestDB
{
    public $path_schema = 'original/schema/';
    public $file_schema = 'original/schema.xml';
    public $path_changes = 'original/changes/';
    public $file_changes = 'original/changes.xml';

    public function checkPotentialUpgradeProblems()
    {
        return true;
    }
}

class OA_Upgrade_IntegritySchema_TestIntegrity
{
    public $oUpgrader;
    public $aTasksConstructiveAll = [];
    public $result = true;
    public $schema;

    public function checkIntegrityQuick($version, $schema)
    {
        $this->schema = $schema;
        $db = $this->oUpgrader->oDBUpgrader;
        $db->path_schema = 'selected/schema/';
        $db->file_schema = 'selected/schema.xml';
        $db->path_changes = 'temporary/changes/';
        $db->file_changes = 'temporary/changes.xml';
        return $this->result;
    }
}

class OA_Upgrade_IntegritySchema_TestLogger
{
    public function logError($message) {}
    public function logClear() {}
}

class Test_OA_Upgrade_IntegritySchema extends UnitTestCase
{
    public function testSchemaRestorationOnSuccessAndFailure()
    {
        foreach ([[], ['name' => 'plugin', 'schemaOld' => 'plugin/schema.xml']] as $schema) {
            foreach ([true, false] as $result) {
                // Isolate path restoration from database and schema initialization.
                $upgrader = (new ReflectionClass(OA_Upgrade::class))->newInstanceWithoutConstructor();
                $upgrader->oDBUpgrader = new OA_Upgrade_IntegritySchema_TestDB();
                $upgrader->oIntegrity = new OA_Upgrade_IntegritySchema_TestIntegrity();
                $upgrader->oIntegrity->result = $result;
                $upgrader->oLogger = new OA_Upgrade_IntegritySchema_TestLogger();
                $this->assertIdentical($result, $upgrader->_checkDBIntegrity('001', $schema));
                $this->assertEqual(empty($schema) ? ['name' => 'tables_core'] : $schema, $upgrader->oIntegrity->schema);
                $this->assertEqual(empty($schema) ? 'original/schema/' : 'selected/schema/', $upgrader->oDBUpgrader->path_schema);
                $this->assertEqual(empty($schema) ? 'original/schema.xml' : 'selected/schema.xml', $upgrader->oDBUpgrader->file_schema);
                $this->assertEqual('original/changes/', $upgrader->oDBUpgrader->path_changes);
                $this->assertEqual('original/changes.xml', $upgrader->oDBUpgrader->file_changes);
            }
        }
    }
}

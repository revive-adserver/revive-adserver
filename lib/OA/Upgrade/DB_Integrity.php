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

/**
 * database vs schema integrity methods
 */
class OA_DB_Integrity
{
    public $oUpgrader;
    public $oDBUpgrader;
    public $aTasksConstructiveAll;
    public $aTasksDestructiveAll;
    public $aTasksConstructiveSelected;
    public $aTasksDestructiveSelected;
    public $aMigrationMethods;

    public $version;
    //var $OK = true;

    public function __construct()
    {
    }

    public function init($version, $dbname = '', $createdb = true)
    {
        $this->_clearProperties();
        $this->version = $version;
        $this->oUpgrader = new OA_Upgrade();
        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($dbname) {
            $aConf['database']['name'] = $dbname;
        }
        if (!$this->oUpgrader->initDatabaseConnection($aConf)) {
            if (!$createdb) {
                return false;
            }
            if (!$this->oUpgrader->_createDatabase($aConf)) {
                return false;
            }
            if (!$this->oUpgrader->initDatabaseConnection($aConf)) {
                return false;
            }
        }
        $this->oDBUpgrader = $this->oUpgrader->oDBUpgrader;
        $this->_initDBUpgrader();
        $this->oUpgrader->oLogger->logClear();
        if ($version > 0) {
            if (!$this->oDBUpgrader->buildSchemaDefinition()) {
                return false;
            }
        }
        return true;
    }

    public function getSchemaFileInfo($directory, $datafile, $ext = '.xml')
    {
        if (!$this->init(0, 'test_data')) {
            return [];
        }
        if (!$directory) {
            $directory = MAX_PATH . '/var/';
        }
        if (!file_exists($directory . $datafile . $ext)) {
            return ['error' => 'file not found ' . $directory . $datafile . $ext];
        }
        $aResult = $this->oDBUpgrader->oSchema->parseDatabaseFileHeader($directory . $datafile . $ext);
        if (PEAR::isError($aResult)) {
            $aResult[] = $aResult->getUserInfo();
        }
        return $aResult;
    }

    public function getVersion()
    {
        $this->oUpgrader = new OA_Upgrade();
        if (!$this->oUpgrader->initDatabaseConnection()) {
            return false;
        }
        $result = $this->oUpgrader->canUpgradeOrInstall();
        return ['canUpgrade' => $result, 'versionApp' => $this->oUpgrader->versionInitialApplication, 'versionSchema' => $this->oUpgrader->versionInitialSchema['tables_core']];
    }

    //function dumpData($versionSchema, $versionApp, $aExclude, $output='')
    public function dumpData($aVariables)
    {
        $aResult = [];
        $aVariables['exclude']['hack'] = "(ad_category_assoc|campaigns_trackers|category|password_recovery|placement_zone_assoc|plugins_channel_delivery_assoc|plugins_channel_delivery_domains|plugins_channel_delivery_rules|targetstats|variable_publisher)";
        foreach ($aVariables['exclude'] as $k => $pattern) {
            foreach ($this->oDBUpgrader->aDefinitionNew['tables'] as $table => $aDef) {
                if (preg_match('/' . $pattern . '/', $table)) {
                    unset($this->oDBUpgrader->aDefinitionNew['tables'][$table]);
                    $aResult[] = 'excluding table ' . $table;
                }
            }
        }
        $this->oDBUpgrader->aDefinitionNew['name'] = $GLOBALS['_MAX']['CONF']['database']['name'];
        if (!$aVariables['output']) {
            $aVariables['output'] = MAX_PATH . '/var/' . $aVariables['appver'] . '_data_tables_core_' . $aVariables['schema'] . '_' . $this->oDBUpgrader->aDefinitionNew['name'] . '.xml';
        }
        $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];

        $aResult[] = 'application version: ' . $aVariables['appver'];
        $aResult[] = 'schema version: ' . $aVariables['schema'];
        $aResult[] = 'source database: ' . $GLOBALS['_MAX']['CONF']['database']['name'];
        $aResult[] = 'table prefix: ' . $prefix;
        $aResult[] = 'output file: ' . $aVariables['output'];

        $options = [
                            'output_mode' => 'file',
                            'output' => $aVariables['output'],
                            'end_of_line' => "\n",
                            'xsl_file' => "",
                            'custom_tags' => ['version' => $aVariables['schema'], 'status' => 'final', 'application' => $aVariables['appver']],
                            'prefix' => $prefix,
                          ];
        $error = $this->oDBUpgrader->oSchema->dumpDatabaseContent($this->oDBUpgrader->aDefinitionNew, $options);
        if (PEAR::isError($error)) {
            $aResult[] = $error->getUserInfo();
        }
        $aDefinition = $this->oDBUpgrader->oSchema->parseDatabaseContentFile($aVariables['output'], [], false, false, $this->oUpgrader->oTable->aDefinition);
        if (PEAR::isError($aDefinition)) {
            $aResult[] = $aDefinition->getUserInfo();
        }
        foreach ($aDefinition['tables'] as $table_name => $aTable) {
            $count = count($aTable['initialization']);
            $aResult[] = $count . ' rows dumped from table ' . $prefix . $table_name;
        }
        return $aResult;
    }

    public function loadData($aVariables = '')
    {
        if (!$this->oDBUpgrader) {
            $this->oDBUpgrader = new OA_DB_Upgrade();
            $this->oDBUpgrader->initMDB2Schema();
        }
        $aResult = [];
        if (!$aVariables['directory']) {
            $aVariables['directory'] = MAX_PATH . '/var/';
        }
        if (!$aVariables['datafile']) {
            $aResult[] = 'no filename supplied';
        }
        /*else
        {
            $aDefinition = $this->oDBUpgrader->oSchema->parseDatabaseContentFile($aVariables['directory'].$aVariables['datafile'], array(), false, false, $this->oUpgrader->oTable->aDefinition);
            $aVariables['schema'] = $aDefinition['version'];
            $aVariables['appver'] = $aDefinition['application'];
        }*/
        if (!$aVariables['schema']) {
            if (!preg_match('/(?P<appver>[\w\W]+)_data_tables_core_(?P<schema>[\d]+)_(?P<dbname>[\w\W]+)\.xml/', $aVariables['datafile'], $aVariables)) {
                $aResult[] = 'could not parse input filename';
            }
        } else {
            if ($aVariables['dryrun']) {
                $aResult[] = 'DRY RUN - database may have been created but no tables altered';
            }
            $aResult[] = 'application version: ' . $aVariables['appver'];
            $aResult[] = 'schema version: ' . $aVariables['schema'];
            $aResult[] = 'target database: ' . $aVariables['dbname'];
            $aResult[] = 'table prefix: ' . $aVariables['prefix'];

            if ($this->init($aVariables['schema'], $aVariables['dbname'])) {
                if ($this->oUpgrader->oTable->init(MAX_PATH . '/etc/changes/schema_tables_core_' . $aVariables['schema'] . '.xml')) {
                    $aDefinition = $this->oDBUpgrader->oSchema->parseDatabaseContentFile($aVariables['directory'] . $aVariables['datafile'], [], false, false, $this->oUpgrader->oTable->aDefinition);
                    if (PEAR::isError($aDefinition)) {
                        $aResult[] = $aDefinition->getUserInfo();
                        return $aResult;
                    }
                    if (!$aVariables['dryrun']) {
                        $this->oUpgrader->oTable->dropAllTables();
                        if (!$this->oUpgrader->oTable->createAllTables()) {
                            $aResult[] = 'ERROR creating all tables';
                            return $aResult;
                        }
                        /*                    $query = 'SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO"';
                                            $mdb2_result = $this->oUpgrader->oDbh->exec($query);
                                            if (PEAR::isError($mdb2_result))
                                            {
                                                $aResult[] = $mdb2_result->getUserInfo();
                                            }
                        */
                    }
                    foreach ($aDefinition['tables'] as $table_name => $aTable) {
                        if (empty($aTable['initialization'])) {
                            continue;
                        }
                        $count = count($aTable['initialization']);
                        if ($aVariables['dryrun']) {
                            $aResult[] = $count . ' rows to insert into table ' . $aVariables['prefix'] . $table_name;
                        } else {
                            $aTable['fields'] = $this->oUpgrader->oTable->aDefinition['tables'][$table_name]['fields'];
                            //$aTable['indexes'] = $this->oUpgrader->oTable->aDefinition['tables'][$table_name]['indexes'];
                            $rows = $this->oDBUpgrader->oSchema->initializeTable($aVariables['prefix'] . $table_name, $aTable, true);
                            if (PEAR::isError($rows)) {
                                $aResult[] = $rows->getUserInfo();
                            } elseif ($rows['error']) {
                                $aResult[] = $rows['error'];
                            } else {
                                $msg = $rows['count'] . ' / ' . $count . ' rows inserted into table ' . $aVariables['prefix'] . $table_name;
                                if ($rows['count'] <> $count) {
                                    $msg = 'ERROR! ' . $msg;
                                }
                                $aResult[] = $msg;
                            }
                        }
                    }
                } else {
                    $aResult[] = 'table initialisation error';
                }
            } else {
                $aResult[] = 'initialisation error';
            }
        }
        return $aResult;
    }

    // this one is called from within OA_Upgrade during detectMax
    // OA_Upgrade assigns itself after instantiation
    // compiles constructive tasks but does not prune or execute
    public function checkIntegrityQuick($version, $aSchema = '')
    {
        $this->_clearProperties();
        $this->version = $version;
        $this->oDBUpgrader = $this->oUpgrader->oDBUpgrader;
        $this->_initDBUpgrader($aSchema['schemaOld']);
        if (!$this->oDBUpgrader->buildSchemaDefinition()) {
            return false;
        }
        if (!$this->oDBUpgrader->applySchemaDefinitionChanges($this->version)) {
            return false;
        }
        if (!$this->oDBUpgrader->checkSchemaIntegrity($this->getFileChanges())) {
            return false;
        }
        if (!$this->oDBUpgrader->init('constructive', $aSchema['name'], $this->version, 'switchTiming')) {
            return false;
        }
        if (!$this->oDBUpgrader->_verifyTasks()) {
            return false;
        }
        $this->aTasksConstructiveAll = $this->oDBUpgrader->aTaskList;
        return true;
    }

    // this one is called via standalone util
    // which calls the init method to instantiate OA_Upgrade
    // compiles, prunes and executes constructive and destructive tasks
    public function checkIntegrity()
    {
        if (!$this->oDBUpgrader->checkSchemaIntegrity($this->getFileChanges())) {
            return false;
        }
        if (!$this->oDBUpgrader->init('constructive', 'tables_core', $this->version, 'switchTiming')) {
            return false;
        }
        if (!$this->oDBUpgrader->_verifyTasks()) {
            return false;
        }
        $this->aTasksConstructiveAll = $this->oDBUpgrader->aTaskList;
        if (!$this->oDBUpgrader->init('destructive', 'tables_core', $this->version, 'switchTiming')) {
            return false;
        }
        if (!$this->oDBUpgrader->_verifyTasks()) {
            return false;
        }
        $this->aTasksDestructiveAll = $this->oDBUpgrader->aTaskList;

        return true;
    }

    public function compileExecuteTasklist($prune = false, $execute = false, $updateVersion = false)
    {
        if (!$this->oDBUpgrader->buildChangesetDefinition()) {
            return false;
        }
        if (!$this->oDBUpgrader->init('constructive', 'tables_core', $this->version, 'switchTiming')) {
            return false;
        }
        if (!$this->oDBUpgrader->_verifyTasks()) {
            return false;
        }
        $this->aTasksConstructiveAll = $this->oDBUpgrader->aTaskList;
        if ($prune) {
            $this->aTasksConstructiveAll = $this->pruneTasklist('constructive');
        }
        if ($execute) {
//            if (!$this->oDBUpgrader->_backup())
//            {
//                return false;
//            }
            $this->mockMigration();
            $this->oDBUpgrader->aTaskList = $this->aTasksConstructiveAll;
            if (!$this->oDBUpgrader->_executeTasks()) {
                return false;
            }
        }
        if (!$this->oDBUpgrader->init('destructive', 'tables_core', $this->version, 'switchTiming')) {
            return false;
        }
        if (!$this->oDBUpgrader->_verifyTasks()) {
            return false;
        }
        $this->aTasksDestructiveAll = $this->oDBUpgrader->aTaskList;
        if ($prune) {
            $this->aTasksDestructiveAll = $this->pruneTasklist('destructive');
        }
        if ($execute) {
//            if (!$this->oDBUpgrader->_backup())
//            {
//                return false;
//            }
            $this->mockMigration();
            $this->oDBUpgrader->aTaskList = $this->aTasksDestructiveAll;
            if (!$this->oDBUpgrader->_executeTasks()) {
                return false;
            }
        }
        if ($updateVersion) {
            $this->oUpgrader->oVersioner->putSchemaVersion('tables_core', $this->version);
        }
        return true;
    }

    public function mockMigration()
    {
        require_once MAX_PATH . '/lib/simpletest/mock_objects.php';
        require_once MAX_PATH . '/lib/OA/Upgrade/Migration.php';
        Mock::generatePartial(
            'Migration',
            $mockMigrator = 'Migration_' . rand(),
            array_keys($this->aMigrationMethods)
        );
        $this->oDBUpgrader->oMigrator = new $mockMigrator($this);

        foreach ($this->aMigrationMethods as $k => $v) {
            $this->oDBUpgrader->oMigrator->setReturnValue($k, $v);
            $this->oDBUpgrader->oMigrator->expectOnce($k);
        }
    }

    public function pruneTasklist($timing)
    {
        $this->aMigrationMethods = [];
        if ($timing == 'constructive') {
            if (isset($this->aTasksConstructiveSelected['tables']['add'])) {
                foreach ($this->aTasksConstructiveAll['tables']['add'] as $kAll => $vAll) {
                    foreach ($this->aTasksConstructiveSelected['tables']['add'] as $kSel => $vSel) {
                        $table = key($vSel);
                        if ($vAll['name'] == $table) {
                            $aTasks['tables']['add'][] = $vAll;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['constructive']['tables'][$table]['self']['afterAddTable']] = 1;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['constructive']['tables'][$table]['self']['beforeAddTable']] = 1;
                        }
                    }
                }
            }
            if (isset($this->aTasksConstructiveSelected['fields']['add'])) {
                foreach ($this->aTasksConstructiveAll['fields']['add'] as $kAll => $vAll) {
                    foreach ($this->aTasksConstructiveSelected['fields']['add'] as $kSel => $vSel) {
                        $table = key($vSel);
                        $field = $vSel[$table];
                        if ((($vAll['name'] == $table) && (($vAll['field'] == $field)))) {
                            $aTasks['fields']['add'][] = $vAll;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['constructive']['tables'][$table]['fields'][$field]['beforeAddField']] = 1;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['constructive']['tables'][$table]['fields'][$field]['afterAddField']] = 1;
                        }
                    }
                }
            }
            if (isset($this->aTasksConstructiveSelected['fields']['change'])) {
                foreach ($this->aTasksConstructiveAll['fields']['change'] as $kAll => $vAll) {
                    foreach ($this->aTasksConstructiveSelected['fields']['change'] as $kSel => $vSel) {
                        $table = key($vSel);
                        $field = $vSel[$table];
                        if ((($vAll['name'] == $table) && (($vAll['field'] == $field)))) {
                            $aTasks['fields']['add'][] = $vAll;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['constructive']['tables'][$table]['fields'][$field]['beforeAlterField']] = 1;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['constructive']['tables'][$table]['fields'][$field]['afterAlterField']] = 1;
                        }
                    }
                }
            }
            if (isset($this->aTasksConstructiveSelected['indexes']['remove'])) {
                foreach ($this->aTasksConstructiveAll['indexes']['remove'] as $kAll => $vAll) {
                    foreach ($this->aTasksConstructiveSelected['indexes']['remove'] as $kSel => $vSel) {
                        $table = key($vSel);
                        $index = $vSel[$table];
                        if ((($vAll['table'] == $table) && (($vAll['name'] == $index)))) {
                            $aTasks['indexes']['remove'][] = $vAll;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['constructive']['tables'][$table]['indexes'][$index]['beforeRemoveIndex']] = 1;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['constructive']['tables'][$table]['indexes'][$index]['afterRemoveIndex']] = 1;
                        }
                    }
                }
            }
            if (isset($this->aTasksConstructiveSelected['indexes']['add'])) {
                foreach ($this->aTasksConstructiveAll['indexes']['add'] as $kAll => $vAll) {
                    foreach ($this->aTasksConstructiveSelected['indexes']['add'] as $kSel => $vSel) {
                        $table = key($vSel);
                        $index = $vSel[$table];
                        if ((($vAll['table'] == $table) && (($vAll['name'] == $index)))) {
                            $aTasks['indexes']['add'][] = $vAll;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['constructive']['tables'][$table]['indexes'][$index]['beforeAddIndex']] = 1;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['constructive']['tables'][$table]['indexes'][$index]['afterAddIndex']] = 1;
                        }
                    }
                }
            }
        } elseif ($timing == 'destructive') {
            if (isset($this->aTasksDestructiveSelected['tables']['remove'])) {
                foreach ($this->aTasksDestructiveAll['tables']['remove'] as $kAll => $vAll) {
                    foreach ($this->aTasksDestructiveSelected['tables']['remove'] as $kSel => $vSel) {
                        $table = key($vSel);
                        if ($vAll['name'] == $table) {
                            $aTasks['tables']['remove'][] = $vAll;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['destructive']['tables'][$table]['self']['afterRemoveTable']] = 1;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['destructive']['tables'][$table]['self']['beforeRemoveTable']] = 1;
                        }
                    }
                }
            }
            if (isset($this->aTasksDestructiveSelected['fields']['remove'])) {
                foreach ($this->aTasksDestructiveAll['fields']['remove'] as $kAll => $vAll) {
                    foreach ($this->aTasksDestructiveSelected['fields']['remove'] as $kSel => $vSel) {
                        $table = key($vSel);
                        $field = $vSel[$table];
                        if ((($vAll['name'] == $table) && (($vAll['field'] == $field)))) {
                            $aTasks['fields']['remove'][] = $vAll;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['destructive']['tables'][$table]['fields'][$field]['beforeRemoveField']] = 1;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['destructive']['tables'][$table]['fields'][$field]['afterRemoveField']] = 1;
                        }
                    }
                }
            }
        }
        return $aTasks;
    }

    public function getMessages()
    {
        return $this->oUpgrader->getMessages();
    }

    public function getFileSchema()
    {
        return $this->oDBUpgrader->file_schema;
    }

    public function getFileChanges()
    {
        return $this->oDBUpgrader->file_changes;
    }

    public function getConstructiveOK()
    {
        return empty($this->aTasksConstructiveAll);
    }

    public function getDestructiveOK()
    {
        return empty($this->aTasksDestructiveAll);
    }

    public function _clearProperties()
    {
        $this->aTasksConstructiveAll = [];
        $this->aTasksDestructiveAll = [];
        $this->aTasksConstructiveSelected = [];
        $this->aTasksDestructiveSelected = [];
        $this->version = '';
    }

    public function _initDBUpgrader($schema = '')
    {
        $this->oDBUpgrader->prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $this->oDBUpgrader->database = $GLOBALS['_MAX']['CONF']['database']['name'];
        if (empty($schema)) {
            $this->oDBUpgrader->path_schema = MAX_PATH . '/etc/changes/';
            $this->oDBUpgrader->file_schema = $this->oDBUpgrader->path_schema . $this->_getXMLFilename();
        } else {
            $this->oDBUpgrader->path_schema = dirname($schema);
            $this->oDBUpgrader->file_schema = $schema;
        }

        $this->oDBUpgrader->path_changes = MAX_PATH . '/var/';
        $this->oDBUpgrader->file_changes = $this->oDBUpgrader->path_changes . $this->_getXMLFilename('changes');
    }

    public function _getXMLFilename($prefix = 'schema')
    {
        return $prefix . '_tables_core' . ($this->version ? '_' . $this->version : '') . '.xml';
    }
}

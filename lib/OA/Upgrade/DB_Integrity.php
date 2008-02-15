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

/**
 * database vs schema integrity methods
 */
class OA_DB_Integrity
{

    var $oUpgrader;
    var $oDBUpgrader;
    var $aTasksConstructiveAll;
    var $aTasksDestructiveAll;
    var $aTasksConstructiveSelected;
    var $aTasksDestructiveSelected;
    var $aMigrationMethods;

    var $version;
    var $OK = true;

    function OA_DB_Integrity()
    {

    }

    function init($version)
    {
        require_once MAX_PATH.'/lib/OA/Upgrade/Upgrade.php';
        $this->_clearProperties();
        $this->version                      = $version;
        $this->oUpgrader                    = new OA_Upgrade();
        if (!$this->oUpgrader->initDatabaseConnection())
        {
            return false;
        }
        $this->oDBUpgrader                  =&  $this->oUpgrader->oDBUpgrader;
        $this->_initDBUpgrader();
        $this->oUpgrader->oLogger->logClear();
        if (!$this->oDBUpgrader->buildSchemaDefinition())
        {
            return false;
        }
        return true;
    }

    // this one is called from within OA_Upgrade during detectMax
    // OA_Upgrade assigns itself after instantiation
    // compiles constructive tasks but does not prune or execute
    function checkIntegrityQuick($version)
    {
        $this->_clearProperties();
        $this->version                      = $version;
        $this->oDBUpgrader                  =&  $this->oUpgrader->oDBUpgrader;
        $this->_initDBUpgrader();
        if (!$this->oDBUpgrader->buildSchemaDefinition())
        {
            return false;
        }
        if (!$this->oDBUpgrader->applySchemaDefinitionChanges($this->version))
        {
            return false;
        }
        if (! $this->oDBUpgrader->checkSchemaIntegrity($this->getFileChanges()))
        {
            return false;
        }
        if (!$this->oDBUpgrader->init('constructive', 'tables_core', $this->version, 'switchTiming'))
        {
            return false;
        }
        if (!$this->oDBUpgrader->_verifyTasks())
        {
            return false;
        }
        $this->aTasksConstructiveAll = $this->oDBUpgrader->aTaskList;
        return true;
    }

    // this one is called via standalone util
    // which calls the init method to instantiate OA_Upgrade
    // compiles, prunes and executes constructive and destructive tasks
    function checkIntegrity()
    {
        if (! $this->oDBUpgrader->checkSchemaIntegrity($this->getFileChanges()))
        {
            return false;
        }
        if (!$this->oDBUpgrader->init('constructive', 'tables_core', $this->version, 'switchTiming'))
        {
            return false;
        }
        if (!$this->oDBUpgrader->_verifyTasks())
        {
            return false;
        }
        $this->aTasksConstructiveAll = $this->oDBUpgrader->aTaskList;
        if (!$this->oDBUpgrader->init('destructive', 'tables_core', $this->version, 'switchTiming'))
        {
            return false;
        }
        if (!$this->oDBUpgrader->_verifyTasks())
        {
            return false;
        }
        $this->aTasksDestructiveAll = $this->oDBUpgrader->aTaskList;

        return true;
    }

    function compileExecuteTasklist($prune = false, $execute = false, $updateVersion = false)
    {
        if (!$this->oDBUpgrader->buildChangesetDefinition())
        {
            return false;
        }
        if (!$this->oDBUpgrader->init('constructive', 'tables_core', $this->version, 'switchTiming'))
        {
            return false;
        }
        if (!$this->oDBUpgrader->_verifyTasks())
        {
            return false;
        }
        $this->aTasksConstructiveAll = $this->oDBUpgrader->aTaskList;
        if ($prune)
        {
            $this->aTasksConstructiveAll = $this->pruneTasklist('constructive');
        }
        if ($execute)
        {
//            if (!$this->oDBUpgrader->_backup())
//            {
//                return false;
//            }
            $this->mockMigration();
            $this->oDBUpgrader->aTaskList = $this->aTasksConstructiveAll;
            if (!$this->oDBUpgrader->_executeTasks())
            {
                return false;
            }
        }
        if (!$this->oDBUpgrader->init('destructive', 'tables_core', $this->version, 'switchTiming'))
        {
            return false;
        }
        if (!$this->oDBUpgrader->_verifyTasks())
        {
            return false;
        }
        $this->aTasksDestructiveAll = $this->oDBUpgrader->aTaskList;
        if ($prune)
        {
            $this->aTasksDestructiveAll = $this->pruneTasklist('destructive');
        }
        if ($execute)
        {
//            if (!$this->oDBUpgrader->_backup())
//            {
//                return false;
//            }
            $this->mockMigration();
            $this->oDBUpgrader->aTaskList = $this->aTasksDestructiveAll;
            if (!$this->oDBUpgrader->_executeTasks())
            {
                return false;
            }
        }
        if ($$updateVersion)
        {
            $this->oUpgrader->oVersioner->putSchemaVersion('tables_core',$this_>version);
        }
        return true;
    }

    function mockMigration()
    {
        require_once MAX_PATH.'/lib/simpletest/mock_objects.php';
        require_once MAX_PATH.'/lib/OA/Upgrade/Migration.php';
        Mock::generatePartial(
            'Migration',
            $mockMigrator = 'Migration_'.rand(),
            array_keys($this->aMigrationMethods)
        );
        $this->oDBUpgrader->oMigrator = new $mockMigrator($this);

        foreach ($this->aMigrationMethods as $k => $v)
        {
            $this->oDBUpgrader->oMigrator->setReturnValue($k, $v);
            $this->oDBUpgrader->oMigrator->expectOnce($k);
        }
    }

    function pruneTasklist($timing)
    {
        $this->aMigrationMethods = array();
        if ($timing=='constructive')
        {
            if (isset($this->aTasksConstructiveSelected['tables']['add']))
            {
                foreach ($this->aTasksConstructiveAll['tables']['add'] AS $kAll => $vAll)
                {
                    foreach ($this->aTasksConstructiveSelected['tables']['add'] AS $kSel => $vSel)
                    {
                        $table = key($vSel);
                        if ($vAll['name']==$table)
                        {
                            $aTasks['tables']['add'][] = $vAll;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['constructive']['tables'][$table]['self']['afterAddTable']] = 1;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['constructive']['tables'][$table]['self']['beforeAddTable']] = 1;
                        }
                    }
                }
            }
            if (isset($this->aTasksConstructiveSelected['fields']['add']))
            {
                foreach ($this->aTasksConstructiveAll['fields']['add'] AS $kAll => $vAll)
                {
                    foreach ($this->aTasksConstructiveSelected['fields']['add'] AS $kSel => $vSel)
                    {
                        $table = key($vSel);
                        $field = $vSel[$table];
                        if ((($vAll['name']==$table) && (($vAll['field']==$field))))
                        {
                            $aTasks['fields']['add'][] = $vAll;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['constructive']['tables'][$table]['fields'][$field]['beforeAddField']] = 1;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['constructive']['tables'][$table]['fields'][$field]['afterAddField']] = 1;
                        }
                    }
                }
            }
            if (isset($this->aTasksConstructiveSelected['fields']['change']))
            {
                foreach ($this->aTasksConstructiveAll['fields']['change'] AS $kAll => $vAll)
                {
                    foreach ($this->aTasksConstructiveSelected['fields']['change'] AS $kSel => $vSel)
                    {
                        $table = key($vSel);
                        $field = $vSel[$table];
                        if ((($vAll['name']==$table) && (($vAll['field']==$field))))
                        {
                            $aTasks['fields']['add'][] = $vAll;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['constructive']['tables'][$table]['fields'][$field]['beforeAlterField']] = 1;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['constructive']['tables'][$table]['fields'][$field]['afterAlterField']] = 1;
                        }
                    }
                }
            }
            if (isset($this->aTasksConstructiveSelected['indexes']['remove']))
            {
                foreach ($this->aTasksConstructiveAll['indexes']['remove'] AS $kAll => $vAll)
                {
                    foreach ($this->aTasksConstructiveSelected['indexes']['remove'] AS $kSel => $vSel)
                    {
                        $table = key($vSel);
                        $index = $vSel[$table];
                        if ((($vAll['table']==$table) && (($vAll['name']==$index))))
                        {
                            $aTasks['indexes']['remove'][] = $vAll;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['constructive']['tables'][$table]['indexes'][$index]['beforeRemoveIndex']] = 1;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['constructive']['tables'][$table]['indexes'][$index]['afterRemoveIndex']] = 1;
                        }
                    }
                }
            }
            if (isset($this->aTasksConstructiveSelected['indexes']['add']))
            {
                foreach ($this->aTasksConstructiveAll['indexes']['add'] AS $kAll => $vAll)
                {
                    foreach ($this->aTasksConstructiveSelected['indexes']['add'] AS $kSel => $vSel)
                    {
                        $table = key($vSel);
                        $index = $vSel[$table];
                        if ((($vAll['table']==$table) && (($vAll['name']==$index))))
                        {
                            $aTasks['indexes']['add'][] = $vAll;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['constructive']['tables'][$table]['indexes'][$index]['beforeAddIndex']] = 1;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['constructive']['tables'][$table]['indexes'][$index]['afterAddIndex']] = 1;
                        }
                    }
                }
            }
        }
        else if ($timing=='destructive')
        {
            if (isset($this->aTasksDestructiveSelected['tables']['remove']))
            {
                foreach ($this->aTasksDestructiveAll['tables']['remove'] AS $kAll => $vAll)
                {
                    foreach ($this->aTasksDestructiveSelected['tables']['remove'] AS $kSel => $vSel)
                    {
                        $table = key($vSel);
                        if ($vAll['name']==$table)
                        {
                            $aTasks['tables']['remove'][] = $vAll;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['destructive']['tables'][$table]['self']['afterRemoveTable']] = 1;
                            $this->aMigrationMethods[$this->oDBUpgrader->aChanges['hooks']['destructive']['tables'][$table]['self']['beforeRemoveTable']] = 1;
                        }
                    }
                }
            }
            if (isset($this->aTasksDestructiveSelected['fields']['remove']))
            {
                foreach ($this->aTasksDestructiveAll['fields']['remove'] AS $kAll => $vAll)
                {
                    foreach ($this->aTasksDestructiveSelected['fields']['remove'] AS $kSel => $vSel)
                    {
                        $table = key($vSel);
                        $field = $vSel[$table];
                        if ((($vAll['name']==$table) && (($vAll['field']==$field))))
                        {
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

    function getMessages()
    {
        return $this->oUpgrader->getMessages();
    }

    function getFileSchema()
    {
        return $this->oDBUpgrader->file_schema;
    }

    function getFileChanges()
    {
        return $this->oDBUpgrader->file_changes;
    }

    function getConstructiveOK()
    {
        return empty($this->aTasksConstructiveAll);
    }

    function getDestructiveOK()
    {
        return empty($this->aTasksDestructiveAll);
    }

    function _clearProperties()
    {
        $this->aTasksConstructiveAll        = array();
        $this->aTasksDestructiveAll         = array();
        $this->aTasksConstructiveSelected   = array();
        $this->aTasksDestructiveSelected    = array();
        $this->version                      = '';
    }

    function _initDBUpgrader()
    {
        $this->oDBUpgrader->prefix          = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $this->oDBUpgrader->database        = $GLOBALS['_MAX']['CONF']['database']['name'];
        $this->oDBUpgrader->path_schema     = MAX_PATH.'/etc/changes/';
        $this->oDBUpgrader->file_schema     = $this->oDBUpgrader->path_schema.'schema_tables_core_'.$this->version.'.xml';
        $this->oDBUpgrader->path_changes    = MAX_PATH.'/var/';
        $this->oDBUpgrader->file_changes    = $this->oDBUpgrader->path_changes.'changes_tables_core_'.$this->version.'.xml';
    }

    function _resetDBUpgrader()
    {
        $this->oDBUpgrader->prefix          = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $this->oDBUpgrader->database        = $GLOBALS['_MAX']['CONF']['database']['name'];
        $this->oDBUpgrader->path_schema     = MAX_PATH.'/etc/changes/';
        $this->oDBUpgrader->file_schema     = $this->oDBUpgrader->path_schema.'schema_tables_core_'.$this->version.'.xml';
        $this->oDBUpgrader->path_changes    = MAX_PATH.'/var/';
        $this->oDBUpgrader->file_changes    = $this->oDBUpgrader->path_changes.'changes_tables_core_'.$this->version.'.xml';
    }

}


?>
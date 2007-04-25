<?php
/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
/**
 * Openads Upgrade Class
 *
 * @author Monique Szpak <monique.szpak@openads.org>
 *
 * $Id $
 *
 */
require_once 'MDB2.php';
require_once 'MDB2/Schema.php';

require_once MAX_PATH.'/lib/OA/DB.php';
require_once(MAX_PATH.'/lib/OA/Upgrade/UpgradeLogger.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/DB_Upgrade.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/DB_UpgradeAuditor.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/UpgradePackageParser.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/VersionController.php');

class OA_Upgrade
{
    var $upgradePath = '';

    var $oLogger;
    var $oParser;
    var $oDBUpgrader;
    var $oVersioner;
    var $oDBAuditor;
    var $oDbh;

    var $aPackage    = array();
    var $aDBPackages = array();

    var $versionInitialApplication;
    var $versionInitialSchema = array();

    function OA_Upgrade()
    {
        $this->upgradePath  = MAX_PATH.'/var/upgrade/';

        $this->oLogger      = new OA_UpgradeLogger();
        $this->oParser      = new OA_UpgradePackageParser();
        $this->oDBUpgrader  = new OA_DB_Upgrade($this->oLogger);
        $this->oDbh         = $this->oDBUpgrader->oSchema->db;
        $this->oDBAuditor   = new OA_DB_UpgradeAuditor();
        $this->oVersioner   = new OA_Version_Controller();
        $this->oVersioner->init($this->oDbh);
        $this->oDBAuditor->init($this->oDbh, $this->oLogger);
        $this->oDBUpgrader->oAuditor = &$this->oDBAuditor;
    }

    function init($input_file, $timing='constructive')
    {
        $logFile = str_replace('.xml', '', $input_file).'_'.$timing.'_'.date('Y_m_d_h_i_s').'.log';
        $this->oLogger->setLogFile($logFile);

        $this->aPackage     = $this->_parseUpgradePackageFile($this->upgradePath.$input_file);
        $this->aDBPackages  = $this->aPackage['db_pkgs'];

        $this->versionInitialApplication = $this->oVersioner->getApplicationVersion();
    }

    function upgradeSchemas()
    {
        foreach ($this->aDBPackages as $k=>$aPkg)
        {
            if (!array_key_exists($aPkg['schema'],$this->versionInitialSchema))
            {
                $this->versionInitialSchema[$aPkg['schema']] = $this->oVersioner->getSchemaVersion($aPkg['schema']);
            }
            if ($this->oDBUpgrader->init($timing, $aPkg['schema'], $aPkg['version']))
            {
                if ($this->oDBUpgrader->upgrade())
                {
                    $this->oVersioner->putSchemaVersion($aPkg['schema'], $aPkg['version']);
                }
                else
                {
                    $this->rollbackSchemas();
                    return false;
                }
            }
        }
        return true;
    }

    function rollbackSchemas()
    {
        foreach ($this->versionInitialSchema AS $schema => $version)
        {
            if ($this->oVersioner->getSchemaVersion($schema) != $version)
            {
                if ($this->oDBUpgrader->init($timing, $schema, $version))
                {
                    if ($this->oDBUpgrader->rollback())
                    {
                        $this->oVersioner->putSchemaVersion($schema, $version);
                    }
                    else
                    {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    function _parseUpgradePackageFile($input_file)
    {
        $result = $this->oParser->setInputFile($input_file);
        if (PEAR::isError($result)) {
            return $result;
        }

        $result = $this->oParser->parse();
        if (PEAR::isError($result)) {
            return $result;
        }
        if (PEAR::isError($this->oParser->error)) {
            return $this->oParser->error;
        }

        return $this->oParser->aPackage;
    }

    function _getPackageList()
    {
        $aFiles = array();
        $dh = opendir($this->upgradePath);
        if ($dh) {
            while (false !== ($file = readdir($dh)))
            {
                $aMatches = array();
                if (preg_match('/openads_upgrade_[\w\W\d]+_to_([\w\W\d])+\.xml/', $file, $aMatches))
                {
                    $aFiles[] = $file;
                }
            }
        }
        closedir($dh);
        return $aFiles;
    }

    /**
     * Open each changeset and determine the version and timings
     *
     * @return boolean
     */
    function _compileChangesetInfo()
    {
        $this->aChangesetList = $this->_getChangesetList();
        foreach ($this->aChangesetList as $version=>$aFiles)
        {
            $file       = MAX_PATH.'/etc/changes/'.$aFiles['changeset'];
            $aChanges   = $this->oDBUpgrader->oSchema->parseChangesetDefinitionFile($file);
            if (!$this->_isPearError($aChanges, "failed to parse changeset ({$file})"))
            {
                $this->_log('changeset found in file: '.$file);
                $this->_log('name: '.$aChanges['name']);
                $this->_log('version: '.$aChanges['version']);
                $this->_log('comments: '.$aChanges['comments']);
                $this->_log(($aChanges['constructive'] ? 'constructive changes found' : 'constructive changes not found'));
                $this->_log(($aChanges['destructive'] ? 'destructive changes found' : 'destructive changes not found'));
            }
            else
            {
                return false;
            }
        }
        return true;
    }
    /**
     * Open each changeset and determine the version and timings
     *
     * @return boolean
     */
    function _checkChangesetAudit($schema)
    {
        $aResult = $this->oDBAuditor->queryAudit('', '', $schema, DB_UPGRADE_ACTION_UPGRADE_SUCCEEDED);
        if ($aResult)
        {
            foreach ($aResult as $k=>$v)
            {
                $this->oLogger->log($v['schema_name'].' upgraded to version '.$v['version'].' on '.$v['updated']);
            }
        }
        return true;
    }

    function getMessages()
    {
        return $this->oLogger->aMessages;
    }

    function getErrors()
    {
        return $this->oLogger->aErrors;
    }

    /**
     * compile a list of changesets available in /etc/changes
     * could be used for a changeset manager
     *
     *
     * @return array
     */
    /*
    function _getChangesetList($schema)
    {
        $aFiles = array();
        $dh = opendir(MAX_PATH.'/etc/changes');
        if ($dh) {
            while (false !== ($file = readdir($dh)))
            {
                $aMatches = array();
                if (preg_match("/schema_{$schema}_([\d])+\.xml/", $file, $aMatches))
                {
                    $version = $aMatches[1];
                    $fileSchema = basename($file);
                    $aFiles[$version] = array();
                    $fileChanges = str_replace('schema', 'changes', $fileSchema);
                    $fileMigrate = str_replace('schema', 'migration', $fileSchema);
                    $fileMigrate = str_replace('xml', 'php', $fileMigrate);
                    if (!file_exists(MAX_CHG.$fileChanges))
                    {
                        $fileChanges = 'not found';
                    }
                    $aFiles[$version]['changeset'] = $fileChanges;
                    if (!file_exists(MAX_CHG.$fileMigrate))
                    {
                        $fileMigrate = 'not found';
                    }
                    $aFiles[$version]['migration'] = $fileMigrate;
                    $aFiles[$version]['schema'] = $fileSchema;
                }
            }
        }
        closedir($dh);
        return $aFiles;
    }
    */

}

?>
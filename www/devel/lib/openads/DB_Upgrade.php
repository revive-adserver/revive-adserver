<?php
/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
 * Openads Schema Management Utility
 *
 * @author Monique Szpak <monique.szpak@openads.org>
 *
 * $Id $
 *
 */

//require_once MAX_DEV.'/lib/pear.inc.php';
//require_once 'MDB2.php';
//require_once 'MDB2/Schema.php';
//require_once 'Config.php';
//
//require_once MAX_PATH.'/lib/OA/DB.php';
//require_once MAX_PATH.'/lib/OA/DB/Table.php';
//require_once MAX_PATH.'/lib/OA/Dal/Links.php';

class Openads_DB_Upgrade
{
    var $versionFrom;
    var $versionTo;

    var $path_changes;
    //var $path_schema;
    //var $path_links;
    //var $path_dbo;

    var $file_schema;
    var $file_changes;
    var $file_migrate;
    //var $file_links;

    var $oSchema;

    var $aDB_definition;
    var $aChanges;
    var $aChangesConstructive;
    var $aChangesDestructive;

    var $aErrors;
    var $aMessages;

    var $timing;

    /**
     * php5 class constructor
     *
     */
    function __construct()
    {
    }

    /**
     * php4 class constructor
     *
     */
    function Openads_DB_Upgrade()
    {
        $this->__construct();
    }

    function init($versionTo, $versionFrom='')
    {
        $this->aErrors = array();
        $this->aMessages = array();

        $this->versionFrom  = ($versionFrom ? $versionFrom : 1);
        $this->versionTo    = $versionTo;

        $this->path_changes = MAX_PATH.'/etc/changes/';
        //$this->path_schema  = MAX_PATH.'/etc/';
        //$this->path_links   = MAX_PATH.'/etc/';
        //$this->path_dbo     = $this->path_changes.'DataObjects_'.$this->versionTo;

        $this->file_schema  = $this->path_changes.'schema_'.$this->versionTo.'.xml';
        $this->file_changes = $this->path_changes.'changes_'.$this->versionTo.'.xml';
        $this->file_migrate = $this->path_changes.'migration_'.$this->versionTo.'.php';
        //$this->file_links   = $this->path_links.'db_schema.links.ini';

        if (!file_exists($this->file_schema))
        {
            $this->aErrors[] = 'boo! file not found: '.$this->file_schema;
            return false;
        }
        else
        {
            $this->aMessages[] = 'yay! file found: '.$this->file_schema;
        }
        if (!file_exists($this->file_changes))
        {
            $this->aErrors[] = 'boo! file not found: '.$this->file_changes;
            return false;
        }
        else
        {
            $this->aMessages[] = 'yay! file found: '.$this->file_changes;
        }
        if (!file_exists($this->file_migrate))
        {
            $this->aMessages[] = 'hmmm.. file not found: '.$this->file_migrate.' (assuming no migration necessary)';
        }
        else
        {
            $this->aMessages[] = 'yay! file found: '.$this->file_migrate;
        }
        $this->aMessages[] = 'successfully initialised DB Upgrade';
        return true;
    }

    function upgrade($timing='constructive')
    {

        $result  = & MDB2_Schema::factory(OA_DB::singleton(OA_DB::getDsn()));
        if (!PEAR::isError($result))
        {
            $this->oSchema = $result;
            $result = $this->oSchema->parseDatabaseDefinitionFile($this->file_schema);
            if (!PEAR::isError($result))
            {
                $this->aDB_definition = $result;
                $this->aMessages[] = 'successfully parsed the schema';
                $this->aMessages[] = 'schema name: '.$this->aDB_definition['name'];
                $this->aMessages[] = 'schema version: '.$this->aDB_definition['version'];
                $this->aMessages[] = 'schema status: '.$this->aDB_definition['status'];

                $result = $this->oSchema->parseChangesetDefinitionFile($this->file_changes);
                if (!PEAR::isError($result))
                {
                    $this->aChanges = $result;
                    $this->aMessages[] = 'successfully parsed the changeset';
                    $this->aMessages[] = 'changeset name: '.$this->aChanges['name'];
                    $this->aMessages[] = 'changeset version: '.$this->aChanges['version'];
                    $this->aMessages[] = ($this->aDB_definition['version']==$this->aChanges['version'] ? 'yay! schema and changeset versions match' : 'hmmm.. schema and changeset versions don\'t match');
                    $this->aMessages[] = ($this->aChanges['constructive'] ? 'constructive changes found' : 'constructive changes not found');
                    $this->aMessages[] = ($this->aChanges['destructive'] ? 'destructive changes found' : 'destructive changes not found');
                }
                else
                {
                    $this->aErrors[] = 'failed to parse changeset ('.$this->file_changes.'): '.$result->getMessage();
                    return false;
                }
            }
            else
            {
                $this->aErrors[] = 'failed to parse new schema ('.$this->file_schema.'): '.$result->getMessage();
                return false;
            }
        }
        else
        {
            $this->aErrors[] = 'failed to instantiate MDB2_Schema: '.$result->getMessage();
            return false;
        }
        $this->aMessages[] = 'executing '.$timing.' changes';
        $this->timing = $timing;
        $this->aChanges = $this->aChanges[$timing];
        $this->oSchema->verifyAlterDatabase($this->aChanges);
        return true;
    }

    function downgrade($timing)
    {

    }

    function _createBackup()
    {

    }

    function _dropBackup()
    {

    }
}
?>
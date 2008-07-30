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
/**
 * OpenX Schema Management Utility
 *
 * @author     Monique Szpak <monique.szpak@openx.org>
 *
 * $Id$
 *
 */

//require_once PATH_DEV.'/lib/upms.inc.php';

require_once 'lib/pear.inc.php';
require_once 'MDB2.php';
require_once 'MDB2/Schema.php';
require_once 'Config.php';

require_once MAX_PATH.'/lib/OA/DB.php';
require_once MAX_PATH.'/lib/OA/DB/Table.php';
require_once MAX_PATH.'/lib/OA/Dal/Links.php';
require_once MAX_PATH.'/lib/OA/Upgrade/UpgradeLogger.php';

class Openads_Schema_Manager
{

    var $oSchema;

    var $aDB_definition;

    var $aDump_options;
    var $aDD_definition;
    var $dd_file;

    var $path_schema_final;
    var $path_schema_trans;

    var $path_changes_final;
    var $path_changes_trans;

    var $path_links_final;
    var $path_links_trans;

    var $path_dbo;
    var $use_links;

    var $file_schema_core;
    var $schema_final;
    var $schema_trans;

    var $file_changes_core;
    var $changes_final;
    var $changes_trans;

    var $file_links_core;
    var $links_final = false;
    var $links_trans = false;

    var $working_file_schema;
    var $working_file_links;

    var $oValidator;

    var $version;

    var $aFile_perms;

    var $dbo_name = 'openads_dbo';

    var $oLogger;

    var $aXMLRPCServer = false;

    /**
     * php5 class constructor
     *
     * @param string The XML schema file we are working on
     */
    function __construct($file_schema = 'tables_core.xml', $file_changes='', $path_schema)
    {
        $this->oLogger = new OA_UpgradeLogger();
        $this->oLogger->setLogFile('schema.log');

        if (empty($path_schema))
        {
            $path_schema = '/etc/';
        }
        if (!empty($path_schema) && (substr($path_schema,0,1)!='/'))
        {
            $path_schema = '/'.$path_schema;
        }
        if (!empty($path_schema) && (substr($path_schema,strlen($path_schema)-4,4)!='etc/'))
        {
            $path_schema = $path_schema.'etc/';
        }

        $this->path_schema_final  = MAX_PATH.$path_schema;
        $this->path_schema_trans  = MAX_PATH.'/var/';
        $this->path_changes_final = MAX_PATH.$path_schema.'changes/';
        $this->path_changes_trans = MAX_PATH.'/var/';

        if ($path_schema == '/etc/')
        {
            $this->path_dbo = MAX_PATH.'/lib/max/Dal/DataObjects/';
        }
        else
        {
            $this->path_dbo = $this->path_schema_final.'DataObjects/';
        }

        //$this->path_links_final = MAX_PATH.'/lib/max/Dal/DataObjects/';
        $this->path_links_final = $this->path_dbo;
        $this->path_links_trans = MAX_PATH.'/var/';

        $file_changes   = ($file_changes ? $file_changes : 'changes_'.$file_schema);
        $file_links     = 'db_schema.links.ini';

        $this->schema_final = $this->path_schema_final.$file_schema;
        $this->schema_trans = $this->path_schema_trans.$file_schema;

        $this->oLogger->log($this->schema_final);

        $this->use_links = ($file_schema=='tables_core.xml');
        if ($this->use_links)
        {
            $this->links_final = $this->path_links_final.$file_links;
            $this->links_trans = $this->path_links_trans.$file_links;
        }

        $this->changes_final = $this->path_changes_final.$file_changes;
        $this->changes_trans = $this->path_changes_trans.$file_changes;

        $this->oLogger->log($this->changes_final);

        if ($this->use_links)
        {
            $this->aFile_perms = array(
                                        $this->path_schema_trans,
                                        $this->path_changes_final,
                                        $this->path_changes_trans,
                                        $this->path_links_trans,
                                        $this->links_final,
                                        $this->schema_final,
                                        MAX_SCHEMA_LOG,
                                        MAX_PATH.'/www/devel/'
                                    );
        }
        else
        {
            $this->aFile_perms = array(
                                        $this->path_schema_trans,
                                        $this->path_changes_final,
                                        $this->path_changes_trans,
                                        $this->schema_final,
                                        MAX_SCHEMA_LOG,
                                        MAX_PATH.'/www/devel/'
                                    );
        }


        $this->aDump_options = array (
                                        'output_mode'   =>    'file',
                                        'output'        =>    $this->schema_trans,
                                        'end_of_line'   =>    "\n",
                                        'xsl_file'      =>    "xsl/mdb2_schema.xsl",
                                        'custom_tags'   => array('version'=>'', 'status'=>'transitional')
                                      );

        //$GLOBALS['_MAX']['CONF']['database']['name'] = $this->dbo_name;
        $this->oSchema  = MDB2_Schema::factory(OA_DB::singleton(OA_DB::getDsn()), $this->aDump_options);

        $this->dd_file = PATH_DEV.'/etc/dd.generic.xml';
        $this->aDD_definition = $this->oSchema->parseDictionaryDefinitionFile($this->dd_file);
        ksort($this->aDD_definition);

        //$this->aXMLRPCServer = array('path'=>'/upms/xmlrpc.php', 'host'=>'localhost','port'=>'80');
    }

    /**
     * php4 class constructor
     *
     * @param string The XML schema file we are working on
     */
    function Openads_Schema_Manager($schema_file = 'tables_core.xml')
    {
        $this->__construct($schema_file);
    }

    function createNew($name)
    {
        $this->aDump_options['custom_tags']['version']  = '000';
        $this->aDump_options['custom_tags']['status']   = 'final';
        $this->aDump_options['output']       = $this->path_schema_trans.'tables_'.$name.'.xml';
        $this->aDump_options['xsl_file']     = "xsl/mdb2_schema.xsl";
        $this->aDB_definition['name']        = $name;
        $result = $this->oSchema->dumpDatabase($this->aDB_definition, $this->aDump_options, MDB2_SCHEMA_DUMP_STRUCTURE, false);
        if (!Pear::iserror($result))
        {
            return true;
        }
        $this->oLogger->logError($result->getUserInfo());
        return false;
    }

    /**
     * use mdb2_schema to compare 2 definition files
     * write the changeset array in xmlformat
     *
     * @param string $output : path and filename for output
     * @return boolean
     */
    function createChangeset($output='', $comments='', $version='')
    {
        if (file_exists($this->schema_trans) && file_exists($this->schema_final))
        {
            $aPrev_definition                   = $this->oSchema->parseDatabaseDefinitionFile($this->schema_final);
            $aCurr_definition                   = $this->oSchema->parseDatabaseDefinitionFile($this->schema_trans);
            //$aCurr_definition                   = $this->aDB_definition;
            $aChanges                           = $this->oSchema->compareDefinitions($aCurr_definition, $aPrev_definition);
            if (isset($aChanges['tables']['add']))
            {
                foreach ($aChanges['tables']['add'] AS $table => $val)
                {
                    $aChanges['tables']['add'][$table] = array('was'=>$table);
                }
            }
            $this->aDump_options['output']      = ($output ? $output : $this->changes_trans);
            $this->aDump_options['xsl_file']    = "xsl/mdb2_changeset.xsl";
            $this->aDump_options['split']       = true;
            $aChanges['version']                = ($version ? $version : $aCurr_definition['version']);
            $aChanges['name']                   = $aCurr_definition['name'];
            $aChanges['comments']               = htmlspecialchars($comments);
            $result = $this->oSchema->dumpChangeset($aChanges, $this->aDump_options);
            if (!Pear::iserror($result))
            {
                return true;
            }
            else
            {
                $this->oLogger->logError($result->getUserInfo());
                return false;
            }
        }
        else
        {
            $this->oLogger->logError('one or more files not found:');
            $this->oLogger->logError($this->schema_trans);
            $this->oLogger->logError($this->schema_final);
        }
        return false;
    }

    /**
     * use mdb2_schema to compare 2 definition files
     * write the changeset array in xmlformat
     *
     * @param string $output : path and filename for output
     * @return boolean
     */
    function saveChangeset($input_file, $comments='')
    {
        if (file_exists($input_file))
        {
            $aChanges                           = $this->oSchema->parseChangesetDefinitionFile($input_file);
            $this->aDump_options['output']      = ($output ? $output : $this->changes_trans);
            $this->aDump_options['xsl_file']    = "xsl/mdb2_changeset.xsl";
            $aChanges['comments']               = $comments;
            $this->aDump_options['split']       = true;
            $result = $this->oSchema->dumpChangeset($aChanges, $this->aDump_options);
            if (!Pear::iserror($result))
            {
                return true;
            }
            else
            {
                $this->oLogger->logError($result->getUserInfo());
                return false;
            }
        }
        $this->oLogger->logError('file not found: '.$input_file);
        return false;
    }

    /**
     * create a copy of the final schema for editing
     * create a copy of the final links file for editing
     *
     * @return boolean
     */
    function createTransitional()
    {
        $result = ($this->deleteSchemaTrans() &&  $this->deleteLinksTrans());
        if ($result)
        {
            $result = (file_exists($this->schema_final));
            if ($result)
            {
                $this->working_file_schema = $this->schema_final;
                $this->parseWorkingDefinitionFile();
                $this->version = $this->_getNextVersion();
                $this->writeWorkingDefinitionFile();
                $result = file_exists($this->schema_trans);
            }
            if ($result && $this->use_links)
            {
                $result = (!empty($this->links_final) && file_exists($this->links_final));
                if ($result)
                {
                    copy($this->links_final, $this->links_trans);
                    $result = file_exists($this->links_trans);
                }
            }
        }
        return $result;
    }

    /**
     * stamp the transitional files as final
     * copy transitional files to final destinations
     * remove transitional files
     *
     * @return boolean
     */
    function commitFinal($comments='', $version='')
    {
        if ($this->use_links && (!file_exists($this->links_trans)))
        {
            return false;
        }
        if (!file_exists($this->schema_trans))
        {
            return false;
        }
        if (!$this->setWorkingFiles())
        {
            return false;
        }
        if (!$this->parseWorkingDefinitionFile())
        {
            return false;
        }
        $this->version =  ($version ? $version : $this->version);
        $basename = $this->_getBasename();
        $this->aDB_definition['version'] =  $this->version;
        $this->aDump_options['custom_tags']['status']='final';
        $this->changes_final = $this->path_changes_final.'changes_'.$basename.'.xml';
        if (!$this->createChangeset($this->changes_final, $comments, $version))
        {
            return false;
        }
        if (!$this->writeWorkingDefinitionFile($this->schema_final))
        {
            return false;
        }
        if (!$this->writeWorkingDefinitionFile($this->path_changes_final.'schema_'.$basename.'.xml'))
        {
            return false;
        }
        if (!$this->_generateDataObjects($this->changes_final, $basename))
        {
            return false;
        }
        if ($this->use_links)
        {
            copy($this->links_trans, $this->links_final);
        }
        if (!$this->writeMigrationClass($this->changes_final, $this->path_changes_final))
        {
            return false;
        }
        $this->deleteTransitional();
        return true;
    }

    /**
     *
     * @return integer
     */
    function _getNextVersion()
    {
        if (!$this->aXMLRPCServer)
        {
            $id = $this->version + 1;
        }
        else
        {
            $id = $this->_getNextVersionXMLRPC();
        }
        return str_pad($id, 3, '0', STR_PAD_LEFT);
    }

    /**
     * take the name of the final schema
     * insert the version number
     * return the basename
     *
     * this is used as the basis of all output files
     *
     * note: schema_final should never point to a *copy* of the final file
     * i.e. should be tables_core.xml NOT tables_core_2.xml
     *
     * @return string
     */
    function _getBasename()
    {
        return basename(str_replace('.xml', '_'.$this->version,$this->schema_final));
    }

    /**
     * assign a schema file and a links file to this instance
     * transitional if they exist, final if they don't
     *
     * @return boolean
     */
    function setWorkingFiles()
    {
        if (file_exists($this->schema_trans))
        {
            $this->working_file_schema = $this->schema_trans;
        }
        else if (file_exists($this->schema_final))
        {
            $this->working_file_schema = $this->schema_final;
        }

        if ($this->use_links)
        {
            if (!empty($this->links_trans) && file_exists($this->links_trans))
            {
                $this->working_file_links = $this->links_trans;
            }
            else if (!empty($this->links_final) && file_exists($this->links_final))
            {
                $this->working_file_links = $this->links_final;
            }
        }
        return file_exists($this->working_file_schema);
    }

    /**
     * read the working schema file and parse the xml to an array
     * assign the array to the current working definition property
     *
     * @return boolean
     */
    function parseWorkingDefinitionFile()
    {
        if (file_exists($this->working_file_schema))
        {
            $result = $this->oSchema->parseDatabaseDefinitionFile($this->working_file_schema);
            if (!Pear::iserror($result))
            {
                $this->aDB_definition = $result;
                $this->version = $this->aDB_definition['version'];
                return true;
            }
            else
            {
                $this->oLogger->logError($result->getUserInfo());
                return false;
            }
        }
        $this->oLogger->logError('file not found: '.$this->working_file_schema);
        $this->aDB_definition = array();
        return false;
    }

    /**
     * write the current definition array to file in xml format
     *
     * @param strin $output : path and filename for output
     * @return boolean
     */
    function writeWorkingDefinitionFile($output='')
    {
        $this->aDump_options['custom_tags']['version'] = $this->version;
        $this->aDump_options['output']       = ($output ? $output : $this->schema_trans);
        $this->aDump_options['xsl_file']     = "xsl/mdb2_schema.xsl";
        $result = $this->oSchema->dumpDatabase($this->aDB_definition, $this->aDump_options, MDB2_SCHEMA_DUMP_STRUCTURE, false);
        if (!Pear::iserror($result))
        {
            return true;
        }
        $this->oLogger->logError($result->getUserInfo());
        return false;
    }

    /**
     * erase all transitional files
     *
     * @return boolean
     */
    function deleteTransitional()
    {
        return $this->deleteLinksTrans() &&
               $this->deleteChangesTrans() &&
               $this->deleteSchemaTrans();
    }

    /**
     * erase the transitional links file
     *
     * @return boolean
     */
    function deleteLinksTrans()
    {
        if ($this->use_links)
        {
            if (!empty($this->links_final) && file_exists($this->links_trans))
            {
                unlink($this->links_trans);
            }
            return ! file_exists($this->links_trans);
        }
        return true;
    }

    /**
     * erase the transitional changeset file
     *
     * @return boolean
     */
    function deleteChangesTrans()
    {
        if (file_exists($this->changes_trans))
        {
            unlink($this->changes_trans);
        }
        return ! file_exists($this->changes_trans);
    }

     /**
     * erase the transitional schema file
     *
     * @return boolean
     */
    function deleteSchemaTrans()
    {
        if (file_exists($this->schema_trans))
        {
            unlink($this->schema_trans);
        }
        return ! file_exists($this->schema_trans);
    }

    /**
     * validate and store a table field
     * cascade changes down to indexes and links
     *
     * @param string $table_name
     * @param string $field_name_old
     * @param string $field_name_new
     * @param string $field_type_old
     * @param string $field_type_new
     * @return boolean
     */
    function fieldSave($table_name, $field_name_old, $field_name_new, $field_type_old, $field_type_new)
    {
        $this->parseWorkingDefinitionFile();
        $aTbl_definition = $this->aDB_definition['tables'][$table_name];
        if ($field_name_new && ($field_name_new != $field_name_old))
        {
            // have to muck around to ensure same field order
            foreach ($aTbl_definition['fields'] AS $k => $v)
            {
                if ($field_name_old == $k)
                {
                    $aFld_definition = $v;
                    $aFld_definition['was'] = $field_name_old;
                    $aFields_ordered[$field_name_new] = $aFld_definition;
                }
                else
                {
                    $aFields_ordered[$k] = $v;
                }
            }
            $aTbl_definition['fields'] = $aFields_ordered;
            $valid = $this->validate_field($table_name, $aFld_definition, $field_name_new);
            if ($valid)
            {
                $this->updateFieldIndexRelations($table_name, $aTbl_definition, $field_name_old, $field_name_new);
            }
        }
        else if ($field_type_new && ($field_type_new != $field_type_old))
        {
            $aFld_definition = $this->aDD_definition[$field_type_new];
            $aTbl_definition['fields'][$field_name_old] = $aFld_definition;
            $valid = true;
        }
        if ($valid)
        {
            unset($this->aDB_definition['tables'][$table_name]);
            $valid = $this->validate_table($aTbl_definition, $table_name);
            if ($valid)
            {
                $this->aDB_definition['tables'][$table_name] = $aTbl_definition;
                ksort($this->aDB_definition['tables'],SORT_STRING);
                return $this->writeWorkingDefinitionFile();
            }
        }
        return false;
    }

    /**
     * validate and store a new table field
     *
     * @param string $table_name
     * @param string $field_name
     * @param string $dd_field_name
     * @return boolean
     */
    function fieldAdd($table_name, $field_name, $dd_field_name)
    {
        $this->parseWorkingDefinitionFile();
        $aFld_definition = $this->aDD_definition[$dd_field_name];
        $valid = $this->validate_field($table_name, $aFld_definition, $field_name);
        if ($valid)
        {
            $aTbl_definition = $this->aDB_definition['tables'][$table_name];
            $aTbl_definition['fields'][$field_name] = $aFld_definition;
            unset($this->aDB_definition['tables'][$table_name]);
            $valid = $this->validate_table($aTbl_definition, $table_name);
            if ($valid)
            {
                $this->aDB_definition['tables'][$table_name] = $aTbl_definition;
                ksort($this->aDB_definition['tables'],SORT_STRING);
                return $this->writeWorkingDefinitionFile();
            }
        }
        return false;
    }

    /**
     * remove a field from a table
     * cascade the change across indexes and links
     *
     * @param string $table_name
     * @param string $field_name
     * @return boolean
     */
    function fieldDelete($table_name, $field_name)
    {
        $this->parseWorkingDefinitionFile();
        $aTbl_definition = $this->aDB_definition['tables'][$table_name];
        unset($aTbl_definition['fields'][$field_name]);

        $this->updateFieldIndexRelations($table_name, $aTbl_definition, $field_name, '');
        unset($this->aDB_definition['tables'][$table_name]);
        $valid = $this->validate_table($aTbl_definition, $table_name);
        if ($valid)
        {
            $this->aDB_definition['tables'][$table_name] = $aTbl_definition;
            ksort($this->aDB_definition['tables'],SORT_STRING);
            return $this->writeWorkingDefinitionFile();
        }
        return false;
    }

    /**
     * validate and store a 'was' field in a changeset
     *
     * @param string $table_name
     * @param string $field_name_old
     * @param string $field_name_new
     * @param string $field_type_old
     * @param string $field_type_new
     * @return boolean
     */
    function fieldWasSave($input_file, $table_name, $field_name, $field_name_was)
    {

        $aChanges = $this->oSchema->parseChangesetDefinitionFile($input_file);

        if (PEAR::isError($aChanges))
        {
            $this->oLogger->logError($aChanges->getUserInfo());
            return false;
        }

        if (isset($aChanges['constructive']['tables']['change'][$table_name]['add']['fields'][$field_name]))
        {
            $aChanges['constructive']['tables']['change'][$table_name]['add']['fields'][$field_name]['was'] = $field_name_was;
        }
        else if (isset($aChanges['constructive']['tables']['change'][$table_name]['rename']['fields'][$field_name]))
        {
            $aChanges['constructive']['tables']['change'][$table_name]['rename']['fields'][$field_name]['was'] = $field_name_was;
            if (isset($aChanges['destructive']['tables']['change'][$table_name]['remove'][$field_name_was]))
            {
                unset($aChanges['destructive']['tables']['change'][$table_name]['remove'][$field_name_was]);
                if (empty($aChanges['destructive']['tables']['change'][$table_name]['remove']))
                {
                    unset($aChanges['destructive']['tables']['change'][$table_name]['remove']);
                }
                if (empty($aChanges['destructive']['tables']['change'][$table_name]))
                {
                    unset($aChanges['destructive']['tables']['change'][$table_name]);
                }
                if (empty($aChanges['destructive']['tables']['change']))
                {
                    unset($aChanges['destructive']['tables']['change']);
                }
            }
        }
        $this->aDump_options['output']     = $input_file;
        $this->aDump_options['xsl_file']   = "xsl/mdb2_changeset.xsl";
        $this->aDump_options['split']      = false;
        $this->aDump_options['rewrite']    = true; // this is a rewrite of a previously split changeset, don't split it again
        $result = $this->oSchema->dumpChangeset($aChanges, $this->aDump_options);

        return false;
    }

    function tableWasSave($input_file, $table_name, $table_name_was)
    {

        $aChanges = $this->oSchema->parseChangesetDefinitionFile($input_file);
        if ($table_name != $table_name_was)
        {
            if (isset($aChanges['constructive']['tables']['add'][$table_name]))
            {
                unset($aChanges['constructive']['tables']['add'][$table_name]);
                if (empty($aChanges['constructive']['tables']['add']))
                {
                    unset($aChanges['constructive']['tables']['add']);
                }
                $aChanges['constructive']['tables']['rename'][$table_name]['was'] = $table_name_was;
                if (isset($aChanges['destructive']['tables']['remove'][$table_name_was]))
                {
                    unset($aChanges['destructive']['tables']['remove'][$table_name_was]);
                    if (empty($aChanges['destructive']['tables']['remove']))
                    {
                        unset($aChanges['destructive']['tables']['remove']);
                    }
                }
            }
            else if (isset($aChanges['constructive']['tables']['rename'][$table_name]))
            {
                $aChanges['constructive']['tables']['rename'][$table_name]['was'] = $table_name_was;
            }
        }

        $this->aDump_options['output']     = $input_file;
        $this->aDump_options['xsl_file']   = "xsl/mdb2_changeset.xsl";
        $this->aDump_options['split']      = false;
        $this->aDump_options['rewrite']    = true; // this is a rewrite of a previously split changeset, don't split it again
        $result = $this->oSchema->dumpChangeset($aChanges, $this->aDump_options);

        return false;
    }

    /**
     * remove an index from a table
     *
     * @param string $table_name
     * @param string $index_name
     * @return boolean
     */
    function indexDelete($table_name, $index_name)
    {
        $this->parseWorkingDefinitionFile();
        unset($this->aDB_definition['tables'][$table_name]['indexes'][$index_name]);
        return $this->writeWorkingDefinitionFile();
    }

    /**
     * add an index to a table
     *
     * @param string $table_name
     * @param string $index_name
     * @param array  $aIndex_fields
     * @param boolean $primary
     * @param boolean $unique
     * @return boolean
     */
    function indexAdd($table_name, $index_name, $aIndex_fields, $primary='', $unique='', $idx_fld_sort)
    {
        if ($primary)
        {
            $index_name = $table_name.'_pkey';
        }
        if ($primary && $unique)
        {
            $this->oLogger->logError('Index cannot be both primary and unique');
            return false;
        }
        $this->parseWorkingDefinitionFile();
        $aTable = $this->aDB_definition['tables'][$table_name];
        foreach ($aTable['indexes'] AS $name=>$aDef)
        {
            if ($name == $index_name)
            {
                $this->oLogger->logError('Index with this name already exists for this table');
                return false;
            }
            if ($primary && $aDef['primary'])
            {
                $this->oLogger->logError('Table can have only one primary constraint');
                return false;
            }
        }
        $aNewIndex['fields']    = array();
        $aNewIndex['primary']   = $primary;
        $aNewIndex['unique']    = $unique;
        foreach ($aIndex_fields AS $fld_name=>$null)
        {
            if ($primary || $unique)
            {
                if (!$aTable['fields'][$fld_name]['notnull'])
                {
                    $this->oLogger->logError('Primary key fields must be not null');
                    return false;
                }
            }
            $aNewIndex['fields'][$fld_name] = array('sorting'=>'ascending');
            //$aNewIndex['fields'][$fld_name]['sorting'] = $idx_fld_sort[$fld_name]; //'descending';
        }
        $this->aDB_definition['tables'][$table_name]['indexes'][$index_name] = $aNewIndex;
        return $this->writeWorkingDefinitionFile();
    }

    function _sortIndexFields($aIndex_def)
    {
        foreach ($aIndex_def['fields'] as $field => $aDef)
        {
            $aIdx_sort[$aDef['order']] = $field;
        }
        ksort($aIdx_sort);
        reset($aIdx_sort);
        foreach ($aIdx_sort as $k => $field)
        {
            $sorting = ($aIndex_definition['fields'][$field]['sorting']?'ascending':'descending');
            $aIdx_new['fields'][$field] = array('sorting'=>$sorting);
        }
        reset($aIdx_new['fields']);
        return $aIdx_new;
    }

    /**
     * validate and store a changed index
     *
     * @param string $table_name
     * @param string $index_name
     * @param array $aIndex_definition
     * @return boolean
     */
    function indexSave($table_name, $index_name, $aIndex_definition)
    {
        $this->parseWorkingDefinitionFile();
        $idx_old = $this->aDB_definition['tables'][$table_name]['indexes'][$index_name];
        $aIdx_new = $this->_sortIndexFields($aIndex_definition);
//        foreach ($aIndex_definition['fields'] as $field => $aDef)
//        {
//            $aIdx_sort[$aDef['order']] = $field;
//        }
//        ksort($aIdx_sort);
//        reset($aIdx_sort);
//        foreach ($aIdx_sort as $k => $field)
//        {
//            $sorting = ($aIndex_definition['fields'][$field]['sorting']?'ascending':'descending');
//            $aIdx_new['fields'][$field] = array('sorting'=>$sorting);
//        }
//        reset($aIdx_new['fields']);
        if (isset($aIndex_definition['unique']))
        {
            $aIdx_new['unique'] = $aIndex_definition['unique'];
        }
        if (isset($aIndex_definition['primary']))
        {
            $aIdx_new['primary'] = $aIndex_definition['primary'];
        }
        if ($aIndex_definition['was']!=$aIndex_definition['name'])
        {
            $idx_name = $aIndex_definition['name'];
        }
        else
        {
            $idx_name = $aIndex_definition['was'];
        }
        unset($this->aDB_definition['tables'][$table_name]['indexes'][$index_name]);
        $valid = $this->validate_index($table_name, $aIdx_new, $idx_name);
        if ($valid)
        {
            $this->aDB_definition['tables'][$table_name]['indexes'][$idx_name] = $aIdx_new;
            return $this->writeWorkingDefinitionFile();
        }
        return false;
    }

    /**
     * validate and store a new table definition
     *
     * @param string $new_table_name
     * @return boolean
     */
    function tableNew($new_table_name)
    {
        $this->parseWorkingDefinitionFile();
        $aFld_definition = array($new_table_name.'_id'=>array('type'=>'openads_mediumint','length'=>'9','default'=>'','notnull'=>'true'));
        $aTbl_definition = array('fields'=>$aFld_definition);
        $valid = $this->validate_table($aTbl_definition, $new_table_name);
        if ($valid)
        {
            $this->aDB_definition['tables'][$new_table_name] = $aTbl_definition;
            ksort($this->aDB_definition['tables'],SORT_STRING);
            return $this->writeWorkingDefinitionFile();
        }
        return false;
    }

    /**
     * remove a table from the schema
     * cascade the change across links
     *
     * @param string $table_name
     * @return boolean
     */
    function tableDelete($table_name)
    {
        $this->parseWorkingDefinitionFile();
        $this->deleteTableLinkRelations($table_name);
        unset($this->aDB_definition['tables'][$table_name]);
        return $this->writeWorkingDefinitionFile();
    }

    /**
     * validate and store a changed table
     * cascade the change across links
     *
     * @param string $table_name
     * @param string $table_name_new
     * @return boolean
     */
    function tableSave($table_name, $table_name_new)
    {
        $this->parseWorkingDefinitionFile();
        $aTbl_definition = $this->aDB_definition['tables'][$table_name];
        if ($table_name_new && ($table_name_new != $table_name))
        {
            $valid = $this->validate_table($aTbl_definition, $table_name_new);
        }
        else
        {
            $valid = false;
        }
        if ($valid)
        {
            $this->aDB_definition['tables'][$table_name_new] = $aTbl_definition;
            unset($this->aDB_definition['tables'][$table_name]);
            ksort($this->aDB_definition['tables'],SORT_STRING);
            if ($this->writeWorkingDefinitionFile())
            {
                if ($this->updateTableLinkRelations($table_name, $table_name_new))
                {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * remove a link from the schema
     *
     * @param string $table_name
     * @param string $link_name
     * @return mixed     true on success or PEAR_ERROR
     */
    function linkDelete($table_name, $link_name)
    {
        if ($this->use_links && (!empty($this->links_trans)))
        {
            $aLinks = Openads_Links::readLinksDotIni($this->links_trans, $table_name);
            unset($aLinks[$table_name][$link_name]);
            return Openads_Links::writeLinksDotIni($this->links_trans, $aLinks);

        }
        return true;
    }

    /**
     * add a link to the schema
     *
     * @param string $table_name
     * @param string $link_add
     * @param string $link_add_target
     * @return mixed     true on success or PEAR_ERROR
     */
    function linkAdd($table_name, $link_add, $link_add_target)
    {
        if ($this->use_links && (!empty($this->links_trans)))
        {
            $aLinks = Openads_Links::readLinksDotIni($this->links_trans, $table_name);
            $aLinks[$table_name][$link_add] = $link_add_target;
            return Openads_Links::writeLinksDotIni($this->links_trans, $aLinks);
        }
        return true;
    }

    /**
     * read the links file and return an array of references
     *
     * @param string $table_name
     * @return array
     */
    function readForeignKeys($table_name)
    {
        if ($this->use_links && (!empty($this->links_trans))) {
            $aLinks = Openads_Links::readLinksDotIni($this->links_trans, $table_name);
            if (!isset($aLinks[$table_name])) {
                $aLinks[$table_name] = array();
            }
        } else {
            $aLinks = array();
        }
        return $aLinks;
    }

    /**
     * build an array of links cross-references
     *
     * @return array
     */
    function getLinkTargets()
    {
        $aLinks_targets = array();
        if ($this->use_links)
        {
            foreach ($this->aDB_definition['tables'] as $tk => $tv) {
                if (isset($tv['indexes'])) {
                    foreach ($tv['indexes'] as $v) {
                        if (isset($v['primary']) && $v['primary'] && count($v['fields']) == 1) {
                            $aLinks_targets["$tk:".key($v['fields'])] = "$tk (".key($v['fields']).")";
                        }
                    }
                }
            }
        }
        return $aLinks_targets;
    }

    /**
     * verify that table properties are valid and legal
     *
     * @param array $aTbl_definition
     * @param string $tbl_name
     * @return boolean
     */
    function validate_table($aTbl_definition, $tbl_name)
    {
        $this->init_schema_validator();
        $result = $this->oValidator->validateTable($this->aDB_definition['tables'], $aTbl_definition, $tbl_name);
        if (PEAR::iserror($result))
        {
            $this->oLogger->logError($result->getUserInfo());
            return false;
        }
        return true;
    }

    /**
     * verify that field properties are valid and legal
     *
     * @param string $table_name
     * @param array $aField_definition
     * @param string $field_name
     * @return boolean
     */
    function validate_field($table_name, $aField_definition, $field_name)
    {
        $this->init_schema_validator();
        $result = $this->oValidator->validateField($this->aDB_definition['tables'][$table_name]['fields'], $aField_definition, $field_name);
        if (PEAR::iserror($result))
        {
            $this->oLogger->logError($result->getUserInfo());
            return false;
        }
        return true;
    }

    /**
     * verify that index properties are valid and legal
     *
     * @param string $table_name
     * @param array $aIdx_definition
     * @param string $idx_name
     * @return boolean
     */
    function validate_index($table_name, $aIdx_definition, $idx_name)
    {
        $this->init_schema_validator();
        $result = $this->oValidator->validateIndex($this->aDB_definition['tables'][$table_name]['indexes'], $aIdx_definition, $idx_name);
        if (PEAR::iserror($result))
        {
            $this->oLogger->logError($result->getUserInfo());
            return false;
        }
        return true;
    }

    /**
     * check all indexes for a given field
     * alter indexes to reflect changes to the field
     *
     * @param string $table_name
     * @param array $aTable_definition
     * @param string $field_name_old
     * @param string $field_name_new
     * @return mixed     true on success or PEAR_ERROR
     */
    function updateFieldIndexRelations($table_name, &$aTable_definition, $field_name_old, $field_name_new)
    {
        if (!empty($aTable_definition['indexes']) && is_array($aTable_definition['indexes']))
        {
            foreach ($aTable_definition['indexes'] as $idx_name => $aIndex)
            {
                if (is_array($aIndex['fields']) && array_key_exists($field_name_old, $aIndex['fields']))
                {
                    foreach ($aIndex['fields'] AS $field => $aTarget)
                    {
                        if ($field_name_old == $field)
                        {
                            if ($field_name_new)
                            {
                                $aFields_ordered[$field_name_new] = $aTarget;
                            }
                        }
                        else
                        {
                            $aFields_ordered[$field] = $aTarget;
                        }
                    }
                    if (is_array($aFields_ordered))
                    {
                        $aTable_definition['indexes'][$idx_name]['fields'] = $aFields_ordered;
                    }
                    else
                    {
                        unset($aTable_definition['indexes'][$idx_name]);
                    }
                }
            }
        }
        return $this->updateFieldLinkRelations($table_name, $field_name_old, $field_name_new);
    }

    /**
     * check all links for a given field
     * alter links to reflect changes to the field
     *
     * @param string $table_name
     * @param string $field_name_old
     * @param string $field_name_new
     * @return mixed     true on success or PEAR_ERROR
     */
    function updateFieldLinkRelations($table_name, $field_name_old, $field_name_new)
    {
        if ($this->use_links)
        {
            if (!empty($this->links_trans)) {
                $aLinks = Openads_Links::readLinksDotIni($this->links_trans, $table_name);
                reset($aLinks);
                foreach ($aLinks AS $table => $aKeys)
                {
                    foreach ($aKeys AS $field => $aTarget)
                    {
                        if (($aTarget['table']==$table_name) && ($aTarget['field']==$field_name_old))
                        {
                            unset($aLinks[$table][$field]);
                            if ($field_name_new)
                            {
                                $aTarget['field'] = $field_name_new;
                                $aLinks[$table][$field] = $aTarget;
                            }
                            if (!is_array($aLinks[$table]))
                            {
                                unset($aLinks[$table]);
                            }
                        }
                        if (($table==$table_name) && ($field==$field_name_old))
                        {
                            unset($aLinks[$table][$field]);
                            if ($field_name_new)
                            {
                                $field = $field_name_new;
                                $aLinks[$table][$field] = $aTarget;
                            }
                            if (!is_array($aLinks[$table]))
                            {
                                unset($aLinks[$table]);
                            }
                        }
                    }
                }
                return Openads_Links::writeLinksDotIni($this->links_trans, $aLinks);
            }
        }
        return true;
    }

    /**
     * check all links for a given table
     * alter links to reflect removal of the table
     *
     * @param string $table_name
     * @return mixed     true on success or PEAR_ERROR
     */
    function deleteTableLinkRelations($table_name)
    {
        if ($this->use_links)
        {
            if (!empty($this->links_trans)) {
                $aLinks = Openads_Links::readLinksDotIni($this->links_trans, $table_name);
                foreach ($aLinks AS $table => $aKeys)
                {
                    if (($table==$table_name))
                    {
                        unset($aLinks[$table]);
                    }
                    foreach ($aKeys AS $field => $aTarget)
                    {
                        if (($aTarget['table']==$table_name))
                        {
                            unset($aLinks[$table][$field]);
                        }
                    }
                }
                return Openads_Links::writeLinksDotIni($this->links_trans, $aLinks);
            }
        }
        return true;
    }

    /**
     * check all links for a given table
     * alter links to reflect changes to the tablename
     *
     * @param string $table_name
     * @param string $table_name_new
     * @return mixed     true on success or PEAR_ERROR
     */
    function updateTableLinkRelations($table_name, $table_name_new)
    {
        if ($this->use_links)
        {
            if (!empty($this->links_trans)) {
                $aLinks = Openads_Links::readLinksDotIni($this->links_trans, $table_name);
                if (isset($aLinks[$table_name]))
                {
                    $aLinks[$table_name_new] = $aLinks[$table_name];
                    unset($aLinks[$table_name]);
                }

                foreach ($aLinks AS $table => $aKeys)
                {
                    foreach ($aKeys AS $field => $aTarget)

                    {
                        if (($aTarget['table']==$table_name))
                        {
                            $aLinks[$table][$field]['table'] = $table_name_new;
                        }
                    }
                }
                return Openads_Links::writeLinksDotIni($this->links_trans, $aLinks);
            }
        }
        return true;
    }

    /**
     * return an instance of an mdb2_schema validation class
     *
     * @return MDB2_Schema_Validate
     */
    function init_schema_validator()
    {
        if (!isset($this->oValidator))
        {
            $fail_on_invalid_names = array();
            $valid_types = $this->oSchema->options['valid_types'];
            $force_defaults = '';

            $this->oValidator =& new MDB2_Schema_Validate($fail_on_invalid_names, $valid_types, $force_defaults);
        }
        if (!Pear::iserror($this->oValidator))
        {
            return $this->oValidator;
        }
        $this->oLogger->logError($this->oValidator->getUserInfo());
        return false;
    }

    /**
     * check access to an array of requried files/folders
     *
     *
     * @return array of error messages
     */
    /*function checkPermissions()
    {
        $aErrors = array();

        foreach ($this->aFile_perms as $file)
        {
            if (empty($file))
            {
                continue;
            }
            if (!file_exists($file))
            {
                $aErrors['errors'][] = sprintf("The file '%s' does not exist", $file);
            }
            elseif (!is_writable($file))
            {
                if (is_dir($file))
                {
                    $aErrors['errors'][] = sprintf("The directory '%s' is not writable", $file);
                    $aErrors['fixes'][]  = sprintf("chmod -R a+w %s", $file);
                }
                else
                {
                    $aErrors['errors'][] = sprintf("The file '%s' is not writable", $file);
                    $aErrors['fixes'][]  = sprintf("chmod a+w %s", $file);
                }
            }
        }

        if (count($aErrors))
        {
            return $aErrors;
        }

        return true;
    }*/

    /**
     * build and write a data migration class
     * based on the given changeset
     *
     * @param string $file_changes
     */
    function writeMigrationClass($file_changes)
    {
        $method_buffer      = '';
        $task_buffer        = '';
        $map_buffer         = '';

        //$this->testChangeset();
        $aChanges = $this->oSchema->parseChangesetDefinitionFile($file_changes);

        $this->_buildBuffers($aChanges, 'constructive', $task_buffer, $method_buffer, $map_buffer);
        $this->_buildBuffers($aChanges, 'destructive', $task_buffer, $method_buffer, $map_buffer);
        $this->_buildMap($aChanges['objectmap'], $map_buffer);

        $buffer = file_get_contents(MAX_PATH."/www/devel/templates/class_migration.tpl");
        $buffer = str_replace('/*version*/' , $aChanges['version'], $buffer);
        $buffer = str_replace('/*methods*/' , $method_buffer, $buffer);
        $buffer = str_replace('/*tasklist*/', $task_buffer, $buffer);
        $buffer = str_replace('/*objectmap*/', $map_buffer, $buffer);

        $file = str_replace('changes_','migration_',$file_changes);
        $file = str_replace('xml','php',$file);
        $fp = fopen($file, 'w');
        if ($fp === false)
        {
            return PEAR::raiseError(MDB2_SCHEMA_ERROR_WRITER, null, null,
                'it was not possible to open the migration output file: '.$file);
        }

        fwrite($fp, $buffer);
        fclose($fp);

        if (file_exists($file))
        {
            return $file;
        }
        return false;
    }

    /**
     * grab the tasks from the changeset
     *
     * @param array $aChanges
     * @param string $timing
     * @param string $task_buffer
     * @param string $method_buffer
     */
    function _buildBuffers($aChanges, $timing, &$task_buffer, &$method_buffer)
    {
        foreach ($aChanges['hooks'][$timing]['tables'] AS $table => $aTable_hooks)
        {
            $params = "'{$table}'";
            foreach ($aTable_hooks['self'] AS $parent => $method)
            {
                $task_buffer.= $this->_buildTask($method, $timing);
                $method_buffer.= $this->_buildMethod($method, $parent, $params);
            }

            foreach ($aTable_hooks['fields'] AS $field => $aField_hooks)
            {
                foreach ($aField_hooks AS $parent => $method)
                {
                    $params = "'{$table}', '{$field}'";
                    $task_buffer.= $this->_buildTask($method, $timing);
                    $method_buffer.= $this->_buildMethod($method, $parent, $params);
                }
            }
            foreach ($aTable_hooks['indexes'] AS $index => $aIndex_hooks)
            {
                foreach ($aIndex_hooks AS $parent => $method)
                {
                    $params = "'{$table}', '{$index}'";
                    $task_buffer.= $this->_buildTask($method, $timing);
                    $method_buffer.= $this->_buildMethod($method, $parent, $params);
                }
            }
        }
    }
    /**
     * return code that will add a task to the migration class tasklist
     *
     * @param string $method
     * @return string
     */
    function _buildTask($method, $timing)
    {
        return "\n\t\t\$this->aTaskList_{$timing}[] = '{$method}';";
    }

    /**
     * return code that will add a task to the migration class tasklist
     *
     * @param string $method
     * @return string
     */
    function _buildMap($map_array, &$map_buffer)
    {
        foreach ($map_array AS $k => $map)
        {
            if ($map['toField'] && $map['fromField'])
            {
                $map_buffer.= "\n\t\t\$this->aObjectMap['{$map['toTable']}']['{$map['toField']}'] = array('fromTable'=>'{$map['fromTable']}', 'fromField'=>'{$map['fromField']}');";
            }
            else
            {
                $map_buffer.= "\n\t\t\$this->aObjectMap['{$map['toTable']}'] = array('fromTable'=>'{$map['fromTable']}');";
            }
        }
    }

    /**
     * return code that will define a migration class method
     *
     * @param string $method_name
     * @param string $parent_name
     * @param string $params
     * @return string
     */
    function _buildMethod($method_name, $parent_name, $params)
    {

        return   "\n\n\tfunction {$method_name}()"
                ."\n\t{"
                ."\n\t\treturn \$this->{$parent_name}({$params});"
                ."\n\t}";
    }

    /**
     * temporary method to help understand the differences
     * between the changes array after compare and
     * the changes array after parsing
     *
     * the differences should be resolved sometime and this method removed :)
     *
     * @param string $output
     * @return unknown
     */
    function testChangeset($output='')
    {
        if (file_exists($this->schema_trans) && file_exists($this->schema_final))
        {
            $aPrev_definition                = $this->oSchema->parseDatabaseDefinitionFile($this->schema_final);
            $aCurr_definition                = $this->oSchema->parseDatabaseDefinitionFile($this->schema_trans);
            $aChanges                        = $this->oSchema->compareDefinitions($aCurr_definition, $aPrev_definition);
            $this->aDump_options['output']   = ($output ? $output : $this->changes_trans);
            $this->aDump_options['xsl_file'] = "xsl/mdb2_changeset.xsl";
            $this->aDump_options['split']    = true;
            $aChanges['version']             = $aCurr_definition['version'];
            $aChanges['name']                = $aCurr_definition['name'];
            $aChanges['comments']            = '';
            $result                         = $this->oSchema->dumpChangeset($aChanges, $this->aDump_options);
            $aChangesX                       = $this->oSchema->parseChangesetDefinitionFile($this->changes_trans);
            $aChanges1                       = $aChangesX['constructive'];
            $aChanges2                       = $aChangesX['destructive'];
//            echo '<div><pre>';
//            foreach ($aChangesX['test'] as $k=>$v)
//            {
//                echo "case '{$v}': ";
//            	echo "\n\tbreak;\n";
//            }
//            //var_dump($aChangesX['test']);
//            echo '</pre></div>';

            echo '<div><pre>';
            var_dump($aChanges);
            echo '</pre></div>';
            echo '<div><pre>';
            var_dump($aChanges1);
            echo '</pre></div>';
            if (!Pear::iserror($result))
            {
                return true;
            }
            else
            {
                $this->oLogger->logError($result->getUserInfo());
                return false;
            }
        }
        $this->oLogger->logError('one or more files do not exist:');
        $this->oLogger->logError($this->schema_trans);
        $this->oLogger->logError($this->schema_final);
        return false;
    }

    /**
     * rebuild the db_DataObject classes
     *
     */
    function _generateDataObjects($changes_file, $basename)
    {
        global $schema, $pathdbo;
        $schema = $this->schema_final;
        $pathdbo = $this->path_dbo;
        $GLOBALS['_MAX']['CONF']['debug']['priority'] = 0;
        include MAX_PATH.'/scripts/db_dataobject/rebuild.php';

        return empty($aDboErrors);
    }

    /**
     * create a new database with the given name
     * check first and drop if necessary
     *
     * @param string $database_name
     * @return boolean
     */
    /*function _createDatabase($database_name)
    {
        if ($this->_dropDatabase($database_name))
        {
            $this->aDB_definition['name'] = $database_name;
            if ($this->oSchema->db->manager->createDatabase($database_name))
            {
                $this->oSchema->db = OA_DB::changeDatabase($database_name);
                $oaTable = new OA_DB_Table();
                $oaTable->oSchema = $this->oSchema;
                $oaTable->aDefinition = $this->aDB_definition;
                return $oaTable->createAllTables();
            }
        }
        return false;
    }*/

    /**
     * check if given database exists and drop if it does
     *
     * @param string $database_name
     * @return boolean
     */
    /*function _dropDatabase($database_name)
    {
        if ($this->_databaseExists($database_name))
        {
            $this->oSchema->db->manager->dropDatabase($database_name);
        }
        return (!$this->_databaseExists($database_name));
    }*/

    /**
     * check if a given database name is in use
     *
     * @param string $database_name
     * @return boolean
     */
    /*function _databaseExists($database_name)
    {
        $result = $this->oSchema->db->manager->listDatabases();
        if (PEAR::isError($result))
        {
            $this->oLogger->logError($result->getUserInfo());
            return false;
        }
        return in_array(strtolower($database_name), array_map('strtolower', $result));
    }*/

///////////////// work in progress - xml-rpc package management
    /**
     * register the version with the schema upms server
     * stamp the transitional files as final
     * copy transitional files to final destinations
     * remove transitional files
     *
     * @return boolean
     */
    function commitFinalXMLRPC($comments='', $version='', $name='')
    {
        $this->oLogger->log('Committing Final Schema');
        if (empty($comments)||empty($version)||empty($name))
        {
            if (empty($name))
            {
                $this->oLogger->logError('User name is empty');
            }
            if (empty($version))
            {
                $this->oLogger->logError('Version is empty');
            }
            if (empty($comments))
            {
                $this->oLogger->logError('Comments is empty');
            }
            return false;
        }
        $this->version =  ($version ? $version : $this->version);
        if (!$this->_registerVersion($version, $name, $comments))
        {
            $this->oLogger->logError('Failed to register schema version');
            return false;
        }
        $result = ($this->use_links ? file_exists($this->links_trans) : true);
        if (!$result)
        {
            $this->oLogger->logError('Links file not found '.$this->links_trans);
            return false;
        }
        if (!file_exists($this->schema_trans))
        {
            $this->oLogger->logError('Schema file not found '.$this->schema_trans);
            return false;
        }
        $this->setWorkingFiles();

        $this->parseWorkingDefinitionFile();

        $basename   = $this->_getBasename();
        $this->aDB_definition['version'] =  $this->version;
        $this->aDump_options['custom_tags']['status']='final';
        $this->changes_final = $this->path_changes_final.'changes_'.$basename.'.xml';
        if (!$this->createChangeset($this->changes_final, $comments, $version))
        {
            $this->oLogger->logError('Failed to create changeset '.$this->changes_final);
            return false;
        }
        $this->_generateDataObjects($this->changes_final, $basename);
        if (!$this->writeWorkingDefinitionFile($this->schema_final))
        {
            $this->oLogger->logError('Failed to write file '.$this->schema_final);
            return false;
        }
        $schema = $this->path_changes_final.'schema_'.$basename.'.xml';
        if (!$this->writeWorkingDefinitionFile($schema))
        {
            $this->oLogger->logError('Failed to write file '.$schema);
            return false;
        }
        if ($this->use_links)
        {
            if (!file_exists($this->links_trans))
            {
                $this->oLogger->logError('Links file not found '.$this->links_trans);
                return false;
            }
            if (!copy($this->links_trans, $this->links_final))
            {
                $this->oLogger->logError('Failed to write file '.$this->links_final);
                return false;
            }
        }
        $this->deleteTransitional();
        return true;
    }

    /**
     *
     * @return integer
     */
    function _getNextVersionXMLRPC()
    {
        $id = UPMS_getNextVersion($this->aXMLRPCServer);
        if (!$id)
        {
            return false;
        }
        return $id;
    }

    function _registerVersion($id, $name, $comments='-')
    {
        if ($this->aXMLRPCServer)
        {
            $aOld = UPMS_checkVersion($this->aXMLRPCServer, $id);
            if (is_array($aOld) && array_key_exists($id, $aOld))
            {
                //$aErrors[] = 'Schema version '.$id.' was registered by '.$aOld[$id]['user'].' on '.$aOld[$id]['registered'];
                return false;
            }
            else
            {
                $aNew = UPMS_registerVersion($this->aXMLRPCServer, $id, $name, $comments);
                if (!is_array($aNew))
                {
                    //$aErrors[] = $aNew;
                    return false;
                }
            }
        }
        return true;
    }

}

?>

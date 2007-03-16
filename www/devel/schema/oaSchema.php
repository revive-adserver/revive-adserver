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
 * $Id$
 *
 */

require_once MAX_DEV.'/lib/pear.inc.php';
require_once 'MDB2.php';
require_once 'MDB2/Schema.php';
require_once 'Config.php';

require_once MAX_PATH.'/lib/openads/Dal.php';
require_once MAX_PATH.'/lib/openads/Dal/Links.php';

class Openads_Schema_Manager
{

    var $schema;

    var $db_definition;
    var $fk_definition;

    var $dump_options;
    var $dd_definition;
    var $dd_file;

    var $path_schema_final;
    var $path_schema_trans;

    var $path_changes_final;
    var $path_changes_trans;

    var $path_links_final;
    var $path_links_trans;

    var $file_schema_core;
    var $schema_final;
    var $schema_trans;

    var $file_changes_core;
    var $changes_final;
    var $changes_trans;

    var $file_links_core;
    var $links_final = false;
    var $links_trans = false;

    var $use_links;

    var $working_file_schema;
    var $working_file_links;

    var $_validator;

    var $version;

    var $file_perms;

    /**
     * php5 class constructor
     *
     * @param string The XML schema file we are working on
     */
    function __construct($file_schema = 'tables_core.xml')
    {
        $this->path_schema_final = MAX_PATH.'/etc/';
        $this->path_schema_trans = MAX_PATH.'/var/';
        $this->path_changes_final = MAX_PATH.'/etc/changes/';
        $this->path_changes_trans = MAX_PATH.'/var/';

        $this->path_links_final = MAX_PATH.'/lib/max/Dal/DataObjects/';
        $this->path_links_trans = MAX_PATH.'/var/';

        $file_changes   = 'changes_'.$file_schema;
        $file_links     = 'db_schema.links.ini';

        $this->schema_final = $this->path_schema_final.$file_schema;
        $this->schema_trans = $this->path_schema_trans.$file_schema;

        $this->use_links = ($file_schema=='tables_core.xml');
        if ($this->use_links)
        {
            $this->links_final = $this->path_links_final.$file_links;
            $this->links_trans = $this->path_links_trans.$file_links;
        }

        $this->changes_final = $this->path_changes_final.$file_changes;
        $this->changes_trans = $this->path_changes_trans.$file_changes;

        if ($this->use_links)
        {
            $this->file_perms = array(
                                        $this->path_schema_trans,
                                        $this->path_changes_final,
                                        $this->path_changes_trans,
                                        $this->path_links_trans,
                                        $this->links_final,
                                        $this->schema_final,
                                        MAX_SCHEMA_LOG,
                                        MAX_PATH.'/www/devel/schema/schema.js'
                                    );
        }
        else
        {
            $this->file_perms = array(
                                        $this->path_schema_trans,
                                        $this->path_changes_final,
                                        $this->path_changes_trans,
                                        $this->schema_final,
                                        MAX_SCHEMA_LOG,
                                        MAX_PATH.'/www/devel/schema/schema.js'
                                    );
        }


        $this->dump_options = array (
                                        'output_mode'   =>    'file',
                                        'output'        =>    $this->schema_trans,
                                        'end_of_line'   =>    "\n",
                                        'xsl_file'      =>    "xsl/mdb2_schema.xsl",
                                        'custom_tags'   => array('version'=>'', 'status'=>'transitional')
                                      );

        $this->schema = & $this->connect($this->dump_options);

        $this->dd_file = MAX_DEV.'/etc/dd.generic.xml';
        $this->dd_definition = $this->schema->parseDictionaryDefinitionFile($this->dd_file);
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

    /**
     * use mdb2_schema to compare 2 definition files
     * write the changeset array in xmlformat
     *
     * @param string $output : path and filename for output
     * @return boolean
     */
    function createChangeset($output='', $comments='')
    {
        if (file_exists($this->schema_trans) && file_exists($this->schema_final))
        {
            $prev_definition = $this->schema->parseDatabaseDefinitionFile($this->schema_final);
            $curr_definition = $this->schema->parseDatabaseDefinitionFile($this->schema_trans);
            $changes         = $this->schema->compareDefinitions($curr_definition, $prev_definition);
            $this->dump_options['output'] = ($output ? $output : $this->changes_trans);
            $this->dump_options['xsl_file']   = "xsl/mdb2_changeset.xsl";
            $changes['version']               = $curr_definition['version'];
            $changes['name']                  = $curr_definition['name'];
            $changes['comments']              = htmlspecialchars($comments);
            $result = $this->schema->dumpChangeset($changes, $this->dump_options, true);
            if (!Pear::iserror($result))
            {
                return true;
            }
        }
        return false;
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
            $prev_definition = $this->schema->parseDatabaseDefinitionFile($this->schema_final);
            $curr_definition = $this->schema->parseDatabaseDefinitionFile($this->schema_trans);
            $changes         = $this->schema->compareDefinitions($curr_definition, $prev_definition);
            $this->dump_options['output'] = ($output ? $output : $this->changes_trans);
            $this->dump_options['xsl_file']   = "xsl/mdb2_changeset.xsl";
            $changes['version']               = $curr_definition['version'];
            $changes['name']                  = $curr_definition['name'];
            $changes['comments']              = '';
            $result = $this->schema->dumpChangeset($changes, $this->dump_options, true);
            $changesX        = $this->schema->parseChangesetDefinitionFile($this->changes_trans);
            echo '<div>';
            var_dump($changes);
            echo '</div>';
            echo '<div>';
            var_dump($changesX);
            echo '</div>';
            if (!Pear::iserror($result))
            {
                return true;
            }
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
            $changes = $this->schema->parseChangesetDefinitionFile($input_file);
            $this->dump_options['output'] = ($output ? $output : $this->changes_trans);
            $this->dump_options['xsl_file']   = "xsl/mdb2_changeset.xsl";
            $changes['comments']              = $comments;
            $result = $this->schema->dumpChangeset($changes, $this->dump_options, true);
            if (!Pear::iserror($result))
            {
                return true;
            }
        }
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
                $this->version++;
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
    function commitFinal($comments='')
    {
        $result = ($this->use_links ? file_exists($this->links_trans) : true);
        $result = $result && (file_exists($this->schema_trans));
        if ($result)
        {
            $this->setWorkingFiles();

            $this->parseWorkingDefinitionFile();

            $this->dump_options['custom_tags']['status']='final';

            $this->changes_final = $this->path_changes_final.'schema_'.$this->version.'.xml';
            $result = $this->createChangeset($this->changes_final, $comments);
            if ($result)
            {
                $result = $this->writeWorkingDefinitionFile($this->schema_final);
            }
            if ($result && $this->use_links)
            {
                $result = (!empty($this->links_trans) && file_exists($this->links_trans));
                if ($result)
                {
                    copy($this->links_trans, $this->links_final);
                }
            }
        }
        if ($result)
        {
            $this->deleteTransitional();
        }
        return $result;
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
            $result = $this->schema->parseDatabaseDefinitionFile($this->working_file_schema);
            if (!Pear::iserror($result))
            {
                $this->db_definition = $result;
                $this->version = $this->db_definition['version'];
                return true;
            }
        }
        $this->db_definition = array();
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
        $this->dump_options['custom_tags']['version'] = $this->version;
        $this->dump_options['output']       = ($output ? $output : $this->schema_trans);
        $this->dump_options['xsl_file']     = "xsl/mdb2_schema.xsl";
        $result = $this->schema->dumpDatabase($this->db_definition, $this->dump_options, MDB2_SCHEMA_DUMP_STRUCTURE, false);
        if (!Pear::iserror($result))
        {
            return true;
        }
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
        $tbl_definition = $this->db_definition['tables'][$table_name];
        if ($field_name_new && ($field_name_new != $field_name_old))
        {
            // have to muck around to ensure same field order
            foreach ($tbl_definition['fields'] AS $k => $v)
            {
                if ($field_name_old == $k)
                {
                    $fld_definition = $v;
                    $fld_definition['was'] = $field_name_old;
                    $fields_ordered[$field_name_new] = $fld_definition;
                }
                else
                {
                    $fields_ordered[$k] = $v;
                }
            }
            $tbl_definition['fields'] = $fields_ordered;
            $valid = $this->validate_field($table_name, $fld_definition, $field_name_new);
            if ($valid)
            {
                $this->updateFieldIndexRelations($table_name, $tbl_definition, $field_name_old, $field_name_new);
            }
        }
        else if ($field_type_new && ($field_type_new != $field_type_old))
        {
            $fld_definition = $this->dd_definition['fields'][$field_type_new];
            $tbl_definition['fields'][$field_name_old] = $fld_definition;
            $valid = true;
        }
        if ($valid)
        {
            unset($this->db_definition['tables'][$table_name]);
            $valid = $this->validate_table($tbl_definition, $table_name);
            if ($valid)
            {
                $this->db_definition['tables'][$table_name] = $tbl_definition;
                ksort($this->db_definition['tables'],SORT_STRING);
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
        $fld_definition = $this->dd_definition['fields'][$dd_field_name];
        $valid = $this->validate_field($table_name, $fld_definition, $field_name);
        if ($valid)
        {
            $tbl_definition = $this->db_definition['tables'][$table_name];
            $tbl_definition['fields'][$field_name] = $fld_definition;
            unset($this->db_definition['tables'][$table_name]);
            $valid = $this->validate_table($tbl_definition, $table_name);
            if ($valid)
            {
                $this->db_definition['tables'][$table_name] = $tbl_definition;
                ksort($this->db_definition['tables'],SORT_STRING);
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
        $tbl_definition = $this->db_definition['tables'][$table_name];
        unset($tbl_definition['fields'][$field_name]);

        $this->updateFieldIndexRelations($table_name, $tbl_definition, $field_name, '');
        unset($this->db_definition['tables'][$table_name]);
        $valid = $this->validate_table($tbl_definition, $table_name);
        if ($valid)
        {
            $this->db_definition['tables'][$table_name] = $tbl_definition;
            ksort($this->db_definition['tables'],SORT_STRING);
            return $this->writeWorkingDefinitionFile();
        }
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
        unset($this->db_definition['tables'][$table_name]['indexes'][$index_name]);
        return $this->writeWorkingDefinitionFile();
    }

    /**
     * add an index to a table
     *
     * @param string $table_name
     * @param string $index_name
     * @param array  $index_fields
     * @param boolean $primary
     * @param boolean $unique
     * @return boolean
     */
    function indexAdd($table_name, $index_name, $index_fields, $primary='', $unique='', $idx_fld_sort)
    {
        $this->parseWorkingDefinitionFile();
        $this->db_definition['tables'][$table_name]['indexes'][$index_name] = array();
        $this->db_definition['tables'][$table_name]['indexes'][$index_name]['fields'] = array();
        $this->db_definition['tables'][$table_name]['indexes'][$index_name]['primary'] = $primary;
        $this->db_definition['tables'][$table_name]['indexes'][$index_name]['unique'] = $unique;
        foreach ($index_fields AS $fld_name=>$null)
        {
            $this->db_definition['tables'][$table_name]['indexes'][$index_name]['fields'][$fld_name] = array('sorting'=>'ascending');
        }
        foreach ($idx_fld_sort AS $fld_name=>$sorting)
        {
            $this->db_definition['tables'][$table_name]['indexes'][$index_name]['fields'][$fld_name]['sorting'] = 'descending';
        }
        return $this->writeWorkingDefinitionFile();
    }

    /**
     * validate and store a changed index
     *
     * @param string $table_name
     * @param string $index_name
     * @param array $index_def
     * @return boolean
     */
    function indexSave($table_name, $index_name, $index_def)
    {
        $this->parseWorkingDefinitionFile();
        $idx_old = $this->db_definition['tables'][$table_name]['indexes'][$index_name];
        foreach ($index_def['fields'] as $field => $def)
        {
            $idx_sort[$def['order']] = $field;
        }
        ksort($idx_sort);
        reset($idx_sort);
        foreach ($idx_sort as $k => $field)
        {
            $sorting = ($index_def['fields'][$field]['sorting']?'ascending':'descending');
            $idx_new['fields'][$field] = array('sorting'=>$sorting);
        }
        reset($idx_new['fields']);
        if (isset($index_def['unique']))
        {
            $idx_new['unique'] = $index_def['unique'];
        }
        if (isset($index_def['primary']))
        {
            $idx_new['primary'] = $index_def['primary'];
        }
        if ($index_def['was']!=$index_def['name'])
        {
            $idx_name = $index_def['name'];
        }
        else
        {
            $idx_name = $index_def['was'];
        }
        unset($this->db_definition['tables'][$table_name]['indexes'][$index_name]);
        $valid = $this->validate_index($table_name, $idx_new, $idx_name);
        if ($valid)
        {
            $this->db_definition['tables'][$table_name]['indexes'][$idx_name] = $idx_new;
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
        $fld_definition = array('newfield'=>array('type'=>'text','length'=>'','default'=>'','notnull'=>''));
        $tbl_definition = array('fields'=>$fld_definition);
        $valid = $this->validate_table($tbl_definition, $new_table_name);
        if ($valid)
        {
            $this->db_definition['tables'][$new_table_name] = $tbl_definition;
            ksort($this->db_definition['tables'],SORT_STRING);
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
        unset($this->db_definition['tables'][$table_name]);
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
        $tbl_definition = $this->db_definition['tables'][$table_name];
        if ($table_name_new && ($table_name_new != $table_name))
        {
            $valid = $this->validate_table($tbl_definition, $table_name_new);
        }
        else
        {
            $valid = false;
        }
        if ($valid)
        {
            $this->db_definition['tables'][$table_name_new] = $tbl_definition;
            unset($this->db_definition['tables'][$table_name]);
            ksort($this->db_definition['tables'],SORT_STRING);
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
            $links = Openads_Links::readLinksDotIni($this->links_trans, $table_name);
            unset($links[$table_name][$link_name]);
            return Openads_Links::writeLinksDotIni($this->links_trans, $links);

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
            $links = Openads_Links::readLinksDotIni($this->links_trans, $table_name);
            $links[$table_name][$link_add] = $link_add_target;
            return Openads_Links::writeLinksDotIni($this->links_trans, $links);
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
            $links = Openads_Links::readLinksDotIni($this->links_trans, $table_name);
            if (!isset($links[$table_name])) {
                $links[$table_name] = array();
            }
        } else {
            $links = array();
        }
        return $links;
    }

    /**
     * build an array of links cross-references
     *
     * @return array
     */
    function getLinkTargets()
    {
        $links_targets = array();
        if ($this->use_links)
        {
            foreach ($this->db_definition['tables'] as $tk => $tv) {
                if (isset($tv['indexes'])) {
                    foreach ($tv['indexes'] as $v) {
                        if (isset($v['primary']) && $v['primary'] && count($v['fields']) == 1) {
                            $links_targets["$tk:".key($v['fields'])] = "$tk (".key($v['fields']).")";
                        }
                    }
                }
            }
        }
        return $links_targets;
    }

    /**
     * create and return an instance of MDB2_Schema with an MDB2 db connection
     *
     * @param array $options
     * @return MDB2_Schema
     */
    function connect($options)
    {
        $dsn['phptype']     = $GLOBALS['_MAX']['CONF']['database']['type'];
        $dsn['hostspec']    = $GLOBALS['_MAX']['CONF']['database']['host'];
        $dsn['username']    = '';
        $dsn['password']    = '';
        $dsn['database']    = '';
        return MDB2_Schema::factory(Openads_Dal::singleton($dsn), $options);
    }

    /**
     * verify that table properties are valid and legal
     *
     * @param array $tbl_definition
     * @param string $tbl_name
     * @return boolean
     */
    function validate_table($tbl_definition, $tbl_name)
    {
        $this->init_schema_validator();
        $result = $this->_validator->validateTable($this->db_definition['tables'], $tbl_definition, $tbl_name);
        return (Pear::iserror($result)? false: true);
    }

    /**
     * verify that field properties are valid and legal
     *
     * @param string $table_name
     * @param array $field_definition
     * @param string $field_name
     * @return boolean
     */
    function validate_field($table_name, $field_definition, $field_name)
    {
        $this->init_schema_validator();
        $result = $this->_validator->validateField($this->db_definition['tables'][$table_name]['fields'], $field_definition, $field_name);
        return (Pear::iserror($result)? false: true);
    }

    /**
     * verify that index properties are valid and legal
     *
     * @param string $table_name
     * @param array $idx_definition
     * @param string $idx_name
     * @return boolean
     */
    function validate_index($table_name, $idx_definition, $idx_name)
    {
        $this->init_schema_validator();
        $result = $this->_validator->validateIndex($this->db_definition['tables'][$table_name]['indexes'], $idx_definition, $idx_name);
        return (Pear::iserror($result)? false: true);
    }

    /**
     * check all indexes for a given field
     * alter indexes to reflect changes to the field
     *
     * @param string $table_name
     * @param array $table_definition
     * @param string $field_name_old
     * @param string $field_name_new
     * @return mixed     true on success or PEAR_ERROR
     */
    function updateFieldIndexRelations($table_name, &$table_definition, $field_name_old, $field_name_new)
    {
        if (!empty($table_definition['indexes']) && is_array($table_definition['indexes']))
        {
            foreach ($table_definition['indexes'] as $idx_name => $index)
            {
                if (is_array($index['fields']) && array_key_exists($field_name_old, $index['fields']))
                {
                    foreach ($index['fields'] AS $field => $target)
                    {
                        if ($field_name_old == $field)
                        {
                            if ($field_name_new)
                            {
                                $fields_ordered[$field_name_new] = $target;
                            }
                        }
                        else
                        {
                            $fields_ordered[$field] = $target;
                        }
                    }
                    if (is_array($fields_ordered))
                    {
                        $table_definition['indexes'][$idx_name]['fields'] = $fields_ordered;
                    }
                    else
                    {
                        unset($table_definition['indexes'][$idx_name]);
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
                $links = Openads_Links::readLinksDotIni($this->links_trans, $table_name);
                reset($links);
                foreach ($links AS $table => $keys)
                {
                    foreach ($keys AS $field => $target)
                    {
                        if (($target['table']==$table_name) && ($target['field']==$field_name_old))
                        {
                            unset($links[$table][$field]);
                            if ($field_name_new)
                            {
                                $target['field'] = $field_name_new;
                                $links[$table][$field] = $target;
                            }
                            if (!is_array($links[$table]))
                            {
                                unset($links[$table]);
                            }
                        }
                        if (($table==$table_name) && ($field==$field_name_old))
                        {
                            unset($links[$table][$field]);
                            if ($field_name_new)
                            {
                                $field = $field_name_new;
                                $links[$table][$field] = $target;
                            }
                            if (!is_array($links[$table]))
                            {
                                unset($links[$table]);
                            }
                        }
                    }
                }
                return Openads_Links::writeLinksDotIni($this->links_trans, $links);
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
                $links = Openads_Links::readLinksDotIni($this->links_trans, $table_name);
                foreach ($links AS $table => $keys)
                {
                    if (($table==$table_name))
                    {
                        unset($links[$table]);
                    }
                    foreach ($keys AS $field => $target)
                    {
                        if (($target['table']==$table_name))
                        {
                            unset($links[$table][$field]);
                        }
                    }
                }
                return Openads_Links::writeLinksDotIni($this->links_trans, $links);
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
                $links = Openads_Links::readLinksDotIni($this->links_trans, $table_name);
                if (isset($links[$table_name]))
                {
                    $links[$table_name_new] = $links[$table_name];
                    unset($links[$table_name]);
                }

                foreach ($links AS $table => $keys)
                {
                    foreach ($keys AS $field => $target)

                    {
                        foreach ($keys AS $field => $target)
                        {
                            if (($target['table']==$table_name))
                            {
                                $links[$table][$field]['table'] = $table_name_new;
                            }
                        }
                    }
                }
                return Openads_Links::writeLinksDotIni($this->links_trans, $links);
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
        if (!isset($this->_validator))
        {
            $fail_on_invalid_names = array();
            $valid_types = $this->schema->options['valid_types'];
            $force_defaults = '';

            $this->_validator =& new MDB2_Schema_Validate($fail_on_invalid_names, $valid_types, $force_defaults);
        }
        if (!Pear::iserror($result))
        {
            return $this->_validator;
        }
        return false;
    }

    /**
     * check access to an array of requried files/folders
     *
     *
     * @return array of error messages
     */
    function checkPermissions()
    {
        $aErrors = array();

        foreach ($this->file_perms as $file)
        {
            if (empty($file))
            {
                continue;
            }
            if (!file_exists($file))
            {
                $aErrors[] = sprintf("The file '%s' does not exists", $file);
            }
            elseif (!is_writable($file))
            {
                $aErrors[] = sprintf("The file '%s' is not writable", $file);
            }
        }

        if (count($aErrors))
        {
            return $aErrors;
        }

        return true;
    }
}

?>

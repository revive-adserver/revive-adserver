<?php

/**
 * Openads Schema Management Utility
 *
 * @author Monique Szpak <monique.szpak@openads.org>
 *
 * $Id $
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

    var $file_schema_core;
    var $path_schema_final;
    var $path_schema_trans;
    var $file_changes_core;

    var $path_links_final;
    var $path_links_trans;

    var $schema_final;
    var $schema_trans;

    var $file_links_core;
    var $links_final;
    var $links_trans;

    var $working_file_schema;
    var $working_file_links;

    var $_validator;

    var $version;

    function __construct()
    {
        $this->file_schema_core = 'tables_core.xml';
        $this->path_schema_final = MAX_PATH.'/etc/';
        $this->path_schema_trans = MAX_PATH.'/var/';
        $this->file_changes_core = $this->path_schema_trans.'changes_core.xml';

        $this->file_links_core = 'db_schema.links.ini';
        $this->path_links_final = MAX_PATH.'/lib/max/Dal/DataObjects/';
        $this->path_links_trans = MAX_PATH.'/var/';

        $this->schema_final = $this->path_schema_final.$this->file_schema_core;
        $this->schema_trans = $this->path_schema_trans.$this->file_schema_core;

        $this->links_final = $this->path_links_final.$this->file_links_core;
        $this->links_trans = $this->path_links_trans.$this->file_links_core;

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

    function Openads_Schema_Manager()
    {
        $this->__construct();
    }

    function createChangeset()
    {
        if (file_exists($this->schema_trans) && file_exists($this->schema_final))
        {
            $prev_definition = $this->schema->parseDatabaseDefinitionFile($this->schema_final);
            $curr_definition = $this->schema->parseDatabaseDefinitionFile($this->schema_trans);
            $changes         = $this->schema->compareDefinitions($curr_definition, $prev_definition);

            $this->dump_options['output']     = $this->file_changes_core;
            $this->dump_options['xsl_file']   = "xsl/mdb2_changeset.xsl";
            $changes['version']               = $curr_definition['version'];
            $changes['name']                  = $curr_definition['name'];
            return $this->schema->dumpChangeset($changes, $this->dump_options, true);
        }
    }

    function createTransitional()
    {
        if (file_exists($this->schema_trans))
        {
            unlink($this->schema_trans);
        }
        if (file_exists($this->links_trans))
        {
            unlink($this->links_trans);
        }
        if (file_exists($this->schema_final))
        {
            $this->working_file_schema = $this->schema_final;
            $this->parseWorkingDefinitionFile();
            $this->version++;
            $this->writeWorkingDefinitionFile();
        }
        if (file_exists($this->links_final))
        {
            copy($this->links_final, $this->links_trans);
        }
    }

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

        if (file_exists($this->links_trans))
        {
            $this->working_file_links = $this->links_trans;
        }
        else if (file_exists($this->links_final))
        {
            $this->working_file_links = $working_links_final;
        }
    }

    function parseWorkingDefinitionFile()
    {
        $this->db_definition = $this->schema->parseDatabaseDefinitionFile($this->working_file_schema);
        $this->version = $this->db_definition['version'];
    }

    function writeWorkingDefinitionFile()
    {
        $this->dump_options['custom_tags']['version'] = $this->version;
        $this->schema->dumpDatabase($this->db_definition, $this->dump_options, MDB2_SCHEMA_DUMP_STRUCTURE, false);
    }

    function deleteTransitional()
    {
        if (file_exists($this->schema_trans))
        {
            unlink($this->schema_trans);
        }
        if (file_exists($this->links_trans))
        {
            unlink($this->links_trans);
        }
    }

    function deleteChangeset()
    {
        if (file_exists($this->file_changes_core))
        {
            unlink($this->file_changes_core);
        }
    }

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
                $this->field_index_relations($table_name, $tbl_definition, $field_name_old, $field_name_new);
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
                $this->writeWorkingDefinitionFile();
            }
        }
    }

    function fieldAdd($table_name, $field_name, $dd_field_name)
    {
        $this->parseWorkingDefinitionFile();
        $fld_definition = $this->dd_definition['fields'][$dd_field_name];
        $valid = $this->validate_field($table_name, $fld_definition, $field_name);
        if ($valid)
        {
            $tbl_definition = $this->db_definition['tables'][$table_name];
            $tbl_definition['fields'][$field_name] = $fld_definition;
            //$this->field_index_relations($table_name, $tbl_definition, '', $field_name);
            unset($this->db_definition['tables'][$table_name]);
            $valid = $this->validate_table($tbl_definition, $table_name);
            if ($valid)
            {
                $this->db_definition['tables'][$table_name] = $tbl_definition;
                ksort($this->db_definition['tables'],SORT_STRING);
                $this->writeWorkingDefinitionFile();
            }
        }
    }

    function fieldDelete($table_name, $field_name)
    {
        $this->parseWorkingDefinitionFile();
        $tbl_definition = $this->db_definition['tables'][$table_name];
        unset($tbl_definition['fields'][$field_name]);

        $this->field_index_relations($table_name, $tbl_definition, $field_name, '');
        unset($this->db_definition['tables'][$table_name]);
        $valid = $this->validate_table($tbl_definition, $table_name);
        if ($valid)
        {
            $this->db_definition['tables'][$table_name] = $tbl_definition;
            ksort($this->db_definition['tables'],SORT_STRING);
            $this->writeWorkingDefinitionFile();
        }
    }


    function indexDelete($table_name, $index_name)
    {
        $this->parseWorkingDefinitionFile();
        unset($this->db_definition['tables'][$table_name]['indexes'][$index_name]);
        $this->writeWorkingDefinitionFile();
    }

    function indexAdd($table_name, $index_name, $index_fields, $primary='', $unique='')
    {
        $this->parseWorkingDefinitionFile();
        $this->db_definition['tables'][$table_name]['indexes'][$index_name] = array();
        $this->db_definition['tables'][$table_name]['indexes'][$index_name]['fields'] = array();
        $this->db_definition['tables'][$table_name]['indexes'][$index_name]['primary'] = $primary;
        $this->db_definition['tables'][$table_name]['indexes'][$index_name]['unique'] = $unique;
        foreach ($index_fields AS $k=>$fld_name)
        {
            $this->db_definition['tables'][$table_name]['indexes'][$index_name]['fields'][$fld_name] = array('sorting'=>'ascending');
        }
        $this->writeWorkingDefinitionFile();
    }

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
            $this->writeWorkingDefinitionFile();
        }
        return $valid;
    }

    function tableDelete($table_name)
    {
        $this->parseWorkingDefinitionFile();
        $this->table_link_relations($table_name);
        unset($this->db_definition['tables'][$table_name]);
        $this->writeWorkingDefinitionFile();
    }

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
            $this->writeWorkingDefinitionFile();
            $this->table_link_relations_update($table_name, $table_name_new);

            return true;
        }

        return false;
    }

    function linkDelete($table_name, $link_name)
    {
        $links = Openads_Links::readLinksDotIni($this->links_trans, $table_name);
        unset($links[$table_name][$link_name]);
        Openads_Links::writeLinksDotIni($this->links_trans, $links);
    }

    function linkAdd($table_name, $link_add, $link_add_target)
    {
        $links = Openads_Links::readLinksDotIni($this->links_trans, $table_name);
        $links[$table_name][$link_add] = $link_add_target;
        Openads_Links::writeLinksDotIni($this->links_trans, $links);
    }

    function readForeignKeys($table_name)
    {
        $links = Openads_Links::readLinksDotIni($this->links_trans, $table_name);
        if (!isset($links[$table_name])) {
            $links[$table_name] = array();
        }
        return $links;
    }

    function getLinkTargets()
    {
        $links_targets = array();
        foreach ($this->db_definition['tables'] as $tk => $tv) {
            if (isset($tv['indexes'])) {
                foreach ($tv['indexes'] as $v) {
                    if (isset($v['primary']) && $v['primary'] && count($v['fields']) == 1) {
                        $links_targets["$tk:".key($v['fields'])] = "$tk (".key($v['fields']).")";
                    }
                }
            }
        }
        return $links_targets;
    }

    function connect($options)
    {
        $dsn['phptype']     = $GLOBALS['_MAX']['CONF']['database']['type'];
        $dsn['hostspec']    = $GLOBALS['_MAX']['CONF']['database']['host'];
        $dsn['username']    = '';
        $dsn['password']    = '';
        $dsn['database']    = '';

        return MDB2_Schema::factory(Openads_Dal::singleton($dsn), $options);
    }

    function validate_table($tbl_definition, $tbl_name)
    {
        $this->init_schema_validator();
        $result = $this->_validator->validateTable($this->db_definition['tables'], $tbl_definition, $tbl_name);
        return (Pear::iserror($result)? false: true);
    }

    function validate_field($table_name, $field_definition, $field_name)
    {
        $this->init_schema_validator();
        $result = $this->_validator->validateField($this->db_definition['tables'][$table_name]['fields'], $field_definition, $field_name);
        return (Pear::iserror($result)? false: true);
    }

    function field_index_relations($table_name, &$table_definition, $field_name_old, $field_name_new)
    {
        if (!empty($table_definition['indexes']) && is_array($table_definition['indexes']))
        {
            foreach ($table_definition['indexes'] as $idx_name => $index)
            {
                if (is_array($index['fields']) && array_key_exists($field_name_old, $index['fields']))
                {
                    foreach ($index['fields'] AS $k => $v)
                    {
                        if ($field_name_old == $k)
                        {
                            if ($field_name_new)
                            {
                                $fields_ordered[$field_name_new] = $v;
                            }
                        }
                        else
                        {
                            $fields_ordered[$k] = $v;
                        }
                    }
                    $table_definition['indexes'][$idx_name]['fields'] = $fields_ordered;
                }
            }
        }
        $this->field_link_relations($table_name, $field_name_old, $field_name_new);
        return true;
    }

    function field_link_relations($table_name, $field_name_old, $field_name_new)
    {
        $links = Openads_Links::readLinksDotIni($this->links_trans, $table_name);
        foreach ($links AS $table => $keys)
        {
            foreach ($keys AS $field => $target)
            {
                if (($field==$field_name_old))
                {
                    if ($field_name_new)
                    {
                        $links[$table][$field_name_new] = $links[$table][$field_name_old];
                    }
                    unset($links[$table][$field_name_old]);
                }
                if (($target['table']==$table_name) && ($target['field']==$field_name_old))
                {
                    if ($field_name_new)
                    {
                        $links[$table][$field_name_old]['field'] == $field_name_new;
                    }
                    else
                    {
                        unset($links[$table][$field_name_old]);
                    }
                }
            }
        }
        Openads_Links::writeLinksDotIni($this->links_trans, $links);
    }

    function table_link_relations($table_name)
    {
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
        Openads_Links::writeLinksDotIni($this->links_trans, $links);
    }

    function table_link_relations_update($table_name, $table_name_new)
    {
        $links = Openads_Links::readLinksDotIni($this->links_trans, $table_name);
        if (isset($links[$table_name])) {
            $links[$table_name_new] = $links[$table_name];
            unset($links[$table_name]);
        }
        foreach ($links AS $table => $keys)
        {
            foreach ($keys AS $field => $target)
            {
                if (($target['table']==$table_name))
                {
                    $links[$table][$field]['table'] = $table_name_new;
                }
            }
        }
        Openads_Links::writeLinksDotIni($this->links_trans, $links);
    }

    function init_schema_validator()
    {
        if (!isset($this->_validator))
        {
            $fail_on_invalid_names = array();
            $valid_types = $this->schema->options['valid_types'];
            $force_defaults = '';

            $this->_validator =& new MDB2_Schema_Validate($fail_on_invalid_names, $valid_types, $force_defaults);
        }
        return $this->_validator;
    }

    function checkPermissions()
    {
        $aFiles = array(
            $this->schema_trans,
            $this->links_trans,
            MAX_SCHEMA_LOG
        );

        $aDirs = array(
            MAX_PATH.'/var'
        );

        $aErrors = array();
        foreach ($aFiles as $file) {
            $dir = dirname($file);
            if (!file_exists($file)) {
                if (!isset($aDirs[$dir])) {
                    $aDirs[] = $dir;
                }
            } elseif (!is_writable($file)) {
                $aErrors[] = sprintf("The file '%s' is not writable", $file);
            }
        }

        foreach ($aDirs as $dir) {
            if (!file_exists($dir)) {
                $aErrors[] = sprintf("The directory '%s' does not exists", $dir);
            } elseif (!is_writable($dir)) {
                $aErrors[] = sprintf("The directory '%s' is not writable", $dir);
            }
        }

        if (count($aErrors)) {
            return $aErrors;
        }

        return true;
    }
}

?>
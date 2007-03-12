<?php

/**
 * Openads Schema Management Utility
 *
 * @author Monique Szpak <monique.szpak@openads.org>
 *
 * $Id $
 *
 */

require_once '../../../init.php';
define('MAX_DEV', MAX_PATH.'/www/devel');

require_once MAX_DEV.'/lib/pear.inc.php';
require_once 'MDB2.php';
require_once 'MDB2/Schema.php';
require_once 'Config.php';
global $schema_trans, $dump_options;

$file_schema_core = 'tables_core.xml';
$path_schema_final = MAX_PATH.'/etc/';
$path_schema_trans = MAX_PATH.'/var/';
$file_changes_core = $path_schema_trans.'changes_core.xml';

$file_links_core = 'db_schema.links.ini';
$path_links_final = MAX_PATH.'/lib/max/Dal/DataObjects/';
$path_links_trans = MAX_PATH.'/var/';

$schema_final = $path_schema_final.$file_schema_core;
$schema_trans = $path_schema_trans.$file_schema_core;

$links_final = $path_links_final.$file_links_core;
$links_trans = $path_links_trans.$file_links_core;

$dump_options = array (
                        'output_mode'   =>    'file',
                        'output'        =>    $schema_trans,
                        'end_of_line'   =>    "\n",
                        'xsl_file'      =>    "xsl/mdb2_schema.xsl",
                        'custom_tags'   => array('version'=>'0.0.1', 'status'=>'transitional')
                      );

require_once MAX_PATH.'/lib/openads/Dal.php';

require_once 'funcs.php';  // this contains the functions registered with xajax
//include xajax itself after the xajax registration funcs
require_once MAX_DEV.'/lib/xajax.inc.php'; // this instantiates xajax object and registers the functions

if (count($_POST)>0)
{
    $schema = & connect($dump_options);
    $dd_definition = $schema->parseDictionaryDefinitionFile(MAX_DEV.'/etc/dd.generic.xml');
}
if (array_key_exists('btn_compare_schemas', $_POST))
{
    if (file_exists($schema_trans) && file_exists($schema_final))
    {
        $prev_definition = $schema->parseDatabaseDefinitionFile($schema_final);
        $curr_definition = $schema->parseDatabaseDefinitionFile($schema_trans);
        $changes         = $schema->compareDefinitions($curr_definition, $prev_definition);

        $dump_options['output']     =   $file_changes_core;
        $dump_options['xsl_file']   = "xsl/mdb2_changeset.xsl";
        $changes['version']         = $curr_definition['version'];
        $xmlchanges                 = $schema->dumpChangeset($changes, $dump_options, true);
        if (file_exists($file_changes_core))
        {
            $file = $file_changes_core;
            header('Content-Type: application/xhtml+xml; charset=ISO-8859-1');
            readfile($file);
            exit();
        }
    }
}
else if (array_key_exists('btn_copy_final', $_POST))
{
    if (file_exists($schema_trans))
    {
        unlink($schema_trans);
    }
    if (file_exists($links_trans))
    {
        unlink($links_trans);
    }
    if (file_exists($schema_final))
    {
        $db_definition = $schema->parseDatabaseDefinitionFile($schema_final);
        $dump_options['custom_tags']['version'] = $db_definition['version'];
        $dump_options['custom_tags']['version']++;
        $dump = $schema->dumpDatabase($db_definition, $dump_options, MDB2_SCHEMA_DUMP_STRUCTURE, false);
    }
    if (file_exists($links_final))
    {
        copy($links_final, $links_trans);
    }
}
else if (array_key_exists('btn_delete_trans', $_POST))
{
    if (file_exists($schema_trans))
    {
        unlink($schema_trans);
    }
    if (file_exists($links_trans))
    {
        unlink($links_trans);
    }
}
else if (array_key_exists('btn_changeset_delete', $_POST))
{
    if (file_exists($file_changes_core))
    {
        unlink($file_changes_core);
    }
}
if (file_exists($schema_trans))
{
    $file = $schema_trans;
}
else if (file_exists($schema_final))
{
    $file = $schema_final;
}

if (file_exists($links_trans))
{
    $file_links = $links_trans;
}
else if (file_exists($links_final))
{
    $file_links = $links_final;
}

if (array_key_exists('btn_table_cancel', $_POST) ||
    array_key_exists('btn_changeset_cancel', $_POST))
{
    header('Content-Type: application/xhtml+xml; charset=ISO-8859-1');
    readfile($file);
    exit();
}
else if (array_key_exists('btn_field_save', $_POST))
{
    $db_definition = $schema->parseDatabaseDefinitionFile($schema_trans);
    $table = $_POST['table_edit'];
    $field_name_old = $_POST['field_name'];
    $field_name_new = $_POST['fld_new_name'];
    $field_type_old = $_POST['fld_old_type'];
    $field_type_new = $_POST['fld_new_type'];
    $fld_definition = $db_definition['tables'][$table]['fields'][$field_name_old];
    $fld_definition['was'] = $field_name_old;
    if ($field_name_new != $field_name_old)
    {
        $db_definition['tables'][$table]['fields'][$field_name_new] = $fld_definition;
        unset($db_definition['tables'][$table]['fields'][$field_name_old]);
    }
    else if ($field_type_new != $field_type_old)
    {
        $fld_definition = $dd_definition['fields'][$field_type_new];
        $db_definition['tables'][$table]['fields'][$field_name_old] = $fld_definition;
    }
    $dump = $schema->dumpDatabase($db_definition, $dump_options, MDB2_SCHEMA_DUMP_STRUCTURE, false);
}
else if (array_key_exists('btn_field_add', $_POST))
{
    $db_definition = $schema->parseDatabaseDefinitionFile($file);
    $table = $_POST['table_edit'];
    $field_name = $_POST['field_add'];
    $fld_definition = $dd_definition['fields'][$_POST['sel_field_add']];
    $db_definition['tables'][$table]['fields'][$field_name] = $fld_definition;
    $dump = $schema->dumpDatabase($db_definition, $dump_options, MDB2_SCHEMA_DUMP_STRUCTURE, false);
}
else if (array_key_exists('btn_field_del', $_POST))
{
    $table = $_POST['table_edit'];
    $db_definition = $schema->parseDatabaseDefinitionFile($file);
    $table = $_POST['table_edit'];
    $field = $_POST['field_name'];
    unset($db_definition['tables'][$table]['fields'][$field]);
    $dump = $schema->dumpDatabase($db_definition, $dump_options, MDB2_SCHEMA_DUMP_STRUCTURE, false);
}
else if (array_key_exists('btn_index_del', $_POST))
{
    $db_definition = $schema->parseDatabaseDefinitionFile($file);
    $table = $_POST['table_edit'];
    $index = $_POST['index_name'];
    unset($db_definition['tables'][$table]['indexes'][$index]);
    $dump = $schema->dumpDatabase($db_definition, $dump_options, MDB2_SCHEMA_DUMP_STRUCTURE, false);
}
else if (array_key_exists('btn_index_add', $_POST))
{
    $db_definition = $schema->parseDatabaseDefinitionFile($file);
    $table = $_POST['table_edit'];
    $index_name = $_POST['index_add'];
    $index_fields = $_POST['sel_idxfld_add'];
    $db_definition['tables'][$table]['indexes'][$index_name] = array();
    $db_definition['tables'][$table]['indexes'][$index_name]['fields'] = array();
    foreach ($index_fields AS $k=>$fld_name)
    {
        $db_definition['tables'][$table]['indexes'][$index_name]['fields'][$fld_name] = array('sorting'=>'ascending');
    }
    $dump = $schema->dumpDatabase($db_definition, $dump_options, MDB2_SCHEMA_DUMP_STRUCTURE, false);
}
else if (array_key_exists('btn_link_del', $_POST))
{
    $table = $_POST['table_edit'];
    $links = readLinksDotIni($file_links, $table);
    foreach ($_POST['chklnk'] AS $k=>$link_name)
    {
        unset($links[$link_name]);
    }

    writeLinksDotIni($file_links, $table, $links);
}
else if (array_key_exists('btn_link_add', $_POST))
{
    $table = $_POST['table_edit'];
    $links = readLinksDotIni($file_links, $table);
    $links[$_POST['link_add']] = $_POST['link_add_target'];

    writeLinksDotIni($file_links, $table, $links);
}
else if (array_key_exists('btn_table_edit', $_POST))
{
    $table = $_POST['btn_table_edit'];
}
else if (array_key_exists('table_edit', $_POST))
{
    $table = $_POST['table_edit'];
}
else if (array_key_exists('btn_table_new', $_POST))
{
    if (array_key_exists('new_table_name', $_POST)) {
        $db_definition = $schema->parseDatabaseDefinitionFile($file);
        $table = $_POST['new_table_name'];
        $db_definition['tables'][$table] = array();
        $fld_definition = array('newfield'=>array('type'=>'text','length'=>'','default'=>'','notnull'=>''));
        $db_definition['tables'][$table]['fields'] = $fld_definition;
        $dump = $schema->dumpDatabase($db_definition, $dump_options, MDB2_SCHEMA_DUMP_STRUCTURE, false);
    }
    header('Content-Type: application/xhtml+xml; charset=ISO-8859-1');
    readfile($file);
    exit();
}
else if (array_key_exists('btn_table_delete', $_POST))
{
    $db_definition = $schema->parseDatabaseDefinitionFile($file);
    $table = $_POST['table_edit'];
    unset($db_definition['tables'][$table]);
    $dump = $schema->dumpDatabase($db_definition, $dump_options, MDB2_SCHEMA_DUMP_STRUCTURE, false);
    header('Content-Type: application/xhtml+xml; charset=ISO-8859-1');
    readfile($file);
    exit();
}
else
{
    header('Content-Type: application/xhtml+xml; charset=ISO-8859-1');
    readfile($file);
    exit();
}

$db_definition = $schema->parseDatabaseDefinitionFile($file);
$tbl_definition = $db_definition['tables'][$table];

$links = readLinksDotIni($file_links, $table);

$links_targets = array();
foreach ($db_definition['tables'] as $tk => $tv) {
    if (isset($tv['indexes'])) {
        foreach ($tv['indexes'] as $v) {
            if (isset($v['primary']) && $v['primary'] && count($v['fields']) == 1) {
                $links_targets["$tk:".key($v['fields'])] = "$tk (".key($v['fields']).")";
            }
        }
    }
}

include 'edit.html';
exit();

function readLinksDotIni($file_links, $table)
{
    $links =& new Config();
    $root =& $links->parseConfig($file_links, 'inifile');
    $links = $root->toArray();
    $links = $links['root'];
    if (isset($links[$table])) {
        $links = $links[$table];
        foreach ($links as $fk => $fv) {
            $tmp = explode(':', $fv);
            $links[$fk] = array(
                'table' => $tmp[0],
                'field' => $tmp[1]
            );
        }
    } else {
        $links = array();
    }

    return $links;
}

function writeLinksDotIni($file_links, $table, $link_array)
{
    $links =& new Config();
    $root =& $links->parseConfig($file_links, 'inifile');
    $root = $root->toArray();
    $root = $root['root'];

    foreach ($link_array as $k => $v) {
        if (is_array($v)) {
            $link_array[$k] = "{$v['table']}:{$v['field']}";
        }
    }

    if (count($link_array)) {
        $root[$table] = $link_array;
    } else {
        unset($root[$table]);
    }

    ksort($root);

    $links =& new Config();
    $links->parseConfig($root, 'phparray');
    $links->writeConfig($file_links, 'inifile');
}

?>

<?php

/**
 * Openads Schema Management Utility
 *
 * @author Monique Szpak <monique.szpak@openads.org>
 *
 * $Id $
 *
 */

define('MAX_PATH', dirname(__FILE__).'/../../..');
define('MAX_DEV', dirname(__FILE__).'/..');
define('MAX_XSL', MAX_DEV.'/schema/xsl');
define('MAX_PEAR', MAX_PATH.'/lib/pear/');

require_once MAX_DEV.'/lib/pear.inc.php';
require_once MAX_DEV.'/lib/oaclass.error.php';
require_once 'MDB2.php';
require_once 'MDB2/Schema.php';
require_once 'funcs.php';  // this contains the functions registered with xajax
//include xajax itself after the xajax registration funcs
require_once MAX_DEV.'/lib/xajax.inc.php'; // this instantiates xajax object and registers the functions
require_once MAX_PATH.'/lib/openads/Dal.php';

$file_schema_core = 'tables_core.xml';
$path_schema_final = MAX_PATH.'/etc/';
$path_schema_trans = MAX_PATH.'/var/';

$schema_final = $path_schema_final.$file_schema_core;
$schema_trans = $path_schema_trans.$file_schema_core;

$dump_options = array (
                        'output_mode'   =>    'file',
                        'output'        =>    $schema_trans,
                        'end_of_line'   =>    "\n",
                        'xsl_file'      =>    "xsl/mdb2_schema.xsl",
                        'custom_tags'   => array('version'=>'0.0.1', 'status'=>'transitional')
                      );

if (count($_POST)>0)
{
    // need some dsn info to make connection
    // even though we won't actually connect to the server
    // don't need to enter username/password/database
    // unless you need to connect for some reason
    // for parsing just the host and db type is required
    $dsn['phptype']     = 'mysql';
    $dsn['hostspec']    = 'localhost';
    $dsn['username']    = '';
    $dsn['password']    = '';
    $dsn['database']    = '';
    // required by Openads_Dal which would normally get it from conf.ini after init
    $GLOBALS['_MAX']['CONF']['database']['type'] = $dsn['phptype'];

    $schema = & MDB2_Schema::factory(Openads_Dal::singleton($dsn), $dump_options);
    $dd_definition = $schema->parseDictionaryDefinitionFile(MAX_DEV.'/etc/dd.generic.xml');
}

if (array_key_exists('btn_copy_final', $_POST))
{
    if (file_exists($schema_trans))
    {
        unlink($schema_trans);
    }
    if (file_exists($schema_final))
    {
        $db_definition = $schema->parseDatabaseDefinitionFile($schema_final);
        $dump_options['custom_tags']['version'] = $db_definition['version'];
        $dump_options['custom_tags']['version']++;
        $dump = $schema->dumpDatabase($db_definition, $dump_options, MDB2_SCHEMA_DUMP_STRUCTURE, false);
    }
}
else if (array_key_exists('btn_delete_trans', $_POST))
{
    if (file_exists($schema_trans))
    {
        unlink($schema_trans);
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

if (array_key_exists('btn_table_cancel', $_POST))
{
    header('Content-Type: application/xhtml+xml; charset=ISO-8859-1');
    readfile($file);
    exit();
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
    $db_definition = $schema->parseDatabaseDefinitionFile($file);
    $table = $_POST['table_edit'];
    $fields = $_POST['chkfld'];
    foreach ($fields AS $k=>$field_name)
    {
        unset($db_definition['tables'][$table]['fields'][$field_name]);
    }
    $dump = $schema->dumpDatabase($db_definition, $dump_options, MDB2_SCHEMA_DUMP_STRUCTURE, false);
}
else if (array_key_exists('btn_index_del', $_POST))
{
    $db_definition = $schema->parseDatabaseDefinitionFile($file);
    $table = $_POST['table_edit'];
    $indexes = $_POST['chkidx'];
    foreach ($indexes AS $k=>$index_name)
    {
        unset($db_definition['tables'][$table]['indexes'][$index_name]);
    }
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
else if (array_key_exists('btn_table_edit', $_POST))
{
    $table = $_POST['btn_table_edit'];
}
else if (array_key_exists('btn_table_new', $_POST))
{
    // do new table stuff
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
include 'edit.html';
exit();


// comment the above and uncomment below to test/play with xAjax
//include 'index.html';

?>


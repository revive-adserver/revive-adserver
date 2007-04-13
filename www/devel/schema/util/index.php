<?php

require_once 'init.php';

//require_once '../../../../init.php';
//define('MAX_DEV', MAX_PATH.'/www/devel');



$htmlfile = 'index.html';

if (array_key_exists('dump', $_POST) ||
    array_key_exists('diff', $_POST) ||
    array_key_exists('diffx', $_POST)||
    array_key_exists('create', $_POST) ||
    array_key_exists('parsec', $_POST) ||
    array_key_exists('show', $_POST))
{
    $dsn = $_POST['dsn'];
    $options = array(
                        'idxname_format' => '%s',
                     );

    $GLOBALS['_MAX']['CONF']['database']['type'] = $dsn['phptype'];
    $mdb = &OA_DB::singleton($dsn);

    $options = array(   'force_defaults'=>false,
                     );

    $schema = & MDB2_Schema::factory($mdb, $options);

    if (array_key_exists('dump', $_POST))
    {
        $def    = $schema->getDefinitionFromDatabase();
        $dumpfile_mdbs = $_POST['dumpfile_mdbs'];
        $options = array (
                            'output_mode'   =>    'file',
                            'output'        =>    MAX_VAR.'/mdbs_'.$dumpfile_mdbs.'.xml',
                            'end_of_line'   =>    "\n",
                            'xsl_file'      =>    "/devel/schema/util/xsl/mdb2_schema.xsl",
                            'custom_tags'   => array('version'=>'0', 'status'=>'transitional')
                          );
        $dump = $schema->dumpDatabase($def, $options, MDB2_SCHEMA_DUMP_STRUCTURE, false);

    }
    else if (array_key_exists('diff', $_POST))
    {
        $parse_prev = $schema->getDefinitionFromDatabase();
        $parse_curr = $schema->parseDatabaseDefinitionFile(MAX_VAR.'/'.$_POST['filediff']);
        $changes    = $schema->compareDefinitions($parse_curr, $parse_prev);
        $xmlchanges = $schema->dumpChangeset($changes, $options);
    }
    else if (array_key_exists('diffx', $_POST))
    {
        $parse_prev = $schema->parseDatabaseDefinitionFile(MAX_VAR.'/'.$_POST['filediffx1']);
        $parse_curr = $schema->parseDatabaseDefinitionFile(MAX_VAR.'/'.$_POST['filediffx2']);
        $changes    = $schema->compareDefinitions($parse_curr, $parse_prev);

        $dumpfile_mdbc = $_POST['dumpfile_mdbc'];
        $changes['name'] = 'mdbc_'.$dumpfile_mdbc.'.xml';
        $options = array (
                            'output_mode'   =>    'file',
                            'output'        =>    MAX_VAR.'/'.$changes['name'],
                            'end_of_line'   =>    "\n"
                          );
        $changes['version'] = 'v0.0.0';
        $split = array_key_exists('split', $_POST);
        $xmlchanges = $schema->dumpChangeset($changes, $options, $split);
    }
    else if (array_key_exists('parsec', $_POST))
    {
        $file = $_POST['fileview'];
        $changes = $schema->parseChangesetDefinitionFile(MAX_VAR.'/'.$file);
    }
    else if (array_key_exists('create', $_POST))
    {
        $def = $schema->parseDatabaseDefinitionFile(MAX_VAR.'/'.$_POST['filecreate']);
        //$def['name'] = $dsn['database'];
        $schema->createDatabase($def);
    }
    else if (array_key_exists('show', $_POST))
    {
        header('Content-Type: application/xhtml+xml; charset=ISO-8859-1');
        readfile(MAX_VAR.'/'.$_POST['fileview']);
        exit();


    }
    $warnings = $schema->warnings;
    $mdb->disconnect();
}
else
{
    $dsn['phptype']  = 'mysql';
    $dsn['hostspec'] = 'localhost';
    $dsn['username'] = '';
    $dsn['password'] = '';
    $dsn['database'] = '';
    $dumpfile_mdbs   = '';
    $dumpfile_mdbc   = '';
    $changes         = array();
    $warnings        = array();

}
$schemas = getSchemas();
include $htmlfile;
?>

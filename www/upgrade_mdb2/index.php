<?php
require_once('error.inc.php');

$htmlfile = 'mdb2.html';

function varchar_callback($p1='', $p2='', $p3='')
{
    switch ($p3['mapped_type'])
    {
        case 'url': return 'http://';
        default: return ($p1->datatype->valid_default_values[$p3['mapped_type']] ? $p1->datatype->valid_default_values[$p3['mapped_type']] : '');
    }
}

if (array_key_exists('dump', $_POST) ||
    array_key_exists('diff', $_POST) ||
    array_key_exists('diffx', $_POST)||
    array_key_exists('create', $_POST) ||
    array_key_exists('show', $_POST))
{
    $dsn = $_POST['dsn'];
    $options = array();

//    $options = array('debug'=>true,
//                    'debug_handler'=>'debug_handler'
//                    );
//                    'portability'=> MDB2_PORTABILITY_EMPTY_TO_NULL

//    $options = array(
//                        'datatype_map'=>array('varchar'=>'url'
//                                              ),
//                        'datatype_map_callback'=>array('varchar'=>'varchar_callback'
//                                                        )
//                    );

    $mdb =& MDB2::factory($dsn, $options);

    $options = array('force_defaults'=>false);
    $schema = & MDB2_Schema::factory($mdb, $options);

    if (array_key_exists('dump', $_POST))
    {
        $def    = $schema->getDefinitionFromDatabase();
        $dumpfile_mdbs = $_POST['dumpfile_mdbs'];
        $options = array (
                            'output_mode'   =>    'file',
                            'output'        =>    MAX_VAR.'/mdbs_'.$dumpfile_mdbs.'.xml',
                            'end_of_line'   =>    "\n",
                            'xsl_file'      =>    "/upgrade_mdb2/mdb2_schema.xsl"
                          );
        $dump = $schema->dumpDatabase($def, $options, MDB2_SCHEMA_DUMP_STRUCTURE, false);

    }
    else if (array_key_exists('diff', $_POST))
    {
        $parse_prev   = $schema->getDefinitionFromDatabase();
        $parse_curr = $schema->parseDatabaseDefinitionFile(MAX_VAR.'/'.$_POST['file']);
        $changes    = $schema->compareDefinitions($parse_curr, $parse_prev);
//        $result     = $schema->dumpDatabaseChanges($changes);
    }
    else if (array_key_exists('diffx', $_POST))
    {
        $parse_prev = $schema->parseDatabaseDefinitionFile(MAX_VAR.'/'.$_POST['file1']);
        $parse_curr = $schema->parseDatabaseDefinitionFile(MAX_VAR.'/'.$_POST['file2']);
        $changes    = $schema->compareDefinitions($parse_curr, $parse_prev);

        $dumpfile_mdbc = $_POST['dumpfile_mdbc'];
        $changes['name'] = 'mdbc_'.$dumpfile_mdbc.'.xml';
        $options = array (
                            'output_mode'   =>    'file',
                            'output'        =>    MAX_VAR.'/'.$changes['name'],
                            'end_of_line'   =>    "\n"
                          );
        $changes['version'] = 'v0.0.0';
        $xmlchanges = $schema->dumpChangeset($changes, $options);

        $xmlchangesparsed = $schema->parseChangesetDefinitionFile(MAX_VAR.'/'.$changes['name']);

        $changes['name'] = 'mdbi_'.$dumpfile_mdbs.'.xml';
        $options = array (
                            'output_mode'   =>    'file',
                            'output'        =>    MAX_VAR.'/'.$changes['name'],
                            'end_of_line'   =>    "\n"
                          );

        $changes['version'] = 'v0.0.0';
        $xmlinstructions = $schema->dumpInstructions($changes, $options);

//        $variables = array();
//        $disable_query = false;
//        $schema->updateDatabase($parse_curr, $parse_prev, $variables, $disable_query);
//        $result     = $schema->dumpDatabaseChanges($changes);
    }
    else if (array_key_exists('create', $_POST))
    {
        $def = $schema->parseDatabaseDefinitionFile(MAX_VAR.'/'.$_POST['file']);
        $def['name'] = $dsn['database'];
        $schema->createDatabase($def);
    }
    else if (array_key_exists('show', $_POST))
    {
        header('Content-Type: application/xhtml+xml; charset=ISO-8859-1');
        readfile(MAX_VAR.'/'.$_POST['file']);
        exit();


    }
//
//    if ($mdb2_type == 'mysql') {
//        $schema->db->setOption('debug', true);
//        $schema->db->setOption('log_line_break', '<br>');
//        // ok now lets create a new xml schema file from the existing DB
//        $database_definition = $schema->getDefinitionFromDatabase();
//        // we will not use the 'metapear_test_db.schema' for this
//        // this feature is especially interesting for people that have an existing Db and want to move to MDB2's xml schema management
//        // you can also try MDB2_MANAGER_DUMP_ALL and MDB2_MANAGER_DUMP_CONTENT
//        echo(Var_Dump($schema->dumpDatabase(
//            $database_definition,
//            array(
//                'output_mode' => 'file',
//                'output' => $mdb2_name.'2.schema'
//            ),
//            MDB2_SCHEMA_DUMP_STRUCTURE
//        )).'<br>');
//        if ($schema->db->getOption('debug') === true) {
//            echo($schema->db->getDebugOutput().'<br>');
//        }
//        // this is the database definition as an array
//        echo(Var_Dump($database_definition).'<br>');
//    }

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
include 'mdb2.html';
?>

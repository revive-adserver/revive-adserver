<?php

require_once './init.php';



$htmlfile = './tpl/index.html';

if (array_key_exists('dumpStru', $_POST) ||
    array_key_exists('dumpData', $_POST) ||
    array_key_exists('diff', $_POST) ||
    array_key_exists('diffx', $_POST)||
    array_key_exists('create', $_POST) ||
    array_key_exists('parsec', $_POST) ||
    array_key_exists('show', $_POST))
{
    $options = array(
                        'idxname_format' => '%s',
                     );

    $dsn = $_POST['database'];
    $prefix = $_POST['table']['prefix'];
    $GLOBALS['_MAX']['CONF']['database'] = $dsn;
    $GLOBALS['_MAX']['CONF']['database']['type'] = $dsn['phptype'];

	// Use a conf-like array to genarate a string DSN
	$aConf = array('database' => $dsn);
	//$aConf['database']['type'] = $aConf['database']['phptype'];

    $oDbh = &OA_DB::singleton(OA_DB::getDsn($aConf));

    $options = array(   'force_defaults'=>false );

    $schema = & MDB2_Schema::factory($oDbh, $options);

    if (array_key_exists('dumpStru', $_POST)
        || array_key_exists('dumpData', $_POST))
    {
        if (array_key_exists('dumpStru', $_POST))
        {
            $dumpDirective = MDB2_SCHEMA_DUMP_STRUCTURE;
            $dumpfile_mdbs = $dumpfile_mdbs_stru = $_POST['dumpfile_mdbs_stru'];
        }
        if (array_key_exists('dumpData', $_POST))
        {
            $dumpDirective = MDB2_SCHEMA_DUMP_CONTENT;
            $dumpfile_mdbs = $dumpfile_mdbs_data = $_POST['dumpfile_mdbs_data'];
            $query = "SELECT * FROM {$prefix}application_variable";
            $aResult = $oDbh->queryAll($query);
            if (PEAR::isError($aResult))
            {
                $versionSchema = '';
                $versionApp    = '';
            }
            foreach ($aResult as $k =>$aVal)
            {
                if ($aVal['name']=='tables_core')
                {
                    $versionSchema = $aVal['value'];
                }
                if ($aVal['name']=='oa_version')
                {
                    $versionApp = $aVal['value'];
                }
            }
            $dumpfile_mdbs = 'data_tables_core_'.$versionSchema;
        }

        $def    = $schema->getDefinitionFromDatabase();
        $options = array (
                            'output_mode'   =>    'file',
                            'output'        =>    MAX_VAR.'/'.$dumpfile_mdbs.'.xml',
                            'end_of_line'   =>    "\n",
                            'xsl_file'      =>    "/devel/schema/util/xsl/mdb2_schema.xsl",
                            'custom_tags'   => array('version'=>'0', 'status'=>'transitional')
                          );
        $dump = $schema->dumpDatabase($def, $options, $dumpDirective, false);

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
        $changes['name'] = $dumpfile_mdbc;
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
        $aDef = $schema->parseDatabaseDefinitionFile(MAX_VAR.'/'.$_POST['filecreate']);
        //require_once MAX_PATH.'/lib/OA/DB.php';
        //$def['name'] = $dsn['database'];
        //$schema->createDatabase($def);

        //$result = $oDbh->manager->listDatabases();
        if (in_array(strtolower($aDef['name']), array_map('strtolower', $oDbh->manager->listDatabases())))
        {
            $oDbh->manager->dropDatabase($aDef['name']);
        }
        if ($oDbh->manager->createDatabase($aDef['name']))
        {
            $schema->db = OA_DB::changeDatabase($aDef['name']);
            require_once MAX_PATH.'/lib/OA/DB/Table.php';
            $oTable = new OA_DB_Table();
            $oTable->oSchema = $schema;
            $oTable->aDefinition = $aDef;
            $oTable->createAllTables();
        }
    }
    else if (array_key_exists('show', $_POST))
    {
        header('Content-Type: application/xhtml+xml; charset=ISO-8859-1');
        readfile(MAX_VAR.'/'.$_POST['fileview']);
        exit();


    }
    $warnings = $schema->warnings;
    $oDbh->disconnect();
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

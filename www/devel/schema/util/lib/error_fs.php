<?php

require_once('init.php');

$htmlfile = 'error_fs.html';

if (array_key_exists('filesys', $_POST))
{

    $dsn = $_POST['dsn'];

    $options = array();

    $mdb =& MDB2::factory($dsn, $options);
    $mdb->connect($dsn, $options);
    $schema = & MDB2_Schema::factory($mdb, $options);

    $readfile = $_POST['readfile'];
    $writefile = $_POST['writefile'];

    if ($_POST['filesys'] == 1)
    {
        $readfile = 'nofile.txt';
        $def = $schema->parseDatabaseDefinitionFile($readfile);
    }
    else if ($_POST['filesys'] == 2)
    {
        $def = array( "tables" => Array ( "ad_zone_assoc" => Array ( "fields" => Array ( "ad_zone_assoc_id" => Array ( "type" => "integer", "length" => 3, "notnull" => 1, "default" => 0, "autoincrement" => 1, "was" => ad_zone_assoc_id ), "zone_id" => Array ( "type" => integer, "length" => 3, "notnull" => "", "default" => "", "was" => "zone_id" ), "ad_id" => Array ( "type" => integer, "length" => 3, "notnull" =>"", "default" => "", "was" => "ad_id" ), "priority" => Array ( "type" => "float", "notnull" => "", "default" => 0, "was" => "priority" ), "link_type" => Array ( "type" => integer, "length" => 2, "notnull" => 1, "default" => 1, "was" => "link_type" ) ), "indexes" => Array ( "zone_id" => Array ( "fields" => Array ( "zone_id" => Array ( "sorting" => "ascending" ) ), "was" => "zone_id" ), "ad_id" => Array ( "fields" => Array ( "ad_id" => Array ( "sorting" => "ascending" ) ), "was" => "ad_id" ), "primary" => Array ( "fields" => Array ( "ad_zone_assoc_id" => Array ( "sorting" => "ascending" ) ), "primary" => 1, "was" => "primary" ) ), "was" => ad_zone_assoc ) ), "sequences" => Array ( ), "name" => "mdbs_core", "create" => 1, "overwrite" => "");

        $writefile = 'nofile.txt';
        $options = array (
                        'output_mode'   =>    'file',
                        'output'        =>    $writefile,
                        'end_of_line'   =>    "\n",
                        'xsl_file'      =>    "/upgrade_mdb2/mdb2_schema.xsl"
                      );
        $dump = $schema->dumpDatabase($def, $options, MDB2_SCHEMA_DUMP_STRUCTURE, false);
    }
    else
    {
        if ($readfile)
        {
            $def = $schema->parseDatabaseDefinitionFile(MAX_VAR.'/'.$readfile);

            if ($writefile)
            {
                $options = array (
                                'output_mode'   =>    'file',
                                'output'        =>    MAX_VAR.'/'.$writefile,
                                'end_of_line'   =>    "\n",
                                'xsl_file'      =>    "/upgrade_mdb2/mdb2_schema.xsl"
                              );
                $dump = $schema->dumpDatabase($def, $options, MDB2_SCHEMA_DUMP_STRUCTURE, false);
            }
        }
    }
    $mdb->disconnect();
}
else
{
    $dsn['phptype']  = 'mysql';
    $dsn['hostspec'] = 'localhost';
    $dsn['username'] = '';
    $dsn['password'] = '';
    $dsn['database'] = '';
}
include $htmlfile;

?>

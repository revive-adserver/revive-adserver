<?php

require_once('init.php');

$htmlfile = 'error_pa.html';

if (array_key_exists('parser', $_POST))
{

    $dsn = $_POST['dsn'];

    $options = array();

    $mdb =& MDB2::factory($dsn, $options);
    $mdb->connect($dsn, $options);
    $schema = & MDB2_Schema::factory($mdb, $options);

    if ($_POST['parser']==0)
    {
        $readfile = 'var/mdbs_good.xml';
    }
    else if ($_POST['parser']==1)
    {
        $readfile = 'var/mdbs_noheader.xml';
    }
    else if ($_POST['parser']==2)
    {
        $readfile = 'var/mdbs_bad.xml';
    }
    else if ($_POST['parser']==3)
    {
        $readfile = 'var/mdbs_invalid_type.xml';
    }
    else if ($_POST['parser']==3)
    {
        $readfile = 'var/mdbs_invalid_table.xml';
    }
    if ($readfile)
    {
        $def = $schema->parseDatabaseDefinitionFile($readfile);
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

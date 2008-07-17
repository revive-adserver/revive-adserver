<?php

require_once('init.php');

$htmlfile = 'error_db.html';

if (array_key_exists('connect', $_POST))
{

    $dsn = $_POST['dsn'];

    if ($_POST['connect'] == -1)
    {
        $aConf['database']['type']      = $dsn['phptype'];
        $aConf['database']['host']      = $dsn['hostspec'];
        $aConf['database']['username']  = $dsn['username'];
        $aConf['database']['password']  = $dsn['password'];
        $aConf['database']['name']      = $dsn['database'];
        $oDbh = OA_DB::singleton(OA_DB::getDsn($aConf));
        include $htmlfile;
        exit;
    }
    else if ($_POST['connect'] == 1)
    {
        $dsn['phptype']  = '';
        $dsn['hostspec'] = 'localhost';
        $dsn['username'] = '';
        $dsn['password'] = '';
        $dsn['database'] = '';
    }
    else if ($_POST['connect'] == 2)
    {
        $dsn['phptype']  = 'mysql';
        $dsn['hostspec'] = '';
        $dsn['username'] = '';
        $dsn['password'] = '';
        $dsn['database'] = '';
    }
    else if ($_POST['connect'] == 3)
    {
        $dsn['phptype']  = 'mysql';
        $dsn['hostspec'] = 'localhost';
        $dsn['username'] = '';
        $dsn['password'] = '';
        $dsn['database'] = '';
    }
    else if ($_POST['connect'] == 4)
    {
        $dsn['phptype']  = 'mysql';
        $dsn['hostspec'] = 'localhost';
        $dsn['username'] = '';
        $dsn['password'] = '';
        $dsn['database'] = '';
    }
    else if ($_POST['connect'] == 5)
    {
        $dsn['phptype']  = 'mysql';
        $dsn['hostspec'] = 'localhost';
        $dsn['username'] = '';
        $dsn['password'] = '';
        $dsn['database'] = '';
    }
    if ($_POST['connect'] == 6)
    {
        $dsn['phptype']  = 'wrongtype';
        $dsn['hostspec'] = 'localhost';
        $dsn['username'] = '';
        $dsn['password'] = '';
        $dsn['database'] = '';
    }
    else if ($_POST['connect'] == 7)
    {
        $dsn['phptype']  = 'mysql';
        $dsn['hostspec'] = 'wronghost';
        $dsn['username'] = '';
        $dsn['password'] = '';
        $dsn['database'] = '';
    }
    else if ($_POST['connect'] == 8)
    {
        $dsn['phptype']  = 'mysql';
        $dsn['hostspec'] = 'localhost';
        $dsn['username'] = 'wronguser';
        $dsn['password'] = '';
        $dsn['database'] = '';
    }
    else if ($_POST['connect'] == 9)
    {
        $dsn['phptype']  = 'mysql';
        $dsn['hostspec'] = 'localhost';
        $dsn['username'] = '';
        $dsn['password'] = 'wrongpassword';
        $dsn['database'] = '';
    }
    else if ($_POST['connect'] == 10)
    {
        $dsn['phptype']  = 'mysql';
        $dsn['hostspec'] = 'localhost';
        $dsn['username'] = '';
        $dsn['password'] = '';
        $dsn['database'] = 'wrongdatabase';
    }

    $options = array();

    $mdb =& MDB2::factory($dsn, $options);
    $mdb->connect($dsn, $options);

    $mdb->disconnect();
}
else if (array_key_exists('create', $_POST))
{

    $dsn = $_POST['dsn'];

    $options = array();

    $mdb =& MDB2::factory($dsn, $options);
    $mdb->connect($dsn, $options);
    $schema = & MDB2_Schema::factory($mdb, $options);

    if ($_POST['create'] == 0)
    {
        //$def = $schema->parseDatabaseDefinitionFile('/var/mdbs_good.xml');
    }
    else if ($_POST['create'] == 1)
    {
        $def = $schema->parseDatabaseDefinitionFile('var/mdbs_simple.xml');
    }
    else if ($_POST['create'] == 2)
    {
        $def = $schema->parseDatabaseDefinitionFile('var/mdbs_storage_index_prob.xml');
    }
    else if ($_POST['create'] == 3)
    {
        $def = $schema->parseDatabaseDefinitionFile('var/mdbs_reserved_word.xml');
    }
    else if ($_POST['create'] == 4)
    {
        $def = $schema->parseDatabaseDefinitionFile('var/mdbs_no_type.xml');
    }
    else if ($_POST['create'] == 5)
    {
        $def = $schema->parseDatabaseDefinitionFile('var/mdbs_invalid_type.xml');
    }
    $schema->createDatabase($def);

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

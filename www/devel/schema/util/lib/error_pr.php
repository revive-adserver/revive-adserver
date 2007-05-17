<?php

require_once('init.php');

$htmlfile = 'error_pr.html';

if (array_key_exists('program', $_POST))
{

    $dsn = $_POST['dsn'];

    $options = array();

    $mdb =& MDB2::factory($dsn, $options);
    $mdb->connect($dsn, $options);

    $mdb->loadFile('/somefile.txt');
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

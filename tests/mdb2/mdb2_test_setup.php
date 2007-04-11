<?php

require_once 'MDB2/tests/testcases.php';

// use a user that has full permissions on a database named "driver_test"
$db = array(
    'dsn' => array(
        'phptype' => '%db.type%',
        'username' => '%db.username%',
        'password' => '%db.password%',
        'hostspec' => '%db.host%',
        'port' => %db.port%
    ),
    %options%
);

$dbarray = array($db);


require_once('MDB2/Schema.php');
$schema_path = '../../MDB2_Schema/tests/';

// OPENADS ONLY
$schema_path = MAX_PATH.'/lib/pear/MDB2_Schema/tests/';

function pe($e) {
    die($e->getMessage().' '.$e->getUserInfo());
}
function databaseExists($db, $database_name)
{
    $result = $db->manager->listDatabases();
    if (PEAR::isError($result)) {
        return false;
    }
    return in_array(strtolower($database_name), array_map('strtolower', $result));
}
PEAR::pushErrorHandling(PEAR_ERROR_CALLBACK, 'pe');
foreach ($dbarray as $dbtype) {
    $schema =& MDB2_Schema::factory($dbtype['dsn'], $dbtype['options']);
    if (databaseExists($schema->db, 'driver_test'))
    {
        $schema->db->manager->dropDatabase('driver_test');
    }
    $schema->updateDatabase(
        $schema_path.'driver_test.schema',
        false,
        array('create' => '1', 'name' => 'driver_test')
    );
    $schema->updateDatabase(
        $schema_path.'lob_test.schema',
        false,
        array('create' => '1', 'name' => 'driver_test')
    );
}
PEAR::popErrorHandling();
?>

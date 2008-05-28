<?php

declare(ticks=1);

if (PHP_SAPI != 'cli') die('Hey, CLI only!');

define('TEST_ITERATIONS', 100);
define('TEST_CREATIVES', 10);
define('TEST_ZONES', 10);

require "Benchmark/Timer.php";

require 'testCases/BucketDB.php';

$t = new Benchmark_Timer();
$t->start();

$aTests = array(
    25,
    50,
    75,
    100
);

$t->setMarker('Script init');

foreach ($aTests as $concurrency) {

    $oTest = bucketDB::factory(array(
        'type' => 'MySQL',
        'host' => 'localhost',
        'user' => 'root',
        'password' => 'password',
        'dbname' => 'test_bucket',
        'engine' => 'MyISAM'
    ));
    test_update($oTest, $concurrency, $t, 'MyISAM');


    $oTest = bucketDB::factory(array(
        'type' => 'MySQL',
        'host' => 'localhost',
        'user' => 'root',
        'password' => 'password',
        'dbname' => 'test_bucket',
        'engine' => 'InnoDB'
    ));
    test_update($oTest, $concurrency, $t, 'InnoDB');


    $oTest = bucketDB::factory(array(
        'type' => 'MySQL',
        'host' => 'localhost',
        'user' => 'root',
        'password' => 'password',
        'dbname' => 'test_bucket',
        'engine' => 'MEMORY'
    ));
    test_update($oTest, $concurrency, $t, 'MEMORY');


    $oTest = bucketDB::factory(array(
        'type' => 'PgSQL',
        'port' => 5432,
        'host' => 'localhost',
        'user' => 'pgsql',
        'password' => 'password',
        'dbname' => 'test_bucket'
    ));
    test_update($oTest, $concurrency, $t, 'PgSQL ');

    $oTest = bucketDB::factory(array(
        'type' => 'SHM'
    ));
    test_update($oTest, $concurrency, $t, 'SHM   ');

    $oTest = bucketDB::factory(array(
        'type' => 'SHMSemaphore'
    ));
    test_update($oTest, $concurrency, $t, 'SHMSEM');
}


$t->stop();

$t->display();

exit;

function test_update($oTest, $concurrency, $t, $text)
{
    $oTest->updateCreate();
    $oTest->disconnect();

    for ($c = 0; $c < $concurrency; $c++) {
        mt_srand(1000 + $c);
        $pid = pcntl_fork();
        if ($pid == 0) {
            $oTest->connect();
            for ($i = 0; $i < TEST_ITERATIONS; $i++) {
                $oTest->updateTest('2008-05-16 16:00:00', mt_rand(1,TEST_CREATIVES), mt_rand(1,TEST_ZONES)) ? 1 : 0;
            }
            exit;
        }
    }

    $status = 0;
    while (pcntl_wait($status) > 0);

    $result = $oTest->updateResult();
    $fail = $concurrency * TEST_ITERATIONS - $result == 0 ? 'OK' : "ERR: {$result}";

    $oTest->updateDrop();

    $t->setMarker("{$text} - C{$concurrency} - {$fail}");
}

?>
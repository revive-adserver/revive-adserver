<?php

declare(ticks=1);

if (PHP_SAPI != 'cli') die('Hey, CLI only!');

error_reporting(E_ALL);

define('TEST_ITERATIONS', 1);
define('TEST_RECORDS', 1000);

require "Benchmark/Timer.php";

require 'testCases/Cache.php';

$t = new Benchmark_Timer();
$t->start();

$aTests = array(
    10,
//    25,
//    50,
//    75,
//    100
);

$t->setMarker('Script init');

foreach ($aTests as $concurrency) {
    $oTest = Cache::factory(array(
        'type' => 'memcached',
        'host' => 'localhost',
        'port' => 11211
    ));
    test_update($oTest, $concurrency, $t, 'MEMCACHED ');

//    $oTest = bucketDB::factory(array(
//        'type' => 'sharedance'
//    ));
//    test_update($oTest, $concurrency, $t, 'SHAREDANCE');
}


$t->stop();

$t->display();

exit;

function test_update($oTest, $concurrency, $t, $text)
{
    $oTest->disconnect();
    $oTest->invalidateAll();
    $oTest->init();

    for ($c = 0; $c < $concurrency; $c++) {
        mt_srand(1000 + $c);
        $pid = pcntl_fork();
        if ($pid == 0) {
            $oTest->connect();
            for ($i = 0; $i < TEST_ITERATIONS; $i++) {
                $oTest->updateTest(mt_rand(1, TEST_RECORDS), mt_rand(1, TEST_RECORDS));
            }
            exit;
        }
    }

    $status = 0;
    while (pcntl_wait($status) > 0);

    $result = $oTest->updateResult();
    $fail = $concurrency * TEST_ITERATIONS - $result == 0 ? 'OK' : "ERR: {$result}";

    $oTest->invalidateAll();

    $t->setMarker("{$text} - C{$concurrency} - {$fail}");
}

?>

<?php

if (PHP_SAPI != 'cli') die('CLI only!');

//define('CACHE_DEBUG', true);
define('CACHE_EXIT_ON_ERROR', true);

error_reporting(E_ALL);

// number of iterations
define('TEST_ITERATIONS', 100);
// how many reads should be performed per each set/update
define('TEST_READS', 1);

require "Benchmark/Timer.php";

require 'testCases/Cache.php';

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
    $oTest = Cache::factory(array(
        'type' => 'memcached',
        'host' => '127.0.0.1',
        'port' => 11211
    ));
    test_update($oTest, $concurrency, $t, 'MEMCACHED ');

    $oTest = Cache::factory(array(
        'type' => 'sharedance',
        'host' => 'localhost'
    ));
    test_update($oTest, $concurrency, $t, 'SHAREDANCE');
}


$t->stop();

$t->display();

exit;

function test_update($oTest, $concurrency, $t, $text)
{
    $oTest->disconnect();
    $oTest->invalidateAll();
    $oTest->init($concurrency, TEST_ITERATIONS);

    for ($c = 0; $c < $concurrency; $c++) {
        mt_srand(1000 + $c);
        $pid = pcntl_fork();
        if ($pid == 0) {
            $oTest->connect();
            for ($i = 0; $i < TEST_ITERATIONS; $i++) {
                $oTest->updateTest($c, $i);
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

function debug(Exception $e)
{
    if (defined('CACHE_DEBUG')) {
        print_r($e);
    }
    throw $e;
    if (defined('CACHE_EXIT_ON_ERROR')) {
        exit(1);
    }
}

?>

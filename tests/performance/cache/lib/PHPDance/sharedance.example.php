<?php
require 'sharedance.class.php';
require 'timer.php';

$timer =& Timer::instance();

$timer->start('connect');
$cache = new Sharedance();
$cache->addServer( new SharedanceServer( '127.0.0.1', 8989 ) );
$cache->addServer( new SharedanceServer( '127.0.0.1', 8990 ) );
$cache->addServer( new SharedanceServer( '127.0.0.1', 8991 ) );
$timer->stop('connect');

$timer->start('run');
for($i=0; $i<10000; $i++) {
    if($i%500==0) {
        echo('.');
    }
    $key = md5( microtime() . mt_rand(1, 1000) );
    $cache->set( $key, 'Some text about the number ' . $i );
    $cache->get( $key );
}
$timer->stop('run');

echo("\n");
$timer->show();

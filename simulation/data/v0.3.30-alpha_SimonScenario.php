<?php

$oRequest = new stdClass();

$oRequest->what     = 'zone:1';
$oRequest->target   = '';
$oRequest->source   = '';
$oRequest->withText = false;
$oRequest->context  = 0;
$oRequest->richMedia = true;
$oRequest->ct0      = '';
$oRequest->loc      = 'http://www.simon.com';
$oRequest->referer  = '';

$aIterations[1]['request_objects'][1]   = $oRequest;
$aIterations[1]['shuffle_requests']     = false;
$aIterations[1]['max_requests']         = 20;

for($i=2;$i<25;$i++)
{
    $aIterations[$i] = $aIterations[1];
}

$iterations = count($aIterations);

$precis=    '<h1>Scenario Simulation: Simon</h1>'
            .'-- v0.3.30-alpha<br />'
            .'-- no impression history<br />'
            .'-- iterations: '.$iterations.'<br />'
            .print_r($oRequest, true);

$GLOBALS['_MAX']['CONF']['sim']['precis']       = $precis;
$GLOBALS['_MAX']['CONF']['sim']['iterations']   = $iterations;
$GLOBALS['_MAX']['CONF']['sim']['oRequest']     = $oRequest;
$GLOBALS['_MAX']['CONF']['sim']['aIterations']  = $aIterations;
?>
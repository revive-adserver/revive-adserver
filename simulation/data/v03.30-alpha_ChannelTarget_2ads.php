<?php

$oRequest = new stdClass();

$oRequest->what = 'zone:1';
$oRequest->target = '';
$oRequest->source = '';
$oRequest->withText = false;
$oRequest->context = 0;
$oRequest->richMedia = true;
$oRequest->ct0 = '';
$oRequest->loc = 'http://www.example.com';
$oRequest->referer = '';

$aIterations[1]['request_objects'][1] = $oRequest;
$aIterations[1]['shuffle_requests'] = false;
$aIterations[1]['max_requests'] =100;

for($i=2;$i<13;$i++)
{
    $aIterations[$i] = $aIterations[1];
}

$iterations = count($aIterations);

$precis =   '<h1>Scenario Simulation: ChannelTargetTwoAds_nohistory</h1>'
            .'-- v0.3.30-alpha<br />'
            .'-- zones=1<br />'
            .'-- banners=2<br />'
            .'-- required impressions=23000<br />'
            .'-- priority lvl=high(10)<br />'
            .'-- distribution=100(per day)<br />'
            .'-- priority starts at 0<br />'
            .'-- no impression history<br />'
            .'-- iterations: '.$iterations.'<br />'
            .print_r($oRequest, true);

$GLOBALS['_MAX']['CONF']['sim']['precis']       = $precis;
$GLOBALS['_MAX']['CONF']['sim']['iterations']   = $iterations;
$GLOBALS['_MAX']['CONF']['sim']['oRequest']     = $oRequest;
$GLOBALS['_MAX']['CONF']['sim']['aIterations']  = $aIterations;
//$GLOBALS['loc'] = 'www.example.com';

?>
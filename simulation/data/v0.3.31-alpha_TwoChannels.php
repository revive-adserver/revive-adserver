<?php

$oRequest = new stdClass();

$oRequest->what      = "zone:1";
$oRequest->target    = "";
$oRequest->source    = "";
$oRequest->withText  = "false";
$oRequest->context   = "";
$oRequest->richMedia = "true";
$oRequest->ct0       = "";
$oRequest->loc       = "www.example.com";
$oRequest->referer   = "http://www.refer.com";

$aIterations[1]['request_objects'][1]   = $oRequest;
$aIterations[1]['shuffle_requests']     = false;
$aIterations[1]['max_requests']         = "10";

$iterations = "2";

for($i=2;$i<($iterations+1);$i++)
{
    $aIterations[$i] = $aIterations[1];
}

$precis=    '<pre>'."Two Channel Limitations:
1=PageURL
2=PageReferer".'</pre>';

$precis.=    '-- from database: '."max03trunk".'<br />'
            .'-- max version: '."v0.3.31-alpha".'<br />'
            .'-- iterations: '.$iterations.'<br />'
            .'-- startdate: '."2000-01-01 00:00:00".'<br />'
            .print_r($oRequest, true);

$GLOBALS['_MAX']['CONF']['sim']['precis']       = $precis;
$GLOBALS['_MAX']['CONF']['sim']['iterations']   = $iterations;
$GLOBALS['_MAX']['CONF']['sim']['oRequest']     = $oRequest;
$GLOBALS['_MAX']['CONF']['sim']['aIterations']  = $aIterations;
$GLOBALS['_MAX']['CONF']['sim']['startdate']    = "2000-01-01 00:00:00";
$GLOBALS['_MAX']['CONF']['sim']['startday']     = "2000-01-01";
$GLOBALS['_MAX']['CONF']['sim']['starthour']    = "0";
$GLOBALS['loc'] = $oRequest->loc;
$GLOBALS['_MAX']['LIMITATION_DATA']['HTTP_REFERER'] = $oRequest->referer;
?>
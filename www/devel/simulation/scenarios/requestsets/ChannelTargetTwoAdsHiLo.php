<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

$oRequest = new stdClass();

$oRequest->what     = 'zone:1';
$oRequest->target   = '';
$oRequest->source   = '';
$oRequest->withText = false;
$oRequest->context  = 0;
$oRequest->richMedia = true;
$oRequest->ct0      = '';
$oRequest->loc      = '';
$oRequest->referer  = '';

// bannerid 1 is override with capping limitation
// bannerid 2 is low priority with no limitations

$aIterations[1]['request_objects'][1]   = $oRequest;
$aIterations[1]['shuffle_requests']     = false;
$aIterations[1]['max_requests']         = 4;

for($i=2;$i<13;$i++)
{
    $aIterations[$i] = $aIterations[1];
}

$iterations = count($aIterations);

$precis=    '<h1>Scenario Simulation: ChannelTargetTwoAdsHiLo_nohistory</h1>'
            .'-- v0.3.30-alpha<br />'
            .'-- Total banners: 2<br />'
            .'-- Total campaigns: 2<br />'
            .'-- Total advertisers: 1<br />'
            .'-- Active banners: 2<br />'
            .'-- Active campaigns: 2<br />'
            .'-- banner 1: priority lvl=override / capping=10<br />'
            .'-- banner 2: priority lvl=low / no limitations<br />'
            .'-- priority starts at 0<br />'
            .'-- no impression history<br />'
            .'-- iterations: '.$iterations.'<br />'
            .print_r($oRequest, true);

$GLOBALS['_MAX']['CONF']['sim']['precis']       = $precis;
$GLOBALS['_MAX']['CONF']['sim']['iterations']   = $iterations;
$GLOBALS['_MAX']['CONF']['sim']['oRequest']     = $oRequest;
$GLOBALS['_MAX']['CONF']['sim']['aIterations']  = $aIterations;

?>
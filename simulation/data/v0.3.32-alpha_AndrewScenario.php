<?php

$aIterations[1]['request_objects'][1]   = new SimulationRequest(
                                            "zone:1",
                                            "",
                                            "",
                                            "",
                                            "",
                                            "",
                                            "false",
                                            "",
                                            "true");
$aIterations[1]['shuffle_requests']     = false;
$aIterations[1]['max_requests']         = "100";

$iterations = "24";

for($i=2;$i<($iterations+1);$i++)
{
    $aIterations[$i] = $aIterations[1];
}

$precis=    '<pre>'."Andrew scenario

Zones (2400 impressions):
1.	100 hourly impressions (2400 total)

Campaigns:
1.	ROS no targeting	1440 impressions target
2.	Targeted to even hours	720 impression target
3.	Low priority
".'</pre>';

$precis.=    '-- from database: '."max_adsel".'<br />'
            .'-- max version: '."v0.3.32-alpha".'<br />'
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

?>
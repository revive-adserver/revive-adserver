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
$aIterations[1]['max_requests']         = "50";

$iterations = "24";

for($i=2;$i<($iterations+1);$i++)
{
    $aIterations[$i] = $aIterations[1];
}

$precis=    '<pre>'."Chris basic scenario

Zones (1200 impressions):
1.	50 hourly impressions (1200 total)
2.	Not directly called, chained to zone 1

Campaigns:
1.	Exclusive targeted between 9am-6pm	linked to zone 1
2.	ROS no targeting 600 impressions target	linked to zone 1
3.	Low priority	linked to zone 2
".'</pre>';

$precis.=    '-- from database: '."max_adsel".'<br />'
            .'-- openads version: '."v2.3.1-alpha".'<br />'
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
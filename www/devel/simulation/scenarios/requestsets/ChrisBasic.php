<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

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
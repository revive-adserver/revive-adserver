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

$aIterations[1]['request_objects'][1]   = new SimulationRequest('zone:1','','',"http://www.refer.com","http://www.example.com");
$aIterations[1]['shuffle_requests']     = false;
$aIterations[1]['max_requests']         = "10";

$aIterations[2]['request_objects'][1]   = new SimulationRequest('zone:1','','',"http://www.refer.com","");
$aIterations[2]['shuffle_requests']     = false;
$aIterations[2]['max_requests']         = "10";

$aIterations[3]['request_objects'][1]   = new SimulationRequest('zone:1','','',"http://www.refer.com","http://www.example.com");
$aIterations[3]['shuffle_requests']     = false;
$aIterations[3]['max_requests']         = "10";

$aIterations[4]['request_objects'][1]   = new SimulationRequest('zone:1','','',"http://www.refer.com","http://www.example.com");
$aIterations[4]['shuffle_requests']     = false;
$aIterations[4]['max_requests']         = "10";

$aIterations[5]['request_objects'][1]   = new SimulationRequest('zone:1','','',"http://www.refer.com","http://www.example.com");
$aIterations[5]['shuffle_requests']     = false;
$aIterations[5]['max_requests']         = "10";

$iterations = "5";

$precis=    '<pre>'."Two Channel Limitations:
1=PageURL
2=PageReferer".'</pre>';

$precis.=    '-- from database: '."max03trunk".'<br />'
            .'-- openads version: '."v2.3.1-alpha".'<br />'
            .'-- iterations: '.$iterations.'<br />'
            .'-- startdate: '."2007-01-09 13:00:00".'<br />'
            .print_r($oRequest, true);

$GLOBALS['_MAX']['CONF']['sim']['precis']       = $precis;
$GLOBALS['_MAX']['CONF']['sim']['iterations']   = $iterations;
$GLOBALS['_MAX']['CONF']['sim']['oRequest']     = $oRequest;
$GLOBALS['_MAX']['CONF']['sim']['aIterations']  = $aIterations;
$GLOBALS['_MAX']['CONF']['sim']['startdate']    = "2007-01-09 13:00:00";
$GLOBALS['_MAX']['CONF']['sim']['startday']     = "2007-01-09";
$GLOBALS['_MAX']['CONF']['sim']['starthour']    = "13";
?>
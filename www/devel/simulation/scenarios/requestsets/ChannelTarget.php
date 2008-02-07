<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

$oRequest = new stdClass();

$oRequest->what = 'zone:1';
$oRequest->target = '';
$oRequest->source = '';
$oRequest->withText = false;
$oRequest->context = 0;
$oRequest->richMedia = true;
$oRequest->ct0 = '';
$oRequest->referer = '';

// bannerid 2 has pageUrl limitation
// hence the parameter 'source' url
// change source for first iteration
// not entirely sure this gets used effectively
// MAX_checkSite_Pageurl uses $GLOBALS['loc'] instead of source
// therefore I had to bodge the scenario class to set the $GLOBAL

// the whole of the first iteration will fail delivery
// owing to the pageUrl limitation
$oRequest->loc = 'http://www.nowhere.com';

$aIterations[1]['request_objects'][1] = $oRequest;
$aIterations[1]['shuffle_requests'] = false;
$aIterations[1]['max_requests'] =10;

// the last 2 iterations will deliver
// because the source is a valid pageUrl
$oRequest->loc = 'http://www.example.com';

$aIterations[2]['request_objects'][1] = $oRequest;
$aIterations[2]['shuffle_requests'] = false;
$aIterations[2]['max_requests'] =20;

$aIterations[3]['request_objects'][1] = $oRequest;
$aIterations[3]['shuffle_requests'] = false;
$aIterations[3]['max_requests'] =10;

$iterations = count($aIterations);

$precis=    '<h1>Scenario Simulation: ChannelTarget_nohistory</h1>'
            .'-- v0.3.30-alpha<br />'
            .'-- zones=1<br />'
            .'-- banners=1<br />'
            .'-- required impressions=23000<br />'
            .'-- priority lvl=exclusive<br />'
            .'-- distribution=100(per day)<br />'
            .'-- priority starts at 0<br />'
            .'-- no impression history<br />'
            .'-- variable request sets<br />'
            .'-- first iteration will fail owing to pageurl limitation<br />'
            .'-- 30 successful deliveries expected<br />'
            .'-- iterations: '.$iterations.'<br />'
            .print_r($oRequest, true);

$GLOBALS['_MAX']['CONF']['sim']['precis']       = $precis;
$GLOBALS['_MAX']['CONF']['sim']['iterations']   = $iterations;
$GLOBALS['_MAX']['CONF']['sim']['oRequest']     = $oRequest;
$GLOBALS['_MAX']['CONF']['sim']['aIterations']  = $aIterations;

?>
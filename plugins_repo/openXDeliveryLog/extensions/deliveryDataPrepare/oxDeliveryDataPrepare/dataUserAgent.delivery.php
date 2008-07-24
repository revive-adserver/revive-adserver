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

// if ($aConf['logging']['sniff'] && isset($GLOBALS['_MAX']['CLIENT']))
// @todo should the call to browser sniffer library be moved in here?

function Plugins_deliveryDataPrepare_oxDeliveryDataPrepare_dataUserAgent()
{
    $userAgentInfo = array(
        'os'        => $GLOBALS['_MAX']['CLIENT']['os'],
        'long_name' => $GLOBALS['_MAX']['CLIENT']['long_name'],
        'browser'   => $GLOBALS['_MAX']['CLIENT']['browser'],
    );
    $GLOBALS['_MAX']['deliveryData']['userAgentInfo'] = $userAgentInfo;
}

function Plugins_deliveryDataPrepare_dataUserAgent_logRequest()
{
    Plugins_deliveryDataPrepare_dataUserAgent();
}

function Plugins_deliveryDataPrepare_dataUserAgent_logImpression()
{
    Plugins_deliveryDataPrepare_dataUserAgent();
}

function Plugins_deliveryDataPrepare_dataUserAgent_logClick()
{
    Plugins_deliveryDataPrepare_dataUserAgent();
}

?>
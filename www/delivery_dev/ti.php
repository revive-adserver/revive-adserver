<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

// Require the initialisation file
require_once '../../init-delivery.php';

// Required files
require_once(MAX_PATH . '/lib/max/Delivery/cache.php');
require_once(MAX_PATH . '/lib/max/Delivery/javascript.php');
require_once MAX_PATH . '/lib/max/Delivery/tracker.php';

###START_STRIP_DELIVERY
OA::debug('starting delivery script '.__FILE__);
###END_STRIP_DELIVERY

// No Caching
MAX_commonSetNoCacheHeaders();

//Register any script specific input variables
MAX_commonRegisterGlobalsArray(array('trackerid'));
if (empty($trackerid)) $trackerid = 0;

// Log the tracker impression
if ($conf['logging']['trackerImpressions']) {
    $aConversion = MAX_trackerCheckForValidAction($trackerid);
    if (!empty($aConversion)) {
        $aConversionInfo = MAX_Delivery_log_logConversion($trackerid, $aConversion);
        if (isset($aConversionInfo['deliveryLog:oxLogConversion:logConversion']['server_conv_id'])) {
            // Store tracker impression variable values
            MAX_Delivery_log_logVariableValues(
                MAX_cacheGetTrackerVariables($trackerid),
                $trackerid,
                $aConversionInfo['deliveryLog:oxLogConversion:logConversion']['server_conv_id'],
                $aConversionInfo['deliveryLog:oxLogConversion:logConversion']['server_raw_ip']
            );
        }
    }
}
MAX_cookieFlush();
// Send a 1 x 1 gif
MAX_commonDisplay1x1();

?>
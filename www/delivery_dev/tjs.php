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
MAX_commonRegisterGlobalsArray(array('trackerid', 'inherit', 'append'));
if (empty($trackerid)) $trackerid = 0;

$conversionsid = NULL;
$variablesScript = '';

MAX_commonSendContentTypeHeader("application/x-javascript", $charset);

// Log the tracker impression
$logVars = false;
$aConversion = $aConversionInfo = array();

if (($conf['logging']['trackerImpressions'])) {
    // Only log and gather variable data if this conversion connects back
    $aConversion = MAX_trackerCheckForValidAction($trackerid);
    if (!empty($aConversion)) {
        $aConversionInfo = MAX_Delivery_log_logConversion($trackerid, $aConversion);
        // Generate code required to send variable values to the {$conf['file']['conversionvars']} script
        if (isset($inherit)) {
            $variablesScript = MAX_trackerbuildJSVariablesScript($trackerid, $aConversionInfo['deliveryLog:oxLogConversion:logConversion'], $inherit);
        } else {
            $variablesScript = MAX_trackerbuildJSVariablesScript($trackerid, $aConversionInfo['deliveryLog:oxLogConversion:logConversion']);
        }
        $logVars = true;
    }
}

MAX_cookieFlush();

// Write the code for tracking the variable values, and any
// additional appended tracker code
if ($logVars) {
    // The $logVars variable contains the code for tracking
    // the variable values (if required by the tracker), and
    // also the code for appending any additional tracker code
    // IF there was a conversion
    echo "$variablesScript";
} else if ($append == true) {
    // As $logVars was empty, this could mean that there are
    // no variable values to track and there is no additional
    // appended code required; but it could also mean that
    // although there is additional appended code required, there
    // was no conversion recorded. As the $append variable
    // is true, double check to see if there is any additional
    // appended tracker code, and if so, send it
    $aTracker = MAX_cacheGetTracker($trackerid);
    if (!empty($aTracker['appendcode'])) {
        $appendScript = MAX_javascriptToHTML($aTracker['appendcode'], "MAX_{$trackerid}_appendcode", true);
        echo $appendScript;
    }
}

// Post tracker render hook
OX_Delivery_Common_hook('postTrackerRender', array(&$aConversion, &$aConversionInfo, &$trackerid, &$inherit));

?>
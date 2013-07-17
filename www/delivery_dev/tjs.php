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

// Require the initialisation file
require_once '../../init-delivery.php';

// Required files
require_once(MAX_PATH . '/lib/max/Delivery/cache.php');
require_once(MAX_PATH . '/lib/max/Delivery/javascript.php');
require_once MAX_PATH . '/lib/max/Delivery/tracker.php';

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
            $variablesScript = MAX_trackerbuildJSVariablesScript($trackerid, $aConversionInfo, $inherit);
        } else {
            $variablesScript = MAX_trackerbuildJSVariablesScript($trackerid, $aConversionInfo);
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
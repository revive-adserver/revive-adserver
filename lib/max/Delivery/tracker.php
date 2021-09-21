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

/**
 * @package    OpenXDelivery
 * @subpackage Trackers
 */

/**
 * This function builds the JavaScript to track variables for a tracker-impression via JavaScript
 *
 * @todo Ask Matteo what the $trackerJsCode is for
 *
 * @param int $trackerid                The ID of the tracker
 * @param array $conversionInfo         An of array of arrays of the return values from the logConversion plugins
 * @param unknown_type $trackerJsCode   Unknown
 *
 * @return string   The JavaScript to pick up the variables from the page, and pass them in to the
 *                  conversionvars script
 */
function MAX_trackerbuildJSVariablesScript($trackerid, $conversionInfo, $trackerJsCode = null)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $buffer = '';
    $url = MAX_commonGetDeliveryUrl($conf['file']['conversionvars']);
    $tracker = MAX_cacheGetTracker($trackerid);
    $variables = MAX_cacheGetTrackerVariables($trackerid);
    $variableQuerystring = '';
    if (empty($trackerJsCode)) {
        $trackerJsCode = md5(uniqid('', true));
    } else {
        // Appended tracker - set method to default
        $tracker['variablemethod'] = 'default';
    }
    if (!empty($variables)) {
        if ($tracker['variablemethod'] == 'dom') {
            $buffer .= "
    function MAX_extractTextDom(o)
    {
        var txt = '';

        if (o.nodeType == 3) {
            txt = o.data;
        } else {
            for (var i = 0; i < o.childNodes.length; i++) {
                txt += MAX_extractTextDom(o.childNodes[i]);
            }
        }

        return txt;
    }

    function MAX_TrackVarDom(id, v)
    {
        if (max_trv[id][v]) { return; }
        var o = document.getElementById(v);
        if (o) {
            max_trv[id][v] = escape(o.tagName == 'INPUT' ? o.value : MAX_extractTextDom(o));
        }
    }";
            $funcName = 'MAX_TrackVarDom';
        } elseif ($tracker['variablemethod'] == 'default') {
            $buffer .= "
    function MAX_TrackVarDefault(id, v)
    {
        if (max_trv[id][v]) { return; }
        if (typeof(window[v]) == undefined) { return; }
        max_trv[id][v] = window[v];
    }";
            $funcName = 'MAX_TrackVarDefault';
        } else {
            $buffer .= "
    function MAX_TrackVarJs(id, v, c)
    {
        if (max_trv[id][v]) { return; }
        if (typeof(window[v]) == undefined) { return; }
        if (typeof(c) != 'undefined') {
            eval(c);
        }
        max_trv[id][v] = window[v];
    }";
            $funcName = 'MAX_TrackVarJs';
        }

        $buffer .= "
    if (!max_trv) { var max_trv = new Array(); }
    if (!max_trv['{$trackerJsCode}']) { max_trv['{$trackerJsCode}'] = new Array(); }";

        foreach ($variables as $key => $variable) {
            $variableQuerystring .= "&{$variable['name']}=\"+max_trv['{$trackerJsCode}']['{$variable['name']}']+\"";
            if ($tracker['variablemethod'] == 'custom') {
                $buffer .= "
    {$funcName}('{$trackerJsCode}', '{$variable['name']}', '" . addcslashes($variable['variablecode'], "'") . "');";
            } else {
                $buffer .= "
    {$funcName}('{$trackerJsCode}', '{$variable['name']}');";
            }
        }
        if (!empty($variableQuerystring)) {
            // Pass the return values from the logConversion hook call into the variables request
            foreach ($conversionInfo as $plugin => $pluginData) {
                $conversionInfoParams = [];
                if (is_array($pluginData)) {
                    foreach ($pluginData as $key => $value) {
                        $conversionInfoParams[] = $key . '=' . urlencode($value);
                    }
                }
                $conversionInfoParams = '&' . implode('&', $conversionInfoParams);
                $buffer .= "
    document.write (\"<\" + \"script language='JavaScript' type='text/javascript' src='\");
    document.write (\"$url?trackerid=$trackerid&plugin={$plugin}{$conversionInfoParams}{$variableQuerystring}'\");";
                $buffer .= "\n\tdocument.write (\"><\\/scr\"+\"ipt>\");";
            }
        }
    }
    if (!empty($tracker['appendcode'])) {
        // Add the correct "inherit" parameter if an OpenX trackercode was found
        $tracker['appendcode'] = preg_replace('/("\?trackerid=\d+&amp;inherit)=1/', '$1=' . $trackerJsCode, $tracker['appendcode']);

        $jscode = MAX_javascriptToHTML($tracker['appendcode'], "MAX_{$trackerid}_appendcode");

        // Replace template style variables
        $jscode = preg_replace("/\{m3_trackervariable:(.+?)\}/", "\"+max_trv['{$trackerJsCode}']['$1']+\"", $jscode);

        $buffer .= "\n" . preg_replace('/^/m', "\t", $jscode) . "\n";
    }
    if (empty($buffer)) {
        $buffer = "document.write(\"\");";
    }
    return $buffer;
}

/**
 * This function checks if the specified tracker connects back to a valid action
 *
 * @param integer $trackerid The ID of the tracker to look up in the database
 * @return mixed If action occurred: array indexed on [#s since action] => array('type' => <connection type>, 'id' => <creative ID>
 *               else false
 */
function MAX_trackerCheckForValidAction($trackerid)
{
    // Get all creatives that are linked to this tracker
    $aTrackerLinkedAds = MAX_cacheGetTrackerLinkedCreatives($trackerid);

    // This tracker is not linked to any creatives
    if (empty($aTrackerLinkedAds)) {
        return false;
    }

    // Note: Constants are not included n the delivery engine, the values below map to the values defined in constants.php
    $aPossibleActions = _getActionTypes();

    $now = MAX_commonGetTimeNow();
    $aConf = $GLOBALS['_MAX']['CONF'];
    $aMatchingActions = [];

    // Iterate over all creatives linked to this tracker...
    foreach ($aTrackerLinkedAds as $creativeId => $aLinkedInfo) {
        // Iterate over all possible actions (currently only "view" and "click")
        foreach ($aPossibleActions as $actionId => $action) {
            // If there is both a connection window set, and this creative has been actioned
            if (!empty($aLinkedInfo[$action . '_window']) && !empty($_COOKIE[$aConf['var']['last' . ucfirst($action)]][$creativeId])) {
                // Check for any custom data which a plugin may have stored in the cookie
                if (stristr($_COOKIE[$aConf['var']['last' . ucfirst($action)]][$creativeId], ' ')) {
                    list($value, $extra) = explode(' ', $_COOKIE[$aConf['var']['last' . ucfirst($action)]][$creativeId], 2);
                    $_COOKIE[$aConf['var']['last' . ucfirst($action)]][$creativeId] = $value;
                } else {
                    $extra = '';
                }
                list($lastAction, $zoneId) = explode('-', $_COOKIE[$aConf['var']['last' . ucfirst($action)]][$creativeId]);
                // Decode the base32 timestamp
                $lastAction = MAX_commonUnCompressInt($lastAction);

                // Calculate how long ago this action occurred
                $lastSeenSecondsAgo = $now - $lastAction;
                // If the action occurred within the window (and sanity check that it's > 0), record this as a matching action
                if ($lastSeenSecondsAgo <= $aLinkedInfo[$action . '_window'] && $lastSeenSecondsAgo > 0) {
                    // Index the matching array against the # seconds ago that the action occurred
                    $aMatchingActions[$lastSeenSecondsAgo] = [
                        'action_type' => $actionId,
                        'tracker_type' => $aLinkedInfo['tracker_type'],
                        'status' => $aLinkedInfo['status'],
                        'cid' => $creativeId,
                        'zid' => $zoneId,
                        'dt' => $lastAction,
                        'window' => $aLinkedInfo[$action . '_window'],
                        'extra' => $extra,
                    ];
                }
            }
        }
    }

    // If no actions matched, return false
    if (empty($aMatchingActions)) {
        return false;
    }

    // Sort by ascending #seconds since action
    ksort($aMatchingActions);
    // Return the first matching action
    return array_shift($aMatchingActions);
}

function _getActionTypes()
{
    return [0 => 'view', 1 => 'click'];
}

function _getTrackerTypes()
{
    return [1 => 'sale', 2 => 'lead', 3 => 'signup'];
}

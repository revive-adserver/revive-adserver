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

/**
 * @package OpenXDelivery
 * @subpackage Trackers
 * @author chris@m3.net
 *
 */


/**
 * This function builds the JavaScript to track variables for a tracker-impression via JavaScript
 *
 * @todo Ask Matteo what the $trackerJsCode is for
 *
 * @param int $trackerid                The ID of the tracker
 * @param array $conversionInfo         An array of the information from the tracker impression
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

        foreach($variables as $key => $variable) {
            $variableQuerystring .= "&{$variable['name']}=\"+max_trv['{$trackerJsCode}']['{$variable['name']}']+\"";
            if ($tracker['variablemethod'] == 'custom') {
                $buffer .= "
    {$funcName}('{$trackerJsCode}', '{$variable['name']}', '".addcslashes($variable['variablecode'], "'")."');";
            } else {
                $buffer .= "
    {$funcName}('{$trackerJsCode}', '{$variable['name']}');";
            }
        }
        if (!empty($variableQuerystring)) {
            $buffer .= "
    document.write (\"<\" + \"script language='JavaScript' type='text/javascript' src='\");
    document.write (\"$url?trackerid=$trackerid&server_raw_tracker_impression_id={$conversionInfo['server_raw_tracker_impression_id']}&server_raw_ip={$conversionInfo['server_raw_ip']}{$variableQuerystring}'\");";
            $buffer .= "\n\tdocument.write (\"><\\/scr\"+\"ipt>\");";
        }
    }
    if(!empty($tracker['appendcode'])) {
        // Add the correct "inherit" parameter if a OpenX trackercode was found
        $tracker['appendcode'] = preg_replace('/("\?trackerid=\d+&amp;inherit)=1/', '$1='.$trackerJsCode, $tracker['appendcode']);

        $jscode = MAX_javascriptToHTML($tracker['appendcode'], "MAX_{$trackerid}_appendcode");

        // Replace template style variables
        $jscode = preg_replace("/\{m3_trackervariable:(.+?)\}/", "\"+max_trv['{$trackerJsCode}']['$1']+\"", $jscode);

        $buffer .= "\n".preg_replace('/^/m', "\t", $jscode)."\n";
    }
    if (empty($buffer)) {
        $buffer = "document.write(\"\");";
    }
    return $buffer;
}

?>

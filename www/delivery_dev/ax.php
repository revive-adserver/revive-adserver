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
require_once MAX_PATH . '/lib/max/Delivery/adSelect.php';
require_once MAX_PATH . '/lib/max/Delivery/flash.php';

// No Caching
MAX_commonSetNoCacheHeaders();

//Register any script specific input variables
MAX_commonRegisterGlobalsArray(array());

// Get the banner
$banner = MAX_adSelect($what, $campaignid, $target, $source, $withtext, $charset, $context, true, $ct0, $loc, $referer);

// Do something special with cookies? 

MAX_cookieFlush();

MAX_commonSendContentTypeHeader('application/xml', $charset);

$aResponse = array(
    'html'    => $banner['html'],
    'context' => $banner['context'],
);
foreach ($banner['aRow']['aSearch'] as $index => $value) {
    $key = substr($value, 1, strlen($value) -2);
    $aResponse[$key] = $banner['aRow']['aReplace'][$index];
}
// Remove duplicated fields from the aRow
unset($banner['aRow']['aSearch'], $banner['aRow']['aReplace'], $banner['aRow']['bannerContent']);

// Add fields from aRow to the response (assuming they don't exist already)
foreach ($banner['aRow'] as $key => $value) {
    if (!in_array($key, array_keys($aResponse))) {
        $aResponse[$key] = $value;
    }
}
$aResponse['creativeUrl'] = _adRenderBuildFileUrl($banner['aRow']);
$outputXml = "<?xml version='1.0' encoding='{$charset}' ?".">\n<ad version='1.0'>\n";
buildXmlTree($aResponse, $outputXml);
$outputXml .= "</ad>";

echo $outputXml;

/**
 * Encodes a string for display in the XML document
 *
 * @param string $string String to be encoded
 * @return string Encoded string
 */
function xmlencode($string) {
    // Switch some weird characters (left and right quotes) which don't seem to encode correctly (bloody M$)
    $search = array('&#x91;', '&#x92;', '&#x93;', '&#x94;', '&#x20;', '&#x00;');
    $replace = array('&#x27;', '&#x27;', '&#x22;', '&#x22;', ' ', '_');
    return str_replace($search, $replace, preg_replace('#%([A-F0-9]{2})#', '&#x${1};', rawurlencode($string)));
}

function buildXmlTree($var, &$xml) {
    if (is_array($var)) {
        foreach ($var as $key => $value) {
            $xml .= "<{$key}>";
            $inner = buildXmlTree($value, $xml);
            $xml .= $inner . "</{$key}>\n";
        }
    } else {
        return xmlencode($var);
    }
}
?>

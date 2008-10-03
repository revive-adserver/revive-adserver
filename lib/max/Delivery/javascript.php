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
 * @subpackage Javascript
 * @author chris@m3.net
 *
 */

/**
 * This function takes some HTML, and generates JavaScript document.write() code
 * to output that HTML via JavaScript
 *
 * @param string  $string   The string to be converted
 * @param string  $varName  The JS variable name to store the output in
 * @param boolean $output   Should there be a document.write to output the code?
 *
 * @return string   The JS-ified string
 */
function MAX_javascriptToHTML($string, $varName, $output = true, $localScope = true)
{
    $jsLines = array();
    $search[] = "\\"; $replace[] = "\\\\";
    $search[] = "\r"; $replace[] = '';
    $search[] = '"'; $replace[] = '\"';
    $search[] = "'";  $replace[] = "\\'";
    $search[] = '<';  $replace[] = '<"+"';
    $lines = explode("\n", $string);
    foreach ($lines AS $line) {
        if(trim($line) != '') {
            $jsLines[] = $varName . ' += "' . trim(str_replace($search, $replace, $line)) . '\n";';
        }
    }

    $buffer = (($localScope) ? 'var ' : '') . $varName ." = '';\n";
    $buffer .= implode("\n", $jsLines);
    if ($output == true) {
        $buffer .= "\ndocument.write({$varName});\n";
    }
    return $buffer;
}

/**
 * This function encodes a string to be quoted and safe for inclusion in a JSON output
 *
 * @param string $string
 * @return string
 */
function MAX_javascriptEncodeJsonField($string)
{
    $string = addcslashes($string, "\\/\"\n\r\t");
    $string = str_replace("\x0C", "\\f", $string);
    $string = str_replace("\x0B", "\\b", $string);
    return '"'.$string.'"';
}

?>

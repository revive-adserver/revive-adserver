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
 * @package OpenXDelivery
 * @subpackage Javascript
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
    $string = str_replace($search, $replace, $string);
    $lines = explode("\n", $string);
    foreach ($lines AS $line) {
        if(trim($line) != '') {
            $jsLines[] = $varName . ' += "' . trim($line) . '\n";';
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
    $string = str_replace("\x08", "\\b", $string);
    $string = str_replace("\x0C", "\\f", $string);
    return '"'.$string.'"';
}

?>

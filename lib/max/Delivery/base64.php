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
 * @package    MaxDelivery
 * @subpackage base64
 */

/**
 * A function to encode a string using a URL-safe alphabet
 *
 * @param string $string The string to be encoded.
 *
 * @return string The URL-safe encoded string
 */
function MAX_base64EncodeUrlSafe($string)
{
    // Encodes a string using the RFC3548 "Filename Safe Alphabet"
    $search = ['+', '/', '='];
    $replace = ['-', '~', ''];

    $string = base64_encode($string);
    return str_replace($search, $replace, $string);
}

/**
 * A function to encode a string using a URL-safe alphabet
 *
 * @param string $string The encoded string to be decoded.
 *
 * @return string The decoded string
 */
function MAX_base64DecodeUrlSafe($string)
{
    // Decodes a string using the RFC3548 "Filename Safe Alphabet"
    $search = ['-', '~'];
    $replace = ['+', '/'];

    $string = str_replace($search, $replace, $string);
    return base64_decode($string);
}

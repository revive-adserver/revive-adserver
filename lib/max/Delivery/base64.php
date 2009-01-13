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

/**
 * @package    MaxDelivery
 * @subpackage base64
 * @author     Chris Nutting <chris@m3.net>
 */

/**
 * A function to encode a string using a URL-safe alphabet
 *
 * @param string $string The string to be encoded.
 * 
 * @return string The URL-safe encoded string
 */
function MAX_base64EncodeUrlSafe($string) {
    // Encodes a string using the RFC3548 "Filename Safe Alphabet"
    $search  = array('+', '/', '=');
    $replace = array('-', '~', '');
    
    $string  = base64_encode($string);
    return str_replace($search, $replace, $string);
}

/**
 * A function to encode a string using a URL-safe alphabet
 *
 * @param string $string The encoded string to be decoded.
 * 
 * @return string The decoded string
 */
function MAX_base64DecodeUrlSafe($string) {
    // Decodes a string using the RFC3548 "Filename Safe Alphabet"    
    $search  = array('-', '~');
    $replace = array('+', '/');
    
    $string = str_replace($search, $replace, $string);
    return base64_decode($string);
}

?>

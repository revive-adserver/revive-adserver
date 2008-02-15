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
 * @package    MaxDelivery
 * @subpackage flash
 * @author     Chris Nutting <chris@m3.net>
 */

/**
 * This function outputs the code to include the FlashObject code as an external
 * JavaScript file
 *
 */
function MAX_flashGetFlashObjectExternal()
{
    $conf = $GLOBALS['_MAX']['CONF'];
    if (substr($conf['file']['flash'], 0, 4) == 'http') {
        $url = $conf['file']['flash'];
    } else {
        $url = MAX_commonGetDeliveryUrl($conf['file']['flash']);
    }
    return "<script type='text/javascript' src='{$url}'></script>";
}

/**
 * This function outputs the code to include the FlashObject code as inline JavaScript
 *
 */
function MAX_flashGetFlashObjectInline()
{
    $conf = $GLOBALS['_MAX']['CONF'];
    
    // If a full URL is specified for the flashObject code
    if (substr($conf['file']['flash'], 0, 4) == 'http') {
        // Try to find the local copy (faster)
        if (file_exists(MAX_PATH . '/www/delivery/' . basename($conf['file']['flash']))) {
            return file_get_contents(MAX_PATH . '/www/delivery/' . basename($conf['file']['flash']));
        } else {
            // Last ditch - Try to read the file from the full URL
            return @file_get_contents($conf['file']['flash']);
        }
    } elseif (file_exists(MAX_PATH . '/www/delivery/' . $conf['file']['flash'])) {
        return file_get_contents(MAX_PATH . '/www/delivery/' . $conf['file']['flash']);
    }
}

?>

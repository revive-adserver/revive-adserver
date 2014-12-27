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
 * @subpackage flash
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

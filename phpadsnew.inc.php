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

// Globalize context
// (just in case phpadsnew.inc.php is called from a function)
global $phpAds_context;

if (!defined('PHPADSNEW_INCLUDED')) {
    // Figure out our location
    if (strlen(__FILE__) > strlen(basename(__FILE__))) {
        define('MAX_PATH', substr(__FILE__, 0, strlen(__FILE__) - strlen(basename(__FILE__)) - 1));
    } else {
        define('MAX_PATH', '.');
    }

    // Require the initialisation file
    require MAX_PATH . '/init-delivery.php';

    // Required files
    require MAX_PATH . '/lib/max/Delivery/adSelect.php';


    function view_raw($what, $clientid = 0, $target = '', $source = '', $withtext = 0, $context = 0, $richmedia = true)
    {
        return MAX_adSelect($what, $clientid, $target, $source, $withtext, '', $context, $richmedia, '', '', '');
    }

    function view($what, $clientid = 0, $target = '', $source = '', $withtext = 0, $context = 0, $richmedia = true)
    {
        $output = view_raw($what, $clientid, "$target", "$source", $withtext, $context, $richmedia);

        if (is_array($output)) {
            echo $output['html'];
            return $output['bannerid'];
        }

        return false;
    }

    // Prevent duplicate includes
    define('PHPADSNEW_INCLUDED', true);
}

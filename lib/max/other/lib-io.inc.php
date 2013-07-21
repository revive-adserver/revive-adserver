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

if(!isset($GLOBALS['_MAX']['FILES']['/lib/max/Delivery/common.php'])) {
    // Required by PHP5.1.2
    require_once MAX_PATH . '/lib/max/Delivery/common.php';
}

/**
 * Register an array of variable names in the global scope
 *
 * Note: This is now a wrapper to the delivery engine's equivalent function
 *
 */
function phpAds_registerGlobal()
{
    $args = func_get_args();
    MAX_commonRegisterGlobalsArray($args);
}

/**
 * This function takes an array of variable names
 * and makes them available in the global scope
 *
 * $_POST values take precedence over $_GET values
 *
 */
function phpAds_registerGlobalUnslashed()
{
    $args = func_get_args();
    $request = array();
    while (list(,$key) = each($args)) {
        if (isset($_GET[$key])) {
            $value = $_GET[$key];
        }
        if (isset($_POST[$key])) {
            $value = $_POST[$key];
        }
        if (isset($value)) {
            if (ini_get('magic_quotes_gpc')) {
                $value = MAX_commonUnslashArray($value);
            }
        }
        else {
            $value = null;
        }
        $GLOBALS[$key] = $request[$key] = $value;
        unset($value);
    }
    return $request;
}

?>

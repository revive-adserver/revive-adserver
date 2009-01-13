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

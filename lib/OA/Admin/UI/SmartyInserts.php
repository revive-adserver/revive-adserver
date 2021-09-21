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
 * A script which defines the global {insert} function for Smarty
 */

/**
 * Include the custom header script
 *
 * @return string
 */
function insert_OA_Admin_UI_CustomHeader()
{
    $aConf = $GLOBALS['_MAX']['CONF'];

    if (!empty($aConf['ui']['headerFilePath'])) {
        ob_start();
        include($aConf['ui']['headerFilePath']);
        return ob_get_clean();
    }

    return '';
}

/**
 * Include the custom footer script
 *
 * @return string
 */
function insert_OA_Admin_UI_CustomFooter()
{
    $aConf = $GLOBALS['_MAX']['CONF'];

    
    if (!empty($aConf['ui']['footerFilePath'])) {
        ob_start();
        include($aConf['ui']['footerFilePath']);
        
        return ob_get_clean();
    }

    return '';
}

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

require_once MAX_PATH . '/lib/OA/Central.php';
require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';

/**
 * The base class to implement a dashboard widget
 *
 */
class OA_Dashboard_Widget extends OA_Central
{
    /**
     * The user permissions mask, defaults to admin + agencies + publishers
     *
     * @var int
     */
    var $accessList;

    var $widgetName;

    /**
     * The class constructor
     *
     * @param array $aParams The parameters array, usually $_REQUEST
     * @return OA_Dashboard_Widget
     */
    function OA_Dashboard_Widget($aParams)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        // Use gzip content compression
        if (isset($aConf['ui']['gzipCompression']) && $aConf['ui']['gzipCompression']) {
            //enable compression if it's not alredy handled by the zlib and ob_gzhandler is loaded
            $zlibCompression = ini_get('zlib.output_compression');
            if (!$zlibCompression && function_exists('ob_gzhandler')) {
                ob_start("ob_gzhandler");
            }
        }

        $this->widgetName = isset($aParams['widget']) ? stripslashes($aParams['widget']) : '';
        $this->checkAccess();
    }

    /**
     * A method to check for permissions to display the widget
     *
     */
    function checkAccess()
    {
        if (empty($this->accessList)) {
            $this->accessList = array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER);
        }

        OA_Permission::enforceAccount($this->accessList);
    }

    /**
     * A method to launch and display the widget
     *
     * @param array $aParams The parameters array, usually $_REQUEST
     */
    function display()
    {
    }
}

?>
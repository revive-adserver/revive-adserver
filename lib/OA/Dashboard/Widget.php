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

    var $accountId;
    var $m2mPassword;

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

    /**
     * A method to build a dashboard URL using the provided M2M ticket
     *
     * @param string $m2mTicket
     * @param string $url If empty, use the default dashboard Url from conf file
     * @return string
     */
    function buildDashboardUrl($m2mTicket, $url = null)
    {
        if (empty($url)) {
            $url = $this->buildUrl($GLOBALS['_MAX']['CONF']['oacDashboard']);
        }
        $url .= strpos($url, '?') === false ? '?' : '&amp;';
        $url .= 'ticket='.urlencode($m2mTicket);
        $url .= '&amp;oapPath='.urlencode(preg_replace('#/$#', '', MAX::constructURL(MAX_URL_ADMIN, '')));
        $url .= '&amp;lang=' . $GLOBALS['_MAX']['PREF']['language'];

        return $url;
    }
}

?>
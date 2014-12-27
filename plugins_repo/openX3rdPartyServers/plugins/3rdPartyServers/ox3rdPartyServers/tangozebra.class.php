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
 * @package    OpenXPlugin
 * @subpackage 3rdPartyServers
 */

require_once LIB_PATH . '/Extension/3rdPartyServers/3rdPartyServers.php';

/**
 *
 * 3rdPartyServer plugin. Allow for generating different banner html cache
 *
 * @static
 */
class Plugins_3rdPartyServers_ox3rdPartyServers_tangozebra extends Plugins_3rdPartyServers
{

    /**
     * Return the name of plugin
     *
     * @return string
     */
    function getName()
    {
        return $this->translate('Tango Zebra');
    }

    /**
     * Return plugin cache
     *
     * @return string
     */
    function getBannerCache($buffer, &$noScript)
    {
        $search = array(
            "/tz_redirector_(\d+)\s*=\s*[\\\\]?\"[\\\\]?\"/",
            "/tz_pv_(\d+)\s*=\s*[\\\\]?\"[\\\\]?\"/",
        );
        $replace = array(
            "tz_redirector_$1=\"{clickurl}\"",
            "tz_pv_$1=\"{logurl}\"",
        );

        $buffer = preg_replace ($search, $replace, $buffer);

        return $buffer;
    }

}

?>

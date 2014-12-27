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
class Plugins_3rdPartyServers_ox3rdPartyServers_atlas extends Plugins_3rdPartyServers
{

    /**
     * Return the name of plugin
     *
     * @return string
     */
    function getName()
    {
        return $this->translate('Atlas');
    }

    /**
     * Return plugin cache
     *
     * @return string
     */
    function getBannerCache($buffer, &$noScript)
    {
        $search  = array("/\[timestamp\]/i","/(http:.*?direct\/01)?click=(.*?)/i");
        $replace = array("{random}",     "$1click={clickurl}$2");

        $buffer = preg_replace ($search, $replace, $buffer);
        $noScript[0] = preg_replace($search[0], $replace[0], $noScript[0]);

        return $buffer;
    }

}

?>
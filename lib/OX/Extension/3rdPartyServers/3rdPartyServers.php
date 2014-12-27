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

require_once LIB_PATH . '/Plugin/Component.php';

/**
 * Plugins_3rdPartyServers is an abstract class for every 3rdPartyServers plugin
 *
 * @package    OpenXPlugin
 * @subpackage 3rdPartyServers
 * @abstract
 */
class Plugins_3rdPartyServers extends OX_Component
{

    /**
     * Return the name of plugin
     *
     * @abstract
     * @return string
     */
    function getName()
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    /**
     * Return plugin cache
     *
     * @abstract
     * @return string
     */
    function getBannerCache($bannerHtml, &$noScript)
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

}

?>

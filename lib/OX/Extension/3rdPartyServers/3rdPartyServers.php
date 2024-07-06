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
 * @deprecated
 *
 * @package    OpenXPlugin
 * @subpackage 3rdPartyServers
 */
abstract class Plugins_3rdPartyServers extends OX_Component
{
    /**
     * Return plugin cache
     *
     * @return string
     */
    abstract public function getBannerCache($bannerHtml, &$noScript);
}

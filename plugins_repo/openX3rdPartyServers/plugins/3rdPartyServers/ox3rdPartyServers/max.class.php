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
 * @author     Radek Maciaszek <radek@m3.net>
 *
 */

require_once LIB_PATH . '/Extension/3rdPartyServers/3rdPartyServers.php';

/**
 *
 * 3rdPartyServer plugin. Allow for generating different banner html cache
 *
 * @static
 */
class Plugins_3rdPartyServers_ox3rdPartyServers_max extends Plugins_3rdPartyServers
{
    var $hasOutputMacros = true;
    var $clickurlMacro = '{clickurl_enc}';
    var $cachebusterMacro = '{random}';

    /**
     * Return the name of plugin
     *
     * @return string
     */
    function getName()
    {
        return $this->translate('Rich Media - OpenX');
    }

    /**
     * Return plugin cache
     *
     * @return string
     */
    function getBannerCache($buffer, &$noScript)
    {
        $search  = array("/insert_random_number_here/i", "/insert_(?:encoded_)?click_?(?:track_|_)?url_here/i");
        $replace = array("{random}", "{clickurl_enc}");

        $buffer = preg_replace($search, $replace, $buffer);
        $noScript[0] = preg_replace($search, $replace, $noScript[0]);

        return $buffer;
    }

}

?>

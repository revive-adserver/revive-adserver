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
class Plugins_3rdPartyServers_ox3rdPartyServers_kontera extends Plugins_3rdPartyServers
{

    /**
     * Return the name of plugin
     *
     * @return string
     */
    function getName()
    {
        return $this->translate('Kontera');
    }

    /**
     * Return plugin cache
     *
     * @return string
     */
    function getBannerCache($buffer, &$noScript)
    {
        if (!stristr($buffer, 'kontera.com')) {
            // This does not appear to be a kontera tag, leave unchanged
            return $buffer;
        }

        $search = "#var dc_adprod\s*=\s*[\'\\\"]([a-zA-Z]+)[\'\\\"];#";
        $replace = "var dc_adprod='$1';\nvar dc_redirect3PartyUrl='{clickurl}';\n";

        $buffer = preg_replace ($search, $replace, $buffer);

        return $buffer;
    }

}

?>

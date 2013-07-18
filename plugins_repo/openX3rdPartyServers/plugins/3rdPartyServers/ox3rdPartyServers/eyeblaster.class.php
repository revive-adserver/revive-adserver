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
class Plugins_3rdPartyServers_ox3rdPartyServers_eyeblaster extends Plugins_3rdPartyServers
{

    /**
     * Return the name of plugin
     *
     * @return string
     */
    function getName()
    {
        return $this->translate('Rich Media - Eyeblaster');
    }

    /**
     * Return plugin cache
     *
     * @return string
     */
    function getBannerCache($buffer, &$noScript)
    {
        $search = "#([a-zA-Z]+)\.nFlightID\s*=\s*(\d+);#";
        $replace = "$1.nFlightID = $2;\r\n//Interactions\n$1.interactions = new Object();\r\n\$1.interactions[\"_eyeblaster\"] = \"ebN={clickurl}\";\r\n";
        $buffer = preg_replace ($search, $replace, $buffer);
        
        $search  = array("/(<script.*)bs.serving-sys.com(.*?)ord=.*?([&'\"].*<\/script>)/i");
        $replace = array("$1bs.serving-sys.com$2{random}&ncu={clickurl}$3");
        $buffer = preg_replace ($search, $replace, $buffer);
        
        return $buffer;
    }

}

?>

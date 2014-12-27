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
class Plugins_3rdPartyServers_ox3rdPartyServers_cpx extends Plugins_3rdPartyServers
{

    /**
     * Return the name of plugin
     *
     * @return string
     */
    function getName()
    {
        return $this->translate('CPX');
    }

    /**
     * Return plugin cache
     *
     * @return string
     */
    function getBannerCache($buffer, &$noScript)
    {
        //http://adserving.cpxinteractive.com/st?ad_type=iframe&ad_size=728x90&entity=33841&site_code=4567345&section_code=0001P

        // Make no changes if cpxinteractive is not present in the buffer
        if (!stristr($buffer, 'cpxinteractive')) {
            return $buffer;
        }
        if (stristr($buffer, 'pub_redirect')) {
            // This code already has the pub_redirect code, just add {clickurl} to it
            $search = array('#cpxinteractive\.com/([^\"\']*?)&pub_redirect[^\"\']*([\"\'])#i');
            $replace = array('cpxinteractive.com/$1&pub_redirect_unencoded=1&pub_redirect={clickurl}$2');
        } else {
            // This code does not have the pub_redirect code that they
            $search  = array("#cpxinteractive\.com/([^\"\']*?)([\"\'])#i");
            $replace = array("cpxinteractive.com/$1&pub_redirect_unencoded=1&pub_redirect={clickurl}$2");
        }

        $buffer = preg_replace ($search, $replace, $buffer);
        $noScript[0] = preg_replace($search[0], $replace[0], $noScript[0]);

        return $buffer;
    }

}

?>
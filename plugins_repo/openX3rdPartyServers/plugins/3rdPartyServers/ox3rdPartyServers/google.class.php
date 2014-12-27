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
class Plugins_3rdPartyServers_ox3rdPartyServers_google extends Plugins_3rdPartyServers
{

    /**
     * Return the name of plugin
     *
     * @return string
     */
    function getName()
    {
        return $this->translate('Google AdSense');
    }

    /**
     * Return plugin cache
     *
     * @return string
     */
    function getBannerCache($buffer, &$noScript)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        if (preg_match('/<script.*?src=".*?googlesyndication\.com/is', $buffer))
        {
            $new_buffer = "<span>".
                      "<script type='text/javascript'><!--// <![CDATA[\n".
            "/* {$conf['var']['openads']}={url_prefix} {$conf['var']['adId']}={bannerid} {$conf['var']['zoneId']}={zoneid} {$conf['var']['channel']}={source} ";
            // addUrlParams hook for plugins to add key=value pairs to the log/click URLs
            $componentParams =  OX_Delivery_Common_hook('addUrlParams', array());
            foreach ($componentParams as $params) {
                if (!empty($params) && is_array($params)) {
                    foreach ($params as $key => $value) {
                        $new_buffer .= urlencode($key) . '={' . urlencode($key) . '} ';
                    }
                }
            }
            $new_buffer .= "*/\n".
                      "// ]]> --></script>".
                      $buffer.
                      "<script type='text/javascript' src='{url_prefix}/".$conf['file']['google']."'></script>".
                      "</span>";
            return $new_buffer;
        }
        return $buffer;
    }

}

?>

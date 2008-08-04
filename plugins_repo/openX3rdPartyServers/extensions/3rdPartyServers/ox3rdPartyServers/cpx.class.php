<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
$Id: doubleclick.plugin.php 9049 2007-08-16 11:52:56Z chris.nutting@openads.org $
*/

/**
 * @package    OpenXPlugin
 * @subpackage 3rdPartyServers
 * @author     Radek Maciaszek <radek@m3.net>
 *
 */

require_once OX_EXTENSIONS_PATH . '/3rdPartyServers/3rdPartyServers.php';

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
        include_once MAX_PATH . '/lib/max/Plugin/Translation.php';
        MAX_Plugin_Translation::init($this->module, $this->package);

        return MAX_Plugin_Translation::translate('Rich Media - CPX', $this->module, $this->package);
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
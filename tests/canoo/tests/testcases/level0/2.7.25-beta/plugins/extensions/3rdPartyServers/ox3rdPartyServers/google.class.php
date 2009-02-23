<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
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
$Id: google.class.php 25335 2008-09-08 10:55:13Z monique.szpak $
*/

/**
 * @package    OpenXPlugin
 * @subpackage 3rdPartyServers
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 *
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
        return $this->translate('Rich Media - Google AdSense');
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
            $buffer = "<span>".
                      "<script type='text/javascript'><!--// <![CDATA[\n".
                      "/* {$conf['var']['openads']}={url_prefix} {$conf['var']['adId']}={bannerid} {$conf['var']['zoneId']}={zoneid} {$conf['var']['channel']}={source} */\n".
                      "// ]]> --></script>".
                      $buffer.
                      "<script type='text/javascript' src='{url_prefix}/".$conf['file']['google']."'></script>".
                      "</span>";
        }

        return $buffer;
    }

}

?>

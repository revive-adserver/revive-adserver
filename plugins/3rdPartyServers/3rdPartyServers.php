<?php
/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: 3rdPartyServers.php 6108 2006-11-24 11:34:58Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/max/Plugin/Common.php';

/**
 * Plugins_3rdPartyServers is an abstract class for every 3rdPartyServers plugin
 *
 * @package    MaxPlugin
 * @subpackage 3rdPartyServers
 * @author     Radek Maciaszek <radek@m3.net>
 * @abstract
 */
class Plugins_3rdPartyServers extends MAX_Plugin_Common
{

    /**
     * Return the name of plugin
     *
     * @abstract
     * @return string
     */
    function getName()
    {
        Max::debug('Cannot run abstract method');
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
        Max::debug('Cannot run abstract method');
        exit();
    }

}

?>

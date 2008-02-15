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
$Id$
*/

/**
 * @package    OpenXPlugin
 * @subpackage ChannelDerivation
 * @author     Radek Maciaszek <radek@m3.net>
 */

require_once MAX_PATH . '/plugins/channelDerivation/ChannelDerivation.php';

/**
 *
 * Class is checking regex rule by domain name (referer) and generate
 * derived source for domains saved in SQL tables
 *
 * @static
 */
class Plugins_ChannelDerivation_Xmlrpc_Xmlrpc extends Plugins_ChannelDerivation
{
    function Plugins_ChannelDerivation_Xmlrpc_Xmlrpc($module, $package, $name)
    {
        $this->module = $module;
        $this->package = $package;
        $this->name = $name;

        $this->init();
    }

    /**
     * This method reads domain regex rules from the origin XML-RPC server
     *
     * @param string $domain
     *
     * @return array
     */
    function getRulesByDomain($domain)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        require_once(MAX_PATH . '/lib/OA/Dal/Delivery/' . strtolower($this->package) . '.php');

        $xParams = array(
            'module'  => $this->module,
            'package' => $this->package,
            'name'    => $this->name,
            'method'  => __FUNCTION__,
            'data'    => $domain
        );

        return MAX_Dal_Delivery_pluginExecute($xParams);
    }
}

?>
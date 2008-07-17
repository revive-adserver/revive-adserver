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
class Plugins_ChannelDerivation_Mysql_Mysql extends Plugins_ChannelDerivation
{
    function Plugins_ChannelDerivation_Mysql_Mysql($module, $package, $name)
    {
        $this->module = $module;
        $this->package = $package;
        $this->name = $name;

        $this->init();
    }

    /**
     * This method read domain regex rules from sql database
     *
     * @param string $domain
     *
     * @return array
     */
    function getRulesByDomain($domain)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        require_once(MAX_PATH . '/lib/OA/Dal/Delivery/' . strtolower($conf['database']['type']) . '.php');

        $rulesRes = OA_Dal_Delivery_query("
            SELECT r.modifier, r.rule
            FROM
                {$conf['table']['prefix']}{$conf['table']['plugins_channel_delivery_assoc']} AS dr,
                {$conf['table']['prefix']}{$conf['table']['plugins_channel_delivery_domains']} AS d,
                {$conf['table']['prefix']}{$conf['table']['plugins_channel_delivery_rules']} AS r
            WHERE
                d.domain_name = '{$domain}'
                AND dr.rule_id = r.rule_id
                AND d.domain_id = dr.domain_id
            ORDER BY dr.rule_order"
        );
        if ($rulesRes) {
            $rules = array();
            while ($thisRule = mysql_fetch_assoc($rulesRes)) {
                $rules[] = $thisRule;
            }
            return $rules;
        } else {
            return false;
        }
    }
}

?>
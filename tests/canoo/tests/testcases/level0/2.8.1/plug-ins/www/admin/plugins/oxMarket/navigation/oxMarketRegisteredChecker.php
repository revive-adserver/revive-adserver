<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$Id: oxMarketRegisteredChecker.php 36120 2009-05-08 14:39:46Z miguel.correa $
*/
require_once(MAX_PATH . '/lib/OA/Admin/Menu/IChecker.php');

/**
 *
 * @package    openXMarket
 * @subpackage oxMarket
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Plugins_admin_oxMarket_oxMarketRegisteredChecker
    implements OA_Admin_Menu_IChecker
{
    /**
     * Returns true if marketPlugin is enabled and status flag is set to valid.
     *
     * @param OA_Admin_Menu_Section $oSection
     */
    public function check($oSection)
    {
        $isRegistered = false;
        if (isset ( $GLOBALS['_MAX']['CONF']['plugins']['openXMarket'] )
            && $GLOBALS['_MAX']['CONF']['plugins']['openXMarket']) {

            require_once(MAX_PATH . '/www/admin/plugins/oxMarket/oxMarket.class.php');
            $oOpenxMarket = new Plugins_admin_oxMarket_oxMarket();
            if ($oOpenxMarket->isActive() && $oOpenxMarket->isRegistered()) {
                $isRegistered = true;
            }
        }
        return $isRegistered;
    }
}

?>

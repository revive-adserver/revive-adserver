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

require_once(MAX_PATH . '/lib/OA/Admin/Menu/IChecker.php');

/**
 *
 * @package    openXMarket
 * @subpackage oxMarket
 * @author     Bernard Lange  <bernard@openx.org>
 */
class Plugins_admin_oxMarket_oxMarketAdminStatsChecker
    implements OA_Admin_Menu_IChecker
{
    /**
     * Returns true if plugin is:
     *  - in hosted mode
     *  or
     *  - in standalone mode and is is enabled and status flag is set to valid
     *  (ie. is active)
     *
     * @param OA_Admin_Menu_Section $oSection
     */
    public function check($oSection)
    {
        $oMarketComponent = OX_Component::factory('admin', 'oxMarket');

        //market stats are only visible if plugin is:
        //- in hosted mode
        //or
        //- in standalone mode and is active
        return $oMarketComponent->isMultipleAccountsMode()
            || $oMarketComponent->isActive();
    }
}

?>

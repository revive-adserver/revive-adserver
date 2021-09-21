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
 * A default deliveryLog extension database layer class. Is both used as an
 * ancestor class for any databases that require special database support
 * functionality to allow the deliveryLog extension to work effectively, and
 * also as a default class when no database-specific class exists.
 *
 * @package    OpenXExtension
 * @subpackage DeliveryLog
 */
class OX_Extension_DeliveryLog_DB_Common
{
    /**
     * A method to install whatever database support functionality
     * is required to allow the deliveryLog extension to operate
     * effectively.
     *
     * @param Plugins_DeliveryLog $oComponent The plugin component being installed
     *                                        that requires the special database
     *                                        layer support.
     * @return boolean True on success, false otherwise.
     */
    public function install(Plugins_DeliveryLog $oComponent)
    {
        return true;
    }

    /**
     * A method to uninstall whatever database support functionality
     * was required to allow the deliveryLog extension to operate
     * effectively.
     *
     * @param Plugins_DeliveryLog $oComponent The plugin component being uninstalled
     *                                        that requires the special database
     *                                        layer support.
     * @return boolean True on success, false otherwise.
     */
    public function uninstall(Plugins_DeliveryLog $oComponent)
    {
        return true;
    }
}

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

$className = 'postscript_install_oxLogRequest';

require_once LIB_PATH . '/Extension/deliveryLog/Setup.php';

/**
 * Installs any additional data after the plugins are installed
 * (before they are enabled)
 *
 * @package    Plugin
 * @subpackage openxDeliveryLog
 */
class postscript_install_oxLogRequest
{
    public const DELIVERY_LOG_EXTENSION = 'deliveryLog';
    public const DELIVERY_LOG_GROUP = 'oxLogRequest';

    /**
     * Calls onInstall method for the required component and group.
     *
     * If for any reason the installation failed perform uninstall of already installed
     * components.
     *
     * @return boolean True on success, else false.
     */
    public function execute()
    {
        $oSetup = new OX_Extension_DeliveryLog_Setup();
        return $oSetup->installComponents(self::DELIVERY_LOG_EXTENSION, [self::DELIVERY_LOG_GROUP]);
    }
}

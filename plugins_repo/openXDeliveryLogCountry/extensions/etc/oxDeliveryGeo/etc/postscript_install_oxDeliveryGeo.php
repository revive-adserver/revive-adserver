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

$className = 'postscript_install_oxDeliveryGeo';

require_once LIB_PATH . '/Extension/deliveryLog/Setup.php';

/**
 * Installs any additional data after the plugins are installed
 * (before they are enabled)
 *
 * @package    Plugin
 * @subpackage openxDeliveryLogCountry
 */
class postscript_install_oxDeliveryGeo
{
    const DELIVERY_LOG_EXTENSION = 'deliveryLog';

    /**
     * Names of component groups which performs additional actions
     * when installing.
     *
     * @var array
     */
    private $aGroups = array(
        'oxLogCountry',
    );

    /**
     * Calls onInstall method on every component from installed groups.
     * If for any reason the installation failed perform uninstall of already installed
     * components.
     *
     * @return boolean  True on success, else false
     */
    function execute()
    {
        $oSetup = new OX_Extension_DeliveryLog_Setup();
        return $oSetup->installComponents(self::DELIVERY_LOG_EXTENSION, $this->aGroups);
    }
}
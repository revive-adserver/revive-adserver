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

$className = 'postscript_install_oxDeliveryDataPrepare';

require_once MAX_PATH . '/lib/OX/Plugin/Component.php';

/**
 * Installs any additional data after the plugins are installed
 * (before they are enabled)
 *
 */
class postscript_install_oxDeliveryDataPrepare
{
    const DELIVERY_LOG_EXTENSION = 'deliveryLog';

    /**
     * Names of component groups which performs additional actions
     * when installing.
     *
     * @var array
     */
    private $aGroups = array(
        'oxLogClick',
        'oxLogImpression',
        'oxLogRequest',
    );

    /**
     * Keeps the reference to already installed components, so it
     * can perform uninstall in case of any error.
     *
     * @var array
     */
    private $aInstalledComponents = array();

    /**
     * Calls onInstall method on every component which is installed groups.
     * If for any reason the installation failed it uninstall already installed
     * components.
     *
     * @return boolean  True on success, else false
     */
    function execute()
    {
        $component = new OX_Component();
        foreach ($this->aGroups as $group) {
            $aComponents = $component->getComponents(self::DELIVERY_LOG_EXTENSION, $group, true, 1, $enabled = false);
            foreach ($aComponents as $component) {
                if (!$component->onInstall()) {
                    $this->_logError('Error when installing component: '.get_class($component));
                    $this->recoverUninstallComponents();
                    return false;
                }
                $this->markComponentAsInstalled($component);
            }
        }
        return true;
        // write a special test which tests this behavior
    }

    /**
     * Recovery on failed installation. Calls onUninstall method
     * on every component from components groups.
     */
    function recoverUninstallComponents()
    {
        foreach ($this->aInstalledComponents as $componentId) {
            $component = OX_Component::factoryByComponentIdentifier($componentId);
            if(!$component) {
                $this->_logError('Error when creating component: '.$componentId);
                continue;
            }
            if (!$component->onUninstall()) {
                $this->_logError('Error when uninstalling component: '.$componentId);
            }
        }
    }

    /**
     * Keeps the reference of already installed components. In case
     * a recovery uninstall will need to be performed.
     *
     * @param Plugins_DeliveryLog_LogCommon $component
     */
    function markComponentAsInstalled(Plugins_DeliveryLog_LogCommon $component)
    {
        $this->aInstalledComponents[] = $component->getComponentIdentifier();
    }

    /**
     * Debugging
     *
     * @param string $msg  Debugging message
     * @param int $err  Type of message (PEAR_LOG_INFO, PEAR_LOG_ERR, PEAR_LOG_WARN)
     */
    function _logMessage($msg, $err=PEAR_LOG_INFO)
    {
        OA::debug($msg, $err);
    }

    /**
     * Debugging - error messages
     *
     * @param string $msg  Debugging message
     */
    function _logError($msg)
    {
        $this->aErrors[] = $msg;
        $this->_logMessage($msg, PEAR_LOG_ERR);
    }
}
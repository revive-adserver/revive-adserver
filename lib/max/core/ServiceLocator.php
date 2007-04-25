<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
 * A class that allows services to be globally registered, so that they
 * can be accessed by any class that needs them. Also allows Mock Objects
 * to be easily used as replacements for classes during testing.
 *
 * @package    Max
 * @author     Luis Correa d'Almeida <luis@m3.net>
 * @author     Andrew Hill <andrew@m3.net>
  */
class ServiceLocator
{

    var $aService = array();

    /**
     * A method to return a singleton handle to the service locator class.
     *
     * @return ServiceLocator
     */
    function &instance()
    {
        static $oInstance;
        if (!$oInstance) {
            $oInstance = new ServiceLocator();
        }
        return $oInstance;
    }

    /**
     * A method to register a service with the service locator class.
     *
     * @param string $serviceName The name of the service being registered.
     * @param mixed $oService The object (service) being registered.
     * @return boolean Always returns true.
     */
    function register($serviceName, &$oService)
    {
        $this->aService[$serviceName] = &$oService;
        return true;
    }

    /**
     * A method to remove a registered service from the service locator class.
     *
     * @param string $serviceName The name of the service being de-registered.
     */
    function remove($serviceName)
    {
        unset($this->aService[$serviceName]);
    }

    /**
     * A method to return a registered service.
     *
     * @param string $serviceName The name of the service required.
     * @return mixed Either the service object requested, or false if the
     *               requested service was not registered.
     */
    function &get($serviceName)
    {
        if (isset($this->aService[$serviceName])) {
            return $this->aService[$serviceName];
        }
        $false = false;
        return $false;
    }

    /**
     * A method to return a registered service.
     *
     * @static
     * @param string $serviceName The name of the service required.
     * @return mixed Either the service object requested, or false if the
     *               requested service was not registered.
     */
    function &staticGet($serviceName)
    {
        $oServiceLocator = &ServiceLocator::instance();
        return $oServiceLocator->get($serviceName);
    }

}

?>

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
 * A class that allows services to be globally registered, so that they
 * can be accessed by any class that needs them. Also allows Mock Objects
 * to be easily used as replacements for classes during testing.
 *
 * @package    OpenX
  */
class OA_ServiceLocator
{
    public $aService = [];

    /**
     * A method to return a singleton handle to the service locator class.
     *
     * @return OA_ServiceLocator
     */
    public static function instance()
    {
        static $oInstance;
        if (!$oInstance) {
            $oInstance = new OA_ServiceLocator();
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
    public function register($serviceName, &$oService)
    {
        $this->aService[$serviceName] = &$oService;
        return true;
    }

    /**
     * A method to remove a registered service from the service locator class.
     *
     * @param string $serviceName The name of the service being de-registered.
     */
    public function remove($serviceName)
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
    public function &get($serviceName)
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
    public function &staticGet($serviceName)
    {
        $oServiceLocator = OA_ServiceLocator::instance();
        return $oServiceLocator->get($serviceName);
    }
}

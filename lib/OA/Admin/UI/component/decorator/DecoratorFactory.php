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

class OA_Admin_UI_Decorator_Factory
{
    /**
     * Returns a singleton of OA_Admin_UI_Decorator_Factory
     *
     * @return    OA_Admin_UI_Decorator_Factory
     */
    public static function singleton()
    {
        static $instance;
        if (!isset($instance)) {
            $instance = new OA_Admin_UI_Decorator_Factory();
        }
        return $instance;
    }

    
    public function __construct()
    {
    }
    
    
    /**
     * Registers OA_Admin_UI_Decorator for a decorator
     *
     * @return true if successfully registered, false if there is already decorator
     * registered for this name.
     */
    public function registerDecorator($decoratorName, $path, $className)
    {
        $decoratorName = strtolower($decoratorName);
        
        if (empty($decoratorName) || empty($path) || empty($className)) {
            $errMsg = "DecoratorRegistry::add() Cannot register decorator $decoratorName from class $className included from $path";
            return MAX::raiseError($errMsg);
        }
        
        if (isset($GLOBALS['_OA_Admin_UI_Decorator_Factory_registered_decorators'][$decoratorName])) {
            return false;
        }
        
        $GLOBALS['_OA_Admin_UI_Decorator_Factory_registered_decorators'][$decoratorName] = [$path, $className];

        return true;
    }

        
    /**
     * Returns an instance of OA_Admin_UI_Decorator registered under a given name
     *
     * @param string $decoratorName a name of adaptor type to be retrieved
     * @param array $aParameters list of parameters to be passed to decorator constructor
     * @return OA_Admin_UI_Decorator
     */
    public static function newDecorator($decoratorName, $aParameters = null)
    {
        $decoratorFactory = OA_Admin_UI_Decorator_Factory::singleton();
        return $decoratorFactory->_newDecorator($decoratorName, $aParameters);
    }
        
        
    private function _newDecorator($decoratorName, $aParameters = null)
    {
        $decoratorName = strtolower($decoratorName);
        if (!isset($GLOBALS['_OA_Admin_UI_Decorator_Factory_registered_decorators'][$decoratorName])) {
            return null;
        }
        
        list($path, $class) = $GLOBALS['_OA_Admin_UI_Decorator_Factory_registered_decorators'][$decoratorName];
        include_once($path);
        
        return new $class($aParameters);
    }
}

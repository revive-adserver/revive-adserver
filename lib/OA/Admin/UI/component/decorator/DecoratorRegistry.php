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

class OA_Admin_UI_Decorator_Registry
{
    private $decoratorNameToDecoratorMap;
    
    /**
     * Returns a singleton of OA_Admin_UI_Decorator_Registry
     *
     * @return    OA_Admin_UI_Decorator_Registry
     */
    function singleton()
    {
        static $instance;
        if (!isset($instance)) {
            $instance = new OA_Admin_UI_Decorator_Registry();
        }
        return $instance;
    } 

    
    function __construct()
    {
        $this->decoratorNameToDecoratorMap = array();
    }
    
    
    /**
     * Registers OA_Admin_UI_Decorator for a decorator
     * 
     * @return true if successfully registered, false if there is already decorator
     * registered for this name. 
     */
    function registerJQueryRuleAdaptor($decoratorName, $path, $className)
    {
        $decoratorName = strtolower($decoratorName);
        
        if (empty($decoratorName) || empty($path) || empty($className)) {
            $errMsg = "DecoratorRegistry::add() Cannot register decorator $decoratorName from class $className included from $path";
            return MAX::raiseError($errMsg);
        }
        
        if (isset($GLOBALS['_OA_Admin_UI_Decorator_Registry_registered_decorators'][$decoratorName])) {
            return false;    
        }
        
        $GLOBALS['_OA_Admin_UI_Decorator_Registry_registered_decorators'][$decoratorName] = array($path, $className);

        return true;
    }
    
    
    /**
     * Returns an instance of OA_Admin_UI_Decorator registered under given name
     *
     * @param string $decoratorName a name of adaptor type to be retrieved
     * @param array $aParameters list of parameters to be passed to decorator constructor
     * @return OA_Admin_UI_Decorator
     */
    function getJQueryRuleAdaptor($decoratorName, $aParameters =  null)
    {
        $decoratorName = strtolower($decoratorName);
        if (!isset($GLOBALS['_OA_Admin_UI_Decorator_Registry_registered_decorators'][$decoratorName])) {
            return null;
        }
        
        list($path, $class) = $GLOBALS['_OA_Admin_UI_Decorator_Registry_registered_decorators'][$decoratorName];
        
        return new $class($aParameters);        

//        if (!isset($this->decoratorNameToDecoratorMap[$decoratorName])) {
//            include_once($path);
//            $this->decoratorNameToDecoratorMap[$decoratorName] = new $class($aParameters);
//        }
//        return $this->decoratorNameToDecoratorMap[$decoratorName];
    }
}

?>

<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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
class OA_Admin_UI_Decorator_Factory
{
    
    /**
     * Returns a singleton of OA_Admin_UI_Decorator_Factory
     *
     * @return    OA_Admin_UI_Decorator_Factory
     */
    function singleton()
    {
        static $instance;
        if (!isset($instance)) {
            $instance = new OA_Admin_UI_Decorator_Factory();
        }
        return $instance;
    } 

    
    function __construct()
    {
    }
    
    
    /**
     * Registers OA_Admin_UI_Decorator for a decorator
     * 
     * @return true if successfully registered, false if there is already decorator
     * registered for this name. 
     */
    function registerDecorator($decoratorName, $path, $className)
    {
        $decoratorName = strtolower($decoratorName);
        
        if (empty($decoratorName) || empty($path) || empty($className)) {
            $errMsg = "DecoratorRegistry::add() Cannot register decorator $decoratorName from class $className included from $path";
            return MAX::raiseError($errMsg);
        }
        
        if (isset($GLOBALS['_OA_Admin_UI_Decorator_Factory_registered_decorators'][$decoratorName])) {
            return false;    
        }
        
        $GLOBALS['_OA_Admin_UI_Decorator_Factory_registered_decorators'][$decoratorName] = array($path, $className);

        return true;
    }

        
    /**
     * Returns an instance of OA_Admin_UI_Decorator registered under a given name
     *
     * @param string $decoratorName a name of adaptor type to be retrieved
     * @param array $aParameters list of parameters to be passed to decorator constructor
     * @return OA_Admin_UI_Decorator
     */
    function newDecorator($decoratorName, $aParameters =  null)
    {
        $decoratorFactory = OA_Admin_UI_Decorator_Factory::singleton();        
        return $decoratorFactory->_newDecorator($decoratorName, $aParameters);        
    }
        
        
    private function _newDecorator($decoratorName, $aParameters =  null)
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

?>

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

class OA_Admin_UI_Rule_JQueryRuleAdaptorRegistry
{
    private $quickFormRuleNameToAdaptorMap;
    
    /**
     * Returns a singleton of OA_Admin_UI_Rule_JQueryRuleAdaptorRegistry
     *
     * @return    OA_Admin_UI_Rule_JQueryRuleAdaptorRegistry
     */
    public static function singleton()
    {
        static $instance;
        if (!isset($instance)) {
            $instance = new OA_Admin_UI_Rule_JQueryRuleAdaptorRegistry();
        }
        return $instance;
    }

    
    public function __construct()
    {
        $this->quickFormRuleNameToAdaptorMap = [];
    }
    
    
    /**
     * Registers OA_Admin_UI_Rule_QuickFormToJQueryRuleAdaptor for a given quickform rule
     *
     * @return true if successfully registered, false if there is already adaptor
     * registered for this quickform rule.
     */
    public function registerJQueryRuleAdaptor($quickFormRuleName, $path, $className)
    {
        $quickFormRuleName = strtolower($quickFormRuleName);
        
        if (empty($quickFormRuleName) || empty($path) || empty($className)) {
            $errMsg = "JQueryRuleAdaptorRegistry::add() Cannot register adaptor for class $className for  rule $quickFormRuleName included from $path";
            return MAX::raiseError($errMsg);
        }
        
        if (isset($GLOBALS['_OA_Admin_UI_Rule_JQueryRuleAdaptorRegistry_registered_adaptors'][$quickFormRuleName])) {
            return false;
        }
        
        $GLOBALS['_OA_Admin_UI_Rule_JQueryRuleAdaptorRegistry_registered_adaptors'][$quickFormRuleName] = [$path, $className];

        return true;
    }
    
    
    /**
     * Returns an instance of OA_Admin_UI_Rule_QuickFormToJQueryRuleAdaptor capable
     * of providing JQuery validation plugin compliant validation for a given
     * quickform rule
     *
     * @param string $quickFormRuleName a name of quickform rule adaptro is retrieved
     * @return OA_Admin_UI_Rule_QuickFormToJQueryRuleAdaptor
     */
    public function getJQueryRuleAdaptor($quickFormRuleName)
    {
        $quickFormRuleName = strtolower($quickFormRuleName);
        if (!isset($GLOBALS['_OA_Admin_UI_Rule_JQueryRuleAdaptorRegistry_registered_adaptors'][$quickFormRuleName])) {
            return null;
        }
        
        list($path, $class) = $GLOBALS['_OA_Admin_UI_Rule_JQueryRuleAdaptorRegistry_registered_adaptors'][$quickFormRuleName];

        if (!isset($this->quickFormRuleNameToAdaptorMap[$quickFormRuleName])) {
            include_once($path);
            $this->quickFormRuleNameToAdaptorMap[$quickFormRuleName] = new $class();
        }
        return $this->quickFormRuleNameToAdaptorMap[$quickFormRuleName];
    }
}

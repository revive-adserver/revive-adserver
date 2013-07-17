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

require_once MAX_PATH . '/lib/OX/Admin/UI/Event/EventDispatcher.php';
require_once MAX_PATH . '/lib/OX/Admin/UI/Event/EventContext.php';

/**
 * A manager for UI related hooks.
 * 
 * Allows registration of event listeners in the form of {@link http://www.php.net/manual/en/language.pseudo-types.php#language.types.callback callback}
 * and when informed of an event it will pass the event to registered listeners.
 * 
 * Listeners can be registered via provided methods. Plugins, whishing to listen
 * to ui events should implement 'registerUiListeners' plugin hook and
 * register apprioriate listeners when it is called.
 * 
 * For performance reasons, plugin 'registerUiListeners' is called once per request
 * and only when ui event is being invoked.
 * 
 * 
 */
class OX_Admin_UI_Hooks
{
    private static $initialized = false;
    
    /*
     * UI hook. Invoked before OA_Admin_UI::showHeader() starts processing.
     * Note:
     * - at this point it should be safe to output any additional headers
     * if needed. 
     * - do not output content here! (use after pageHeader or beforePageContent hooks to
     *   render any content after layout and before actual page content.)
     *
     * @param string $menuSectionId section id of page being rendered
     * @param array $pageData array of page related parameters eg. clientid, campaignid
     * @param OA_Admin_UI_Model_PageHeaderModel optional $headerModel 
     */
    public static function beforePageHeader($menuSectionId, $pageData, $oHeaderModel = null)
    {
        self::init();
        
        $oContext = new OX_Admin_UI_Event_EventContext(array(
            'pageId' => $menuSectionId,
            'pageData' => $pageData,
            'headerModel' => $oHeaderModel,
        ));         
        
        self::getDispatcher()->triggerEvent('beforePageHeader', $oContext); 
    }
    
    
    /**
     * Registers callback to be invoked when 'beforePageHeader' event occurs.
     * 
     * Callback will be passed an OX_Admin_UI_Event_EventContext object with the following
     * data:
     * 'pageId' - string menu section id of page being rendered 
     * 'pageData' => menu links parameter values (eg. clientid, campaignid etc.),
     *
     * @param PHP callback $callback
     */
    public static function registerBeforePageHeaderListener($callback)
    {
        self::getDispatcher()->register('beforePageHeader', $callback);
    }
    
    
    /*
     * UI hook. Invoked right after OA_Admin_UI::showHeader() ends processing.
     * Any data displayed here will precede page content (including content rendered
     * via beforePageContent hook. 
     *
     * @param string $menuSectionId section id of page being rendered
     */
    public static function afterPageHeader($menuSectionId)
    {
        self::init();
        
        $oContext = new OX_Admin_UI_Event_EventContext(array(
            'pageId' => $menuSectionId,
            'pageData' => $pageData,
        ));         
        
        self::getDispatcher()->triggerEvent('afterPageHeader', $oContext); 
    }    
    

    /**
     * Registers callback to be invoked when 'afterPageHeader' event occurs.
     * 
     * Callback will be passed an OX_Admin_UI_Event_EventContext object with the following
     * data:
     * 'pageId' - string menu section id of page being rendered 
     * 'pageData' => menu links parameter values (eg. clientid, campaignid etc.),
     *      
     * @param PHP callback $callback
     */
    public static function registerAfterPageHeaderListener($callback)
    {
        self::getDispatcher()->register('afterPageHeader', $callback);
    }
    
    
    /**
     * Template hook. Should be invoked only from smarty template at the top of the top-most page 
     * content template, before page content.
     * 
     * By page content, we mean anything which is not rendered from layout built by UI->showHeader(); 
     *
     * @param string $pageId
     * @param array $pageData
     * @param OA_Admin_Template $oTpl
     * @return string HTML content to be injected before page content
     */
    public static function beforePageContent($pageId, $pageData, &$oTpl)
    {
        self::init();
        $result = '';
        $oContext = new OX_Admin_UI_Event_EventContext(array(
            'pageId' => $pageId,
            'pageData' => $pageData,
            'oTpl'     => $oTpl
        )); 
        
        $aStrings = self::getDispatcher()->triggerEvent('beforePageContent', $oContext);
        if (!empty($aStrings)) {
            $result = join('\n', $aStrings); 
        }

        return $result; 
    }

    
    /**
     * Registers callback to be invoked when 'beforePageContent' event occurs.
     * 
     * Callback will be passed an OX_Admin_UI_Event_EventContext object with the following
     * data:
     * 'pageId' - string menu section id of page being rendered 
     * 'pageData' => menu links parameter values (eg. clientid, campaignid etc.),
     * 'oTpl'     => instance of OA_Admin_Template being used to render page content 
     *      
     * @param PHP callback $callback
     */
    public static function registerBeforePageContentListener($callback)
    {
        self::getDispatcher()->register('beforePageContent', $callback);    
    }
    
    
    /**
     * Template hook. Should be invoked only from smarty template at the top of the top-most page 
     * content template, before page content.
     * 
     * By page content, we mean anything which is not rendered from layout built by UI->showHeader(); 
     *
     * @param string $pageId
     * @param array $pageData
     * @param OA_Admin_Template $oTpl
     * @return string HTML content to be injected before page content
     */
    public static function afterPageContent($pageId, $pageData, &$oTpl)
    {
        self::init();
        $oContext = new OX_Admin_UI_Event_EventContext(array(
            'pageId' => $pageId,
            'pageData' => $pageData,
            'oTpl'     => $oTpl
        )); 
        
        $aStrings = self::getDispatcher()->triggerEvent('afterPageContent', $oContext);   
        if (!empty($aStrings)) {
            $result = join('\n', $aStrings); 
        }

        return $result;              
    }
    
    
    /**
     * Registers callback to be invoked when 'beforePageContent' event occurs.
     * 
     * Callback will be passed an OX_Admin_UI_Event_EventContext object with the following
     * data:
     * 'pageId' - string menu section id of page being rendered 
     * 'pageData' => menu links parameter values (eg. clientid, campaignid etc.),
     * 'oTpl'     => instance of OA_Admin_Template being used to render page content 
     *      
     * @param PHP callback $callback
     */
    public static function registerAfterPageContentListener($callback)
    {
        self::getDispatcher()->register('afterPageContent', $callback);
    }

    
    /**
     * Retrieves an instance of event dispatcher
     *
     * @return OX_Admin_UI_Event_EventDispatcher
     */
    private static function getDispatcher()
    {
        $oDispatcher = OX_Admin_UI_Event_EventDispatcher::getInstance(); 
        
        
        return $oDispatcher;
    }
    
    
    //hack function
    private static function init()
    {
        if (self::$initialized) {
            return;
        }
        
        //register UI listeners from plugins
        $aPlugins = OX_Component::getListOfRegisteredComponentsForHook('registerUiListeners');
        foreach ($aPlugins as $i => $id) {
            if ($obj = OX_Component::factoryByComponentIdentifier($id)) {
                if(is_callable(array($obj, 'registerUiListeners'))) {
                    $obj->registerUiListeners();
                }
            }
        }
                
        self::$initialized = true;   
    }
}
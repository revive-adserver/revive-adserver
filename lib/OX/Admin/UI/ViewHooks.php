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

require_once MAX_PATH . '/lib/OX/Admin/UI/Hooks.php';

/**
 * A template hooks helper class used when rendering page to invoke specific listeners from within
 * Smarty template.
 */
class OX_Admin_UI_ViewHooks
{
    private $pageId;
    private $pageData;

    
    public function __construct($pageId, $pageData = null)
    {
        $this->pageId = $pageId;
        $this->pageData = $pageData;
    }
    

    /**
     * Register supported hooks on the view template.
     * In order to invoke listeners reacting on that hooks template must invoke
     * smarty functions.
     * 
     * Registered hooks:
     * {view_before_content}
     * {view_after_content}
     * 
     *
     * @param OA_Admin_Template $oTpl
     * @param string $pageId page identifier (is passed to listeners)
     * @param array $pageData any page data that should be passed to listeneres
     */
    public static function registerPageView(OA_Admin_Template $oTpl, $pageId, $pageData = null)
    {
        $oHooks = new self($pageId, $pageData);
        $oHooks->register($oTpl);
        
        return $oHooks;
    }
    
    
    /**
     * Register supported hooks on the view template.
     * In order to invoke listeners reacting on that hooks template must invoke
     * smarty functions.
     * 
     * Registered hooks:
     * {view_before_content}
     * {view_after_content}
     *
     * @param OA_Admin_Template $oTpl
     */
    protected function register(OA_Admin_Template $oTpl)
    {
        $oTpl->register_function('view_before_content', array($this, 'beforeContent'));
        $oTpl->register_function('view_after_content', array($this, 'afterContent'));
    }
    
    
    public function beforeContent($aParams, &$oTpl)
    {
        return OX_Admin_UI_Hooks::beforePageContent($this->pageId, $this->pageData, $oTpl);
    }
    
    
    public function afterContent($aParams, &$oTpl)
    {
        return OX_Admin_UI_Hooks::afterPageContent($this->pageId, $this->pageData, $oTpl);
    }
}
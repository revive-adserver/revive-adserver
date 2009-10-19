<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
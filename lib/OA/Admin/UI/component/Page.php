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
 * Base page object
 *
 */
class OA_Admin_UI_Page
{
    private $id;
    private $dispatcher;
    
    public function __construct($id)
    {
        $this->id = $id;
        $this->dispatcher = OA_Admin_Plugins_EventDispatcher::singleton();
    }
    
    
    /**
     * Creates a EventContext for this particular page
     * @return OA_Admin_Plugins_EventContext
     */
    protected function createPageContext()
    {
       $context = new OA_Admin_Plugins_EventContext();
       $context->pageId = $this->getId();

       return $context;
    }
    
    
    /**
     * Returns page id
     *
     * @return string page id
     */
    public function getId()
    {
        return $this->id;
    }
    
    
    /**
     * Return gloabl applicatin event dispatcher
     *
     * @return OA_Admin_Plugins_EventDispatcher
     */
    protected function getEventDispatcher()
    {
        return $this->dispatcher;
    }
}

?>

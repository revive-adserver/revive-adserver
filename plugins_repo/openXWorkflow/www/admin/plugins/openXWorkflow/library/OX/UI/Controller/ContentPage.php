<?php

/**
 * A base class for content page controllers, before dispatching actions, it computes
 * the menu content for the page being handled.
 */
class OX_UI_Controller_ContentPage extends OX_UI_Controller_Default
{
    /**
     * Key for the page-level message to be displayed on the page redirected to.
     */
    const PAGE_LOCAL_MESSAGE_CONTENT = 'pageLocalMessageContent';
    
    /**
     * Key for the type of page-level message to be displayed on the page redirected to.
     */
    const PAGE_LOCAL_MESSAGE_TYPE = 'pageLocalMessageType';
    
    /**
     * Key for the scope of page-level message to be displayed on the page redirected to.
     * Supported values: 'local', 'form'.
     */
    const PAGE_LOCAL_MESSAGE_SCOPE = 'pageLocalMessageScope';


    public function preDispatch()
    {
        parent::preDispatch();
        
        // Set default header
        $this->addHeader($this->view->section ? $this->view->section->getLabel() : 
            OX_UI_Menu_Section::DEFAULT_LABEL, $this->view->section ? $this->view->section->getIcon() : null);
    }


    /**
     * Redirects to the provided action/controller/module/params and displays the provided
     * message on the page that loaded after redirect. Please note that the provided message text needs to 
     * be escaped as appropriate.
     * 
     * @param $message OX_UI_Message|array if array is provided an OX_UI_Message_Text
     *                  will be created with the provided spec
     * @param $action action to redirect to
     * @param $controller controller to redirect to
     * @param $module module to redirect to
     * @param $params parms to redirect with
     */
    public function redirectWithPageLocalMessage($message, $action = null, 
            $controller = null, $module = null, 
            $params = array())
    {
        $this->redirectWithPayload(self::serializeMessage(self::getMessageFromSpec($message)), 
            $action, $controller, $module, $params);
    }


    /**
     * Redirects to the provided action/controller/module/params, displays the provided
     * message on the page that loaded after redirect. Also attaches the provided payload
     * on the view of the next page. Please note that the provided message text needs to 
     * be escaped as appropriate.
     * 
     * @param $message OX_UI_Message|array if array is provided an OX_UI_Message_Text
     *                  will be created with the provided spec. Please note that the provided 
     *                  message text needs to be escaped as appropriate.
     * @param $payload payload to pass to the next page
     * @param $action action to redirect to
     * @param $controller controller to redirect to
     * @param $module module to redirect to
     * @param $params parms to redirect with
     */
    public function redirectWithPageLocalMessageAndPayload($message, 
            array $payload = array(), $action = null, 
            $controller = null, $module = null, 
            $params = array())
    {
        self::serializeMessage(self::getMessageFromSpec($message), $payload);
        $this->redirectWithPayload($payload, $action, $controller, $module, $params);
    }

    
    /**
     * Serializes the provided message to the provided array.
     */
    private static function serializeMessage(OX_UI_Message $message, 
            &$array = array())
    {
        $array[self::PAGE_LOCAL_MESSAGE_CONTENT] = $message->render();
        $array[self::PAGE_LOCAL_MESSAGE_TYPE] = $message->getType();
        $array[self::PAGE_LOCAL_MESSAGE_SCOPE] = $message->getScope();
        return $array;
    }


    /**
     * Sets the message to be displayed on _this_ page. Note that this call does _not_
     * perform a redirect.
     * 
     * @param $message OX_UI_Message|array if array is provided an OX_UI_Message_Text
     * will be created with the provided spec. Please note that the provided 
     * message text needs to be escaped as appropriate.
     */
    public function setPageLocalMessage($spec)
    {
        $message = self::getMessageFromSpec($spec);
        $this->view->pageLocalMessageContent = $message->render();
        $this->view->pageLocalMessageType = $message->getType();
        $this->view->pageLocalMessageScope = $message->getScope();
    }
    
    
    /**
     * Checks if the local message has been set for _this_ page.
     * 
     * @return true if localMessage has been set for _this_ page
     */
    public function isSetPageLocalMessage()
    {
        return isset($this->view->pageLocalMessageContent);
    }

    
    
    /**
     * Converts a message spec to an OX_UI_Message instance.
     */    
    private static function getMessageFromSpec($spec)
    {
        if (is_array($spec)) {
            return new OX_UI_Message_Text($spec);
        } else {
            return $spec;
        }
    }
    

    /**
     * Adds a header to this page.
     *
     * @param mixed $titleOrHeader plain text title of this page or instance of
     * OX_UI_Page_Header
     * @param $icon Icon corresponding to the entity, e.g. 'Account'. The prefixes
     * ('icon') and suffixes ('Add', 'Large') will be added automatically.
     */
    protected function addHeader($titleOrHeader, $icon = null)
    {
        if ($titleOrHeader instanceof OX_UI_Page_Header) {
            $this->view->header = $titleOrHeader;
        }
        else {
            $this->view->header = new OX_UI_Page_Header($titleOrHeader, $icon);
        }
    }


    /**
     * Adds an action to this page.
     *
     * @param OX_UI_Menu_Shortcut $action
     */
    protected function addPageAction($action)
    {
        $actions = $this->view->pageActions;
        if (!is_array($this->view->pageActions)) {
            $actions = array ();
        }
        $actions[] = $action;
        $this->view->assign("pageActions", $actions);
    }


    /**
     * Adds a shortcut to this page.
     *
     * @param OX_UI_Menu_Shortcut $action
     */
    protected function addPageShortcut($action)
    {
        $actions = $this->view->pageShortcuts;
        if (!is_array($this->view->pageShortcuts)) {
            $actions = array ();
        }
        $actions[] = $action;
        $this->view->assign("pageShortcuts", $actions);
    }
    
    /**
     * Hides the gap reserved for page local message when there is no message
     * to display. If this method is not called, the gap will be kept, even if
     * there is no message to display in it.
     */
    protected function setHideEmptyThirdLevelTools($hideEmptyThirdLevelTools = true)
    {
        $this->view->hideEmptyThirdLevelTools = $hideEmptyThirdLevelTools;
    }
}

<?php

/**
 * The default base class for OX controllers. It sets current action, controller and module
 * names to the view. Also, it supports registering plugins that can perform application-specific
 * set up etc.
 */
class OX_UI_Controller_Default extends Zend_Controller_Action
{
    private static $plugins = array ();
    
    private $attrs = array ();


    public function init()
    {
        parent::init();
        
        $this->view->currentAction = $this->_request->getActionName();
        $this->view->currentController = $this->_request->getControllerName();
        $this->view->currentModule = $this->_request->getModuleName();
        
        foreach (self::$plugins as $plugin) {
            $plugin->postInit($this);
        }
    }


    public function preDispatch()
    {
        parent::preDispatch();
        
        // Unpack payload and assign to the view on the redirected page
        $store = new Zend_Session_Namespace("redirectMessage");
        $iter = $store->getIterator();
        foreach ($iter as $key => $val) {
            $this->view->assign($key, $val);
        }
        $store->unsetAll();
        
        foreach (self::$plugins as $plugin) {
            $plugin->preDispatch($this);
        }
    }


    public function postDispatch()
    {
        /**
         * We call a hook method that is called beforeRender() because in fact, 
         * because we're inheriting from Zend_Controller_Action, the hook will
         * indeed be called right before rendering. The beforeRender() name
         * probably better reflects what would happen than e.g. postDispatch(). 
         */
        foreach (self::$plugins as $plugin) {
            $plugin->beforeRender($this);
        }
        parent::postDispatch();
    }


    public function render($action = null, $name = null, $noController = false)
    {
        parent::render($action, $name, $noController);
    }


    public function forward($action, $controller = null, $module = null, $params = null)
    {
        $this->_forward($action, $controller, $module, $params);
    }

    
    /**
     * Redirects to the provided action/controller/module/params.
     */
    public function redirect($action = null, $controller = null, $module = null, $params = array())
    {
        if (!isset($action)) {
            $action = $this->getRequest()->getActionName();
        }
        
        $this->_helper->redirector->goto($action, $controller, $module, $params);
    }


    /**
     * Redirects to the provided action/controller/module/params and passes the payload
     * to the page that loaded after redirect. All values from payload will be set directly
     * on the view object of the page that loaded after redirect (see preDispatch()).
     */
    public function redirectWithPayload(array $payload, $action = null, $controller = null, 
            $module = null, $params = array())
    {
        $store = new Zend_Session_Namespace("redirectMessage");
        foreach ($payload as $key => $val) {
            $store->$key = $val;
        }
        
        $this->redirect($action, $controller, $module, $params);
    }
    
    
    public function getAttr($key)
    {
        if (isset($this->attrs[$key])) {
            return $this->attrs[$key];
        }
        else {
            return null;
        }
    }


    public function setAttr($key, $value)
    {
        if ($value === null) {
            unset($this->attrs[$key]);
        }
        else {
            $this->attrs[$key] = $value;
        }
    }


    public function __get($name)
    {
        return $this->getAttr($name);
    }


    public function __set($name, $value)
    {
        $this->setAttr($name, $value);
    }


    public static function registerPlugin(OX_UI_Controller_Plugin $plugin)
    {
        self::$plugins[] = $plugin;
    }


    public static function redirectRemovingParams(Zend_Controller_Request_Abstract $request, 
            Zend_Controller_Response_Abstract $response, 
            array $paramNamesToRemove = array())
    {
        $params = array_diff_key($request->getParams(), 
            array_fill_keys($paramNamesToRemove, true));
        unset($params[$request->getActionKey()]);
        unset($params[$request->getControllerKey()]);
        unset($params[$request->getModuleKey()]);
        $response->setRedirect(OX_UI_View_Helper_ActionUrl::actionUrl($request->getActionName(), 
            $request->getControllerName(), $request->getModuleName(), $params));
        self::fixRedirect($request);
    }
    
    
    public static function fixRedirect(Zend_Controller_Request_Abstract $request)
    {
        // There is no easy way to break the dispatch loop entirely so that
        // it does not invoke any actions (in particular the one that user
        // got redirected from). Instead, we'll forward the request to some
        // dummy action that will do nothing. The results of this action will
        // not be sent to the user anyway, because of the redirect we set
        // above.
        $request->setDispatched(true);
        $request->setActionName('dummy-redirect');
        $request->setControllerName('index');
        $request->setModuleName('default');
    }
    
    
    public function dummyRedirectAction()
    {
        $this->view->noViewScript();
        $this->_helper->layout->disableLayout();
    }


    /**
     * Disables the standard layout, useful in AJAX response handlers.
     */
    public function disableLayout()
    {
        $this->_helper->layout->disableLayout();
    }

    
    /**
     * Disables the view script look-up, outputs the provided replacement content. This
     * method is especially useful when writing handlers for AJAX requests.
     *
     * @param string $replacementContent replacement content to be rendered
     *                instead of the script, optional
     * @param boolean $disableLayout set to true, to disable the layout
     */    
    public function noViewScript($replacementContent = '', $disableLayout = false)
    {
        $this->view->noViewScript($replacementContent);
        if ($disableLayout)
        {
            $this->disableLayout();
        }
    }
    

    /**
     * Sets a specific view script name to be used for handling the current action. This
     * method may be useful to avoid duplication of view script files in cases when 
     * different actions have the same view script.
     *
     * @param string $viewScriptName name of the view script to render
     */
    public function setViewScript($viewScriptName)
    {
        $this->view->setViewScript($viewScriptName);
    }

    
    /**
     * Gets parameter from request and defaults it to a given value if parameter
     * is not set
     *
     * @param unknown_type $name of the parameter to get from request
     * @param unknown_type $default to set if param is null
     */
    public function getRequestParam($name, $default = null)
    {
        return OX_Common_ObjectUtils::getDefault(
            $this->getRequest()->getParam($name), $default);
    }
    
    
    /**
     * Shortcut to translate function. Translates the given string
     *
     * @param  string $messageId Translation string
     * @param  string|Zend_Locale $locale    (optional) Locale/Language to use, identical with locale
     *                                       identifier, 
     * @see Zend_Translate_Adapter
     * @return string
     */
    public function t($messageId, $aValues = null, $locale = null)
    {
        return $this->view->getHelper('t')->t($messageId, $aValues, $locale);
    }
}

<?php

/**
 * A helper that outputs a link to the page described by action, controller and module.
 */
class OX_UI_View_Helper_ActionUrl
{
    private static $aExtraParameters = array ();


    public static function actionUrl($action, $controller = null, $module = null, 
            array $params = null, $absolute = false)
    {
        $urlActionHelper = new Zend_Controller_Action_Helper_Url();
        if (empty($params)) {
            $params = array ();
        }
        
        if (!empty(self::$aExtraParameters)) {
            if ($params == null) {
                // We need to copy the extra parameters, otherwise, we'd
                // be modifying them with current call's params.
                $params = array_merge(self::$aExtraParameters);
            }
            else {
                // Give priority to the caller's params
                $params = array_merge(self::$aExtraParameters, $params);
            }
        }
        
        // We need to detect which route is handling the current request. If it's
        // Zend's standard Module route, we should use the simple() action url method
        // to build the URL. Otherwise, the would we're building would contain all the
        // parameters of the currently handled request (this is what the url() method
        // is doing).
        $router = Zend_Controller_Front::getInstance()->getRouter();
        $canUseSimple = ($router instanceof Zend_Controller_Router_Rewrite) && 
            ($router->getCurrentRoute() instanceof Zend_Controller_Router_Route_Module);
        
        $urlExtension = '';
        if ($canUseSimple) {
            $urlExtension = $urlActionHelper->simple($action, $controller, $module, $params);
        }
        else {
            $request = $urlActionHelper->getRequest();
            $params[$request->getModuleKey()] = OX_Common_ObjectUtils::getDefault($module, $request->getModuleName());
            $params[$request->getControllerKey()] = OX_Common_ObjectUtils::getDefault($controller, $request->getControllerName());
            $params[$request->getActionKey()] = OX_Common_ObjectUtils::getDefault($action, $request->getActionName());
            $urlExtension = $urlActionHelper->url($params);
        }
        
        return ($absolute ? self::getAbsoluteUrlPrefix() : '') . $urlExtension;
    }


    public static function getAbsoluteUrlPrefix()
    {
        $prefix = '';
        $server_port = (integer) $_SERVER['SERVER_PORT'];
        if (array_key_exists('HTTPS', $_SERVER) && (0 == strcmp($_SERVER['HTTPS'], 'on'))) {
            $prefix = 'https://' . $_SERVER['SERVER_NAME'];
            if (443 != $server_port) {
                $prefix .= ':' . $server_port;
            }
        }
        else {
            $prefix = 'http://' . $_SERVER['SERVER_NAME'];
            if (80 != $server_port) {
                $prefix .= ':' . $server_port;
            }
        }
        return $prefix;
    }


    public static function registerExtraParameter($key, $value)
    {
        self::$aExtraParameters[$key] = $value;
    }


    public static function unregisterExtraParameter($key)
    {
        unset(self::$aExtraParameters[$key]);
    }
}

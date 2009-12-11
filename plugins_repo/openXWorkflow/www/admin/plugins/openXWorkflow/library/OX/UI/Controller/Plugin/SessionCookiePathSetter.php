<?php

/**
 * Sets base path in session cookies so that there are no conflicts between the
 * applications running on the same domain (see: LIB-16).
 */
class OX_UI_Controller_Plugin_SessionCookiePathSetter extends Zend_Controller_Plugin_Abstract
{
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        if ($request instanceof Zend_Controller_Request_Http)
        {
            $basePath = $request->getBasePath();
            if (!empty($basePath))
            {
                Zend_Session::setOptions(array('cookie_path' => $basePath));
            }
        }
    }
}
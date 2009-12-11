<?php

interface OX_UI_Controller_Plugin_LoginListener
{
    /**
     * Invoked every time there is a need to authenticate a user. Should return
     * true if given request should be authenticated
     * 
     * @return boolean true if request should be authenticated
     * @param Zend_Controller_Request_Abstract $request
     */
    function shouldAuthenticate(Zend_Controller_Request_Abstract $request);


    /**
     * Invoked after user credentials have been successfully verified.
     *
     * @param Zend_Controller_Request_Abstract $request
     * @param Zend_Controller_Response_Abstract $response
     * @param $authenticatedUser object representing the user that has just authenticated 
     * or null. The actual type is application-specific.
     * @return true if the user should be allowed to access the system. If this method
     * returns false, the application will not log in the user, even though the credentials
     * were correct.
     */
    function afterAuthenticated(Zend_Controller_Request_Abstract $request, 
            Zend_Controller_Response_Abstract $response, 
            $authenticatedUser);


    /**
     * Invoked after successful authentication, but before a redirect to the authenticated
     * page is made. You can use this hook to change action, add or remove parameters from 
     * the redirected page.
     *
     * @param Zend_Controller_Request_Abstract $request
     * @param $authenticatedUser object representing the user that has just authenticated 
     * or null. The actual type is application-specific.
     */
    function beforeAuthenticatedRedirect(Zend_Controller_Request_Abstract $request, 
            $authenticatedUser);


    /**
     * Invoked after user identifier has been retrieved from the session. Either this methor
     * of afterAuthenticated() will be called but not both.
     *
     * @param Zend_Controller_Request_Abstract $request
     * @param Zend_Controller_Response_Abstract $response
     */
    function afterAuthenticationRetrieved(Zend_Controller_Request_Abstract $request, 
            Zend_Controller_Response_Abstract $response);
}


<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';
require_once MAX_PATH . '/lib/OA/Dashboard/Dashboard.php';

/** Protocol parameters as defined: https://staff.openads.org/wiki/DashboardSSO **/
define('OA_SSO_URL_PARAM', 'url');
define('OA_SSO_SERVICE_PARAM', 'service');
define('OA_SSO_BACK_URL_PARAM', 'backUr');

// CAS-server parameters
define('OA_SSO_CAS_SERVICE_PARAM', 'service');
define('OA_SSO_CAS_GATEWAY_PARAM', 'gateway');
define('OA_SSO_CAS_TICKET_PARAM', 'ticket');

// ssoProxy.php specific parameters
define('OA_SSO_CAS_SERVER_CHECK_PARAM', 'casServerCheck');

/**
 * The class to sign-in client into dashboard and cas-server
 *
 */
class OA_Dashboard_SsoProxy
{
    /** Path to OAP (without trailing slash) **/
    var $oapPath;
    
    /** Path to ssoProxy.php script in OAP **/
    var $ssoProxyPath;
    
    /** Path to dashboard ssoCheck path **/
    var $ssoCheckUrl;
    
    /** Path to cas login servlet **/
    var $casServerLoginUrl;
    
    /** OAP platform hash **/
    var $oapId;
    
    /** Widget or dashboard url where ssoProxy should authenticate user into **/
    var $url;
    
    /** Url to dashboard with appended platform hash and platform path **/
    var $dashboardTargetUrl;

    /** Parameters array, usually $_REQUEST **/
    var $aParams;
    
    /**
     * The class constructor
     *
     * @param array $aParams The parameters array, usually $_REQUEST
     * @return OA_Dashboard_Widget
     */
    function OA_Dashboard_SsoProxy($aParams)
    {
        $this->validate($aParams);
        $this->init($aParams);
        $this->checkAccess();
    }
    
    function init($aParams)
    {
        $this->aParams = $aParams;
        $aConf = $GLOBALS['_MAX']['CONF'];
        
        $this->oapPath = $this->removeTrailingSlash(MAX::constructURL(MAX_URL_ADMIN));
        $this->ssoProxyPath = $this->oapPath . '/ssoProxy.php';
        
        $this->ssoCheckUrl       = OA_Dashboard::buildUrl($aConf['oacDashboard'], 'ssoCheck');
        $this->casServerLoginUrl = OA_Dashboard::buildUrl($aConf['oacSSO']);
        
        $this->oapId = OA_Dal_ApplicationVariables::get('platform_hash');
        
        // A target url where user should be redirected to
        // this is url where ssoProxy.php is proxying user
        $this->url = $aParams[OA_SSO_URL_PARAM];
        $this->dashboardTargetUrl = $this->url . (strpos($this->url, '?') ? '&' : '?')
            . OA_SSO_PLATFORM_HASH_PARAM . '=' . $this->oapId
            . '&'. OA_SSO_PLATFORM_PATH_PARAM .'=' . $this->oapPath;
    }
    
    /**
     * Removes trailing slash from the url
     *
     * @param String $url  Url to remove last slash from
     * @return String
     */
    function removeTrailingSlash($url)
    {
        if (strrpos($url, '/') == (strlen($url) - 1)) {
            $url = substr($url, 0, strlen($url)-1);
        }
        return $url;
    }
    
    /**
     * A method to check for permissions to run SsoProxy
     *
     */
    function checkAccess()
    {
        MAX_Permission::checkAccess(phpAds_Admin);
    }
    
    /**
     * Validate request parameters
     *
     * @param unknown_type $aParams
     */
    function validate($aParams)
    {
        if (empty($aParams[OA_SSO_URL_PARAM])) {
            MAX::raiseError('URL pararameter is required but was empty');
            exit();
        }
    }
    
    /**
     * "ssoProxy.php" script sends request to "ssoCheck" servlet
     *    * if user is already authenticated request is redirected to "service" url -> STOP
     *    * if user is not authenticated "ssoCheck" redirects client to "backUrl"
     *      and pass back OA_SSO_DASHBOARD_CHECK_PARAM parameter
     */
    function redirectToSsoCheck()
    {
        if (!empty($this->aParams[OA_SSO_CAS_SERVER_CHECK_PARAM]))
        {
            return;
        }
        $backUrl = $this->ssoProxyPath 
            . '?'. OA_SSO_URL_PARAM . '=' . urlencode($this->url)
            . '&' . OA_SSO_DASHBOARD_CHECK_PARAM . '=1';
        
        $serviceUrl = $this->ssoProxyPath . '?'
            . OA_SSO_URL_PARAM . '=' . $this->url
            . '&' . OA_SSO_CAS_SERVER_CHECK_PARAM . '=1';
        $redirectToSsoGatewayUrl = $this->casServerLoginUrl . '?'
            . OA_SSO_CAS_SERVICE_PARAM . '=' . urlencode($serviceUrl)
            . '&' . OA_SSO_CAS_GATEWAY_PARAM . '=1';
        $redirectToSsoCheckUrl = $this->ssoCheckUrl 
            . '?'. OA_SSO_SERVICE_PARAM .'=' . urlencode($this->dashboardTargetUrl)
            . '&backUrl=' . urlencode($redirectToSsoGatewayUrl);
    
        MAX_header('Location: ' . $redirectToSsoCheckUrl);
        exit();
    }
    
    /**
     *   CAS-server returned the answer after we queried it with gateway parameter
     *   If user is authenticated, CAS-server appended a service "ticket" to URL
     *   in that case we redirect client to widget url and allow to handle dashboard
     *   cas client to handle rest
     *
     */
    function redirectToDashboard()
    {
        if (!empty($this->aParams[OA_SSO_CAS_SERVER_CHECK_PARAM]) 
            && !empty($this->aParams[OA_SSO_CAS_TICKET_PARAM]))
        {
            MAX_header('Location: ' . $this->dashboardTargetUrl);
            exit();
        }
    }

    function display()
    {
        $this->redirectToSsoCheck();
        $this->redirectToDashboard();
        
        // user is not signed-in yet and in that case we
        // should perform authentication using credentials stored in OAP database
        require(MAX_PATH.'/lib/OA/Dashboard/Widgets/IFrame.php');
        $oDashboard = new OA_Dashboard_Widget_Iframe($this->aParams);
        $oDashboard->setServiceUrl($this->dashboardTargetUrl);
        $oDashboard->display();
    }
}

?>
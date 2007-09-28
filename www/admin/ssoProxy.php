<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';

require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';

// all errors should be handled in such a way that user should see a message that dashboard is not available
// ?is it possible?

/** Protocol parameters as defined here: https://staff.openads.org/wiki/DashboardSSO **/
define('OA_SSO_PLATFORM_HASH_PARAM', 'oapId');
define('OA_SSO_PLATFORM_PATH_PARAM', 'oapPath');
define('OA_SSO_URL_PARAM', 'url');
define('OA_SSO_SERVICE_PARAM', 'service');
define('OA_SSO_BACK_URL_PARAM', 'backUr');

// ssoProxy.php specific parameters
// @TODO - upgrade these parameters in wiki documentation
define('OA_SSO_DASHBOARD_CHECK_PARAM', 'dashboardCheck');
define('OA_SSO_CAS_SERVER_CHECK_PARAM', 'casServerCheck');

// CAS-server parameters
define('OA_SSO_CAS_SERVICE_PARAM', 'service');
define('OA_SSO_CAS_GATEWAY_PARAM', 'gateway');
define('OA_SSO_CAS_TICKET_PARAM', 'ticket');

if (empty($_REQUEST[OA_SSO_URL_PARAM])) {
    MAX::raiseError('URL pararameter is required but was empty');
    exit();
}

// path to local ssoProxy.php script
$oapPath      = MAX::constructURL(MAX_URL_ADMIN);
if (strrpos($oapPath, '/') == (strlen($oapPath) - 1)) {
    $oapPath = substr($oapPath, 0, strlen($oapPath)-1);
}
$ssoProxyPath = $oapPath . '/ssoProxy.php';

// path to remote services (dashboard and cas sso)
$ssoCheckUrl       = 'http://localhost:8080/adnetworks/ssoCheck';
$casServerLoginUrl = 'https://login.openads.org:8443/sso/login';

$oapId = OA_Dal_ApplicationVariables::get('platform_hash');

// A target url where user should be redirected to
// this is url where ssoProxy.php is proxying user
$url = $_REQUEST[OA_SSO_URL_PARAM];
$dashboardTargetUrl = $url . (strpos($url, '?') ? '&' : '?')
    . OA_SSO_PLATFORM_HASH_PARAM . '=' . $oapId
    . '&'. OA_SSO_PLATFORM_PATH_PARAM .'=' . $oapPath;


if (empty($_REQUEST[OA_SSO_DASHBOARD_CHECK_PARAM])
    && empty($_REQUEST[OA_SSO_CAS_SERVER_CHECK_PARAM]))
{
    // "ssoProxy.php" script sends request to "ssoCheck" servlet
    //   * if user is already authenticated request is redirected to "service" url -> STOP
    //   * if user is not authenticated "ssoCheck" redirects client to "backUrl"
    //     and pass back OA_SSO_DASHBOARD_CHECK_PARAM parameter
    $backUrl = $ssoProxyPath 
        . '?'. OA_SSO_URL_PARAM . '=' . urlencode($url) 
        . '&' . OA_SSO_DASHBOARD_CHECK_PARAM . '=1';
    
    $redirectToSsoCheckUrl = $ssoCheckUrl 
        . '?'. OA_SSO_SERVICE_PARAM .'=' . urlencode($dashboardTargetUrl)
        . '&backUrl=' . urlencode($backUrl);

    MAX_header('Location: ' . $redirectToSsoCheckUrl);
    exit();
}

if (!empty($_REQUEST[OA_SSO_DASHBOARD_CHECK_PARAM]))
{
    // "ssoProxy.php" script needs to check if user is already logged to CAS-server. 
    // In order to do this it sends a "gateway" request to CAS-server
    // for more information on CAS protocol see: 
    // http://www.ja-sig.org/products/cas/overview/protocol/index.html
    $serviceUrl = $ssoProxyPath . '?'
        . OA_SSO_URL_PARAM . '=' . $url
        . '&' . OA_SSO_CAS_SERVER_CHECK_PARAM . '=1';
    
    $redirectToSsoGatewayUrl = $casServerLoginUrl . '?'
        . OA_SSO_CAS_SERVICE_PARAM . '=' . urlencode($serviceUrl)
        . '&' . OA_SSO_CAS_GATEWAY_PARAM . '=1';
    MAX_header('Location: ' . $redirectToSsoGatewayUrl);
    exit();
}

if (!empty($_REQUEST[OA_SSO_CAS_SERVER_CHECK_PARAM]) 
    && !empty($_GET[OA_SSO_CAS_TICKET_PARAM]))
{
    // CAS-server returned the answer after we queried it with gateway parameter
    // If user is authenticated, CAS-server appended a service "ticket" to URL
    // in that case we redirect client to widget url and allow to handle dashboard
    // cas client to handle rest
    MAX_header('Location: ' . $dashboardTargetUrl);
    exit();
}

// If any of above fails it means that user is not signed-in yet and in that case we
// should perform authentication using crednetials stored in OAP database
require(MAX_PATH.'/lib/OA/Dashboard/Widgets/IFrame.php');
$oDashboard = new OA_Dashboard_Widget_Iframe($_REQUEST);
$oDashboard->setServiceUrl($dashboardTargetUrl);
$oDashboard->display();

?>

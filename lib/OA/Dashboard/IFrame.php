<?php

require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';

class OA_Dashboard_Iframe
{
    function start()
    {
        $oTpl = new OA_Admin_Template('dashboard-iframe.html');

        $oTpl->assign('dashboardURL', MAX::constructURL(MAX_URL_ADMIN, 'dashboard.php?module=IFrame'));
        $oTpl->assign('ssoAdmin',     OA_Dal_ApplicationVariables::get('sso_admin'));
        $oTpl->assign('ssoPasswd',    OA_Dal_ApplicationVariables::get('sso_password'));
        $oTpl->assign('casLoginURL',  'https://login.openads.org/sso/login');
        $oTpl->assign('serviceURL',   'https://login.openads.org/account/account.auth');

        $oTpl->display();
    }
}

?>
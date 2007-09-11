<?php

class OA_Dashboard_Index
{
    function start()
    {
        phpAds_PageHeader("1.0");

        $oTpl = new OA_Admin_Template('dashboard-index.html');
        $oTpl->assign('dashboardURL', MAX::constructURL(MAX_URL_ADMIN, 'dashboard.php?module=IFrame'));

        $oTpl->display();

        phpAds_PageFooter();
    }
}

?>
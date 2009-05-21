<?php
require_once '../../../../init.php';
require_once '../../config.php';
require_once MAX_PATH . '/lib/OA/Admin/TemplatePlugin.php';

$urlIframe = "http://staging.openx.org/sites/all/themes/openx3/players/players-content.html";
// TEMPLATE
$oTpl = new OA_Plugin_Template('players.html', 'TODO title');
$oTpl->assign('urlIframe', $urlIframe);
phpAds_PageHeader("players-vast",'','../../');
$oTpl->display();
phpAds_PageFooter();

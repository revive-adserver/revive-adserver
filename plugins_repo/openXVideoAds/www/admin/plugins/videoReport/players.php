<?php
require_once '../../../../init.php';
require_once '../../config.php';
require_once MAX_PATH . '/lib/OA/Admin/TemplatePlugin.php';

$production = $GLOBALS['_MAX']['CONF']['debug']['production'];
$urlIframe = "./players-content.html";

// TEMPLATE
$oTpl = new OA_Plugin_Template('players.html', 'openXVideoAds');
$oTpl->assign('urlIframe', $urlIframe);
phpAds_PageHeader("players-vast",'','../../');
$oTpl->display();
phpAds_PageFooter();

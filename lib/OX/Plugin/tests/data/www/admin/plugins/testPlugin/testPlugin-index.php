<?php
require_once 'testPlugin-common.php';

phpAds_PageHeader("test-plugin-0",'','../../');

$oTpl = new OA_Plugin_Template('testPlugin.html','testPlugin');

$message = 'Test Plugin';
$oTpl->assign('message',$message);
$oTpl->display();

$dispatcher = OA_Admin_Plugins_EventDispatcher::singleton();
$context = new OA_Admin_Plugins_EventContext();
$context->pageId = 'test-plugin-0';
$context->templates = array();

$templates = $dispatcher->onAfterContent($context);

//process results
foreach ($templates as $oPluginTemplate)
{
    if (is_a($oPluginTemplate, 'Smarty')) {
        $oPluginTemplate->display();
    }
}

phpAds_PageFooter();

?>
<?php
require_once 'testPlugin-common.php';

$oTpl    = new OA_Plugin_Template('testPlugin.html','testPlugin');

if ( isset($_REQUEST['action']) &&
     isset($GLOBALS['_MAX']['CONF']['testPlugin'][$_REQUEST['action']])
    )
{

    $otestPluginTable = OA_Dal::factoryDO('testplugin_table');
    $otestPluginTable->testplugin_id = $GLOBALS['_MAX']['CONF']['testPlugin'][$_REQUEST['action']];
    $otestPluginTable->find(true);
    $message = $otestPluginTable->testplugin_desc;

    switch ($_REQUEST['action'])
    {
        case '1':
            phpAds_PageHeader("test-plugin-1",'','../../');
            $image   = 'testPlugin1.jpg';
            break;
        case '2':
            phpAds_PageHeader("test-plugin-2",'','../../');
            $image   = 'testPlugin1.jpg';
            break;
        case '3':
            phpAds_PageHeader("test-plugin-3",'','../../');
            $image   = 'testPlugin2.jpg';
            break;
    }
}
else
{
    $image   = '';
    $message = '';
}

$oTpl->assign('image',$image);
$oTpl->assign('message',$message);

$oTpl->display();


phpAds_PageFooter();

?>
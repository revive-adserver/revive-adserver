<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

/**
 * OpenX Plugin Builder
 */

require_once('oxPlugin-common.php');

phpAds_registerGlobalUnslashed(
                                'name',
                                'email',
                                'author',
                                'url',
                                'version',
                                'group',
                                'licence',
                                'description'
                              );

OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);
global $session;

$aVersion['major'] = 0;
$aVersion['minor'] = 0;
$aVersion['build'] = 1;
$aVersion['status'] = '-dev';
$aValues['name']          = ($name        ? $name        : $oTrans->translate("myPlugin"));
$aValues['email']         = ($email       ? $email       : $session['user']->aUser['email_address']);
$aValues['author']        = ($author      ? $author      : $session['user']->aUser['contact_name']);
$aValues['url']           = ($url         ? $url         : $GLOBALS['HTTP_SERVER_VARS']['HTTP_HOST']);
$aValues['licence']       = ($licence     ? $licence     : 'GPL');
$aValues['description']   = ($description ? $description : $oTrans->translate("My New Plugin"));
$aValues['group']         = ($group       ? $group       : array());
$aValues['version']       = ($version     ? $version     : $aVersion);

$form = buildForm();
if ($form->validate())
{
    $aMessages = processForm($form, $aValues);
}
else
{
    $form->setDefaults($aValues);
}

displayPage($form, $aMessages);

function &buildForm()
{
    global $oTrans;

    $form = new OA_Admin_UI_Component_Form("oxToolBoxForm", "POST", $_SERVER['SCRIPT_NAME'], null, array("enctype"=>"multipart/form-data"));
    $form->forceClientValidation(true);

    $form->addElement('header', 'header', $oTrans->translate("New Plugin"));

    $form->addElement('text', 'name'        , $oTrans->translate("Plugin Name"), array('class'=>'medium'));
    $form->addElement('text', 'email'       , $oTrans->translate("Author Email"));
    $form->addElement('text', 'author'      , $oTrans->translate("Author Name"));
    $form->addElement('text', 'url'         , $oTrans->translate("Author URL"));
    $form->addElement('text', 'licence'     , $oTrans->translate("Licence Info"));
    $form->addElement('text', 'description' , $oTrans->translate("Description"));
    $version['major']  = $form->createElement('text', 'version[major]', $oTrans->translate("Major"));
    $version['minor']  = $form->createElement('text', 'version[minor]', $oTrans->translate("Minor"));
    $version['build']  = $form->createElement('text', 'version[build]', $oTrans->translate("Build"));
    // for new plugins status is -dev only
    //$aStatus = array('-dev','-beta','-beta-rc');
    $aStatus = array('-dev'=>'-dev');
    $version['status'] = $form->createElement( 'select', 'version[status]', $oTrans->translate("Status"), $aStatus);
    //$version['rc']     = $form->createElement('text', 'version[rc]', 'rc#');
    $form->addGroup($version, 'version', $oTrans->translate("Version"), "", false);

    //$form->addElement('text', 'versionMajor', 'Version',  array('class'=>'small'));

    $aGroups = getExtensionList();
    foreach ($aGroups as $extension)
    {
        $group['name']   = $form->createElement('text'    , 'group['.$extension.'][groupname]', $oTrans->translate("Group Name"), array('class'=>'medium'));
        $group['schema']  = $form->createElement('checkbox', 'group['.$extension.'][schema]', $oTrans->translate("Has Schema"));
        $form->addGroup($group, 'group_'.$extension, $oTrans->translate("Extends %s",array($extension)), "", false);
    }
    $form->addElement('controls', 'form-controls');
    $form->addElement('submit'  , 'submit', $oTrans->translate("Submit"));
    return $form;
}

function displayPage($form, $aMessages = '')
{
    phpAds_PageHeader('devtools-plugins','','../../');

    $oTpl = new OA_Plugin_Template('oxPlugin.html', 'oxPlugin');
    //$oTpl->debugging = true;
    $oTpl->assign('aMessages', $aMessages);
    $oTpl->assign('form', $form->serialize());

    $oTpl->display();

    phpAds_PageFooter();
}

function processForm(&$form, $aPluginValues)
{
    global $pathPlugin, $pathPackages, $pathAdmin;

    $aPaths = $GLOBALS['_MAX']['CONF']['pluginPaths'];

    $varTmp = MAX_PATH.'/var/tmp/';
    if (!file_exists($varTmp))
    {
        mkdir($varTmp, 0777);
    }
    $pathPlugin = $varTmp.$aPluginValues['name'];
    if (!file_exists($pathPlugin))
    {
        mkdir($pathPlugin, 0777);
    }
    $pathPackages   = $pathPlugin.$aPaths['packages'];
    $pathAdmin      = $pathPlugin.$aPaths['admin'];

    require_once(LIB_PATH.'/Plugin/PluginManager.php');
    $oPluginManager = new OX_PluginManager();

    $aVersion                   = $aPluginValues['version'];
    $aPluginValues['date']      = date('Y-m-d');
    $aPluginValues['oxversion'] = VERSION;
    $aPluginValues['version']   = $aVersion['major'].'.'.$aVersion['minor'].'.'.$aVersion['build'].$aVersion['status'];
    $aGroupValues               = $aPluginValues['group'];
    unset($aPluginValues['group']);

    foreach ($aGroupValues as $extension => $aGroup)
    {
        if ($aGroup['groupname'])
        {
            $aVals                          = $aPluginValues;
            $aVals['extension']             = $extension;
            $aVals['name']                  = $aGroup['groupname'];
            $aVals['group']                 = $aGroup['groupname'];
            $aPluginValues['grouporder'][]  = $aGroup['groupname'];
            $oPluginManager->_decompressFile('etc/group.zip', $pathPackages.$aGroup['groupname']);

            $oBuilder = new OX_PluginBuilder_Group();
            if (isset($aGroup['schema']) && $aGroup['schema'])
            {
                $oBuilder->schema = true;
                $oPluginManager->_decompressFile('etc/schema.zip', $pathPackages.$aGroup['groupname']);
            }
            if ($extension=='admin')
            {
                $oPluginManager->_decompressFile('etc/admin.zip', $pathPlugin);
                rename($pathAdmin.'group', $pathAdmin.$aGroup['groupname']);
            }
            $oBuilder->init($aVals);
            $oBuilder->putGroup();
        }
    }
    $oPluginManager->_decompressFile('etc/plugin.zip', $pathPackages);
    $oBuilder = new OX_PluginBuilder_Package();
    $oBuilder->init($aPluginValues);
    $oBuilder->putPlugin();
    $aMessages[] = $aPluginValues['name'].' created in '.$pathPlugin;
    return $aMessages;
}

?>

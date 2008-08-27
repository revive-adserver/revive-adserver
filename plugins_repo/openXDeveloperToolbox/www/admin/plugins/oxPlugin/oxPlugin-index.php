<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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
/**
 * OpenX Plugin Builder
 *
 * @author     Monique Szpak <monique.szpak@openx.org>
 *
 * $Id$
 *
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
$aValues['name']          = ($name        ? $name        : 'myPlugin');
$aValues['email']         = ($email       ? $email       : $session['user']->aUser['email_address']);
$aValues['author']        = ($author      ? $author      : $session['user']->aUser['contact_name']);
$aValues['url']           = ($url         ? $url         : $GLOBALS['HTTP_SERVER_VARS']['HTTP_HOST']);
$aValues['licence']       = ($licence     ? $licence     : 'GPL');
$aValues['description']   = ($description ? $description : 'My New Plugin');
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
    $form = new OA_Admin_UI_Component_Form("oxToolBoxForm", "POST", $_SERVER['PHP_SELF'], null, array("enctype"=>"multipart/form-data"));
    $form->forceClientValidation(true);

    $form->addElement('header', 'header', "New Plugin");

    $form->addElement('text', 'name'        , 'Plugin Name', array('class'=>'medium'));
    $form->addElement('text', 'email'       , 'Author Email');
    $form->addElement('text', 'author'      , 'Author Name');
    $form->addElement('text', 'url'         , 'Author URL');
    $form->addElement('text', 'licence'     , 'Licence Info');
    $form->addElement('text', 'description' , 'Description');
    $version['major']  = $form->createElement('text', 'version[major]', 'Major');
    $version['minor']  = $form->createElement('text', 'version[minor]', 'Minor');
    $version['build']  = $form->createElement('text', 'version[build]', 'Build');
    // for new plugins status is -dev only
    //$aStatus = array('-dev','-beta','-beta-rc');
    $aStatus = array('-dev'=>'-dev');
    $version['status'] = $form->createElement( 'select', 'version[status]', 'Status', $aStatus);
    //$version['rc']     = $form->createElement('text', 'version[rc]', 'rc#');
    $form->addGroup($version, 'version', 'Version', "", false);

    //$form->addElement('text', 'versionMajor', 'Version',  array('class'=>'small'));

    $aGroups = getExtensionList();
    foreach ($aGroups as $extension)
    {
        $group['name']   = $form->createElement('text'    , 'group['.$extension.'][groupname]', 'Group Name ', array('class'=>'medium'));
        $group['schema']  = $form->createElement('checkbox', 'group['.$extension.'][schema]', 'Has Schema');
        $form->addGroup($group, 'group_'.$extension, 'Extends '.$extension, "", false);
    }
    $form->addElement('controls', 'form-controls');
    $form->addElement('submit'  , 'submit', 'Submit');
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
        mkdir($varTmp);
    }
    $pathPlugin = $varTmp.$aPluginValues['name'];
    if (!file_exists($pathPlugin))
    {
        mkdir($pathPlugin);
    }
    $pathPackages   = $pathPlugin.$aPaths['packages'];
    $pathAdmin      = $pathPlugin.$aPaths['admin'];

    require_once(LIB_PATH.'/Plugin/PluginManager.php');
    $oPluginManager = new OX_PluginManager();

    $aVersion                   = $aPluginValues['version'];
    $aPluginValues['date']      = date('Y-d-m');
    $aPluginValues['oxversion'] = OA_VERSION;
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
            if (isset($aGroup['schema']) && $aGroup['schema'])
            {
                $oPluginManager->_decompressFile('etc/schema.zip', $pathPackages.$aGroup['groupname']);
            }
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

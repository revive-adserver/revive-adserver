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

$aValues['name']          = ($name        ? $name        : 'myPlugin');
$aValues['email']         = ($email       ? $email       : 'me@mydomain.org');
$aValues['author']        = ($author      ? $author      : 'me');
$aValues['url']           = ($url         ? $url         : 'www.mydomain.org');
$aValues['version']       = ($version     ? $version     : '0.0.1-dev');
$aValues['licence']       = ($licence     ? $licence     : 'GPL');
$aValues['description']   = ($description ? $description : 'My New Plugin');
$aValues['group']         = ($group       ? $group       : '');

$form = buildForm();
if ($form->validate())
{
    processForm($form, $aValues);
}
else
{
    $form->setDefaults($aValues);
}

displayPage($form);

function &buildForm()
{
    $form = new OA_Admin_UI_Component_Form("oxToolBoxForm", "POST", $_SERVER['PHP_SELF'], null, array("enctype"=>"multipart/form-data"));
    $form->forceClientValidation(true);

    $form->addElement('header', 'header', "New Plugin");

    $form->addElement('text', 'name'        , 'Plugin Name');
    $form->addElement('text', 'email'       , 'Author Email');
    $form->addElement('text', 'author'      , 'Author Name');
    $form->addElement('text', 'url'         , 'Author URL');
    $form->addElement('text', 'licence'     , 'Licence Info');
    $form->addElement('text', 'description' , 'Description');
    $form->addElement('text', 'version'     , 'Version');

    $form->addElement('controls', 'form-controls');
    $form->addElement('submit'  , 'submit', 'Submit');

    /*$aGroups = getExtensionList();
    foreach ($aGroups as $extension)
    {
        $group['check']  = $form->createElement('checkbox', 'group['.$extension.']', null, '');
        $group['name']   = $form->createElement('text'    , 'group['.$extension.'][groupname]', null, 'Group Name');
        $form->addGroup($group, 'group_'.$extension, 'Extends '.$extension, "", false);
    }*/

    return $form;
}

function displayPage($form)
{
    phpAds_PageHeader('devtools-plugins','','../../');

    $oTpl = new OA_Plugin_Template('oxPlugin.html', 'oxPlugin');
    //$oTpl->debugging = true;
    $oTpl->assign('form', $form->serialize());

    $oTpl->display();

    phpAds_PageFooter();
}

function processForm(&$form, $aValues)
{
    global $pathPluginsTmp;
    $pathPluginsTmp = MAX_PATH.'/var/tmp'.$GLOBALS['_MAX']['CONF']['pluginPaths']['packages'];
    if (_fileMissing($pathPluginsTmp))
    {
        return false;
    }
    $aPluginValues = $aValues;
    $aPluginValues['date'] = date('Y-d-m');
    $aPluginValues['oxversion'] = OA_VERSION;
    $aGroupValues = $aPluginValues['group'];
    unset($aPluginValues['group']);

    if ($aGroupValues)
    {
        foreach ($aGroupValues as $name => $aVal)
        {
            $aVals = $aPluginValues;
            $aVals['extension'] = $name;
            $aVals['component'] = $aVal['componentname'];
            $aVals['group']     = $aVal['groupname'];
            $aPluginValues['grouporder'][] = $aVals['group'];
            putGroup($aVals);
        }
    }
    return putPlugin($aPluginValues);
}

?>

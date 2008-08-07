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
 *
 * @author {AUTHOR} {EMAIL}
 *
 * $Id$
 *
 */

require_once('{GROUP}-common.php');

phpAds_registerGlobalUnslashed(
                                'data1',
                                'data2',
                                'data3',
                                'data4'
                              );

OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);

$aValues['data1'] = ($data1 ? $data1 : 'value1');
$aValues['data2'] = ($data2 ? $data2 : 'value2');
$aValues['data3'] = ($data3 ? $data3 : 'value3');
$aValues['data4'] = ($data4 ? $data4 : 'value4');

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
    $form = new OA_Admin_UI_Component_Form("{GROUP}Form", "POST", $_SERVER['PHP_SELF'], null, array("enctype"=>"multipart/form-data"));
    $form->forceClientValidation(true);

    $form->addElement('header', 'header', "{GROUP}");

    $form->addElement('text', 'data1'       , 'Label 1');
    $form->addElement('text', 'data2'       , 'Label 2', array('class'=>'medium'));

    $group['data3']   = $form->createElement('text'    , 'group[data3]', 'Label 3');
    $group['data4']   = $form->createElement('text'    , 'group[data4]', 'Label 4');
    $form->addGroup($group, 'group_data', 'Group Data', "-", false);
    $form->addElement('controls', 'form-controls');
    $form->addElement('submit'  , 'submit', 'Submit');

    return $form;
}

function displayPage($form)
{
    phpAds_PageHeader('{GROUP}-menu-i','','../../');

    $oTpl = new OA_Plugin_Template('{GROUP}.html', '{GROUP}');
    //$oTpl->debugging = true;
    $oTpl->assign('form', $form->serialize());

    $oTpl->display();

    phpAds_PageFooter();
}

function processForm(&$form, $aPluginValues)
{
    // do stuff to the data
}

?>

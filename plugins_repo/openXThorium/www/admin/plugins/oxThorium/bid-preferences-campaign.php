<?php
/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
$Id$
*/

require_once 'bid-common.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';

/*-------------------------------------------------------*/
/* MAIN REQUEST PROCESSING                               */
/*-------------------------------------------------------*/
//build form
$marketplaceForm = buildForm($clientid, $campaignid);

if ($marketplaceForm->validate()) {
    //process submitted values
    processForm($marketplaceForm);
}
displayPage($clientId, $campaignId, $marketplaceForm);


/*-------------------------------------------------------*/
/* Build form                                            */
/*-------------------------------------------------------*/
function buildForm($clientId, $campaignId)
{
    $form = new OA_Admin_UI_Component_Form("campaignmplaceform", "POST", $_SERVER['PHP_SELF']);
    $form->forceClientValidation(true);

    $form->addElement('hidden', 'clientid', $clientId);
    $form->addElement('hidden', 'campaignid', $campaignId);
    $form->addElement('advcheckbox', 'enable_mplace', null, 'Yes, allow this campaign to be challenged by MarketPlace', null, array("f", "t"));
    $form->addElement('text', 'floor_price', 'Campaign floor price', array('class' => 'x-small', 'style' => "margin-left: 5px;"));


    //Form validation rules
    $translation = new OA_Translation();
    $requiredMsg = $translation->translate($GLOBALS['strXRequiredField'], array('Campaign floor price'));
    $form->addRule('floor_price', $requiredMsg, 'required');    
    
    $aDefaults = array('enable_mplace' => 't', 'floor_price' => '5.5');
    //set form  values
    $form->setDefaults($aDefaults); //here we set current values of floor price and if campaign is enabled for marketplace 
    return $form;
}


/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/
function processForm($form)
{
    $aFields = $form->exportValues(); //this contains submitted values
    
    //this function is invoked only if validation was successful    
}


/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
function displayPage($clientId, $campaignId, $form)
{
    phpAds_PageHeader("bid-preferences-campaign",'','../../');
    $oTpl = new OA_Plugin_Template('bid-preferences-campaign.html','bidService');
    $oTpl->assign('form', $form->serialize());
    $oTpl->display();
    phpAds_PageFooter();
}







?>
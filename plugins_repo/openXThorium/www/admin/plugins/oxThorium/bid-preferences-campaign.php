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
/* SECURITY CHECK                                        */
/*-------------------------------------------------------*/


/*-------------------------------------------------------*/
/* MAIN REQUEST PROCESSING                               */
/*-------------------------------------------------------*/
//build form
$marketplaceForm = buildForm($clientid, $campaignid);

if ($marketplaceForm->validate()) {
    //process submitted values
    processForm($marketplaceForm, $campaignId);
}
displayPage($clientId, $campaignId, $marketplaceForm);


/*-------------------------------------------------------*/
/* Build form                                            */
/*-------------------------------------------------------*/
function buildForm($clientId, $campaignId)
{
    $oExt_thorium_campaign_pref = OA_Dal::factoryDO('ext_thorium_campaign_pref');
    $aFields = array(
        'is_enabled' => 'f',
        'floor_price' => 0.1,
    );
    if ($oExt_thorium_campaign_pref->get($campaignId)) {
        $aFields = array(
            'is_enabled' => $oExt_thorium_campaign_pref->is_enabled ? 't' : 'f',
            'floor_price' => $oExt_thorium_campaign_pref->floor_price,
        );
    }

    $form = new OA_Admin_UI_Component_Form("campaignmplaceform", "POST", $_SERVER['PHP_SELF']);
    $form->forceClientValidation(true);

    $form->addElement('hidden', 'clientid', $clientId);
    $form->addElement('hidden', 'campaignid', $campaignId);
    $form->addElement('advcheckbox', 'is_enabled', null, 'Yes, allow this campaign to be challenged by MarketPlace', null, array("f", "t"));
    $form->addElement('text', 'floor_price', 'Campaign floor price', array('class' => 'x-small', 'style' => "margin-left: 5px;"));


    //Form validation rules
    $translation = new OA_Translation();
    $requiredMsg = $translation->translate($GLOBALS['strXRequiredField'], array('Campaign floor price'));
    $form->addRule('floor_price', $requiredMsg, 'required');

    $form->setDefaults($aFields);
    return $form;
}


/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/
function processForm($form)
{
    $aFields = $form->exportValues();
    $oExt_thorium_campaign_pref = OA_Dal::factoryDO('ext_thorium_campaign_pref');
    $oExt_thorium_campaign_pref->campaignid = $aFields['campaignid'];
    $recordExist = false;
    if ($oExt_thorium_campaign_pref->find()) {
        $oExt_thorium_campaign_pref->fetch();
        $recordExist = true;
    }
    $oExt_thorium_campaign_pref->is_enabled = $aFields['is_enabled'] == 't' ? 1 : 0;
    $oExt_thorium_campaign_pref->floor_price = $aFields['floor_price'];
    if ($recordExist) {
        $oExt_thorium_campaign_pref->update();
    } else {
        $oExt_thorium_campaign_pref->insert();
    }
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
<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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
$Id$
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/max/other/common.php';
require_once MAX_PATH . '/lib/max/other/capping/lib-capping.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/component/Form.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-maintenance-priority.inc.php';
require_once MAX_PATH . '/lib/pear/Date.php';
require_once MAX_PATH . '/lib/OA/Admin/NumberFormat.php';
require_once MAX_PATH . '/lib/OX/Util/Utils.php';

require_once LIB_PATH . '/Admin/Redirect.php';

// Register input variables
phpAds_registerGlobalUnslashed ( 'start', 'startSet', 'anonymous', 'campaignname', 'clicks', 'companion', 'comments', 'conversions', 'end', 'endSet', 'priority', 'high_priority_value', 'revenue', 'revenue_type', 'submit', 'submit_status', 'target_old', 'target_type_old', 'target_value', 'target_type', 'rd_impr_bkd', 'rd_click_bkd', 'rd_conv_bkd', 'impressions', 'weight_old', 'weight', 'clientid', 'status', 'status_old', 'as_reject_reason', 'an_status', 'previousimpressions', 'previousconversions', 'previousclicks' );

// Security check
OA_Permission::enforceAccount ( OA_ACCOUNT_MANAGER );
OA_Permission::enforceAccessToObject ( 'clients', $clientid );
OA_Permission::enforceAccessToObject ( 'campaigns', $campaignid, true );

/*-------------------------------------------------------*/
/* Initialise data                                    */
/*-------------------------------------------------------*/
if ($campaignid != "") {
    // Edit or Convert
    // Fetch exisiting settings
    // Parent setting for converting, campaign settings for editing
    if ($campaignid != "") {
        $ID = $campaignid;
    }

    // Get the campaign data from the campaign table, and store in $campaign
    $doCampaigns = OA_Dal::factoryDO ( 'campaigns' );
    $doCampaigns->selectAdd ( "views AS impressions" );
    $doCampaigns->get ( $ID );
    $data = $doCampaigns->toArray ();

    $campaign ['campaignname'] = $data ['campaignname'];
    $campaign ['impressions'] = $data ['impressions'];
    $campaign ['clicks'] = $data ['clicks'];
    $campaign ['conversions'] = $data ['conversions'];
    $campaign ['expire'] = $data ['expire'];
    if (OA_Dal::isValidDate ( $data ['expire'] )) {
        $oExpireDate = new Date ( $data ['expire'] );
        $campaign ['expire_f'] = $oExpireDate->format ( $date_format );
        $campaign ['expire_dayofmonth'] = $oExpireDate->format ( '%d' );
        $campaign ['expire_month'] = $oExpireDate->format ( '%m' );
        $campaign ['expire_year'] = $oExpireDate->format ( '%Y' );
    }
    $campaign ['status'] = $doCampaigns->status;
    $campaign ['an_status'] = $doCampaigns->an_status;
    $campaign ['as_reject_reason'] = $doCampaigns->as_reject_reason;

    if (OA_Dal::isValidDate ( $data ['activate'] )) {
        $oActivateDate = new Date ( $data ['activate'] );
        $campaign ['activate_f'] = $oActivateDate->format ( $date_format );
        $campaign ['activate_dayofmonth'] = $oActivateDate->format ( '%d' );
        $campaign ['activate_month'] = $oActivateDate->format ( '%m' );
        $campaign ['activate_year'] = $oActivateDate->format ( '%Y' );
    }
    $campaign ['priority'] = $data ['priority'];
    $campaign ['weight'] = $data ['weight'];
    $campaign ['target_impression'] = $data ['target_impression'];
    $campaign ['target_click'] = $data ['target_click'];
    $campaign ['target_conversion'] = $data ['target_conversion'];
    $campaign ['anonymous'] = $data ['anonymous'];
    $campaign ['companion'] = $data ['companion'];
    $campaign ['comments'] = $data ['comments'];
    $campaign ['revenue'] = OA_Admin_NumberFormat::formatNumber ( $data ['revenue'], 4 );
    $campaign ['revenue_type'] = $data ['revenue_type'];
    $campaign ['block'] = $data ['block'];
    $campaign ['capping'] = $data ['capping'];
    $campaign ['session_capping'] = $data ['session_capping'];
    $campaign ['impressionsRemaining'] = '';
    $campaign ['clicksRemaining'] = '';
    $campaign ['conversionsRemaining'] = '';

    $campaign ['impressionsRemaining'] = '';
    $campaign ['clicksRemaining'] = '';
    $campaign ['conversionsRemaining'] = '';

    // Get the campagin data from the data_intermediate_ad table, and store in $campaign
    if (($campaign ['impressions'] >= 0) || ($campaign ['clicks'] >= 0) || ($campaign ['conversions'] >= 0)) {
        $dalData_intermediate_ad = OA_Dal::factoryDAL ( 'data_intermediate_ad' );
        $record = $dalData_intermediate_ad->getDeliveredByCampaign ( $campaignid );
        $data = $record->toArray ();

        $campaign ['impressionsRemaining'] = ($campaign ['impressions']) ? ($campaign ['impressions'] - $data ['impressions_delivered']) : '';
        $campaign ['clicksRemaining'] = ($campaign ['clicks']) ? ($campaign ['clicks'] - $data ['clicks_delivered']) : '';
        $campaign ['conversionsRemaining'] = ($campaign ['conversions']) ? ($campaign ['conversions'] - $data ['conversions_delivered']) : '';

        $campaign ['impressions_delivered'] = $data ['impressions_delivered'];
        $campaign ['clicks_delivered'] = $data ['clicks_delivered'];
        $campaign ['conversions_delivered'] = $data ['conversions_delivered'];
    }

    // Get the value to be used in the target_value field
    if ($campaign ['target_impression'] > 0) {
        $campaign ['target_value'] = $campaign ['target_impression'];
        $campaign ['target_type'] = 'target_impression';
    } elseif ($campaign ['target_click'] > 0) {
        $campaign ['target_value'] = $campaign ['target_click'];
        $campaign ['target_type'] = 'target_click';
    } elseif ($campaign ['target_conversion'] > 0) {
        $campaign ['target_value'] = $campaign ['target_conversion'];
        $campaign ['target_type'] = 'target_conversion';
    } else {
        $campaign ['target_value'] = '-';
        $campaign ['target_type'] = 'target_impression';
    }

    if ($campaign ['target_value'] > 0) {
        $campaign ['weight'] = '-';
    } else {
        $campaign ['target_value'] = '-';
    }

    // Set default activation settings
    if (! isset ( $campaign ["activate_dayofmonth"] )) {
        $campaign ["activate_dayofmonth"] = 0;
    }
    if (! isset ( $campaign ["activate_month"] )) {
        $campaign ["activate_month"] = 0;
    }
    if (! isset ( $campaign ["activate_year"] )) {
        $campaign ["activate_year"] = 0;
    }
    if (! isset ( $campaign ["activate_f"] )) {
        $campaign ["activate_f"] = "-";
    }

    // Set default expiration settings
    if (! isset ( $campaign ["expire_dayofmonth"] )) {
        $campaign ["expire_dayofmonth"] = 0;
    }
    if (! isset ( $campaign ["expire_month"] )) {
        $campaign ["expire_month"] = 0;
    }
    if (! isset ( $campaign ["expire_year"] )) {
        $campaign ["expire_year"] = 0;
    }
    if (! isset ( $campaign ["expire_f"] )) {
        $campaign ["expire_f"] = "-";
    }

    // Set the default financial information
    if (! isset ( $campaign ['revenue'] )) {
        $campaign ['revenue'] = OA_Admin_NumberFormat::formatNumber ( 0, 4 );
    }

} else {
    // New campaign
    $doClients = OA_Dal::factoryDO ( 'clients' );
    $doClients->clientid = $clientid;
    $client = $doClients->toArray ();

    if ($doClients->find () && $doClients->fetch () && $client = $doClients->toArray ()) {
        $campaign ['campaignname'] = $client ['clientname'] . ' - ';
    } else {
        $campaign ["campaignname"] = '';
    }

    $campaign ["campaignname"] .= $strDefault . " " . $strCampaign;
    $campaign ["impressions"] = '';
    $campaign ["clicks"] = '';
    $campaign ["conversions"] = '';
    $campaign ["status"] = ( int ) $status;
    $campaign ["expire"] = '';
    $campaign ["activate"] = '';
    $campaign ["priority"] = 0;
    $campaign ["anonymous"] = ($pref ['gui_campaign_anonymous'] == 't') ? 't' : '';
    $campaign ['revenue'] = OA_Admin_NumberFormat::formatNumber ( 0, 4 );
    ;
    $campaign ['revenue_type'] = null;
    $campaign ['target_value'] = '-';
    $campaign ['impressionsRemaining'] = null;
    $campaign ['clicksRemaining'] = null;
    $campaign ['conversionsRemaining'] = null;
    $campaign ['companion'] = null;
    $campaign ['block'] = null;
    $campaign ['capping'] = null;
    $campaign ['session_capping'] = null;
    $campaign ['comments'] = null;
    $campaign ['target_type'] = null;
}

if ($campaign ['status'] == OA_ENTITY_STATUS_RUNNING && OA_Dal::isValidDate ( $campaign ['expire'] ) && $campaign ['impressions'] > 0) {
    $campaign ['delivery'] = 'auto';
} elseif ($campaign ['target_value'] > 0) {
    $campaign ['delivery'] = 'manual';
} else {
    $campaign ['delivery'] = 'none';
}

$campaign ['clientid'] = $clientid;
$campaign ['campaignid'] = $campaignid;

/*-------------------------------------------------------*/
/* MAIN REQUEST PROCESSING                               */
/*-------------------------------------------------------*/
//build campaign form


//var_dump($campaign);


$campaignForm = buildCampaignForm ( $campaign );

if (! empty ( $campaign ['campaignid'] ) && defined ( 'OA_AD_DIRECT_ENABLED' ) && OA_AD_DIRECT_ENABLED === true) {
    //campaign status form
    $statusForm = buildStatusForm ( $campaign );
}

if ($campaignForm->isSubmitted () && $campaignForm->validate ()) {
    //process submitted values
    $errors = processCampaignForm ( $campaignForm );
    if (! empty ( $errors )) { //need to redisplay page with general errors
        displayPage ( $campaign, $campaignForm, $statusForm, $campaignErrors );
    }
} else if (! empty ( $campaign ['campaignid'] ) && defined ( 'OA_AD_DIRECT_ENABLED' ) && OA_AD_DIRECT_ENABLED === true && $statusForm->isSubmitted () && $statusForm->validate ()) {
    processStatusForm ( $statusForm );
} else { //either validation failed or no form was not submitted, display the page
    displayPage ( $campaign, $campaignForm, $statusForm );
}

/*-------------------------------------------------------*/
/* Build form                                            */
/*-------------------------------------------------------*/
function buildCampaignForm($campaign)
{
    global $pref;

    $form = new OA_Admin_UI_Component_Form ( "campaignform", "POST", $_SERVER ['PHP_SELF'] );
    $form->forceClientValidation ( true );
    $form->addElement ( 'hidden', 'campaignid', $campaign ['campaignid'] );
    $form->addElement ( 'hidden', 'clientid', $campaign ['clientid'] );
    $form->addElement ( 'hidden', 'expire', $campaign ['expire'] );
    $form->addElement ( 'hidden', 'target_old', isset ( $campaign ['target_value'] ) ? ( int ) $campaign ['target_value'] : 0 );
    $form->addElement ( 'hidden', 'target_type_old', isset ( $campaign ['target_type'] ) ? $campaign ['target_type'] : '' );
    $form->addElement ( 'hidden', 'weight_old', isset ( $campaign ['weight'] ) ? ( int ) $campaign ['weight'] : 0 );
    $form->addElement ( 'hidden', 'status_old', isset ( $campaign ['status'] ) ? ( int ) $campaign ['status'] : 1 );
    $form->addElement ( 'hidden', 'previousweight', isset ( $campaign ["weight"] ) ? $campaign ["weight"] : '' );
    $form->addElement ( 'hidden', 'previoustarget', isset ( $campaign ["target"] ) ? $campaign ["target"] : '' );
    $form->addElement ( 'hidden', 'previousactive', isset ( $campaign ["active"] ) ? $campaign ["active"] : '' );
    $form->addElement ( 'hidden', 'previousimpressions', isset ( $campaign ["impressions"] ) ? $campaign ["impressions"] : '' );
    $form->addElement ( 'hidden', 'previousclicks', isset ( $campaign ["clicks"] ) ? $campaign ["clicks"] : '' );
    $form->addElement ( 'hidden', 'previousconversions', isset ( $campaign ["conversions"] ) ? $campaign ["conversions"] : '' );

    //campaign inactive note (if any)
    if (isset ( $campaign ['status'] ) && $campaign ['status'] != OA_ENTITY_STATUS_RUNNING) {
        $aReasons = getCampaignInactiveReasons ( $campaign );
        $form->addElement ( 'custom', 'campaign-inactive-note', null, array ('inactiveReason' => $aReasons ), false );
    }

    //form sections
    $newCampaign = empty ( $campaign ['campaignid'] );

    buildBasicInformationFormSection ( $form, $campaign, $newCampaign );
    buildDateFormSection ( $form, $campaign, $newCampaign );
    buildPricingFormSection ( $form, $campaign, $newCampaign );
    buildHighPriorityFormSection ( $form, $campaign, $newCampaign );
    buildLowAndExclusivePriorityFormSection ( $form, $campaign, $newCampaign );
    buildDeliveryCappingFormSection ( $form, $GLOBALS ['strCappingCampaign'], $campaign, null, null, false, $newCampaign );
    buildMiscFormSection ( $form, $campaign, $newCampaign );

    //form controls
    $form->addElement ( 'controls', 'form-controls' );
    $form->addElement ( 'submit', 'submit', $GLOBALS ['strSaveChanges'] );

    //validation rules
    $translation = new OA_Translation ( );
    $nameRequiredMsg = $translation->translate ( $GLOBALS ['strXRequiredField'], array ($GLOBALS ['strName'] ) );
    $form->addRule ( 'campaignname', $nameRequiredMsg, 'required' );

    $typeRequiredMsg = $translation->translate ( $GLOBALS ['strXRequiredField'], array ($GLOBALS ['strCampaignType'] ) );
    //TODO$form->addRule('campaign_type', $typeRequiredMsg, 'required');


    $typeRequiredMsg = $translation->translate ( $GLOBALS ['strXRequiredField'], array ($GLOBALS ['strPricingModel'] ) );
    $form->addRule ( 'revenue_type', $typeRequiredMsg, 'required' );

    // Get unique campaignname
    $doCampaigns = OA_Dal::factoryDO ( 'campaigns' );
    $doCampaigns->clientid = $campaign ['clientid'];
    $aUnique_names = $doCampaigns->getUniqueValuesFromColumn ( 'campaignname', empty ( $campaign ['campaignid'] ) ? '' : $campaign ['campaignname'] );
    $nameUniqueMsg = $translation->translate ( $GLOBALS ['strXUniqueField'], array ($GLOBALS ['strCampaign'], strtolower ( $GLOBALS ['strName'] ) ) );
    $form->addRule ( 'campaignname', $nameUniqueMsg, 'unique', $aUnique_names );

    //  $form->addRule('impressions', 'TODO message', 'formattedNumber');
    //  $form->addRule('clicks', 'TODO message', 'formattedNumber');
    //    if ($conf['logging']['trackerImpressions']) {
    //      $form->addRule('conversions', 'TODO message', 'formattedNumber');
    //    }
    //  $form->addRule('weight', 'TODO message', 'wholeNumber-');
    //  $form->addRule('target_value', 'TODO message', 'wholeNumber-');


    //set form values
    $form->setDefaults ( $campaign );

    $form->setDefaults ( array ('impressions' => ! isset ( $campaign ['impressions'] ) || $campaign ['impressions'] == '' || $campaign ['impressions'] < 0 ? '-' : $campaign ['impressions'], 'clicks' => ! isset ( $campaign ['clicks'] ) || $campaign ['clicks'] == '' || $campaign ['clicks'] < 0 ? '-' : $campaign ['clicks'], 'conversions' => ! isset ( $campaign ['conversions'] ) || $campaign ['conversions'] == '' || $campaign ['conversions'] < 0 ? '-' : $campaign ['conversions'] ) );

    $startDateSet = ($campaign ["activate_dayofmonth"] == 0 && $campaign ["activate_month"] == 0 && $campaign ["activate_year"] == 0) ? 'f' : 't';
    $endDateSet = ($campaign ["expire_dayofmonth"] == 0 && $campaign ["expire_month"] == 0 && $campaign ["expire_year"] == 0) ? 'f' : 't';

    if ($startDateSet == "t") {
        $oStartDate = new Date ( $campaign ["activate_year"] . '-' . $campaign ["activate_month"] . '-' . $campaign ["activate_dayofmonth"] );
    }
    $startDateStr = is_null ( $oStartDate ) ? '' : $oStartDate->format ( '%d %B %Y ' );
    if ($endDateSet == "t") {
        $oEndDate = new Date ( $campaign ["expire_year"] . '-' . $campaign ["expire_month"] . '-' . $campaign ["expire_dayofmonth"] );
    }
    $endDateStr = is_null ( $oEndDate ) ? '' : $oEndDate->format ( '%d %B %Y ' );

    $form->setDefaults ( array ('campaign_type' => $newCampaign ? '' : OX_Util_Utils::getCampaignType ( $campaign ['priority'] ), 'impr_unlimited' => (! empty ( $campaign ["impressions"] ) && $campaign ["impressions"] >= 0 ? 'f' : 't'), 'click_unlimited' => (! empty ( $campaign ["clicks"] ) && $campaign ["clicks"] >= 0 ? 'f' : 't'), 'conv_unlimited' => (! empty ( $campaign ["conversions"] ) && $campaign ["conversions"] >= 0 ? 'f' : 't'), 'startSet' => $startDateSet, 'endSet' => $endDateSet, 'start' => $startDateStr, 'end' => $endDateStr, 'priority' => ($campaign ['priority'] > '0' && $campaign ['campaignid'] != '') ? 2 : $campaign ['priority'], 'high_priority_value' => $campaign ['priority'] > '0' ? $campaign ['priority'] : 5, 'target_value' => ! empty ( $campaign ['target_value'] ) ? $campaign ['target_value'] : '-', 'weight' => isset ( $campaign ["weight"] ) ? $campaign ["weight"] : $pref ['default_campaign_weight'], 'revenue_type' => isset ( $campaign ["revenue_type"] ) ? $campaign ["revenue_type"] : MAX_FINANCE_CPM ) );

    return $form;
}

function buildBasicInformationFormSection(&$form, $campaign, $newCampaign)
{
    $form->addElement ( 'header', 'h_basic_info', $GLOBALS ['strBasicInformation'] );

    $form->addElement ( 'text', 'campaignname', $GLOBALS ['strName'] );

    //block type change - allow for new campaigns only
    if ($newCampaign) {
        $priority_h [] = $form->createElement ( 'radio', 'campaign_type', null, "<span class='type-name'>" . $GLOBALS ['strStandardContract'] . "</span>", OX_CAMPAIGN_TYPE_CONTRACT_NORMAL, array ('id' => 'priority-h' ) );
        $priority_h [] = $form->createElement ( 'custom', 'campaign-type-note', null, array ('radioId' => 'priority-h', 'infoKey' => 'StandardContractInfo' ) );

        $priority_e [] = $form->createElement ( 'radio', 'campaign_type', null, "<span class='type-name'>" . $GLOBALS ['strExclusiveContract'] . "</span>", OX_CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE, array ('id' => 'priority-e' ) );
        $priority_e [] = $form->createElement ( 'custom', array ('excl-limit-both-set-note', 'campaign-date-limit-both-set-note' ), null, null, false );
        $form->addDecorator ( 'excl-limit-both-set-note', 'tag', array ('attributes' => array ('id' => 'excl-limit-date-both-set', 'class' => 'hide' ) ) );
        $priority_e [] = $form->createElement ( 'custom', 'campaign-type-note', null, array ('radioId' => 'priority-e', 'infoKey' => 'ExclusiveContractInfo' ) );

        $priority_l [] = $form->createElement ( 'radio', 'campaign_type', null, "<span class='type-name'>" . $GLOBALS ['strRemnant'] . "</span>", OX_CAMPAIGN_TYPE_REMNANT, array ('id' => 'priority-l' ) );
        $priority_l [] = $form->createElement ( 'custom', array ('low-limit-both-set-note', 'campaign-date-limit-both-set-note' ), null, null, false );
        $form->addDecorator ( 'low-limit-both-set-note', 'tag', array ('attributes' => array ('id' => 'low-limit-date-both-set', 'class' => 'hide' ) ) );

        $priority_l [] = $form->createElement ( 'custom', 'campaign-type-note', null, array ('radioId' => 'priority-l', 'infoKey' => 'RemnantInfo' ) );

        $typeG [] = $form->createElement ( 'group', 'g_priority_h', null, $priority_h, null, false );
        $typeG [] = $form->createElement ( 'group', 'g_priority_e', null, $priority_e, null, false );
        $typeG [] = $form->createElement ( 'group', 'g_priority_l', null, $priority_l, null, false );
        $form->addGroup ( $typeG, 'g_ctype', $GLOBALS ['strCampaignType'], "" );

        $translation = new OA_Translation ( );
        $typeRequiredMsg = $translation->translate ( $GLOBALS ['strXRequiredField'], array ($GLOBALS ['strCampaignType'] ) );
        //        $form->addGroupRule('g_ctype', $typeRequiredMsg, 'required', null, 1);


    //        $form->addGroupRule('g_ctype', array(
    //            'campaign_type' => array(
    //                array($typeRequiredMsg, 'required')
    //            )
    //        ));
    } else {
        $type = OX_Util_Utils::getCampaignType ( $campaign ['priority'] );
        $form->addElement ( 'hidden', 'campaign_type', $type, array ('id' => 'campaign_type' ) );

        $typeName = OX_Util_Utils::getCampaignTypeName ( $campaign ['priority'] );
        $typeG [] = $form->createElement ( 'static', 'campaign_type_static', null, "<label class='type-name'>" . $typeName . "</label>" );

        $translationKey = OX_Util_Utils::getCampaignTypeDescriptionTranslationKey ( $campaign ['priority'] );
        $translationKey = substr ( $translationKey, 3 );
        $typeG [] = $form->createElement ( 'custom', 'campaign-type-note', null, array ('infoKey' => $translationKey ) );

        $form->addGroup ( $typeG, 'g_ctype', $GLOBALS ['strCampaignType'], "" );
    }

//EX.   $form->addElement('text', 'test', 'Test field');
//EX.   $form->addRule('test', 'Weight must be positive number', 'formattednumber');


//EX.    $form->addDecorator('h_basic_info', 'tag',
//        array('attributes' => array('id' => 'test', 'style' => 'display:none')));
//EX.    $form->addDecorator('h_basic_info', 'tag', array('tag' => 'div',
//        'attributes' => array('id' => 'innerdiv', 'style' => 'display:none')));


//EX.    $form->addDecorator('test', 'process', array('tag' => 'tr',
//        'addAttributes' => array('id' => 'trtest{numCall}', 'style' => 'display: none')));
}

function buildDateFormSection(&$form, $campaign, $newCampaign)
{
    $form->addElement ( 'header', 'h_date', $GLOBALS ['strDate'] );
    //section decorator to allow hiding of the section
    $form->addDecorator ( 'h_date', 'tag', array ('attributes' => array ('id' => 'sect_date', 'class' => $newCampaign ? 'hide' : '' ) ) );

    //activation date
    $actDateGroup ['radioNow'] = $form->createElement ( 'radio', 'startSet', null, $GLOBALS ['strActivateNow'], 'f', array ('id' => 'startSet_immediate' ) );

    $actDateGroup ['radioSpecific'] = $form->createElement ( 'radio', 'startSet', null, $GLOBALS ['strSetSpecificDate'], 't', array ('id' => 'startSet_specific' ) );

    $specificStartDateGroup ['date'] = $form->createElement ( 'text', 'start', null, array ('id' => 'start', 'class' => 'small' ) );
    $specificStartDateGroup ['cal_img'] = $form->createElement ( 'image', 'start_button', OX::assetPath () . "/images/icon-calendar.gif", array ('id' => 'start_button', 'align' => 'absmiddle' ) );
    $specificStartDateGroup ['note'] = $form->createElement ( 'html', 'activation_note', $GLOBALS ['strActivationDateComment'] );
    $actDateGroup ['specificDate'] = $form->createElement ( 'group', 'g_specificStartDate', null, $specificStartDateGroup, null, false );
    $form->addDecorator ( 'g_specificStartDate', 'tag', array ('tag' => 'span', 'attributes' => array ('id' => 'specificStartDateSpan', 'style' => 'display:none' ) ) );

    $form->addGroup ( $actDateGroup, 'act_date', $GLOBALS ['strActivationDate'], array ("<BR>", '' ) );

    //expiriation date
    $expDateGroup ['radioNow'] = $form->createElement ( 'radio', 'endSet', null, $GLOBALS ['strDontExpire'], 'f', array ('id' => 'endSet_immediate' ) );

    $expDateGroup ['radioSpecific'] = $form->createElement ( 'radio', 'endSet', null, $GLOBALS ['strSetSpecificDate'], 't', array ('id' => 'endSet_specific' ) );
    //add warning note when disabled
    $expDateGroup ['disablednote'] = $form->createElement ( 'custom', 'date-campaign-date-limit-set-note', null, null, false );
    $form->addDecorator ( 'date-campaign-date-limit-set-note', 'tag', array ('attributes' => array ('id' => 'date-section-limit-date-set', 'class' => 'hide' ) ) );

    $specificEndDateGroup ['date'] = $form->createElement ( 'text', 'end', null, array ('id' => 'end', 'class' => 'small' ) );
    $specificEndDateGroup ['cal_img'] = $form->createElement ( 'image', 'end_button', OX::assetPath () . "/images/icon-calendar.gif", array ('id' => 'end_button', 'align' => 'absmiddle' ) );
    $specificEndDateGroup ['note'] = $form->createElement ( 'html', 'expiration_note', $GLOBALS ['strExpirationDateComment'] );
    $expDateGroup ['specificDate'] = $form->createElement ( 'group', 'g_specificEndDate', null, $specificEndDateGroup, null, false );
    $form->addDecorator ( 'g_specificEndDate', 'tag', array ('tag' => 'span', 'attributes' => array ('id' => 'specificEndDateSpan', 'style' => 'display:none' ) ) );

    $form->addGroup ( $expDateGroup, 'exp_date', $GLOBALS ['strExpirationDate'], array ("<BR>", '', '' ) );

    //decorators
    $form->addDecorator ( 'activation_note', 'tag', array ('tag' => 'span', 'attributes' => array ('id' => 'revTypeSel', 'class' => 'hide' ) ) );

    $form->addDecorator ( 'expiration_note', 'tag', array ('tag' => 'span', 'attributes' => array ('id' => 'startDateNote', 'class' => 'hide' ) ) );
}

function buildPricingFormSection(&$form, $campaign, $newCampaign)
{
    global $conf;

    $form->addElement ( 'header', 'h_pricing', $GLOBALS ['strPricing'] );
    //section decorator to allow hiding of the section
    $form->addDecorator ( 'h_pricing', 'tag', array ('attributes' => array ('id' => 'sect_pricing', 'class' => $newCampaign ? 'hide' : '' ) ) );

    //pricing model
    $aRevenueTypes = array ('' => $GLOBALS ['strSelectPricingModel'], MAX_FINANCE_CPM => $GLOBALS ['strFinanceCPM'], MAX_FINANCE_CPC => $GLOBALS ['strFinanceCPC'] );
    // Conditionally display CPA model
    if ($conf ['logging'] ['trackerImpressions']) {
        $aRevenueTypes [MAX_FINANCE_CPA] = $GLOBALS ['strFinanceCPA'];
    }
    $aRevenueTypes [MAX_FINANCE_MT] = $GLOBALS ['strFinanceMT'];
    $form->addElement ( 'select', 'revenue_type', $GLOBALS ['strPricingModel'], $aRevenueTypes, array ('id' => 'pricing_revenue_type' ) );

    //pricing model groups
    //rate price - common
    $ratePriceG ['field'] = $form->createElement ( 'text', 'revenue', null);
    $form->addGroup ( $ratePriceG, 'g_revenue', $GLOBALS ['strRatePrice'] );
    //decorator - to allow hiding until model is set
    $form->addDecorator ( 'g_revenue', 'process', array ('tag' => 'tr', 'addAttributes' => array ('id' => 'pricing_revenue_row{numCall}', 'class' => 'hide' ) ) );

    // Conditionally display conversions
    if ($conf ['logging'] ['trackerImpressions']) {
        $convCount ['conversions'] = $form->createElement ( 'text', 'conversions', null, array ('id' => 'conversions', 'class' => 'small' ) );
        $convCount ['checkbox'] = $form->createElement ( 'advcheckbox', 'conv_unlimited', null, $GLOBALS ['strUnlimited'], array ('id' => 'conv_unlimited' ), array ("f", "t" ) );
        $convCount ['disablednote'] = $form->createElement ( 'custom', array ('conv-campaign-date-limit-set-note', 'pricing-campaign-date-limit-set-note' ), null, array ('type' => 'conv' ), false );
        $form->addDecorator ( 'conv-campaign-date-limit-set-note', 'tag', array ('tag' => 'span', 'attributes' => array ('id' => 'conv-disabled-note', 'class' => 'hide' ) ) );
        $convCount ['note'] = $form->createElement ( 'custom', 'campaign-remaining-conv', null, array ('conversionsRemaining' => $campaign ['conversionsRemaining'] ), false );
        $form->addGroup ( $convCount, 'g_conv_booked', $GLOBALS ['strConversions'] );
        //decorator - to allow hiding until model is set
        $form->addDecorator ( 'g_conv_booked', 'process', array ('tag' => 'tr', 'addAttributes' => array ('id' => 'pricing_conv_booked{numCall}', 'class' => 'hide' ) ) );
    }

    //click
    $clickCount ['clicks'] = $form->createElement ( 'text', 'clicks', null, array ('id' => 'clicks', 'class' => 'small' ) );
    $clickCount ['checkbox'] = $form->createElement ( 'advcheckbox', 'click_unlimited', null, $GLOBALS ['strUnlimited'], array ('id' => 'click_unlimited' ), array ("f", "t" ) );
    $clickCount ['disablednote'] = $form->createElement ( 'custom', array ('click-campaign-date-limit-set-note', 'pricing-campaign-date-limit-set-note' ), null, array ('type' => 'click' ), false );
    $form->addDecorator ( 'click-campaign-date-limit-set-note', 'tag', array ('tag' => 'span', 'attributes' => array ('id' => 'click-disabled-note', 'class' => 'hide' ) ) );
    $clickCount ['note'] = $form->createElement ( 'custom', 'campaign-remaining-click', null, array ('clicksRemaining' => $campaign ['clicksRemaining'] ), false );
    $form->addGroup ( $clickCount, 'g_click_booked', $GLOBALS ['strClicks'] );
    //decorator - to allow hiding until model is set
    $form->addDecorator ( 'g_click_booked', 'process', array ('tag' => 'tr', 'addAttributes' => array ('id' => 'pricing_click_booked{numCall}', 'class' => 'hide' ) ) );

    //impr
    $imprCount ['impressions'] = $form->createElement ( 'text', 'impressions', null, array ('id' => 'impressions', 'class' => 'small' ) );
    $imprCount ['checkbox'] = $form->createElement ( 'advcheckbox', 'impr_unlimited', null, $GLOBALS ['strUnlimited'], array ('id' => 'impr_unlimited' ), array ("f", "t" ) );
    $imprCount ['disablednote'] = $form->createElement ( 'custom', array ('impr-campaign-date-limit-set-note', 'pricing-campaign-date-limit-set-note' ), null, array ('type' => 'impr' ), false );
    $form->addDecorator ( 'impr-campaign-date-limit-set-note', 'tag', array ('tag' => 'span', 'attributes' => array ('id' => 'impr-disabled-note', 'class' => 'hide' ) ) );
    $imprCount ['note'] = $form->createElement ( 'custom', 'campaign-remaining-impr', null, array ('impressionsRemaining' => $campaign ['impressionsRemaining'] ), false );

    $form->addGroup ( $imprCount, 'g_impr_booked', $GLOBALS ['strImpressions'] );
    //decorator - to allow hiding until model is set
    $form->addDecorator ( 'g_impr_booked', 'process', array ('tag' => 'tr', 'addAttributes' => array ('id' => 'pricing_impr_booked{numCall}', 'class' => 'hide' ) ) );
}

function buildHighPriorityFormSection(&$form, $campaign, $newCampaign)
{
    global $conf;

    //priority section
    $form->addElement ( 'header', 'h_high_priority', $GLOBALS ['strPriorityInformation'] );
    //section decorator to allow hiding of the section
    $form->addDecorator ( 'h_high_priority', 'tag', array ('attributes' => array ('id' => 'sect_priority_high', 'class' => $newCampaign ? 'hide' : '' ) ) );

    //high - dropdown
    for($i = 10; $i >= 1; $i --) {
        $aHighPriorities [$i] = $i;
    }
    $highPriorityGroup ['select'] = $form->createElement ( 'select', 'high_priority_value', null, $aHighPriorities, array ('class' => 'x-small' ) );

    //high - limit per day
    $aTargetTypes ['target_impression'] = $GLOBALS ['strImpressions'];
    $aTargetTypes ['target_click'] = $GLOBALS ['strClicks'];
    // Conditionally display conversion tracking
    if ($conf ['logging'] ['trackerImpressions']) {
        $aTargetTypes ['target_conversion'] = $GLOBALS ['strConversions'];
    }
    $aManualDel ['select'] = $form->createElement ( 'select', 'target_type', " - " . $GLOBALS ['strLimit'], $aTargetTypes );
    $aManualDel ['text'] = $form->createElement ( 'text', 'target_value', $GLOBALS ['strTo'], array ('id' => 'target_value') );
    $aManualDel ['perDayNote'] = $form->createElement ( 'html', null, $GLOBALS ['strTargetPerDay'] );

    $highPriorityGroup ['high-distr'] = $form->createElement ( 'group', 'high_distribution_man', null, $aManualDel, null, false );
    $form->addDecorator ( 'high_distribution_man', 'tag', array ('tag' => 'span', 'attributes' => array ('id' => 'high_distribution_span', 'style' => 'display:none' ) ) );

    $form->addGroup ( $highPriorityGroup, 'g_high_priority', $GLOBALS ['strPriorityLevel'], null, false );
}

function buildLowAndExclusivePriorityFormSection(&$form, $campaign, $newCampaign)
{
    global $conf;

    //priority section
    $form->addElement ( 'header', 'h_lowexcl_priority', $GLOBALS ['strPriorityInformation'] );
    //section decorator to allow hiding of the section
    $form->addDecorator ( 'h_lowexcl_priority', 'tag', array ('attributes' => array ('id' => 'sect_priority_low_excl', 'class' => $newCampaign ? 'hide' : '' ) ) );

    //exclusive and low - weight only (this group is artificial - there's one field only,
    //but I want it to get proper size)
    $weightGroup ['weight'] = $form->createElement ( 'text', 'weight', null, array ('id' => 'weight') );
    $form->addGroup ( $weightGroup, 'weight_group', $GLOBALS ['strCampaignWeight'], null, false );
}

function buildMiscFormSection(&$form, $campaign, $newCampaign)
{
    $form->addElement ( 'header', 'h_misc', $GLOBALS ['strMiscellaneous'] );
    //section decorator to allow hiding of the section
    $form->addDecorator ( 'h_misc', 'tag', array ('attributes' => array ('id' => 'sect_misc', 'class' => $newCampaign ? 'hide' : '' ) ) );

    //priority misc
    $miscG ['anonymous'] = $form->createElement ( 'advcheckbox', 'anonymous', null, $GLOBALS ['strAnonymous'], null, array ("f", "t" ) );
    $miscG ['companion'] = $form->createElement ( 'checkbox', 'companion', null, $GLOBALS ['strCompanionPositioning'] );
    $form->addGroup ( $miscG, 'misc_g', $GLOBALS ['strPriorityOptimisation'], "<BR>" );
}

//-----------


function OLD_buildInventoryDetailsFormSection(&$form, $campaign)
{
    global $conf;

    $form->addElement ( 'header', 'h_inv_details', $GLOBALS ['strInventoryDetails'] );

    //EX.    $form->addDecorator('inv_details', 'tag', array('tag' => 'span',
    //        'mode' => 'wrap', 'attributes' => array('id' => 'test', 'style' => 'display:none')));
    //EX.    $form->addDecorator('basic_info', 'tag', array('tag' => 'div',
    //        'attributes' => array('id' => 'innerdiv', 'style' => 'display:none')));


    //impr booked
    $imprCount ['radio'] = $form->createElement ( 'radio', 'rd_impr_bkd', null, null, 'no', array ('id' => 'limitedimpressions' ) );
    $imprCount ['impressions'] = $form->createElement ( 'text', 'impressions' );
    $imprCount ['note'] = $form->createElement ( 'custom', 'campaign-remaining-impr', null, array ('impressionsRemaining' => $campaign ['impressionsRemaining'] ), false );

    $imprBookedGroup ['count'] = $form->createElement ( 'group', 'impr_booked', null, $imprCount, null, false );
    $imprBookedGroup ['unlimitedradio'] = $form->createElement ( 'radio', 'rd_impr_bkd', null, $GLOBALS ['strUnlimited'], 'unl', array ('id' => 'unlimitedimpressions' ) );

    $form->addGroup ( $imprBookedGroup, 'impr_booked', $GLOBALS ['strImpressionsBooked'], "<br/>" );

    //clicks booked
    $clickCount ['radio'] = $form->createElement ( 'radio', 'rd_click_bkd', null, null, 'no', array ('id' => 'limitedclicks' ) );
    $clickCount ['clicks'] = $form->createElement ( 'text', 'clicks' );
    $clickCount ['note'] = $form->createElement ( 'custom', 'campaign-remaining-click', null, array ('clicksRemaining' => $campaign ['clicksRemaining'] ), false );
    $clickBookedGroup ['count'] = $form->createElement ( 'group', 'click_booked', null, $clickCount, null, false );
    $clickBookedGroup ['unlimitedradio'] = $form->createElement ( 'radio', 'rd_click_bkd', null, $GLOBALS ['strUnlimited'], 'unl', array ('id' => 'unlimitedclicks' ) );

    $form->addGroup ( $clickBookedGroup, 'click_booked', $GLOBALS ['strClicksBooked'], "<br/>" );

    // Conditionally display conversion tracking
    if ($conf ['logging'] ['trackerImpressions']) {
        //conversions booked
        $convCount ['radio'] = $form->createElement ( 'radio', 'rd_conv_bkd', null, null, 'no', array ('id' => 'limitedconv' ) );
        $convCount ['conversions'] = $form->createElement ( 'text', 'conversions' );
        $convCount ['note'] = $form->createElement ( 'html', null, '<span  id="remainingConversions" >' . $GLOBALS ['strConversionsRemaining'] . ':<span id="remainingConversionsCount">' . $campaign ['conversionsRemaining'] . '</span></span>' );
        $convBookedGroup ['count'] = $form->createElement ( 'group', 'conv_booked', null, $convCount, null, false );
        $convBookedGroup ['unlimitedradio'] = $form->createElement ( 'radio', 'rd_conv_bkd', null, $GLOBALS ['strUnlimited'], 'unl', array ('id' => 'unlimitedconversions' ) );

        $form->addGroup ( $convBookedGroup, 'conv_booked', $GLOBALS ['strConversionsBooked'], "<br/>" );
    }
}

function buildStatusForm($campaign)
{
    $form = new OA_Admin_UI_Component_Form ( "statusChangeForm", "POST", $_SERVER ['PHP_SELF'] );
    $form->forceClientValidation ( true );
    $form->addElement ( 'hidden', 'campaignid', $campaign ['campaignid'] );
    $form->addElement ( 'hidden', 'campaignid', $campaign ['clientid'] );
    $form->addElement ( 'header', 'h_misc', $GLOBALS ['strCampaignStatus'] );

    if ($campaign ['status'] == OA_ENTITY_STATUS_APPROVAL) {
        $form->addElement ( 'radio', 'status', $GLOBALS ['strStatus'], $GLOBALS ['strCampaignApprove'] . " - " . $GLOBALS ['strCampaignApproveDescription'], OA_ENTITY_STATUS_RUNNING, array ('id' => 'sts_approve' ) );

        $form->addElement ( 'radio', 'status', $GLOBALS ['strStatus'], $GLOBALS ['strCampaignReject'] . " - " . $GLOBALS ['strCampaignRejectDescription'], OA_ENTITY_STATUS_REJECTED, array ('id' => 'sts_reject' ) );
    } elseif ($campaign ['status'] == OA_ENTITY_STATUS_RUNNING) {
        $form->addElement ( 'radio', 'status', $GLOBALS ['strStatus'], $GLOBALS ['strCampaignPause'] . " - " . $GLOBALS ['strCampaignPauseDescription'], OA_ENTITY_STATUS_PAUSED, array ('id' => 'sts_pause' ) );
    } elseif ($campaign ['status'] == OA_ENTITY_STATUS_PAUSED) {
        $form->addElement ( 'radio', 'status', $GLOBALS ['strStatus'], $GLOBALS ['strCampaignRestart'] . " - " . $GLOBALS ['strCampaignRestartDescription'], OA_ENTITY_STATUS_RUNNING, array ('id' => 'sts_restart' ) );
    } elseif ($campaign ['status'] == OA_ENTITY_STATUS_REJECTED) {
        $rejectionReasonText = phpAds_showStatusRejected ( $campaign ['as_reject_reason'] );
        $form->addElement ( 'static', 'status', $GLOBALS ['strStatus'], $rejectionReasonText, OA_ENTITY_STATUS_PAUSED, array ('id' => 'sts_pause' ) );
    }

    $form->addElement ( 'select', 'as_reject_reason', $GLOBALS ['strReasonForRejection'], array (OA_ENTITY_ADVSIGNUP_REJECT_NOTLIVE => $GLOBALS ['strReasonSiteNotLive'], OA_ENTITY_ADVSIGNUP_REJECT_BADCREATIVE => $GLOBALS ['strReasonBadCreative'], OA_ENTITY_ADVSIGNUP_REJECT_BADURL => $GLOBALS ['strReasonBadUrl'], OA_ENTITY_ADVSIGNUP_REJECT_BREAKTERMS => $GLOBALS ['strReasonBreakTerms'] ) );

    $form->addDecorator ( 'as_reject_reason', 'process', array ('tag' => 'tr', 'addAttributes' => array ('id' => 'rsn_row{numCall}', 'class' => 'hide' ) ) );

    $form->addElement ( 'controls', 'form-controls' );
    $submitLabel = (! empty ( $zone ['zoneid'] )) ? $GLOBALS ['strSaveChanges'] : $GLOBALS ['strNext'] . ' >';
    $form->addElement ( 'submit', 'submit_status', $GLOBALS ['strChangeStatus'] );

    return $form;
}

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/
/**
 * Processes submit values of campaign form
 *
 * @param OA_Admin_UI_Component_Form $form form to process
 * @return An array of Pear::Error objects if any
 */
function processCampaignForm($form)
{
    $aFields = $form->exportValues ();

    $expire = ! empty ( $aFields ['end'] ) ? date ( 'Y-m-d', strtotime ( $aFields ['end'] ) ) : OA_Dal::noDateValue ();
    $activate = ! empty ( $aFields ['start'] ) ? date ( 'Y-m-d', strtotime ( $aFields ['start'] ) ) : OA_Dal::noDateValue ();

    // If ID is not set, it should be a null-value for the auto_increment
    if (empty ( $aFields ['campaignid'] )) {
        $aFields ['campaignid'] = "null";
    } else {
        require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
        $oldCampaignAdZoneAssocs = Admin_DA::getAdZones ( array ('placement_id' => $aFields ['campaignid'] ) );
        $errors = array ();
        foreach ( $oldCampaignAdZoneAssocs as $adZoneAssocId => $adZoneAssoc ) {
            $aZone = Admin_DA::getZone ( $adZoneAssoc ['zone_id'] );
            if ($aZone ['type'] == MAX_ZoneEmail) {
                $thisLink = Admin_DA::_checkEmailZoneAdAssoc ( $aZone, $aFields ['campaignid'], $activate, $expire );
                if (PEAR::isError ( $thisLink )) {
                    $errors [] = $thisLink;
                    break;
                }
            }
        }
    }

    //correct and check revenue
    //correction revenue from other formats (23234,34 or 23 234,34 or 23.234,34)
    //to format acceptable by is_numeric (23234.34)
    $corrected_revenue = OA_Admin_NumberFormat::unformatNumber ( $aFields ['revenue'] );
    if ($corrected_revenue !== false) {
        $aFields ['revenue'] = $corrected_revenue;
        unset ( $corrected_revenue );
    }
    if (! empty ( $aFields ['revenue'] ) && ! (is_numeric ( $aFields ['revenue'] ))) {
        // Suppress PEAR error handling to show this error only on top of HTML form
        PEAR::pushErrorHandling ( null );
        $errors [] = PEAR::raiseError ( $GLOBALS ['strErrorEditingCampaignRevenue'] );
        PEAR::popErrorHandling ();
    }

    if (empty ( $errors )) {
        //check booked limits values
        if (! empty ( $aFields ['impr_unlimited'] ) && $aFields ['impr_unlimited'] == 't') {
            $aFields ['impressions'] = - 1;
        } else if (empty ( $aFields ['impressions'] ) || $aFields ['impressions'] == '-') {
            $aFields ['impressions'] = 0;
        }

        if (! empty ( $aFields ['click_unlimited'] ) && $aFields ['click_unlimited'] == 't') {
            $aFields ['clicks'] = - 1;
        } else if (empty ( $aFields ['clicks'] ) || $aFields ['clicks'] == '-') {
            $aFields ['clicks'] = 0;
        }

        if (! empty ( $aFields ['conv_unlimited'] ) && $aFields ['conv_unlimited'] == 't') {
            $aFields ['conversions'] = - 1;
        } else if (empty ( $aFields ['conversions'] ) || $aFields ['conversions'] == '-') {
            $aFields ['conversions'] = 0;
        }

        //pricing model - reset fields not applicable to model to 0,
        //note that in new flow MAX_FINANCE_CPA allows all limits to be set
        if ($aFields ['revenue_type'] == MAX_FINANCE_CPM) {
            $aFields ['clicks'] = 0;
            $aFields ['conversions'] = 0;
        } else if ($aFields ['revenue_type'] == MAX_FINANCE_CPC) {
            $aFields ['conversions'] = 0;
        } else if ($aFields ['revenue_type'] == MAX_FINANCE_MT) {
            $aFields ['impressions'] = 0;
            $aFields ['clicks'] = 0;
            $aFields ['conversions'] = 0;
        }

        //check type and set priority
        if ($aFields ['campaign_type'] == OX_CAMPAIGN_TYPE_REMNANT) {
            $aFields ['priority'] = 0; //low
        } else if ($aFields ['campaign_type'] == OX_CAMPAIGN_TYPE_CONTRACT_NORMAL) {
            $aFields ['priority'] = (isset ( $aFields ['high_priority_value'] ) ? $aFields ['high_priority_value'] : 5); //high
        }
        if ($aFields ['campaign_type'] == OX_CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE) {
            $aFields ['priority'] = - 1; //exclusive
        }

        if ($aFields ['priority'] > 0) {
            // Set target
            $target_impression = 0;
            $target_click = 0;
            $target_conversion = 0;
            if ((isset ( $aFields ['target_value'] )) && ($aFields ['target_value'] != '-')) {
                switch ( $aFields ['target_type']) {
                    case 'target_impression' :
                        $target_impression = $aFields ['target_value'];
                        break;

                    case 'target_click' :
                        $target_click = $aFields ['target_value'];
                        break;

                    case 'target_conversion' :
                        $target_conversion = $aFields ['target_value'];
                        break;
                }
            }
            $aFields ['weight'] = 0;
        } else {
            // Set weight
            if (! isset ( $aFields ['weight'] ) || $aFields ['weight'] == '-' || $aFields ['weight'] == '') {
                $aFields ['weight'] = 0;
            }
            $target_impression = 0;
            $target_click = 0;
            $target_conversion = 0;
        }

        if ($aFields ['anonymous'] != 't') {
            $aFields ['anonymous'] = 'f';
        }
        if ($aFields ['companion'] != 1) {
            $aFields ['companion'] = 0;
        }
        $new_campaign = $aFields ['campaignid'] == 'null';

        if (empty ( $aFields ['revenue'] ) || ($aFields ['revenue'] <= 0)) {
            // No revenue information, set to null
            $aFields ['revenue'] = 'NULL';
        }

        // Get the capping variables
        $block = _initCappingVariables ( $aFields ['time'], $aFields ['capping'], $aFields ['session_capping'] );

        $noDateValue = OA_Dal::noDateValue ();
        if (! isset ( $noDateValue )) {
            $noDateValue = 0;
        }

        $doCampaigns = OA_Dal::factoryDO ( 'campaigns' );
        $doCampaigns->campaignname = $aFields ['campaignname'];
        $doCampaigns->clientid = $aFields ['clientid'];
        $doCampaigns->views = $aFields ['impressions'];
        $doCampaigns->clicks = $aFields ['clicks'];
        $doCampaigns->conversions = $aFields ['conversions'];
        $doCampaigns->expire = OA_Dal::isValidDate ( $expire ) ? $expire : $noDateValue;
        $doCampaigns->activate = OA_Dal::isValidDate ( $activate ) ? $activate : $noDateValue;
        $doCampaigns->priority = $aFields ['priority'];
        $doCampaigns->weight = $aFields ['weight'];
        $doCampaigns->target_impression = $target_impression;
        $doCampaigns->target_click = $target_click;
        $doCampaigns->target_conversion = $target_conversion;
        $doCampaigns->anonymous = $aFields ['anonymous'];
        $doCampaigns->companion = $aFields ['companion'];
        $doCampaigns->comments = $aFields ['comments'];
        $doCampaigns->revenue = $aFields ['revenue'];
        $doCampaigns->revenue_type = $aFields ['revenue_type'];
        $doCampaigns->block = $block;
        $doCampaigns->capping = $aFields ['capping'];
        $doCampaigns->session_capping = $aFields ['session_capping'];

        $doCampaigns->updated = OA::getNow ();

        if (! empty ( $aFields ['campaignid'] ) && $aFields ['campaignid'] != "null") {
            $doCampaigns->campaignid = $aFields ['campaignid'];
            $doCampaigns->update ();
        } else {
            $aFields ['campaignid'] = $doCampaigns->insert ();
        }

        // Recalculate priority only when editing a campaign
        // or moving banners into a newly created, and when:
        //
        // - campaign changes status (activated or deactivated) or
        // - the campaign is active and target/weight are changed
        //
        if (! $new_campaign) {
            $doCampaigns = OA_Dal::staticGetDO ( 'campaigns', $aFields ['campaignid'] );
            $status = $doCampaigns->status;
            switch ( true) {
                case (( bool ) $status != ( bool ) $aFields ['status_old']) :
                    // Run the Maintenance Priority Engine process
                    OA_Maintenance_Priority::scheduleRun ();
                    break;

                case ($status == OA_ENTITY_STATUS_RUNNING) :
                    if ((! empty ( $aFields ['target_type'] ) && ${$aFields ['target_type']} != $aFields ['target_old']) || (! empty ( $aFields ['target_type'] ) && $aFields ['target_type_old'] != $aFields ['target_type']) || $aFields ['weight'] != $aFields ['weight_old'] || $aFields ['clicks'] != $aFields ['previousclicks'] || $aFields ['conversions'] != $aFields ['previousconversions'] || $aFields ['impressions'] != $aFields ['previousimpressions']) {
                        // Run the Maintenance Priority Engine process
                        OA_Maintenance_Priority::scheduleRun ();
                    }
                    break;
            }
        }

        // Rebuild cache
        // include_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
        // phpAds_cacheDelete();


        // Delete channel forecasting cache
        include_once 'Cache/Lite.php';
        $options = array ('cacheDir' => MAX_CACHE );
        $cache = new Cache_Lite ( $options );
        $group = 'campaign_' . $aFields ['campaignid'];
        $cache->clean ( $group );

        $oUI = new OA_Admin_UI ( );
        OX_Admin_Redirect::redirect ( "campaign-zone.php?clientid=" . $aFields ['clientid'] . "&campaignid=" . $aFields ['campaignid'] );
    }

    //return processing errors
    return $errors;
}

function processStatusForm($form)
{
    $aFields = $form->exportValues ();

    if (empty ( $aFields ['campaignid'] )) {
        return;
    }

    //update status for existing campaign
    $doCampaigns = OA_Dal::factoryDO ( 'campaigns' );
    $doCampaigns->campaignid = $aFields ['campaignid'];
    $doCampaigns->as_reject_reason = $aFields ['as_reject_reason'];
    $doCampaigns->status = $aFields ['status'];
    $doCampaigns->update ();

    // Run the Maintenance Priority Engine process
    OA_Maintenance_Priority::scheduleRun ();

    OX_Admin_Redirect::redirect ( "campaign-edit.php?clientid=" . $aFields ['clientid'] . "&campaignid=" . $aFields ['campaignid'] );
}

/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
function displayPage($campaign, $campaignForm, $statusForm, $campaignErrors = null)
{
    global $conf;

    //header and breadcrumbs
    if ($campaign ['campaignid'] != "") { //edit campaign
        // Initialise some parameters
        $pageName = basename ( $_SERVER ['PHP_SELF'] );
        $tabindex = 1;
        $agencyId = OA_Permission::getAgencyId ();
        $aEntities = array ('clientid' => $campaign ['clientid'], 'campaignid' => $campaign ['campaignid'] );

        // Display navigation
        $aOtherAdvertisers = Admin_DA::getAdvertisers ( array ('agency_id' => $agencyId ) );
        $aOtherCampaigns = Admin_DA::getPlacements ( array ('advertiser_id' => $campaign ['clientid'] ) );
        MAX_displayNavigationCampaign ( $pageName, $aOtherAdvertisers, $aOtherCampaigns, $aEntities );
    } else { //new campaign
        $advertiser = phpAds_getClientDetails ( $campaign ['clientid'] );
        $advertiserName = $advertiser ['clientname'];
        $advertiserEditUrl = "advertiser-edit.php?clientid=" . $campaign ['clientid'];

        // New campaign
        MAX_displayInventoryBreadcrumbs ( array (array ("name" => $advertiserName, "url" => $advertiserEditUrl ), array ("name" => "" ) ), "campaign", true );
        phpAds_PageHeader ( "campaign-edit_new" );
    }

    //get template and display form
    $oTpl = new OA_Admin_Template ( 'campaign-edit.html' );
    $oTpl->assign ( 'clientid', $campaign ['clientid'] );
    $oTpl->assign ( 'campaignid', $campaign ['campaignid'] );
    $oTpl->assign ( 'showAddBannerLink', ! empty ( $campaign ['campaignid'] ) && ! OA_Permission::isAccount ( OA_ACCOUNT_ADVERTISER ) );
    $oTpl->assign ( 'calendarBeginOfWeek', $GLOBALS ['pref'] ['begin_of_week'] ? 1 : 0 );
    $oTpl->assign ( 'language', $GLOBALS ['_MAX'] ['PREF'] ['language'] );
    $oTpl->assign ( 'conversionsEnabled', $conf ['logging'] ['trackerImpressions'] );
    $oTpl->assign ( 'adDirectEnabled', defined ( 'OA_AD_DIRECT_ENABLED' ) && OA_AD_DIRECT_ENABLED === true );

    $oTpl->assign ( 'impressionsDelivered', isset ( $campaign ['impressions_delivered'] ) ? $campaign ['impressions_delivered'] : 0 );
    $oTpl->assign ( 'clicksDelivered', isset ( $campaign ['clicks_delivered'] ) ? $campaign ['clicks_delivered'] : 0 );
    $oTpl->assign ( 'conversionsDelivered', isset ( $campaign ['conversions_delivered'] ) ? $campaign ['conversions_delivered'] : 0 );

    $oTpl->assign ( 'strCampaignWarningNoTargetMessage', str_replace ( "\n", '\n', addslashes ( $GLOBALS ['strCampaignWarningNoTarget'] ) ) );
    $oTpl->assign ( 'strCampaignWarningNoWeightMessage', str_replace ( "\n", '\n', addslashes ( $GLOBALS ['strCampaignWarningNoWeight'] ) ) );

    $oTpl->assign ( 'campaignErrors', $campaignErrors );

    $oTpl->assign ( 'CAMPAIGN_TYPE_REMNANT', OX_CAMPAIGN_TYPE_REMNANT );
    $oTpl->assign ( 'CAMPAIGN_TYPE_CONTRACT_NORMAL', OX_CAMPAIGN_TYPE_CONTRACT_NORMAL );
    $oTpl->assign ( 'CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE', OX_CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE );
    $oTpl->assign ( 'MODEL_CPM', MAX_FINANCE_CPM );
    $oTpl->assign ( 'MODEL_CPC', MAX_FINANCE_CPC );
    $oTpl->assign ( 'MODEL_CPA', MAX_FINANCE_CPA );
    if ($conf ['logging'] ['trackerImpressions']) {
        $oTpl->assign ( 'MODEL_MT', MAX_FINANCE_MT );
    }

    $oTpl->assign ( 'campaignFormId', $campaignForm->getId () );
    $oTpl->assign ( 'campaignForm', $campaignForm->serialize () );
    if (! empty ( $campaign ['campaignid'] ) && defined ( 'OA_AD_DIRECT_ENABLED' ) && OA_AD_DIRECT_ENABLED === true) {
        $oTpl->assign ( 'statusForm', $statusForm->serialize () );
    }
    $oTpl->display ();

    _echoDeliveryCappingJs ();

    //footer
    phpAds_PageFooter ();
}

//UTILS
function phpAds_showStatusRejected($reject_reason)
{
    global $strReasonSiteNotLive, $strReasonBadCreative, $strReasonBadUrl, $strReasonBreakTerms, $strCampaignStatusRejected;

    switch ( $reject_reason) {
        case OA_ENTITY_ADVSIGNUP_REJECT_NOTLIVE :
            $text = $strReasonSiteNotLive;
            break;
        case OA_ENTITY_ADVSIGNUP_REJECT_BADCREATIVE :
            $text = $strReasonBadCreative;
            break;
        case OA_ENTITY_ADVSIGNUP_REJECT_BADURL :
            $text = $strReasonBadUrl;
            break;
        case OA_ENTITY_ADVSIGNUP_REJECT_BREAKTERMS :
            $text = $strReasonBreakTerms;
            break;
    }

    return $strCampaignStatusRejected . ": " . $text;
}

function getCampaignInactiveReasons($aCampaign)
{
    $activate_ts = mktime ( 23, 59, 59, $aCampaign ["activate_month"], $aCampaign ["activate_dayofmonth"], $aCampaign ["activate_year"] );
    $expire_ts = $aCampaign ['expire_year'] ? mktime ( 23, 59, 59, $aCampaign ["expire_month"], $aCampaign ["expire_dayofmonth"], $aCampaign ["expire_year"] ) : 0;
    $aReasons = array ();

    if ($aCampaign ['impressions'] == 0) {
        $aReasons [] = $GLOBALS ['strNoMoreImpressions'];
    }
    if ($aCampaign ['clicks'] == 0) {
        $aReasons [] = $GLOBALS ['strNoMoreClicks'];
    }
    if ($aCampaign ['conversions'] == 0) {
        $aReasons [] = $GLOBALS ['strNoMoreConversions'];
    }
    if ($activate_ts > 0 && $activate_ts > time ()) {
        $aReasons [] = $GLOBALS ['strBeforeActivate'];
    }
    if ($expire_ts > 0 && time () > $expire_ts) {
        $aReasons [] = $GLOBALS ['strAfterExpire'];
    }

    if ($aCampaign ['priority'] == 0 && $aCampaign ['weight'] == 0) {
        $aReasons [] = $GLOBALS ['strWeightIsNull'];
    }
    if ($aCampaign ['priority'] > 0 && $aCampaign ['target_value'] == 0) {
        $aReasons [] = $GLOBALS ['strTargetIsNull'];
    }

    return $aReasons;
}

?>

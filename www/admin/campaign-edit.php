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
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Campaigns.php';


// Register input variables
phpAds_registerGlobalUnslashed ( 'start', 'startSet', 'anonymous', 'campaignname', 'clicks', 'companion', 'show_capped_no_cookie', 'comments', 'conversions', 'end', 'endSet', 'priority', 'high_priority_value', 'revenue', 'revenue_type', 'submit', 'submit_status', 'target_old', 'target_type_old', 'target_value', 'target_type', 'rd_impr_bkd', 'rd_click_bkd', 'rd_conv_bkd', 'impressions', 'weight_old', 'weight', 'clientid', 'status', 'status_old', 'as_reject_reason', 'an_status', 'previousimpressions', 'previousconversions', 'previousclicks' );

// Security check
OA_Permission::enforceAccount ( OA_ACCOUNT_MANAGER );
OA_Permission::enforceAccessToObject('clients', $clientid, false, OA_Permission::OPERATION_VIEW);
OA_Permission::enforceAccessToObject('campaigns', $campaignid, true, OA_Permission::OPERATION_EDIT);


/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'] = $clientid;
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['campaignid'][$clientid] = $campaignid;
phpAds_SessionDataStore();

/*-------------------------------------------------------*/
/* Initialise data                                    */
/*-------------------------------------------------------*/
if ($campaignid != "") {
    // Edit or Convert
    // Fetch exisiting settings
    // Parent setting for converting, campaign settings for editing
    $ID = $campaignid;

    // Get the campaign data from the campaign table, and store in $campaign
    $doCampaigns = OA_Dal::factoryDO ( 'campaigns' );
    $doCampaigns->selectAdd ( "views AS impressions" );
    $doCampaigns->get ( $ID );
    $data = $doCampaigns->toArray ();

    $campaign['campaignname'] = $data ['campaignname'];
    $campaign['impressions'] = $data ['impressions'];
    $campaign['clicks'] = $data ['clicks'];
    $campaign['conversions'] = $data ['conversions'];
    $campaign['expire'] = $data ['expire'];
    if (!empty($data['expire_time'])) {
        $oExpireDate = new Date($data['expire_time']);
        $oTz = $oExpireDate->tz;
        $oExpireDate->setTZbyID('UTC');
        $oExpireDate->convertTZ($oTz);
        $campaign['expire_f'] = $oExpireDate->format($date_format);
        $campaign['expire_date'] = $oExpireDate->format('%Y-%m-%d');
    }
    $campaign['status'] = $doCampaigns->status;
    $campaign['an_status'] = $doCampaigns->an_status;
    $campaign['as_reject_reason'] = $doCampaigns->as_reject_reason;

    if (!empty($data['activate_time'])) {
        $oActivateDate = new Date($data['activate_time']);
        $oTz = $oActivateDate->tz;
        $oActivateDate->setTZbyID('UTC');
        $oActivateDate->convertTZ($oTz);
        $campaign['activate_f'] = $oActivateDate->format($date_format);
        $campaign['activate_date'] = $oActivateDate->format('%Y-%m-%d');
    }
    $campaign['priority'] = $data ['priority'];
    $campaign['weight'] = $data ['weight'];
    $campaign['target_impression'] = $data ['target_impression'];
    $campaign['target_click'] = $data ['target_click'];
    $campaign['target_conversion'] = $data ['target_conversion'];
    $campaign['min_impressions'] = $data ['min_impressions'];
    $campaign['ecpm'] = OA_Admin_NumberFormat::formatNumber ( $data ['ecpm'], 4 );
    $campaign['anonymous'] = $data ['anonymous'];
    $campaign['companion'] = $data ['companion'];
    $campaign['show_capped_no_cookie'] = $data ['show_capped_no_cookie'];
    $campaign['comments'] = $data ['comments'];
    $campaign['revenue'] = OA_Admin_NumberFormat::formatNumber ( $data ['revenue'], 4 );
    $campaign['revenue_type'] = $data ['revenue_type'];
    $campaign['block'] = $data ['block'];
    $campaign['capping'] = $data ['capping'];
    $campaign['session_capping'] = $data ['session_capping'];
    $campaign['impressionsRemaining'] = '';
    $campaign['clicksRemaining'] = '';
    $campaign['conversionsRemaining'] = '';

    $campaign['impressionsRemaining'] = '';
    $campaign['clicksRemaining'] = '';
    $campaign['conversionsRemaining'] = '';

    // Get the campagin data from the data_intermediate_ad table, and store in $campaign
    if (($campaign['impressions'] > 0) || ($campaign['clicks'] > 0) || ($campaign['conversions'] > 0)) {
        $dalData_intermediate_ad = OA_Dal::factoryDAL ( 'data_intermediate_ad' );
        $record = $dalData_intermediate_ad->getDeliveredByCampaign ( $campaignid );
        $data = $record->toArray ();

        if ($campaign['impressions'] != -1) {
            $campaign['impressionsRemaining'] = $campaign['impressions'] - $data ['impressions_delivered'];
        } else {
            $campaign['impressionsRemaining'] = '';
        }
        if ($campaign['clicks'] != -1) {
            $campaign['clicksRemaining'] = $campaign['clicks'] - $data ['clicks_delivered'];
        } else {
            $campaign['clicksRemaining'] = '';
        }
        if ($campaign['conversions'] != -1) {
            $campaign['conversionsRemaining'] = $campaign['conversions'] - $data ['conversions_delivered'];
        } else {
            $campaign['conversionsRemaining'] = '';
        }
        $campaign['impressions_delivered'] = $data ['impressions_delivered'];
        $campaign['clicks_delivered'] = $data ['clicks_delivered'];
        $campaign['conversions_delivered'] = $data ['conversions_delivered'];
        $deliveryDataLoaded = true;
    }

    // Get the value to be used in the target_value field
    if ($campaign['target_impression'] > 0) {
        $campaign['target_value'] = $campaign['target_impression'];
        $campaign['target_type'] = 'target_impression';
    } elseif ($campaign['target_click'] > 0) {
        $campaign['target_value'] = $campaign['target_click'];
        $campaign['target_type'] = 'target_click';
    } elseif ($campaign['target_conversion'] > 0) {
        $campaign['target_value'] = $campaign['target_conversion'];
        $campaign['target_type'] = 'target_conversion';
    } else {
        $campaign['target_value'] = '-';
        $campaign['target_type'] = 'target_impression';
    }

    if ($campaign['target_value'] > 0) {
        $campaign['weight'] = '-';
    } else {
        $campaign['target_value'] = '-';
    }

    if (!isset($campaign["activate_f"])) {
        $campaign["activate_f"] = "-";
    }

    if (!isset($campaign["expire_f"])) {
        $campaign["expire_f"] = "-";
    }

    // Set the default financial information
    if (!isset($campaign['revenue'])) {
        $campaign['revenue'] = OA_Admin_NumberFormat::formatNumber(0, 4);
    }

    // Set the default eCPM prioritization settings
    if (!isset($campaign['ecpm'])) {
        $campaign['ecpm'] = OA_Admin_NumberFormat::formatNumber(0, 4);
    }
} else {
    // New campaign
    $doClients = OA_Dal::factoryDO ( 'clients' );
    $doClients->clientid = $clientid;
    $client = $doClients->toArray ();

    if ($doClients->find () && $doClients->fetch () && $client = $doClients->toArray ()) {
        $campaign['campaignname'] = $client ['clientname'] . ' - ';
    } else {
        $campaign["campaignname"] = '';
    }

    $campaign["campaignname"] .= $strDefault . " " . $strCampaign;
    $campaign["impressions"] = -1;
    $campaign["clicks"] = -1;
    $campaign["conversions"] = -1;
    $campaign["status"] = ( int ) $status;
    $campaign["expire_time"] = '';
    $campaign["activate_time"] = '';
    $campaign["priority"] = 0;
    $campaign["anonymous"] = ($pref ['gui_campaign_anonymous'] == 't') ? 't' : '';
    $campaign['revenue'] = '';
    $campaign['revenue_type'] = null;
    $campaign['target_value'] = '-';
    $campaign['impressionsRemaining'] = null;
    $campaign['clicksRemaining'] = null;
    $campaign['conversionsRemaining'] = null;
    $campaign['companion'] = null;
    $campaign['block'] = null;
    $campaign['capping'] = null;
    $campaign['session_capping'] = null;
    $campaign['comments'] = null;
    $campaign['target_type'] = null;
    $campaign['min_impressions'] = 100;
    $campaign['show_capped_no_cookie'] = 0;
}

if ($campaign['status'] == OA_ENTITY_STATUS_RUNNING && OA_Dal::isValidDate ( $campaign['expire'] ) && $campaign['impressions'] > 0) {
    $campaign['delivery'] = 'auto';
} elseif ($campaign['target_value'] > 0) {
    $campaign['delivery'] = 'manual';
} else {
    $campaign['delivery'] = 'none';
}

$campaign['clientid'] = $clientid;
$campaign['campaignid'] = $campaignid;

/*-------------------------------------------------------*/
/* MAIN REQUEST PROCESSING                               */
/*-------------------------------------------------------*/

// Handle ajax call to update ecpm field.
if (isset($_REQUEST['ajax'])) {
    if ($start) {
        $startDate = date('Y-m-d', strtotime($start));
    } else {
        $startDate = null;
    }
    if ($end) {
        $endDate = date('Y-m-d', strtotime($end));
    } else {
        $endDate = null;
    }

    if (is_null($deliveryDataLoaded) && !empty($campaignid)) {
        $dalData_intermediate_ad = OA_Dal::factoryDAL('data_intermediate_ad');
        $record = $dalData_intermediate_ad->getDeliveredByCampaign($campaignid);
        $data = $record->toArray();
        $impressions = $data['impressions_delivered'];
        $clicks = $data['clicks_delivered'];
        $conversions = $data['conversions_delivered'];
    }
    $ecpm = OX_Util_Utils::getEcpm($revenue_type, $revenue,
            $impressions, $clicks, $conversions, $startDate, $endDate);
    echo OA_Admin_NumberFormat::formatNumber($ecpm, 4);
    exit();
}

//build campaign form
//var_dump($campaign);
$oComponent = null;
if (isset ( $GLOBALS ['_MAX'] ['CONF'] ['plugins'] ['openXThorium'] )
	&& $GLOBALS ['_MAX'] ['CONF'] ['plugins'] ['openXThorium']) {
    $oComponent = &OX_Component::factory ( 'admin', 'oxThorium', 'oxThorium' );
}

$campaignForm = buildCampaignForm ( $campaign, $oComponent );

if ($campaignForm->isSubmitted () && $campaignForm->validate ()) {
    //process submitted values
    $errors = processCampaignForm ( $campaignForm, $oComponent );
    if (! empty ( $errors )) { //need to redisplay page with general errors
        displayPage ( $campaign, $campaignForm, $statusForm, $errors );
    }
}
else { //either validation failed or no form was not submitted, display the page
    displayPage ( $campaign, $campaignForm, $statusForm );
}

/*-------------------------------------------------------*/
/* Build form                                            */
/*-------------------------------------------------------*/
function buildCampaignForm($campaign, &$oComponent = null)
{
    global $pref;

    $form = new OA_Admin_UI_Component_Form ( "campaignform", "POST", $_SERVER ['SCRIPT_NAME'] );
    $form->forceClientValidation ( true );
    $form->addElement ( 'hidden', 'campaignid', $campaign['campaignid'] );
    $form->addElement ( 'hidden', 'clientid', $campaign['clientid'] );
    $form->addElement ( 'hidden', 'expire_time', $campaign['expire_time'] );
    $form->addElement ( 'hidden', 'target_old', isset ( $campaign['target_value'] ) ? ( int ) $campaign['target_value'] : 0 );
    $form->addElement ( 'hidden', 'target_type_old', isset ( $campaign['target_type'] ) ? $campaign['target_type'] : '' );
    $form->addElement ( 'hidden', 'weight_old', isset ( $campaign['weight'] ) ? ( int ) $campaign['weight'] : 0 );
    $form->addElement ( 'hidden', 'status_old', isset ( $campaign['status'] ) ? ( int ) $campaign['status'] : 1 );
    $form->addElement ( 'hidden', 'previousweight', isset ( $campaign["weight"] ) ? $campaign["weight"] : '' );
    $form->addElement ( 'hidden', 'previoustarget', isset ( $campaign["target"] ) ? $campaign["target"] : '' );
    $form->addElement ( 'hidden', 'previousactive', isset ( $campaign["active"] ) ? $campaign["active"] : '' );
    $form->addElement ( 'hidden', 'previousimpressions', isset ( $campaign["impressions"] ) ? $campaign["impressions"] : '' );
    $form->addElement ( 'hidden', 'previousclicks', isset ( $campaign["clicks"] ) ? $campaign["clicks"] : '' );
    $form->addElement ( 'hidden', 'previousconversions', isset ( $campaign["conversions"] ) ? $campaign["conversions"] : '' );

    //campaign inactive note (if any)
    if (isset ( $campaign['status'] ) && $campaign['status'] != OA_ENTITY_STATUS_RUNNING) {
        $aReasons = getCampaignInactiveReasons ( $campaign );
        $form->addElement ( 'custom', 'campaign-inactive-note', null, array ('inactiveReason' => $aReasons ), false );
    }

    //form sections
    $newCampaign = empty ( $campaign['campaignid'] );

    $remnantEcpmEnabled = !empty($pref['campaign_ecpm_enabled']);
    $contractEcpmEnabled = !empty($pref['contract_ecpm_enabled']);
    buildBasicInformationFormSection($form, $campaign, $newCampaign, $remnantEcpmEnabled, $contractEcpmEnabled);
    buildDateFormSection ( $form, $campaign, $newCampaign );
    buildPricingFormSection($form, $campaign, $newCampaign, $remnantEcpmEnabled, $contractEcpmEnabled);
    buildPluggableFormSection ( $oComponent, 'afterPricingFormSection', $form, $campaign, $newCampaign );
    buildHighPriorityFormSection ( $form, $campaign, $newCampaign );
    buildLowAndExclusivePriorityFormSection ( $form, $campaign, $newCampaign );
    buildDeliveryCappingFormSection ( $form, $GLOBALS ['strCappingCampaign'], $campaign, null, null, true, $newCampaign );
    buildMiscFormSection ( $form, $campaign, $newCampaign );

    //form controls
    $form->addElement ( 'controls', 'form-controls' );
    $form->addElement ( 'submit', 'submit', $GLOBALS ['strSaveChanges'] );

    //validation rules
    $translation = new OX_Translation();
    $nameRequiredMsg = $translation->translate ( $GLOBALS ['strXRequiredField'], array ($GLOBALS ['strName'] ) );
    $form->addRule ( 'campaignname', $nameRequiredMsg, 'required' );
    $form->addFormRule('checkIfCampaignTypeSpecified');


    $typeRequiredMsg = $translation->translate ( $GLOBALS ['strXRequiredField'], array ($GLOBALS ['strPricingModel'] ) );
    $form->addRule ( 'revenue_type', $typeRequiredMsg, 'required' );

    //  $form->addRule('impressions', 'TODO message', 'formattedNumber');
    //  $form->addRule('clicks', 'TODO message', 'formattedNumber');
    //    if ($conf['logging']['trackerImpressions']) {
    //      $form->addRule('conversions', 'TODO message', 'formattedNumber');
    //    }
    //  $form->addRule('weight', 'TODO message', 'wholeNumber-');
    //  $form->addRule('target_value', 'TODO message', 'wholeNumber-');


    //set form values
    $form->setDefaults($campaign);
    $form->setDefaults (array(
    	'impressions' => !isset($campaign['impressions']) || $campaign['impressions'] == '' || $campaign['impressions'] < 0 ? '-' : $campaign['impressions'],
    	'clicks' => !isset($campaign['clicks']) || $campaign['clicks'] == '' || $campaign['clicks'] < 0 ? '-' : $campaign['clicks'],
    	'conversions' => !isset($campaign['conversions']) || $campaign['conversions'] == '' || $campaign['conversions'] < 0 ? '-' : $campaign['conversions']
	));

	if (!empty($campaign['activate_date'])) {
	    $oDate = new Date($campaign['activate_date']);
	    $startDateSet = 't';
	    $startDateStr = $oDate->format('%d %B %Y ');
	} else {
	    $startDateSet = 'f';
	    $startDateStr = '';
	}

	if (!empty($campaign['expire_date'])) {
	    $oDate = new Date($campaign['expire_date']);
	    $endDateSet = 't';
	    $endDateStr = $oDate->format('%d %B %Y ');
	} else {
	    $endDateSet = 'f';
	    $endDateStr = '';
	}

    $form->setDefaults(array(
    	'campaign_type' => $newCampaign ? '' : OX_Util_Utils::getCampaignType($campaign['priority']),
    	'impr_unlimited' => (isset($campaign["impressions"]) && $campaign["impressions"] >= 0 ? 'f' : 't'),
    	'click_unlimited' => (isset($campaign["clicks"]) && $campaign["clicks"] >= 0 ? 'f' : 't'),
    	'conv_unlimited' => (isset($campaign["conversions"]) && $campaign["conversions"] >= 0 ? 'f' : 't'),
    	'startSet' => $startDateSet,
    	'endSet' => $endDateSet,
    	'start' => $startDateStr,
    	'end' => $endDateStr,
    	'priority' => ($campaign['priority'] > '0' && $campaign['campaignid'] != '') ? 2 : $campaign['priority'],
    	'high_priority_value' => $campaign['priority'] > '0' ? $campaign['priority'] : 5,
    	'target_value' => !empty($campaign['target_value']) ? $campaign['target_value'] : '-',
    	'weight' => isset($campaign["weight"]) ? $campaign["weight"] : $pref ['default_campaign_weight'],
    	'revenue_type' => isset($campaign["revenue_type"]) ? $campaign["revenue_type"] : MAX_FINANCE_CPM
	));

    return $form;
}

function buildPluggableFormSection(&$oComponent, $method, &$form, $campaign, $newCampaign)
{
    if ($oComponent && method_exists ( $oComponent, $method )) {
        $oComponent->$method ( $form, $campaign, $newCampaign );
    }
}

function buildBasicInformationFormSection(&$form, $campaign, $newCampaign, $remnantEcpmEnabled, $contractEcpmEnabled)
{
    $form->addElement ( 'header', 'h_basic_info', $GLOBALS ['strBasicInformation'] );

    $form->addElement ( 'text', 'campaignname', $GLOBALS ['strName'] );

    $priority_h [] = $form->createElement ( 'radio', 'campaign_type', null, "<span class='type-name'>" . $GLOBALS ['strStandardContract'] . "</span>", OX_CAMPAIGN_TYPE_CONTRACT_NORMAL, array ('id' => 'priority-h' ) );
    $priority_h [] = $form->createElement ( 'custom', 'campaign-type-note', null, array ('radioId' => 'priority-h', 'infoKey' => 'StandardContractInfo' ) );

    $priority_e [] = $form->createElement ( 'radio', 'campaign_type', null, "<span class='type-name'>" . $GLOBALS ['strExclusiveContract'] . "</span>", OX_CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE, array ('id' => 'priority-e' ) );
    $priority_e [] = $form->createElement ( 'custom', array ('excl-limit-both-set-note', 'campaign-date-limit-both-set-note' ), null, null, false );
    $form->addDecorator ( 'excl-limit-both-set-note', 'tag', array ('attributes' => array ('id' => 'excl-limit-date-both-set', 'class' => 'hide' ) ) );
    $priority_e [] = $form->createElement ( 'custom', 'campaign-type-note', null, array ('radioId' => 'priority-e', 'infoKey' => 'ExclusiveContractInfo' ) );

    if ($remnantEcpmEnabled) {
        $priority_l [] = $form->createElement ( 'radio', 'campaign_type', null, "<span class='type-name'>" . $GLOBALS ['strRemnant'] . "</span>", OX_CAMPAIGN_TYPE_ECPM, array ('id' => 'priority-l' ) );
        $priority_l [] = $form->createElement ( 'custom', array ('ecpm-limit-both-set-note', 'campaign-date-limit-both-set-note' ), null, null, false );
        $form->addDecorator ( 'ecpm-limit-both-set-note', 'tag', array ('attributes' => array ('id' => 'ecpm-limit-date-both-set', 'class' => 'hide' ) ) );
        $priority_l [] = $form->createElement ( 'custom', 'campaign-type-note', null, array ('radioId' => 'priority-l', 'infoKey' => 'ECPMInfo' ) );
//        $form->addElement ( 'hidden', 'ecpm_enabled', 1 );
    } else {
        $priority_l [] = $form->createElement ( 'radio', 'campaign_type', null, "<span class='type-name'>" . $GLOBALS ['strRemnant'] . "</span>", OX_CAMPAIGN_TYPE_REMNANT, array ('id' => 'priority-l' ) );
        $priority_l [] = $form->createElement ( 'custom', array ('low-limit-both-set-note', 'campaign-date-limit-both-set-note' ), null, null, false );
        $form->addDecorator ( 'low-limit-both-set-note', 'tag', array ('attributes' => array ('id' => 'low-limit-date-both-set', 'class' => 'hide' ) ) );
        $priority_l [] = $form->createElement ( 'custom', 'campaign-type-note', null, array ('radioId' => 'priority-l', 'infoKey' => 'RemnantInfo' ) );
        $form->addElement ( 'hidden', 'campaignid', $aCampaign ['campaignid'] );
//        $form->addElement ( 'hidden', 'ecpm_enabled', 0 );
    }

    if ($remnantEcpmEnabled) {
        $form->addElement ( 'hidden', 'remnant_ecpm_enabled', 1 );
    } else {
        $form->addElement ( 'hidden', 'remnant_ecpm_enabled', 0 );
    }
    if ($contractEcpmEnabled) {
        $form->addElement ( 'hidden', 'contract_ecpm_enabled', 1 );
    } else {
        $form->addElement ( 'hidden', 'contract_ecpm_enabled', 0 );
    }

    $typeG [] = $form->createElement ( 'group', 'g_priority_h', null, $priority_h, null, false );
    $typeG [] = $form->createElement ( 'group', 'g_priority_e', null, $priority_e, null, false );
    $typeG [] = $form->createElement ( 'group', 'g_priority_l', null, $priority_l, null, false );
    $form->addGroup ( $typeG, 'g_ctype', $GLOBALS ['strCampaignType'], "" );

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
    $specificStartDateGroup ['cal_img'] = $form->createElement ('html', 'start_button', "<a href='#' id='start_button'><img src='".OX::assetPath () . "/images/icon-calendar.gif' align= 'absmiddle' /></a>");
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
    $specificEndDateGroup ['cal_img'] = $form->createElement ( 'html', 'end_button',    "<a href='#' id='end_button'><img src='".OX::assetPath () . "/images/icon-calendar.gif' align='absmiddle' /></a>");
    $specificEndDateGroup ['note'] = $form->createElement ( 'html', 'expiration_note', $GLOBALS ['strExpirationDateComment'] );
    $expDateGroup ['specificDate'] = $form->createElement ( 'group', 'g_specificEndDate', null, $specificEndDateGroup, null, false );
    $form->addDecorator ( 'g_specificEndDate', 'tag', array ('tag' => 'span', 'attributes' => array ('id' => 'specificEndDateSpan', 'style' => 'display:none' ) ) );

    $form->addGroup ( $expDateGroup, 'exp_date', $GLOBALS ['strExpirationDate'], array ("<BR>", '', '' ) );
}

function buildPricingFormSection(&$form, $campaign, $newCampaign, $remnantEcpmEnabled, $contractEcpmEnabled)
{
    global $conf;

    $form->addElement ( 'header', 'h_pricing', $GLOBALS ['strPricing'] );
    //section decorator to allow hiding of the section
    $form->addDecorator ( 'h_pricing', 'tag', array ('attributes' => array ('id' => 'sect_pricing', 'class' => $newCampaign ? 'hide' : '' ) ) );

    //pricing model
    $aRevenueTypes = array ('' => $GLOBALS ['strSelectPricingModel'], MAX_FINANCE_CPM => $GLOBALS ['strFinanceCPM'] );
    $aRevenueTypes[MAX_FINANCE_CPC] = $GLOBALS ['strFinanceCPC'];
    // Conditionally display CPA model
    if ($conf ['logging'] ['trackerImpressions']) {
        $aRevenueTypes [MAX_FINANCE_CPA] = $GLOBALS ['strFinanceCPA'];
    }
    $aRevenueTypes [MAX_FINANCE_MT] = $GLOBALS ['strFinanceMT'];
    $form->addElement ( 'select', 'revenue_type', $GLOBALS ['strPricingModel'], $aRevenueTypes, array ('id' => 'pricing_revenue_type' ) );
    $form->addElement ( 'hidden', 'min_impressions', $campaign ['min_impressions'] );

    //pricing model groups
    //rate price - common
    $ratePriceG ['field'] = $form->createElement ( 'text', 'revenue', null );
    $form->addGroup ( $ratePriceG, 'g_revenue', $GLOBALS ['strRatePrice'] );
    //decorator - to allow hiding until model is set
    $form->addDecorator ( 'g_revenue', 'process', array ('tag' => 'tr', 'addAttributes' => array ('id' => 'pricing_revenue_row{numCall}', 'class' => 'hide' ) ) );

    // Conditionally display conversions
    if ($conf ['logging'] ['trackerImpressions']) {
        $convCount ['conversions'] = $form->createElement ( 'text', 'conversions', null, array ('id' => 'conversions', 'class' => 'small' ) );
        $convCount ['checkbox'] = $form->createElement ( 'advcheckbox', 'conv_unlimited', null, $GLOBALS ['strUnlimited'], array ('id' => 'conv_unlimited' ), array ("f", "t" ) );
        $convCount ['disablednote'] = $form->createElement ( 'custom', array ('conv-campaign-date-limit-set-note', 'pricing-campaign-date-limit-set-note' ), null, array ('type' => 'conv' ), false );
        $form->addDecorator ( 'conv-campaign-date-limit-set-note', 'tag', array ('tag' => 'span', 'attributes' => array ('id' => 'conv-disabled-note', 'class' => 'hide' ) ) );
        $convCount ['note'] = $form->createElement ( 'custom', 'campaign-remaining-conv', null, array ('conversionsRemaining' => $campaign['conversionsRemaining'] ), false );
        $form->addGroup ( $convCount, 'g_conv_booked', $GLOBALS ['strConversions'] );
        //decorator - to allow hiding until model is set
        $form->addDecorator ( 'g_conv_booked', 'process', array ('tag' => 'tr', 'addAttributes' => array ('id' => 'pricing_conv_booked{numCall}', 'class' => 'hide' ) ) );
    }

    //click
    $clickCount ['clicks'] = $form->createElement ( 'text', 'clicks', null, array ('id' => 'clicks', 'class' => 'small' ) );
    $clickCount ['checkbox'] = $form->createElement ( 'advcheckbox', 'click_unlimited', null, $GLOBALS ['strUnlimited'], array ('id' => 'click_unlimited' ), array ("f", "t" ) );
    $clickCount ['disablednote'] = $form->createElement ( 'custom', array ('click-campaign-date-limit-set-note', 'pricing-campaign-date-limit-set-note' ), null, array ('type' => 'click' ), false );
    $form->addDecorator ( 'click-campaign-date-limit-set-note', 'tag', array ('tag' => 'span', 'attributes' => array ('id' => 'click-disabled-note', 'class' => 'hide' ) ) );
    $clickCount ['note'] = $form->createElement ( 'custom', 'campaign-remaining-click', null, array ('clicksRemaining' => $campaign['clicksRemaining'] ), false );
    $form->addGroup ( $clickCount, 'g_click_booked', $GLOBALS ['strClicks'] );
    //decorator - to allow hiding until model is set
    $form->addDecorator ( 'g_click_booked', 'process', array ('tag' => 'tr', 'addAttributes' => array ('id' => 'pricing_click_booked{numCall}', 'class' => 'hide' ) ) );

    //impr
    $imprCount ['impressions'] = $form->createElement ( 'text', 'impressions', null, array ('id' => 'impressions', 'class' => 'small' ) );
    $imprCount ['checkbox'] = $form->createElement ( 'advcheckbox', 'impr_unlimited', null, $GLOBALS ['strUnlimited'], array ('id' => 'impr_unlimited' ), array ("f", "t" ) );
    $imprCount ['disablednote'] = $form->createElement ( 'custom', array ('impr-campaign-date-limit-set-note', 'pricing-campaign-date-limit-set-note' ), null, array ('type' => 'impr' ), false );
    $form->addDecorator ( 'impr-campaign-date-limit-set-note', 'tag', array ('tag' => 'span', 'attributes' => array ('id' => 'impr-disabled-note', 'class' => 'hide' ) ) );
    $imprCount ['note'] = $form->createElement ( 'custom', 'campaign-remaining-impr', null, array ('impressionsRemaining' => $campaign['impressionsRemaining'] ), false );

    $form->addGroup ( $imprCount, 'g_impr_booked', $GLOBALS ['strImpressions'] );
    //decorator - to allow hiding until model is set
    $form->addDecorator ( 'g_impr_booked', 'process', array ('tag' => 'tr', 'addAttributes' => array ('id' => 'pricing_impr_booked{numCall}', 'class' => 'hide' ) ) );

    // eCPM
    if ($remnantEcpmEnabled || $contractEcpmEnabled) {
        $ecpmGroup['ecpm'] = $form->createElement('static', 'ecpm', null);
        $form->addDecorator ('ecpm', 'tag', array('attributes' => array('id' => 'ecpm_val')));

        // Show either remnant ecpm note or contract ecpm note
        $ecpmGroup['remnantNote'] = $form->createElement('custom', 'remnant-ecpm-note', null);
        $form->addDecorator('remnant-ecpm-note', 'tag', array('attributes' => array('id' => 'remnant_ecpm_note', 'class' => $campaign['priority'] != DataObjects_Campaigns::PRIORITY_ECPM ? 'hide' : '')));
        $ecpmGroup['contractNote'] = $form->createElement('custom', 'contract-ecpm-note', null);
        $form->addDecorator('contract-ecpm-note', 'tag', array('attributes' => array('id' => 'contract_ecpm_note', 'class' => $campaign['priority'] == DataObjects_Campaigns::PRIORITY_ECPM ? 'hide' : '')));
        $form->addGroup ( $ecpmGroup, 'ecpm_group', $GLOBALS ['strECPM'], null, false );
        $form->addDecorator ( 'ecpm_group', 'process',
            array ('tag' => 'tr',
                   'addAttributes' => array ('id' => 'sect_priority_ecpm{numCall}',
                                             'class' => $newCampaign ? 'hide' : '' ) ) );

        // Minimum number of required impressions should only be shown for remnant ecpm.
        $minimumImpr['field'] = $form->createElement ( 'text', 'min_impressions', null );
        $minimumImpr['note'] = $form->createElement('custom', 'minimum-impressions-note', null);
        $form->addGroup ( $minimumImpr, 'g_min_impressions', $GLOBALS ['strMinimumImpressions'] );
        $form->addDecorator ( 'g_min_impressions', 'process',
            array ('tag' => 'tr',
                   'addAttributes' => array ('id' => 'ecpm_min_row{numCall}',
                                             'class' => $campaign['priority'] != DataObjects_Campaigns::PRIORITY_ECPM ? 'hide' : '')));
    } else {
        $form->addElement ( 'hidden', 'ecpm', $campaign ['ecpm'] );
        $form->addElement ( 'hidden', 'min_impressions', $campaign ['min_impressions'] );
    }
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
    $aManualDel ['text'] = $form->createElement ( 'text', 'target_value', $GLOBALS ['strTo'], array ('id' => 'target_value' ) );
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
    $weightGroup ['weight'] = $form->createElement ( 'text', 'weight', null, array ('id' => 'weight' ) );
    $form->addGroup ( $weightGroup, 'weight_group', $GLOBALS ['strCampaignWeight'], null, false );
}

function buildMiscFormSection(&$form, $campaign, $newCampaign)
{
    $form->addElement ( 'header', 'h_misc', $GLOBALS ['strMiscellaneous'] );
    //section decorator to allow hiding of the section
    $form->addDecorator ( 'h_misc', 'tag', array ('attributes' => array ('id' => 'sect_misc', 'class' => $newCampaign ? 'hide' : '' ) ) );

    //priority misc
    $miscG['anonymous'] = $form->createElement('advcheckbox', 'anonymous', null, $GLOBALS['strAnonymous'], null, array("f", "t" ));
    $miscG['companion'] = $form->createElement('checkbox', 'companion', null, $GLOBALS['strCompanionPositioning']);
    $form->addGroup($miscG, 'misc_g', $GLOBALS['strMiscellaneous'], "<BR>");

    $commentsG ['comments']  = $form->createElement ( 'textarea', 'comments', null);
    $form->addGroup ( $commentsG, 'comments_g', $GLOBALS['strComments'], "<BR>" );
}

/**
 *
 * Correction revenue from other formats (23234,34 or 23 234,34 or 23.234,34)
 * to format acceptable by is_numeric (23234.34)
 *
 * @param array $aFields  Array of exported form fields
 * @param array $errors  Array of pear errors
 * @param String $field  Numeric field which will be checked and converted
 * @param String $errrorString     Error string used in case format of the field is not correct
 */
function correctAdnCheckNumericFormField($aFields, $errors, $field, $errrorString)
{
    $corrected = OA_Admin_NumberFormat::unformatNumber ( $aFields[$field] );
    if ($corrected !== false) {
        $aFields[$field] = $corrected;
    }
    if (! empty ( $aFields[$field] ) && ! (is_numeric ( $aFields[$field] ))) {
        // Suppress PEAR error handling to show this error only on top of HTML form
        PEAR::pushErrorHandling ( null );
        $errors [] = PEAR::raiseError ( $GLOBALS [$errrorString] );
        PEAR::popErrorHandling ();
    }
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
function processCampaignForm($form, &$oComponent = null)
{
    $aFields = $form->exportValues ();

    if (!empty($aFields['start'])) {
        $oDate = new Date(date('Y-m-d 00:00:00', strtotime($aFields['start'])));
        $oDate->toUTC();
        $activate = $oDate->getDate();
    } else {
        $oDate = new Date(date('Y-m-d 00:00:00'));
        $oDate->toUTC();
        $activate = $oDate->getDate();
    }
    if (!empty($aFields['end'])) {
        $oDate = new Date(date('Y-m-d 23:59:59', strtotime($aFields['end'])));
        $oDate->toUTC();
        $expire = $oDate->getDate();
    } else {
        $expire = null;
    }

    if (empty($aFields['campaignid'])) {
        // The form is submitting a new campaign, so, the ID is not set;
        // set the ID to the string "null" so that the table auto_increment
        // or sequence will be used when the campaign is created
        $aFields['campaignid'] = "null";
    } else {
        // The form is submitting a campaign modification; need to test
        // if any of the banners in the campaign are linked to an email zone,
        // and if so, if the link(s) would still be valid if the change(s)
        // to the campaign were made...
        $dalCampaigns = OA_Dal::factoryDAL('campaigns');
        $aCurrentLinkedEmalZoneIds = $dalCampaigns->getLinkedEmailZoneIds($aFields['campaignid']);
        if (PEAR::isError($aCurrentLinkedEmalZoneIds)) {
            OX::disableErrorHandling();
            $errors[] = PEAR::raiseError($GLOBALS['strErrorDBPlain']);
            OX::enableErrorHandling();
        }
        $errors = array();
        foreach ($aCurrentLinkedEmalZoneIds as $zoneId) {
            $thisLink = Admin_DA::_checkEmailZoneAdAssoc($zoneId, $aFields['campaignid'], $activate, $expire);
            if (PEAR::isError($thisLink)) {
                $errors[] = $thisLink;
                break;
            }
        }
    }

    //correct and check revenue and ecpm
    correctAdnCheckNumericFormField($aFields, $errors, 'revenue', $GLOBALS ['strErrorEditingCampaignRevenue']);
    correctAdnCheckNumericFormField($aFields, $errors, 'ecpm', $GLOBALS ['strErrorEditingCampaignECPM']);

    if (empty($errors)) {
        //check booked limits values

        // If this is a remnant, ecpm or exclusive campaign with an expiry date, set the target's to unlimited
        if (!empty($expire) &&
            ($aFields['campaign_type'] == OX_CAMPAIGN_TYPE_REMNANT
                || $aFields['campaign_type'] == OX_CAMPAIGN_TYPE_ECPM
                || $aFields['campaign_type'] == OX_CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE)
        ) {
            $aFields['impressions'] = $aFields['clicks'] = $aFields['conversions'] = -1;
        } else {
            if ((!empty($aFields['impr_unlimited']) && $aFields['impr_unlimited'] == 't')) {
                $aFields['impressions'] = -1;
            } else if (empty($aFields['impressions']) || $aFields['impressions'] == '-') {
                $aFields['impressions'] = 0;
            }

            if (!empty($aFields['click_unlimited']) && $aFields['click_unlimited'] == 't') {
                $aFields['clicks'] = -1;
            } else if (empty($aFields['clicks']) || $aFields['clicks'] == '-') {
                $aFields['clicks'] = 0;
            }

            if (!empty($aFields['conv_unlimited']) && $aFields['conv_unlimited'] == 't') {
                $aFields['conversions'] = -1;
            } else if (empty( $aFields['conversions']) || $aFields['conversions'] == '-') {
                $aFields['conversions'] = 0;
            }
        }

        //pricing model - reset fields not applicable to model to 0,
        //note that in new flow MAX_FINANCE_CPA allows all limits to be set
        if ($aFields['revenue_type'] == MAX_FINANCE_CPM) {
            $aFields['clicks'] = - 1;
            $aFields['conversions'] = - 1;
        } else if ($aFields['revenue_type'] == MAX_FINANCE_CPC) {
            $aFields['conversions'] = - 1;
        } else if ($aFields['revenue_type'] == MAX_FINANCE_MT) {
            $aFields['impressions'] = - 1;
            $aFields['clicks'] = - 1;
            $aFields['conversions'] = - 1;
        }

        //check type and set priority
        if ($aFields['campaign_type'] == OX_CAMPAIGN_TYPE_REMNANT) {
            $aFields['priority'] = 0; //low
        } else if ($aFields['campaign_type'] == OX_CAMPAIGN_TYPE_CONTRACT_NORMAL) {
            $aFields['priority'] = (isset($aFields['high_priority_value']) ? $aFields['high_priority_value'] : 5); //high
        } else if ($aFields['campaign_type'] == OX_CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE) {
            $aFields['priority'] = - 1; //exclusive
        } else if ($aFields['campaign_type'] == OX_CAMPAIGN_TYPE_ECPM) {
            $aFields['priority'] = - 2; //ecpm
        }

        // Set target
        $target_impression = 0;
        $target_click = 0;
        $target_conversion = 0;
        if ($aFields['priority'] > 0) {
            // Daily targets need to be set only if the campaign doesn't have both expiration and lifetime targets
            $hasExpiration = !empty($expire);
            $hasLifetimeTargets = $aFields['impressions'] != -1 || $aFields['clicks'] != -1 || $aFields['conversions'] != -1;
            if (!($hasExpiration && $hasLifetimeTargets) && (isset($aFields['target_value'])) && ($aFields['target_value'] != '-')) {
                switch ( $aFields['target_type']) {
                    case 'target_impression':
                        $target_impression = $aFields['target_value'];
                        break;

                    case 'target_click':
                        $target_click = $aFields['target_value'];
                        break;

                    case 'target_conversion':
                        $target_conversion = $aFields['target_value'];
                        break;
                }
            }
            $aFields['weight'] = 0;
        } else {
            // Set weight
            if (!isset($aFields['weight']) || $aFields['weight'] == '-' || $aFields['weight'] == '') {
                $aFields['weight'] = 0;
            }
        }

        if ($aFields['anonymous'] != 't') {
            $aFields['anonymous'] = 'f';
        }
        if ($aFields['companion'] != 1) {
            $aFields['companion'] = 0;
        }
        if ($aFields['show_capped_no_cookie'] != 1) {
            $aFields['show_capped_no_cookie'] = 0;
        }
        $new_campaign = $aFields['campaignid'] == 'null';

        if (empty($aFields['revenue']) || ($aFields['revenue'] <= 0)) {
            // No revenue information, set to null
            $aFields['revenue'] = OX_DATAOBJECT_NULL;
        }
        if (empty($aFields['ecpm']) || ($aFields['ecpm'] <= 0)) {
            // No ecpm information, set to null
            $aFields['ecpm'] = OX_DATAOBJECT_NULL;
        }

        // Get the capping variables
        $block = _initCappingVariables($aFields['time'], $aFields['capping'], $aFields['session_capping']);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = $aFields['campaignname'];
        $doCampaigns->clientid = $aFields['clientid'];
        $doCampaigns->views = $aFields['impressions'];
        $doCampaigns->clicks = $aFields['clicks'];
        $doCampaigns->conversions = $aFields['conversions'];
        $doCampaigns->priority = $aFields['priority'];
        $doCampaigns->weight = $aFields['weight'];
        $doCampaigns->target_impression = $target_impression;
        $doCampaigns->target_click = $target_click;
        $doCampaigns->target_conversion = $target_conversion;
        $doCampaigns->min_impressions = $aFields['min_impressions'];
        $doCampaigns->ecpm = $aFields['ecpm'];
        $doCampaigns->anonymous = $aFields['anonymous'];
        $doCampaigns->companion = $aFields['companion'];
        $doCampaigns->show_capped_no_cookie = $aFields['show_capped_no_cookie'];
        $doCampaigns->comments = $aFields['comments'];
        $doCampaigns->revenue = $aFields['revenue'];
        $doCampaigns->revenue_type = $aFields['revenue_type'];
        $doCampaigns->block = $block;
        $doCampaigns->capping = $aFields['capping'];
        $doCampaigns->session_capping = $aFields['session_capping'];

        // Activation and expiration
        $doCampaigns->activate_time = isset($activate) ? $activate : OX_DATAOBJECT_NULL;
        $doCampaigns->expire_time = isset($expire) ? $expire : OX_DATAOBJECT_NULL;

        if (!empty($aFields['campaignid']) && $aFields['campaignid'] != "null") {
            $doCampaigns->campaignid = $aFields['campaignid'];
            $doCampaigns->setEcpmEnabled();
            $doCampaigns->update();
        } else {
            $doCampaigns->setEcpmEnabled();
            $aFields['campaignid'] = $doCampaigns->insert();
        }
        if ($oComponent) {
            $oComponent->processCampaignForm($aFields);
        }

        // Recalculate priority only when editing a campaign
        // or moving banners into a newly created, and when:
        //
        // - campaign changes status (activated or deactivated) or
        // - the campaign is active and target/weight are changed
        //
        if (!$new_campaign) {
            $doCampaigns = OA_Dal::staticGetDO('campaigns', $aFields['campaignid']);
            $status = $doCampaigns->status;
            switch (true) {
                case ((bool) $status != (bool) $aFields['status_old']) :
                    // Run the Maintenance Priority Engine process
                    OA_Maintenance_Priority::scheduleRun();
                    break;

                case ($status == OA_ENTITY_STATUS_RUNNING) :
                    if ((!empty($aFields['target_type']) && ${$aFields['target_type']} != $aFields['target_old']) || (!empty($aFields['target_type']) && $aFields['target_type_old'] != $aFields['target_type']) || $aFields['weight'] != $aFields['weight_old'] || $aFields['clicks'] != $aFields['previousclicks'] || $aFields['conversions'] != $aFields['previousconversions'] || $aFields['impressions'] != $aFields['previousimpressions']) {
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
        $group = 'campaign_' . $aFields['campaignid'];
        $cache->clean ( $group );

        $translation = new OX_Translation();
        if ($new_campaign) {
            // Queue confirmation message
            $translated_message = $translation->translate ( $GLOBALS ['strCampaignHasBeenAdded'], array (MAX::constructURL ( MAX_URL_ADMIN, 'campaign-edit.php?clientid=' . $aFields['clientid'] . '&campaignid=' . $aFields['campaignid'] ), htmlspecialchars ( $aFields['campaignname'] ), MAX::constructURL ( MAX_URL_ADMIN, 'banner-edit.php?clientid=' . $aFields['clientid'] . '&campaignid=' . $aFields['campaignid'] ) ) );
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
            OX_Admin_Redirect::redirect("advertiser-campaigns.php?clientid=" . $aFields['clientid']);
        }
        else {
            $translated_message = $translation->translate ($GLOBALS ['strCampaignHasBeenUpdated'], array (
                MAX::constructURL(MAX_URL_ADMIN, 'campaign-edit.php?clientid=' . $aFields['clientid'] . '&campaignid=' . $aFields['campaignid'] ),
                htmlspecialchars ( $aFields['campaignname'] )
                ));
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
            OX_Admin_Redirect::redirect("campaign-edit.php?clientid=" . $aFields['clientid'] . "&campaignid=" . $aFields['campaignid'] );
        }
    }

    //return processing errors
    return $errors;
}

function processStatusForm($form)
{
    $aFields = $form->exportValues ();

    if (empty ( $aFields['campaignid'] )) {
        return;
    }

    //update status for existing campaign
    $doCampaigns = OA_Dal::factoryDO ( 'campaigns' );
    $doCampaigns->campaignid = $aFields['campaignid'];
    $doCampaigns->as_reject_reason = $aFields['as_reject_reason'];
    $doCampaigns->status = $aFields['status'];
    $doCampaigns->update ();

    // Run the Maintenance Priority Engine process
    OA_Maintenance_Priority::scheduleRun ();

    OX_Admin_Redirect::redirect ( "campaign-edit.php?clientid=" . $aFields['clientid'] . "&campaignid=" . $aFields['campaignid'] );
}

/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
function displayPage($campaign, $campaignForm, $statusForm, $campaignErrors = null)
{
    global $conf;

    //header and breadcrumbs
    if ($campaign['campaignid'] != "") { //edit campaign
        // Initialise some parameters
        $tabindex = 1;
        $agencyId = OA_Permission::getAgencyId ();
        $aEntities = array ('clientid' => $campaign['clientid'], 'campaignid' => $campaign['campaignid'] );

        // Display navigation
        $aOtherAdvertisers = Admin_DA::getAdvertisers ( array ('agency_id' => $agencyId ) );
        $aOtherCampaigns = Admin_DA::getPlacements ( array ('advertiser_id' => $campaign['clientid'] ) );
        MAX_displayNavigationCampaign ( $campaign['campaignid'], $aOtherAdvertisers, $aOtherCampaigns, $aEntities );
    } else { //new campaign
        $advertiser = phpAds_getClientDetails ( $campaign['clientid'] );
        $advertiserName = $advertiser ['clientname'];
        $advertiserEditUrl = "advertiser-edit.php?clientid=" . $campaign['clientid'];

        // New campaign
        $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder ( );
        $oHeaderModel = $builder->buildEntityHeader ( array (array ("name" => $advertiserName, "url" => $advertiserEditUrl ), array ("name" => "" ) ), "campaign", "edit-new" );
        phpAds_PageHeader ( "campaign-edit_new", $oHeaderModel );
    }

    //get template and display form
    $oTpl = new OA_Admin_Template ( 'campaign-edit.html' );
    $oTpl->assign ( 'clientid', $campaign['clientid'] );
    $oTpl->assign ( 'campaignid', $campaign['campaignid'] );
    $oTpl->assign ( 'calendarBeginOfWeek', $GLOBALS ['pref'] ['begin_of_week'] ? 1 : 0 );
    $oTpl->assign ( 'language', $GLOBALS ['_MAX'] ['PREF'] ['language'] );
    $oTpl->assign ( 'conversionsEnabled', $conf ['logging'] ['trackerImpressions'] );
    $oTpl->assign ( 'adDirectEnabled', defined ( 'OA_AD_DIRECT_ENABLED' ) && OA_AD_DIRECT_ENABLED === true );

    $oTpl->assign ( 'impressionsDelivered', isset ( $campaign['impressions_delivered'] ) ? $campaign['impressions_delivered'] : 0 );
    $oTpl->assign ( 'clicksDelivered', isset ( $campaign['clicks_delivered'] ) ? $campaign['clicks_delivered'] : 0 );
    $oTpl->assign ( 'conversionsDelivered', isset ( $campaign['conversions_delivered'] ) ? $campaign['conversions_delivered'] : 0 );

    $oTpl->assign ( 'strCampaignWarningNoTargetMessage', str_replace ( "\n", '\n', addslashes ( $GLOBALS ['strCampaignWarningNoTarget'] ) ) );
    $oTpl->assign ( 'strCampaignWarningRemnantNoWeight', str_replace ( "\n", '\n', addslashes ( $GLOBALS ['strCampaignWarningRemnantNoWeight'] ) ) );
    $oTpl->assign ( 'strCampaignWarningEcpmNoRevenue', str_replace ( "\n", '\n', addslashes ( $GLOBALS ['strCampaignWarningEcpmNoRevenue'] ) ) );
    $oTpl->assign ( 'strCampaignWarningExclusiveNoWeight', str_replace ( "\n", '\n', addslashes ( $GLOBALS ['strCampaignWarningExclusiveNoWeight'] ) ) );

    $oTpl->assign ( 'campaignErrors', $campaignErrors );

    $oTpl->assign ( 'CAMPAIGN_TYPE_REMNANT', OX_CAMPAIGN_TYPE_REMNANT );
    $oTpl->assign ( 'CAMPAIGN_TYPE_CONTRACT_NORMAL', OX_CAMPAIGN_TYPE_CONTRACT_NORMAL );
    $oTpl->assign ( 'CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE', OX_CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE );
    $oTpl->assign ( 'CAMPAIGN_TYPE_ECPM', OX_CAMPAIGN_TYPE_ECPM );
    $oTpl->assign ( 'CAMPAIGN_TYPE_CONTRACT_ECPM', OX_CAMPAIGN_TYPE_CONTRACT_ECPM );
    $oTpl->assign ( 'PRIORITY_ECPM_FROM', DataObjects_Campaigns::PRIORITY_ECPM_FROM);
    $oTpl->assign ( 'PRIORITY_ECPM_TO', DataObjects_Campaigns::PRIORITY_ECPM_TO);
    $oTpl->assign ( 'MODEL_CPM', MAX_FINANCE_CPM );
    $oTpl->assign ( 'MODEL_CPC', MAX_FINANCE_CPC );
    $oTpl->assign ( 'MODEL_CPA', MAX_FINANCE_CPA );
    if ($conf ['logging'] ['trackerImpressions']) {
        $oTpl->assign ( 'MODEL_MT', MAX_FINANCE_MT );
    }

    $oTpl->assign ( 'campaignFormId', $campaignForm->getId () );
    $oTpl->assign ( 'campaignForm', $campaignForm->serialize () );
    if (! empty ( $campaign['campaignid'] ) && defined ( 'OA_AD_DIRECT_ENABLED' ) && OA_AD_DIRECT_ENABLED === true) {
        $oTpl->assign ( 'statusForm', $statusForm->serialize () );
    }
    $oTpl->display ();

    _echoDeliveryCappingJs ();

    //footer
    phpAds_PageFooter ();
}


function getCampaignInactiveReasons($aCampaign)
{
    $aPref = $GLOBALS['_MAX']['PREF'];
    $aReasons = array ();

    if (($aCampaign['impressions'] != -1) && ($aCampaign['impressionsRemaining'] <= 0)) {
        $aReasons [] = $GLOBALS ['strNoMoreImpressions'];
    }
    if (($aCampaign['clicks'] != -1) && ($aCampaign['clicksRemainging'] <= 0)) {
        $aReasons [] = $GLOBALS ['strNoMoreClicks'];
    }
    if (($aCampaign['conversions'] != -1) & ($aCampaign['conversionsRemaining'] <= 0)) {
        $aReasons [] = $GLOBALS ['strNoMoreConversions'];
    }
    if (strtotime($aCampaign['activate_date'].' 00:00:00') > time()) {
        $aReasons [] = $GLOBALS ['strBeforeActivate'];
    }
    if (strtotime($aCampaign['expire_date'].' 23:59:59') < time()) {
        $aReasons [] = $GLOBALS ['strAfterExpire'];
    }

    if (($aCampaign ['priority'] == 0 || $aCampaign ['priority'] == - 1) && $aCampaign ['weight'] == 0) {
        $aReasons [] = $GLOBALS ['strWeightIsNull'];
    }
    if (($aCampaign['priority'] > 0) && ($aCampaign['target_value'] == 0 || $aCampaign['target_value'] == '-') &&
        ($aCampaign['impressions'] == -1) && ($aCampaign['clicks'] == -1) && ($aCampaign['conversions'] == -1)
    ) {
        $aReasons [] = $GLOBALS ['strTargetIsNull'];
    }
    if ($aCampaign['revenue'] <= 0) {
        // Remnant eCPM?
        $isEcpm = $aPref['campaign_ecpm_enabled'] &&
            $aCampaign['priority'] == DataObjects_Campaigns::PRIORITY_ECPM;
        if (!$isEcpm) {
            // Otherwise Contract eCPM?
            $isEcpm = $aPref['contract_ecpm_enabled'] &&
                $aCampaign['priority'] >= DataObjects_Campaigns::PRIORITY_ECPM_FROM &&
                $aCampaign['priority'] <= DataObjects_Campaigns::PRIORITY_ECPM_TO;
        }
        if ($isEcpm) {
            $aReasons [] = $GLOBALS ['strRevenueIsNull'];
        }
    }

    return $aReasons;
}


function checkIfCampaignTypeSpecified($submitValues)
{
    if (empty($submitValues['campaign_type'])) {
        $translation = new OX_Translation();
        return array('g_ctype' => $translation->translate(
            $GLOBALS['strXRequiredField'], array($GLOBALS['strCampaignType'])));
    }
    return true;
}


?>

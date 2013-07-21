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
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';
require_once MAX_PATH . '/lib/max/other/html.php';


// Register input variables
phpAds_registerGlobalUnslashed (
    'description'
    ,'move'
    ,'submit'
    ,'trackername'
    ,'status'
    ,'type'
    ,'linkcampaigns'
);

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients', $clientid);
OA_Permission::enforceAccessToObject('trackers', $trackerid, true);

/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'] = $clientid;
phpAds_SessionDataStore();

/*-------------------------------------------------------*/
/* Initialise data                                       */
/*-------------------------------------------------------*/
if ($trackerid != "" || (isset($move) && $move == 't')) {
    // Edit or Convert
    // Fetch exisiting settings
    // Parent setting for converting, tracker settings for editing
    if ($trackerid != "") {
        $ID = $trackerid;
    }
    if (isset($move) && $move == 't') {
        if (isset($clientid) && $clientid != "") {
            $ID = $clientid;
        }
    }
    $doTrackers = OA_Dal::factoryDO('trackers');
    $doTrackers->get($ID);
    $tracker = $doTrackers->toArray();
}
else {
    // New tracker
    $doClients = OA_Dal::factoryDO('clients');
    $doClients->clientid = $clientid;

    if ($doClients->find() && $doClients->fetch() && $client = $doClients->toArray()) {
        $tracker['trackername'] = $client['clientname'].' - ';
    } else {
        $tracker['trackername'] = '';
    }

    $tracker['trackername']  .= $strDefault." ".$strTracker;
    $tracker['status']        = isset($pref['tracker_default_status']) ? $pref['tracker_default_status'] : MAX_CONNECTION_STATUS_APPROVED;
    $tracker['type']          = isset($pref['tracker_default_type']) ? $pref['tracker_default_type'] : MAX_CONNECTION_TYPE_SALE;
    $tracker['linkcampaigns'] = $pref['tracker_link_campaigns'] == true ? 't' : 'f';
    $tracker['description'] = '';

    $tracker['clientid'] = $clientid;
}

/*-------------------------------------------------------*/
/* MAIN REQUEST PROCESSING                               */
/*-------------------------------------------------------*/
//build form
$trackerForm = buildTrackerForm($tracker);

if ($trackerForm->validate()) {
    //process submitted values
    processForm($trackerForm);
}
else { //either validation failed or form was not submitted, display the form
    displayPage($tracker, $trackerForm);
}

/*-------------------------------------------------------*/
/* Build form                                            */
/*-------------------------------------------------------*/
function buildTrackerForm($tracker)
{
    $form = new OA_Admin_UI_Component_Form("trackerform", "POST", $_SERVER['SCRIPT_NAME']);
    $form->forceClientValidation(true);
    $form->addElement('hidden', 'trackerid', $tracker['trackerid']);
    $form->addElement('hidden', 'clientid', $tracker['clientid']);
    $form->addElement('hidden', 'move', $tracker['move']);


    $form->addElement('header', 'basic_info', $GLOBALS['strTrackerInformation']);
    $form->addElement('text', 'trackername', $GLOBALS['strName']);
    $form->addElement('text', 'description', $GLOBALS['strDescription']);


    $types = $GLOBALS['_MAX']['CONN_TYPES'];
    foreach($types as $typeId => $typeName) {
        $aTypes[$typeId] = $GLOBALS[$typeName];
    }
    $form->addElement('select', 'type', $GLOBALS['strConversionType'], $aTypes);

    $statuses = $GLOBALS['_MAX']['STATUSES'];
    $startStatusesIds = array(1,2,4);
    foreach($statuses as $statusId => $statusName) {
        if(in_array($statusId, $startStatusesIds)) {
            $activeStatuses[$statusId] = $GLOBALS[$statusName];
        }
    }
    $form->addElement('select', 'status', $GLOBALS['strDefaultStatus'],
        $activeStatuses);
    $form->addElement('advcheckbox', 'linkcampaigns', null,
        $GLOBALS['strLinkCampaignsByDefault'], null, array("f", "t"));

    $form->addElement('controls', 'form-controls');
    $form->addElement('submit', 'submit', $GLOBALS['strSaveChanges']);

    //set form values
    $form->setDefaults($tracker);

    //validation rules
    $translation = new OX_Translation();
    $nameRequiredMsg = $translation->translate($GLOBALS['strXRequiredField'], array($GLOBALS['strName']));
    $form->addRule('trackername', $nameRequiredMsg, 'required');

    return $form;
}

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/
function processForm($form)
{
    $aFields = $form->exportValues();
    // If ID is not set, it should be a null-value for the auto_increment

    if (empty($aFields['trackerid'])) {
        $aFields['trackerid'] = "null";
    }

    $doTrackers = OA_Dal::factoryDO('trackers');
    $doTrackers->trackername = $aFields['trackername'];
    $doTrackers->description = $aFields['description'];
    $doTrackers->status = $aFields['status'];
    $doTrackers->type = $aFields['type'];
    $doTrackers->linkcampaigns = $aFields['linkcampaigns'] == "t" ? "t" : "f";
    $doTrackers->clientid = $aFields['clientid'];

    if (empty($aFields['trackerid']) || $aFields['trackerid'] == "null") {
        $aFields['trackerid'] = $doTrackers->insert();

        // Queue confirmation message
        $translation = new OX_Translation ();
        $translated_message = $translation->translate ( $GLOBALS['strTrackerHasBeenAdded'], array(
            MAX::constructURL(MAX_URL_ADMIN, "tracker-edit.php?clientid=".$aFields['clientid']."&trackerid=".$aFields['trackerid']),
            htmlspecialchars($aFields['trackername'])
        ));
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
        OX_Admin_Redirect::redirect('advertiser-trackers.php?clientid=' .  $aFields['clientid']);
    }
    else {
        $doTrackers->trackerid = $aFields['trackerid'];
        $doTrackers->update();

        // Queue confirmation message
        $translation = new OX_Translation();
        $translated_message = $translation->translate ( $GLOBALS['strTrackerHasBeenUpdated'], array(
            MAX::constructURL(MAX_URL_ADMIN, "tracker-edit.php?clientid=".$aFields['clientid']."&trackerid=".$aFields['trackerid']),
            htmlspecialchars($aFields['trackername'])
        ));
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
        OX_Admin_Redirect::redirect("tracker-edit.php?clientid=".$aFields['clientid']."&trackerid=".$aFields['trackerid']);
    }
    exit;
}


/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
function displayPage($tracker, $form)
{
    //header and breadcrumbs
    if ($tracker['trackerid'] != "") {
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->whereAdd('clientid <>'.$tracker['clientid']);
        if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $doClients->agencyid = OA_Permission::getAgencyId();
        }
        $doClients->find();
        $aOtherAdvertisers = array();
        while ($doClients->fetch() && $row = $doClients->toArray()) {
            $aOtherAdvertisers[] = $row;
        }
        MAX_displayNavigationTracker($tracker['clientid'], $tracker['trackerid'], $aOtherAdvertisers);
    }
    else {
        // New tracker
        $oHeaderModel = MAX_displayTrackerBreadcrumbs($tracker['clientid'], null);
        phpAds_PageHeader("tracker-edit_new", $oHeaderModel);
    }

    //get template and display form
    $oTpl = new OA_Admin_Template('tracker-edit.html');
    $oTpl->assign('form', $form->serialize());
    $oTpl->assign('formId', $form->getId());

    $oTpl->display();

    //footer
    phpAds_PageFooter();
}

function splitSecondsIntoCalendarItems($seconds)
{
    $result['day'] = floor($seconds / (60*60*24));
    $seconds = $seconds % (60*60*24);
    $result['hour'] = floor($seconds / (60*60));
    $seconds = $seconds % (60*60);
    $result['minute'] = floor($seconds / (60));
    $seconds = $seconds % (60);
    $result['second'] = $seconds;

    return $result;
}

?>

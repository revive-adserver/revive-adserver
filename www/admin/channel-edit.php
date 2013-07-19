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
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';



// Register input variables
phpAds_registerGlobalUnslashed('name', 'description', 'comments',
    'affiliateid','agencyid', 'channelid');

/*-------------------------------------------------------*/
/* Affiliate interface security                          */
/*-------------------------------------------------------*/

OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('channel', $channelid, true);

// Initalise data
$doChannel = OA_Dal::factoryDO('channel');
if (!empty($channelid)) {
    $doChannel->get($channelid);
    $channel = $doChannel->toArray();
}
else {
    //for new channels set affiliate id (if any)
    if (!empty($affiliateid)) {
        OA_Permission::enforceAccessToObject('affiliates', $affiliateid);

        $channel['affiliateid'] = $affiliateid;
    }
}

if(!empty($affiliateid)) {
	/*-------------------------------------------------------*/
	/* Store preferences									 */
	/*-------------------------------------------------------*/
	$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['affiliateid'] = $affiliateid;
	phpAds_SessionDataStore();
}

/*-------------------------------------------------------*/
/* MAIN REQUEST PROCESSING                               */
/*-------------------------------------------------------*/
//build form
$channelForm = buildChannelForm($channel);

if ($channelForm->validate()) {
    //process submitted values
    processForm($channelForm);
}
else { //either validation failed or form was not submitted, display the form
    displayPage($channel, $channelForm);
}

/*-------------------------------------------------------*/
/* Build form                                            */
/*-------------------------------------------------------*/
function buildChannelForm($channel)
{
    $form = new OA_Admin_UI_Component_Form("channelform", "POST", $_SERVER['SCRIPT_NAME']);
    $form->forceClientValidation(true);

    $form->addElement('hidden', 'agencyid', OA_Permission::getAgencyId());
    $form->addElement('hidden', 'affiliateid', $channel['affiliateid']);
    $form->addElement('hidden', 'channelid', $channel['channelid']);

    $form->addElement('header', 'header_basic', $GLOBALS['strBasicInformation']);
    $form->addElement('text', 'name', $GLOBALS['strName']);
    $form->addElement('text', 'description', $GLOBALS['strDescription']);
    $form->addElement('textarea', 'comments', $GLOBALS['strComments']);

    $form->addElement('controls', 'form-controls');
    $form->addElement('submit', 'submit', $GLOBALS['strSaveChanges']);

    //set form values
    $form->setDefaults($channel);

    //validation rules
    $translation = new OX_Translation();
    $nameRequiredMsg = $translation->translate($GLOBALS['strXRequiredField'], array($GLOBALS['strName']));
    $form->addRule('name', $nameRequiredMsg, 'required');

    return $form;

}


/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/
function processForm($form)
{
    $aFields = $form->exportValues();

    if (empty($aFields['affiliateid'])) {
        $aFields['affiliateid'] = 0;
    }
    if ($aFields['channelid']) {
        $doChannel = OA_Dal::factoryDO('channel');
        $doChannel->get($aFields['channelid']);
        $doChannel->name = $aFields['name'];
        $doChannel->description = $aFields['description'];
        $doChannel->comments = $aFields['comments'];
        $ret = $doChannel->update();

        // Queue confirmation message
        $translation = new OX_Translation();
        $channelURL = "channel-edit.php?".(empty($aFields['affiliateid']) ? "agencyid=".$aFields['agencyid']."&channelid=".$aFields['channelid']
            :   "affiliateid=".$aFields['affiliateid']."&channelid=".$aFields['channelid']);

        $translated_message = $translation->translate ( $GLOBALS['strChannelHasBeenUpdated'],
            array(
            MAX::constructURL(MAX_URL_ADMIN, $channelURL),
            htmlspecialchars($aFields['name'])
            ));
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

        if (!empty($aFields['affiliateid'])) {
            header("Location: channel-edit.php?affiliateid=".$aFields['affiliateid']."&channelid=".$aFields['channelid']);
        }
        else {
            header("Location: channel-edit.php?agencyid=".$aFields['agencyid']."&channelid=".$aFields['channelid']);
        }
        exit;
    }
    else {
        $doChannel = OA_Dal::factoryDO('channel');
        $doChannel->agencyid = $aFields['agencyid'];
        $doChannel->affiliateid = $aFields['affiliateid'];
        $doChannel->name = $aFields['name'];
        $doChannel->description = $aFields['description'];
        $doChannel->comments = $aFields['comments'];
        $doChannel->compiledlimitation = 'true';
        $doChannel->acl_plugins = 'true';
        $doChannel->active = 1;
        $aFields['channelid'] = $doChannel->insert();

        // Queue confirmation message
        $translation = new OX_Translation ();
        $translated_message = $translation->translate ( $GLOBALS['strChannelHasBeenAdded'], array(
            MAX::constructURL(MAX_URL_ADMIN, 'channel-edit.php?affiliateid=' .  $aFields['affiliateid'] . '&channelid=' . $aFields['channelid']),
            htmlspecialchars($aFields['name']),
            MAX::constructURL(MAX_URL_ADMIN, 'channel-acl.php?affiliateid=' .  $aFields['affiliateid'] . '&channelid=' . $aFields['channelid'])
        ));
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

        if (!empty($aFields['affiliateid'])) {
            OX_Admin_Redirect::redirect("affiliate-channels.php?affiliateid=" . $aFields['affiliateid']);
        } else {
            OX_Admin_Redirect::redirect("channel-index.php");
        }
    }
}

/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
function displayPage($channel, $form)
{
    $pageName = basename($_SERVER['SCRIPT_NAME']);
    $agencyId = OA_Permission::getAgencyId();

    // Obtain the needed data
    if (!empty($channel['affiliateid'])) {
        $aEntities = array('agencyid' => $agencyId, 'affiliateid' => $channel['affiliateid'], 'channelid' => $channel['channelid']);
        // Editing a channel at the publisher level; Only use the
        // channels at this publisher level for the navigation bar
        $aOtherChannels = Admin_DA::getChannels(array('publisher_id' => $channel['affiliateid']));
    }
    else {
        $aEntities = array('agencyid' => $agencyId, 'channelid' => $channel['channelid']);
        // Editing a channel at the agency level; Only use the
        // channels at this agency level for the navigation bar
        $aOtherChannels = Admin_DA::getChannels(array('agency_id' => $agencyId, 'channel_type' => 'agency'));
    }
    //show header and breadcrumbs
    MAX_displayNavigationChannel($pageName, $aOtherChannels, $aEntities);


    //get template and display form
    $oTpl = new OA_Admin_Template('channel-edit.html');
    $oTpl->assign('form', $form->serialize());
    $oTpl->assign('formId', $form->getId());
    $oTpl->display();


    //show footer
    phpAds_PageFooter();
}
?>

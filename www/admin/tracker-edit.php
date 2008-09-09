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
$Id$
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once LIB_PATH . '/Plugin/Component.php';

// Register input variables
phpAds_registerGlobalUnslashed (
     'clickwindow'
    ,'description'
    ,'move'
    ,'submit'
    ,'trackername'
    ,'viewwindow'
    ,'status'
    ,'type'
    ,'linkcampaigns'
);

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
OA_Permission::enforceAccessToObject('clients', $clientid);
OA_Permission::enforceAccessToObject('trackers', $trackerid, true);

// Initalise any tracker based plugins
$plugins = array();
$invocationPlugins = &OX_Component::getComponents('invocationTags');
foreach($invocationPlugins as $pluginKey => $plugin) {
    if (!empty($plugin->trackerEvent)) {
        $plugins[] = $plugin;
        $fieldName = strtolower($plugin->trackerEvent);
        phpAds_registerGlobal("{$fieldName}window");
    }
}

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
    $tracker['clickwindow']   = $conf['logging']['defaultImpressionConnectionWindow'];
    $tracker['viewwindow']    = $conf['logging']['defaultClickConnectionWindow'];
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
$trackerForm = buildTrackerForm($tracker, $plugins);

if ($trackerForm->validate()) {
    //process submitted values
    processForm($trackerForm, $plugins);
}
else { //either validation failed or form was not submitted, display the form
    displayPage($tracker, $trackerForm, $plugins);
}

/*-------------------------------------------------------*/
/* Build form                                            */
/*-------------------------------------------------------*/
function buildTrackerForm($tracker, $plugins)
{
    $form = new OA_Admin_UI_Component_Form("trackerform", "POST", $_SERVER['PHP_SELF']);
    $form->forceClientValidation(true);
    $form->addElement('hidden', 'trackerid', $tracker['trackerid']);
    $form->addElement('hidden', 'clientid', $tracker['clientid']);
    $form->addElement('hidden', 'move', $tracker['move']);


    $form->addElement('header', 'basic_info', $GLOBALS['strBasicInformation']);
    $form->addElement('text', 'trackername', $GLOBALS['strName']);
    $form->addElement('text', 'description', $GLOBALS['strDescription']);


    $types = $GLOBALS['_MAX']['CONN_TYPES'];
    foreach($types as $typeId => $typeName) {
        $aTypes[$typeId] = $GLOBALS[$typeName];
    }
    $form->addElement('select', 'type', $GLOBALS['strConversionType'], $aTypes);


    $form->addElement('header', 'conv_rules', $GLOBALS['strDefaultConversionRules']);
    $clickG['day'] = $form->createElement('text', 'clickwindow[day]', $GLOBALS['strDays'],
        array("id" => "clickwindowday", "onKeyUp" => "phpAds_formLimitUpdate(this.form);",
        "labelPlacement" => "after"));
    $clickG['day']->setSize(3);
    $clickG['hour'] = $form->createElement('text', 'clickwindow[hour]', $GLOBALS['strHours'],
        array("id" => "clickwindowhour", "onKeyUp" => "phpAds_formLimitUpdate(this.form);",
        "labelPlacement" => "after"));
    $clickG['hour']->setSize(3);
    $clickG['minute'] = $form->createElement('text', 'clickwindow[minute]', $GLOBALS['strMinutes'],
        array("id" => "clickwindowminute", "onKeyUp" => "phpAds_formLimitUpdate(this.form);",
        "labelPlacement" => "after"));
    $clickG['minute']->setSize(3);
    $clickG['second'] = $form->createElement('text', 'clickwindow[second]', $GLOBALS['strSeconds'],
        array("id" => "clickwindowsecond", "onKeyUp" => "phpAds_formLimitUpdate(this.form);",
            "onBlur" => "phpAds_formLimitBlur(this.form);", "labelPlacement" => "after"));
    $clickG['second']->setSize(3);
    $form->addGroup($clickG, 'size', $GLOBALS['strClickWindow'], "&nbsp;", false);

    $viewG['day'] = $form->createElement('text', 'viewwindow[day]', $GLOBALS['strDays'],
        array("id" => "viewwindowday", "onKeyUp" => "phpAds_formLimitUpdate(this.form);",
        "labelPlacement" => "after"));
    $viewG['day']->setSize(3);
    $viewG['hour'] = $form->createElement('text', 'viewwindow[hour]', $GLOBALS['strHours'],
        array("id" => "viewwindowhour", "onKeyUp" => "phpAds_formLimitUpdate(this.form);",
        "labelPlacement" => "after"));
    $viewG['hour']->setSize(3);
    $viewG['minute'] = $form->createElement('text', 'viewwindow[minute]', $GLOBALS['strMinutes'],
        array("id" => "viewwindowminute", "onKeyUp" => "phpAds_formLimitUpdate(this.form);",
        "labelPlacement" => "after"));
    $viewG['minute']->setSize(3);
    $viewG['second'] = $form->createElement('text', 'viewwindow[second]', $GLOBALS['strSeconds'],
        array("id" => "viewwindowsecond", "onKeyUp" => "phpAds_formLimitUpdate(this.form);",
            "onBlur" => "phpAds_formLimitBlur(this.form);", "labelPlacement" => "after"));
    $viewG['second']->setSize(3);
    $form->addGroup($viewG, 'size', $GLOBALS['strViewWindow'], "&nbsp;", false);

    //plugin fields
    foreach ($plugins as $plugin) {
        $fieldName = strtolower($plugin->trackerEvent);


        $pluginG['day'] = $form->createElement('text', '{$fieldName}window[day]', $GLOBALS['strDays'],
            array("id" => "{$fieldName}windowday", "onKeyUp" => "phpAds_formLimitUpdate(this.form);"));
        $pluginG['day']->setSize(3);
        $pluginG['hour'] = $form->createElement('text', '{$fieldName}window[hour]', $GLOBALS['strHours'],
            array("id" => "{$fieldName}windowhour", "onKeyUp" => "phpAds_formLimitUpdate(this.form);"));
        $pluginG['hour']->setSize(3);
        $pluginG['minute'] = $form->createElement('text', '{$fieldName}window[minute]', $GLOBALS['strMinutes'],
            array("id" => "{$fieldName}windowminute", "onKeyUp" => "phpAds_formLimitUpdate(this.form);"));
        $pluginG['minute']->setSize(3);
        $pluginG['second'] = $form->createElement('text', '{$fieldName}window[second]', $GLOBALS['strSeconds'],
            array("id" => "{$fieldName}windowsecond", "onKeyUp" => "phpAds_formLimitUpdate(this.form);",
                "onBlur" => "phpAds_formLimitBlur(this.form);"));
        $pluginG['second']->setSize(3);
        $form->addGroup($pluginG, 'size', ucfirst($fieldName), "&nbsp;", false);

        //set plugin defaults
        $pluginsCalendarItems = splitSecondsIntoCalendarItems($tracker[$fieldName . 'window']);
        $form->setDefaults(array($fieldName."window[day]" => $clickCalendarItems['day'],
            $fieldName."window[hour]" => $clickCalendarItems['hour'],
            $fieldName."window[minute]" => $clickCalendarItems['minute'],
            $fieldName."window[second]" => $clickCalendarItems['second']));
    }


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

    // Parse the number of seconds in the conversion windows into days, hours, minutes, seconds..
    $clickCalendarItems = splitSecondsIntoCalendarItems($tracker['clickwindow']);
    $form->setDefaults(array("clickwindow[day]" => $clickCalendarItems['day'],
        "clickwindow[hour]" => $clickCalendarItems['hour'],
        "clickwindow[minute]" => $clickCalendarItems['minute'],
        "clickwindow[second]" => $clickCalendarItems['second']));

    $clickclickCalendarItems = splitSecondsIntoCalendarItems($tracker['viewwindow']);
    $form->setDefaults(array("viewwindow[day]" => $clickclickCalendarItems['day'],
        "viewwindow[hour]" => $clickclickCalendarItems['hour'],
        "viewwindow[minute]" => $clickclickCalendarItems['minute'],
        "viewwindow[second]" => $clickclickCalendarItems['second']));

    //validation rules
    $translation = new OA_Translation();
    $nameRequiredMsg = $translation->translate($GLOBALS['strXRequiredField'], array($GLOBALS['strName']));
    $form->addRule('trackername', $nameRequiredMsg, 'required');

    // Get unique trackers
    $doTrackers = OA_Dal::factoryDO('trackers');
    $doTrackers->clientid = $tracker['clientid'];
    $aUnique_names = $doTrackers->getUniqueValuesFromColumn('trackername',
         empty($tracker['trackerid'])? '': $tracker['trackername']);
    $nameUniqueMsg = $translation->translate($GLOBALS['strXUniqueField'],
        array($GLOBALS['strTracker'], strtolower($GLOBALS['strName'])));
    $form->addRule('trackername', $nameUniqueMsg, 'unique', $aUnique_names);


    return $form;
}

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/
function processForm($form, $plugins)
{
    $aFields = $form->exportValues();
    // If ID is not set, it should be a null-value for the auto_increment

    if (empty($aFields['trackerid'])) {
        $aFields['trackerid'] = "null";
    }

    // Set window delays
    if (isset($aFields['clickwindow'])) {
        $clickwindow_seconds = 0;
        if ($aFields['clickwindow']['second'] != '-') {
            $clickwindow_seconds += (int)$aFields['clickwindow']['second'];
        }
        if ($aFields['clickwindow']['minute'] != '-') {
            $clickwindow_seconds += (int)$aFields['clickwindow']['minute'] * 60;
        }
        if ($aFields['clickwindow']['hour'] != '-') {
            $clickwindow_seconds += (int)$aFields['clickwindow']['hour'] * 60*60;
        }
        if ($aFields['clickwindow']['day'] != '-') {
            $clickwindow_seconds += (int)$aFields['clickwindow']['day'] * 60*60*24;
        }
    }
    else {
        $clickwindow_seconds = 0;
    }
    if (isset($aFields['viewwindow'])) {
        $viewwindow_seconds = 0;
        if ($aFields['viewwindow']['second'] != '-') {
            $viewwindow_seconds += (int)$aFields['viewwindow']['second'];
        }
        if ($aFields['viewwindow']['minute'] != '-') {
            $viewwindow_seconds += (int)$aFields['viewwindow']['minute'] * 60;
        }
        if ($aFields['viewwindow']['hour'] != '-') {
            $viewwindow_seconds += (int)$aFields['viewwindow']['hour'] * 60*60;
        }
        if ($aFields['viewwindow']['day'] != '-') {
            $viewwindow_seconds += (int)$aFields['viewwindow']['day'] * 60*60*24;
        }
    } else {
        $viewwindow_seconds = 0;
    }

    $doTrackers = OA_Dal::factoryDO('trackers');
    $doTrackers->trackername = $aFields['trackername'];
    $doTrackers->description = $aFields['description'];
    $doTrackers->clickwindow = $clickwindow_seconds;
    $doTrackers->viewwindow = $viewwindow_seconds;
    $doTrackers->status = $aFields['status'];
    $doTrackers->type = $aFields['type'];
    $doTrackers->linkcampaigns = $aFields['linkcampaigns'] == "t" ? "t" : "f";
    $doTrackers->clientid = $aFields['clientid'];

    foreach ($plugins as $plugin) {
        $dbField = strtolower($plugin->trackerEvent) . 'window';
        $value = ${$dbField}['day'] * (24*60*60) + ${$dbField}['hour'] * (60*60) + ${$dbField}['minute'] * (60) + ${$dbField}['second'];
        $doTrackers->$dbField = $value;
    }

    if (empty($aFields['trackerid']) || $aFields['trackerid'] == "null") {
        $aFields['trackerid'] = $doTrackers->insert();
    }
    else {
        $doTrackers->trackerid = $aFields['trackerid'];
        $doTrackers->update();
    }

    Header("Location: tracker-campaigns.php?clientid=".$aFields['clientid']."&trackerid=".$aFields['trackerid']);
    exit;
}


/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
function displayPage($tracker, $form, $plugins)
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

    foreach ($plugins as $plugin) {
        $aPlugins[]['fieldName'] = strtolower($plugin->trackerEvent);
    }
    $oTpl->assign('aPlugins', $aPlugins);

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

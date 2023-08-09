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

// Prepare the OpenX environment via standard external OpenX scripts
require_once '../../../../init.php';
require_once '../../config.php';
require_once MAX_PATH . $conf['pluginPaths']['plugins'] . '/apVideo/lib/Dal/Admin.php';
require_once MAX_PATH . $conf['pluginPaths']['plugins'] . '/bannerTypeHtml/vastInlineBannerTypeHtml/common.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/component/Form.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients', $clientid);
OA_Permission::enforceAccessToObject('campaigns', $campaignid);
OA_Permission::enforceAccessToObject('banners', $bannerid);
OA_Permission::enforceTrue(AP_Video_Dal_Admin::isAnyVideoBanner($bannerid));

/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'] = $clientid;
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['campaignid'][$clientid] = $campaignid;
phpAds_SessionDataStore();

$doApVideo = OA_Dal::staticGetDO('ext_ap_video', $bannerid);
if (!empty($doApVideo->impression_trackers)) {
    $aBanner = [
        'impression_trackers' => join("\n", json_decode($doApVideo->impression_trackers, true))
    ];
}

if (empty($aBanner) || !is_array($aBanner)) {
    $aBanner = [];
}

$aBanner += [
    'clientid' => $clientid,
    'campaignid' => $campaignid,
    'bannerid' => $bannerid,
];

$oTrans = new OX_Translation($conf['pluginPaths']['packages'] . '/apVideoUI/_lang');

$form = buildBannerTrackersMediaForm($aBanner);

if ($form->validate()) {
    processForm($aBanner, $form);
} else {
    displayPage($aBanner, $form);
}


function buildBannerTrackersMediaForm($aBanner)
{
    global $aTypes, $oTrans;

    $form = new OA_Admin_UI_Component_Form("bannertrackers", "POST", $_SERVER['SCRIPT_NAME']);
    $form->forceClientValidation(true);

    $form->addElement('hidden', 'clientid', $aBanner['clientid']);
    $form->addElement('hidden', 'campaignid', $aBanner['campaignid']);
    $form->addElement('hidden', 'bannerid', $aBanner['bannerid']);

    $form->addElement('header', 'header_trackers', $oTrans->translate("Additional Trackers"));

    $el = $form->addElement('textarea', 'impression_trackers', $oTrans->translate("Impression trackers (one URL per line)"));

    $form->addFormRule('checkUrls');

    //we want submit to be the last element in its own separate section
    $form->addElement('controls', 'form-controls');
    $form->addElement('submit', 'submit', $GLOBALS['strSaveChanges']);

    //set form  values
    $form->setDefaults($aBanner);
    return $form;
}

function processForm($aBanner, $form)
{
    global $aTypes;

    $aFields = $form->exportValues();

    $impressionTrackers = json_encode(splitUrls($aFields['impression_trackers']));

    $doVideo = OA_Dal::staticGetDO('ext_ap_video', $aFields['bannerid']);

    if ($doVideo) {
        $doVideo->impression_trackers = $impressionTrackers;
        $doVideo->update();
    } else {
        $doVideo = OA_Dal::factoryDO('ext_ap_video');
        $doVideo->ad_id = $aFields['bannerid'];
        $doVideo->impression_trackers = $impressionTrackers;
        $doVideo->insert();
    }

    OX_Admin_Redirect::redirect("plugins/apVideoUI/banner-trackers.php?clientid=" . $aFields['clientid'] . "&campaignid=" . $aFields['campaignid'] . "&bannerid=" . $aFields['bannerid']);
}


function displayPage($aBanner, $form)
{
    // Initialise some parameters
    $pageName = basename($_SERVER['SCRIPT_NAME']);
    $agencyId = OA_Permission::getAgencyId();
    $aEntities = ['clientid' => $aBanner['clientid'], 'campaignid' => $aBanner['campaignid'], 'bannerid' => $aBanner['bannerid']];

    // Display navigation
    $aOtherCampaigns = Admin_DA::getPlacements(['agency_id' => $agencyId]);
    $aOtherBanners = Admin_DA::getAds(['placement_id' => $aBanner['campaignid']], false);
    MAX_displayNavigationBanner($pageName, $aOtherCampaigns, $aOtherBanners, $aEntities);

    //get template and display form
    $oTpl = new OA_Admin_Template('form/form.html');

    $oTpl->assign('form', $form->serialize());
    $oTpl->display();

    //footer
    phpAds_PageFooter();
}

function splitUrls($text)
{
    $urls = [];

    foreach (preg_split("/\r?\n/", trim($text)) as $url) {
        $url = trim($url);
        if (!empty($url)) {
            $urls[] = $url;
        }
    }

    return $urls;
}

function checkUrls($aFields)
{
    global $oTrans;

    $errorMessage = $oTrans->translate('Invalid URL: %s');

    $aErrors = [];

    foreach (splitUrls($aFields['impression_trackers']) as $v) {
        if (!preg_match('#^https?://#', $v)) {
            $aErrors['impression_trackers'] = sprintf($errorMessage, htmlspecialchars($v));
            break;
        }
    }

    if (count($aErrors)) {
        return $aErrors;
    }

    return true;
}

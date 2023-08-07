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
OA_Permission::enforceTrue(AP_Video_Dal_Admin::isInlineVideoBanner($bannerid));

/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'] = $clientid;
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['campaignid'][$clientid] = $campaignid;
phpAds_SessionDataStore();

$doApVideo = OA_Dal::staticGetDO('ext_ap_video', $bannerid);
if (!empty($doApVideo->alt_media)) {
    $aBanner = json_decode($doApVideo->alt_media, true);
}

if (empty($aBanner) || !is_array($aBanner)) {
    $aBanner = [];
}

$doBanner = OA_Dal::staticGetDO('banners', $bannerid);

$aParameters = unserialize($doBanner->parameters);

$aTypes = getVastVideoTypes();

$aBanner += [
    'clientid' => $clientid,
    'campaignid' => $campaignid,
    'bannerid' => $bannerid,
    'main_type' => $aParameters['vast_video_type'],
    'main_url' => $aParameters['vast_video_outgoing_filename'],
];

$aBanner[$aBanner['main_type']] = $aBanner['main_url'];

$oTrans = new OX_Translation($conf['pluginPaths']['packages'] . '/apVideoUI/_lang');

$form = buildBannerAltMediaForm($aBanner);

if ($form->validate()) {
    processForm($aBanner, $form);
} else {
    displayPage($aBanner, $form);
}


function buildBannerAltMediaForm($aBanner)
{
    global $aTypes, $oTrans;

    $form = new OA_Admin_UI_Component_Form("banneraltmedia", "POST", $_SERVER['SCRIPT_NAME']);
    $form->forceClientValidation(true);

    $form->addElement('hidden', 'clientid', $aBanner['clientid']);
    $form->addElement('hidden', 'campaignid', $aBanner['campaignid']);
    $form->addElement('hidden', 'bannerid', $aBanner['bannerid']);

    $form->addElement('header', 'header_altmedia', $oTrans->translate("Alternate Media"));

    foreach ($aTypes as $k => $v) {
        $el = $form->addElement('text', $k, sprintf($oTrans->translate("%s Video URL"), $v));
        if ($k == $aBanner['main_type']) {
            $el->freeze();
        }
    }

    $form->addElement(
        'html',
        '',
        <<<EOF
<script type="text/javascript">
            $('input.frozen').addClass('large');
</script>
EOF
    );

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

    $aAltMedia = [];

    foreach ($aTypes as $k => $v) {
        if ($k != $aBanner['main_type'] && !empty($aFields[$k])) {
            $aAltMedia[$k] = $aFields[$k];
        }
    }

    $altMedia = json_encode($aAltMedia);

    $doVideo = OA_Dal::staticGetDO('ext_ap_video', $aFields['bannerid']);

    if ($doVideo) {
        $doVideo->alt_media = $altMedia;
        $doVideo->update();
    } else {
        $doVideo = OA_Dal::factoryDO('ext_ap_video');
        $doVideo->ad_id = $aFields['bannerid'];
        $doVideo->alt_media = $altMedia;
        $doVideo->insert();
    }

    OX_Admin_Redirect::redirect("plugins/apVideoUI/banner-alt-media.php?clientid=" . $aFields['clientid'] . "&campaignid=" . $aFields['campaignid'] . "&bannerid=" . $aFields['bannerid']);
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

function checkUrls($aFields)
{
    global $aTypes, $oTrans;

    $errorMessage = $oTrans->translate('Invalid URL');

    $aErrors = [];
    foreach ($aTypes as $k => $v) {
        if ($k != $aBanner['main_type']) {
            if (!empty($aFields[$k]) && !preg_match('#^https?://#', $aFields[$k])) {
                $aErrors[$k] = $errorMessage;
            }
        }
    }
    if (count($aErrors)) {
        return $aErrors;
    }
    return true;
}

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
require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/component/Form.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('affiliates', $affiliateid);
OA_Permission::enforceAccessToObject('zones', $zoneid);
OA_Permission::enforceTrue(AP_Video_Dal_Admin::isVideoZone($zoneid));

/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['affiliateid'] = $affiliateid;
phpAds_SessionDataStore();


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

// Initialise some parameters
$pageName = basename($_SERVER['SCRIPT_NAME']);
$tabIndex = 1;
$agencyId = OA_Permission::getAgencyId();
$aEntities = ['affiliateid' => $affiliateid, 'zoneid' => $zoneid];

$aOtherPublishers = Admin_DA::getPublishers(['agency_id' => $agencyId]);
$aOtherZones = Admin_DA::getZones(['publisher_id' => $affiliateid]);
MAX_displayNavigationZone($pageName, $aOtherPublishers, $aOtherZones, $aEntities);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$url = MAX_commonConstructSecureDeliveryUrl($conf['file']['frontcontroller']) . '?script=apVideo:vast2&zoneid=' . $zoneid;

$oTrans = new OX_Translation($conf['pluginPaths']['packages'] . '/apVideoUI/_lang');

$message = $oTrans->translate('Below you will find the tag that can be used in video players and other systems that are VAST 2.0 compliant:');

?>
<br />
<br />
<br />
<br />
<h4><?php echo htmlspecialchars($message); ?></h4>
<br />
<br />
<p>
<textarea class='code-gray' rows='5' cols='40' style='width:95%; border: 1px solid black' readonly><?php echo htmlspecialchars($url); ?></textarea>
</p>
<script type='text/javascript'>
$(document).ready(function() {
    $('textarea.code-gray').selectText();
});
</script>
<?php

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

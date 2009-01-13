<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

//
// NOTE: This code has been copied/adapted from affiliate-channels.php
// The actual HTML that is relevant is at the bottom of the page. Feel
// free to refactor it into Smarty templates.

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/OA/Dal.php';

// Register input variables
phpAds_registerGlobal ('acl', 'action', 'submit');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);
OA_Permission::enforceAccessToObject('affiliates', $affiliateid);


// Initialise some parameters
$pageName = basename($_SERVER['PHP_SELF']);
$tabindex = 1;
$agencyId = OA_Permission::getAgencyId();
$aEntities = array('affiliateid' => $affiliateid);

if (!MAX_checkPublisher($affiliateid)) {
    phpAds_Die($strAccessDenied, $strNotAdmin);
}

$doAffiliates = OA_Dal::factoryDO('affiliates');
$doAffiliates->get($affiliateid);

$anWebsiteId = $doAffiliates->as_website_id;

$oacXmlRpcUrl         = $conf['oacXmlRpc']['protocol'] . '://' .
                        $conf['oacXmlRpc']['host'] .
                        ':' . $conf['oacXmlRpc']['port'];
$publisherCentralLink = $oacXmlRpcUrl .
                        $conf['oacXmlRpc']['publihserUrl'] .
                        '?site=' . $anWebsiteId;
$advertiserSignUpLink = $oacXmlRpcUrl .
                        $conf['oacXmlRpc']['signUpUrl'] .
                        '?site=' . $anWebsiteId;
$advertiserSignUpHTML = '&lt;a href="' . $advertiserSignUpLink . '"&gt;' .
                        $advertiserSignUpLink . '&lt;/a&gt;';

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

// Display navigation
$aOtherPublishers = Admin_DA::getPublishers(array('agency_id' => $agencyId));
MAX_displayNavigationPublisher($pageName, $aOtherPublishers, $aEntities);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

?>

<?php
if (!$anWebsiteId) {
?>
This Website is not subscribed to Ad Networks.
<?php
} else { ?>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
   <tr><td height="25" colspan="3"><b><?php echo $strAdvertiserSignupOption ?>/b></td></tr>
   <tr height="1">
   <td width="30"><img width="30" height="1" src="<?php echo OX::assetPath() ?>/images/break.gif"/></td>
      <td width="200"><img width="200" height="1" src="<?php echo OX::assetPath() ?>/images/break.gif"/></td>
      <td width="100%"><img width="100%" height="1" src="<?php echo OX::assetPath() ?>/images/break.gif"/></td>
   </tr>
   <tr>
      <td height="10" colspan="3"></td>
   </tr>
   <tr>
      <td width="100%" colspan="3">
         <?php echo $strAdvertiserSignupOptionDesc ?>
         <a target="_blank" href="<?php echo $publisherCentralLink?>"><?php echo $publisherCentralLink?></a>
      </td>
   </tr>
</tbody>
</table>

<table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-top: 30px">
<tbody>
   <tr><td height="25" colspan="3"><b><?php echo $strAdvertiserSignupLink ?></b></td></tr>
   <tr height="1">
   <td width="30"><img width="30" height="1" src="<?php echo OX::assetPath() ?>/images/break.gif"/></td>
      <td width="200"><img width="200" height="1" src="<?php echo OX::assetPath() ?>/images/break.gif"/></td>
      <td width="100%"><img width="100%" height="1" src="<?php echo OX::assetPath() ?>/images/break.gif"/></td>
   </tr>
   <tr>
      <td height="10" colspan="3"></td>
   </tr>
   <tr>
      <td width="100%" colspan="3">
        <?php echo $strAdvertiserSignupLinkDesc ?>
        <pre class="invocation-codes js"><?php echo $advertiserSignUpHTML?></pre>
      </td>
   </tr>
</tbody>
</table>

<?php
}
?>

<script><!--
  $('pre').bind('mouseover', selectElement);
//-->
</script>
<?php

phpAds_PageFooter();

?>

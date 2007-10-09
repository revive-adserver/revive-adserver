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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-size.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/max/Delivery/cache.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/OA/Central/AdNetworks.php';
require_once MAX_PATH . '/lib/OA/Dll/Publisher.php';

// Register input variables
phpAds_registerGlobalUnslashed('expand', 'collapse', 'hideinactive', 'listorder', 'orderdirection',
                               'pubid', 'url', 'country', 'language', 'category', 'adnetworks', 'formId');

// Security check
MAX_Permission::checkAccess(phpAds_Admin + phpAds_Agency);

// Initialise Ad  Networks
$oAdNetworks = new OA_Central_AdNetworks();


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

$captchaErrorFormId = false;
$aError = false;

if (!empty($formId)) {
    // Setup a new publisher object and set the fields passed in from the form:
    $oPublisher = new OA_Dll_PublisherInfo();
    $oPublisher->publisherId    = $pubid;
    $oPublisher->agencyId       = phpAds_getAgencyID();
    $oPublisher->publisherName  = $url;
    $oPublisher->oacCategoryId  = $category;
    $oPublisher->oacCountryCode = $country;
    $oPublisher->oacLanguageId  = $language;
    $oPublisher->website        = 'http://' . $url;
    $oPublisher->adNetworks     = ($adnetworks == 't') ? true : false;
    $oPublisherDll = new OA_Dll_Publisher();
    if ($oPublisherDll->modify($oPublisher)) {
        if ($formId == 'add_new_publisher_form') {
            MAX_Admin_Redirect::redirect('affiliate-zones.php?affiliateid='.$oPublisher->publisherId);
        }
    } else {
        $aError = array(
            'id' => $pubid,
            'message' => 'There was an error creating/updating the publisher: ' . $oPublisher->_errorMessage
        );
    }
}

phpAds_PageHeader("4.2");
phpAds_ShowSections(array("4.1", "4.2", "4.3"));

/*-------------------------------------------------------*/
/* Get preferences                                       */
/*-------------------------------------------------------*/

if (!isset($listorder))
{
	if (isset($session['prefs']['affiliate-index.php']['listorder']))
		$listorder = $session['prefs']['affiliate-index.php']['listorder'];
	else
		$listorder = '';
}

if (!isset($orderdirection))
{
	if (isset($session['prefs']['affiliate-index.php']['orderdirection']))
		$orderdirection = $session['prefs']['affiliate-index.php']['orderdirection'];
	else
		$orderdirection = '';
}

if (isset($session['prefs']['affiliate-index.php']['nodes']))
	$node_array = explode (",", $session['prefs']['affiliate-index.php']['nodes']);
else
	$node_array = array();



/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('affiliate-index.html');

$loosezones = false;

if (MAX_Admin_Preferences::checkBool('updates_enabled', true)) {
    $aCategories       = $oAdNetworks->getCategoriesFlat();
    $aSelectCategories = $oAdNetworks->getCategoriesSelect();
    $aCountries        = $oAdNetworks->getCountries();
    $aSelectCountries  = $oAdNetworks->getCountriesSelect();
    $aLanguages        = $oAdNetworks->getLanguages();
    $aSelectLanguages  = $oAdNetworks->getLanguagesSelect();
    
    $oTpl->assign('oacEnabled', true);
    $oTpl->assign('categories', $aSelectCategories);
    $oTpl->assign('countries',  $aSelectCountries);
    $oTpl->assign('languages',  $aSelectLanguages);
}

$doAffiliates = OA_Dal::factoryDO('affiliates');
$doAffiliates->addListOrderBy($listorder, $orderdirection);

// Get affiliates and build the tree
if (phpAds_isUser(phpAds_Agency))
{
	$doAffiliates->agencyid = $session['userid'];
}
elseif (phpAds_isUser(phpAds_Affiliate))
{
	$doAffiliates->affiliateid = $session['userid'];
}

$doAffiliates->find();
while ($doAffiliates->fetch() && $row_affiliates = $doAffiliates->toArray())
{
	$affiliates[$row_affiliates['affiliateid']] = $row_affiliates;
	$affiliates[$row_affiliates['affiliateid']]['expand'] = 0;
	$affiliates[$row_affiliates['affiliateid']]['count'] = 0;

    $affiliates[$row_affiliates['affiliateid']]['website'] = preg_replace('#^https?://#', '', $row_affiliates['website']);
    $affiliates[$row_affiliates['affiliateid']]['oac_adnetworks'] = !empty($row_affiliates['oac_website_id']) ? 'yes' : 'no';

    if (!empty($row_affiliates['oac_country_code']) && isset($aCountries[$row_affiliates['oac_country_code']])) {
        $affiliates[$row_affiliates['affiliateid']]['oac_country'] = $aCountries[$row_affiliates['oac_country_code']];
    }
    if (!empty($row_affiliates['oac_language_id']) && isset($aLanguages[$row_affiliates['oac_language_id']])) {
        $affiliates[$row_affiliates['affiliateid']]['oac_language'] = $aLanguages[$row_affiliates['oac_language_id']];
    }
    if (!empty($row_affiliates['oac_category_id']) && isset($aCategories[$row_affiliates['oac_category_id']])) {
        $affiliates[$row_affiliates['affiliateid']]['oac_category'] = $aCategories[$row_affiliates['oac_category_id']];
    }

    if (isset($aError['id']) && $aError['id'] == $row_affiliates['affiliateid']) {
        $row_affiliates['edit']['website']          = $url;
        $row_affiliates['edit']['oac_country_code'] = $country;
        $row_affiliates['edit']['oac_language_id']  = $language;
        $row_affiliates['edit']['oac_category_id']  = $category;
        $row_affiliates['edit']['oac_adnetworks']   = isset($adnetworks) ? 'yes' : 'no';
    }
}

$newAffiliate = array();

if (isset($aError['id'])) {
    if (!$aError['id']) {
        $errorAffiliate = &$newAffiliate;
    } else {
        $affiliates[$aError['id']]['edit'] = array();
        $errorAffiliate = &$affiliates[$aError['id']]['edit'];
    }
    $errorAffiliate = array(
        'website' => $url,
        'oac_country_code' => $country,
        'oac_language_id'  => $language,
        'oac_category_id'  => $category,
        'oac_adnetworks'   => isset($adnetworks) ? 'yes' : 'no'
    );
}

$doAffiliates = OA_Dal::factoryDO('affiliates');

if (phpAds_isUser(phpAds_Agency)) {
    $doAffiliates->agencyid = phpAds_getAgencyID();
}

$countAffiliate = $doAffiliates->count();

$oTpl->assign('affiliates',     $affiliates);
$oTpl->assign('countAffiliate', $countAffiliate);
$oTpl->assign('listorder',      $listorder);
$oTpl->assign('orderdirection', $orderdirection);

if (!empty($oPublisherDll->_errorMessage)) {
    $oTpl->assign('error', 'There was an error creating/updating the publisher: '
        . $oPublisherDll->_errorMessage);
}
$oTpl->assign('captchaErrorFormId', $captchaErrorFormId);
$oTpl->assign('newAffiliate', $newAffiliate);

$oTpl->assign('phpAds_ZoneBanner',          phpAds_ZoneBanner);
$oTpl->assign('phpAds_ZoneInterstitial',    phpAds_ZoneInterstitial);
$oTpl->assign('phpAds_ZonePopup',           phpAds_ZonePopup);
$oTpl->assign('phpAds_ZoneText'.            phpAds_ZoneText);


/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['affiliate-index.php']['listorder'] = $listorder;
$session['prefs']['affiliate-index.php']['orderdirection'] = $orderdirection;
$session['prefs']['affiliate-index.php']['nodes'] = implode (",", $node_array);

phpAds_SessionDataStore();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/
$oTpl->display();

phpAds_PageFooter();

?>

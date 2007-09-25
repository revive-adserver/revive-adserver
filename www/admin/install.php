<?php
/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

define('OA_UPGRADE_RECOVERY_INFORM',          -3);
define('OA_UPGRADE_RECOVERY',                 -2);
define('OA_UPGRADE_ERROR',                    -1);
define('OA_UPGRADE_WELCOME',                   0);
define('OA_UPGRADE_TERMS',                     1);
define('OA_UPGRADE_POLICY',                    5);
define('OA_UPGRADE_SYSCHECK',                  10);
define('OA_UPGRADE_APPCHECK',                  20);
define('OA_UPGRADE_LOGIN',                     25);
define('OA_UPGRADE_DBSETUP',                   30);
define('OA_UPGRADE_UPGRADE',                   35);
define('OA_UPGRADE_INSTALL',                   36);
define('OA_UPGRADE_CONFIGSETUP',               37);
define('OA_UPGRADE_ADMINSETUP',                40);
define('OA_UPGRADE_SITESSETUP',                50);
define('OA_UPGRADE_TAGSSETUP',                 60);
define('OA_UPGRADE_FINISH',                    70);

global $installing, $tabindex;
$installing = true;

require_once '../../init.php';

if (array_key_exists('btn_openads', $_POST) || (OA_INSTALLATION_STATUS == OA_INSTALLATION_STATUS_INSTALLED))
{
    require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
    MAX_Admin_Redirect::redirect('maintenance-banners-check.php?action=Rebuild&returnurl=advertiser-index.php');
}

require_once MAX_PATH.'/lib/OA/Upgrade/Upgrade.php';

// setup oUpgrader, determine whether they are installing or that they can Upgrade
$oUpgrader = new OA_Upgrade();
$oSystemMgr = &$oUpgrader->oSystemMgr;
$oSystemMgr->getAllInfo();
if (!$oSystemMgr->checkMemory()) {
    $memory = getMinimumRequiredMemory() / 1048576;
    echo '<link rel="stylesheet" type="text/css" href="css/install.css"/><br />';
    echo '<div class="sysmessage sysinfoerror" style="text-align: center;">The minimum amount of memory <a href="http://docs.openads.org/openads-2.3-guide/requirements.html" target="_blank" style="color: #990000">required</a> by Openads is <b>'. $memory
        .' MB</b>. <br />Please <a href="http://www.openads.org/support/faq.html" target="_blank" style="color: #990000">increase</a> your PHP memory_limit before continuing.</div>';
    exit(1);
}

@set_time_limit(600);

// required files for header & nav
require_once MAX_PATH . '/lib/max/Admin/Languages.php';
require_once MAX_PATH . '/www/admin/lib-permissions.inc.php';
require_once MAX_PATH . '/www/admin/lib-gui.inc.php';
require_once MAX_PATH . '/www/admin/lib-settings.inc.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';

// clear the $session variable to prevent users pretending to be logged in.
unset($session);
define('phpAds_installing',     true);

// changed form name for javascript dependent fields
$GLOBALS['settings_formName'] = "frmOpenads";

$imgPath = '';
$installStatus = 'unknown';

 /**
 * Return an array of supported DB types
 *
 * @return array
 */
function getSupportedDbTypes()
{
    // These values must be the same as used for the
    // data access layer file names!
    $types['mysql'] = 'MySQL';
    $types['pgsql'] = 'PostgreSQL';
    return $types;
}

 /**
 * Return an array of supported Table types
 *
 * @return array
 */
function getSupportedTableTypes()
{
    // These values must be the same as used for the
    // data access layer file names!
    $types['MYISAM'] = 'MyISAM';
    $types['INNODB'] = 'InnoDB';
    return $types;
}

 /**
 * Checks a folder to make sure it exists and is writable
 *
 * @param  int Folder the directory that needs to be tested
 * @return boolean - true if folder exists and is writable
 */
function checkFolderPermissions($folder) {
    if (!file_exists($folder))
    {
        return false;
    }
    elseif (!is_writable($folder))
    {
        return false;
    }
    return true;
}

/**
 * Check administrator login during the upgrade steps
 *
 * @todo Refactor and/or move parts of this function to a more appropriate place
 *
 * @return boolean True if login succeded
 */
function checkLogin()
{
    if (empty($_COOKIE['oat']) || $_COOKIE['oat'] != OA_UPGRADE_UPGRADE) {
        return true;
    }

    // Make sure that the preferences array wasn't injected
    $GLOBALS['_MAX']['PREF'] = array();

    $oUpgrader = new OA_Upgrade();

    $openadsDetected = $oUpgrader->detectOpenads(true) ||
        $oUpgrader->existing_installation_status == OA_STATUS_CURRENT_VERSION;

    // Sequentially check, to avoid useless work
    if (!$openadsDetected) {
        if (!($panDetected = $oUpgrader->detectPAN(true))) {
            if (!($maxDetected = $oUpgrader->detectMAX(true))) {
                $max01Detected = $oUpgrader->detectMAX01(true);
            }
        }
    }

    if ($openadsDetected || $panDetected || $maxDetected || $max01Detected) {
        if ($openadsDetected) {
            // Openads 2.3+ - Load admin username and password using the preference DAL
            require_once MAX_PATH . '/lib/max/Admin/Preferences.php';
            MAX_Admin_Preferences::loadPrefs();
        } else {
            // Old versions - Load admin username and password using hardcoded queries
            $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];

            if ($panDetected) {
                $table = 'config';
                $where = '';
            } else {
                $table = $max01Detected ? 'config' : 'preference';
                $where = ' WHERE agencyid = 0';
            }
            $oDbh = OA_DB::singleton();
            if (!PEAR::isError($oDbh)) {
                $aPref = $oDbh->queryRow("SELECT admin, admin_pw FROM {$prefix}{$table}{$where}",
                    null,
                    MDB2_FETCHMODE_ASSOC);

                if (is_array($aPref)) {
                    $GLOBALS['_MAX']['PREF'] = $aPref;
                }
            }
        }
    }

    phpAds_SessionStart();
    phpAds_SessionDataFetch();

    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username  = MAX_commonGetPostValueUnslashed('username');
        $password  = MAX_commonGetPostValueUnslashed('password');

        $md5digest = md5($password);

        // Clean up session
        $GLOLBALS['session'] = array();

        if (phpAds_isAdmin($username, $md5digest)) {
            phpAds_SessionDataRegister(MAX_Permission_User::getAAdminData($username));
        }

        phpAds_SessionDataStore();
    }

    return phpAds_isUser(phpAds_Admin);
}

if (array_key_exists('btn_startagain', $_POST))
{
    // Delete the cookie if user is restarting upgrader
    setcookie('oat', '');
}

if ($oUpgrader->isRecoveryRequired())
{
    if (array_key_exists('btn_recovery', $_POST))
    {
        $oUpgrader->recoverUpgrade();
        $action = OA_UPGRADE_RECOVERY;
    }
    else
    {
        $action = OA_UPGRADE_RECOVERY_INFORM;
    }
}
else if (array_key_exists('btn_syscheck', $_POST) || $_POST['dirPage'] == OA_UPGRADE_SYSCHECK)
{
    // store updates_enabled value into session, so that they can be inserted into DB once DB has been created
    session_start();

    if (isset($_POST['hdn_policy'])) {
        $_SESSION['updates_enabled'] = isset($_POST['updates_enabled']);
    }

    $aSysInfo = $oUpgrader->checkEnvironment();

    // Do not check for an upgrade package if environment errors exist
    if (!$aSysInfo['PERMS']['error'] && !$aSysInfo['PHP']['error'] && !$aSysInfo['FILES']['error'])
    {
        $halt = !$oUpgrader->canUpgrade();
        $installStatus = $oUpgrader->existing_installation_status;
        if ($installStatus == OA_STATUS_CURRENT_VERSION) {
            // Do not halt if the version is current
            $halt = false;
        }
    } else {
        $message = $strFixErrorsBeforeContinuing;
    }

    $action   = OA_UPGRADE_SYSCHECK;
}
else if (array_key_exists('btn_appcheck', $_POST))
{
    $action = OA_UPGRADE_APPCHECK;
}
else if (array_key_exists('btn_login', $_POST))
{
    $action = OA_UPGRADE_LOGIN;
}
else if (array_key_exists('btn_dbsetup', $_POST))
{
    if (!checkLogin()) {
        $message = $strUsernameOrPasswordWrong;
        $action = OA_UPGRADE_LOGIN;
    }
    elseif ($oUpgrader->canUpgrade())
    {
        $installStatus = $oUpgrader->existing_installation_status;

        if ($installStatus != OA_STATUS_NOT_INSTALLED &&
            (empty($_COOKIE['oat']) || $_COOKIE['oat'] != OA_UPGRADE_UPGRADE)) {
            // Hey, what's going on, we shouldn't be here, go back to login!
            $action = OA_UPGRADE_LOGIN;
        } else {
            $aDatabase = $oUpgrader->aDsn;
            $action    = OA_UPGRADE_DBSETUP;
        }
    }
    else
    {
        $installStatus = $oUpgrader->existing_installation_status;
        if ($installStatus == OA_STATUS_CURRENT_VERSION)
        {
            $message = 'Openads is up to date';
            $strInstallSuccess = $strOaUpToDate;
            $action = OA_UPGRADE_FINISH;
        }
        else
        {
            $action = OA_UPGRADE_ERROR;
        }
    }
}
else if (array_key_exists('btn_upgrade', $_POST))
{
    if (!checkLogin()) {
        $message = $strUsernameOrPasswordWrong;
        $action = OA_UPGRADE_LOGIN;
    }
    elseif ($oUpgrader->canUpgrade())
    {
        $installStatus = $oUpgrader->existing_installation_status;

        if ($installStatus == OA_STATUS_NOT_INSTALLED)
        {
            if ($oUpgrader->install($_POST['aConfig']))
            {
                $message = 'Your database has successfully been created for Openads '.OA_VERSION;
                $action  = OA_UPGRADE_INSTALL;
            }
        }
        else
        {
            if (empty($_COOKIE['oat']) || $_COOKIE['oat'] != OA_UPGRADE_UPGRADE) {
                // Hey, what's going on, we shouldn't be here, go back to login!
                $action = OA_UPGRADE_LOGIN;
            }
            elseif ($oUpgrader->upgrade($oUpgrader->package_file))
            {
                $message = 'Your database has successfully been upgraded to Openads version '.OA_VERSION;
                $action  = OA_UPGRADE_UPGRADE;
            }
        }
    }

    if ((($action != OA_UPGRADE_UPGRADE) && ($action != OA_UPGRADE_INSTALL) && ($action != OA_UPGRADE_LOGIN)) || $oUpgrader->oLogger->errorExists)
    {
        // if they're being redirected from an install, they will have DB info in POST, otherwise they will have DBinfo in CONF
        if ($_POST['aConfig']) {
            $aDatabase = $_POST['aConfig'];
        } else {
            $aDatabase['database'] = $GLOBALS['_MAX']['CONF']['database'];
            $aDatabase['table']    = $GLOBALS['_MAX']['CONF']['table'];
        }

        $displayError = true;
        $action = OA_UPGRADE_DBSETUP;
    }
}
else if (array_key_exists('btn_configsetup', $_POST))
{
    if (!checkLogin()) {
        $message = $strUsernameOrPasswordWrong;
        $action = OA_UPGRADE_LOGIN;
    }
    else
    {
        $aConfig = $oUpgrader->getConfig();
        $action = OA_UPGRADE_CONFIGSETUP;
    }
}
else if (array_key_exists('btn_adminsetup', $_POST))
{
    if (!checkLogin()) {
        $message = $strUsernameOrPasswordWrong;
        $action = OA_UPGRADE_LOGIN;
    }
    else
    {
        // acquire the community preferences from session in order to add them to preferences table using putCommunityPreferences
        $aCommunity = array();
        session_start();
        $aCommunity['updates_enabled']         = $_SESSION['updates_enabled'];

        // Always use the path we're using to install as admin UI path
        $aConfig = $oUpgrader->getConfig();
        $_POST['aConfig']['webpath']['admin'] = $aConfig['webpath']['admin'];

        if ($oUpgrader->saveConfig($_POST['aConfig']) && $oUpgrader->putCommunityPreferences($aCommunity))
        {
            if (!checkFolderPermissions($_POST['aConfig']['store']['webDir'])) {
                $aConfig                    = $_POST['aConfig'];
                $aConfig['store']['webDir'] = stripslashes($aConfig['store']['webDir']);
                $errMessage                 = $strImageDirLockedDetected;
                $action                     = OA_UPGRADE_CONFIGSETUP;
            } else {
                if ($_COOKIE['oat'] == OA_UPGRADE_INSTALL)
                {
                    //$oUpgrader->getAdmin();
                    $action = OA_UPGRADE_ADMINSETUP;
                }
                else
                {
                    //Hide the IDsetup, instead display the finish page
                    //$action = OA_UPGRADE_SITESSETUP;
                    $message = 'Congratulations you have finished upgrading Openads';
                    //$oUpgrader->setOpenadsInstalledOn();
                    $action = OA_UPGRADE_FINISH;
                }
            }
        }
        else
        {
            $aConfig    = $_POST['aConfig'];
            if ($_COOKIE['oat'] == OA_UPGRADE_INSTALL) {
                $errMessage = 'We are unable to create your configuration file. Please re-check the permissions of the Openads var folder.';
            } else {
                $errMessage = 'We are unable to update your configuration file. Please re-check the permissions of the Openads var folder, and also check the permissions of the previous install\'s config file that you copied into this folder.';
            }
            $action     = OA_UPGRADE_CONFIGSETUP;
        }
    }
}
else if (array_key_exists('btn_adminsetup_back', $_POST))
{
    if (!checkLogin()) {
        $message = $strUsernameOrPasswordWrong;
        $action = OA_UPGRADE_LOGIN;
    }
    else
    {
        $aAdmin = unserialize(stripslashes($_POST['aAdminPost']));
        $action = OA_UPGRADE_ADMINSETUP;
    }
}
else if (array_key_exists('btn_tagssetup', $_POST))
{
    if (!checkLogin()) {
        $message = $strUsernameOrPasswordWrong;
        $action = OA_UPGRADE_LOGIN;
    }
    else
    {
        $aPref = $GLOBALS['_MAX']['PREF'];

        $action = OA_UPGRADE_FINISH;

        $aWebsites    = array(
            0 => array(),
            1 => array()
        );

        if (isset($_POST['aUrls']) && is_array($_POST['aUrls'])) {
            phpAds_registerGlobalUnslashed('aUrls', 'aCountries', 'aLanguages', 'aCategories', 'aAdnetworks');

            $aTplSites = array();
            foreach ($aUrls as $key => $url) {
                $isOac = $aAdnetworks[$key] == 'true' ? 1 : 0;

                $aWebsites[$isOac][] = $aTplSites[count($aTplSites)+1] = array(
                    'url'        => $url,
                    'country'    => $aCountries[$key],
                    'language'   => $aLanguages[$key],
                    'category'   => $aCategories[$key],
                    'adnetworks' => $isOac
                );
            }

            foreach ($aWebsites[0] as $v) {
                $doAffiliate = OA_Dal::factoryDO('affiliates');
                $publisher = array(
                    'name'             => $v['url'],
                    'mnemonic'         => '',
                    'contact'          => $aPref['admin_name'],
                    'email'            => $aPref['admin_email'],
                    'website'          => 'http://'.$v['url'],
                    'oac_country_code' => $v['country'],
                    'oac_language_id'  => $v['language'],
                    'oac_category_id'  => $v['category']
                );

                $doAffiliate->setFrom($publisher);
                $doAffiliate->insert();
            }

            if (count($aWebsites[1])) {
                require_once MAX_PATH . '/lib/OA/Central/AdNetworks.php';
                $oAdNetworks = new OA_Central_AdNetworks();
                $result = $oAdNetworks->subscribeWebsites($aWebsites[1]);

                if (PEAR::isError($result)) {
                    // Initialise template
                    $oTpl = new OA_Admin_Template('install/sites.html');

                    $oTpl->assign('aSelectCategories', $oAdNetworks->getCategoriesSelect());
                    $oTpl->assign('aSelectCountries',  $oAdNetworks->getCountriesSelect());
                    $oTpl->assign('aSelectLanguages',  $oAdNetworks->getLanguagesSelect());

                    // We need to pass back the submitted values to the form
                    $oTpl->assign('aSites', $aTplSites);

                    if ($result->getCode() == 802) {
                        // Captcha error
                        $oTpl->assign('captchaErrorFormId', 'frmOpenads');
                    } else {
                        // Other error
                    }

                    $action = OA_UPGRADE_SITESSETUP;
                } else {
                    require_once MAX_PATH . '/lib/max/Admin/Invocation.php';

                    // Initialise template
                    $oTpl = new OA_Admin_Template('install/tags.html');

                    $doAffiliates = OA_Dal::factoryDO('affiliates');
                    $doAffiliates->selectAdd();
                    $doAffiliates->selectAdd('affiliateid');
                    $doAffiliates->selectAdd('name');
                    $doAffiliates->selectAdd('mnemonic'); // Needed for SPC
                    $doAffiliates->whereAdd('oac_website_id IS NOT NULL');
                    $doAffiliates->orderBy('name');

                    $aAffiliates = $doAffiliates->getAll(array(), true, false);

                    $doZones = OA_Dal::factoryDO('zones');
                    $doZones->orderBy('width = -1, height = 1, width, height');

                    $aSizes = array();
                    $spcHeader = '';
                    $doZones->find();
                    while ($doZones->fetch()) {
                        $row = $doZones->toArray();
                        if (!isset($aAffiliates[$row['affiliateid']])) {
                            continue;
                        }
                        $width = $row['width'] == -1 ? '*' : $row['width'];
                        $height = $row['height'] == -1 ? '*' : $row['height'];
                        $aAffiliates[$row['affiliateid']]['zones'][$row['zoneid']] = array(
                            'name' => $row['zonename'],
                            'width' => $width,
                            'height' => $height
                        );

                        $affiliateid = $row['affiliateid'];
                        $zoneid = $row['zoneid'];

                        $codetype = 'spc';
                        $invocationTag = MAX_Plugin::factory('invocationTags', $codetype);
                        $maxInvocation = new MAX_Admin_Invocation();
                        $maxInvocation->generateInvocationCode($invocationTag);
                        if (!$spcHeader) {
                            $spcHeader = $invocationTag->getHeaderCode();
                        }
                        $aAffiliates[$row['affiliateid']]['zones'][$row['zoneid']][$codetype] =
                            $invocationTag->getZoneCode($row, $aAffiliates[$row['affiliateid']]);

                        foreach (array('local', 'adframe') as $v){
                            $codetype = $v;
                            $maxInvocation = new MAX_Admin_Invocation();
                            $aAffiliates[$row['affiliateid']]['zones'][$row['zoneid']][$codetype] =
                                $maxInvocation->generateInvocationCode($invocationTag = null);
                        }

                        $aSizes[$width.'x'.$height] = array('width' => $width, 'height' => $height);
                    }

                    $oTpl->assign('aAffiliates', $aAffiliates);
                    $oTpl->assign('aSizes', $aSizes);
                    $oTpl->assign('spcHeader', $spcHeader);

                    $action = OA_UPGRADE_TAGSSETUP;
                }
            }
        }
    }
}
else if (array_key_exists('btn_sitessetup', $_POST))
{
    if (!checkLogin()) {
        $message = $strUsernameOrPasswordWrong;
        $action = OA_UPGRADE_LOGIN;
    }
    else
    {
        if ($_COOKIE['oat'] == OA_UPGRADE_INSTALL)
        {
            // Save admin credentials
            $_POST['aAdmin']['updates_enabled'] = $_POST['updates_enabled'];
            $oUpgrader->putAdmin($_POST['aAdmin']);

            // Initialise template
            $oTpl = new OA_Admin_Template('install/sites.html');

            require_once MAX_PATH . '/lib/OA/Central/AdNetworks.php';
            $oAdNetworks = new OA_Central_AdNetworks();

            $oTpl->assign('aSelectCategories', $oAdNetworks->getCategoriesSelect());
            $oTpl->assign('aSelectCountries',  $oAdNetworks->getCountriesSelect());
            $oTpl->assign('aSelectLanguages',  $oAdNetworks->getLanguagesSelect());

            $oTpl->assign('aSites', array(
                1 => array('url' => '')
            ));

            $action = OA_UPGRADE_SITESSETUP;
        }
        else
        {
            $action = OA_UPGRADE_FINISH;
            $message = 'Congratulations you have finished upgrading Openads';
        }
    }
}
else if (array_key_exists('btn_terms', $_POST))
{
    $action = OA_UPGRADE_TERMS;
}
else if (array_key_exists('btn_policy', $_POST))
{
    session_start();

    $action = OA_UPGRADE_POLICY;
}
else if (array_key_exists('btn_finish', $_POST))
{
    if ($_COOKIE['oat'] == OA_UPGRADE_INSTALL)
    {
        // Log the user in
        require_once MAX_PATH . '/lib/max/Admin/Preferences.php';
        MAX_Admin_Preferences::loadPrefs();
        phpAds_SessionStart();
        phpAds_SessionDataRegister(MAX_Permission_User::getAAdminData($GLOBALS['_MAX']['PREF']['admin']));
        phpAds_SessionDataStore();

        $message = 'Congratulations you have finished installing Openads';
    }
    else
    {
        $message = 'Congratulations you have finished upgrading Openads';
    }
    //$oUpgrader->setOpenadsInstalledOn();
    $action = OA_UPGRADE_FINISH;
}
else if (array_key_exists('dirPage', $_POST) && !empty($_POST['dirPage']))
{
    $action = $_POST['dirPage'];
    if ($_POST['dirPage'] == OA_UPGRADE_SYSCHECK) {
        $aSysInfo = $oUpgrader->checkEnvironment();
        $halt = !$oUpgrader->canUpgrade();
        if (!$halt)
        {
            $halt = !$oUpgrader->checkUpgradePackage();
        }
    }
}
else
{
    $action = OA_UPGRADE_WELCOME;
}

if ($action == OA_UPGRADE_FINISH)
{
    // Delete the cookie
    setcookie('oat', '');
    $oUpgrader->setOpenadsInstalledOn();

    if (!$oUpgrader->removeUpgradeTriggerFile())
    {
        $message.= '. '.$strRemoveUpgradeFile;
        $strInstallSuccess = '<div class="sysinfoerror">'.$strOaUpToDateCantRemove.'</div>'.$strInstallSuccess;
    }
}

if ($installStatus == OA_STATUS_OAD_NOT_INSTALLED)
{
    setcookie('oat', OA_UPGRADE_INSTALL);
    $_COOKIE['oat'] = OA_UPGRADE_INSTALL;
}
elseif ($installStatus !== 'unknown')
{
    setcookie('oat', OA_UPGRADE_UPGRADE);
    $_COOKIE['oat'] = OA_UPGRADE_UPGRADE;
}

// Used to detmine which page is active in nav
$activeNav = array (
                    OA_UPGRADE_WELCOME        =>      '10',
                    OA_UPGRADE_TERMS          =>      '20',
                    OA_UPGRADE_POLICY         =>      '25',
                    OA_UPGRADE_SYSCHECK       =>      '30',
                    OA_UPGRADE_APPCHECK       =>      '30',
                    OA_UPGRADE_DBSETUP        =>      '50',
                    OA_UPGRADE_UPGRADE        =>      '50',
                    OA_UPGRADE_INSTALL        =>      '50',
                    OA_UPGRADE_CONFIGSETUP    =>      '60',
                    OA_UPGRADE_FINISH         =>      '100'
                  );
if (!empty($_COOKIE['oat']) && $_COOKIE['oat'] != OA_UPGRADE_UPGRADE) {
    $activeNav[OA_UPGRADE_ADMINSETUP]     =      '70';
    $activeNav[OA_UPGRADE_SITESSETUP]     =      '80';
    $activeNav[OA_UPGRADE_TAGSSETUP]      =      '90';
} else {
    $activeNav[OA_UPGRADE_LOGIN]          =      '45';
}

ksort($activeNav);

// setup the nav to determine whether or not to show a valid link
$navLinks = array();
foreach ($activeNav as $key=>$val) {
    if ($val <= $activeNav[$action] && $action <= OA_UPGRADE_DBSETUP) {
        $navLinks[$key] = 'javascript: changePage('.$key.')';
    } else {
        $navLinks[$key] = '';
    }
}

// Setup array for navigation
$phpAds_nav = array (
    '10'     =>  array($navLinks[OA_UPGRADE_WELCOME]     => 'Welcome'),
    '20'     =>  array($navLinks[OA_UPGRADE_TERMS]       => 'Terms'),
    '25'     =>  array($navLinks[OA_UPGRADE_POLICY]      => 'Policy'),
    '30'     =>  array($navLinks[OA_UPGRADE_SYSCHECK]    => 'System Check'),
    '40'     =>  array($navLinks[OA_UPGRADE_APPCHECK]    => 'Application Check'),
    '45'     =>  array($navLinks[OA_UPGRADE_LOGIN]       => 'Login'),
    '50'     =>  array($navLinks[OA_UPGRADE_DBSETUP]     => 'Database'),
    '60'     =>  array($navLinks[OA_UPGRADE_CONFIGSETUP] => 'Configuration'),
    '70'     =>  array($navLinks[OA_UPGRADE_ADMINSETUP]  => 'Admin'),
    '80'     =>  array($navLinks[OA_UPGRADE_SITESSETUP]  => 'Sites'),
    '90'     =>  array($navLinks[OA_UPGRADE_TAGSSETUP]   => 'Tags'),
    '100'    =>  array('' => 'Finished')
);

// display header, with proper 'active page' marked using $activeNav[$action]
phpAds_PageHeader($activeNav[$action],'', $imgPath, false, false);

// setup which sections to display
$showSections = array();
foreach ($activeNav as $val) {
    if (!in_array($val, $showSections))
        $showSections[] = $val;
}

// display navigation
phpAds_ShowSections($showSections, false, true, $imgPath, $phpAds_nav);

// calculate percentage complete
$totalNav     = count($showSections)-1;
$progressRate = 100 / $totalNav;
foreach($showSections as $key=>$val) {
    if ($val == $activeNav[$action]) {
        if ($key == 0) {
            $progressVal = 0;
        } elseif ($key == $totalNav) {
            $progressVal = 100;
        } else {
            $progressVal = round(($key) * $progressRate);
        }
        break;
    } else {
        $progressVal = 0;
    }
}
// display main template
include 'templates/install-index.html';

// display footer
phpAds_PageFooter($imgPath);

?>

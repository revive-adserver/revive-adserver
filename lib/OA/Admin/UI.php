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

require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/SmartyInserts.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/UI.php';

/**
 * A class to generate all the UI parts
 *
 */
class OA_Admin_UI
{
    /**
     * @var OA_Admin_Template
     */
    var $oTpl;

    /**
     * Class constructor
     *
     * @return OA_Admin_UI
     */
    function OA_Admin_UI()
    {
        $this->oTpl = new OA_Admin_Template('layout/main.html');
    }

    /**
     * Show page header
     *
     * @param int $ID
     * @param int $extra
     * @param int $imgPath A relative path to Images, CSS files. Used if calling function
     *                     from anything other than admin folder
     * @param bool $showSidebar Set to false if you do not wish to show the grey sidebar
     * @param bool $showMainNav Set to false if you do not wish to show the main navigation
     * @param bool $noBorder Set to true to hide white borders in the main part
     */
    function showHeader($ID, $extra="", $imgPath="", $showSidebar=true, $showMainNav=true, $noBorder = false)
    {
        global $phpAds_TextDirection;
        global $phpAds_GUIDone;
        global $phpAds_context, $phpAds_shortcuts;
        global $pages;
        global $phpAds_CharSet;
        global $OA_Navigation, $OA_Navigation_ID;
        global $xajax, $session;

        $conf = $GLOBALS['_MAX']['CONF'];
        $pref = $GLOBALS['_MAX']['PREF'];

        $phpAds_GUIDone = true;
        $OA_Navigation_ID   = $ID;

        $aNav           = array();
        $aSide          = array();
        $aSideContext   = array();
        $aSideShortcuts = array();

        $pageTitle = !empty($conf['ui']['applicationName']) ? $conf['ui']['applicationName'] : MAX_PRODUCT_NAME;

        // Travel navigation
        if ($ID != phpAds_Login && $ID != phpAds_Error) {
            // Select active navigation array
            $accountType = OA_Permission::getAccountType();
            $pages = isset($OA_Navigation[$accountType]) ? $OA_Navigation[$accountType] : array();

            // Build sidebar
            $sections = explode('.', $ID);
            $sectionID = '';

            for ($i = 0; $i < count($sections) - 1; $i++)
            {
                $sectionID .= $sections[$i];
                list($filename, $title) = each($pages[$sectionID]);
                $sectionID .= ".";

                $linkUp    = $i == count($sections) - 2;
                $linkTop   = !$i;
                $linkFirst = $i == 1;

                $aSide[] = array(
                    'title' => $title,
                    'filename' => $filename,
                    'top' => $i == 0,
                    'up'  => $i == count($sections) - 2,
                    'first' => $i == 1,
                    'current' => false
                );
            }

            if (isset($pages[$ID]) && is_array($pages[$ID])) {
                list($filename, $title) = each($pages[$ID]);
                $aSide[] = array(
                    'title' => $title,
                    'filename' => $filename,
                    'top' => count($sections) <= 1,
                    'up'  => false,
                    'first' => count($sections) == 2,
                    'current' => count($sections) > 1
                );

                $pageTitle .= ' - '.$title;
            }

            $up_limit = count($phpAds_context);
            $down_limit = 0;

            // Build Context
            if (count($phpAds_context)) {
                $selectedcontext = '';
                for ($ci = $down_limit; $ci < $up_limit; $ci++) {
                    if ($phpAds_context[$ci]['selected']) {
                        $selectedcontext = $ci;
                    }
                }
                for ($ci = $down_limit; $ci < $up_limit; $ci++) {
                    if ($ci == $selectedcontext - 1) {
                        $phpAds_context[$ci]['accesskey'] = $GLOBALS['keyPreviousItem'];
                    }
                    if ($ci == $selectedcontext + 1) {
                        $phpAds_context[$ci]['accesskey'] = $GLOBALS['keyNextItem'];
                    }
                }

                $aSideContext = $phpAds_context;
            }

            // Include shortcuts
            if (count($phpAds_shortcuts)) {
                $aSideShortcuts = $phpAds_shortcuts;
            }

            // Build tabbed navigation bar
            foreach (array_keys($pages) as $key) {
                if (strpos($key, '.') === false) {
                    reset($pages[$key]);
                    list($filename, $title) = each($pages[$key]);
                    $aNav[] = array(
                        'title'    => $title,
                        'filename' => $filename,
                        'selected' => $key == $sections[0]
                    );
                }
            }
        } else {
            // Build tabbed navigation bar
            if ($ID == phpAds_Login) {
                $aNav[] = array(
                    'title'    => $GLOBALS['strAuthentification'],
                    'filename' => 'index.php',
                    'selected' => true
                );
            } elseif ($ID == phpAds_Error) {
                $aNav[] = array(
                    'title'    => $GLOBALS['strError'],
                    'filename' => 'index.php',
                    'selected' => true
                );
            }
        }

        // Tabbed navigation bar and sidebar
        $this->oTpl->assign('aNav', $aNav);
        $this->oTpl->assign('aSide', $aSide);
        $this->oTpl->assign('aSideContext', $aSideContext);
        $this->oTpl->assign('aSideShortcuts', $aSideShortcuts);

        // Include custom HTML for the sidebar
        if ($extra) {
            $this->oTpl->assign('sidebarExtra', $extra);
        }

        // Use gzip content compression
        if (isset($conf['ui']['gzipCompression']) && $conf['ui']['gzipCompression']) {
            ob_start("ob_gzhandler");
        }

        // Send header with charset info
        header ("Content-Type: text/html".(isset($phpAds_CharSet) && $phpAds_CharSet != "" ? "; charset=".$phpAds_CharSet : ""));

        // Generate layout
        $this->oTpl->assign('pageTitle', $pageTitle);
        $this->oTpl->assign('imgPath', $imgPath);
        $this->oTpl->assign('metaGenerator', MAX_PRODUCT_NAME.' v'.OA_VERSION.' - http://'.MAX_PRODUCT_URL);

        // Defaults for validation
        $aLocale = localeconv();
        if (isset($GLOBALS['phpAds_ThousandsSeperator'])) {
            $separator = $GLOBALS['phpAds_ThousandsSeperator'];
        } elseif (isset($aLocale['thousands_sep'])) {
            $separator = $aLocale['thousands_sep'];
        } else {
            $separator = ',';
        }

        $this->oTpl->assign('thousandsSeperator', $separator);
        $this->oTpl->assign('strFieldContainsErrors', html_entity_decode($GLOBALS['strFieldContainsErrors']));
        $this->oTpl->assign('strFieldFixBeforeContinue1', html_entity_decode($GLOBALS['strFieldFixBeforeContinue1']));
        $this->oTpl->assign('strFieldFixBeforeContinue2', html_entity_decode($GLOBALS['strFieldFixBeforeContinue2']));
        $this->oTpl->assign('strWarningMissing', html_entity_decode($GLOBALS['strWarningMissing']));
        $this->oTpl->assign('strWarningMissingOpening', html_entity_decode($GLOBALS['strWarningMissingOpening']));
        $this->oTpl->assign('strWarningMissingClosing', html_entity_decode($GLOBALS['strWarningMissingClosing']));
        $this->oTpl->assign('strSubmitAnyway', html_entity_decode($GLOBALS['strSubmitAnyway']));

        // Javascript and stylesheets to include
        $this->oTpl->assign('genericStylesheets', urlencode(implode(',', $this->genericStylesheets())));
        $this->oTpl->assign('genericJavascript', urlencode(implode(',', $this->genericJavascript())));
        $this->oTpl->assign('aGenericStyleshets', $this->genericStylesheets());
        $this->oTpl->assign('aGenericJavascript', $this->genericJavascript());
        $this->oTpl->assign('combineAssets', $conf['ui']['combineAssets']);

        if (!empty($session['RUN_MPE']) && $session['RUN_MPE']) {
            require_once MAX_PATH . '/www/admin/lib-maintenance-priority.inc.php';
            $this->oTpl->assign('jsMPE', $xajax->getJavascript(MAX::assetPath(), 'js/xajax.js'));
        }

        if (!defined('phpAds_installing')) {
            // Include the flashObject resource file
            $this->oTpl->assign('jsFlash', MAX_flashGetFlashObjectExternal());
        }

        // Branding
        $this->oTpl->assign('applicationName', $conf['ui']['applicationName']);
        $this->oTpl->assign('logoFilePath', $conf['ui']['logoFilePath']);
        $this->oTpl->assign('productName', MAX_PRODUCT_NAME);

        $displaySearch = ($ID != phpAds_Login && $ID != phpAds_Error && OA_Auth::isLoggedIn() && OA_Permission::isAccount(OA_ACCOUNT_MANAGER) && !defined('phpAds_installing'));
        $this->oTpl->assign('displaySearch', $displaySearch);
        $this->oTpl->assign('searchUrl', MAX::constructURL(MAX_URL_ADMIN, 'admin-search.php'));

        // Show currently logged on user and IP
        if (OA_Auth::isLoggedIn() || defined('phpAds_installing')) {
            $this->oTpl->assign('helpLink', OA_Admin_Help::getDocLinkFromPhpAdsNavId($OA_Navigation_ID));
            if (!defined('phpAds_installing')) {
                $this->oTpl->assign('infoUser', OA_Permission::getUsername());
                $this->oTpl->assign('buttonLogout', true);
                $this->oTpl->assign('buttonReportBugs', true);

                // Account switcher
                $this->oTpl->assign('strWorkingAs', $GLOBALS['strWorkingAs']);
                $aAccounts = array();
                foreach (OA_Permission::getLinkedAccounts(true, true) as $k => $v) {
                    $workingFor = sprintf($GLOBALS['strWorkingFor'], ucfirst(strtolower($k)));
                    $aAccounts[$workingFor] = $v;
                }
                reset($aAccounts);
                if (key($aAccounts) == sprintf($GLOBALS['strWorkingFor'], ucfirst(strtolower(OA_ACCOUNT_ADMIN)))) {
                    $aAdminAccounts = array_shift($aAccounts);
                } else {
                    $aAdminAccounts = array();
                }
                $this->oTpl->assign('aAdminAccounts', $aAdminAccounts);
                $this->oTpl->assign('aAccounts', $aAccounts);
                $this->oTpl->assign('accountId', OA_Permission::getAccountId());
                $this->oTpl->assign('accountName', OA_Permission::getAccountName());

                $this->oTpl->assign('productUpdatesCheck',
                    OA_Permission::isAccount(OA_ACCOUNT_ADMIN) &&
                    $conf['sync']['checkForUpdates'] &&
                    !isset($session['maint_update_js'])
                );

                $this->oTpl->assign('maintenanceAlert', OA_Dal_Maintenance_UI::alertNeeded());

            } else {
                $this->oTpl->assign('buttonStartOver', true);
            }
        }

        $this->oTpl->assign('showMainNav', $showMainNav);
        $this->oTpl->assign('showSidebar', $showSidebar);
        $this->oTpl->assign('noBorder', $noBorder);

        $this->oTpl->assign('uiPart', 'header');
        $this->oTpl->display();
    }

    function showFooter()
    {
        global $session;

        $aConf = $GLOBALS['_MAX']['CONF'];

        $this->oTpl->assign('uiPart', 'footer');
        $this->oTpl->display();

        // Clean up MPE session variable
        if (!empty($session['RUN_MPE']) && $session['RUN_MPE'] === true) {
            unset($session['RUN_MPE']);
            phpAds_SessionDataStore();
        }

        if (isset($aConf['ui']['gzipCompression']) && $aConf['ui']['gzipCompression']) {
            ob_end_flush();
        }
    }
    
    function genericJavascript() {
        return array (
            'js/jquery-1.2.3.js', 
            'js/jquery.bgiframe.js',
            'js/jquery.dimensions.js',
            'js/jquery.metadata.js',
            'js/jquery.validate.js',
            'js/jquery.jqmodal.js',
            'js/jquery.typewatch.js',
            'js/jquery.autocomplete.js', 
            'js/jscalendar/calendar.js',
            'js/jscalendar/lang/calendar-en.js',
            'js/jscalendar/calendar-setup.js',
            'js/js-gui.js',
            'js/sorttable.js',
            'js/boxrow.js',
            'js/ox.usernamecheck.js',
            'js/ox.addirect.js',
            'js/ox.help.js',
            'js/ox.util.js',
            'js/formValidation.js'
        );
    }
    
    function genericStylesheets() {
        global $phpAds_TextDirection;
        
        if ($phpAds_TextDirection == 'ltr') {
            return array (
            'css/jquery.jqmodal.css',
                'css/jquery.autocomplete.css',
                'css/oa.help.css',
                'css/chrome.css',
                'js/jscalendar/calendar-openads.css',
                'css/interface-ltr.css',
            );
        }
        
        return array (
            'css/jquery.jqmodal.css',
            'css/jquery.autocomplete.css',
            'css/oa.help.css',
            'css/chrome.css',
            'css/chrome-rtl.css',
            'js/jscalendar/calendar-openads.css',
            'css/interface-rtl.css'
        );
    }
}

?>

<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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
require_once MAX_PATH . '/lib/OA/Admin/Menu.php';
require_once MAX_PATH . '/lib/OA/Admin/Menu/CompoundChecker.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';

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

    var $aLinkParams;
    
    /** holds the id of the page being currently displayed **/
    var $currentSectionId;

    /**
     * Class constructor
     *
     * @return OA_Admin_UI
     */
    function OA_Admin_UI()
    {
        $this->oTpl = new OA_Admin_Template('layout/main.html');
        $this->setLinkParams();
    }

    function setLinkParams()
    {
        global $affiliateid, $agencyid, $bannerid, $campaignid, $channelid, $clientid, $day, $trackerid, $userlogid, $zoneid;

        $this->aLinkParams = array('affiliateid'    => $affiliateid,
                                     'agencyid'     => $agencyid,
                                     'bannerid'     => $bannerid,
                                     'campaignid'   => $campaignid,
                                     'channelid'    => $channelid,
                                     'clientid'     => $clientid,
                                     'day'          => $day,
                                     'trackerid'    => $trackerid,
                                     'userlogid'    => $userlogid,
                                     'zoneid'       => $zoneid,
                                    );
    }
    
    function setCurrentId($ID)
    {
        $this->currentSectionId = $ID;
    }
    
    
    function getCurrentId()
    {
        return $this->currentSectionId;
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
     * @param bool $noBorder Set to true to hide white borders between sub nav and main nav in the main part
     * @param bool $showSidePlugins Set to false if you do not wish to show the plugins sidebar
     */
    function showHeader($ID = null, $extra="", $imgPath="", $showSidebar=true, $showMainNav=true, $noBorder = false)
    {
        $ID = $this->getId($ID);
        $this->setCurrentId($ID);

        global $phpAds_shortcuts;
        global $phpAds_breadcrumbs;
        global $phpAds_breadcrumbs_extra;
        global $phpAds_CharSet;
        global $OA_Navigation, $OA_Navigation_ID;
        global $conf;
        $conf = $GLOBALS['_MAX']['CONF'];

        $phpAds_GUIDone = true;
        $OA_Navigation_ID   = $ID;

        $aMainNav       = array();
        $aSectionNav    = array();
        $aSideNav       = array();
        $aSideContext   = array();
        $aSideShortcuts = array();
        $aBreadcrumbs = array();

        $pageTitle = !empty($conf['ui']['applicationName']) ? $conf['ui']['applicationName'] : MAX_PRODUCT_NAME;

        $oCurrentSection = null;
        // Travel navigation
        if ($ID !== phpAds_Login && $ID !== phpAds_Error) {

            //get system navigation
            $oMenu = OA_Admin_Menu::singleton();
            //update page title
            $oCurrentSection = $oMenu->get($ID);
            if ($oCurrentSection != null) {
                $pageTitle .= ' - '.$oCurrentSection->getName();
            } else {
                phpAds_Die($GLOBALS['strErrorOccurred'], 'Menu system error: <strong>' . OA_Permission::getAccountType(true) . '::' . $ID . '</strong> not found for the current user');
            }

            // compile navigation arrays
            $this->_compileNavigationTabBar($ID, $oMenu, $aMainNav);
            $this->_compileSectionTabBar($ID, $oMenu, $aSectionNav);
            $this->_compileSideNavigation($ID, $oMenu, $aSideNav);

            // build context
            $this->_buildSideContext($aSideContext);

            // Include shortcuts
            if (count($phpAds_shortcuts)) {
                $aSideShortcuts = $phpAds_shortcuts;
            }
           
            // Include breadcrumbs
            $aBreadcrumbs = $phpAds_breadcrumbs;
        } else {
            // Build tabbed navigation bar
            if ($ID == phpAds_Login) {
                $aMainNav[] = array(
                    'title'    => $GLOBALS['strAuthentification'],
                    'filename' => 'index.php',
                    'selected' => true
                );
            } elseif ($ID == phpAds_Error) {
                $aMainNav[] = array(
                    'title'    => $GLOBALS['strErrorOccurred'],
                    'filename' => 'index.php',
                    'selected' => true
                );
            }
        }

        // Tabbed navigation bar and sidebar
        $this->oTpl->assign('aNav', $aMainNav);
        $this->oTpl->assign('aSectionNav', $aSectionNav);
        $this->oTpl->assign('aSide', $aSideNav);
        $this->oTpl->assign('aSideContext', $aSideContext);
        $this->oTpl->assign('aSideShortcuts', $aSideShortcuts);
        $this->oTpl->assign('aBreadcrumbs', $aBreadcrumbs);
        $this->oTpl->assign('breadcrumbsExtra', $phpAds_breadcrumbs_extra);

        // Include custom HTML for the sidebar
        if ($extra) {
            $this->oTpl->assign('sidebarExtra', $extra);
        }

        // Use gzip content compression
        if (isset($conf['ui']['gzipCompression']) && $conf['ui']['gzipCompression']) {
            //enable compression if it's not alredy handled by the zlib and ob_gzhandler is loaded
            $zlibCompression = ini_get('zlib.output_compression');
            if (!$zlibCompression && function_exists('ob_gzhandler')) {
                // enable compression only if it wasn't enabled previously (e.g by widget)
                if (ob_get_contents()===false) {
                    ob_start("ob_gzhandler");
                }
            }
        }

        // Send header with charset info
        header ("Content-Type: text/html".(isset($phpAds_CharSet) && $phpAds_CharSet != "" ? "; charset=".$phpAds_CharSet : ""));

        $this->_assignLayout($pageTitle, $imgPath);

        $this->_assignJavascriptandCSS();

        $this->_assignValidationDefaults();

        $this->_assignAlertMPE();

        $this->_assignInstalling();

        $this->_assignBranding($conf['ui']['applicationName'], $conf['ui']['logoFilePath']);

        $this->_assignSearch($ID);

        $this->_assignUserAccountInfo($oCurrentSection);

        $this->oTpl->assign('showMainNav', $showMainNav);
        $this->oTpl->assign('showSidebar', $showSidebar);
        $this->oTpl->assign('noBorder', $noBorder);

        $this->oTpl->assign('uiPart', 'header');
        $this->oTpl->display();
    }

    function getID($ID)
    {
        $id = $ID;
        
        if (is_null($ID) || (($ID !== phpAds_Login && $ID !== phpAds_Error && basename($_SERVER['SCRIPT_NAME']) != 'stats.php') && (preg_match('#^[0-9](\.[0-9])*$#', $ID)))) {
            $id =  basename(substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '.')));
        }
        return $id;
    }
    

    function getNextPage($sectionId = null)
    {
        $sectionId = OA_Admin_UI::getID($sectionId);
        $oMenu = OA_Admin_Menu::singleton();
        $nextSection = $oMenu->getNextSection($sectionId);
        return $nextSection->getLink($this->aLinkParams);
    }

    function _assignInstalling()
    {
        global $phpAds_installing;
        if (!defined('phpAds_installing')) {
            // Include the flashObject resource file
            $this->oTpl->assign('jsFlash', MAX_flashGetFlashObjectExternal());
        }
    }

    function _assignLayout($pageTitle, $imgPath)
    {
        $this->oTpl->assign('pageTitle', $pageTitle);
        $this->oTpl->assign('imgPath', $imgPath);
        $this->oTpl->assign('metaGenerator', MAX_PRODUCT_NAME.' v'.OA_VERSION.' - http://'.MAX_PRODUCT_URL);
    }

    function _assignAlertMPE()
    {
        global $xajax, $session;
        if (!empty($session['RUN_MPE']) && $session['RUN_MPE']) {
            require_once MAX_PATH . '/www/admin/lib-maintenance-priority.inc.php';
            $this->oTpl->assign('jsMPE', $xajax->getJavascript('./', 'js/xajax.js'));
        }
    }

    function _assignBranding($appName, $logoPath)
    {
        $this->oTpl->assign('applicationName', $appName);
        $this->oTpl->assign('logoFilePath', $logoPath);
        $this->oTpl->assign('productName', MAX_PRODUCT_NAME);
    }

    function _compileSideNavigation($sectionID, $oMenu, &$aSideNav)
    {
        $aParentSections = $oMenu->getParentSections($sectionID);

        $parentCount = count($aParentSections);
        for ($i = 0; $i < $parentCount; $i++)
        {
            $aSideNav[] = array(
                'title' => $aParentSections[$i]->getName(),
                'filename' => $aParentSections[$i]->getLink($this->aLinkParams),
                'top' => $i == 0,
                'up'  => $i == ($parentCount - 1),
                'first' => $i == 1,
                'current' => false
            );
        }

        $oCurrentSection = $oMenu->get($sectionID);
        if ($oCurrentSection != null) {
            $aSideNav[] = array(
              'title' => $oCurrentSection->getName(),
              'filename' => $oCurrentSection->getLink($this->aLinkParams),
              'top' => $parentCount == 0,
              'up'  => false,
              'first' => $parentCount == 1,
              'current' => $parentCount > 0
            );
        }
    }


    function _OLDcompileSideNavigation($ID, $sections, &$sectionID, $pages, &$aSide)
    {
            for ($i = 0; $i < count($sections) - 1; $i++)
            {
                $sectionID .= $sections[$i];
                list($filename, $title) = each($pages[$sectionID]);
                $sectionID .= ".";

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
            }
    }


    function _compileNavigationTabBar($sectionID, $oMenu, &$aMainNav)
    {
        $aRootPages = $oMenu->getRootSections();
    	  $aParentSections = $oMenu->getParentSections($sectionID);
        $rootParentId = !empty($aParentSections) ? $aParentSections[0]->getId() : $sectionID;

        for ($i = 0; $i < count($aRootPages); $i++) {
            $aMainNav[]= array(
              'title'    => $aRootPages[$i]->getName(),
              'filename' => $aRootPages[$i]->getLink($this->aLinkParams),
              'selected' => $aRootPages[$i]->getId() == $rootParentId
            );
        }
    }


    function _compileSectionTabBar($ID, $oMenu, &$aSectionNav)
    {
      $oCurrentSection = $oMenu->get($ID);

      //at the moment every root section in fact links to one of its children,
      //so there is no page for a root section actually
      //for broken implementations where there is such page we could check if we are root section and display children instead of siblings
      if ($oMenu->isRootSection($oCurrentSection)) {
      	$aSections = $oCurrentSection->getSections();
      }
      else {
        $aParent = $oCurrentSection->getParent();
        $aSections =$aParent->getSections();
      }

      //filter out exclusive and affixed sections from view if they're not active
      $aSections = array_values(array_filter($aSections, array(new OA_Admin_Section_Type_Filter($oCurrentSection), 'accept')));


      for ($i = 0; $i < count($aSections); $i++) {
        $aSectionNav[]= array(
          'title'    => $aSections[$i]->getName(),
          'filename' => $aSections[$i]->getLink($this->aLinkParams),
          'selected' => $aSections[$i]->getId() == $ID
          );
      }
    }


    function _assignValidationDefaults()
    {
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
    }

    function _assignJavascriptandCSS()
    {
        global $installing, $conf; //if installing no admin base URL is known yet
        //URL to combine script
        $this->oTpl->assign('adminBaseURL', $installing ? '' : MAX::constructURL(MAX_URL_ADMIN, ''));
        // Javascript and stylesheets to include
        $this->oTpl->assign('genericStylesheets', urlencode(implode(',', $this->genericStylesheets())));
        $this->oTpl->assign('genericJavascript', urlencode(implode(',', $this->genericJavascript())));
        $this->oTpl->assign('aGenericStyleshets', $this->genericStylesheets());
        $this->oTpl->assign('aGenericJavascript', $this->genericJavascript());
        $this->oTpl->assign('combineAssets', $conf['ui']['combineAssets']);
    }

    function _assignSearch($ID)
    {
        $displaySearch = ($ID !== phpAds_Login && $ID !== phpAds_Error && OA_Auth::isLoggedIn() && OA_Permission::isAccount(OA_ACCOUNT_MANAGER) && !defined('phpAds_installing'));
        $this->oTpl->assign('displaySearch', $displaySearch);
        $this->oTpl->assign('searchUrl', MAX::constructURL(MAX_URL_ADMIN, 'admin-search.php'));
    }

    function _assignUserAccountInfo($oCurrentSection)
    {
        global $OA_Navigation_ID, $session;
        // Show currently logged on user and IP
        if (OA_Auth::isLoggedIn() || defined('phpAds_installing')) {
            //$this->oTpl->assign('helpLink', OA_Admin_Help::getDocLinkFromPhpAdsNavId($OA_Navigation_ID));
            $this->oTpl->assign('helpLink', OA_Admin_Help::getHelpLink($oCurrentSection));            
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

                if (OA_Permission::isUserLinkedToAdmin()) {
                    $this->oTpl->assign('maintenanceAlert', OA_Dal_Maintenance_UI::alertNeeded());
                }

            } else {
                $this->oTpl->assign('buttonStartOver', true);
            }
        }
    }

    function _buildSideContext(&$aSideContext)
    {
        global $phpAds_context;

        $up_limit = count($phpAds_context);
        $down_limit = 0;

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
            //flush if we have used ob_gzhandler
            $zlibCompression = ini_get('zlib.output_compression');
            if (!$zlibCompression && function_exists('ob_gzhandler')) {
                ob_end_flush();
            }
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
            'js/jquery.example.js',
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
            'js/ox.multicheckbox.js',
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

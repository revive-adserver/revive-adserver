<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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

require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/SmartyInserts.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/UI.php';
require_once MAX_PATH . '/lib/OA/Admin/Menu.php';
require_once MAX_PATH . '/lib/OA/Admin/Menu/CompoundChecker.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/model/PageHeaderModel.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/NotificationManager.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/AccountSwitch.php';
require_once LIB_PATH . '/Admin/Redirect.php';




/**
 * A class to generate all the UI parts
 *
 */
class OA_Admin_UI
{
    /**
      * Singleton instance.
      * Holds the only one UI instance created per request
      */
    private static $_instance;

    /**
     * @var OA_Admin_Template
     */
    var $oTpl;
    
    /**
     * left side notifications manager
     *
     * @var OA_Admin_UI_NotificationManager
     */
    var $notificationManager;
    var $aLinkParams;
    /** holds the id of the page being currently displayed **/
    var $currentSectionId;
    var $aTools;
    var $aShortcuts;

    /**
     * An array containing a list of CSS files to be included in HEAD section
     * when page header is rendered.
     * @var array
     */
    var $otherCSSFiles;


    /**
     * Class constructor, private to force getInstance usage
     *
     * @return OA_Admin_UI
     */
    private function __construct()
    {
        $this->oTpl = new OA_Admin_Template('layout/main.html');
        $this->notificationManager = new OA_Admin_UI_NotificationManager();
        $this->otherCSSFiles = array();
        $this->setLinkParams();
        $this->aTools = array();
        $this->aShortcuts = array();
    }


    /**
     * Singleton instance
     *
     * @return OA_Admin_UI object
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }


    function setLinkParams()
    {
        global $affiliateid, $agencyid, $bannerid, $campaignid, $channelid, $clientid, $day, $trackerid, $userlogid, $zoneid, $userid;

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
                                     'userid'       => $userid,
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
     * Return manager for accessing notifications shown in UI
     *
     * @return OA_Admin_UI_NotificationManager
     */
    public function getNotificationManager()
    {
        if (empty($this->notificationManager) ) {
            $this->notificationManager = new OA_Admin_UI_NotificationManager();
        }
        
        return $this->notificationManager;
    }
    

    /**
     * Show page header
     *
     * @param int $ID
     * @param OA_Admin_UI_Model_PageHeaderModel $headerModel
     * @param int $imgPath A relative path to Images, CSS files. Used if calling function
     *                     from anything other than admin folder
     * @param bool $showSidebar Set to false if you do not wish to show the sidebar navigation
     * @param bool $showContentFrame Set to false if you do not wish to show the content frame
     * @param bool $showMainNavigation Set to false if you do not wish to show the main navigation
     */
    function showHeader($ID = null, $oHeaderModel = null, $imgPath="", $showSidebar=true, $showContentFrame=true, $showMainNavigation=true)
    {
        global $conf, $phpAds_CharSet, $phpAds_breadcrumbs_extra;
        $conf = $GLOBALS['_MAX']['CONF'];

        $ID = $this->getId($ID);
        $this->setCurrentId($ID);

        $pageTitle = !empty($conf['ui']['applicationName']) ? $conf['ui']['applicationName'] : MAX_PRODUCT_NAME;
        $aMainNav        = array();
        $aLeftMenuNav    = array();
        $aLeftMenuSubNav = array();
        $aSectionNav     = array();

        if ($ID !== phpAds_Login && $ID !== phpAds_Error && $ID !== phpAds_PasswordRecovery) {
            //get system navigation
            $oMenu = OA_Admin_Menu::singleton();
            //update page title
            $oCurrentSection = $oMenu->get($ID);
            if ($oCurrentSection == null) {
                phpAds_Die($GLOBALS['strErrorOccurred'], 'Menu system error: <strong>' . OA_Permission::getAccountType(true) . '::' . htmlspecialchars($ID) . '</strong> not found for the current user');
            }

            if ($oHeaderModel == null) {
                //build default model with title and name taken from nav entry
                $oHeaderModel = new OA_Admin_UI_Model_PageHeaderModel($oCurrentSection->getName());
            }
            if ($oHeaderModel->getTitle()) {
                $pageTitle .= ' - '.$oHeaderModel->getTitle();
            }
            else {
                $pageTitle .= ' - '.$oCurrentSection->getName();
            }

            // compile navigation arrays
            $this->_compileMainNavigationTabBar($oCurrentSection, $oMenu, $aMainNav);
            $this->_compileLeftMenuNavigation($oCurrentSection, $oMenu, $aLeftMenuNav);
            $this->_compileLeftSubMenuNavigation($oCurrentSection, $oMenu, $aLeftMenuSubNav);
            $this->_compileSectionTabBar($oCurrentSection, $oMenu, $aSectionNav);

        }
        else {
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
            } elseif ($ID == phpAds_PasswordRecovery) {
                $aMainNav[] = array (
                    'title'    => $GLOBALS['strPasswordRecovery'],
                    'filename' => 'index.php',
                    'selected' => true
                );
            }
			
			$showContentFrame=false; 
        }

        //html header
        $this->_assignLayout($pageTitle, $imgPath);
        $this->_assignJavascriptandCSS();

        //layout stuff
        $this->oTpl->assign('uiPart', 'header');
        $this->oTpl->assign('showContentFrame', $showContentFrame);
        $this->oTpl->assign('showSidebar', $showSidebar);
        $this->oTpl->assign('showMainNavigation', $showMainNavigation);

        //top
        $this->_assignBranding($conf['ui']);
        $this->_assignSearch($ID);
        $this->_assignUserAccountInfo($oCurrentSection);

        $this->oTpl->assign('headerModel', $oHeaderModel);
        // Tabbed navigation bar and sidebar
        $this->oTpl->assign('aMainTabNav', $aMainNav);
        $this->oTpl->assign('aLeftMenuNav', $aLeftMenuNav);
        $this->oTpl->assign('aLeftMenuSubNav', $aLeftMenuSubNav);
        $this->oTpl->assign('aSectionNav', $aSectionNav);
        // This is used to show banner preview
        $this->oTpl->assign('breadcrumbsExtra', $phpAds_breadcrumbs_extra);

        //tools and shortcuts
        $this->oTpl->assign('aTools', $this->aTools);
        $this->oTpl->assign('aShortcuts', $this->aShortcuts);



        //additional things
        $this->_assignJavascriptDefaults(); //JS validation messages and other defaults
        $this->_assignAlertMPE(); //mpe xajax
        $this->_assignInstalling(); //install indicator
        $this->_assignMessagesAndNotifications(); //messaging system



        //html header
        $this->_assignJavascriptandCSS();


        /* DISPLAY */
        // Use gzip content compression
        if (isset($conf['ui']['gzipCompression']) && $conf['ui']['gzipCompression']) {
            //enable compression if it's not alredy handled by the zlib and ob_gzhandler is loaded
            $zlibCompression = ini_get('zlib.output_compression');
            if (!$zlibCompression && function_exists('ob_gzhandler')) {
                // enable compression only if it wasn't enabled previously (e.g by widget)
                if (ob_get_contents() === false) {
                    ob_start("ob_gzhandler");
                }
            }
        }
        // Send header with charset info and display
        header ("Content-Type: text/html".(isset($phpAds_CharSet) && $phpAds_CharSet != "" ? "; charset=".$phpAds_CharSet : ""));
        $this->oTpl->display();
    }

    function getID($ID)
    {
        $id = $ID;

        if (is_null($ID) || (($ID !== phpAds_Login && $ID !== phpAds_Error && $ID !== phpAds_PasswordRecovery && basename($_SERVER['SCRIPT_NAME']) != 'stats.php') && (preg_match('#^[0-9](\.[0-9])*$#', $ID)))) {
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

    /**
     * Method that returns the top level page of the page passed as parameter.
     *
     * @param string $sectionId The page that we want to know its parent page.
     * @return string A string with the parent page, it will be null if the page
     *                doesn't have a parent page.
     */
    function getTopLevelPage($sectionId = null)
    {
        $sectionId = OA_Admin_UI::getID($sectionId);
        $oMenu = OA_Admin_Menu::singleton();
        $parentSections = $oMenu->getParentSections($sectionId);
        return (count($parentSections) ? $parentSections[0]->link : '');
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
            $this->oTpl->assign('jsMPE', $xajax->getJavascript(OX::assetPath(), 'js/xajax.js'));
        }
    }

    function _assignBranding($aConf)
    {
        $this->oTpl->assign('applicationName', $aConf['applicationName']);
        $this->oTpl->assign('logoFilePath', $aConf['logoFilePath']);
        if (!empty($aConf['headerForegroundColor'])) {
            $this->oTpl->assign('headerForegroundColor', $aConf['headerForegroundColor']);
        }
        if (!empty($aConf['headerBackgroundColor'])) {
            $this->oTpl->assign('headerBackgroundColor', $aConf['headerBackgroundColor']);
        }
        if (!empty($aConf['headerActiveTabColor'])) {
            $this->oTpl->assign('headerActiveTabColor', $aConf['headerActiveTabColor']);
        }
        if (!empty($aConf['headerTextColor'])) {
            $this->oTpl->assign('headerTextColor', $aConf['headerTextColor']);
        }
        if (!empty($aConf['headerForegroundColor']) || !empty($aConf['headerBackgroundColor'])
            || !empty($aConf['headerActiveTabColor']) || !empty($aConf['headerTextColor']))
        {
            $this->oTpl->assign('customBranding', true);
        }
        $this->oTpl->assign('productName', MAX_PRODUCT_NAME);
    }


    function _compileMainNavigationTabBar($oCurrentSection, $oMenu, &$aMainNav)
    {
        $sectionID = $oCurrentSection->getId();
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


    function _compileLeftMenuNavigation($oCurrentSection, $oMenu, &$aLeftMenuNav)
    {
        $sectionID = $oCurrentSection->getId();
        $aParentSections = $oMenu->getParentSections($sectionID);

        if ($aParentSections) {
            $aSecondLevelSections = $aParentSections[0]->getSections(); //second level

            $secondLevelParentId = count($aParentSections) > 1  ? $aParentSections[1]->getId() : $sectionID;

            $currGroup = '';
            $count = count($aSecondLevelSections);
            for ($i = 0; $i < $count; $i++) {
                $first = false;
                $last  = false;
                if ($i == 0 || $currGroup != $aSecondLevelSections[$i]->getGroupName() ) {
                    $first = true;
                }
                if ($i == $count - 1 || $aSecondLevelSections[$i]->getGroupName() != $aSecondLevelSections[$i+1]->getGroupName()) {
                    $last = true;
                }
                $single = $first && $last;

                $aLeftMenuNav[]= array(
                  'title'    => $aSecondLevelSections[$i]->getName(),
                  'filename' => $aSecondLevelSections[$i]->getLink($this->aLinkParams),
                  'first'    => $first,
                  'last'     => $last,
                  'single'   => $single,
                  'selected' => $aSecondLevelSections[$i]->getId() == $secondLevelParentId
                );
                $currGroup = $aSecondLevelSections[$i]->getGroupName();
            }
        }
    }


    function _compileLeftSubMenuNavigation($oCurrentSection, $oMenu, &$aLeftMenuSubNav)
    {
        $oLeftMenuSub = $oCurrentSection->getParentOrSelf(OA_Admin_Menu_Section::TYPE_LEFT_SUB);

        if ($oLeftMenuSub != null) {
            $aLeftMenuSubSections = $oLeftMenuSub->siblings(OA_Admin_Menu_Section::TYPE_LEFT_SUB);

            $count = count($aLeftMenuSubSections);
            for ($i = 0; $i < $count; $i++) {
                $aLeftMenuSubNav[]= array(
                  'title'    => $aLeftMenuSubSections[$i]->getName(),
                  'filename' => $aLeftMenuSubSections[$i]->getLink($this->aLinkParams),
                  'selected' => $aLeftMenuSubSections[$i]->getId() == $oLeftMenuSub->getId()
                );
            }
        }

        global $ox_left_menu_sub;
        if (count($ox_left_menu_sub)) {
            $currentLeftSub = $ox_left_menu_sub['current'];

            foreach($ox_left_menu_sub['items'] as $k => $v) {
              $aLeftMenuSubNav[]= array(
                      'title'    => $v['title'],
                      'filename' => $v['link'],
                      'selected' => $k == $currentLeftSub
                    );
            }
        }
    }


    function _compileSectionTabBar($oCurrentSection, $oMenu, &$aSectionNav)
    {
        $sectionID = $oCurrentSection->getId();
        if ($oMenu->getLevel($sectionID) < 2) { //if we are on root or first level
            return;                             //page no tabs will be shown since there is nav already for these levels
        }

        //at the moment every root section in fact links to one of its children,
        //so there is no page for a root section actually
        //for broken implementations where there is such page we could check if we are root section and display children instead of siblings
        if ($oMenu->isRootSection($oCurrentSection)) {
            $aSections = $oCurrentSection->getSections();
        }
        else {
            $aParent = $oCurrentSection->getParent();
            $aSections = $aParent->getSections();
        }

        //filter out exclusive and affixed sections from view if they're not active
        $aSections = array_values(array_filter($aSections, array(new OA_Admin_Section_Type_Filter($oCurrentSection), 'accept')));


        for ($i = 0; $i < count($aSections); $i++) {
        $aSectionNav[]= array(
          'title'    => $aSections[$i]->getName(),
          'filename' => $aSections[$i]->getLink($this->aLinkParams),
          'selected' => $aSections[$i]->getId() == $sectionID
          );
        }
    }


    function _assignJavascriptDefaults()
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
		    $this->oTpl->assign('warningBeforeDelete', $GLOBALS['_MAX']['PREF']['ui_novice_user'] ? 'true' : 'false');
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
        $this->oTpl->assign('aOtherStylesheets', $this->otherCSSFiles);
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
        global $session;
        // Show currently logged on user and IP
        if (OA_Auth::isLoggedIn() || defined('phpAds_installing')) {
            $this->oTpl->assign('helpLink', OA_Admin_Help::getHelpLink($oCurrentSection));
            if (!defined('phpAds_installing')) {
                $this->oTpl->assign('infoUser', OA_Permission::getUsername());
                $this->oTpl->assign('buttonLogout', true);
                $this->oTpl->assign('buttonReportBugs', true);

                // Account switcher
                OA_Admin_UI_AccountSwitch::assignModel($this->oTpl);
                $this->oTpl->assign('strWorkingAs', $GLOBALS['strWorkingAs_Key']);
                $this->oTpl->assign('keyWorkingAs', $GLOBALS['keyWorkingAs']);
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
    

    function _assignMessagesAndNotifications()
    {
        global $session;

        if (isset($session['messageQueue']) && is_array($session['messageQueue']) && count($session['messageQueue'])) {
            $this->oTpl->assign('aMessageQueue', $session['messageQueue']);
            $session['messageQueue'] = array();

            // Force session storage
            phpAds_SessionDataStore();
        }
        
        $aNotifications = $this->getNotificationManager()->getNotifications();
        if (count($aNotifications)) {
            $this->oTpl->assign('aNotificationQueue', $aNotifications);
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


    /**
     * Schedules a message to be shown on next showHeader call. Message can be of 4 different types:
     * - info
     * - confirm
     * - warning
     * - error and
     * It can be shown in two locations (global - glued to the top of the scren, local
     * - placed within page content). Message can automatically disappera after a given number
     * of miliseconds. If timeout is set to 0, message will not disappear automaticaly,
     * user will have to close it.
     *
     * When adding a message an action it is related to can be specified.
     * Later, this action type can be used to access messages in queue before they got displayed.
     *
     * @param string $text either Message text
     * @param string $location either local or global
     * @param string $type info, confirm, warning, error
     * @param int $timeout value or 0
     * @param string $relatedAction this is an optional parameter which can be used to asses the message with action it is related to
     */
    function queueMessage($text, $location = 'global', $type = 'confirm', $timeout = 5000, $relatedAction = null) {
        global $session;

        if (!isset($session['messageId'])) {
            $session['messageId'] = time();
        } else {
            $session['messageId']++;
        }

        $session['messageQueue'][] = array(
            'id' => $session['messageId'],
            'text' => $text,
            'location' => $location,
            'type' => $type,
            'timeout' => $timeout,
            'relatedAction' => $relatedAction
        );

        // Force session storage
        phpAds_SessionDataStore();
    }


    /**
     * Removes from queue all messages that are related to a given action. Please
     * make sure that if you intend to remove messages you queue them with 'relatedAction'
     * parameter set properly.
     *
     * @param string $relatedAction name of the action which messages should be removed
     * @return number of messages removed from queue
     */
    function removeMessages($relatedAction)
    {
        global $session;

        if (empty($relatedAction) || !isset($session['messageQueue'])
            || !is_array($session['messageQueue']) || !count($session['messageQueue'])) {
            return 0;
        }

        $aMessages = $session['messageQueue'];
        $aFilteredMessages = array();

        //filter messages out, if any
        foreach ($aMessages as $message) {
            if ($relatedAction != $message['relatedAction']) {
                $aFilteredMessages[] = $message;
            }
        }

        //if sth was filtered save new queue
        $removedCount = count($aMessages) - count($aFilteredMessages);
        if ($removedCount > 0) {
            $session['messageQueue'] = $aFilteredMessages;
            // Force session storage
            phpAds_SessionDataStore();
        }

        return $removedCount;
    }


    /**
     * Removes from queue the latest message related to a given action. Please
     * make sure that if you intend to remove messages you queue them with 'relatedAction'
     * parameter set properly.
     *
     * @param string $relatedAction name of the action which messages should be removed
     * @return true if there was any message removed, false otherwise
     */
    function removeOneMessage($relatedAction)
    {
        global $session;

        if (empty($relatedAction) || !isset($session['messageQueue'])
            || !is_array($session['messageQueue']) || !count($session['messageQueue'])) {
            return false;
        }

        $aMessages = $session['messageQueue'];
        //filter messages out, if any
        $count = count($aMessages);
        for($i = 0; $i < $count; $i++) {
            if ($relatedAction == $aMessages[$i]['relatedAction']) {
                unset($aMessages[$i]);
                $aMessages = array_slice($aMessages, 0); //a hack to reorder indices after elem was removed
                break;
            }
        }

        //if sth was filtered save new queue
        if ($count > count($aMessages)) {
            $session['messageQueue'] = $aMessages;
            // Force session storage
            phpAds_SessionDataStore();
        }

        return $removedCount;
    }


    function genericJavascript() {
        return array (
            'js/jquery-1.2.6-mod.js',
            'js/effects.core.js',
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
            'js/boxrow.js',
            'js/ox.message.js',
            'js/ox.usernamecheck.js',
            'js/ox.accountswitch.js',
            'js/ox.ui.js',
            'js/ox.form.js',
            'js/ox.help.js',
            'js/ox.util.js', //1.3s
            'js/ox.multicheckbox.js',
            'js/ox.dropdown.js',
            'js/ox.navigator.js',
            'js/jquery.delegate-1.1.min.js',
            'js/ox.table.js', //1,2s
            'js/jquery.tablesorter.js',
            'js/ox.tablesorter.plugins.js',
            'js/formValidation.js'        
        );
    }

    function genericStylesheets()
    {
        global $phpAds_TextDirection;

        if ($phpAds_TextDirection == 'ltr') {
            return array (
            'css/jquery.jqmodal.css',
                'css/jquery.autocomplete.css',
                'css/oa.help.css',
                'css/chrome.css',
                'css/table.css',
                'css/message.css',
                'js/jscalendar/calendar-openads.css',
                'css/interface-ltr.css',
                'css/icons.css'
            );
        }

        return array (
            'css/jquery.jqmodal.css',
            'css/jquery.autocomplete.css',
            'css/oa.help.css',
            'css/chrome.css',
            'css/table.css',
            'css/message.css',
            'css/chrome-rtl.css',
            'js/jscalendar/calendar-openads.css',
            'css/interface-rtl.css',
            'css/icons.css'
        );
    }

    function registerStylesheetFile($filePath)
    {
        if (!in_array($filePath, $this->otherCSSFiles)) {
            $this->otherCSSFiles[] = $filePath;
        }
    }


    function addPageLinkTool($title, $url, $iconClass, $accesskey = null, $extraAttributes = null)
    {
        $this->aTools[] = array(
            'type' => 'link',
            'title' => $title,
            'url' => $url,
            'iconClass' => $iconClass,
            'accesskey' => $accesskey,
            'extraAttr' => $extraAttributes
        );
    }

    /** TODO refactor form **/
    function addPageFormTool($title, $iconClass, $form)
    {
        $this->aTools[] = array(
            'type' => 'form',
            'title' => $title,
            'iconClass' => $iconClass,
            'form'=> $form
        );
    }



    function addPageShortcut($title, $url, $iconClass = null)
    {
        $this->aShortcuts[] = array(
            'type' => 'link',
            'title' => $title,
            'url' => $url,
            'iconClass' => $iconClass,
        );
    }


}
?>

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
        $this->oTpl = new OA_Admin_Template('layout.html');
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
        global $phpAds_GUIDone, $phpAds_NavID;
        global $phpAds_context, $phpAds_shortcuts;
        global $phpAds_nav, $pages;
        global $phpAds_CharSet;
        global $xajax, $session;

        $conf = $GLOBALS['_MAX']['CONF'];
        $pref = $GLOBALS['_MAX']['PREF'];

        $phpAds_GUIDone = true;
        $phpAds_NavID   = $ID;

        $tabbar = '';
    	$sidebar = '';
    	$head = '';

        // Travel navigation
        if ($ID != phpAds_Login && $ID != phpAds_Error) {
    		switch (true) {
    			case phpAds_isUser(phpAds_Admin):	$pages = $phpAds_nav['admin']; break;
    			case phpAds_isUser(phpAds_Agency):	$pages = $phpAds_nav['agency']; break;
    			case phpAds_isUser(phpAds_Client):	$pages = $phpAds_nav['client']; break;
    			default:							$pages = $phpAds_nav['affiliate']; break;
    		}

            // Build sidebar
            $sections = explode(".", $ID);
            $sectionID = "";

    		$sidebar .= "<div id='oaSidebar'><h3>{$GLOBALS['strNavigation']}</h3>";
    		$sidebar .= "<ul id='oaSidebarNavigation'>";

            for ($i=0; $i<count($sections)-1; $i++)
    		{
                $sectionID .= $sections[$i];
                list($filename, $title) = each($pages[$sectionID]);
                $sectionID .= ".";

                if ($i==0) {
    				$sidebar .= "<li class='top'><a href='{$filename}'>{$title}</a></li>";
                    $head .= "<link rel='top' href='{$filename}' title='{$title}' />";
                } else {
    				$sidebar .= "<li class='up" . ($i == 1 ? " first" : "") . "'>";
    				$sidebar .= "<a href='{$filename}'" . ($i == count($sections) - 2 ? " accesskey='{$GLOBALS['keyUp']}'" : "") . ">{$title}</a></li>";
                }
                if ($i == count($sections) - 2) {
                    $head .= "<link rel='up' href='{$filename}' title='{$title}' />";
                }
            }

            if (isset($pages[$ID]) && is_array($pages[$ID])) {
                list($filename, $title) = each($pages[$ID]);
    			$sidebar .= "<li class='" . (count($sections) == 2 ? "first " : "") . (count($sections) > 1 ? "current" : "top") . "'>";
    			$sidebar .= "<a href='{$filename}'>{$title}</a></li>";
                $pagetitle = isset($conf['ui']['applicationName']) && $conf['ui']['applicationName'] != '' ? $conf['ui']['applicationName'] : MAX_PRODUCT_NAME;
                $pagetitle .= ' - '.$title;
            } else {
                $pagetitle = isset($conf['ui']['applicationName']) && $conf['ui']['applicationName'] != '' ? $conf['ui']['applicationName'] : MAX_PRODUCT_NAME;
            }

    		$sidebar .= "</ul>";

    		$up_limit = count($phpAds_context);
            $down_limit = 0;

            // Build Context
            if (count($phpAds_context)) {
    			$sidebar .= "<ul id='oaSidebarContext'>";
                $selectedcontext = '';
                for ($ci=$down_limit; $ci < $up_limit; $ci++) {
                    if ($phpAds_context[$ci]['selected']) {
                        $selectedcontext = $ci;
                    }
                }
                for ($ci=$down_limit; $ci < $up_limit; $ci++) {
                    $ac = '';
                    if ($ci == $selectedcontext - 1) $ac = $GLOBALS['keyPreviousItem'];
                    if ($ci == $selectedcontext + 1) $ac = $GLOBALS['keyNextItem'];

    				$sidebar .= "<li" . ($phpAds_context[$ci]['selected'] ? " class='selected'" : "") . ">";
    				$sidebar .= "<a href='{$phpAds_context[$ci]['link']}'" . ($ac != '' ? " accesskey='" . $ac . "'" : "") . ">";
    				$sidebar .= "{$phpAds_context[$ci]['name']}</a></li>";
                }
    			$sidebar .= "</ul>";
            }

            // Include custom HTML for the sidebar
            if ($extra != '') $sidebar .= "<div id='oaSidebarCustom'>{$extra}</div>";

            // Include shortcuts
            if (count($phpAds_shortcuts)) {
    			$sidebar .= "<h3>{$GLOBALS['strShortcuts']}</h3>";
    			$sidebar .= "<ul id='oaSidebarShortcuts'>";

                for ($si=0; $si<count($phpAds_shortcuts); $si++) {
    				$sidebar .= "<li style='background-image: url({$phpAds_shortcuts[$si]['icon']});'>";
    				$sidebar .= "<a href='{$phpAds_shortcuts[$si]['link']}'>{$phpAds_shortcuts[$si]['name']}</a>";
    				$sidebar .= "</li>";
                    $head  .= "<link rel='bookmark' href='{$phpAds_shortcuts[$si]['link']}' title='{$phpAds_shortcuts[$si]['name']}' />";
                }

    			$sidebar .= "</ul>";
            }
    		$sidebar .= "</div>";

            // Build Tabbar
            $currentsection = $sections[0];

            // Prepare Navigation
    		switch (true) {
    			case phpAds_isUser(phpAds_Admin):		$pages = $phpAds_nav['admin']; break;
    			case phpAds_isUser(phpAds_Agency):		$pages = $phpAds_nav['agency']; break;
    			case phpAds_isUser(phpAds_Client):		$pages = $phpAds_nav['client']; break;
    			case phpAds_isUser(phpAds_Affiliate):	$pages = $phpAds_nav['affiliate']; break;
    			default:								$pages = array(); break;
    		}

    		$tabbar .= "<ul id='oaNavigationTabs'>";

            foreach (array_keys($pages) as $key) {
                if (strpos($key, ".") == 0) {
                    list($filename, $title) = each($pages[$key]);
                    if ($key == $currentsection) {
    					$tabbar .= "<li class='selected'><a href='{$filename}' accesskey='{$GLOBALS['keyHome']}'>{$title}</a></li>";
                    } else {
    					$tabbar .= "<li><a href='{$filename}'>{$title}</a></li>";
                    }
                }
            }

    		$tabbar .= "</ul>";
        }
        else {
            $sidebar = "&nbsp;";
            $pagetitle = isset($conf['ui']['applicationName']) && $conf['ui']['applicationName'] != '' ? $conf['ui']['applicationName'] : MAX_PRODUCT_NAME;

            if ($ID == phpAds_Login) {
    			$tabbar .= "<ul id='oaNavigationTabs'><li class='selected'><a href='index.php'>{$GLOBALS['strAuthentification']}</a></li></ul>";
            }
            if ($ID == phpAds_Error) {
    			$tabbar .= "<ul id='oaNavigationTabs'><li class='selected'><a href='index.php'>Error</a></li></ul>";
            }
        }

        // Use gzip content compression
        if (isset($conf['ui']['gzipCompression']) && $conf['ui']['gzipCompression']) {
            ob_start("ob_gzhandler");
        }

        // Send header with charset info
        header ("Content-Type: text/html".(isset($phpAds_CharSet) && $phpAds_CharSet != "" ? "; charset=".$phpAds_CharSet : ""));

        // Generate layout
        $this->oTpl->assign('pageTitle', $pagetitle);
        $this->oTpl->assign('imgPath', $imgPath);
        $this->oTpl->assign('metaGenerator', MAX_PRODUCT_NAME.' v'.OA_VERSION.' - http://'.MAX_PRODUCT_URL);
        $this->oTpl->assign('formValidation', !defined('phpAds_installing'));

        if (!empty($session['RUN_MPE']) && $session['RUN_MPE']) {
            require_once MAX_PATH . '/www/admin/lib-maintenance-priority.inc.php';
            $this->oTpl->assign('jsMPE', $xajax->getJavascript('./', 'js/xajax.js'));
        }

        if (!defined('phpAds_installing')) {
            // Include the flashObject resource file
            $this->oTpl->assign('jsFlash', MAX_flashGetFlashObjectExternal());
        }

        $this->oTpl->assign('headExtras', $head);

        // Branding
        $this->oTpl->assign('applicationName', $conf['ui']['applicationName']);
        $this->oTpl->assign('logoFilePath', $conf['ui']['logoFilePath']);

        $displaySearch = ($ID != phpAds_Login && $ID != phpAds_Error && phpAds_isLoggedIn() && phpAds_isUser(phpAds_Admin|phpAds_Agency|phpAds_Affiliate) && !defined('phpAds_installing'));
        $this->oTpl->assign('displaySearch', $displaySearch);
        $this->oTpl->assign('searchUrl', MAX::constructURL(MAX_URL_ADMIN, 'admin-search.php'));

        if ($showMainNav == true) {
            $this->oTpl->assign('tabBar', $tabbar);
        }

        // Show currently logged on user and IP
        if (($ID != "" && phpAds_isLoggedIn()) || defined('phpAds_installing')) {
            $this->oTpl->assign('helpLink', OA_Admin_Help::getDocLinkFromPhpAdsNavId($phpAds_NavID));
            $this->oTpl->assign('buttonLogout', true);
            if (!defined('phpAds_installing')) {
                $this->oTpl->assign('infoUser', "{$session['username']} [{$_SERVER['REMOTE_ADDR']}]");
                $this->oTpl->assign('buttonReportBugs', true);
            } else {
                $this->oTpl->assign('buttonStartOver', true);
            }
        }

        $this->oTpl->assign('sideBar', $showSidebar ? $sidebar : '');

        $this->oTpl->assign('noBorder', $noBorder);

        $this->oTpl->assign('productUpdatesCheck',
            phpAds_isUser(phpAds_Admin) &&
            $conf['sync']['checkForUpdates'] &&
            !isset($session['maint_update_js'])
        );

        $this->oTpl->assign('maintenanceAlert', OA_Dal_Maintenance_UI::alertNeeded());

        $this->oTpl->assign('uiPart', 'header');
        $this->oTpl->display();
    }

    function showFooter()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        $this->oTpl->assign('uiPart', 'footer');
        $this->oTpl->display();

        // Clean up MPE session variable
        if (!empty($session['RUN_MPE']) && $session['RUN_MPE'] === true) {
            unset($session['RUN_MPE']);
            phpAds_SessionDataStore();
        }

        if (isset($conf['ui']['gzipCompression']) && $conf['ui']['gzipCompression']) {
            ob_end_flush();
        }
    }
}

?>
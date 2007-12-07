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

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Admin/Help.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/Delivery/flash.php';
require_once MAX_PATH . '/www/admin/lib-permissions.inc.php';

// Define defaults
$phpAds_NavID        = '';
$phpAds_GUIDone     = false;
$phpAds_context        = array();
$phpAds_shortcuts    = array();

define("phpAds_Login", 0);
define("phpAds_Error", -1);

/*-------------------------------------------------------*/
/* Add breadcrumb context to left menubar                */
/*-------------------------------------------------------*/

function phpAds_PageContext($name, $link, $selected)
{
    global $phpAds_context;
    $phpAds_context[] = array(
        'name' => $name,
        'link' => $link,
        'selected' => $selected
    );
}

/*-------------------------------------------------------*/
/* Add shortcuts to left menubar                         */
/*-------------------------------------------------------*/

function phpAds_PageShortcut($name, $link, $icon)
{
    global $phpAds_shortcuts;
    $phpAds_shortcuts[] = array(
        'name' => $name,
        'link' => $link,
        'icon' => $icon
    );
}



/**
 * Show page header
 *
 * @param int ID
 * @param int Extra
 * @param int imgPath: a relative path to Images, CSS files. Used if calling function from anything other than admin folder
 * @param boolean set to false if you do not wish to show the grey sidebar
 * @param boolean set to false if you do not wish to show the main navigation
 * @param boolean set to true to hide white borders in the main part
 */
function phpAds_PageHeader($ID, $extra="", $imgPath="", $showSidebar=true, $showMainNav=true, $noBorder = false)
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
    if (isset($conf['ui']['gzipCompression']) && $conf['ui']['gzipCompression'] == 't') {
        ob_start("ob_gzhandler");
    }

    // Send header with charset info
    header ("Content-Type: text/html".(isset($phpAds_CharSet) && $phpAds_CharSet != "" ? "; charset=".$phpAds_CharSet : ""));

    // Generate layout
    $oTpl = new OA_Admin_Template('layout.html');
    $oTpl->assign('pageTitle', $pagetitle);
    $oTpl->assign('imgPath', $imgPath);
    $oTpl->assign('formValidation', !defined('phpAds_installing'));

    if (!empty($session['RUN_MPE']) && $session['RUN_MPE']) {
        require_once MAX_PATH . '/www/admin/lib-maintenance-priority.inc.php';
        $oTpl->assign('jsMPE', $xajax->getJavascript('./', 'js/xajax.js'));
    }

    if (!defined('phpAds_installing')) {
        // Include the flashObject resource file
        $oTpl->assign('jsFlash', MAX_flashGetFlashObjectExternal());
    }

    $oTpl->assign('headExtras', $head);

    $oTpl->assign('showSidebar', $showSidebar);

    // Header
    if (isset($conf['ui']['headerFilePath']) && $conf['ui']['headerFilePath'] != '') {
        ob_start();
        include ($conf['ui']['headerFilePath']);
        $oTpl->assign('headerFileOutput', ob_get_clean());
    }

    // Branding
    $oTpl->assign('applicationName', $conf['ui']['applicationName']);
    $oTpl->assign('logoFilePath', $conf['ui']['logoFilePath']);

    $displaySearch = ($ID != phpAds_Login && $ID != phpAds_Error && phpAds_isLoggedIn() && phpAds_isUser(phpAds_Admin|phpAds_Agency|phpAds_Affiliate) && !defined('phpAds_installing'));
    $oTpl->assign('displaySearch', $displaySearch);
    $oTpl->assign('searchUrl', MAX::constructURL(MAX_URL_ADMIN, 'admin-search.php'));

    $oTpl->display();


	echo "<div id='oaNavigation'>";

    if ($showMainNav == true) {
        echo $tabbar;
    }

    // Show currently logged on user and IP
	echo "<ul id='oaNavigationExtra'>";

    if (($ID != "" && phpAds_isLoggedIn()) || defined('phpAds_installing')) {
        if (!defined('phpAds_installing')) {
       		echo "<li class='infoUser'>{$session['username']} [{$_SERVER['REMOTE_ADDR']}]</li>";
            echo "<li class='buttonLogout'><a href='logout.php'>{$GLOBALS['strLogout']}</a></li>";
	        if ($helpLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId($phpAds_NavID)) {
    	        echo "<li class='buttonHelp'><a href='{$helpLink}' target='_blank' onclick=\"openWindow('{$helpLink}','','status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=700,height=500'); return false;\">{$GLOBALS['strHelp']}</a></li>";
        	}
            echo "<li class='buttonReportBugs'><a href='https://developer.openads.org/wiki/ReportingBugs' target='_blank'><img alt='Report a bug' src='{$imgPath}images/bug.png' /></a></li>";
        } else {
			echo "<li class='buttonStartOver'><a href='index.php'>{$GLOBALS['strStartOver']}</a></li>";
	        if ($helpLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId($phpAds_NavID)) {
    	        echo "<li class='buttonHelp'><a href='{$helpLink}' target='_blank' onclick=\"openWindow('{$helpLink}','','status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=700,height=500'); return false;\">{$GLOBALS['strHelp']}</a></li>";
        	}
            echo "<li class='buttonLogout'><a href='logout.php'>{$GLOBALS['strLogout']}</a></li>";
        }
    }

	echo "</ul>";		// oaNavigationExtra
	echo "</div>";		// oaNavigation

	echo "<div id='oaMain'>";

    if ($showSidebar != false) {
        echo $sidebar;
    }

    // Main contents
	echo "<div id='oaContents'>";

    echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
    echo "<tr>";
    if (!$noBorder) {
        echo "<td colspan='2' height='10'><img src='".$imgPath."images/spacer.gif' height='1'></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td width='20'>&nbsp;</td>";
    }
    echo "<td>";
}

/*-------------------------------------------------------*/
/* Show page footer                                      */
/*-------------------------------------------------------*/

function phpAds_PageFooter($imgPath='', $noBorder = false)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $pref = $GLOBALS['_MAX']['PREF'];
    global $session, $strMaintenanceNotActive;

    echo "</td>";
    if (!$noBorder) {
        echo "<td width='40'>&nbsp;</td>";
	    echo "</tr>";
    	// Spacer
	    echo "<tr>";
	    echo "<td width='40' height='20'>&nbsp;</td>";
	    echo "<td height='20'>&nbsp;</td>";
    }
    echo "</tr>";

    // Footer
    if (isset($conf['ui']['footerFilePath']) && $conf['ui']['footerFilePath'] != '') {
        echo "<tr>";
        echo "<td width='40' height='20'>&nbsp;</td>";
        echo "<td height='20'>";
        include ($conf['ui']['footerFilePath']);
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";

	echo "</div>";		// oaContents
	echo "</div>";		// oaMain

    if (!empty($session['RUN_MPE']) && $session['RUN_MPE'] === true) {
        echo "<div id='runMpe' name='runMpe'>&#160;</div>";
        echo "<script language='JavaScript' type='text/javascript'>";
        echo "<!--//\n";
        echo "xajax_OA_runMPE();";
        echo "//-->\n";
        echo "</script>";

        unset($session['RUN_MPE']);
        phpAds_SessionDataStore();
    }

    if (!ereg("/(index|updates-product|install|upgrade)\.php$", $_SERVER['PHP_SELF'])) {
        // Add Product Update redirector
        if (phpAds_isUser(phpAds_Admin) && $conf['sync']['checkForUpdates'] == 't' && !isset($session['maint_update_js'])) {
            echo "<script type='text/javascript' src='maintenance-updates-js.php'></script>\n";
        }
        // Check if the maintenance script is running
        if (phpAds_isUser(phpAds_Admin)) {
            if (($pref['maintenance_timestamp'] < time() - (60 * 60 * 24)) &&
                (!$conf['maintenance']['autoMaintenance'])) {
                if ($pref['maintenance_timestamp'] > 0) {
                    // The maintenance script hasn't run in the
                    // last 24 hours, warn the user
                    echo "<script type='text/javascript'>\n";
                    echo "<!--//\n";
                    echo "\talert('".$strMaintenanceNotActive."');\n";
                    echo "\tlocation.replace('maintenance-maintenance.php');\n";
                    echo "//-->\n";
                    echo "</script>\n";
                }
                // Update the timestamp to make sure the warning
                // is shown only once every 24 hours
                $doPreference = OA_Dal::factoryDO('preference');
                $doPreference->whereAdd('1 = 1'); //Global table update.
                $doPreference->maintenance_timestamp = time();
                $doPreference->update(DB_DATAOBJECT_WHEREADD_ONLY);
            }
        }
    }
    echo "</body>";
    echo "</html>";
    if (isset($conf['ui']['gzipCompression']) && $conf['ui']['gzipCompression'] == 't') {
        ob_end_flush();
    }
}

/**
 * Return all link parameters
 *
 * Appears to serialize an array to URL query string format,
 * with special exclusions for "entity" and "breakdown".
 *
 * @param array Associative array
 * @return string A string of the format "key1=value1&key2=value2"
 *
 * @todo Make it clear why 'entity' and 'breakdown' are handled specially
 * @todo Consider renaming this function to better illustrate its purpose
 */
function showParams($params)
{
    $tempStr = '';
    foreach($params as $k => $v) {
      if ($k != 'entity' && $k != 'breakdown') {
          $tempStr .= '&' . $k . '=' . $v;
      }
    }
    return $tempStr;
}

/**
 * Show section navigation
 *
 * @param array Sections to be displayed
 * @param array page params
 * @param boolean determines whether a new table should be created after displaying sections. Defaults to true. Set to false if you want no new table created, so that you can place your own HTML after the sections.
 *
 * @see getTranslation
 */
function phpAds_ShowSections($sections, $params=false, $openNewTable=true, $imgPath='', $customNav=false)
{
    global $phpAds_nav, $phpAds_NavID;

	// Close current table
	echo "</td></tr></table>";

	echo "<div id='oaSection'>";
	echo "<ul id='oaSectionTabs'>";

    // Prepare Navigation
    if ($customNav != false) {
        $pages  = $customNav;
    } elseif (phpAds_isUser(phpAds_Admin)) {
        $pages  = $phpAds_nav['admin'];
    } elseif (phpAds_isUser(phpAds_Agency)) {
        $pages  = $phpAds_nav['agency'];
    } elseif (phpAds_isUser(phpAds_Client)) {
        $pages  = $phpAds_nav['client'];
    } else {
        $pages  = $phpAds_nav['affiliate'];
    }

    for ($i=0; $i < count($sections); $i++) {
        list($sectionUrl, $sectionStr) = each($pages[$sections[$i]]);
        $selected = ($phpAds_NavID == $sections[$i]);
        if ($selected) {
            if (!empty($sectionUrl)) {
				echo "<li class='selected'><a href='" . $sectionUrl . ($params ? showParams($params) : '') . "'";
	            echo "' accesskey='".($i+1)."'>{$sectionStr}</a></li>";
            } else {
				echo "<li class='selected'><span>{$sectionStr}</span></li>";
            }
        } else {
            if (!empty($sectionUrl)) {
				echo "<li><a href='" . $sectionUrl . ($params ? showParams($params) : '') . "'";
	            echo "' accesskey='".($i+1)."'>{$sectionStr}</a></li>";
            } else {
				echo "<li><span>{$sectionStr}</span></li>";
            }
        }
        $previousselected = $selected;
    }
	echo "</ul></div>";

    if ($openNewTable==true) {
        echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
        echo "<td width='40'>&nbsp;</td><td><br />";
    }
}

/*-------------------------------------------------------*/
/* Show a light gray line break                          */
/*-------------------------------------------------------*/

function phpAds_ShowBreak($print = true, $imgPath = '')
{
	$buffer = "</td></tr></table>";
	$buffer .= "<hr />";
	$buffer .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
    $buffer .= "<td width='40'>&nbsp;</td><td><br />";

    if ($print) {
        echo $buffer;
    }

    return $buffer;
}

/*-------------------------------------------------------*/
/* Show a the last SQL error and die                     */
/*-------------------------------------------------------*/

function phpAds_sqlDie()
{
    global $phpAds_last_query;

    $corrupt = false;
    $aConf = $GLOBALS['_MAX']['CONF'];
    if (strcasecmp($aConf['database']['type'], 'mysql') === 0) {
        $error = mysql_error();
        $errornumber = mysql_errno();
        if ($errornumber == 1027 || $errornumber == 1039) {
            $corrupt = true;
        }
        if ($errornumber == 1016 || $errornumber == 1030) {
            // Probably corrupted table, do additional check
            eregi ("[0-9]+", $error, $matches);
            if ($matches[0] == 126 || $matches[0] == 127 ||
            $matches[0] == 132 || $matches[0] == 134 ||
            $matches[0] == 135 || $matches[0] == 136 ||
            $matches[0] == 141 || $matches[0] == 144 ||
            $matches[0] == 145) {
                $corrupt = true;
            }
        }

        $dbmsName = 'MySQL';
    } elseif (strcasecmp($aConf['database']['type'], 'pgsql') === 0) {
        $error = pg_errormessage();
        $dbmsName = 'PostgreSQL';
    } else {
        $error = '';
        $dbmsName = 'Unknown';
    }
    if ($corrupt) {
        $title    = $GLOBALS['strErrorDBSerious'];
        $message  = $GLOBALS['strErrorDBNoDataSerious'];
        if (phpAds_isLoggedIn() && phpAds_isUser(phpAds_Admin)) {
            $message .= " (".$error.").<br><br>".$GLOBALS['strErrorDBCorrupt'];
        } else {
            $message .= ".<br>".$GLOBALS['strErrorDBContact'];
        }
    } else {
        $title    = $GLOBALS['strErrorDBPlain'];
        $message  = $GLOBALS['strErrorDBNoDataPlain'];
        if ((phpAds_isLoggedIn() && (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency))) || defined('phpAds_installing')) {

            // Get the DB server version
            $connection = DBC::getCurrentConnection();
            $connectionId = $connection->getConnectionId();
            $aVersion = $connectionId->getServerVersion();
            $dbVersion = $aVersion['major'] . '.' . $aVersion['minor'] . '.' . $aVersion['patch'] . '-' . $aVersion['extra'];

            $message .= $GLOBALS['strErrorDBSubmitBug'];
            $last_query = $phpAds_last_query;
            $message .= "<br><br><table cellpadding='0' cellspacing='0' border='0'>";
            $message .= "<tr><td valign='top' nowrap><b>Version:</b>&nbsp;&nbsp;&nbsp;</td><td>".MAX_PRODUCT_NAME." v".OA_VERSION."</td></tr>";
            $message .= "<tr><td valien='top' nowrap><b>PHP/DB:</b></td><td>PHP ".phpversion()." / ".$dbmsName." " . $dbVersion . "</td></tr>";
            $message .= "<tr><td valign='top' nowrap><b>Page:</b></td><td>".$_SERVER['PHP_SELF']."</td></tr>";
            $message .= "<tr><td valign='top' nowrap><b>Error:</b></td><td>".$error."</td></tr>";
            $message .= "<tr><td valign='top' nowrap><b>Query:</b></td><td><pre>".$last_query."</pre></td></tr>";
            $message .= "<tr><td valign='top' nowrap><b>\$_POST:</b></td><td><pre>".(empty($_POST) ? 'Empty' : print_r($_POST, true))."</pre></td></tr>";
            $message .= "<tr><td valign='top' nowrap><b>\$_GET:</b></td><td><pre>".(empty($_GET) ? 'Empty' : print_r($_GET, true))."</pre></td></tr>";
            $message .= "</table>";
        }
    }
    phpAds_Die ($title, $message);
}

/*-------------------------------------------------------*/
/* Display a custom error message and die                */
/*-------------------------------------------------------*/

function phpAds_Die($title="Error", $message="Unknown error", $imgPath="")
{
    $conf = $GLOBALS['_MAX']['CONF'];
    global $phpAds_GUIDone, $phpAds_TextDirection;
    // Header
    if ($phpAds_GUIDone == false) {
        if (!isset($phpAds_TextDirection)) {
            $phpAds_TextDirection = 'ltr';
        }
        phpAds_PageHeader(phpAds_Error);
    }
    // Message
    echo "<br>";
    echo "<div class='errormessage'><img class='errormessage' src='".$imgPath."images/errormessage.gif' align='absmiddle'>";
    echo "<span class='tab-r'>".$title."</span><br><br>".$message."</div><br>";
    // Die
    if ($title == $GLOBALS['strAccessDenied']) {
        $_COOKIE['sessionID'] = phpAds_SessionStart();
        phpAds_LoginScreen('', $_COOKIE['sessionID'], true);
    }
    phpAds_PageFooter();
    exit;
}

/*-------------------------------------------------------*/
/* Show a confirm message for delete / reset actions     */
/*-------------------------------------------------------*/

function phpAds_DelConfirm($msg)
{
    $pref = $GLOBALS['_MAX']['PREF'];
    if (phpAds_isUser(phpAds_Admin)) {
        if ($pref['admin_novice']) {
            $str = " onclick=\"return confirm('".$msg."');\"";
        } else {
            $str = "";
        }
    } else {
        $str = " onclick=\"return confirm('".$msg."');\"";
    }
    return $str;
}

/**
 * Displays progress bar in the supposed centre of the screen. Accompanied by
 * the Javascript showLoader() function in the openads.js.
 *
 * @param string $message Message to be displayed with the progress bar.
 */
function OA_GUI_getHtmlForDbLoader($message)
{
    echo "<div id=\"dbLoader\" class=\"pageLoader tab-s\" style=\"display: none;\"><div>$message</div></div>";
}

?>
<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
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

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Admin/Help.php';
require_once MAX_PATH . '/lib/OA/Admin/UI.php';
require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/Delivery/flash.php';
require_once MAX_PATH . '/lib/OA/Permission.php';
require_once MAX_PATH . '/lib/OA/Auth.php';

require_once OX_PATH . '/lib/OX.php';

// Define defaults
$OA_Navigation_ID  = '';
$phpAds_GUIDone    = false;
$phpAds_context    = array();
$phpAds_shortcuts  = array();
$phpAds_breadcrumbs  = array();
$phpAds_breadcrumbs_extra  = '';

define("phpAds_Login", 0);
define("phpAds_Error", -1);
define("phpAds_PasswordRecovery", -2);

/*-------------------------------------------------------*/
/* Add breadcrumb context to left menubar                */
/*-------------------------------------------------------*/

function phpAds_PageContext($name, $link, $selected)
{
    global $phpAds_context;
    $phpAds_context[] = array(
        'name' => $name,
        'name_full' => preg_replace("/<\\/?span.*>/U", "",$name),
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
        'icon' => OX::assetPath() . "/" . $icon
    );
}

function registerStylesheetFile($filePath)
{
    $GLOBALS['_MAX']['ADMIN_UI'] = OA_Admin_UI::getInstance();
    $GLOBALS['_MAX']['ADMIN_UI']->registerStylesheetFile($filePath);
}


/**
 * Show page header
 *
 * @todo Remove the "if stats, use numeric system" mechanism, should happen with the stats rewrite
 *       Also, this function seems to just be a wrapper to OA_Admin_UI::showHeader()... removing it would seem to make sense
 *
 * @param string ID If not passed in (or null) the page filename is used as the ID
 * @param string Extra
 * @param string imgPath: a relative path to Images, CSS files. Used if calling function from anything other than admin folder
 * @param boolean set to false if you do not wish to show the grey sidebar
 * @param boolean set to false if you do not wish to show the main navigation
 * @param boolean set to true to hide white borders between main nav and sub nav in the main part
 */
function phpAds_PageHeader($ID = null, $extra="", $imgPath="", $showSidebar=true, $showMainNav=true, $noBorder = false)
{
    $GLOBALS['_MAX']['ADMIN_UI'] = OA_Admin_UI::getInstance();
    $GLOBALS['_MAX']['ADMIN_UI']->showHeader($ID, $extra, $imgPath, $showSidebar, $showMainNav, $noBorder);
    $GLOBALS['phpAds_GUIDone'] = true;
}

/*-------------------------------------------------------*/
/* Show page footer                                      */
/*-------------------------------------------------------*/

function phpAds_PageFooter($imgPath='', $noBorder = false)
{
    if (isset($GLOBALS['_MAX']['ADMIN_UI'])) {
        $GLOBALS['_MAX']['ADMIN_UI']->showFooter();
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
	/*
    global $OA_Navigation, $OA_Navigation_ID;

	// Close current table
	echo "</td></tr></table>";

	echo "<div id='oaSection'>";
	echo "<a id='context-help' target='_blank' href='" . OA_Admin_Help::getDocLinkFromPhpAdsNavId($OA_Navigation_ID) . "'>Help</a>";
	echo "<ul id='oaSectionTabs'>";

    // Prepare Navigation
    if ($customNav != false) {
        $pages  = $customNav;
    } else {
        $accountType = OA_Permission::getAccountType();
        $pages = $OA_Navigation[$accountType];
    }

	$previousselect = false;
    for ($i=0; $i < count($sections); $i++) {
        if (!isset($pages[$sections[$i]])) {
            OA::debug(__FUNCTION__.": navigation array doesn't contain {$sections[$i]}", PEAR_LOG_DEBUG);
            continue;
        }
        list($sectionUrl, $sectionStr) = each($pages[$sections[$i]]);
        $selected = ($OA_Navigation_ID == $sections[$i]);

        if ($selected) {
			echo "<li class='active" . ($i == 0 ? " first" : "" ) . ($i == count($sections) - 1 ? " last" : "" ) . "'>";
			echo "<div class='right'><div class='left'>";
            if (!empty($sectionUrl)) {
				echo "<a href='" . $sectionUrl . ($params ? showParams($params) : '') . "'";
	            echo " accesskey='".($i+1)."'>{$sectionStr}</a>";
            } else {
				echo "<span>{$sectionStr}</span>";
            }
			echo "</div></div></li>";
        }
      else {
			echo "<li class='passive" . ($i == 0 ? " first" : "" ) . ($i == count($sections) - 1 ? " last" : "" ) . ($previousselected ? "  after-active" : "") . "'>";
			echo "<div class='right'><div class='left'>";
            if (!empty($sectionUrl)) {
				echo "<a href='" . $sectionUrl . ($params ? showParams($params) : '') . "'";
	            echo " accesskey='".($i+1)."'>{$sectionStr}</a>";
            } else {
				echo "<span>{$sectionStr}</span>";
            }
			echo "</div></div></li>";
        }
        $previousselected = $selected;
    }
	echo "</ul></div>";

    if ($openNewTable==true) {
        echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
        echo "<td width='40'>&nbsp;</td><td><br />";
    }
*/
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
        if (OA_Auth::isLoggedIn() && OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $message .= " (".$error.").<br><br>".$GLOBALS['strErrorDBCorrupt'];
        } else {
            $message .= ".<br>".$GLOBALS['strErrorDBContact'];
        }
    } else {
        $title    = $GLOBALS['strErrorDBPlain'];
        $message  = $GLOBALS['strErrorDBNoDataPlain'];
        if ((OA_Auth::isLoggedIn() && (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER))) || defined('phpAds_installing')) {

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

function phpAds_Die($title="Error", $message="Unknown error")
{
    $conf = $GLOBALS['_MAX']['CONF'];
    global $phpAds_GUIDone, $phpAds_TextDirection;

    $header = ($title == $GLOBALS['strAccessDenied']) ? phpAds_Login : phpAds_Error;
    // Header
    if ($phpAds_GUIDone == false) {
        if (!isset($phpAds_TextDirection)) {
            $phpAds_TextDirection = 'ltr';
        }
        phpAds_PageHeader(phpAds_Error);
    }
    // Message
    echo "<br>";
    echo "<div class='errormessage'><img class='errormessage' src='". OX::assetPath() ."/images/errormessage.gif' align='absmiddle'>";
    echo "<span class='tab-r'>".$title."</span><br><br>".$message."</div><br>";
    // Die
    if ($header == phpAds_Login) {
        $_COOKIE['sessionID'] = phpAds_SessionStart();
        OA_Auth::displayLogin('', $_COOKIE['sessionID'], true);
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
    if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
        if ($pref['ui_novice_user']) {
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
 * the Javascript showLoader() function in the openx.js.
 *
 * @param string $message Message to be displayed with the progress bar.
 */
function OA_GUI_getHtmlForDbLoader($message)
{
    echo "<div id=\"dbLoader\" class=\"pageLoader tab-s\" style=\"display: none;\"><div>$message</div></div>";
}

?>

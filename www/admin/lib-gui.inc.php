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

// Required files
require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Admin/Help.php';
require_once MAX_PATH . '/lib/OA/Admin/UI.php';
require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/Delivery/flash.php';
require_once MAX_PATH . '/lib/OA/Permission.php';
require_once MAX_PATH . '/lib/OA/Auth.php';

require_once OX_PATH . '/lib/OX.php';

// Define defaults
$OA_Navigation_ID = '';
$phpAds_GUIDone = false;
$phpAds_context = [];
$phpAds_shortcuts = [];
$phpAds_breadcrumbs = [];
$phpAds_breadcrumbs_extra = '';

define("phpAds_Login", 0);
define("phpAds_Error", -1);
define("phpAds_PasswordRecovery", -2);


function phpAds_PageContext($name, $link, $selected)
{
}

/*-------------------------------------------------------*/
/* Add shortcuts to left menubar                         */
/*-------------------------------------------------------*/

function phpAds_PageShortcut($name, $link, $icon)
{
    global $phpAds_shortcuts;
    $phpAds_shortcuts[] = [
        'name' => $name,
        'link' => $link,
        'icon' => OX::assetPath() . "/" . $icon
    ];
}

function registerStylesheetFile($filePath)
{
    $GLOBALS['_MAX']['ADMIN_UI'] = OA_Admin_UI::getInstance();
    $GLOBALS['_MAX']['ADMIN_UI']->registerStylesheetFile($filePath);
}


/**
 * Adds new action to the page.
 *
 * Please note that you need to add tools before invoking showHeader function.
 *
 * @param string $title action title - translated
 * @param string $url link url for the action
 * @param string $iconClass icon class for action (if any)
 * @param string $accesskey access key for action (if any)
 * @param string $extraAttributes extra html attributes for action link (if any)
 */
function addPageLinkTool($title, $url, $iconClass = null, $accesskey = null, $extraAttributes = null)
{
    $oUI = OA_Admin_UI::getInstance();
    $oUI->addPageLinkTool($title, $url, $iconClass, $accesskey, $extraAttributes);
}

/**
 * Adds new action to the page.
 *
 * Please note that you need to add tools before invoking showHeader function.
 *
 * @param string $title action title - translated
 * @param string $iconClass icon class for action (if any)
 * @param string $form The HTML of the form
 */
function addPageFormTool($title, $iconClass, $form)
{
    $oUI = OA_Admin_UI::getInstance();
    $oUI->addPageFormTool($title, $iconClass, $form);
}

/**
 * A hook to add left menu subitems to current left menu item
 *
 */
function addLeftMenuSubItem($id, $title, $url)
{
    global $ox_left_menu_sub;

    $ox_left_menu_sub['items'][$id]['title'] = $title;
    $ox_left_menu_sub['items'][$id]['link'] = $url;
}


function setCurrentLeftMenuSubItem($itemId)
{
    global $ox_left_menu_sub;

    $ox_left_menu_sub['current'] = $itemId;
}


/**
 * Adds new shortcut to the page.
 *
 * Please note that you need to add shortcuts before invoking showHeader function.
 *
 * @param string $title action title - translated
 * @param string $url link url for the action
 * @param string $iconClass icon class for action; see icons.css for examples of icon classes
 * @param string $accesskey access key for action (if any)
 */
function addPageShortcut($title, $url, $iconClass, $accesskey = null)
{
    $oUI = OA_Admin_UI::getInstance();
    $oUI->addPageShortcut($title, $url, $iconClass);
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
 * @param bool $showSidebar Set to false if you do not wish to show the sidebar navigation
 * @param bool $showContentFrame Set to false if you do not wish to show the content frame
 * @param bool $showMainNavigation Set to false if you do not wish to show the main navigation
 */
function phpAds_PageHeader($ID = null, $headerModel = null, $imgPath = "", $showSidebar = true, $showContentFrame = true, $showMainNavigation = true)
{
    $GLOBALS['_MAX']['ADMIN_UI'] = OA_Admin_UI::getInstance();
    $GLOBALS['_MAX']['ADMIN_UI']->showHeader($ID, $headerModel, $imgPath, $showSidebar, $showContentFrame, $showMainNavigation);
    $GLOBALS['phpAds_GUIDone'] = true;
}

/*-------------------------------------------------------*/
/* Show page footer                                      */
/*-------------------------------------------------------*/

function phpAds_PageFooter($imgPath = '')
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
    foreach ($params as $k => $v) {
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
function phpAds_ShowSections($sections, $params = false, $openNewTable = true, $imgPath = '', $customNav = false)
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

    if (strcasecmp($aConf['database']['type'], 'mysqli') === 0) {
        $dbLink = $GLOBALS['_MAX']['database'] ?? OA_DB::singleton()->getConnection();
        $error = mysqli_error($dbLink);
        $errornumber = mysqli_errno($dbLink);

        if ($errornumber == 1027 || $errornumber == 1039) {
            $corrupt = true;
        }

        if ($errornumber == 1016 || $errornumber == 1030) {
            // Probably corrupted table, do additional check
            preg_match("/[0-9]+/Di", $error, $matches);
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
        $title = $GLOBALS['strErrorDBSerious'];
        $message = sprintf($GLOBALS['strErrorDBNoDataSerious'], PRODUCT_NAME);
        if (OA_Auth::isLoggedIn() && OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $message .= " (" . $error . ").<br><br>" . $GLOBALS['strErrorDBCorrupt'];
        } else {
            $message .= ".<br>" . $GLOBALS['strErrorDBContact'];
        }
    } else {
        $title = $GLOBALS['strErrorDBPlain'];
        $message = sprintf($GLOBALS['strErrorDBNoDataPlain'], PRODUCT_NAME);
        if ((OA_Auth::isLoggedIn() && (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER))) || defined('phpAds_installing')) {

            // Get the DB server version
            $connection = DBC::getCurrentConnection();
            $connectionId = $connection->getConnectionId();
            $aVersion = $connectionId->getServerVersion();
            $dbVersion = $aVersion['major'] . '.' . $aVersion['minor'] . '.' . $aVersion['patch'] . '-' . $aVersion['extra'];

            $message .= sprintf($GLOBALS['strErrorDBSubmitBug'], PRODUCT_NAME);
            $last_query = $phpAds_last_query;
            $message .= "<br><br><table cellpadding='0' cellspacing='0' border='0'>";
            $message .= "<tr><td valign='top' nowrap><b>Version:</b>&nbsp;&nbsp;&nbsp;</td><td>" . htmlspecialchars(PRODUCT_NAME) . " v" . htmlspecialchars(VERSION) . "</td></tr>";
            $message .= "<tr><td valien='top' nowrap><b>PHP/DB:</b></td><td>PHP " . phpversion() . " / " . $dbmsName . " " . $dbVersion . "</td></tr>";
            $message .= "<tr><td valign='top' nowrap><b>Page:</b></td><td>" . htmlspecialchars($_SERVER['PHP_SELF']) . "</td></tr>";
            $message .= "<tr><td valign='top' nowrap><b>Error:</b></td><td>" . htmlspecialchars($error) . "</td></tr>";
            $message .= "<tr><td valign='top' nowrap><b>Query:</b></td><td><pre>" . htmlspecialchars($last_query) . "</pre></td></tr>";
            $message .= "<tr><td valign='top' nowrap><b>\$_POST:</b></td><td><pre>" . (empty($_POST) ? 'Empty' : htmlspecialchars(print_r($_POST, true))) . "</pre></td></tr>";
            $message .= "<tr><td valign='top' nowrap><b>\$_GET:</b></td><td><pre>" . (empty($_GET) ? 'Empty' : htmlspecialchars(print_r($_GET, true))) . "</pre></td></tr>";
            $message .= "</table>";
        }
    }

    phpAds_Die($title, $message);
}

/*-------------------------------------------------------*/
/* Display a custom error message and die                */
/*-------------------------------------------------------*/

function phpAds_Die($title = "Error", $message = "Unknown error")
{
    if (defined('OA_WEBSERVICES_API_XMLRPC')) {
        // It's an XML-RPC response
        if (class_exists('XmlRpcUtils')) {
            $oResponse = XmlRpcUtils::generateError($message);
        } else {
            $oResponse = new XML_RPC_Response('', 99999, $message);
        }
        echo $oResponse->serialize();
        exit;
    }
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
    echo "<br>";
    echo "<div class='errormessage'><img class='errormessage' src='" . OX::assetPath() . "/images/errormessage.gif' align='absmiddle'> ";
    echo "<span class='tab-r'>" . $title . "</span><br><br>" . $message . "</div><br>";
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
            $str = " onclick=\"return confirm('" . $msg . "');\"";
        } else {
            $str = "";
        }
    } else {
        $str = " onclick=\"return confirm('" . $msg . "');\"";
    }
    return $str;
}

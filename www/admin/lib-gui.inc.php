<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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
require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/Delivery/flash.php';
require_once MAX_PATH . '/www/admin/lib-permissions.inc.php';

// Define defaults
$phpAds_Message     = '';
$phpAds_NavID        = '';
$phpAds_GUIDone     = false;
$phpAds_showHelp    = false;
$phpAds_helpDefault = '';
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

function phpAds_writeHeader($displaySearch = true, $fromSearchWindow = false, $client='', $campaign='', $banner='', $zone='', $affiliate='', $compact='')
{
    $pref = $GLOBALS['_MAX']['PREF'];
    global $phpAds_TextAlignRight, $phpAds_TextDirection, $keySearch, $strSearch;
    $headerBackgroundColor = phpAds_getHeaderBackgroundColor();
    $headerForegroundColor = phpAds_getHeaderForegroundColor();
    $keyLineColor = phpAds_getKeyLineColor();

    if ($displaySearch) {
        $searchUrl = phpAds_isUser(phpAds_Affiliate) ? 'affiliate-search.php' : 'admin-search.php';
        if ($fromSearchWindow) {
            $form = "<form name='search' action='{$searchUrl}' method='post'>
            <input type='hidden' name='client' value='$client'>
            <input type='hidden' name='campaign' value='$campaign'>
            <input type='hidden' name='banner' value='$banner'>
            <input type='hidden' name='zone' value='$zone'>
            <input type='hidden' name='affiliate' value='$affiliate'>
            <input type='hidden' name='compact' value='$compact'>";
        } else {
            $form = "\t\t<form name='search' action='{$searchUrl}' target='SearchWindow' onSubmit=\"search_window(document.search.keyword.value,'".MAX::constructURL(MAX_URL_ADMIN, $searchUrl)."'); return false;\">\n";
        }
        $searchbar  = "\t\t<table cellpadding='0' cellspacing='0' border='0' bgcolor='#$headerForegroundColor'>\n";
        $searchbar .= $form;
        $searchbar .= "\t\t<tr height='24'>\n";
        $searchbar .= "\t\t\t\t\t<td width='1'><table border='0' cellspacing='0' cellpadding='0'><tr height='17'><td width='1' bgcolor='#$keyLineColor'><img src='images/spacer.gif' height='17' width='1'></td></tr><tr height='7'><td width='1' bgcolor='#$headerBackgroundColor'><img src='images/spacer.gif' height='7' width='1'></td></tr></table></td>\n";
        $searchbar .= "\t\t\t<td valign='bottom'><img src='images/$phpAds_TextDirection/tab-bottomleftcorner-$headerBackgroundColor.gif' height='21' width='7'></td>\n";
        $searchbar .= "\t\t\t<td class='tab-u'><img src='images/spacer.gif' width='4'>$strSearch:</td>\n";
        $searchbar .= "\t\t\t<td>&nbsp;&nbsp;<input type='text' name='keyword' size='15' class='search' accesskey='".$keySearch."'>&nbsp;&nbsp;</td>\n";
        $searchbar .= "\t\t\t<td><a href=\"javascript:search_window(document.search.keyword.value,'".MAX::constructURL(MAX_URL_ADMIN, $searchUrl)."');\"><img src='images/".$phpAds_TextDirection."/go.gif' border='0'></a></td>\n";
        $searchbar .= "\t\t\t<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>\n";
        $searchbar .= "\t\t</tr>\n";
        $searchbar .= "\t\t<tr height='1'>\n";
        $searchbar .= "\t\t\t<td colspan='2' bgcolor='#$headerBackgroundColor'><img src='images/spacer.gif' height='1'></td>\n";
        $searchbar .= "\t\t\t<td colspan='4' bgcolor='#$keyLineColor'><img src='images/spacer.gif' height='1'></td>\n";
        $searchbar .= "\t\t</tr>\n";
        $searchbar .= "\t\t</form>\n";
        $searchbar .= "\t\t</table>\n";
    } else {
        $searchbar = "\t\t&nbsp;\n";
    }
    echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>\n";
    echo "<tr>\n";
    $logo = !empty($pref['my_logo']) ? 'images/'.$pref['my_logo'] : 'images/logo-s.gif';
    if (!empty($pref['name'])) {
        $productName = $pref['name'];
    } elseif (empty($pref['my_logo'])) {
        $productName = MAX_PRODUCT_NAME;
    } else {
        $productName = '';
    }
    echo "\t<td bgcolor='#$headerBackgroundColor'><img src=images/spacer.gif height='48' width='10'>";
    echo "<img src='$logo' align='absmiddle'><img src=images/spacer.gif height='48' width='20'>";
    echo "<span class='phpAdsNew'>$productName</span>";
    echo "</td>\n";
    echo "\t<td bgcolor='#$headerBackgroundColor' valign='top' align='$phpAds_TextAlignRight'>\n";
    echo $searchbar;
    echo "\t</td>\n";
    echo "</tr>\n";
    echo "</table>\n";
}

function phpAds_getHeaderBackgroundColor()
{
    $pref = $GLOBALS['_MAX']['PREF'];
    return !empty($pref['gui_header_background_color']) ? $pref['gui_header_background_color'] : '000063';
}

function phpAds_getHeaderForegroundColor()
{
    $pref = $GLOBALS['_MAX']['PREF'];
    return !empty($pref['gui_header_foreground_color']) ? $pref['gui_header_foreground_color'] : '0066CC';
}

function phpAds_getHeaderActiveTabColor()
{
    $pref = $GLOBALS['_MAX']['PREF'];
    return !empty($pref['gui_header_active_tab_color']) ? $pref['gui_header_active_tab_color'] : 'FFFFFF';
}

function phpAds_getHeaderTextColor()
{
    $pref = $GLOBALS['_MAX']['PREF'];
    return !empty($pref['gui_header_text_color']) ? $pref['gui_header_text_color'] : 'FFFFFF';
}

function phpAds_getKeyLineColor()
{
    $pref = $GLOBALS['_MAX']['PREF'];
    return !empty($pref['gui_header_key_line_color']) ? $pref['gui_header_key_line_color'] : '999999';
}


/*-------------------------------------------------------*/
/* Show page header                                      */
/*-------------------------------------------------------*/

function phpAds_PageHeader($ID, $extra="")
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $pref = $GLOBALS['_MAX']['PREF'];
    global $phpAds_TextDirection, $phpAds_TextAlignRight, $phpAds_TextAlignLeft;
    global $phpAds_Message, $phpAds_GUIDone, $phpAds_NavID;
    global $phpAds_context, $phpAds_shortcuts;
    global $phpAds_nav, $pages, $phpAds_showHelp;
    global $phpAds_CharSet;
    global $strLogout, $strNavigation, $strShortcuts;
    global $strAuthentification, $strSearch, $strHelp;
    global $keyHome, $keyUp, $keyNextItem, $keyPreviousItem, $keySearch, $session;
    global $breakdown;
    $phpAds_GUIDone = true;
    $phpAds_NavID   = $ID;
    $mozbar = '';
    $headerForegroundColor = phpAds_getHeaderForegroundColor();
    $headerBackgroundColor = phpAds_getHeaderBackgroundColor();
    $headerActiveTabColor = phpAds_getHeaderActiveTabColor();
    $headerTextColor = phpAds_getHeaderTextColor();
    $keyLineColor = phpAds_getKeyLineColor();

    // Travel navigation
    $tabbar = '';
    $tabbottom = '';
    $tabtop = '';
    if ($ID != phpAds_Login && $ID != phpAds_Error) {
        // Prepare Navigation
        if (phpAds_isUser(phpAds_Admin)) {
            $pages    = $phpAds_nav['admin'];
        } elseif (phpAds_isUser(phpAds_Agency)) {
            $pages    = $phpAds_nav['agency'];
        } elseif (phpAds_isUser(phpAds_Client)) {
            $pages  = $phpAds_nav['client'];
        } else {
            $pages  = $phpAds_nav['affiliate'];
        }
        // Build sidebar
        $sections = explode(".", $ID);
        $sectionID = "";
        $sidebar  = "\t\t\t\t<table width='160' cellpadding='0' cellspacing='0' border='0'>\n";
        $sidebar .= "\t\t\t\t<tr>\n";
        $sidebar .= "\t\t\t\t\t<td colspan='2' class='nav'><b>$strNavigation</b></td>\n";
        $sidebar .= "\t\t\t\t</tr>\n";
        $sidebar .= "\t\t\t\t<tr>\n";
        $sidebar .= "\t\t\t\t\t<td colspan='2'><img src='images/break.gif' height='1' width='160' vspace='4'></td>\n";
        $sidebar .= "\t\t\t\t</tr>\n";
        for ($i=0; $i<count($sections)-1; $i++) {
            $sectionID .= $sections[$i];
            list($filename, $title) = each($pages["$sectionID"]);
            $sectionID .= ".";
            if ($i==0) {
                $sidebar .= "\t\t\t\t<tr>\n";
                $sidebar .= "\t\t\t\t\t<td width='20' valign='top'><img src='images/caret-t.gif' width='11' height='7'>&nbsp;</td>\n";
                $sidebar .= "\t\t\t\t\t<td width='140'><a href='$filename'>$title</a></td>\n";
                $sidebar .= "\t\t\t\t</tr>\n";
                $sidebar .= "\t\t\t\t<tr>\n";
                $sidebar .= "\t\t\t\t\t<td colspan='2'><img src='images/break.gif' height='1' width='160' vspace='4'></td>\n";
                $sidebar .= "\t\t\t\t</tr>\n";
                $mozbar  .= "\t\t<link REL='top' HREF='$filename' TITLE='$title'>\n";
            } else {
                $sidebar .= "\t\t\t\t<tr>\n";
                $sidebar .= "\t\t\t\t\t<td width='20' valign='top'><img src='images/caret-u.gif' width='11' height='7'>&nbsp;</td>\n";
                $sidebar .= "\t\t\t\t\t<td width='140'><a href='$filename'".($i == count($sections) - 2 ? " accesskey='".$keyUp."'" : "").">$title</a></td>\n";
                $sidebar .= "\t\t\t\t</tr>\n";
            }
            if ($i == count($sections) - 2) {
                $mozbar  .= "\t\t<link REL='up' HREF='$filename' TITLE='$title'>\n";
            }
        }
        if (isset($pages["$ID"]) && is_array($pages["$ID"])) {
            list($filename, $title) = each($pages["$ID"]);
            $sidebar .= "\t\t\t\t<tr>\n";
            $sidebar .= "\t\t\t\t\t<td width='20'valign='top'><img src='images/caret-u.gif' width='11' height='7'>&nbsp;</td>\n";
            $sidebar .= "\t\t\t\t\t<td width='140' class='nav'>$title</td>\n";
            $sidebar .= "\t\t\t\t</tr>\n";
            $sidebar .= "\t\t\t\t<tr>\n";
            $sidebar .= "\t\t\t\t\t<td colspan='2'><img src='images/break.gif' height='1' width='160' vspace='4'></td>\n";
            $sidebar .= "\t\t\t\t</tr>";
            $pagetitle  = isset($pref['name']) && $pref['name'] != '' ? $pref['name'] : MAX_PRODUCT_NAME;
            $pagetitle .= ' - '.$title;
        } else {
            $pagetitle = isset($pref['name']) && $pref['name'] != '' ? $pref['name'] : MAX_PRODUCT_NAME;
        }

        //show only +- 7 records for 'daily' pages
        if($breakdown == 'daily') {
            foreach($phpAds_context as $k => $v) {
                if($v['selected'] == 1) {
                    $up_limit = $k + 9;
                    if($k > 7) {
                        $down_limit = $k - 8;
                    } else {
                        $down_limit = 0;
                    }

                }

            }
        } else {
            $up_limit = count($phpAds_context);
            $down_limit=0;
        }

        // Build Context
        if (count($phpAds_context)) {
            $sidebar .= "\t\t\t\t<tr>\n";
            $sidebar .= "\t\t\t\t\t<td width='20'>&nbsp;</td>\n";
            $sidebar .= "\t\t\t\t\t<td width='140'>\n";
            $sidebar .= "\t\t\t\t\t\t<table width='140' cellpadding='0' cellspacing='0' border='0'>\n";
            $selectedcontext = '';
            for ($ci=$down_limit; $ci < $up_limit; $ci++) {
                if ($phpAds_context[$ci]['selected']) {
                    $selectedcontext = $ci;
                }
            }
            for ($ci=$down_limit; $ci < $up_limit; $ci++) {
                $ac = '';
                if ($ci == $selectedcontext - 1) $ac = $keyPreviousItem;
                if ($ci == $selectedcontext + 1) $ac = $keyNextItem;
                if ($phpAds_context[$ci]['selected']) {
                    $sidebar .= "\t\t\t\t\t\t<tr>\n";
                    $sidebar .= "\t\t\t\t\t\t\t<td width='20' valign='top'><img src='images/box-1.gif'>&nbsp;</td>\n";
                } else {
                    $sidebar .= "\t\t\t\t\t\t<tr>\n";
                    $sidebar .= "\t\t\t\t\t\t\t<td width='20' valign='top'><img src='images/box-0.gif'>&nbsp;</td>\n";
                }
                $sidebar .= "\t\t\t\t\t\t\t<td width='120'><a href='".$phpAds_context[$ci]['link']."'".($ac != '' ? " accesskey='".$ac."'" : "").">";
                $sidebar .= str_replace('-', '-<wbr />', $phpAds_context[$ci]['name'])."</a></td>\n";
                $sidebar .= "\t\t\t\t\t\t</tr>\n";
            }
            $sidebar .= "\t\t\t\t\t\t</table>\n";
            $sidebar .= "\t\t\t\t\t</td>\n";
            $sidebar .= "\t\t\t\t</tr>\n";
            $sidebar .= "\t\t\t\t<tr>\n";
            $sidebar .= "\t\t\t\t\t<td colspan='2'><img src='images/break.gif' height='1' width='160' vspace='4'></td>\n";
            $sidebar .= "\t\t\t\t</tr>\n";
        }
        $sidebar .= "\t\t\t\t</table>\n";
        // Include custom HTML for the sidebar
        if ($extra != '') $sidebar .= $extra;
        // Include shortcuts
        if (count($phpAds_shortcuts)) {
            $sidebar .= "\t\t\t\t<br><br><br>\n";
            $sidebar .= "\t\t\t\t<table width='160' cellpadding='0' cellspacing='0' border='0'>\n";
            $sidebar .= "\t\t\t\t<tr>\n";
            $sidebar .= "\t\t\t\t\t<td colspan='2' class='nav'><b>$strShortcuts</b></td>\n";
            $sidebar .= "\t\t\t\t</tr>\n";
            for ($si=0; $si<count($phpAds_shortcuts); $si++) {
                $sidebar .= "\t\t\t\t<tr>\n";
                $sidebar .= "\t\t\t\t\t<td colspan='2'><img src='images/break.gif' height='1' width='160' vspace='4'></td>\n";
                $sidebar .= "\t\t\t\t</tr>\n";
                $sidebar .= "\t\t\t\t<tr>\n";
                $sidebar .= "\t\t\t\t\t<td width='20' valign='top'><img src='".$phpAds_shortcuts[$si]['icon']."' align='absmiddle'>&nbsp;</td>\n";
                $sidebar .= "\t\t\t\t\t<td width='140'><a href='".$phpAds_shortcuts[$si]['link']."'>".$phpAds_shortcuts[$si]['name']."</a></td>\n";
                $sidebar .= "\t\t\t\t</tr>\n";
                $mozbar  .= "\t\t<link REL='bookmark' HREF='".$phpAds_shortcuts[$si]['link']."' TITLE='".$phpAds_shortcuts[$si]['name']."'>\n";
            }
            $sidebar .= "\t\t\t\t<tr>\n";
            $sidebar .= "\t\t\t\t\t<td colspan='2'><img src='images/break.gif' height='1' width='160' vspace='4'></td>\n";
            $sidebar .= "\t\t\t\t</tr>\n";
            $sidebar .= "\t\t\t\t</table>\n";
        }
        // Build Tabbar
        $currentsection = $sections[0];
        // Prepare Navigation
        if (phpAds_isUser(phpAds_Admin)) {
            $pages    = $phpAds_nav['admin'];
        } elseif (phpAds_isUser(phpAds_Agency)) {
            $pages  = $phpAds_nav['agency'];
        } elseif (phpAds_isUser(phpAds_Client)) {
            $pages  = $phpAds_nav['client'];
        } elseif (phpAds_isUser(phpAds_Affiliate)) {
            $pages  = $phpAds_nav['affiliate'];
        } else {
            $pages  = array();
        }
        $i = 0;
        $lastselected = false;
        foreach (array_keys($pages) as $key) {
            if (strpos($key, ".") == 0) {
                list($filename, $title) = each($pages[$key]);
                if ($i > 0) {
                    $tabtop .= "\t\t\t\t\t<td bgcolor='#$keyLineColor'><img src='images/spacer.gif' height='1'></td>\n";
                    $tabtop .= "\t\t\t\t\t<td width='2'><img src='images/spacer.gif' height='1' width='2'></td>\n";
                    $tabtop .= "\t\t\t\t\t<td bgcolor='#$keyLineColor'><img src='images/spacer.gif' height='1'></td>\n";
                    $tabbar .= "\t\t\t\t\t<td bgcolor='#$keyLineColor'><img src='images/spacer.gif' width='1'></td>\n";
                    $tabbar .= "\t\t\t\t\t<td width='2'><img src='images/spacer.gif' height='1' width='2'></td>\n";
                    $tabbar .= "\t\t\t\t\t<td bgcolor='#$keyLineColor'><img src='images/spacer.gif' width='1'></td>\n";
                    $tabbottom .= "\t\t\t\t\t<td colspan='3' bgcolor='#$headerForegroundColor'><img src='images/spacer.gif' height='1'></td>\n";
                } else {
                    $tabtop .= "\t\t\t\t\t<td width='1' bgcolor='#$keyLineColor'><img src='images/spacer.gif' height='1' width='1'></td>\n";
                    $tabbar .= "\t\t\t\t\t<td width='1' bgcolor='#$keyLineColor'><img src='images/spacer.gif' width='1'></td>\n";
                    $tabbottom .= "\t\t\t\t\t<td width='1' bgcolor='#$keyLineColor'><img src='images/spacer.gif' width='1'></td>\n";
                }
                if ($key == $currentsection) {
                    $tabtop .= "\t\t\t\t\t<td bgcolor='#$keyLineColor'><img src='images/spacer.gif' height='1'></td>\n";
                    $tabbar .= "\t\t\t\t\t<td bgcolor='#$headerActiveTabColor' valign='bottom' nowrap><img src='images/spacer.gif' width='7'><a class='tab-s' href='$filename' accesskey='".$keyHome."'>$title</a><img src='images/spacer.gif' width='7'></td>\n";
                    $tabbottom .= "\t\t\t\t\t<td bgcolor='#$headerActiveTabColor'><img src='images/spacer.gif' height='4'></td>\n";
                    $lastselected = true;
                } else {
                    $tabtop .= "\t\t\t\t\t<td bgcolor='#$keyLineColor'><img src='images/spacer.gif' height='1'></td>\n";
                    $tabbar .= "\t\t\t\t\t<td bgcolor='#$headerForegroundColor' valign='bottom' nowrap><img src='images/spacer.gif' width='7'><a class='tab-u' href='$filename'>$title</a><img src='images/spacer.gif' width='7'></td>\n";
                    $tabbottom .= "\t\t\t\t\t<td bgcolor='#$headerForegroundColor' width='1'><img src='images/spacer.gif' height='4' width='1'></td>\n";
                    $lastselected = false;
                }
            }
            $i++;
        }
        if ($lastselected) {
            $tabbar .= "\t\t\t\t\t<td bgcolor='#$headerActiveTabColor' align='right' valign='top'><img src='images/$phpAds_TextDirection/tab-toprightcorner-$headerBackgroundColor.gif' width='7' height='21'></td>\n";
            $tabbar .= "\t\t\t\t\t<td><table border='0' cellspacing='0' cellpadding='0'><tr height='7'><td width='1'><img src='images/spacer.gif' height='7' width='1'></td></tr><tr height='14'><td width='1' bgcolor='#$keyLineColor'><img src='images/spacer.gif' height='14' width='1'></td></tr></table></td>\n";
            $tabbottom .= "\t\t\t\t\t<td bgcolor='#$headerActiveTabColor'><img src='images/spacer.gif' height='4'></td>\n";
            $tabbottom .= "\t\t\t\t\t<td bgcolor='#$keyLineColor' width='1'><img src='images/spacer.gif' width='1'></td>\n";
        } else {
            $tabbar .= "\t\t\t\t\t<td bgcolor='#$headerForegroundColor' align='right' valign='top'><img src='images/$phpAds_TextDirection/tab-toprightcorner-$headerBackgroundColor.gif' width='7' height='21'></td>\n";
            $tabbar .= "\t\t\t\t\t<td><table border='0' cellspacing='0' cellpadding='0'><tr height='7'><td width='1'><img src='images/spacer.gif' height='7' width='1'></td></tr><tr height='14'><td width='1' bgcolor='#$keyLineColor'><img src='images/spacer.gif' height='14' width='1'></td></tr></table></td>\n";
            $tabbottom .= "\t\t\t\t\t<td bgcolor='#$headerForegroundColor'><img src='images/spacer.gif' height='4'></td>\n";
            $tabbottom .= "\t\t\t\t\t<td bgcolor='#$keyLineColor' width='1'><img src='images/spacer.gif' width='1'></td>\n";
        }
        if (phpAds_isLoggedIn() && ( phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency) ) && !defined('phpAds_installing')) {
            $searchbar  = "\t\t<table cellpadding='0' cellspacing='0' border='0' bgcolor='#$headerForegroundColor' height='24'>\n";
            $searchbar .= "\t\t<form name='search' action='admin-search.php' target='SearchWindow' onSubmit=\"search_window(document.search.keyword.value,'".MAX::constructURL(MAX_URL_ADMIN, 'admin-search.php')."'); return false;\">\n";
            $searchbar .= "\t\t<tr>\n";
            $searchbar .= "\t\t\t<td valign='bottom'><img src='images/$phpAds_TextDirection/tab-bottomleftcorner-$headerBackgroundColor.gif' height='21' width='7'></td>\n";
            $searchbar .= "\t\t\t<td class='tab-u'><img src='images/spacer.gif' width='4'>$strSearch:</td>\n";
            $searchbar .= "\t\t\t<td>&nbsp;&nbsp;<input type='text' name='keyword' size='15' class='search' accesskey='".$keySearch."'>&nbsp;&nbsp;</td>\n";
            $searchbar .= "\t\t\t<td><a href=\"javascript:search_window(document.search.keyword.value,'".MAX::constructURL(MAX_URL_ADMIN, 'admin-search.php')."');\"><img src='images/".$phpAds_TextDirection."/go.gif' border='0'></a></td>\n";
            $searchbar .= "\t\t\t<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>\n";
            $searchbar .= "\t\t</tr>\n";
            $searchbar .= "\t\t</form>\n";
            $searchbar .= "\t\t</table>\n";
        } else {
            $searchbar = "\t\t&nbsp;\n";
        }
    } else {
        $sidebar   = "\t\t\t\t&nbsp;\n";
        $searchbar = "\t\t&nbsp;\n";
        $pagetitle = isset($pref['name']) && $pref['name'] != '' ? $pref['name'] : MAX_PRODUCT_NAME;
        if ($ID == phpAds_Login) {
            $tabtop .= "\t\t\t\t\t<td width='1' bgcolor='#$keyLineColor'><img src='images/spacer.gif' height='1' width='1'></td>\n";
            $tabbar .= "\t\t\t\t\t<td width='1' bgcolor='#$keyLineColor'><img src='images/spacer.gif' width='1'></td>\n";
            $tabbottom .= "\t\t\t\t\t<td width='1' bgcolor='#$keyLineColor'><img src='images/spacer.gif' width='1'></td>\n";
            $tabtop .= "\t\t\t\t\t<td bgcolor='#$keyLineColor'><img src='images/spacer.gif' height='1'></td>\n";
            $tabbar    .= "\t\t\t\t\t<td bgcolor='#$headerActiveTabColor' valign='middle' nowrap>&nbsp;&nbsp;<a class='tab-s' href='index.php'>$strAuthentification</a></td>\n";
            $tabbottom .= "\t\t\t\t\t<td bgcolor='#$headerActiveTabColor'><img src='images/spacer.gif' height='4'></td>\n";
            $tabbar .= "\t\t\t\t\t<td bgcolor='#$headerActiveTabColor' align='right' valign='top'><img src='images/$phpAds_TextDirection/tab-toprightcorner-$headerBackgroundColor.gif' width='7' height='21'></td>\n";
            $tabbar .= "\t\t\t\t\t<td><table border='0' cellspacing='0' cellpadding='0'><tr height='7'><td width='1'><img src='images/spacer.gif' height='7' width='1'></td></tr><tr height='14'><td width='1' bgcolor='#$keyLineColor'><img src='images/spacer.gif' height='14' width='1'></td></tr></table></td>\n";
            $tabbottom .= "\t\t\t\t\t<td bgcolor='#$headerActiveTabColor'><img src='images/spacer.gif' height='4'></td>\n";
            $tabbottom .= "\t\t\t\t\t<td bgcolor='#$keyLineColor' width='1'><img src='images/spacer.gif' width='1'></td>\n";
        }
        if ($ID == phpAds_Error) {
            $tabtop .= "\t\t\t\t\t<td width='1' bgcolor='#$keyLineColor'><img src='images/spacer.gif' height='1' width='1'></td>\n";
            $tabbar .= "\t\t\t\t\t<td width='1' bgcolor='#$keyLineColor'><img src='images/spacer.gif' width='1'></td>\n";
            $tabbottom .= "\t\t\t\t\t<td width='1' bgcolor='#$keyLineColor'><img src='images/spacer.gif' width='1'></td>\n";
            $tabtop .= "\t\t\t\t\t<td bgcolor='#$keyLineColor'><img src='images/spacer.gif' height='1'></td>\n";
            $tabbar    .= "\t\t\t\t\t<td bgcolor='#$headerActiveTabColor' valign='middle' nowrap>&nbsp;&nbsp;<a class='tab-s' href='index.php'>Error</a></td>\n";
            $tabbottom .= "\t\t\t\t\t<td bgcolor='#$headerActiveTabColor'><img src='images/spacer.gif' height='4'></td>\n";
            $tabbar .= "\t\t\t\t\t<td bgcolor='#$headerActiveTabColor' align='right' valign='top'><img src='images/$phpAds_TextDirection/tab-toprightcorner-$headerBackgroundColor.gif' width='7' height='21'></td>\n";
            $tabbar .= "\t\t\t\t\t<td><table border='0' cellspacing='0' cellpadding='0'><tr height='7'><td width='1'><img src='images/spacer.gif' height='7' width='1'></td></tr><tr height='14'><td width='1' bgcolor='#$keyLineColor'><img src='images/spacer.gif' height='14' width='1'></td></tr></table></td>\n";
            $tabbottom .= "\t\t\t\t\t<td bgcolor='#$headerActiveTabColor'><img src='images/spacer.gif' height='4'></td>\n";
            $tabbottom .= "\t\t\t\t\t<td bgcolor='#$keyLineColor' width='1'><img src='images/spacer.gif' width='1'></td>\n";
        }
    }
    // Use gzip content compression
    if (isset($pref['content_gzip_compression']) && $pref['content_gzip_compression'] == 't') {
        ob_start("ob_gzhandler");
    }
    // Send header with charset info
    header ("Content-Type: text/html".(isset($phpAds_CharSet) && $phpAds_CharSet != "" ? "; charset=".$phpAds_CharSet : ""));
    // Head
    echo "<html".($phpAds_TextDirection != 'ltr' ? " dir='".$phpAds_TextDirection."'" : '').">\n";
    echo "\t<head>\n";
    echo "\t\t<title>".$pagetitle."</title>\n";
    echo "\t\t<meta name='generator' content='".MAX_PRODUCT_NAME." ".MAX_VERSION_READABLE." - http://max.m3.net'>\n";
    echo "\t\t<meta name='robots' content='noindex, nofollow'>\n\n";
    echo "\t\t<link rel='stylesheet' href='images/".$phpAds_TextDirection."/interface.css'>\n";
    echo "\t\t<link rel='stylesheet' type='text/css' media='all' href='js/jscalendar/calendar-openads.css' title='openads'>\n";
    echo "\t\t<script language='JavaScript' src='js-gui.js'></script>\n";
    echo "\t\t<script language='JavaScript' src='js/sorttable.js'></script>\n";
    echo "\t\t<script language='JavaScript' src='js/boxrow.js'></script>\n";
    echo "\t\t<script language='JavaScript' src='js/formValidation.php'></script>\n";

    echo "\t\t<script language='JavaScript' type='text/javascript' src='js/jscalendar/calendar.js'></script>\n";
    echo "\t\t<script language='JavaScript' type='text/javascript' src='js/jscalendar/lang/calendar-en.js'></script>\n";
    echo "\t\t<script language='JavaScript' type='text/javascript' src='js/jscalendar/calendar-setup.js'></script>\n";

    if ($phpAds_showHelp) echo "\t\t<script language='JavaScript' src='js-help.js'></script>\n";
    // Include the flashObject resource file
    echo MAX_flashGetFlashObjectExternal();

    // Show Moz site bar
    echo $mozbar;
    echo "\t</head>\n\n\n";
    echo "<body bgcolor='#FFFFFF' background='images/".$phpAds_TextDirection."/background.gif' text='#000000' leftmargin='0' ";
    echo "topmargin='0' marginwidth='0' marginheight='0' onLoad='initPage();'".($phpAds_showHelp ? " onResize='resizeHelp();' onScroll='resizeHelp();'" : '').">\n";
    // Header
    if (isset($pref['my_header']) && $pref['my_header'] != '') {
        include ($pref['my_header']);
    }
    // Branding and searchbar
    $displaySearch = ($ID != phpAds_Login && $ID != phpAds_Error && phpAds_isLoggedIn() && phpAds_isUser(phpAds_Admin|phpAds_Agency|phpAds_Affiliate) && !defined('phpAds_installing'));
    phpAds_writeHeader($displaySearch);
    // Spacer
    echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>\n";
    echo "<tr>\n";
    echo "\t<td colspan='2' height='6' bgcolor='#$headerBackgroundColor'><img src='images/spacer.gif' height='1' width='1'></td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    // Tabbar
    echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>\n";
    echo "<tr>\n";
    echo "\t<td height='24' width='181' bgcolor='#$headerBackgroundColor'>&nbsp;</td>\n";
    echo "\t<td height='24' bgcolor='#$headerBackgroundColor'>\n";
    echo "\t\t<table border='0' cellspacing='0' cellpadding='0' width='100%'>\n";
    echo "\t\t<tr>\n";
    echo "\t\t\t<td>\n";
    echo "\t\t\t\t<table border='0' cellspacing='0' cellpadding='0'>\n";
    echo "\t\t\t\t<tr height='1'>$tabtop</tr>\n";
    echo "\t\t\t\t<tr>\n";
    echo $tabbar;
    echo "\t\t\t\t</tr>\n";
    echo "\t\t\t\t<tr height='3'>$tabbottom</tr>\n";
    echo "\t\t\t\t</table>\n";
    echo "\t\t\t</td>\n";
    echo "\t\t\t<td align='".$phpAds_TextAlignRight."' valign='middle' nowrap>";
    // Show currently logged on user and IP
    if (phpAds_isLoggedIn()) {
        echo "<span style='color:#$headerTextColor'><b>" . $session['username'] . "</b>&nbsp;[" . $_SERVER['REMOTE_ADDR']. "]</span>&nbsp;&nbsp;&nbsp;\n";
    }
    if ($ID != "" && phpAds_isLoggedIn() && !defined('phpAds_installing')) {
        if ($helpLink = phpAds_getHelpFile()) {
            echo "\t\t\t\t<a style='color: #$headerTextColor' href='{$helpLink}' target='_blank'";
            echo "onClick=\"openWindow('{$helpLink}','',";
            echo "'status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=700,height=500'); return false;\"><b>$strHelp</b></a> \n";
            echo "\t\t\t\t<a href='{$helpLink}' target='_blank'";
            echo "onClick=\"openWindow('{$helpLink}','',";
            echo "'status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=700,height=500'); return false;\">";
            echo "<img src='images/help.gif' width='16' height='16' align='absmiddle' border='0'></a>";
            echo "&nbsp;&nbsp;&nbsp;\n";
        }
        echo "\t\t\t\t<a style='color: #$headerTextColor' href='logout.php'><b>$strLogout</b></a> \n";
        echo "\t\t\t\t<a href='logout.php'><img src='images/logout.gif' width='16' height='16' align='absmiddle' border='0'></a>";

        //  bug reporter button
        echo "&nbsp;&nbsp;&nbsp;<a href='bug.php'><img alt='Report a bug' src='images/bug.png' border='0'></a>";
    }
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
    echo "\t\t\t</td>\n";
    echo "\t\t</tr>\n";
    echo "\t\t</table>\n";
    echo "\t</td>\n";
    echo "</tr>\n";
    echo "</table>\n\n";
    // Sidebar
    echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>\n";
    echo "<tr>\n";
    echo "\t<td colspan='2' height='1' bgcolor='#$keyLineColor'><img src='images/spacer.gif' height='1'></td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "\t<td valign='top'>\n";
    echo "\t\t<table width='181' border='0' cellspacing='0' cellpadding='0'>\n";
    // Spacer
    echo "\t\t<tr>\n";
    echo "\t\t\t<td colspan='2' height='15'><img src='images/spacer.gif' height='1'></td>\n";
    echo "\t\t</tr>\n";
    // Navigation
    echo "\t\t<tr>\n";
    echo "\t\t\t<td width='20'>&nbsp;</td>\n";
    echo "\t\t\t<td class='nav'>\n";
    echo $sidebar;
    echo "\t\t\t</td>\n";
    echo "\t\t</tr>\n";
    echo "\t\t</table>\n";
    echo "\t</td>\n";
    // Main contents
    echo "\t<td valign='top' width='100%'>\n";
    echo "\t\t<table width='100%' border='0' cellspacing='0' cellpadding='0'>\n";
    echo "\t\t<tr>\n";
    echo "\t\t\t<td colspan='2' height='10'><img src='images/spacer.gif' height='1'></td>\n";
    echo "\t\t</tr>\n";
    echo "\t\t<tr>\n";
    echo "\t\t\t<td width='20'>&nbsp;</td>\n";
    echo "\t\t\t<td>\n";
}

/*-------------------------------------------------------*/
/* Show page footer                                      */
/*-------------------------------------------------------*/

function phpAds_PageFooter()
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $pref = $GLOBALS['_MAX']['PREF'];
    global $session, $phpAds_showHelp, $phpAds_helpDefault, $strMaintenanceNotActive;
    global $phpAds_TextDirection, $phpAds_TextAlignLeft, $phpAds_TextAlignRight;
    echo "\t\t\t</td>\n";
    echo "\t\t\t<td width='40'>&nbsp;</td>\n";
    echo "\t\t</tr>\n";
    // Spacer
    echo "\t\t<tr>\n";
    echo "\t\t\t<td width='40' height='20'>&nbsp;</td>\n";
    echo "\t\t\t<td height='20'>&nbsp;</td>\n";
    echo "\t\t</tr>\n";
    // Footer
    if (isset($pref['my_footer']) && $pref['my_footer'] != '') {
        echo "\t\t<tr>\n";
        echo "\t\t\t<td width='40' height='20'>&nbsp;</td>\n";
        echo "\t\t\t<td height='20'>";
        include ($pref['my_footer']);
        echo "</td>\n";
        echo "\t\t</tr>\n";
    }
    echo "\t\t</table>\n";
    echo "\t</td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    if ($phpAds_showHelp) {
        echo "<div id='helpLayer' name='helpLayer' style='position:absolute; left:".($phpAds_TextDirection != 'ltr' ? '0' : '181')."; top:-10; width:10px; height:10px; z-index:1; overflow: hidden; visibility: hidden;'>\n";
        echo "<img id='helpIcon' src='images/help-book.gif' align='absmiddle'>\n";
        echo "<span id='helpContents' name='helpContents'>".$phpAds_helpDefault."</span>\n";
        echo "</div>\n";
        echo "<br><br><br><br><br><br>\n";
    }
    echo "\n\n";
    if (!ereg("/(index|maintenance-updates|install|upgrade)\.php$", $_SERVER['PHP_SELF'])) {
        // Add Product Update redirector
        if (phpAds_isUser(phpAds_Admin) && function_exists('xml_parser_create') && !isset($session['update_check'])) {
            echo "<script language='JavaScript' src='maintenance-updates-js.php'></script>\n";
        }
        // Check if the maintenance script is running
        if (phpAds_isUser(phpAds_Admin)) {
            if ($pref['maintenance_timestamp'] < time() - (60 * 60 * 24)) {
                if ($pref['maintenance_timestamp'] > 0) {
                    // The maintenance script hasn't run in the
                    // last 24 hours, warn the user
                    echo "<script language='JavaScript'>\n";
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
    echo "</body>\n";
    echo "</html>\n";
    if (isset($pref['content_gzip_compression']) && $pref['content_gzip_compression'] == 't') {
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
function phpAds_ShowSections($sections, $params=false, $openNewTable=true)
{
    global $phpAds_nav, $phpAds_NavID;
    global $phpAds_TextDirection, $phpAds_TextAlignRight, $phpAds_TextAlignLeft;
    echo "\t\t\t</td>\n";
    echo "\t\t</tr>\n";
    echo "\t\t</table>\n";
    echo "\t\t<table border='0' cellpadding='0' cellspacing='0' width='100%' background='images/".$phpAds_TextDirection."/stab-bg.gif'>\n";
    echo "\t\t<tr height='24'>\n";
    echo "\t\t\t<td width='40'><img src='images/".$phpAds_TextDirection."/stab-bg.gif' width='40' height='24'></td>\n";
    echo "\t\t\t<td width='600' align='".$phpAds_TextAlignLeft."'>\n";
    echo "\t\t\t\t<table border='0' cellpadding='0' cellspacing='0'>\n";
    echo "\t\t\t\t<tr height='24'>\n";
    // Prepare Navigation
    if (phpAds_isUser(phpAds_Admin)) {
        $pages    = $phpAds_nav['admin'];
    } elseif (phpAds_isUser(phpAds_Agency)) {
        $pages  = $phpAds_nav['agency'];
    } elseif (phpAds_isUser(phpAds_Client)) {
        $pages  = $phpAds_nav['client'];
    } else {
        $pages  = $phpAds_nav['affiliate'];
    }
    echo "\t\t\t\t\t<td></td>\n";
    for ($i=0; $i < count($sections); $i++) {
        list($sectionUrl, $sectionStr) = each($pages["$sections[$i]"]);
        $selected = ($phpAds_NavID == $sections[$i]);
        if ($selected) {
            echo "\t\t\t\t\t<td background='images/".$phpAds_TextDirection."/stab-sb.gif' valign='middle' nowrap>";
            if ($i > 0) {
                echo "<img src='images/".$phpAds_TextDirection."/stab-mus.gif' align='absmiddle'>";
            } else {
                echo "<img src='images/".$phpAds_TextDirection."/stab-bs.gif' align='absmiddle'>";
            }
            echo "</td>\n";
            echo "\t\t\t\t\t<td background='images/".$phpAds_TextDirection."/stab-sb.gif' valign='middle' nowrap>";
            echo "&nbsp;&nbsp;<a class='tab-s' href='".$sectionUrl;
            if($params) {
                echo showParams($params);
            }
            echo "' accesskey='".($i+1)."'>".$sectionStr."</a></td>\n";
        } else {
            echo "\t\t\t\t\t<td background='images/".$phpAds_TextDirection."/stab-ub.gif' valign='middle' nowrap>";
            if ($i > 0) {
                if ($previousselected) {
                    echo "<img src='images/".$phpAds_TextDirection."/stab-msu.gif' align='absmiddle'>";
                } else {
                    echo "<img src='images/".$phpAds_TextDirection."/stab-muu.gif' align='absmiddle'>";
                }
            } else {
                echo "<img src='images/".$phpAds_TextDirection."/stab-bu.gif' align='absmiddle'>";
            }
            echo "</td>\n";
            echo "\t\t\t\t\t<td background='images/".$phpAds_TextDirection."/stab-ub.gif' valign='middle' nowrap>";
            echo "&nbsp;&nbsp;<a class='tab-g' href='".$sectionUrl;
            if($params) {
                echo showParams($params);
            }
            echo "' accesskey='".($i+1)."'>".$sectionStr."</a></td>\n";
        }
        $previousselected = $selected;
    }
    if ($previousselected) {
        echo "\t\t\t\t\t<td><img src='images/".$phpAds_TextDirection."/stab-es.gif'></td>\n";
    } else {
        echo "\t\t\t\t\t<td><img src='images/".$phpAds_TextDirection."/stab-eu.gif'></td>\n";
    }
    echo "\t\t\t\t</tr>\n";
    echo "\t\t\t\t</table>\n";
    echo "\t\t\t</td>\n";
    echo "\t\t\t<td>&nbsp;</td>\n";
    echo "\t\t</tr>\n";
    echo "\t\t</table>\n";
    if ($openNewTable==true) {
	    echo "\t\t<table width='100%' border='0' cellspacing='0' cellpadding='0'>\n";
	    echo "\t\t<tr>\n";
	    echo "\t\t\t<td width='40'>&nbsp;</td>\n";
	    echo "\t\t\t<td>\n";
	    echo "\t\t\t\t<br>\n";
    }
}

/*-------------------------------------------------------*/
/* Show a light gray line break                          */
/*-------------------------------------------------------*/

function phpAds_ShowBreak($print = true)
{
    $buffer =  "\t\t\t</td>\n";
    $buffer .= "\t\t\t<td width='40'>&nbsp;</td>\n";
    $buffer .= "\t\t</tr>\n";
    $buffer .= "\t\t</table>\n";
    $buffer .= "\t\t<img src='images/break-el.gif' height='1' width='100%' vspace='5'>\n";
    $buffer .= "\t\t<table width='100%' border='0' cellspacing='0' cellpadding='0'>\n";
    $buffer .= "\t\t<tr>\n";
    $buffer .= "\t\t\t<td width='40'>&nbsp;</td>\n";
    $buffer .= "\t\t\t<td>\n";

    if($print) {
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
    $error = phpAds_dbError();
    $corrupt = false;
    if (phpAds_dbmsname == 'MySQL') {
        $errornumber = phpAds_dbErrorNo();
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
        if (phpAds_isLoggedIn() && (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency))) {

            // Get the DB server version
            $connection = DBC::getCurrentConnection();
            $connectionId = $connection->getConnectionId();
            $aVersion = $connectionId->getServerVersion();
            $dbVersion = $aVersion['major'] . '.' . $aVersion['minor'] . '.' . $aVersion['patch'] . '-' . $aVersion['extra'];

            $message .= $GLOBALS['strErrorDBSubmitBug'];
            $last_query = $phpAds_last_query;
            $message .= "<br><br><table cellpadding='0' cellspacing='0' border='0'>";
            $message .= "<tr><td valign='top' nowrap><b>Version:</b>&nbsp;&nbsp;&nbsp;</td><td>".MAX_PRODUCT_NAME." ".MAX_VERSION_READABLE." (".MAX_VERSION.")</td></tr>";
            $message .= "<tr><td valien='top' nowrap><b>PHP/DB:</b></td><td>PHP ".phpversion()." / ".phpAds_dbmsname." " . $dbVersion . "</td></tr>";
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
    // Header
    if ($phpAds_GUIDone == false) {
        if (!isset($phpAds_TextDirection)) {
            $phpAds_TextDirection = 'ltr';
        }
        phpAds_PageHeader(phpAds_Error);
    }
    // Message
    echo "<br>";
    echo "<div class='errormessage'><img class='errormessage' src='images/errormessage.gif' align='absmiddle'>";
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
            $str = " onClick=\"return confirm('".$msg."')\"";
        } else {
            $str = "";
        }
    } else {
        $str = " onClick=\"return confirm('".$msg."')\"";
    }
    return $str;
}

/*-------------------------------------------------------*/
/* Load the function need for the help system            */
/*-------------------------------------------------------*/

function phpAds_PrepareHelp($default='')
{
    global $phpAds_showHelp, $phpAds_helpDefault;
    $phpAds_helpDefault = $default;
    $phpAds_showHelp = true;
}

?>

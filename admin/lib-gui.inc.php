<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Define defaults
$phpAds_Message     = '';
$phpAds_NavID	    = '';
$phpAds_GUIDone     = false;
$phpAds_showHelp    = false;
$phpAds_helpDefault = '';
$phpAds_context		= array();
$phpAds_shortcuts	= array();

define ("phpAds_Login", 0);
define ("phpAds_Error", -1);



/*********************************************************/
/* Add breadcrumb context to left menubar                */
/*********************************************************/

function phpAds_PageContext ($name, $link, $selected)
{
	global $phpAds_context;
	
	$phpAds_context[] = array (
		'name' => $name,
		'link' => $link,
		'selected' => $selected
	);
}



/*********************************************************/
/* Add shortcuts to left menubar                         */
/*********************************************************/

function phpAds_PageShortcut ($name, $link, $icon)
{
	global $phpAds_shortcuts;
	
	$phpAds_shortcuts[] = array (
		'name' => $name,
		'link' => $link,
		'icon' => $icon
	);
}



/*********************************************************/
/* Show page header                                      */
/*********************************************************/

function phpAds_PageHeader($ID, $extra="")
{
	global $phpAds_config;
	global $phpAds_version_readable, $phpAds_productname;
	global $phpAds_TextDirection, $phpAds_TextAlignRight, $phpAds_TextAlignLeft;
	
	global $phpAds_Message, $phpAds_GUIDone, $phpAds_NavID;
	global $phpAds_context, $phpAds_shortcuts;
	global $phpAds_nav, $pages, $phpAds_showHelp;
	
	global $phpAds_CharSet;
	global $strLogout, $strNavigation, $strShortcuts;
	global $strAuthentification, $strSearch, $strHelp;
	
	global $keyHome, $keyUp, $keyNextItem, $keyPreviousItem, $keySearch;
	
	
	$phpAds_GUIDone = true;
	$phpAds_NavID   = $ID;
	
	$mozbar = '';
	
	// Travel navigation
	if ($ID != phpAds_Login && $ID != phpAds_Error)
	{
		// Prepare Navigation
		if (phpAds_isUser(phpAds_Admin))
			$pages	= $phpAds_nav['admin'];
		elseif (phpAds_isUser(phpAds_Client))
			$pages  = $phpAds_nav['client'];
		else
			$pages  = $phpAds_nav['affiliate'];
		
		// Build sidebar
		$sections = explode(".", $ID);
		$sectionID = "";
		
		$sidebar  = "<table width='160' cellpadding='0' cellspacing='0' border='0'>";
		$sidebar .= "<tr><td colspan='2' class='nav'><b>$strNavigation</b></td></tr>";
		$sidebar .= "<tr><td colspan='2'><img src='images/break.gif' height='1' width='160' vspace='4'></td></tr>";
		
		for ($i=0; $i<count($sections)-1; $i++)
		{
			$sectionID .= $sections[$i];
			list($filename, $title) = each($pages["$sectionID"]);
			$sectionID .= ".";
			
			if ($i==0)
			{
				$sidebar .= "<tr><td width='20' valign='top'><img src='images/caret-t.gif' width='11' height='7'>&nbsp;</td>";
				$sidebar .= "<td width='140'><a href='$filename'>$title</a></td></tr>";
				$sidebar .= "<tr><td colspan='2'><img src='images/break.gif' height='1' width='160' vspace='4'></td></tr>";
				
				$mozbar  .= "\t\t<link REL='top' HREF='$filename' TITLE='$title'>\n";
			}
			else
			{
				$sidebar .= "<tr><td width='20' valign='top'><img src='images/caret-u.gif' width='11' height='7'>&nbsp;</td>";
				$sidebar .= "<td width='140'><a href='$filename'".($i == count($sections) - 2 ? " accesskey='".$keyUp."'" : "").">$title</a></td></tr>";
			}
			
			if ($i == count($sections) - 2)
				$mozbar  .= "\t\t<link REL='up' HREF='$filename' TITLE='$title'>\n";
		}
		
		if (isset($pages["$ID"]) && is_array($pages["$ID"]))
		{
			list($filename, $title) = each($pages["$ID"]);
			$sidebar .= "<tr><td width='20'valign='top'><img src='images/caret-u.gif' width='11' height='7'>&nbsp;</td>";
			$sidebar .= "<td width='140' class='nav'>$title</td></tr>";
			$sidebar .= "<tr><td colspan='2'><img src='images/break.gif' height='1' width='160' vspace='4'></td></tr>";
			
			$pagetitle  = isset($phpAds_config['name']) && $phpAds_config['name'] != '' ? $phpAds_config['name'] : $phpAds_productname;
			$pagetitle .= ' - '.$title;
		}
		else
		{
			$pagetitle = isset($phpAds_config['name']) && $phpAds_config['name'] != '' ? $phpAds_config['name'] : $phpAds_productname;
		}
		
		
		// Build Context
		if (count($phpAds_context))
		{
			$sidebar .= "<tr><td width='20'>&nbsp;</td><td width='140'>";
			$sidebar .= "<table width='140' cellpadding='0' cellspacing='0' border='0'>";
			
			$selectedcontext = '';
			
			for ($ci=0; $ci < count($phpAds_context); $ci++)
				if ($phpAds_context[$ci]['selected'])
					$selectedcontext = $ci;
			
			for ($ci=0; $ci < count($phpAds_context); $ci++)
			{
				$ac = '';
				if ($ci == $selectedcontext - 1) $ac = $keyPreviousItem;
				if ($ci == $selectedcontext + 1) $ac = $keyNextItem;
				
				if ($phpAds_context[$ci]['selected'])
					$sidebar .= "<tr><td width='20' valign='top'><img src='images/box-1.gif'>&nbsp;</td>";
				else
					$sidebar .= "<tr><td width='20' valign='top'><img src='images/box-0.gif'>&nbsp;</td>";
				
				$sidebar .= "<td width='120'><a href='".$phpAds_context[$ci]['link']."'".($ac != '' ? " accesskey='".$ac."'" : "").">";
				$sidebar .= $phpAds_context[$ci]['name']."</a></td></tr>";
			}
			
			$sidebar .= "</table></td></tr>";
			$sidebar .= "<tr><td colspan='2'><img src='images/break.gif' height='1' width='160' vspace='4'></td></tr>";
		}
		
		$sidebar .= "</table>";
		
		
		// Include custom HTML for the sidebar
		if ($extra != '') $sidebar .= $extra;
		
		
		// Include shortcuts
		if (count($phpAds_shortcuts))
		{
			$sidebar .= "<br><br><br>";
			$sidebar .= "<table width='160' cellpadding='0' cellspacing='0' border='0'>";
			$sidebar .= "<tr><td colspan='2' class='nav'><b>$strShortcuts</b></td></tr>";
			
			for ($si=0; $si<count($phpAds_shortcuts); $si++)
			{
				$sidebar .= "<tr><td colspan='2'><img src='images/break.gif' height='1' width='160' vspace='4'></td></tr>";
				$sidebar .= "<tr><td width='20' valign='top'><img src='".$phpAds_shortcuts[$si]['icon']."' align='absmiddle'>&nbsp;</td>";
				$sidebar .= "<td width='140'><a href='".$phpAds_shortcuts[$si]['link']."'>".$phpAds_shortcuts[$si]['name']."</a></td></tr>";
				
				$mozbar  .= "\t\t<link REL='bookmark' HREF='".$phpAds_shortcuts[$si]['link']."' TITLE='".$phpAds_shortcuts[$si]['name']."'>\n";
			}
			
			$sidebar .= "<tr><td colspan='2'><img src='images/break.gif' height='1' width='160' vspace='4'></td></tr>";
			$sidebar .= "</table>";
		}
		
		
		// Build Tabbar
		$currentsection = $sections[0];
		$tabbar = '';
		
		
		// Prepare Navigation
		if (phpAds_isUser(phpAds_Admin))
			$pages	= $phpAds_nav['admin'];
		elseif (phpAds_isUser(phpAds_Client))
			$pages  = $phpAds_nav['client'];
		elseif (phpAds_isUser(phpAds_Affiliate))
			$pages  = $phpAds_nav['affiliate'];
		else
			$pages  = array();
		
		
		$i = 0;
		$lastselected = false;
		
		for (reset($pages);$key=key($pages);next($pages))
		{
			if (strpos($key, ".") == 0)
			{
				list($filename, $title) = each($pages[$key]);
				
				
				if ($i > 0)
				{
					if ($lastselected)
						$tabbar .= "<td><img src='images/".$phpAds_TextDirection."/tab-d.gif' width='10' height='24'></td>";
					else
						$tabbar .= "<td><img src='images/".$phpAds_TextDirection."/tab-dd.gif' width='10' height='24'></td>";
				}
				
				if ($key == $currentsection)
				{
					$tabbar .= "<td bgcolor='#FFFFFF' valign='middle' nowrap>&nbsp;&nbsp;<a class='tab-s' href='$filename' accesskey='".$keyHome."'>$title</a></td>";
					$lastselected = true;
				}
				else
				{
					$tabbar .= "<td bgcolor='#0066CC' valign='middle' nowrap>&nbsp;&nbsp;<a class='tab-u' href='$filename'>$title</a></td>";
					$lastselected = false;
				}
			}
			
			$i++;
		}
		
		if ($lastselected)
			$tabbar .= "<td><img src='images/".$phpAds_TextDirection."/tab-ew.gif' width='10' height='24'></td>";
		else
			$tabbar .= "<td><img src='images/".$phpAds_TextDirection."/tab-eb.gif' width='10' height='24'></td>";
		
		
		
		if (phpAds_isLoggedIn() && phpAds_isUser(phpAds_Admin) && !defined('phpAds_installing'))
		{
			$searchbar  = "<table cellpadding='0' cellspacing='0' border='0' bgcolor='#0066CC' height='24'>";
			$searchbar .= "<form name='search' action='admin-search.php' target='SearchWindow' onSubmit=\"search_window(document.search.keyword.value,'".$phpAds_config['url_prefix']."/admin/admin-search.php'); return false;\">";
			$searchbar .= "<tr height='24'>";
			$searchbar .= "<td height='24'><img src='images/".$phpAds_TextDirection."/tab-sb.gif' height='24' width='10'></td>";
			$searchbar .= "<td class='tab-u'>".$strSearch.":</td>";
			$searchbar .= "<td>&nbsp;&nbsp;<input type='text' name='keyword' size='15' class='search' accesskey='".$keySearch."'>&nbsp;&nbsp;</td>";
			$searchbar .= "<td><a href=\"javascript:search_window(document.search.keyword.value,'".$phpAds_config['url_prefix']."/admin/admin-search.php');\"><img src='images/".$phpAds_TextDirection."/go.gif' border='0'></a></td>";
			$searchbar .= "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
			$searchbar .= "</tr>";
			$searchbar .= "</form>";
			$searchbar .= "</table>";
		}
		else
			$searchbar = "&nbsp;";
	}
	else
	{
		$sidebar   = "&nbsp;";
		$searchbar = "&nbsp;";
		$pagetitle = isset($phpAds_config['name']) && $phpAds_config['name'] != '' ? $phpAds_config['name'] : $phpAds_productname;
		
		if ($ID == phpAds_Login)
			$tabbar    = "<td bgcolor='#FFFFFF' valign='middle' nowrap>&nbsp;&nbsp;<a class='tab-s' href='index.php'>$strAuthentification</a></td>";
		
		if ($ID == phpAds_Error)
			$tabbar    = "<td bgcolor='#FFFFFF' valign='middle' nowrap>&nbsp;&nbsp;<a class='tab-s' href='index.php'>Error</a></td>";
		
		$tabbar   .= "<td><img src='images/".$phpAds_TextDirection."/tab-ew.gif' width='10' height='24'></td>";
	}
	
	
	
	// Use gzip content compression
	if (isset($phpAds_config['content_gzip_compression']) && $phpAds_config['content_gzip_compression'])
		ob_start("ob_gzhandler");
	
	// Send header with charset info
	header ("Content-Type: text/html".(isset($phpAds_CharSet) && $phpAds_CharSet != "" ? "; charset=".$phpAds_CharSet : ""));
	
	
	// Head
	echo "<html".($phpAds_TextDirection != 'ltr' ? " dir='".$phpAds_TextDirection."'" : '').">\n";
	echo "\t<head>\n";
	echo "\t\t<title>".$pagetitle."</title>\n";
	echo "\t\t<meta name='generator' content='".$phpAds_productname." ".$phpAds_version_readable." - http://www.phpadsnew.com'>\n";
	echo "\t\t<meta name='robots' content='noindex, nofollow'>\n\n";
	echo "\t\t<link rel='stylesheet' href='images/".$phpAds_TextDirection."/interface.css'>\n";
	echo "\t\t<script language='JavaScript' src='js-gui.js'></script>\n";
	if (isset($phpAds_config['language'])) echo "\t\t<script language='JavaScript' src='js-form.php?language=".$phpAds_config['language']."'></script>\n";
	if ($phpAds_showHelp) echo "\t\t<script language='JavaScript' src='js-help.js'></script>\n";
	
	// Show Moz site bar
	echo $mozbar;
	echo "\t</head>\n\n\n";
	
	echo "<body bgcolor='#FFFFFF' background='images/".$phpAds_TextDirection."/background.gif' text='#000000' leftmargin='0' ";
	echo "topmargin='0' marginwidth='0' marginheight='0' onLoad='initAccessKey();'".($phpAds_showHelp ? " onResize='resizeHelp();' onScroll='resizeHelp();'" : '').">";
	
	// Header
	if (isset($phpAds_config['my_header']) && $phpAds_config['my_header'] != '')
	{
		include ($phpAds_config['my_header']);
	}
	
	
	// Branding
 	echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
	echo "<tr>";
	
	if (isset($phpAds_config['name']) && $phpAds_config['name'] != '')
	{
		echo "<td height='48' bgcolor='#000063' valign='middle'>";
		echo "&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/logo-s.gif' width='36' height='34' align='absmiddle'>";
		echo "<span class='phpAdsNew'>".$phpAds_config['name']."</span>";
	}
	else
	{
		echo "<td height='48' bgcolor='#000063' valign='bottom'>";
		echo "&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/logo.gif' width='163' height='34'>";
	}
	
	echo "</td><td bgcolor='#000063' valign='top' align='".$phpAds_TextAlignRight."'>";
	echo $searchbar;
	echo "</td></tr></table>";
	
	
	// Spacer
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
	echo "<tr><td colspan='2' height='6' bgcolor='#000063'><img src='images/spacer.gif' height='1' width='1'></td></tr>";
	echo "</table>";
	
	
	// Tabbar
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
	echo "<tr><td height='24' width='181' bgcolor='#000063'>&nbsp;</td>";
	echo "<td height='24' bgcolor='#000063'>";
	echo "<table border='0' cellspacing='0' cellpadding='0' width='100%'>";
	echo "<tr><td>";
	echo "<table border='0' cellspacing='0' cellpadding='0' width='1'>";
	echo "<tr>".$tabbar."</tr>";
	echo "</table>";
	echo "</td><td align='".$phpAds_TextAlignRight."' valign='middle' nowrap>";
	
	if ($ID != "" && phpAds_isLoggedIn() && !defined('phpAds_installing'))
	{
		if (phpAds_isUser(phpAds_Admin))
		{
			echo "<a class='tab-n' href='../misc/documentation/user-guide.pdf' target='_blank'";
			echo "onClick=\"openWindow('../misc/documentation/user-guide.pdf','',";
			echo "'status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=700,height=500'); return false;\">$strHelp</a> ";
			echo "<a href='../misc/documentation/user-guide.pdf' target='_blank'";
			echo "onClick=\"openWindow('../misc/documentation/user-guide.pdf','',";
			echo "'status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=700,height=500'); return false;\">";
			echo "<img src='images/help.gif' width='16' height='16' align='absmiddle' border='0'></a>";
			echo "&nbsp;&nbsp;&nbsp;";
		}
		
		echo "<a class='tab-n' href='logout.php'>$strLogout</a> ";
		echo "<a href='logout.php'><img src='images/logout.gif' width='16' height='16' align='absmiddle' border='0'></a>";
	}
	
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "</td></tr></table>";
	echo "</td></tr></table>";
	
	
	// Sidebar
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
	echo "<tr><td valign='top'>";
	echo "<table width='181' border='0' cellspacing='0' cellpadding='0'>";
	
	
	// Blue square
    echo "<tr valign='top'><td colspan='2' width='20' height='48' bgcolor='#000063' valign='bottom'>";
	echo "&nbsp;</td></tr>";
	
	
	// Gradient
    echo "<tr valign='top'><td width='20' height='24'><img src='images/grad-1.gif' width='20' height='20'></td>";
	echo "<td height='24'><img src='images/grad-1.gif' width='160' height='20'></td></tr>";
	
	
	// Navigation
	echo "<tr><td width='20'>&nbsp;</td>";
    echo "<td class='nav'>".$sidebar."</td></tr>";
    echo "</table></td>";
	
	
	// Main contents
	echo "<td valign='top' width='100%'>";
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
    echo "<tr><td width='40' height='20'>&nbsp;</td><td height='20'>&nbsp;</td></tr>";
    echo "<tr><td width='20'>&nbsp;</td><td>";
}



/*********************************************************/
/* Show page footer                                      */
/*********************************************************/

function phpAds_PageFooter()
{
	global $phpAds_config, $HTTP_SERVER_VARS;
	global $Session, $phpAds_showHelp, $phpAds_helpDefault, $strMaintenanceNotActive;
	global $phpAds_TextDirection, $phpAds_TextAlignLeft, $phpAds_TextAlignRight;
	
	echo "</td><td width='40'>&nbsp;</td></tr>";
	
	// Spacer
	echo "<tr><td width='40' height='20'>&nbsp;</td>";
	echo "<td height='20'>&nbsp;</td></tr>";
	
	// Footer
	if (isset($phpAds_config['my_footer']) && $phpAds_config['my_footer'] != '')
	{
		echo "<tr><td width='40' height='20'>&nbsp;</td>";
		echo "<td height='20'>";
		include ($phpAds_config['my_footer']);
		echo "</td></tr>";
	}
	
	echo "</table>";
	echo "</td></tr>";
	echo "</table>";
	
	if ($phpAds_showHelp) 
	{
		echo "<div id='helpLayer' name='helpLayer' style='position:absolute; left:".($phpAds_TextDirection != 'ltr' ? '0' : '181')."; top:-10; width:10px; height:10px; z-index:1; overflow: hidden; visibility: hidden;'>";
		echo "<img id='helpIcon' src='images/help-book.gif' align='absmiddle'>";
		echo "<span id='helpContents' name='helpContents'>".$phpAds_helpDefault."</span></div>";
		echo "<br><br><br><br><br><br>";
	}
	
	echo "\n\n";
	
	
	if (!ereg("/(index|maintenance-updates|install|upgrade)\.php$", $HTTP_SERVER_VARS['PHP_SELF']))
	{
		// Add Product Update redirector
		if (phpAds_isUser(phpAds_Admin) &&
			function_exists('xml_parser_create') &&
			!isset($Session['update_check']))
		{
			echo "\t<script language='JavaScript' src='maintenance-updates-js.php'></script>\n";
		}
		
		// Check if the maintenance script is running
		if (phpAds_isUser(phpAds_Admin))
		{
			if ($phpAds_config['maintenance_timestamp'] < time() - (60 * 60 * 24))
			{
				if ($phpAds_config['maintenance_timestamp'] > 0)
				{
					// The maintenance script hasn't run in the 
					// last 24 hours, warn the user
					echo "<script language='JavaScript'>\n";
					echo "<!--//\n";
					echo "\talert('".$strMaintenanceNotActive."');\n";
					echo "//-->\n";
					echo "</script>";
				}
				
				// Update the timestamp to make sure the warning 
				// is shown only once every 24 hours
				$res = phpAds_dbQuery ("
					UPDATE
						".$phpAds_config['tbl_config']."
					SET
						maintenance_timestamp = '".time()."'
				");
			}
		}
	}
	
	echo "\n</body></html>";
}



/*********************************************************/
/* Show section navigation                               */
/*********************************************************/

function phpAds_ShowSections($sections)
{
	global $phpAds_nav, $phpAds_NavID;
	global $phpAds_TextDirection, $phpAds_TextAlignRight, $phpAds_TextAlignLeft;
	
	echo "</td></tr>";
	echo "</table>";
	
	
	echo "<table border='0' cellpadding='0' cellspacing='0' width='100%' background='images/".$phpAds_TextDirection."/stab-bg.gif'><tr height='24'>";
	echo "<td width='40'><img src='images/".$phpAds_TextDirection."/stab-bg.gif' width='40' height='24'></td><td width='600' align='".$phpAds_TextAlignLeft."'>";
	
	echo "<table border='0' cellpadding='0' cellspacing='0'><tr height='24'>";
	
	// Prepare Navigation
	if (phpAds_isUser(phpAds_Admin))
		$pages	= $phpAds_nav['admin'];
	elseif (phpAds_isUser(phpAds_Client))
		$pages  = $phpAds_nav['client'];
	else
		$pages  = $phpAds_nav['affiliate'];
	
	echo "<td></td>";
	
	for ($i=0; $i<count($sections);$i++)
	{
		list($sectionUrl, $sectionStr) = each($pages["$sections[$i]"]);
		$selected = ($phpAds_NavID == $sections[$i]);
		
		if ($selected)
		{
			echo "<td background='images/".$phpAds_TextDirection."/stab-sb.gif' valign='middle' nowrap>";
			
			if ($i > 0) 
				echo "<img src='images/".$phpAds_TextDirection."/stab-mus.gif' align='absmiddle'></td>";
			else
				echo "<img src='images/".$phpAds_TextDirection."/stab-bs.gif' align='absmiddle'></td>";
			
			echo "<td background='images/".$phpAds_TextDirection."/stab-sb.gif' valign='middle' nowrap>";
			echo "&nbsp;&nbsp;<a class='tab-s' href='".$sectionUrl."' accesskey='".($i+1)."'>".$sectionStr."</a></td>";
		}
		else
		{
			echo "<td background='images/".$phpAds_TextDirection."/stab-ub.gif' valign='middle' nowrap>";
			
			if ($i > 0) 
				if ($previousselected) 
					echo "<img src='images/".$phpAds_TextDirection."/stab-msu.gif' align='absmiddle'></td>";
				else
					echo "<img src='images/".$phpAds_TextDirection."/stab-muu.gif' align='absmiddle'></td>";
			else
				echo "<img src='images/".$phpAds_TextDirection."/stab-bu.gif' align='absmiddle'></td>";
			
			echo "<td background='images/".$phpAds_TextDirection."/stab-ub.gif' valign='middle' nowrap>";
			echo "&nbsp;&nbsp;<a class='tab-g' href='".$sectionUrl."' accesskey='".($i+1)."'>".$sectionStr."</a></td>";
		}
		
		$previousselected = $selected;
	}
	
	if ($previousselected)
		echo "<td><img src='images/".$phpAds_TextDirection."/stab-es.gif'></td>";
	else
		echo "<td><img src='images/".$phpAds_TextDirection."/stab-eu.gif'></td>";
	
	echo "</tr></table>";
	
	echo "</td><td>&nbsp;</td></tr></table>";
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
	echo "<tr><td width='40'>&nbsp;</td><td><br>";
}



/*********************************************************/
/* Show a light gray line break                          */
/*********************************************************/

function phpAds_ShowBreak()
{
	echo "</td><td width='40'>&nbsp;</td></tr>";
	echo "</table>";
	echo "<img src='images/break-el.gif' height='1' width='100%' vspace='5'>";
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
	echo "<tr><td width='40'>&nbsp;</td><td>";
}



/*********************************************************/
/* Show a the last SQL error and die                     */
/*********************************************************/

function phpAds_sqlDie()
{
	global $phpAds_dbmsname, $phpAds_version_readable, $phpAds_version, $phpAds_productname;
    global $phpAds_last_query, $HTTP_SERVER_VARS;
	
	
	$error = phpAds_dbError();
	$corrupt = false;
	
	if ($phpAds_dbmsname == 'MySQL')
	{
		$errornumber = phpAds_dbErrorNo();
		
		if ($errornumber == 1027 || $errornumber == 1039)
			$corrupt = true;
		
		if ($errornumber == 1016 || $errornumber == 1030)
		{
			// Probably corrupted table, do additional check
			eregi ("[0-9]+", $error, $matches);
			
			if ($matches[0] == 126 || $matches[0] == 127 ||
				$matches[0] == 132 || $matches[0] == 134 ||
				$matches[0] == 135 || $matches[0] == 136 ||
				$matches[0] == 141 || $matches[0] == 144 ||
				$matches[0] == 145)
			{
				$corrupt = true;
			}
		}
	}
	
	if ($corrupt)
	{
		$title    = $GLOBALS['strErrorDBSerious'];
		$message  = $GLOBALS['strErrorDBNoDataSerious'];
		
		if (phpAds_isLoggedIn() && phpAds_isUser(phpAds_Admin))
			$message .= " (".$error.").<br><br>".$GLOBALS['strErrorDBCorrupt'];
		else
			$message .= ".<br>".$GLOBALS['strErrorDBContact'];
	}
	else
	{
		$title    = $GLOBALS['strErrorDBPlain'];
		$message  = $GLOBALS['strErrorDBNoDataPlain'];
		
		if (phpAds_isLoggedIn() && phpAds_isUser(phpAds_Admin))
		{
			$message .= $GLOBALS['strErrorDBSubmitBug'];
			
			$last_query = $phpAds_last_query;
			
			$message .= "<br><br><table cellpadding='0' cellspacing='0' border='0'>";
			$message .= "<tr><td valign='top' nowrap><b>Version:</b>&nbsp;&nbsp;&nbsp;</td><td>".$phpAds_productname." ".$phpAds_version_readable." (".$phpAds_version.")</td></tr>";
			$message .= "<tr><td>&nbsp;</td><td>PHP ".phpversion()." / ".$phpAds_dbmsname." ".phpAds_dbResult(phpAds_dbQuery('SELECT VERSION()'), 0, 0)."</td></tr>";
			$message .= "<tr><td valign='top' nowrap><b>Page:</b></td><td>".$HTTP_SERVER_VARS['PHP_SELF']."</td></tr>";
			$message .= "<tr><td valign='top' nowrap><b>Error:</b></td><td>".$error."</td></tr>";
			$message .= "<tr><td valign='top' nowrap><b>Query:</b></td><td>".$last_query."</td></tr>";
			$message .= "</table>";
		}
	}
	
	phpAds_Die ($title, $message);
}



/*********************************************************/
/* Display a custom error message and die                */
/*********************************************************/

function phpAds_Die($title="Error", $message="Unknown error")
{
	global $phpAds_GUIDone, $phpAds_TextDirection, $phpAds_config;
	
	// Header
	if ($phpAds_GUIDone == false)
	{
		if (!isset($phpAds_TextDirection)) 
			$phpAds_TextDirection = 'ltr';
		
		phpAds_PageHeader(phpAds_Error);
	}
	
	// Message
	echo "<br>";
	echo "<div class='errormessage'><img class='errormessage' src='images/errormessage.gif' align='absmiddle'>";
	echo "<span class='tab-r'>".$title."</span><br><br>".$message."</div><br><br>";
	
	// Die
	phpAds_PageFooter();
	exit;
}



/*********************************************************/
/* Show a confirm message for delete / reset actions	 */
/*********************************************************/

function phpAds_DelConfirm($msg)
{
	global $phpAds_config;
	
	if (phpAds_isUser(phpAds_Admin))
	{
		if ($phpAds_config['admin_novice'])
			$str = " onClick=\"return confirm('".$msg."')\"";
		else
			$str = "";
	}
	else
		$str = " onClick=\"return confirm('".$msg."')\"";
	
	return $str;
}



/*********************************************************/
/* Load the function need for the help system            */
/*********************************************************/

function phpAds_PrepareHelp($default='')
{
	global $phpAds_showHelp, $phpAds_helpDefault;
	
	$phpAds_helpDefault = $default;
	$phpAds_showHelp = true;
}

?>
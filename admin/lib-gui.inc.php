<?php // $Revision$
/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
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


/*********************************************************/
/* Show page header                                      */
/*********************************************************/

function phpAds_PageHeader($ID, $extra="")
{
	global $phpAds_config;
	global $phpAds_Message, $phpAds_GUIDone, $phpAds_NavID;
	global $phpAds_nav, $pages;
	global $phpAds_CharSet;
	global $strLogout, $strNavigation;
	global $strAuthentification, $strSearch;
	global $phpAds_showHelp;
	
	$phpAds_GUIDone = true;
	$phpAds_NavID   = $ID;
	
	// Travel navigation
	if ($ID != "")
	{	
		// Prepare Navigation
		if (phpAds_isUser(phpAds_Admin))
			$pages	= $phpAds_nav['admin'];
		else
			$pages  = $phpAds_nav['client'];
		
		// Build sidebar
		$sections = explode(".", $ID);
		$sectionID = "";
		
		$sidebar  = "<b>$strNavigation</b><br>";
		$sidebar .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		
		for ($i=0; $i<count($sections)-1; $i++)
		{
			$sectionID .= $sections[$i];
			list($filename, $title) = each($pages["$sectionID"]);
			$sectionID .= ".";
			
			if ($i==0)
			{
				$sidebar .= "<img src='images/caret-t.gif' width='11' height='7'>&nbsp;";
				$sidebar .= "<a href='$filename'>$title</a>";
				$sidebar .= "<br>"; 
				$sidebar .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
			}
			else
			{
				$sidebar .= "<img src='images/caret-u.gif' width='11' height='7'>&nbsp;";
				$sidebar .= "<a href='$filename'>$title</a>";
				$sidebar .= "<br>"; 
			}
		}
		
		if (isset($pages["$ID"]) && is_array($pages["$ID"]))
		{
			list($filename, $title) = each($pages["$ID"]);
			$sidebar .= "<img src='images/caret-u.gif' width='11' height='7'>&nbsp;";
			$sidebar .= "$title<br>";
			$sidebar .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
			$pagetitle = $title;
		}
		else
		{
			$pagetitle = $phpAds_config['name'] != '' ? $phpAds_config['name'] : 'phpAdsNew';
		}
		
		if ($extra != '') $sidebar .= $extra;
		
		
		// Build Tabbar
		$currentsection = $sections[0];
		$tabbar = '';
		
		// Prepare Navigation
		if (phpAds_isUser(phpAds_Admin))
			$pages	= $phpAds_nav['admin'];
		else
			$pages  = $phpAds_nav['client'];
		
		
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
						$tabbar .= "<td><img src='images/tab-d.gif' width='10' height='24'></td>";
					else
						$tabbar .= "<td><img src='images/tab-dd.gif' width='10' height='24'></td>";
				}
				
				if ($key == $currentsection)
				{
					$tabbar .= "<td bgcolor='#FFFFFF' valign='middle' nowrap>&nbsp;&nbsp;<a class='tab-s' href='$filename'>$title</a></td>";
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
			$tabbar .= "<td><img src='images/tab-ew.gif' width='10' height='24'></td>";
		else
			$tabbar .= "<td><img src='images/tab-eb.gif' width='10' height='24'></td>";
		
		
		
		if (phpAds_isLoggedIn() && phpAds_isUser(phpAds_Admin) && !defined('phpAds_installing'))
		{
			$searchbar  = "<table cellpadding='0' cellspacing='0' border='0' bgcolor='#0066CC' height='24'>";
			$searchbar .= "<form name='search' action='admin-search.php' target='SearchWindow' onSubmit=\"search_window(document.search.keyword.value,'".$phpAds_config['url_prefix']."/admin/admin-search.php'); return false;\">";
			$searchbar .= "<tr height='24'>";
			$searchbar .= "<td height='24'><img src='images/tab-sb.gif' height='24' width='10'></td>";
			$searchbar .= "<td class='tab-u'>$strSearch:</td>";
			$searchbar .= "<td>&nbsp;&nbsp;<input type='text' name='keyword' size='15'>&nbsp;&nbsp;</td>";
			$searchbar .= "<td><a href=\"javascript:search_window(document.search.keyword.value,'".$phpAds_config['url_prefix']."/admin/admin-search.php');\"><img src='images/go.gif' border='0'></a></td>";
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
		$tabbar    = "<td bgcolor='#FFFFFF' valign='middle' nowrap>&nbsp;&nbsp;<a class='tab-s' href='index.php'>$strAuthentification</a></td>";
		$tabbar   .= "<td><img src='images/tab-ew.gif' width='10' height='24'></td>";
		$pagetitle = $phpAds_config['name'] != '' ? $phpAds_config['name'] : 'phpAdsNew';
	}
	
	
	
	// Send header with charset info
	header ("Content-Type: text/html".(isset($phpAds_CharSet) && $phpAds_CharSet != "" ? "; charset=".$phpAds_CharSet : ""));
	
	
	// Head
	echo "<html>\n";
	echo "\t<head>\n";
	echo "\t\t<title>".$pagetitle."</title>\n";
	echo "\t\t<meta http-equiv='Content-Type' content='text/html".($phpAds_CharSet != '' ? '; charset='.$phpAds_CharSet : '')."'>\n";
	echo "\t\t<meta name='author' content='phpAdsNew - http://sourceforge.net/projects/phpadsnew'>\n";
	echo "\t\t<meta name='robots' content='noindex, nofollow'>\n";
	echo "\t\t<link rel='stylesheet' href='interface.css'>\n";
	echo "\t\t<script language='JavaScript' src='interface.js'></script>\n";
	if ($phpAds_showHelp) echo "\t\t<script language='JavaScript' src='help.js'></script>\n";
	echo "\t</head>\n";
	
	
	// Header
	echo "<body bgcolor='#FFFFFF' background='images/background.gif' text='#000000' leftmargin='0' ";
	echo "topmargin='0' marginwidth='0' marginheight='0'".($phpAds_showHelp ? " onResize='resizeHelp();' onScroll='resizeHelp();'" : '').">\n";
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
	echo "<tr>";
	
 	if ($phpAds_config['name'] != "")
	{
		echo "<td height='48' bgcolor='#000063' valign='middle'>";
		echo "<span class='phpAdsNew'>&nbsp;&nbsp;&nbsp;".$phpAds_config['name']."&nbsp;&nbsp;&nbsp;</span>";
	}
	else
	{
		echo "<td height='48' bgcolor='#000063' valign='bottom'>";
		echo "&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/logo.gif' width='163' height='34' alt='phpAdsNew 2 beta 6.1'>";
	}
	
	echo "</td><td bgcolor='#000063' valign='top' align='right'>";
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
	echo "</td><td align='right' valign='middle' nowrap>";
	
	if ($ID != "" && phpAds_isLoggedIn() && !defined('phpAds_installing'))
	{
		echo "<a class='tab-n' href='logout.php'>$strLogout</a> ";
		echo "<img src='images/logout.gif' width='16' height='16' align='absmiddle'>";
	}
	
	echo "&nbsp;&nbsp;&nbsp;";
	echo "</td></tr></table>";
	echo "</td></tr></table>";
	
	
	// Sidebar
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
	echo "<tr><td valign='top'>";
	echo "<table width='181' border='0' cellspacing='0' cellpadding='0'>";
	
	
	// Blue square
    echo "<tr valign='top'><td colspan='2' width='20' height='48' bgcolor='#000063' valign='bottom'>";
	if ($phpAds_Message != '')
	{
		echo "<table border='0' cellpadding='0' cellspacing='0' width='160'>";
		echo "<tr>";
		echo "<td width='20'>&nbsp;</td>";
		echo "<td width='20' valign='top'><img src='images/info.gif'>&nbsp;</td>";
		echo "<td width='120' valign='top'><b><font color='#FFFFFF'>$phpAds_Message</font></b></td>";
		echo "</tr><tr><td colspan='3'><img src='images/spacer.gif' width='160' height='5'></td>";
		echo "</tr></table>";
	}
	else
		echo "&nbsp;";
	echo "</td></tr>";
	
	
	// Gradient
    echo "<tr valign='top'><td width='20' height='24'><img src='images/grad-1.gif' width='20' height='20'></td>";
	echo "<td height='24'><img src='images/grad-1.gif' width='160' height='20'></td></tr>";
	
	
	// Navigation
	echo "<tr><td width='20'>&nbsp;</td>";
    echo "<td class='nav'>".$sidebar."</td></tr>";
    echo "</table></td>";
	
	
	// Main contents
	echo "<td valign='top' width='100%'>";
	echo "<table width='640' border='0' cellspacing='0' cellpadding='0'>";
    echo "<tr><td width='40' height='20'>&nbsp;</td><td height='20'>&nbsp;</td></tr>";
    echo "<tr><td width='20'>&nbsp;</td><td>";
}



/*********************************************************/
/* Show page footer                                      */
/*********************************************************/

function phpAds_PageFooter()
{
	global $phpAds_config;
	global $phpAds_showHelp, $phpAds_helpDefault;
	
	echo "</td></tr>";
	
	// Spacer
	echo "<tr><td width='40' height='20'>&nbsp;</td>";
	echo "<td height='20'>&nbsp;</td></tr>";
	echo "</table>";
	echo "</td></tr>";
	echo "</table>";
	
	
	if ($phpAds_showHelp) 
	{
?>

<div id="helpLayer" name="helpLayer" style="position:absolute; left:-40; top:-40; width:10px; height:10px; z-index:1; background-color: #F6F6F6; layer-background-color: #F6F6F6; border: 1px none #000000; overflow: hidden; visibility: visible; background-image: url(images/help-background.gif); layer-background-image: url(images/help-background.gif);">
<table width='100%' cellpadding='0' cellspacing='0' border='0'>
	<tr>
		<td width='40' align='left' valign='top'><img src="images/help-icon.gif" width="40" height="40" border="0" vspace="0" hspace="0"></td>
		<td width='100%' align='left' valign='top' style="font-family: Verdana; font-size: 11px;">
			<br>
			<div id="helpContents" name="helpContents">
				<?php echo $phpAds_helpDefault; ?>
			</div>
		</td>
		<td width='16' align='right' valign='top'><img src="images/help-close.gif" width="16" height="16" border="0" vspace="4" hspace="4" onClick="hideHelp();"></td>
	</tr>
</table> 
</div>
<br><br>
<br><br>
<br><br>
<?php 
	}
	
	if (!empty($phpAds_config['my_footer']))
	{
		include ($phpAds_config['my_footer']);
	}
	
	echo "</body>";
	echo "</html>";
}



/*********************************************************/
/* Show a messagebox                                     */
/*********************************************************/

function phpAds_ShowMessage($message)
{
	global $phpAds_Message;
	
	$phpAds_Message = $message;
}



/*********************************************************/
/* Show a the last SQL error and die                     */
/*********************************************************/

function phpAds_sqlDie()
{
	global $strMySQLError;
    global $phpAds_last_query;
	global $phpAds_GUIDone;
	
	if ($phpAds_GUIDone == false) phpAds_PageHeader(-1);
	
	echo "<br><br>";
	echo "<table border='0' cellpadding='1' cellspacing='1' width='100%'><tr><td bgcolor='#FF0000'>";
		echo "<table border='0' cellpadding='5' cellspacing='0' width='100%'>";
		echo "<tr bgcolor='#EEEEEE'>";
		echo "<td width='20' valign='top'><img src='images/error.gif' hspace='3'></td>";
		echo "<td valign='top'>";
		echo "<b>$strMySQLError</b><br>";
		echo phpAds_dbError()."<br><br>";
		echo "<b>SQL Query:</b><br>";
		echo "$phpAds_last_query<br>";
		echo "</td>";
		echo "</tr></table>";
	echo "</td></tr></table>";
	echo "<br><br>";
	
	// die
	phpAds_PageFooter();
	exit;
}



/*********************************************************/
/* Display a custom error message and die                */
/*********************************************************/

function phpAds_Die($title="Error", $message="Unkown error")
{
	global $phpAds_GUIDone;
	
	if ($phpAds_GUIDone == false) phpAds_PageHeader(-1);
	
	echo "<br><br>";
	echo "<table border='0' cellpadding='1' cellspacing='1' width='100%'><tr><td bgcolor='#FF0000'>";
		echo "<table border='0' cellpadding='5' cellspacing='0' width='100%'>";
		echo "<tr bgcolor='#EEEEEE'>";
		echo "<td width='20' valign='top'><img src='images/error.gif' hspace='3'></td>";
		echo "<td valign='top'>";
		echo "<b>$title</b><br>";
		echo "$message<br>";
		echo "</td>";
		echo "</tr></table>";
	echo "</td></tr></table>";
	echo "<br><br>";
	
	// die
	phpAds_PageFooter();
	exit;
}



/*********************************************************/
/* Show a confirm message for delete / reset actions	 */
/*********************************************************/

function phpAds_DelConfirm($msg)
{
	global $phpAds_config;
	
	if ($phpAds_config['admin_novice'])
		$str = " onClick=\"return confirm('" . $msg . "')\"";
	else
		$str = "";
	
	return $str;
}



/*********************************************************/
/* Show section navigation                               */
/*********************************************************/

function phpAds_ShowSections($sections)
{
	global $phpAds_nav, $phpAds_NavID;
	
	// Prepare Navigation
	if (phpAds_isUser(phpAds_Admin))
		$pages	= $phpAds_nav['admin'];
	else
		$pages  = $phpAds_nav['client'];
	
	for ($i=0; $i<count($sections);$i++)
	{
		list($sectionUrl, $sectionStr) = each($pages["$sections[$i]"]);
		echo "<img src='images/caret-rs.gif' width='11' height='7'>&nbsp;";
		
		if ($phpAds_NavID == $sections[$i])
			echo "<a class='tab-s' href='".$sectionUrl."'>".$sectionStr."</a> &nbsp;&nbsp;&nbsp;";
		else
			echo "<a class='tab-g' href='".$sectionUrl."'>".$sectionStr."</a> &nbsp;&nbsp;&nbsp;";
	}
	
	echo "</td></tr>";
	echo "</table>";
	echo "<img src='images/break-el.gif' height='1' width='100%' vspace='5'>";
	echo "<table width='640' border='0' cellspacing='0' cellpadding='0'>";
	echo "<tr><td width='40'>&nbsp;</td><td>";
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

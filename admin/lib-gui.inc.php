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
$phpAds_Message = '';
$phpAds_GUIDone = false;



/*********************************************************/
/* Show page header                                      */
/*********************************************************/

function phpAds_PageHeader($ID, $extra="")
{
	global $phpAds_nav, $pages;
	global $phpAds_name, $phpAds_my_header, $phpAds_CharSet;
	global $strLogout, $strNavigation;
	global $phpAds_Message, $phpAds_GUIDone;
	
	$phpAds_GUIDone = true;
	
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
		
		list($filename, $title) = each($pages["$ID"]);
		$sidebar .= "<img src='images/caret-u.gif' width='11' height='7'>&nbsp;";
		$sidebar .= "$title<br>";
		$sidebar .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		
		if ($extra != '') $sidebar .= $extra;
		
		
		// Set Pagetitle
		$pagetitle = $title;
		
		
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
					$tabbar .= "<td bgcolor='#FFFFFF' valign='middle'>&nbsp;&nbsp;<a class='tab-s' href='$filename'>$title</a></td>";
					$lastselected = true;
				}
				else
				{
					$tabbar .= "<td bgcolor='#0066CC' valign='middle'>&nbsp;&nbsp;<a class='tab-u' href='$filename'>$title</a></td>";
					$lastselected = false;
				}
			}
			
			$i++;
		}
		
		if ($lastselected)
			$tabbar .= "<td><img src='images/tab-ew.gif' width='10' height='24'></td>";
		else
			$tabbar .= "<td><img src='images/tab-eb.gif' width='10' height='24'></td>";
	}
	else
	{
		$sidebar = "&nbsp;";
		$tabbar = "&nbsp;";
		$pagetitle = "";
	}
	
	
	
	// Send header with charset info
	header ("Content-Type: text/html".($phpAds_CharSet != "" ? "; charset=".$phpAds_CharSet : ""));
	
	// Begin HTML
	?>
<html>
	<head>
		<title><?echo $pagetitle;?></title>
		<meta http-equiv='Content-Type' content='text/html<? echo $phpAds_CharSet != "" ? "; charset=".$phpAds_CharSet : "" ?>'>
		<meta name='author" content='phpAdsNew - http://sourceforge.net/projects/phpadsnew'>
		<link rel='stylesheet' href='interface.css'>
		<script language='JavaScript' src='interface.js'></script>
	</head>
	
<body bgcolor='#FFFFFF' background='images/background.gif' text='#000000' leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>

<!-- Top -->
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
<tr><td colspan='2' height='48' bgcolor='#000063' valign='bottom'>
<?
 	if ($phpAds_name != "")
		echo "<span class='phpAdsNew'>&nbsp;&nbsp;&nbsp;$phpAds_name &nbsp;&nbsp;&nbsp;</span>";
	else
		echo "&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/logo.gif' width='163' height='34' alt='phpAdsNew 2 beta 4'>";
?>
</td></tr>

<!-- Spacer -->
<tr><td colspan='2' height='6' bgcolor='#000063'><img src='images/spacer.gif' height='1' width='1'></td></tr>

<!-- Tabbar -->
<tr><td height='24' width='181' bgcolor='#000063'>&nbsp;</td>
<td height='24' bgcolor="#000063"> 
	<table border="0" cellspacing="0" cellpadding="0" width='100%'>
	<tr><td>
		<table border="0" cellspacing="0" cellpadding="0" width='1'>
	    <tr><? echo $tabbar; ?></tr>
		</table>
	</td><td align='right' valign='middle' nowrap>
		<a class='tab-n' href='logout.php'><?print $strLogout;?></a>
		<img src='images/logout.gif' width='16' height='16' align='absmiddle'>&nbsp;&nbsp;&nbsp;
	</td></tr>
	</table>
</td></tr>

<!-- Sidebar -->
<tr><td valign="top">
	<table width="181" border="0" cellspacing="0" cellpadding="0">

	<!-- Blue square -->
    <tr valign="top"><td colspan='2' width="20" height="48" bgcolor='#000063' valign='bottom'>
	<?
		// Show a message if defined
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
	?>
	</td></tr>
	
	<!-- Gradient -->
    <tr valign="top"><td width="20" height="24"><img src="images/grad-1.gif" width="20" height="20"></td>
	<td height="24"><img src="images/grad-1.gif" width="160" height="20"></td></tr>
	
	<!-- Navigation -->	
	<tr><td width="20">&nbsp;</td>
    <td class='nav'><? echo $sidebar; ?></td></tr>
    </table>
</td>

<!-- Main contents -->
<td valign="top">
	<table width="640" border="0" cellspacing="0" cellpadding="0">
    <tr><td width="40" height="20">&nbsp;</td><td height="20">&nbsp;</td></tr>
    <tr><td width="20">&nbsp;</td><td>
<?
	// END HTML
}



/*********************************************************/
/* Show page footer                                      */
/*********************************************************/

function phpAds_PageFooter()
{
	global $phpAds_my_footer, $strLogout, $strPreferences;
?>
	</td></tr>

	<!-- Spacer -->
	<tr><td width="40" height="20">&nbsp;</td>
	<td height="20">&nbsp;</td></tr>
	</table>
</td></tr>
</table>

<?
if (!empty($phpAds_my_footer))
{
	include ($phpAds_my_footer);
}
?>
</body>
</html>
<?
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
/* Show a the last SQL error and die                      */
/*********************************************************/

function mysql_die()
{
	global $strMySQLError;
    global $phpAds_last_query;
	global $phpAds_GUIDone;
	
	if ($phpAds_GUIDone == false) phpAds_PageHeader(0);
	
	echo "<table border='0' cellpadding='1' cellspacing='1' width='100%'><tr><td bgcolor='#FF0000'>";
		echo "<table border='0' cellpadding='5' cellspacing='0' width='100%'>";
		echo "<tr bgcolor='#EEEEEE'>";
		echo "<td width='20' valign='top'><img src='images/error.gif' hspace='3'></td>";
		echo "<td valign='top'>";
		echo "<b>$strMySQLError</b><br>";
		echo mysql_error()."<br><br>";
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

function php_die($title="Error", $message="Unkown error")
{
	global $phpAds_GUIDone;
	
	if ($phpAds_GUIDone == false) phpAds_PageHeader(0);
	
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

?>

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
$phpAds_NavID	= '';
$phpAds_GUIDone = false;



/*********************************************************/
/* Show page header                                      */
/*********************************************************/

function phpAds_PageHeader($ID, $extra="")
{
	global $phpAds_Message, $phpAds_GUIDone, $phpAds_NavID;
	global $phpAds_nav, $pages;
	global $phpAds_name, $phpAds_my_header, $phpAds_CharSet;
	global $phpAds_url_prefix;
	global $strLogout, $strNavigation;
	global $strAuthentification, $strSearch;
	
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
			$pagetitle = $phpAds_name != '' ? $phpAds_name : 'phpAdsNew';
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
		
		
		
		if (phpAds_isLoggedIn() && phpAds_isUser(phpAds_Admin))
		{
			$searchbar  = "<table cellpadding='0' cellspacing='0' border='0' bgcolor='#0066CC' height='24'>";
			$searchbar .= "<form name='search' action='admin-search.php' target='SearchWindow' onSubmit=\"search_window(document.search.keyword.value,'$phpAds_url_prefix/admin/admin-search.php'); return false;\">";
			$searchbar .= "<tr height='24'>";
			$searchbar .= "<td height='24'><img src='images/tab-sb.gif' height='24' width='10'></td>";
			$searchbar .= "<td class='tab-u'>$strSearch:</td>";
			$searchbar .= "<td>&nbsp;&nbsp;<input type='text' name='keyword' size='15'>&nbsp;&nbsp;</td>";
			$searchbar .= "<td><a href=\"javascript:search_window(document.search.keyword.value,'$phpAds_url_prefix/admin/admin-search.php');\"><img src='images/go.gif' border='0'></a></td>";
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
		$pagetitle = $phpAds_name != '' ? $phpAds_name : 'phpAdsNew';
	}
	
	
	
	// Send header with charset info
	header ("Content-Type: text/html".(isset($phpAds_CharSet) && $phpAds_CharSet != "" ? "; charset=".$phpAds_CharSet : ""));
	
	// Begin HTML
	?>
<html>
	<head>
		<title><?php echo $pagetitle;?></title>
		<meta http-equiv='Content-Type' content='text/html<?php echo $phpAds_CharSet != "" ? "; charset=".$phpAds_CharSet : "" ?>'>
		<meta name='author" content='phpAdsNew - http://sourceforge.net/projects/phpadsnew'>
		<meta name='robots' content='noindex, nofollow'>
		<link rel='stylesheet' href='interface.css'>
		<script language='JavaScript' src='interface.js'></script>
	</head>
	
<body bgcolor='#FFFFFF' background='images/background.gif' text='#000000' leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>

<!-- Top -->
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
<tr>
<?php
 	if ($phpAds_name != "")
	{
		echo "<td height='48' bgcolor='#000063' valign='middle'>";
		echo "<span class='phpAdsNew'>&nbsp;&nbsp;&nbsp;".$phpAds_name."&nbsp;&nbsp;&nbsp;</span>";
	}
	else
	{
		echo "<td height='48' bgcolor='#000063' valign='bottom'>";
		echo "&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/logo.gif' width='163' height='34' alt='phpAdsNew 2 beta 5'>";
	}
?>
	</td>
	<td bgcolor='#000063' valign='top' align='right'>
		<?php echo $searchbar; ?>
	</td>
</tr>
</table>

<!-- Spacer -->
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
<tr><td colspan='2' height='6' bgcolor='#000063'><img src='images/spacer.gif' height='1' width='1'></td></tr>
</table>

<!-- Tabbar -->
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
<tr><td height='24' width='181' bgcolor='#000063'>&nbsp;</td>
<td height='24' bgcolor="#000063"> 
	<table border="0" cellspacing="0" cellpadding="0" width='100%'>
	<tr><td>
		<table border="0" cellspacing="0" cellpadding="0" width='1'>
	    <tr><?php echo $tabbar; ?></tr>
		</table>
	</td><td align='right' valign='middle' nowrap>
		<?php
		if ($ID != "" && phpAds_isLoggedIn())
		{
			echo "<a class='tab-n' href='logout.php'>$strLogout</a> ";
			echo "<img src='images/logout.gif' width='16' height='16' align='absmiddle'>";
		}
		?>
		&nbsp;&nbsp;&nbsp;
	</td></tr>
	</table>
</td></tr>
</table>

<!-- Sidebar -->
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
<tr><td valign="top">
	<table width="181" border="0" cellspacing="0" cellpadding="0">

	<!-- Blue square -->
    <tr valign="top"><td colspan='2' width="20" height="48" bgcolor='#000063' valign='bottom'>
	<?php
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
    <td class='nav'><?php echo $sidebar; ?></td></tr>
    </table>
</td>

<!-- Main contents -->
<td valign="top">
	<table width="640" border="0" cellspacing="0" cellpadding="0">
    <tr><td width="40" height="20">&nbsp;</td><td height="20">&nbsp;</td></tr>
    <tr><td width="20">&nbsp;</td><td>
<?php
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

<?php
if (!empty($phpAds_my_footer))
{
	include ($phpAds_my_footer);
}
?>
</body>
</html>
<?php
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
	
	if ($phpAds_GUIDone == false) phpAds_PageHeader(-1);
	
	echo "<br><br>";
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
	global $phpAds_admin_novice;
	
	if ($phpAds_admin_novice == true)
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

?>

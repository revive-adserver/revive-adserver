<?php // $Revision: 1.0 
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



// Include required files
require ("config.php");


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Client);


?>

<html>
	<head>
		<title>Errors</title>
		<meta http-equiv='Content-Type' content='text/html<?php echo $phpAds_CharSet != "" ? "; charset=".$phpAds_CharSet : "" ?>'>
		<meta name='author' content='phpAdsNew - http://sourceforge.net/projects/phpadsnew'>
		<link rel='stylesheet' href='images/<?php echo $phpAds_TextDirection; ?>/interface.css'>
		<script language='JavaScript' src='interface.js'></script>
	</head>
	
<body bgcolor='#FFFFFF' text='#000000' leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>

<!-- Top -->
<table width='100%' border='0' cellspacing='0' cellpadding='0'>


<!-- Spacer -->
<tr><td colspan='2' height='24' bgcolor='#000063'><img src='images/spacer.gif' height='1' width='1'></td></tr>

<!-- Tabbar -->
<tr>
	<td colspan='2' height='24' bgcolor="#000063"> 
		<table cellpadding='0' cellspacing='0' border='0' bgcolor='#FFFFFF' height='24'>
			<tr height='24'>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td valign='middle'><span class='tab-s'>Errors:</span></td>
				<td height='24'><img src='images/<?php echo $phpAds_TextDirection; ?>/tab-ew.gif' height='24' width='10'></td>
			</tr>
		</table>
	</td>
</tr>
</table>

<br><br>

<!-- Search Results -->	
<table width='100%' cellpadding='0' cellspacing='0' border='0'>
<tr><td width='20'>&nbsp;</td><td>
	
<?php
	$errorArray = explode ('|', $errors);
	
	echo "<table width='294' cellpadding='0' cellspacing='0' border='0'>";
	echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";	
	
	for ($i=0;$i<sizeof($errorArray);$i++)
	{
		if ($errorArray[$i] != '')
		{
			if ($i > 0) echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
			echo "<tr height='35' ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td>";
			echo "&nbsp;<img src='images/error.gif' align='absmiddle'>&nbsp;</td><td>";
			
			if (ereg("^(.*):", $errorArray[$i], $regs))
				echo "&nbsp;<b>".$GLOBALS[$regs[1]]."</b><br>";
			
			if (ereg(":required", $errorArray[$i]))
				echo "&nbsp;&nbsp;&nbsp;&nbsp;is required.";
			
			if (ereg(":email", $errorArray[$i]))
				echo "&nbsp;&nbsp;&nbsp;&nbsp;must contain an e-mail address.";
			
			if (ereg(":number", $errorArray[$i]))
				echo "&nbsp;&nbsp;&nbsp;&nbsp;must contain a number.";
			
			if (ereg(":positive", $errorArray[$i]))
				echo "&nbsp;&nbsp;&nbsp;&nbsp;must contain a positive number.";
			
			if (ereg(":range(.*)-(.*)", $errorArray[$i], $regs))
				echo "&nbsp;&nbsp;&nbsp;&nbsp;must contain a number between ".$regs[1]." and ".$regs[2].".";
			
			echo "</td><td>";
		}
	}
	
	echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";	
	echo "</table>";
?>
</table>

</td><td width='20'>&nbsp;</td></tr>
</table>

<br><br> 

</body>
</html>
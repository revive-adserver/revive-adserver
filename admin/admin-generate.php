<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by Niels Leenheer <niels@creatype.nl              */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-statistics.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageHeader("4.3");
phpAds_ShowSections(array("4.1", "4.2", "4.3", "4.4"));




/*********************************************************/
/* Generate bannercode                                   */
/*********************************************************/

function phpAds_GenerateInvocationCode()
{
	global $phpAds_config;
	global $codetype, $what, $clientid, $source, $target;
	global $withText, $template, $refresh, $uniqueid;
	global $width, $height;
	global $popunder, $left, $top, $timeout;
	global $transparent, $resize;
	
	$buffer = '';
	$parameters = array();
	
	
	$uniqueid = substr(md5(uniqid('')), 0, 8);
	if (!isset($withText)) $withText = 0;
	
	
	// Set parameters
	if (isset($what) && $what != '')
		$parameters[] = "what=".str_replace (",+", ",_", $what);
	
	if (isset($clientid) && $clientid != '0')
		$parameters[] = "clientid=".$clientid;
	
	if (isset($source) && $source != '')
		$parameters[] = "source=".$source;
	
	if (isset($target) && $target != '')
		$parameters[] = "target=".$target;
	
	
	// Remote invocation
	if ($codetype=='adview')
	{
		if (isset($uniqueid) && $uniqueid != '')
			$parameters[] = "n=".$uniqueid;	
		
		$buffer .= "<a href='".$phpAds_config['url_prefix']."/adclick.php";
		if (isset($uniqueid) & $uniqueid != '')
			$buffer .= "?n=".$uniqueid;
		$buffer .= "'";
		if (isset($target) && $target != '')
			$buffer .= " target='$target'";
		$buffer .= "><img src='".$phpAds_config['url_prefix']."/adview.php";
		if (sizeof($parameters) > 0)
			$buffer .= "?".implode ("&", $parameters);
		$buffer .= "' border='0'></a>";
	}
	
	// Remote invocation with JavaScript
	if ($codetype=='adjs')
	{
		if (isset($withText) && $withText == '0')
			$parameters[] = "withText=0";
		
		$buffer .= "<script language='JavaScript' src='".$phpAds_config['url_prefix']."/adjs.php";
		if (sizeof($parameters) > 0)
			$buffer .= "?".implode ("&", $parameters);
		$buffer .= "'></script>";
	}
	
	// Remote invocation for iframes
	if ($codetype=='adframe')
	{
		if (isset($refresh) && $refresh != '')
			$parameters[] = "refresh=".$refresh;
		
		if (isset($resize) && $resize == '1')
			$parameters[] = "resize=1";
		
		$buffer .= "<iframe id='".$uniqueid."' name='".$uniqueid."' src='".$phpAds_config['url_prefix']."/adframe.php";
		if (sizeof($parameters) > 0)
			$buffer .= "?".implode ("&", $parameters);
		$buffer .= "' framespacing='0' frameborder='no' scrolling='no'";
		if (isset($width) & $width != '')
			$buffer .= " width='".$width."'";
		if (isset($height) & $height != '')
			$buffer .= " height='".$height."'";
		if (isset($transparent) & $transparent == '1')
			$buffer .= " allowtransparency='true'";
		$buffer .= "></iframe>";
	}
	
	// Combined remote invocation
	if ($codetype=='ad')
	{
		// Parameters for remote invocation for javascript
		if (isset($withText) && $withText == '0')
			$parameters['withtext'] = "withText=0";
		
		$buffer .= "<script language='JavaScript' src='".$phpAds_config['url_prefix']."/adjs.php";
		if (sizeof($parameters) > 0)
			$buffer .= "?".implode ("&", $parameters);
		$buffer .= "'></script>";
		
		if (isset($parameters['withtext']))
			unset ($parameters['withtext']);
		
		
		
		$buffer .= "<noscript>";
		
		// Parameters for remote invocation for iframes
		if (isset($resize) && $resize != '')
			$parameters['resize'] = "resize=".$resize;
		
		$buffer .= "<iframe id='".$uniqueid."' name='".$uniqueid."' src='".$phpAds_config['url_prefix']."/adframe.php";
		if (sizeof($parameters) > 0)
			$buffer .= "?".implode ("&", $parameters);
		$buffer .= "' framespacing='0' frameborder='no' scrolling='no'";
		if (isset($width) & $width != '')
			$buffer .= " width='".$width."'";
		if (isset($height) & $height != '')
			$buffer .= " height='".$height."'";
		if (isset($transparent) & $transparent == '1')
			$buffer .= " allowtransparency='true'";
		$buffer .= ">";
		
		if (isset($parameters['resize']))
			unset ($parameters['resize']);
		
		
		
		// Parameters for remote invocation
		if (isset($uniqueid) && $uniqueid != '')
			$parameters[] = "n=".$uniqueid;	
		
		$buffer .= "<a href='".$phpAds_config['url_prefix']."/adclick.php";
		if (isset($uniqueid) & $uniqueid != '')
			$buffer .= "?n=".$uniqueid;
		$buffer .= "'";
		if (isset($target) && $target != '')
			$buffer .= " target='$target'";
		$buffer .= "><img src='".$phpAds_config['url_prefix']."/adview.php";
		if (sizeof($parameters) > 0)
			$buffer .= "?".implode ("&", $parameters);
		$buffer .= "' border='0'></a>";		
		
		$buffer .= "</iframe>";
		
		$buffer .= "</noscript>";
	}
	
	// Popup
	if ($codetype=='popup')
	{
		if (isset($popunder) && $popunder == '1')
			$parameters[] = "popunder=1";
		
		if (isset($left) && $left != '' && $left != '-')
			$parameters[] = "left=".$left;
		
		if (isset($top) && $top != '' && $top != '-')
			$parameters[] = "top=".$top;
		
		if (isset($timeout) && $timeout != '' && $timeout != '-')
			$parameters[] = "timeout=".$timeout;
		
		$buffer .= "<script language='JavaScript' src='".$phpAds_config['url_prefix']."/adpopup.php";
		if (sizeof($parameters) > 0)
			$buffer .= "?".implode ("&", $parameters);
		$buffer .= "'></script>";
	}
	
	if ($codetype=='local')
	{
		$path = phpAds_path;
		$path = str_replace ('\\', '/', $path);
		$root = getenv('DOCUMENT_ROOT');
		$pos  = strpos ($path, $root);
		
		if (is_int($pos) && $pos == 0)
			$path = "getenv('DOCUMENT_ROOT').'".substr ($path, $pos + strlen ($root))."/phpadsnew.inc.php'";
		else
			$path = "'".$path."/phpadsnew.inc.php'";
		
		$buffer .= "<"."?php\n";
		$buffer .= "    require($path);\n";
		$buffer .= "    view ('$what', $clientid, '$target', '$source', '$withText');\n";
		$buffer .= "?".">";
	
	}
	
	return $buffer;
}




/*********************************************************/
/* Main code                                             */
/*********************************************************/

echo "<form name='availability' action='admin-generate.php' method='POST'>\n";


if (!isset($codetype)) $codetype = 'local';

// Invocation type selection
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>$strChooseInvocationType</b></td></tr>";
echo "<tr><td height='35'>";
	echo "<select name='codetype'>";
	echo "<option value='adview'".($codetype == 'adview' ? ' selected' : '').">Remote Invocation</option>";
	echo "<option value='adjs'".($codetype == 'adjs' ? ' selected' : '').">Remote Invocation with JavaScript</option>";
	echo "<option value='adframe'".($codetype == 'adframe' ? ' selected' : '').">Remote Invocation for iframes</option>";
	echo "<option value='ad'".($codetype == 'ad' ? ' selected' : '').">Combined Remote Invocation</option>";
	echo "<option value='popup'".($codetype == 'popup' ? ' selected' : '').">Pop-up</option>";
	if (phpAds_isUser(phpAds_Admin)) echo "<option value='local'".($codetype == 'local' ? ' selected' : '').">Local mode</option>";
	echo "</select>";
	echo "&nbsp;<a href='javascript:document.availability.submit();'><img src='images/go_blue.gif' border='0'></a>";
echo "</td></tr></table>";

phpAds_ShowBreak();
echo "<br><br>";


// Header
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>$strParameters</b></td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr bgcolor='#F6F6F6'><td height='10' colspan='3'>&nbsp;</td></tr>";



if ($codetype == 'adview')
	$show = array ('what' => true, 'clientid' => true, 'target' => true, 'source' => true);

if ($codetype == 'adjs')
	$show = array ('what' => true, 'clientid' => true, 'target' => true, 'source' => true, 'withText' => true);

if ($codetype == 'adframe')
	$show = array ('what' => true, 'clientid' => true, 'target' => true, 'source' => true, 'refresh' => true, 'size' => true, 'resize' => true, 'transparent' => true);

if ($codetype == 'ad')
	$show = array ('what' => true, 'clientid' => true, 'target' => true, 'source' => true, 'withText' => true, 'size' => true, 'resize' => true, 'transparent' => true);

if ($codetype == 'popup')
	$show = array ('what' => true, 'clientid' => true, 'target' => true, 'source' => true, 'absolute' => true, 'popunder' => true, 'timeout' => true);

if ($codetype == 'local')
	$show = array ('what' => true, 'clientid' => true, 'target' => true, 'source' => true, 'withText' => true, 'template' => true);




// What
if (isset($show['what']) && $show['what'] == true)
{
	echo "<tr bgcolor='#F6F6F6'><td width='30'>&nbsp;</td>";
	echo "<td width='200' valign='top'>What</td><td width='370'>";
		echo "<textarea class='flat' name='what' rows='3' cols='50' style='width:350px;'>".(isset($what) ? stripslashes($what) : '')."</textarea></td></tr>";
	echo "<tr bgcolor='#F6F6F6'><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td bgcolor='#F6F6F6' colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
}


// ClientID
if (isset($show['clientid']) && $show['clientid'] == true)
{
	echo "<tr bgcolor='#F6F6F6'><td width='30'>&nbsp;</td>";
	echo "<td width='200'>ClientID</td><td width='370'>";
	echo "<select name='clientid' style='width:175px;'>";
		echo "<option value='0'>-</option>";
	
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_clients']."
		");
		
		while ($row = phpAds_dbFetchArray($res))
		{
			echo "<option value='".$row['clientid']."'".($clientid == $row['clientid'] ? ' selected' : '').">";
			echo phpAds_buildClientName ($row['clientid'], $row['clientname']);
			echo "</option>";
		}
	
	echo "</select>";
	echo "</td></tr>";
	echo "<tr bgcolor='#F6F6F6'><td height='10' colspan='3'>&nbsp;</td></tr>";
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
}


// Target
if (isset($show['target']) && $show['target'] == true)
{
//	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>Target</td><td width='370'>";
		echo "<input class='flat' type='text' name='target' size='' value='".(isset($target) ? $target : '')."' style='width:175px;'></td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
}


// Source
if (isset($show['source']) && $show['source'] == true)
{
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>Source</td><td width='370'>";
		echo "<input class='flat' type='text' name='source' size='' value='".(isset($source) ? $source : '')."' style='width:175px;'></td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
}


// WithText
if (isset($show['withText']) && $show['withText'] == true)
{
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>WithText</td>";
	echo "<td width='370'><input type='radio' name='withText' value='1'".(isset($withText) && $withText != 0 ? ' checked' : '').">&nbsp;Yes<br>";
	echo "<input type='radio' name='withText' value='0'".(!isset($withText) || $withText == 0 ? ' checked' : '').">&nbsp;No</td>";
	echo "</tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
}


// refresh
if (isset($show['refresh']) && $show['refresh'] == true)
{
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>Refresh after</td><td width='370'>";
		echo "<input class='flat' type='text' name='refresh' size='' value='".(isset($refresh) ? $refresh : '')."' style='width:175px;'> sec</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
}


// size
if (isset($show['size']) && $show['size'] == true)
{
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>$strFrameSize</td><td width='370'>";
		echo "$strWidth: <input class='flat' type='text' name='width' size='3' value='".(isset($width) ? $width : '')."'>&nbsp;&nbsp;&nbsp;";
		echo "$strHeight: <input class='flat' type='text' name='height' size='3' value='".(isset($height) ? $height : '')."'>";
	echo "</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
}


// Resize
if (isset($show['resize']) && $show['resize'] == true)
{
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>Resize iframe to banner dimensions</td>";
	echo "<td width='370'><input type='radio' name='resize' value='1'".(isset($resize) && $resize == 1 ? ' checked' : '').">&nbsp;Yes<br>";
	echo "<input type='radio' name='resize' value='0'".(!isset($resize) || $resize == 0 ? ' checked' : '').">&nbsp;No</td>";
	echo "</tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
}


// Transparent
if (isset($show['transparent']) && $show['transparent'] == true)
{
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>Make the iframe transparent</td>";
	echo "<td width='370'><input type='radio' name='transparent' value='1'".(isset($transparent) && $transparent == 1 ? ' checked' : '').">&nbsp;Yes<br>";
	echo "<input type='radio' name='transparent' value='0'".(!isset($transparent) || $transparent == 0 ? ' checked' : '').">&nbsp;No</td>";
	echo "</tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
}


// popunder
if (isset($show['popunder']) && $show['popunder'] == true)
{
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>Pop-up type</td>";
	echo "<td width='370'><input type='radio' name='popunder' value='0'".(!isset($popunder) || $popunder != '1' ? ' checked' : '').">&nbsp;Pop-up<br>";
	echo "<input type='radio' name='popunder' value='1'".(isset($popunder) && $popunder == '1' ? ' checked' : '').">&nbsp;Pop-under</td>";
	echo "</tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
}


// absolute
if (isset($show['absolute']) && $show['absolute'] == true)
{
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>Initial position (top)</td><td width='370'>";
		echo "<input class='flat' type='text' name='top' size='' value='".(isset($top) ? $top : '-')."' style='width:175px;'> px</td></tr>";
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>Initial position (left)</td><td width='370'>";
		echo "<input class='flat' type='text' name='left' size='' value='".(isset($left) ? $left : '-')."' style='width:175px;'> px</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
}


// timeout
if (isset($show['timeout']) && $show['timeout'] == true)
{
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>Automatically close after</td><td width='370'>";
		echo "<input class='flat' type='text' name='timeout' size='' value='".(isset($timeout) ? $timeout : '-')."' style='width:175px;'> sec</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
}



if (isset($submit))
{
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='560' colspan='2'>";
	echo "<br><br><img src='images/icon-generatecode.gif' align='absmiddle'>&nbsp;<b>$strBannercode:</b><br><br>";
	
	echo "<textarea class='flat' rows='8' cols='55' style='width:560px;'>".htmlentities(phpAds_GenerateInvocationCode($zoneid))."</textarea>";
	echo "</td></tr>";
}


echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

echo "</table>";
echo "<br><br>";
echo "<input type='submit' value='$strGenerate' name='submit'>";
echo "</form>";
echo "<br><br>";



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();


?>
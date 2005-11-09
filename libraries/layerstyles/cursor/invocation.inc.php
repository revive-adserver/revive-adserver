<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2005 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Prevent full path disclosure
if (!defined('phpAds_path')) die();



// Define constant used to place code generator
define('phpAds_adLayerLoaded', true);


// Register input variables
phpAds_registerGlobal ('stickyness', 'offsetx', 'offsety', 'hide',
					   'transparancy', 'delay', 'trail');



/*********************************************************/
/* Place ad-generator settings                           */
/*********************************************************/

function phpAds_placeLayerSettings ()
{
	global $stickyness, $offsetx, $offsety, $hide, $transparancy, $delay, $trail;
	global $tabindex;
	
	if (!isset($trail)) $trail = '0';
	if (!isset($stickyness)) $stickyness = 5;
	if (!isset($offsetx)) $offsetx = 10;
	if (!isset($offsety)) $offsety = 10;
	if (!isset($hide)) $hide = '0';
	if (!isset($transparancy)) $transparancy = 0;
	if (!isset($delay)) $delay = 90;
	
	echo "<tr><td height='30' colspan='3'>&nbsp;</td></tr>";
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strSmoothMovement']."</td><td width='370'>";
	echo "<select name='trail' style='width:60px;' onChange='this.form.stickyness.disabled = this.selectedIndex ? true : false;' tabindex='".($tabindex++)."'>";
		echo "<option value='1'".($trail == '1' ? ' selected' : '').">".$GLOBALS['strYes']."</option>";
		echo "<option value='0'".($trail == '0' ? ' selected' : '').">".$GLOBALS['strNo']."</option>";
	echo "</select>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strSpeed']."</td><td width='370'>";
	echo "<select name='stickyness' style='width:60px;'".($trail == '0' ? ' disabled' : '')." tabindex='".($tabindex++)."'>";
	for ($i=1;$i<=9;$i++)
		echo "<option value='".$i."'".($stickyness == $i ? ' selected' : '').">".$i."</option>";
	echo "</select>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	
	echo "<tr><td height='30' colspan='3'>&nbsp;</td></tr>";
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strHideNotMoving']."</td><td width='370'>";
	echo "<select name='hide' style='width:60px;' tabindex='".($tabindex++)."' onChange='this.form.transparancy.disabled = this.selectedIndex ? true : false; this.form.delay.disabled = this.selectedIndex ? true : false;'>";
		echo "<option value='1'".($hide == '1' ? ' selected' : '').">".$GLOBALS['strYes']."</option>";
		echo "<option value='0'".($hide == '0' ? ' selected' : '').">".$GLOBALS['strNo']."</option>";
	echo "</select>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strHideDelay']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='delay' size='' value='".$delay."' style='width:60px;'".($hide == '0' ? ' disabled' : '')." tabindex='".($tabindex++)."'> ms</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strHideTransparancy']."</td><td width='370'>";
	echo "<select name='transparancy' style='width:60px;'".($hide == '0' ? ' disabled' : '')." tabindex='".($tabindex++)."'>";
	for ($i=0;$i<=9;$i++)
		echo "<option value='".($i * 10)."'".($transparancy == ($i * 10) ? ' selected' : '').">".($i * 10)." %</option>";
	echo "</select>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	
	echo "<tr><td height='30' colspan='3'>&nbsp;</td></tr>";
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strHShift']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='offsetx' size='' value='".$offsetx."' style='width:60px;' tabindex='".($tabindex++)."'> ".$GLOBALS['strAbbrPixels']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strVShift']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='offsety' size='' value='".$offsety."' style='width:60px;' tabindex='".($tabindex++)."'> ".$GLOBALS['strAbbrPixels']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
}



/*********************************************************/
/* Place ad-generator settings                           */
/*********************************************************/

function phpAds_generateLayerCode ($parameters)
{
	global $phpAds_config;
	global $stickyness, $offsetx, $offsety, $hide, $transparancy, $delay, $trail;
	
	$parameters[] = 'layerstyle=cursor';
	$parameters[] = 'hide='.$hide;
	$parameters[] = 'trail='.$trail;
	$parameters[] = 'offsetx='.$offsetx;
	$parameters[] = 'offsety='.$offsety;
	
	if ($trail == '1')
		$parameters[] = 'stickyness='.$stickyness;
	
	if ($hide == '1')
	{
		$parameters[] = 'transparancy='.$transparancy;
		$parameters[] = 'delay='.$delay;
	}
	
	$buffer = "<script language='JavaScript' type='text/javascript' src='".$phpAds_config['url_prefix']."/adlayer.php";
	if (sizeof($parameters) > 0)
		$buffer .= "?".implode ("&amp;", $parameters);
	$buffer .= "'></script>";
	
	return $buffer;
}



/*********************************************************/
/* Return $show var for generators                       */
/*********************************************************/

function phpAds_getlayerShowVar ()
{
	return array (
		'what' => true,
		'acid' => true,
		'target' => true,
		'source' => true,
		'layerstyle' => true,
		'layercustom' => true
	);
}

?>
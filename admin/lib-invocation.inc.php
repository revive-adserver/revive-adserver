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



// Load translations
if (file_exists("../language/".strtolower($phpAds_config['language'])."/invocation.lang.php"))
{
	require ("../language/".strtolower($phpAds_config['language'])."/invocation.lang.php");
}
else
{
	require ("../language/english/invocation.lang.php");
}



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
	global $hostlanguage;
	
	$buffer = '';
	$parameters = array();
	
	
	$uniqueid = substr(md5(uniqid('')), 0, 8);
	if (!isset($withText)) $withText = 0;
	
	
	// Set parameters
	if (isset($what) && $what != '')
		$parameters[] = "what=".str_replace (",+", ",_", $what);
	
	if (isset($clientid) && strlen($clientid) && $clientid != '0')
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
		$buffer .= "?n=".$uniqueid;
		if (sizeof($parameters) > 0)
			$buffer .= "&".implode ("&", $parameters);
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
		$buffer .= "?n=".$uniqueid;
		if (sizeof($parameters) > 0)
			$buffer .= "&".implode ("&", $parameters);
		$buffer .= "' framespacing='0' frameborder='no' scrolling='no'";
		if (isset($width) & $width != '')
			$buffer .= " width='".$width."'";
		if (isset($height) & $height != '')
			$buffer .= " height='".$height."'";
		if (isset($transparent) & $transparent == '1')
			$buffer .= " allowtransparency='true'";
		$buffer .= ">";
		
		if (isset($refresh) && $refresh != '')
			unset ($parameters['refresh']);
		
		if (isset($resize) && $resize == '1')
			unset ($parameters['resize']);
		
		if (isset($uniqueid) && $uniqueid != '')
			$parameters[] = "n=".$uniqueid;	
		
		$buffer .= "<a href='".$phpAds_config['url_prefix']."/adclick.php";
		$buffer .= "?n=".$uniqueid;
		$buffer .= "'";
		if (isset($target) && $target != '')
			$buffer .= " target='$target'";
		$buffer .= "><img src='".$phpAds_config['url_prefix']."/adview.php";
		if (sizeof($parameters) > 0)
			$buffer .= "?".implode ("&", $parameters);
		$buffer .= "' border='0'></a>";
		
		$buffer .= "</iframe>";
	}
	
	// Combined remote invocation
	if ($codetype=='ad')
	{
		// Parameters for remote invocation for javascript
		if (isset($withText) && $withText == '0')
			$parameters['withtext'] = "withText=0";
		
		$buffer .= "<script language='JavaScript' src='".$phpAds_config['url_prefix']."/adjs.php";
		$buffer .= "?n=".$uniqueid;
		if (sizeof($parameters) > 0)
			$buffer .= "&".implode ("&", $parameters);
		$buffer .= "'></script>";
		
		if (isset($parameters['withtext']))
			unset ($parameters['withtext']);
		
		
		
		$buffer .= "<noscript>";
		
		// Parameters for remote invocation for iframes
		if (isset($resize) && $resize != '')
			$parameters['resize'] = "resize=".$resize;
		
		$buffer .= "<iframe id='".$uniqueid."' name='".$uniqueid."' src='".$phpAds_config['url_prefix']."/adframe.php";
		$buffer .= "?n=".$uniqueid;
		if (sizeof($parameters) > 0)
			$buffer .= "&".implode ("&", $parameters);
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
		$buffer .= "?n=".$uniqueid;
		if (sizeof($parameters) > 0)
			$buffer .= "&".implode ("&", $parameters);
		$buffer .= "'></script>";
	}
	
	// Remote invocation for layers
	if ($codetype=='adlayer')
		$buffer = phpAds_generateLayerCode($parameters);
	
	// Remote invocation using XML-RPC
	if ($codetype=='xmlrpc')
	{
		$params = parse_url($phpAds_config['url_prefix']);
		
		switch($hostlanguage)
		{
			case 'php':
				$buffer = "<"."?php\n";
				$buffer .= "    // Remember to copy files in samples/xmlrpc/php to the same directory as your script\n\n";
				$buffer .= "    require('lib-xmlrpc-class.inc.php');\n";
				$buffer .= "    \$xmlrpcbanner = new phpAds_XmlRpc('$params[host]', '$params[path]'".
					($params['port'] ? ", '$params[port]'" : "").");\n";
				$buffer .= "    \$xmlrpcbanner->view('$what', $clientid, '$target', '$source', '$withText');\n";
				$buffer .= "?".">";
				break;
		}
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
/* Place invocation form                                 */
/*********************************************************/

function phpAds_placeInvocationForm($extra = '', $zone_invocation = false)
{
	global $phpAds_config, $phpAds_TextDirection, $PHP_SELF;
	global $submitbutton, $generate;
	global $codetype, $what, $clientid, $source, $target;
	global $withText, $template, $refresh, $uniqueid;
	global $width, $height;
	global $popunder, $left, $top, $timeout;
	global $transparent, $resize;
	global $hostlanguage;
	global $layerstyle;
	
	
	echo "<form name='generate' action='".$PHP_SELF."' method='POST'>\n";
	
	if (!isset($codetype)) $codetype = 'local';
	
	// Invocation type selection
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
	echo "<tr><td height='25' colspan='3'><b>".$GLOBALS['strChooseInvocationType']."</b></td></tr>";
	echo "<tr><td height='35'>";
		echo "<select name='codetype' onChange=\"this.form.submit()\">";
		echo "<option value='adview'".($codetype == 'adview' ? ' selected' : '').">".$GLOBALS['strInvocationRemote']."</option>";
		echo "<option value='adjs'".($codetype == 'adjs' ? ' selected' : '').">".$GLOBALS['strInvocationJS']."</option>";
		echo "<option value='adframe'".($codetype == 'adframe' ? ' selected' : '').">".$GLOBALS['strInvocationIframes']."</option>";
		echo "<option value='xmlrpc'".($codetype == 'xmlrpc' ? ' selected' : '').">".$GLOBALS['strInvocationXmlRpc']."</option>";
		echo "<option value='ad'".($codetype == 'ad' ? ' selected' : '').">".$GLOBALS['strInvocationCombined']."</option>";
		echo "<option value='popup'".($codetype == 'popup' ? ' selected' : '').">".$GLOBALS['strInvocationPopUp']."</option>";
		echo "<option value='adlayer'".($codetype == 'adlayer' ? ' selected' : '').">".$GLOBALS['strInvocationAdLayer']."</option>";
		if (phpAds_isUser(phpAds_Admin)) echo "<option value='local'".($codetype == 'local' ? ' selected' : '').">".$GLOBALS['strInvocationLocal']."</option>";
		echo "</select>";
		echo "&nbsp;<input type='image' src='images/".$phpAds_TextDirection."/go_blue.gif' border='0'>";
	echo "</td></tr></table>";
	
	phpAds_ShowBreak();
	echo "<br><br>";
	
	
	// Header
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
	echo "<tr><td height='25' colspan='3'><b>".$GLOBALS['strParameters']."</b></td></tr>";
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr".($zone_invocation? '' : " bgcolor='#F6F6F6'")."><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	
	
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
	
	if ($codetype == 'adlayer')
	{
		if (!isset($layerstyle)) $layerstyle = 'geocities';
		
		include ('../misc/layerstyles/'.$layerstyle.'/layerstyle.inc.php');
	
		$show = phpAds_getLayerShowVar();
	}
	
	if ($codetype == 'xmlrpc')
		$show = array ('what' => true, 'clientid' => true, 'target' => true, 'source' => true, 'withText' => true, 'template' => true, 'hostlanguage' => true);
	
	if ($codetype == 'local')
		$show = array ('what' => true, 'clientid' => true, 'target' => true, 'source' => true, 'withText' => true, 'template' => true);
	
	
	
	// What
	if (!$zone_invocation && isset($show['what']) && $show['what'] == true)
	{
		echo "<tr bgcolor='#F6F6F6'><td width='30'>&nbsp;</td>";
		echo "<td width='200' valign='top'>".$GLOBALS['strInvocationWhat']."</td><td width='370'>";
			echo "<textarea class='flat' name='what' rows='3' cols='50' style='width:350px;'>".(isset($what) ? stripslashes($what) : '')."</textarea></td></tr>";
		echo "<tr bgcolor='#F6F6F6'><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
		echo "<td bgcolor='#F6F6F6' colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	}
	
	
	// ClientID
	if (!$zone_invocation && isset($show['clientid']) && $show['clientid'] == true)
	{
		echo "<tr bgcolor='#F6F6F6'><td width='30'>&nbsp;</td>";
		echo "<td width='200'>".$GLOBALS['strInvocationClientID']."</td><td width='370'>";
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
		echo "<td width='200'>".$GLOBALS['strInvocationTarget']."</td><td width='370'>";
			echo "<input class='flat' type='text' name='target' size='' value='".(isset($target) ? $target : '')."' style='width:175px;'></td></tr>";
		echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	}
	
	
	// Source
	if (isset($show['source']) && $show['source'] == true)
	{
		echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200'>".$GLOBALS['strInvocationSource']."</td><td width='370'>";
			echo "<input class='flat' type='text' name='source' size='' value='".(isset($source) ? $source : '')."' style='width:175px;'></td></tr>";
		echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	}
	
	
	// WithText
	if (isset($show['withText']) && $show['withText'] == true)
	{
		echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200'>".$GLOBALS['strInvocationWithText']."</td>";
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
		echo "<td width='200'>".$GLOBALS['strIFrameRefreshAfter']."</td><td width='370'>";
			echo "<input class='flat' type='text' name='refresh' size='' value='".(isset($refresh) ? $refresh : '')."' style='width:175px;'> sec</td></tr>";
		echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	}
	
	
	// size
	if (!$zone_invocation && isset($show['size']) && $show['size'] == true)
	{
		echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200'>".$GLOBALS['strFrameSize']."</td><td width='370'>";
			echo $GLOBALS['strWidth'].": <input class='flat' type='text' name='width' size='3' value='".(isset($width) ? $width : '')."'>&nbsp;&nbsp;&nbsp;";
			echo $GLOBALS['strHeight'].": <input class='flat' type='text' name='height' size='3' value='".(isset($height) ? $height : '')."'>";
		echo "</td></tr>";
		echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	}
	
	
	// Resize
	if (isset($show['resize']) && $show['resize'] == true)
	{
		echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200'>".$GLOBALS['strIframeResizeToBanner']."</td>";
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
		echo "<td width='200'>".$GLOBALS['strIframeMakeTransparent']."</td>";
		echo "<td width='370'><input type='radio' name='transparent' value='1'".(isset($transparent) && $transparent == 1 ? ' checked' : '').">&nbsp;Yes<br>";
		echo "<input type='radio' name='transparent' value='0'".(!isset($transparent) || $transparent == 0 ? ' checked' : '').">&nbsp;No</td>";
		echo "</tr>";
		echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	}
	
	
	// AdLayer style
	if (isset($show['layerstyle']) && $show['layerstyle'] == true)
	{
		$layerstyles = array();
		
		$stylesdir = opendir('../misc/layerstyles');
		while ($stylefile = readdir($stylesdir))
		{
			if (is_dir('../misc/layerstyles/'.$stylefile) &&
				file_exists('../misc/layerstyles/'.$stylefile.'/layerstyle.inc.php'))
			{
				if (ereg('^[^.]', $stylefile))
					$layerstyles[$stylefile] = isset($GLOBALS['strAdLayerStyleName'][$stylefile]) ?
						$GLOBALS['strAdLayerStyleName'][$stylefile] :
						str_replace("- ", "-", 
							ucwords(str_replace("-", "- ", $stylefile)));
			}
		}
		closedir($stylesdir);
	
		asort($layerstyles, SORT_STRING);
		
		echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200'>".$GLOBALS['strAdLayerStyle']."</td><td width='370'>";
		echo "<select name='layerstyle' onChange='this.form.submit()' style='width:175px;'>";
	
		while (list($k, $v) = each($layerstyles))
			echo "<option value='$k'".($layerstyle == $k ? ' selected' : '').">$v</option>";
	
		echo "</select>";
		echo "</td></tr>";
		echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	}
	
	
	// popunder
	if (isset($show['popunder']) && $show['popunder'] == true)
	{
		echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200'>".$GLOBALS['strPopUpStyle']."</td>";
		echo "<td width='370'><input type='radio' name='popunder' value='0'".
			(!isset($popunder) || $popunder != '1' ? ' checked' : '').">&nbsp;".
			$GLOBALS['strPopUpStylePopUp']."<br>";
		echo "<input type='radio' name='popunder' value='1'".
			(isset($popunder) && $popunder == '1' ? ' checked' : '').">&nbsp;".
			$GLOBALS['strPopUpStylePopUnder']."</td>";
		echo "</tr>";
		echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	}
	
	
	// absolute
	if (isset($show['absolute']) && $show['absolute'] == true)
	{
		echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200'>".$GLOBALS['strPopUpTop']."</td><td width='370'>";
			echo "<input class='flat' type='text' name='top' size='' value='".(isset($top) ? $top : '-')."' style='width:175px;'> ".$GLOBALS['strAbbrPixels']."</td></tr>";
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200'>".$GLOBALS['strPopUpLeft']."</td><td width='370'>";
			echo "<input class='flat' type='text' name='left' size='' value='".(isset($left) ? $left : '-')."' style='width:175px;'> ".$GLOBALS['strAbbrPixels']."</td></tr>";
		echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	}
	
	
	// timeout
	if (isset($show['timeout']) && $show['timeout'] == true)
	{
		echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200'>".$GLOBALS['strAutoCloseAfter']."</td><td width='370'>";
			echo "<input class='flat' type='text' name='timeout' size='' value='".(isset($timeout) ? $timeout : '-')."' style='width:175px;'> ".$GLOBALS['strAbbrSeconds']."</td></tr>";
		echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	}
	
	
	// AdLayer custom code
	if (isset($show['layercustom']) && $show['layercustom'] == true)
		phpAds_placeLayerSettings();
	
	
	// Host Language
	if (isset($show['hostlanguage']) && $show['hostlanguage'] == true)
	{
		echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200'>".$GLOBALS['strXmlRpcLanguage']."</td><td width='370'>";
		echo "<select name='hostlanguage'>";
			echo "<option value='php'".($hostlanguage == 'php' ? ' selected' : '').">PHP</option>";
	//		echo "<option value='php-xmlrpc'".($hostlanguage == 'php-xmlrpc' ? ' selected' : '').">PHP with built in XML-RPC extension</option>";
	//		echo "<option value='asp'".($hostlanguage == 'asp' ? ' selected' : '').">ASP</option>";
	//		echo "<option value='jsp'".($hostlanguage == 'jsp' ? ' selected' : '').">JSP</option>";
		echo "</select>";
		echo "</td></tr>";
		echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	}
	
	
	if (isset($submitbutton) || isset($generate) && $generate)
	{
		echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='560' colspan='2'>";
		echo "<br><br><img src='images/icon-generatecode.gif' align='absmiddle'>&nbsp;<b>".$GLOBALS['strBannercode'].":</b><br><br>";
		
		echo "<textarea class='flat' rows='8' cols='55' style='width:560px;'>".htmlspecialchars(phpAds_GenerateInvocationCode($zoneid))."</textarea>";
		echo "</td></tr>";
	
		$generated = true;
	}
	else
		$generated = false;
	
	
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	echo "</table>";
	echo "<br><br>";
	echo "<input type='hidden' value='".($generated ? 1 : 0)."' name='generate'>";
	
	// Put extra hidden fields
	if (is_array($extra))
	{
		while (list($k, $v) = each($extra))
			echo "<input type='hidden' value='$v' name='$k'>";
	}
	
	echo "<input type='submit' value='".$GLOBALS['strGenerate']."' name='submitbutton'>";
	echo "</form>";
	echo "<br><br>";
}

?>